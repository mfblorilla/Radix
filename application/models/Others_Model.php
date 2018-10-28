<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Others_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

//        $this->load->model('Users_Model');
    }

    public function loadCountries() {
        $this->db->select('*');
        $query = $this->db->get('country')->result();
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

}
