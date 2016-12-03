<?php


class PaperQuestion extends RP_Model {
	public function __construct() {
		parent::__construct ();
		$this->dbtable="paperquestion";
		$this->dbkey="idpaperquestion";
		$this->fields=array();
	}
}

?>