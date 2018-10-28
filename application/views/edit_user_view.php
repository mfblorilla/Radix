<div class="content-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Administration'); ?>">Administration</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Users'); ?>">People</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Users/manage_users'); ?>">Users</a></li>

                        <li class="breadcrumb-item active" >Edit User <?php echo ($user) ? $user[0]->username : ''; ?></li>
                    </ol>
                </nav>

                
                <hr>
            </div>

        </div>
        <div class="row">
            <?php echo form_open('Users/edit_user'); ?>
            <div class="col-md-12">

                <?php if ($user): ?>
                    <button type="submit" class="btn btn-outline-primary"> <span class="fa fa-save"></span> Update </button>
                <?php endif; ?>
                <a href="<?php echo base_url('index.php/Users/manage_users'); ?>" class="btn btn-outline-secondary"> <span class="fa fa-close"></span> Cancel </a>

            </div>


        </div>





        <div class="row">
            <div class="col-lg-12" style="padding-top: .5em;">
                <?php if ($user) { ?>
                    <?php echo form_open('Users/edit_user'); ?>
                    <input type="hidden" name="user_id" value="<?php echo $user[0]->user_id; ?>">
                    <div class="card bg-light mb-3" >
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-3">

                                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?php echo (set_value('username')) ? set_value('username') : $user[0]->username; ?>" required="" maxlength="12">
                                </div>
                                <div class="form-group col-md-3">

                                    <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" value="<?php echo (set_value('first_name')) ? set_value('first_name') : $user[0]->first_name; ?>" required="" maxlength="15">
                                </div>
                                <div class="form-group col-md-3">

                                    <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo (set_value('last_name')) ? set_value('last_name') : $user[0]->last_name; ?>" required="" maxlength="15">
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">

                                    <input type="text" class="form-control" id="position" placeholder="Position" name="position" value="<?php echo (set_value('position')) ? set_value('position') : $user[0]->position; ?>" required="" maxlength="30">
                                </div>
                                <div class="form-group col-md-3">

                                    <select class="form-control" name="role" required="">
                                        <option value=""> Role </option>
                                        <?php if ($user) { ?>
                                            <option value="admin" <?php
                                            if (set_select('role', 'admin')) {
                                                echo set_select('role', 'admin');
                                            } else {
                                                if ($user[0]->role == 'admin') {
                                                    echo 'selected';
                                                }
                                            }
                                            ?>> Administrator </option>
                                            <option value="analyst" <?php
                                            if (set_select('role', 'analyst')) {
                                                echo set_select('role', 'analyst');
                                            } else {
                                                if ($user[0]->role == 'analyst') {
                                                    echo 'selected';
                                                }
                                            }
                                            ?>> Analyst </option>
                                                <?php } else { ?>
                                            <option value="admin" > Administrator </option>
                                            <option value="analyst" > Analyst </option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <?php echo form_close(); ?>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label><strong>Groups</strong></label>
                                    <?php if ($group_member) { ?>
                                        <ul class="list-group">
                                            <?php for ($x = 0; $x < count($group_member); $x++): ?>

                                                <li class="list-group-item"><?php echo $group_member[$x]->group_name; ?></li>

                                            <?php endfor; ?>
                                        </ul>
                                    <?php } else { ?>
                                        <div class="jumbotron">
                                            <p class="lead text-center" >No groups involved</p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-row float-right">
                                <div class="btn-group" role="group">
                                    <a href="#" class="btn btn-outline-warning" data-toggle="modal" data-target="#reset_modal"><span class="fa fa-key"></span> Reset Password</a>
                                    <?php if ($user[0]->status == 1): ?>
                                        <a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#disable_account"><span class="fa fa-user-times"></span> Disable Account</a>
                                    <?php endif; ?>
                                    <?php if ($user[0]->status == 0): ?>
                                        <a href="#" class="btn btn-outline-success" data-toggle="modal" data-target="#disable_account"><span class="fa fa-check-circle"></span> Enable Account</a>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>


                    </div>
                <?php } else { ?>

                    <div class="jumbotron">
                        <h3 class="display-4">No such user. <span class="fa fa-frown-o"></span>  </h3>
                    </div>


                <?php } ?>

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
        <?php if ($response == 1): ?>
            <div class="row">

                <div class="col-md-6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> User has been successfully updated!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

            </div>
        <?php endif; ?>
        <?php if ($response == 2): ?>
            <div class="row">

                <div class="col-md-6">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> New password for <?php echo $user[0]->username; ?>. <span style="background-color: black;color: black;"><?php echo $pass; ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

            </div>
        <?php endif; ?>
        <?php if ($response == 3): ?>
            <div class="row">

                <div class="col-md-6">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> User <?php echo $user[0]->username; ?> has been disabled.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

            </div>
        <?php endif; ?>
        <?php if ($response == 4): ?>
            <div class="row">

                <div class="col-md-6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> User <?php echo $user[0]->username; ?> has been enabled.
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

<div class="modal fade" id="reset_modal" tabindex="-1" role="dialog" aria-labelledby="reset_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                Are you sure you want to reset the password of <?php echo $user[0]->username; ?>?



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <?php echo form_open('Users/resetPassword'); ?>
                <input type="hidden" name="user_id" value="<?php echo $user[0]->user_id; ?>">
                <button type="submit" class="btn btn-danger" >Reset</button>
                <?php echo form_close(); ?>

                <!--            <a class="btn btn-primary" href="login.html">Logout</a>-->

            </div>
        </div>
    </div>
</div>

<?php
if ($user[0]->status == 1) {
    $action = 0;
}
if ($user[0]->status == 0) {
    $action = 1;
}
?>


<div class="modal fade" id="disable_account" tabindex="-1" role="dialog" aria-labelledby="disable_account" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Disable Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to disable the account of <?php echo $user[0]->username; ?>?

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?php echo form_open('Users/EDuser'); ?>
                <input type="hidden" name="user_id" value="<?php echo $user[0]->user_id; ?>">
                <input type="hidden" name="axion" value="<?php echo $action; ?>">
                <button type="submit" class="btn <?php echo ($user[0]->status == 1) ? 'btn-danger' : 'btn-success'; ?>" ><?php echo ($user[0]->status == 1) ? 'Disable' : 'Enable'; ?></button>
                <?php echo form_close(); ?>

                <!--            <a class="btn btn-primary" href="login.html">Logout</a>-->

            </div>
        </div>
    </div>
</div>


