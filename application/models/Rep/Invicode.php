<?php
class Invicode extends RP_Model {
	public function __construct() {
		parent::__construct ();
		$this->dbkey="idinvitable";
		$this->dbtable="invitable";
	}

    public function GetCodeInfo($code)
    {
        return $this->GetOne(array("invicode"=>$code));
    }

    public function GetSource($code){
        return $this->GetCodeInfo($code)->sourceid;
    }
    public function GetResult($code){
        return $this->GetCodeInfo($code)->targetid;
    }

    /**
     * 
     * 
     * @param mixed $source exam id
     * @param mixed $target user id
     */
    public function GenerateCode($source,$target)
    {
        $code = $this->MakeCode();
        $this->Delete(array("sourceid" => $source, "targetid" => $target));
        $this->Create(array("invicode" => $code, "sourceid" => $source, "targetid" => $target));
    }

    private function MakeCode(){
        $code=rand(10000000,99999999);
        if(!$this->CheckExist($code))
            return $code;
        else
            return $this->MakeCode();
    }
    private function CheckExist($code)
    {
        $num=$this->Count(array("invicode"=>$code));
        return $num>0;
            
    }

    public function SetResult($code,$resultid)
    {
        $this->UpdateBy(array("invicode"=>$code),array("resultid"=>$resultid));
    }
}

?>