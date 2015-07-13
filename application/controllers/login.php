<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class login extends MY_Controller {

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

	private $connection;

	public function __construct() {
		parent::__construct();
		$this->load->model('people_model');
		$this->load->model('permissions_model');

		//E-Mail
		$this->load->config('email');
		$this->load->library("email");

		//Facebook
		$this->load->config('facebook');
		$this->load->library('fb_connect');

		//Google
		$this->load->config('googleplus');
		$this->load->library('googleplus');

		//Twitter
		$this->load->library('twitter_api');
		$this->load->config('twitter');

		//$this->masterpage->use_session_info();
		$this->_prepare_login();

	}

	private function _check_auth() {
		// Return previous URL, when authenticated.
		if ($this->session->userdata('user')) {
			$url = read_prev_url_cookies();
			redirect($url);
		}
	}

	private function _prepare_login() {

		//$this->masterpage->header = "/shared/view_header_login";
		$this->masterpage->footer = "";

	}

	/**
	 * Reset session data for Twitter
	 * @access	private
	 * @return	void
	 */
	private function _twitter_reset_session() {
		$this->session->unset_userdata('twitter_access_token');
		$this->session->unset_userdata('twitter_access_token_secret');
		$this->session->unset_userdata('twitter_request_token');
		$this->session->unset_userdata('twitter_request_token_secret');
		$this->session->unset_userdata('twitter_user_id');
		$this->session->unset_userdata('twitter_screen_name');
	}

	/**
	 * Reset session data for Twitter
	 * @access	private
	 * @return	void
	 */

	private function _twitter_create_connection() {
		if ($this->session->userdata('twitter_access_token') && $this->session->userdata('twitter_access_token_secret')) {
			// If user already logged in
			$this->connection = $this->twitter_api->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('twitter_access_token'), $this->session->userdata('twitter_access_token_secret'));
		} elseif ($this->session->userdata('twitter_request_token') && $this->session->userdata('twitter_request_token_secret')) {
			// If user in process of authentication
			$this->connection = $this->twitter_api->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('twitter_request_token'), $this->session->userdata('twitter_request_token_secret'));
		} else {
			// Unknown user
			$this->connection = $this->twitter_api->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
		}
		return $this->connection;
	}

	public function index() {

		store_prev_url_cookies();

		$this->_check_auth();

		$this->masterpage->view('login/view_login');
	}

	public function password_recovery() {

		$this->_check_auth();

		$this->masterpage->view('login/view_password_recovery');
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

		redirect(base_url('login/'));
	}

	public function create_password() {

		if ($this->input->post("inputEmail")) {

			$email_user = $this->input->post("inputEmail");

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

				if ($result !== false) {
					/*$email_from = $this->config->item('sender_email');
					$name_from = $this->config->item('sender_name');*/
					$name_from = "Atendimento - Presente Top";
					$email_to  = $email_user;
					$subject   = "Procedimento para Alteração de senha";

					$link_hash = base_url('/login/recoverpassword');
					$link_hash .= "/".$randomHash;

					$message = '<h1 style="font-size:14px; color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif;">%greeting%</h1>';
					$message .= '<p style="font-size:12;">%body%</p>';
					$message .= '<p><a href="%url%">%url%</a></p>';
					$message .= '<p style="font-size:12;">Atenciosamente,</p>';
					$message .= '<p style="font-size:12;">Equipe Presente Top</p>';

					$greeting = "Prezado";
					$body     = "Segue abaixo o link para criar uma nova senha e assim ter acesso na sua conta:";

					$message = str_replace('%greeting%', $greeting.' '.$people_data->fullname.',', $message);
					$message = str_replace('%body%', $body, $message);
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

					//echo $this->email->print_debugger();
					//exit();

					if ($result !== false) {
						$success = true;
						$message = 'O procedimento para recuperar sua senha foi enviado para o e-mail informado.';
					} else {
						$success = false;
						$message = 'Erro ao enviar o e-mail. Tente novamente mais tarde.';
					}

				} else {
					$message = 'Erro ao efetuar processo de envio de senha. Tente novamente mais tarde.';
					$success = false;
				}

			} else {

				$message = "Este E-Mail  não existe no cadastro.";
				$success = false;

			}

			$data = array(
				"alert_type" => $success?"success":"danger",
				"msg"        => $message,
			);

			$this->masterpage->view('login/view_password_recovery', $data);

		} else {
			$this->masterpage->view('login/view_create_password');
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

				$data_user["fullname"]  = $peopleObj->fullname;
				$data_user["firstname"] = substr($peopleObj->fullname, 0, strpos($peopleObj->fullname, " "));
				$data_user["email"]     = $peopleObj->email;
				$data_user["iduser"]    = $userObj->iduser;
				$data_user["username"]  = $userObj->username;

				$this->session->set_userdata('user', $data_user);

				redirect(base_url('login/create-password'));
			} else {
				$data["error_recovery"] = "O link para inicializar sua senha expirou. Por tanto, inserir seu E-Mail para solicitar a inicialização de senha.";
				$this->masterpage->view('login/view_password_recovery', $data);
			}
		} else {
			$data["error_recovery"] = "O link para inicializar sua senha não é válido. Por tanto, efetuar novamente o procedimento de Esquecí minha senha.";
			$this->masterpage->view('login/view_password_recovery', $data);

		}
	}

	public function auth() {
		$this->form_validation->set_rules('inputUser', 'Usuário', 'trim|xss_clean');
		$this->form_validation->set_rules('inputPassword', 'Senha', 'trim|xss_clean');

		$validation = $this->form_validation->run();

		if ($validation) {
			$username = $this->input->post("inputUser");
			$password = md5($this->input->post("inputPassword"));

			$userObj = $this->users_model->searchUserByLoginPass($username, $password);

			if (!empty($userObj)) {

				$peopleObj = $this->people_model->get($userObj->idpeople);

				// Create a session for authenticating users.
				set_session_user($username, $peopleObj, $userObj);

				if ($userObj->changepassword == "0") {

					$url = read_prev_url_cookies();

					redirect($url);
				} else {
					redirect(base_url('login/create_password/'));
				}
			} else {
				$data['error_login'] = "O usuário ou senha estão incorretos";
				$this->masterpage->view('login/view_login', $data);
			}
		} else {
			$data["error_login"] = "O usuário ou senha estão incorretos";
			$this->masterpage->view('login/view_login', $data);
		}
	}

	public function logout() {
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('permissions');

		if ($this->session->userdata('google_token')) {
			$this->session->unset_userdata('google_token');
			$this->googleplus->revokeToken();
		}

		if ($this->session->userdata('twitter_access_token')) {
			$this->_twitter_reset_session();
		}

		redirect(base_url('home/'));
	}

	/*
	 * SOCIAL MEDIA COntrollers below
	 */

	public function facebook() {

		$this->_check_auth();

		$param['redirect_uri'] = base_url("login/facebook");
		$return_url            = $this->fb_connect->login_url();
		redirect($return_url);

	}

	public function facebook_redirect_url() {

		$this->_check_auth();

		$fb_user = $this->fb_connect->get_user();

		if (!$this->fb_connect->user_id) {
			//Handle not logged in,
		} else {

			//Get User Data
			$fb_usr = $this->fb_connect->user;

			// Verify Facebook data against user and people model.
			$peopleObj = $this->people_model->sync_from_facebook($fb_usr);

			$userObj = $this->users_model->sync_from_facebook($peopleObj->idpeople, $fb_usr);

			$data_user["username"]  = is_null($userObj->username)?"fb-".$userObj->facebook_id:$userObj->username;
			$data_user["fullname"]  = $peopleObj->fullname;
			$data_user["firstname"] = strpos($peopleObj->fullname, " ") !== false?substr($peopleObj->fullname, 0, strpos($peopleObj->fullname, " ")):$peopleObj->fullname;
			$data_user["picture"]   = is_null($peopleObj->picture_url) || $peopleObj->picture_url == ""?get_no_profile_picture($peopleObj->gender):$peopleObj->picture_url;
			$data_user["iduser"]    = $userObj->iduser;
			$data_user["idpeople"]  = $peopleObj->idpeople;

			$this->session->set_userdata('user', $data_user);

			$url = read_prev_url_cookies();

			redirect($url);

		}

	}

	public function google_plus() {

		$this->_check_auth();

		$client = $this->googleplus->client;

		redirect($client->createAuthUrl());

	}

	public function get_google_plus_token() {

		var_dump($this->googleplus->getAccessToken());

	}

	public function google_plus_redirect_url() {

		$this->_check_auth();

		$client = $this->googleplus->client;

		$code = $this->input->get('code');
		//Call back for authenticate
		if ($code !== false) {
			$client->authenticate($code);

			$token = $client->getAccessToken();

			$this->session->set_userdata('google_token', $token);

			//Get Info Data
			$google_usr = $this->googleplus->people->get('me');

			// Verify Google Plus data against user and people model.
			$peopleObj = $this->people_model->sync_from_google($google_usr);

			$userObj = $this->users_model->sync_from_google($peopleObj->idpeople, $google_usr);

			$data_user["username"]  = is_null($userObj->username)?"google-".$userObj->google_id:$userObj->username;
			$data_user["fullname"]  = $peopleObj->fullname;
			$data_user["firstname"] = strpos($peopleObj->fullname, " ") !== false?substr($peopleObj->fullname, 0, strpos($peopleObj->fullname, " ")):$peopleObj->fullname;
			$data_user["picture"]   = is_null($peopleObj->picture_url) || $peopleObj->picture_url == ""?get_no_profile_picture($peopleObj->gender):$peopleObj->picture_url;
			$data_user["iduser"]    = $userObj->iduser;
			$data_user["idpeople"]  = $peopleObj->idpeople;

			$this->session->set_userdata('user', $data_user);

			$url = read_prev_url_cookies();

			redirect($url);

			return;
		}

		if ($this->session->userdata('google_token')) {
			$client->setAccessToken($this->session->userdata('google_token'));
		}

		if ($client->getAccessToken()) {
			$user = $oauth2->userinfo->get();

			$email        = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
			$img          = filter_var($user['picture'], FILTER_VALIDATE_URL);
			$personMarkup = "$email<div><img src='$img?sz=50'></div>";

			$token = $client->getAccessToken();
			$this->session->set_userdata('google_token', $token);

		} else {
			$authUrl = $client->createAuthUrl();
			var_dump($authUrl);
		}

	}

	/**
	 * Here comes authentication process begin.
	 * @access	public
	 * @return	void
	 */
	public function twitter() {

		$connection = $this->_twitter_create_connection();

		if ($this->session->userdata('twitter_access_token') && $this->session->userdata('twitter_access_token_secret')) {
			// User is already authenticated. Add your user notification code here.
			redirect(base_url('/'));
		} else {

			$request_token = $this->connection->getRequestToken(base_url('login/twitter-redirect-url'));

			// Making a request for request_token

			/*
			echo '<pre>';
			var_dump($request_token);
			echo '</pre>';
			exit();
			 */

			$this->session->set_userdata('twitter_request_token', $request_token['oauth_token']);
			$this->session->set_userdata('twitter_request_token_secret', $request_token['oauth_token_secret']);

			if ($connection->http_code == 200) {
				$url = $connection->getAuthorizeURL($request_token);
				redirect($url);
			} else {
				// An error occured. Make sure to put your error notification code here.
				//redirect(base_url('/'));
				$data['error_login'] = "Erro ao usar autenticação de Twitter. HTTP Code: ".$connection->http_code;
				$this->masterpage->view('login/view_login', $data);
			}
		}
	}

	/**
	 * Callback function, landing page for twitter.
	 * @access	public
	 * @return	void
	 */
	public function twitter_redirect_url() {

		$connection = $this->_twitter_create_connection();

		if ($this->input->get('oauth_token') && $this->session->userdata('twitter_request_token') !== $this->input->get('oauth_token')) {
			$this->_twitter_reset_session();
			redirect(base_url('/login/twitter'));
		} else {
			$access_token = $connection->getAccessToken($this->input->get('oauth_verifier'));

			if ($connection->http_code == 200) {
				$this->session->set_userdata('twitter_access_token', $access_token['oauth_token']);
				$this->session->set_userdata('twitter_access_token_secret', $access_token['oauth_token_secret']);
				$this->session->set_userdata('twitter_user_id', $access_token['user_id']);
				$this->session->set_userdata('twitter_screen_name', $access_token['screen_name']);

				$this->session->unset_userdata('twitter_request_token');
				$this->session->unset_userdata('twitter_request_token_secret');

				$twitter_usr = $this->connection->get('account/verify_credentials');

				// Verify Google Plus data against user and people model.
				$peopleObj = $this->people_model->sync_from_twitter($twitter_usr);

				$userObj = $this->users_model->sync_from_twitter($peopleObj->idpeople, $twitter_usr);

				$data_user["username"]  = is_null($userObj->username)?"twitter-".$userObj->google_id:$userObj->username;
				$data_user["fullname"]  = $peopleObj->fullname;
				$data_user["firstname"] = strpos($peopleObj->fullname, " ") !== false?substr($peopleObj->fullname, 0, strpos($peopleObj->fullname, " ")):$peopleObj->fullname;
				$data_user["picture"]   = is_null($peopleObj->picture_url) || $peopleObj->picture_url == ""?get_no_profile_picture($peopleObj->gender):$peopleObj->picture_url;
				$data_user["iduser"]    = $userObj->iduser;
				$data_user["idpeople"]  = $peopleObj->idpeople;

				$this->session->set_userdata('user', $data_user);

				$url = read_prev_url_cookies();

				redirect($url);

				return;

			} else {
				// An error occured. Add your notification code here.
				//redirect(base_url('/'));
				$data['error_login'] = "Erro de retorno Twitter. HTTP Code: ".$connection->http_code;
				$this->masterpage->view('login/view_login', $data);

			}
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */