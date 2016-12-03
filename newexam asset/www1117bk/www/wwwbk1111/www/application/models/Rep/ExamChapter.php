<?php
class ExamChapter extends RP_Model {
	function __construct() {
		parent::__construct ();
		$this->dbkey="idexamchapter";
		$this->dbtable="examchapter";
	}
	
	public function GetByExam($eid)
	{
		$data=$this->GetList(array("exam"=>$eid));
		return $data;
	}
}

?>