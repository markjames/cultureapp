<?php

class Controller_Search extends Controller_Template {
	
	public $template = 'search/index';
	
	public function action_index() {
		$results = array();
		if(isset($_POST['command'])) {
			$results = $this->_search_on_postcode($_POST['postcode']);
			$results = $this->_sort_events_into_genre($results);
			$this->template->results = $results;
		}
		
		return $results;
		
		// $this->render('search/index');
		$this->template->content = View::factory('search/index');
	}
	
	private function _search_on_postcode( $postcode ) {
		// Sanitize the postcode
		$postcode = htmlentities($postcode, ENT_QUOTES, "UTF-8");
		// Remove spaces, as that's how we're saving them
		$postcode = str_replace(" ", "", $postcode);
		// Make it uppercase
		$postcode = strtoupper($postcode);
		
		$data = array();
		$postcode_search = new Postcodes();
		$venue_search = new Venues();
		
		$postcode_items = $postcode_search->findOne(array('postcode' => $postcode));
		
		// Third parameter is the max distance from the postcode lat/long in miles.
		$venue_items = $venue_search->find_by_lat_lng($postcode_items->lat, $postcode_items->lng, 15);
		
		$events = new Events();
		$event_items = array();
		foreach($venue_items as $venue_item) {
			$event_items[] = $events->find_by_venue_id($venue_item->source_id);
		}
		
		$data['postcode'] = $postcode_items;
		$data['venues'] = $venue_items;
		$data['events'] = $event_items;
		
		return $data;
	}
	
	private function _sort_events_into_genre($data) {
		$genres = array('exhibit' => 0,'dance' => 0,'opera' => 0,'classical' => 0,'music' => 0,'folk-and-world' => 0,'jazz-and-blues' => 0,'rock-and-pop' => 0,'theatre' => 0,'film' => 0,'comedy' => 0,'special-events' => 0);
		
		// Create a mapping array
		$mappings = array('MUSEUM' => 'exhibit','DANCE' => 'dance','OPERA' => 'opera','CLASSICAL' => 'classical','MUSIC' => 'music','MUSIC:FOLKCELTIC' => 'folk-and-world','MUSIC:JAZZ' => 'jazz-and-blues','MUSIC:ROCK' => 'rock-and-pop','THEATRE' => 'theatre','FILM' => 'film','COMEDY' => 'comedy','SPECIALEVENTS' => 'special-events');
		
		// Events are in a multidimensional array.
		foreach($data['events'] as $events) {
			foreach($events as $event) {
				foreach($event->categories as $genre) {
					if(array_key_exists($genre, $mappings)) {
						$genres[$mappings[$genre]]++;
					}
				}
			}
		}
		
		return $genres;
		
	}
	
	private function _convert_search_to_json( $data ) {
		return json_encode($data);
	}
	
}

?>