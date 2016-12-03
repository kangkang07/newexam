<?php

/**
 * @property Search $model
 * @author Qikang
 *
 */
class SearchAPI extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Search","model");
	}
	public function DefaultItems()
	{
		
		echo json_encode($this->model->MatchItem());
	}
	public function SearchItems()
	{
		$param=$_REQUEST["param"];
		$withimage=$_REQUEST["withimage"];
		$withtags=$_REQUEST["withtags"];
		echo json_encode($this->model->SearchItems($param,$withimage,$withtags));
	}
}

?>