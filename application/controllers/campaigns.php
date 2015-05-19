<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class campaigns extends CI_Controller {

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
		$this->masterpage->use_session_info();
	}

	public function index() {

		$this->masterpage->view('/campaigns/view_list_campaigns');

	}

	public function details($id_campaign = "") {

		$data['rs'] = $this->campaigns_model->get_campaign_info($id_campaign);

		if ($data['rs']) {
			$view_name = "details";
		} else {
			$view_name = "not_found";
		}
		$this->masterpage->view("campaigns/".$view_name, $data);

	}

	public function save() {

		if (!$this->input->post()) {
			show_404();
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
			echo json_encode(
				array(
					"result" => false,
					"msg"    => "Erro ao atualizar campo.",
				)
			);
		}

	}

}

/* End of file campaigns.php */
/* Location: ./application/controllers/campaigns.php */