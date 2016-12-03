<?php
class Answerapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/Answers","model");
	}
	
	public function answertime($eid)
	{
		
	}
}

?>