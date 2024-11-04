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
      
      
      <!-- Notifications Dropdown Menu -->
      <h4>HI!  <?=$user['name']?></h4>
      <input type="hidden" id="ur_id" value="<?=$uid?>">
      <li class="nav-item">
      <a class="nav-link" href="<?=base_url();?>/Menu/Notification">
        <i class="far fa-bell fa-2x" style="color: green;"></i> <!-- Increased the bell icon size with fa-2x -->
        <?php $notify = $this->Menu_model->notify($uid); ?>
        <?php if(sizeof($notify)>0){?>
        <span class="badge badge-danger navbar-badge" id="notification" style="display:block; font-size: 1.2em; padding: 5px 8px;">
            <?= sizeof($notify); ?>
        </span>
        <?php } ?>
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

      </div></div>
      
      
      
      
      <a href="https://meet.google.com/vbk-btki-wcw" class="btn btn-primary" target="_blank">Handover Timeline Link</a>
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
            <a href="<?=base_url();?>Menu/HandBIND" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Handover to Installation</p>
            </a>
          </li>
          
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/NewLead" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Add New Lead</p>
            </a>
          </li>
          
          
          <!--<li class="nav-item">
            <a href="<?=base_url();?>Menu/HandBINDDetail/6" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Installation Detail</p>
            </a>
          </li>-->
          
          
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
                <a href="<?=base_url();?>Menu/PlannerTaskApprovelPage" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Planner Task Approvel</p>
                </a>
          </li>
            
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/TodaysTaskApprovelRequest" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Todays Task Approvel Request</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/SpecialRequestForLeaveSomeTimeData" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Team Special Request For Leave Some Time </p>
            </a>
        </li>
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/Mytarget" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>My Target</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?=base_url();?>Menu/assignpst" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>RP Check</p>
            </a>
          </li>
          
          <!--<li class="nav-item">-->
          <!--  <a href="<?=base_url();?>Menu/AddFAQ" class="nav-link">-->
          <!--    <i class="far fa-circle nav-icon"></i>-->
          <!--    <p>Add FAQ</p>-->
          <!--  </a>-->
          <!--</li>-->
          <!--<li class="nav-item">-->
          <!--  <a href="<?=base_url();?>Menu/FAQReport" class="nav-link">-->
          <!--    <i class="far fa-circle nav-icon"></i>-->
          <!--    <p>FAQ Report</p>-->
          <!--  </a>-->
          <!--</li>-->
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
            <a class="nav-link" href="<?=base_url();?>Menu/AllReviewPlaing" >
              <i class="far fa-circle nav-icon"></i>
              <p>All Review</p>
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/cluster" >
              <i class="far fa-circle nav-icon"></i>
              <p>Add travel Cluster</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/AnnualReviewDet" >
              <i class="far fa-circle nav-icon"></i>
              <p>Annual Review</p>
            </a>
          </li>
         
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link" href="<?=base_url();?>Menu/AnnualReviewReport" >-->
          <!--    <i class="far fa-circle nav-icon"></i>-->
          <!--    <p>Annual Review Report</p>-->
          <!--  </a>-->
          <!--</li>-->
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/AnnualReviewReportDatabkp" >
              <i class="far fa-circle nav-icon"></i>
              <p>Annual Review Report</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/ReviewReport" >
              <i class="far fa-circle nav-icon"></i>
              <p>Review Report</p>
            </a>
          </li>
          
          
          <li class="nav-item">
            <a class="nav-link" href="<?=base_url();?>Menu/CategoryStatusPage" >
              <i class="far fa-circle nav-icon"></i>
              <p>Category Wise Status</p>
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
      <!-- /<hr><center><lable class="text-warning"><b>Alert!</b></lable></center><hr>
      <span id="alsmss"></span>
    </div>
    <!-- /.sidebar -->
  <hr><center><lable class="text-warning"><b>Alert!</b></lable></center><hr>
      <span id="alsmss"></span>
      <hr><center><lable class="text-warning"><b>Opration Update!</b></lable></center><hr>
      <span id="opalsms"></span>
      <hr><center><lable class="text-warning"><b>Notification!</b></lable></center><hr>
      <span id="nitisms"></span>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<script>
  $(document).ready(function() {  
    //alert("inside");
    var admin_id = <?=$uid?>;
    console.log("Admin ID:", admin_id);
    
    //checkNotifications(admin_id, false);
    
    setInterval(function() {
        checkNotifications(admin_id, true);
    }, 60000);
  });

  let shownNotifications = [];

  function checkNotifications(admin_id, flag) {
    console.log(flag);
    console.log("Checking notifications for admin_id: " + admin_id);
    $.ajax({
        url: '<?=base_url();?>Menu/check_notifications', 
        method: 'post',
        dataType: 'json', 
        data: { admin_id: admin_id },
        success: function(response) {
          console.log(response);
                if (response.length > 0) {
                    let notificationCount = response.length;
                    console.log(notificationCount);
                    response.forEach(function(notification) {

                      if (shownNotifications.includes(notification.type)) 
                      {
                          if (flag) {
                              //freezeScreen();
                              flag = true;
                          }
                      } else {
                          shownNotifications.push(notification.type);
                      }
                        Swal.fire({
                            title: `${notificationCount} New Notifications`,
                            text: notification.sms,
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Go to page',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                markNotificationAsRead(notification.id);

                                var sdatet = new Date(notification.sdatet).toISOString().split('T')[0];
                                console.log(notification);
                                console.log(sdatet);

                                // Redirect based on notification type_id
                                if (notification.type == '1') {
                                    window.location.href = '<?= base_url("#"); ?>';
                                } else if (notification.type == '2') {
                                    let url2 = `<?= base_url("Menu/CheckTaskDetailsByUser/"); ?>${notification.uid}/${sdatet}`;
                                    console.log('Redirecting to:', url2);  
                                    window.location.href = url2;
                                } else if (notification.type == '3') {
                                    window.location.href = '<?= base_url("#"); ?>';
                                } else if (notification.type == '4') {
                                    window.location.href = '<?= base_url("Menu/TodaysTaskApprovelRequest"); ?>';
                                } else if (notification.type == '5') {
                                    window.location.href = '<?= base_url("#"); ?>';
                                } else {
                                    console.error('Unknown notification type:', notification.type);
                                }

                                //unfreezeScreen(); // Unfreeze the screen only after processing
                            }
                        });
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

  function freezeScreen() 
  {
    var overlay = document.createElement('div');
    overlay.id = 'screen-overlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    overlay.style.zIndex = '1000';
    document.body.appendChild(overlay);
  }

// Remove the freeze screen overlay when needed
function unfreezeScreen() 
{
    var overlay = document.getElementById('screen-overlay');
    if (overlay) {
        overlay.remove();
    }
}
</script>
<script>
    $('#notification').on('click', function() {
        // Hide the notification count
        $('#notification').hide();
    });
</script>