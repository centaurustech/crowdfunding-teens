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
		$this->load->model('document_type_model', 'document_type');
		$this->load->model('file_uploader_model', 'file_uploader');
	}

	public function index() {
		redirect(base_url("profile/info"));
	}

	public function info($id) {
		//TODO: Create a "Under Construction" view.
		echo ("Uder construction...");
	}

	public function edit() {

		//Call user model.

		$usr_auth = $this->session->userdata('user');

		if ($usr_auth) {

			$data = array(
				"people" => $this->people_model->get_auth(),
				"user" => $this->users_model->get_auth(),
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
		$data_user = array();
		$data_user["username"] = $data["inputUser"];
		if ($data["inputPassword"] != "") {
			$data_user["userpassword"] = md5($data["inputPassword"]);
		}

		$update_user = $this->users_model->update_by("idpeople", $data["inputIdPeople"], $data_user);

		$result = array();

		if ($update_people && $update_user) {

			$peopleObj = $this->people_model->get($data["inputIdPeople"]);
			$userObj = $this->users_model->get_by("idpeople", $data["inputIdPeople"]);

			set_session_user($data_user["username"], $peopleObj, $userObj);

			$result["msg"] = "Dados atualizados com sucesso";
			$result["label_type"] = "success";

		} else {
			$result["msg"] = "Erro ao atualizar os dados";
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