<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login_model extends CI_Model {

    public function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    public function authenticate($username, $password) {
        $sql = "SELECT * FROM user u JOIN user_info ui ON u.user_id = ui.user_id WHERE u.username = " . $this->db->escape($username) . " AND u.password = '" . $password . "' AND u.status = 1";
        $query = $this->db->query($sql);

        if ($query->num_rows() == 1) {
            session_start();

            foreach ($query->result() as $row):

                $data = array(
                    'ip_address' => $this->input->ip_address(),
                    'action' => 'Logged-in',
                    'user_id' => $row->user_id,
                );

                $this->db->insert('user_logs', $data);

                $newdata = array(
                    'username' => $row->username,
                    'user_id' => $row->user_id,
                    'first_name' => $row->first_name,
                    'last_name' => $row->last_name,
                    'position' => $row->position,
                    'role' => $row->role,
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($newdata);

                $this->db->set('logged_in', 1);
                $this->db->where('user_id', $this->session->user_id);
                $this->db->update('user');

            endforeach;


            return TRUE;
        }
        return FALSE;
    }

    public function destroy() {
        $data = array(
            'ip_address' => $this->input->ip_address(),
            'action' => 'Logged-out',
            'user_id' => $this->session->user_id,
        );

        $this->db->insert('user_logs', $data);
        $this->db->set('logged_in', 0);
        $this->db->where('user_id', $this->session->user_id);
        $this->db->update('user');
        $this->session->sess_destroy();
    }

}
