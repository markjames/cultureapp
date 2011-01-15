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

namespace Cultureapp\Exception;

/**
 * Exception
 *
 * @package		Cultureapp
 * @author		Mark James
 */
class DataNotAvailableExtension extends \Extension {

	const $ARTSCOUNCIL_STATS = array(
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

	const $GPD_CATEGORY_MAP = array(
		'MUSEUM' => 'exhibit'
		'DANCE' => 'dance'
		'OPERA' => 'opera'
		'CLASSICAL' => 'classical'
		'MUSIC' => 'music'
		'MUSIC:FOLKCELTIC' => 'folk-and-world'
		'MUSIC:JAZZ' => 'jazz-and-blues'
		'MUSIC:ROCK' => 'rock-and-pop'
		'THEATRE' => 'theatre'
		'FILM' => 'film'
		'COMEDY' => 'comedy'
		'SPECIALEVENTS' => 'special-events'
	);

	/**
	 * Calculate scores for postcode
	 * 
	 * @param String $postcode Postcode
	 * @return Scores
	 */
	public function calculateScoresForPostcode( $postcode ) {

		// Load the data
		
		
		// Normalise the scores
		
		// 

	}

}