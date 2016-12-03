<?php

/**
 * @property Category $model
 * @author Qikang
 *
 */
class CatAPI extends TR_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model("Tag/Category","model");
		
	}
}

?>