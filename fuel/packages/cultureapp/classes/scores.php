<?php
/**
 * CultureApp
 *
 *
 * @package		Cultureapp
 * @version		1.0
 * @author		Mark James & Andrew Lowther
 * @license		MIT License
 * @copyright	2011 Mark James & Andrew Lowther
 */

namespace Cultureapp;

/**
 * Scores
 *
 * @package		Cultureapp
 * @author		Mark James
 */
class Scores {

	public static $ARTSCOUNCIL_STATS = array(
		'Any performance in a theatre' => '48.2',
		'Plays' => '32.5',
		'Opera' => '8.3',
		'Ballet' => '9.3',
		'Contemporary dance' => '8.6',
		'Classical music concerts or recitals' => '16.5',
		'Jazz concerts or performances' => '10.7',
		'Other music concerts in stadiums/arenas' => '8.1',
		'Other music gigs' => '7.5',
		'Arts galleries or art exhibitions' => '29.7',
		'Cinema' => '66.8'
	);

	public static $GPD_CATEGORY_MAP = array(
		'MUSEUM' => 'exhibit',
		'DANCE' => 'dance',
		'OPERA' => 'opera',
		'CLASSICAL' => 'classical',
		'MUSIC' => 'music',
		'MUSIC:FOLKCELTIC' => 'folk-and-world',
		'MUSIC:JAZZ' => 'jazz-and-blues',
		'MUSIC:ROCK' => 'rock-and-pop',
		'THEATRE' => 'theatre',
		'FILM' => 'film',
		'COMEDY' => 'comedy',
		'SPECIALEVENTS' => 'special-event'
	);

	public $_searchDistanceInMiles = 10;
	
	public $_scores_data;

	/**
	 * Calculate scores for postcode
	 * 
	 * @param String $postcode Postcode
	 * @return Scores
	 */
	public function calculateScoresForPostcode( $postcode ) {

		// Load the data
		$data = $this->_load_data_for_postcode($postcode);
		$data = $this->_assignVenueCategories($data);
		
		$this->_lat = $data['postcode']->lat;
		$this->_lng = $data['postcode']->lng;

		// Calculate scores per genre
		$scoreData = $this->_calculateGenreScores( $data['events'] );

		// Normalise the scores
		$this->_scores_data = $this->_normaliseScores( $scoreData );
		$this->_calculateTotal();
		$this->_sortVenueDistances($data['venues']);
		
		return $this;

	}
	
	/**
	 * Export the data as a json object
	 *
	 * @param void
	 * @return JSON Object
	 */
	public function toJson() {
		return json_encode($this->_scores_data);
	}
	
	/**
	 * Get the venue distances
	 *
	 * @param void
	 * @return array
	 */
	public function getVenueDistances() {
		return $this->venue_distances;
	}

	/** 
	* Load all nearby events for a given postcode
	*
	* @param String $postcode Postcode
	*/
	private function _load_data_for_postcode( $postcode ) {

		// Sanitize the postcode
		$postcode = preg_replace('~[^a-zA-Z0-9]~','',$postcode);
		// Remove spaces, as that's how we're saving them
		$postcode = str_replace(" ", "", $postcode);
		// Make it uppercase
		$postcode = strtoupper($postcode);
		
		$data = array();
		$postcode_search = new \Postcodes();
		$venue_search = new \Venues();
		
		// Get the postcode
		$postcode_items = $postcode_search->findOne(
			array('postcode' => $postcode)
		);

		// Third parameter is the max distance from the postcode lat/long in miles.
		$venue_items = $venue_search->find_by_lat_lng(
			$postcode_items->lat,
			$postcode_items->lng,
			$this->_searchDistanceInMiles
		);

		// Load events
		$events = new \Events();
		$event_items = array();
		foreach($venue_items as $venue_item) {
			$event_items[] = $events->find_by_venue_id($venue_item->source_id);
		}

		$data['postcode'] = $postcode_items;
		$data['venues'] = $venue_items;
		$data['events'] = $event_items;

		return $data;

	}

	/**
	 * Returns an array containing scores for this event keyed by genre
	 * 
	 * @param mixed $event Event
	 * @return array
	 */
	private function _scoreEvent( $events ) {
		$genres = array();
		foreach($events as $event) {
			$venue = new \Venues();
			$event_venue = $venue->find(array('source_id' => $event->venue_id));
			// Create an approximation of the distance based on a square root of the locations.
			$distance = sqrt(pow($event_venue->loc['lat'] - $this->_lat, 2) + pow($event_venue->loc['lng'] - $this->_lng, 2));
			$distance = round($distance * 100);
			
			foreach( $event->categories as $category ) {
				if(isset(static::$GPD_CATEGORY_MAP[$category])) {
					$score = 11 / min(max(1, $this->_searchDistanceInMiles), 10);
					if(isset($genres[static::$GPD_CATEGORY_MAP[$category]])) {
						$genres[static::$GPD_CATEGORY_MAP[$category]] += $score;
					} else {
						$genres[static::$GPD_CATEGORY_MAP[$category]] = $score;
					}
				}
			}
		}
		return $genres;

	}
	
	/**
	 * Assign a category to a venue based on events
	 *
	 * @param array $data
	 * @return array
	 */
	private function _assignVenueCategories( $data ) {

		$venues = array();
		foreach( $data['venues'] as $venue ) {
			$venues[$venue->source_id] = $venue;
		}
		$data['venues'] = $venues;

		foreach($data['events'] as $eventskey => $events) {
			foreach($events as $eventkey => $event) {
				foreach($event->categories as $category) {

					$venue = $venues[$event->venue_id];

					if(isset(static::$GPD_CATEGORY_MAP[$category])) {
						$cat = static::$GPD_CATEGORY_MAP[$category];
						if(isset($venue->genre->$cat)) {
							$venues[$venue->source_id]->genre->$cat + 1;
						} else {
							$venues[$venue->source_id]->genre->$cat = 1;
						}
					}
					
				}
			}
		}

		return $data;
	}

	/**
	 * Calculate genre scores for given events
	 * 
	 * @param mixed $events Event data
	 * @return array
	 */
	private function _calculateGenreScores( $events ) {

		$genreScores = array('exhibit' => 0,'dance' => 0,'opera' => 0,'classical' => 0,'music' => 0,'folk-and-world' => 0,'jazz-and-blues' => 0,'rock-and-pop' => 0,'theatre' => 0,'film' => 0,'comedy' => 0,'special-event' => 0);
		foreach( $events as $event ) {
			foreach( $this->_scoreEvent($event) as $genre => $score ) {
				$genreScores[$genre] += $score;
			}
		}
		return $genreScores;

	}
	
	/**
	 * Generate a total score
	 *
	 * @param void
	 * @return array
	 */
	private function _calculateTotal() {
		$this->_scores_data['total'] = 0;
		foreach($this->_scores_data as $scores_data) {
			$this->_scores_data['total'] += $scores_data;
		}
		
		return $this->_scores_data;
	}
	
	/**
	 * Normalise event scores.
	 *
	 * @param mixed $scores_data
	 * @return array
	 */
	private function _normaliseScores( $scores_data ) {
		
		// Need to update to update from data
		$totals = array(
			'dance' => 26,
			'exhibit' => 77,
			'opera' => 14,
			'classical' => 111,
			'music' => 555,
			'folk-and-world' => 69,
			'jazz-and-blues' => 71,
			'rock-and-pop' => 132,
			'theatre' => 102,
			'film' => 215,
			'comedy' => 108,
			'special-event' => 1366
		);
		
		foreach( $scores_data as $g => $v ) {
			$scores_data[$g] = round(($v / $totals[$g]) * 100);
		}
		return $scores_data;
	}
	
	/**
	 * Get the venue distance to plot on graph
	 *
	 * @param mixed $venues
	 * @param int $lat
	 * @param int $long
	 * @param int $max_distance
	 * @return array
	 */
	private function _sortVenueDistances( $venues, $max_distance = 10, $limit = 50 ) {
		$venues_list = array();
		$key = 0;
		foreach($venues as $venue) {
			$distance = sqrt(pow($venue->loc['lat'] - $this->_lat, 2) + pow($venue->loc['lng'] - $this->_lng, 2));
			$distance = round($distance * 100);
			
			if($distance < $max_distance && ($key + 1) < $limit) {
				$venues_list[$distance][] = $venue;
			}
			$key++;
		}
		return $this->_scores_data['venues_list'] = $venues_list;
	}
	
}