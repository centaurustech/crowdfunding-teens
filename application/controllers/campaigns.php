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
	}

	public function index() {
		//$this->view();
		if ($this->session->userdata('user')) {
			$user_session         = $this->session->userdata('user');
			$data['current_user'] = $user_session['fullname'];
			$data['user_pic']     = $user_session['picture'];

			//$this->load->view('view_campaigns', $data);
		} else {
			//redirect(base_url('/login'));
			/*
		$this->load->view('/view_header');
		$this->load->view('/campaigns/view_campaigns');
		$this->load->view('/view_footer');
		 */
		}

		$this->masterpage->view('/campaigns/view_list_campaigns');

	}

	public function show_details($id_campaign = "") {

		$data['rs'] = $this->campaigns_model->get_campaign_info($id_campaign);

		if ($data['rs']) {
			$view_name = "details";
		} else {
			$view_name = "not_found";
		}
		$this->masterpage->view("campaigns/".$view_name, $data);

	}

}

/* End of file campaigns.php */
/* Location: ./application/controllers/campaigns.php */