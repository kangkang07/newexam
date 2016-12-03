<?php
class VWAnswerSheet extends RP_Model {
	public function __construct() {
		parent::__construct ();
		$this->dbkey="idanswersheet";
		$this->dbtable="vwanswersheet";
	}
}

?>