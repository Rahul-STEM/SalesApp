<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> -->
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
.scrollme{overflow-x:auto;h1{font-size:36px;color:#333}p{font-size:24px;color:#666;margin:10px}.container{background-color:#fff;padding:20px;border-radius:10px;box-shadow:0 0 10px rgb(0 0 0 / .2)}}.custom-card{padding:20px;border:1px solid #e0e0e0;border-radius:5px}.custom-card-header{background-color:#007bff;color:#fff;padding:10px 20px;border-radius:5px 5px 0 0}.custom-radio-label{font-weight:700}.card.container-fluid{background-color:honeydew}p#totalcompany{font-size:12px;padding:10px;color:green;font-weight:700;font-family:sans-serif}label{font-size:12px!important}div#maintaskcard{background:antiquewhite}div#selectCategory{background:#fff6dd}div#actionnotplaned{background:#434630;color:#fff}.card.p-4.taskselectionarea,#companyLocationdatacard,#selectCategory{background:#4bb1ac;background-image:linear-gradient(-225deg,#FF057C 0%,#8D0B93 50%,#321575 100%);color:#fff}div#selectCategory{background:#4bb1ac;background-image:linear-gradient(-225deg,#FF057C 0%,#8D0B93 50%,#321575 100%);color:#fff}.modal-footer{justify-content:center!important}div#pstAssignCard,div#taskActionCard,div#partnertype,div#actionPlanned,div#companyLocationdatacard,div#clusterLocactionFiltercard,div#sameStatusLastLimitDays,div#planbutnotinitiatedcard,div#planbutnotinitiatedcardold,div#auto_assign,div#pendingAutotaskCard,div#firstQuarter1,div#reviewTargetDate{background:#4bb1ac;background-image:linear-gradient(-225deg,#FF057C 0%,#8D0B93 50%,#321575 100%);color:#fff}div#maintaskcard{background:#bfbfbf}.card-header.custom-card-header{border-radius:43px;text-align:center;padding:2px}.custom-card{background:#efb2b2}span.alertmessagecmp{font-size:14px;padding:2px;color:red}div#plantimerBox{background:linear-gradient(to right,#a80077,#66ff00);border-radius: 56px;box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;}span#timer{font-size:38px;color:#fff}.stopbtntimer{align-items:center;justify-content:center;display:flex}button#stop{padding: 7px 12px;} table.dataTable>thead>tr>th:not(.sorting_disabled), table.dataTable>thead>tr>td:not(.sorting_disabled) {padding-right: 30px; background: #851241;color: white;}
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
          #plandate{
          width:300px;
          }
          .setpaldate{
          display:flex;
          }
        </style>
        <div class="container">
          <div class="card p-2 bg-primary">
            <div class="row">
              <div class="col-md-8"></div>
              <div class="col-md-4">
                <form class="setpaldate" action="<?=base_url();?>Menu/TaskPlanner/<?=$adate ?>" method="post">
                  <?php $next_date = date('Y-m-d', strtotime('+1 day', strtotime($adate))); ?>
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
                      <button class="btn btn-primary m-3" type="submit" >Submit</button>
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
              <h5><i>If you want to plan task for todays you need to first approvel.</i></h5>
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
              <div class="card p-3 container-fluid">
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
                      
                      $getPendingTask = $this->Menu_model->get_PendingTask($uid);
                      $getoldPendingTask = $this->Menu_model->get_OLDPendingTask($uid);
                      $getpendSize = sizeof($getPendingTask);
                      $getoldPendingTaskcnt = sizeof($getoldPendingTask);
                      
                      ?>

                    <?php if($planbutnotinitedcnt > 0 && $adate !== date("Y-m-d")){ ?>
                      <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Plan But Not Initiated" >
                          <span style="color:red;">Today's Pending Task - Plan But Not Initiated (<?= $getpendSize; ?>)</span>
                        </label>
                        </div>
                        <?php } else{?>
                          <?php if($oldPendTaskcnt > 0){ ?>
                          <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Plan But Not Initiated Old" >
                          <span style="color:red;">Old Pending Task (<?= $getoldPendingTaskcnt; ?>)</span>
                        </label>
                        </div>
                        <?php }else{ ?>
                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Compnay Name" >Company Name
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Status" >Status
                          </label>
                        </div>
                        
                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Task Action" >Task Action
                          </label>
                        </div>
                       
                        <!-- <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Location" >Company Location
                          </label>
                        </div> -->

                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Cluster Location" >Cluster Location
                          </label>
                        </div>

                      

                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Category" >Category
                          </label>
                        </div>

                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Partner Type" >Partner Type
                          </label>
                        </div>
                
                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Same Status Last Limit Days" >Same Status Last Limit Days 
                          </label>
                        </div>
                        
                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="PST Assign" >Other Assign
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Auto Assign" >Auto Assign
                          </label>
                        </div>

                        <!-- <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="FirstQuarter1" > First Quarter
                          </label>
                        </div> -->

                        <div class="form-check">
                          <label class="form-check-label custom-radio-label">
                          <input type="radio" class="form-check-input" name="optradio" value="Review Target Date" > Review Target Date
                          </label>
                        </div>
                        <!-- <div class="form-check">
                        <label>
                        <input type="radio" class="form-check-input" name="optradio" value="actionNotPlanned" > Action Not Planned
                        </label>
                        </div> -->

                       
                        <?php  } }?>
                        <hr>
                        <div class="card-header">
                          <b>Let's Start Creating Task for <span id="tasktype"></span></b> <hr>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                          <b>Create a Special Request For Plan Change </b>
                          </button>

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
                          <lable>Start Time : </lable>
                        <input type="time" id="meetingtimerequest1" name="start_meeting_time" min="10:00" max="19:00" class="form-control" required=""> 
                          <hr>
                          <lable>End Time : </lable>
                        <input type="time" id="meetingtimerequest2" name="end_meeting_time" min="10:00" max="19:00" class="form-control" required=""> 
                          
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
                          <div class="form-group">
                            <input type="radio" id="option2" name="optradio" value="actionNotPlanned">
                            <label>Action Not Planned </label>                          
                          </div>
                        </div>
                      </div>
                      <div id="actionPlanned" class ="card p-2">

                          
                          <div id="selectcompanyname" class="form-group">
                          <lable>Enter Company Name Or CID</lable>  <hr>   
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
                          <hr>
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
                          <?php $action = $this->Menu_model->get_action();
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
                            <?php $action = $this->Menu_model->get_action();
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
                            <?php $action = $this->Menu_model->get_action();
                              foreach($action as $a){
                              ?>
                            <option value="<?=$a->id?>"><?=$a->name?></option>
                            <?php } ?>
                          </select>
                        </div>
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
                              <?php $action = $this->Menu_model->get_action();
                                foreach($action as $a){
                                ?>
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
                          <?php $action = $this->Menu_model->get_action();
                            foreach($action as $a){if($a->id!=4 && $a->id!=6 && $a->id!=8 && $a->id!=9 && $a->id!=11 && $a->id!=12){
                            ?>
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
                                <select class="form-control" id="slct_barg_in_meeting1">
                                  <option disabled value="" >Select Assign</option>
                                  <option value="From Funnel">Self Assign</option>
                                  <option value="Other">Other Assign</option>
                                </select>
                            </div>
                        </div>




                    <div class="card p-4" id="maintaskcard" >
                      <form method="post" action="<?=base_url();?>Menu/addplantask12" id="myForm" >
                        <div class="was-validated">
                          <input type="hidden" id="curuserid" value="<?=$uid?>" name="bdid" required=""> 
                          <input type="hidden" id="pdate" value="<?=$adate?>" name="pdate" required=""> 
                          <input type="text" readonly class="form-control" id="tptime" name="tptime" required=""> 
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
                              <?php $action = $this->Menu_model->get_action();
                                foreach($action as $a){if($a->id!=3 && $a->id!=4 && $a->id!=6 && $a->id!=8 && $a->id!=9 && $a->id!=11 && $a->id!=17){
                                ?>
                              <option value="<?=$a->id;?>"><?=$a->name;?></option>
                              <?php }} ?>
                            </select>
                          </div>

                          <div class="form-group">
                          <?php $clusters = $this->Menu_model->getClusterByUserId($uid); ?>
                            <select id="select_cluster" name="select_cluster" class="form-control">
                              <option value="">Select Cluster</option>
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
                          <button class="btn btn-primary m-3" type="submit" id="planbtn1">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="card col-lg-4 col-sm-4" id="content">
                    <p id="demo" class="bg-primary text-center card p-2 m-2">Time Spent in Task Planning: 00:00:00</p>
                    <center>
                      <b><i>Total Time Spent in Task Planning : <?=$planSessionmin; ?></i></b>
                      <p class="m-auto" id="chart_div"></p>
                      <hr>
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
                                    
                                    // echo "<pre>";
                                    // print_r($ted);
                                    // die;
                                    
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
                          <button class="btn btn-info" id="printButton">Print</button> <br><br>
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


      <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
      <script type='text/javascript'>
        document.getElementById('printButton').addEventListener('click', function() {
        var contentToPrint = document.getElementById('content').outerHTML;
        var printWindow = window.open('', '', 'width=600,height=600');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(contentToPrint);
        printWindow.document.write('</body></html>');
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
        });
        
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

                //  $('.js-example-basic-multiple').select2();
                 $('#status_taskaction_card').hide();
                 $('#auto_assign').hide();
                
                });
        
                $("#mainbox").hide();$("#ScheduledBox").hide();
                // $("#statusid6").hide();
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
                
                if(val=='Compnay Name'){
                   $('#selectcompanyname').show();
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
                       
                    //    alert(selectdcategory);
                    //    alert(statusfiltercardCat);
                    //    alert(taskActionbyusercatcat);
        
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

                        $("#selectcompanybyuser").html('');
                        $("#totalcompany").text('');
                        var uid = $("#curuserid").val();

                        var tasktaction = $(this).val();
                        // var selectedValue1 = $('#status_taskaction').val();
                        $.ajax({
                        url:'<?=base_url();?>Menu/taskactionnotplan_filter',
                        type: "POST",
                        data: {
                        // sid: selectedValue1,
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

                    
            

                    if(val == 'Auto Assign'){
                    
                    $('#auto_assign').show();
                    $(".taskselectionarea").hide();
                    $('#partnertype').hide();
                    $('#maintaskcard').hide();
                    $('#status_taskaction_card').hide();
                    $('#taskaction_card_area').hide();
                    $('#taskActionbyuserCard').hide();
                    $('#taskPurposebyuserCard').hide();
                    var uid = $("#curuserid").val();


                    }else{
                      $('#auto_assign').hide();
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

    </script>
  </body>
</html>