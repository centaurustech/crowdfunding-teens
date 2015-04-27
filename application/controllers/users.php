<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/users
	 *	- or -  
	 * 		http://example.com/index.php/users/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/users/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct() {
		parent::__construct();
		$this->load->model('users_model');
        $this->load->model('modules_model');
        $this->load->model('permissions_model');
        $this->load->model('stations_users_model');
        $this->load->model('markets_users_model');
	}
	
	public function index()
	{
        redirect(goto_url('dashboard/view/users/'));
	}

    /*public function searchAllUsers() {
        $usersObj = $this->users_model->getAll();
        load_view($this, 'view_dashboard_users',$usersObj);	// Call helper function
    }*/

    public function searchAllUsers($page='') {
        $base_url_admin = base_url();
        $confPagination = $this->_configPagination();

        $data = $this->users_model->getAllPag($confPagination['per_page'], $page);

        $confPagination['base_url'] = $base_url_admin.'/users/searchAllUsersPag';
        $confPagination['total_rows'] = $data['total'];

        $this->pagination->initialize($confPagination);

        $dataUser['users'] = $data['users'];
        $dataUser['pagination'] = $this->pagination->create_links();

        load_view($this, 'view_dashboard_users',$dataUser);
    }

    public function searchAllUsersPag($page='') {
        $base_url_admin = base_url();
        $confPagination = $this->_configPagination();

        $data = $this->users_model->getAllPag($confPagination['per_page'], $page);

        $confPagination['base_url'] = $base_url_admin.'/users/searchAllUsersPag';
        $confPagination['total_rows'] = $data['total'];

        $this->pagination->initialize($confPagination);

        $dataUser['users'] = $data['users'];
        $dataUser['pagination'] = $this->pagination->create_links();

        $this->load->view('list_dashboard_users', $dataUser);
    }

    public function getAllUsers($page='') {
        $data = $this->users_model->getAllPag(-1, $page);
        $dataUser['users'] = $data['users'];

        $usersSelected = $this->input->post("userselected");
        $userArray = explode(',',$usersSelected);
        $dataUser['userselected'] = $userArray;

        $this->load->view('view_list_user_pagination', $dataUser);
    }

    public function searchPag($page='') {
        $base_url_admin = base_url();
        $confPagination = $this->_configPagination();
        $confPagination['per_page'] = 4;
        $confPagination['full_tag_open'] = '<div id="modal_pag"><ul class="pagination">';

        $key = $this->input->post('search_userModal');
        $data = $this->users_model->searchByNamePag($key,$confPagination['per_page'], $page);

        $confPagination['base_url'] = $base_url_admin.'/users/searchPag';
        $confPagination['total_rows'] = $data['total'];

        $this->pagination->initialize($confPagination);

        $dataUser['users'] = $data['users'];
        $dataUser['pagination'] = $this->pagination->create_links();

        $this->load->view('view_list_user_pagination', $dataUser);	// Call helper function
    }

    public function searchModal($page='') {
        $key = $this->input->post('search_userModal');
        $data = $this->users_model->searchByNamePag($key,-1, $page);

        $dataUser['users'] = $data['users'];

        $this->load->view('view_list_user_pagination', $dataUser);	// Call helper function
    }

    public function search() {
        $key = $this->input->post('search_user');
        //$usersObj = $this->users_model->searchByName($key);
        $data = $this->users_model->searchByNamePag($key,-1, '');

        //$dataUser['users'] = $usersObj;
        $dataUser['pagination'] = '';
        $dataUser['users'] = $data['users'];

        //load_view($this, 'view_dashboard_users',$dataUser);
        $this->load->view('list_dashboard_users', $dataUser);
    }
	
	public function create(){
		$rs = $this->users_model->init();
		
		load_view($this, 'view_crud_users',$rs);	// Call helper function
	}
	
	public function edit($id){
			
		//Call user model.
		$user = $this->users_model->get($id);

        $rs['action_title'] = "Alterar";
        $rs['username'] = $user->username;
        $rs['firstname'] = $user->firstname;
        $rs['lastname'] = $user->lastname;
        $rs['email'] = $user->email;
        $rs['idusers'] = $user->idusers;
        $rs['changepassword'] = $user->changepassword;
		
		load_view($this, 'view_crud_users', $rs);	// Call helper function
	}
	
	public function save(){
		$username = $this->input->post("userLogin");
        $firstname = $this->input->post("userFirtsName");
        $lastname = $this->input->post("userLastName");
        $email = $this->input->post("userEMail");
        $password = $this->input->post("userPassword");
        $changepassword = (isset($_POST['userMustChangePassword']))? 1 : 0;
        $iduser = $this->input->post("iduser");

        if ($iduser == 0) {
            $this->form_validation->set_rules('userLogin','Usu&#225;rio','trim|xss_clean|is_unique[users.username]');
            $this->form_validation->set_rules('userEMail','E-Mail','trim|xss_clean|is_unique[users.email]');

            $validation = $this->form_validation->run();
        } else {
            $validation = true;
        }

        $data = array(
            'username'      => $username,
            'firstname'     => $firstname,
            'lastname'      => $lastname,
            'email'         => $email
        );

        if ($validation) {
            $data['userpassword'] = trim($password) != ''  ? md5($password) : '';
            $data['changepassword'] = $changepassword;

            if ($iduser == 0) {
                $result = $this->users_model->addnew($data);
				if ($result) {                    
                    $message = "1O usu&#225;rio adicionado com &#234;xito";
					$message .= $this->_setDefaultPermissions($result);
                } else {
                    $message = "0Falha ao adicionar o usu&#225;rio. Tente novamente.";
                }
            } else {
                $data['idusers'] = $iduser;

                $result = $this->users_model->update($data);

                if ($result) {
                    $message = "1O usu&#225;rio foi alterado com sucesso";
                } else {
                    $message = "0N&#227;o foi possível alterar o usu&#225;rio. Tente novamente.";
                }
            }

            echo json_encode($message);
        } else {
            $message = validation_errors();
            $errors = $this->_processMessage($message);
            echo json_encode('0'.$errors);
        }
	}		

    public function delete($id) {
        $revoke_module = $this->permissions_model->deleteByUser($id);
        $revoke_markets = $this->markets_users_model->revokeAllRecordsByUser($id);
        $revoke_station = $this->stations_users_model->revokeAllRecordsByUser($id);  
		
		
        if($revoke_module && $revoke_markets && $revoke_station){
        	$result = $this->users_model->delete($id);
        	$message = 'O registro foi exclu&#237;do com sucesso '.$result;
		}
		else{
			$message = 'Não foi possível excluir as permissões de usuário';
		}

        echo json_encode($message);
    }

	public function permissions($id){
		$rs['user'] = $this->users_model->get($id);
        $permission = $this->permissions_model->getPermissionsByUser($id);
        //buscar los modulos de la tabla modules
        
        //var_dump($permission);
		//exit;

        //esto hay que cambiarlo...
        foreach($permission as $key) {
				
			$module_name = str_replace('dashboard/view/', '', $key->url);
			$module_name = str_replace('/', '', $module_name);
            
			$rs['module_'.$module_name] = $key->idmodule;
				
            if ($key->idmodule == 101) {
                $rs['permission_user_val'] = $key->user_role;
                $rs['idpermissionuser'] = $key->idpermission;				
            }
            if ($key->idmodule == 102) {
                $rs['permission_radio_val'] = $key->user_role;
                $rs['idpermissionradio'] = $key->idpermission;
            }
            if ($key->idmodule == 103) {
                $rs['permission_market_val'] = $key->user_role;
                $rs['idpermissionmarket'] = $key->idpermission;
            }
            if ($key->idmodule == 104) {
                $rs['permission_album_val'] = $key->user_role;
                $rs['idpermissionalbum'] = $key->idpermission;
            }
            if ($key->idmodule == 201) {
                $rs['permission_albumimg_val'] = $key->user_role;
                $rs['idpermissionalbumimg'] = $key->idpermission;
            }
            if ($key->idmodule == 301) {
                $rs['permission_integration_val'] = $key->user_role;
                $rs['idpermissionintegration'] = $key->idpermission;
            }

        }

        $stations = $this->stations_users_model->searchStationsByUser($id);
        $stationsList = implode(",", $stations);

        $markets = $this->markets_users_model->searchMarketsByUser($id);
        $marketsList = implode(",", $markets);

        $rs['stationsbyuser'] = $stationsList;
        $rs['marketsbyuser'] = $marketsList;
		
		load_view($this, 'view_crud_users_access', $rs);	// Call helper function
	}

    private function _revokePermissions($iduser) {
    	$this->permissions_model->deleteByUser($iduser);
    }
	
    private function _setDefaultPermissions($iduser) {
    		
		//Get Array modules
		$modules = $this->modules_model->getAll();
		
		if(!$modules)
			return false;
		
		$result = array();
		
		foreach ($modules as $module) {
			$data_user = array(
	            'iduser'        => $iduser,
	            'idmodule'      => $module->idmodule,
	            'user_role'     => 0,
	            'idpermission'  => ''
	        );
	
	        $this->permissions_model->save($data_user);		
		}
    	
		return;
    }
	
    public function savePermissions() {
        	
		$modules = $this->modules_model->getAll();
		
		$idusers = $this->input->post("idusers");

        $idModuleUser = $this->input->post("module_user");
        $idModuleRadio = $this->input->post("module_radio");
        $idModuleMarket = $this->input->post("module_market");
        $idModuleAlbum = $this->input->post("module_album");
        $idModuleAlbumimg = $this->input->post("module_albumimg");
        $idModuleIntegration = $this->input->post("module_integration");

        $permissions_user = $this->input->post("permissions_user");
        $permissions_radio = $this->input->post("permissions_radio");
        $permissions_market = $this->input->post("permissions_market");
        $permissions_album = $this->input->post("permissions_album");
        $permissions_albumimg = $this->input->post("permissions_albumimg");
        $permissions_integration = $this->input->post("permissions_integration");

        $stationsbyuser = '';
        $marketsbyuser = '';

        if (isset($_POST["stationsbyuser"]) && $_POST["stationsbyuser"] != '') {
            $stationsbyuser = $_POST["stationsbyuser"];

            $station_arr = explode(",", $stationsbyuser);
            $dataAssocStation['stations'] = $station_arr;
        }

        if (isset($_POST["marketsbyuser"]) && $_POST["marketsbyuser"] != '') {
            $marketsbyuser = $_POST["marketsbyuser"];

            $market_arr = explode(",", $marketsbyuser);
            $dataAssocMarket['markets'] = $market_arr;
        }

        $data_user = array(
            'iduser'        => $idusers,
            'idmodule'      => $idModuleUser,
            'user_role'     => $permissions_user,
            'idpermission'  => $this->input->post('idpermissionsuser')
        );

        $result = $this->permissions_model->save($data_user);

        /*
        echo json_encode(
        	array
        	( 
        		'data_user' => $data_user,
        		'result' => $result
			)
		);
		
		return;
        */
        
        $data_radio = array(
            'iduser'        => $idusers,
            'idmodule'      => $idModuleRadio,
            'user_role'     => $permissions_radio,
            'idpermission'  => $this->input->post('idpermissionsradio')
        );

        $result = $this->permissions_model->save($data_radio);

        $data_market = array(
            'iduser'        => $idusers,
            'idmodule'      => $idModuleMarket,
            'user_role'     => $permissions_market,
            'idpermission'  => $this->input->post('idpermissionsmarket')
        );

        $result = $this->permissions_model->save($data_market);

        $data_album = array(
            'iduser'        => $idusers,
            'idmodule'      => $idModuleAlbum,
            'user_role'     => $permissions_album,
            'idpermission'  => $this->input->post('idpermissionsalbum')
        );

        $result = $this->permissions_model->save($data_album);

        $data_albumimg = array(
            'iduser'        => $idusers,
            'idmodule'      => $idModuleAlbumimg,
            'user_role'     => $permissions_albumimg,
            'idpermission'  => $this->input->post('idpermissionsalbumimg')
        );
		
		$result = $this->permissions_model->save($data_albumimg);

        $data_integration = array(
            'iduser'        => $idusers,
            'idmodule'      => $idModuleIntegration,
            'user_role'     => $permissions_integration,
            'idpermission'  => $this->input->post('idpermissionsintegration')
        );

        $permissions_modules = $this->permissions_model->save($data_integration);

        if ($permissions_modules) {
            $dataAssocStation['iduser'] = $idusers;
            $permissions_stations = $this->stations_users_model->saveStationsByUser($dataAssocStation);

            $dataAssocMarket['iduser'] = $idusers;
            $permissions_markets = $this->markets_users_model->saveMarketsByUser($dataAssocMarket);

            if ($permissions_markets && $permissions_stations) {
                $message = "1Autoriza&#231;&#245;es foram armazenadas com sucesso";
            } else {
                if (!$permissions_markets && $permissions_stations) {
                    $message = "0Falha ao adicionar o mercado. Tente novamente.";
                } else if (!$permissions_stations && $permissions_markets) {
                    $message = "0Falha ao adicionar o emissora. Tente novamente.";
                } else {
                    $message = "0Falha ao adicionar o emissora e mercado. Tente novamente.";
                }
            }
        } else {
            $message = "0Falha ao adicionar autoriza&#231;&#245;es. Tente novamente.";
        }

        echo json_encode($message);
    }

    private function _processMessage($message) {
        $patron_user = 'Usu&#225;rio';
        $patron_email = 'E-Mail';

        $error_user = strstr($message, $patron_user, true);
        $error_email = strstr($message, $patron_email, true);

        $errors = '';

        if ($error_user && $error_email) {
            $errors = 'O Usu&#225;rio e E-mail j&#225; est&#225; registrado.';
        } else if ($error_user && $error_email == '') {
            $errors = 'O Usu&#225;rio j&#225; est&#225; registrado.';
        } else if ($error_user == '' && $error_email) {
            $errors = 'O E-mail est&#225; registrado.';
        }

        return $errors;
    }

    function _configPagination() {
        $configPag['num_links'] = 2;
        $configPag['per_page'] = 3;
        $configPag['first_link'] = '<<';
        $configPag['last_link'] = '>>';
        $configPag['next_link'] = '>';
        $configPag['prev_link'] = '<';
        $configPag['display_pages'] = true;
        $configPag['full_tag_open'] = '<div><ul class="pagination">';
        $configPag['full_tag_close'] = '</ul></div>';
        $configPag['num_tag_open'] = '<li>';
        $configPag['num_tag_close'] = '</li>';
        $configPag['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $configPag['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $configPag['next_tag_open'] = "<li>";
        $configPag['next_tagl_close'] = "</li>";
        $configPag['prev_tag_open'] = "<li>";
        $configPag['prev_tagl_close'] = "</li>";
        $configPag['first_tag_open'] = "<li>";
        $configPag['first_tagl_close'] = "</li>";
        $configPag['last_tag_open'] = "<li>";
        $configPag['last_tagl_close'] = "</li>";

        return $configPag;
    }
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */