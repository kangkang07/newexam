<?php
class Examapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/Exam","model");
	}
	
	public function GetAll(){
		$objs=$this->model->GetList();
		$this->load->model("Rep/ExamChapter","echap");
		foreach ($objs as $e)
		{
			$e->chapters=$this->echap->GetByExam($e->idexam);
			for($i=0;$i<count($e->chapters);$i++)
			{
				$e->chapters[$i]=$e->chapters[$i]->chapter;
			}
// 			foreach ($e->chapters as $ec)
// 			{
// 				$ec=$ec->chapter;
// 			}
		}
		$this->outputjson($objs);
	}
	
	public function index()
	{
		$this->loadview("exammanagement.html");
	}
	public function EnableExam($id)
	{
		$this->model->UpdateByID($id, array("enabled"=>1));
	}
	public function DisableExam($id)
	{
		$this->model->UpdateByID($id, array("enabled"=>0));
	}
	public function CreateExam()
	{
		$obj=$_REQUEST["data"];
		$chaps=$obj["chapters"];
		unset($obj["chapters"]);
		$exam=$this->model->Create($obj);
		$id=$exam['idexam'];
		$this->load->model("Rep/ExamChapter","echap");
		foreach ($chaps as $ec)
		{
			$this->echap->Create(array("exam"=>$id,"chapter"=>$ec));
		}
		$obj["idexam"]=$id;
		$obj["chapters"]=$chaps;
		$this->outputjson($obj);
	}
	
	public function UpdateExam(){
		$id=$_REQUEST["id"];
		$obj=$_REQUEST["data"];
		//print_r($obj);
		$chaps=$obj["chapters"];
		unset($obj["chapters"]);
		$this->model->UpdateByID($id, $obj);
		$this->load->model("Rep/ExamChapter","echap");
		$this->echap->Delete(array("exam"=>$id));
		foreach ($chaps as $ec)
		{
			$this->echap->Create(array("exam"=>$id,"chapter"=>$ec));
		}
		$obj["idexam"]=$id;
		$this->outputjson($obj);
	}



	
}

?>