<div class="content-wrapper">

    <div class="container-fluid">



        <div class="row">
            <div class="col-lg-9">
                <h1 >Add Incident</h1>

            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-3">
                <?php echo form_open('Incident/add_incident'); ?>
                <div class="input-group mb-3">
                    <select class="form-control" name="status" required=""> 
                        <?php
                        for ($x = 0; $x <= 2; $x++) {
                            if ($x == 1) {
                                $name = 'Queued';
                            } elseif ($x == 2) {
                                $name = 'In Progress';
                            } else {
                                $name = 'Status';
                            }
                            echo '<option value="' . $x . '"' . set_select('status', $x, ($temp['status'] === $x) ? TRUE : FALSE) . '>' . $name . '</option>';
                        }
                        ?>

                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" id="submit_btn"><span class="fa fa-send"></span> Submit</button>

                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->
        <div class="container-fluid">
            <hr>

            <h4 >General Details</h4>
            <div class="row">
                <div class="col-lg-3">

                    <div class="form-group">

                        <select class="form-control" name="incident_type" id="incident_type" required="">
                            <option value="">Incident Type</option>
                            <?php
                            foreach ($incident_type as $row):
                                if ($temp['incident_type'] == $row->incident_type_id) {
                                    echo '<option value="' . $row->incident_type_id . ' "' . set_select('incident_type', $row->incident_type_id, TRUE) . '">' . $row->name . '</option>';
                                } else {
                                    echo '<option value="' . $row->incident_type_id . ' "' . set_select('incident_type', $row->incident_type_id) . '">' . $row->name . '</option>';
                                }

                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">

                        <input type="text" name="description" class="form-control" value="<?php echo set_value('description'); ?>" id="FormControlInput1" placeholder="Description i.e. Multiple Exploit Attempts" aria-describedby="basic-addon2" required="" maxlength="255">



                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" name="maximo_incident_id" class="form-control" placeholder="Maximo Incident ID" value="<?php echo set_value('maximo_incident_id'); ?>" required="" maxlength="10">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" name="offense_id" class="form-control"  placeholder="Offense ID" value="<?php echo set_value('offense_id'); ?>" required="" maxlength="255">
                        </div>
                    </div>



                    <div class="form-group input-group">
                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                            <div class="input-group-prepend"><span class="input-group-text">Offense Start</span></div>
                            <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" name="offense_start" value="<?php echo set_value('offense_start'); ?>" required=""/>
                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>







                </div>
                <div class="col-lg-3">
                    <div class="form-group">


                        <div class="btn-group btn-group-toggle input-group" data-toggle="buttons">
                            <div class="input-group-prepend"><span class="input-group-text">Severity</span></div>
                            <label class="btn btn-outline-success">
                                <input type="radio" name="severity" id="option1" autocomplete="off" value="1" required=""> Low
                            </label>
                            <label class="btn btn-outline-warning">
                                <input type="radio" name="severity" id="option2" autocomplete="off" value="2" required=""> Medium
                            </label>
                            <label class="btn btn-outline-danger">
                                <input type="radio" name="severity" id="option3" autocomplete="off" value="3" required=""> High
                            </label>

                        </div>

                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend"><span class="input-group-text">Priority</span></div>
                        <select class="form-control" name="priority" required="">
                            <option value="">Priority</option>
                            <?php
                            foreach ($priority as $row):
                                if ($temp['priority'] == $row->priority_id) {
                                    echo '<option value="' . $row->priority_id . '"' . set_select('priority', $row->priority_id, TRUE) . '">' . $row->name . '</option>';
                                } else {
                                    echo '<option value="' . $row->priority_id . '"' . set_select('priority', $row->priority_id) . '">' . $row->name . '</option>';
                                }
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Groups Involved</label>
                        <select multiple class="form-control" id="exampleFormControlSelect2" name="groups_involved[]" required="">
                            <?php
                            foreach ($groups as $row):
                                if (!empty($temp)) {
                                    if (in_array($row->group_id, $temp['groups_involved'])) {
                                        echo '<option value="' . $row->group_id . '"' . set_select('groups_involved[]', $row->group_id, TRUE) . '">' . $row->name . ' </option>';
                                    } else {
                                        echo '<option value="' . $row->group_id . '"' . set_select('groups_involved[]', $row->group_id) . '">' . $row->name . ' </option>';
                                    }
                                } else {
                                    echo '<option value="' . $row->group_id . '"' . set_select('groups_involved[]', $row->group_id) . '">' . $row->name . ' </option>';
                                }
                            endforeach;
                            ?>


                        </select>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="form-group">

                        <textarea class="form-control" id="notes_textarea" rows="4" placeholder="Notes" name="notes" maxlength="255"><?php echo set_value('notes'); ?></textarea>
                    </div>
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo validation_errors(); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>



                </div>
            </div>
            <!--row for details-->

<!--            <hr>
            <div class="row">
                <div class="col-lg-9">
                    <h4> Artifacts</h4>

                </div>

            </div>-->
            <!--row for artifacts-->
<!--            <div class="row">

                <div class="col-lg-12" style="padding-top: 20px;">



                    <div class="card" style="padding-top: 1em;" >
                        <div class="card-body">
                            <div id="change_div">

                                <p class="text-center lead">Please Select Incident Type</p>
                            </div>
                        </div>

                    </div>




                </div>


            </div>-->
            <!--row-->

            <div class="row" style="padding-top: 30px;">
                <div class="col-lg-10">

                </div>
                <div class="col-lg-2">

                </div>
            </div>

        </div>

        <!--end of container fluid-->
    </div>
    <!--end of content wrapper-->

    <?php echo form_close(); ?>