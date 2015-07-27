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

		if ($this->session->userdata('user')) {
			$user_session = $this->session->userdata('user');
			$iduser       = $user_session["iduser"];
		} else {
			$iduser = null;
		}

		$data = array(
			"idcampaign"         => $this->input->post("idCampaignContrib"),
			"iduser"             => $iduser,
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
		//TODO: Force to approved payment until gateway is deployed.
		//Logic for sending payments to gateway here.

		//$this->update($idcontribution, $data);

		return true;

	}

	public function count_received($userid) {

		$query = $this->db
		              ->select("count(1) count_contrib", false)
		              ->from("contributions as co")
		              ->join("campaigns as c", "co.idcampaign = c.idcampaign")
		              ->join("users as u", "u.iduser = c.iduser")
		              ->where('u.iduser', $userid)
		              ->get();

		if ($query && $query->num_rows > 0) {
			$row = $query->row();

			if (is_null($row->count_contrib)) {
				$row->count_contrib = 0;
			}

			return $row;
		}

		return false;

	}

	public function summary_sent($userid) {

		$query = $this->db
		              ->select("count(1) count_sent_contrib,
		              	sum(co.amount) sum_sent_contrib", false)
		->from("contributions as co")
		->where('co.iduser', $userid)
		->get();

		if ($query && $query->num_rows > 0) {
			$row = $query->row();

			if (is_null($row->count_sent_contrib)) {
				$row->count_sent_contrib = 0;

			}

			if (is_null($row->sum_sent_contrib)) {
				$row->sum_sent_contrib = 0;

			}

			return $row;
		}

		return false;

	}

	public function get_received_by_user($userid) {

		$query = $this->db
		              ->select("c.idcampaign,
								c.camp_name,
								co.amount,
								co.nickname,
								co.payment_date,
								co.notes",
			false)
		->from("contributions as co")
		->join("campaigns as c", "co.idcampaign = c.idcampaign")
		->join("users as u", "u.iduser = c.iduser")
		->where('u.iduser', $userid)
		->order_by('co.payment_date', 'desc')
		->get();

		if ($query && $query->num_rows > 0) {
			$result = $query->result();
			foreach ($result as $row) {
				$length           = strlen($row->notes);
				$row->short_notes = "";
				if ($length > 40) {
					$row->short_notes = trim(substr($row->notes, 0, 40));
					$row->short_notes .= "...";
				} else {
					$row->short_notes = $row->notes;
				}
			}
			return $query->result();
		}

		return false;

	}

	public function get_sent_by_user($userid) {

		$query = $this->db
		              ->select("c.idcampaign,
		              			c.camp_name,
		              			p.fullname camp_owner,
		              			o.username camp_owner_nickname,
		              			co.amount,
								co.payment_date,
								co.service_fee,
								co.total_payment",
			false)
		->from("contributions as co")
		->join("campaigns as c", "co.idcampaign = c.idcampaign")
		->join("users as o", "o.iduser = c.iduser")
		->join("people as p", "p.idpeople = o.idpeople")
		->join("users as u", "u.iduser = co.iduser")
		->where('u.iduser', $userid)
		->order_by('co.payment_date', 'desc')
		->get();

		if ($query && $query->num_rows > 0) {
			return $query->result();
		}

		return false;

	}

	public function get_by_campaign($idcampaign) {
		$query = $this->order_by('payment_date', 'desc')
		              ->get_many_by("idcampaign", $idcampaign);

		if ($query) {
			foreach ($query as $row) {
				if ($row->hide_contrib_name == "1") {
					$row->nickname          = "Anônimo";
					$row->hide_contrib_name = true;
				} else {
					$row->hide_contrib_name = false;
				}
				if ($row->hide_contrib_value == "1") {
					$row->amount             = 0;
					$row->service_fee        = 0;
					$row->total_payment      = 0;
					$row->hide_contrib_value = true;
				} else {
					$row->hide_contrib_value = false;

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
		} else {

			$contrib           = new stdClass();
			$contrib->notes    = "Começa logo a promocionar tua campanha para assim familiares e amigos te adujem a alcançar teu sonho...";
			$contrib->nickname = "Equipe Presente Top";

			return array($contrib);
		}
	}

	public function get_contrib_msg($idcampaign) {

		$rs_contrib = $this->get_by_campaign($idcampaign);

		if ($rs_contrib) {

			$contrib_msg = array();

			foreach ($rs_contrib as $contrib) {
				$msg = "Um presente";

				if (!$contrib->hide_contrib_value) {
					$msg .= ' de <span class="currency">'.strval($contrib->amount).'</span>';
				}

				$msg .= ' foi adicionado por '.$contrib->nickname;
				$contrib_msg += array($msg);

			}

			return $contrib_msg;

		} else {
			return array("Está campanha de presente ainda não recebeu contribuição. Se empolga e contribuia para fazer acontecer...");
		}

	}

}
