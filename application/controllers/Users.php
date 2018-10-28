<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Users extends CI_Controller {

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
        $this->load->model('Users_Model');
    }

    public function index() {
        $data['title'] = "People Management";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();

        $this->load->view('templates/header-nav', $data);
        $this->load->view('manage_people_view', $data);
        $this->load->view('templates/footer-nav', $data);
    }

    public function manage_users($success = NULL) {
        $data['title'] = "People Management";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();

        if ($success == 1) {
            $data['success'] = 1;
        } else {
            $data['success'] = 0;
        }


        $data['users'] = $this->Users_Model->getAllUsers();
//        $data['usersg'] = $this->Users_Model->getAllUserswithGroups();

        $this->load->view('templates/header-nav', $data);
        $this->load->view('users_management_view', $data);
        $this->load->view('templates/footer-nav', $data);
    }

    public function add_user_view() {
        $data['title'] = "People Management";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();
        $data['temp'] = array();



        $data['groups'] = $this->Users_Model->getAllGroups();

        $this->load->view('templates/header-nav', $data);
        $this->load->view('add_user_view', $data);
        $this->load->view('templates/footer-nav', $data);
    }

    public function edit_user_view($user_id = NULL, $response = NULL, $pass = NULL) {
        $data['title'] = "People Management";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();
        $data['temp'] = array();

        if ($response == 1) {
            $data['response'] = 1;
        } elseif ($response == 2) {
            $data['response'] = 2;
            $data['pass'] = $pass;
        } elseif ($response == 3) {
            $data['response'] = 3;
        } elseif ($response == 4) {
            $data['response'] = 4;
        } else {
            $data['response'] = NULL;
            $data['pass'] = NULL;
        }


        $data['user'] = $this->Users_Model->getUserByID($user_id);
        $data['group_member'] = $this->Users_Model->getGroupByUserID($user_id);
        $data['groups'] = $this->Users_Model->getAllGroups();

        $this->load->view('templates/header-nav', $data);
        $this->load->view('edit_user_view', $data);
        $this->load->view('templates/footer-nav', $data);
    }

    public function edit_user() {
        $data['title'] = "People Management";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();
        $data['groups'] = $this->Users_Model->getAllGroups();
        $user = $this->Users_Model->getUserByID($this->input->post('user_id'));
        $data['user'] = $this->Users_Model->getUserByID($this->input->post('user_id'));
        $data['group_member'] = $this->Users_Model->getGroupByUserID($this->input->post('user_id'));

        if ($user) {
            $config = array(
                array(
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'trim|required|max_length[12]|alpha_numeric',
                ),
                array(
                    'field' => 'first_name',
                    'label' => 'First Name',
                    'rules' => 'trim|required|max_length[15]',
                ),
                array(
                    'field' => 'last_name',
                    'label' => 'Last Name',
                    'rules' => 'trim|required|max_length[15]',
                ),
                array(
                    'field' => 'position',
                    'label' => 'Position',
                    'rules' => 'trim|required|max_length[30]',
                ),
                array(
                    'field' => 'role',
                    'label' => 'Role',
                    'rules' => 'trim|required|max_length[12]',
                ),
            );


            $this->form_validation->set_rules($config);

            if ($this->form_validation->run()) {
                $response = $this->Users_Model->edit_user($this->input->post(NULL, TRUE));

                print_r($response);
                if ($response) {
                    $this->edit_user_view($this->input->post('user_id'), 1);
                }
            } else {
                $data['sla'] = $this->input->post(NULL);
                $data['response'] = 1;
                $data['pass'] = validation_errors();

                $this->load->view('templates/header-nav', $data);
                $this->load->view('edit_user_view', $data);
                $this->load->view('templates/footer-nav', $data);
            }
        } else {
            echo 'error';
        }
    }

    public function add_user() {
        $data['title'] = "People Management";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();
        $data['groups'] = $this->Users_Model->getAllGroups();
        $config = array(
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required|max_length[12]|alpha_numeric',
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[8]',
            ),
            array(
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'trim|required|min_length[8]|matches[password]',
            ),
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'trim|required|max_length[15]',
            ),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'trim|required|max_length[15]',
            ),
            array(
                'field' => 'position',
                'label' => 'Position',
                'rules' => 'trim|required|max_length[30]',
            ),
            array(
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'trim|required|max_length[12]',
            ),
            array(
                'field' => 'groups[]',
                'label' => 'Groups',
                'rules' => 'trim|required|max_length[30]',
            ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run()) {
            $response = $this->Users_Model->add_user($this->input->post(NULL, TRUE));

            if ($response) {
                $this->manage_users(1);
            }
        } else {
            $data['temp'] = $this->input->post(NULL);


            $this->load->view('templates/header-nav', $data);
            $this->load->view('add_user_view', $data);
            $this->load->view('templates/footer-nav', $data);
        }
    }

    public function resetPassword() {

        if ($this->session->role == 'admin') {

            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 12; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $n_password = implode($pass);
            $new_password = hash('sha256', implode($pass));
            $this->Users_Model->resetPassword($this->input->post('user_id'), $new_password);

            $this->edit_user_view($this->input->post('user_id'), 2, $n_password);
        } else {
            show_error('Unauthorized Request');
        }
    }

    public function EDuser() {
        $this->Users_Model->EDuser($this->input->post('user_id', TRUE), $this->input->post('axion', TRUE));
        if ($this->input->post('axion') == 1) {
            $rep = 4;
        }
        if ($this->input->post('axion') == 0) {
            $rep = 3;
        }

        $this->edit_user_view($this->input->post('user_id'), $rep);
    }

}
