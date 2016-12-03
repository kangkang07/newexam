<?php

/**
 * @property RP_Model $exam
 * @property RP_Model $vwasheet
 */

class Answersheetapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/AnswerSheet","model");
	}
	
	public function index()
	{
		$this->loadview("answersheets.html");
	}
	
    //public function regexam($eid)
    //{
    //    $uid=$this->session->uid;
    //    $this->model->Create(array(
    //            "user"=>$uid,
    //            "exam"=>$eid
    //    ));
    //}

    //public function startanswer($asid)
    //{
    //    $uid=$this->session->uid;
    //    $this->model->UpdateByID($asid, array("answerstart"=>date()));
    //}
    //public function submitanswersheet($asid)
    //{
    //    $uid=$this->session->uid;
    //    $this->model->Create(array("answerend"=>date()));
    //}

    public function ExamUsers($eid)
    {
        $this->load->model("Rep/Exam","exam");
        $this->load->model("Rep/VWAnswerSheet","vwasheet");
        $exam=$this->exam->GetByID($eid);
        $data["exam"]=$exam;
        $data["sheets"]=$this->vwasheet->GetList(array("exam"=>$eid));
        $this->loadview("examusers",$data);
        

    }
	
	
}

?>