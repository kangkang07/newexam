<?php
class Question extends RP_Model {
	public function __construct() {
		parent::__construct ();
		$this->dbtable="question";		
		$this->dbkey="idquestion";
		$this->fields=array();
	}
	
	
}

?>