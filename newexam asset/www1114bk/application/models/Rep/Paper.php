<?php
class Paper extends RP_Model {
	public function __construct() {
		parent::__construct ();
		$this->dbtable="paper";
		$this->dbkey="idpaper";
		$this->fields=array();
	}
	
	public function GeneratePaper()
	{
		
	}
	
	
}

?>