<?php 

/**
 * @category entity class 实体类
 * @author Qikang
 *
 */
class Item extends ET_Model{
	public function __construct(){
		parent::__construct ();
		$this->dbreadtable="item";
		$this->dbwritetable="item";
		$this->dbkey="iditem";
		$this->tagsourceid=2;
		
		$this->fields=array(
				"iditem",
				"name",
				"type",
				"description",
				"createdon",
				"updatedon",
				"owner",//id
				"quantity",
				"status",
				"price",
				
		);
	}
	public function GetImages($id)
	{
		$this->db->where("iditem",$id);
		$qry=$this->db->get("vwitemimage");
		return $qry->result();
	}
	
	public function GetItems($withimg,$withtags)
	{
		
	}
	
	
	

}
?>