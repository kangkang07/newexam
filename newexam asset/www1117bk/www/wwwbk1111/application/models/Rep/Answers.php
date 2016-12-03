<?php
class Answers extends RP_Model {
	public function __construct() {
		parent::__construct ();
		$this->dbkey="idanswers";
		$this->dbtable="answers";
	}
}

?>