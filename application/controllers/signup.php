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

		$this->masterpage->header = "/shared/view_header_login";
		$this->masterpage->footer = "";

		$this->_check_auth();
	}

	public function index() {
		store_prev_url_cookies();
		$this->masterpage->view('signup/view_signup');
	}

	public function create_user() {
		$post_data = $this->input->post();

		if (!$this->users_model->searchUserByUserName($post_data['inputUser'])) {

			$idpeople = $this->people_model->signup($post_data);

			if (!$idpeople) {
				$msg = 'E-Mail já cadastrado. Tente com outro E-Mail <a href="'.base_url('signup').'">Login</a>';
			} else {
				$iduser = $this->users_model->signup($post_data, $idpeople);
				$msg    = 'Usuário cadastrado com sucesso. <a href="'.base_url('login').'">Login</a>';
			}
		} else {
			$msg = 'Nome de Usuário (Login) já cadastrado.';
		}

		echo ($msg);

	}
}

/* End of file signup.php */
/* Location: ./application/controllers/signup.php */