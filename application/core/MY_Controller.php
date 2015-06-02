<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/**
 * A base controller with a support to authetication user data.
 *
 *
 * @author César Urdaneta
 * @copyright Copyright (c) 2015, César Urdaneta <http://www.betadevconsult.com.br>
 */

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->upload->load_default_param();// Load default parameter for uploading files.
	}

}