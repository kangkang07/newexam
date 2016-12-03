<?php
class UserExam extends RP_Model {
	public function __construct() {
		parent::__construct ();
		$this->dbkey="iduserexam";
		$this->dbtable="userexam";
	}
}

?>