<?php
/**
 * Summary of Examapi
 * @property User $user
 * @property RP_Model $exam
 * @property Invicode $icode
 */
class Examapi extends RP_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Rep/Exam","model");
	}

	public function GetAll(){
		$objs=$this->model->GetList();
		$this->load->model("Rep/ExamChapter","echap");
		foreach ($objs as $e)
		{
			$e->chapters=$this->echap->GetByExam($e->idexam);
			for($i=0;$i<count($e->chapters);$i++)
			{
				$e->chapters[$i]=$e->chapters[$i]->chapter;
			}
            // 			foreach ($e->chapters as $ec)
            // 			{
            // 				$ec=$ec->chapter;
            // 			}
		}
		$this->outputjson($objs);
	}

	public function index()
	{
		$this->loadview("exammanagement.html");
	}
	public function EnableExam($id)
	{
		$this->model->UpdateByID($id, array("enabled"=>1));
	}
	public function DisableExam($id)
	{
		$this->model->UpdateByID($id, array("enabled"=>0));
	}
	public function CreateExam()
	{
		$obj=$_REQUEST["data"];
		$chaps=$obj["chapters"];
		unset($obj["chapters"]);
		$exam=$this->model->Create($obj);
		$id=$exam->idexam;
		$this->load->model("Rep/ExamChapter","echap");
		foreach ($chaps as $ec)
		{
			$this->echap->Create(array("exam"=>$id,"chapter"=>$ec));
		}
		$obj["idexam"]=$id;
		$obj["chapters"]=$chaps;
		$this->outputjson($obj);
	}

	public function UpdateExam(){
		$id=$_REQUEST["id"];
		$obj=$_REQUEST["data"];
		//print_r($obj);
		$chaps=$obj["chapters"];
		unset($obj["chapters"]);
		$this->model->UpdateByID($id, $obj);
		$this->load->model("Rep/ExamChapter","echap");
		$this->echap->Delete(array("exam"=>$id));
		foreach ($chaps as $ec)
		{
			$this->echap->Create(array("exam"=>$id,"chapter"=>$ec));
		}
		$obj["idexam"]=$id;
		$this->outputjson($obj);
	}

    private $sheet;
    private function Cell($col, $row)
    {
        return $this->sheet->getCellByColumnAndRow($col, $row)->getValue();
    }

    /**
     * Summary of ImportUser
     * @property User $user
     * @property RP_Model $exam
     */
    public function ImportUser(){
        $config['upload_path']      = './upload/';
		$config['allowed_types']    = 'xlsx|xls|csv';
		$config['max_size']     = 10000;
		$config['max_width']        = 1024;
		$config['max_height']       = 768;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('usersheet'))
		{

            $this->errorpage("导入失败", $this->upload->display_errors());

		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			include './phpexcel/PHPExcel.php';
			$inputFileName="./upload/".$data['upload_data']["file_name"];
			if($data["upload_data"]["file_ext"]==".xls") {
				$objReader = PHPExcel_IOFactory::createReader("Excel5");
			}
			else {
				$objReader = PHPExcel_IOFactory::createReader("Excel2007");
			}
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($inputFileName);
		    $this->sheet = $objPHPExcel->getSheet(0);
			$highestRow = $this->sheet->getHighestRow();
            $this->load->model("Rep/User","user");
            $this->load->model("Rep/Exam","exam");
            $this->load->model("Rep/Invicode","icode");
            $eid=$_REQUEST["examid"];
            for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
                if(trim($this->Cell(0,$row))=="")
                    break;

                $u= $this->user->UpsertBySID(array(
                    "schoolid"=>$this->Cell(0,$row),
                    "name"=>$this->Cell(1,$row),
                    "role"=>3
                    ));
                
                $this->icode->GenerateCode($eid,$u->iduser);
			}
			$this->load->helper('url');
			redirect("/Answersheetapi/ExamUsers/".$eid);
            //echo $eid;
		}
    }

}

?>
