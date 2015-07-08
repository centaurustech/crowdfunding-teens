<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class users_model extends MY_Model {

	public function users_model() {
		parent::__construct();
		$this->_table = 'users';
		$this->primary_key = 'iduser';
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
		$query = $this->db->get_where(
			$this->_table, array(
				'hash_value' => $hash,
			)
		);

		if ($query && $query->num_rows > 0) {
			return $query->row();
		}
		return false;
	}

	public function searchUserByUserName($username) {
		$row = $this->get_by("username", $username);
		return count($row) > 0 ? $row : false;
	}

	public function count_record() {
		return $this->db->count_all('users');
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

		$userObj = $this->get_by("facebook_id", $social_data["id"]);

		if (!$userObj) {

			$userObj = $this->get_by("idpeople", $idpeople);

			if (!$userObj) {

				$data = array(
					'idpeople' => $idpeople,
					'facebook_id' => $social_data["id"],
				);

				$user_id = $this->insert($data);

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

	public function get_auth() {
		$usr_auth = $this->session->userdata('user');

		if ($usr_auth) {
			return $this->get($usr_auth["iduser"]);
		}

		return false;
	}

	public function signup($postdata, $idpeople) {

		//Check if record exists
		$row = $this->searchUserByUserName($postdata['inputUser']);

		if (!$row) {

			$arr_filter = array(
				'username' => (isset($postdata['inputUser']) ? $postdata['inputUser'] : NULL),
				'userpassword' => (isset($postdata['inputPassword']) ? md5($postdata['inputPassword']) : NULL),
				'changepassword' => 0,
				'idpeople' => $idpeople,
				'facebook_id' => (isset($postdata['facebook_id']) ? $postdata['facebook_id'] : NULL),
				'is_admin' => (isset($postdata['is_admin']) ? $postdata['is_admin'] : 0),
				'creationdate' => date('Y-m-d H:i:s'),
			);

			return $this->insert($arr_filter);

		}

		return false;

	}

	public function update($data) {

		$iduser = $data['iduser'];

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

		return parent::update($iduser, $arr_filter);
	}

	public function searchUserByLoginPass($login, $password) {
		$return = $this->db->get_where(
			$this->_table, array(
				'username' => $login,
				'userpassword' => $password,
			)
		)->row();

		return $return;
	}

	public function searchUserByEmail($email) {
		return $this->db->get_where(
			$this->_table, array(
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

	public function isLogged() {
		if ($this->session->userdata("user")) {
			return true;
		}

		return false;

	}

	public function get_auth_user() {

		$user_session = $this->session->userdata("user");

		if ($user_session) {

			$obj = new stdClass();

			$obj->username = $user_session['username'];
			$obj->iduser = $user_session['iduser'];
			$obj->fullname = $user_session['fullname'];
			$obj->fullname = $user_session['firstname'];
			$obj->user_pic = $user_session['picture'];

			return $obj;
		}

		return false;
	}

	public function create_user_folder() {

		$auth_user = $this->get_auth_user();

		if ($auth_user) {
			$path = FCPATH . 'assets/uploads/' . strtolower($auth_user->username);

			if (!is_dir($path)) {
				mkdir($path, 0777, true);
			}

			return $path;

		}
		return FALSE;
	}

}
