<?php
class PaperDetails extends RP_Model {
	public function __construct() {
		parent::__construct ();
		$this->dbkey="idpaper";
		$this->dbtable="paperdetails";
	}
	
	public function GetPaper($pid)
	{
		$this->db->where("idpaper",$pid);
		$this->db->order_by("type");
		$qry=$this->db->get($this->dbtable);
		return $qry->result();
	}
}

?>