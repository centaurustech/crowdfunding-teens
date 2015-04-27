<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/login
	 *	- or -
	 * 		http://example.com/index.php/login/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/login/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function login() {
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('people_model');
		$this->load->model('permissions_model');
		$this->load->config('email');
		$this->load->config('facebook');
		$this->load->library("email");
	}

	public function index() {
		$this->load->view('login/view_login');
	}

	public function password_recovery() {
		$this->load->view('login/view_password_recovery');
	}

	public function changepassword() {
		$user = $this->session->userdata('user');

		$password = md5($this->input->post('inputPassword'));

		$data['iduser']         = $user['iduser'];
		$data['userpassword']   = $password;
		$data['changepassword'] = 0;
		$data['hash_value']     = null;
		$data['hash_date']      = null;

		$this->users_model->update($data);

		//var_dump($this->users_model->update($data));
		//exit();

		redirect(base_url('login/'));
	}

	public function create_password() {
		if (isset($_POST["inputEmail"]) && $_POST["inputEmail"] != "") {

			$email_user = $_POST["inputEmail"];

			$people_data = $this->people_model->searchPeopleByEmail($email_user);

			if (!empty($people_data)) {
				$date = new DateTime();

				$user_data = $this->users_model->searchUserByPeopleId($people_data->idpeople);

				$randomHash = md5($user_data->username).md5($date->getTimestamp());

				$data['iduser']     = $user_data->iduser;
				$data['hash_value'] = $randomHash;
				$new_hour           = Time()+(60*60*2);
				$new_date           = date("Y-m-d H:i.s", $new_hour);
				$data['hash_date']  = $new_date;

				$result = $this->users_model->update($data);

				if ($result) {
					/*$email_from = $this->config->item('sender_email');
					$name_from = $this->config->item('sender_name');*/
					$name_from = "Crowdfunding";
					$email_to  = $email_user;
					$subject   = "Alteração de senha";

					$link_hash = base_url('/login/recoverpassword');
					$link_hash .= "/".$randomHash;

					$message = '<h1 style="font-size:14px; color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif;">%saludo%</h1>';
					$message .= '<p style="font-size:12;">%cuerpo%</p>';
					$message .= '<p><a href="%url%">%url%</a></p>';
					$message .= '<p style="font-size:12;">Atenciosamente,</p>';
					$message .= '<p style="font-size:12;">Crowdfunding</p>';

					$saludo = "Prezado";
					$cuerpo = "Segue abaixo o link para criar uma nova senha e assim ter acesso na sua conta:";

					$message = str_replace('%saludo%', $saludo.' '.$people_data->fullname.',', $message);
					$message = str_replace('%cuerpo%', $cuerpo, $message);
					$message = str_replace('%url%', $link_hash, $message);

					$config_email['protocol']  = $this->config->item("protocol");
					$config_email['mailtype']  = $this->config->item("mailtype");
					$config_email['smtp_host'] = $this->config->item("smtp_host");
					$config_email['smtp_user'] = $this->config->item("smtp_user");
					$config_email['smtp_pass'] = $this->config->item("smtp_pass");
					$config_email['smtp_port'] = $this->config->item("smtp_port");

					$this->email->set_newline("\r\n");
					$this->email->from($config_email['smtp_user'], $name_from);
					$this->email->to($email_to);
					$this->email->subject($subject);
					$this->email->message($message);

					$result = $this->email->send();

					if ($result) {
						$message = '1O processo para recuperar sua senha foi enviado para o e-mail cadastrado.';
					} else {
						$message = '0Houve um erro no sistema. Tente novamente mais tarde.';
					}

					echo json_encode($message);
				} else {
					$message = '0Houve um erro no sistema. Tente novamente mais tarde.';
					echo json_encode($message);
				}

			} else {
				/*$data_error['error_email'] = "O endere&#231;o de e-mail especificado n&#227;o existe no sistema.";
				$this->load->view('view_password_recovery',$data_error);*/
				$message = "0Este E-Mail  não existe no cadastro.";
				echo json_encode($message);
			}

		} else {
			$this->load->view('login/view_create_password');
		}

	}

	public function recoverpassword($hash = "") {

		if ($hash != "") {
			$userObj = $this->users_model->searchUserByHash($hash);
		} else {
			$userObj = "";
		}

		if (!empty($userObj)) {

			$peopleObj    = $this->people_model->get($userObj->idpeople);
			$current_date = floatval(strtotime('now'));
			$hash_date    = floatval(strtotime($userObj->hash_date));

			if ($current_date < $hash_date && $hash == $userObj->hash_value) {

				$data_user["fullname"] = $peopleObj->fullname;
				$data_user["email"]    = $peopleObj->email;
				$data_user["iduser"]   = $userObj->iduser;
				$data_user["username"] = $userObj->username;

				$this->session->set_userdata('user', $data_user);

				redirect(base_url('login/create_password'));
			} else {
				$data["error_recovery"] = "O link para inicializar sua senha expirou. Por tanto, inserir seu E-Mail para solicitar a inicialização de senha.";
				$this->load->view('login/view_password_recovery', $data);
			}
		} else {
			$data["error_recovery"] = "O link para inicializar sua senha não é válido. Por tanto, efetuar novamente o procedimento de Esquecí minha senha.";
			$this->load->view('login/view_password_recovery', $data);

		}
	}

	public function auth() {
		$this->form_validation->set_rules('inputUser', 'Usu&#225;rio', 'trim|xss_clean');
		$this->form_validation->set_rules('inputPassword', 'Senha', 'trim|xss_clean');

		$validation = $this->form_validation->run();

		if ($validation) {
			$username = $this->input->post("inputUser");
			$password = md5($this->input->post("inputPassword"));

			$userObj = $this->users_model->searchUserByLoginPass($username, $password);

			if (!empty($userObj)) {

				// Check for permission before access (disabled for now)
				/*
				$permissionObj = $this->permissions_model->getPermissionsByUser($userObj->iduser, true);

				if (empty($permissionObj)) {
				$data['error_login'] = "O usu&#225;rio não possui permissões configuradas.";
				$this->load->view('view_login', $data);
				return;
				}
				 */

				$peopleObj             = $this->people_model->get($userObj->idpeople);
				$data_user["username"] = $username;
				$data_user["fullname"] = $peopleObj->fullname;
				$data_user["picture"]  = is_null($peopleObj->picture_url)?"":$peopleObj->picture_url;
				$data_user["iduser"]   = $userObj->iduser;

				$this->session->set_userdata('user', $data_user);

				if ($userObj->changepassword == "0") {

					redirect(base_url('dashboard/'));
				} else {
					redirect(base_url('login/create_password/'));
				}
			} else {
				$data['error_login'] = "O usu&#225;rio ou senha est&#227;o incorretos";
				$this->load->view('login/view_login', $data);
			}
		} else {
			$data["error_login"] = "O usu&#225;rio ou senha est&#227;o incorretos";
			$this->load->view('login/view_login', $data);
		}
	}

	public function logout() {
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('permissions');
		//$this->load->view('view_login');
		redirect(base_url('login/'));
	}

	public function facebook() {
		$this->load->library('fb_connect');

		$login_url = $this->fb_connect->login_url();

		$param['redirect_uri'] = base_url("login/facebook");
		redirect($this->fb_connect->login_url());
		//var_dump($this->fb_connect->login_url());
	}

	public function facebook_redirect_url() {
		$this->load->library('fb_connect');

		$fb_user = $this->fb_connect->get_user();

		if (!$this->fb_connect->user_id) {
			//Handle not logged in,
		} else {
			$fb_usr = $this->fb_connect->user;
			//Handle user logged in,by updating session
			//print_r($fb_usr) will help to see what is returned
			//print_r($fb_usr);

			// Verify Facebook data against user and people model.
			$peopleObj = $this->people_model->sync_from_facebook($fb_usr);

			$userObj = $this->users_model->sync_from_facebook($peopleObj->idpeople, $fb_usr);

			$data_user["username"] = is_null($userObj->username)?"Autenticado por Facebook":$userObj->username;
			$data_user["fullname"] = $peopleObj->fullname;
			$data_user["picture"]  = $peopleObj->picture_url;
			$data_user["iduser"]   = $userObj->iduser;

			$this->session->set_userdata('user', $data_user);
			redirect(base_url('dashboard/'));

		}

	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */