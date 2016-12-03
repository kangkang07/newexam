<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends RP_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
// 		$this->load->model("testm");
// 		echo $this->testm->test();
// 		$this->load->library("session");
// 		$this->session->testdata="hhahaha";
// 		$this->load->model("Biz/User");
// 		echo $this->User->testsession();

		
	}
	public function test()
	{
		
		echo $_REQUEST["test"]=="rue";
		//$this->load->view('publish_item.html');
// 		$item=(object)null;
// 		$item->rr=555;
// 		$item->er=444;
// 		print_r($item);
// 		$this->load->helper("array");
// 		$ti=elements(array("rr"), $item);
// 		print_r($ti);
// 		echo $item->rr;
// 		echo $item->er;
		$obj=(object)array("qq"=>3,"rr"=>4);
		$obj1=(object)array("qq"=>5,"rr"=>6);
		$arr=array($obj,$obj1);
		$objj=$arr[1];
		$objj->qq=222;

		print_r($arr);
	}
	public function search()
	{
		$this->load->view('search.html');
	}
	public function result()
	{
		$this->load->view('result_list.html');
	}
}
