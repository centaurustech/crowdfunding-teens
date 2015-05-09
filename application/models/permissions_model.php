<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class permissions_model extends CI_Model{
		
	private $_row;
	
	public function permissions_model(){
		parent::__construct();
        $this->table = 'permissions';
		
		//$this->load->database();
	}

    //eliminar
	public function get_by_user($id){
		
		//Meantime test data will be returned until we create the DB Model.	
		$row = array(
			'username' => 'joaosilva',
			'fullname' => 'João Silva',
			'email'	 => 'jsilva@contoso.net',
			'action_title' => 'Alterar'
			);
		
		return $row;
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
	
	public function checkModuleByUser($iduser, $url){
			
		$str_sql = "SELECT p.* ";
		$str_sql .= "FROM permissions p ";
		$str_sql .= "INNER JOIN modules m ON p.idmodule = m.idmodule ";
		$str_sql .= "WHERE p.iduser = ".$iduser;
		$str_sql .= " AND m.url LIKE '%".$url."'";
		$str_sql .= " AND p.user_role > 0";
		
		$query = $this->db->query($str_sql);
		
        return $query->result();
        
	}

    public function getPermissionsByUser($iduser, $withaccessonly = false){
        /*
        $query =  $this->db->get_where(
            $this->table, array(
                'iduser' => $iduser
            )
        )->result();
		*/
		
		$str_sql = "SELECT m.modulename parentname, mc.*, p.idpermission, p.iduser, p.user_role ";
		$str_sql .= "FROM modules mc ";
		$str_sql .= "INNER JOIN modules m ON m.idmodule = mc.id_parent ";
		$str_sql .= "INNER JOIN permissions p ON p.idmodule = mc.idmodule ";
		$str_sql .= "WHERE p.iduser = ".$iduser;
		if($withaccessonly)
			$str_sql .= " AND p.user_role > 0";
		
		$query = $this->db->query($str_sql);
		
        return $query->result();
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
            if(isset($data['idpermission']))
				unset($data['idpermission']);
            
            return $this->db->insert('permissions', $data);
        }
    }
	
	public function deleteByUser($idUser){
			
		return $this->db->delete('permissions', array('iduser' => $idUser));
		
		
	}
}  
