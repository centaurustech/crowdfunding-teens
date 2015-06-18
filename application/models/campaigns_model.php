<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class campaigns_model extends MY_Model {

	public function campaigns_model() {
		parent::__construct();
		$this->primary_key = 'idcampaign';
	}

	public function list_campaigns($highlighted = false, $limit_start = 0, $limit_count = 0) {

		$query = $this->db
		              ->select("
		               		c.idcampaign,
		               		c.camp_name,
		               		c.camp_description,
	        				p.fullname camp_owner,
	        				c.camp_goal,
	        				c.camp_completed,
	        				i.imgurl
							", false)
		->from("campaigns as c")
		->join("users as u", "u.iduser = c.iduser")
		->join("people as p", "u.idpeople = p.idpeople")
		->join("campaigns_images_gallery as i", "i.idcampaign = c.idcampaign", 'left');

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

	public function get_campaign_info($id) {

		$query = $this->db
		              ->select("
		               		c.idcampaign,
		               		c.camp_name,
		               		c.camp_description,
	        				p.fullname camp_owner,
	        				p.picture_url camp_owner_picture,
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
			$row->imgurl             = is_null($row->imgurl)|empty($row->imgurl)?base_url("assets/img/no-campaign-picture.png"):$row->imgurl;// Edit campaign
			$row->camp_owner_picture = is_null($row->camp_owner_picture)|empty($row->camp_owner_picture)?base_url('assets/img/no-profile-picture.jpg'):$row->camp_owner_picture;

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

			$action = "insert";

			$data["camp_completed"] = "0";
			$data["camp_expire"]    = $camp_expire;
			$stm                    = $this->insert($data);
		} else {

			$action = "update";

			$stm = $this->update($idcampaign, $data);

		}

		if ($stm != false) {
			$result = true;

			if ($action == "update") {
				return intval($idcampaign);

			} else {
				return intval($stm);
			}
		}

		return false;
	}

	public function show_msg_not_auth() {

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
