<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Incident extends CI_Controller {

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
        $this->load->model('Incident_Model');
        $this->load->model('Artifacts_Model');
        $this->load->model('Status_Model');
        $this->load->model('Severity_Model');
        $this->load->model('Priority_Model');
        $this->load->model('Users_Model');
        $this->load->model('Others_Model');
        $this->load->model('Verdict_Model');
    }

    public function index() {
        $data['title'] = "Incidents";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();


        $data['incidents'] = $this->Incident_Model->getIncidentList();



        $this->load->view('templates/header-nav', $data);
        $this->load->view('incident-list', $data);
        $this->load->view('templates/footer-nav', $data);
    }

    public function view_incident($var, $error = NULL, $notif = NULL) {
        $data['title'] = "Incident";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();

        $data['incident_type'] = $this->Incident_Model->getIncidentType_All();
        $data['artifacts'] = $this->Artifacts_Model->getAllArtifacts();
        $data['status'] = $this->Status_Model->getStatus();
        $data['priority'] = $this->Priority_Model->getPriority();
        $data['severity'] = $this->Severity_Model->getSeverity();
        $data['groups'] = $this->Users_Model->getAllGroups();
        $data['verdict'] = $this->Verdict_Model->getAllVerdict();
        $data['save_notif'] = 0;
        $data['list_users'] = $this->Users_Model->getAllUsersE();

        $var = xss_clean($var);

        $temp = $this->Incident_Model->getIncidentByID($var);

        if ($error) {
            $data['error'] = $error;
        } else {
            $data['error'] = NULL;
        }

        if ($notif) {
            $data['notif'] = $notif;
        } else {
            $data['notif'] = NULL;
        }



        if ($temp) {
            $data['assigned_user'] = $this->Incident_Model->getAssignedUser($var);
            $temp_use = $this->Incident_Model->getAssignedUser($var);
            if ($temp_use) {
                $data['assigned_username'] = $this->Users_Model->getUserByID($temp_use[0]->user_id);
            }
            $data['groups_involved'] = $this->Users_Model->getGroupsInvolvedByIncidentID($temp[0]->incident_id);
            $data['incidenttype'] = $this->Incident_Model->getIncidentTypeByID($temp[0]->incident_type_id);
            $data['creator'] = $this->Users_Model->getUserByID($temp[0]->user_id);
            $temp_data = array();
            $temp_data1 = array();
            $data['result'] = array();
            foreach ($temp as $row):
                $temp_data = $this->Users_Model->getGroupByID($row->group_id);
                array_push($data['result'], $temp_data);
//                array_push($data['groups_involved'], $result[0]->name);
            endforeach;
            $data['incident_log'] = $this->Incident_Model->getIncidentLogByID($temp[0]->incident_id);
            $data['artifacts_type'] = $this->Artifacts_Model->getIncidentArtifactByIncidentType($temp[0]->incident_type_id);
            $data['status'] = $this->Status_Model->getStatusByID($temp[0]->status_id);
            $data['incident_artifacts'] = $this->Incident_Model->getIncidentArtifactsByID($temp[0]->incident_id);
            $data['artifacts_count'] = $this->Incident_Model->countIncidentArtifacts($temp[0]->incident_id);
        }

        $data['var'] = $this->Incident_Model->getIncidentByID($var);
        $data['countries'] = $this->Others_Model->loadCountries();



        $this->load->view('templates/header-nav', $data);
        $this->load->view('incident-view', $data);
        $this->load->view('templates/footer-nav', $data);
    }

    public function add_incident() {
        $data['title'] = "Add Incident";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();

        $data['incident_type'] = $this->Incident_Model->getIncidentType_All();
        $data['artifacts'] = $this->Artifacts_Model->getAllArtifacts();
        $data['status'] = $this->Status_Model->getStatus();
        $data['priority'] = $this->Priority_Model->getPriority();
        $data['severity'] = $this->Severity_Model->getSeverity();
        $data['groups'] = $this->Users_Model->getAllGroups();


        if ($this->input->post()) {
//            print_r($this->input->post());
            $config = array(
                array(
                    'field' => 'status',
                    'label' => 'Status',
                    'rules' => 'trim|required|numeric|max_length[4]',
                ),
                array(
                    'field' => 'incident_type',
                    'label' => 'Incident Type',
                    'rules' => 'trim|required|numeric|max_length[5]',
                ),
                array(
                    'field' => 'description',
                    'label' => 'Description',
                    'rules' => 'trim|required|max_length[255]',
                ),
                array(
                    'field' => 'maximo_incident_id',
                    'label' => 'Maximo Incident ID',
                    'rules' => 'trim|required|alpha_numeric|max_length[10]',
                ),
                array(
                    'field' => 'offense_id',
                    'label' => 'Offense ID',
                    'rules' => 'trim|required|max_length[255]',
                ),
                array(
                    'field' => 'offense_start',
                    'label' => 'Offense Start',
                    'rules' => 'trim|required|max_length[30]',
                ),
                array(
                    'field' => 'severity',
                    'label' => 'Severity',
                    'rules' => 'trim|required|numeric|max_length[4]',
                ),
                array(
                    'field' => 'priority',
                    'label' => 'Priority',
                    'rules' => 'trim|required|numeric|max_length[4]',
                ),
                array(
                    'field' => 'groups_involved[]',
                    'label' => 'Groups Involved',
                    'rules' => 'trim|required|max_length[30]',
                ),
                array(
                    'field' => 'notes',
                    'label' => 'Notes',
                    'rules' => 'trim|alpha_numeric_spaces|alpha_dash|max_length[255]',
                ),
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE) {
                $data['temp'] = $this->input->post(NULL, TRUE);

                $this->load->view('templates/header-nav', $data);
                $this->load->view('add-incident-view', $data);
                $this->load->view('templates/footer-nav', $data);
            } else {
                // Validation is TRUE
                $status = $this->input->post('status', TRUE);
                $incident_type = $this->input->post('incident_type', TRUE);
                $description = $this->input->post('description', TRUE);
                $maximo_incident_id = $this->input->post('maximo_incident_id', TRUE);
                $offense_id = $this->input->post('offense_id', TRUE);
                $offense_start = $this->input->post('offense_start', TRUE);
                $severity = $this->input->post('severity', TRUE);
                $priority = $this->input->post('priority', TRUE);
                $groups_involved = $this->input->post('groups_involved', TRUE);
                $notes = $this->input->post('notes', TRUE);

                $response = $this->Incident_Model->add_incident($status, $incident_type, $description, $maximo_incident_id, $offense_id, $offense_start, $severity, $priority, $groups_involved, $notes);
                redirect(base_url('index.php/Incident/view_incident/' . $response));
            }
        } else {
            $data['temp'] = array();
            $this->load->view('templates/header-nav', $data);
            $this->load->view('add-incident-view', $data);
            $this->load->view('templates/footer-nav', $data);
        }
    }

// end of add_incident

    public function receive_incident() {
        $data['title'] = "Incidents";
        $data['base_url'] = base_url();
        $data['nav'] = uri_string();

        $config = array(
            array(
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'trim|required|max_length[2]|numeric',
            ),
            array(
                'field' => 'incident_type',
                'label' => 'Incident Type',
                'rules' => 'trim|required|max_length[3]|numeric',
            ),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|required|max_length[50]',
            ),
            array(
                'field' => 'maximo_incident_id',
                'label' => 'Maximo Incident ID',
                'rules' => 'trim|required|alpha_numeric|max_length[10]',
            ),
            array(
                'field' => 'offense_id',
                'label' => 'Offense ID',
                'rules' => 'trim|required|alpha_numeric_spaces|alpha_dash',
            ),
            array(
                'field' => 'offense_start',
                'label' => 'Offense Start',
                'rules' => 'trim|required|max_length[30]',
            ),
            array(
                'field' => 'severity',
                'label' => 'Severity',
                'rules' => 'trim|required|numeric|max_length[3]',
            ),
            array(
                'field' => 'priority',
                'label' => 'Priority',
                'rules' => 'trim|required|numeric|max_length[3]',
            ),
            array(
                'field' => 'groups_involved',
                'label' => 'Groups Involved',
                'rules' => 'trim|required|numeric|max_length[30]',
            ),
            array(
                'field' => 'notes',
                'label' => 'Notes',
                'rules' => 'trim|alpha_numeric_spaces|alpha_dash|max_length[255]',
            ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header-nav', $data);
            $this->load->view('add-incident-view', $data);
            $this->load->view('templates/footer-nav', $data);
        } else {
            $this->view_incident($this->input->post(NULL, TRUE));
        }
    }

    public function getIncidentArtifacts($incident_type) {
        $incident_type = xss_clean($incident_type);
        $response = $this->Artifacts_Model->getIncidentArtifactByIncidentType($incident_type);
        if ($response) {
            echo '<table class="table table-hover" style="width: 100%">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th scope="col" style="width:15%">Type</th>';
            echo '<th scope="col">Value</th>';
            echo '<th scope="col" style="width:10%">Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody id="artifact_table">';
            $x = 0;

            foreach ($response as $row):
                $x++;
                echo '<tr>';
                echo '<td>' . $row->name . '</td>';
                if ($row->artifact_id == 54) {
                    echo '<td><div class="form-row"><div class="col"><input type="text" class="form-control" placeholder="Source IP Address" name="artifact' . $x . '" id="artifact' . $x . '"></div><div class="col"><input type="text" class="form-control" placeholder="Source Geolocation"></div></div></td>';
                } elseif ($row->artifact_id == 55) {
                    echo '<td><div class="form-row"><div class="col"><input type="text" class="form-control" placeholder="Destination IP Address" name="artifact' . $x . '" id="artifact' . $x . '"></div><div class="col"><input type="text" class="form-control placeholder="Destination Geolocation"></div></div></td>';
                } elseif ($row->artifact_id == 53) {
                    echo '<td><textarea class="form-control" id="payloadtextarea" rows="3" placeholder="Payload" name="artifact' . $x . '" id="artifact' . $x . '"></textarea></td>';
                } else {
                    echo '<td><input type="text" class="form-control" placeholder="' . $row->name . '" name="artifact' . $x . '" id="artifact' . $x . '"></td>';
                }

                echo '<td><input type="checkbox" name="check' . $x . '"> <span class="label-text"> Ignore</span></td>';
                echo '</tr>';
            endforeach;

            echo '</tbody>';
            echo '</table>';
            echo '<small id="HelpBlock" class="form-text text-muted">
  For multiple entries, please include a space after a value. (i.e. 192.168.0.1 192.168.0.2)
</small>';
        } //end of if
        else {
            echo '<div class="jumbotron" id="change_div">  <p class="text-center lead">Please Select a valid Incident Type</p> </div>';
        } // end of else
    }

    public function segregate($response) {
        $temp = array();
        foreach ($response as $row):
            array_push($temp, $row->code);
        endforeach;


        return $temp;
    }

    public function getIncidentTemplateArtifact($incident_type = NULL) {
        $incident_type = xss_clean($incident_type);
        $response = $this->Artifacts_Model->getArtifcatsByIncType($incident_type);

        $countries = $this->Others_Model->loadCountries();

        if ($response == 0) {
            echo '<p class="text-center lead">Please Select Incident Type</p>';
        } else {

            $segregated = $this->segregate($response);

            echo '<table class="table table-hover" >';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th scope="col" style="width: 25%;">Type</th>';
            echo '<th scope="col">Value</th>';

            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($response as $row):
                echo '<tr>';

                echo '<td>' . $row->artifact_name . '</td>';
                echo '<td>';
                if ($row->artifact_name == 'Source IP Address - Source Geolocation') {
                    echo '<div class="form-row">';
                    echo '<div class="col">';
                    echo '<input type="text" class="form-control" name="source_ip" placeholder="Source IP Address">';

                    echo '</div>';
                    echo '<div class="col">';
                    echo '<select class="form-control selectpicker" name="source_geolocation">';
                    echo '<option value="XX">Source Geolocation</option>';
                    foreach ($countries as $row):
                        echo '<option value="' . $row->iso . '" data-thumbnail="' . base_url('assets/img/flags/' . strtolower($row->iso) . '.png') . '">' . $row->nicename . '</option>';
                    endforeach;

                    echo '</select>';
                    echo '</div>';


                    echo '</div>';
                } elseif ($row->artifact_name == 'Payload') {

                    echo '<textarea class="form-control" id="payload_textarea" rows="4" name="payload">' . set_value('payload') . '</textarea>';
                } else {

                    echo '<input type="text" class="form-control" name="' . $row->code . '" placeholder="' . $row->artifact_name . '">';
                }

                echo '</td>';
                echo '</tr>';
            endforeach;
            echo '</tbody>';
            echo '</table>';

            echo '<small id="HelpBlock" class="form-text text-muted">
  For multiple entries, please include a space after a value. (i.e. 192.168.0.1 192.168.0.2)
</small>';
        }
    }

    public function getIncidentTemplateArtifact2($incident_type = NULL) {
        $incident_type = xss_clean($incident_type);
        $response = $this->Artifacts_Model->getArtifcatsByIncType($incident_type);

        if ($response == 0) {
            echo 0;
        } else {

            $segregated = $this->segregate($response);
            print json_encode($segregated);
        }
    }

    public function save() {

        $artifact = $this->Artifacts_Model->getIncidentArtifactByIncidentType($this->input->post('incident_type_id'));
        $logs = array();
        $config = array(
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'offense_id',
                'label' => 'Offense ID',
                'rules' => 'trim|required',
            ),
        );


        if ($this->input->post('incident_inc') == 0) {

            foreach ($artifact as $row) {
                if ($row->artifact_id == 54) {
                    $temp = array(
                        'field' => 'source_ip_address',
                        'label' => 'Source IP Address',
                        'rules' => 'trim|required|valid_ip',
                    );
                    $temp2 = array(
                        'field' => 'source_geolocation',
                        'label' => 'Source Geolocation',
                        'rules' => 'trim|required',
                    );

                    array_push($config, $temp, $temp2);
                } elseif ($row->artifact_id == 35 || $row->artifact_id == 36) {
                    $temp = array(
                        'field' => $row->code,
                        'label' => $row->name,
                        'rules' => 'trim|alpha_numeric_spaces|required',
                    );
                    array_push($config, $temp);
                } else {
                    $temp = array(
                        'field' => $row->code,
                        'label' => $row->name,
                        'rules' => 'trim|required',
                    );

                    array_push($config, $temp);
                }
            } // end of rules config
        }

        if ($this->input->post('prev_status') != $this->input->post('status')) {
            $temp = array(
                'field' => 'change_status_notes',
                'label' => 'Reason for Change of Status',
                'rules' => 'trim|required',
            );
            $temp1 = array(
                'field' => 'change_status_datetime',
                'label' => 'Change Status DateTime',
                'rules' => 'trim|required',
            );
            array_push($config, $temp);
            array_push($config, $temp1);
        }

        if ($this->input->post('prev_severity') != $this->input->post('severity') || $this->input->post('prev_priority') != $this->input->post('priority')) {
            $temp = array(
                'field' => 'change_severity_notes',
                'label' => 'Reason for Change of Severity',
                'rules' => 'trim|required',
            );
            array_push($config, $temp);
        }

        if ($this->input->post('prev_verdict') != $this->input->post('verdict')) {
            $temp = array(
                'field' => 'change_verdict_notes',
                'label' => 'Reason for Change of Verdict',
                'rules' => 'trim|required',
            );
            array_push($config, $temp);
        }

        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<p class="text-danger " style=" "><span class="badge badge-danger" style="background-color: rgba(220,53,69,.8) ! important;">', '</span></p>');
        if ($this->form_validation->run()) {
            $data['success'] = true;

            //prep data
            $prev_status = $this->prep_status($this->input->post('prev_status'));
            $status = $this->prep_status($this->input->post('status'));

            $prev_severity = $this->prep_severity($this->input->post('prev_severity'));
            $severity = $this->prep_severity($this->input->post('severity'));

            $prev_priority = $this->prep_priority($this->input->post('prev_priority'));
            $priority = $this->prep_priority($this->input->post('priority'));

            $prev_verdict = $this->prep_verdict($this->input->post('prev_verdict'));
            $verdict = $this->prep_verdict($this->input->post('verdict'));




            if ($this->input->post('change_status_notes')) {
                $message = $this->session->first_name . ' ' . $this->session->last_name . ' modified status from <strong>' . $prev_status . '</strong> to <strong>' . $status . '</strong>. <span class="text-primary">[Reason for change: ' . $this->input->post('change_status_notes', TRUE) . ']</span>';
                array_push($logs, $message);
            }
            if ($this->input->post('change_severity_notes')) {
                $message = $this->session->first_name . ' ' . $this->session->last_name . ' modified severity from  <strong>' . $prev_severity . ' - ' . $prev_priority . '</strong> to <strong>' . $severity . ' - ' . $priority . '</strong>.  <span class="text-primary">[Reason for change: ' . $this->input->post('change_severity_notes', TRUE) . ']</span>';
                array_push($logs, $message);
            }
            if ($this->input->post('change_verdict_notes')) {
                $message = $this->session->first_name . ' ' . $this->session->last_name . ' modified verdict from <strong>' . $prev_verdict . '</strong> to <strong>' . $verdict . '</strong>. <span class="text-primary">[Reason for change: ' . $this->input->post('change_verdict_notes', TRUE) . ']</span>';
                array_push($logs, $message);
            }

            if ($this->input->post('prev_description') != $this->input->post('description')) {
                $message = $this->session->first_name . ' ' . $this->session->last_name . ' modified description from <span class="text-primary">' . $this->input->post('prev_description') . '</span> to <span class="text-primary">' . $this->input->post('description') . '</span>';
                array_push($logs, $message);
            }
            if ($this->input->post('prev_offense_id') != $this->input->post('offense_id')) {
                $message = $this->session->first_name . ' ' . $this->session->last_name . ' modified offense ID from <span class="text-primary">' . $this->input->post('prev_offense_id') . '</span> to <span class="text-primary">' . $this->input->post('offense_id') . '</span>';
                array_push($logs, $message);
            }
            if ($this->input->post('prev_assigned') != $this->input->post('assigned')) {
                $user_assigned = $this->Users_Model->getUserByID($this->input->post('assigned'));
//                print_r($user_assigned);

                if ($user_assigned) {

                    if ($this->input->post('prev_assigned') == 0) {
                        $message = $this->session->first_name . ' ' . $this->session->last_name . ' assigned this incident to <strong>' . $user_assigned[0]->first_name . ' ' . $user_assigned[0]->last_name . '</strong>.';
                        array_push($logs, $message);
                    } else {
                        $message = $this->session->first_name . ' ' . $this->session->last_name . ' reassigned this incident to <strong>' . $user_assigned[0]->first_name . ' ' . $user_assigned[0]->last_name . '</strong>.';
                        array_push($logs, $message);
                    }
                }
            }

            if ($logs) {
                $this->Incident_Model->add_incident_log($this->input->post('incident_id', TRUE), $logs);
            }

            if ($this->input->post('incident_inc') == 0) {
//                print_r($this->input->post());

                $this->Incident_Model->add_incident_artifacts($this->input->post(NULL, TRUE));
                $this->Incident_Model->update_incident($this->input->post(NULL, TRUE));


                $data['incident_id'] = $this->input->post('incident_id', TRUE);
                $data['save_notif'] = 1;
                $data['redirect'] = base_url('index.php/Incident/view_incident/' . $this->input->post('incident_id', TRUE));
//                print_r($response1);
            }
            if ($this->input->post('incident_inc') == 1) {
//                print_r($this->input->post());
                $this->Incident_Model->update_incident($this->input->post(NULL, TRUE));


                $data['incident_id'] = $this->input->post('incident_id', TRUE);
                $data['save_notif'] = 1;
                $data['redirect'] = base_url('index.php/Incident/view_incident/' . $this->input->post('incident_id', TRUE));
            }
        } else {
            foreach ($_POST as $key => $value) {
                $data['messages'][$key] = form_error($key);
            }
//            print_r($this->input->post());
        }
        echo json_encode($data);

//        print_r($this->input->post('incident_inc'));
    }

    public function prep_status($status) {
        switch ($status) {
            case 1:
                return 'Queued';
                break;
            case 2:
                return 'In Progress';
                break;
            case 3:
                return 'Pending';
                break;
            case 4:
                return 'SLAHOLD';
                break;
            case 5:
                return 'Resolved';
                break;
            case 6:
                return 'Closed';
                break;
            case 7:
                return 'Cancelled';
                break;
            case 8:
                return 'Rejected';
                break;
            default:
                return 'NA';
        }
    }

    public function prep_severity($severity) {
        switch ($severity) {
            case 1:
                return 'Low';
                break;
            case 2:
                return 'Medium';
                break;
            case 3:
                return 'High';
                break;
            default:
                return 'NA';
        }
    }

    public function prep_priority($priority) {
        switch ($priority) {
            case 1:
                return 'P1';
                break;
            case 2:
                return 'P2';
                break;
            case 3:
                return 'P3';
                break;
            case 4:
                return 'P4';
                break;
            default :
                return 'NA';
        }
    }

    public function prep_verdict($verdict) {
        switch ($verdict) {
            case 1:
                return 'Positive';
                break;
            case 2:
                return 'False Positive';
                break;
            case 3:
                return 'Benign';
                break;
            default:
                return 'NA';
        }
    }

    public function add_artifact() {

        $config = array(
            array(
                'field' => 'artifact_id',
                'label' => 'Artifact ID',
                'rules' => 'trim|required|integer|max_length[250]'
            ),
        );
        if ($this->input->post('artifact_id') == 19 || $this->input->post('artifact_id') == 20 || $this->input->post('artifact_id') == 68) {
            $temp = array(
                'field' => 'value',
                'label' => 'Value',
                'rules' => 'trim|required|valid_ip|max_length[255]',
            );

            array_push($config, $temp);
        } else {
            $temp = array(
                'field' => 'value',
                'label' => 'Value',
                'rules' => 'trim|required|max_length[255]',
            );
            array_push($config, $temp);
        }


        $this->form_validation->set_rules($config);

        if ($this->form_validation->run()) {
            $data = $this->Incident_Model->add_artifact($this->input->post(NULL, TRUE));
            $this->view_incident($data, NULL, 1);

            print_r($data);
        } else {
            $this->view_incident($this->input->post('incident_id'), validation_errors());
        }
    }

    public function append_offense() {

        if ($this->input->post('num') == 1) {
            $config = array();
            switch ($this->input->post('incident_type')):
//                Abnormal System Events
                case 33:
                    $config = array(
                        array(
                            'field' => 'offense_id',
                            'label' => 'Offense ID',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                        array(
                            'field' => 'source_ip_address',
                            'label' => 'Source IP Address',
                            'rules' => 'trim|required|valid_ip',
                        ),
                        array(
                            'field' => 'destination_ip_address',
                            'label' => 'Source IP Address',
                            'rules' => 'trim|required|valid_ip',
                        ),
                    );
                    break;
//                Abnormal traffic
                case 31:
                    $config = array(
                        array(
                            'field' => 'offense_id',
                            'label' => 'Offense ID',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                        array(
                            'field' => 'source_ip_address',
                            'label' => 'Source IP Address',
                            'rules' => 'trim|required|valid_ip',
                        ),
                        array(
                            'field' => 'destination_ip_address',
                            'label' => 'Source IP Address',
                            'rules' => 'trim|required|valid_ip',
                        ),
                    );
                    break;
//                IPS Alerts
                case 19:
                    $config = array(
                        array(
                            'field' => 'offense_id',
                            'label' => 'Offense ID',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                        array(
                            'field' => 'source_ip_address',
                            'label' => 'Source IP Address',
                            'rules' => 'trim|required|valid_ip',
                        ),
                        array(
                            'field' => 'ips_signature',
                            'label' => 'IPS Signature',
                            'rules' => 'trim|required',
                        ),
                    );
                    break;
//                Malware
                case 28:
                    $config = array(
                        array(
                            'field' => 'offense_id',
                            'label' => 'Offense ID',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                        array(
                            'field' => 'malware_variant',
                            'label' => 'Malware Variant',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                        array(
                            'field' => 'source_ip_address',
                            'label' => 'Source IP Address',
                            'rules' => 'trim|required|valid_ip',
                        ),
                        array(
                            'field' => 'source_hostname',
                            'label' => 'Source Hostname',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                        array(
                            'field' => 'infected_file_location',
                            'label' => 'Infected File Location',
                            'rules' => 'trim|required',
                        ),
                    );
                    break;
//                Phishing and Scam
                case 30:
                    $config = array(
                        array(
                            'field' => 'offense_id',
                            'label' => 'Offense ID',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                        array(
                            'field' => 'phishing_url',
                            'label' => 'Phishing URL',
                            'rules' => 'trim|required|valid_url',
                        ),
                        array(
                            'field' => 'ip_address',
                            'label' => 'IP Address',
                            'rules' => 'trim|required|valid_ip',
                        ),
                    );
                    break;
//Probes and Scans
                case 29:
                    $config = array(
                        array(
                            'field' => 'offense_id',
                            'label' => 'Offense ID',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                        array(
                            'field' => 'source_ip_address',
                            'label' => 'Source IP Address',
                            'rules' => 'trim|required|valid_ip',
                        ),
                    );
                    break;
//                Suspicious Accounts and Authentication
                case 32:
                    $config = array(
                        array(
                            'field' => 'offense_id',
                            'label' => 'Offense ID',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                        array(
                            'field' => 'source_ip_address',
                            'label' => 'Source IP Address',
                            'rules' => 'trim|required|valid_ip',
                        ),
                        array(
                            'field' => 'username',
                            'label' => 'Username',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                    );
                    break;
//                WAF Alerts
                case 27:
                    $config = array(
                        array(
                            'field' => 'offense_id',
                            'label' => 'Offense ID',
                            'rules' => 'trim|required|max_length[30]',
                        ),
                        array(
                            'field' => 'source_ip_address',
                            'label' => 'Source IP Address',
                            'rules' => 'trim|required|valid_ip',
                        ),
                        array(
                            'field' => 'waf_attack_type',
                            'label' => 'WAF Attack Type',
                            'rules' => 'trim|required',
                        ),
                    );
                    break;
            endswitch;

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run()) {
                $data = $this->Incident_Model->appendOneOffense($this->input->post(NULL, TRUE));
//                redirect(base_url('index.php/Incident/view_incident/' . $data));
                $this->view_incident($data, NULL, 1);
            } else {
                $this->view_incident($this->input->post('incident_id'), validation_errors());
            }
        } elseif ($this->input->post('num') == 2) {
            
        } else {

            show_404();
        }
    }

}

// end of function

