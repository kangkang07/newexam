<?php 

/**
 * @category entity class 实体类
 * @author Qikang
 *
 */
class Order extends ET_Model{
	public function __construct(){
		parent::__construct ();
		$this->dbreadtable="order";
		$this->dbwritetable="order";
		$this->dbkey="idorder";

	}
}
?>