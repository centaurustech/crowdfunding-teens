<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

require_once APPPATH.'/libraries/Twitter/OAuth.php';
require_once APPPATH.'/libraries/Twitter/Twitteroauth.php';

class Twitter_API extends TwitterOAuth {

	private $connection;

	public function __construct() {
		parent::__construct();
	}
}