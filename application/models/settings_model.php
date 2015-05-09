<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class settings_model extends CI_Model{
    private $_row;

    public function settings_model(){
        parent::__construct();

        $this->_row = new stdClass();	//Initialize a generic object.
        $this->table = 'settings';
        $this->id = 'idsetting';
    }

    public function getByVariable($variable){

        $sql = "SELECT * ";
        $sql.= "FROM settings s ";
        $sql.= "WHERE s.variable = '" . $variable . "'";

        return $this->db->query($sql)->row();

    }

    public function addnew($data){
        $arr_filter = array(
            'variable' 		    => $data['variable'],
            'description' 	    => $data['description'],
            'creationdate'      => (isset($data['creationdate']) ? $data['creationdate'] : NULL),
            'value'             => $data['value'],
            'idusercreator'     => $data['idusercreator']
        );

        $query = $this->db->insert('settings', $arr_filter);
        $last_insert_id = $this->db->insert_id();

        return $last_insert_id;
    }

    public function update($data) {

        if (isset($data['variable']) && $data['variable'] != '')
            $arr_filter['variable'] = $data['variable'];
        if (isset($data['description']) && $data['description'] != '')
            $arr_filter['description'] = $data['description'];
        if (isset($data['value']) && $data['value'] != '')
            $arr_filter['value'] = $data['value'];
        if (isset($data['creationdate']) && $data['creationdate'] != '')
            $arr_filter['creationdate'] = $data['creationdate'];
        if (isset($data['editiondate']) && $data['editiondate'] != '')
            $arr_filter['editiondate'] = $data['editiondate'];
        if (isset($data['idusercreator']) && $data['idusercreator'] != '')
            $arr_filter['idusercreator'] = $data['idusercreator'];

        $this->db->where('idsetting', $data['idsetting']);
        return $this->db->update('settings', $arr_filter);
    }
}