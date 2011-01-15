<?php

class Postcodes extends ActiveMongo {
	
	public $postcode;
	public $loc;
	
	public function __construct( $db, $host, $username = NULL, $password = NULL ) {
		$config = new Config();
		parent::connect($config->get('dbname'), $config->get('dbhost'));
	}
	
}

?>