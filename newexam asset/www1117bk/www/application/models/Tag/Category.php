<?php 

/**
 * @category entity class 实体类
 * @author Qikang
 *
 */
class Category extends TR_Model{
	public function __construct(){
		parent::__construct ();
		$this->dbreadtable="category";
		$this->dbwritetable="category";
		$this->dbkey="idcategory";
		$this->dbfatherRef="fcategory";
	}
}

?>