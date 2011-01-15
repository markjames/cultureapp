<?php

class Venues extends ActiveMongo {
	
	public $_id;
	public $title;
	public $loc;
	public $source;
	
	public function __construct() {
		$config = new ConfigObject();
		parent::connect($config->get('dbname'), $config->get('dbhost'));
	}
	
	public function find_by_lat_lng( $lat, $long, $distance = 5 ) {
		$collection = $this->findAllAssoc(array('loc' => array(
			'$within' => array('$center' => array(array($lat, $long), $distance / 69))
		)));
		
		return $collection;
	}
	
}

?>