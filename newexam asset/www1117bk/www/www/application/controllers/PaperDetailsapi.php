<?php
class PaperDetailsapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/PaperDetails","model");
	}
	
	public function GetPaper($pid)
	{
		$this->outputjson($this->model->GetPaper($pid));

	}
}

?>