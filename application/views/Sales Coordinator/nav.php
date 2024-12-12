<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
      <li class="nav-item d-none d-sm-inline-block">
        <a href="Dashboard" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block"> 
      
      <button type="button" class="btn btn-primary" onclick="goBack()">Go Back</button>
      <button type="button" class="btn btn-secondary" onclick="goForward()">Go Forward</button>
        
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      
      <!-- Messages Dropdown Menu
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            
            <div class="media">
              <img src="<?=base_url();?>assets/image/user/Team.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  User 1
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            
            <div class="media">
              <img src="<?=base_url();?>assets/image/user/Team.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                User 2
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            
            <div class="media">
              <img src="<?=base_url();?>assets/image/user/Team.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                User 3
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>-->
      <!-- Notifications Dropdown Menu -->
      <h4>HI!  <?=$user['name']?></h4>
      <input type="hidden" id="ur_id" value="<?=$uid?>">
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url();?>/Menu/Notification">
          <i class="far fa-bell"></i>
          <?php
          $udetail = $this->Menu_model->get_userbyid($uid);
          $admid = $udetail[0]->admin_id;
          $notify=$this->Menu_model->notify($uid);?>
          <span class="badge badge-warning navbar-badge"><?=sizeof($notify);?></span>
        </a> 
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <img src="https://stemlearning.in/wp-content/uploads/2020/07/stem-new-logo-2-1.png" width="80%" class="p-3">
    <center><h5 class="text-white"><b>STEM APP</b></h5></center>
    <hr>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=base_url();?>assets/image/user/Team.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
               <div class="info">
      <?php $userName=$this->Menu_model->get_userName($uid);?>

        <a href="<?=base_url();?>Menu/myProfile" class="d-block"><?=$userName[0]->name?></a>

      </div>

      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/Dashboard" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="<?= base_url(); ?>Management/CheckingDayManagement_New">
          <i class="fas fa-chart-line nav-icon"></i>
          <!-- <p>Day Check Report</p> -->
          Day Check Management
          </a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="<?= base_url(); ?>Menu/TaskCheck_New">
          <i class="fas fa-chart-bar nav-icon"></i>
          <!-- <p>Task Check Report</p> -->
          Task Check Management
          </a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="<?= base_url(); ?>Management/DayManagementReport">
          <i class="fas fa-chart-line nav-icon"></i>

          <!-- <p>Day Check Report</p> -->
          Day Check Report
          </a>

          </li>
          <li class="nav-item">

          <a class="nav-link" href="<?= base_url(); ?>Menu/TaskCheck_NewReport">
          <i class="fas fa-chart-bar nav-icon"></i>

          <!-- <p>Task Check Report</p> -->
          Task Check Report

          </a>

          </li>

          <li class="nav-item">
                    <a href="<?=base_url();?>Menu/DayManagement" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Day Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=base_url();?>Menu/YesterDayDaysCloseRequest" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Day Close Request</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=base_url();?>Menu/GetTodaysTeamDayChnageRequestData" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Day Change Request</p>
                    </a>
                </li>
                <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Analysis
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Task Graph
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/StatusWiseTaskAnalysis" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Status Wise Task Analysis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/ActionWiseFunnelAnalysis" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Action Wise Funnel Analysis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/OtherUserOnFunnelAnalysis" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Other User On Funnel Analysis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/TimeSlotWiseTaskAnalysis" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Time Slot Wise Task Analysis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/ActionWiseTaskConversion" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Action Wise Task Conversion</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/StatusWiseTaskConversion" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Status Wise Task Conversion</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/TaskWiseDetailAnalysis" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Task Wise Detail Analysis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/StatusWiseTaskConversion" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Status Wise Task Conversion</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Funnel Graph
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/FunnelAnalysis" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Funnel Analysis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/CityWiseFunnelAnalysis" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>City Wise Funnel Analysis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/PartnerWiseFunnelAnalysis" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Partner Wise Funnel Analysis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/CategoryWiseFunnelAnalysis" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Category Wise Funnel Analysis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/CompanyWithSameStatusSinceFunnleAnalysis" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Company With Same Status Analysis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/StageWiseFunnleAnalysis" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Stage Wise Funnle Analysis</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        R Graph
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/BDRequest" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>BD Request</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>GraphNew/PendingRIDDayWise" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>RID Day Wise</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Level 3</p>
                            </a>
                        </li> -->
                    </ul>
                </li>
            </ul>
                </li>
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/LiveTaskTracking" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Live Task Tracking</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/HandBIND" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Handover to Installation</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/NewFunnel" >
              <i class="far fa-circle nav-icon"></i>
              <p>New Funnel Added</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/CategoryStatusPage" >
              <i class="far fa-circle nav-icon"></i>
              <p>Category Wise Status</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/AllReviewPlaing" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>All Review</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/Mytarget" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>My Target</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/ReviewReport" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Review Report</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/DayStartCheck" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Day Start Check</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/DayCloseCheck" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Day Close Check</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>/Menu/TodaysTaskApprovelRequest" >
              <i class="far fa-circle nav-icon"></i>
              <p>Planner Approvel Request</p>
            </a>
          </li>
          <li class="nav-item">
              <a href="<?=base_url();?>Menu/PlannerTaskApprovelPage" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Planner Task Approvel</p>
              </a>
          </li>
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/SpecialRequestForLeaveSomeTimeData" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Team Special Request For Leave Some Time </p>
            </a>
        </li>
          <!--<li class="nav-item">
            <a href="<?=base_url();?>Menu/MeetingCheck" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Meeting Review</p>
            </a>
          </li>-->
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/BDReviewReportSummary" >
              <i class="far fa-circle nav-icon"></i>
              <p>BD Review Summary</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>/Management/CheckingDayManagement" >
              <i class="far fa-circle nav-icon"></i>
              <p>Day Management System</p>
            </a>
          </li>
        
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/TaskCheck" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Task Check</p>
            </a>
          </li>
          
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/DayManagement" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Day Management</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/logout" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      
      
      
      <hr>
  
  <hr><center><lable class="text-warning"><b>Alert!</b></lable></center><hr>
      <span id="alsmss"></span>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
    <?php 
        if(!isset($daycheck)){
            // echo "hii";die;
            $current_uid    = $user['user_id'];
            // var_dump(($current_uid));die;
            // echo $current_uid;die;
            $user_type = $user['type_id'];
            $user_day = $this->Menu_model->get_daydetail($current_uid,date("Y-m-d"));
            // var_dump(sizeof($user_day));die;
            // echo sizeof($user_day);die;
            if(sizeof($user_day) == 0){
                $this->session->set_flashdata('error_message','* Please start your day first');
                redirect('Menu/DayManagement');
            }  
        }    

        // $current_uid    = $user['user_id'];

        // $checkDayCheck = $this->Menu_model->get_checkDayCheck($current_uid,date("Y-m-d"));
        // // var_dump(sizeof($checkDayCheck) );die;
        // $checkTaskCheck = $this->Menu_model->get_checkTaskCheck($current_uid,date("Y-m-d"));

        // if(sizeof($checkDayCheck) == 0){
    
        //     $this->session->set_flashdata('error_message','* Please Complete Day Check first');
        //     if ($this->uri->uri_string() !== 'Management/CheckingDayManagement_New') {
        //         redirect('Management/CheckingDayManagement_New');
        //     }
        //     // redirect('Management/CheckingDayManagement_New');
        // }
        // if(sizeof($checkTaskCheck) == 0){

        //     $this->session->set_flashdata('error_message','* Please Complete Task Check first');
        //     if ($this->uri->uri_string() !== 'Menu/TaskCheck_New') {
        //         redirect('Menu/TaskCheck_New');
        //     }
        //     // redirect('Menu/TaskCheck_New');
        // }  


        // if(isset($daycheck)){
        //     // echo "die";die;
        //     // var_dump($daycheck);die;
        //     $current_uid    = $user['user_id'];

        //     $user_type = $user['type_id'];

        //     $checkDayCheck = $this->Menu_model->get_checkDayCheck($current_uid,date("Y-m-d"));
    
        //     $checkTaskCheck = $this->Menu_model->get_checkTaskCheck($current_uid,date("Y-m-d"));
    
        //     if(sizeof($checkDayCheck) == 0){
    
        //         $this->session->set_flashdata('error_message','* Please Complete Day Check first');
        //         // redirect('Management/CheckingDayManagement_New');
        //     }
        //     if(sizeof($checkTaskCheck) == 0){
    
        //         $this->session->set_flashdata('error_message','* Please Complete Task Check first');
        //         // redirect('Menu/TaskCheck_New');
        //     }  
        // }

    ?>
  
  <script src="<?=base_url();?>assets/js/jquery.min.js"></script>

<!-- Bootstrap Bundle (includes Popper) -->
<script src="<?=base_url();?>assets/js/bootstrap.bundle.min.js"></script>

<!-- ChartJS -->
<script src="<?=base_url();?>assets/js/Chart.min.js"></script>

<!-- Sparkline -->
<script src="<?=base_url();?>assets/js/sparkline.js"></script>

<!-- JQVMap -->
<script src="<?=base_url();?>assets/js/jquery.vmap.min.js"></script>
<script src="<?=base_url();?>assets/js/jquery.vmap.usa.js"></script>

<!-- jQuery Knob Chart -->
<!-- <script src="plugins/jquery-knob/jquery.knob.min.js"></script> -->

<!-- daterangepicker -->
<script src="<?=base_url();?>assets/js/moment.min.js"></script>
<script src="<?=base_url();?>assets/js/daterangepicker.js"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url();?>assets/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Summernote -->
<script src="<?=base_url();?>assets/js/summernote-bs4.min.js"></script>

<!-- overlayScrollbars -->
<script src="<?=base_url();?>assets/js/jquery.overlayScrollbars.min.js"></script>

<!-- DataTables & Plugins -->
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

<!-- Daterangepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<!-- Daterangepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script> 
$(document).ready(function() {
    trackLocation();
});
function handleGeolocationError() {
   const bodyElement = document.querySelector("body");
   bodyElement.style.display = "none";
   alert('Error: Geolocation is not available or location services are turned off.');
}
function handleGeolocationSuccess(position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;
    const contentDiv = document.getElementById("content");
    contentDiv.style.display = "block";
}
function getLocation() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(handleGeolocationSuccess, handleGeolocationError);
    } else {
        const errorMessage = document.getElementById("error-message");
        errorMessage.style.display = "block";
    }
}
window.onload = getLocation;
function startCamera() {
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
        })
        .catch(function(error) {
             const bodyElement = document.querySelector("body");
             bodyElement.style.display = "none";
             alert('Error: Camera access permission denied.');
        });
}
startCamera();
function trackLocation() {
    if ("geolocation" in navigator) {
      navigator.geolocation.getCurrentPosition(
        function (position) {
          var ur_id = document.getElementById("ur_id").value;
          var latitude = position.coords.latitude;
          var longitude = position.coords.longitude;
            $.ajax({
                url:'<?=base_url();?>Menu/store_location',
                 method: 'post',
                 data: {latitude: latitude, longitude: longitude, ur_id: ur_id},
                 success: function(result){
                }
            });
        },
        function (error) {
          console.error("Error getting location: " + error.message);
        }
      );
    } 
    else {console.error("Geolocation is not supported by this browser.");} 
}
function goBack() { window.history.back(); }
function goForward() { window.history.forward(); }
  
    var ur_id = document.getElementById("ur_id").value;

    $.ajax({
        url:'<?=base_url();?>Menu/adminpopup',
        method: 'post',
        data: {ur_id: ur_id},
        success: function(result){
            var res = result;
            $("#alsmss").html(result);
        }
    });
    
</script> 
  
