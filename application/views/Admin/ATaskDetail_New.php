<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="wi$dth=device-wi$dth, initial-scale=1">
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
  <?php //var_dump($getCountData);die; ?>
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
        <div class="row">
          <div class="col-12">
            <div class="card">
                <!-- <img class="card-img-top" src="holder.js/100x180/" alt=""> -->
                <div class="card-body">
                    <form action="<?=base_url();?>Menu/ATaskDetail_New/<?=$code?>/<?=$uid?>/<?=$atid?>/<?=$sd?>/<?=$sd?>/0" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input type="date" name="FromDate" id="FromDate" value="<?=$sd?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input type="date" name="EndDate" id="EndDate" value="<?=$ed?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 class="text-center"><center><b>
                <?php 

                    if ($code == 4) {
                        $status = 'Total';
                    }elseif ($code == 5) {
                        $status = 'Pending';
                    }elseif ($code == 6) {
                        $status = 'Completed';
                    }else{
                        $status = '';
                    }
                
                ?>    
                <?php echo $status;echo ' '; ?>Task Detail <br>(from <?=$sd?> to <?=$ed?>)</b></center></h3>
                </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <div class="container body-content">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <canvas id="TaskChart" style="width: 100%; height: 200px;"></canvas>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="page-header">
                            <fieldset>
                                        <div class="table-responsive">
                                            <div class="table-responsive">
                                                <div class="pdf-viwer">
                                                    <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No.</th>
                                                            <th>BD Name</th>
                                                            <th>Company Name</th>
                                                            <th>Plan Time</th>
                                                            <th>Initiated Time</th>
                                                            <th>Plan and Initiated Time Diff</th>
                                                            <th>Completed Time</th>
                                                            <th>Plan and Completed Time Diff</th>
                                                            <th>Initiated and Completed Time Diff</th>
                                                            <th>Last_Task Date</th>
                                                            <th>Current_Task Date</th>
                                                            <th>Current task planned after time difference</th>
                                                            <th>Last_Task_Activity</th>
                                                            <th>Current_Task_Activity</th>
                                                            <th>Last_Task_Remarks</th>
                                                            <th>Current_Task_Remarks</th>
                                                            <th>Last_Status</th>
                                                            <th>Current_Status</th>
                                                            <th>Action Taken</th>
                                                            <th>Purpose Achieved</th>
                                                            <!-- <th>Review Remark</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $i=1;
                                                        
                                                        foreach($mtdata as $md){
                                                            $bd = $md->user_id;
                                                            $bdname = $this->Menu_model->get_userbyid($bd);
                                                            $tid = $md->id;
                                                            $ltid = $md->ltid;
                                                            $inid  = $md->cid_id;
                                                            $inid = $this->Menu_model->get_initbyid($inid);
                                                            $mtd = $this->Menu_model->get_ccitblall($tid);
                                                            $lsid = $mtd[0]->status_id;
                                                            $csid = $mtd[0]->nstatus_id;
                                                            $s1 = $this->Menu_model->get_statusbyid($lsid);
                                                            if($s1){$s1=$s1[0]->name;}else{$s1='';}
                                                            $s2 = $this->Menu_model->get_statusbyid($csid);
                                                            if($s2){$s2=$s2[0]->name;}else{$s2='';}
                                                            if($ltid!=''){  
                                                            $mltd = $this->Menu_model->get_ccitblall($ltid);
                                                            $ltime = $mltd[0]->updateddate;
                                                            $ctime = $mtd[0]->updateddate;
                                                            $nltime = date('d-m-Y  h:i A', strtotime($ltime));
                                                            $nctime = date('d-m-Y  h:i A', strtotime($ctime));
                                                            }else{$mltd='';$nltime='';$nctime='';$ltime='';$ctime='';}
                                                        ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td><?=$bdname[0]->name?></td>
                                                        <td><a href="<?=base_url();?>/Menu/CompanyDetails/<?=$inid[0]->cmpid_id?>"><?=$mtd[0]->compname?></a></td>
                                                        <td><?=date('d-m-Y h:i A', strtotime($pltime = $md->appointmentdatetime));?></td>
                                                        <td><?=date('d-m-Y h:i A', strtotime($intime = $md->initiateddt));?></td>
                                                        <td><?=$this->Menu_model->timediff($pltime,$intime)?></td>
                                                        <td><?=date('d-m-Y h:i A', strtotime($uptime = $md->updateddate));?></td>
                                                        <td><?=$this->Menu_model->timediff($pltime,$uptime)?></td>
                                                        <td><?=$this->Menu_model->timediff($intime,$uptime)?></td>
                                                        <td><?=$nltime?></td>
                                                        <td><?=$nctime?></td>
                                                        <td><?php if($ctime!=''){echo $this->Menu_model->timediff($ltime,$ctime);}?></td>
                                                        <td><?php if($mltd!=''){echo $mltd[0]->current_action_type;}?></td>
                                                        <td><?=$mtd[0]->current_action_type?></td>
                                                        <td><?php if($mltd!=''){echo $mltd[0]->remarks;}?></td>
                                                        <td><?=$md->remarks?><?=$md->mom?></td>
                                                        <td><?=$s1?></td>
                                                        <td><?=$s2?></td>
                                                        <td><?=$mtd[0]->actontaken?></td>
                                                        <td><?=$mtd[0]->purpose_achieved?></td>
                                                        <!-- <td><?=$md->rremark?><hr><?=$md->star?> Star</td> -->
                                                    </tr>
                                                    <?php $i++;} ?>
                                                </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </form>            <!--END OF FORM ^^-->
                            </fieldset>
                            
                        </div>
                    </div>
                </div></div></div>
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
      "responsive": false, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
<script>
    // Assuming $count is the PHP variable containing your data array
    const count = <?php echo json_encode($getCountData); ?>;
    
    // Define chart data and configuration
    const data = {
        labels: Object.keys(count[0]),
        datasets: [{
            data: Object.values(count[0]),
            backgroundColor: [
                '#FF5733', '#33FF57', '#3357FF', '#F3FF33', '#FF33A8', '#8E44AD',
                '#3498DB', '#F1C40F', '#B9B9B9', '#C7D3C6','#2ECC71','#E74C3C',
            ]
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Your Chart Title Here' // Add an appropriate title
                }
            }
        },
    };

    // Render the chart
    window.onload = function() {
        const ctx = document.getElementById('TaskChart').getContext('2d');
        new Chart(ctx, config);
    };
</script>
</body>
</html>