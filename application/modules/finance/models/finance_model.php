<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertPayment($data) {
        $this->db->insert('payment', $data);
    }

    function getPayment() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getPaymentById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('payment');
        return $query->row();
    }

    function getPaymentByHId($hospital_id) {
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('payment', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getPaymentByPatientIdByStatus($id) {
        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $query = $this->db->get('payment');
        return $query->result();
    }

    function lastPaidInvoice($id) {
        $this->db->where('patient', $id);
        $this->db->where('status', 'paid-last');
        $query = $this->db->get('payment');
        return $query->result();
    }

    function updatePayment($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('payment', $data);
    }

    function insertPaymentCategory($data) {
        $this->db->insert('payment_category', $data);
    }

    function getPaymentCategory() {
        $query = $this->db->get('payment_category');
        return $query->result();
    }

    function getPaymentCategoryByHId($hospital_id) {
        $query = $this->db->get_where('payment_category', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getPaymentCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('payment_category');
        return $query->row();
    }

    function updatePaymentCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('payment_category', $data);
    }

    function deletePayment($id) {
        $this->db->where('id', $id);
        $this->db->delete('payment');
    }

    function deletePaymentCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('payment_category');
    }

    function insertExpense($data) {
        $this->db->insert('expense', $data);
    }

    function getExpense() {
        $query = $this->db->get('expense');
        return $query->result();
    }

    function getExpenseByHId($hospital_id) {
        $query = $this->db->get_where('expense', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getExpenseById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('expense');
        return $query->row();
    }

    function updateExpense($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('expense', $data);
    }

    function insertExpenseCategory($data) {
        $this->db->insert('expense_category', $data);
    }

    function getExpenseCategory() {
        $query = $this->db->get('expense_category');
        return $query->result();
    }

    function getExpenseCategoryByHId($hospital_id) {
        $query = $this->db->get_where('expense_category', array('hospital_id' => $hospital_id));
        return $query->result();
    }

    function getExpenseCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('expense_category');
        return $query->row();
    }

    function updateExpenseCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('expense_category', $data);
    }

    function deleteExpense($id) {
        $this->db->where('id', $id);
        $this->db->delete('expense');
    }

    function deleteExpenseCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('expense_category');
    }

    function getDiscountTypeByHId($hospital_id) {
        $query = $this->db->get_where('settings', array('hospital_id' => $hospital_id));
        return $query->row()->discount;
    }

    function getPaymentByDate($date_from, $date_to, $hospital_id) {
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('hospital_id', $hospital_id);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getExpenseByDate($date_from, $date_to, $hospital_id) {
        $this->db->select('*');
        $this->db->from('expense');
        $this->db->where('hospital_id', $hospital_id);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function makeStatusPaid($id, $patient_id, $data, $data1) {
        $this->db->where('patient', $patient_id);
        $this->db->where('status', 'paid-last');
        $this->db->update('payment', $data);
        $this->db->where('id', $id);
        $this->db->update('payment', $data1);
    }

    function makePaidByPatientIdByStatus($id, $data, $data1) {
        $this->db->where('patient', $id);
        $this->db->where('status', 'paid-last');
        $this->db->update('payment', $data1);
        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $this->db->update('payment', $data);
    }

}
