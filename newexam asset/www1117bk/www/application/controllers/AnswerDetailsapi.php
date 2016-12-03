<?php

/**
 * @property RP_Model $pq
 * @property RP_Model $asheet
 * @property RP_Model $question
 * @property RP_Model $exam
 * @property RP_Model $vasheet
 * @property User $user
 * @property Invicode $icode
 */

class AnswerDetailsapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/AnswerDetails","model");

	}

    public function test()
    {
        
    }


    public function ByCode()
    {
        $this->loadsimpleview("bycode");
    }

    /**
     * Summary of FromCode
     * @param mixed $code 
     * 
     */
    public function FromCode()
    {
        $eid=$_GET["examid"];
        $sid=$_GET["schoolid"];
        $name=$_GET["username"];
        $this->load->model("Rep/Invicode","icode");
        $this->load->model("Rep/User","user");
       
        $u=$this->user->GetBySID($sid);
if($u!=null){
 $codeinfo=$this->icode->GetOne(array("sourceid"=>(int)$eid,"targetid"=>$u->iduser));
}
else{

$this->errorpage("考试码或学号错误");
return;
}
        if($u->name==$name&&$codeinfo!=null)
        {
			$this->session->user=$this->user->GetBySID($sid);
            $this->answertime((int)$eid);
            return;
        }
        else
        $this->errorpage("考试码或学号错误");
    }


	/**
	 *
     *
     * @property Exam $em
     * @property RP_Model $vwasheet
	 * @param mixed $eid
	 */
	public function answertime($eid)
	{
        $isended=false;

        $this->load->model("Rep/Exam","exam");
        $em=$this->exam->GetByID($eid);
        if(strtotime($em->examend)<=strtotime( date("Y-m-d h:i:s"))){
            $isended=true;
        }


		//$uid=$this->session->uid;
		//$detail=$this->model->GetList(array("idexam"=>$eid));
		//$data["data"]=$detail;
		$this->load->model("Rep/AnswerSheet","asheet");
        
		if($this->asheet->Count(array("user"=>$this->session->user->iduser,"exam"=>$eid))==0)
		{
	            if($isended)
        	    {
                	$this->loadview("examend");
	                return;
        	    }
			$ash=$this->asheet->Create(array("user"=>$this->session->user->iduser,"exam"=>$eid,"answerstart"=>date("Y-m-d h:i:s",time())));
			$asid=$ash->idanswersheet;
			$this->load->model("PaperLogic","plogic");
			$this->plogic->GeneratePaper($asid);
		}
		else{
            		$this->load->model("Rep/VWAnswerSheet","vasheet");
			$ash=$this->vasheet->GetOne(array("user"=>intval($this->session->user->iduser),"exam"=>$eid));
         	   	$asid=$ash->idanswersheet;
			if($ash->answerend!=null)
			{
                		$data["answersheet"]=$ash;
		                $data["details"]=$this->model->GetList(array("idanswersheet"=>$asid));

				$this->loadview("examresult",$data);
				return;
			}
			
		}


		$data["asid"]=$asid;
		$this->loadsimpleview("answertime",$data);
	}

	public function getmysheet($asid)
	{
		$detail=$this->model->GetList(array("idanswersheet"=>(int)$asid));
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
    	$this->load->model("Rep/VWAnswerSheet","vasheet");
    	$ash=$this->vasheet->GetOne(array("idanswersheet"=>$asid));
    	$data["answersheet"]=$ash;
        $data["details"]=$this->model->GetList(array("idanswersheet"=>$asid));
        $this->loadview("examresult",$data);
    }
}

?>