<?php
class DBContext extends CI_Model {
	public function __construct() {
		parent::__construct ();
	}
	
	private $question=FALSE;
	private $chapter=FALSE;
	private $paper=FALSE;
	private $user=false;
	private $paperquestion=FALSE;
	private $exam=FALSE;
	
	public function question()
	{
		if(!$this->question){
			$this->load->model("Rep/Question");
			$this->question=true;
		}
		return $this->Question;
	}
	public function chapter()
	{
		if(!$this->chapter){
			$this->load->model("Rep/Chapter");
			$this->chapter=true;
		}
		return $this->Chpater;
	}
	public function user()
	{
		if(!$this->user){
			$this->load->model("Rep/User");
			$this->user=true;
		}
		return $this->User;
	}
	public function paper()
	{
		if(!$this->paper){
			$this->load->model("Rep/Paper");
			$this->paper=true;
		}
		return $this->Paper;
	}
	public function exam()
	{
		if(!$this->exam){
			$this->load->model("Rep/Exam");
			$this->exam=true;	
		}
		return $this->Exam;
	}
	
	
}

?>