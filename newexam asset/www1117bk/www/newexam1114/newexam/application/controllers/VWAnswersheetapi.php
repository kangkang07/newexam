<?php
class VWAnswersheetapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/VWAnswerSheet","model");
	}
	
	public function GetMyExams()
	{
		$this->GetAll();
	}
}

?>