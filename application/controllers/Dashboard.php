<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dashboard extends CI_Controller {

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
    }

    public function index() {
        $data['title'] = "Dashboard";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();

        $this->load->view('templates/header-nav', $data);
        $this->load->view('dashboard-view', $data);
        $this->load->view('templates/footer-nav', $data);
    }

}
