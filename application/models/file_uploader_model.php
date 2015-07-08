<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class file_uploader_model extends MY_Model {

	private $_upload_data;

	public function __construct() {
		parent::__construct();
	}

	private function _restore_permission($path) {
		if ((is_dir($path)|is_file($path)) && chmod($path, 0777)) {
			chmod($path, 0755);
		}
	}

	private function _set_write_permission($path) {
		if (is_dir($path)) {
			chmod($path, 0777);
			return true;
		}
		return false;
	}

	public function upload($path, $field_container) {

		$folder_exists = $this->_set_write_permission($path);

		if ($folder_exists) {

			$this->upload->set_upload_path($path);

			if (!$this->upload->do_upload($field_container)) {
				$this->_upload_data = array('error' => $this->upload->display_errors());
			} else {
				$upload_data = $this->upload->data();
				$this->_restore_permission($upload_data["full_path"]);
				$this->_upload_data = array('upload_data' => $upload_data);
			}

			$this->_restore_permission($path);

		} else {

			$this->_upload_data = array('error' => "Não existe pasta de usuârio para fazer upload de imagens");

		}

		return $this->_upload_data;
	}

	public function get_uploaded_path() {

		if (isset($this->_upload_data["upload_data"])) {
			$upload_data = $this->_upload_data["upload_data"];
			return str_replace(FCPATH, base_url(), $upload_data["full_path"]);
		}
		return null;
	}
}
