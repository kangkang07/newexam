<?php

/**
 * @property Tag $model
 * @author Qikang
 *
 */
class TagAPI extends TR_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Tag/Tag","model");
	}
	
	
}

?>