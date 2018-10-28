<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Status_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

//        $this->load->model('Users_Model');
    }

    public function getStatus() {
        $sql = "SELECT * FROM status";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getStatusByID($id) {
        $this->db->select('*');
        $this->db->where('status_id', $id);
        $query = $this->db->get('status')->result();

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

}
