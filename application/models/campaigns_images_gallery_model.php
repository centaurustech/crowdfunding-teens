<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class campaigns_images_gallery_model extends MY_Model {

	public function campaigns_images_gallery_model() {
		parent::__construct();
		$this->table = 'campaigns_images_gallery';
		$this->id    = 'idcampaign';
	}

	public function update_field($id, $field_name, $value) {

		$new_data = array(
			$field_name => $value,
		);

		$result = $this->db->where($this->id, $id);

		if ($result) {
			return $this->db->update($this->table, $new_data);
		}

		return false;
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

		$query          = $this->db->insert('campaigns_images_gallery', $arr_filter);
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

	public function searchcampaigns_images_galleryByEmail($email) {
		return $this->db->get_where(
			$this->table, array(
				'email' => $email,
			)
		)->row();
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
