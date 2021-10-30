<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Setting_model extends CI_Model{

    public function get_data_setting()
    {
        $q  = $this->db->get_where("TA_SETTING",["ID_SETTING",1])->row_array();
        return $q;
    }

}
