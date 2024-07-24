<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Day Management System | STEM APP | WebAPP</title>
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
     .scrollme {overflow-x: auto;}.card.bg-graywe {background: #175456;height: 100px;align-items: center;justify-content: center;display: flex;}.card.bg-graywe {transition: background 0.3s ease-in-out;}.card.bg-graywe:hover {background: #172556;}.card-body {min-height:650px;background: #e0f0f1;}.card a {color: white;}.uimage {background: #47758b;margin: 4px;padding: 4px;box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;}.dot {height: 18px;width: 18px;background-color: blue;border-radius: 50%;display: inline-block;position: relative;border: 3px solid #fff;top: -48px;left: 186px;z-index: 1000;}.name{margin-top: -21px;font-size: 18px;}.fw-500{font-weight: 500 !important;}.start{color: green;}.stop{color: red;}.rate{border-bottom-right-radius: 12px;border-bottom-left-radius: 12px;}.rating {display: flex;flex-direction: row-reverse;justify-content: left }.rating>input {display: none }.rating>label {position: relative;width: 1em;font-size: 30px;font-weight: 300;color: #f39c12;cursor: pointer }.rating>label::before {content: "\2605";position: absolute;opacity: 0 }.rating>label:hover:before, .rating>label:hover~label:before {opacity: 1 !important }.rating>input:checked~label:before {opacity: 1 }.rating:hover>input:checked~label:before {opacity: 0.4 }.buttons{top: 36px;position: relative;}.rating-submit{border-radius: 15px;color: #fff;height: 49px;}.rating-submit:hover{color: #fff;}div#exampleModalCenter {background: rgba(0, 0, 0, 0.9);}.modal-content {background: azure;}.modal-content {border: none;}.modal-open .modal { background: rgba(0, 0, 0, .2)!important;}
    #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        /* color: #0062cc; */
        background-color: #ffc107;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bolder;
    }
    .nav-tabs .nav-link{
        background-color: white;
        color: black;
        font-weight: 600;
    }
    .question{
        color: black;
        font-weight: 600;
    }
    .star-rating {
            color: #f39c12;
            font-size:20px;
    }
    .success-message {
            /* color: green; */
            display: none;
            /* margin-top: 10px; */
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
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0"></h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <h4></h4>
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
        <?php
        $bd = $this->Menu_model->get_alluserbyaid($uid);
        // dd($bd);
        //for testing
        $previousDate = '2024-07-19';
        $cdate = '2024-07-20';
         ?>
        <section class="content">
          <div class="container-fluid">
          <div class="alert alert-success" id="success-message" style="display: none;">Thank you for your rating!</div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="bg-primary card-header">
                    
                    <h3 class="text-center m-3 text-white text-secondary">Day Management System</h3>
                  </div>
                  <!-- /.card-header -->
                    
                  <?php if ($this->session->flashdata('success_message')): ?>
                    <hr>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> <?php echo $this->session->flashdata('success_message'); ?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <hr>
                    <?php endif; ?>

                  <div class="card-body">
                    <div class="container-fluid body-content">
                      <div class="page-header bg-graywe11">
                            <div class="table-responsive">
                                <div class="pdf-viwer">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav_TodayMorning" data-toggle="tab" href="#TodayMorning" role="tab" aria-controls="TodayMorning" aria-selected="true">Add Today Morning's Feedback</a>
                                        <a class="nav-item nav-link" id="nav_YesterdayEvening" data-toggle="tab" href="#YesterdayEvening" role="tab" aria-controls="YesterdayEvening" aria-selected="false">Add Yesterday Evening FeedBack</a>
                                        <a class="nav-item nav-link" id="nav_YesterdayTask" data-toggle="tab" href="#YesterdayTask" role="tab" aria-controls="YesterdayTask" aria-selected="false">Add Yesterday Task FeedBack</a>
                                    </div>
                                </nav>
                                <br>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="TodayMorning" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <table id="TodayMorningTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Start Time</th>
                                                    <th>Start Image</th>
                                                    <th>Start Google Map </th>
                                                    <th>Close Time</th>
                                                    <th>Close Image</th>
                                                    <th>Close Google Map</th>
                                                    <th>Wfo</th>
                                                    <th>Start Comment</th>
                                                    <th>End Comment</th>
                                                    <th>Todays AutoTask Time</th>
                                                    <th>Todays Task Plan Request</th>
                                                    <th>Todays Consume Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $i=1; foreach($dayData as $data):
                                                    $teamuid = $data->user_id;
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $data->name; ?></td>
                                                    <td data-question="Started at Good Time" data-userid="<?= $data->user_id; ?>" data-period="Mornings" data-cdate="<?= $cdate; ?>">
                                                        <?= $data->ustart; ?>
                                                        <br><br><hr>
                                                        <p class="question">Started at Good Time?</p>
                                                        <?php 

                                                            $chkStarRating = $this->Management_model->CheckStarRatingsExistorNot_New($teamuid,$cdate,'Started at Good Time','Mornings');

                                                            if(sizeof($chkStarRating) == 0){ ?>

                                                                <div class="rating" id="rating1">
                                                                    <input type="radio" name="rat1_<?= $data->user_id; ?>" value="5" id="5_<?= $data->user_id; ?>"><label for="5_<?= $data->user_id; ?>">☆</label>
                                                                    <input type="radio" name="rat1_<?= $data->user_id; ?>" value="4" id="4_<?= $data->user_id; ?>"><label for="4_<?= $data->user_id; ?>">☆</label>
                                                                    <input type="radio" name="rat1_<?= $data->user_id; ?>" value="3" id="3_<?= $data->user_id; ?>"><label for="3_<?= $data->user_id; ?>">☆</label>
                                                                    <input type="radio" name="rat1_<?= $data->user_id; ?>" value="2" id="2_<?= $data->user_id; ?>"><label for="2_<?= $data->user_id; ?>">☆</label>
                                                                    <input type="radio" name="rat1_<?= $data->user_id; ?>" value="1" id="1_<?= $data->user_id; ?>"><label for="1_<?= $data->user_id; ?>">☆</label>
                                                                </div>

                                                            <?php }else{
                                                                foreach($chkStarRating as $star){

                                                                    $starRating = $star->star;
                                                                    
                                                                }
                                                                echo "<hr>";
                                                                echo "<span class='text-success12'><b>Total Star Given</b> :</span>";
                                                                echo "<div class='star-rating'>";
                                                                $totalStars = 5;
                                                                for ($i = 0; $i < $starRating; $i++) {
                                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                                }
                                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                                }
                                                            }  ?>
                                                            
                                                            <?php ?> 
                                                        
                                                        <div class="show_rating" >
                                                        
                                                            <p></p>
                                                        </div>
                                                    </td>
                                                    <td data-question="Day Start Image is Good" data-userid="<?= $data->user_id; ?>" data-period="Mornings" data-cdate="<?= $cdate; ?>">
                                                        <a href="<?=base_url().'/'.$data->usimg;?>">
                                                            <img class="uimage" height="100px" alt="image not found" src="<?=base_url().'/'.$data->usimg;?>">
                                                        </a>
                                                        <br><br><hr>
                                                        <p class="question">Day Start Image is Good</p>
                                                        <?php 

                                                            $chkStarRating = $this->Management_model->CheckStarRatingsExistorNot_New($teamuid,$cdate,'Day Start Image is Good','Mornings');

                                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat2_" value="5" id="10_<?= $data->user_id; ?>"><label for="10_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat2_" value="4" id="9_<?= $data->user_id; ?>"><label for="9_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat2_" value="3" id="8_<?= $data->user_id; ?>"><label for="8_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat2_" value="2" id="7_<?= $data->user_id; ?>"><label for="7_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat2_" value="1" id="6_<?= $data->user_id; ?>"><label for="6_<?= $data->user_id; ?>">☆</label>
                                                        </div>
                                                        <?php }else{
                                                                foreach($chkStarRating as $star){

                                                                    $starRating = $star->star;
                                                                    
                                                                }
                                                                echo "<hr>";
                                                                echo "<span class='text-success12'><b>Total Star Given</b> :</span>";
                                                                echo "<div class='star-rating'>";
                                                                $totalStars = 5;
                                                                for ($i = 0; $i < $starRating; $i++) {
                                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                                }
                                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                                }
                                                            }  ?>
                                                    </td>
                                                    <td data-question="Day Start Location as per Plan" data-userid="<?= $data->user_id; ?>" data-period="Mornings" data-cdate="<?= $cdate; ?>">
                                                        <?php
                                                        $latitude = $data->slatitude;;
                                                        $longitude = $data->slongitude;;
                                                        ?>                     
                                                        <div class="img-thumbnail" style="height: 150px"><iframe width="150px"  height="100%" src="https://maps.google.com/?q=<?=$latitude?>,<?=$longitude?>&t=k&z=13&ie=UTF8&iwloc=&output=embed"></iframe></div>
                                                        <div class="text-center">
                                                        <?php 
                                                        $googleMapsUrl = "https://www.google.com/maps/search/?api=1&query={$latitude},{$longitude}";
                                                        echo "<a style='color:green' href='{$googleMapsUrl}' target='_blank'>Open in Google Maps</a>";
                                                        ?>
                                                        </div>

                                                        <br><hr>
                                                        <p class="question">Day Start Location as per Plan</p>
                                                        <?php 

                                                            $chkStarRating = $this->Management_model->CheckStarRatingsExistorNot_New($teamuid,$cdate,'Day Start Location as per Plan','Mornings');

                                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat3_<?= $data->user_id; ?>" value="5" id="15_<?= $data->user_id; ?>"><label for="15_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat3_<?= $data->user_id; ?>" value="4" id="14_<?= $data->user_id; ?>"><label for="14_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat3_<?= $data->user_id; ?>" value="3" id="13_<?= $data->user_id; ?>"><label for="13_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat3_<?= $data->user_id; ?>" value="2" id="12_<?= $data->user_id; ?>"><label for="12_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat3_<?= $data->user_id; ?>" value="1" id="11_<?= $data->user_id; ?>"><label for="11_<?= $data->user_id; ?>">☆</label>
                                                        </div> 
                                                        <?php }else{
                                                                foreach($chkStarRating as $star){

                                                                    $starRating = $star->star;
                                                                    
                                                                }
                                                                echo "<hr>";
                                                                echo "<span class='text-success12'><b>Total Star Given</b> :</span>";
                                                                echo "<div class='star-rating'>";
                                                                $totalStars = 5;
                                                                for ($i = 0; $i < $starRating; $i++) {
                                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                                }
                                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                                }
                                                            }  ?>
                                                    </td>
                                                    <td>
                                                        <?php if(isset($data->uclose)){ ?>
                                                            <?= $data->uclose; ?>
                                                        <?php }else{ ?>
                                                            <span class="bg-warning p-1"> Pending</span>
                                                        <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php if(isset($data->ucimg)){ ?>
                                                        <a href="<?=base_url().'/'.$data->ucimg;?>">
                                                            <img class="uimage" height="100px" alt="image not found" src="<?=base_url().'/'.$data->ucimg;?>">
                                                        </a>
                                                        <?php }else{ ?>
                                                            <span class="bg-warning p-1"> Pending</span>
                                                        <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $clatitude = $data->clatitude;;
                                                        $clongitude = $data->clongitude;;
                                                        if(isset($clatitude)){ ?>
                                                        <div class="img-thumbnail" style="height: 300px"><iframe width="300px"  height="100%" src="https://maps.google.com/?q=<?=$clatitude?>,<?=$clongitude?>&t=k&z=13&ie=UTF8&iwloc=&output=embed"></iframe></div>
                                                            <div class="text-center">
                                                            <?php 
                                                            $googleMapsUrl = "https://www.google.com/maps/search/?api=1&query={$clatitude},{$clongitude}";
                                                            echo "<a style='color:green' href='{$googleMapsUrl}' target='_blank'>Open in Google Maps</a>";
                                                            ?>
                                                            </div>
                                                            <?php }else{ ?>
                                                                <span class="bg-warning p-1"> Pending</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td data-question="Today Working as per Plan" data-userid="<?= $data->user_id; ?>" data-period="Mornings" data-cdate="<?= $cdate; ?>">
                                                        <?php 
                                                            if($data->wffo ==1){ ?>
                                                                <span class="bg-warning1 p-1"> Work&nbsp;From&nbsp;Office</span>
                                                        <?php  }elseif($data->wffo ==2){ ?>
                                                            <span class="bg-warning1 p-1"> Work&nbsp;From&nbsp;Field</span>
                                                        <?php }elseif($data->wffo ==3){ ?>
                                                            <span class="bg-warning1 p-1"> Work&nbsp;From&nbsp;Field+Office </span>
                                                        <?php  } ?>

                                                        <br><br><hr>
                                                        <p class="question">Today Working as per Plan</p>
                                                        <?php 

                                                            $chkStarRating = $this->Management_model->CheckStarRatingsExistorNot_New($teamuid,$cdate,'Today Working as per Plan','Mornings');

                                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat4_<?= $data->user_id; ?>" value="5" id="20_<?= $data->user_id; ?>"><label for="20_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat4_<?= $data->user_id; ?>" value="4" id="19_<?= $data->user_id; ?>"><label for="19_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat4_<?= $data->user_id; ?>" value="3" id="18_<?= $data->user_id; ?>"><label for="18_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat4_<?= $data->user_id; ?>" value="2" id="17_<?= $data->user_id; ?>"><label for="17_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat4_<?= $data->user_id; ?>" value="1" id="16_<?= $data->user_id; ?>"><label for="16_<?= $data->user_id; ?>">☆</label>
                                                        </div> 
                                                        <?php }else{
                                                                foreach($chkStarRating as $star){

                                                                    $starRating = $star->star;
                                                                    
                                                                }
                                                                echo "<hr>";
                                                                echo "<span class='text-success12'><b>Total Star Given</b> :</span>";
                                                                echo "<div class='star-rating'>";
                                                                $totalStars = 5;
                                                                for ($i = 0; $i < $starRating; $i++) {
                                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                                }
                                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                                }
                                                            }  ?>
                                                    </td>
                                                    <td>
                                                        <?php if(isset($data->scomment)){ ?>
                                                            <?= $data->scomment ?>
                                                        <?php }else{ ?>
                                                            <span class="bg-danger p-1"> Not Set</span>
                                                        <?php }?>
                                                    </td> 
                                                    <td>
                                                        <?php if(isset($data->ccomment)){ ?>
                                                            <?= $data->ccomment ?>
                                                        <?php }else{ ?>
                                                            <span class="bg-danger p-1"> Not Set</span>
                                                        <?php }?>
                                                    </td>
                                                    <td data-question="Auto task time entered correctly" data-userid="<?= $data->user_id; ?>" data-period="Mornings" data-cdate="<?= $cdate; ?>">
                                                        <?php 
                                                        $checkaTime = $this->Management_model->CheckAutoTaskTime($teamuid,$cdate);
                                                        if(sizeof($checkaTime) > 0){
                                                            echo '<b>Start Time : </b>'.$checkaTime[0]->stime;
                                                            echo "<hr>";
                                                            echo '<b>End Time : </b>'.$checkaTime[0]->etime ;
                                                            echo "<br/> <hr/>";
                                                            $start = new DateTime($checkaTime[0]->stime);
                                                            $end = new DateTime($checkaTime[0]->etime);
                                                            $interval = $start->diff($end);
                                                            $minutes = ($interval->h * 60) + $interval->i;
                                                            echo "Time Difference: $minutes minutes</b>";
                                                        }
                                                        ?>
                                                        <br><br><hr>
                                                        <p class="question">Auto task time entered correctly </p>
                                                        <?php 

                                                            $chkStarRating = $this->Management_model->CheckStarRatingsExistorNot_New($teamuid,$cdate,'Auto task time entered correctly','Mornings');

                                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat5_<?= $data->user_id; ?>" value="5" id="25_<?= $data->user_id; ?>"><label for="25_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat5_<?= $data->user_id; ?>" value="4" id="24_<?= $data->user_id; ?>"><label for="24_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat5_<?= $data->user_id; ?>" value="3" id="23_<?= $data->user_id; ?>"><label for="23_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat5_<?= $data->user_id; ?>" value="2" id="22_<?= $data->user_id; ?>"><label for="22_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat5_<?= $data->user_id; ?>" value="1" id="21_<?= $data->user_id; ?>"><label for="21_<?= $data->user_id; ?>">☆</label>
                                                        </div>
                                                        <?php }else{
                                                                foreach($chkStarRating as $star){

                                                                    $starRating = $star->star;
                                                                    
                                                                }
                                                                echo "<hr>";
                                                                echo "<span class='text-success12'><b>Total Star Given</b> :</span>";
                                                                echo "<div class='star-rating'>";
                                                                $totalStars = 5;
                                                                for ($i = 0; $i < $starRating; $i++) {
                                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                                }
                                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                                }
                                                            }  ?>
                                                    </td> 
                                                    <td data-question="Auto task time entered correctly" data-userid="<?= $data->user_id; ?>" data-period="Mornings" data-cdate="<?= $cdate; ?>">
                                                        <?php 
                                                        $checkReqTime = $this->Management_model->CheckTaskPlanRequest($teamuid,$cdate);
                                                        if(sizeof($checkReqTime) > 0){ ?>
                                                        <b>Request Reamarks : </b><?= $checkReqTime[0]->request_remarks ?> <hr>
                                                        <b>Approvel Status :<br/><br> </b> 
                                                        <?php if($checkReqTime[0]->approvel_status == 'Approved'){ ?>
                                                        <span class="bg-success p-1"> <?= $checkReqTime[0]->approvel_status ?></span>
                                                        <?php } ?>

                                                        <?php if($checkReqTime[0]->approvel_status == 'Reject'){ ?>
                                                        <span class="bg-danger p-1"> <?= $checkReqTime[0]->approvel_status ?></span>
                                                        <?php } ?>
                                                        <?php if($checkReqTime[0]->approvel_status == ''){ ?>
                                                            <span class="bg-warning p-1"> Pending</span>
                                                        <?php } ?>
                                                        <hr>
                                                        <b>Admin Reamarks : </b> <?= $checkReqTime[0]->remarks ?>
                                                        <?php }else{
                                                            echo "No Request";
                                                        }
                                                        ?>
                                                        <br><br><hr>
                                                        <p class="question">Did you request today's work plan?</p>
                                                        <?php 

                                                            $chkStarRating = $this->Management_model->CheckStarRatingsExistorNot_New($teamuid,$cdate,'Auto task time entered correctly','Mornings');

                                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat6_<?= $data->user_id; ?>" value="5" id="30_<?= $data->user_id; ?>"><label for="30_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat6_<?= $data->user_id; ?>" value="4" id="29_<?= $data->user_id; ?>"><label for="29_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat6_<?= $data->user_id; ?>" value="3" id="28_<?= $data->user_id; ?>"><label for="28_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat6_<?= $data->user_id; ?>" value="2" id="27_<?= $data->user_id; ?>"><label for="27_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat6_<?= $data->user_id; ?>" value="1" id="26_<?= $data->user_id; ?>"><label for="26_<?= $data->user_id; ?>">☆</label>
                                                        </div>
                                                        <?php }else{
                                                                foreach($chkStarRating as $star){

                                                                    $starRating = $star->star;
                                                                    
                                                                }
                                                                echo "<hr>";
                                                                echo "<span class='text-success12'><b>Total Star Given</b> :</span>";
                                                                echo "<div class='star-rating'>";
                                                                $totalStars = 5;
                                                                for ($i = 0; $i < $starRating; $i++) {
                                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                                }
                                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                                }
                                                            }  ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $dayconsumetime = $this->Management_model->CheckingYesterDayConsumeTime($teamuid,$cdate);
                                                            date_default_timezone_set('Asia/Kolkata');
                                                            $ustart = $dayconsumetime[0]->ustart;
                                                            $uclose = $dayconsumetime[0]->uclose;
                                                            $sst = (isset($ustart)) ? $ustart : 'Not Set';
                                                            $eet = (isset($uclose)) ? $uclose : 'Pendings';
                                                            echo '<b>Start Time : </b>'.$sst;
                                                            echo "<hr>";
                                                            if(!isset($uclose)){ ?>
                                                                <span class="bg-warning p-1"> <b>End&nbsp;Time&nbsp;:&nbsp;</b>&nbsp;&nbsp;Pending</span> <hr>
                                                        <?php  }else{
                                                            echo '<b>End Time : </b>'.$eet ;
                                                            } ?>
                                                            <?php
                                                            if($eet == 'Pendings'){
                                                                $uclose = date("Y-m-d H:i:s"); 
                                                            }else{
                                                                $uclose = new DateTime($uclose);
                                                            }
                                                            $start = new DateTime($ustart);
                                                            $end = new DateTime($uclose);
                                                            $interval = $start->diff($end);
                                                            $minutesd = ($interval->h * 60) + $interval->i;
                                                            $hours = floor($minutesd / 60);
                                                            // Calculate the remaining minutes
                                                            $minutes = $minutesd % 60;
                                                            echo "<b>Till now Consume Time : </b> <hr/>";
                                                            echo "$hours hours and $minutes minutes.\n";
                                                        ?>
                                                    </td>          
                                                </tr>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="YesterdayEvening" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <table id="YesterdayEveningTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Yesterday Day Manage Time</th>
                                                    <th>Yesterday AutoTask Time</th>
                                                    <th>Yesterday Task Plan Request</th>
                                                    <th>Yesterday Start Image</th>
                                                    <th>Yesterday Start Comment</th>
                                                    <th>Yesterday Close Image</th>
                                                    <th>Yesterday End Comment</th>
                                                    <th>Yesterday Close Google Map </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $i=1; foreach($dayData as $data):
                                                    $teamuid = $data->user_id;
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $data->name; ?></td>
                                                    <td data-question="The Day Ended at a good time" data-userid="<?= $data->user_id; ?>" data-period="Yesterday Evening" data-cdate="<?= $cdate; ?>" style="width:100px">
                                                        <?php 
                                                        $dayconsumetime = $this->Management_model->CheckingYesterDayConsumeTime($teamuid,$previousDate);
                                                        $ustart = $dayconsumetime[0]->ustart;
                                                        $uclose = $dayconsumetime[0]->uclose;
                                                        $sst = (isset($ustart)) ? $ustart : 'Not Set';
                                                        $eet = (isset($uclose)) ? $uclose : '';
                                                        echo '<b>Start Time : </b>'.$sst;
                                                        echo "<hr>";
                                                        echo '<b>End Time : </b>'.$eet ;
                                                        echo "<br/> <hr/>";
                                                        $start = new DateTime($ustart);
                                                        $end = new DateTime($uclose);
                                                        $interval = $start->diff($end);
                                                        $minutesd = ($interval->h * 60) + $interval->i;
                                                        $hours = floor($minutesd / 60);
                                                        // Calculate the remaining minutes
                                                        $minutes = $minutesd % 60;
                                                        if(isset($uclose)){
                                                            echo "$hours hours and $minutes minutes.\n";
                                                        }else{ ?>
                                                            <span class="bg-danger p-1"> <b>End&nbsp;Time&nbsp;:&nbsp;</b>&nbsp;Not&nbsp;Set</span>
                                                        <?php } ?>

                                                        <br><br><hr>
                                                        <p class="question">The Day Ended at a good time</p>
                                                        <?php 
                                                            $sdate = new DateTime($cdate);
                                                            $sdate->modify('-1 day');
                                                            $previousDate = $sdate->format('Y-m-d');
                                                            
                                                            $chkStarRating = $this->Management_model->CheckStarRatingsExistorNot_New($teamuid,$previousDate,'The Day Ended at a good time','Yesterday Evening');

                                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat7_<?= $data->user_id; ?>" value="5" id="35_<?= $data->user_id; ?>"><label for="35_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat7_<?= $data->user_id; ?>" value="4" id="34_<?= $data->user_id; ?>"><label for="34_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat7_<?= $data->user_id; ?>" value="3" id="33_<?= $data->user_id; ?>"><label for="33_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat7_<?= $data->user_id; ?>" value="2" id="32_<?= $data->user_id; ?>"><label for="32_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat7_<?= $data->user_id; ?>" value="1" id="31_<?= $data->user_id; ?>"><label for="31_<?= $data->user_id; ?>">☆</label>
                                                        </div> 
                                                        <?php }else{
                                                                foreach($chkStarRating as $star){
                                                                    $starRating = $star->star;
                                                                }
                                                                echo "<hr>";
                                                                echo "<span class='text-success12'><b>Total Star Given</b> :</span>";
                                                                echo "<div class='star-rating'>";
                                                                $totalStars = 5;
                                                                for ($i = 0; $i < $starRating; $i++) {
                                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                                }
                                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                                }
                                                            }  ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $checkaTime = $this->Management_model->CheckAutoTaskTime($teamuid,$previousDate);
                                                    
                                                        if(sizeof($checkaTime) > 0){

                                                            echo '<b>Start Time : </b>'.$checkaTime[0]->stime;
                                                            echo "<hr>";
                                                            echo '<b>End Time : </b>'.$checkaTime[0]->etime ;
                                                            echo "<br/> <hr/>";

                                                            $start = new DateTime($checkaTime[0]->stime);
                                                            $end = new DateTime($checkaTime[0]->etime);
                                                            $interval = $start->diff($end);
                                                            $minutes = ($interval->h * 60) + $interval->i;
                                                            echo "Time Difference: $minutes minutes</b>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $checkReqTime = $this->Management_model->CheckTaskPlanRequest($teamuid,$previousDate);
                                                        if(sizeof($checkReqTime) > 0){ ?>
                                                        <b>Request Reamarks : </b><?= $checkReqTime[0]->request_remarks ?> <hr>
                                                        <b>Approvel Status :<br/><br> </b> 
                                                        <?php if($checkReqTime[0]->approvel_status == 'Approved'){ ?>
                                                        <span class="bg-success p-1"> <?= $checkReqTime[0]->approvel_status ?></span>
                                                        <?php } ?>

                                                        <?php if($checkReqTime[0]->approvel_status == 'Reject'){ ?>
                                                        <span class="bg-danger p-1"> <?= $checkReqTime[0]->approvel_status ?></span>
                                                        <?php } ?>
                                                        <?php if($checkReqTime[0]->approvel_status == ''){ ?>
                                                            <span class="bg-warning p-1"> Pending</span>
                                                        <?php } ?>
                                                        <hr>
                                                        <b>Admin Reamarks : </b> <?= $checkReqTime[0]->remarks ?>
                                                        <?php }else{
                                                            echo "No Request";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td >
                                                        <?php 
                                                        $checkcloseday = $this->Management_model->CheckingYesterDayConsumeTime($teamuid,$previousDate);
                                                        if(isset($checkcloseday[0]->usimg)){ ?>
                                                        <a href="<?=base_url().'/'.$checkcloseday[0]->usimg;?>">
                                                            <img class="uimage" height="100px" alt="image not found" src="<?=base_url().'/'.$checkcloseday[0]->usimg;?>">
                                                        </a>
                                                        <?php }else{ ?>
                                                            <span class="bg-danger p-1"> Not Set</span>
                                                        <?php }?>

                                                        
                                                    </td> 
                                                    <td>
                                                        <?php if(isset($checkcloseday[0]->scomment)){ ?>
                                                            <?= $checkcloseday[0]->scomment ?>
                                                        <?php }else{ ?>
                                                            <span class="bg-danger p-1"> Not Set</span>
                                                        <?php }?>
                                                    </td> 
                                                    <td data-question="Day End Image is Good" data-userid="<?= $data->user_id; ?>" data-period="Yesterday Evening" data-cdate="<?= $cdate; ?>">
                                                        <?php 
                                                        if(isset($checkcloseday[0]->ucimg)){ ?>
                                                        <a href="<?=base_url().'/'.$checkcloseday[0]->ucimg;?>">
                                                            <img class="uimage" height="100px" alt="image not found" src="<?=base_url().'/'.$checkcloseday[0]->ucimg;?>">
                                                        </a>
                                                        <?php }else{ ?>
                                                            <span class="bg-danger p-1"> Not Set</span>
                                                        <?php }?>
                                                        <br><br><hr>
                                                        <p class="question">Day End Image is Good?</p>
                                                        <?php 
                                                            $sdate = new DateTime($cdate);
                                                            $sdate->modify('-1 day');
                                                            $previousDate = $sdate->format('Y-m-d');
                                                            
                                                            $chkStarRating = $this->Management_model->CheckStarRatingsExistorNot_New($teamuid,$previousDate,'Day End Image is Good','Yesterday Evening');

                                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat8_<?= $data->user_id; ?>" value="5" id="40_<?= $data->user_id; ?>"><label for="40_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat8_<?= $data->user_id; ?>" value="4" id="39_<?= $data->user_id; ?>"><label for="39_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat8_<?= $data->user_id; ?>" value="3" id="38_<?= $data->user_id; ?>"><label for="38_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat8_<?= $data->user_id; ?>" value="2" id="37_<?= $data->user_id; ?>"><label for="37_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat8_<?= $data->user_id; ?>" value="1" id="36_<?= $data->user_id; ?>"><label for="36_<?= $data->user_id; ?>">☆</label>
                                                        </div>
                                                        <?php }else{
                                                                foreach($chkStarRating as $star){
                                                                    $starRating = $star->star;
                                                                }
                                                                echo "<hr>";
                                                                echo "<span class='text-success12'><b>Total Star Given</b> :</span>";
                                                                echo "<div class='star-rating'>";
                                                                $totalStars = 5;
                                                                for ($i = 0; $i < $starRating; $i++) {
                                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                                }
                                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                                }
                                                            }  ?> 
                                                    </td> 
                                                    <td>
                                                        <?php if(isset($checkcloseday[0]->ccomment)){ ?>
                                                            <?= $checkcloseday[0]->ccomment ?>
                                                        <?php }else{ ?>
                                                            <span class="bg-danger p-1"> Not Set</span>
                                                        <?php }?>
                                                    </td> 
                                                    <td data-question="Day End Location as per Plan" data-userid="<?= $data->user_id; ?>" data-period="Yesterday Evening" data-cdate="<?= $cdate; ?>">
                                                        <?php 
                                                            $clatitude = $checkcloseday[0]->clatitude;;
                                                            $clongitude = $checkcloseday[0]->clongitude;;
                                                            if(isset($clatitude)){ ?>
                                                            <div class="img-thumbnail" style="height: 300px"><iframe width="300px"  height="100%" src="https://maps.google.com/?q=<?=$clatitude?>,<?=$clongitude?>&t=k&z=13&ie=UTF8&iwloc=&output=embed"></iframe></div>
                                                                <div class="text-center">
                                                                <?php 
                                                                $googleMapsUrl = "https://www.google.com/maps/search/?api=1&query={$clatitude},{$clongitude}";
                                                                echo "<a style='color:green' href='{$googleMapsUrl}' target='_blank'>Open in Google Maps</a>";
                                                                ?>
                                                                </div>
                                                                <?php }else{ ?>
                                                                    <span class="bg-danger p-1"> Not Set</span>
                                                        <?php } ?>
                                                        <br><br><hr>
                                                        <p class="question">Day End Location as per Plan?</p>
                                                        <?php 
                                                            $sdate = new DateTime($cdate);
                                                            $sdate->modify('-1 day');
                                                            $previousDate = $sdate->format('Y-m-d');
                                                            
                                                            $chkStarRating = $this->Management_model->CheckStarRatingsExistorNot_New($teamuid,$previousDate,'Day End Image is Good','Yesterday Evening');

                                                            if(sizeof($chkStarRating) == 0){ ?> 
                                                        <div class="rating">
                                                            <input type="radio" name="rat9_<?= $data->user_id; ?>" value="5" id="45_<?= $data->user_id; ?>"><label for="45_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat9_<?= $data->user_id; ?>" value="4" id="44_<?= $data->user_id; ?>"><label for="44_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat9_<?= $data->user_id; ?>" value="3" id="43_<?= $data->user_id; ?>"><label for="43_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat9_<?= $data->user_id; ?>" value="2" id="42_<?= $data->user_id; ?>"><label for="42_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat9_<?= $data->user_id; ?>" value="1" id="41_<?= $data->user_id; ?>"><label for="41_<?= $data->user_id; ?>">☆</label>
                                                        </div> 
                                                        <?php }else{
                                                                foreach($chkStarRating as $star){
                                                                    $starRating = $star->star;
                                                                }
                                                                echo "<hr>";
                                                                echo "<span class='text-success12'><b>Total Star Given</b> :</span>";
                                                                echo "<div class='star-rating'>";
                                                                $totalStars = 5;
                                                                for ($i = 0; $i < $starRating; $i++) {
                                                                    echo "<i class='fas fa-star'></i>"; // filled star
                                                                }
                                                                for ($i = $starRating; $i < $totalStars; $i++) {
                                                                    echo "<i class='far fa-star'></i>"; // empty star
                                                                }
                                                            }  ?>
                                                    </td>        
                                                </tr>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="YesterdayTask" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <table id="YesterdayTaskTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Yesterday Total Plan Task</th>
                                                    <th>Yesterday Total Pending Task</th>
                                                    <th>Yesterday Total Autotask Task</th>
                                                    <th>Yesterday Total Done Task</th>
                                                    <th>Yesterday Total Consume Time</th>
                                                    <!-- <th>Yesterday Task FeedBack</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $i=1; foreach($dayData as $data):
                                                    $teamuid = $data->user_id;
                                                ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $data->name; ?></td>
                                                    <td data-question="Yesterday Total Plan Task is Good" data-userid="<?= $data->user_id; ?>" data-period="Yesterday Task">
                                                        <?php $dayData = $this->Management_model->CheckingYesterDayTaskStatus($teamuid); ?>
                                                            <a class="text-primary" target="_BLANK" href="<?= base_url().'Management/CheckingYesterDayTask/total/'.$teamuid.'/'.$cdate ?>"><?= $dayData[0]->plan ?></a>

                                                        <br><br><hr>
                                                        <p class="question">Yesterday Total Plan Task is Good?</p>
                                                        <div class="rating" id="rating10">
                                                            <input type="radio" name="rat10_<?= $data->user_id; ?>" value="5" id="50_<?= $data->user_id; ?>"><label for="50_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat10_<?= $data->user_id; ?>" value="4" id="49_<?= $data->user_id; ?>"><label for="49_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat10_<?= $data->user_id; ?>" value="3" id="48_<?= $data->user_id; ?>"><label for="48_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat10_<?= $data->user_id; ?>" value="2" id="47_<?= $data->user_id; ?>"><label for="47_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat10_<?= $data->user_id; ?>" value="1" id="46_<?= $data->user_id; ?>"><label for="46_<?= $data->user_id; ?>">☆</label>
                                                        </div> 
                                                    </td>
                                                    <td data-question="Yesterday Total Pending Task is Good" data-userid="<?= $data->user_id; ?>" data-period="Yesterday Task">
                                                        <a class="text-primary" target="_BLANK" href="<?= base_url().'Management/CheckingYesterDayTask/Pending/'.$teamuid.'/'.$cdate ?>"><?= $dayData[0]->pending ?></a>

                                                        <br><br><hr>
                                                        <p class="question">Yesterday Total Pending Task is Good?</p>
                                                        <div class="rating">
                                                            <input type="radio" name="rat11_<?= $data->user_id; ?>" value="5" id="55_<?= $data->user_id; ?>"><label for="55_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat11_<?= $data->user_id; ?>" value="4" id="54_<?= $data->user_id; ?>"><label for="54_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat11_<?= $data->user_id; ?>" value="3" id="53_<?= $data->user_id; ?>"><label for="53_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat11_<?= $data->user_id; ?>" value="2" id="52_<?= $data->user_id; ?>"><label for="52_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat11_<?= $data->user_id; ?>" value="1" id="51_<?= $data->user_id; ?>"><label for="51_<?= $data->user_id; ?>">☆</label>
                                                        </div>
                                                    </td>    
                                                    <td data-question="Yesterday Total Autotask Task is Good" data-userid="<?= $data->user_id; ?>">
                                                        <a class="text-primary" target="_BLANK" href="<?= base_url().'Management/CheckingYesterDayTask/autotask/'.$teamuid.'/'.$cdate ?>"><?= $dayData[0]->autotask ?></a>

                                                        <br><br><hr>
                                                        <p class="question">Yesterday Total Autotask Task is Good?</p>
                                                        <div class="rating">
                                                            <input type="radio" name="rat12_<?= $data->user_id; ?>" value="5" id="60_<?= $data->user_id; ?>"><label for="60_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat12_<?= $data->user_id; ?>" value="4" id="59_<?= $data->user_id; ?>"><label for="59_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat12_<?= $data->user_id; ?>" value="3" id="58_<?= $data->user_id; ?>"><label for="58_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat12_<?= $data->user_id; ?>" value="2" id="57_<?= $data->user_id; ?>"><label for="57_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat12_<?= $data->user_id; ?>" value="1" id="56_<?= $data->user_id; ?>"><label for="56_<?= $data->user_id; ?>">☆</label>
                                                        </div>
                                                    </td>
                                                    <td data-question="Yesterday Total Done Task is Good" data-userid="<?= $data->user_id; ?>" data-period="Yesterday Task">   
                                                        <a class="text-primary" target="_BLANK" href="<?= base_url().'Management/CheckingYesterDayTask/done/'.$teamuid.'/'.$cdate ?>"><?= $dayData[0]->done ?></a>

                                                        <br><br><hr>
                                                        <p class="question">Yesterday Total Done Task is Good?</p>
                                                        <div class="rating">
                                                            <input type="radio" name="rat13_<?= $data->user_id; ?>" value="5" id="65_<?= $data->user_id; ?>"><label for="65_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat13_<?= $data->user_id; ?>" value="4" id="64_<?= $data->user_id; ?>"><label for="64_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat13_<?= $data->user_id; ?>" value="3" id="63_<?= $data->user_id; ?>"><label for="63_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat13_<?= $data->user_id; ?>" value="2" id="62_<?= $data->user_id; ?>"><label for="62_<?= $data->user_id; ?>">☆</label>
                                                            <input type="radio" name="rat13_<?= $data->user_id; ?>" value="1" id="61_<?= $data->user_id; ?>"><label for="61_<?= $data->user_id; ?>">☆</label>
                                                        </div>
                                                    </td>  
                                                    <td>
                                                        <?php 
                                                        $dayconsumetime = $this->Management_model->CheckingYesterDayConsumeTime($teamuid,$previousDate);

                                                        $ustart = $dayconsumetime[0]->ustart;
                                                        $uclose = $dayconsumetime[0]->uclose;
                                                        $sst = (isset($ustart)) ? $ustart : 'Not Set';
                                                        $eet = (isset($uclose)) ? $uclose : 'Not Set';
                                                        // echo '<b>Start Time : </b>'.$sst;
                                                        // echo "<hr>";
                                                        // echo '<b>End Time : </b>'.$eet ;
                                                        // echo "<br/> <hr/>";
                                                        $start = new DateTime($ustart);
                                                        $end = new DateTime($uclose);
                                                        $interval = $start->diff($end);
                                                        $minutesd = ($interval->h * 60) + $interval->i;
                                                        $hours = floor($minutesd / 60);
                                                        // Calculate the remaining minutes
                                                        $minutes = $minutesd % 60;
                                                        if(isset($uclose)){
                                                            echo "$hours hours and $minutes minutes.\n";
                                                        }else{ ?>
                                                            <p class="text-danger p-2 ">* Time will be Calculate, if user set his End Time.</p>
                                                            <span class="bg-danger p-1"> <b>End&nbsp;Time&nbsp;:&nbsp;</b>&nbsp;Not&nbsp;Set</span>
                                                        <?php }  ?>

                                                        <!--  -->
                                                    </td>
                                                    
                                                </tr>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    </section>
    </div>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  

    <script type='text/javascript'>

function feedBackButton(mid,id,val){
    // alert(val); // MorningsfeedBack
    if(val == 'MorningsfeedBack'){
        $('#exampleModalCenter').modal('show');
        $('#selectedusermorning').val(id);
    }

    if(val == 'yesterdayEveningfeedBack'){
        // alert(val);
        $('#yesterDayeveningModalCenter').modal('show');
        $('#selecteduserYevening').val(id);
    }
    if(val == 'yesterdayTaskfeedBack'){
        // alert(val);
        $('#taskModalCenter').modal('show');
        $('#selecteduserytask').val(id);
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
    <script src="<?=base_url();?>assets/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?=base_url();?>assets/js/dashboard.js"></script>
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
        // $("#YesterdayEveningTable").DataTable({
        //     "responsive": false, "lengthChange": false, "autoWidth": true,
        //     // "buttons": ["csv", "excel", "pdf", "print"]
        // }).buttons().container().appendTo('#YesterdayEveningTable_wrapper .col-md-6:eq(0)');

        $(document).ready(function() {
            $("#YesterdayEveningTable").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": true
                // "buttons": ["csv", "excel", "pdf", "print"]
            });

            $("#TodayMorningTable").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": true
                // "buttons": ["csv", "excel", "pdf", "print"]
            });

            $("#YesterdayTaskTable").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": true
                // "buttons": ["csv", "excel", "pdf", "print"]
            });
        });
        
        // $("#YesterdayTaskTable").DataTable({
        //     "responsive": false, "lengthChange": false, "autoWidth": true,
        //     // "buttons": ["csv", "excel", "pdf", "print"]
        // }).buttons().container().appendTo('#YesterdayTaskTable_wrapper .col-md-6:eq(0)');
    </script>
    <script>
        $(document).ready(function(){
            $(".rating input").on("change", function(){
                var $td = $(this).closest('td');
                // console.log($td);
                $(this).parent().hide();
                var rating_id = $(this).attr('id');
                var rating = $(this).val();
                var question = $td.data('question');
                var userId = $td.data('userid');
				var period = $td.data('period');
                var cdate = $td.data('cdate');
                // data-userid
                // console.log(rating_id);
                // console.log(userId);
                // console.log(question);
                // console.log(rating);
				// console.log(period);

                $.ajax({
                    url: '<?=base_url();?>Management/checkdayswithStarNew',
                    type: 'POST',
                    data: {
                        rating: rating,
                        question: question,
                        userId: userId,
						period: period,
                        cdate:cdate
                    },
                    success: function(response) {
                        // alert(response);
                        // alert(response);
                        // alert("Rating submitted successfully!");
                         
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
            });
        });
    </script>    
  </body>
</html>