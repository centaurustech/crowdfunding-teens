<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class campaigns_images_gallery_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->table       = 'campaigns_images_gallery';
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

	public function save($idcampaign, $imgurl) {
		$query = $this->db
		              ->select('*')
		              ->from($this->table)
			->where('idcampaign', $idcampaign)
			->get();

		if ($query->num_rows > 0) {
			return $this->update($idcampaign, $imgurl);

		} else {

			return $this->insert($idcampaign, $imgurl);

		}

	}

	public function insert($idcampaign, $imgurl) {

		$data = array(
			"imgurl"       => $imgurl,
			"idcampaign"   => $idcampaign,
			"creationdate" => date('Y-m-d H:i:s'),
		);

		$result = $this->db->insert($this->table, $data);

		return $result;

	}

	public function update($idcampaign, $imgurl) {

		$data = array(
			"imgurl"      => $imgurl,
			"editiondate" => date('Y-m-d H:i:s'),
		);

		$this->db->where('idcampaign', $idcampaign);
		$result = $this->db->update($this->table, $data);

		return $result;

	}
}
