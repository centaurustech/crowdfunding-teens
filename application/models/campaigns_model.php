<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class campaigns_model extends MY_Model {

	public function campaigns_model() {
		parent::__construct();
		$this->primary_key = 'idcampaign';
	}

	public function get_campaign_info($id) {

		$result = $this->db
		               ->select("
		               		c.idcampaign,
		               		c.camp_name,
		               		c.camp_description,
	        				p.fullname camp_owner,
	        				p.picture_url camp_owner_picture,
	        				c.camp_expire,
							c.camp_goal,
	        				c.camp_completed,
	        				c.camp_goal * c.camp_completed / 100 as camp_collected,
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

		$session = $this->users_model->get_auth_user();
		$row     = $result->row();

		if ($result && $result->num_rows > 0) {

			// Edit campaign enabled if user logged is the campaign owner.
			if ($session && ($row->iduser == $session->iduser)) {
				$row->is_own_campaign = TRUE;
			} else {
				$row->is_own_campaign = FALSE;
			}

			//Set Default No Picture when imgurl is empty or null.
			$row->imgurl = is_null($row->imgurl)?base_url("assets/img/no-campaign-picture.png"):$row->imgurl;// Edit campaign

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

}
