<?php
/**
 * CultureApp
 *
 * App for Culture Hack Day 2011 #chd11
 *
 */

namespace cultureapp\dataimporter;

use \cultureapp\DataImporter;

/**
 * GDP data importer
 *
 */
class GDPDataImporter extends DataImporter {

	/**
	 * Parsed data
	 *
	 * @var array
	 */
	private $_parsedData;

	/**
	 * Constructor for GDPDataImporter
	 * 
	 */
	public function __construct() {

		$this->_sourceName = 'GDP';

		$this->_parsedData = array(
			'venues' => array(),
			'events' => array()
		);

	}

	/**
	 * Import from directory
	 * 
	 * @param mixed $directory Directory
	 * @param mixed $glob Glob Optional (Defaults to '*.xml')
	 * @return Boolean
	 */
	public function importFromDirectory( $directory, $glob='*.xml' ) {

		$titleFiles = array();
		$venueFiles = array();
		$eventFiles = array();

		$iterator = new \GlobIterator( $directory . $glob );

		if(!$iterator->count()) {
		    throw new \Exception('Could not find files in given directory: ' . $directory . $glob );
		} else {
			foreach($iterator as $item) {
				$filename = $iterator->key();
				
				// Figure out which file is which
				if( FALSE !== stripos($filename, '_TITLES_' ) ) {
					$titleFiles []= $filename;
				}
				if( FALSE !== stripos($filename, '_VENUE_' ) ) {
					$venueFiles []= $filename;
				}
				if( FALSE !== stripos($filename, '_EVENT_' ) ) {
					$eventFiles []= $filename;
				}
			}
		}

		foreach( $titleFiles as $titleFile ) {
			if( !$this->_parseTitleFile( realpath($directory . $titleFile) ) ) {
				return false;
			}
		}
		foreach( $venueFiles as $venueFile ) {
			if( !$this->_parseVenueFile( realpath($directory . $venueFile) ) ) {
				return false;
			}
		}
		foreach( $eventFiles as $eventFile ) {
			if( !$this->_parseEventFile( realpath($directory . $eventFile) ) ) {
				return false;
			}
		}

		$this->_insertParsedData();

		return true;

	}

	/**
	 * Parse a single GDP title file into parsedData
	 * 
	 * @param mixed $file File
	 */
	protected function _parseTitleFile( $file ) {

		echo "Parsing Title File: $file\n";

		$xml = simplexml_load_file($file);

		foreach( $xml->xpath('title') as $title ) {

			// Create the data
			$t = array();
			$t['name'] = strval(current($title->xpath('//title_name')));
			$t['source'] = $this->_sourceName;
			$t['source_id'] = strval($title->title_id);
			$t['categories'] = array();

			foreach( $title->categories->category as $cats ) {
				$t['categories'] []= strval($cats);
			}
			if( isset($title->subcategories)) {
				foreach( $title->subcategories[0]->subcategory as $subcats ) {
					$attrs = $subcats->attributes();
					$t['categories'] []= strval($attrs['parent_category']) . ':' . strval($subcats);
				}
			}
			$this->_parsedData['titles'][$t['source_id']] = $t;

		}


		return TRUE;

	}

	/**
	 * Parse a single GDP venue file into parsedData
	 * 
	 * @param mixed $file File
	 */
	protected function _parseVenueFile( $file ) {

		echo "Parsing Venue File: $file\n";

		$xml = simplexml_load_file($file);

		foreach( $xml->xpath('venue') as $venue ) {

			// Create the data
			$v = array();
			$v['source'] = $this->_sourceName;
			$v['source_id'] = strval($venue->venue_id);
			$v['title'] = (string)($venue->venue_name);
			$v['loc'] = array(
				'lat'=> floatval($venue->latitude),
				'lng'=> floatval($venue->longitude)
			);

			$this->_parsedData['venues'][(string)($venue->venue_id)] = $v;

		}

		return TRUE;

	}

	/**
	 * Parse a single GDP event file into parsedData
	 * 
	 * @param mixed $file File
	 */
	protected function _parseEventFile( $file ) {

		echo "Parsing Event File: $file\n";

		$xml = simplexml_load_file($file);

		foreach( $xml->xpath('//venue') as $venue ) {
			
			$venueAttrs = $venue->attributes();

			foreach( $venue->titles->title as $title ) {
				
				$titleAttrs = $title->attributes();

				foreach( $title->performance as $performancerun ) {
					// Create the data
					$runAttrs = $performancerun->attributes();
					
					$e = array();
					$e['source'] = $this->_sourceName;
					$e['source_id'] = strval($runAttrs['performance_id']);
					$e['venue_id'] = strval($venueAttrs['venue_id']);
					
					$e['title'] = (string)($titleAttrs['title_name']);

					// Add start/end
					$dateformat = 'd/m/Y H:i';
					$startdate = \DateTime::createFromFormat($dateformat, strval($performancerun->start_date) . ' 18:00');
					$enddate = \DateTime::createFromFormat($dateformat, strval($performancerun->end_date) . ' 18:00');

					if( $startdate && $enddate ) {
						$e['dtstart'] = new \MongoDate($startdate->getTimestamp());
						$e['dtend'] = new \MongoDate($enddate->getTimestamp());
					}

					$title_id = strval($titleAttrs['title_id']);
					$existingTitle = isset($this->_parsedData['titles'][$title_id]) ? $this->_parsedData['titles'][$title_id] : array('categories'=>array());
					$e['categories'] = $existingTitle['categories'];

					// I'm being clever
					$existingVenue = isset($this->_parsedData['venues'][$e['venue_id']]) ? $this->_parsedData['venues'][$e['venue_id']] : array('loc'=>array('lat'=>'','lng'=>''));
					$this->_parsedData['events'][$e['source_id']] = $e;

				}

			}

		}

		return TRUE;

	}

	/**
	 * Insert parsed data
	 * 
	 * @return Boolean
	 */
	protected function _insertParsedData() {

		$db = $this->_mongoDb;
		$venues = $db->selectCollection("venues");
		$events = $db->selectCollection("events");

		foreach( $this->_parsedData['venues'] as $venue ) {
			$venues->insert( $venue );
		}

		foreach( $this->_parsedData['events'] as $event ) {
			$events->insert( $event );
		}
		
		return true;

	}

}
?>