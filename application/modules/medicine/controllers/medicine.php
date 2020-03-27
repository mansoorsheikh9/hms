<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medicine extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->model('medicine_model');
        $this->load->model('settings/settings_model');
        $this->load->model('patient/patient_model');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }

        $data['medicines'] = $this->medicine_model->getMedicineByHId($hospital_id);
        $data['categories'] = $this->medicine_model->getMedicineCategoryByHId($hospital_id);
        $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addMedicineView() {
        $data = array();
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $data['categories'] = $this->medicine_model->getMedicineCategoryByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new_medicine_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewMedicine() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $category = $this->input->post('category');
        $price = $this->input->post('price');
        $quantity = $this->input->post('quantity');
        $generic = $this->input->post('generic');
        $company = $this->input->post('company');
        $effects = $this->input->post('effects');
        $e_date = $this->input->post('e_date');

        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }

        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('medicine', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Price Field
        $this->form_validation->set_rules('price', 'Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
         // Validating Quantity Field
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('generic', 'Generic Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Company Name Field
        $this->form_validation->set_rules('company', 'Company', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Effects Field
        $this->form_validation->set_rules('effects', 'Effects', 'trim|required|min_length[2]|max_length[100]|xss_clean');
         // Validating Expiry date Field
        $this->form_validation->set_rules('e_date', 'Expiry Date', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $this->session->set_flashdata('feedback', 'Invalid Form');
                redirect('medicine/editMedicine?id=' . $id);
            } else {
                $data = array();
                $data['categories'] = $this->medicine_model->getMedicineCategoryByHId($hospital_id);
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new_medicine_view', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            $data = array('name' => $name,
                'category' => $category,
                'price' => $price,
                'quantity' => $quantity,
                'generic' => $generic,
                'company' => $company,
                'effects' => $effects,
                'add_date' => $add_date,
                'hospital_id' => $hospital_id,
                'e_date' => $e_date
            );
            if (empty($id)) {

                $this->medicine_model->insertMedicine($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->medicine_model->updateMedicine($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('medicine');
        }
    }

    function editMedicine() {
        $data = array();
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $data['categories'] = $this->medicine_model->getMedicineCategoryByHId($hospital_id);
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new_medicine_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editMedicineByJason() {
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteMedicine($id);
        redirect('medicine');
    }

    public function medicineCategory() {
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
        $data['categories'] = $this->medicine_model->getMedicineCategoryByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('medicine_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategoryView() {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new_category_view');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewCategory() {
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
            if (!empty($id)) {
                redirect('medicine/editCategory?id=' . $id);
            } else {
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new_category_view');
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description,
                'hospital_id' => $hospital_id
            );
            if (empty($id)) {

                $this->medicine_model->insertMedicineCategory($data);
                 $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->medicine_model->updateMedicineCategory($id, $data);
                 $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('medicine/medicineCategory');
        }
    }

    function editCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineCategoryById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editMedicineCategoryByJason() {
        $id = $this->input->get('id');
        $data['medicinecategory'] = $this->medicine_model->getMedicineCategoryById($id);
        echo json_encode($data);
    }

    function deleteMedicineCategory() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteMedicineCategory($id);
         $this->session->set_flashdata('feedback', 'Trashed');
        redirect('medicine/medicineCategory');
    }

}

/* End of file medicine.php */
/* Location: ./application/modules/medicine/controllers/medicine.php */
