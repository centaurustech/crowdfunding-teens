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
		$this->load->model('geography_model');
		$this->load->model('people_model');
		$this->load->model('campaigns_model');
		$this->load->model('contributions_model');
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

		$usr_auth   = $this->users_model->get_auth_user();
		$rs_contrib = false;
		$rs_notes   = false;

		if ($action == 'details'|$action == 'edit') {
			$rs         = $this->campaigns_model->get_campaign_info($idcampaign);
			$rs_contrib = $this->contributions_model->get_by_campaign($idcampaign);
			$rs_notes   = $this->contributions_model->get_last_notes($idcampaign);

		} else if ($action == 'add-new'|$action == 'add_new') {

			if (!$usr_auth) {
				redirect(base_url('login'));
				return;
			}

			$rs = $this->campaigns_model->init($usr_auth);
		} else {
			show_404();
			return;
		}

		// // Prepare array data before sending to the view

		$data = array(
			'rs'              => $rs,
			'rs_contrib'      => $rs_contrib,
			'rs_notes'        => $rs_notes,
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

		//Get first 8 campaign from database.
		$rs_camp = $this->campaigns_model->list_campaigns(false, 0, 8);

		$data = array(
			"rs_camp" => $rs_camp,
		);

		$this->masterpage->view('/campaigns/list', $data);

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

	public function save_img($idcampaign = "") {

		if (!$this->input->post() || $idcampaign == "") {
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

			//Save the image url in DB.
			$result = $this->camp_pictures->save($idcampaign, $imgurl);

			if ($result != false) {
				redirect(base_url("campaigns/details/".$idcampaign));
				return;
			}

		}

		$data = array(
			"msg"        => $file["error"],
			"source_url" => "campaigns/details/".$idcampaign,
		);

		$this->masterpage->view("campaigns/status_action", $data);

		var_dump($file);// Meanwhile, we spit variable. Later, create a view for error.

	}

	public function add_new() {

		$usr_auth = $this->users_model->get_auth_user();

		$this->_render();

	}

	public function delete() {

		if (!$this->input->post()) {
			show_404();
			return;
		}

		$deleted = $this->campaigns_model->delete(
			$this->input->post('idcampaign')
		);

		$data = array(
			"msg"        => $deleted->msg,
			"source_url" => "",
		);

		$this->masterpage->view("campaigns/status_action", $data);

	}

	public function save() {

		if (!$this->input->post()) {
			show_404();
			return;
		}

		$auth_usr = $this->users_model->get_auth_user();

		if ($auth_usr) {

			$data = array(
				"camp_name"        => $this->input->post("inputCampName"),
				"camp_description" => $this->input->post("inputCampDescription"),
				"camp_goal"        => $this->input->post("hiddenCampPriceAmount"),
				"iduser"           => $auth_usr->iduser,
				"creationdate"     => date('Y-m-d H:i:s'),
			);

			$idcampaign = $this->input->post("idcampaign");

			$id = $this->campaigns_model->save($idcampaign, $data);

			if ($id) {
				redirect(base_url('campaigns/details/'.$id));
			} else {
				$data = array(
					"msg" => "Error ao salvar a campanha",
				);

				$this->masterpage->view("campaigns/status_action", $data);
			}

		} else {

			redirect(base_url('login'));

		}

	}
	function get_campaign_ajax($offset = 0) {
		if ($offset > 0) {

		} else {
			show_404();
		}

	}

}

/* End of file campaigns.php */
/* Location: ./application/controllers/campaigns.php */