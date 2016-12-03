<?php
class Chapterapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/Chapter","model");
	}
	
}

?>