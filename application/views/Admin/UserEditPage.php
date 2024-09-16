<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="wi$dth=device-wi$dth, initial-scale=1">
<title>STEM APP | WebAPP</title>
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?=base_url();?>assets/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?=base_url();?>assets/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="<?=base_url();?>assets/css/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="<?=base_url();?>assets/css/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?=base_url();?>assets/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?=base_url();?>assets/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?=base_url();?>assets/css/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="<?=base_url();?>assets/css/summernote-bs4.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url();?>assets/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url();?>assets/css/buttons.bootstrap4.min.css">
<style>
.scrollme {
overflow-x: auto;
}
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<!-- Preloader -->

<!-- Navbar -->
<?php require('nav.php');?>
<!-- /.navbar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
<div class="container-fluid">

<div class="container">
    <?php
        if ($this->session->flashdata('success_message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong> <?php echo $this->session->flashdata('success_message'); ?></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
        <?php
            if ($this->session->flashdata('error_message')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong> <?php echo $this->session->flashdata('error_message'); ?></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
</div>
<!-- Main content -->
<section class="content">
<div class="container-fluid">
    <form id="regForm" method="POST" action="<?=base_url();?>Menu/UserRegistration">
            <section class="gradient-custom">
                <div class="container py-5">
                    <div class="row justify-content-center align-items-center ">
                    <div class="col-md-12">
                        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Update User Details for : <span style="color: red;"><?=$userDetails[0]->name?></span></h3>

                            <div class="row">
                                <div class="col-md-6 mb-4">

                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="name"> Name</label>
                                    <input type="text" id="name" name="name" class="form-control form-control-lg" value="<?= isset($userDetails) ? $userDetails[0]->name : '' ?>" />
                                    <input type="hidden" id="user_id" name="user_id" value="<?= $userId ?>" />
                                    
                                </div>

                                </div>
                                <div class="col-md-6 mb-4">

                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" id="email" name="email" class="form-control form-control-lg" value="<?= isset($userDetails) ? $userDetails[0]->email : '' ?>"/>
                                    
                                </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4 d-flex align-items-center">

                                <div data-mdb-input-init class="form-outline datepicker w-100">
                                    <label for="Username" class="form-label">Username</label>
                                    <input type="text" class="form-control form-control-lg" name="Username" id="Username" value="<?= isset($userDetails) ? $userDetails[0]->username : '' ?>"/>
                                    
                                </div>

                                </div>

                                <div class="col-md-6 mb-4 d-flex align-items-center">

                                <div data-mdb-input-init class="form-outline datepicker w-100">
                                    <label for="joiningDate" class="form-label">Joining Date</label>
                                    <input type="date" class="form-control form-control-lg" name="joiningDate" id="joiningDate" value="<?= isset($userDetails) ? $userDetails[0]->usercreateDate : '' ?>"/>
                                    
                                </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4 align-items-center">

                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="phone">Phone number</label>
                                    <input type="number" class="form-control form-control-lg" name="phone" id="phone" value="<?= isset($userDetails) ? $userDetails[0]->phoneno : '' ?>"/>
                                    
                                </div>

                                </div>

                                <div class="col-md-4 mb-4 align-items-center">
                                    <label class="form-label">Inside</label>
                                    <div class="form-check form-check-inline ms-3">
                                        <input class="form-check-input" type="radio" name="inside" id="option1" value="1" <?php if($userDetails[0]->inside == '1') echo 'checked'; ?>>
                                        <label class="form-check-label" for="option1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inside" id="option2" value="0" <?php if($userDetails[0]->inside == '0') echo 'checked'; ?>>
                                        <label class="form-check-label" for="option2">No</label>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4  align-items-center">

                                    <label for="zone" class="form-label">Zone</label>
                                    <select class="select form-control" id="zone" name="zone">
                                        <option value="" disabled selected>Choose zone</option>
                                        <?php foreach($zone as $val) { ?>
                                            <option value="<?= $val->id ?>" <?php if($userDetails[0]->zone_id == $val->id) echo 'selected'; ?>>
                                                <?= $val->name ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4  align-items-center">
                                <label for="type" class="form-label">User Type</label>

                                <select class="select form-control" id="type" name="type">
                                    <option value="" disabled selected>Choose User Type</option>
                                    <?php foreach($type as $val){?>
                                    <option value="<?=$val->id?>" <?php if($userDetails[0]->type_id == $val->id) echo 'selected'; ?>><?=$val->name?></option>
                                    <?php }?>
                                </select>
                                </div>

                                <div class="col-md-6 mb-4  align-items-center">
                                <label for="type" class="form-label">Admin</label>

                                <select class="select form-control" id="admin" name="admin">
                                    <option value="" disabled selected>Choose Admin</option>
                                    <?php foreach($admin as $val){?>
                                    <option value="<?=$val->user_id?>" <?php if($userDetails[0]->aadmin == $val->user_id) echo 'selected'; ?>><?=$val->name?></option>
                                    <?php }?>
                                </select>
                                </div>
                            </div>

                            <div class ="row">

                                <div class="col-md-6 mb-4  align-items-center" id="clusterManager">
                                    <label for="cluster" class="form-label">Cluster Manager</label>

                                    <select class="select form-control" name="cluster" id="cluster">
                                        <option value="" disabled selected>Choose CLuster Manager</option>
                                        <?php foreach($clusterManager as $val){?>
                                        <option value="<?=$val->user_id?>" <?php if($userDetails[0]->aadmin == $val->user_id) echo 'selected'; ?>><?=$val->name?></option>
                                        <?php }?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4  align-items-center" id="bdpst">
                                    <label for="bdpstF" class="form-label">BDPST</label>
                                    <select class="select form-control" name="bdpstF" id="bdpstF">
                                        <option value="" disabled selected>Choose BDPST</option>
                                        <?php foreach($bdpst as $val){?>
                                        <option value="<?=$val->user_id?>" <?php if($userDetails[0]->aadmin == $val->user_id) echo 'selected'; ?>><?=$val->name?></option>
                                        <?php }?>
                                    </select>
                                    
                                </div>
                            </div>

                        
                            <div class="row" id="showFields">
                                
                                <div class="col-md-6 mb-4  align-items-center">
                                    <label for="sales" class="form-label">Sales Coordinator</label>
                                    <select class="select form-control" name="sales" id="sales">
                                        <option value="" disabled selected>Choose Sales-Coordinator</option>
                                        <?php foreach($salesCoordinator as $val){?>
                                        <option value="<?=$val->user_id?>" <?php if($userDetails[0]->sales_co == $val->user_id) echo 'selected'; ?>><?=$val->name?></option>
                                        <?php }?>
                                    </select>
                                    
                                
                                </div>

                                <div class="col-md-6 mb-4  align-items-center">
                                    <label for="pst" class="form-label">PST</label>
                                    <select class="select form-control" name="pst" id="pst">
                                        <option value="" disabled selected>Choose PST</option>
                                        <?php foreach($pst as $val){?>
                                        <option value="<?=$val->user_id?>" <?php if($userDetails[0]->pst_co == $val->user_id) echo 'selected'; ?>><?=$val->name?></option>
                                        <?php }?>
                                    </select>
                                    
                                
                                </div>
                            </div>
                           <div class="mt-4 pt-2">
                                <input data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit" value="Submit" />
                            </div>

                        
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </section>
        </form>
</div>
<!-- /.container-fluid -->
</section>
</div></div>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- <script>
    $(document).ready(function() {
        // Function to show the fields
        function showFields() {
            $('#showFields').removeClass('d-none');
        }

        function hideBdpst() {
            $('#bdpst').addClass('d-none');
        }

        function hideCluster() {
            $('#clusterManager').addClass('d-none');
        }

        // Call this function when you need to show the fields
        // Example: on a button click
        $('#clusterManager').on('click', function() {
            hideBdpst();
            showFields();
        });

        $('#bdpst').on('click', function() {
            hideCluster();
        });

    });
</script> -->

<footer class="main-footer">
<strong>Copyright &copy; 2021-2022 <a href="<?=base_url();?>">Stemlearning</a>.</strong>
All rights reserved.
<div class="float-right d-none d-sm-inline-block">
<b>Version</b> 1.0
</div>
</footer>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url();?>assets/js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=base_url();?>assets/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?=base_url();?>assets/js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?=base_url();?>assets/js/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?=base_url();?>assets/js/jquery.vmap.min.js"></script>
<script src="<?=base_url();?>assets/js/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=base_url();?>assets/js/moment.min.js"></script>
<script src="<?=base_url();?>assets/js/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url();?>assets/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?=base_url();?>assets/js/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url();?>assets/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>assets/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url();?>assets/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url();?>assets/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url();?>assets/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url();?>assets/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url();?>assets/js/jszip.min.js"></script>
<script src="<?=base_url();?>assets/js/pdfmake.min.js"></script>
<script src="<?=base_url();?>assets/js/vfs_fonts.js"></script>
<script src="<?=base_url();?>assets/js/buttons.html5.min.js"></script>
<script src="<?=base_url();?>assets/js/buttons.print.min.js"></script>
<script src="<?=base_url();?>assets/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url();?>assets/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=base_url();?>assets/js/dashboard.js"></script>

</body>
</html>