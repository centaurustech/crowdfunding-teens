<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class checkout extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/checkout
	 *	- or -
	 * 		http://example.com/index.php/checkout/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/checkout/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
		$this->load->model('geography_model');
		$this->load->model('people_model');
		$this->load->model('campaigns_model');
		$this->load->model('campaigns_images_gallery_model', 'camp_pictures');
		$this->load->model('contributions_model');

		$this->masterpage->use_session_info();
	}

	private function _prepare_checkout() {
		$idcampaign = $this->input->post("idCampaignContrib");
		$rs         = $this->campaigns_model->get_campaign_info($idcampaign);

		$this->masterpage->header      = "/shared/view_header_checkout";
		$this->masterpage->header_vars = array(
			"confirm_checkout" => "",
			"payment_method"   => "",
			"payment_result"   => "",
			"rs"               => $rs,
		);

		return $rs;

	}

	private function _set_checkout_step($step_name) {
		$this->masterpage->header_vars[$step_name] = "checkout-current-step";
	}

	/*	Public Methods	 */

	public function index() {

		$this->masterpage->view('/checkout/confirm_contribution');

	}

	public function contribute() {

		$this->_prepare_checkout();
		$this->_set_checkout_step("confirm_checkout");

		$data = array(
			"idCampaignContrib"  => $this->input->post("idCampaignContrib"),
			"inputValContribute" => $this->input->post("inputValContribute"),
		);

		//$this->masterpage->footer = "";	//TODO: create an empty footer view and insert it in masterpage.
		$this->masterpage->view("checkout/confirm_contribution", $data);
	}

	public function payment_method() {

		$rs = $this->_prepare_checkout();
		$this->_set_checkout_step("payment_method");

		$rs_countries = $this->geography_model->get_countries();

		$contrib_value = $this->input->post("inputValContribute");
		$payment_info  = $this->contributions_model->calculate_payment($contrib_value);

		$data = array(
			"idCampaignContrib"   => $this->input->post("idCampaignContrib"),
			"inputValContribute"  => $this->input->post("inputValContribute"),
			"inputContribValue"   => $this->input->post("inputContribValue"),
			"inputSignature"      => $this->input->post("inputSignature"),
			"inputContribMsg"     => $this->input->post("inputContribMsg"),
			"chkHideContribValue" => $this->input->post("chkHideContribValue")?"1":"0",
			"chkHideContribName"  => $this->input->post("chkHideContribName")?"1":"0",
			"payment_info"        => $payment_info,
			"rs"                  => $rs,
			"countries_list"      => $rs_countries,
		);

		//$this->masterpage->footer = "";	//TODO: create an empty footer view and insert it in masterpage.
		$this->masterpage->view("checkout/payment_method", $data);

	}

	public function process_payment() {

		$rs_contrib = $this->contributions_model->create_payment();

		//TODO: Check payment creation before redirecting.

		//Emulate

		$result_contrib = $this->campaigns_model->contribute($rs_contrib->idcampaign, $rs_contrib->contrib_amount);

		redirect(base_url('checkout/payment-confirmation/'.$rs_contrib->idcontribution));

	}

	public function payment_confirmation($idcontribution) {
		//$rs = $this->_prepare_checkout();
		//$this->_set_checkout_step("payment_result");

		$idcontribution = intval($idcontribution);

		$rs_contrib  = $this->contributions_model->get($idcontribution);
		$rs_campaign = $this->campaigns_model->get_campaign_info($rs_contrib->idcampaign);

		$data = array(
			"rs_campaign" => $rs_campaign,
			"rs_contrib"  => $rs_contrib,
		);

		//$this->masterpage->footer = "";	//TODO: create an empty footer view and insert it in masterpage.
		$this->masterpage->view("checkout/payment_confirmation", $data);

	}

}

/* End of file checkout.php */
/* Location: ./application/controllers/checkout.php */