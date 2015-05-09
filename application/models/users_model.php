<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class users_model extends CI_Model {

	public function users_model() {
		parent::__construct();
		$this->table = 'users';
		$this->id = 'iduser';
	}

	public function getAll() {
		$query = $this->db->get('users');
		return $query->result();
	}

	public function getAllPag($byPage, $uriSegment) {
		if ($byPage > 0) {
			$limit = " LIMIT ";
			$limit .= ($uriSegment != '') ? ($uriSegment . ', ') : ('');
			$limit .= $byPage;
		} else {
			$limit = '';
		}

		$sql_total = "SELECT * ";
		$sql_total .= "FROM users";
		$sql_pagination = $sql_total . $limit;

		$data['users'] = $this->db->query($sql_pagination)->result();
		$data['total'] = $this->db->query($sql_total)->num_rows();

		return $data;
	}

	public function searchUserByHash($hash) {
		return $this->db->get_where(
			$this->table, array(
				'hash_value' => $hash,
			)
		)->row();
	}

	public function searchUserByPeopleId($idpeople) {
		return $this->db->get_where(
			$this->table, array(
				'idpeople' => $idpeople,
			)
		)->row();
	}

	public function searchUserByUserName($username) {
		return $this->db->get_where(
			$this->table, array(
				'username' => $username,
			)
		)->row();
	}

	public function searchUserByFacebookId($idfacebook) {
		return $this->db->get_where(
			$this->table, array(
				'facebook_id' => $idfacebook,
			)
		)->row();
	}

	public function count_record() {
		return $this->db->count_all('users');
	}

	public function get($id) {
		return $this->db->get_where(
			$this->table, array(
				'iduser' => $id,
			)
		)->row();
	}

	public function init() {

		$row = array(
			'username' => '',
			'firstname' => '',
			'lastname' => '',
			'email' => '',
			'action_title' => 'Novo',
		);

		return $row;
	}

	public function sync_from_facebook($idpeople, $social_data) {

		$userObj = $this->searchUserByFacebookId($social_data["id"]);

		if (!$userObj) {
			$userObj = $this->searchUserByPeopleId($idpeople);

			if (!$userObj) {

				$data = array(
					'idpeople' => $idpeople,
					'facebook_id' => $social_data["id"],
				);

				$user_id = $this->addnew($data);

				return $this->get($user_id);

			} else {

				$data = array(
					'iduser' => $userObj->iduser,
					'facebook_id' => $social_data["id"],
				);

				$user_id = $this->update($data);

				return $this->get($user_id);

			}

		}

		return $userObj;
	}

	public function signup($postdata, $idpeople) {

		//Check if record exists
		$row = $this->searchUserByUserName($postdata['inputUser']);
		if (!$row) {

			$arr_filter = array(
				'username' => (isset($postdata['inputUser']) ? $postdata['inputUser'] : NULL),
				'userpassword' => (isset($postdata['inputPassword']) ? $postdata['inputPassword'] : NULL),
				'changepassword' => 0,
				'idpeople' => $idpeople,
			);

			return $this->addnew($arr_filter);

		}

		return false;

	}

	public function addnew($data) {
		$arr_filter = array(
			'username' => (isset($data['username']) ? $data['username'] : NULL),
			'userpassword' => (isset($data['userpassword']) ? md5($data['userpassword']) : NULL),
			'changepassword' => (isset($data['changepassword']) ? $data['changepassword'] : 0),
			'idpeople' => (isset($data['idpeople']) ? $data['idpeople'] : NULL),
			'facebook_id' => (isset($data['facebook_id']) ? $data['facebook_id'] : NULL),
			'is_admin' => (isset($data['is_admin']) ? $data['is_admin'] : 0),
			'creationdate' => date('Y-m-d H:i:s'),
		);

		$query = $this->db->insert('users', $arr_filter);
		$last_insert_id = $this->db->insert_id();

		return $last_insert_id;
	}

	public function update($data) {

		if (isset($data['username']) && $data['username'] != '') {
			$arr_filter['username'] = $data['username'];
		}

		if (isset($data['userpassword']) && $data['userpassword'] != '') {
			$arr_filter['userpassword'] = $data['userpassword'];
		}

		if (isset($data['changepassword']) && $data['changepassword'] != '') {
			$arr_filter['changepassword'] = $data['changepassword'];
		} else {
			$arr_filter['changepassword'] = 0;
		}

		if (isset($data['hash_value']) && $data['hash_value'] != '') {
			$arr_filter['hash_value'] = $data['hash_value'];
		} else {
			$arr_filter['hash_value'] = null;
		}

		if (isset($data['hash_date']) && $data['hash_date'] != '') {
			$arr_filter['hash_date'] = $data['hash_date'];
		} else {
			$arr_filter['hash_date'] = null;
		}

		if (isset($data['idpeople']) && $data['idpeople'] != '') {
			$arr_filter['idpeople'] = $data['idpeople'];
		}

		if (isset($data['facebook_id']) && $data['facebook_id'] != '') {
			$arr_filter['facebook_id'] = $data['facebook_id'];
		}

		$arr_filter['editiondate'] = date('Y-m-d H:i:s');

		$this->db->where('iduser', $data['iduser']);
		return $this->db->update('users', $arr_filter);
	}

	public function searchUserByLoginPass($login, $password) {
		$return = $this->db->get_where(
			$this->table, array(
				'username' => $login,
				'userpassword' => $password,
			)
		)->row();

		return $return;
	}

	public function searchUserByEmail($email) {
		return $this->db->get_where(
			$this->table, array(
				'email' => $email,
			)
		)->row();
	}

	public function searchByName($nameUser) {
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "WHERE fullname LIKE '%" . $nameUser . "%' ";
		$sql .= "OR lastname LIKE '%" . $nameUser . "%' ";
		$sql .= "OR username LIKE '%" . $nameUser . "%' ";
		$sql .= "OR email LIKE '%" . $nameUser . "%' ";

		return $this->db->query($sql)->result();
	}

	public function searchByNamePag($nameUser, $byPage, $uriSegment) {
		if ($byPage > -1) {
			$limit = " LIMIT ";
			$limit .= ($uriSegment != '') ? ($uriSegment . ', ') : ('');
			$limit .= $byPage;
		} else {
			$limit = '';
		}

		$sql_total = "SELECT * ";
		$sql_total .= "FROM users ";
		$sql_total .= "WHERE firstname LIKE '%" . $nameUser . "%' ";
		$sql_total .= "OR lastname LIKE '%" . $nameUser . "%' ";
		$sql_total .= "OR username LIKE '%" . $nameUser . "%' ";
		$sql_total .= "OR email LIKE '%" . $nameUser . "%' ";
		$sql_pagination = $sql_total . $limit;

		$data['users'] = $this->db->query($sql_pagination)->result();
		$data['total'] = $this->db->query($sql_total)->num_rows();

		return $data;
	}

	public function delete($id) {
		$this->db->delete('users', array('iduser' => $id));
	}

	function isLogged() {
		if ($this->session->userdata("user")) {
			return true;
		} else {
			return false;
		}
	}
}
