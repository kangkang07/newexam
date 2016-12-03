<?php


class Chapter extends RP_Model {
	public function __construct() {
		parent::__construct ();
		$this->dbtable="chapter";
		$this->dbkey="idchapter";
		$this->fields=array();
	}
	
	public function AllIds()
	{
		$allchaps=$this->GetList();
		$ids=array();
		foreach($allchaps as $chap)
		{
			array_push($ids, $chap->idchapter);
		}
		return $ids;
	}
}

?>