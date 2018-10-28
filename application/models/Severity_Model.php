<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Severity_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

//        $this->load->model('Users_Model');
    }

    public function getSeverity() {
        $sql = "SELECT * FROM severity";
        $query = $this->db->query($sql);

        return $query->result();
    }

}
