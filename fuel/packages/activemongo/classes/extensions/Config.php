<?php

class ConfigObject {
	
	public $_config = array(
		'dbname' => 'culturehackday',
		'dbhost' => 'localhost'
	);
	
	public function set( $var, $val ) {
		$this->_config[$var] = $val;
	}
	
	public function get( $var, $default = '' ) {
		if(isset($this->_config[$var])) {
			return $this->_config[$var];
		}
		return $default;
	}
	
}

?>