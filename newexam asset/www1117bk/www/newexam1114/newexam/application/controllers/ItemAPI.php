<?php
/**
 * @property Item $model
 * @author Qikang
 *
 */
class ItemAPI extends ET_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Item","model");
	}
	public function GetImages($id)
	{
		echo  json_encode($this->model->GetImages($id));
	}
	public function GetItems()
	{
		$withimages=$_REQUEST["withimages"];
		$withtags=$_REQUEST["withtags"];
		//$tags=$_REQUEST["param"];
		$items=$this->model->GetList();
		foreach ($items as $it)
		{
			if($withimages)
				$it->images=$this->model->GetImages($it->iditem);
			if($withtags)
				$it->tags=$this->model->GetAllTags($it->iditem);
			
		}
	}
	
	
	
	
}
?>
