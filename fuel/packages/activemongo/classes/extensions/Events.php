<?php

class Events extends ActiveMongo {
	
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
	
}

?>