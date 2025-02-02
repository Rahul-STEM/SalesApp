<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul id="notifications"></ul>

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

    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="image">

          <img src="<?=base_url();?>assets/image/user/Team.jpg" class="img-circle elevation-2" alt="User Image">

        </div>

        <div class="info">
        <?php 
$userName=$this->Menu_model->get_userName($uid);?>

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
                <a href="<?=base_url();?>Menu/DayManagement" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Day Management</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url(); ?>Management/CheckingDayManagement_New">
                    <i class="fas fa-chart-line nav-icon"></i>
                    <!-- <p>Day Check Management</p> -->
                    Day Check Management
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url(); ?>Management/ApproveDayCheckRequest">
                    <i class="fas fa-chart-line nav-icon"></i>
                    <!-- <p>Day Check Report</p> -->
                    Approve Day Check Request
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url(); ?>Menu/ApproveTaskCheckRequest">
                    <i class="fas fa-chart-line nav-icon"></i>
                    <!-- <p>Day Check Report</p> -->
                    Approve Task Check Request
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
                <a class="nav-link" href="<?= base_url(); ?>Menu/TaskCheck_New">
                    <i class="fas fa-chart-bar nav-icon"></i>
                    <!-- <p>Task Check Management</p> -->
                    Task Check Management
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
                <a class="nav-link" href="<?=base_url();?>Menu/NewFunnel" >
                <i class="far fa-circle nav-icon"></i>
                    <p>New Funnel Added</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        User Management
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url(); ?>Menu/UserRegistration">
                        <i class="far fa-circle nav-icon"></i>
                        <p>User Entry Form</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url(); ?>Menu/UserDisplayPage">
                        <i class="far fa-circle nav-icon"></i>
                        <p>User Details</p>
                        </a>
                    </li>
                </ul>
            </li>

          
            <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-circle"></i>
                    <p>
                        Requests
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>
                                Task Planner Requests
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=base_url();?>Menu/TodaysTaskApprovelRequest" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Task Planner Start Request</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=base_url();?>Menu/PlannerTaskApprovelPage" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Planner Task Approval</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>
                                    Day Requests
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=base_url();?>Menu/YesterDayDaysCloseRequest" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Day Close Request</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=base_url();?>Menu/dayShiftStartReq" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Late Shift Start Request</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=base_url();?>Menu/GetTodaysTeamDayChnageRequestData" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Day Change Request</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=base_url();?>Menu/leaveApproval" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Leave Requests</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?=base_url();?>Menu/NotworkCompanyBDPST" >
                <i class="far fa-circle nav-icon"></i>
                <p>Not Work Company by BDPST</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?=base_url();?>Management/HolidayList" >
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage Holiday List</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?=base_url();?>Menu/CategoryStatusPage" >
                    <i class="far fa-circle nav-icon"></i>
                    <p>Category Wise Status</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?=base_url();?>Menu/TeamDailyReport/<?=date('Y-m-d')?>" >
                    <i class="far fa-circle nav-icon"></i>
                    <p>Team Daily Report</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?=base_url();?>Menu/TodaysTaskApprovelRequest" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Task Approval Request</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?=base_url();?>Menu/AllReviewPlaing" >
                    <i class="far fa-circle nav-icon"></i>
                    <p>Plan BD Review</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?=base_url();?>Menu/targetVsAchievedData" >
                    <i class="far fa-circle nav-icon"></i>
                    <p>Target vs Achived Data Report</p>
                </a>
            </li>

          

            <li class="nav-item">
                <a class="nav-link" href="<?=base_url();?>Menu/AllPSTReviewPlaing" >
                    <i class="far fa-circle nav-icon"></i>
                    <p>Plan PST Review</p>
                </a>
            </l>

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/ReviewReport" >

              <i class="far fa-circle nav-icon"></i>

              <p>All Review Report</p>

            </a>

          </li>

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/PSTReviewReportSummary" >

              <i class="far fa-circle nav-icon"></i>

              <p>PST Review Summary</p>

            </a>

          </li>

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/BDReviewReportSummary" >

              <i class="far fa-circle nav-icon"></i>

              <p>BD Review Summary</p>

            </a>

          </li>

          

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/NOREVIEWCOMP" >

              <i class="far fa-circle nav-icon"></i>

              <p>No Review Company</p>

            </a>

          </li>

          <!-- <li class="nav-item">

            <a href="<?=base_url();?>Menu/TaskCheck" class="nav-link">

              <i class="far fa-circle nav-icon"></i>

              <p>Task Check</p>

            </a>

          </li> -->

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/BDWORKBWDBYTC" >

              <i class="far fa-circle nav-icon"></i>

              <p>Work B/W Date</p>

            </a>

          </li>

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/RPTHISYEAR" >

              <i class="far fa-circle nav-icon"></i>

              <p>RP This Year</p>

            </a>

          </li>

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/BDNotWorkDD" >

              <i class="far fa-circle nav-icon"></i>

              <p>NO Work B/W Date</p>

            </a>

          </li>

          

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/PSTWorkOnRPCompanies" >

              <i class="far fa-circle nav-icon"></i>

              <p>PST Work On RP Companies (Newly Assigned) </p>

            </a>

          </li>

          

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/PSTWorkOnRPALLCompanies" >

              <i class="far fa-circle nav-icon"></i>

              <p>PST Work On RP Companies (All Assigned)</p>

            </a>

          </li>

          

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/PSTWorkOnRPPACompanies" >

              <i class="far fa-circle nav-icon"></i>

              <p>PST Work On RP Companies (Previously Assigned)</p>

            </a>

          </li>

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/AllUtilisation" >

              <i class="far fa-circle nav-icon"></i>

              <p>All Utilisation</p>

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

            <a class="nav-link" href="<?=base_url();?>Menu/ReviewPage" >

              <i class="far fa-circle nav-icon"></i>

              <p>Annual Review Report</p>

            </a>

          </li>

          

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/HumHongeTaiyarReportAdmin" >

              <i class="far fa-circle nav-icon"></i>

              <p>Hum Honge Taiyar Report</p>

            </a>

          </li>

          <li class="nav-item">

            <a class="nav-link" href="<?=base_url();?>Menu/HumHongeTaiyarReportApprove" >

              <i class="far fa-circle nav-icon"></i>

              <p>Hum Honge Taiyar Approve Report</p>

            </a>

          </li>
          <li class="nav-item">
                    <a href="<?=base_url();?>Menu/YesterDayDaysCloseRequest" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Day Close Request</p>
                    </a>
                </li>
          <li class="nav-item">
                    <a href="<?=base_url();?>Menu/needyourattention" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Need Your Attentions </p>
                    </a>
                </li>


          <li class="nav-item">

            <a href="<?=base_url();?>Menu/AssignTask" class="nav-link">

              <i class="far fa-circle nav-icon"></i>

              <p>Assign Task</p>

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

      <hr><center><lable class="text-warning"><b>Alert!</b></lable></center><hr>

      <span id="alsmss"></span>

    </div>

    <!-- /.sidebar -->

  </aside>

  

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script> 
<!-- jQuery UI -->
<script src="<?=base_url();?>assets/js/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<!-- jQuery -->
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

<script>
  //alert("Fuck");
  $(document).ready(function() {  
    //alert("inside");
    var admin_id = <?=$uid?>;
    console.log("Admin ID:", admin_id);
    
    checkNotifications(admin_id);
    
    setInterval(function() {
        checkNotifications(admin_id); 
    }, 10000); 
  });

  function checkNotifications(admin_id) {
    console.log("Checking notifications for admin_id: " + admin_id);
    $.ajax({
        url: '<?=base_url();?>Menu/check_notifications', 
        method: 'post',
        dataType: 'json', 
        data: { admin_id: admin_id },
        success: function(response) {

            if (response.length > 0) {
                response.forEach(function(notification) {
                  //console.log(notification);
                    alert('New Notification: ' + notification.sms);
                    markNotificationAsRead(notification.id); 
                });
            } else {
                console.log('No new notifications.');
            }
        },
        error: function(error) {
            console.error('Error fetching notifications:', error);
        }
    });
  }

  // Function to mark notifications as read
  function markNotificationAsRead(notificationId) {
    console.log("Marking notification as read, ID: " + notificationId);
    $.ajax({
        url: '<?=base_url();?>Menu/mark_notification_as_read', // Correct endpoint for marking as read
        method: 'post',
        data: { id: notificationId },
        dataType: 'json', // Expecting JSON data
        success: function() {
            console.log('Notification marked as read.');
        },
        error: function(error) {
            console.error('Error marking notification as read:', error);
        }
    });
  }
</script>


</script>  