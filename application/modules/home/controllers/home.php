<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('ion_auth_model');
        $this->load->library('upload');
        $this->load->model('settings/settings_model');
        $this->load->model('report/report_model');
        $this->load->model('hospital/hospital_model');
        $this->load->model('patient/patient_model');

        $this->load->model('home_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index() {
        $data = array();
        if (!$this->ion_auth->in_group('superadmin')) {
            if ($this->ion_auth->in_group(array('admin'))) {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
            } else {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $hospital_id = $this->patient_model->getHospitalId($current_user_id);
            }
            $data['hospital_id'] = $hospital_id;
            $data['current_user_id'] = $current_user_id;
            $data['settings'] = $this->settings_model->getSettingsByHId($hospital_id);
            $data['sum'] = $this->home_model->getSum('gross_total', 'payment', $hospital_id);
        } else {
            $data['hospitals'] = $this->hospital_model->getHospital();
        }
        if ($this->ion_auth->in_group('Patient')) {

            $data['reports'] = $this->report_model->getReport();
            $data['user_id_for_report'] = $this->ion_auth->user()->row()->id;
        }
        $this->load->view('dashboard'); // just the header file
        $this->load->view('home', $data);
        $this->load->view('footer');
    }

    public function permission() {
        $this->load->view('permission');
    }

}

/* End of file home.php */
/* Location: ./application/modules/home/controllers/home.php */
