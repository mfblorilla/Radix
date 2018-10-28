<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($_SESSION['user_id'])) {
    redirect('Dashboard');
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/img/favicon.png" type="image/x-icon">
        <link rel="icon" href="<?php echo $base_url; ?>assets/img/favicon.png" type="image/x-icon">
        <title><?php echo $title; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo $base_url; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="<?php echo $base_url; ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Plugin CSS -->
        <link href="<?php echo $base_url; ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo $base_url; ?>assets/css/sb-admin.css" rel="stylesheet">

    </head>

    <body class="bg-dark">

        <div class="container">

