<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_Authentication extends CI_Controller {

    public function __construct() {
        parent::__construct();

// Load form helper library
        $this->load->helper('form');

// Load form validation library
        $this->load->library('form_validation');

// Load session library
        $this->load->library('session');

// Load database
        $this->load->model('Login_model');
// Load URL Helper
        $this->load->helper('url');
    }

    public function index($var = NULL) {
        $data['title'] = "Radix - Incident Management";
        $data['base_url'] = base_url();
        $data['msg'] = $var;
        $this->load->view('templates/header-login', $data);
        $this->load->view('login_form', $data);
        $this->load->view('templates/footer-login');
    }

    public function login() {

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('username', 'Username', 'max_length[12]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password', 'Password', 'max_length[30]');


        if ($this->form_validation->run() == FALSE) {
            $var = 'Invalid login';
            $this->index($var);
        } else {
            $username = $this->input->post('username', TRUE);
            $password = hash('sha256', $this->input->post('password'));
            $value = $this->Login_model->authenticate($username, $password);


            if (!$value) {

                $var = 'Invalid login';
                $this->index($var);
            } else {
                redirect('Dashboard');
            }
        }
    }

    public function logout() {
        $this->Login_model->destroy();
        redirect('');
    }

}
