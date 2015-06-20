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
			"hide_contrib_name"  => $this->input->post("chkHideContribName") == "1",
			"hide_contrib_value" => $this->input->post("chkHideContribValue") == "1",
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

	public function get_by_campaign($idcampaign) {
		$query = $this->order_by('payment_date', 'desc')
		              ->get_many_by("idcampaign", $idcampaign);

		if ($query) {
			foreach ($query as $row) {
				if ($row->hide_contrib_name) {
					$row->nickname = "Anônimo";
				}
				if ($row->hide_contrib_value) {
					$row->amount        = 0;
					$row->service_fee   = 0;
					$row->total_payment = 0;
				}
			}

			return $query;
		}

		return false;
	}

	public function get_last_notes($idcampaign, $recent_date = "") {

		$query = $this->db->select("
					c.idcontribution,
					c.notes,
					c.nickname,
					c.payment_date", false)
		->from("contributions c")
		->where("c.idcampaign", $idcampaign)
		->limit(2)
		->order_by('c.payment_date desc');

		if ($recent_date != "") {
			$query = $query->where("c.payment_date < ", $recent_date);
		}

		$query = $query->get();

		if ($query && $query->num_rows > 0) {
			return $query->result();
		}

		return false;
	}

}
