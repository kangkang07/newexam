<?php
class OrderAPI extends ET_Controller {
	//登陆后每个用户默认有一个购物车
	public function __construct() {
		parent::__construct ();
		if($this->session->user==null)
		{
			echo "login needed";
			exit;
				
		}
	}
// 	public function CreateOrder()
// 	{
// 		$itemid=$_REQUEST['itemid'];
// 		$uid
// 	}
}
?>
