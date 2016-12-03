<?php


class ExamLogic extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model("Rep/Exam","exam");
	}
	
	public function scheduleexam($paper,$start,$end,$duration,$name)
	{
		$this->exam->Create(array(
				"paper"=>$paper,
				"examstart"=>$start,
				"examend"=>$end,
				"duration"=>$duration,
				
		));
	}
	
	
}

?>