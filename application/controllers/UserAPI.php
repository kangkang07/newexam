<?php

/**
 * @property User $model
 */

class Userapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		//这里应当有权限控制，只允许登陆用户调用。
		

		$this->load->model("Rep/User",'model');
	}
	public function Index()
	{
		
		$this->loadsimpleview("login.html");
	}
	public function Login()
	{
		$logintype=$_REQUEST['logintype'];
		$account=$_REQUEST['account'];
		$pwd=$_REQUEST['pwd'];
		echo json_encode($this->model->Login(array($logintype=>$account,'pwd'=>$pwd)));
// 		if($this->model->Login(array($logintype=>$account,'pwd'=>$pwd)))
// 			echo 1;
// 		else 
// 			echo 0;
	}
	public function LogOut()
	{
		$this->model->LogOut();
		$this->load->helper('url');
		redirect("/UserAPI");
	}
	public function Register()
	{
		if($_REQUEST["pwd"]!=$_REQUEST["rptpwd"])
		{	echo 0;
			return ;
		}
		$pwd=$_REQUEST["pwd"];
		$data=$_REQUEST["data"];
		$user=$this->model->Register($data,$pwd);
		echo json_encode($user);
	}
	public function ChangePWD()
	{
		$uid=$_REQUEST["uid"];
		$oldpwd=$_REQUEST["oldpwd"];
		$newpwd=$_REQUEST["newpwd"];
		echo $this->model->ChangePWD($uid, $oldpwd, $newpwd);
		
	}

	public function EditUser()
	{
		$this->load->database();
		$grades=$this->db->select("grade")
			->distinct()
			->get("user");
		$classes=$this->db->select("class")
			->distinct()
			->get("user");
		$data["grades"]=$grades;
		$data["classes"]=$classes;
		$this->loadview("edituser",$data);
	}

	public function Edit(){
		$draw=$_REQUEST["draw"];
		$start=$_REQUEST["start"];
		$length=$_REQUEST["length"];
		$search=$_REQUEST["search"];
		$orders=$_REQUEST["order"];
		$where=[];
		if(!empty($_REQUEST["grade"]))
			$where["grade"]=$_REQUEST["grade"];
		if(!empty($_REQUEST["class"]))
			$where["class"]=$_REQUEST["class"];
		$this->load->database();
		$rst=$this->db
			->select('iduser,schoolid,name,grade,class')
			->where($where)
			->group_start()
				->or_like("schoolid",$search)
				->or_like("name",$search)
			->group_end()
			->order_by($orders)
			->get('user',$length,$start);
		$result=(object)array();
		$result->recordsTotal=$this->db->count_all("user");
		$result->recordsFiltered=count($rst);
		$result->draw=$draw;
		$result->data=$rst;
		$this->outputjson($result);

	}

	public function ImportUser(){
		$this->load->model("UploadExcel","upload");
		$this->upload->GetBook("usersheet");
		for ($row = 2; $row <= $this->upload->highestRow; $row++){//行数是以第1行开始
			if(trim($this->Cell(0,$row))=="")
				break;

			$u= $this->user->UpsertBySID(array(
				"schoolid"=>$this->upload->Cell(0,$row),
				"name"=>$this->upload->Cell(1,$row),
				"grade"=>$this->upload->Cell(2,$row),
				"class"=>$this->upload->Cell(3,$row),
				"role"=>3
			));

		}
	}

}
?>
