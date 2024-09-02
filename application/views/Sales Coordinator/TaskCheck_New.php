<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Task Check | STEM Operation | WebAPP</title>

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
</head>
<style>


.circle-image img{

	border: 6px solid #fff;
    border-radius: 100%;
    padding: 0px;
    top: -28px;
    position: relative;
    width: 70px;
    height: 70px;
    border-radius: 100%;
    z-index: 1;
    background: #e7d184;
    cursor: pointer;

}

.dot {
      height: 18px;
    width: 18px;
    background-color: blue;
    border-radius: 50%;
    display: inline-block;
    position: relative;
    border: 3px solid #fff;
    top: -48px;
    left: 186px;
    z-index: 1000;
}

.name{
	margin-top: -21px;
	font-size: 18px;
}


.fw-500{
	font-weight: 500 !important;
}


.start{

	color: green;
}

.stop{
	color: red;
}

.success-message {
    /* color: green; */
    display: none;
    /* margin-top: 10px; */
}
#tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: black;
        background-color: #ffc107;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bolder;
    }
    .nav-tabs .nav-link{
        background-color: lightgray;
        color: black;
        font-weight: 600;
    }
    .nav-tabs .nav-link:hover{
        background-color: #3498db;
        color: black;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bolder;
    }
    .question{
        color: black;
        font-weight: 600;
    }
    .star-rating {
            color: #f39c12;
            font-size:20px;
    }
    .rate{border-bottom-right-radius: 12px;border-bottom-left-radius: 12px;}.rating {display: flex;flex-direction: row-reverse;justify-content: left }.rating>input {display: none }.rating>label {position: relative;width: 1em;font-size: 30px;font-weight: 300;color: #f39c12;cursor: pointer }.rating>label::before {content: "\2605";position: absolute;opacity: 0 }.rating>label:hover:before, .rating>label:hover~label:before {opacity: 1 !important }.rating>input:checked~label:before {opacity: 1 }.rating:hover>input:checked~label:before {opacity: 0.4 }
    /* Star Rating CSS */
.star-rating {
    display: flex;
    direction: row-reverse;
    font-size: 1.5em;
    justify-content: center;
}

.star-rating input {
    display: none;
}

.star-rating label {
    color: #ddd;
    cursor: pointer;
    margin: 0;
}

.star-rating input:checked ~ label {
    color: #f5b301;
}

.star-rating label:before {
    content: '★';
    display: inline-block;
}

.star-rating input:checked ~ label:before {
    content: '★';
}

.star-rating input:checked ~ label ~ label:before {
    content: '☆';
}

</style>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  

  <!-- Navbar -->
  <?php require('nav.php');
  
  ?>
  <!-- /.navbar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <h4></h4>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<!-- Main content -->
 <?php // var_dump($selectedUser);die; ?>
    <section class="content">
      <div class="container-fluid">
      <div class="alert alert-success" id="success-message" style="display: none;">Thank you for your rating!</div>
       <div class="row p-3">
           <div class="col-sm col-md-12 col-lg-12 m-auto">
              	<div class="card card-success card-outline">
					<div class="card-body box-profile">
                        <h3 class="text-center">Task Check</h3>
                        <hr>
                        <form action="<?=base_url();?>Menu/TaskCheck_New" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control" name="userId">
                                        <option selected disabled>--Select--</option>
                                        <?php 

                                            foreach($userList as $user){?>

                                        <option value="<?=$user->user_id?>" <?php if ($user->user_id == $selectedUser) echo ' selected="selected"';?>><?=$user->name?></option>

                                        <?php } ?>
                                    </select>    
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div> 
                        </form>
                        <br>

                        <div class="table-responsive" id="tbdata">
                            <table id="PlannerTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>Company Name</th>
                                        <th>Filter Used</th>
                                        <th>Action</th>
                                        <th>Action And Purpose </th>
                                        <th>Planned Date-time</th>
                                        <th>Initiated Date-time</th>
                                        <th>Update Date-time</th>
                                        <th>Status</th>
                                        <th>Same Status Since</th>
                                        <th>No of Task Since Status Change</th>
                                        <th>Remark</th>
                                        <th>Next Action Planned</th>
                                        <!-- <th>MoM Details</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $i=1; 
                                    foreach($taskList as $task){

                                        $getLastActionDetails = getLastActionDetails($task->tid,$task->user_id,$cdate);

                                        $getSameStatusSince = getSameStatusSince($task->tid,$cdate);
                                        if (!empty($getSameStatusSince)) {

                                            $SameStatusSince_1 = $getSameStatusSince->days_difference;
                                            $NoOfTaskSinceStatusChange = $getSameStatusSince->Taskcount;
                                        }else{

                                            $SameStatusSince_1 = '0';
                                            $NoOfTaskSinceStatusChange = '0';
                                        }

                                        if ($task->nextCFID != 0) {
                                            
                                            $getNextActionDetails= $this->Menu_model->getActionDetails($task->nextCFID);
                                            $nextAction = $getNextActionDetails->action_name;
                                            
                                            if ($getNextActionDetails->autotask == 1) {
                                                
                                                $TaskType = ' - It is autotask';

                                            }else{
                                                $TaskType = 'This is not autotask ';
                                            }

                                        }else {
                                            $nextAction = '';
                                        }

                                        if($task->autotask == 1){
                                            $OGTaskType = ' - It is autotask';
                                        }else{
                                            $OGTaskType = ''; 
                                        }
                                        $filterUsed = ($task->filter_by);
                                        $filterUsed = json_decode($filterUsed, true);
                                        // var_dump($filterUsed);die;
                                        $SinglefilterUsedFinal = '';
                                        if (is_array($filterUsed)) {

                                            foreach ($filterUsed as $key => $SinglefilterUsed) {

                                                if ($key === 'Plan_BY') {

                                                    $SinglefilterUsedFinal = 'Plan By - '.$SinglefilterUsed;

                                                }elseif ($key === 'comp_status' ) {

                                                    $SinglefilterUsedFinal = get_CompanyStatus($task->company_id,$SinglefilterUsed);

                                                    $SinglefilterUsedFinal = 'Company Status - '.$SinglefilterUsedFinal->name;
                                                }
                                                // if 
    
                                            }
                                        }                                        
                                ?>
                                    <tr>
                                        <!-- <td><?= $i; ?></td> -->
                                        <td><?= $task->compname; ?></td>
                                        <td><?= $SinglefilterUsedFinal; ?>
                                            <br><hr>
                                            <p class="question">Was Correct filters used..??</p>

                                            <?php 

                                                $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'Was Correct filters used',$task->tid);
                                                // var_dump($chkStarRating);die;
                                                if(sizeof($chkStarRating) == 0){ ?>

                                                    <div class="rating" data-question="Was Correct filters used" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>" >
                                                        <input type="radio" name="rat8_<?= $task->user_id; ?>" value="5" id="40_<?= $task->tid; ?>"><label for="40_<?= $task->tid; ?>">☆</label>
                                                        <input type="radio" name="rat8_<?= $task->user_id; ?>" value="4" id="39_<?= $task->tid; ?>"><label for="39_<?= $task->tid; ?>">☆</label>
                                                        <input type="radio" name="rat8_<?= $task->user_id; ?>" value="3" id="38_<?= $task->tid; ?>"><label for="38_<?= $task->tid; ?>">☆</label>
                                                        <input type="radio" name="rat8_<?= $task->user_id; ?>" value="2" id="37_<?= $task->tid; ?>"><label for="37_<?= $task->tid; ?>">☆</label>
                                                        <input type="radio" name="rat8_<?= $task->user_id; ?>" value="1" id="36_<?= $task->tid; ?>"><label for="36_<?= $task->tid; ?>">☆</label>
                                                    </div>

                                            <?php }else{
                                                foreach($chkStarRating as $star){
                                                    // var_dump($chkStarRating);die;
                                                    $starRating = $star->star;
                                                    $starRemark = $star->remarks;
                                                    
                                                }
                                                echo "<hr>";
                                                echo "<span class='text-dark font-weight-normal'><b>Total Star Given</b> :</span>";
                                                echo "<div class='star-rating'>";
                                                $totalStars = 5;
                                                for ($i = 0; $i < $starRating; $i++) {
                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                }
                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                }
                                                echo "</div><br><span class='text-dark font-weight-normal'><b>Remark</b> :".$starRemark."</span>";
                                            }  ?>
                                        </td>
                                        <td><?= $task->action_name; ?>
                                            <!-- <br> -->
                                            <b><?= $OGTaskType; ?></b> <hr>

                                            <?php
                                            
                                                if ($task->actiontype_id == 6 ) { ?>
                                                    
                                                    <button type="button" class="btn btn-primary" onclick="OpenModal(<?=$task->tid?>)">View MoM Details</button>
                                                
                                        <?php   }  ?>
                                        </td>
                                        <td >
                                            Action Taken - <b><?= $task->actontaken; ?></b>  <br> <hr> Purpose Achieved - <b> <?= $task->purpose_achieved; ?></b> 
                                            
                                            <br><hr>
                                            <p class="question">Was purpose achieved for the task..??</p>

                                            <?php 

                                                $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'Was purpose achieved for the task',$task->tid);
                                                // var_dump($chkStarRating);die;
                                                if(sizeof($chkStarRating) == 0){ ?>

                                                    <div class="rating" data-question="Was purpose achieved for the task" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>">
                                                        <input type="radio" name="rat9_<?= $task->user_id; ?>" value="5" id="45_<?= $task->tid;?>"><label for="45_<?= $task->tid; ?>">☆</label>
                                                        <input type="radio" name="rat9_<?= $task->user_id; ?>" value="4" id="44_<?= $task->tid;?>"><label for="44_<?= $task->tid; ?>">☆</label>
                                                        <input type="radio" name="rat9_<?= $task->user_id; ?>" value="3" id="43_<?= $task->tid;?>"><label for="43_<?= $task->tid;?>">☆</label>
                                                        <input type="radio" name="rat9_<?= $task->user_id; ?>" value="2" id="42_<?= $task->tid;?>"><label for="42_<?= $task->tid; ?>">☆</label>
                                                        <input type="radio" name="rat9_<?= $task->user_id; ?>" value="1" id="41_<?= $task->tid;?>"><label for="41_<?= $task->tid;?>">☆</label>
                                                    </div>

                                            <?php }else{
                                                foreach($chkStarRating as $star){
                                                    // var_dump($chkStarRating);die;
                                                    $starRating = $star->star;
                                                    $starRemark = $star->remarks;
                                                    
                                                }
                                                echo "<hr>";
                                                echo "<span class='text-dark font-weight-normal'><b>Total Star Given</b> :</span>";
                                                echo "<div class='star-rating'>";
                                                $totalStars = 5;
                                                for ($i = 0; $i < $starRating; $i++) {
                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                }
                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                }
                                                echo "</div><br><span class='text-dark font-weight-normal'><b>Remark</b> :".$starRemark."</span>";
                                            }  ?>
                                        
                                        </td>
                                        <td ><?= $task->plan_date; ?>
                                            <br><br><hr>
                                            <p class="question">Was Task Planned on time..??</p>
                                            <?php 

                                                $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'Was Task Planned on time',$task->tid);
                                                // var_dump($chkStarRating);die;
                                                if(sizeof($chkStarRating) == 0){ ?>

                                                    <div class="rating" data-question="Was Task Planned on time" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>">
                                                        <input type="radio" name="rat1_<?= $task->user_id; ?>" value="5" id="5_<?= $task->tid; ?>"><label for="5_<?= $task->tid; ?>">☆</label>
                                                        <input type="radio" name="rat1_<?= $task->user_id; ?>" value="4" id="4_<?= $task->tid; ?>"><label for="4_<?= $task->tid; ?>">☆</label>
                                                        <input type="radio" name="rat1_<?= $task->user_id; ?>" value="3" id="3_<?= $task->tid; ?>"><label for="3_<?= $task->tid;?>">☆</label>
                                                        <input type="radio" name="rat1_<?= $task->user_id; ?>" value="2" id="2_<?= $task->tid; ?>"><label for="2_<?= $task->tid; ?>">☆</label>
                                                        <input type="radio" name="rat1_<?= $task->user_id; ?>" value="1" id="1_<?= $task->tid; ?>"><label for="1_<?= $task->tid; ?>">☆</label>
                                                    </div>

                                            <?php }else{
                                                foreach($chkStarRating as $star){
                                                    // var_dump($chkStarRating);die;
                                                    $starRating = $star->star;
                                                    $starRemark = $star->remarks;
                                                    
                                                }
                                                echo "<hr>";
                                                echo "<span class='text-dark font-weight-normal'><b>Total Star Given</b> :</span>";
                                                echo "<div class='star-rating'>";
                                                $totalStars = 5;
                                                for ($i = 0; $i < $starRating; $i++) {
                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                }
                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                }
                                                echo "</div><br><span class='text-dark font-weight-normal'><b>Remark</b> :".$starRemark."</span>";
                                            }  ?>
                                            
                                            <?php ?>
                                        </td>
                                        <td ><?= $task->start_time; ?>
                                            <br><br>
                                            Time taken from planning to initiate : <b> <?= $task->time_diff_updateVsInitiat; ?></b>
                                        <br><br><hr>
                                            <p class="question">Was Task Initiated on time..??</p>
                                        <?php 
                                            $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'Was Task Initiated on time',$task->tid);
                                            // var_dump($chkStarRating);die;
                                            if(sizeof($chkStarRating) == 0){ ?>

                                                <div class="rating" data-question="Was Task Initiated on time" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>">
                                                    <input type="radio" name="rat2_" value="5" id="10_<?=$task->tid; ?>"><label for="10_<?= $task->tid; ?>">☆</label>
                                                    <input type="radio" name="rat2_" value="4" id="9_<?= $task->tid; ?>"><label for="9_<?= $task->tid; ?>">☆</label>
                                                    <input type="radio" name="rat2_" value="3" id="8_<?= $task->tid; ?>"><label for="8_<?= $task->tid; ?>">☆</label>
                                                    <input type="radio" name="rat2_" value="2" id="7_<?= $task->tid;?>"><label for="7_<?= $task->tid; ?>">☆</label>
                                                    <input type="radio" name="rat2_" value="1" id="6_<?= $task->tid; ?>"><label for="6_<?= $task->tid;?>">☆</label>
                                                </div>

                                        <?php }else{
                                            foreach($chkStarRating as $star){
                                                // var_dump($chkStarRating);die;
                                                $starRating = $star->star;
                                                $starRemark = $star->remarks;
                                                
                                            }
                                            echo "<hr>";
                                            echo "<span class='text-dark font-weight-normal'><b>Total Star Given</b> :</span>";
                                            echo "<div class='star-rating'>";
                                            $totalStars = 5;
                                            for ($i = 0; $i < $starRating; $i++) {
                                                echo "<i class='fas fa-star'></i>"; // filled star
                                            }
                                            for ($i = $starRating; $i < $totalStars; $i++) {
                                                echo "<i class='far fa-star'></i>"; // empty star
                                            }
                                            echo "</div><br><span class='text-dark font-weight-normal'><b>Remark</b> :".$starRemark."</span>";
                                        }  ?>
                                        </td>
                                        <td ><?= $task->end_time; ?>
                                        <br><br>
                                            Time taken from initiating to update : <b> <?= $task->time_diff_InitiatVsClose; ?></b>
                                            
                                            <br><hr>

                                            <p class="question">Was Task Updated on time..??</p>

                                            <?php 

                                            $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'Was Task Updated on time',$task->tid);

                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                <div class="rating" data-question="Was Task Updated on time" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>">
                                                    <input type="radio" name="rat3_<?= $task->user_id; ?>" value="5" id="15_<?=$task->tid; ?>"><label for="15_<?=  $task->tid; ?>">☆</label>
                                                    <input type="radio" name="rat3_<?= $task->user_id; ?>" value="4" id="14_<?=$task->tid; ?>"><label for="14_<?=  $task->tid; ?>">☆</label>
                                                    <input type="radio" name="rat3_<?= $task->user_id; ?>" value="3" id="13_<?=$task->tid; ?>"><label for="13_<?=  $task->tid; ?>">☆</label>
                                                    <input type="radio" name="rat3_<?= $task->user_id; ?>" value="2" id="12_<?=$task->tid; ?>"><label for="12_<?=  $task->tid; ?>">☆</label>
                                                    <input type="radio" name="rat3_<?= $task->user_id; ?>" value="1" id="11_<?=$task->tid; ?>"><label for="11_<?=  $task->tid; ?>">☆</label>
                                                </div> 
                                            <?php }else{

                                                foreach($chkStarRating as $star){
                                                    // var_dump($chkStarRating);die;
                                                    $starRating = $star->star;
                                                    $starRemark = $star->remarks;
                                                    
                                                }
                                                echo "<hr>";
                                                echo "<span class='text-dark font-weight-normal'><b>Total Star Given</b> :</span>";
                                                echo "<div class='star-rating'>";
                                                $totalStars = 5;
                                                for ($i = 0; $i < $starRating; $i++) {
                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                }
                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                }
                                                echo "</div><br><span class='text-dark font-weight-normal'><b>Remark</b> :".$starRemark."</span>";
                                            }  ?>

                                        </td>
                                        <td ><?=$task->old_status?> to <?=$task->new_status?>
                                            <br><hr>

                                            <p class="question">Status change was correct..??</p>

                                            <?php 
                                            $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'status change was correct',$task->tid);

                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                <div class="rating" data-question="status change was correct" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>">
                                                    <input type="radio" name="rat5_<?= $task->user_id; ?>" value="5" id="25_<?= $task->tid; ?>"><label for="25_<?= $task->tid;  ?>">☆</label>
                                                    <input type="radio" name="rat5_<?= $task->user_id; ?>" value="4" id="24_<?= $task->tid; ?>"><label for="24_<?= $task->tid;  ?>">☆</label>
                                                    <input type="radio" name="rat5_<?= $task->user_id; ?>" value="3" id="23_<?= $task->tid; ?>"><label for="23_<?= $task->tid;  ?>">☆</label>
                                                    <input type="radio" name="rat5_<?= $task->user_id; ?>" value="2" id="22_<?= $task->tid;  ?>"><label for="22_<?= $task->tid; ?>">☆</label>
                                                    <input type="radio" name="rat5_<?= $task->user_id; ?>" value="1" id="21_<?= $task->tid; ?>"><label for="21_<?=$task->tid; ?>">☆</label>
                                                </div>
                                                <?php }else{
                                                        foreach($chkStarRating as $star){
                                                            // var_dump($chkStarRating);die;
                                                            $starRating = $star->star;
                                                            $starRemark = $star->remarks;
                                                            
                                                        }
                                                        echo "<hr>";
                                                        echo "<span class='text-dark font-weight-normal'><b>Total Star Given</b> :</span>";
                                                        echo "<div class='star-rating'>";
                                                        $totalStars = 5;
                                                        for ($i = 0; $i < $starRating; $i++) {
                                                            echo "<i class='fas fa-star'></i>"; // filled star
                                                        }
                                                        for ($i = $starRating; $i < $totalStars; $i++) {
                                                            echo "<i class='far fa-star'></i>"; // empty star
                                                        }
                                                        echo "</div><br><span class='text-dark font-weight-normal'><b>Remark</b> :".$starRemark."</span>";
                                                    }  ?>
                                        </td>
                                        <td><?=$SameStatusSince_1 .' Days';?></td>
                                        <td><?=$NoOfTaskSinceStatusChange ;?></td>
                                        <td ><?= $task->remarks; ?>
                                            <br><hr>

                                            <p class="question">Was correct remark entered..??</p>

                                            <?php 
                                            $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'status change was correct',$task->tid);
                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                <div class="rating" data-question="correct remark entered" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>">
                                                    <input type="radio" name="rat6_<?= $task->user_id; ?>" value="5" id="30_<?= $task->tid; ?>"><label for="30_<?= $task->tid;  ?>">☆</label>
                                                    <input type="radio" name="rat6_<?= $task->user_id; ?>" value="4" id="29_<?= $task->tid;  ?>"><label for="29_<?= $task->tid;  ?>">☆</label>
                                                    <input type="radio" name="rat6_<?= $task->user_id; ?>" value="3" id="28_<?= $task->tid;  ?>"><label for="28_<?= $task->tid;  ?>">☆</label>
                                                    <input type="radio" name="rat6_<?= $task->user_id; ?>" value="2" id="27_<?= $task->tid;  ?>"><label for="27_<?= $task->tid;  ?>">☆</label>
                                                    <input type="radio" name="rat6_<?= $task->user_id; ?>" value="1" id="26_<?= $task->tid;  ?>"><label for="26_<?= $task->tid; ?>">☆</label>
                                                </div>
                                                <?php }else{
                                                        foreach($chkStarRating as $star){
                                                            // var_dump($chkStarRating);die;
                                                            $starRating = $star->star;
                                                            $starRemark = $star->remarks;
                                                            
                                                        }
                                                        echo "<hr>";
                                                        echo "<span class='text-dark font-weight-normal'><b>Total Star Given</b> :</span>";
                                                        echo "<div class='star-rating'>";
                                                        $totalStars = 5;
                                                        for ($i = 0; $i < $starRating; $i++) {
                                                            echo "<i class='fas fa-star'></i>"; // filled star
                                                        }
                                                        for ($i = $starRating; $i < $totalStars; $i++) {
                                                            echo "<i class='far fa-star'></i>"; // empty star
                                                        }
                                                        echo "</div><br><span class='text-dark font-weight-normal'><b>Remark</b> :".$starRemark."</span>";
                                                    }  ?>
                                        </td>
                                        <td>
                                            <?=$nextAction;?> <b><?=$TaskType;?></b>

                                            <br><hr>
                                            <p class="question">Is correct action created..??</p>

                                            <?php 
                                            $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'correct action created',$task->tid);
                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                <div class="rating" data-question="correct action created" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>">
                                                    <input type="radio" name="rat7_<?= $task->user_id; ?>" value="5" id="35_<?= $task->tid; ?>"><label for="35_<?= $task->user_id; ?>">☆</label>
                                                    <input type="radio" name="rat7_<?= $task->user_id; ?>" value="4" id="34_<?= $task->tid; ?>"><label for="34_<?= $task->user_id; ?>">☆</label>
                                                    <input type="radio" name="rat7_<?= $task->user_id; ?>" value="3" id="33_<?= $task->tid; ?>"><label for="33_<?= $task->user_id; ?>">☆</label>
                                                    <input type="radio" name="rat7_<?= $task->user_id; ?>" value="2" id="32_<?= $task->user_id; ?>"><label for="32_<?= $task->user_id; ?>">☆</label>
                                                    <input type="radio" name="rat7_<?= $task->user_id; ?>" value="1" id="31_<?= $task->user_id; ?>"><label for="31_<?= $task->user_id; ?>">☆</label>
                                                </div>
                                                <?php }else{
                                                        foreach($chkStarRating as $star){
                                                            // var_dump($chkStarRating);die;
                                                            $starRating = $star->star;
                                                            $starRemark = $star->remarks;
                                                            
                                                        }
                                                        echo "<hr>";
                                                        echo "<span class='text-dark font-weight-normal'><b>Total Star Given</b> :</span>";
                                                        echo "<div class='star-rating'>";
                                                        $totalStars = 5;
                                                        for ($i = 0; $i < $starRating; $i++) {
                                                            echo "<i class='fas fa-star'></i>"; // filled star
                                                        }
                                                        for ($i = $starRating; $i < $totalStars; $i++) {
                                                            echo "<i class='far fa-star'></i>"; // empty star
                                                        }
                                                        echo "</div><br><span class='text-dark font-weight-normal'><b>Remark</b> :".$starRemark."</span>";
                                                    }  ?>
                                        </td>
                                        <!-- <td></td> -->
                                    </tr>
                                <?php $i++; } ?>
                                    
                                </tbody>
                            </table>
                        </div>
						
					</div>
                </div>
                  
            </div>
          </div>
      </div>   
     </div>     
    </section>


        <div class="modal fade" id="ReviewModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h5 class="modal-title">Modal title</h5> -->
                    </div>
                    <div class="modal-body">
                    <form >
                        <input type="hidden" name="starID" id="starID">
                        <textarea class="form-control" name="remark" id="remark" placeholder="Remark" required="true"></textarea>
                    </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitReview()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="MoMModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">MoM Details</h5>
                    </div>
                    <div class="modal-body">
                    <form>
                        <hr>
                        <input type="hidden" name="taskID" id="taskID" value="">
                        
                        <p><strong>Start Time:</strong> <span id="modalStartTime"></span></p>

                        <p><b> Did the meeting started on right time..??</b></p>
                        <hr>
                        <strong>Start Location:</strong> 
                        <div class="img-thumbnail" style="height: 150px">
                            <iframe id="startMap" width="150px"  height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                        <p><b>Was meeting start location correct..??</b> </p>  
                        <hr>
                        <!-- <br> -->
                        <p>
                            <strong>End Time:</strong> 
                            <span id="modalEndTime"></span>

                        </p>
                        <p><b>Was meeting start location correct..??</b> </p>  
                        <hr>
                        <strong>End Location:</strong> 
                        <div class="img-thumbnail" style="height: 150px">
                            <iframe id="endMap"  width="150px"  height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>

                        <p><b>Was meeting end location correct..??</b> </p>  
                        <hr>

                        <p>
                            <strong>Photo:</strong> 
                            <img id="modalPhoto" src="" alt="Photo" class="img-fluid">
                        </p>

                        <p><b>Was company photo is right..??</b> </p>
                        <hr>
                        <p><strong>Type:</strong> <span id="modalMomType"></span></p>
                        
                        <p><b>..??</b> </p>
                        <hr>
                        <p><strong>Partner Type:</strong> <span id="modalPartnerType"></span></p>
                        
                        <p><b>Was partner type correct..??</b> </p>
                        <hr>
                        <p><strong>BD Potential:</strong> <span id=""></span></p>
                        
                        <p><b>BD potential marked correctly..??</b> </p>
                        <!-- <hr> -->
                        <p><strong>Rating:</strong></p>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label for="star5" title="5 stars"></label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="4 stars"></label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="3 stars"></label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="2 stars"></label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="1 star"></label>
                            </div>
                            <!-- <hr> -->
                    </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitReview()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type='text/javascript'>

$('[id^="giveRating"]').on('click', function() {
    $('#RatingModal').modal('show');
    var tid = this.value;
    document.getElementById("taskid").value = tid;
    
});
</script>

          
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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
    <!-- <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script> -->
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
    <!-- <script src="<?=base_url();?>assets/js/adminlte.js"></script> -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="<?=base_url();?>assets/js/dashboard.js"></script> -->

<!-- 
<script>
    $(document).ready(function() {
    // Activate the saved tab
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('#nav-tab a[href="' + activeTab + '"]').tab('show');
        }

        // Save the active tab on click
        $('#nav-tab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var activeTab = $(e.target).attr('href');
            localStorage.setItem('activeTab', activeTab);
        });
    });
</script> -->

<script>
    $("#PlannerTable").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
<script>
    $(document).ready(function(){

        $(".rating input").on("click", function() {

            var $rating = $(this);
            var inputId = $rating.attr('id');

            // Extract the number after the underscore in the ID (e.g., "100087" from "7_100087")
            var extractedId = inputId.split('_')[1];

            // Get other data attributes
            var taskId = $rating.closest('.rating').data('taskid');
            var userId = $rating.closest('.rating').data('userid');
            var question = $rating.closest('.rating').data('question');
            var ratingValue = $rating.val();

            // Display the extracted ID (100087 in this case)
            // console.log("Extracted ID: " + extractedId);
            // alert("Task ID: " + taskId + "\nUser ID: " + userId + "\nExtracted ID: " + extractedId + "\nRating Value: " + ratingValue);
            
            // Prevent the default action
            // return false;

            $.ajax({
            url: '<?=base_url();?>Menu/TaskCheckStarNew',
            type: 'POST',
            data: {
                rating: ratingValue,
                question: question,
                userId: userId,
                taskId: taskId
                // cdate:cdate
                },
                success: function(response) {
                    console.log('Response:', response); 

                    if (ratingValue <= 2) {

                        $('#starID').val(response);
                        $('#ReviewModal').modal('show');

                    }else{

                        $('#success-message').show();
    
                        $('html, body').animate({
                            scrollTop: $('#success-message').offset().top
                        }, 1000);
    
                        setTimeout(function() {

                            $('#success-message').fadeOut('slow', function() {
                                location.reload();
                            });
                        }, 3000);
                    }
                },
                error: function() {
                    alert("There was an error submitting the rating.");
                }
            });
        });
    });
</script>
<script>
    function OpenModal(id){

        document.getElementById('taskID').value = id;

        $.ajax({
            url: '<?=base_url();?>Menu/getMoMData',
            type: 'POST',
            data: {
                taskID: id,
                },
                success: function(response) {

                    // console.log('Response:', response); 
                    var data = JSON.parse(response);

        // Update modal content
                    document.getElementById('modalPhoto').src = data.cphoto; // Set image source
                    document.getElementById('modalStartTime').textContent = data.start_time;
                    document.getElementById('modalEndTime').textContent = data.end_time;
                    document.getElementById('modalMomType').textContent = data.momType || 'N/A';
                    document.getElementById('modalEndTime').textContent = data.end_time;
                    document.getElementById('modalPartnerType').textContent = data.mompartner;
                    

                    var startLat = data.start_lat;
                    var startLong = data.start_long;
                    var endLat = data.end_lat;
                    var endLong = data.end_long;

                    document.getElementById('startMap').src = `https://maps.google.com/?q=${startLat},${startLong}&t=k&z=13&ie=UTF8&iwloc=&output=embed`;
                    

                    // Update the end location map and link

                    document.getElementById('endMap').src = `https://maps.google.com/?q=${endLat},${endLong}&t=k&z=13&ie=UTF8&iwloc=&output=embed`;

                    $('#MoMModal').modal('show');
                },
                error: function() {
                    alert("There was an error submitting the rating.");
                }
            });

    }
</script>
<script>
    function submitReview(){

        var remark = document.getElementById("remark").value;
        var starID = document.getElementById("starID").value;

        $.ajax({
            url: '<?=base_url();?>Menu/updateTaskCheckRemark',
            type: 'POST',
            data: {

                remark: remark,
                starID: starID,
                
                },
                success: function(response) {
                    $('#ReviewModal').modal('hide');

                    $('#success-message').show();

                    $('html, body').animate({
                        scrollTop: $('#success-message').offset().top
                    }, 1000);

                    setTimeout(function() {
                        $('#success-message').fadeOut('slow');
                    }, 3000);

                        location.reload();
                },
                error: function() {
                    alert("There was an error submitting the rating.");
                }
            });

    }
</script>
<script>
$(document).ready(function() {
    // Handle star click
    $('.star').on('click', function() {
        var value = $(this).data('value');
        var container = $(this).closest('.star-rating');

        container.find('.star').removeClass('rated');
        container.find('.star').each(function() {
            if ($(this).data('value') <= value) {
                $(this).addClass('rated');
            }
        });

        // Set the value of the hidden input
        var hiddenInput = container.siblings('input[type="hidden"]');
        hiddenInput.val(value);
    });

    // Optional: Add hover effect
    $('.star').on('mouseover', function() {
        var value = $(this).data('value');
        var container = $(this).closest('.star-rating');

        container.find('.star').each(function() {
            if ($(this).data('value') <= value) {
                $(this).addClass('rated');
            } else {
                $(this).removeClass('rated');
            }
        });
    }).on('mouseout', function() {
        $(this).closest('.star-rating').find('.star').removeClass('rated');
    });

    // Function to handle form submission
    window.submitReview = function() {
        $.ajax({
            url: 'path/to/your_controller/save', // Update with your controller method URL
            type: 'POST',
            data: $('#ratingForm').serialize(), // Serialize form data
            success: function(response) {
                // Handle success response
                alert('Rating submitted successfully!');
                $('#MoMModal').modal('hide'); // Hide the modal
            },
            error: function(xhr, status, error) {
                // Handle error response
                alert('An error occurred while submitting the rating.');
            }
        });
    };
});
</script>

</body>
</html>