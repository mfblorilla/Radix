<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Users_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function getAllGroups() {
        $sql = "SELECT * FROM groups ORDER BY group_id ASC";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getAllGroups2() {
        
    }

    public function getUserByID($id) {
        $this->db->select('user.user_id,user.username,user_info.first_name,user_info.last_name,user_info.position,user_info.role,user.status');
        $this->db->join('user_info', 'user.user_id = user_info.user_id');
        $this->db->where('user.user_id', $id);
        $query = $this->db->get('user')->result();
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getGroupByUserID($user_id) {
        if ($user_id) {
            $this->db->select('groups.group_id, groups.name as group_name, groups.description as group_description');
            $this->db->join('group_member', 'groups.group_id = group_member.group_id');
            $this->db->where('group_member.user_id', $user_id);
            $query = $this->db->get('groups')->result();
            if ($query) {
                return $query;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function getGroupByID($id) {
        $this->db->select('*');
        $this->db->where('group_id', $id);
        $query = $this->db->get('groups')->result();

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getAllUsers() {
        $this->db->select('user.user_id,user.username,user_info.first_name,user_info.last_name,user_info.position,user_info.role,user.status');
        $this->db->join('user_info', 'user.user_id = user_info.user_id');
        $query = $this->db->get('user')->result();
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getAllUsersE() {
        $this->db->select('user.user_id,user.username,user_info.first_name,user_info.last_name,user_info.position,user_info.role,user.status');
        $this->db->join('user_info', 'user.user_id = user_info.user_id');
        $this->db->where('status !=', 0);
        $query = $this->db->get('user')->result();
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getAllUserswithGroups() {
        $this->db->select('user.user_id, user.username, user_info.first_name, user_info.last_name, user_info.position, user_info.role, groups.name as group_name, groups.description as group_description');
        $this->db->join('user_info', 'user.user_id = user_info.user_id', 'left');
        $this->db->join('group_member', 'user.user_id = group_member.user_id', 'left');
        $this->db->join('groups', 'group_member.group_id = groups.group_id', 'left');
        $query = $this->db->get('user')->result();
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getGroupsInvolvedByIncidentID($incident_id) {
        $this->db->select('groups.name, groups.description, groups_involved.group_id, groups_involved.incident_id');
        $this->db->join('groups', 'groups_involved.group_id = groups.group_id');
        $this->db->where('groups_involved.incident_id', $incident_id);
        $query = $this->db->get('groups_involved')->result();
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function add_user($data) {
        //prep data
        $password = hash('sha256', $data['password']);
        $user_tbl = array(
            'username' => $data['username'],
            'password' => $password,
        );

        // insert user data
        $this->db->insert('user', $user_tbl);

        $sql = 'SELECT * FROM user';
        $query_user = $this->db->query($sql);
        $last_user = $query_user->last_row();

        $userinfo_tbl = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'position' => $data['position'],
            'role' => $data['role'],
            'user_id' => $last_user->user_id,
        );

        $this->db->insert('user_info', $userinfo_tbl);
        $group_mem_tbl = array();

        for ($x = 0; $x < count($data['groups']); $x++) {
            $temp = array(
                'user_id' => $last_user->user_id,
                'group_id' => $data['groups'][$x],
            );
            array_push($group_mem_tbl, $temp);
        }

        $this->db->insert_batch('group_member', $group_mem_tbl);

        $user_log_data = array(
            'ip_address' => $this->input->ip_address(),
            'action' => $this->session->username . ' added a user with username: ' . $data['username'],
            'user_id' => $this->session->user_id,
        );
        $this->db->insert('user_logs', $user_log_data);
        return TRUE;
    }

    public function edit_user($data) {

        $user_info = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'position' => $data['position'],
            'role' => $data['role'],
        );

        $this->db->where('user_id', $data['user_id']);
        $this->db->update('user_info', $user_info);

        $user = array(
            'username' => $data['username'],
        );
        $this->db->where('user_id', $data['user_id']);
        $this->db->update('user', $user);

        $response = $this->getUserByID($data['user_id']);
        $user_log_data = array(
            'ip_address' => $this->input->ip_address(),
            'action' => $this->session->username . ' edited User Account: ' . $response[0]->user_id . ' - ' . $response[0]->username,
            'user_id' => $this->session->user_id,
        );
        $this->db->insert('user_logs', $user_log_data);

        return 1;
    }

    public function resetPassword($user_id, $password) {
        $this->db->set('password', $password);
        $this->db->where('user_id', $user_id);
        $this->db->update('user');

        $response = $this->getUserByID($user_id);
        $user_log_data = array(
            'ip_address' => $this->input->ip_address(),
            'action' => $this->session->username . ' performed reset password on username: ' . $response[0]->username,
            'user_id' => $this->session->user_id,
        );
        $this->db->insert('user_logs', $user_log_data);
    }

    public function EDuser($user_id, $action) {
        $this->db->set('status', $action);
        $this->db->where('user_id', $user_id);
        $this->db->update('user');

        if ($action == 1) {
            $rep = 'enabled';
        } else {
            $rep = 'disabled';
        }


        $response = $this->getUserByID($user_id);
        $user_log_data = array(
            'ip_address' => $this->input->ip_address(),
            'action' => $this->session->username . ' ' . $rep . ' a user account with username: ' . $response[0]->username,
            'user_id' => $this->session->user_id,
        );
        $this->db->insert('user_logs', $user_log_data);
    }

}
