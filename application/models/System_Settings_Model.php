<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class System_Settings_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Artifacts_Model');

//        $this->load->model('Users_Model');
    }

    public function getAllSLA() {
        $this->db->select('*');
        $query = $this->db->get('sla')->result();

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function add_sla($data) {
//        prep data
        $data = array(
            'phase' => $data['phase'],
            'description' => $data['description'],
            'warning_hour' => $data['warning_hours'],
            'actual_hour' => $data['actual_hours'],
        );

        $this->db->insert('sla', $data);

        $user_log_data = array(
            'ip_address' => $this->input->ip_address(),
            'action' => $this->session->username . ' added an SLA',
            'user_id' => $this->session->user_id,
        );
        $this->db->insert('user_logs', $user_log_data);
        return TRUE;
    }

    public function delete_sla($data) {
        $this->db->delete('sla', array('sla_id' => $data['sla_id']));

        $user_log_data = array(
            'ip_address' => $this->input->ip_address(),
            'action' => $this->session->username . ' deleted an SLA (SLA ID: ' . $data['sla_id'] . ')',
            'user_id' => $this->session->user_id,
        );
        $this->db->insert('user_logs', $user_log_data);

        return TRUE;
    }

    public function getSLAByID($sla_id) {
        $this->db->select('*');
        $this->db->where('sla_id', $sla_id);
        $query = $this->db->get('sla')->result();

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function edit_sla($data) {
//        print_r($data);
        
        $update = array(
            'phase' => $data['phase'],
            'description' => $data['description'],
            'warning_hour' => $data['warning_hour'],
            'actual_hour' => $data['actual_hour'],
        );
        $this->db->where('sla_id', $data['sla_id']);
        $this->db->update('sla', $update);


        $user_log_data = array(
            'ip_address' => $this->input->ip_address(),
            'action' => $this->session->username . ' modified SLA ID: '.$data['sla_id'],
            'user_id' => $this->session->user_id,
        );
        $this->db->insert('user_logs', $user_log_data);

        return 1;
    }

}
