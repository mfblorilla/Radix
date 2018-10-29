<div class="content-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('index.php/Administration'); ?>">Administration</a></li>
                        <li class="breadcrumb-item active" >People</li>
                    </ol>
                </nav>
                
                
             
                <hr>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-user"></i>
                        </div>
                        <div class="mr-5">
                            Users
                        </div>
                    </div>
                    <a href="<?php echo base_url('index.php/Users/manage_users'); ?>" class="card-footer text-white clearfix small z-1">
                        <span class="float-left">Manage</span>
                        <span class="float-right">
                            <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-users"></i>
                        </div>
                        <div class="mr-5">
                           Groups
                        </div>
                    </div>
                    <a href="<?php echo base_url('index.php/Users/manage_groups'); ?>" class="card-footer text-white clearfix small z-1">
                        <span class="float-left">Manage</span>
                        <span class="float-right">
                            <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
            


    </div>
    <!--end of container fluid-->
</div>
<!--end of content wrapper-->