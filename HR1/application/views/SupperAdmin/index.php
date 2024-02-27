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
  <style>
      .scrollme {
    overflow-x: auto;
}
  </style>
  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->

  <!-- Navbar -->
  <?php require('nav.php');?>
  <?php require('addpop.php');?>
  <!-- /.navbar -->




  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
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
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
    <!-- Main content -->
    
       <div class="card m-3 p-3">
        <table class="table">
        <tr>
            <th>Type</th>
            <th>Call</th>
            <th>Email</th>
            <th>Whatsapp</th>
            <th>Meeting</th>
            <th>Total</th>
        </tr>
        <tr>
            <th>Planned</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th>Executed</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </table></div>
    
    
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>Team Task Detail</h5></center><hr>
                <a href="CandidateList/0"><p>Total Task Assign/Planned - <b></b></p></a>
                <a href="CandidateList/0"><p>Total Task Pending  - <b></b></p></a>
                <a href="CandidateList/0"><p>Total Task Completed - <b></b></p></a>
                <a href="CandidateList/0"><p>Call Done- <b></b></p></a>
                <a href="CandidateList/0"><p>Email Done - <b></b></p></a>
                <a href="CandidateList/0"><p>Whatsapp Done - <b></b></p></a>
                <a href="CandidateList/0"><p>Meeting Done - <b></b></p></a>
                <a href="CandidateList/0"><p>Induction Done - <b></b></p></a>
                <a href="CandidateList/0"><p>Action Taken Yes - <b></b></p></a>
                <a href="CandidateList/0"><p>Action Taken No - <b></b></p></a>
                <a href="CandidateList/0"><p>Purpose Achieved Yes - <b></b></p></a>
                <a href="CandidateList/0"><p>Purpose Achieved No - <b></b></p></a>
                <p></p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="TeamDetail" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>Team Conversion Detail</h5></center><hr>
                <p>Open to Ringing</p>
                <p>Open to Not Interested</p>
                <p>OPEN to Interested</p>
                <p>OPEN to Not Relevant</p>
                <p>Interested to Hight CTC</p>
                <p>Interested to Round 1 Select</p>
                <p>Interested to Round 1 Reject</p>
                <p>Round 1 Select to Round 2 Select</p>
                <p>Round 1 Select to Round 2 Reject</p>
                <p>Round 2 Select to Back Out</p>
                <p>Round 2 Select to Selected</p>
                <p>Selected to Joined</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="TeamDetail" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                  <?php $swcd = $this->Menu_model->statuswiseCdetail($uid);?>
                <center><h5>Team Candidate Status</h5></center><hr>
                <a href="CandidateList/0"><p>Total Candidate - <b><?=$swcd[0]->ab?></b></p></a>
                 <a href="CandidateList/1"><p>OPEN - <b><?=$swcd[0]->a?></b></p></a>
                <a href="CandidateList/1"><p>Ringing - <b><?=$swcd[0]->b?></b></p></a>
                <a href="CandidateList/2"><p>Not Interested - <b><?=$swcd[0]->c?></b></p></a>
                <a href="CandidateList/3"><p>Interested - <b><?=$swcd[0]->d?></b></p></a>
                <a href="CandidateList/4"><p>Not Relevant - <b><?=$swcd[0]->e?></b></p></a>
                <a href="CandidateList/9"><p>Hight CTC - <b><?=$swcd[0]->f?></b></p></a>
                <a href="CandidateList/5"><p>Round 1 Select - <b><?=$swcd[0]->g?></b></p></a>
                <a href="CandidateList/6"><p>Round 1 Reject - <b><?=$swcd[0]->h?></b></p></a>
                <a href="CandidateList/7"><p>Round 2 Select - <b><?=$swcd[0]->i?></b></p></a>
                <a href="CandidateList/8"><p>Round 2 Reject - <b><?=$swcd[0]->j?></b></p></a>
                <a href="CandidateList/8"><p>Back Out - <b><?=$swcd[0]->k?></b></p></a>
                <a href="CandidateList/8"><p>Selected - <b><?=$swcd[0]->l?></b></p></a>
                <a href="CandidateList/8"><p>Joined - <b><?=$swcd[0]->m?></b></p></a>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="CandidateList/0" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                  <?php $pwcd = $this->Menu_model->positionwiseCdetail($uid);?>
                <center><h5>Team Candidate Detail</h5></center><hr>
                <?php foreach($pwcd as $pwc){?>
                    <a href="CandidateList/1"><p><?php if($pwc->spname==''){echo 'Blank';}else{echo $pwc->spname;}?> - <b><?=$pwc->cont?></b></p></a>
                <?php } ?>
                
                 </div>
              <div class="icon"> 
                <i class="ion ion-bag"></i>
              </div>
              <a href="CandidateList/0" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
    
            
          </div>
        <!-- /.row (main row) -->
        
        </div>
  </div>
  </div></div>
    <div class="row">
          <div class="col-lg-8 col-sm">
              <div class="row">
                  <div class="col-lg-12 col-sm">
            <div class="card card-primary card-outline card-outline-tabs">
                <h4 class="p-3">Today's Task Planned</h4>
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                      <?php 
                        date_default_timezone_set("Asia/Calcutta");
                        $tdate=date('Y-m-d');
                        $ttbyd = $this->Menu_model->pending_task($uid,$tdate);
                        $totalt = $this->Menu_model->pending_taskd($uid,$tdate);
                      
                      ?>
                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">
                        All <span class="badge badge-success"><?=$ttbyd[0]->ab?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-call-tab" data-toggle="pill" href="#custom-tabs-four-call" role="tab" aria-controls="custom-tabs-four-call" aria-selected="false">
                        Call <span class="badge badge-success"><?=$ttbyd[0]->a?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-email-tab" data-toggle="pill" href="#custom-tabs-four-email" role="tab" aria-controls="custom-tabs-four-email" aria-selected="false">
                        Email <span class="badge badge-success">0</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-meeting-tab" data-toggle="pill" href="#custom-tabs-four-meeting" role="tab" aria-controls="custom-tabs-four-meeting" aria-selected="false">
                        Meeting <span class="badge badge-success">0</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-whatsapp-tab" data-toggle="pill" href="#custom-tabs-four-whatsapp" role="tab" aria-controls="custom-tabs-whatsapp" aria-selected="false">
                        WA<span class="badge badge-success">0</span>
                    </a>
                  </li>
                </ul>
                
              </div>
              <div class="card-body">
                  <div class="tab-pane fade" id="custom-tabs-four-call" role="tabpanel" aria-labelledby="custom-tabs-four-call-tab">
                    <?php $aai=0;foreach($totalt as $tt){if($tt->action_id=='1'){
                          $taid = $tt->action_id;
                          $taid=$this->Menu_model->get_action($taid);
                          $time = $tt->plan;
                          $time = date('h:i a', strtotime($time));
                      ?>
                        <div class="list-group-item list-group-item-action">
                            <button id="add_act<?=$aai?>" value="<?=$tt->tid?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                          <input type="hidden" value="<?=$tt->tid?>" id="tid">
                           <span class="mr-3 align-items-center">
                              <i class="fa-solid fa-circle"></i>
                           </span>
                           <span class="flex"><?=$taid[0]->name?> | 
                               <strong class="text-secondary mr-1"><?=$tt->cname?> | <?=$tt->cqual?> | <?=$tt->city?> | <?=$tt->state?> |</strong><br>
                               <small class="text-muted">Task Time:- <?=$time?></small>
                            </span>
                            <span class="text-right">
                                <i class="fa-solid fa-forward"></i>
                            </span>
                        </button></div>
                      <?php $aai++;}} ?>
                  </div></button>
            </div>
              <!-- /.card -->
            </div><!-- /.card -->
            </div>
            <div class="col-lg-12 col-sm">
            <div class="card card-primary card-outline card-outline-tabs">
                <h4 class="p-3">Today's Task Completed</h4>
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-four-homea-tab" data-toggle="pill" href="#custom-tabs-four-homea" role="tab" aria-controls="custom-tabs-four-homea" aria-selected="true">
                        All <span class="badge badge-success">0</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-calla-tab" data-toggle="pill" href="#custom-tabs-four-calla" role="tab" aria-controls="custom-tabs-four-calla" aria-selected="false">
                        Call <span class="badge badge-success">0</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-emaila-tab" data-toggle="pill" href="#custom-tabs-four-emaila" role="tab" aria-controls="custom-tabs-four-emaila" aria-selected="false">
                        Email <span class="badge badge-success">0</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-meetinga-tab" data-toggle="pill" href="#custom-tabs-four-meetinga" role="tab" aria-controls="custom-tabs-four-meetinga" aria-selected="false">
                        Meeting <span class="badge badge-success">0</span>
                    </a>
                  </li>
                </ul>
                </div>
              <div class="card-body">
                
                  <div class="tab-pane fade" id="custom-tabs-four-calla" role="tabpanel" aria-labelledby="custom-tabs-four-calla-tab">
                        <div class="list-group-item list-group-item-action">
                            <button id="comp_task" value=">" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                            <input type="hidden" value="" id="tid">
                           <span class="mr-3 align-items-center">
                              <i class="fa-solid fa-circle"></i>
                           </span>
                           <span class="flex">
                               <strong class="text-secondary mr-1"></strong><br>
                               <small class="text-muted"></small>
                            </span>
                            <span class="p-3"></span>
                            <span class="text-right">
                                <i class="fa-solid fa-forward"></i>
                            </span>
                            </button>
                        </div>
            </div>
              </div></div></div></div></div>
            <div class="col-lg-4 col-sm">
            <div class="card card-primary card-outline card-outline-tabs">
                <?php 
                $patd = $this->Menu_model->pending_task_up($uid,$tdate);
                $patdd = $this->Menu_model->pending_taskd_up($uid,$tdate);
                ?>
              <div class="card-header text-center bg-info"><b>Task to be Schedule</b></div>
              <div class="card-header text-center bg-light"><b>
              Total Task <?=$patd[0]->ab?> | Call(<?=$patd[0]->a?>)
              
              
              </b></div>
              <div class="card-body">
                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
                        <ul id="myUL">
                            <?php $ai=0;foreach($patdd as $tt){?>
                          <li><a>
                           <strong class="text-secondary"><?=$tt->cname?></strong>
                           <button id="add_plan<?=$ai?>" value="<?=$tt->tid?>">Plan</button>
                          </a>
                          
                          </li><?php $ai++;} ?>
                        </ul>
                  </div>
                </div>
                
                
              
          </div>
        </div>
</div>
 </div>
        </div>
</div>
  
        
            
            
            
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
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light1",
	title:{
		text: "Goals of This Month"
	},
	axisY:{
		includeZero: true
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Real Trees",
		indexLabel: "{y}",
		yValueFormatString: "$#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Artificial Trees",
		indexLabel: "{y}",
		yValueFormatString: "$#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}
 
}
</script>




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
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    $("#example2").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
</body>
</html>
