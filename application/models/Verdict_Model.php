<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Verdict_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function getAllVerdict() {
        $this->db->select('*');
        $query = $this->db->get('verdict')->result();

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

}
