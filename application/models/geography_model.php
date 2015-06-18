<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class geography_model extends MY_Model {

	public function contributions_model() {
		parent::__construct();

	}

	public function get_countries() {

		$result = $this->db
		               ->select("
		               		c.country_id,
		               		c.country_name
							", false)
		->from("country as c")
		//->order_by("c.country_name", "asc")
		->get();

		if ($result && $result->num_rows > 0) {

			foreach ($result->result() as $row) {
				$rows[] = $row;
			}

			return $rows;
		}

		return false;
	}

}
