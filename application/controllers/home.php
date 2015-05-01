<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
		$this->load->model('users_model');
	}

	public function index() {
		//$this->view();
		if ($this->session->userdata('user')) {
			$user_session         = $this->session->userdata('user');
			$data['current_user'] = $user_session['fullname'];
			$data['user_pic']     = $user_session['picture'];

			//$this->load->view('view_home', $data);
		} else {
			//redirect(base_url('/login'));
			$this->load->view('/view_header');
			$this->load->view('/home/view_home');
			$this->load->view('/view_footer');
		}

	}

	public function logout() {
		redirect(base_url('/login/logout/'));
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */