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
          <?php $notify=$this->Menu_model->notify($uid);?>
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

   <div class="user-panel mt-3 pb-3 mb-3 d-flex">

      <div class="image">

        <img src="<?=base_url();?>assets/image/user/Team.jpg" class="img-circle elevation-2" alt="User Image">

      </div>

      <div class="info">
      <?php $userName=$this->Menu_model->get_userName($uid);?>

        <a href="<?=base_url();?>Menu/myProfile" class="d-block"><?=$userName[0]->name?></a>

      </div>

    </div>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/Dashboard" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Dashboard</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/DayManagement" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Day Management</p>
            </a>
          </li>
       
           <li class="nav-item">
            <a href="<?=base_url();?>Menu/NewFunnel" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>New Funnel Added</p>
            </a>
          </li>
          
          <!--<li class="nav-item">
            <a href="<?=base_url();?>Menu/LiveTaskTracking" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Live Task Tracking</p>
            </a>
          </li>-->
          
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/pstnotassignc" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>PST Not Assign Company</p>
            </a>
          </li>
          
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/workdoneCompanyBDPST" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Work Done Company by BDPST</p>
            </a>
          </li>
         
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/NotworkCompanyBDPST" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Not Work Company by BDPST</p>
            </a>
          </li>
          
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/workbutactionnobd" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Work But Action No by BD</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/workbutactionnopst" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Work But Action No by PST</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/workOnClusterOnBDFunnels" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Work on Cluser of Bd Funnel</p>
            </a>
          </li>
          
          <?php 
          $tdate = date('Y-m-d');
          ?>
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/BDDayDetail/<?=$tdate?>/1" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Day Report</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/UserTaskViewPage" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Todays Task Status</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/AddSpecialCommentOnTask" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Add Special Comment On Task (Pending)</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/AddThanksCommentOnTask" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Add Thanks Comment On Task (Complete)</p>
            </a>
          </li>
          <li class="nav-item">
                    <a href="<?=base_url();?>Menu/SpecialRequestForLeaveSomeTime" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Our Special Request For Leave Some Time </p>
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
            <a href="<?=base_url();?>Menu/AllReviewPlaing" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>All Review Planning</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/cluster" >
              <i class="far fa-circle nav-icon"></i>
              <p>Add travel Cluster</p>
            </a>
          </li>
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link" href="<?=base_url();?>Menu/AddSchoolDetails" >-->
          <!--    <i class="far fa-circle nav-icon"></i>-->
          <!--    <p>Add School Details</p>-->
          <!--  </a>-->
          <!--</li>-->
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/AnnualReviewDet" >
              <i class="far fa-circle nav-icon"></i>
              <p>Annual Review</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/AnnualReviewReportData" >
              <i class="far fa-circle nav-icon"></i>
              <p>Annual Review Report</p>
            </a>
          </li>
          
          <!-- <li class="nav-item">
            <a href="<?=base_url();?>Menu/NewLead" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>New Lead</p>
            </a>
           </li>  -->
           
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Sales Kit</p>
            </a>
           </li>
           <li class="nav-item">
            <a href="<?=base_url();?>Menu/HumHongeTaiyar" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Hum Honge Taiyar</p>
            </a>
           </li>
           <li class="nav-item">
            <a href="<?=base_url();?>Menu/HumHongeTaiyarReport" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Hum Honge Taiyar Report</p>
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
      <!-- /.sidebar-menu -->
      
      
      
      <hr>
        <a href="AlertsPage"><button type="button" class="btn btn-danger">
            Alerts! <span class="badge badge-light">100</span>
        </button></a>
      <hr>
        <a href="NotificationPage"><button type="button" class="btn btn-success">
            Notification! <span class="badge badge-light">52</span>
        </button></a>
      <hr>
      
    </div>
    <!-- /.sidebar -->
  </aside>
  <?php 
      if(!isset($daycheck)){
        $current_uid    = $user['user_id'];
      $user_type = $user['type_id'];
      $user_day = $this->Menu_model->get_daydetail($current_uid,date("Y-m-d"));
      if(sizeof($user_day) == 0){
          $this->session->set_flashdata('error_message','* Please start your day first');
          redirect('Menu/DayManagement');
      }  
      }    
      ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script> 
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
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
    url:'<?=base_url();?>Menu/bdpopup',
     method: 'post',
     data: {ur_id: ur_id},
     success: function(result){
        var res = result;
        $("#alsmss").html(result);
    }
    });
    
    
    $.ajax({
    url:'<?=base_url();?>Menu/opalsms',
     method: 'post',
     data: {ur_id: ur_id},
     success: function(result){
        var res = result;
        $("#opalsms").html(result);
    }
    });
    
    
    $.ajax({
    url:'<?=base_url();?>Menu/nitisms',
     method: 'post',
     data: {ur_id: ur_id},
     success: function(result){
        var res = result;
        $("#nitisms").html(result);
    }
    });
</script>