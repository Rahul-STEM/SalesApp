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
body{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
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
<?php $managerName=$this->Menu_model->get_reportingManager($data[0]->aadmin);?>
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
 <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Apply for leave</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="leaveApply">
          <!-- From Date input -->
           <input type="hidden" name="aadmin" id="aadmin" value="<?=$data[0]->aadmin?>">
           <input type="hidden" name="uid" id="uid" value="<?=$uid?>">
          <div class="form-group">
            <label for="fromDate">From Date</label><span style="color:red">*</span>
            <input type="date" class="form-control" name="fromDate" id="fromDate" placeholder="Select from date" required>
          </div>

          <!-- To Date input -->
          <div class="form-group">
            <label for="toDate">To Date</label><span style="color:red">*</span>
            <input type="date" class="form-control" name="toDate" id="toDate" placeholder="Select to date" required>
          </div>

          <!-- Reason textarea input -->
          <div class="form-group">
            <label for="reason">Reason</label><span style="color:red">*</span>
            <textarea class="form-control" name="reason" id="reason" rows="3" placeholder="Enter the reason for leave" required></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
<section class="content">
<div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <div class="file btn btn-lg btn-primary">
                                Upload Photo
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        <?=$data[0]->name?>
                                    </h5>
                                    <h6>
                                    <?=$dep_name?>
                                    </h6>
                                    <p class="proile-rating">RANKINGS : <span>8/10</span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="leave-tab" data-toggle="tab" href="#leave" role="tab" aria-controls="leave" aria-selected="false">Leave management</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="day-tab" data-toggle="tab" href="#day" role="tab" aria-controls="day" aria-selected="false">Day Management</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="button" class="profile-edit-btn" name="btnAddMore" value="Edit Profile" 
                            onclick="window.location.href='<?= base_url(); ?>Menu/AdminEditAction/<?=$uid?>'"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>User Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$data[0]->username?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>User Id</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$data[0]->user_id?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$data[0]->name?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$data[0]->email?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$data[0]->phoneno?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Reporting Manager</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$managerName[0]->name?></p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Experience</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Expert</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Date Of Joining</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$data[0]->usercreateDate?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Zone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>230</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>My teams</label>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- <?php $count = $this->Menu_model->get_bdpstOrClusterTeams($uid); 
                                                       //echo $count;
                                                ?> -->
                                                <p><a href="<?=base_url();?>Menu/teamDetails"><?=$count[0]->teamsCount?></a></p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="leave" role="tabpanel" aria-labelledby="profile-tab">
                            <?php if($lvTypes){?>
                                <?php foreach($lvTypes as $val){?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><?=$val->leave_type?></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$val->balance?></p>
                                            </div>
                                        </div>
                                        <?php }?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Apply for leave</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><button id="applyButton" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                                Apply
                                                </button></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Leave Status</label>
                                            </div>
                                            <?php if($lvData){?>
                                            <div class="col-md-6">
                                                <p>Leave form <?=$lvData[0]->start_date?> to <?=$lvData[0]->end_date?> is <?=$lvData[0]->status?>.</p>     
                                            </div>
                                            <?php }else{?>
                                                <div class="col-md-6">
                                                <p>No leaves planned</p>     
                                            </div>
                                                <?php }?>
                                        </div>
                                        <?php }else{?>
                                            <h4>No leaves available</h4>
                                            <?php }?>
                            </div>
                            <div class="tab-pane fade" id="day" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Day Start</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$dayData[0]->ustart??'Day Yet to Start'?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Day End</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$dayData[0]->uclose??'Day Yet to Start'?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Tasks Planned</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$taskData[0]->allTasks?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Tasks Completed</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$taskData[0]->completed?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Tasks Pending</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?=$taskData[0]->pending?></p>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>
</section>
</div></div>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    $(document).ready(function() {
        // Event listener for form submission
        $('#regForm').on('submit', function(event) {
            var password = $('#password').val();
            var confirmPassword = $('#confirmPassword').val();

            if (password !== confirmPassword) {
                // Set the flash data in session using AJAX or display the message directly
                <?php $this->session->set_flashdata('error_message', 'Password Mismatch !!'); ?>

                // Optionally display the error message directly using jQuery
                alert('Password Mismatch !!');

                // Prevent the form from submitting
                event.preventDefault();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#zone').change(function() {
            var zoneId = $(this).val();
            if (zoneId) {
                // Fetch Cluster Managers
                $.ajax({
                    url: 'fetchClusterManagers',
                    type: 'POST',
                    dataType: 'json',
                    data: { zone_id: zoneId },
                    success: function(response) {
                        var clusterSelect = $('#cluster');
                        
                        // Clear existing options
                        clusterSelect.empty();

                        // Check if the response is an array and has data
                        if (Array.isArray(response) && response.length > 0) {
                            // Add default option
                            clusterSelect.append('<option value="" selected>Choose Cluster Manager</option>');
                            
                            // Add options from the response
                            $.each(response, function(index, item) {
                                clusterSelect.append('<option value="' + item.user_id + '">' + item.name + '</option>');
                            });
                        } else {
                            // Add "No data available" option
                            clusterSelect.append('<option value="" disabled selected>No data available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error: ", status, error);
                    }
                });

                // Fetch Sales Coordinators
                $.ajax({
                    url: 'fetchSalesCoordinators', 
                    type: 'POST',
                    dataType: 'json',
                    data: { zone_id: zoneId },
                    success: function(response) {
                        var salesSelect = $('#sales');
                        
                        // Clear existing options
                        salesSelect.empty();

                        // Check if the response is an array and has data
                        if (Array.isArray(response) && response.length > 0) {
                            // Add default option
                            salesSelect.append('<option value="" selected>Choose Sales Coordinator</option>');
                            
                            // Add options from the response
                            $.each(response, function(index, item) {
                                salesSelect.append('<option value="' + item.user_id + '">' + item.name + '</option>');
                            });
                        } else {
                            // Add "No data available" option
                            salesSelect.append('<option value="" disabled selected>No data available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error: ", status, error);
                    }
                });

                // Fetch BDPST
                $.ajax({

                    url: 'fetchBdpst', // Your URL to fetch BDPST
                    type: 'POST',
                    dataType: 'json',
                    data: { zone_id: zoneId },
                    success: function(response) {
                        var bdpstSelect = $('#bdpstF');
                        
                        // Clear existing options
                        bdpstSelect.empty();

                        // Check if the response is an array and has data
                        if (Array.isArray(response) && response.length > 0) {
                            // Add default option
                            bdpstSelect.append('<option value="" selected>Choose BDPST</option>');
                            
                            // Add options from the response
                            $.each(response, function(index, item) {
                                bdpstSelect.append('<option value="' + item.user_id + '">' + item.name + '</option>');
                            });
                        } else {
                            // Add "No data available" option
                            bdpstSelect.append('<option value="" disabled selected>No data available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error: ", status, error);
                    }
                });

                // Fetch PST
                $.ajax({
                    url: 'fetchPst',
                    type: 'POST',
                    dataType: 'json',
                    data: { zone_id: zoneId },
                    success: function(response) {
                        var pstSelect = $('#pst');
                        
                        // Clear existing options
                        pstSelect.empty();

                        // Check if the response is an array and has data
                        if (Array.isArray(response) && response.length > 0) {
                            // Add default option
                            pstSelect.append('<option value="" selected>Choose PST</option>');
                            
                            // Add options from the response
                            $.each(response, function(index, item) {
                                pstSelect.append('<option value="' + item.user_id + '">' + item.name + '</option>');
                            });
                        } else {
                            // Add "No data available" option
                            pstSelect.append('<option value="" disabled selected>No data available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error: ", status, error);
                    }
                });
            }
        });

    });
</script>

<script>
    $(document).ready(function() {
        // Call the function when the page is loaded and when the type field is changed
        $('#type').on('change', function() {
            toggleFields();
        });

        function toggleFields() {
            const userType = parseInt($('#type').val()); // Get the selected value of user type
            console.log(userType);
            const salesField = $('#sales');
            const pstField = $('#pst');
            const clusterField = $('#cluster');
            const bdpst = $('#bdpstF');

            // Enable all fields initially
            salesField.prop('disabled', false);
            pstField.prop('disabled', false);
            clusterField.prop('disabled', false);
            bdpst.prop('disabled', false);

            if ((userType === 2) || (userType === 1)) {
                salesField.prop('disabled', true);
                pstField.prop('disabled', true);
                clusterField.prop('disabled', true);
                bdpst.prop('disabled', true);
            } else if (userType === 15) {
                pstField.prop('disabled', true);
                clusterField.prop('disabled', true);
                bdpst.prop('disabled', true);
                salesField.prop('disabled', true);
            } else if (userType === 4) {
                clusterField.prop('disabled', true);
                bdpst.prop('disabled', true);
                //salesField.prop('disabled', true);
                pstField.prop('disabled', true);
            }else if (userType === 9) {
                clusterField.prop('disabled', true);
                bdpst.prop('disabled', true);
                salesField.prop('disabled', true);
                pstField.prop('disabled', true);
            }else if (userType === 13) {
                clusterField.prop('disabled', true);
                bdpst.prop('disabled', true);
                //salesField.prop('disabled', true);
                //pstField.prop('disabled', true);
            }else if (userType === 5) {
                clusterField.prop('disabled', true);
                //bdpst.prop('disabled', true);
                salesField.prop('disabled', true);
                pstField.prop('disabled', true);
            }
        }

        // Optionally trigger the function when the page is first loaded in case user type is pre-selected
        toggleFields();
    });
</script>
<script>
    function togglePassword(fieldId) {
        var passwordField = document.getElementById(fieldId);
        var toggleIcon = passwordField.nextElementSibling.querySelector('i');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>

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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta1/js/bootstrap.min.js"></script> -->

<!-- AdminLTE App -->
<script src="<?=base_url();?>assets/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=base_url();?>assets/js/dashboard.js"></script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script> -->


</body>
</html>