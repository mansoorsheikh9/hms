<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->model('finance_model');
        $this->load->model('patient/patient_model');
        $this->load->model('settings/settings_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Accountant'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        redirect('finance/financialReport');
    }

    public function payment() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $data['discount_type'] = $this->finance_model->getDiscountTypeByHId($hospital_id);
        $data['categories'] = $this->finance_model->getPaymentCategoryByHId($hospital_id);
        $data['patients'] = $this->patient_model->getPatientByHId($hospital_id);
        $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
        $data['payments'] = $this->finance_model->getPaymentByHId($hospital_id);

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentView() {
        $data = array();
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $data['discount_type'] = $this->finance_model->getDiscountTypeByHId($hospital_id);
        $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
        $data['categories'] = $this->finance_model->getPaymentCategoryByHId($hospital_id);
        $data['patients'] = $this->patient_model->getPatientByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_payment_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPayment() {
        $id = $this->input->post('id');
        $amount_by_category = $this->input->post('category_amount');
        $category_selected = $this->input->post('category_name');
        $cat_val = array_combine($category_selected, $amount_by_category);
        foreach ($cat_val as $key => $value) {
            $category_name[] = $key . '*' . $value;
        }
        $category_name = implode(',', $category_name);
        $patient = $this->input->post('patient');
        $date = time();
        $vat = $this->input->post('vat');
        $discount = $this->input->post('discount');



        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Field
        // $this->form_validation->set_rules('category_amount[]', 'Category', 'min_length[1]|max_length[100]');
        // Validating Price Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('vat', 'Vat', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('finance/addPaymentView');
            // redirect('accountant/add_new'); 
        } else {
            $amount = array_sum($amount_by_category);
            $discount_type = $this->finance_model->getDiscountTypeByHId($hospital_id);

            if ($discount_type == 'flat') {
                $amount_with_discount = $amount - $discount;
                $gross_total = $amount_with_discount + $amount_with_discount * ($vat / 100);
                $flat_discount = $discount;
                $flat_vat = $amount_with_discount * ($vat / 100);
            } else {
                $flat_discount = $amount * ($discount / 100);
                $amount_with_discount = $amount - $amount * ($discount / 100);
                $gross_total = $amount_with_discount + $amount_with_discount * ($vat / 100);
                $discount = $discount . '*' . $amount * ($discount / 100);
                $flat_vat = $amount_with_discount * ($vat / 100);
            }

            $data = array();

            if (empty($id)) {
                $data = array(
                    'category_name' => $category_name,
                    'patient' => $patient,
                    'date' => $date,
                    'amount' => $amount,
                    'vat' => $vat,
                    'flat_vat' => $flat_vat,
                    'discount' => $discount,
                    'flat_discount' => $flat_discount,
                    'gross_total' => $gross_total,
                    'status' => 'unpaid',
                    'hospital_id' => $hospital_id
                );
                $this->finance_model->insertPayment($data);
                $inserted_id = $this->db->insert_id();
                $this->session->set_flashdata('feedback', 'Payment Added');
                redirect("finance/invoice?id=" . "$inserted_id");
            } else {
                $data = array(
                    'category_name' => $category_name,
                    'patient' => $patient,
                    'amount' => $amount,
                    'vat' => $vat,
                    'flat_vat' => $flat_vat,
                    'discount' => $discount,
                    'flat_discount' => $flat_discount,
                    'gross_total' => $gross_total,
                    'hospital_id' => $hospital_id
                );
                $this->finance_model->updatePayment($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
                redirect("finance/invoice?id=" . "$id");
            }
        }
    }

    function editPayment() {
        if ($this->ion_auth->in_group(array('admin', 'Accountant'))) {
            $data = array();
            if ($this->ion_auth->in_group(array('admin'))) {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
            } else {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $hospital_id = $this->patient_model->getHospitalId($current_user_id);
            }
            $data['discount_type'] = $this->finance_model->getDiscountTypeByHId($hospital_id);
            $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
            $data['categories'] = $this->finance_model->getPaymentCategoryByHId($hospital_id);
            $data['patients'] = $this->patient_model->getPatientByHId($hospital_id);
            $id = $this->input->get('id');
            $data['payment'] = $this->finance_model->getPaymentById($id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_payment_view', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function editPaymentByJason() {
        $id = $this->input->get('id');
        $data['payment'] = $this->accountant_model->getPaymentById($id);
        echo json_encode($data);
    }

    function delete() {
        if ($this->ion_auth->in_group('admin')) {
            $id = $this->input->get('id');
            $this->finance_model->deletePayment($id);
            $this->session->set_flashdata('feedback', 'Trashed');
            redirect('finance/payment');
        }
    }

    public function paymentCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $data['categories'] = $this->finance_model->getPaymentCategoryByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('payment_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentCategoryView() {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_payment_category');
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_payment_category');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description,
                'hospital_id' => $hospital_id
            );
            if (empty($id)) {
                $this->finance_model->insertPaymentCategory($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->finance_model->updatePaymentCategory($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('finance/paymentCategory');
        }
    }

    function editPaymentCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['category'] = $this->finance_model->getPaymentCategoryById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_payment_category', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editPaymentCategoryByJason() {
        $id = $this->input->get('id');
        $data['category'] = $this->finance_model->getPaymentCategoryById($id);
        echo json_encode($data);
    }

    function deletePaymentCategory() {
        $id = $this->input->get('id');
        $this->finance_model->deletePaymentCategory($id);
        $this->session->set_flashdata('feedback', 'Trashed');
        redirect('finance/paymentCategory');
    }

    public function expense() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }

        $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
        $data['categories'] = $this->finance_model->getExpenseCategoryByHId($hospital_id);
        $data['expenses'] = $this->finance_model->getExpenseByHId($hospital_id);

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('expense', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseView() {
        $data = array();

        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }

        $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
        $data['categories'] = $this->finance_model->getExpenseCategoryByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_expense_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpense() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $date = time();
        $amount = $this->input->post('amount');

        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Company Name Field

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect('finance/editExpense?id=' . $id);
            } else {
                $data = array();
                $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
                $data['categories'] = $this->finance_model->getExpenseCategoryByHId($hospital_id);
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_expense_view', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            if (empty($id)) {
                $data = array(
                    'category' => $category,
                    'date' => $date,
                    'amount' => $amount,
                    'hospital_id' => $hospital_id
                );
            } else {
                $data = array(
                    'category' => $category,
                    'amount' => $amount,
                    'hospital_id' => $hospital_id
                );
            }
            if (empty($id)) {

                $this->finance_model->insertExpense($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->finance_model->updateExpense($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('finance/expense');
        }
    }

    function editExpense() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $data = array();
        $data['categories'] = $this->finance_model->getExpenseCategory();
        $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
        $id = $this->input->get('id');
        $data['expense'] = $this->finance_model->getExpenseById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_expense_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editExpenseByJason() {
        $id = $this->input->get('id');
        $data['expense'] = $this->finance_model->getExpenseById($id);
        echo json_encode($data);
    }

    function deleteExpense() {
        $id = $this->input->get('id');
        $this->finance_model->deleteExpense($id);
        $this->session->set_flashdata('feedback', 'Trashed');
        redirect('finance/expense');
    }

    public function expenseCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }

        $data['categories'] = $this->finance_model->getExpenseCategoryByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('expense_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseCategoryView() {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_expense_category');
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_expense_category');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description,
                'hospital_id' => $hospital_id
            );
            if (empty($id)) {

                $this->finance_model->insertExpenseCategory($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->finance_model->updateExpenseCategory($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('finance/expenseCategory');
        }
    }

    function editExpenseCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['category'] = $this->finance_model->getExpenseCategoryById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_expense_category', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editExpenseCategoryByJason() {
        $id = $this->input->get('id');
        $data['category'] = $this->finance_model->getExpenseCategoryById($id);
        echo json_encode($data);
    }

    function deleteExpenseCategory() {
        $id = $this->input->get('id');
        $this->finance_model->deleteExpenseCategory($id);
        $this->session->set_flashdata('feedback', 'Trashed');
        redirect('finance/expenseCategory');
    }

    function invoice() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
        $data['discount_type'] = $this->finance_model->getDiscountTypeByHId($hospital_id);
        $data['payment'] = $this->finance_model->getPaymentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function invoicePatientTotal() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
        $data['discount_type'] = $this->finance_model->getDiscountTypeByHId($hospital_id);
        $data['payments'] = $this->finance_model->getPaymentByPatientIdByStatus($id);
        $data['patient_id'] = $id;
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('invoicePT', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function lastPaidInvoice() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
        $data['discount_type'] = $this->finance_model->getDiscountTypeByHId($hospital_id);
        $data['payments'] = $this->finance_model->lastPaidInvoice($id);
        $data['patient_id'] = $id;
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('LPInvoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function makePaid() {
        $id = $this->input->get('id');
        $patient_id = $this->finance_model->getPaymentById($id)->patient;
        $data = array();
        $data = array('status' => 'paid');
        $data1 = array();
        $data1 = array('status' => 'paid-last');
        $this->finance_model->makeStatusPaid($id, $patient_id, $data, $data1);
        $this->session->set_flashdata('feedback', 'Paid');
        redirect('finance/invoice?id=' . $id);
    }

    function makePaidByPatientIdByStatus() {
        $id = $this->input->get('id');
        $data = array();
        $data = array('status' => 'paid-last');
        $data1 = array();
        $data1 = array('status' => 'paid');
        $this->finance_model->makePaidByPatientIdByStatus($id, $data, $data1);
        $this->session->set_flashdata('feedback', 'Paid');
        redirect('patient');
    }

    function financialReport() {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        $data = array();

        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }

        $data['payment_categories'] = $this->finance_model->getPaymentCategoryByHId($hospital_id);
        $data['expense_categories'] = $this->finance_model->getExpenseCategoryByHId($hospital_id);

        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to, $hospital_id);
        $data['expenses'] = $this->finance_model->getExpenseByDate($date_from, $date_to, $hospital_id);

        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('financial_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

}

/* End of file finance.php */
/* Location: ./application/modules/finance/controllers/finance.php */
