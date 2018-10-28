<div class="content-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                 <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Administration'); ?>">Administration</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Users'); ?>">People</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Users/manage_users'); ?>">Users</a></li>

                        <li class="breadcrumb-item active" >Add User</li>
                    </ol>
                </nav>
                
                <hr>
            </div>

        </div>
        <div class="row">
            <?php echo form_open('Users/add_user'); ?>
            <div class="col-md-12">


                <button type="submit" class="btn btn-outline-success"> <span class="fa fa-save"></span> Save </button>
                <a href="<?php echo base_url('index.php/Users/manage_users'); ?>" class="btn btn-outline-danger"> <span class="fa fa-close"></span> Cancel </a>

            </div>


        </div>





        <div class="row">
            <div class="col-lg-12" style="padding-top: .5em;">
                <div class="card bg-light mb-3" >
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">

                                <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?php echo set_value('username'); ?>" required="">
                            </div>
                            <div class="form-group col-md-3">

                                <input type="password" class="form-control" id="password" placeholder="Password" name="password" value="<?php echo set_value('password'); ?>" required="">
                            </div>
                            <div class="form-group col-md-3">

                                <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password" value="<?php echo set_value('confirm_password'); ?>" required="">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">

                                <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" value="<?php echo set_value('first_name'); ?>" required="">
                            </div>
                            <div class="form-group col-md-3">

                                <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo set_value('last_name'); ?>" required="">
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">

                                <input type="text" class="form-control" id="position" placeholder="Position" name="position" value="<?php echo set_value('position'); ?>" required="">
                            </div>
                            <div class="form-group col-md-3">

                                <select class="form-control" name="role" required="">
                                    <option value=""> Role </option>
                                    <?php if ($temp) { ?>
                                        <option value="admin" <?php echo set_select('role', 'admin') ?>> Administrator </option>
                                        <option value="analyst" <?php echo set_select('role', 'analyst') ?>> Analyst </option>
                                    <?php } else { ?>
                                        <option value="admin" > Administrator </option>
                                        <option value="analyst" > Analyst </option>

                                    <?php } ?>
                                </select>
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label><strong>Groups</strong></label>
                                <select multiple class="form-control" id="exampleFormControlSelect2" name="groups[]" required="">
                                    <?php
                                    foreach ($groups as $row):
                                        if (!empty($temp)) {
                                            if (in_array($row->group_id, $temp['groups'])) {
                                                echo '<option value="' . $row->group_id . '"' . set_select('groups[]', $row->group_id, TRUE) . '">' . $row->name . ' </option>';
                                            } else {
                                                echo '<option value="' . $row->group_id . '"' . set_select('groups[]', $row->group_id) . '">' . $row->name . ' </option>';
                                            }
                                        } else {
                                            echo '<option value="' . $row->group_id . '"' . set_select('groups[]', $row->group_id) . '">' . $row->name . ' </option>';
                                        }
                                    endforeach;
                                    ?>


                                </select>
                            </div>
                        </div>

                    </div>


                </div>

                <?php echo form_close(); ?>

            </div>
        </div>
        <?php if (validation_errors()): ?>
            <div class="row">

                <div class="col-md-6">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> <?php echo validation_errors(); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

            </div>

        <?php endif; ?>

       


    </div>
    <!--end of container fluid-->
</div>
<!--end of content wrapper-->