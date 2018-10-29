<div class="content-wrapper">

    <div class="container-fluid">
        <?php if ($var == 0) { ?>
            <div class="jumbotron">
                <h1 class="display-4">Ooops! Something went wrong! <span class="fa fa-frown-o"> </span></h1>
                <!--<p class="lead"> </p>-->
                <hr class="my-4">

                <a class="btn btn-primary btn-lg" href="<?php echo base_url('index.php/Incident') ?>" role="button">Go back to Incidents</a>
            </div>
            <?php
        } else {
            //prep_data
            if ($var[0]->priority_id == 1) {
                $priority = 'P1';
            } elseif ($var[0]->priority_id == 2) {
                $priority = 'P2';
            } elseif ($var[0]->priority_id == 3) {
                $priority = 'P3';
            } elseif ($var[0]->priority_id == 4) {
                $priority = 'P4';
            } else {
                $priority = 'Unknown';
            } // pirority
            //prep_data
            if ($var[0]->verdict_id == 1) {
                $verdict = 'Positive';
            } elseif ($var[0]->verdict_id == 2) {
                $verdict = 'False Positive';
            } elseif ($var[0]->verdict_id == 3) {
                $verdict = 'Benign';
            } else {
                $verdict = 'Unknown';
            } // pirority


            if ($var[0]->severity_id == 1) {
                $severity = 'Low';
                $severity_response = '<span class="badge badge-success">Low</span>';
            } elseif ($var[0]->severity_id == 2) {
                $severity = 'Medium';
                $severity_response = '<span class="badge badge-warning">Medium</span>';
            } elseif ($var[0]->severity_id == 3) {
                $severity = 'High';
                $severity_response = '<span class="badge badge-danger">High</span>';
            } else {
                $severity = 'Unknown';
                $severity_response = '<button type="button" class="btn btn-secondary">Unknown</button>';
            }

            if ($var[0]->date_created == '0000-00-00 00:00:00') {
                $date_created = 'Unknown';
            } else {
                $date_created = nice_date($var[0]->date_created, 'm/d/y , H:i:s');
            }
            if ($var[0]->date_triaged == '0000-00-00 00:00:00') {
                $date_triaged = 'Unknown';
            } else {
                $date_triaged = nice_date($var[0]->date_triaged, 'm/d/y , H:i:s');
            }
            if ($var[0]->date_resolved == '0000-00-00 00:00:00') {
                $date_resolved = 'Unknown';
            } else {
                $date_resolved = nice_date($var[0]->date_resolved, 'm/d/y , H:i:s');
            }
            if ($var[0]->date_closed == '0000-00-00 00:00:00') {
                $date_closed = 'Unknown';
            } else {
                $date_closed = nice_date($var[0]->date_closed, 'm/d/y , H:i:s');
            }
            if ($var[0]->last_updated == '0000-00-00 00:00:00') {
                $last_updated = 'Unknown';
            } else {
                $last_updated = nice_date($var[0]->last_updated, 'm/d/y , H:i:s');
            }
            if ($var[0]->offense_start == '0000-00-00 00:00:00') {
                $offense_start = 'Unknown';
            } else {
                $offense_start = nice_date($var[0]->offense_start, 'm/d/y , H:i:s');
            }
            ?>
            <div class="row">
                <div class="col-lg-9">
                    <h2 class="text-truncate" style="width: 70rem;"><?php echo $incidenttype[0]->code . '_' . $incidenttype[0]->incident_type_id . $var[0]->incident_id; ?> - <?php echo $var[0]->description; ?></h2>

                </div>
                <div class="col-lg-3">
                    <?php echo form_open("Incident/save", array("id" => "form-save")); ?>
                    <input type="hidden" value="<?php echo $var[0]->incident_id; ?>" name="incident_id">
                    <input type="hidden" value="<?php echo $var[0]->incident_type_id; ?>" name="incident_type_id">

                </div>
                <hr>
            </div> <!-- end of row -->
            <hr>
            <div class="row">
                <div class="col-lg-3">


                    <div class="card bg-light mb-3" >
                        <div class="card-body">
                            <h4 class="card-title"><span class="fa fa-file-o"></span> Summary</h4>

                            <table class="table table-hover table-sm table-condensed" style="font-size: 14px;">
                                <tbody>
                                    <tr>
                                        <td><span class="font-weight-bold">ID</span></td>
                                        <td><span ><?php echo $var[0]->incident_id; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Maximo Incident ID</td>
                                        <td><?php echo $var[0]->maximo_incident_id; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Status</td>
                                        <td><?php echo ($status == 0) ? 'Unknown' : $status[0]->status; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Severity</td>
                                        <td><?php echo $severity_response; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Priority</td>
                                        <td><?php echo $priority; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Offense ID</td>
                                        <td><?php echo $var[0]->offense_id; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Offense Start</td>
                                        <td><?php echo $offense_start; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Date Created</td>
                                        <td><?php echo $date_created; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Date Triaged</td>
                                        <td><?php echo $date_triaged; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Date Resolved</td>
                                        <td><?php echo $date_resolved; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Date Closed</td>
                                        <td><?php echo $date_closed; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Incident Type</td>
                                        <td><span class="badge badge-secondary"><?php echo $incidenttype[0]->name; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Verdict</td>
                                        <td><?php echo $verdict; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>



<!--                    <div class="card bg-light mb-3" >
                        <div class="card-body">
                            <h4 class="card-title"><span class="fa fa-comment"></span> Incident Log</h4>
                            <hr>
                            <div class="scrollable-log">
                                <div class="list-group">

                                    <?php // foreach ($incident_log as $row): ?>
                                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">

                                            <div class="d-flex w-100 justify-content-between">
                                                <span class="font-weight-bold"><?php // echo nice_date($row->datetime, 'm/d/y , H:i:s'); ?></span>
                                                <small class="text-muted"><span class="fa fa-clock-o"></span> <?php // echo time_elapsed_string($row->datetime); ?></small>
                                            </div>

                                            <small><?php // echo $row->content; ?></small>

                                        </a>
                                    <?php // endforeach; ?>
                                </div>

                                <ul>

                                </ul>
                            </div>

                        </div>
                    </div>-->

                    <div class="card bg-light mb-3" style="height: 15em;">
                        <div class="card-body">
                            <h4 class="card-title"><span class="fa fa-users"></span> People</h4>

                            <table class="table table-hover table-sm table-condensed">
                                <tbody>
                                    <tr>
                                        <td style="width:30%;"><span class="font-weight-bold">Created By</span></td>
                                        <td><span ><?php echo $creator[0]->first_name . ' ' . $creator[0]->last_name; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;"><span class="font-weight-bold">Assigned To</span></td>
                                        <td><span >
                                                <?php
                                                if ($assigned_user) {
                                                    echo $assigned_username[0]->first_name . ' ' . $assigned_username[0]->last_name;
                                                } else {
                                                    echo 'Unknown';
                                                }
                                                ?>
                                            </span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Groups Involved</td>
                                        <td><?php
                                            for ($x = 0; $x <= count($groups_involved) - 1; $x++) {


                                                if ($x == count($groups_involved) - 1) {
                                                    echo $groups_involved[$x]->name;
                                                } else {
                                                    echo $groups_involved[$x]->name . ', ';
                                                }
                                            }
                                            ?></td>
                                    </tr>


                                </tbody>
                            </table>

                        </div>
                    </div>





                </div> <!-- end of col-lg-3 -->

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="alert alert-primary float-right" role="alert" id="save-load">
                                <div class="text-center">
                                    <span class="fa fa-spinner fa-pulse fa-fw"></span> Saving Incident
                                </div>
                            </div>
                            <?php if ($save_notif == 1): ?>
                                <div class="alert alert-success alert-dismissible fade show float-right" role="alert" id="updateMe">
                                    <div class="text-center">
                                        <span class="fa fa-save"></span> Incident Updated
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <div class="alert alert-danger alert-dismissible fade show float-right" role="alert" id="error">
                                <div class="text-center">
                                    Error! <span class="fa fa-frown-o"></span> Please check the required fields.
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show float-right" role="alert" >
                                    <div class="text-center">
                                        Error! <span class="fa fa-frown-o"></span> 

                                        <?php print_r($error); ?>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            <?php if ($notif == 1): ?>
                                <div class="alert alert-success alert-dismissible fade show float-right" role="alert" >
                                    <div class="text-center">
                                        <span class="fa fa-save"></span> Incident Updated!
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">

                            <div class="btn-group float-right" >
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions 
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#assign_modal"><span class="fa fa-user"></span> Assign</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#verdict_modal"><span class="fa fa-gavel"></span> Change Verdict</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#severity_modal"><span class="fa fa-fire"></span> Change Severity</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#status_modal"><span class="fa fa-support"></span> Change Status</a>
                                        <?php if ($_SESSION['role'] == 'admin'): ?>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_inc_modal"><span class="text-danger"><span class="fa fa-trash"></span> Delete Incident</span></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
    <!--                                <a href="#" class="btn btn-outline-dark" data-toggle="modal" data-target="#assign_modal"><span class="fa fa-user"></span> Assign</a>
                                <a href="#" class="btn btn-outline-info" data-toggle="modal" data-target="#verdict_modal"><span class="fa fa-gavel"></span> Change Verdict</a>
                                <a href="#" class="btn btn-outline-warning mod" data-toggle="modal" data-target="#severity_modal"><span class="fa fa-fire"></span> Change Severity</a>
                                <a href="#" class="btn btn-outline-success" data-toggle="modal" data-target="#status_modal"><span class="fa fa-support"></span> Change Status</a>-->
                                <button class="btn btn-outline-primary" id="update-btn" type="submit"><span class="fa fa-save"></span> Update</button>

                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-artifacts" role="tab" aria-controls="nav-artifacts" aria-selected="true"><span class="fa fa-hdd-o"></span> Artifacts</a>
                                    <a class="nav-item nav-link" id="nav-details-tab" data-toggle="tab" href="#nav-details" role="tab" aria-controls="nav-details" aria-selected="false"><span class="fa fa-folder-open-o"></span> Details</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-tasks" role="tab" aria-controls="nav-tasks" aria-selected="false"><span class="fa fa-tasks"></span> Tasks</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-timeline" role="tab" aria-controls="nav-contact" aria-selected="false"><span class="fa fa-history"></span> Timeline</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="false"><span class="fa fa-pencil-square-o"></span> Notes</a>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-artifacts" role="tabpanel" aria-labelledby="nav-artifacts-tab">
                                    <div style="padding-top: 1em;">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <?php if ($incident_artifacts) { ?>
                                                    <input type="hidden" name="incident_inc" value="1">


                                                    <div class="float-right" style="padding-bottom: .5em;">
                                                        <div class="btn-group">
                                                            <button type="button" data-toggle="modal" data-target="#add_artifact_mod" class="btn btn-success"><span class="fa fa-plus-circle"></span> Add Artifact</button>
                                                            <div class="btn-group" role="group">
                                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span class="fa fa-plus-circle"></span> Append Offense
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target=".append_offense_one">One</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target=".append_offense_multiple">Multiple</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="padding-top: .5em;">
                                                        <!--if artifacts are less than or equal to 10-->
                                                        <?php if ($artifacts_count <= 10) { ?>
                                                            <table class="table table-hover table-responsive-md" >
                                                                <thead class="thead-dark">
                                                                    <tr>
                                                                        <th scope="col" style="width:20%;">Type</th>
                                                                        <th scope="col" style="width:30%;">Value</th>
                                                                        <th scope="col" style="width:15%;">Created</th>
                                                                        <th scope="col" style="width:20%;" class="text-center">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php foreach ($incident_artifacts as $row): ?>
                                                                        <tr>

                                                                            <td><?php echo $row->name; ?></td>
                                                                            <?php if ($row->name == 'Payload') { ?>
                                                                                <td>
                                                                                    <div  class="jumbotron-fluid" style="word-wrap: break-word;overflow: auto; height: 150px;width: 600px;">
                                                                                        <?php echo $row->value; ?>

                                                                                    </div>
                                                                                </td>
                                                                            <?php } else {
                                                                                ?>
                                                                                <td>
                                                                                    <?php echo $row->value; ?> 
                                                                                </td>
                                                                            <?php } ?>
                                                                            <td><?php echo nice_date($row->created_date_incident, 'm/d/y'); ?></td>
                                                                            <td class="text-center">


                                                                                <button type="button" class="btn btn-outline-success rounded-circle" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></button>
                                                                                <button type="button" class="btn btn-outline-danger rounded-circle" data-toggle="tooltip" data-placement="top" title="Delete"><span class="fa fa-trash"></span></button>


                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>            
                                                        <?php } else { ?>
                                                            <!--if artifacts are greater than 10-->

                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-responsive-md" width="100%" id="dataTable" cellspacing="0">
                                                                    <thead class="thead-dark">
                                                                        <tr>
                                                                            <th scope="col" style="width:20%;">Type</th>
                                                                            <th scope="col" style="width:30%;">Value</th>
                                                                            <th scope="col" style="width:15%;">Created</th>
                                                                            <th scope="col" style="width:20%;" class="text-center">Actions</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        <?php foreach ($incident_artifacts as $row): ?>
                                                                            <tr>

                                                                                <td><?php echo $row->name; ?></td>
                                                                                <?php if ($row->name == 'Payload') { ?>
                                                                                    <td>
                                                                                        <div  class="jumbotron-fluid" style="word-wrap: break-word;overflow: auto; height: 150px;width: 600px;">
                                                                                            <?php echo $row->value; ?>

                                                                                        </div>
                                                                                    </td>
                                                                                <?php } else {
                                                                                    ?>
                                                                                    <td>
                                                                                        <?php echo $row->value; ?> 
                                                                                    </td>
                                                                                <?php } ?>
                                                                                <td><?php echo nice_date($row->created_date_incident, 'm/d/y'); ?></td>
                                                                                <td class="text-center">


                                                                                    <button type="button" class="btn btn-outline-success rounded-circle" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></button>
                                                                                    <button type="button" class="btn btn-outline-danger rounded-circle" data-toggle="tooltip" data-placement="top" title="Delete"><span class="fa fa-trash"></span></button>


                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                } // if with artifacts
                                                else {
                                                    ?>
                                                    <input type="hidden" name="incident_inc" value="0">
                                                    <div style="padding-top: 1em;" class="secret-div">
                                                        <table class="table table-hover" >
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col" style="width: 25%;">Type</th>
                                                                    <th scope="col">Value</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($artifacts_type as $row): ?>
                                                                    <tr>

                                                                        <td><?php echo $row->name; ?></td>
                                                                        <td>
                                                                            <?php if ($row->name == 'Source IP Address - Source Geolocation') { ?>
                                                                                <div class="form-row">
                                                                                    <div class="col">
                                                                                        <div class="form-group ">
                                                                                            <input type="text" class="form-control" name="source_ip_address"  id="source_ip_address" placeholder="Source IP Address">

                                                                                        </div>


                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <div class="form-group">

                                                                                            <select class="form-control" name="source_geolocation" id="source_geolocation">
                                                                                                <option value="XX">Source Geolocation</option>
                                                                                                <?php
                                                                                                foreach ($countries as $row):
                                                                                                    echo '<option value="' . $row->iso . '" data-thumbnail="' . base_url('assets/img/flags/' . strtolower($row->iso) . '.png') . '">' . $row->nicename . '</option>';
                                                                                                endforeach;
                                                                                                ?>
                                                                                            </select>

                                                                                        </div>

                                                                                    </div>


                                                                                </div>
                                                                            <?php } elseif ($row->name == 'Payload') {
                                                                                ?>
                                                                                <div class="form-group">
                                                                                    <textarea class="form-control" id="payload" rows="4" name="payload"><?php echo set_value('payload'); ?></textarea>

                                                                                </div>

                                                                            <?php } else {
                                                                                ?>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" name="<?php echo $row->code; ?>" id="<?php echo $row->code; ?>" placeholder="<?php echo $row->name; ?>">

                                                                                </div>

                                                                            <?php } ?>


                                                                        </td>

                                                                    </tr>
                                                                <?php endforeach; ?> 
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php } // end of else (No artifacts)      ?>


                                            </div>
                                        </div>


                                    </div>


                                </div>
                                <div class="tab-pane fade" id="nav-tasks" role="tabpanel" aria-labelledby="nav-tasks-tab">

                                    <div style="padding-top: 1em;">
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                    </div>

                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
                                    <div style="padding-top: 1em;">
                                        <div class="row">

                                            <div class="col">
                                                <div class="card bg-light mb-3" style="height: 15em;">
                                                    <div class="card-body">
                                                        <h4 class="card-title"><span class="fa fa-bookmark"></span> General Details</h4>

                                                        <table class="table table-hover table-sm table-condensed">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:15%;"><span class="font-weight-bold">Description</span></td>

                                                                    <td><input type="hidden" name="prev_description" value="<?php echo $var[0]->description; ?>"><input type="text" name="description" value="<?php echo $var[0]->description; ?>" id="description" class="form-control needs-validation">
                                                                        <div class="invalid-feedback">
                                                                            Please provide a valid description
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:15%;"><span class="font-weight-bold">Offense ID</span></td>
                                                                    <td><input type="hidden" name="prev_offense_id" value="<?php echo $var[0]->offense_id; ?>"><textarea class="form-control needs-validation" id="offense_id" rows="3" name="offense_id"><?php echo $var[0]->offense_id; ?></textarea>
                                                                        <div class="invalid-feedback">
                                                                            Please provide a valid offense ID
                                                                        </div>
                                                                    </td>
                                                                </tr>




                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="card bg-light mb-3" style="height: 10em;">
                                                    <div class="card-body">
                                                        <h4 class="card-title"><span class="fa fa-braille"></span> Related Incidents</h4>


                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">


                                        </div>

                                        <div class="row">

<!--                                            <div class="col">
                                                <div class="card bg-light mb-3" style="height: 10em;">
                                                    <div class="card-body">
                                                        <h4 class="card-title"><span class="fa fa-braille"></span> Related Incidents</h4>

test
                                                    </div>
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <!--timeline-->
                                <div class="tab-pane fade" id="nav-timeline" role="tabpanel" aria-labelledby="nav-timeline-tab">

                                    <div style="padding-top: 1em;">
                                        <div class="row">

                                            <div class="col-lg-8">
                                                <div class="card bg-light mb-3" >
                                                    <div class="card-body">
                                                        <h4 class="card-title"><span class="fa fa-clock-o"></span> Incident Duration</h4>

                                                        <table class="table table-hover table-sm table-condensed">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:10%;"><span class="font-weight-bold">Monitoring</span></td>

                                                                    <td style="width:100%;">

                                                                        <div class="col-lg-9">

                                                                            <div class="row">

                                                                                <span class="font-weight-bold">Offense Start: &nbsp;</span> <?php echo $offense_start; ?>
                                                                            </div>
                                                                            <div class="row">
                                                                                <span class="font-weight-bold">Offense Reported:&nbsp; </span> <?php echo $date_created; ?> 
                                                                            </div>
                                                                            <div class="row">
                                                                                <span class="font-weight-bold">Monitoring Duration: &nbsp;</span> 
                                                                                <?php
                                                                                $datetime1 = new DateTime($offense_start);
                                                                                $datetime2 = new DateTime($date_created);
                                                                                $interval = $datetime1->diff($datetime2);

                                                                                $days = "";
                                                                                $hours = "";
                                                                                $minutes = "";
                                                                                $seconds = "";

                                                                                if ($interval->format('%d')) {
                                                                                    $days = $interval->format('%d') . " Days";
                                                                                }
                                                                                if ($interval->format('%h')) {
                                                                                    $hours = $interval->format('%h') . " Hours ";
                                                                                }
                                                                                if ($interval->format('%i')) {
                                                                                    $minutes = $interval->format('%i') . " Minutes ";
                                                                                }
                                                                                if ($interval->format('%s')) {
                                                                                    $seconds = $interval->format('%s') . " Seconds ";
                                                                                }
                                                                                echo $days . ' ' . $hours . ' ' . $minutes . ' ' . $seconds;

//                                                                                echo $interval->format('%d') . " Days, " . $interval->format('%h') . " Hours " . $interval->format('%i') . " Minutes " . $interval->format('%s') . " Seconds";
                                                                                ?>
                                                                            </div>
                                                                        </div>





                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:15%;"><span class="font-weight-bold">Triage</span></td>
                                                                    <td>
                                                                        <div class="col-lg-9">

                                                                            <div class="row">

                                                                                <span class="font-weight-bold">Triage Date: &nbsp;</span> <?php echo $date_triaged; ?>
                                                                            </div>
                                                                            <div class="row">
                                                                                <span class="font-weight-bold">Triage Duration:&nbsp; </span> 


                                                                                <?php
                                                                                if ($date_triaged != 'Unknown') {
                                                                                    $datetime1 = new DateTime($date_created);
                                                                                    $datetime2 = new DateTime($date_triaged);
                                                                                    $interval = $datetime1->diff($datetime2);

                                                                                    $days = "";
                                                                                    $hours = "";
                                                                                    $minutes = "";
                                                                                    $seconds = "";

                                                                                    if ($interval->format('%d')) {
                                                                                        $days = $interval->format('%d') . " Days";
                                                                                    }
                                                                                    if ($interval->format('%h')) {
                                                                                        $hours = $interval->format('%h') . " Hours ";
                                                                                    }
                                                                                    if ($interval->format('%i')) {
                                                                                        $minutes = $interval->format('%i') . " Minutes ";
                                                                                    }
                                                                                    if ($interval->format('%s')) {
                                                                                        $seconds = $interval->format('%s') . " Seconds ";
                                                                                    }
                                                                                    echo $days . ' ' . $hours . ' ' . $minutes . ' ' . $seconds;
//                                                                                    echo $interval->format('%d') . " Days, " . $interval->format('%h') . " Hours " . $interval->format('%i') . " Minutes " . $interval->format('%s') . " Seconds";
                                                                                } else {
                                                                                    echo 'Unknown';
                                                                                }
                                                                                ?>
                                                                            </div>

                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:15%;"><span class="font-weight-bold">Resolution</span></td>
                                                                    <td>
                                                                        <div class="col-lg-9">

                                                                            <div class="row">

                                                                                <span class="font-weight-bold">Resolved Date: &nbsp;</span> <?php echo $date_resolved; ?>
                                                                            </div>
                                                                            <div class="row">
                                                                                <span class="font-weight-bold">Resolution Duration:&nbsp; </span> 
                                                                                <?php
                                                                                if ($date_triaged == 'Unknown' && $date_resolved != 'Unknown') {
                                                                                    $datetime1 = new DateTime($date_created);
                                                                                    $datetime2 = new DateTime($date_resolved);
                                                                                    $interval = $datetime1->diff($datetime2);

                                                                                    $days = "";
                                                                                    $hours = "";
                                                                                    $minutes = "";
                                                                                    $seconds = "";

                                                                                    if ($interval->format('%d')) {
                                                                                        $days = $interval->format('%d') . " Days";
                                                                                    }
                                                                                    if ($interval->format('%h')) {
                                                                                        $hours = $interval->format('%h') . " Hours ";
                                                                                    }
                                                                                    if ($interval->format('%i')) {
                                                                                        $minutes = $interval->format('%i') . " Minutes ";
                                                                                    }
                                                                                    if ($interval->format('%s')) {
                                                                                        $seconds = $interval->format('%s') . " Seconds ";
                                                                                    }
                                                                                    echo $days . ' ' . $hours . ' ' . $minutes . ' ' . $seconds;
                                                                                } elseif ($date_triaged != 'Unknown' && $date_resolved != 'Unknown') {
                                                                                    $datetime1 = new DateTime($date_triaged);
                                                                                    $datetime2 = new DateTime($date_resolved);
                                                                                    $interval = $datetime1->diff($datetime2);

                                                                                    $days = "";
                                                                                    $hours = "";
                                                                                    $minutes = "";
                                                                                    $seconds = "";

                                                                                    if ($interval->format('%d')) {
                                                                                        $days = $interval->format('%d') . " Days";
                                                                                    }
                                                                                    if ($interval->format('%h')) {
                                                                                        $hours = $interval->format('%h') . " Hours ";
                                                                                    }
                                                                                    if ($interval->format('%i')) {
                                                                                        $minutes = $interval->format('%i') . " Minutes ";
                                                                                    }
                                                                                    if ($interval->format('%s')) {
                                                                                        $seconds = $interval->format('%s') . " Seconds ";
                                                                                    }
                                                                                    echo $days . ' ' . $hours . ' ' . $minutes . ' ' . $seconds;
                                                                                } else {
                                                                                    echo 'Unknown';
                                                                                }
                                                                                ?>
                                                                            </div>

                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:15%;"><span class="font-weight-bold">Response</span></td>
                                                                    <td>
                                                                        <div class="col-lg-9">

                                                                            <div class="row">

                                                                                <span class="font-weight-bold">Close Date: &nbsp;</span> <?php echo $date_closed; ?>
                                                                            </div>
                                                                            <div class="row">
                                                                                <span class="font-weight-bold">Response Duration:&nbsp; </span> 
                                                                                <?php
                                                                                if ($date_resolved != 'Unknown') {
                                                                                    $datetime1 = new DateTime($date_resolved);
                                                                                    $datetime2 = new DateTime($date_closed);
                                                                                    $interval = $datetime1->diff($datetime2);

                                                                                    $days = "";
                                                                                    $hours = "";
                                                                                    $minutes = "";
                                                                                    $seconds = "";

                                                                                    if ($interval->format('%d')) {
                                                                                        $days = $interval->format('%d') . " Days";
                                                                                    }
                                                                                    if ($interval->format('%h')) {
                                                                                        $hours = $interval->format('%h') . " Hours ";
                                                                                    }
                                                                                    if ($interval->format('%i')) {
                                                                                        $minutes = $interval->format('%i') . " Minutes ";
                                                                                    }
                                                                                    if ($interval->format('%s')) {
                                                                                        $seconds = $interval->format('%s') . " Seconds ";
                                                                                    }
                                                                                    echo $days . ' ' . $hours . ' ' . $minutes . ' ' . $seconds;
//                                                                                    echo $interval->format('%d') . " Days, " . $interval->format('%h') . " Hours " . $interval->format('%i') . " Minutes " . $interval->format('%s') . " Seconds";
                                                                                } else {
                                                                                    echo 'Unknown';
                                                                                }
                                                                                ?>
                                                                            </div>

                                                                        </div>
                                                                    </td>
                                                                </tr>




                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="card bg-light mb-3">

                                                <div class="card-body">
                                                    <h4><span class="fa fa-comment"></span> Incident Log</h4>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <ul class="timeline">
                                                                <?php foreach ($incident_log as $log): ?>


                                                                    <?php
                                                                    $icon = "";
                                                                    $log_title = "";
                                                                    if (strpos($log->content, 'created')) {

                                                                        $log_title = "<span class='text-primary'><span class='fa fa-upload'></span> Creation</span>";
                                                                    } elseif (strpos($log->content, 'added artifacts') || strpos($log->content, 'added additonal artifact')) {

                                                                        $log_title = "<span class='text-success'><span class='fa fa-plus-circle'></span> Added Artifacts </span>";
                                                                    } elseif (strpos($log->content, 'modified status')) {

                                                                        $log_title = "<span class='text-danger'><span class='fa fa-share-alt'></span> Modified Status</span>";
                                                                    } elseif (strpos($log->content, 'append')) {

                                                                        $log_title = "<span class='text-success'><span class='fa fa-plus-circle'></span> Appended Offense </span>";
                                                                    } elseif (strpos($log->content, 'modified severity')) {

                                                                        $log_title = "<span class='text-warning'><span class='fa fa-fire'></span> Modified Severity</span>";
                                                                    } elseif (strpos($log->content, 'modified verdict')) {

                                                                        $log_title = "<span class='text-warning'><span class='fa fa-gavel'></span> Modified Verdict</span>";
                                                                    } elseif (strpos($log->content, 'assigned')) {

                                                                        $log_title = "<span class='text-info'><span class='fa fa-user'></span> Assign </span>";
                                                                    } elseif (strpos($log->content, 'modified offense ID')) {

                                                                        $log_title = "<span class='text-success'> <span class='fa fa-edit'></span> Modified Offense ID</span>";
                                                                    } elseif (strpos($log->content, 'modified description')) {
                                                                        $log_title = "<span class='text-success'> <span class='fa fa-edit'></span> Modified Description</span>";
                                                                    }
                                                                    ?>

                                                                    <li>
                                                                        <hr>
                                                                        <a  href="#"><?php echo $log_title ?></a>
                                                                        <a href="#" class="float-right"><?php echo nice_date($log->datetime, 'm/d/y , H:i:s'); ?></a>

                                                                        <p>
                                                                            <small class="text-muted"><span class="fa fa-clock-o"></span> <?php echo time_elapsed_string($log->datetime); ?></small><br/>
                                                                            <?php echo $log->content; ?></p>
                                                                    </li>



                                                                <?php endforeach; ?>


                                                            </ul>
                                                        </div>
                                                    </div>






                                                </div>

                                            </div>
                                        </div>
                                    </div>












                                </div>
                                <div class="tab-pane fade" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                                    <?php
                                    print_r($var);
//                                    print_r($incidenttype);
//                                    print_r($creator);
//                                    print_r($result);
                                    ?>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        <?php } //end of else                             ?>
    </div>
    <!--end of container fluid-->
</div>
<!--end of content wrapper-->

<!-- Change status Modal -->
<div class="modal fade" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="status_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="prev_status" value="<?php echo $var[0]->status_id; ?>">
                    <select class="form-control" name="status">
                        <option value="2" <?php echo ($var[0]->status_id == 2) ? 'selected' : ''; ?>>In Progress</option>
                        <option value="3" <?php echo ($var[0]->status_id == 3) ? 'selected' : ''; ?>>Pending</option>
                        <option value="4" <?php echo ($var[0]->status_id == 4) ? 'selected' : ''; ?>>SLAHOLD</option>
                        <option value="5" <?php echo ($var[0]->status_id == 5) ? 'selected' : ''; ?>>Resolved</option>
                        <option value="6" <?php echo ($var[0]->status_id == 6) ? 'selected' : ''; ?>>Closed</option>
                        <option value="7" <?php echo ($var[0]->status_id == 7) ? 'selected' : ''; ?>>Cancelled</option>
                        <option value="8" <?php echo ($var[0]->status_id == 8) ? 'selected' : ''; ?>>Rejected</option>
                    </select>

                </div>
                <div class="form-group input-group">
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest" >
                        <!--<div class="input-group-prepend"><span class="input-group-text">Offense Start</span></div>-->
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" name="change_status_datetime" value="<?php echo set_value('change_status_datetime'); ?>" />
                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <div class="input-group-text" ><i class="fa fa-calendar"></i></div>

                        </div>
                    </div>
                    <div id="change_status_datetime">

                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="4" name="change_status_notes" id="change_status_notes" placeholder="Please indicate the reason for change of status."></textarea>
                </div>
                <div class="invalid-feedback">
                    Please provide a valid reason
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                <!--            <a class="btn btn-primary" href="login.html">Logout</a>-->

            </div>
        </div>
    </div>
</div>


<!-- Change status Modal -->
<div class="modal fade" id="severity_modal" tabindex="-1" role="dialog" aria-labelledby="severity_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Severity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="prev_severity" value="<?php echo $var[0]->severity_id; ?>">
                    <select class="form-control" name="severity">
                        <option value="1" <?php echo ($var[0]->severity_id == 1) ? 'selected' : ''; ?>>Low</option>
                        <option value="2" <?php echo ($var[0]->severity_id == 2) ? 'selected' : ''; ?>>Medium</option>
                        <option value="3" <?php echo ($var[0]->severity_id == 3) ? 'selected' : ''; ?>>High</option>
                    </select>


                </div>
                <div class="form-group">
                    <input type="hidden" name="prev_priority" value="<?php echo $var[0]->priority_id; ?>">
                    <select class="form-control" name="priority">
                        <option value="1" <?php echo ($var[0]->priority_id == 1) ? 'selected' : ''; ?>>P1</option>
                        <option value="2"<?php echo ($var[0]->priority_id == 2) ? 'selected' : ''; ?> >P2</option>
                        <option value="3" <?php echo ($var[0]->priority_id == 3) ? 'selected' : ''; ?>>P3</option>
                        <option value="4" <?php echo ($var[0]->priority_id == 4) ? 'selected' : ''; ?>>P4</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="3" name="change_severity_notes" id="change_severity_notes" placeholder="Please indicate the reason for change of severity."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                <!--            <a class="btn btn-primary" href="login.html">Logout</a>-->

            </div>
        </div>
    </div>
</div>
<!--change verdict modal-->
<div class="modal fade" id="verdict_modal" tabindex="-1" role="dialog" aria-labelledby="verdict_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Verdict</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="prev_verdict" value="<?php echo $var[0]->verdict_id; ?>">
                    <select class="form-control" name="verdict">
                        <option value="<?php echo ($var[0]->verdict_id); ?>" <?php echo ($var[0]->verdict_id == NULL) ? 'selected' : ''; ?>>Verdict</option>
                        <option value="1" <?php echo ($var[0]->verdict_id == 1) ? 'selected' : ''; ?>>Positive</option>
                        <option value="2" <?php echo ($var[0]->verdict_id == 2) ? 'selected' : ''; ?>>False Positive</option>
                        <option value="3" <?php echo ($var[0]->verdict_id == 3) ? 'selected' : ''; ?>>Benign</option>

                    </select>

                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="3" name="change_verdict_notes" id="change_verdict_notes" placeholder="Please indicate the reason for change of verdict."></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                <!--            <a class="btn btn-primary" href="login.html">Logout</a>-->

            </div>
        </div>
    </div>
</div>
<!--assign modal-->
<div class="modal fade" id="assign_modal" tabindex="-1" role="dialog" aria-labelledby="assign_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-truncate" id="exampleModalLabel"><?php echo ($assigned_user) ? 'Reassign' : 'Assign'; ?> <?php echo $var[0]->description; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php if ($assigned_user) { ?>

                        <input type="hidden" name="prev_assigned" value="<?php echo $assigned_user[0]->user_id; ?>">
                    <?php } else { ?>
                        <input type="hidden" name="prev_assigned" value="<?php print_r($assigned_user) ?>">
                    <?php }
                    ?>

                    <select class="form-control" name="assigned">
                        <option <?php echo ($assigned_user == 0) ? 'selected' : ''; ?> value="0"> Assign </option>
                        <?php foreach ($list_users as $user): ?>
                            <option value="<?php echo $user->user_id ?>"  
                            <?php
                            if ($assigned_user) {
                                echo ($assigned_user[0]->user_id == $user->user_id) ? 'selected' : '';
                            }
                            ?>

                                    ><?php echo $user->first_name . ' ' . $user->last_name; ?></option>
                                <?php endforeach; ?>

                    </select>

                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                <!--            <a class="btn btn-primary" href="login.html">Logout</a>-->

            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<div class="modal fade append_offense_one" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Append One Offense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open("Incident/append_offense"); ?>
                <div class="form-group">
                    <input type="hidden" name="num" value="1">
                    <input type="hidden" name="incident_type" value="<?php echo $incidenttype[0]->incident_type_id; ?>">
                    <input type="hidden" name="incident_id" value="<?php echo $var[0]->incident_id; ?>">
                    <input type="text" class="form-control" placeholder="Offense ID" name="offense_id">
                </div>
                <div class="form-group">
                    <?php
                    switch ($incidenttype[0]->incident_type_id):
                        case 33:
                            echo '<div class="form-group">';
                            echo '<input type="text" class="form-control" name="source_ip_address" placeholder="Source IP Address">';
                            echo '</div><div class="form-group">';
                            echo '<input type="text" class="form-control" name="destination_ip_address" placeholder="Destination IP Address">';
                            echo '</div>';
                            break;
                        case 31:
                            echo '<div class="form-group">';
                            echo '<input type="text" class="form-control" name="source_ip_address" placeholder="Source IP Address">';
                            echo '</div><div class="form-group">';
                            echo '<input type="text" class="form-control" name="destination_ip_address" placeholder="Destination IP Address">';
                            echo '</div>';
                            break;
                        case 19:
                            echo '<div class="form-group">';
                            echo '<input type="text" class="form-control" name="source_ip_address" placeholder="Source IP Address">';
                            echo '</div><div class="form-group">';
                            echo '<input type="text" class="form-control" name="ips_signature" placeholder="IPS Signature">';
                            echo '</div>';
                            break;
                        case 28:
                            echo '<div class="form-group">';
                            echo '<input type="text" class="form-control" name="malware_variant" placeholder="Malware Variant">';
                            echo '</div><div class="form-group">';
                            echo '<input type="text" class="form-control" name="source_ip_address" placeholder="Source IP Address">';
                            echo '</div><div class="form-group">';
                            echo '<input type="text" class="form-control" name="source_hostname" placeholder="Source Hostname">';
                            echo '</div><div class="form-group">';
                            echo '<input type="text" class="form-control" name="infected_file_location" placeholder="Infected File Location">';
                            echo '</div>';
                            break;
                        case 30:
                            echo '<div class="form-group">';
                            echo '<input type="text" class="form-control" name="phishing_url" placeholder="Phishing URL">';
                            echo '</div><div class="form-group">';
                            echo '<input type="text" class="form-control" name="ip_address" placeholder="IP Address">';
                            echo '</div>';
                            break;
                        case 29:
                            echo '<div class="form-group">';
                            echo '<input type="text" class="form-control" name="source_ip_address" placeholder="Source IP Address">';

                            echo '</div>';
                            break;
                        case 32:
                            echo '<div class="form-group">';
                            echo '<input type="text" class="form-control" name="source_ip_address" placeholder="Source IP Address">';
                            echo '</div><div class="form-group">';
                            echo '<input type="text" class="form-control" name="username" placeholder="Username">';
                            echo '</div>';
                            break;
                        case 27:
                            echo '<div class="form-group">';
                            echo '<input type="text" class="form-control" name="source_ip_address" placeholder="Source IP Address">';
                            echo '</div><div class="form-group">';
                            echo '<input type="text" class="form-control" name="waf_attack_type" placeholder="WAF Attack Type">';
                            echo '</div>';
                            break;
                    endswitch;
                    ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="append_one">Append</button>

                <?php echo form_close(); ?>
                <!--            <a class="btn btn-primary" href="login.html">Logout</a>-->

            </div>
        </div>
    </div>
</div>


<div class="modal fade append_offense_multiple" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Append Multiple Offenses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<!--delete modal-->
<div class="modal fade" id="delete_inc_modal" tabindex="-1" role="dialog" aria-labelledby="delete_inc_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Incident</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this incident?
                <div class="form-group">
                    <textarea class="form-control" rows="3" name="change_verdict_notes" id="change_verdict_notes" placeholder="Please indicate the reason for change of verdict."></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                <!--            <a class="btn btn-primary" href="login.html">Logout</a>-->

            </div>
        </div>
    </div>
</div>


<!--add artifact modal-->
<div class="modal fade" id="add_artifact_mod" tabindex="-1" role="dialog" aria-labelledby="add_artifact_mod" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Artifact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open("Incident/add_artifact"); ?>
                <div class="form-group">

                    <input type="hidden" name="incident_id" value="<?php echo $var[0]->incident_id; ?>">
                    <select class="form-control" name="artifact_id">
                        <option value="0">Artifacts</option>
                        <?php foreach ($artifacts as $artifact): ?>
                            <option value="<?php echo $artifact->artifact_id ?>"><?php echo $artifact->name; ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="value" placeholder="Value">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submit_artifact">Append</button>


                <!--            <a class="btn btn-primary" href="login.html">Logout</a>-->
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>