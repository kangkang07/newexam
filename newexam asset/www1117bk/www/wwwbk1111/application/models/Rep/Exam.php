<?php
class Exam extends RP_Model {
	public function __construct() {
		parent::__construct ();
		$this->dbtable="exam";
		$this->dbkey="idexam";
		$this->fields=array();
	}

}

?>