<?php
class AuthAPI extends MY_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->library("session");
		$this->load->modal("Biz/User","userbiz");
	}
	public function login()
	{
		$logintype=$_REQUEST["logintype"];
		$key=$_REQUEST["key"];
		$pwd=$_REQUEST["pwd"];
		if($this->userbiz->login($logintype, $key, $pwd))
			echo 1;
		else 
			echo 0;
	}
	public function logout()
	{
		//$this->session->unset_userdata("userinfo")
	}
	public function qqcallback()
	{
	}
	public function wxcallback()
	{
	}
	public function wbcallback()
	{
	}
	public function changepwd()
	{
	}
	public function reguser()
	{
	}
	public function checkemail($email)
	{
	}
	public function checkphone($phone)
	{
	}
	public function checkqq($qq)
	{
	}
	public function checkwx($wx)
	{
	}
	public function checkeb($wb)
	{
	}
	public function checklogin()
	{
		if($this->session->userinfo==null)
			echo 0;
		else {
			echo 1;
		}
	}
}
?>
