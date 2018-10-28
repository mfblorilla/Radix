<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Incident_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Artifacts_Model');

//        $this->load->model('Users_Model');
    }

    public function getIncidentType_All() {
        $sql = "SELECT * FROM incident_type ORDER BY name ASC";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getIncidentTypeByID($id) {
        $this->db->select('*');
        $this->db->where('incident_type_id', $id);
        $query = $this->db->get('incident_type')->result();
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function add_incident($status, $incident_type, $description, $maximo_incident_id, $offense_id, $offense_start, $severity, $priority, $groups_involved, $notes) {

        // prep data
        date_default_timezone_set('Asia/Manila');

        $date = date("Y-m-d H:i:s");




        $create_date = date_create($offense_start);
        $new_date = date_format($create_date, "Y-m-d H:i:s");
        if ($status == 0) {
            $status = 1;
        }


        // insert data
        $incident_data = array(
            'status_id' => $status,
            'incident_type_id' => $incident_type,
            'description' => $description,
            'maximo_incident_id' => $maximo_incident_id,
            'offense_id' => $offense_id,
            'offense_start' => $new_date,
            'severity_id' => $severity,
            'priority_id' => $priority,
            'notes' => $notes,
            'date_created' => $date,
            'user_id' => $this->session->user_id,
        );


        $this->db->insert('incidents', $incident_data); //insert incident data

        $sql = "SELECT * FROM incidents";
        $query_incident = $this->db->query($sql);
        $last_row = $query_incident->last_row(); //query latest inserted incident

        for ($x = 0; $x <= count($groups_involved) - 1; $x++) {
            $grps_invlvd = array(
                'group_id' => $groups_involved[$x],
                'incident_id' => $last_row->incident_id,
            );

            $this->db->insert('groups_involved', $grps_invlvd);
        } // insert groups_involved (for loop)

        $incident_log_data = array(
            'incident_id' => $last_row->incident_id,
            'content' => 'Incident created by ' . $this->session->first_name . ' ' . $this->session->last_name,
        );

        $this->db->insert('incident_log', $incident_log_data); // insert to incident_log


        $user_log_data = array(
            'ip_address' => $this->input->ip_address(),
            'action' => $this->session->username . ' created incident_id - ' . $last_row->incident_id . ' with maximo_incident_id of ' . $maximo_incident_id,
            'user_id' => $this->session->user_id,
        );

        $this->db->insert('user_logs', $user_log_data);

        return $last_row->incident_id;
    }

// end of add_incident function
    public function add_incident_artifacts($data) {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d H:i:s");
        $log = array();
        $artifacts = $this->Artifacts_Model->getIncidentArtifactByIncidentType($data['incident_type_id']);

        $artifact_data = array();

        foreach ($artifacts as $row) {
            $temp = array();
            $temp['artifact_id'] = $row->artifact_id;
            $temp['incident_id'] = $data['incident_id'];
            if ($row->artifact_id == 54) {
                $temp['value'] = $data['source_ip_address'] . ' - ' . $data['source_geolocation'];
            } else {
                $temp['value'] = $data[$row->code];
            }
            $temp['created_date'] = $date;
            array_push($artifact_data, $temp);
        } // end of foreach
        $this->db->insert_batch('incident_artifacts', $artifact_data);


        $message = $this->session->first_name . ' ' . $this->session->last_name . ' added artifacts to this incident.';
        array_push($log, $message);

        $this->add_incident_log($data['incident_id'], $log);
//        return $artifact_data;
    }

    public function add_incident_log($incident_id, $logs) {
        $data = array();

        if ($logs) {

            foreach ($logs as $log) {
                $temp = array(
                    'incident_id' => $incident_id,
                    'content' => $log,
                );

                array_push($data, $temp);
            }
            $this->db->insert_batch('incident_log', $data);
//            print_r($logs);
        }
    }

    public function update_incident($data) {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d H:i:s");
        $nice_date = nice_date($data['change_status_datetime'], 'Y-m-d H:i:s');
        $update = array();

        if ($data['prev_status'] != $data['status']) {
            if ($data['status'] == 3) {
                $update['date_triaged'] = $nice_date;
                $update['system_date_triaged'] = $date;
            } elseif ($data['status'] == 5) {
                $update['date_resolved'] = $nice_date;
                $update['system_date_resolved'] = $date;
            } elseif ($data['status'] == 6) {
                $update['date_closed'] = $nice_date;
                $update['system_date_closed'] = $date;
            }

            $update['status_id'] = $data['status'];
        }

        if ($data['prev_severity'] != $data['severity']) {
            $update['severity_id'] = $data['severity'];
        }

        if ($data['prev_priority'] != $data['priority']) {
            $update['priority_id'] = $data['priority'];
        }

        if ($data['prev_verdict'] != $data['verdict']) {
            $update['verdict_id'] = $data['verdict'];
        }

        if ($data['prev_offense_id'] != $data['offense_id']) {
            $update['offense_id'] = $data['offense_id'];
        }
        if ($data['prev_description'] != $data['description']) {
            $update['description'] = $data['description'];
        }

        if ($data['prev_assigned'] != $data['assigned']) {
            if ($data['assigned'] != 0) {
                $respond = $this->getAssignedUser($data['incident_id']);
                if ($respond) {
                    $temp = array(
                        'user_id' => $data['assigned'],
                        'incident_id' => $data['incident_id'],
                    );
                    $this->db->where('incident_id', $data['incident_id']);
                    $this->db->update('incident_assignment', $temp);
                } else {
                    $temp = array(
                        'user_id' => $data['assigned'],
                        'incident_id' => $data['incident_id'],
                    );
                    $this->db->insert('incident_assignment', $temp);
                }
            }
        }

        if ($update) {
            $this->db->where('incident_id', $data['incident_id']);
            $this->db->update('incidents', $update);
        }
//        print_r($update);
    }

    public function getIncidentByID($incident_id) {

        $this->db->select('*');
//        $this->db->from('incidents');
//        $this->db->join('incident_artifacts', 'incidents.incident_id = incident_artifacts.incident_id', 'left');
        $this->db->join('groups_involved', 'incidents.incident_id = groups_involved.incident_id', 'left');
        $this->db->join('incident_task', 'incidents.incident_id = incident_task.incident_id', 'left');
        $this->db->join('incident_log', 'incidents.incident_id = incident_log.incident_id', 'left');
        $this->db->where('incidents.incident_id', $incident_id);
        $query = $this->db->get('incidents')->result();

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getIncidentLogByID($id) {
        $this->db->select('*');
        $this->db->where('incident_id', $id);
        $query = $this->db->get('incident_log')->result();
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getIncidentArtifactsByID($id) {
        $this->db->distinct();
        $this->db->select('artifacts.artifact_id, artifacts.name, artifacts.description, artifacts.created_date as created_date_artifact, incident_artifacts.incident_artifact_id, incident_artifacts.value, incident_artifacts.created_date as created_date_incident, incident_artifacts.incident_id ');
        $this->db->join('artifacts', 'incident_artifacts.artifact_id = artifacts.artifact_id');
//        $this->db->join('incident_template_artifact', 'artifacts.artifact_id = incident_template_artifact.artifact_id');
        $this->db->where('incident_artifacts.incident_id', $id);
        $this->db->order_by('artifacts.name', 'ASC');
        $query = $this->db->get('incident_artifacts')->result();

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getIncidentList() {
        $this->db->select('incidents.incident_id, incidents.maximo_incident_id, incidents.description, incidents.offense_id, incidents.incident_type_id, '
                . 'incidents.verdict_id, incidents.status_id, incidents.priority_id, incidents.severity_id, incidents.user_id, incidents.notes, incidents.date_created, '
                . 'incidents.date_triaged, incidents.date_resolved, incidents.offense_start, incidents.date_closed, incidents.last_updated, '
                . 'incident_type.incident_type_id, incident_type.name, incident_type.description as incident_type_description, status.status, '
                . 'user.username, user_info.first_name, user_info.last_name');
        $this->db->join('incident_type', 'incidents.incident_type_id = incident_type.incident_type_id');
        $this->db->join('status', 'incidents.status_id = status.status_id');
        $this->db->join('user', 'incidents.user_id = user.user_id');
        $this->db->join('user_info', 'user.user_id = user_info.user_id');
        $query = $this->db->get('incidents')->result();

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getAssignedUser($incident_id) {
        $this->db->select('*');
        $this->db->where('incident_id', $incident_id);
        $query = $this->db->get('incident_assignment')->result();
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getIncidentSimple($incident_id) {
        $this->db->select('*');
        $this->db->where('incident_id', $incident_id);
        $query = $this->db->get('incidents')->result();
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function appendOneOffense($data) {
        $insert_data = array();
        $N_offense_id = NULL;
        $date = date("Y-m-d H:i:s");
        $incident_log = NULL;


        switch ($data['incident_type']):

            case 33:
//                Abnormal System Events

                if ($this->check_if_exist(1, $data['source_ip_address'], $data['incident_id'], 19)) {

                    $temp1 = array(
                        'artifact_id' => 19,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['source_ip_address'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }
                if ($this->check_if_exist(1, $data['destination_ip_address'], $data['incident_id'], 20)) {

                    $temp2 = array(
                        'artifact_id' => 20,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['destination_ip_address'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp2);
                }


                if ($this->check_if_exist(2, $data['offense_id'], $data['incident_id'])) {
                    $response = $this->getOffenseIDs($data['incident_id']);
                    $N_offense_id = $response[0]->offense_id . ' ' . $data['offense_id'];
                }

                $incident_log = $this->session->first_name . ' ' . $this->session->last_name . ' appended an offense on this incident. <br><strong><span class="text-primary">Offense Details:</span></strong><br><strong>Offense:</strong> ' . $data['offense_id']
                        . '<br><strong>Source IP:</strong> ' . $data['source_ip_address'] . '<br><strong>Destination IP:</strong> ' . $data['destination_ip_address'];


                break;
            case 31:
//                Abnormal Traffic
                if ($this->check_if_exist(1, $data['source_ip_address'], $data['incident_id'], 19)) {

                    $temp1 = array(
                        'artifact_id' => 19,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['source_ip_address'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }
                if ($this->check_if_exist(1, $data['destination_ip_address'], $data['incident_id'], 20)) {

                    $temp1 = array(
                        'artifact_id' => 20,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['destination_ip_address'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }
                if ($this->check_if_exist(2, $data['offense_id'], $data['incident_id'])) {
                    $response = $this->getOffenseIDs($data['incident_id']);
                    $N_offense_id = $response[0]->offense_id . ' ' . $data['offense_id'];
                }

                $incident_log = $this->session->first_name . ' ' . $this->session->last_name . ' appended an offense on this incident. <br><strong><span class="text-primary">Offense Details:</span></strong><br><strong>Offense:</strong> ' . $data['offense_id']
                        . '<br><strong>Source IP:</strong> ' . $data['source_ip_address'] . '<br><strong>Destination IP:</strong> ' . $data['destination_ip_address'];





                break;
            case 19:
//                IPS Alerts
                if ($this->check_if_exist(1, $data['source_ip_address'], $data['incident_id'], 19)) {

                    $temp1 = array(
                        'artifact_id' => 19,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['source_ip_address'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }
                if ($this->check_if_exist(1, $data['ips_signature'], $data['incident_id'], 51)) {

                    $temp2 = array(
                        'artifact_id' => 51,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['ips_signature'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp2);
                }

                if ($this->check_if_exist(2, $data['offense_id'], $data['incident_id'])) {
                    $response = $this->getOffenseIDs($data['incident_id']);
                    $N_offense_id = $response[0]->offense_id . ' ' . $data['offense_id'];
                }

                $incident_log = $this->session->first_name . ' ' . $this->session->last_name . ' appended an offense on this incident. <br><strong><span class="text-primary">Offense Details:</span></strong><br><strong>Offense:</strong> ' . $data['offense_id']
                        . '<br><strong>Source IP:</strong> ' . $data['source_ip_address'] . '<br><strong>IPS Signature:</strong> ' . $data['ips_signature'];



                break;
            case 28:
//                Malware
                if ($this->check_if_exist(1, $data['source_ip_address'], $data['incident_id'], 19)) {

                    $temp1 = array(
                        'artifact_id' => 19,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['source_ip_address'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }
                if ($this->check_if_exist(1, $data['malware_variant'], $data['incident_id'], 26)) {

                    $temp1 = array(
                        'artifact_id' => 26,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['malware_variant'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }
                if ($this->check_if_exist(1, $data['infected_file_location'], $data['incident_id'], 59)) {

                    $temp1 = array(
                        'artifact_id' => 59,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['infected_file_location'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }
                if ($this->check_if_exist(1, $data['source_hostname'], $data['incident_id'], 21)) {

                    $temp1 = array(
                        'artifact_id' => 21,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['source_hostname'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }

                if ($this->check_if_exist(2, $data['offense_id'], $data['incident_id'])) {
                    $response = $this->getOffenseIDs($data['incident_id']);
                    $N_offense_id = $response[0]->offense_id . ' ' . $data['offense_id'];
                }
                $incident_log = $this->session->first_name . ' ' . $this->session->last_name . ' appended an offense on this incident. <br><strong><span class="text-primary">Offense Details:</span></strong><br><strong>Offense:</strong> ' . $data['offense_id']
                        . '<br><strong>Source IP:</strong> ' . $data['source_ip_address'] . '<br><strong>Source Hostname:</strong> ' . $data['source_hostname'] . '<br><strong>Malware Variant:</strong> ' . $data['malware_variant'] . '<br><strong>Infected File Location:</strong> ' . $data['infected_file_location'];





                break;
            case 30:
//                Phishing and Scam
                if ($this->check_if_exist(1, $data['phishing_url'], $data['incident_id'], 65)) {

                    $temp1 = array(
                        'artifact_id' => 65,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['phishing_url'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }
                if ($this->check_if_exist(1, $data['ip_address'], $data['incident_id'], 68)) {

                    $temp2 = array(
                        'artifact_id' => 68,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['ip_address'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp2);
                }

                if ($this->check_if_exist(2, $data['offense_id'], $data['incident_id'])) {
                    $response = $this->getOffenseIDs($data['incident_id']);
                    $N_offense_id = $response[0]->offense_id . ' ' . $data['offense_id'];
                }
                $incident_log = $this->session->first_name . ' ' . $this->session->last_name . ' appended an offense on this incident. <br><strong><span class="text-primary">Offense Details:</span></strong><br><strong>Offense:</strong> ' . $data['offense_id']
                        . '<br><strong>Phishing URL:</strong> ' . $data['phishing_url'] . '<br><strong>IP Address:</strong> ' . $data['ip_address'];



                break;
            case 29:
//                Probes and Scans

                if ($this->check_if_exist(1, $data['source_ip_address'], $data['incident_id'], 19)) {

                    $temp1 = array(
                        'artifact_id' => 19,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['source_ip_address'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }

                if ($this->check_if_exist(2, $data['offense_id'], $data['incident_id'])) {
                    $response = $this->getOffenseIDs($data['incident_id']);
                    $N_offense_id = $response[0]->offense_id . ' ' . $data['offense_id'];
                }
                $incident_log = $this->session->first_name . ' ' . $this->session->last_name . ' appended an offense on this incident. <br><strong><span class="text-primary">Offense Details:</span></strong><br><strong>Offense:</strong> ' . $data['offense_id']
                        . '<br><strong>Source IP:</strong> ' . $data['source_ip_address'];


                break;
            case 32:
//                Suspicious Accounts and Authentication
                if ($this->check_if_exist(1, $data['source_ip_address'], $data['incident_id'], 19)) {

                    $temp1 = array(
                        'artifact_id' => 19,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['source_ip_address'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }
                if ($this->check_if_exist(1, $data['username'], $data['incident_id'], 49)) {

                    $temp2 = array(
                        'artifact_id' => 49,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['username'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp2);
                }

                if ($this->check_if_exist(2, $data['offense_id'], $data['incident_id'])) {
                    $response = $this->getOffenseIDs($data['incident_id']);
                    $N_offense_id = $response[0]->offense_id . ' ' . $data['offense_id'];
                }

                $incident_log = $this->session->first_name . ' ' . $this->session->last_name . ' appended an offense on this incident. <br><strong><span class="text-primary">Offense Details:</span></strong><br><strong>Offense:</strong> ' . $data['offense_id']
                        . '<br><strong>Source IP:</strong> ' . $data['source_ip_address'] . '<br><strong>Username:</strong> ' . $data['username'];




                break;
            case 27:
//                WAF Alerts
                if ($this->check_if_exist(1, $data['source_ip_address'], $data['incident_id'], 19)) {

                    $temp1 = array(
                        'artifact_id' => 19,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['source_ip_address'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp1);
                }
                if ($this->check_if_exist(1, $data['waf_attack_type'], $data['incident_id'], 52)) {

                    $temp2 = array(
                        'artifact_id' => 52,
                        'incident_id' => $data['incident_id'],
                        'value' => $data['waf_attack_type'],
                        'created_date' => $date,
                    );
                    array_push($insert_data, $temp2);
                }

                if ($this->check_if_exist(2, $data['offense_id'], $data['incident_id'])) {
                    $response = $this->getOffenseIDs($data['incident_id']);
                    $N_offense_id = $response[0]->offense_id . ' ' . $data['offense_id'];
                }


                $incident_log = $this->session->first_name . ' ' . $this->session->last_name . ' appended an offense on this incident. <br><strong><span class="text-primary">Offense Details:</span></strong><br><strong>Offense:</strong> ' . $data['offense_id']
                        . '<br><strong>Source IP:</strong> ' . $data['source_ip_address'] . '<br><strong>WAF Attack Type:</strong> ' . $data['waf_attack_type'];

                break;
        endswitch;
        if ($N_offense_id) {
            $this->db->set('offense_id', $N_offense_id);
            $this->db->where('incident_id', $data['incident_id']);
            $this->db->update('incidents');
        }

        if ($insert_data) {
            $this->db->insert_batch('incident_artifacts', $insert_data);
        }

        $incident_log_data = array(
            'incident_id' => $data['incident_id'],
            'content' => $incident_log,
        );
        $this->db->insert('incident_log', $incident_log_data);

//        if ($temp) {
//            return $temp;
//        }

        return $data['incident_id'];
    }

    public function check_if_exist($option, $value, $incident_id, $artifact_id = NULL) {
        if ($option == 1) {
            $array = array(
                'artifact_id' => $artifact_id,
                'incident_id' => $incident_id,
                'value' => $value,
            );

            $this->db->select('*');
            $this->db->where($array);
            $response = $this->db->count_all_results('incident_artifacts');

//            return $response;

            if ($response) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

        if ($option == 2) {
            $this->db->select('*');
            $this->db->like('offense_id', $value, 'both');
            $this->db->where('incident_id', $incident_id);
            $response = $this->db->get('incidents')->result();

            if ($response) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    public function getOffenseIDs($incident_id) {
        $this->db->select('offense_id');
        $this->db->where('incident_id', $incident_id);
        $response = $this->db->get('incidents')->result();

        return $response;
    }

    public function add_artifact($data) {
        $date = date("Y-m-d H:i:s");
        $insert_data = array(
            'artifact_id' => $data['artifact_id'],
            'incident_id' => $data['incident_id'],
            'value' => $data['value'],
            'created_date' => $date,
        );
        $q = $this->Artifacts_Model->getArtifactByID($data['artifact_id']);

        $incident_log = $this->session->first_name . ' ' . $this->session->last_name . ' added additonal artifact on this incident. <br>'
                . '<strong><span class="text-primary">Details: </span></strong><br><strong>Artifact Name:</strong> ' . $q[0]->name . '<br><strong>Value:</strong> ' . $data['value'];

        $incident_log_data = array(
            'incident_id' => $data['incident_id'],
            'content' => $incident_log,
        );

        $this->db->insert('incident_artifacts', $insert_data);
        $this->db->insert('incident_log', $incident_log_data);

        return $data['incident_id'];
    }
    
    public function countIncidentArtifacts($incident_id){
        $this->db->where('incident_id',$incident_id);
        $this->db->from('incident_artifacts');
        return $this->db->count_all_results();
    }

}
