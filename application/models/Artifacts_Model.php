<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Artifacts_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

//        $this->load->model('Users_Model');
    }

    public function getAllArtifacts() {
        $sql = "SELECT * FROM artifacts ORDER BY name ASC";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getArtifactByID($artifact_id) {
        $this->db->select('*');
        $this->db->where('artifact_id', $artifact_id);
        $query = $this->db->get('artifacts')->result();

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    public function getIncidentArtifactByIncidentType($incident_type) {
        $incident_type = $this->db->escape($incident_type);
        $sql = "SELECT itype.incident_type_id, itype.name, a.name, a.artifact_id, a.code, it.incident_template_id FROM incident_template it JOIN incident_type itype ON it.incident_type_id = itype.incident_type_id JOIN incident_template_artifact itf ON it.incident_template_id = itf.incident_template_id LEFT OUTER JOIN artifacts a ON itf.artifact_id = a.artifact_id WHERE itype.incident_type_id = " . $incident_type . " ORDER BY itf.order_by ASC";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getArtifcatsByIncType($incident_type) {
        $this->db->select("incident_template.incident_type_id, incident_type.name as incident_type_name, incident_template.incident_template_id, incident_template_artifact.order_by, artifacts.code, artifacts.name as artifact_name");
        $this->db->join('incident_type', 'incident_template.incident_type_id = incident_type.incident_type_id');
        $this->db->join('incident_template_artifact', 'incident_template.incident_template_id = incident_template_artifact.incident_template_id');
        $this->db->join('artifacts', 'incident_template_artifact.artifact_id = artifacts.artifact_id');
        $this->db->where('incident_template.incident_type_id', $incident_type);
        $this->db->order_by('incident_template_artifact.order_by', 'ASC');
        $query = $this->db->get('incident_template')->result();

        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

}
