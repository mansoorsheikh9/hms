<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Donor_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertDonor($data) {
        $this->db->insert('donor', $data);
    }

    function getDonor() {
        $query = $this->db->get('donor');
        return $query->result();
    }

    function getDonorByHId($hospital_id) {
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('donor', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getDonorById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('donor');
        return $query->row();
    }

    function updateDonor($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('donor', $data);
    }

    function deleteDonor($id) {
        $this->db->where('id', $id);
        $this->db->delete('donor');
    }

    function getBloodBank() {
        $query = $this->db->get('bankb');
        return $query->result();
    }

    function getBloodBankById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('bankb');
        return $query->row();
    }

    function updateBloodBank($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('bankb', $data);
    }

}
