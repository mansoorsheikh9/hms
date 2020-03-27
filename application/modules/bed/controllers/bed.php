<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bed extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->model('bed_model');
        $this->load->model('patient/patient_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Accountant'))) {
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
        $data['beds'] = $this->bed_model->getBedByHId($hospital_id);
        $data['categories'] = $this->bed_model->getBedCategoryByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('bed', $data);
        $this->load->view('home/footer'); // just the header file  
    }

    public function addBedView() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $data = array();
        $data['categories'] = $this->bed_model->getBedCategoryByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_bed_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addBed() {
        $id = $this->input->post('id');
        $number = $this->input->post('number');
        $description = $this->input->post('description');
        $status = $this->input->post('status');
        $category = $this->input->post('category');

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
        // Validating Price Field
        $this->form_validation->set_rules('number', 'Bed Number', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Company Name Field

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $this->session->set_flashdata('feedback', 'Validation Error');
                redirect('bed/editBed?id=' . $id);
            } else {
                $data = array();
                $data['categories'] = $this->bed_model->getBedCategoryByHId($hospital_id);
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_bed_view', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $bed_id = implode('-', array($category, $number));
            $data = array();
            $data = array(
                'category' => $category,
                'number' => $number,
                'description' => $description,
                'bed_id' => $bed_id,
                'hospital_id' => $hospital_id
            );
            if (empty($id)) {
                $this->bed_model->insertBed($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->bed_model->updateBed($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('bed');
        }
    }

    function editBed() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $data = array();
        $data['categories'] = $this->bed_model->getBedCategoryByHId($hospital_id);
        $id = $this->input->get('id');
        $data['bed'] = $this->bed_model->getBedById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_bed_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editBedByJason() {
        $id = $this->input->get('id');
        $data['bed'] = $this->bed_model->getBedById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->bed_model->deleteBed($id);
        $this->session->set_flashdata('feedback', 'Trashed');
        redirect('bed');
    }

    public function bedCategory() {
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

        $data['categories'] = $this->bed_model->getBedCategoryByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('bed_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategoryView() {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_category_view');
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategory() {
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
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $this->session->set_flashdata('feedback', 'Validation Error');
                redirect('bed/editCategory?id=' . $id);
            } else {
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_category_view');
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description,
                'hospital_id' => $hospital_id
            );
            if (empty($id)) {

                $this->bed_model->insertBedCategory($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->bed_model->updateBedCategory($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('bed/bedCategory');
        }
    }

    function editCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['bed'] = $this->bed_model->getbedCategoryById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editCategoryByJason() {
        $id = $this->input->get('id');
        $data['bedcategory'] = $this->bed_model->getBedCategoryById($id);
        echo json_encode($data);
    }

    function deleteBedCategory() {
        $id = $this->input->get('id');
        $this->bed_model->deleteBedCategory($id);
        $this->session->set_flashdata('feedback', 'Trashed');
        redirect('bed/bedCategory');
    }

    function bedAllotment() {

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

        $data['alloted_beds'] = $this->bed_model->getAllotmentByHId($hospital_id);
        $data['beds'] = $this->bed_model->getBedByHId($hospital_id);
        $data['patients'] = $this->patient_model->getPatientByHId($hospital_id);

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('bed_allotment', $data);
        $this->load->view('home/footer'); // just 
    }

    function addAllotmentView() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->patient_model->getHospitalId($current_user_id);
        }
        $data = array();
        $data['beds'] = $this->bed_model->getBedByHId($hospital_id);
        $data['patients'] = $this->patient_model->getPatientByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_allotment_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addAllotment() {
        $id = $this->input->post('id');
        $patient = $this->input->post('patient');
        $a_time = $this->input->post('a_time');
        $d_time = $this->input->post('d_time');
        $status = $this->input->post('status');
        $bed_id = $this->input->post('bed_id');

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
        $this->form_validation->set_rules('bed_id', 'Bed', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Alloted Time Field
        $this->form_validation->set_rules('a_time', 'Alloted Time', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Discharge Time Field
        $this->form_validation->set_rules('d_time', 'Discharge Time', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Status Field
        $this->form_validation->set_rules('status', 'Status', 'trim|min_length[2]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['beds'] = $this->bed_model->getBedByHId($hospital_id);
            $data['patients'] = $this->patient_model->getPatientByHId($hospital_id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_allotment_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array(
                'bed_id' => $bed_id,
                'patient' => $patient,
                'a_time' => $a_time,
                'd_time' => $d_time,
                'status' => $status,
                'hospital_id' => $hospital_id
            );
            $data1 = array(
                'last_a_time' => $a_time,
                'last_d_time' => $d_time,
                'hospital_id' => $hospital_id
            );

            if (empty($id)) {

                $this->bed_model->insertAllotment($data);
                $this->bed_model->updateBedByBedId($bed_id, $data1);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->bed_model->updateAllotment($id, $data);
                $this->bed_model->updateBedByBedId($bed_id, $data1);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('bed/bedAllotment');
        }
    }

    function editAllotment() {
        $data = array();
        $data['beds'] = $this->bed_model->getBed();
        $data['patients'] = $this->patient_model->getPatient();
        $id = $this->input->get('id');
        $data['allotment'] = $this->bed_model->getAllotmentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_allotment_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editAllotmentByJason() {
        $id = $this->input->get('id');
        $data['allotment'] = $this->bed_model->getAllotmentById($id);
        echo json_encode($data);
    }

    function deleteAllotment() {
        $id = $this->input->get('id');
        $this->bed_model->deleteBedAllotment($id);
        $this->session->set_flashdata('feedback', 'Trashed');
        redirect('bed/bedAllotment');
    }

}

/* End of file bed.php */
/* Location: ./application/modules/bed/controllers/bed.php */
