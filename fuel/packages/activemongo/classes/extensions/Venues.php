<?php

class Venues extends ActiveMongo {
	
	public $title;
	public $loc;
	public $source;
	
	public function __construct( $db, $host, $username = NULL, $password = NULL ) {
		parent::connect($db, $host, $username, $password);
	}
	
}

?>