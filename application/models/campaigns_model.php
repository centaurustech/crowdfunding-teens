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
		->join("campaings_images_gallery as i", "i.idcampaign = c.idcampaign", 'left')
		->where('c.idcampaign', $id)
		->get();

		$session = $this->session->userdata('user');
		$row     = $result->row();

		if ($result) {

			// Edit campaign enabled if user logged is the campaign owner.
			if ($session) {
				$row->is_own_campaign = $row->iduser == $session["iduser"];
			} else {
				$row->is_own_campaign = false;
			}

			return $row;
		}

		return false;
	}

	public function upload_picture() {

	}

	public function getAll() {
		$query = $this->db->get($this->_table);
		return $query->result();
	}

	public function getAllPag($byPage, $uriSegment) {
		if ($byPage > 0) {
			$limit = " LIMIT ";
			$limit .= ($uriSegment != '')?($uriSegment.', '):('');
			$limit .= $byPage;
		} else {
			$limit = '';
		}

		$sql_total = "SELECT * ";
		$sql_total .= "FROM ".$this->_table;
		$sql_pagination = $sql_total.$limit;

		$data['users'] = $this->db->query($sql_pagination)->result();
		$data['total'] = $this->db->query($sql_total)->num_rows();

		return $data;
	}

	public function count_record() {
		return $this->db->count_all('users');
	}

	public function get($id) {
		return $this->db->get_where(
			$this->_table, array(
				'idcampaign' => $id,
			)
		)->row();
	}

	public function init() {

		$row = array(
			'username'     => '',
			'firstname'    => '',
			'lastname'     => '',
			'email'        => '',
			'action_title' => 'Novo',
		);

		return $row;
	}

	public function addnew($data) {
		$arr_filter = array(
			'fullname'     => (isset($data['fullname'])?$data['fullname']:''),
			'picture_url'  => (isset($data['picture_url'])?$data['picture_url']:''),
			'doctype_id'   => (isset($data['doctype_id'])?$data['doctype_id']:NULL),
			'docnum'       => (isset($data['docnum'])?$data['docnum']:''),
			'address'      => (isset($data['address'])?$data['address']:''),
			'phone'        => (isset($data['phone'])?$data['phone']:''),
			'zipcode'      => (isset($data['zipcode'])?$data['zipcode']:''),
			'email'        => (isset($data['email'])?$data['email']:''),
			'creationdate' => date('Y-m-d H:i:s'),
		);

		$query          = $this->db->insert('campaigns', $arr_filter);
		$last_insert_id = $this->db->insert_id();

		return $last_insert_id;
	}

	public function searchcampaignsByEmail($email) {
		return $this->db->get_where(
			$this->_table, array(
				'email' => $email,
			)
		)->row();
	}

	public function searchByName($nameUser) {
		$sql = "SELECT * ";
		$sql .= "FROM ".$this->_table." ";
		$sql .= "WHERE fullname LIKE '%".$nameUser."%' ";
		$sql .= "OR email LIKE '%".$nameUser."%' ";

		return $this->db->query($sql)->result();
	}

	public function searchByNamePag($nameUser, $byPage, $uriSegment) {
		if ($byPage > -1) {
			$limit = " LIMIT ";
			$limit .= ($uriSegment != '')?($uriSegment.', '):('');
			$limit .= $byPage;
		} else {
			$limit = '';
		}

		$sql_total = "SELECT * ";
		$sql_total .= "FROM ".$this->_table." ";
		$sql_total .= "WHERE fullname LIKE '%".$nameUser."%' ";
		$sql_total .= "OR email LIKE '%".$nameUser."%' ";
		$sql_pagination = $sql_total.$limit;

		$data['users'] = $this->db->query($sql_pagination)->result();
		$data['total'] = $this->db->query($sql_total)->num_rows();

		return $data;
	}

	public function delete($id) {
		$this->db->delete('users', array('idusers' => $id));
	}
}