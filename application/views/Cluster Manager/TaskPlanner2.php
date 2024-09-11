<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskPlanner2.0 | STEM APP | WebAPP</title>
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
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">

    <script>
      function validateTimeInput(event) {
          const input = event.target;
          const timeValue = input.value;
          const minTime = "10:00";
          const maxTime = "19:00";
      
          if (timeValue < minTime || timeValue > maxTime) {
              alert("Please enter a time between 10:00 AM and 7:00 PM.");
              input.value = "";
          }
      }
      function validateTimeInputAuto(event) {
          const input = event.target;
          const timeValue = input.value;
          const minTime = "16:00";
          const maxTime = "19:00";
      
          if (timeValue < minTime || timeValue > maxTime) {
              alert("Please enter a time between 04:00 PM and 7:00 PM.");
              input.value = "";
          }
      }
      
      document.addEventListener('DOMContentLoaded', function() {
          const timeInput = document.getElementById('start-time1');
          timeInput.setAttribute('min', '10:00');
          timeInput.setAttribute('max', '19:00');
          timeInput.addEventListener('change', validateTimeInput);
      });
      document.addEventListener('DOMContentLoaded', function() {
          const timeInput = document.getElementById('end-time1');
          timeInput.setAttribute('min', '10:00');
          timeInput.setAttribute('max', '19:00');
          timeInput.addEventListener('change', validateTimeInput);
      });
      document.addEventListener('DOMContentLoaded', function() {
          const timeInput = document.getElementById('start-time');
          timeInput.setAttribute('min', '16:00');
          timeInput.setAttribute('max', '19:00');
          timeInput.addEventListener('change', validateTimeInputAuto);
      });
      document.addEventListener('DOMContentLoaded', function() {
          const timeInput = document.getElementById('end-time');
          timeInput.setAttribute('min', '16:00');
          timeInput.setAttribute('max', '19:00');
          timeInput.addEventListener('change', validateTimeInputAuto);
      });

      document.addEventListener('DOMContentLoaded', function() {
          const timeInput = document.getElementById('meetingtimerequest1');
          timeInput.setAttribute('min', '10:00');
          timeInput.setAttribute('max', '19:00');
          timeInput.addEventListener('change', validateTimeInput);
      });

      document.addEventListener('DOMContentLoaded', function() {
          const timeInput = document.getElementById('meetingtimerequest2');
          timeInput.setAttribute('min', '10:00');
          timeInput.setAttribute('max', '19:00');
          timeInput.addEventListener('change', validateTimeInput);
      });
      document.addEventListener('DOMContentLoaded', function() {
          const timeInput = document.getElementById('meetingtimerequest3');
          timeInput.setAttribute('min', '10:00');
          timeInput.setAttribute('max', '19:00');
          timeInput.addEventListener('change', validateTimeInput);
      });

      document.addEventListener('DOMContentLoaded', function() {
          const timeInput = document.getElementById('review_plantime');
          timeInput.setAttribute('min', '10:00');
          timeInput.setAttribute('max', '19:00');
          timeInput.addEventListener('change', validateTimeInput);
      });
      
    </script>
    <?php
      if(sizeof($getplandt) == 1){
          $stime = explode(":", $getplandt[0]->stime);
          $endtime = explode(":", $getplandt[0]->etime);
      
          $starttime = $stime[0].':'.$stime[1];
          $endtime = $endtime[0].':'.$endtime[1];
      
      ?>
    <script>
      function validateTimeInputMeet(event) {
           const input = event.target;
           const timeValue = input.value;
           const minTime = "10:00";
           const maxTime = "19:00";
           const restrictedStartTime = "<?=$starttime?>";
           const restrictedEndTime = "<?=$endtime ?>";
           
           if ((timeValue >= restrictedStartTime && timeValue <= restrictedEndTime) || timeValue < minTime || timeValue > maxTime) {
               alert("Try to Diffrent between 10:00 AM to 7:00 PM (<?=$starttime?> to <?=$endtime ?> time is booked for auto task)");
               input.value = "";
           }else{
            $.ajax({
                url:'<?=base_url();?>Menu/GetCheckExistsTaskTime',
                type: "POST",
                data: {
                timeValue: timeValue,
                pdate:"<?=$adate?>"
                },
                cache: false,
                success: function a(result){
                  if(result > 0){
                    alert("You have allready plan task for this time, please enter another time");
                    input.value = "";
                  }
                    // console.log(result);
                    }
                });
           }
       }

       document.addEventListener('DOMContentLoaded', function() {
           const timeInput = document.getElementById('meeting-time');
           timeInput.setAttribute('min', '10:00');
           timeInput.setAttribute('max', '19:00');
           timeInput.addEventListener('change', validateTimeInputMeet);
       });
      
    </script>
    <?php
      }
      ?>
    <style>
.scrollme{overflow-x:auto;h1{font-size:36px;color:#333}p{font-size:24px;color:#666;margin:10px}.container{background-color:#fff;padding:20px;border-radius:10px;box-shadow:0 0 10px rgb(0 0 0 / .2)}}.custom-card{padding:20px;border:1px solid #e0e0e0;border-radius:5px}.custom-card-header{background-color:#007bff;color:#fff;padding:10px 20px;border-radius:5px 5px 0 0}.custom-radio-label{font-weight:700}.card.container-fluid{background-color:honeydew}p#totalcompany{font-size:12px;padding:10px;color:green;font-weight:700;font-family:sans-serif}label{font-size:12px!important}div#maintaskcard{background:antiquewhite}div#selectCategory{background:#fff6dd}div#actionnotplaned{background:#434630;color:#fff}.card.p-4.taskselectionarea,#companyLocationdatacard,#selectCategory{background:#4bb1ac;background-image:linear-gradient(-225deg,#FF057C 0%,#8D0B93 50%,#321575 100%);color:#fff;}div#selectCategory{background:#4bb1ac;background-image:linear-gradient(-225deg,#FF057C 0%,#8D0B93 50%,#321575 100%);color:#fff}.modal-footer{justify-content:center!important}div#pstAssignCard,div#taskActionCard,div#partnertype,div#actionPlanned,div#review_planning_card,div#companyLocationdatacard,div#clusterLocactionFiltercard,div#sameStatusLastLimitDays,div#becauseofplanchange,div#becauseof_topsender_pst_meet,div#planbutnotinitiatedcard,div#actionnotplaned_NeedYour,div#planbutnotinitiatedcardold,div#auto_assign,div#compulsive_task_card,div#pendingAutotaskCard,div#need_your_attention,div#firstQuarter1,div#reviewTargetDate{background:#4bb1ac;background-image:linear-gradient(-225deg,#FF057C 0%,#8D0B93 50%,#321575 100%);color:#fff}div#maintaskcard{background:#bfbfbf}.card-header.custom-card-header{border-radius:43px;text-align:center;padding:2px}.custom-card{background:#efb2b2}span.alertmessagecmp{font-size:14px;padding:2px;color:red}div#plantimerBox{background:linear-gradient(to right,#a80077,#66ff00);border-radius: 56px;box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;}span#timer{font-size:38px;color:#fff}.stopbtntimer{align-items:center;justify-content:center;display:flex}button#stop{padding: 7px 12px;} table.dataTable>thead>tr>th:not(.sorting_disabled), table.dataTable>thead>tr>td:not(.sorting_disabled) {padding-right: 30px; background: #851241;color: white;}
.hrclass{box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;}
 .bgresactive{background: #263b0d!important;}
 .form-control.is-invalid, .was-validated .form-control:invalid {background-image: none !important;}
 .form-control.is-valid, .was-validated .form-control:valid {background-image: none !important;}   
 .select-readonly { background-color: #f5f5f5; color: #666;cursor: not-allowed;}
lable{font-size: 14px!important; font-weight: 500!important;font-family: system-ui!important;}
.boxshadownew{box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;border-radius: 25px;}
span#tasktype {color: green;}   
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
<?php 
$action = $this->Menu_model->get_action();
if($type_id == 3){
  foreach ($action as $key => $value) {
    if ($value->id == 17 || $value->id == 18) {
        unset($action[$key]);
    }
  }
  $action = array_values($action);
}

 ?>
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
            <?php
              if ($this->session->flashdata('success_message_plan')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong> <?php echo $this->session->flashdata('success_message_plan'); ?></strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php endif; ?>
            <?php
              if ($this->session->flashdata('error_message_plan')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong> <?php echo $this->session->flashdata('error_message_plan'); ?></strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php endif; ?>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0"></h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <h4><?php $uid=$user['user_id']?></h4>
                </ol>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <style>
          #plandate{width:300px;}.setpaldate{display:flex;}.planerdflex{align-items: center; justify-content: center; display: flex;}
        </style>
        <div class="container-fluid">
          <div class="card p-2 bg-primary">
            <div class="row">
              <div class="col-md-4 planerdflex">
                <?php
                  $aptime = $this->Menu_model->GetTodaysAutoTaskANDPlanningTime($uid,date("Y-m-d"));
                  $aptimecnt = sizeof($aptime);
                  if($aptimecnt > 0){
                    $start_tttpft = $aptime[0]->start_tttpft;
                    $end_tttpft = $aptime[0]->end_tttpft;
                    $timeArray = explode(':', $start_tttpft);
                    // Assign the components to variables
                    $phours = $timeArray[0];
                    $pminutes = $timeArray[1];
                    $pseconds = $timeArray[2];
                    ?>
                    <div class="mt-3">
                    <p><b> <span id="yndpt">Todays Planner Time is :</span> <?=$start_tttpft; ?></b></p> 
                    </div>
                 <?php } ?>
              </div>
              <div class="col-md-4 planerdflex">
              <!-- <p id="planertime">edwd</p> -->
              </div>
              <div class="col-md-4">
                <form class="setpaldate" action="<?=base_url();?>Menu/TaskPlanner2/<?=$adate ?>" method="post">
                  <?php 
                  $adatess = date("Y-m-d");
                  $next_date = date('Y-m-d', strtotime('+1 day', strtotime($adatess))); ?>
                  <input type="date" class="form-control m-2" name="adate" value="<?=$adate?>" required="" id="plandate"  min="<?= date('Y-m-d') ?>" max="<?= $next_date ?>">
                  <input type="submit" class="btn btn-warning m-2" value="Set Date">
                </form>
              </div>
            </div>
          </div>
          <?php
            $reqCount = sizeof($getreqData);
            $getAutoTaskTime = sizeof($getAutoTaskTime);
            $approvel_status = $getreqData[0]->approvel_status;
            $oldPendTaskcnt = sizeof($oldPendTask);
                // if($pendingtask !== 0){
                // echo "<pre>";
                //   print_r($reqCount);
                //   die; 
            // $approvel_status = 'Approved';
            if($adate == date("Y-m-d") && $getAutoTaskTime == 0 || $adate !== date("Y-m-d")){ 
                if($getAutoTaskTime !==1){
                ?>
          <div class="justify-content-center col-lg-12 col-md-12 col-sm-4 col-sm m-auto p-3">
            <div class="card">
              <div class="card-body" id="mainboxAutoTask1">
                <h5><i>First Set Auto Task Time </i></h5>
                <hr/>
                <marquee class="p-2 mt-1" width="100%"  onMouseOver="this.stop()" onMouseOut="this.start()" behavior="left" bgcolor="pink">
                  <h6> Auto task time should be between 4:00 PM to 7:00 PM and maximum duration of 90 minutes. </h6>
                </marquee>
                <form method="post" action="<?=base_url();?>Menu/updateAtotaskTime">
                  <div class="was-validated">
                    <input type="hidden" id="userid" value="<?=$uid?>" name="bdid" required="">
                    <div class="col-md-12 col-sm mt-3">
                      <input type="hidden" class="form-control" id="ttype" name="ttype" Value="Auto Task" required="">
                      <input type="hidden" class="form-control" name="pdate" value="<?=$adate?>" required="">
                      <input type="hidden" name="ntuid" value="<?=$uid?>" required="">
                     
                      <div class="form-group">
                        <label for="start-time">Enter Start Time</label>
                        <input type="time" id="start-time" name="startautotasktime" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label for="end-time">Enter End Time</label>
                        <input type="time" id="end-time" name="endautotasktime" class="form-control" required>
                      </div>
                      <hr>
                      <?php 
                      if($adate !== date("Y-m-d")){ 
                       $userdfrom = $this->Menu_model->userworkfrom() ?>
                        <div class="form-group">
                          <label>Select Your Tomorrow  Day</label>
                          <select name="userworkfrom" class="form-control">
                              <?php foreach($userdfrom as $udfrom){ ?>
                            <option value="<?= $udfrom->ID; ?>"><?= $udfrom->TYPE; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                     <?php } ?>
                      <hr>
                      <marquee class="p-2 mt-1" width="100%"  onMouseOver="this.stop()" onMouseOut="this.start()" behavior="left" bgcolor="pink">
                  <h6> Todays is the Time to plan for tomorrow. Its maximum of 1 hour. After Auto Task</h6>
                </marquee>
                      <div class="form-group">
                        <label for="end-time">Today is the start time to plan for tomorrow.</label>
                        <input type="time" readonly id="start_tttpft" name="start_tttpft" class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label for="end-time">Today is the end time to plan for tomorrow.</label>
                        <input type="time" readonly id="end_tttpft" name="end_tttpft" class="form-control" required>
                      </div>

                      <button class="btn btn-primary m-3" type="submit" id="autoplan_submit">Submit</button>
                    </div>
                </form>
                </div>
              </div>
            </div>
            <?php }}else if($adate == date("Y-m-d") || $approvel_status == '' || $approvel_status =='Reject'){
             
            if($reqCount !== 1 && $adate == date("Y-m-d")){

                $getPendingTaskreq = $this->Menu_model->GetUserRequestForPendingTask($uid,$adate);
                $getPendingTaskreqcnt = sizeof($getPendingTaskreq);

                if($getPendingTaskreqcnt > 0){
                    $getPendingTaskreqappr = $getPendingTaskreq[0]->approvel_status;
                  }
                  ?>

            <div class="card p-2 bg-dark text-center">
              <h5><i>If you want to plan task for todays you need to first approval.</i></h5>
            </div>
            <form class="was-validated" action="<?=base_url();?>Menu/RequestForTodaysTaskPlan/<?=$adate ?>" method="post">
              <input type="hidden" value="<?= $adate?>" name="setdatebyuser">
              <input type="hidden" value="<?= $oldPendTaskcnt?>" name="taskcnt">
              <div class="row">
              <div class="col-md-12">
                  <label for="validationServer04" class="form-label">
                  Why would you want to set up a todays planner?
                  </label>
                  <select class="form-select is-invalid" id="validationServer04" aria-describedby="validationServer04Feedback" name="would_you_want" required>
                    <option selected disabled value="">Choose...</option>
                    <option value="Planning urgent tasks for today">Planning urgent tasks for today</option>
                    <option value="Planning yesterday pending tasks">Planning yesterday's pending tasks</option>
                    <option value="Not planned yesterday due to network issues">Not planned yesterday due to network issues</option>
                    <option value="Not planned yesterday due to health issues">Not planned yesterday due to health issues</option>
                    <option value="Not planned yesterday due to an urgent meeting">Not planned yesterday due to an urgent meeting</option>
                    <option value="Forgot to set up the planner yesterday">Forgot to set up the planner yesterday</option>
                  </select>
                  <div id="validationServer04Feedback" class="invalid-feedback">
                   * Please select a valid state.
                  </div>
                </div>
                
              </div>
              <div class="mb-3">
                <label for="requestForTodaysTaskPlan" class="form-label">Type Reason : </label>
                <textarea class="form-control" name="requestForTodaysTaskPlan" id="requestForTodaysTaskPlan" required rows="3"></textarea>
                <div class="invalid-feedback">* Invalid Message</div>
              </div>
              <div class="mb-3 text-center">
                <input type="submit" class="btn btn-warning" value="Send Request">
              </div>
            </form>

           <?php if($oldPendTaskcnt > 0 && ($getPendingTaskreqappr !== '1')){ ?>
            <hr>
            <div class="card p-2 text-center bg-danger">
                <h3>Yesterday Pending Task </h3>
            </div>
     <hr>
       <div class="table-responsive">
            <table id="example10" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Company Name</th>
                  <th scope="col">Company Status</th>
                  <th scope="col">Task Type</th>
                  <th scope="col">Task Date</th>
                  <th scope="col">Action Taken</th>
                  <th scope="col">Purpose Taken</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1; foreach($oldPendTask as $data){
                   $compname = $this->Menu_model->get_cmpbyinid($data->cid_id)[0]->compname;
                   $compsname = $this->Menu_model->get_statusbyid($data->status_id)[0]->name;
                   $actname = $this->Menu_model->get_actionbyid($data->actiontype_id)[0]->name;
                  ?>
                <tr>
                  <th><?=$i?></th>
                  <td><?= $compname ?></td>
                  <td><?=$compsname ?></td>
                  <td><?= $actname ?></td>
                  <td><?= $data->appointmentdatetime ?></td>
                  <td><?=$data->actontaken ?></td>
                  <td><?=$data->purpose_achieved ?></td>
                </tr>
                <?php $i++; } ?>
              </tbody>
            </table>
            </div>
              <?php } ?>

            <?php } 
            }

              if($reqCount == 1 && $approvel_status == '' || $approvel_status =='Reject' ){
              ?>
            <table class="table table-striped table-dark">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Date</th>
                  <th scope="col">Request Type</th>
                  <th scope="col">Request Message</th>
                  <th scope="col">Approvel Status</th>
                  <th scope="col">Remarks</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($getreqData as $data){ ?>
                <tr>
                  <th>1</th>
                  <td><?= $this->Menu_model->get_userbyid($data->user_id)[0]->name ?></td>
                  <td><?= $data->created_at ?></td>
                  <td><?= $data->would_you_want ?></td>
                  <td><?= $data->request_remarks ?></td>
                  <td>
                    <?php
                      if($data->approvel_status == ''){ ?>
                    <span class="p-1 bg-warning mr-2">Pending</span>
                    <?php }else if($data->approvel_status == 'Approved'){ ?>
                    <span class="p-1 bg-success mr-2">Approved</span>
                    <?php }else{ ?>
                    <span class="p-1 bg-danger mr-2">Reject</span>
                    <?php }?>
                  </td>
                  <td><?=$data->remarks ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php }else if($getAutoTaskTime ==1 && $reqCount == 1 && $approvel_status == 'Approved' || $adate !== date("Y-m-d")){   
               if($getAutoTaskTime == 1){ ?>

            </div>
            <section class="content">
              <div class="card container-fluid">
                <br>

                <div class="col-md-12 plantimer text-center p-2 mb-2" id="plantimerBox">
                  <div class="row">
                    <div class="col-md-8">
                    <span id="timer">00:00:00</span>
                    </div>
                    <div class="col-md-2 stopbtntimer">
                    <button type="button" class="btn btn-danger" id="stop">Stop Planning</button>
                    </div>
                  </div>
                </div>
               <center> <hr class="hrclass" style="width: 600px;"/></center>
                <div class="row">
                <div class="justify-content-center col-md-8" id="planningStartbtn" >
                 <div class="card" style="min-height:100px;align-items: center; justify-content: center; display: flex;" >
                      <div class="planningTime">
                          <button type="button" class="btn btn-primary" id="start">Start Planning</button>
                      </div>
                 </div>
                 <div class="table-responsive">
                  <?php $planSessionData  = $this->Menu_model->TodaysPlannerSession($uid); ?>
                  <?php $planSessionmin  = $this->Menu_model->TodaysTotalsPlannerSessioninMinute($uid); ?>
                   <p class="text-center" > <b>Today's Total Time Spent in Planning : <?=$planSessionmin; ?></b> </p>
                  <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          <th>S.No</th>
                          <th>Name</th>
                          <th>Start Date</th>
                          <th>Start Time</th>
                          <th>End Time</th>
                          <th>End Date</th>
                          <th>Total Consume Time</th>
                          <th>Total Task</th>
                          <th>Average time per task</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php 
                      $i =1;
                     $planSessionData  = $this->Menu_model->TodaysPlannerSession($uid);
                      foreach($planSessionData as $req){
                        $username =  $this->Menu_model->get_userbyid($req->user_id)[0]->name;
                      
                        $total_task = $this->Menu_model->TotalTaskBetweenTime($req->user_id,$adate,$req->pstime,$req->pctime);
                        $total_taskcnt = sizeof($total_task);

                        // Convert total time to seconds
                        $totaltime = $req->totaltime;
                        list($hours, $minutes, $seconds) = explode(":", $totaltime);
                        $totaltime_in_seconds = $hours * 3600 + $minutes * 60 + $seconds;

                        // Calculate average time per task
                        $average_time_per_task = $totaltime_in_seconds / $total_taskcnt;
                        // Convert average time back to hours, minutes, and seconds
                        $average_hours = floor($average_time_per_task / 3600);
                        $average_minutes = floor(($average_time_per_task % 3600) / 60);
                        $average_seconds = round($average_time_per_task % 60);
                        
                        ?>
                          <tr>
                            <td><?=$i; ?></td>
                            <td><?=$username ?></td>
                            <td><?=$req->psdatetime ?></td>
                            <td><?=$req->pstime ?></td>
                            <td><?=$req->pctime ?></td>
                            <td><?=$req->pcdatetime ?></td>
                            <td><?=$req->totaltime ?></td>
                            <td> <a href="<?=base_url();?>Menu/CheckPlanTaskBetweenTimes/<?=$req->pstime ?>/<?=$req->pctime ?>"> <?=$total_taskcnt?></a></td>
                            <td><?= sprintf("%02d:%02d:%02d", $average_hours, $average_minutes, $average_seconds); ?></td>
                          </tr>
                     <?php $i++; } ?>
                     
                  </tbody>
              </table>
                 </div>
                </div>
                  <div class="justify-content-center col-lg-4 col-sm-4" id="planningStart1">
                    <div class="card custom-card">
                      <div class="card-header custom-card-header">
                        <h5>Task Planner</h5>
                      </div>
                      <div class="card-body">

                        <?php  
                        $current_date = date("Y-m-d");
                        $tomorrow_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
                        if($adate == $tomorrow_date){
                        
                        $planchangetask = $this->Menu_model->GetTaskBecauseOfPlanChange($uid,$tomorrow_date);
                        $planchangetaskcnt = sizeof($planchangetask);
                        if($planchangetaskcnt > 0){
                          $cssct = 'red';
                          
                        ?>
                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Because of Plan Change" > 
                           <span style="<?='color:'.$cssct?>" data-toggle="tooltip" data-placement="left" title="This filter is activated due to a change in a plan. Only those tasks will appear that are to be rescheduled within the specified time frame."> Because of Plan Change (<?=$planchangetaskcnt ?>) </span>
                        
                          </label>
                        </div>
                        <?php }} ?>
                      <?php 
                      $getPendingTask = $this->Menu_model->get_PendingTask($uid);
                      $getoldPendingTask = $this->Menu_model->get_OLDPendingTask($uid);

                      $getmomTask = $this->Menu_model->getTaskAfterMomApproved($uid);
                      $getmomTaskcnt = sizeof($getmomTask);
 
                      $getpendSize = sizeof($getPendingTask);
                      $getoldPendingTaskcnt = sizeof($getoldPendingTask);
                      
                      ?>
                    <?php if($planbutnotinitedcnt > 0 && $adate !== date("Y-m-d")){ ?>
                      <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Plan But Not Initiated" >
                          <span style="color:red;" data-toggle="tooltip" data-placement="left" title="This filter is active due to If user have any Today's pending task (User Planned But Not Initiated) " >Today's Pending Task - Plan But Not Initiated (<?= $getpendSize; ?>)</span>
                        </label>
                        </div>
                        <?php } else{?>

                          <?php if($oldPendTaskcnt > 0){ ?>
                          <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Plan But Not Initiated Old">
                          <span style="color:red;" data-toggle="tooltip" data-placement="left" title="This filter is active due to If user have any old pending task (User Planned But Not Completed) ">Old Pending Task (<?= $getoldPendingTaskcnt; ?>)</span>
                        </label>
                        </div>
                        <?php }else{ ?>
                    <?php 
                       $days = 8;
                       if($type_id ==3){
                        $cmpstatus = '1,2,8';  // Status with - Open, Reachout, Open RPEM
                        $dyslimit = 15;
                       }else if($type_id ==13 || $type_id ==4){
                        $cmpstatus = '3,6,9,12,13';  // Status with - Tentive, Positive, Very Positive, Positive NAP, Very Positive NAP
                        $dyslimit = 30;
                       }
                       $cmpstatss = '4,5'; // Status with - WDL AND NI

                        $statusnochangecmp = $this->Menu_model->getCompanyWhichNoStatusChange($uid,$days,$cmpstatus);
                        $statusnochangecmpcnt = sizeof($statusnochangecmp);

                        $statusnochangecmp_wdl_nl = $this->Menu_model->getCompanyWhichNoStatusChange($uid,$dyslimit,$cmpstatss);
                        $statusnochangecmp_wdl_nl_cnt = sizeof($statusnochangecmp_wdl_nl);

                        $status_nochangecnt = $statusnochangecmpcnt + $statusnochangecmp_wdl_nl_cnt;
                        if($status_nochangecnt > 0){$cssct = 'text-danger';}else{$cssct = '';}

                        $impcomp = [];
                 
                        $impcomp ['Compulsive Task']= $status_nochangecnt;
                        if($status_nochangecnt > 0){
                        ?>

                          <div class="form-check" id="compulsive_task_filter">
                            <?php 
                            if($type_id ==3){
                              $tooltips = "This filter is active if the company status has not changed in the last 8 days for 'Open,' 'OPEN RPEM,' or 'Reachout' and in the last 15 days for 'Will do Later' or 'Not Interested.'";
                              }else if($type_id ==13 || $type_id ==4){
                                $tooltips = "This filter is active if the company status has not changed in the last 8 days for Tentative, Positive, Very Positive, Positive-NAP, Very Positive-NAP and in the last 30 days for 'Will do Later' or 'Not Interested.'";
                                }
                            ?>
                          <label>
                            <input type="radio" class="form-check-input" name="optradio" value="Compulsive Task"> 
                            <span data-toggle="tooltip" data-placement="left" title="<?=$tooltips;?>" class="<?=$cssct?>"> Compulsive Task (<?=$status_nochangecnt ?>) </span>
                          </label>
                        </div>
                        <?php } ?>
                      <?php 
                 
                        $getBDNoWorked = $this->Menu_model->CompanyThatBDHasNoWorkedInDays($uid,$days,$cmpstatus);
                        $getBDNoWorkedcnt = sizeof($getBDNoWorked);

                        $getBDNoWorked_wdl_nl = $this->Menu_model->CompanyThatBDHasNoWorkedInDays($uid,$dyslimit,$cmpstatss);
                        $getBDNoWorked_wdl_nlcnt = sizeof($getBDNoWorked_wdl_nl);

                        $notworkedcnt = $getBDNoWorkedcnt + $getBDNoWorked_wdl_nlcnt;
                        if($notworkedcnt > 0){$cssc = 'text-danger';}else{$cssc = '';}
                        
                        $impcomp ['No Work Days']= $notworkedcnt;
                        if($notworkedcnt > 0){
                        ?>
                        <div class="form-check" id="actionNotPlannedNeed_filter">
                        <label>
                        <?php 
                            if($type_id ==3){
                             
                              $tooltips = "This filter is active if the company is visible and no work has been done in the last 8 days for Open, OPEN RPEM, and Reachout status, or in the last 15 days for 'Will Do Later' or 'Not Interested' tasks.";

                              }else if($type_id ==13 || $type_id ==4){

                                $tooltips = "This filter is active if the company is visible and has not had any work done in the last 8 days for Tentative, Positive, Very Positive, Positive-NAP, and Very Positive-NAP status, or in the last 30 days for 'Will Do Later' or 'Not Interested' status.";
                                }
                            ?>

                        <input type="radio" class="form-check-input" name="optradio" value="actionNotPlannedNeed" > 
                        <span class="<?=$cssc?>" data-toggle="tooltip" data-placement="left" title="<?=$tooltips;?>" > No Work Days  <?php if($notworkedcnt > 0){echo '('.$notworkedcnt.')';}?></span>
                        </label>
                        </div>
                        <?php } ?>
                        <?php 
                          if($type_id ==  3){
                            $impcomp ['Need Your Attention']= 0;
                          }
                        if($type_id ==  13 || $type_id == 4){
                          $dyslimit = 8;
                          if($type_id == 13){
                            $cmpstatus = '1,2,8';  // Status with - Open, Reachout, Open RPEM
                           }else if($type_id == 4){
                            $cmpstatus = '3,6,9,12,13';  // Status with - Tentive, Positive, Very Positive, Positive NAP, Very Positive NAP
                           }
                          $need_your_atte = $this->Menu_model->NeedYourAttentions($dyslimit,$cmpstatus);
                          $need_your_attecnt = sizeof($need_your_atte);
                          if($need_your_attecnt > 0){$cssc = 'text-danger';}else{$cssc = '';}
                          
                          $impcomp ['Need Your Attention']= $need_your_attecnt;
                          if($need_your_attecnt > 0){
                          ?>
                          <div class="form-check" id="need_your_attention_filter">
                          <?php 
                            if($type_id ==13){
                             
                              $tooltips = "When there is no change in company status for 8 days, this filter displays a list of companies along with the number of days and the BD name. This applies when BD activities are ongoing but the status remains as 'Open,' 'Reachout,' or 'Open RPEM.'";

                              }else if($type_id ==4){

                                $tooltips = "When there is no change in company status for 8 days, this filter displays a list of companies along with the number of days and the BD name. This applies when BD activities are ongoing but the status remains as Tentative, Positive, Very Positive, Positive NAP, Very Positive NAP";
                                }
                            ?>

                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Need Your Attention" > 
                          
                          <span class="<?=$cssc?>" data-toggle="tooltip" data-placement="left" title="<?=$tooltips;?>" > Need Your Attention  <?php if($need_your_attecnt > 0){echo '('.$need_your_attecnt.')';}?></span>
                          </label>
                        </div>
                         <?php } } ?> 


                         <?php 
                         
                         $impcomp ['Compulsive Task']= 0;
                         $impcomp ['No Work Days']= 0;
                         $impcomp ['Need Your Attention']= 0;
                         
                            $elementsGreaterThanOne = [];

                            foreach ($impcomp as $key => $value) {
                                if ($value > 1) {
                                    $elementsGreaterThanOne[] = $key;
                                }
                            }

                            if (!empty($elementsGreaterThanOne)) { ?>
                              <hr>
                                <div class="card bg-danger p-2 boxshadownew text-center">
                                  
                                  <lable>
                                  First Plan Their <?= implode(", ", $elementsGreaterThanOne) ?>
                                  </lable>
                                </div>
                           <?php } else { ?>
                         <?php if($type_id ==13 || $type_id ==4){ 
                          if($type_id ==13){
                            $tooltips = "This Filter are Self Assign , After MOM approval, user are automatically assigned a call task. These tasks are visible here. For MOM check, the user can plan the MOM check task when the team submits the MOM task.";
                            }else if($type_id ==4){
                              $tooltips = "This Filter are Auto Assign , After MOM approval, user are automatically assigned a call task. These tasks are visible here. For MOM check, the user can plan the MOM check task when the team submits the MOM task.";
                              }
                          ?>
                        <div class="form-check" id="self_assign_filter" >
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Self Assign" > <span data-toggle="tooltip" data-placement="left" title="<?=$tooltips;?>">Auto Assign</span>
                          </label>
                        </div>
                        <?php } ?>

                        <div class="form-check" id="company_name_filter">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Compnay Name" >Company Name
                          </label>
                        </div>
                        <div class="form-check" id="company_status_filter">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Status" >Status
                          </label>
                        </div>
                          <?php
                              $tooltipstaskact = "This feature allows users to filter and plan tasks related to meetings and research within the company.\n";  
                              $tooltipstaskact .= "Plan Scheduled Meeting Task: Users can plan and schedule specific meeting tasks.\n";  
                              $tooltipstaskact .= "Plan Barg-in Meeting Task: Users can plan Barg meeting tasks, choosing from:\n";  
                              $tooltipstaskact .= "Barg-in Meeting From Funnel: When selecting tasks from the funnel.\n";  
                              $tooltipstaskact .= "Barg-in Meeting Other : When selecting tasks from other sources.\n";  
                              $tooltipstaskact .= "Plan Research Task: Users can plan research tasks, choosing from:\n";  
                              $tooltipstaskact .= "Research  From Funnel: When selecting tasks from the funnel.\n";  
                              $tooltipstaskact .= "Research  Other : When selecting tasks from other sources.\n";  
                              $tooltipstaskact .= "Add New Lead: Automatically creates a task to add a new lead.\n";  
                            ?>
                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Task Action" > <span data-toggle="tooltip" data-placement="left" title="<?=$tooltipstaskact;?>" >Task Action</span>
                          </label>
                        </div>
                       
                        <!-- <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Location" >Company Location
                          </label>
                        </div> -->

                        <?php
                        $tooltips_clulocations = "This feature allows users to filter out the company using Travel Cluster.";
                      ?>

                        <div class="form-check" id="cluster_location_fiilter">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Cluster Location" >
                          <span data-toggle="tooltip" data-placement="left" title="<?=$tooltips_clulocations;?>">Cluster Location</span>
                          </label>
                        </div>

                        <?php
                        $tooltips_category = "This feature allows users to filter out the company using Category";
                        ?>

                        <div class="form-check" id="company_category_filter">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Category" >
                          <span data-toggle="tooltip" data-placement="left" title="<?=$tooltips_category;?>">Category</span>
                          </label>
                        </div>
                        <?php
                        $tooltips_partner = "This feature allows users to filter out the company using Partner Type";
                        ?>
                        <div class="form-check" id="partner_type_filter">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Partner Type" >
                          <span data-toggle="tooltip" data-placement="left" title="<?=$tooltips_partner;?>">Partner Type</span>
                          </label>
                        </div>
                        <?php
                        $tooltips_partner = "This feature allows users to filter out the company using Days";
                        ?>
                        <div class="form-check" id="ssllimit_days_filter">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Same Status Last Limit Days" >Same Status Last Limit Days 
                          </label>
                        </div>
                        
                        <!-- <div class="form-check" id="other_assign_filter">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="PST Assign" >Other Assign
                          </label>
                        </div> -->
                        <div class="form-check" id="review_target_date_filter">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Review Target Date" > Review Target Date
                          </label>
                        </div>
                        <div class="form-check" id="review_planning_filter">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Review Planning">  Review Planning
                          </label>
                        </div>
                        <?php  } }}?>
                        <hr>
                        <div class="card-header boxshadownew text-center">
                          <b>Let's Start Creating Task for <span id="tasktype"></span></b>
                          <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                          <b>Create a Special Request For Plan Change </b>
                          </button> -->

                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <form method="post" action="<?=base_url();?>Menu/SpecialRequestForLeave">
                    <div class="was-validated">
                      <div class="modal-content">
                        <div class="modal-header" styel="background: #fbff00;" >
                          <h5 class="modal-title" id="exampleModalLongTitle">Special Request For Plan Change</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" style="background: darkslategrey;color: white;" >
                        <input type="hidden" id="pdate" value="<?=$adate?>" name="pdate" required=""> 
                          <lable>Todays Start Time : </lable>
                        <input type="time" id="meetingtimerequest1" name="start_meeting_time" min="10:00" max="19:00" class="form-control" required=""> 
                          
                        <lable>Todays End Time : </lable>
                        <input type="time" id="meetingtimerequest2" name="end_meeting_time" min="10:00" max="19:00" class="form-control" required=""> 
                        <hr>
                        <div id="taskcounttable">
                        </div>
                        <hr>
                        <lable>Tomorrow Start Time : </lable>
                        <input type="time" id="meetingtimerequest3" name="start_tommorow_task_time" min="10:00" max="19:00" class="form-control" required=""> 
                        <hr>
                        <lable>Purpose For Plan Change : </lable>
                          <textarea name="purpose" class="form-control" placeholder="Please Enter Purpose" required="" ></textarea>
                        </div>
                        <div class="modal-footer text-center" style="background: #2f4f4f;" >
                            <center>
                            <button class="btn btn-primary m-3" type="submit">Send Request For Approval</button>
                            </center>
                        </div>
                      </div>
                      </div>
                        </form>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-4" id="planningStart2" >
                    <div class="card p-4 taskselectionarea">
                      <div class="row">
                        <div class="col-6">
                        </div>
                        <div class="col-6">
                          <div class="form-group" id="actionNotPlanned_task_filter">
                            <input type="radio" id="option2" name="optradio" value="actionNotPlanned">
                            <label>Action Not Planned </label>                          
                          </div>
                        </div>
                      </div>
                      <div id="actionPlanned" class ="card p-2">

                      <div id="becauseof_topsender_pst_meet" class="p-2">
                      <div class="form-group">
                          <label>Planning for own / other  funnel</label>
                          <select id="planning_funnel" class="form-control">
                            <option value="">Select funnel</option> 
                            <option value="Own funnel">own funnel</option> 
                            <option value="Other funnel">Other funnel</option> 
                          </select>
                        </div>

                      <div class="form-group" id="becauseofTPM_TaskDatacard">
                          <label>Select On </label>
                          <select id="becauseofTPM_TaskData" class="form-control">
                            <option value="">Select On</option> 
                            <option value="On BD">ON BD</option> 
                            <option value="On PST">ON PST</option> 
                            <option value="both">Both</option> 
                          </select>
                        </div>
                      <div class="form-group" id="becauseofTPM_TaskDatacard_new">
                          <label>Because Of </label>
                          <select id="becauseofTPM_new" class="form-control">
                          <option value="">Select Because Of</option>     
                            <option value="Top Spender">Top Spender</option> 
                            <option value="Meeting">Meeting</option> 
                          </select>
                        </div>
                      </div>
                          
                          <div id="selectcompanyname" class="form-group">
                          <lable>Enter Company Name Or CID</lable>
                          <?php $allCmpData = $this->Menu_model->GetAllCompanyByUserID($uid); ?>
                          
                          <input type="search" class="form-control" class="search" id="search_company" placeholder="Search" list="data">
                            <datalist id="data">
                            <?php foreach($allCmpData as $cmp){ ?>
                                <option value="<?=$cmp->com_id?> - <?= $cmp->compname?>" />
                                <?php } ?>
                            </datalist>
                          </div>
                        <?php 
                          $allStatus = $this->Menu_model->get_status();
                          ?>
                        <input type="hidden" name="selectbyuser" id="selectbyuser" value="">
                        <div class="form-group" id="selectstatus" >
                          <lable class="text-left">Select Company Status : </lable>
                          <select class="form-control" id="selectstatusbyuser">
                            <option selected disabled>Select Status</option>
                            <option value="all">All</option>
                            <?php foreach($allStatus as $getstatus): ?>
                            <option value="<?= $getstatus->id ?>"><?= $getstatus->name ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <hr>
                        <select id="tasktaction" name="tasktaction" class="form-control" >
                          <option selected disabled >Types of Task</option>
                          <option value="all">All</option>
                          <?php
                            foreach($action as $a){if($a->id!=4 && $a->id!=6 && $a->id!=8 && $a->id!=9 && $a->id!=11 && $a->id!=12){
                            ?>
                          <option value="<?=$a->id?>"><?=$a->name?></option>
                          <?php }} ?>
                        </select>
                        <hr>
                        <select class="form-control" id="taskActionbyuser">
                          <option selected disabled>Action</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                        <hr>
                        <select class="form-control" id="taskPurposebyuser">
                          <option selected disabled>Purpose</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                    </div>
                    <div id="actionnotplaned" class="card p-4" >
                      <input type="hidden" name="selectbyuser" id="selectbyuser" value=""> 
                      <div class="form-group" id="selectstatus" >
                        <lable>Select Company Status : </lable>
                        <hr>
                        <select class="form-control" id="selectstatusbyusernotplaned">
                          <option selected disabled>Select Status</option>
                          <option value="all">All</option>
                          <?php foreach($allStatus as $getstatus): ?>
                          <option value="<?= $getstatus->id ?>"><?= $getstatus->name ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                      <div id="task_actionCard">
                        <div class="form-group">
                          <label>Task/Action</label>
                          <select id="task_action" class="form-control" name="task_action">
                            <option value="">Select Task</option>
                            <option value="all">All</option>
                            <?php
                              foreach($action as $a){
                              ?>
                            <option value="<?=$a->id?>"><?=$a->name?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group" id="daysfiltercard_anp">
                        <label>Days</label>
                        <select id="daysfiltercard_anp_date" class="form-control" name="days">
                          <option value="">Select Days</option>
                          <option value="all">All </option>
                          <option value="8">8 days </option>
                          <option value="15">15 days </option>
                          <option value="more">more than 15 days </option>
                        </select>
                      </div>
                    </div>

                    <div id="actionnotplaned_NeedYour" class="card p-4">
                    <lable>Select Company Status : </lable>
                    <hr>
                        <select class="form-control" id="selectstatusbyusernotplanedCompany">
                            <option value="">Select Task</option>
                                <?php 
                                $getBDNoWorkedcnts = [];
                                  foreach ($getBDNoWorked as $objects) {
                                      $cstatus = $objects->cstatus;
                                      if (!isset($getBDNoWorkedcnts[$cstatus])) {
                                          $getBDNoWorkedcnts[$cstatus] = [];
                                      }
                                      $getBDNoWorkedcnts[$cstatus][] = $objects;
                                  }
                                  $getBDNoWorkedcnts_wdlnl = [];
                                  foreach ($getBDNoWorked_wdl_nl as $objects_wdl_nl) {
                                      $cstatus = $objects_wdl_nl->cstatus;
                                      if (!isset($getBDNoWorkedcnts_wdlnl[$cstatus])) {
                                          $getBDNoWorkedcnts_wdlnl[$cstatus] = [];
                                      }
                                      $getBDNoWorkedcnts_wdlnl[$cstatus][] = $objects_wdl_nl;
                                  }
                                ?>
                            <?php 
                              foreach($getBDNoWorkedcnts as $key => $npstatus){
                                $getstatus_name = $this->Menu_model->get_statusbyid($key)[0]->name;
                                $npstatuscnt = sizeof($npstatus);
                                echo "<option class='text-danger' value='$key'>$getstatus_name($npstatuscnt)</options>";
                              }
                              foreach($getBDNoWorkedcnts_wdlnl as $key => $npstatus){
                                $getstatus_name = $this->Menu_model->get_statusbyid($key)[0]->name;
                                $npstatuscnt = sizeof($npstatus);
                                echo "<option class='text-danger' value='$key'>$getstatus_name($npstatuscnt)</options>";
                              }
                            ?>
                          </select>
                    </div>


                    <div id="need_your_attention" class="card p-4">
                    <lable>Select Company Status : </lable>
                    <hr>
                        <select class="form-control" id="need_your_attention_slsct">
                            <option value="">Select Task</option>
                                <?php 
                                $needyouratte = [];
                                  foreach ($need_your_atte as $objects) {
                                      $cstatus = $objects->cstatus;
                                      if (!isset($needyouratte[$cstatus])) {
                                          $needyouratte[$cstatus] = [];
                                      }
                                      $needyouratte[$cstatus][] = $objects;
                                  }
                                ?>
                            <?php 
                              foreach($needyouratte as $key => $npstatus){
                                $getstatus_name = $this->Menu_model->get_statusbyid($key)[0]->name;
                                $npstatuscnt = sizeof($npstatus);
                                echo "<option class='text-danger' value='$key'>$getstatus_name($npstatuscnt)</options>";
                              }
                            ?>
                          </select>
                    </div>

                    <div id="selectCategory" class="card p-4" >
                      <input type="hidden" name="selectbyuser" id="selectbyuser" value=""> 
                      <div class="form-group" id="selectCategorybyuser" >
                        <lable>Select Category : </lable>
                        <hr>
                        <select class="form-control" id="selectdcategory">
                          <option selected disabled >Choose one</option>
                          <option value="topspender">Top Spender</option>
                          <option value="upsell_client">Upsell Client</option>
                          <option value="focus_funnel">Focus Funnel</option>
                          <option value="keycompany">Key Company</option>
                          <option value="pkclient">P Key Client</option>
                        </select>
                      </div>
                      <div class="form-group" id="statusfiltercardCategory">
                        <label>Select Status</label>
                        <select class="form-control" id="statusfiltercardCat">
                          <option selected disabled>Select Status</option>
                          <option value="all">All</option>
                          <?php foreach($allStatus as $getstatus): ?>
                          <option value="<?= $getstatus->id ?>"><?= $getstatus->name ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group" id="taskActionbyusercatcatcard">
                        <label>Select Action</label>
                        <select class="form-control" id="taskActionbyusercat">
                          <option selected disabled>Action</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group" id="taskPurposebyusercatcard">
                        <label>Select Purpose</label>
                        <select class="form-control" id="taskPurposebyusercatdata">
                          <option selected disabled>Purpose</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                    </div>
                    <div id="clusterLocactionFiltercard" class="card p-4" >
                      <input type="hidden" name="selectbyuser" id="selectbyuser" value=""> 
                      <div class="form-group" id="selectCategorybyuser" >
                        <lable>Select Cluster Location : </lable>
                        <hr>
                        <select class="form-control" id="clusterNameLocaction"></select>
                      </div>
                      <div class="form-group" id="statusfiltercardCluster">
                        <label>Select Status</label>
                        <select class="form-control" id="statusfilterCluster">
                          <option selected disabled>Select Status</option>
                          <option value="all">All</option>
                          <?php 
                            foreach($allStatus as $getstatus):
                             ?>
                          <option value="<?= $getstatus->id ?>"><?= $getstatus->name ?></option>
                          <?php
                            endforeach;
                             ?>
                        </select>
                      </div>
                      <div class="form-group" id="taskActionbyuserCluster">
                        <label>Select Action</label>
                        <select class="form-control" id="taskActionbyCluster">
                          <option selected disabled>Action</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group" id="taskPurposebyuserCluster">
                        <label>Select Purpose</label>
                        <select class="form-control" id="taskPurposebyCluster">
                          <option selected disabled>Purpose</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                    </div>
                    <div id="companyLocationdatacard" class="card p-4" >
                      <input type="hidden" name="selectbyuser" id="selectbyuser" value=""> 
                      <div class="form-group" id="companyLocationdata" >
                        <label>Select Compnay</label>
                        <select class="form-control" id="companyLocation"></select>
                      </div>
                      <div class="form-group" id="selectactionplanecard" >
                        <label>Select Action</label>
                        <select class="form-control" id="selectactionplane">
                          <option selected value="">Select Action </option>
                          <!-- <option value="actionplaned">Action Planed</option> -->
                          <option value="actionnotplaned">Action not Planed</option>
                        </select>
                      </div>
                      <div class="form-group" id="daysfiltercard">
                        <label>Days</label>
                        <select id="daysfilter" class="form-control" name="days">
                          <option value="">All </option>
                          <option value="8">8 days </option>
                          <option value="15">15 days </option>
                          <option value="more">more than 15 days </option>
                        </select>
                      </div>
                    </div>
                    <div id="pstAssignCard" class="card p-4">
                      <!-- <h5>PST Assign Company</h5> -->
                      <hr>
                      <div class="form-group" id="pstAssignCarddiv" >
                        <label>Assign Company</label>
                        <select class="form-control" id="pstAssignCardData">
                          <option selected value="">Select One </option>
                          <option value="pst_assign">PST Assign</option>
                          <option value="other_assign">Cluster Assign</option>
                          <option value="admin_assign">Admin Assign</option>
                        </select>
                      </div>
                    </div>
                    <div id="taskActionCard" class="card p-4">
                    <div class="form-group" id="taskaction_card_area">
                        <div class="form-group">
                          <label>Task/Action</label>
                          <select id="task_action_filter" class="form-control" name="task_action_filter">
                            <option value="">Select Task</option>
                            <option value="all">All</option>
                            <?php foreach($action as $a){if($a->id!=9 && $a->id!=15){ ?>
                            <option value="<?=$a->id?>"><?=$a->name?></option>
                            <?php }} ?>
                          </select>
                        </div>
                      </div>
                      <div id="selectbarginCompanyType" class="form-group">
                          <select id="bcytpe" name="bcytpe" class="form-control mt-2">
                              <option value="">Select Bargin Company Type</option>
                              <option value="From Funnel">From Funnel</option>
                              <option value="Other">Other</option>
                            </select>
                        </div>
                        <div id="selectReseachCompanyType" class="form-group">
                          <select id="researchType" name="researchType" class="form-control mt-2">
                              <option value="">Select Research Type</option>
                              <option value="From Funnel">From Funnel</option>
                              <option value="Other">Other</option>
                            </select>
                        </div>
                      <div class="form-group" id="status_taskaction_card" >
                        <lable>Select Company Status : </lable>
                        <hr>
                        <select class="form-control" id="status_taskaction">
                          <option selected disabled>Select Status</option>
                          <option value="all">All</option>
                          <?php foreach($allStatus as $getstatus): ?>
                          <option value="<?= $getstatus->id ?>"><?= $getstatus->name ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group" id="taskActionbyuserCard">
                        <label>Select Action</label>
                        <select class="form-control" id="taskActionbyuserCardData">
                          <option selected disabled>Action</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="form-group" id="taskPurposebyuserCard">
                        <label>Select Purpose</label>
                        <select class="form-control" id="taskPurposebyuserCardData">
                          <option selected disabled>Purpose</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div id="partnertype" class="card p-4">
                        <div class="form-group">
                          <label>Partner Type</label>
                          <select id="partnertype_select" class="form-control" name="partnertype_select">
                            <option value="">Select Partner Type</option>
                            <option value="all">All</option>
                            <?php $get_partner = $this->Menu_model->get_partner();
                              foreach($get_partner as $a){
                              ?>
                            <option value="<?=$a->id?>"><?=$a->name?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group" id="partnertype_cstatus" >
                          <lable class="text-left">Select Company Status : </lable>
                          <select class="form-control" id="partnertype_cstatusData">
                            <option selected disabled>Select Status</option>
                            <?php foreach($allStatus as $getstatus): ?>
                            <option value="<?= $getstatus->id ?>"><?= $getstatus->name ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div id="partnertype_task">
                          <div class="form-group">
                            <label>Task/Action</label>
                            <select id="partnertype_taskData" class="form-control" name="task_action">
                              <option value="">Select Task</option>
                              <option value="all">All</option>
                              <?php foreach($action as $a){ ?>
                              <option value="<?=$a->id?>"><?=$a->name?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group" id="partnertype_taskAction">
                          <label>Select Action</label>
                          <select class="form-control" id="partnertype_taskActionData">
                            <option selected disabled>Action</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                        </div>
                        <div class="form-group" id="partnertype_taskPurpose">
                          <label>Select Purpose</label>
                          <select class="form-control" id="partnertype_taskPurposeData">
                            <option selected disabled>Purpose</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                        </div>
                      </div>
                      <div id="sameStatusLastLimitDays" class="card p-4" >
                        <div class="form-group" id="samestatuslast15days">
                          <lable class="text-left">Select Company Status : </lable>
                          <hr>
                          <select class="form-control" id="samestatuslast15daysData">
                            <option selected disabled>Select Status</option>
                            <option value="all">All</option>
                            <?php foreach($allStatus as $getstatus): ?>
                            <option value="<?= $getstatus->id ?>"><?= $getstatus->name ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group" id="partnertype_planbut" >
                          <label>Partner Type</label>
                          <select id="partnertype_planbutData" class="form-control" name="partnertype_planbut">
                            <option value="">Select Partner Type</option>
                            <option value="all">All</option>
                            <?php $get_partner = $this->Menu_model->get_partner();
                              foreach($get_partner as $a){
                              ?>
                            <option value="<?=$a->id?>"><?=$a->name?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group" id="daysfiltercard_planbut">
                          <label>Days</label>
                          <select id="daysfilter2_samedays" class="form-control" name="days">
                            <option value="">Select Days </option>
                            <option value="all">All </option>
                            <option value="8">8 days </option>
                            <option value="15">15 days </option>
                            <option value="more">more than 15 days </option>
                          </select>
                        </div>
                        <div class="form-group" id="planbut_taskActioncard">
                          <label>Select Action</label>
                          <select class="form-control" id="planbut_taskActionData">
                            <option selected disabled>Action</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                        </div>
                        <div class="form-group" id="planbut_taskPurposecard">
                          <label>Select Purpose</label>
                          <select class="form-control" id="planbut_taskPurposeData">
                            <option selected disabled>Purpose</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                        </div>
                      </div>
                      <div id="planbutnotinitiatedcard" class="card p-4" >
                        <div class="form-group">
                          <label>Task/Action</label>
                          <select id="planbutnoinit_TaskData" class="form-control" name="task_action">
                            <option value="">Select Task</option>
                                <?php 
                                $groupedByActionTypes = [];
                                foreach ($getPendingTask as $objects) {
                                    $actionTypeId = $objects->actiontype_id;
                                    if (!isset($groupedByActionTypes[$actionTypeId])) {
                                        $groupedByActionTypes[$actionTypeId] = [];
                                    }
                                    $groupedByActionTypes[$actionTypeId][] = $objects;
                                }
                                ?>
                            <?php 
                              foreach($groupedByActionTypes as $key => $petotaskData){
                                $getaction_name = $this->Menu_model->get_actionbyid($key)[0]->name;
                                $getaction_namecnts = sizeof($petotaskData);
                                echo "<option value='$key'>$getaction_name($getaction_namecnts)</options>";
                              }
                            ?>
                          </select>
                        </div>
                        <p class="p-2 text-white" id="plancomp"></p>
                      </div>

                      <div id="becauseofplanchange" class="card p-4" >
                        <div class="form-group">
                          <label>Task/Action</label>
                          <select id="planChange_TaskData" class="form-control" name="task_action">
                            <option value="">Select Task</option>
                                <?php 
                                $groupedByActionTypespc = [];
                                foreach ($planchangetask as $planchange) {
                                    $actionTypeId = $planchange->actiontype_id;
                                    if (!isset($groupedByActionTypespc[$actionTypeId])) {
                                        $groupedByActionTypespc[$actionTypeId] = [];
                                    }
                                    $groupedByActionTypespc[$actionTypeId][] = $planchange;
                                }
                                ?>
                            <?php 
                              foreach($groupedByActionTypespc as $key => $plan_change){
                                $getaction_name = $this->Menu_model->get_actionbyid($key)[0]->name;
                                $getaction_namecnts = sizeof($plan_change);
                                echo "<option value='$key'>$getaction_name($getaction_namecnts)</options>";
                              }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div id="planbutnotinitiatedcardold" class="card p-4" >
                        <div class="form-group">
                          <label>Task/Action (Old Pending Task)</label>
                          <select id="planbutnoinit_TaskDataold" class="form-control" name="task_action">
                            <option value="">Select Task</option>
                                <?php 
                                $groupedByActionTypes = [];
                                foreach ($getoldPendingTask as $objects) {
                                    $actionTypeId = $objects->actiontype_id;
                                    if (!isset($groupedByActionTypes[$actionTypeId])) {
                                        $groupedByActionTypes[$actionTypeId] = [];
                                    }
                                    $groupedByActionTypes[$actionTypeId][] = $objects;
                                }
                                ?>
                            <?php 
                              foreach($groupedByActionTypes as $key => $petotaskData){
                                $getaction_name = $this->Menu_model->get_actionbyid($key)[0]->name;
                                $getaction_namecnts = sizeof($petotaskData);
                                echo "<option value='$key'>$getaction_name($getaction_namecnts)</options>";
                              }
                            ?>
                          </select>
                        </div>
                        <p class="p-2 text-white" id="plancompold"></p>
                      </div>
                    </div>
                    <div id="firstQuarter1" class="card p-4" >
                    <div class="form-group" id="firstQuarter1cstatys" >
                          <lable class="text-left">Select Company Status : </lable>
                          <hr>
                          <select class="form-control" id="firstQuarter1cstatysData">
                            <option selected disabled>Select Status</option>
                            <option value="all">All</option>
                            <?php foreach($allStatus as $getstatus): ?>
                            <option value="<?= $getstatus->id ?>"><?= $getstatus->name ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <select id="firstQuarter1cstatysDataTask" name="" class="form-control">
                          <option selectedd disbaled value="" >Types of Task</option>
                          <option value="all">All</option>
                          <?php foreach($action as $a){if($a->id!=4 && $a->id!=6 && $a->id!=8 && $a->id!=9 && $a->id!=11 && $a->id!=12){ ?>
                          <option value="<?=$a->id?>"><?=$a->name?></option>
                          <?php }} ?>
                        </select>
                        <br>
                        <select class="form-control" id="firstQuarter1taskActionbyuser">
                          <option selected disabled>Action</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                        <br>
                        <select class="form-control" id="firstQuarter1taskPurposebyuser">
                          <option selected disabled>Purpose</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                    </div>
                    <div id="reviewTargetDate" class="card p-4" >
                    <div class="form-group" id="reviewTargetreviewtype" >
                        <select class="form-control" name="reviewtype" required="" id="reviewTargetreviewtypeData">
                        <option selected disabled>Select Review Time</option>
                            <option value="Self Weekly">Weekly</option>
                            <option value="Self Fortnightly">Fortnightly</option>
                            <option value="Self Monthly">Monthly</option>
                            <option value="Self Quarterly">Quarterly</option>
                        </select>
                    </div>
                    <div class="form-group" id="reviewTargetReviewSelf" >
                        <select class="form-control" name="reviewtype" required="" id="reviewTargetReviewSelfData">
                        <option selected disabled>Select Self / Other Review</option>
                            <option value="Self Review">Self Review</option>
                            <option value="Admin Review">Admin Review</option>
                            <option value="Cluster Review">Cluster Review</option>
                            <option value="PST Review">PST Review</option>
                        </select>
                    </div>
                    </div>
                          <div id="auto_assign" class="card p-4" >
                            <div class="form-group">
                                <label>Select Assign</label>
                                <select class="form-control" id="slct_auto_assign_task">
                                  <option value="" >Select Assign</option>
                                  <!-- <option value="Self Assign">Self Assign</option>
                                  <option value="Other Assign">Other Assign</option> -->
                                  <option value="Call Assign on Tentive Status">Call Assign on Tentive Status</option>
                                  <option value="Mom Check">MOM Check</option>
                                  <!-- <option value="Praposal Check">Praposal Check</option>
                                  <option value="Handover Check">Handover Check</option>
                                  <option value="BD Request Check">BD Request Check</option>
                                  <option value="Praposal write">BD Request Check</option> -->
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="slct_auto_assign_task_type">
                                </select>
                            </div>
                           <hr>
                           <p id="pendingdata_message"></p>
                        </div>
                        <div id="compulsive_task_card" class="card p-4" >
                        <div class="form-group" id="compulsive_task_card1">
                        <label>Select Status</label>
                        <?php  if($status_nochangecnt > 0){ ?>
                        <select class="form-control" id="statusnochanhecomp_status">
                            <option value="">Select Task</option>
                                <?php 
                                $statusnochanhecomp = [];
                                  foreach ($statusnochangecmp as $objects) {
                                      $cstatus = $objects->cstatus;
                                      if (!isset($statusnochanhecomp[$cstatus])) {
                                          $statusnochanhecomp[$cstatus] = [];
                                      }
                                      $statusnochanhecomp[$cstatus][] = $objects;
                                  }
                                  $statusnochanhecomp_wdl = [];
                                  foreach ($statusnochangecmp_wdl_nl as $objects_wdl_nl) {
                                      $cstatus = $objects_wdl_nl->cstatus;
                                      if (!isset($statusnochanhecomp_wdl[$cstatus])) {
                                          $statusnochanhecomp_wdl[$cstatus] = [];
                                      }
                                      $statusnochanhecomp_wdl[$cstatus][] = $objects_wdl_nl;
                                  }
                                ?>
                            <?php 
                              foreach($statusnochanhecomp as $key => $npstatus){
                                $getstatus_name = $this->Menu_model->get_statusbyid($key)[0]->name;
                                $npstatuscnt = sizeof($npstatus);
                                echo "<option class='text-danger' value='$key'>$getstatus_name($npstatuscnt)</options>";
                              }
                              foreach($statusnochanhecomp_wdl as $key => $npstatus){
                                $getstatus_name = $this->Menu_model->get_statusbyid($key)[0]->name;
                                $npstatuscnt = sizeof($npstatus);
                                echo "<option class='text-danger' value='$key'>$getstatus_name($npstatuscnt)</options>";
                              }
                            ?>
                          </select>
                        <?php } ?>
                      </div>
                      </div>

                      <div id="review_planning_card" class="card p-4">
                      <form action="<?=base_url();?>/Menu/PlanningForReview" method="post">
                    <div class="was-validated">
                    <div class="form-group">
                        <input type="hidden" name="uid" value="<?=$uid?>">
                         <lable>Review Start Date</lable>
                        <input type="date" name="plandate" value="<?=$adate?>" min="<?=$adate?>" class="form-control" readonly required="">
                        <lable>Review Start Time</lable>
                        <input type="time" id="review_plantime"  name="review_plantime" class="form-control" required="">
                        <div class="invalid-feedback text-white"> * Please provide Plan Date Time.</div>
                        <div class="valid-feedback">Looks good!</div>
                        <?php if($type_id ==3){ ?>
                        <div class="mt-4">
                            <select class="form-control" name="reviewtype" required="" id="reviewtype">
                                <option value="Self Weekly">Self Weekly</option>
                                <option value="Self Fortnightly">Self Fortnightly</option>
                                <option value="Self Monthly">Self Monthly</option>
                                <option value="Self Quarterly">Self Quarterly</option>
                            </select>
                        </div>
                        <?php }else if($type_id ==13 || $type_id ==4){ ?>
                          <div class="mt-4">
                            <select class="form-control" name="reviewtype" required="" id="reviewtype">
                                <option value="Roaster">Roaster</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Fortnightly">Fortnightly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Querterly">Querterly</option>
                                <option value="Self Review">Self Review</option>
                            </select>
                        </div>
                        <?php }?>

                        <!-- <input type="checkbox" id="myCheckbox" onclick="myFunction()">
                        <label>Do You Want to Change Period Time Frame.</label><br> -->
                        
                        <lable>Review Period</lable>
                        <?php 
                        $year = date("Y"); // Get the current year
                        $revdate = sprintf("%s-04-01", $year); // Format the date with the dynamic year 
                        ?>
                        <input type="date" name="fixdate" id="fixdate" value="<?= $revdate ?>" min="<?= $revdate ?>" class="form-control" required="" readonly="">
                        <?php if($type_id ==3){ ?>
                        <div class="mt-4">
                            <select class="form-control" name="bdid" required="">
                            <option value="<?=$uid?>"><?=$user['name']?></option>
                            </select>
                        </div>
                        <?php }?>

                        <?php if($type_id ==13 || $type_id ==4){ ?>
                          <div class="mt-4">
                            <select class="form-control" name="bdid" required="">
                                <option value="<?=$uid?>"><?=$user['name']?></option>
                                <?php $bd = $this->Menu_model->get_userbyaaid($uid);
                                 foreach($bd as $bd){?>
                                 <option value="<?=$bd->user_id?>"><?=$bd->name?></option>
                                 <?php } ?>
                            </select>
                        </div>
                        <?php }?>

                        <?php if($type_id ==13 || $type_id ==4){ ?>
                        <div class="mt-4">
                            <input type="text" name="meetlink" placeholder="Meeting Link" class="form-control" required="">
                            <div class="invalid-feedback text-white">* Please provide Meeting LInk.</div>
                        <div class="valid-feedback">Looks good!</div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" onclick="this.form.submit(); this.disabled = true;">Create Plan</button>
                    </div>
                    </div>
                  </form>
                      </div>
                  </div>
                  <div class="card col-lg-4 col-sm-4 p-2" id="content">
                    <div class="card" id="taskplanningimg"  >
                      <img src="https://stemapp.in//assets/image/planning1.jpg" alt="" >
                    </div>
                  <div class="card p-4" id="maintaskcard">
                  <p id="demo" class="text-center text-white hrclass p-2">Time Spent in Task Planning: 00:00:00</p>
                      <form method="post" action="<?=base_url();?>Menu/addplantask12" id="myForm" >
                        <div class="was-validated">
                          <input type="hidden" id="curuserid" value="<?=$uid?>" name="bdid" required=""> 
                          <input type="hidden" id="pdate" value="<?=$adate?>" name="pdate" required=""> 
                          <input type="hidden" readonly class="form-control" id="tptime" name="tptime" required=""> 
                          <hr>
                          <input type="time" id="meeting-time" name="ptime" min="10:00" max="19:00" class="form-control" required=""> 
                          <hr>
                          <div class="form-group" id="selectcompany">
                            <lable><span class="alertmessagecmp"><small>* You can only 3 company plans at a time</small></span></lable>
                            <select class="form-control" required="" multiple placeholder="Choose Company" data-allow-clear="1" name="selectcompanybyuser[]" id="selectcompanybyuser">
                              <option selected disabled>Select Company</option>
                              <option value="all">All</option>
                            </select>
                            <p id="totalcompany"></p>
                          </div>
                          <div class="form-group">
                          <select id="ntactionnew" name="ntaction" class="form-control" required="">
                              <option value="">Select Action</option>
                              <?php  foreach($action as $a){if($a->id!=3 && $a->id!=4 && $a->id!=6 && $a->id!=8 && $a->id!=9 && $a->id!=11 && $a->id!=17 && $a->id!=15 && $a->id!=18 && $a->id!=10){ ?>
                              <option value="<?=$a->id;?>"><?=$a->name;?></option>
                              <?php }} ?>
                            </select>
                          </div>
                          <div class="form-group">
                          <?php $clusters = $this->Menu_model->getClusterByUserId($uid); ?>
                            <select id="select_cluster" name="select_cluster" class="form-control">
                              <option selected value="">Select Cluster</option>
                              <?php  foreach($clusters as $cluster){ ?>
                              <option value="<?=$cluster->id;?>"><?=$cluster->clustername;?></option>
                              <?php } ?>
                            </select>
                          </div>

                          <input type="hidden" id="hiddenSelectStatus" name="selectstatusbyuser">
                          <input type="hidden" id="hiddenTaskAction" name="tasktaction">
                          <input type="hidden" id="hiddenTaskActionByUser" name="taskActionbyuser">
                          <input type="hidden" id="hiddenTaskPurposeByUser" name="taskPurposebyuser">
                          <input type="hidden" id="hiddenSelectStatusByUserNotPlanned" name="selectstatusbyusernotplaned">
                          <input type="hidden" id="hiddenTask_Action" name="task_action">
                          <input type="hidden" id="hiddenDaysFilterCardAnpDate" name="daysfiltercard_anp_date">
                          <input type="hidden" id="hiddenSelectdCategory" name="selectdcategory">
                          <input type="hidden" id="hiddenStatusFilterCardCat" name="statusfiltercardCat">
                          <input type="hidden" id="hiddenTaskActionByUserCat" name="taskActionbyusercat">
                          <input type="hidden" id="hiddenTaskPurposeByUserCatData" name="taskPurposebyusercatdata">
                          <input type="hidden" id="hiddenClusterNameLocation" name="clusterNameLocaction">
                          <input type="hidden" id="hiddenStatusFilterCluster" name="statusfilterCluster">
                          <input type="hidden" id="hiddenTaskActionByCluster" name="taskActionbyCluster">
                          <input type="hidden" id="hiddenTaskPurposeByCluster" name="taskPurposebyCluster">
                          <input type="hidden" id="hiddenCompanyLocation" name="companyLocation">
                          <input type="hidden" id="hiddenSelectActionPlane" name="selectactionplane">
                          <input type="hidden" id="hiddenDaysFilter" name="daysfilter">
                          <input type="hidden" id="hiddenPstAssignCardData" name="pstAssignCardData">
                          <input type="hidden" id="hiddenStatusTaskAction" name="status_taskaction">
                          <input type="hidden" id="hiddenTaskActionFilter" name="task_action_filter">
                          <input type="hidden" id="hiddenTaskActionByUserCardData" name="taskActionbyuserCardData">
                          <input type="hidden" id="hiddenTaskPurposeByUserCardData" name="taskPurposebyuserCardData">
                          <input type="hidden" id="hiddenPartnerTypeSelect" name="partnertype_select">
                          <input type="hidden" id="hiddenPartnerTypeCStatusData" name="partnertype_cstatusData">
                          <input type="hidden" id="hiddenPartnerTypeTaskData" name="partnertype_taskData">
                          <input type="hidden" id="hiddenPartnerTypeTaskActionData" name="partnertype_taskActionData">
                          <input type="hidden" id="hiddenPartnerTypeTaskPurposeData" name="partnertype_taskPurposeData">
                          <input type="hidden" id="hiddenSameStatusLast15DaysData" name="samestatuslast15daysData">
                          <input type="hidden" id="hiddenPartnerTypePlanButData" name="partnertype_planbutData">
                          <input type="hidden" id="hiddenDaysFilter2SameDays" name="daysfilter2_samedays">
                          <input type="hidden" id="hiddenPlanButTaskActionData" name="planbut_taskActionData">
                          <input type="hidden" id="hiddenPlanButTaskPurposeData" name="planbut_taskPurposeData">
                          <input type="hidden" id="hiddenPlanButNoInitTaskData" name="planbutnoinit_TaskData">
                          <input type="hidden" id="hiddenFirstQuarter1CStatusData" name="firstQuarter1cstatysData">
                          <input type="hidden" id="hiddenFirstQuarter1CStatusDataTask" name="firstQuarter1cstatysDataTask">
                          <input type="hidden" id="hiddenFirstQuarter1TaskActionByUser" name="firstQuarter1taskActionbyuser">
                          <input type="hidden" id="hiddenFirstQuarter1TaskPurposeByUser" name="firstQuarter1taskPurposebyuser">
                          <input type="hidden" id="hiddenReviewTargetReviewTypeData" name="reviewTargetreviewtypeData">
                          <input type="hidden" id="hiddenReviewTargetReviewSelfData" name="reviewTargetReviewSelfData">
                          <div class="form-group">
                            <select id="ntppose" class="form-control" name="ntppose" required="">
                              <option value='' disabled>Select Purpose</option>
                            </select>
                          </div>
                          <input type="hidden" class="form-control" value="" id="selectby" name="selectby">
                          <input type="hidden" class="form-control" value="" id="check_data" name="check_data">
                          <center><button class="btn btn-primary m-3" type="submit" id="planbtn1">Submit</button></center>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card col-lg-12 col-sm-12">
                    <div class="table-responsive mt-2">
                      <?php  
                      $rstData = $this->Menu_model->GetActiveTaskPlannerRestrication($adate);
                      ?>
                        <table id="example4" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead class="bg-danger">
                                <tr>
                                    <th class="bgresactive">S.No</th>
                                    <th class="bgresactive">User Type</th>
                                    <th class="bgresactive">Name</th>
                                    <th class="bgresactive">Company Status</th>
                                    <th class="bgresactive">Partner Type</th>
                                    <th class="bgresactive">Company Category</th>
                                    <th class="bgresactive">Restrication</th>
                                    <th class="bgresactive">Start&nbsp;Date</th>
                                    <th class="bgresactive">End&nbsp;Date</th>
                                    <th class="bgresactive">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i=1;
                                foreach($rstData as $data){
                                  $chk_user_types = explode(',', $data->user_types);
                                  $rsuser_ids = $data->user_ids;
                                  $user_ids_arr = explode(',', $rsuser_ids);
                                 
                                  if(in_array($type_id, $chk_user_types)) {
                                 
                                      if (empty($user_ids_arr[0]) || in_array($uid, $user_ids_arr)) {
                                ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                         <td>
                                            <?php 
                                            if($data->user_types !=='all'){
                                                $auser_types = $this->Menu_model->get_user_types($data->user_types);
                                                foreach($auser_types as $types){
                                                   $utypes = $types->name;
                                                    $utypes = str_replace(' ', '&nbsp;', $utypes);
                                                    echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >$utypes</span>";
                                                }
                                            }else{
                                                echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >All</span>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if($data->user_ids !==''){
                                                $rusers = $this->Menu_model->get_userbyids($data->user_ids);
                                                $k=1;
                                                foreach($rusers as $ruser){
                                                    if($k == 6){
                                                        echo "<br/>";
                                                        $k=1;
                                                    }
                                                    $ruser_name = $ruser->name;
                                                    $ruser_name = str_replace(' ', '&nbsp;', $ruser_name);
                                                    echo "<span class='p-2 bg-success m-1 text-capitalize' style='line-height: 50px;' >$ruser_name</span>";
                                                    $k++;
                                                 }
                                            }else{
                                                echo "<span class='p-2 bg-warning m-1' style='line-height: 50px;' >All</span>";
                                            }
                                            ?>
                                        </td>
                                        <td> 
                                        <?php 
                                            if($data->company_status !==''){
                                                $acompany_status = $this->Menu_model->get_statusbyMultiid($data->company_status);
                                                foreach($acompany_status as $c_statuss){
                                                    $com_status = $c_statuss->name;
                                                    $com_status = str_replace(' ', '&nbsp;', $com_status);
                                                    echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >$com_status</span>";
                                                }
                                            }else{
                                                if($data->company_status ==''){
                                                    echo "<span class='p-2 bg-warning m-1' style='line-height: 50px;' >All</span>";
                                                }
                                            }
                                            ?>
                                          </td>
                                        <td> 
                                        <?php 
                                            if($data->partner_types !==''){
                                                $apartner_types = $this->Menu_model->get_partnerbyMultiid($data->partner_types);
                                                foreach($apartner_types as $cprt_statuss){
                                                    $comp_partnername = $cprt_statuss->name;
                                                    $comp_partnername = str_replace(' ', '&nbsp;', $comp_partnername);
                                                    echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >$comp_partnername</span>";
                                                }
                                            }else{
                                                if($data->partner_types ==''){
                                                    echo "<span class='p-2 bg-warning m-1' style='line-height: 50px;' >All</span>";
                                                }
                                            }
                                            ?>
                                          </td>
                                         <td> 
                                        <?php 
                                          if($data->categorys ==''){
                                            echo "<span class='p-2 bg-warning m-1' style='line-height: 50px;' >All</span>";
                                        }else{
                                            $arrays = explode(',', $data->categorys);
                                            foreach($arrays as $arr){
                                                if($arr == 'topspender'){echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >Top&nbsp;Spender</span>";}
                                                if($arr == 'upsell_client'){echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >Upsell&nbsp;Client</span>";}
                                                if($arr == 'focus_funnel'){echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >Focus&nbsp;Funnel</span>";}
                                                if($arr == 'keycompany'){echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >Key&nbsp;Company</span>";}
                                                if($arr == 'pkclient'){echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >Positive&nbsp;Key&nbsp;Client</span>";}
                                                if($arr == 'all'){echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >All</span>";}
                                            }
                                        }
                                      ?></td>
                                       <td>
                                        <?php
                                        if($data->action_id !=='all'){
                                            $actiondata = $this->Menu_model->get_actionbyids($data->action_id);
                                            foreach($actiondata as $actiondatasp){
                                             $actiondataname = $actiondatasp->name;
                                             $actiondataname = str_replace(' ', '&nbsp;', $actiondataname);
                                            echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >$actiondataname</span>";
                                            }
                                        }else{
                                            echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >All</span>";
                                        }
                                         ?>
                                         </td>
                                         <td>
                                            <?= $data->sdate ?> 
                                        </td>
                                        <td>
                                        <?php
                                        $renddate = $data->edate;
                                        $currentDate = new DateTime();
                                        $givenDateObj = new DateTime($renddate);

                                        // Remove the time part from the current date for accurate comparison
                                        $currentDate->setTime(0, 0, 0);
                                        $givenDateObj->setTime(0, 0, 0);

                                        if ($givenDateObj < $currentDate) {
                                            echo "<span class='p-2 bg-danger m-1' style='line-height: 50px;' >$renddate</span><br>"; 
                                            echo "<span class='p-2 bg-danger m-1' style='line-height: 50px;' >The&nbsp;Restriction&nbsp;has&nbsp;expired.</span>";
                                        } elseif ($givenDateObj == $currentDate) {
                                            echo "<span class='p-2 bg-warning m-1' style='line-height: 50px;' >$renddate</span><br>"; 
                                            echo "<span class='p-2 bg-warning m-1' style='line-height: 50px;' >The&nbsp;Restriction&nbsp;expires&nbsp;today.</span>";
                                        } else {
                                            echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >$renddate</span><br>"; 
                                            echo "<span class='p-2 bg-success m-1' style='line-height: 50px;' >The&nbsp;Restriction&nbsp;is&nbsp;still&nbsp;active.</span>";
                                        }
                                        ?>
                                        </td>
                                        <td>
                                        <?php 
                                        if($data->status ==1){
                                            echo "<span class='p-2 bg-success'>Active</span>";
                                        }else{
                                             echo "<span class='p-2 bg-danger'>Inactive</span>";
                                        }
                                        ?>
                                        </td>
                                      
                                    </tr>
                                    <?php $i++; } }} ?>
                            </tbody>
                        </table>
                    </div>
                  </div>
                  <div class="card col-lg-12 col-sm-12" id="content">
                    <br>
                    <center>
                      <b><i>Total Time Spent in Task Planning : <?=$planSessionmin; ?></i></b>
                      <p class="m-auto" id="chart_div"></p>
                      <hr class="hrclass"style="width:80%"/>
                    </center>
                    <div class="row">
                      <div class="col-lg-6 col-sm" id="piechart1"></div>
                      <div class="col-lg-6 col-sm" id="piechart2"></div>
                    </div>
                    <script>
                      <?php 
                      $totaltaktimep = $this->Menu_model->get_totaltaktimep($uid,$adate); 
                      $ttime = $totaltaktimep[0]->ttime; 
                      $ttime = $ttime/60;
                      $getPlannerSession = $this->Menu_model->GetPlannerSession($uid);
                      $getPlannerSessioncnt = sizeof($getPlannerSession);
                      if($getPlannerSessioncnt != 0){
                      ?>
                      var pageLoadTime = new Date().getTime() - 0;
                      var x = setInterval(function() {
                      var now = new Date().getTime();
                      var timeSpent = now - pageLoadTime;
                      var hours = Math.floor((timeSpent / 1000) / 3600);
                      var minutes = Math.floor(((timeSpent / 1000) % 3600) / 60);
                      var seconds = Math.floor((timeSpent / 1000) % 60);
                      var formattedTimeSpent =
                      (hours < 10 ? "0" : "") + hours + ":" +
                      (minutes < 10 ? "0" : "") + minutes + ":" +
                      (seconds < 10 ? "0" : "") + seconds;
                      document.getElementById("demo").innerHTML = "Time Spent in Task Planning: " + formattedTimeSpent;
                      document.getElementById("tptime").value=formattedTimeSpent;
                      }, 1000);
                      <?php
                       }
                       ?>

                    </script>
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['gauge']});
                      google.charts.setOnLoadCallback(drawChart);
                      function drawChart() {
                      var data = google.visualization.arrayToDataTable([
                      ['Label', 'Value'],
                      ['Planning', <?=$ttime?>]
                      ]);
                      var options = {
                      redFrom: 0,
                      redTo: 3,
                      yellowFrom: 3,
                      yellowTo: 6,
                      greenFrom: 6,
                      greenTo: 8,
                      minorTicks: 4,
                      max: 8
                      };
                      var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
                      chart.draw(data, options);
                      }
                      google.charts.load("current", {packages:["corechart"]});
                      google.charts.setOnLoadCallback(drawChart2);
                      function drawChart2() {
                      var data = google.visualization.arrayToDataTable([
                      ['Status', 'No of Task'],
                      <?php $action = $this->Menu_model->get_tttbytimedaction($uid,$adate);
                        foreach($action as $ac){?>
                      ["<?=$ac->acname?> (<?=$ac->cont?>)", <?=$ac->cont?>],
                      <?php } ?>
                      ]);
                      var options = {
                      is3D: false,
                      };
                      var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
                      chart.draw(data, options);
                      }
                      google.charts.load("current", {packages:["corechart"]});
                      google.charts.setOnLoadCallback(drawChart4);
                      function drawChart4() {
                      var data = google.visualization.arrayToDataTable([
                      ['Status', 'No of Task'],
                      <?php $status = $this->Menu_model->get_tttbytimedstatus($uid,$adate);
                        foreach($status as $st){?>
                      ["<?=$st->stname?> (<?=$st->cont?>)", <?=$st->cont?>],
                      <?php } ?>
                      ]);
                      var options = {
                      is3D: false,
                      };
                      var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
                      chart.draw(data, options);
                      }
                    </script>
                    <hr>
                    <div>
                      <div id="accordion">
                        <div class="card">
                          <div class="card-header" id="headingOne">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne">
                              <h6>Task Planned for <?=$adate?></h6>
                            </button>
                          </div>
                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                              <?php $tted = $this->Menu_model->get_tttbytimedaction($uid,$adate); foreach($tted as $ted){?>
                              <span class="badge"  style="background-color:<?=$ted->aclr?>"><?=$ted->acname?> <span class="badge badge-light text-dark"><?=$ted->cont?></span></span>
                              <?php } ?>
                              <hr>
                              <?php $tted = $this->Menu_model->get_tttbytimedstatus($uid,$adate); foreach($tted as $ted){?>
                              <span class="badge" style="background-color:<?=$ted->sclr?>"><?=$ted->stname?> <span class="badge badge-light text-dark"><?=$ted->cont?></span></span>
                              <?php } ?>
                              <hr>
                              <h5></h5>
                              <?php $timeslot = $this->Menu_model->get_timeslot(); foreach($timeslot as $tl){
                                $t1=$tl->time1;$t2=$tl->time2;
                                ?>
                              <div class="card border border-info">
                                <div class="card-header">
                                  <b><?=date("h:i A", strtotime($tl->time1));?> to <?=date("h:i A", strtotime($tl->time2));?></b>
                                  </br>
                                  <?php  $ted = $this->Menu_model->get_ttbytimedaction($uid,$adate,$t1,$t2); foreach($ted as $ted){
                                    ?>
                                  <?php if($ted){?>
                                  <input type="hidden" id="timeslot-alloted_s" name="timeslot-alloted_s" value="<?=$tl->time1?>">
                                  <input type="hidden" id="timeslot-alloted_e" name="timeslot-alloted_e" value="<?=$tl->time2?>">
                                  <?php } ?>
                                  <span class="badge" style="background-color:<?=$ted->aclr?>"><?=$ted->acname?> <span class="badge badge-light text-dark"><?=$ted->cont?></span></span>
                                  <?php } ?>
                                  <hr>
                                  <?php $ted = $this->Menu_model->get_ttbytimedstatus($uid,$adate,$t1,$t2); foreach($ted as $ted){?>
                                  <span class="badge" style="background-color:<?=$ted->sclr?>"><?=$ted->stname?> <span class="badge badge-light text-dark"><?=$ted->cont?></span></span>
                                  <?php } ?>
                                </div>
                                <?php $totaltaktimep = $this->Menu_model->get_totaltaktimepbyh($uid,$adate,$t1,$t2);
                                  $ttime = $totaltaktimep[0]->ttime;
                                  if($ttime>'120'){$bcolor="bg-success"; $msg="Great! You have been scheduled for full-time utilization.";}
                                  elseif($ttime=='0'){$bcolor="bg-danger";$msg="Caution! Make sure to plan for this period.";}
                                  else{$bcolor="bg-warning";$msg="Nice job! Consider planning additional tasks.";}
                                  ?>
                                <div class="card-footer <?=$bcolor?>"><b><?=$msg?></b></div>
                              </div>
                              <?php } ?>
                              <br>
                              <?php if(sizeof($getplandt) > 0){ ?>
                              <div class="card border border-info">
                                <div class="card-header">
                                  <b>AutoTask Time: <?=date("h:i A", strtotime($getplandt[0]->stime));?> to <?=date("h:i A", strtotime($getplandt[0]->etime));?></b>
                                  </br>
                                  <?php
                                    $t1=$getplandt[0]->stime;
                                    $t2=$getplandt[0]->etime;
                                    $ted = $this->Menu_model->get_ttbytimedactionAutoTask($uid,$adate,$t1,$t2);
                                    foreach($ted as $ted){
                                    ?>
                                  <?php if($ted){?>
                                  <input type="hidden" id="timeslot-alloted_s" name="timeslot-alloted_s" value="<?=$tl->time1?>">
                                  <input type="hidden" id="timeslot-alloted_e" name="timeslot-alloted_e" value="<?=$tl->time2?>">
                                  <?php } ?>
                                  <span class="badge" style="background-color:<?=$ted->aclr?>"><?=$ted->acname?> <span class="badge badge-light text-dark"><?=$ted->cont?></span></span>
                                  <?php } ?>
                                  <hr>
                                  <?php
                                    $ted = $this->Menu_model->get_ttbytimedstatusAutoTask($uid,$adate,$t1,$t2);
                                    foreach($ted as $ted){
                                        ?>
                                  <span class="badge" style="background-color:<?=$ted->sclr?>"><?=$ted->stname?> <span class="badge badge-light text-dark"><?=$ted->cont?></span></span>
                                  <?php } ?>
                                </div>
                                <?php
                                  $totaltaktimep = $this->Menu_model->get_totaltaktimepbyh($uid,$adate,$t1,$t2);
                                      $ttime = $totaltaktimep[0]->ttime;
                                      if($ttime>'120'){$bcolor="bg-success"; $msg="Great! You have been scheduled for full-time utilization.";}
                                      elseif($ttime=='0'){$bcolor="bg-danger";$msg="Caution! Make sure to plan for this period.";}
                                      else{$bcolor="bg-warning";$msg="Nice job! Consider planning additional tasks.";}
                                  ?>
                                <div class="card-footer <?=$bcolor?>"><b><?=$msg?></b></div>
                              </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <center>
                          <button class="btn btn-info" id="printPage">Print Page</button> <br><br>
                          <p> <b> <span id="rtsyndp">Remaining Time to Start Your Next Days Planing:</span> <span  id="planertime"></span></b></p>
                        </center>
                      </div>
                    </div>
                  </div>
                  <section class="content">
                    <div class="container-fluid">
                      <div class="p-3" id="logs"></div>
                    </div>
                  </section>
                </div>
              </div>
            </section>
            <?php  }
              }
              ?>
          </div>
        </div>
      </div>

      <input type="hidden" value="<?=$adate?>" id = "uplanedate">
      <input type="hidden" value="<?=$phours?>" id = "phours">
      <input type="hidden" value="<?=$pminutes?>" id = "pminutes">
      <input type="hidden" value="<?=$pseconds?>" id = "pseconds">
      <script type='text/javascript'>
     
        var currentTime = new Date();
        var currentHours = currentTime.getHours();
        var currentMinutes = currentTime.getMinutes();
        currentHours = (currentHours < 10 ? "0" : "") + currentHours;
        currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
        var currentTimeString = currentHours + ":" + currentMinutes;
        var year = currentTime.getFullYear();
        var month = ("0" + (currentTime.getMonth() + 1)).slice(-2); // Month is zero-based, so we add 1 and pad with leading zero if needed
        var day = ("0" + currentTime.getDate()).slice(-2); // Pad with leading zero if needed
        // Construct the desired date format (YYYY-MM-DD)
        var formattedDate = year + "-" + month + "-" + day;
        var plandate = document.getElementById("plandate").value;
        if(plandate == formattedDate){
        document.getElementById("meeting-time").min = currentTimeString;
        document.getElementById("tasktimeplan").min = currentTimeString;
        }
        //   document.getElementById("meeting-time").min = currentTimeString;
        //   document.getElementById("tasktimeplan").min = currentTimeString;
        $(document).ready(function() {
        $('#meeting-time').on('change', function() {
        var enteredTime = $(this).val();
        var time = new Date('1970-01-01T' + enteredTime);
  
        // Get hours, minutes, and seconds
        var hours = ('0' + time.getHours()).slice(-2); // Ensure leading zero
        var minutes = ('0' + time.getMinutes()).slice(-2); // Ensure leading zero
        var seconds = ('0' + time.getSeconds()).slice(-2);
        var formattedTime = hours + ':' + minutes + ':' + seconds;
        var starttime = $('#timeslot-alloted_s').val();
        var endtime = $('#timeslot-alloted_e').val();
        // alert(starttime);
        var startMs = convertToMilliseconds($('#timeslot-alloted_s').val());
        var endMs = convertToMilliseconds($('#timeslot-alloted_e').val());
        var enteredMs = convertToMilliseconds(enteredTime);
        // Check if entered time is between start and end time frames
        if(plandate == formattedDate){
        if (enteredMs >= startMs && enteredMs <= endMs) {
        alert("You already have plan for this time slot");
        $('#planbtn1').css('display', 'none');
        } else {
        $('#planbtn1').css('display', '');
        }
        }
        });
        
        function convertToMilliseconds(timeStr) {
        var parts = timeStr.split(':');
        var hours = parseInt(parts[0], 10);
        var minutes = parseInt(parts[1], 10);
        var seconds = parseInt(parts[2], 10) || 0; // Default to 0 seconds if not provided
        return hours * 3600000 + minutes * 60000 + seconds * 1000;
        }
        });
        
        $("#cmpdetail,#statusmdetail,#locationdetail,#categorydetail,#notask15ddetail,#tobescheduled,#samesfld,#preplanned,#reviewtarget").hide();
        
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> -->
      <script type='text/javascript'>
   
                $(document).ready(function() {
                 $('#selectcompanyname').hide();
                 $("#selectstatus").hide();
                 $("#daysByTask").hide();
                 $("#selectcompanybyuser").hide();
                 $("#tasktaction").hide();
                 $('#taskActionbyuser').hide();
                 $('#taskPurposebyuser').hide();
                 $("#actionnotplaned").hide();
                 $("#tptime").hide();
                 $('#ntactionnew').hide();
                 $('#ntppose').hide();
                 $('#meeting-time').hide();
                 $('#planbtn1').hide();
                 $('#companyLocation').hide();
                 $('#companyLocationdata').hide();
                 $('#companyLocation').hide();
                 $('#selectCategory').hide();
                 $("#maintaskcard").hide();
                 $("#selectactionplanecard").hide();
                 $("#daysfiltercard").hide();
                 $("#companyLocationdatacard").hide();
                 $("#daysfiltercard_anp").hide();
                 $("#taskActionbyusercatcatcard").hide();
                 $("#taskPurposebyusercatcard").hide();
                 $("#clusterLocactionFiltercard").hide();
                 $("#statusfiltercardCluster").hide();
                 $("#taskActionbyuserCluster").hide();
                 $("#taskPurposebyuserCluster").hide();
                 $("#task_actionCard").hide();
                 $("#pstAssignCard").hide();
                 $('#taskActionCard').hide();
                 $('#status_taskaction_card').hide();
                 $('#taskaction_card_area').hide();
                 $('#taskActionbyuserCard').hide();
                 $('#taskPurposebyuserCard').hide();
                 $('#partnertype').hide();
                 $('#partnertype_cstatus').hide();
                 $('#partnertype_task').hide();
                 $('#partnertype_taskAction').hide();
                 $('#partnertype_taskPurpose').hide();
                 $('#sameStatusLastLimitDays').hide();
                 $('#partnertype_planbut').hide();
                 $('#daysfiltercard_planbut').hide();
                 $('#planbut_taskActioncard').hide();
                 $('#planbut_taskPurposecard').hide();
                 $('#planbutnotinitiatedcard').hide();
                 $('#planbutnotinitiatedcardold').hide();
                 $('#create_barg_in_meeting').hide();
                 $('#firstQuarter1').hide();
                 $('#firstQuarter1cstatys').hide();
                 $('#firstQuarter1cstatysDataTask').hide();
                 $('#firstQuarter1taskActionbyuser').hide();
                 $('#firstQuarter1taskPurposebyuser').hide();
                 $('#reviewTargetDate').hide();
                 $('#reviewTargetDate_typeoftaskCard').hide();
                 $('#reviewTargetDate_Action').hide();
                 $('#reviewTargetDate_Purpose').hide();
                 $('#reviewTargetReviewSelf').hide();
                 $('#reviewTargetReviewSelf').hide();
                 $('#select_cluster').hide();
                 $('#selectcompanyname_barg').hide();
                 $('#status_taskaction_card').hide();
                 $('#auto_assign').hide();
                 $('#selectbarginCompanyType').hide();
                 $('#selectReseachCompanyType').hide();
                 $('#slct_auto_assign_task_type').hide();
                 $('#pendingdata_message').hide();
                 $('#compulsive_task_card').hide();
                 $('#actionnotplaned_NeedYour').hide();
                 $("#review_planning_card").hide();
                 $("#need_your_attention").hide();
                 $("#becauseofplanchange").hide();
                 $("#becauseof_topsender_pst_meet").hide();
                 $("#becauseofTPM_TaskDatacard").hide();
                 $("#becauseofTPM_TaskDatacard_new").hide();
                });
        
                $("#mainbox").hide();$("#ScheduledBox").hide();
                $("#box0").hide();$("#box1").hide();$("#box2").hide();$("#box3").hide();$("#box4").hide();$("#box5").hide();
                $('#ntactionnew').on('change', function f() {    
                var inid = document.getElementById("selectcompanybyuser").value;
                var aid = document.getElementById("ntactionnew").value;
                
                var inidids = '';
                $('#selectcompanybyuser :selected').each(function(i, sel){
                    inidids += $(sel).val()+',';
                });
                if(aid==3){
                  $('#select_cluster').show().attr('required', '');;
                }else{
                  $('#select_cluster').hide().removeAttr('required');
                }
                $.ajax({
                url:'<?=base_url();?>Menu/getpurposebyinidnew',
                type: "POST",
                data: {
                inid: inidids,
                aid: aid
                },
                cache: false,
                success: function a(result){
                    console.log(result);
                $("#ntppose").html(result);
                }
                });
                });
        
                var radioButtons = document.querySelectorAll('input[name="optradio"]');
                radioButtons.forEach(function(radio) {
                radio.addEventListener('change', function() {
                var val = radio.value;
                $("#selectby").val(val);

                if(val =='actionNotPlannedNeed'){
                  $("#tasktype").text('No Work Days');
                }else if (val == 'actionNotPlanned'){
                  $("#tasktype").text('Action Not Planned');
                }else{
                  $("#tasktype").text(val);
                }
                
                if(val=='Compnay Name'){
                    var userslcttype = <?php echo $type_id; ?>;
                    if(userslcttype == 13){
                      $('#selectcompanyname').hide();
                      $("#selectstatus").hide();

                      $("#becauseof_topsender_pst_meet").show();
                    
                      $('#planning_funnel').on('change', function() {
                          var planning_funnel = $(this).val();
                          if(planning_funnel == 'Own funnel'){
                            $('#becauseofTPM_TaskDatacard').hide();
                            $('#becauseofTPM_TaskDatacard_new').hide();
                            $('#selectcompanyname').show();
                            $("#selectstatus").show();
                        $("#selectcompanybyuser").html('');

                          $.ajax({
                          url:'<?=base_url();?>Menu/getownfunnel',
                          type: "POST",
                          data: {
                          sid:'all',
                          uid: uid
                          },
                          cache: false,
                          success: function a(result){
                          $("#maintaskcard").show();    
                          $("#selectcompanybyuser").html(result);
                          $("#selectcompanybyuser").show();
                          var optionCount = $('#selectcompanybyuser').find('option').length;
                          optionCount = optionCount-1;
                          $("#totalcompany").text('Total Company :'+ optionCount);
                          $("#tptime").val('');
                          $("#tptime").show();
                          $('#ntactionnew').show();
                          $('#ntppose').show();
                          $('#meeting-time').show();
                          $('#planbtn1').show();
                          $("#taskplanningimg").hide();
                          }
                          });
                          }else if(planning_funnel == 'Other funnel'){
                            $('#becauseofTPM_TaskDatacard').show();
                            $('#selectcompanyname').hide();
                            $("#selectstatus").hide();
                            $("#tasktaction").hide();
                            $("#taskActionbyuser").hide();
                            $("#taskPurposebyuser").hide();
                            $("#taskplanningimg").show();

                            var becauseofTPM_TaskData_img = $("#becauseofTPM_TaskData").val();
                            var becauseofTPM_new_img = $("#becauseofTPM_new").val();
                            var planning_funnel_data = $("#planning_funnel").val();

                            if(becauseofTPM_TaskData_img == ''){
                              $("#taskplanningimg").show();
                            }else{
                              $("#taskplanningimg").hide();
                            }
                            if(becauseofTPM_new_img == ''){
                              $("#taskplanningimg").show();
                            }else{
                              $("#taskplanningimg").hide();
                            }
                            if(planning_funnel_data == '' && becauseofTPM_TaskData_img !==''){
                              $("#taskplanningimg").hide();
                            }else{
                              $("#taskplanningimg").hide();
                            }

                          }else if(planning_funnel == ''){
                            $('#becauseofTPM_TaskDatacard').hide();
                            $('#becauseofTPM_TaskDatacard_new').hide();
                            $("#taskplanningimg").show();
                            $('#selectcompanyname').hide();
                            $("#selectstatus").hide();
                            $("#maintaskcard").hide();
                            $("#tasktaction").hide();
                            $("#taskActionbyuser").hide();
                            $("#taskPurposebyuser").hide();

                          }
                      });

                    $('#becauseofTPM_TaskData').on('change', function() {
                        
                      var becauseofTPM = $(this).val();
                      $('#becauseofTPM_TaskDatacard_new').show();
                        $("#selectcompanybyuser").html('');
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmp_becauseoftpm',
                        type: "POST",
                        data: {
                        becauseofTPM: becauseofTPM,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();    
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $("#taskplanningimg").hide();
                        }
                        });
                      });

                      $('#becauseofTPM_new').on('change', function() {
                        
                        var usertypes = $('#becauseofTPM_TaskData').val();
                        var becauseofTPM = $(this).val();
                          $("#selectcompanybyuser").html('');
                          $.ajax({
                          url:'<?=base_url();?>Menu/get_becauseoftpm',
                          type: "POST",
                          data: {
                          usertypes: usertypes,
                          becauseofTPM: becauseofTPM,
                          uid: uid
                          },
                          cache: false,
                          success: function a(result){
                          $("#maintaskcard").show();    
                          $("#selectcompanybyuser").html(result);
                          $("#selectcompanybyuser").show();
                          var optionCount = $('#selectcompanybyuser').find('option').length;
                          optionCount = optionCount-1;
                          $("#totalcompany").text('Total Company :'+ optionCount);
                          $("#tptime").val('');
                          $("#tptime").show();
                          $('#ntactionnew').show();
                          $('#ntppose').show();
                          $('#meeting-time').show();
                          $('#planbtn1').show();
                          $("#taskplanningimg").hide();
                          }
                          });
                        });
                    }else{
                      $('#selectcompanyname').show();
                      $("#selectstatus").show();
                    }

                    $("#maintaskcard").hide();
                    $("#actionPlanned").show();
                    $("#actionnotplaned").hide();
                    $('#ntactionnew').hide();
                    $('#companyLocation').hide();
                    $('#tasktaction').hide();
                    $('#taskActionbyuser').hide();
                    $('#taskPurposebyuser').hide();
                    var uid = $("#curuserid").val();
                    
                    $('#search_company').on('input', function() {
                          var inputVal = $(this).val();
                          var options = $('#data').find('option').map(function() {
                              return $(this).val();
                          }).get();
                          var selectedId = null;
                          options.forEach(function(option) {
                              if (option.startsWith(inputVal)) {
                                  selectedId = option.split(' ')[0];
                              }
                          });
                          if (selectedId) {
                            $.ajax({
                              url:'<?=base_url();?>Menu/getUserCompBy_cmp_id',
                              type: "POST",
                              data: {
                              company_val: selectedId,
                              uid: uid
                              },
                              cache: false,
                              success: function a(result){
                              // alert(result);
                              $("#maintaskcard").show();    
                              $("#selectcompanybyuser").html(result);
                              $("#selectcompanybyuser").show();
                              var optionCount = $('#selectcompanybyuser').find('option').length;
                              optionCount = optionCount-1;
                              $("#totalcompany").text('Total Company :'+ optionCount);
                              $("#tasktaction").show();
                              $("#tptime").val('');
                              $("#tptime").show();
                              $('#ntactionnew').show();
                              $('#ntppose').show();
                              $('#meeting-time').show();
                              $('#planbtn1').show();
                              $("#taskplanningimg").hide();
                              }
                              });
                          }
                      });

                    $('#selectstatusbyuser').on('change', function() {
                    var selectedValue = $(this).val();
                        $("#daysByTask").show();
                        $("#selectcompanybyuser").html('');
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmp',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();    
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").show();
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $("#taskplanningimg").hide();
                        }
                        });
                    });

                    $('#tasktaction').on('change', function() {
                        var uid = $("#curuserid").val();
                        var tasktaction = $(this).val();
                        var selectedValue = $('#selectstatusbyuser').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmpwithtasktaction',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        tasktaction: tasktaction,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $('#taskActionbyuser').show();
                            }
                        });
                        });
        
                    $('#taskActionbyuser').on('change', function() {
                        var uid = $("#curuserid").val();
                        var taskActionbyuser = $(this).val();
                        var tasktaction = $('#tasktaction').val();
                        var selectedValue = $('#selectstatusbyuser').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getTaskActionYesorNobyuser',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        tasktaction: tasktaction,
                        taskActionbyuser: taskActionbyuser,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $('#taskPurposebyuser').show();
                            }
                        });
                        });
        
                        $('#taskPurposebyuser').on('change', function() {
                        var uid = $("#curuserid").val();
                        var taskPurposebyuser = $(this).val();
                        var tasktaction = $('#tasktaction').val();
                        var selectedValue = $('#selectstatusbyuser').val();
                        var taskActionbyuser = $('#taskActionbyuser').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getTaskPurposeYesorNobyuser',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        tasktaction: tasktaction,
                        taskActionbyuser: taskActionbyuser,
                        taskPurposebyuser: taskPurposebyuser,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                            }
                        });
                        });
                }else{
                  $('#selectcompanyname').hide();
                }
                if(val == 'actionNotPlanned'){
                    $("#maintaskcard").hide();
                    $("#actionPlanned").hide();
                    $("#actionnotplaned").show();
                    $('#companyLocationdata').hide();
                    $('#tasktaction').hide();
                    $('#taskActionbyuser').hide();
                    $('#taskPurposebyuser').hide();
                    $('#selectstatusbyusernotplaned').on('change', function() {
                    var selectstatusbyusernotplaned = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
               
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmpnotplaned',
                        type: "POST",
                        data: {
                        sid: selectstatusbyusernotplaned,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        // $('#daysfiltercard_anp').show();
                        $('#task_actionCard').show();
                        }
                        });
                    });

                    $('#task_action').on('change', function() {
                    var selectstatusbyusernotplaned = $('#selectstatusbyusernotplaned').val();
                    var task_action = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/taskactionnotplan',
                        type: "POST",
                        data: {
                        sid: selectstatusbyusernotplaned,
                        task_action: task_action,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#daysfiltercard_anp').show();
                        }
                        });
                    });
        
                    $('#daysfiltercard_anp_date').on('change', function() {

                    var selectstatusbyusernotplaned = $('#selectstatusbyusernotplaned').val();
                    var task_action = $('#task_action').val();
                    var daysfiltercard_anp_date = $(this).val();
                    
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
        
                    var uid = $("#curuserid").val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/taskactionnotplanwithdays',
                        type: "POST",
                        data: {
                        sid: selectstatusbyusernotplaned,
                        task_action: task_action,
                        daysfiltercard_anp_date: daysfiltercard_anp_date,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#daysfiltercard_anp').show();
                        }
                        });
                    });
                }else{
                    $("#actionnotplaned").hide();
                    $("#daysfiltercard_anp").hide();
                    $('#ntactionnew option').prop('disabled', false);
                }

                if(val=='Status'){
                    $("#maintaskcard").hide();
                    $("#actionPlanned").show();
                    $("#actionnotplaned").hide();
                    $('#ntactionnew').hide();
                    $('#companyLocation').hide();
                    $('#tasktaction').hide();
                    $('#taskActionbyuser').hide();
                    $('#taskPurposebyuser').hide();
                    var uid = $("#curuserid").val();
                    $("#selectstatus").show();
        
                    $('#selectstatusbyuser').on('change', function() {
                        var uid = $("#curuserid").val();
                        $("#selectcompanybyuser").html('');
                    var selectedValue = $(this).val();
                        $("#daysByTask").show();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmp',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").show();
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $("#taskplanningimg").hide();
                        }
                        });
                    });
        
                    $('#tasktaction').on('change', function() {
                        var tasktaction = $(this).val();
                        var selectedValue = $('#selectstatusbyuser').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmpwithtasktaction',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        tasktaction: tasktaction,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $('#taskActionbyuser').show();
                            }
                        });
                        });
                    $('#taskActionbyuser').on('change', function() {
        
                        var taskActionbyuser = $(this).val();
                        var tasktaction = $('#tasktaction').val();
                        var selectedValue = $('#selectstatusbyuser').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getTaskActionYesorNobyuser',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        tasktaction: tasktaction,
                        taskActionbyuser: taskActionbyuser,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $('#taskPurposebyuser').show();
                            }
                        });
                        });
        
                        $('#taskPurposebyuser').on('change', function() {
                        var taskPurposebyuser = $(this).val();
                        var tasktaction = $('#tasktaction').val();
                        var selectedValue = $('#selectstatusbyuser').val();
                        var taskActionbyuser = $('#taskActionbyuser').val();
        
                        $.ajax({
                        url:'<?=base_url();?>Menu/getTaskPurposeYesorNobyuser',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        tasktaction: tasktaction,
                        taskActionbyuser: taskActionbyuser,
                        taskPurposebyuser: taskPurposebyuser,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                            }
                        });
                        });
                }
                
                if(val=='Location'){
                    $("#maintaskcard").hide();
                    $("#actionPlanned").show();
                    $("#actionnotplaned").hide();
                    $('#ntactionnew').hide();
                    $('#tasktaction').hide();
                    $('#taskActionbyuser').hide();
                    $('#taskPurposebyuser').hide();
                    $("#selectstatus").hide();
                    $('#companyLocationdata').show();
                     $('#companyLocation').show();
                     $("#companyLocationdatacard").show();
                     $(".taskselectionarea").hide();
                     var uid = $("#curuserid").val();
                    $.ajax({
                    url:'<?=base_url();?>Menu/getcmpbybylocation',
                    type: "POST",
                    data: {
                    bylocation: 'bylocation',
                    uid: uid
                    },
                    cache: false,
                    success: function a(result){
                    $("#companyLocation").html(result);
                    }
                    });
        
                    $('#companyLocation').on('change', function() {
        
                        var uid = $("#curuserid").val();
                        $("#selectcompanybyuser").html('');
                       var companyLocation = $(this).val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmpbyloc',
                        type: "POST",
                        data: {
                        bylocation: companyLocation,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").hide();
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $("#selectactionplanecard").show();
                        $("#taskplanningimg").hide();
                        }
                        });
                    });
        
                    $('#selectactionplane').on('change', function() {
                    var uid = $("#curuserid").val();
                    $("#selectcompanybyuser").html('');
                    var selectactionplane = $(this).val();
                    if(selectactionplane !== 'Select Action'){
                    var companyLocation = $('#companyLocation').val();
                    $.ajax({
                    url:'<?=base_url();?>Menu/getcmpbylocaction',
                    type: "POST",
                    data: {
                    selectactionplane: selectactionplane,
                    bylocation: companyLocation,
                    uid: uid
                    },
                    cache: false,
                    success: function a(result){
                    $("#maintaskcard").show();
                    $("#selectcompanybyuser").html(result);
                    $("#selectcompanybyuser").show();
                    var optionCount = $('#selectcompanybyuser').find('option').length;
                    optionCount = optionCount-1;
                    $("#totalcompany").text('Total Company :'+ optionCount);
                    $("#tasktaction").hide();
                    $("#tptime").val('');
                    $("#tptime").show();
                    $('#ntactionnew').show();
                    $('#ntppose').show();
                    $('#meeting-time').show();
                    $('#planbtn1').show();
                    $('#daysfiltercard').show();
                    }
                    });
                }else{
                    // alert("Please Chhose Right Action");
                }
                  });
                }else{
                    $("#companyLocationdatacard").hide();
                    $(".taskselectionarea").show();
                    $("#companyLocation").html('');
                    $("#selectactionplanecard").hide();
                    $("#daysfiltercard").hide();
                }
        
                if(val=='Category'){
                
                $(".taskselectionarea").hide();
                $("#maintaskcard").hide();
                $('#selectCategory').show();
                $("#maintaskcard").hide();
                $("#actionPlanned").hide();
                $("#actionnotplaned").hide();
                $('#ntactionnew').hide();
                $('#tasktaction').hide();
                $("#selectstatus").hide();
                $('#companyLocationdata').hide();
                $('#companyLocation').hide();
                $('#statusfiltercardCategory').hide();
                    $('#selectdcategory').on('change', function() {
                        var uid = $("#curuserid").val();
                        $("#selectcompanybyuser").html('');
                       var selectdcategory = $(this).val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmpbycategory',
                        type: "POST",
                        data: {
                        category: selectdcategory,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        // optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").hide();
        
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#statusfiltercardCategory').show();
                        $("#taskplanningimg").hide();
                        }
                        });
                    });
        
                    $('#statusfiltercardCat').on('change', function() {
                      var uid = $("#curuserid").val();
                       var  selectdcategory = $('#selectdcategory').val();
                       var statusfiltercardCat = $(this).val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmpbycategory12',
                        type: "POST",
                        data: {
                        statusfiltercardCat: statusfiltercardCat,
                        category: selectdcategory,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        // optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").hide();
        
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#taskActionbyusercatcatcard').show();
                        }
                        });
                    });
        
                    $('#taskActionbyusercat').on('change', function() {
                        var uid = $("#curuserid").val();
                        $("#selectcompanybyuser").html('');
                       var selectdcategory = $('#selectdcategory').val();
                       var statusfiltercardCat = $('#statusfiltercardCat').val();
                       var taskActionbyusercatcat = $(this).val();

                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmpbycategory13',
                        type: "POST",
                        data: {
                        taskActionbyusercatcat: taskActionbyusercatcat,
                        statusfiltercardCat: statusfiltercardCat,
                        category: selectdcategory,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        // optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").hide();
        
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#taskPurposebyusercatcard').show();
                        }
                        });
                    });
        
        
                    $('#taskPurposebyusercatdata').on('change', function() {
                        var uid = $("#curuserid").val();
                        $("#selectcompanybyuser").html('');
                       var taskActionbyusercat = $('#taskActionbyusercat').val();
                       var selectdcategory = $('#selectdcategory').val();
                       var statusfiltercardCat = $('#statusfiltercardCat').val();
                       var taskPurposebyusercat = $(this).val();
                       $.ajax({
                        url:'<?=base_url();?>Menu/getcmpbycategory13',
                        type: "POST",
                        data: {
                        taskPurposebyusercat: taskPurposebyusercat,
                        taskActionbyusercatcat: taskActionbyusercat,
                        statusfiltercardCat: statusfiltercardCat,
                        category: selectdcategory,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        // optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").hide();
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();   
                        }
                        });
                    });
                }else{
                    $('#selectCategory').hide();
                }
        
                if(val == 'Cluster Location'){
                $(".taskselectionarea").hide();
                $("#maintaskcard").hide();
                $('#selectCategory').hide();
                $("#maintaskcard").hide();
                $("#actionPlanned").hide();
                $("#actionnotplaned").hide();
                $('#ntactionnew').hide();
                $('#tasktaction').hide();
                $("#selectstatus").hide();
                $('#companyLocationdata').hide();
                $('#companyLocation').hide();
                $('#statusfiltercardCategory').hide();
                $('#clusterLocactionFiltercard').show();
                $('#clusterNameLocaction').html('');
                $("#selectcompanybyuser").html('');
        
                $(".taskselectionarea").hide();
                var uid = $("#curuserid").val();
                $.ajax({
                url:'<?=base_url();?>Menu/getcmpbyClusterLocation',
                type: "POST",
                data: {
                bylocation: 'byclusterlocation',
                uid: uid
                },
                cache: false,
                success: function a(result){
                $("#clusterNameLocaction").html(result);
                }
                });
        
                $('#clusterNameLocaction').on('change', function() {
                    var uid = $("#curuserid").val();
                    $("#selectcompanybyuser").html('');
                    var clusterid= $(this).val();

                    var allowedValues = ['1', '2'];
                    if ($(this).val() === '') {
                      $('#ntactionnew').find('option').prop('disabled', false);
                        } else {
                            $('#ntactionnew').find('option').each(function() {
                                var option = $(this);
                                if (allowedValues.includes(option.val())) {
                                    option.prop('disabled', false);
                                } else {
                                    option.prop('disabled', true);
                                }
                            });
                        }
                    $.ajax({
                    url:'<?=base_url();?>Menu/getcmpbyClusterLocationid',
                    type: "POST",
                    data: {
                    clusterid: clusterid,
                    uid: uid
                    },
                    cache: false,
                    success: function a(result){
                    $("#maintaskcard").show();
                    $("#selectcompanybyuser").html(result);
                    $("#selectcompanybyuser").show();
                    var optionCount = $('#selectcompanybyuser').find('option').length;
                    if(optionCount == 1){
                        optionCount = 0;
                    }
                    // optionCount = optionCount-1;
                    $("#totalcompany").text('Total Company :'+ optionCount);
                    $("#tasktaction").hide();
                    $("#tptime").val('');
                    $("#tptime").show();
                    $('#ntactionnew').show();
                    $('#ntppose').show();
                    $('#meeting-time').show();
                    $('#planbtn1').show();
                    $('#statusfiltercardCluster').show();
                    $("#taskplanningimg").hide();
                    }
                    });
                    });
        
                    $('#statusfilterCluster').on('change', function() {
                    var uid = $("#curuserid").val();
                    $("#selectcompanybyuser").html('');
                    var clusterid= $('#clusterNameLocaction').val();
                    var statusfilterCluster= $(this).val();
                    $.ajax({
                    url:'<?=base_url();?>Menu/getcmpbyClusteridWithStatus',
                    type: "POST",
                    data: {
                    clusterid: clusterid,
                    statusfilterCluster: statusfilterCluster,
                    uid: uid
                    },
                    cache: false,
                    success: function a(result){
                    $("#maintaskcard").show();
                    $("#selectcompanybyuser").html(result);
                    $("#selectcompanybyuser").show();
                    var optionCount = $('#selectcompanybyuser').find('option').length;
                    if(optionCount == 1){
                        optionCount = 0;
                    }
                    // optionCount = optionCount-1;
                    $("#totalcompany").text('Total Company :'+ optionCount);
                    $("#tasktaction").hide();
                    $("#tptime").val('');
                    $("#tptime").show();
                    $('#ntactionnew').show();
                    $('#ntppose').show();
                    $('#meeting-time').show();
                    $('#planbtn1').show();
                    $('#taskActionbyuserCluster').show();
                    }
                    });
                    });
        
                    $('#taskActionbyCluster').on('change', function() {
                    var uid = $("#curuserid").val();
                    $("#selectcompanybyuser").html('');
                    var clusterid= $('#clusterNameLocaction').val();
                    var statusfilterCluster= $('#statusfilterCluster').val();
                    var taskActionbyCluster= $(this).val();
                    $.ajax({
                    url:'<?=base_url();?>Menu/getcmpbyClusteridWithStatusWithAction',
                    type: "POST",
                    data: {
                    clusterid: clusterid,
                    statusfilterCluster: statusfilterCluster,
                    taskActionbyCluster: taskActionbyCluster,
                    uid: uid
                    },
                    cache: false,
                    success: function a(result){
                    $("#maintaskcard").show();
                    $("#selectcompanybyuser").html(result);
                    $("#selectcompanybyuser").show();
                    var optionCount = $('#selectcompanybyuser').find('option').length;
                    if(optionCount == 1){
                        optionCount = 0;
                    }
                    // optionCount = optionCount-1;
                    $("#totalcompany").text('Total Company :'+ optionCount);
                    $("#tasktaction").hide();
        
                    $("#tptime").val('');
                    $("#tptime").show();
                    $('#ntactionnew').show();
                    $('#ntppose').show();
                    $('#meeting-time').show();
                    $('#planbtn1').show();
                    $('#taskPurposebyuserCluster').show();
                    }
                    });
                    });
                    $('#taskPurposebyCluster').on('change', function() {
                    var uid = $("#curuserid").val();
                    $("#selectcompanybyuser").html('');
                    var taskActionbyCluster= $('#taskActionbyCluster').val();
                    var clusterid= $('#clusterNameLocaction').val();
                    var statusfilterCluster= $('#statusfilterCluster').val();
                    var taskPurposebyCluster= $(this).val();
                    $.ajax({
                    url:'<?=base_url();?>Menu/getcmpbyClusteridWithStatusWithActionPurpose',
                    type: "POST",
                    data: {
                    clusterid: clusterid,
                    statusfilterCluster: statusfilterCluster,
                    taskActionbyCluster: taskActionbyCluster,
                    taskPurposebyCluster: taskPurposebyCluster,
                    uid: uid
                    },
                    cache: false,
                    success: function a(result){
                    $("#maintaskcard").show();
                    $("#selectcompanybyuser").html(result);
                    $("#selectcompanybyuser").show();
                    var optionCount = $('#selectcompanybyuser').find('option').length;
                    if(optionCount == 1){
                        optionCount = 0;
                    }
                    // optionCount = optionCount-1;
                    $("#totalcompany").text('Total Company :'+ optionCount);
                    $("#tasktaction").hide();
        
                    $("#tptime").val('');
                    $("#tptime").show();
                    $('#ntactionnew').show();
                    $('#ntppose').show();
                    $('#meeting-time').show();
                    $('#planbtn1').show();
                    }
                    });
                    });
                }else{
                    $('#clusterLocactionFiltercard').hide();
                }
        
                if(val == 'PST Assign'){
                    var uid = $("#curuserid").val();
                    $(".taskselectionarea").hide();
                    $('#pstAssignCard').show();
                    $('#pstAssignCardData').on('change', function() {
                        var pstAssignfilter= $(this).val();
                            $.ajax({
                            url:'<?=base_url();?>Menu/getpstassigncmp',
                            type: "POST",
                            data: {
                            pstassign: pstAssignfilter,
                            uid: uid
                            },
                            cache: false,
                            success: function a(result){
                            $("#maintaskcard").show();
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                            if(optionCount == 1){
                                optionCount = 0;
                            }
                            // optionCount = optionCount-1;
                            $("#totalcompany").text('Total Company :'+ optionCount);
                            $("#tasktaction").hide();
                            $("#tptime").val('');
                            $("#tptime").show();
                            $('#ntactionnew').show();
                            $('#ntppose').show();
                            $('#meeting-time').show();
                            $('#planbtn1').show();
                            $("#taskplanningimg").hide();
                            }
                            });
                    });
                }else{
                    $('#pstAssignCard').hide();
                    
                }
                if(val == 'PST Assigned Not Worked'){
                    $('#taskActionCard').show();
                    var uid = $("#curuserid").val();
                    $(".taskselectionarea").hide();
                    $('#pstAssignCard').show();
                }
        
                if(val !== 'Task Action'){
                  $('#ntactionnew option[value="3"]').remove();
                  $('#ntactionnew option[value="4"]').remove();
                }
                if(val == 'Task Action'){
                    var uid = $("#curuserid").val();
                    $(".taskselectionarea").hide();
                    $('#taskActionCard').show();
                    $('#maintaskcard').hide();
                    $('#taskaction_card_area').show();
                    $('#task_action_filter').show();
                    // $('#taskaction_card_area').hide();
                    $('#taskPurposebyuserCard').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#status_taskaction').hide();
                    $('#task_action_filter').on('change', function() {

                        $("#taskplanningimg").hide();
                        $("#selectcompanybyuser").html('');
                        $("#totalcompany").text('');
                        var uid = $("#curuserid").val();
                        var tasktaction = $(this).val();
                        if(tasktaction ==3){
                          $("#ntppose").html("<option value=''>Select Purpose</option>");
                          $('#status_taskaction_card').hide();
                          $('#status_taskaction').hide();
                          $('#taskActionbyuserCard').hide();
                          $('#taskPurposebyuserCard').hide();
                          $("#selectcompany").show();
                          $("#bcytpe").hide();
                          $('#selectReseachCompanyType').hide();
                          $.ajax({
                          url:'<?=base_url();?>Menu/get_SheduledMeetCompany',
                          type: "POST",
                          data: {
                          uid: uid
                          },
                          cache: false,
                          success: function a(result){
                            $("#maintaskcard").show();
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            $("#select_cluster").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                            optionCount = optionCount-1;
                            $("#totalcompany").text('Total Company :'+ optionCount);
                            $("#tasktaction").show();
                            $("#tptime").val('');
                            $("#tptime").show();
                            $('#ntactionnew').show();
                            $('#ntppose').show();
                            $('#meeting-time').show();
                            $('#planbtn1').show();
                            $("#taskplanningimg").hide();
                          var newOption = $('<option>', {
                              value: '3',
                              text: 'Scheduled Meeting',
                              selected: true,
                          });
                          $('#ntactionnew').append(newOption);
                          $('#ntactionnew option').prop('disabled', true);
                          $('#ntactionnew option[value="3"]').prop('disabled', false);
                          var inidids = '';
                            $('#selectcompanybyuser').change(function() {
                            var inidids = '';
                            $('#selectcompanybyuser :selected').each(function(i, sel){
                                inidids += $(sel).val() + ',';
                            });
                            inidids = inidids.slice(0, -1);
                            $.ajax({
                              url:'<?=base_url();?>Menu/getpurposebyinidnew',
                              type: "POST",
                              data: {
                              inid: inidids,
                              aid: 3
                              },
                              cache: false,
                              success: function a(result){
                                $("#ntppose").html(result);
                              }
                              });
                        });
                          }
                          });
                        }else if(tasktaction ==4){
                          $("#ntppose").html("<option value='34'>Fresh Meeting</option>");
                          $('#status_taskaction_card').hide();
                          $('#status_taskaction').hide();
                          $('#taskActionbyuserCard').hide();
                          $('#taskPurposebyuserCard').hide();
                          $('#maintaskcard').hide();
                          $("#bcytpe").show();
                          $('#selectbarginCompanyType').show();
                          $('#selectReseachCompanyType').hide();
                          $("#taskplanningimg").show();
                          $('#bcytpe').on('change', function() {
                            var bcytpe = $(this).val();
                          if(bcytpe == 'From Funnel'){
                            $("#taskplanningimg").hide();
                            $('#maintaskcard').show();
                            $("#selectcompany").show();
                          $.ajax({
                          url:'<?=base_url();?>Menu/get_BargeMeetCompany',
                          type: "POST",
                          data: {
                          uid: uid
                          },
                          cache: false,
                          success: function a(result){
                            $("#maintaskcard").show();
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            $("#select_cluster").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                            optionCount = optionCount-1;
                            $("#totalcompany").text('Total Company :'+ optionCount);
                            $("#tasktaction").show();
                            $("#tptime").val('');
                            $("#tptime").show();
                            $('#ntactionnew').show();
                            $('#ntppose').show();
                            $('#meeting-time').show();
                            $('#planbtn1').show();
                          var newOption = $('<option>', {
                              value: '4',
                              text: 'Barg in Meeting',
                              selected: true,
                          });

                          $('#ntactionnew').append(newOption);
                          $("#ntppose").html("<option value='135'>Remeeting</option>");
                          $('#ntactionnew option').prop('disabled', true);
                          $('#ntactionnew option[value="4"]').prop('disabled', false);

                          }
                          });
                            }else if(bcytpe == 'Other'){
                              $("#taskplanningimg").hide();
                              $("#maintaskcard").show();
                              $("#selectcompany").hide();
                              $("#select_cluster").show();
                              $("#tasktaction").show();
                              $("#tptime").val('');
                              $("#tptime").show();
                              $('#ntactionnew').show();
                              $('#ntppose').show();
                              $('#meeting-time').show();
                              $('#planbtn1').show();
                              
                              var newOption = $('<option>', {
                              value: '4',
                              text: 'Barg in Meeting',
                              selected: true,
                          });

                          $('#ntactionnew option').prop('disabled', true);
                          $('#ntactionnew option[value="4"]').prop('disabled', false);

                          $('#ntactionnew').append(newOption);
                              $("#ntppose").html("<option value='34'>Fresh Meeting</option>");
                              $('#selectcompanybyuser').removeAttr('required');
                            }
                          });
                        }else if(tasktaction ==17){
                          $("#ntppose").html("<option value=''>Select Purpose</option>");
                          $('#status_taskaction_card').hide();
                          $('#status_taskaction').hide();
                          $('#taskActionbyuserCard').hide();
                          $('#taskPurposebyuserCard').hide();
                          $("#selectcompany").show();
                          $("#bcytpe").hide();
                          $('#selectReseachCompanyType').hide();
                          $('#ntactionnew option').prop('disabled', true);
                          $('#ntactionnew option[value="17"]').prop('disabled', false);
                          
                          $.ajax({
                          url:'<?=base_url();?>Menu/get_JoinMeetingsCompany',
                          type: "POST",
                          data: {
                          uid: uid
                          },
                          cache: false,
                          success: function a(result){
                            $("#maintaskcard").show();
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            $("#select_cluster").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                            optionCount = optionCount-1;
                            $("#totalcompany").text('Total Company :'+ optionCount);
                            $("#tasktaction").show();
                            $("#tptime").val('');
                            $("#tptime").show();
                            $('#ntactionnew').show();
                            $('#ntppose').show();
                            $('#meeting-time').show();
                            $('#planbtn1').show();
                            $('#select_with_bd_pst').show();
                          var newOption = $('<option>', {
                              value: '17',
                              text: 'Join Meeting',
                              selected: true,
                          });

                          $('#ntactionnew option').prop('disabled', true);
                          $('#ntactionnew option[value="17"]').prop('disabled', false);
                          $('#ntactionnew').append(newOption);

                            var inidids = '';

                            $('#selectcompanybyuser').change(function() {
                            var inidids = '';
                            $('#selectcompanybyuser :selected').each(function(i, sel){
                                inidids += $(sel).val() + ',';
                            });
                            inidids = inidids.slice(0, -1);

                            $.ajax({
                              url:'<?=base_url();?>Menu/getpurposebyinidnew',
                              type: "POST",
                              data: {
                              inid: inidids,
                              aid: 3
                              },
                              cache: false,
                              success: function a(result){
                                $("#ntppose").html(result);
                              }
                              });
                             });
                          }
                          });

                        }else if(tasktaction ==10){
                          $('#selectReseachCompanyType').show();
                          $('#bcytpe').hide();
                          $('#researchType').on('change', function() {
                            $("#taskplanningimg").hide();
                            var researchType = $(this).val();
                          if(researchType == 'From Funnel'){
                            $('#maintaskcard').show();
                            $("#selectcompany").show();

                            $.ajax({
                              url:'<?=base_url();?>Menu/getstatuscmp',
                              type: "POST",
                              data: {
                              sid:1,
                              uid: uid
                              },
                              cache: false,
                              success: function a(result){
                          
                            $("#maintaskcard").show();
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            $("#select_cluster").hide();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                            optionCount = optionCount-1;
                            $("#totalcompany").text('Total Company :'+ optionCount);
                            $("#tasktaction").show();
                            $("#tptime").val('');
                            $("#tptime").show();
                            $('#ntactionnew').show();
                            $('#ntppose').show();
                            $('#meeting-time').show();
                            $('#planbtn1').show();
                            $('#ntactionnew option').prop('disabled', true);
                            $('#ntactionnew option[value="10"]').prop('disabled', false).prop('selected', true);
                            $("#ntppose").html("<option value='94'>Research & Data Collection</option>");
                              }
                              });
                            }
                            
                            else if(researchType == 'Other'){

                              $("#maintaskcard").show();
                              $("#selectcompany").hide();
                              $("#select_cluster").hide();
                              $("#tasktaction").show();
                              $("#tptime").val('');
                              $("#tptime").show();
                              $('#ntactionnew').show();
                              $('#ntppose').show();
                              $('#meeting-time').show();
                              $('#planbtn1').show();
                              $('#selectcompanybyuser').removeAttr('required');
                              $('#ntactionnew option').prop('disabled', true);
                              $('#ntactionnew option[value="10"]').prop('disabled', false).prop('selected', true);
                              $("#ntppose").html("<option value='94'>Research & Data Collection</option>");
                            }
                        });
                        }else{
                          $('#ntactionnew option[value="3"]').remove();
                          $('#ntactionnew option[value="4"]').remove();
                          $('#ntactionnew option[value="17"]').remove();
                          $('#selectbarginCompanyType').hide();
                          $("#select_cluster").hide();
                          $('#selectReseachCompanyType').hide();
                          $('#ntactionnew option').prop('disabled', false);
                          $("#ntppose").html("<option value=''>Select Purpose</option>");

                            $.ajax({
                            url:'<?=base_url();?>Menu/taskactionnotplan_filter',
                            type: "POST",
                            data: {
                            tasktaction: tasktaction,
                            uid: uid
                            },
                            cache: false,
                            success: function a(result){
                            $("#maintaskcard").show();
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                            optionCount = optionCount-1;
                            $("#totalcompany").text('Total Company :'+ optionCount);
                            $("#tptime").show();
                            $('#ntactionnew').show();
                            $('#ntppose').show();
                            $('#meeting-time').show();
                            $('#planbtn1').show();
                            // $('#daysfiltercard_anp').show();
                            $('#status_taskaction_card').show();
                            $('#status_taskaction').show();
                                }
                            });
                        }
                        });

                    $('#status_taskaction').on('change', function() {
                    var selectstatusbyusernotplaned = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
                    var tasktaction =  $('#task_action_filter').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmpnotplaned',
                        type: "POST",
                        data: {
                        sid: selectstatusbyusernotplaned,
                        tasktaction: tasktaction,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                              $("#selectcompanybyuser").show();
                              var optionCount = $('#selectcompanybyuser').find('option').length;
                          optionCount = optionCount-1;
                          $("#totalcompany").text('Total Company :'+ optionCount);
                          $('#taskActionbyuserCard').show();
                        }
                        });
                    });


                    $('#taskActionbyuserCardData').on('change', function() {
                        var taskActionbyuserCardData = $(this).val();
                        var selectedValue1 = $('#status_taskaction').val();
                        var tasktaction =  $('#task_action_filter').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/taskactionnotplan_filter_action',
                        type: "POST",
                        data: {
                        sid: selectedValue1,
                        tasktaction: tasktaction,
                        tasktactionData: taskActionbyuserCardData,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $('#taskPurposebyuserCard').show();
                            }
                        });
                        });
        
                    $('#taskPurposebyuserCardData').on('change', function() {
                        var taskPurposebyuserCardData = $(this).val();
                        var taskActionbyuserCardData =  $('#taskActionbyuserCardData').val();
                        var selectedValue1 = $('#status_taskaction').val();
                        var tasktaction =  $('#task_action_filter').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/taskactionnotplan_filter_purpose',
                        type: "POST",
                        data: {
                        sid: selectedValue1,
                        tasktaction: tasktaction,
                        tasktactionData: taskActionbyuserCardData,
                        taskPurposeData: taskPurposebyuserCardData,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $('#taskPurposebyuserCard').show();
                            }
                        });
        
                        });
                }else{
                    $('#taskActionCard').hide();
                }
        
                if(val =='Partner Type'){
        
                    var uid = $("#curuserid").val();
                    $(".taskselectionarea").hide();
                    $('#taskActionCard').show();
                    $('#partnertype').show();
                    $('#maintaskcard').hide();
                    $('#status_taskaction_card').hide();
                    $('#taskaction_card_area').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#taskPurposebyuserCard').hide();
                    $('#partnertype_select').on('change', function() {
                    var partnertype = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();





                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_partnertype',
                        type: "POST",
                        data: {
                        partnertype: partnertype,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#partnertype_cstatus').show();
                        $("#taskplanningimg").hide();
                        }
                        });
                    });
        
        
                    $('#partnertype_cstatusData').on('change', function() {
                    var partnertype_cstatus = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
                    var partnertype = $('#partnertype_select').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_partnertypeCstatus',
                        type: "POST",
                        data: {
                        partnertype: partnertype,
                        partnertype_cstatus: partnertype_cstatus,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#partnertype_task').show();
                        }
                        });
                    });
        
        
                    $('#partnertype_taskData').on('change', function() {
                    var partnertype_task = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
                    var partnertype = $('#partnertype_select').val();
                    var partnertype_cstatus = $('#partnertype_cstatusData').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_partnertypeCstatusTask',
                        type: "POST",
                        data: {
                        partnertype: partnertype,
                        partnertype_cstatus: partnertype_cstatus,
                        partnertype_task: partnertype_task,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#partnertype_taskAction').show();
                        }
                        });
                    });
        
        
                    $('#partnertype_taskActionData').on('change', function() {
                    var partnertype_taskAction = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
                    var partnertype = $('#partnertype_select').val();
                    var partnertype_cstatus = $('#partnertype_cstatusData').val();
                    var partnertype_task = $('#partnertype_taskData').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_partnertypeCstatusTaskAction',
                        type: "POST",
                        data: {
                        partnertype: partnertype,
                        partnertype_cstatus: partnertype_cstatus,
                        partnertype_task: partnertype_task,
                        partnertype_taskAction: partnertype_taskAction,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#partnertype_taskPurpose').show();
        
                        }
                        });
                    });
        
                    $('#partnertype_taskPurposeData').on('change', function() {
                    var partnertype_taskPurpose = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
                    var partnertype = $('#partnertype_select').val();
                    var partnertype_cstatus = $('#partnertype_cstatusData').val();
                    var partnertype_task = $('#partnertype_taskData').val();
                    var partnertype_taskAction = $('#partnertype_taskActionData').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_partnertypeCstatusTaskPurpose',
                        type: "POST",
                        data: {
                        partnertype: partnertype,
                        partnertype_cstatus: partnertype_cstatus,
                        partnertype_task: partnertype_task,
                        partnertype_taskAction: partnertype_taskAction,
                        partnertype_taskPurpose: partnertype_taskPurpose,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#partnertype_taskPurpose').show();
        
                        }
                        });
                    });
                    }else{
                        $('#partnertype').hide();
                    }
        
                    if(val == 'Plan But Not Initiated'){
                    $('#taskActionCard').show();
                    $('#planbutnotinitiatedcard').show();
                    var uid = $("#curuserid").val();
                    $(".taskselectionarea").hide();
                    $('#partnertype').hide();
                    $('#maintaskcard').hide();
                    $('#status_taskaction_card').hide();
                    $('#taskaction_card_area').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#taskPurposebyuserCard').hide();
                    
                    $.ajax({
                        url:'<?=base_url();?>Menu/getallcmp_planbutnotinited',
                        type: "POST",
                        data: {
                        taskaction:'all',
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#plancomp").text('Plan But Not Initiated = '+result);
                        }
                        });
        
                    $('#planbutnoinit_TaskData').on('change', function() {
                    var planbutnotinitiated_taskaction = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_planbutnotinited',
                        type: "POST",
                        data: {
                        taskaction: planbutnotinitiated_taskaction,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        if(optionCount == 0){
                            optionCount = 0;
                        }
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#partnertype_cstatus').show();
                        $('#ntactionnew').hide();
                        $('#ntppose').hide();
                        $("#taskplanningimg").hide();
                        $('#planbtn1').click(function() {
                                var newValue = '0';
                                var newText = 'Pending Task Action';
                                $('#ntactionnew').append(new Option(newText, newValue));
                                $('#ntppose').append(new Option(newText, newValue));
                                $('#ntactionnew').val(newValue);
                                $('#ntppose').val(newValue);   
                            });
                        }
                        });
                    });
                    }else{
                        $('#planbutnotinitiatedcard').hide();
                    }
        
                    if(val == 'Plan But Not Initiated Old'){
                    $('#taskActionCard').show();
                    $('#planbutnotinitiatedcardold').show();
                    var uid = $("#curuserid").val();
                    $(".taskselectionarea").hide();
                    $('#partnertype').hide();
                    $('#maintaskcard').hide();
                    $('#status_taskaction_card').hide();
                    $('#taskaction_card_area').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#taskPurposebyuserCard').hide();
                    
                    $.ajax({
                        url:'<?=base_url();?>Menu/getallcmp_planbutnotinitedold',
                        type: "POST",
                        data: {
                        taskaction:'all',
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#plancompold").text('Plan But Not Initiated = '+result);
                        }
                        });
        
                    $('#planbutnoinit_TaskDataold').on('change', function() {
                    var planbutnotinitiated_taskaction = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_planbutnotinitedOld',
                        type: "POST",
                        data: {
                        taskaction: planbutnotinitiated_taskaction,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        if(optionCount == 0){
                            optionCount = 0;
                        }
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#partnertype_cstatus').show();
                        $("#taskplanningimg").hide();
                        $('#ntactionnew').hide();
                        $('#ntppose').hide();

                        $('#planbtn1').click(function() {

                                var newValue = '0';
                                var newText = 'Pending Task Action';
                                $('#ntactionnew').append(new Option(newText, newValue));
                                $('#ntppose').append(new Option(newText, newValue));
                                $('#ntactionnew').val(newValue);
                                $('#ntppose').val(newValue);

                                val = 'Plan But Not Initiated';
                                $("#selectby").val(val);
                               
                            });
                        }
                        });
                    });
                    }else{
                        $('#planbutnotinitiatedcardold').hide();
                    }
                    if(val == 'FirstQuarter1'){
                    $('#firstQuarter1cstatys').show();
                    $('#taskActionCard').hide();
                    $('#firstQuarter1').show();  
                    var uid = $("#curuserid").val();
                    $(".taskselectionarea").hide();
                    $('#partnertype').hide();
                    $('#maintaskcard').hide();
                    $('#status_taskaction_card').hide();
                    $('#taskaction_card_area').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#taskPurposebyuserCard').hide();
        
                    $.ajax({
                        url:'<?=base_url();?>Menu/getquarter1company',
                        type: "POST",
                        data: {
                        quarter:'quarter',
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount -1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#partnertype_cstatus').show();
                        $('#ntactionnew').hide();
                        $('#ntppose').hide();
                        $("#taskplanningimg").hide();
                        }
                        });

                        $('#firstQuarter1cstatysData').on('change', function() {
                    var selectedValue = $(this).val();
                        $("#daysByTask").show();
                        $("#selectcompanybyuser").html('');
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmp',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();    
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").show();
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#firstQuarter1cstatysDataTask').show();
                        }
                        });
                    });

                    $('#firstQuarter1cstatysDataTask').on('change', function() {
                        var uid = $("#curuserid").val();
                        var tasktaction = $(this).val();
                        var selectedValue = $('#firstQuarter1cstatysData').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmpwithtasktaction',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        tasktaction: tasktaction,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $('#firstQuarter1taskActionbyuser').show();
                            }
                        });
                        });
                        $('#firstQuarter1taskActionbyuser').on('change', function() {
                        var uid = $("#curuserid").val();
                        var taskActionbyuser = $(this).val();
                        var tasktaction = $('#firstQuarter1cstatysDataTask').val();
                        var selectedValue = $('#selectstatusbyuser').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getTaskActionYesorNobyuser',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        tasktaction: tasktaction,
                        taskActionbyuser: taskActionbyuser,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        // $('#taskPurposebyuser').show();
                        $('#firstQuarter1taskPurposebyuser').show();
                            }
                        });
        
                        });
        
                        $('#firstQuarter1taskPurposebyuser').on('change', function() {
                            var uid = $("#curuserid").val();
                        var taskPurposebyuser = $(this).val();
                        var tasktaction = $('#tasktaction').val();
                        var selectedValue = $('#selectstatusbyuser').val();
                        var taskActionbyuser = $('#firstQuarter1taskActionbyuser').val();
        
                        $.ajax({
                        url:'<?=base_url();?>Menu/getTaskPurposeYesorNobyuser',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        tasktaction: tasktaction,
                        taskActionbyuser: taskActionbyuser,
                        taskPurposebyuser: taskPurposebyuser,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                            }
                        });
        
                        });
                    }else{
                        $('#firstQuarter1').hide();  
                    }
                    if(val == 'Same Status Last Limit Days'){
                    $('#taskActionCard').show();
                    $('#sameStatusLastLimitDays').show();
        
                    var uid = $("#curuserid").val();
                    $(".taskselectionarea").hide();
                    $('#partnertype').hide();
                    $('#maintaskcard').hide();
                    $('#status_taskaction_card').hide();
                    $('#taskaction_card_area').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#taskPurposebyuserCard').hide();
                    
                    $('#samestatuslast15daysData').on('change', function() {
                    var samestatuslast15daysData = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_samestatuslastdays',
                        type: "POST",
                        data: {
                        samestatus: samestatuslast15daysData,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#partnertype_planbut').show();
                        $("#taskplanningimg").hide();
                        }
                        });
                    });
        
        
                    $('#partnertype_planbutData').on('change', function() {
                    var partnertype_planbutData = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
        
                    var uid = $("#curuserid").val();
                    var samestatuslast15daysData = $('#samestatuslast15daysData').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_samestatuslastdaysPartner',
                        type: "POST",
                        data: {
                        samestatus: samestatuslast15daysData,
                        partnertype: partnertype_planbutData,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#daysfiltercard_planbut').show();
        
                        }
                        });
                    });
        
                    $('#daysfilter2_samedays').on('change', function() {
                    var daysfilter2_samedays = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
        
                    var uid = $("#curuserid").val();
                    var samestatuslast15daysData = $('#samestatuslast15daysData').val();
                    var partnertype_planbutData = $('#partnertype_planbutData').val();
        
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_samestatuslastdaysPartnerDays',
                        type: "POST",
                        data: {
                        samestatus: samestatuslast15daysData,
                        partnertype: partnertype_planbutData,
                        daysfilter: daysfilter2_samedays,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#planbut_taskActioncard').show();
                        }
                        });
                    });
        
        
                    $('#planbut_taskActionData').on('change', function() {
                    var planbut_taskActioncardData = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
        
                    var uid = $("#curuserid").val();
                    var samestatuslast15daysData = $('#samestatuslast15daysData').val();
                    var partnertype_planbutData = $('#partnertype_planbutData').val();
                    var daysfilter2_samedays = $('#daysfilter2_samedays').val();
        
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_samestatuslastdaysPartnerDaysAction',
                        type: "POST",
                        data: {
                        samestatus: samestatuslast15daysData,
                        partnertype: partnertype_planbutData,
                        daysfilter: daysfilter2_samedays,
                        taskActioncard: planbut_taskActioncardData,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#planbut_taskPurposecard').show();
        
                        }
                        });
                    });
        
                    $('#planbut_taskPurposeData').on('change', function() {
                    var planbut_taskPurposeData = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
        
                    var uid = $("#curuserid").val();
                    var samestatuslast15daysData = $('#samestatuslast15daysData').val();
                    var partnertype_planbutData = $('#partnertype_planbutData').val();
                    var daysfilter2_samedays = $('#daysfilter2_samedays').val();
                    var planbut_taskActioncardData = $('#planbut_taskActionData').val();
        
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_samestatuslastdaysPartnerDaysPurpose',
                        type: "POST",
                        data: {
                        samestatus: samestatuslast15daysData,
                        partnertype: partnertype_planbutData,
                        daysfilter: daysfilter2_samedays,
                        taskActioncard: planbut_taskActioncardData,
                        taskPurposecard: planbut_taskPurposeData,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        }
                        });
                    });
                    }else{
                        $('#sameStatusLastLimitDays').hide();
                    }

                    if(val == 'Review Target Date'){

                        $('#taskActionCard').hide();
                        $('#reviewTargetDate').show();
                        var uid = $("#curuserid").val();
                        $(".taskselectionarea").hide();
                        $('#partnertype').hide();
                        $('#maintaskcard').hide();
                        $('#status_taskaction_card').hide();
                        $('#taskaction_card_area').hide();
                        $('#taskActionbyuserCard').hide();
                        $('#taskPurposebyuserCard').hide();

                        $('#reviewTargetreviewtypeData').on('change', function() {
                        var getreviewtype = $(this).val();
                        $("#daysByTask").show();
                        $("#selectcompanybyuser").html('');
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_getreviewtype',
                        type: "POST",
                        data: {
                        getreviewtype: getreviewtype,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();    
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").show();
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#reviewTargetReviewSelf').show();
                        // $('#reviewTargetDate_typeoftaskCard').show();
                        $("#taskplanningimg").hide();
                        }
                        });
                    });
                        $('#reviewTargetReviewSelfData').on('change', function() {
                        var getreviewtypeself = $(this).val();
                        var getreviewtype = $('#reviewTargetreviewtypeData').val();
                        $("#daysByTask").show();
                        $("#selectcompanybyuser").html('');
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_getreviewtype_self',
                        type: "POST",
                        data: {
                        getreviewtypeself: getreviewtypeself,
                        getreviewtype: getreviewtype,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();    
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").show();
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#reviewTargetReviewSelf').show();
                        // $('#reviewTargetDate_typeoftaskCard').show();
                        }
                        });
                    });

                        $('#reviewTargetDateData').on('change', function() {
                        var selectedValue = $(this).val();
                        $("#daysByTask").show();
                        $("#selectcompanybyuser").html('');
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmp_reviewTarget',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();    
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").show();
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#reviewTargetDate_typeoftaskCard').show();
                        }
                        });
                    });

                    
                        $('#reviewTargetDate_typeoftaskData').on('change', function() {
                        var reviewTargetDate_typeoftaskData = $(this).val();
                        var selectedValue = $('#reviewTargetDateData').val();
                        $("#daysByTask").show();
                        $("#selectcompanybyuser").html('');
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_reviewTarget_typeoftaskData',
                        type: "POST",
                        data: {
                        sid: selectedValue,
                        typeoftask: reviewTargetDate_typeoftaskData,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();    
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tasktaction").show();
                        $("#tptime").val('');
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#reviewTargetDate_Action').show();
                        }
                        });
                    });

                    }else{
                        $('#reviewTargetDate').hide();
                    }

                    if(val == 'Self Assign'){
                    $('#auto_assign').show();
                    $(".taskselectionarea").hide();
                    $('#partnertype').hide();
                    $('#maintaskcard').hide();
                    $('#status_taskaction_card').hide();
                    $('#taskaction_card_area').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#taskPurposebyuserCard').hide();
                    var uid = $("#curuserid").val();
                    $('#slct_auto_assign_task').on('change', function() {
                        var selectedValue = $(this).val();
                        if(selectedValue == 'Call Assign on Tentive Status'){
                          $('#selectby').val('Plan When MOM Approved'); 
                          $('#pendingdata_message').hide();
                          $('#start_check,#end_check').removeAttr('required');
                          $.ajax({
                            url:'<?=base_url();?>Menu/getAutoAssignTask',
                            type: "POST",
                            data: {
                            selectedValue: selectedValue,
                            uid: uid
                            },
                            cache: false,
                            success: function a(result){
                              $("#slct_auto_assign_task_type").show();
                              $("#slct_auto_assign_task_type").html(result);
                            }
                            });
                            $('#slct_auto_assign_task_type').on('change', function() {
                            var tasktype = $(this).val(); //when is mom task
                            var slcttasktype = $('#slct_auto_assign_task').val(); //when is mom task
                            $.ajax({
                            url:'<?=base_url();?>Menu/getAutoAssignTaskWithType',
                            type: "POST",
                            data: {
                            selectedValue: slcttasktype,
                            tasktype: tasktype,
                            uid: uid
                            },
                            cache: false,
                            success: function a(result){
                              // console.log(result);
                            $("#maintaskcard").show();
                            $("#selectcompany").show();
                            $("#selectcompanybyuser").html(result);
                            $("#selectcompanybyuser").show();
                            var optionCount = $('#selectcompanybyuser').find('option').length;
                            if(optionCount == 0){
                                optionCount = 0;
                            }
                            $("#totalcompany").text('Total Company :'+ optionCount);
                            $("#tptime").show();
                            $('#meeting-time').show();
                            $('#planbtn1').show();
                            $('#ntactionnew').show();
                            $('#ntactionnew').hide();
                            $('#ntppose').hide();
                            $("#taskplanningimg").hide();
                            $('#ntppose,#ntactionnew').removeAttr('required');
                              }
                        });
                      });   
                        }else{
                          $('#slct_auto_assign_task_type').hide();
                          if(selectedValue =='Mom Check'){
                                $.ajax({
                                url:'<?=base_url();?>Menu/getPendingTeamMoM',
                                type: "POST",
                                data: {
                                uid: uid
                                },
                                cache: false,
                                success: function a(result){
                                  if(result >0){
                                    
                                    $("#maintaskcard").show();
                                    $("#selectcompany").hide();
                                    $("#taskplanningimg").hide();
                                    $("#selectcompanybyuser").hide();
                                    $("#tptime").show();
                                    $('#meeting-time').show();
                                    $('#planbtn1').show();
                                    $('#ntactionnew').hide();
                                    $('#ntactionnew').hide();
                                    $('#ntppose').hide();
                                    $('#ntppose,#ntactionnew,#selectcompanybyuser').removeAttr('required');
                                  }
                                  $('#pendingdata_message').show();
                                  $('#pendingdata_message').text(result +" Pending MOM For Check");
                                  $('#check_data').val(selectedValue);
                              }
                            });
                          }
                        }
                    });
                    }else{
                      $('#auto_assign').hide();
                      $('#ntppose, #ntactionnew, #selectcompanybyuser').attr('required', 'required');
                      $("#selectcompany").show();
                      $('#pendingdata_message').hide();
        
                    }

                    if(val == 'Compulsive Task'){

                    $('#compulsive_task_card').show();
                    $(".taskselectionarea").hide();
                    $('#partnertype').hide();
                    $('#maintaskcard').hide();
                    $('#status_taskaction_card').hide();
                    $('#taskaction_card_area').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#taskPurposebyuserCard').hide();
                    var uid = $("#curuserid").val();
                    
                    $('#statusnochanhecomp_status').on('change', function() {
                    var selectstatusbyusernotplaned = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
               
                        $.ajax({
                        url:'<?=base_url();?>Menu/nostatuschange_indate',
                        type: "POST",
                        data: {
                        sid: selectstatusbyusernotplaned,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $("#taskplanningimg").hide();
                        $('#ntactionnew option').prop('disabled', true);
                        $('#ntactionnew option[value="1"]').prop('disabled', false);
                        }
                        });
                    });
                    }else{
                      $('#compulsive_task_card').hide();
                      $('#ntactionnew option').prop('disabled', false);
                      $("#selectcompany").show();
                      $('#pendingdata_message').hide();
                    }

                    if(val == 'actionNotPlannedNeed'){
                      $("#actionnotplaned_NeedYour").show();
                      $("#actionPlanned").hide();
                      $(".taskselectionarea").hide();
                      $('#selectstatusbyusernotplanedCompany').on('change', function() {
                    var selectstatusbyusernotplaned = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
               
                        $.ajax({
                        url:'<?=base_url();?>Menu/getstatuscmpnotplanedCompany',
                        type: "POST",
                        data: {
                        sid: selectstatusbyusernotplaned,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $("#taskplanningimg").hide();
                        $('#ntactionnew option').prop('disabled', true);
                        $('#ntactionnew option[value="1"]').prop('disabled', false);
                        }
                        });
                    });
                    }else{
                    $("#actionnotplaned_NeedYour").hide();
                    $("#daysfiltercard_anp").hide();
                    $('#ntactionnew option').prop('disabled', false);
                    $("#taskplanningimg").show();
                    }

                    if(val == 'Review Planning'){
                      $("#review_planning_card").show();
                      $(".taskselectionarea").hide();
                      $('#maintaskcard').hide();
                    }else{
                      $("#review_planning_card").hide();
                    }



                    if(val == 'Need Your Attention'){
                      $("#need_your_attention").show();
    
                
                    $(".taskselectionarea").hide();
                    $('#partnertype').hide();
                    $('#maintaskcard').hide();
                    $('#status_taskaction_card').hide();
                    $('#taskaction_card_area').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#taskPurposebyuserCard').hide();
                    var uid = $("#curuserid").val();

                    $('#need_your_attention_slsct').on('change', function() {
                    var selectstatusbyusernotplaned = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();

                        $.ajax({
                        url:'<?=base_url();?>Menu/NeedYourAttentionInCompany',
                        type: "POST",
                        data: {
                        sid: selectstatusbyusernotplaned,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        optionCount = optionCount-1;
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $("#taskplanningimg").hide();
                        $('#ntactionnew option').prop('disabled', true);
                        $('#ntactionnew option[value="1"]').prop('disabled', false);
                        }
                        });
                    });
                  }else{
                    $("#need_your_attention").hide();
                  }

              

            if(val == 'Because of Plan Change'){

                    $('#taskActionCard').show();
                    $('#becauseofplanchange').show();

                    var uid = $("#curuserid").val();

                    $(".taskselectionarea").hide();
                    $('#partnertype').hide();
                    $('#maintaskcard').hide();
                    $('#status_taskaction_card').hide();
                    $('#taskaction_card_area').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#taskPurposebyuserCard').hide();
                    
                    $('#planChange_TaskData').on('change', function() {
                    var planChange_action = $(this).val();
                    $("#selectcompanybyuser").html('');
                    $("#totalcompany").text('');
                    var uid = $("#curuserid").val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/getcmp_becauseofplanchange',
                        type: "POST",
                        data: {
                        taskaction: planChange_action,
                        uid: uid
                        },
                        cache: false,
                        success: function a(result){
                        $("#maintaskcard").show();
                        $("#selectcompanybyuser").html(result);
                        $("#selectcompanybyuser").show();
                        var optionCount = $('#selectcompanybyuser').find('option').length;
                        if(optionCount == 0){
                            optionCount = 0;
                        }
                        $("#totalcompany").text('Total Company :'+ optionCount);
                        $("#tptime").show();
                        $('#ntactionnew').show();
                        $('#ntppose').show();
                        $('#meeting-time').show();
                        $('#planbtn1').show();
                        $('#partnertype_cstatus').show();
                        $('#ntactionnew').hide();
                        $('#ntppose').hide();
                        $("#taskplanningimg").hide();
                        $('#planbtn1').click(function() {
                                var newValue = '0';
                                var newText = 'Pending Task Action';
                                $('#ntactionnew').append(new Option(newText, newValue));
                                $('#ntppose').append(new Option(newText, newValue));
                                $('#ntactionnew').val(newValue);
                                $('#ntppose').val(newValue);   
                            });
                        }
                        });
                    });
                    }else{
                      $('#becauseofplanchange').hide();
                    }



                });
                });
               
          $(document).ready(function() {

            $('#planningStart1').hide();
            $('#planningStart2').hide();
            $('#plantimerBox').hide();
            $('#planningStartbtn').show();

            var timerInterval;
            var startTime;
            // Function to update the timer every second
            function updateTimer() {
                clearInterval(timerInterval); // Clear any existing interval to prevent multiple intervals
                timerInterval = setInterval(function() {
                    var currentTime = new Date();
                    var elapsedTime = currentTime - startTime;
                    var seconds = Math.floor((elapsedTime / 1000) % 60);
                    var minutes = Math.floor((elapsedTime / (1000 * 60)) % 60);
                    var hours = Math.floor((elapsedTime / (1000 * 60 * 60)) % 24);

                    $('#timer').text(
                        (hours < 10 ? "0" + hours : hours) + ":" +
                        (minutes < 10 ? "0" + minutes : minutes) + ":" +
                        (seconds < 10 ? "0" + seconds : seconds)
                    );
                }, 1000);
            }

            // Function to show/hide the form based on timer status
            function toggleFormVisibility() {
                if (startTime) {
                  $('#planningStart1').show();
                    $('#planningStart2').show();
                    $('#plantimerBox').show();
                    $('#planningStartbtn').hide();
                } else {
                   $('#planningStart1').hide();
                    $('#planningStart2').hide();
                    $('#plantimerBox').hide();
                    $('#planningStartbtn').show();
                }
            }

            // Initialize the timer from local storage if the start button was previously clicked
            if (localStorage.getItem('timerStartTime')) {
                startTime = new Date(localStorage.getItem('timerStartTime'));
                updateTimer();
                toggleFormVisibility();
            }

            // Start button click event
            $('#start').click(function() {
                if (!startTime) {
                    startTime = new Date();
                    localStorage.setItem('timerStartTime', startTime);
                    updateTimer();
                    toggleFormVisibility();
                    alert("Planner Timer started!");

                    $.ajax({
                        url:'<?=base_url();?>Menu/session_plan_time_start',
                        type: "POST",
                        data: {
                          start: 'start',
                        },
                        cache: false,
                        success: function a(result){
                        }
                        });

                      var pageLoadTime = new Date().getTime() - 0;
                      var x = setInterval(function() {
                      var now = new Date().getTime();
                      var timeSpent = now - pageLoadTime;
                      var hours = Math.floor((timeSpent / 1000) / 3600);
                      var minutes = Math.floor(((timeSpent / 1000) % 3600) / 60);
                      var seconds = Math.floor((timeSpent / 1000) % 60);
                      var formattedTimeSpent =
                      (hours < 10 ? "0" : "") + hours + ":" +
                      (minutes < 10 ? "0" : "") + minutes + ":" +
                      (seconds < 10 ? "0" : "") + seconds;
                      document.getElementById("demo").innerHTML = "Time Spent in Task Planning: " + formattedTimeSpent;
                      document.getElementById("tptime").value=formattedTimeSpent;
                      }, 1000);
                }
            });

            // Stop button click event
            $('#stop').click(function() {
                if (startTime) {

                  var timerval = $("#timer").text();

                    resetTimer();
                    alert("Planner Timer stopped and reset!");
                    $.ajax({
                        url:'<?=base_url();?>Menu/session_plan_time_close',
                        type: "POST",
                        data: {
                          close: timerval,
                        },
                        cache: false,
                        success: function a(result){
                          location.reload();
                        }
                        });
                        clearInterval(x);
                        document.getElementById("demo").innerHTML = "Time Spent in Task Planning: " + "00:00:00";
                }
            });
          
            // Function to reset the timer
            function resetTimer() {
                clearInterval(timerInterval); // Stop the timer
                startTime = null;
                localStorage.removeItem('timerStartTime'); // Clear the start time from local storage
                $('#timer').text("00:00:00"); // Reset the timer display
                toggleFormVisibility();
            }


            $('#meetingtimerequest2').on('change', function() {
              var mtime1 = $('#meetingtimerequest1').val();
              if(mtime1 == ''){
                alert("Please Enter Start Time");
                  $('#meetingtimerequest2').val('');
              }else{
                var mtime2 = $(this).val();
                $.ajax({
                        url:'<?=base_url();?>Menu/GetTaskBeetweenUserTime',
                        type: "POST",
                        data: {
                          mtime1: mtime1,
                          mtime2: mtime2
                        },
                        cache: false,
                        success: function a(result){
                          $('#taskcounttable').html(result);
                        }
                        });
              }
          });


          $('#end-time').on('change', function() {
              var startTime = $('#start-time').val();
              if (startTime === '') {
                  alert("Please Enter Start Time");
                  $('#end-time').val('');
              } else {
                  var endTime = $(this).val();
                  var startTimeMinutes = convertTimeToMinutes(startTime);
                  var endTimeMinutes = convertTimeToMinutes(endTime);
                  // Check if the difference is more than 90 minutes
                  if ((endTimeMinutes - startTimeMinutes) > 90) {
                      alert('Auto Task Max Time is Only 90 Minutes');
                      $('#end-time').val('');
                  }
              }
          });
          function convertTimeToMinutes(time) {
                          var timeParts = time.split(':');
                          var hours = parseInt(timeParts[0], 10);
                          var minutes = parseInt(timeParts[1], 10);
                          return (hours * 60) + minutes;
                      }


         var uid = $("#curuserid").val();
          $.ajax({
            url:'<?=base_url();?>Menu/getUserDayStartStatus',
            type: "POST",
            data: {
              uid: uid,
            },
            cache: false,
            success: function a(result){
                if(result ==2){
                  $('#compulsive_task_filter input[name="optradio"]').prop('disabled', true);
                  // $('#compulsive_task_filter label').css('text-decoration', 'line-through');
                  $('#actionNotPlannedNeed_filter input[name="optradio"]').prop('disabled', true);
                  $('#company_name_filter input[name="optradio"]').prop('disabled', true);
                  $('#company_status_filter input[name="optradio"]').prop('disabled', true);

                  $('#cluster_location_fiilter input[name="optradio"]').prop('disabled', true);
                  $('#company_category_filter input[name="optradio"]').prop('disabled', true);
                  $('#partner_type_filter input[name="optradio"]').prop('disabled', true);
                  $('#ssllimit_days_filter input[name="optradio"]').prop('disabled', true);

                  $('#other_assign_filter input[name="optradio"]').prop('disabled', true);
                  $('#self_assign_filter input[name="optradio"]').prop('disabled', true);
                  $('#review_target_date_filter input[name="optradio"]').prop('disabled', true);
                  $('#review_planning_filter input[name="optradio"]').prop('disabled', true);
                  $('#need_your_attention_filter input[name="optradio"]').prop('disabled', true);

                  $('#actionNotPlanned_task_filter input[name="optradio"]').prop('disabled', true);
                  $('#task_action_filter option').not('[value="3"], [value="4"]').attr('disabled', true);

                }
            }
            });
          });
      </script>
      <style>
        #myInput {
        background-position: 10px 12px;
        background-repeat: no-repeat;
        width: 100%;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
        }
        #myUL {
        list-style-type: none;
        padding: 0;
        margin: 0;
        }
        #myUL li a {
        border: 1px solid #ddd;
        margin-top: -1px; /* Prevent double borders */
        background-color: #f6f6f6;
        padding: 12px;
        text-decoration: none;
        font-size: 18px;
        color: black;
        display: block
        }
        #myUL li a:hover:not(.header) {
        background-color: #eee;
        }
      </style>
      <script>
        function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
        } else {
        li[i].style.display = "none";
        }
        }
        }
      </script>



<script>
        $(document).ready(function () {
          $('#myForm').on('submit', function () {
              // Populate hidden fields with form input values
              $('#hiddenSelectStatus').val($('#selectstatusbyuser').val());
              $('#hiddenTaskAction').val($('#tasktaction').val());
              $('#hiddenTaskActionByUser').val($('#taskActionbyuser').val());
              $('#hiddenTaskPurposeByUser').val($('#taskPurposebyuser').val());

              $('#hiddenSelectStatusByUserNotPlanned').val($('#selectstatusbyusernotplaned').val());
              $('#hiddenTask_Action').val($('#task_action').val());
              $('#hiddenDaysFilterCardAnpDate').val($('#daysfiltercard_anp_date').val());
              $('#hiddenSelectdCategory').val($('#selectdcategory').val());
              $('#hiddenStatusFilterCardCat').val($('#statusfiltercardCat').val());
              $('#hiddenTaskActionByUserCat').val($('#taskActionbyusercat').val());
              $('#hiddenTaskPurposeByUserCatData').val($('#taskPurposebyusercatdata').val());
              $('#hiddenClusterNameLocation').val($('#clusterNameLocaction').val());
              $('#hiddenStatusFilterCluster').val($('#statusfilterCluster').val());
              $('#hiddenTaskActionByCluster').val($('#taskActionbyCluster').val());
              $('#hiddenTaskPurposeByCluster').val($('#taskPurposebyCluster').val());
              $('#hiddenCompanyLocation').val($('#companyLocation').val());
              $('#hiddenSelectActionPlane').val($('#selectactionplane').val());
              $('#hiddenDaysFilter').val($('#daysfilter').val());
              $('#hiddenPstAssignCardData').val($('#pstAssignCardData').val());
              $('#hiddenStatusTaskAction').val($('#status_taskaction').val());
              $('#hiddenTaskActionFilter').val($('#task_action_filter').val());
              $('#hiddenTaskActionByUserCardData').val($('#taskActionbyuserCardData').val());
              $('#hiddenTaskPurposeByUserCardData').val($('#taskPurposebyuserCardData').val());
              $('#hiddenPartnerTypeSelect').val($('#partnertype_select').val());
              $('#hiddenPartnerTypeCStatusData').val($('#partnertype_cstatusData').val());
              $('#hiddenPartnerTypeTaskData').val($('#partnertype_taskData').val());
              $('#hiddenPartnerTypeTaskActionData').val($('#partnertype_taskActionData').val());
              $('#hiddenPartnerTypeTaskPurposeData').val($('#partnertype_taskPurposeData').val());
              $('#hiddenSameStatusLast15DaysData').val($('#samestatuslast15daysData').val());
              $('#hiddenPartnerTypePlanButData').val($('#partnertype_planbutData').val());
              $('#hiddenDaysFilter2SameDays').val($('#daysfilter2_samedays').val());
              $('#hiddenPlanButTaskActionData').val($('#planbut_taskActionData').val());
              $('#hiddenPlanButTaskPurposeData').val($('#planbut_taskPurposeData').val());
              $('#hiddenPlanButNoInitTaskData').val($('#planbutnoinit_TaskData').val());
              $('#hiddenFirstQuarter1CStatusData').val($('#firstQuarter1cstatysData').val());
              $('#hiddenFirstQuarter1CStatusDataTask').val($('#firstQuarter1cstatysDataTask').val());
              $('#hiddenFirstQuarter1TaskActionByUser').val($('#firstQuarter1taskActionbyuser').val());
              $('#hiddenFirstQuarter1TaskPurposeByUser').val($('#firstQuarter1taskPurposebyuser').val());
              $('#hiddenReviewTargetReviewTypeData').val($('#reviewTargetreviewtypeData').val());
              $('#hiddenReviewTargetReviewSelfData').val($('#reviewTargetReviewSelfData').val());

              // Allow form to be submitted normally
              return true;
          });
      });

    </script>


<script>
$(document).ready(function(){
  
        $("#selectstatusbyuser").change(function(){
          var sid = $(this).val();
          if (sid == 1) {
            $('#ntactionnew option[value="10"]').prop('disabled', false);
            } else {
                $('#ntactionnew option[value="10"]').prop('disabled', true);
            }
        });
        $("#status_taskaction").change(function(){
          var sid = $(this).val();
          if (sid == 1) {
            $('#ntactionnew option[value="10"]').prop('disabled', false);
            } else {
                $('#ntactionnew option[value="10"]').prop('disabled', true);
            }
        });
        $("#statusfilterCluster").change(function(){
          var sid = $(this).val();
          if (sid == 1) {
            $('#ntactionnew option[value="10"]').prop('disabled', false);
            } else {
                $('#ntactionnew option[value="10"]').prop('disabled', true);
            }
        });
        $("#statusfiltercardCat").change(function(){
          var sid = $(this).val();
          if (sid == 1) {
            $('#ntactionnew option[value="10"]').prop('disabled', false);
            } else {
                $('#ntactionnew option[value="10"]').prop('disabled', true);
            }
        });
        $("#partnertype_cstatusData").change(function(){
          var sid = $(this).val();
          if (sid == 1) {
            $('#ntactionnew option[value="10"]').prop('disabled', false);
            } else {
                $('#ntactionnew option[value="10"]').prop('disabled', true);
            }
        });
        $("#samestatuslast15daysData").change(function(){
          var sid = $(this).val();
          if (sid == 1) {
            $('#ntactionnew option[value="10"]').prop('disabled', false);
            } else {
                $('#ntactionnew option[value="10"]').prop('disabled', true);
            }
        });

        $('#selectcompanybyuser').on('change', function() {
                var selectedOptions = $(this).find('option:selected');
                if (selectedOptions.length > 3) {
                    alert('You can select only 3 companies at a Time.');
                    // Deselect the last selected option
                    selectedOptions.last().prop('selected', false);
                }
            });

        

            $("#printPage").click(function() {
        window.print();
    });


    $('#end-time').on('change', function() {
        let endTime = $(this).val();

        if (endTime) {
            // Convert endTime to a Date object
            let endDateTime = new Date('1970-01-01T' + endTime + ':00');

            // Increment by 1 minute for start_tttpft
            // let startDateTime = new Date(endDateTime.getTime() + 1 * 60000);
            let startDateTime = new Date(endDateTime.getTime() + 0 * 60000);
            let startHours = ('0' + startDateTime.getHours()).slice(-2);
            let startMinutes = ('0' + startDateTime.getMinutes()).slice(-2);
            $('#start_tttpft').val(startHours + ':' + startMinutes);

            // Increment by 1 hour for end_tttpft
            let endTttPftDateTime = new Date(endDateTime.getTime() + 1 * 3600000);
            let endTttPftHours = ('0' + endTttPftDateTime.getHours()).slice(-2);
            let endTttPftMinutes = ('0' + endTttPftDateTime.getMinutes()).slice(-2);
            $('#end_tttpft').val(endTttPftHours + ':' + endTttPftMinutes);
        }
    });

    $('#autoplan_submit').click(function(event) {
            var endTime = $('#end_tttpft').val();
            var time = new Date('1970-01-01T' + endTime + 'Z');
            var limitTime = new Date('1970-01-01T19:00:00Z');
            // Compare the times
            if (time > limitTime) {
                event.preventDefault();
                // Show an alert
                alert('The time cannot be later than 7 PM.');
                $('#end_tttpft').css('border', '2px solid red');
                // $('#end-time').val('');
            }else{
              $('#end_tttpft').css('border', '');
            }
        });


        function updateCountdown() {
                var now = new Date();
                var targetTime = new Date();
                
                var phours  = $("#phours").val();
                var pminutes = $("#pminutes").val();
                var pseconds = $("#pseconds").val();

                targetTime.setHours(phours);
                targetTime.setMinutes(pminutes);
                targetTime.setSeconds(pseconds);
                
                var timeDifference = targetTime - now;
                
                if (timeDifference <= 0) {
                    $('#planertime').text('Now Start Your Next Day Planning');
                    $('#yndpt').text('Now Plan Your Next Day Task : ');
                    $('#rtsyndp').hide();
                    clearInterval(countdownInterval);
                    return;
                }
                
                var hours = Math.floor(timeDifference / (1000 * 60 * 60));
                var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);
                
                $('#planertime').text(hours + "h " + minutes + "m " + seconds + "s ");
            }
            
            // Update the countdown every second
            var countdownInterval = setInterval(updateCountdown, 1000);


});
</script>


      <!-- /.row (main row) -->
    </div>
    <!-- /.container-fluid -->
    </section>
    </div></div></div>
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
    <script>
$("#example1").DataTable({
"responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
"buttons": ["excel", "pdf"]
}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

$("#example10").DataTable({
"responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 10,
"buttons": ["excel", "pdf"]
}).buttons().container().appendTo('#example10_wrapper .col-md-6:eq(0)');
$("#example4").DataTable({
"responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 10,
"buttons": ["excel", "pdf"]
}).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');


    </script>
  </body>
</html>