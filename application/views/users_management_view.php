<div class="content-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Administration'); ?>">Administration</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Users'); ?>">People</a></li>

                        <li class="breadcrumb-item active" >Users</li>
                    </ol>
                </nav>
                
                <hr>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-6">
                <a href="<?php echo base_url('index.php/Users/add_user_view'); ?>" class="btn btn-outline-primary"> <span class="fa fa-plus-circle"></span> Add User </a>
            </div>
            <?php
            if ($success):
                ?>
                <div class="col-md-6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> A user was successfully added!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>    

        </div>
        <div class="row">
            <div class="col-lg-12" style="padding-top: .5em;">
                <div class="card bg-light mb-3" >
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered " width="100%" id="dataTable" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center" style="width:7%;">User ID</th>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Position</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Status</th>
                                        <th style="width:9%;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($users as $row): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $row->user_id; ?></td>
                                            <td class="text-center"><?php echo $row->username; ?></td>
                                            <td class="text-center"><?php echo $row->first_name . ' ' . $row->last_name; ?></td>

                                            <td class="text-center"><?php echo $row->position; ?></td>
                                            <td class="text-center"><?php echo $row->role; ?></td>
                                            <td class="text-center"><?php echo ($row->status == 1) ? 'Active' : 'Disabled'; ?></td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url('index.php/Users/edit_user_view/' . $row->user_id); ?>" class="btn btn-outline-success rounded-circle" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></a>



                                            </td>
                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>







            </div>
        </div>
    </div>
    <!--end of container fluid-->
</div>
<!--end of content wrapper-->