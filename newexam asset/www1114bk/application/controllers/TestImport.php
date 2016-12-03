<?php
class TestImport extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->helper(array('form', 'url'));
	}
	
	public function index()
	{
		$this->load->view('upload_form.html', array('error' => ' ' ));
	}
	public function importf()
	{
		include './phpexcel/PHPExcel.php';
		$objReader = PHPExcel_IOFactory::createReader("Excel2007");
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load("./import.xlsx");
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$this->load->model("Rep/Question","qst");

		for ($row = 2; $row <= 29; $row++){//行数是以第1行开始
			$this->qst->Create(array(
					"chapter"=>$sheet->getCellByColumnAndRow(1, $row)->getValue(),
					"group"=>$sheet->getCellByColumnAndRow(2, $row)->getValue(),
					"star"=>$sheet->getCellByColumnAndRow(3, $row)->getValue(),
					"type"=>$sheet->getCellByColumnAndRow(4, $row)->getValue(),
					"maintext"=>$sheet->getCellByColumnAndRow(5, $row)->getValue(),
					"o1"=>$sheet->getCellByColumnAndRow(6, $row)->getValue(),
					"o2"=>$sheet->getCellByColumnAndRow(7, $row)->getValue(),
					"o3"=>$sheet->getCellByColumnAndRow(8, $row)->getValue(),
					"o4"=>$sheet->getCellByColumnAndRow(9, $row)->getValue(),
					"answer"=>$sheet->getCellByColumnAndRow(10, $row)->getValue(),
					"title"=>$sheet->getCellByColumnAndRow(11, $row)->getValue(),
					"refid"=>$sheet->getCellByColumnAndRow(12, $row)->getValue(),
					
				));
				
		}
	}
	public function doupload()
	{
		$config['upload_path']      = './upload/';
		$config['allowed_types']    = 'xlsx';
		$config['max_size']     = 10000;
		$config['max_width']        = 1024;
		$config['max_height']       = 768;
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('userfile'))
		{
			$error = array('error' => $this->upload->display_errors());
		
			$this->load->view('upload_form.html', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			include '../phpexcel/PHPExcel.php';
			$inputFileName="./upload/".$data['upload_data']["file_name"];
			$objReader = PHPExcel_IOFactory::createReader("Excel2007");
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($inputFileName);
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
					$columnName = PHPExcel_Cell::stringFromColumnIndex($column);
					$data["questions"][$row]["text"]=$sheet->getCellByColumnAndRow(0, $row)->getValue();
					$data["questions"][$row]["a"]=$sheet->getCellByColumnAndRow(1, $row)->getValue();
					$data["questions"][$row]["b"]=$sheet->getCellByColumnAndRow(2, $row)->getValue();
					$data["questions"][$row]["c"]=$sheet->getCellByColumnAndRow(3, $row)->getValue();
					$data["questions"][$row]["d"]=$sheet->getCellByColumnAndRow(4, $row)->getValue();
					$data["questions"][$row]["as"]=$sheet->getCellByColumnAndRow(5, $row)->getValue();
					
			}
			
			
		
			$this->load->view('upload_success', $data);
		}
	}
}

?>