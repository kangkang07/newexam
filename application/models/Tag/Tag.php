<?php 

/**
 * @category entity class 实体类
 * @author Qikang
 *
 */
class Tag extends TR_Model{
	public function __construct(){
		parent::__construct ();
		$this->dbreadtable="vwtagcat";
		$this->dbwritetable="tag";
		$this->dbkey="idtag";
		$this->dbfatherRef="ftag";
		$this->fields=array(
				"idtag",
				"tagname",
				"ftag",
				"categoryname",
				"idcategory",
				"fcategory",
				"note",
				"alias"
		);
	}
	
	
}
?>