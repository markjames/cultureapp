<?php

class Controller_Search extends Controller_Template {
	
	public $template = 'search/index';
	
	public function action_index() {
		if(isset($_POST['command'])) {
			$this->template->results = $this->_search_on_postcode($_POST['postcode']);
		}
		
		// $this->render('search/index');
		$this->template->content = View::factory('search/index');
	}
	
	private function _search_on_postcode( $postcode ) {
		// Sanitize the postcode
		$postcode = htmlentities($postcode, ENT_QUOTES, "UTF-8");
		// Remove spaces, as that's how we're saving them
		$postcode = str_replace(" ", "", $postcode);
		// Make it uppercase
		$postcode = strtoupper($postcode);
		
		$data = array();
		$postcode_search = new Postcodes();
		$venue_search = new Venues();
		
		$postcode_items = $postcode_search->findOne(array('postcode' => $postcode));
		$venue_items = $venue_search->find_by_lat_lng($postcode_items->lat, $postcode_items->lng);
		
		$data['postcode'] = $postcode_items;
		$data['venues'] = $venue_items;
		
		return $data;
	}
	
}

?>