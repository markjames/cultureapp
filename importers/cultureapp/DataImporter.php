<?php
/**
 * CultureApp
 *
 * App for Culture Hack Day 2011 #chd11
 *
 */

namespace cultureapp;

/**
 * Importer
 *
 */
class DataImporter {

	/**
	 * Source name
	 *
	 * @var String
	 */
	protected $_sourceName;

	/**
	 * Constructor for Importer
	 * 
	 * @param String $sourceShortName Source short name
	 */
	public function __construct( $sourceShortName ) {

		$this->_sourceName = $sourceShortName;

	}

	public function setMongoDb( \MongoDB $mongoDb ) {
		
		$this->_mongoDb = $mongoDb;

	}

	/**
	 * Import data from source
	 * 
	 * @return boolean
	 */
	public function import() {

		return FALSE;

	}

	/**
	 * Create event
	 * 
	 * @param array $data Data
	 * @return Boolean
	 */
	protected function _createEvent( array $data ) {

		return FALSE;

	}

	/**
	 * Create venue
	 * 
	 * @param array $data Data
	 * @return Boolean
	 */
	protected function _createVenue( array $data ) {

		return FALSE;

	}

}
?>