<?php
class Paperapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/Paper","model");
	}
	
	public function index()
	{
		$this->loadview("editpaper.html");
	}
	
	public function getpaperview($pid){
		$this->load->model("Rep/PaperDetails","fullpaper");
		$paper=$this->model->GetByID($pid);
		$paperdetail=$this->fullpaper->GetList(array("idpaper"=>$pid));
		$data["paper"]=$paper;
		$data["qstlist"]=$paperdetail;
		$this->load->view("layout/simpleheader");
		$this->load->view("paperview",$data);
		$this->load->view("layout/footer.html");
		
	}
	
	public function GeneratePaper()
	{
		$this->load->model("PaperLogic","pl");
		$pname=$_REQUEST["pname"];
		$chaps=$_REQUEST["chaps"];
		print_r($chaps);
		$this->pl->GeneratePaper($pname,array("chapter"=>$chaps));
	}
	
	public function DeletePaper($pid)
	{
		$this->db->where("paper",$pid);
		$this->db->delete("paperquestion");
		$this->DeleteByID($pid);
	}
}

?>