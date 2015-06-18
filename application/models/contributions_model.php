<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class contributions_model extends MY_Model {

	public function contributions_model() {
		parent::__construct();
		$this->primary_key = "idcontribution";

	}

	public function calculate_payment($contrib_value) {

		$payment_data = new stdClass();

		$payment_data->gross_amount  = $contrib_value;
		$payment_data->fee_campaign  = $contrib_value*0.1;// TODO: Hardcoded, get value from setting tables.
		$payment_data->total_payment = $payment_data->gross_amount+$payment_data->fee_campaign;

		return $payment_data;

	}

	public function create_payment() {

		$data = array(
			"idcampaign"         => $this->input->post("idCampaignContrib"),
			"amount"             => $this->input->post("inputValContribute"),
			"service_fee"        => $this->input->post("inputFeeContribute"),
			"total_payment"      => $this->input->post("inputTotalPayment"),
			"payment_date"       => date('Y-m-d H:i:s'),
			"nickname"           => $this->input->post("inputSignature"),
			"notes"              => $this->input->post("inputContribMsg"),
			"hide_contrib_name"  => $this->input->post("chkHideContribName"),
			"hide_contrib_value" => $this->input->post("chkHideContribValue"),
		);

		$stm = $this->insert($data);

		if ($stm != false) {
			$obj                 = new stdClass();
			$obj->idcontribution = str_pad(intval($stm), 11, "0", STR_PAD_LEFT);
			$obj->idcampaign     = $data["idcampaign"];
			$obj->contrib_amount = $data["amount"];
			return $obj;
		}

		return false;

	}

	public function send_payment($idcontribution) {
		//TODO: Force to approved payment until gateway is deployed. Logic for sending payments to gateway here.

		//$this->update($idcontribution, $data);

		return true;

	}

}
