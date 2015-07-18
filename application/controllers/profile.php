<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class profile extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/profile
	 *	- or -
	 * 		http://example.com/index.php/profile/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/profile/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();

		$this->masterpage->use_session_info();
		$this->load->model('people_model');
		$this->load->model('users_model');
		$this->load->model('campaigns_model');
		$this->load->model('contributions_model');
		$this->load->model('document_type_model', 'document_type');
		$this->load->model('file_uploader_model', 'file_uploader');
	}

	private function _set_header($iduser) {

		$count_camp             = $this->campaigns_model->count_by("iduser", $iduser);
		$amount_contrib_sent    = $this->contributions_model->summary_sent($iduser);
		$count_contrib_received = $this->contributions_model->count_received($iduser);

		$method_called = $this->router->fetch_method();
		$method_called = str_replace("-", "_", $method_called);

		$this->masterpage->header_vars['my_account']                = "";
		$this->masterpage->header_vars['my_campaigns']              = "";
		$this->masterpage->header_vars['my_received_contributions'] = "";
		$this->masterpage->header_vars['my_sent_contributions']     = "";

		$this->masterpage->header_vars['header_count_camp']             = $count_camp;
		$this->masterpage->header_vars['header_count_contrib_received'] = $count_contrib_received->count_contrib;
		$this->masterpage->header_vars['header_count_contrib_sent']     = $amount_contrib_sent->count_sent_contrib;

		$this->masterpage->header_vars[$method_called] = "account-info-menu-selected";
		$this->masterpage->header                      = "shared/view_header_profile";

	}

	public function index() {
		redirect(base_url("my-account"));
	}

	public function my_account() {

		$usr_auth = $this->session->userdata('user');

		if ($usr_auth) {

			$people = $this->people_model->get_auth();
			$user   = $this->users_model->get_auth();

			$count_camp             = $this->campaigns_model->count_by("iduser", $user->iduser);
			$amount_received        = $this->campaigns_model->sum_amount_by_user($user->iduser);
			$amount_contrib_sent    = $this->contributions_model->summary_sent($user->iduser);
			$count_contrib_received = $this->contributions_model->count_received($user->iduser);

			$data = array(
				"people"               => $people,
				"user"                 => $user,
				"num_campaign"         => $count_camp,
				"sum_camp_goal"        => $amount_received->sum_camp_goal,
				"sum_camp_collected"   => $amount_received->sum_camp_collected,
				"num_contrib_sent"     => $amount_contrib_sent->count_sent_contrib,
				"sum_contrib_sent"     => $amount_contrib_sent->sum_sent_contrib,
				"num_contrib_received" => $count_contrib_received->count_contrib,
			);

			/*echo '<pre>';
			var_dump($this->masterpage->header_vars);
			var_dump($data);
			echo '</pre>';
			exit();*/

			$this->_set_header($user->iduser);
			$this->masterpage->view("user_profile/view_my_account", $data);

		} else {
			redirect("login");
		}
	}

	public function my_campaigns() {

		$usr_auth = $this->session->userdata('user');

		if ($usr_auth) {

			$people = $this->people_model->get_auth();
			$user   = $this->users_model->get_auth();

			$count_camp   = $this->campaigns_model->count_by("iduser", $user->iduser);
			$my_campaigns = $this->campaigns_model->get_many_by("iduser", $user->iduser);
			$my_campaigns = $this->campaigns_model->list_campaigns(false, 0, 0, "", $user->iduser);

			$data = array(
				"people"       => $people,
				"user"         => $user,
				"num_campaign" => $count_camp,
				"my_campaigns" => $my_campaigns,
			);

			/*
			echo '<pre>';
			var_dump($data);
			echo '</pre>';
			 */

			$this->_set_header($user->iduser);
			$this->masterpage->view("user_profile/view_my_campaigns", $data);

		} else {
			redirect("login");
		}

	}

	public function my_received_contributions() {

		$usr_auth = $this->session->userdata('user');

		if ($usr_auth) {

			$people = $this->people_model->get_auth();
			$user   = $this->users_model->get_auth();

			$count_contrib_received = $this->contributions_model->count_received($user->iduser);
			$my_contrib_received    = $this->contributions_model->get_received_by_user($user->iduser);
			$my_campaigns           = $this->campaigns_model->get_many_by("iduser", $user->iduser);
			$sum_contrib_received   = $this->campaigns_model->sum_amount_by_user($user->iduser);

			$data = array(
				"people"                 => $people,
				"user"                   => $user,
				"sum_contrib_received"   => $sum_contrib_received->sum_camp_collected,
				"count_contrib_received" => $count_contrib_received->count_contrib,
				"my_contrib_received"    => $my_contrib_received,
			);

			/*echo '<pre>';
			var_dump($data);
			echo '</pre>';
			exit();*/

			$this->_set_header($user->iduser);
			$this->masterpage->view("user_profile/view_my_contrib_received", $data);

		} else {
			redirect("login");
		}

	}

	public function my_sent_contributions() {

		$usr_auth = $this->session->userdata('user');

		if ($usr_auth) {

			$people = $this->people_model->get_auth();
			$user   = $this->users_model->get_auth();

			$my_contrib_sent      = $this->contributions_model->get_sent_by_user($user->iduser);
			$summary_contrib_sent = $this->contributions_model->summary_sent($user->iduser);

			$data = array(
				"people"             => $people,
				"user"               => $user,
				"count_contrib_sent" => $summary_contrib_sent->count_sent_contrib,
				"sum_contrib_sent"   => $summary_contrib_sent->sum_sent_contrib,
				"my_contrib_sent"    => $my_contrib_sent,
			);

			/*
			echo '<pre>';
			var_dump($data);
			echo '</pre>';*/

			$this->_set_header($user->iduser);
			$this->masterpage->view("user_profile/view_my_contrib_sent", $data);

		} else {
			redirect("login");
		}

	}

	public function edit() {

		//Call user model.

		$usr_auth = $this->session->userdata('user');

		if ($usr_auth) {

			$data = array(
				"people"        => $this->people_model->get_auth(),
				"user"          => $this->users_model->get_auth(),
				"doc_type_list" => $this->document_type->get_all(),
			);

			$this->masterpage->view("user_profile/view_edit_profile", $data);

		} else {
			redirect("login");
		}
	}

	public function save() {
		$data = $this->input->post();
		$file = $_FILES;

		if ($data === false) {
			show_404();
			return;
		}

		//Check for private user folder and set it for uploading.
		$path = $this->users_model->create_user_folder();

		//Upload the image.
		$file = $this->file_uploader->upload($path, "fileProfilePhoto");

		// Image successfully uploaded
		$data["inputPictureURL"] = $this->file_uploader->get_uploaded_path();

		$update_people = $this->people_model->update($data, $file);

		// Update login and password here
		$data_user             = array();
		$data_user["username"] = $data["inputUser"];
		if ($data["inputPassword"] != "") {
			$data_user["userpassword"] = md5($data["inputPassword"]);
		}

		$update_user = $this->users_model->update_by("idpeople", $data["inputIdPeople"], $data_user);

		$result = array();

		if ($update_people && $update_user) {

			$peopleObj = $this->people_model->get($data["inputIdPeople"]);
			$userObj   = $this->users_model->get_by("idpeople", $data["inputIdPeople"]);

			set_session_user($data_user["username"], $peopleObj, $userObj);

			$result["msg"]        = "Dados atualizados com sucesso";
			$result["label_type"] = "success";

		} else {
			$result["msg"]        = "Erro ao atualizar os dados";
			$result["label_type"] = "danger";

		}

		redirect("profile/edit/", $result);

	}

	public function delete($id) {
		//TODO: Call delete user account.
	}

}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */