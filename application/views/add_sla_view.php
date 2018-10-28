<div class="content-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Administration'); ?>">Administration</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/System_Settings'); ?>">System Settings</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/System_Settings/SLA_View'); ?>">SLA View</a></li>
                        <li class="breadcrumb-item active" >Add SLA</li>
                    </ol>
                </nav>
                <hr>
            </div>

        </div>
        <div class="row">
            <?php echo form_open('System_Settings/add_sla'); ?>
            <div class="col-md-12">


                <button type="submit" class="btn btn-outline-success"> <span class="fa fa-save"></span> Save </button>
                <a href="<?php echo base_url('index.php/System_Settings/sla_view'); ?>" class="btn btn-outline-danger"> <span class="fa fa-close"></span> Cancel </a>

            </div>


        </div>





        <div class="row">
            <div class="col-lg-12" style="padding-top: .5em;">
                <div class="card bg-light mb-3" >
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">

                                <input type="text" class="form-control" id="phase" placeholder="Phase Name" name="phase" value="<?php echo set_value('phase'); ?>" required="" maxlength="30">
                            </div>
                           

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">

                                <textarea class="form-control" id="description" placeholder="Description" name="description" maxlength="250"><?php echo set_value('description'); ?></textarea>
                            </div>
                            


                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-3">

                                <input type="number" class="form-control" id="warning_hours" placeholder="Warning Hours" name="warning_hours" value="<?php echo set_value('warning_hours'); ?>" required="" maxlength="4">
                            </div>
                            <div class="form-group col-sm-3">

                                <input type="number" class="form-control" id="warning_hours" placeholder="Actual Hours" name="actual_hours" value="<?php echo set_value('actual_hours'); ?>" required="" maxlength="4">
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