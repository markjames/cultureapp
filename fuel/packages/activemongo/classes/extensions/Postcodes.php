<?php

class Postcodes extends ActiveMongo {
	
	public $_id;
	public $postcode;
	public $loc;
	
	public function __construct() {
		$config = new ConfigObject();
		parent::connect($config->get('dbname'), $config->get('dbhost'));
	}
	
}

?>