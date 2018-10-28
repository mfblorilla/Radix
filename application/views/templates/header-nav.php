<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($_SESSION['user_id'])) {
    redirect('');
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="description" content="SOC Incident Management">
        <meta name="author" content="Miguel Lorilla">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url(); ?>assets/img/favicon.png" type="image/x-icon">
        <title><?php echo $title ?></title>

        <!-- Bootstrap core CSS -->

        <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Plugin CSS -->
        <link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
        <!--<link href="<?php // echo base_url(); ?>assets/vendor/country-picker-master/js/dependancies/bootstrap-select-1.12.4/dist/css/bootstrap-select.min.css" rel="stylesheet">-->






    </head>

    <body class="fixed-nav sticky-footer bg-dark" id="page-top">

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg  navbar-dark bg-dark fixed-top" id="mainNav">
            <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/Dashboard">Radix</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">


                    <li class="nav-item <?php echo ($nav == 'Dashboard') ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/Dashboard">
                            <i class="fa fa-fw fa-dashboard"></i>
                            <span class="nav-link-text">
                                Dashboard</span>
                        </a>
                    </li>


                    <li class="nav-item <?php echo ($nav == 'Incident' | $nav == 'Incident/add_incident') ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="right" title="Incidents Level">
                        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
                            <i class="fa fa-fw fa-shield"></i>
                            <span class="nav-link-text">
                                Incidents</span>
                        </a>
                        <ul class="sidenav-second-level collapse" id="collapseMulti">
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Incident/add_incident"><i class="fa fa-plus-circle"></i> Add Incident</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Incident"><i class="fa fa-file-archive-o"></i> List of Incidents</a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item <?php echo ($nav == 'Tasks') ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="right" title="My Tasks">
                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/Tasks">
                            <i class="fa fa-fw fa-tasks"></i>
                            <span class="nav-link-text">
                                My Tasks</span>
                        </a>
                    </li>

                    <li class="nav-item <?php echo ($nav == 'Playbook') ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="right" title="Playbook">
                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/Playbook">
                            <i class="fa fa-fw fa-sitemap"></i>
                            <span class="nav-link-text">
                                Playbook</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($nav == 'Reports') ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="right" title="Reports">
                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/Reports">
                            <i class="fa fa-fw fa-file"></i>
                            <span class="nav-link-text">
                                Reports</span>
                        </a>
                    </li>

                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <li class="nav-item nav-item <?php echo ($nav == 'Administration') ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="right" title="Administration">
                            <a class="nav-link" href="<?php echo base_url(); ?>index.php/Administration">
                                <i class="fa fa-fw fa-cogs"></i>
                                <span class="nav-link-text">
                                    Administration</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav sidenav-toggler">
                    <li class="nav-item">
                        <a class="nav-link text-center" id="sidenavToggler">
                            <i class="fa fa-fw fa-angle-left"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="#" class="badge badge-pill badge-light " style="margin-top:.75rem;"><?php echo $_SESSION['username']; ?></a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-bell"></i>
                            <span class="d-lg-none">Alerts
                                <span class="badge badge-pill badge-warning">6 New</span>
                            </span>
                            <span class="new-indicator text-warning d-none d-lg-block">
                                <i class="fa fa-fw fa-circle"></i>
                                <span class="number">6</span>
                            </span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">New Alerts:</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <span class="text-success">
                                    <strong>
                                        <i class="fa fa-long-arrow-up"></i>
                                        Status Update</strong>
                                </span>
                                <span class="small float-right text-muted">11:21 AM</span>
                                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <span class="text-danger">
                                    <strong>
                                        <i class="fa fa-long-arrow-down"></i>
                                        Status Update</strong>
                                </span>
                                <span class="small float-right text-muted">11:21 AM</span>
                                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <span class="text-success">
                                    <strong>
                                        <i class="fa fa-long-arrow-up"></i>
                                        Status Update</strong>
                                </span>
                                <span class="small float-right text-muted">11:21 AM</span>
                                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item small" href="#">
                                View all alerts
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-user"></i>
                            <span class="d-lg-none">User Settings
                                <span class="badge badge-pill badge-warning">6 New</span>
                            </span>

                        </a>
                        <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">User Settings:</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <span class="text-primary">
                                    <strong>
                                        <i class="fa fa-address-card"></i>
                                        My Profile</strong>
                                </span>

                                <div class="dropdown-message small">View and edit your Profile</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <span class="text-primary">
                                    <strong>
                                        <i class="fa fa-key"></i>
                                        Change Password</strong>
                                </span>

                                <div class="dropdown-message small">Let's you change your password.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#exampleModal">
                                <span class="text-primary">
                                    <strong>
                                        <i class="fa fa-fw fa-sign-out"></i>

                                        Logout

                                    </strong>
                                </span>
                                <div class="dropdown-message small">Ends your current session.</div>
                            </a>



                        </div>
                    </li>
                    <li class="nav-item">
                        <form class="form-inline my-2 my-lg-0 mr-lg-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </li>




                </ul>
            </div>
        </nav>

