<?php
/**
 * CultureApp
 *
 * App for Culture Hack Day 2011 #chd11
 *
 */

error_reporting(E_ALL);
ini_set('display_errors','On');
ini_set('memory_limit','512M');

// Start the Autoloader
require 'SplClassLoader.php';
$loader = new SplClassLoader();
$loader->register();

$dir = (isset($_SERVER['argv']) && isset($_SERVER['argv'][1])) ? $_SERVER['argv'][1] : '';

try {

	// Setup Database
	$mongo = new Mongo();
	$mongodb = $mongo->culturehackday;

	$importer = new \cultureapp\dataimporter\GDPDataImporter();
	$importer->setMongoDb( $mongodb );
	if( $result = $importer->importFromDirectory($dir) ) {
		echo "\nComplete\n\n";
	} else {
		echo "\nCould not import\n\n";
	}
} catch( \Exception $e ) {
	echo $e->getMessage();
	die();
}