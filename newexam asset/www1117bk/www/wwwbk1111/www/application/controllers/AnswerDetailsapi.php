<?php

/**
 * @property RP_Model $pq
 * @property RP_Model $asheet
 * @property RP_Model $question
 *
 */

class AnswerDetailsapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/AnswerDetails","model");

	}
	public function answertime($eid)
	{
		//$uid=$this->session->uid;
		//$detail=$this->model->GetList(array("idexam"=>$eid));
		//$data["data"]=$detail;
		$this->load->library("session");
		$this->load->model("Rep/AnswerSheet","asheet");
		if($this->asheet->Count(array("user"=>$this->session->user->iduser,"exam"=>$eid))==0)
		{
			$ash=$this->asheet->Create(array("user"=>$this->session->user->iduser,"exam"=>$eid,"answerstart"=>date("Y-m-d h:i:s",time())));
			$asid=$ash["idanswersheet"];
			$this->load->model("PaperLogic","plogic");
			$this->plogic->GeneratePaper($asid);
		}
		else{
			$asid=$this->asheet->GetOne(array("user"=>$this->session->user->iduser,"exam"=>$eid))->idanswersheet;
		}
		$data["asid"]=$asid;
		$this->loadsimpleview("answertime",$data);

	}

	public function getmysheet($asid)
	{
		$detail=$this->model->GetList(array("idanswersheet"=>$asid));
		$this->outputjson($detail);
	}

	/**
     * @property RP_Model $pq
     *
     */
	public function answer()
	{
		$pqid=$_REQUEST["id"];
        $answer=$_REQUEST["myanswer"];
        $flag=$_REQUEST["flag"];
        $this->load->model("Rep/PaperQuestion","pq");
        $this->pq->UpdateByID($pqid,array("myanswer"=>$answer,"flag"=>$flag));
	}

	public function EndExam($id)
	{
        $this->load->model("Rep/AnswerSheet","asheet");

        $this->load->model("Rep/PaperQuestion","pq");
        $qas=$this->pq->GetList(array("paper"=>$id));
        $finalscore=0;
        foreach($qas as $qa)
        {
            $ra=$this->getrightanswer($qa->question);
            if($qa->myanswer==$ra&&$ra!=null)
            {
                $qa->result=$qa->score;
                $finalscore+=$qa->score;
            }
            else{
                $qa->result=0;
            }
            $this->pq->Update($qa);

        }

        //$this->load->helper('date');
        $this->asheet->UpdateByID($id,array("answerend"=>date("Y-m-d h:i:s",time()),"finalscore"=>$finalscore));
        $this->loadview("examend");
	}

    protected function getrightanswer($qid)
    {
        $this->load->model("Rep/Question","question");
        $q=$this->question->GetByID($qid);
        return $q->answer;
    }

    public function viewdetails($asid)
    {
        $data["details"]=$this->model->GetList(array("idanswersheet"=>$asid));
        $this->loadview("viewanswerdetails",$data);
    }
}

?>