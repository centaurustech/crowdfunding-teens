<?php if (!defined('BASEPATH')) {
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
			$this->load->view('/home/view_home');
		}

	}

	public function logout() {
		redirect(base_url('/login/logout/'));
	}

	private function _get_imgur_data() {
		$rs = new stdClass();

		$rs->stations = $this->stations_model->getAll();
		$rs->markets  = $this->markets_model->getAll();

		if ($this->input->post()) {
			$idstation = $this->input->post("idstation");
			$idmarket  = $this->input->post("idmarket");
			$albumdate = $this->input->post("albumdate");

			$idalbums = $this->albums_assoc_model->get_album_by_market_station($idstation, $idmarket, $albumdate);

			$rs->imgur_result = $this->integrations_model->get_imgur_albums_array($idalbums);

		} else {
			//$rs->imgur['data']['images'] = array();
		}

		return $rs;

	}

	public function view($view_name = '') {

		switch ($view_name) {
			case 'users':
				redirect("/users/searchAllUsers");
				return;
				break;
			case 'images_albums':
				$rs = $this->_get_imgur_data();
				break;

			default:
				//$rs = $this->_countRecords();
				break;
		}

		load_view($this, 'view_home_'.$view_name, $rs);// Call helper function

	}

	private function _countRecords() {

		$objModule = new stdClass();

		$objModule->module_name  = 'Total Usuários = ';
		$objModule->count_record = $this->users_model->count_record();
		$data[]                  = $objModule;

		$objModule               = new stdClass();
		$objModule->module_name  = 'Total Emissoras = ';
		$objModule->count_record = $this->stations_model->count_record()->num_stations;
		$data[]                  = $objModule;

		$objModule               = new stdClass();
		$objModule->module_name  = 'Total Mercado / Setor Econômico = ';
		$objModule->count_record = $this->markets_model->count_record()->num_markets;
		$data[]                  = $objModule;

		$objModule               = new stdClass();
		$objModule->module_name  = 'Total Álbuns Associados = ';
		$objModule->count_record = $this->albums_assoc_model->count_record();
		$data[]                  = $objModule;

		return $data;
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */