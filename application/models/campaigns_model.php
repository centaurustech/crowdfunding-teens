<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class campaigns_model extends MY_Model {

	public function campaigns_model() {
		parent::__construct();
		$this->primary_key = 'idcampaign';
		$this->load->model('people_model');
	}

	private function _has_contribution($idcampaign) {

		$query = $this->db
		              ->from("contributions")
		              ->where("idcampaign", $idcampaign);

		return ($query->count_all_results() > 0);
	}

	public function list_campaigns($highlighted = false, $limit_start = 0, $limit_count = 0, $camp_owner = "", $iduser = "") {

		$query = $this->db
		              ->select("
		               		c.idcampaign,
		               		c.camp_name,
		               		c.camp_description,
	        				p.fullname camp_owner,
	        				c.camp_goal,
	        				c.camp_completed,
	        				c.camp_collected,
	        				i.imgurl
							", false)
		->from("campaigns as c")
		->join("users as u", "u.iduser = c.iduser")
		->join("people as p", "u.idpeople = p.idpeople")
		->join("campaigns_images_gallery as i", "i.idcampaign = c.idcampaign", 'left');

		if ($camp_owner != "") {
			$query = $query->like('p.fullname', $camp_owner);
		}
		if ($iduser != "") {
			$query = $query->where('u.iduser', $iduser);
		}

		$order_field = "";
		if ($highlighted) {
			$order_field = "c.camp_completed desc";
		} else {
			$order_field = "c.creationdate desc, c.idcampaign desc";
		}

		$query = $query->order_by($order_field);

		if ($limit_count > 0) {
			$query = $query->limit($limit_count, $limit_start);
		}

		$query = $query->get();

		if ($query && $query->num_rows > 0) {

			foreach ($query->result() as $row) {

				//Set Default No Picture when imgurl is empty or null.
				$row->imgurl = is_null($row->imgurl)|empty($row->imgurl)?base_url("assets/img/no-campaign-picture.png"):$row->imgurl;
			}

			return $query->result();
		}

		return false;

	}

	public function sum_amount_by_user($userid) {

		$query = $this->db
		              ->select("
		              	SUM(camp_goal) AS sum_camp_goal,
		              	SUM(camp_collected) AS sum_camp_collected,
		              	", false)
		->from($this->_table)
			->where("iduser", $userid)
			->get();

		if ($query && $query->num_rows > 0) {
			$row = $query->row();
			setlocale(LC_MONETARY, 'it_IT');
			$row->sum_camp_goal      = floatval($row->sum_camp_goal);
			$row->sum_camp_collected = floatval($row->sum_camp_collected);

			return $row;
		}

		return false;

	}

	public function get_campaign_info($id) {

		$query = $this->db
		              ->select("
		               		c.idcampaign,
		               		c.camp_name,
		               		c.camp_description,
	        				p.idpeople,
	        				p.fullname camp_owner,
	        				p.picture_url camp_owner_picture,
	        				p.gender,
	        				c.camp_expire,
							c.camp_goal,
	        				c.camp_completed,
	        				c.camp_collected,
	        				u.iduser,
	        				u.username,
							u.facebook_id,
							i.imgurl
							", false)
		->from("campaigns as c")
		->join("users as u", "u.iduser = c.iduser")
		->join("people as p", "u.idpeople = p.idpeople")
		->join("campaigns_images_gallery as i", "i.idcampaign = c.idcampaign", 'left')
		->where('c.idcampaign', $id)
		->get();

		if ($query && $query->num_rows > 0) {

			$session = $this->users_model->get_auth_user();
			$row     = $query->row();

			// Edit campaign enabled if user logged is the campaign owner.
			if ($session && ($row->iduser == $session->iduser)) {
				$row->is_own_campaign = TRUE;
			} else {
				$row->is_own_campaign = FALSE;
			}

			// Extract first name of campaign's owner.
			if ($session && ($row->iduser == $session->iduser)) {
				$row->camp_owner_first_name = substr($row->camp_owner, 0, strpos($row->camp_owner, " "));
			} else {
				$row->camp_owner_first_name = $row->camp_owner;
			}

			//Set Default No Picture when imgurl is empty or null.
			$row->imgurl = is_null($row->imgurl) || empty($row->imgurl)?base_url("assets/img/no-campaign-picture.png"):$row->imgurl;// Edit campaign

			if (is_null($row->camp_owner_picture) || $row->camp_owner_picture == '') {
				$row->camp_owner_picture = get_no_profile_picture($row->gender);
			} else {
				//$row->camp_owner_picture = $this->people_model->get_profile_picture($row->idpeople);
			}

			$row->is_new_campaign = FALSE;// Edit campaign

			return $row;
		}

		return false;
	}

	public function init($user = null) {

		$row = new stdClass();

		$row->idcampaign         = "";
		$row->camp_name          = "";
		$row->camp_description   = "";
		$row->camp_owner         = $user->fullname;
		$row->camp_owner_picture = is_null($user->user_pic)?base_url('assets/img/no-profile-picture.jpg'):$user->user_pic;
		$row->camp_expire        = 0;
		$row->camp_goal          = 0;
		$row->camp_completed     = 0;
		$row->camp_collected     = 0;
		$row->iduser             = $user->iduser;
		$row->username           = $user->username;
		$row->facebook_id        = 0;
		$row->imgurl             = base_url('assets/img/no-campaign-picture.png');
		$row->is_own_campaign    = TRUE;
		$row->is_new_campaign    = TRUE;

		return $row;
	}

	public function save($idcampaign, $data) {

		if ($idcampaign == "") {

			// TODO: Create a user parameter.
			$creationdate = date_create($data["creationdate"]);
			date_add($creationdate, date_interval_create_from_date_string("90 days"));
			$camp_expire = date_format($creationdate, "Y-m-d H:i:s");

			$action = "added";

			$data["camp_completed"] = "0";
			$data["camp_expire"]    = $camp_expire;
			$stm                    = $this->insert($data);
		} else {

			$action = "updated";

			$stm = $this->update($idcampaign, $data);

		}

		if ($stm != false) {
			$result = true;
			$obj    = new stdClass();

			$obj->action = $action;

			if ($action == "updated") {
				$obj->id = intval($idcampaign);

			} else {
				$obj->id = intval($stm);
			}

			return $obj;
		}

		return false;
	}

	public function delete($id) {

		//Check if campaign has contribution before deleting it.

		$has_contrib = $this->_has_contribution($id);
		$obj         = new stdClass();

		if (!$has_contrib) {

			$obj->result = parent::delete($id);

			$obj->msg = $obj->result?
			"Campanha de presente apagada com sucesso.":
			"Erro ao apagar esta campanha";

		} else {
			$obj->result = false;
			$obj->msg    = "A campaha não pode ser apagada porque possui contibuições associadas.";
		}

		return $obj;

	}

	public function how_msg_not_auth() {

		return json_encode(
			array(
				'result'     => false,
				'idcampaign' => null,
				'msg'        => 'Usuário não autenticado',
			)
		);

	}

	public function contribute($idcampaign, $contrib_value) {

		$result = $this->db
		               ->select("
		               		c.camp_goal,
	        				c.camp_collected
							", false)
		->from("campaigns as c")
		->where('c.idcampaign', $idcampaign)
		->get();

		if ($result && $result->num_rows > 0) {
			$row = $result->row();

			$new_contrib        = $row->camp_collected+$contrib_value;
			$new_camp_completed = round($new_contrib/$row->camp_goal*100, 2);

			$data = array(
				"camp_collected" => $new_contrib,
				"camp_completed" => $new_camp_completed,
			);

			$id_camp_result = $this->save($idcampaign, $data);

			return ($id_camp_result == $idcampaign);

		}

		return false;

	}

}
