<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class System_Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
// Load form helper library
        $this->load->helper('form');
// Load form validation library
        $this->load->library('form_validation');
// Load session library
        $this->load->library('session');

// Load URL Helper
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->helper('timeago');
        $this->load->helper('date');

//Load database
        $this->load->model('Incident_Model');
        $this->load->model('Artifacts_Model');
        $this->load->model('Status_Model');
        $this->load->model('Severity_Model');
        $this->load->model('Priority_Model');
        $this->load->model('Users_Model');
        $this->load->model('Others_Model');
        $this->load->model('Verdict_Model');
        $this->load->model('System_Settings_Model');
    }

    public function index() {
        $data['title'] = "System Settings";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();


        $data['base_url'] = base_url();
        $data['nav'] = uri_string();

        $this->load->view('templates/header-nav', $data);
        $this->load->view('system_settings_view', $data);
        $this->load->view('templates/footer-nav', $data);
    }

    public function SLA_View($response = NULL) {
        $data['title'] = "SLA Settings";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();

        $data['sla'] = $this->System_Settings_Model->getAllSLA();

        if ($response == 1) {
            $data['response'] = 1;
        } elseif ($response == 2) {
            $data['response'] = 2;
        } else {
            $data['response'] = 0;
        }




        $this->load->view('templates/header-nav', $data);
        $this->load->view('sla_view', $data);
        $this->load->view('templates/footer-nav', $data);
    }

    public function add_sla_view() {
        $data['title'] = "Add SLA";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();

        $this->load->view('templates/header-nav', $data);
        $this->load->view('add_sla_view', $data);
        $this->load->view('templates/footer-nav', $data);
    }

    public function add_sla() {
        $config = array(
            array(
                'field' => 'phase',
                'label' => 'Phase Name',
                'rules' => 'trim|required|max_length[30]|alpha_numeric_spaces',
            ),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|required|max_length[250]|alpha_numeric_spaces',
            ),
            array(
                'field' => 'warning_hours',
                'label' => 'Warning Hours',
                'rules' => 'trim|required|max_length[4]|numeric',
            ),
            array(
                'field' => 'actual_hours',
                'label' => 'Actual Hours',
                'rules' => 'trim|required|max_length[4]|numeric',
            ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run()) {
            $response = $this->System_Settings_Model->add_sla($this->input->post(NULL));
            if ($response) {
                $this->SLA_View(1);
            }
        } else {
            $data['temp'] = $this->input->post(NULL);
            $data['title'] = "Add SLA";
            $data['base_url'] = base_url();
            $data['nav'] = uri_string();


            $this->load->view('templates/header-nav', $data);
            $this->load->view('add_sla_view', $data);
            $this->load->view('templates/footer-nav', $data);
        }
    }

    public function delete_sla() {
//        print_r($this->input->post());
        $config = array(
            array(
                'field' => 'sla_id',
                'label' => 'SLA ID',
                'rules' => 'trim|required|max_length[3]|numeric',
            ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run()) {
            $response = $this->System_Settings_Model->delete_sla($this->input->post(NULL));
            if ($response) {
                echo json_encode(2);
            }
        } else {
            echo 'error!';
            echo validation_errors();
        }
    }

    public function edit_sla_view($sla_id = NULL, $response = NULL, $errors = NULL) {
        $data['title'] = "Edit SLA";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();

        if ($response) {
            $data['response'] = 1;
        } else {
            $data['response'] = 0;
        }

        $data['sla'] = $this->System_Settings_Model->getSLAByID($sla_id);

        $this->load->view('templates/header-nav', $data);
        $this->load->view('edit_sla_view', $data);
        $this->load->view('templates/footer-nav', $data);
    }

    public function edit_sla() {
//        print_r($this->input->post());

        $config = array(
            array(
                'field' => 'sla_id',
                'label' => 'SLA ID',
                'rules' => 'trim|required|max_length[2]|numeric',
            ),
            array(
                'field' => 'phase',
                'label' => 'Phase Name',
                'rules' => 'trim|required|max_length[30]|alpha_numeric_spaces',
            ),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|required|max_length[250]',
            ),
            array(
                'field' => 'warning_hour',
                'label' => 'Warning Hour',
                'rules' => 'trim|required|max_length[4]|numeric',
            ),
            array(
                'field' => 'actual_hour',
                'label' => 'Actual Hour',
                'rules' => 'trim|required|max_length[4]|numeric',
            ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run()) {
            $response = $this->System_Settings_Model->edit_sla($this->input->post(NULL));
            if ($response == 1) {
                $this->edit_sla_view($this->input->post('sla_id'), $response);
            } else {
                show_404();
            }
        } else {
            $this->edit_sla_view($this->input->post('sla_id'), NULL, validation_errors());
        }
    }

}
