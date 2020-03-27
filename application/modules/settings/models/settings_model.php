<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getSettings() {
        $query = $this->db->get('settings');
        return $query->row();
    }

    function getSettingsByHId($hospital_id) {
        $query = $this->db->get_where('settings', array('hospital_id' => $hospital_id));
        return $query->row();
    }

    function updateSettingsByHId($hospital_id, $data) {
        $this->db->where('hospital_id', $hospital_id);
        $this->db->update('settings', $data);
    }

    function insertSettings($hospital_settings_data) {
        $this->db->insert('settings', $hospital_settings_data);
    }

}
