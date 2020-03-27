<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bed_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertBed($data) {
        $this->db->insert('bed', $data);
    }

    function getBed() {
        $query = $this->db->get('bed');
        return $query->result();
    }
    
    function getBedByHId($hospital_id){
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('bed', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getBedById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('bed');
        return $query->row();
    }

    function updatebed($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('bed', $data);
    }

    function updatebedByBedId($bed_id, $data) {
        $this->db->where('bed_id', $bed_id);
        $this->db->update('bed', $data);
    }

    function insertBedCategory($data) {
        $this->db->insert('bed_category', $data);
    }

    function getbedCategory() {
        $query = $this->db->get('bed_category');
        return $query->result();
    }
    
    function getBedCategoryByHId($hospital_id){
        $query = $this->db->get_where('bed_category', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getBedCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('bed_category');
        return $query->row();
    }

    function updateBedCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('bed_category', $data);
    }

    function deleteBed($id) {
        $this->db->where('id', $id);
        $this->db->delete('bed');
    }

    function deleteBedCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('bed_category');
    }

    function insertAllotment($data) {
        $this->db->insert('alloted_bed', $data);
    }

    function getAllotment() {
        $query = $this->db->get('alloted_bed');
        return $query->result();
    }
    
    function getAllotmentByHId($hospital_id){
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('alloted_bed', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getAllotmentById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('alloted_bed');
        return $query->row();
    }

    function updateAllotment($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('alloted_bed', $data);
    }

    function deleteBedAllotment($id) {
        $this->db->where('id', $id);
        $this->db->delete('alloted_bed');
    }

}
