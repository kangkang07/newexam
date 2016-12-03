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
 *
 */


/**
 * @property RP_Model $model
 * @author Qikang
 *
 */

class RP_Controller extends CI_Controller {
	public function __construct() {

		parent::__construct ();
		$this->load->helper('url');
		$this->load->library("session");
		//echo uri_string();
        $uri=strtolower(uri_string());
        $flag=true;
        if(!$this->session->has_userdata('user')){
            
            $flag=$flag & strpos($uri,"userapi")===false;
            $flag=$flag & !$uri=="";
            $flag=$flag & strpos($uri,"bycode")===false;
            $flag=$flag & strpos($uri,"fromcode")===false;
          
            if($flag)
            {
                redirect("/UserAPI");
            }

        }
        //if(!$this->session->has_userdata('user')&&uri_string()!="Userapi"&&uri_string()!="Userapi/Login"&&uri_string()!=""&&uri_string()!="")
        //{
        //    //echo 33;
        //    redirect("/Userapi");
        //}
	}



	public function GetByID($id)
	{
		$obj=$this->model->GetByID($id);
		$this->outputjson($obj);
	}
	public function GetBy()
	{
		$orderby="";
		if(!empty($_REQUEST["orderby"]))
			$orderby=$_REQUEST['orderby'];
		$objs=$this->model->GetList($_REQUEST['param'],$orderby);
		$this->outputjson($objs);
	}
	public function GetAll()
	{
		$objs=$this->model->GetList();
		$this->outputjson($objs);
	}
	public function Create()
	{
		$obj=$_REQUEST['data'];
		$newobj=$this->model->Create($obj);
		$this->outputjson($newobj);
	}

	public function Update()
	{
		$param=$_REQUEST['param'];
		$data=$_REQUEST['data'];
		$newobj=$this->model->UpdateBy($param, $data);
		$this->outputjson($newobj);

	}
	public function UpdateByID()
	{
		$id=$_REQUEST['id'];
		$data=$_REQUEST['data'];
		$this->outputjson($this->model->UpdateByID($id, $data));


	}
	public function DeleteByID($id)
	{
		echo $this->model->DeleteByID($id);

	}
	public function Delete()
	{
		$param=$_REQUEST["param"];
		echo $this->model->Delete($param);
	}

	protected function loadview($view,$data=null)
	{
		$this->load->view("layout/header.php");

		$this->load->view($view,$data);
		$this->load->view("layout/footer.html");
	}
	public function loadsimpleview($view,$data=null)
	{
		$this->load->view("layout/simpleheader.php");
		$this->load->view($view,$data);
		$this->load->view("layout/footer.html");
	}
	protected function outputjson($data)
	{
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data,JSON_NUMERIC_CHECK));
	}

    protected function errorpage($title,$msg="")
    {
        $data["title"]=$title;
        $data["msg"]=$msg;
        $this->loadsimpleview("error.php",$data);
    }

}

?>
