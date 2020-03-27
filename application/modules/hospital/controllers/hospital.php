<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hospital extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('hospital_model');
        $this->load->library('upload');
        $this->load->model('ion_auth_model');
        $this->load->model('settings/settings_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group('superadmin')) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data['hospitals'] = $this->hospital_model->getHospital();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('hospital', $data);
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
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[5]|max_length[50]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("hospital/editHospital?id=$id");
            } else {
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'phone' => $phone
            );

            $username = $this->input->post('name');

            if (empty($id)) {     // Adding New Hospital
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', 'This Email Address Is Already Registered');
                    redirect('hospital/addNewView');
                } else {
                    $dfg = 10;
                    $this->ion_auth->register($username, $password, $email, $dfg);
                    $user_id = $this->db->insert_id();
                    $ion_user_id = $this->db->get_where('users_groups', array('id' => $user_id))->row()->user_id;
                    $this->hospital_model->insertHospital($data);
                    $hospital_user_id = $this->db->insert_id();
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->hospital_model->updateHospital($hospital_user_id, $id_info);
                    $hospital_settings_data = array();
                    $hospital_settings_data = array('hospital_id' => $hospital_user_id,
                        'title' => $name,
                        'email' => $email,
                        'address' => $address,
                        'phone' => $phone,
                        'system_vendor' => 'Code Aristos | Hospital management System',
                        'discount' => 'flat',
                        'currency' => '$'
                        
                        );
                    $this->settings_model->insertSettings($hospital_settings_data);
                     $this->session->set_flashdata('feedback', 'New Hospital Created');
                }
            } else { // Updating Hospital
                $ion_user_id = $this->db->get_where('hospital', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->hospital_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->hospital_model->updateHospital($id, $data);
                 $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('hospital');
        }
    }

    function getHospital() {
        $data['hospitals'] = $this->hospital_model->getHospital();
        $this->load->view('hospital', $data);
    }

    function editHospital() {
        $data = array();
        $id = $this->input->get('id');
        $data['hospital'] = $this->hospital_model->getHospitalById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editHospitalByJason() {
        $id = $this->input->get('id');
        $data['hospital'] = $this->hospital_model->getHospitalById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('hospital', array('id' => $id))->row();
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->hospital_model->delete($id);
        redirect('hospital');
    }

}

/* End of file hospital.php */
/* Location: ./application/modules/hospital/controllers/hospital.php */
