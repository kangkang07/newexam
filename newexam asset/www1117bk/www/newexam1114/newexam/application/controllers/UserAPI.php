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

}
?>
