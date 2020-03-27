<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertPatient($data) {
        $this->db->insert('patient', $data);
    }

    function getPatient() {
        $this->db->order_by("id", "desc");
        $query = $this->db->get('patient');
        return $query->result();
    }

    function getPatientByHId($hospital_id) {
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('patient', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getPatientById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('patient');
        return $query->row();
    }

    function updatePatient($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('patient', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('patient');
    }

    function updateIonUser($username, $email, $password, $ion_user_id) {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }

    function getHospitalId($current_user_id) {
        $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
        $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
        $group_name = strtolower($group_name);
        $hospital_id = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->hospital_id;
        return $hospital_id;
    }
}
