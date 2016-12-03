<?php
class Questionapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/Question","model");
	}
	
	public function index()
	{
		$this->loadview("editquestion.html");
	}
	public function editpage()
	{
		
		
	}
	
	public function previewchapter($cid)
	{
		$data["qstlist"]=$this->model->GetList(array("chapter"=>$cid),"type,CAST(refid as signed)");
		$this->loadsimpleview("previewchapter",$data);
	}
	
	public function importqst()
	{
		$config['upload_path']      = './upload/';
		$config['allowed_types']    = 'xlsx';
		$config['max_size']     = 10000;
		$config['max_width']        = 1024;
		$config['max_height']       = 768;
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('datasheet'))
		{
			$error = array('error' => $this->upload->display_errors());
		
			$this->load->view('upload_form.html', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			include './phpexcel/PHPExcel.php';
			$inputFileName="./upload/".$data['upload_data']["file_name"];
			$objReader = PHPExcel_IOFactory::createReader("Excel2007");
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($inputFileName);
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
		$this->load->model("Rep/Question","qst");

		$chapid=$_REQUEST["chapid"];
		for ($row = 2; $row <= 29; $row++){//行数是以第1行开始
			if(trim($sheet->getCellByColumnAndRow(4, $row)->getValue())=="")
				continue;
			$this->qst->Create(array(
					"chapter"=>$chapid,
					"group"=>$sheet->getCellByColumnAndRow(1, $row)->getValue(),
					"star"=>$sheet->getCellByColumnAndRow(2, $row)->getValue(),
					"type"=>$sheet->getCellByColumnAndRow(3, $row)->getValue(),
					"maintext"=>$sheet->getCellByColumnAndRow(4, $row)->getValue(),
					"o1"=>$sheet->getCellByColumnAndRow(5, $row)->getValue(),
					"o2"=>$sheet->getCellByColumnAndRow(6, $row)->getValue(),
					"o3"=>$sheet->getCellByColumnAndRow(7, $row)->getValue(),
					"o4"=>$sheet->getCellByColumnAndRow(8, $row)->getValue(),
					"answer"=>$sheet->getCellByColumnAndRow(9, $row)->getValue(),
					"title"=>$sheet->getCellByColumnAndRow(4, $row)->getValue(),
					"refid"=>$sheet->getCellByColumnAndRow(10, $row)->getValue(),
					
				));
			}
			$this->load->helper('url');
			redirect("/Questionapi");
			//$this->loadview("editquestion.html");
		}
		
	}
	public function testdb()
	{
		$this->load->database();
		$this->db->get("question");
	}
	public function testc()
	{
		echo $_REQUEST["ccc"];
	}
}

?>