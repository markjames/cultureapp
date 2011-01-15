<?php

class Venues extends ActiveMongo {
	
	public $title;
	public $loc;
	public $source;
	
	public function __construct() {
		$config = new ConfigObject();
		parent::connect($config->get('dbname'), $config->get('dbhost'));
	}
	
}

?>