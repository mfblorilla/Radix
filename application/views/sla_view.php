<div class="content-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Administration'); ?>">Administration</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/System_Settings'); ?>">System Settings</a></li>

                        <li class="breadcrumb-item active" >SLA View</li>

                    </ol>
                </nav>
                <hr>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-6">
                <a href="<?php echo base_url('index.php/System_Settings/add_sla_view'); ?>" class="btn btn-outline-primary"> <span class="fa fa-plus-circle"></span> Add SLA </a>
            </div>
            <?php
            if ($response == 1):
                ?>
                <div class="col-md-6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> SLA added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>    
           <?php if ($response == 2):
                ?>
                <div class="col-md-6">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        SLA has been successfully deleted.
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

                                        <th class="text-center">SLA ID</th>
                                        <th class="text-center">Phase</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Warning Hour</th>
                                        <th class="text-center">Actual Hour</th>
                                        <th style="width:9%;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($sla as $row): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $row->sla_id; ?></td>
                                            <td class="text-center"><?php echo $row->phase; ?></td>
                                            <td ><?php echo $row->description; ?></td>

                                            <td class="text-center"><?php echo $row->warning_hour; ?></td>
                                            <td class="text-center"><?php echo $row->actual_hour; ?></td>


                                            <td class="text-center">
                                                <a href="<?php echo base_url('index.php/System_Settings/edit_sla_view/' . $row->sla_id); ?>" class="btn btn-outline-success rounded-circle" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></a>
                                                <button type="button"  class="btn btn-outline-danger rounded-circle delete-sla" id="<?php echo $row->sla_id . ' - ' . $row->phase; ?>" data-toggle="modal"  data-target="#delete_modal"><span class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></span></button>



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



<!-- Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete SLA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <span id="sla_content"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="hidden" id="token_name" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <button type="button" class="btn btn-danger" id="confirm_delete_sla">Yes</button>
            </div>
        </div>
    </div>
</div>

