<?php

class Controller_Search extends Controller {
		
	public function action_index() {
		$results = array();
		if(isset($_POST['command'])) {
			$scores = new \Cultureapp\Scores();
			$totals = $scores->calculateScoresForPostcode($_POST['postcode'])->toJson();
		}
		
		header('Content-Type: application/json');
		echo $totals;
		
		// $this->render('search/index');
	}
	
}

?>