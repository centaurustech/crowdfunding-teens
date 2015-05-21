<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class campaigns extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/campaigns
	 *	- or -
	 * 		http://example.com/index.php/campaigns/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/campaigns/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
		$this->load->model('people_model');
		$this->load->model('campaigns_model');
		$this->load->model('campaigns_images_gallery_model', 'camp_pictures');

		$this->masterpage->use_session_info();
	}

	/*	Private Methods	 */
	private function _render($idcampaign = "") {

		// Request data to model for editing or querying campaign.

		$action = strtolower($this->router->method);

		/*
		Uncomment block for redirecting to listing campaign instead of showing 404 page.
		if ($idcampaign == "") {
		show_404();
		return;
		}
		 */

		if ($action == 'details'|$action == 'edit') {
			$rs = $this->campaigns_model->get_campaign_info($idcampaign);
		}if ($action == 'addnew') {
			$rs = $this->campaigns_model->init();
		} else {
			show_404();
			return;
		}

		// // Prepare array data before sending to the view

		$data = array(
			'rs'              => $rs,
			'controller_name' => $this->router->class,
			'action_name'     => $action,
		);

		if ($data['rs']) {
			$view_name = "details";
		} else {
			$view_name = "not_found";
		}

		$this->masterpage->view("campaigns/".$view_name, $data);

	}

	/*	Public Methods	 */

	public function index() {

		$this->masterpage->view('/campaigns/view_list_campaigns');

	}

	public function details($idcampaign = "") {

		$this->_render($idcampaign);

	}

	public function edit($idcampaign = "") {

		$this->_render($idcampaign);

	}

	public function update_field() {

		if (!$this->input->post()) {
			show_404();
			return;
		}

		$new_data = array(
			$this->input->post('fieldName')=> $this->input->post('value'),
		);

		$result = $this->campaigns_model->update(
			$this->input->post('record_id'),
			$new_data
		);

		if ($result === true && $this->campaigns_model->affected_rows() > 0) {
			echo json_encode(
				array(
					"result"    => true,
					"msg"       => "Registro atualizado",
					"new_value" => $this->input->post('value'),
				)
			);
		} else {
			log_message(
				'error',
				'Error #'.$this->db->_error_number().': '.$this->db->_error_message()
			);
			echo json_encode(
				array(
					"result" => false,
					"msg"    => "Erro ao atualizar campo.".$this->db->_error_message(),
				)
			);
		}
	}

	public function save_img() {

		if (!$this->input->post()) {
			show_404();
			return;
		}

		//Check for private user folder and set it for uploading.
		$path = $this->users_model->create_user_folder();

		//Upload the image.
		$file = $this->camp_pictures->upload($path, "uploadCampaignPict");

		// Image successfully uploaded
		if (isset($file["upload_data"])) {
			$upload_data = $file["upload_data"];
			$imgurl      = str_replace(FCPATH, base_url(), $upload_data["full_path"]);

			$campaign_id = "1";// Get idcampaign from HTML (later)
			//Save the image url in DB.
			$result = $this->camp_pictures->update_by_campaing_id($campaign_id, $imgurl);

			redirect(base_url('campaigns/details/1'));
		}

		var_dump($file);// Meanwhile, we spit variable. Later, create a view for error.

	}

	public function addnew() {

		$this->_render();
	}

	public function delete() {

		if (!$this->input->post()) {
			show_404();
			return;
		}

		$result = $this->campaigns_model->delete(
			$this->input->post('idcampaign')
		);

		$msg = $result?
		"Campanha de presente apagada com sucesso.":
		"Erro ao apagar esta campanha";

		$data = array(
			"msg" => $msg,
		);

		$this->masterpage->view("campaigns/status_deleted_updated", $data);

	}

}

/* End of file campaigns.php */
/* Location: ./application/controllers/campaigns.php */