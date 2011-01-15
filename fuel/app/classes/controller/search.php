<?php

class Controller_Search extends Controller_Template {
	
	public $template = 'search/index';
	
	private function _search_on_postcode( $postcode ) {
		// Sanitize the postcode
		$postcode = htmlentities($postcode, ENT_QUOTES, "UTF-8");
		// Remove spaces, as that's how we're saving them
		$postcode = str_replace(" ", "", $postcode);
		// Make it uppercase
		$postcode = strtoupper($postcode);
		
		$postcode_search = new Postcodes();
		
		return $postcode_search->findOne(array('postcode' => $postcode));
	}
	
	public function action_index() {
		if(isset($_POST['command'])) {
			$this->template->results = $this->_search_on_postcode($_POST['postcode']);
		}
		
		// $this->render('search/index');
		$this->template->content = View::factory('search/index');
	}
	
}

?>