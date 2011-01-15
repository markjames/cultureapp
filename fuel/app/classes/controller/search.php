<?php

class Controller_Search extends Controller {
	
	public function action_index() {
		if(isset($_POST['command'])) {
			$postcode = $_POST['postcode'];
		}
		
		$mongo = new Venues('test', 'localhost');
		var_dump($mongo->find());
		
		$this->render('search/index');
	}
	
}

?>