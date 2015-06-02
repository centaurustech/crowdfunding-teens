<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class people_model extends MY_Model {

	public function people_model() {
		parent::__construct();
		$this->table = 'people';
		$this->id    = 'idpeople';
	}

	public function getAll() {
		$query = $this->db->get($this->table);
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
		$sql_total .= "FROM ".$this->table;
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
			$this->table, array(
				'idpeople' => $id,
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

	private function _add_from_facebook($social_data) {

		$data = array(
			'fullname'    => $social_data["name"],
			'picture_url' => 'https://graph.facebook.com/'.$social_data["id"].'/picture/',
			'doctype_id'  => NULL,
			'docnum'      => NULL,
			'address'     => NULL,
			'phone'       => NULL,
			'zipcode'     => NULL,
			'email'       => $social_data["email"],
		);

		return $this->addnew($data);
	}

	public function sync_from_facebook($social_data) {

		$row = $this->searchPeopleByEmail($social_data["email"]);
		if (!$row) {
			$new_id = $this->_add_from_facebook($social_data);
			return $this->get($new_id);
		}
		return $row;
	}

	public function signup($postdata) {

		//Check if email exists
		$row = $this->searchPeopleByEmail($postdata['inputEmail']);

		if (!$row) {

			$arr_filter = array(
				'fullname'    => (isset($postdata['inputFullName'])?$postdata['inputFullName']:''),
				'picture_url' => NULL,
				'doctype_id'  => (isset($postdata['inputDocType'])?$postdata['inputDocType']:NULL),
				'docnum'      => (isset($postdata['inputNumDoc'])?$postdata['inputNumDoc']:''),
				'address'     => (isset($postdata['inputAddress'])?$postdata['inputAddress']:''),
				'phone'       => (isset($postdata['inputPhone'])?$postdata['inputPhone']:''),
				'zipcode'     => (isset($postdata['inputZipCode'])?$postdata['inputZipCode']:''),
				'email'       => (isset($postdata['inputEmail'])?$postdata['inputEmail']:''),
			);

			return $this->addnew($arr_filter);

		}

		return false;

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

		$query          = $this->db->insert('people', $arr_filter);
		$last_insert_id = $this->db->insert_id();

		return $last_insert_id;
	}

	public function update($data) {

		if (isset($data['username']) && $data['username'] != '') {
			$arr_filter['username'] = $data['username'];
		}

		if (isset($data['firstname']) && $data['firstname'] != '') {
			$arr_filter['firstname'] = $data['firstname'];
		}

		if (isset($data['lastname']) && $data['lastname'] != '') {
			$arr_filter['lastname'] = $data['lastname'];
		}

		if (isset($data['email']) && $data['email'] != '') {
			$arr_filter['email'] = $data['email'];
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

		$this->db->where('idusers', $data['idusers']);
		return $this->db->update('users', $arr_filter);
	}

	public function searchPeopleByEmail($email) {
		$query = $this->db->get_where(
			$this->table, array(
				'email' => $email,
			)
		);

		if ($query && $query->num_rows > 0) {
			return $query->row();
		}
		return false;
	}

	public function searchByName($nameUser) {
		$sql = "SELECT * ";
		$sql .= "FROM ".$this->table." ";
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
		$sql_total .= "FROM ".$this->table." ";
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
