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

	private function _get_physical_file_path() {
		if (isset($this->_upload_data["upload_data"])) {
			$upload_data = $this->_upload_data["upload_data"];
			return $upload_data["full_path"];
		}
		return null;

	}

	private function _rename_extension($ext_name = "") {

		$full_file_name = $this->_get_physical_file_path();

		$renamed = "";

		if ($full_file_name != null) {

			if ($ext_name == "") {
				$ext_name = $this->_upload_data["file_ext"];
			}

			$upload_data = $this->_upload_data["upload_data"];
			$renamed     = $upload_data["file_path"].$upload_data["raw_name"].'.'.$ext_name;

			return $renamed;
		}
		return null;

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

		$full_file_name = $this->_get_physical_file_path();

		if ($full_file_name != null) {
			return str_replace(FCPATH, base_url(), $full_file_name);
		}
		return null;
	}

	public function resize_uploaded_img($newWidth, $newHeight, $img_file = "") {

		if ($img_file == "") {
			$img_file = $this->_get_physical_file_path();
		}

		// *** 1) Initialize / load image, passing paramenters to constructor as array.
		$this->load->library('resizeimage', array("fileName" => $img_file));

		// *** 2) Resize image using auto (options: exact, portrait, landscape, auto, crop, scale)
		$this->resizeimage->resize($newWidth, $newHeight, 'scale');

		// *** 3) Set new file to PNG
		$png_file = $this->_rename_extension('png');

		// *** 4) Save image
		$this->resizeimage->saveImage($png_file, 100);

		// *** 5) Finally delete de original whether original and new are not identical.
		if ($img_file != $png_file) {
			unlink($img_file);
		}

		//exit('<img src="'.str_replace(FCPATH, base_url(), $png_file).'" alt="">');

		// *** 6) Return the new file name for saving URL in DB.
		return str_replace(FCPATH, base_url(), $png_file);

	}

}
