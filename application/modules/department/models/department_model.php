<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertDepartment($data) {
        $this->db->insert('department', $data);
    }

    function getDepartment() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('department');
        return $query->result();
    }

    function getDepartmentByHId($hospital_id) {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get_where('department', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getDepartmentById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('department');
        return $query->row();
    }

    function updateDepartment($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('department', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('department');
    }

}
