<?php
/**
 * Mongo Database Active Record Class
 *
 * @package		Fuel
 * @version		1.0
 * @author		Andrew Lowther
 * @license		MIT License
 * @copyright	2010 - 2011 Fuel Development Team
 * @link		http://fuelphp.com
 */


// Get the classes from the directory
$iterator = new RecursiveIteratorIterator($directory = new RecursiveDirectoryIterator(dirname(__file__) . '/classes'));

while($iterator->valid()) {
	if(!$iterator->isDot() && !$iterator->isDir()) {
		$sub_path = $iterator->getSubPath() ? $iterator->getSubPath() . DIRECTORY_SEPARATOR : "";
		$required[] = $iterator->getFilename();
		require_once( $iterator->getPathname() );
		//require_once dirname(__file__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $sub_path . $iterator->getFilename();
	}
	$iterator->next();
}


/* End of file bootstrap.php */