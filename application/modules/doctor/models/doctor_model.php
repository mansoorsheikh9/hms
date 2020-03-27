<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Doctor_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertDoctor($data) {
        $this->db->insert('doctor', $data);
    }

    function getDoctor() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('doctor');
        return $query->result();
    }

    function getDoctorByHId($hospital_id) {
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('doctor', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getDoctorById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('doctor');
        return $query->row();
    }

    function updateDoctor($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('doctor', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('doctor');
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

}
