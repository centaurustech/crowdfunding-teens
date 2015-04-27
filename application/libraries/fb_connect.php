<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

include APPPATH.'libraries/facebook/facebook.php';
class Fb_connect extends Facebook {
	//declare public variables public
	public $user      = NULL;
	public $user_id   = FALSE;
	public $fb        = FALSE;
	public $fbSession = FALSE;
	public $appkey    = 0;

	//constructor method.
	public function __construct() {
		$CI = &get_instance();
		$CI->config->load("facebook", TRUE);
		$config = $CI->config->item('facebook');

		parent::__construct($config);
		//$this->user_id = $this->getUser();// New code
		$this->user_id = $this->get_user();// New code    //

		$me = null;
		if ($this->user_id) {
			try
			{
				//$me         = $this->api('/me');
				$me         = $this->user_id;
				$this->user = $me;
			} catch (FacebookApiException $e) {
				error_log($e);
			}
		}
	}
}

// end class
