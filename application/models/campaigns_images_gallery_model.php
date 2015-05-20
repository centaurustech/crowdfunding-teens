<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class campaigns_images_gallery_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->table       = 'campaings_images_gallery';
		$this->primary_key = 'idimagesgallery';
	}

	public function upload($path, $field_container) {

		$this->upload->set_upload_path($path);

		if (!$this->upload->do_upload($field_container)) {

			return array('error' => $this->upload->display_errors());

		} else {

			return array('upload_data' => $this->upload->data());

		}
	}

	public function update_by_campaing_id($idcampaign, $imgurl) {

		$data = array(
			"imgurl" => $imgurl,
		);

		$this->db->where('idcampaign', $idcampaign);
		$result = $this->db->update($this->table, $data);

		return $result;

	}
}
