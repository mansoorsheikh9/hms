<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medicine_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertMedicine($data) {
        $this->db->insert('medicine', $data);
    }

    function getMedicine() {
        $query = $this->db->get('medicine');
        return $query->result();
    }
    
    function getMedicineByHId($hospital_id){
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('medicine', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getMedicineById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('medicine');
        return $query->row();
    }

    function updateMedicine($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('medicine', $data);
    }

    function insertMedicineCategory($data) {

        $this->db->insert('medicine_category', $data);
    }

    function getMedicineCategory() {
        $query = $this->db->get('medicine_category');
        return $query->result();
    }
    
    function getMedicineCategoryByHId($hospital_id){
        $query = $this->db->get_where('medicine_category', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getMedicineCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('medicine_category');
        return $query->row();
    }

    function updateMedicineCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('medicine_category', $data);
    }

    function deleteMedicine($id) {
        $this->db->where('id', $id);
        $this->db->delete('medicine');
    }

    function deleteMedicineCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('medicine_category');
    }

}
