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
        $data["sheets"]=$this->vwasheet->GetList(array("idexam"=>$eid));
        $this->loadview("examusers",$data);
        

    }

    public function ExportTable()
    {
	$eid=$_GET['eid'];
        $this->load->model("Rep/Exam","exam");
        $this->load->model("Rep/VWAnswerSheet","vwasheet");
        $exam=$this->exam->GetByID($eid);
        $data["exam"]=$exam;
        $data["sheets"]=$this->vwasheet->GetList(array("exam"=>$eid));
	$this->output->set_header('Content-disposition: attachment; filename=code.xls');
	$this->output->set_content_type('application/vnd.ms-excel','utf-8');
	print(chr(0xEF).chr(0xBB).chr(0xBF));
//	echo "xEFxBBxBF";
        $this->load->view("exportinvicode",$data);
    }
	
   // public function 
	
}

?>
