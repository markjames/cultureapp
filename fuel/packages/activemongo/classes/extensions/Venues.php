<?php

class Venues extends ActiveMongo {
	
	public $title;
	public $loc;
	public $source;
	
	public function __construct() {
		$config = new Config();
		parent::connect($config->get('dbname'), $config->get('dbhost'));
	}
	
}

?>