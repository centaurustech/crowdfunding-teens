<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class document_type_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->_table      = 'document_type';
		$this->primary_key = 'doctype_id';
	}
}
