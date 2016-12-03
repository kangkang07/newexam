<?php

/**
 * Created by PhpStorm.
 * User: yuanq
 * Date: 2016-11-27
 * Time: 22:11
 */
class UploadExcel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        include './phpexcel/PHPExcel.php';
    }
    private $sheet;

    public $highestRow;

    public function Cell($col,$row){
        return $this->sheet->getCellByColumnAndRow($col, $row)->getValue();
    }
    public function GetBook($fieldname)
    {
        $config['upload_path']      = './upload/';
        $config['allowed_types']    = 'xlsx|xls|csv';
        $config['max_size']     = 10000;
        $config['max_width']        = 1024;
        $config['max_height']       = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($fieldname))
        {

            throw new Exception("File upload error");

        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $inputFileName="./upload/".$data['upload_data']["file_name"];
            if($data["upload_data"]["file_ext"]==".xls") {
                $objReader = PHPExcel_IOFactory::createReader("Excel5");
            }
            else {
                $objReader = PHPExcel_IOFactory::createReader("Excel2007");
            }
            //$objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFileName);
            $this->sheet = $objPHPExcel->getSheet(0);
            $this->highestRow = $this->sheet->getHighestRow();
        }
    }

    public function GetSheet($sheetname=null){

    }

}

?>