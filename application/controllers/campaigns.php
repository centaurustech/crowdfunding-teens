<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class campaigns extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/campaigns
	 *	- or -
	 * 		http://example.com/index.php/campaigns/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/campaigns/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
		$this->load->model('geography_model');
		$this->load->model('people_model');
		$this->load->model('campaigns_model');
		$this->load->model('contributions_model');
		$this->load->model('campaigns_images_gallery_model', 'camp_pictures');
		$this->load->model('file_uploader_model', 'file_uploader');

		$this->masterpage->use_session_info();
	}

	/*	Private Methods	 */
	private function _render($idcampaign = "", $action_param = null) {

		// Request data to model for editing or querying campaign.

		$action = strtolower($this->router->method);

		$usr_auth    = $this->users_model->get_auth_user();
		$rs_contrib  = false;
		$rs_notes    = false;
		$promote     = false;
		$msg_promote = "";

		switch ($action) {
			case 'details':
			case 'edit':
			case 'promote':
				$rs               = $this->campaigns_model->get_campaign_info($idcampaign);
				$rs_contrib_msg   = $this->contributions_model->get_contrib_msg($idcampaign);
				$rs_notes         = $this->contributions_model->get_last_notes($idcampaign);
				$view_name_suffix = $action == "edit"?"_add_edit":"";
				$msg_action       = "Alterar ";
				if ($action == "edit" && !$usr_auth) {
					redirect(base_url('login'));
					return;
				}

				if ($action == 'promote') {
					$promote = true;

					// Hardcoded promotions message
					if ($action_param == "updated") {
						$msg_promote = "Você atualizou sua campanha. Informe aos seus amigos as novidades.";
					} else {
						$msg_promote = "Parabéns, você criou a campanha. Comece a promove-la agora.";
					}
				}

				break;

			case 'add-new':
			case 'add_new':
				if (!$usr_auth) {
					redirect(base_url('login'));
					return;
				}

				$msg_action     = "Criar ";
				$rs_contrib_msg = null;
				$rs_notes       = null;

				$view_name_suffix = "_add_edit";
				$rs               = $this->campaigns_model->init($usr_auth);
				break;

			default:
				show_404();
				return;
		}

		//Redirect to detail when campaign does't belong to the auth user.
		if ($action == "edit" && $rs->iduser != $usr_auth->iduser) {
			redirect(base_url("campaigns/details/".$idcampaign));
			return;
		}

		//Read Get variable for returning previous URL
		if (isset($_GET['from_my_account'])) {
			$previous_url = base_url('profile/my-campaigns');
		} else {
			$previous_url = base_url('campaigns/details/'.$idcampaign);
		}

		// Prepare array data before sending to the view

		$data = array(
			'rs'              => $rs,
			'rs_contrib_msg'  => $rs_contrib_msg,
			'rs_notes'        => $rs_notes,
			'controller_name' => $this->router->class,
			'action_name'     => $action,
			'msg_action'      => $msg_action,
			'previous_url'    => $previous_url,
			'promote'         => $promote,
			'msg_promote'     => $msg_promote,
		);

		if ($data['rs']) {
			$view_name = "details".$view_name_suffix;
		} else {
			$view_name = "not_found";
		}

		$this->masterpage->view("campaigns/".$view_name, $data);

	}

	private function _show_view($rs_camp, $criteria = "") {

		$list_title = $criteria == ""?
		"Listado de Presentes":
		"Campanhas de ".$criteria;

		$data = array(
			"rs_camp"       => $rs_camp,
			"list_title"    => $list_title,
			"criteria_text" => $criteria,
		);

		$this->masterpage->view('/campaigns/list', $data);
	}

	/*	Public Methods	 */
	public function index() {

		//Get first 8 campaign from database.
		$rs_camp = $this->campaigns_model->list_campaigns(false, 0, 8);

		$this->_show_view($rs_camp);

	}

	public function search($criteria = "") {

		$criteria = trim(rawurldecode($criteria));

		if ($criteria != "") {
			if (!is_numeric($criteria)) {
				$rs_camp = $this->campaigns_model->list_campaigns(false, 0, 8, $criteria);
				$this->_show_view($rs_camp, $criteria);
			} else {
				redirect(base_url("campaigns/details/".$criteria));
			}
		} else {
			redirect(base_url("campaigns/"));
		}
	}

	public function details($idcampaign = "") {

		$this->_render($idcampaign);

	}

	public function promote($action, $idcampaign = "") {

		$this->_render($idcampaign, $action);

	}

	public function edit($idcampaign = "") {

		$this->_render($idcampaign);

	}

	public function update_field() {

		if (!$this->input->post()) {
			show_404();
			return;
		}

		$new_data = array(
			$this->input->post('fieldName')=> $this->input->post('value'),
		);

		$result = $this->campaigns_model->update(
			$this->input->post('record_id'),
			$new_data
		);

		if ($result === true && $this->campaigns_model->affected_rows() > 0) {
			echo json_encode(
				array(
					"result"    => true,
					"msg"       => "Registro atualizado",
					"new_value" => $this->input->post('value'),
				)
			);
		} else {
			log_message(
				'error',
				'Error #'.$this->db->_error_number().': '.$this->db->_error_message()
			);
			echo json_encode(
				array(
					"result" => false,
					"msg"    => "Erro ao atualizar campo.".$this->db->_error_message(),
				)
			);
		}
	}

	private function _save_img($idcampaign = "") {

		if (!$this->input->post() || $idcampaign == "") {
			show_404();
			return;
		}

		//Check for private user folder and set it for uploading.
		$path = $this->users_model->create_user_folder();

		//Upload the image.
		$file = $this->file_uploader->upload($path, "uploadCampaignPict");

		// Image successfully uploaded
		$imgurl = $this->file_uploader->get_uploaded_path();

		if (!is_null($imgurl)) {

			$imgurl = $this->file_uploader->resize_uploaded_img(677, 351);

			//Save the image url in DB.
			$result = $this->camp_pictures->save($idcampaign, $imgurl);

			if ($result != false) {

				return false;
			}

		}

		return array(
			"msg"        => $file["error"],
			"source_url" => "campaigns/details/".$idcampaign,
		);

	}

	private function _clear_picture($idcampaign = "") {

		$imgurl = base_url("assets/img/no-campaign-picture.png");
		return $this->camp_pictures->save($idcampaign, $imgurl);

	}

	public function add_new() {

		$usr_auth = $this->users_model->get_auth_user();

		$this->_render();

	}

	public function delete($idcampaign = "") {

		$usr_auth = $this->users_model->get_auth_user();

		if ($idcampaign == "") {
			show_404();
			return;
		}

		if (!$usr_auth) {
			redirect(base_url('login'));
			return;
		}

		$deleted = $this->campaigns_model->delete($idcampaign);

		$data = array(
			"msg"        => $deleted->msg,
			"source_url" => "profile/my-campaigns",
		);

		$this->masterpage->view("campaigns/status_action", $data);

	}

	public function save() {

		if (!$this->input->post()) {
			show_404();
			return;
		}

		$auth_usr = $this->users_model->get_auth_user();

		if ($auth_usr) {

			$data = array(
				"camp_name"        => $this->input->post("inputCampName"),
				"camp_description" => $this->input->post("inputCampDescription"),
				"camp_goal"        => $this->input->post("hiddenCampPriceAmount"),
				"iduser"           => $auth_usr->iduser,
				"creationdate"     => date('Y-m-d H:i:s'),
			);

			$idcampaign = $this->input->post("idcampaign");

			$status = $this->campaigns_model->save($idcampaign, $data);

			if ($status->id) {

				if ($this->input->post("emptyPicture") == 1) {
					$this->_clear_picture($status->id);
					$err_img_saved = true;
				} else {
					$err_img_saved = $this->_save_img($status->id);
				}

				if ($err_img_saved === false) {
					redirect(base_url('campaigns/promote/'.$status->action.'/'.$status->id));
				} else {

					//var_dump_pretty($data);

					$this->masterpage->view("campaigns/status_action", $err_img_saved);

				}

			} else {
				$data = array(
					"msg" => "Error ao salvar a campanha",
				);

				$this->masterpage->view("campaigns/status_action", $data);
			}

		} else {

			redirect(base_url('login'));

		}

	}
	function get_campaign_ajax($offset = 0) {
		if ($offset > 0) {

		} else {
			show_404();
		}

	}

}

/* End of file campaigns.php */
/* Location: ./application/controllers/campaigns.php */