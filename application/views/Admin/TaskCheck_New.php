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
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav_Planner" data-toggle="tab" href="#Planner" role="tab" aria-controls="Planner" aria-selected="true">Planner Rating</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="Planner" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <table id="PlannerTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Company Name</th>
                                                <th>Action</th>
                                                <th>Action And Purpose </th>
                                                <th>Planned Date-time</th>
                                                <th>Initiated Date-time</th>
                                                <th>Update Date-time</th>
                                                <th>Status</th>
                                                <th>Last Task Planned Date</th>
                                                <th>Remark</th>
                                                <th>Next Action Planned</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $i=1; 
                                            foreach($taskList as $task){

                                                if ($task->lastCFID != 0) {
                                                    
                                                    $getLastActionDetails= $this->Menu_model->getActionDetails($task->lastCFID);
                                                    // var_dump($getLastActionDetails);die;
                                                    $lastActionDate = $getNextActionDetails->appointmentdatetime;

                                                }else {
                                                    $lastActionDate = '';
                                                }

                                                if ($task->nextCFID != 0) {
                                                    
                                                    $getNextActionDetails= $this->Menu_model->getActionDetails($task->nextCFID);

                                                    $nextAction = $getNextActionDetails->action_name;

                                                }else {
                                                   $nextAction = '';
                                                }

                                                
                                                ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><a href="#"><?= $task->compname; ?></a></td>
                                                <td><?= $task->action_name; ?></td>
                                                <td>Action Taken - <b><?= $task->actontaken; ?></b>  <br> <hr> Purpose Achieved - <b> <?= $task->purpose_achieved; ?></b> </td>
                                                <td data-question="Was Task Planned on time" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>"><?= $task->plan_date; ?>
                                                    <br><br><hr>
                                                    <p class="question">Was Task Planned on time..??</p>
                                                    <?php 

                                                        $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'Was Task Planned on time',$task->tid);
                                                        // var_dump($chkStarRating);die;
                                                        if(sizeof($chkStarRating) == 0){ ?>

                                                            <div class="rating">
                                                                <input type="radio" name="rat1_<?= $task->user_id; ?>" value="5" id="5_<?= $task->user_id; ?>"><label for="5_<?= $task->user_id; ?>">☆</label>
                                                                <input type="radio" name="rat1_<?= $task->user_id; ?>" value="4" id="4_<?= $task->user_id; ?>"><label for="4_<?= $task->user_id; ?>">☆</label>
                                                                <input type="radio" name="rat1_<?= $task->user_id; ?>" value="3" id="3_<?= $task->user_id; ?>"><label for="3_<?= $task->user_id; ?>">☆</label>
                                                                <input type="radio" name="rat1_<?= $task->user_id; ?>" value="2" id="2_<?= $task->user_id; ?>"><label for="2_<?= $task->user_id; ?>">☆</label>
                                                                <input type="radio" name="rat1_<?= $task->user_id; ?>" value="1" id="1_<?= $task->user_id; ?>"><label for="1_<?= $task->user_id; ?>">☆</label>
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
                                                <td data-question="Was Task Initiated on time" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>"><?= $task->start_time; ?>
                                                    <br><br>
                                                    Time taken from planning to initiate : <b> <?= $task->time_diff1; ?></b>
                                                <br><br><hr>

                                                    <p class="question">Was Task Initiated on time..??</p>

                                                <?php 

                                                    $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'Was Task Initiated on time',$task->tid);
                                                    // var_dump($chkStarRating);die;
                                                    if(sizeof($chkStarRating) == 0){ ?>

                                                        <div class="rating">
                                                            <input type="radio" name="rat2_" value="5" id="10_<?= $task->user_id; ?>"><label for="10_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat2_" value="4" id="9_<?= $task->user_id; ?>"><label for="9_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat2_" value="3" id="8_<?= $task->user_id; ?>"><label for="8_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat2_" value="2" id="7_<?= $task->user_id; ?>"><label for="7_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat2_" value="1" id="6_<?= $task->user_id; ?>"><label for="6_<?= $task->user_id; ?>">☆</label>
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
                                                <td data-question="Was Task Updated on time" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>"><?= $task->end_time; ?>
                                                <br><br>
                                                    Time taken from initiating to update : <b> <?= $task->time_diff; ?></b>
                                                    
                                                    <br><hr>

                                                    <p class="question">Was Task Updated on time..??</p>

                                                    <?php 

                                                    $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'Was Task Updated on time',$task->tid);

                                                    if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat3_<?= $task->user_id; ?>" value="5" id="15_<?= $task->user_id; ?>"><label for="15_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat3_<?= $task->user_id; ?>" value="4" id="14_<?= $task->user_id; ?>"><label for="14_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat3_<?= $task->user_id; ?>" value="3" id="13_<?= $task->user_id; ?>"><label for="13_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat3_<?= $task->user_id; ?>" value="2" id="12_<?= $task->user_id; ?>"><label for="12_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat3_<?= $task->user_id; ?>" value="1" id="11_<?= $task->user_id; ?>"><label for="11_<?= $task->user_id; ?>">☆</label>
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
                                                <td data-question="status change was correct" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>"><?=$task->old_status?> to <?=$task->new_status?>
                                                    <br><hr>

                                                    <p class="question">Status change was correct..??</p>

                                                    <?php 
                                                    $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'status change was correct',$task->tid);

                                                    if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat5_<?= $task->user_id; ?>" value="5" id="25_<?= $task->user_id; ?>"><label for="25_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat5_<?= $task->user_id; ?>" value="4" id="24_<?= $task->user_id; ?>"><label for="24_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat5_<?= $task->user_id; ?>" value="3" id="23_<?= $task->user_id; ?>"><label for="23_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat5_<?= $task->user_id; ?>" value="2" id="22_<?= $task->user_id; ?>"><label for="22_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat5_<?= $task->user_id; ?>" value="1" id="21_<?= $task->user_id; ?>"><label for="21_<?= $task->user_id; ?>">☆</label>
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
                                                <td><?=$lastActionDate;?></td>
                                                <td data-question="correct remark entered" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>"><?= $task->remarks; ?>
                                                    <br><hr>

                                                    <p class="question">Was correct remark entered..??</p>

                                                    <?php 
                                                    $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'status change was correct',$task->tid);
                                                    if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat6_<?= $task->user_id; ?>" value="5" id="30_<?= $task->user_id; ?>"><label for="30_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat6_<?= $task->user_id; ?>" value="4" id="29_<?= $task->user_id; ?>"><label for="29_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat6_<?= $task->user_id; ?>" value="3" id="28_<?= $task->user_id; ?>"><label for="28_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat6_<?= $task->user_id; ?>" value="2" id="27_<?= $task->user_id; ?>"><label for="27_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat6_<?= $task->user_id; ?>" value="1" id="26_<?= $task->user_id; ?>"><label for="26_<?= $task->user_id; ?>">☆</label>
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
                                                <td data-question="correct action created" data-userid="<?= $task->user_id; ?>" data-taskid="<?= $task->tid; ?>"><?=$nextAction;?>

                                                    <br><hr>
                                                    <p class="question">Is correct action created..??</p>

                                                    <?php 
                                                    $chkStarRating = $this->Menu_model->CheckTaskStarRatingsExistorNot_New($task->user_id,'correct action created',$task->tid);
                                                    if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat7_<?= $task->user_id; ?>" value="5" id="35_<?= $task->user_id; ?>"><label for="35_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat7_<?= $task->user_id; ?>" value="4" id="34_<?= $task->user_id; ?>"><label for="34_<?= $task->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat7_<?= $task->user_id; ?>" value="3" id="33_<?= $task->user_id; ?>"><label for="33_<?= $task->user_id; ?>">☆</label>
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
                                            </tr>
                                        <?php $i++; } ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="Status" role="tabpanel" aria-labelledby="nav-home-tab"></div>
                                <div class="tab-pane fade" id="Action" role="tabpanel" aria-labelledby="nav-home-tab"></div>
                            </div>
                            
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
</script>

<script>
        $(document).ready(function() {

            $("#TodayMorningTable").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": true,
                "buttons": ["csv", "excel", "pdf", "print"]
            });

            $("#YesterdayTaskTable").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": true,
                "buttons": ["csv", "excel", "pdf", "print"]
            });
        });

</script>
<script>
    $(document).ready(function(){

        $(".rating input").on("change", function(){

            var $td = $(this).closest('td');

            $(this).parent().hide();

            var ratingId = $(this).attr('id');
            var ratingValue = $(this).val();
            var question = $td.data('question');
            var userId = $td.data('userid');
            var taskId = $td.data('taskid');

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
</body>
</html>