<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class modules_model extends CI_Model{
		
	private $_row;
	
	public function modules_model(){
		parent::__construct();
        $this->table = 'permissions';
		
		//$this->load->database();
	}

    
	public function getAll(){		
		$this->db->select('*');
	    $this->db->order_by("idmodule","asc");
	    $this->db->from('modules');
	    
	    $query=$this->db->get();
	    return $query->result();
	}
	
	public function init(){
			
		$row = array(
			'username' => '',
			'fullname' => '',
			'email'	 => '',
			'action_title' => 'Novo'
			);
		
		return $row;
	}
	
	public function getpermissions($id){

	}

    public function getPermissionsByUser($iduser){
        $return =  $this->db->get_where(
            $this->table, array(
                'iduser' => $iduser
            )
        )->result();

        return $return;
    }
	
	public function addnew($data){
		$arr_filter = array(
							'username' 			=> $data['userName'],
							'userlastname'  	=> $data['userLastname'],
							'useremail' 	    => $data['userEmail'],
							'userphone' 	    => $data['userPhone']
							);
			
		$query = $this->db->insert('permissions', $arr_filter);

		return $query;
	}

    public function save($data) {
        if (isset($data['idpermission']) && $data['idpermission'] != '') {

            if ($data['user_role'] == '') {
                return $this->db->delete('permissions', array('idpermission' => $data['idpermission']));
            } else {
                $this->db->where('idpermission', $data['idpermission']);
                return $this->db->update('permissions', $data);
            }

        } else {
            return $this->db->insert('permissions', $data);
        }
    }
}  
