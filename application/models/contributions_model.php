<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class contributions_model extends MY_Model {

	public function contributions_model() {
		parent::__construct();
		$this->primary_key = "idcontribution";

	}

	private function _set_filters($query, $camp_name = "", $nickname = "",
		$contrib_from = "", $contrib_to = "", $contrib_date = "") {

		if ($camp_name != "") {
			$query = $query->like('c.camp_name', $camp_name);
		}

		if ($nickname != "") {
			$query = $query->where('co.nickname', $nickname);
		}

		if ($contrib_from != "") {
			$query = $query->where('co.amount >=', $contrib_from);
		}

		if ($contrib_to != "") {
			$query = $query->where('co.amount <=', $contrib_to);
		}

		if ($contrib_date != "") {

			$contrib_date_start = str_replace("/", "-", $contrib_date);

			$contrib_date_start = mdate("%Y-%m-%d", strtotime($contrib_date_start));

			$contrib_date_end = date_create($contrib_date_start);
			$contrib_date_end = date_add($contrib_date_end, date_interval_create_from_date_string("1 days"));
			$contrib_date_end = date_format($contrib_date_end, "Y-m-d");

			$query = $query->where('co.payment_date >=', $contrib_date_start);
			$query = $query->where('co.payment_date <', $contrib_date_end);
		}

		return $query;

	}

	private function _set_filters_sent($userid, $camp_name = "", $camp_owner = "",
		$contrib_from = "", $contrib_to = "", $contrib_date = "") {

		$obj_filter               = new stdClass();
		$obj_filter->where_sql    = "";
		$obj_filter->where_values = array();

		$obj_filter->where_values[] = $userid;

		if ($camp_name != "") {
			$obj_filter->where_sql .= " AND LOWER(c.camp_name) LIKE ? ";
			$obj_filter->where_values[] = "%".strtolower($camp_name)."%";
		}

		if ($camp_owner != "") {
			$obj_filter->where_sql      = " AND (LOWER(p.fullname) LIKE ? OR LOWER(o.username) LIKE ?) ";
			$obj_filter->where_values[] = "%".strtolower($camp_owner)."%";
			$obj_filter->where_values[] = "%".strtolower($camp_owner)."%";
		}

		if ($contrib_from != "") {
			$obj_filter->where_sql .= " AND co.amount >= ? ";
			$obj_filter->where_values[] = $contrib_from;
		}

		if ($contrib_to != "") {
			$obj_filter->where_sql .= " AND co.amount <= ? ";
			$obj_filter->where_values[] = $contrib_to;
		}

		if ($contrib_date != "") {

			$contrib_date_start = str_replace("/", "-", $contrib_date);

			$contrib_date_start = mdate("%Y-%m-%d", strtotime($contrib_date_start));

			$contrib_date_end = date_create($contrib_date_start);
			$contrib_date_end = date_add($contrib_date_end, date_interval_create_from_date_string("1 days"));
			$contrib_date_end = date_format($contrib_date_end, "Y-m-d");

			$obj_filter->where_sql .= " AND co.payment_date >= ? ";
			$obj_filter->where_sql .= " AND co.payment_date < ? ";
			$obj_filter->where_values[] = $contrib_date_start;
			$obj_filter->where_values[] = $contrib_date_end;

		}

		return $obj_filter;

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

	public function summary_received($userid, $camp_name = "", $nickname = "",
		$contrib_from = "", $contrib_to = "", $contrib_date = "") {

		$query = $this->db
		              ->select("count(1) count_contrib,
		              	SUM(co.amount) sum_camp_collected", false)
		->from("contributions as co")
		->join("campaigns as c", "co.idcampaign = c.idcampaign")
		->join("users as u", "u.iduser = c.iduser")
		->where('u.iduser', $userid);

		$query = $this->_set_filters($query, $camp_name, $nickname, $contrib_from, $contrib_to, $contrib_date);

		$query = $query->get();

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

	public function get_received(
		$userid, $camp_name = "", $nickname = "",
		$contrib_from = "", $contrib_to = "", $contrib_date = "") {

		$query = $this->db
		              ->select("c.idcampaign,
								c.camp_name,
								co.idcontribution,
								co.amount,
								co.nickname,
								co.payment_date,
								co.notes", false)
		->from("contributions as co")
		->join("campaigns as c", "co.idcampaign = c.idcampaign")
		->join("users as u", "u.iduser = c.iduser")
		->where('u.iduser', $userid)
		->order_by('co.payment_date', 'desc');

		$query = $this->_set_filters($query, $camp_name, $nickname, $contrib_from, $contrib_to, $contrib_date);

		$query = $query->get();

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

	public function get_sent_by_user($userid,
		$camp_name = "", $camp_owner = "",
		$contrib_from = "", $contrib_to = "",
		$contrib_date = "", $notes = "") {

		/*if ($contrib_from != "" || $contrib_to != "") {
		var_dump_pretty(array(
		"contrib_from" => $contrib_from,
		"contrib_to"   => $contrib_to,
		//"query"        => $query,
		//"sql"          => $str_sql,
		//"where_values" => $filter->where_values,
		)

		);
		}*/

		$filter = $this->_set_filters_sent($userid, $camp_name, $camp_owner,
			$contrib_from, $contrib_to, $contrib_date);

		$str_sql = "SELECT c.idcampaign,
		              			c.camp_name,
		              			p.fullname camp_owner,
		              			o.username camp_owner_nickname,
		              			co.amount,
								co.payment_date,
								co.service_fee,
								co.total_payment
				FROM contributions AS co
				INNER JOIN campaigns as c ON co.idcampaign = c.idcampaign
				INNER JOIN users as o ON o.iduser = c.iduser
				INNER JOIN people as p ON p.idpeople = o.idpeople
				INNER JOIN users as u ON u.iduser = co.iduser
				WHERE u.iduser = ? ".
		$filter->where_sql.
		" ORDER BY co.payment_date desc";

		$query = $this->db->query($str_sql, $filter->where_values);

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
