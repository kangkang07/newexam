<?php 
/**
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_Calendar $calendar
 * @property Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Language $language
 * @property CI_Log $log
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Unit_test $unit
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Zip $zip
 */


/**
 * @property ET_Model $model
 * @author Qikang
 *
 */

class ET_Controller extends CI_Controller {
	public function __construct() {
		
		parent::__construct ();
		$this->load->library("session");
	}



	public function GetByID($id)
	{
		$obj=$this->model->GetByID($id);
		echo json_encode($obj);
	}
	public function GetBy()
	{
		$objs=$this->model->GetList($_REQUEST['param']);
		echo json_encode($objs);
	}
	public function GetAll()
	{
		$objs=$this->model->GetList();
		echo json_encode($objs);
	}
	public function Create()
	{
		$obj=$_REQUEST['data'];
		$this->model->Create(obj);
		echo 1;
	}

	public function Update()
	{
		$param=$_REQUEST['param'];
		$data=$_REQUEST['data'];
		if($this->model->UpdateBy($param, $data)>0)
			echo 1;
		else
			echo 0;
	}
	public function UpdateByID()
	{
		$id=$_REQUEST['id'];
		$data=$_REQUEST['data'];
		echo $this->model->UpdateByID($id, $data);

	}
	public function DeleteByID($id)
	{
		echo $this->model->Delete($id);

	}
	public function Delete()
	{
		$param=$_REQUEST["param"];
		echo $this->model->Delete($param);
	}
	public function AddTag()
	{
		$entityid=$_REQUEST["id"];
		$catid=$_REQUEST["catid"];
		$tag=$_REQUEST["tag"];
		echo $this->model->AddTag($entityid, $catid, $tag);
		
	}
	public function DeleteTag()
	{
		$entityid=$_REQUEST["id"];
		$tagid=$_REQUEST["tagid"];
		echo $this->taglogic->Delete(array("entityid"=>$entityid,"tagid"=>$tagid));
	}
	public function GetAllTags($entityid)
	{
		echo json_encode($this->model->GetAllTags($entityid));
	}
	public function GetTagByCat($cat,$id)
	{
		echo json_encode($this->model->GetTagByCat($cat, $id));
	}
	public function GetTagsByCats()
	{
		$cats=$_REQUEST["cats"];
		$id=$_REQUEST["id"];
		echo json_encode($this->model->GetTagsByCats($cats, $id));
	}
}
class TR_Controller extends ET_Controller {
	public function __construct() {

		parent::__construct ();
		
	}
	
	public function GetTree($id)
	{
		echo json_encode($this->model->GetTree($id));
	}
}
?>
