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
  <?php require('nav.php');?>
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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <button onclick="printPDF()" id="create_pdf">Download</button>
            <div class="abc p-3 m-3" id="abc" style="font: 15px Arial, sans-serif;color:black;">
        <div class="row">
            
            <div class="card">
                    <?php $users = $this->Menu_model->get_allactiveuserbyaid($uid);$tdate=date('Y-m-d');?>
                    <div class="card-header"><center><h5><b>Current Day Status Updated Task (<?=$tdate?>)</b></h5></center></div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <?php $mstatus = $this->Menu_model->get_status();foreach($mstatus as $status){?>
                                <th><?=$status->name;?></th>
                                <?php } ?>
                            </tr>
                            <?php foreach($users as $user){$username = $user->name;?>
                            <tr>
                                <td><?=$username?></td>
                                <?php $mstatus = $this->Menu_model->get_status();foreach($mstatus as $status){?>
                                <td>0</td>
                                <?php } ?>
                            </tr>
                            <?php }?>
                        </table>
                    </div>
                </div>
            </div>
            
            
          <div class="col-12">
              <?php  $mstatus = $this->Menu_model->get_status($uid);
                     foreach($mstatus as $status){
                         $sid = $status->id;
                         $sname = $status->name;
                     ?>
              <div class="card">
                  <div class="card-header"><center><h5><b>Task for <?=$sname?></b></h5></center></div>
                  <div class="card-body">
                      <?php foreach($users as $user){
                          $username = $user->name;
                          $userid = $user->user_id;
                          $ttbytime = $this->Menu_model->get_allusertaskbystatus($userid,$tdate,$sid); ?>
                      <div class="row">
                          <div class="col-lg-12 col-sm p-3 card">
                                <b><?=$username?></b>
                           </div>
                                      <?php 
                                          foreach($ttbytime as $tt){
                                          $taid = $tt->actiontype_id;
                                          $taid=$this->Menu_model->get_action($taid);
                                          $time = $tt->appointmentdatetime;
                                          $utime = $tt->updateddate;
                                          $itime = $tt->initiateddt;
                                          $nextCFID = $tt->nextCFID;
                                          $time = date('h:i a', strtotime($time));
                                          $utime = date('h:i a', strtotime($utime));
                                          $itime = date('h:i a', strtotime($itime));
                                          if($nextCFID=='0'){$color='bg-danger';$bcolor='border-danger';$itime='';$utime='';}
                                          if($nextCFID!='0'){$color='bg-success';$bcolor='border-success';}
                                          $txt="";
                                            $upsell_client= $tt->upsell_client;
                                            $focus_funnel= $tt->focus_funnel;
                                            $keycompany= $tt->keycompany;
                                            $pkclient= $tt->pkclient;
                                            $priorityc= $tt->priorityc;
                                            if($upsell_client=='yes'){$txt=$txt.'Upsell Client, ';}
                                            if($focus_funnel=='yes'){$txt=$txt.'Focus Funnel, ';}
                                            if($keycompany=='yes'){$txt=$txt.'Key Client, ';}
                                            if($pkclient=='yes'){$txt=$txt.'Positive Key Client, ';}
                                            if($priorityc=='yes'){$txt=$txt.'Priority Client, ';}
                                      ?>
                                  <div class="col-lg-2 col-sm p-1">
                                        <span class="flex card border <?=$bcolor?>">
                                            <div class="<?=$color?> p-2"><b>
                                            <?=$taid[0]->name?> (<?=$tt->ostatus?>) - (<?=$tt->nstatus?>)<br> 
                                            <?=$tt->compname?><br><?=$txt?></b></div>
                                            <div class="p-2"><b>
                                            Plan Time:- <?=$time?><br>
                                            Initiat Time:- <?=$itime?><br>
                                            Update Time:- <?=$utime?></b></div>
                                        </span>
                                   </div>
                                  <?php } ?>
                                  </div>
                      <hr>
                      <?php } ?>
                  </div>
              </div>
              
              <?php } ?>
              
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
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>  
<script>
$(document).ready(function () {
    
    var form = $('.abc'),  
    cache_width = form.width(),  
    a4 = [1280,720];
    $('#create_pdf').on('click', function () { 
        var element = document.getElementById('abc');
        element.style.display = 'block'
        $('body').scrollTop(0);  
        createPDF(); 
    });
     function createPDF() {
     getCanvas().then(function(canvas) {
       var imgWidth = 200;
       var pageHeight = 290;
       var imgHeight = canvas.height * imgWidth / canvas.width;
       var heightLeft = imgHeight;
       var doc = new jsPDF('p', 'mm');
       var position = 0;
       var img = canvas.toDataURL("image/png");
 doc.addImage(img, 'JPEG', 0, position, imgWidth, imgHeight);
   heightLeft -= pageHeight;
   while (heightLeft >= 0) {
     position = heightLeft - imgHeight;
     doc.addPage();
     doc.addImage(img, 'JPEG', 0, position, imgWidth, imgHeight);
     heightLeft -= pageHeight;
   }
   doc.save('Next-Day-Task.pdf');
   form.width(cache_width);
  });
 }
   function getCanvas() {
     form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
     return html2canvas(form, {
       imageTimeout: 2000,
       removeContainer: false
     });
   }
});
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
</body>
</html>