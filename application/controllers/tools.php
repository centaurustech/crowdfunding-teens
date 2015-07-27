<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class tools extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/tools
	 *	- or -
	 * 		http://example.com/index.php/tools/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/tools/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
	}

	public function index() {

		$help = "Welcome to CLI tools... \n".$this->input->ip_address();

		echo $help."\n";

	}

	public function len($text = "") {
		echo strlen($text)."\n";
	}

}

/* End of file tools.php */
/* Location: ./application/controllers/tools.php */