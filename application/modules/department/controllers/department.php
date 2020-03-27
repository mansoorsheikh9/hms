<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('department_model');
        $this->load->library('upload');
        $this->load->model('ion_auth_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group('admin')) {
            redirect('home/permission');
        }
    }

    public function index() {
        $current_user_id = $this->ion_auth->user()->row()->id;
        $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        $data['departments'] = $this->department_model->getDepartmentByHId($hospital_id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('department', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $current_user_id = $this->ion_auth->user()->row()->id;
        $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Password Field    
        // Validating Email Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[1000]|xss_clean');
        // Validating Address Field   
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect('department/editDepartment?id=' . $id);
            } else {
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            $data = array(
                'name' => $name,
                'description' => $description,
                'hospital_id' => $hospital_id
            );
            if (empty($id)) {     // Adding New department
                $this->department_model->insertDepartment($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else { // Updating department
                $this->department_model->updateDepartment($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('department');
        }
    }

    function getDepartment() {
        $data['departments'] = $this->department_model->getDepartment();
        $this->load->view('department', $data);
    }

    function editDepartment() {
        $data = array();
        $id = $this->input->get('id');
        $data['department'] = $this->department_model->getDepartmentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editDepartmentByJason() {
        $id = $this->input->get('id');
        $data['department'] = $this->department_model->getDepartmentById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->department_model->delete($id);
        $this->session->set_flashdata('feedback', 'Trashed');
        redirect('department');
    }

}

/* End of file department.php */
/* Location: ./application/modules/department/controllers/department.php */
