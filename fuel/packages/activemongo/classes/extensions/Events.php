<?php

class Events extends ActiveMongo {
	
	public $_id;
	
	/**
	 * Venue relationship
	 *
	 * @access public
	 * @type string
	 */
	public $venue;
	
	/**
	 * Event title
	 *
	 * @access public
	 * @type string
	 */
	public $title;
	
	public $dtstart;
	public $dtend;
	public $genre;
	public $loc;
	
	/**
	 * Source of data
	 *
	 * @access public
	 * @type string
	 */
	public $source;
	
	public function __construct() {
		$config = new ConfigObject();
		parent::connect($config->get('dbname'), $config->get('dbhost'));
	}
	
	public function find_by_venue_id( $venue_id ) {
		return $this->findAll(array('venue_id' => $venue_id));
	}
	
}

?>