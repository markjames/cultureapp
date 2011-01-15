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
		
		// Third parameter is the max distance from the postcode lat/long in miles.
		$venue_items = $venue_search->find_by_lat_lng($postcode_items->lat, $postcode_items->lng, 15);
		
		$events = new Events();
		$event_items = array();
		foreach($venue_items as $venue_item) {
			$event_items[] = $events->find_by_venue_id($venue_item['source_id']);
		}
		
		$data['postcode'] = $postcode_items;
		$data['venues'] = $venue_items;
		$data['events'] = $event_items;
		
		return $data;
	}
	
}

?>