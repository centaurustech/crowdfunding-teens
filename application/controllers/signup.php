<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class signup extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/signup
	 *	- or -
	 * 		http://example.com/index.php/signup/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/signup/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
		$this->load->model('people_model');
		$this->load->model('permissions_model');
		$this->load->config('email');
		$this->load->config('facebook');
		$this->load->library("email");

		$this->_prepare_signup();
	}

	private function _check_auth() {
		// Return previous URL, when authenticated.
		if ($this->session->userdata('user')) {
			$url = read_prev_url_cookies();
			redirect($url);
		}
	}

	private function _prepare_signup() {

		//$this->masterpage->header = "/shared/view_header_login";
		$this->masterpage->footer = "";

		$this->_check_auth();
	}

	public function index() {
		store_prev_url_cookies();
		$this->masterpage->view('signup/view_signup');
	}

	public function create_user() {
		$post_data = $this->input->post();

		//Ensure method is calling from signup page
		if (!$post_data) {
			show_404();
			return;
		}

		if (!$this->users_model->searchUserByUserName($post_data['inputUser'])) {

			$idpeople = $this->people_model->signup($post_data);

			if (!$idpeople) {
				redirect(base_url("signup/warning-existing-email"));
			} else {
				$iduser = $this->users_model->signup($post_data, $idpeople);
				redirect(base_url("signup/welcome"));
			}
		} else {
			redirect(base_url("signup/warning-existing-username"));
		}

		$data = array(
			'msg' => $msg,
		);

		//echo ($msg);
	}

	public function welcome() {
		$this->masterpage->view("signup/view_welcome_user");
	}

	public function warning_existing_email() {

		$message = array(
			"line1" => "Este E-Mail pertence a um usuário cadastrado nosso sistema.",
			"line2" => "Por gentileza efetuar o cadastro com outro E-Mail.",
		);

		$data = array(
			"message"      => $message,
			"previous_url" => base_url("signup"),
			"msg_img"      => "warning.png",
		);

		$this->masterpage->view("shared/view_message", $data);
	}

	public function warning_existing_username() {

		$message = array(
			"line1" => "O Nome de Usuário (Login) não está disponível.",
			"line2" => "Utilize outro nome de usuário para efetuar o cadastro.",
		);

		$data = array(
			"message"      => $message,
			"previous_url" => base_url("signup"),
			"msg_img"      => "warning.png",
		);

		$this->masterpage->view("shared/view_message", $data);
	}

}

/* End of file signup.php */
/* Location: ./application/controllers/signup.php */