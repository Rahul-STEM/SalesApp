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
            <h1 class="m-0">Team Work</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <h4><?php $uid=$user['user_id']; ?></h4>
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
              <div class="card-header">
                <h3 class="text-center"><center><b>Task Detail <br>(from <?=$sd?> to <?=$ed?>)</b></center></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <div class="container body-content">
        <div class="page-header">
            <fieldset>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <div class="pdf-viwer">
                                    <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>BD Name</th>
                                            <th>Total Task Assign/Planned</th>
                                            <th>Total Task Pending</th>
                                            <th>Total Task Completed</th>
                                            <th>Call Assign/Planned</th>
                                            <th>Call Pending</th>
                                            <th>Call Completed</th>
                                            <th>Email Assign/Planned</th>
                                            <th>Email Pending</th>
                                            <th>Email Completed</th>
                                            <th>Scheduled Meeting Assign/Planned</th>
                                            <th>Scheduled Meeting Pending</th>
                                            <th>Scheduled Meeting Completed</th>
                                            <th>Barg in Meeting Assign/Planned</th>
                                            <th>Barg in Meeting Pending</th>
                                            <th>Barg in Meeting Completed</th>
                                            <th>Whatsapp Assign/Planned</th>
                                            <th>Whatsapp Pending</th>
                                            <th>Whatsapp Completed</th>
                                            <th>MOM Assign/Planned</th>
                                            <th>MOM Pending</th>
                                            <th>MOM Completed</th>
                                            <th>Proposal Assign/Planned</th>
                                            <th>Proposal Pending</th>
                                            <th>Proposal Completed</th>
                                            <th>Action Taken Yes</th>
                                            <th>Action Taken No</th>
                                            <th>Purpose Achieved Yes</th>
                                            <th>Purpose Achieved No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        
                                        $bd = $this->Menu_model->get_userbyaaid($uid);
                                        foreach($bd as $bd){
                                        $bdname = $bd->name;
                                        $bdid = $bd->user_id;
                                        $bdtd = $this->Menu_model->get_bwdtotaltd($bdid,$sd,$ed);
                                        foreach($bdtd as $ttd){
                                        if($ttd->a!=0){
                                        ?>
                                    <tr>
                                        <td><a href="<?=base_url();?>/Menu/BDTaskDetail/<?=$sd?>/<?=$ed?>/<?=$bdid?>"><?=$bdname?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/4/<?=$bdid?>/1/<?=$sd?>/<?=$ed?>/1"><?=$ttd->a?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/5/<?=$bdid?>/1/<?=$sd?>/<?=$ed?>/1"><?=$ttd->b?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/6/<?=$bdid?>/1/<?=$sd?>/<?=$ed?>/1"><?=$ttd->c?></a></td> 
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/1/<?=$bdid?>/1/<?=$sd?>/<?=$ed?>/1"><?=$ttd->d?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/2/<?=$bdid?>/1/<?=$sd?>/<?=$ed?>/1"><?=$ttd->e?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/3/<?=$bdid?>/1/<?=$sd?>/<?=$ed?>/1"><?=$ttd->d-$ttd->e?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/1/<?=$bdid?>/2/<?=$sd?>/<?=$ed?>/1"><?=$ttd->f?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/2/<?=$bdid?>/2/<?=$sd?>/<?=$ed?>/1"><?=$ttd->g?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/3/<?=$bdid?>/2/<?=$sd?>/<?=$ed?>/1"><?=$ttd->f-$ttd->g?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/1/<?=$bdid?>/3/<?=$sd?>/<?=$ed?>/1"><?=$ttd->h?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/2/<?=$bdid?>/3/<?=$sd?>/<?=$ed?>/1"><?=$ttd->i?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/3/<?=$bdid?>/3/<?=$sd?>/<?=$ed?>/1"><?=$ttd->h-$ttd->i?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/1/<?=$bdid?>/4/<?=$sd?>/<?=$ed?>/1"><?=$ttd->j?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/2/<?=$bdid?>/4/<?=$sd?>/<?=$ed?>/1"><?=$ttd->k?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/3/<?=$bdid?>/4/<?=$sd?>/<?=$ed?>/1"><?=$ttd->j-$ttd->k?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/1/<?=$bdid?>/5/<?=$sd?>/<?=$ed?>/1"><?=$ttd->l?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/2/<?=$bdid?>/5/<?=$sd?>/<?=$ed?>/1"><?=$ttd->m?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/3/<?=$bdid?>/5/<?=$sd?>/<?=$ed?>/1"><?=$ttd->l-$ttd->m?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/1/<?=$bdid?>/6/<?=$sd?>/<?=$ed?>/1"><?=$ttd->n?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/2/<?=$bdid?>/6/<?=$sd?>/<?=$ed?>/1"><?=$ttd->o?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/3/<?=$bdid?>/6/<?=$sd?>/<?=$ed?>/1"><?=$ttd->n-$ttd->o?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/1/<?=$bdid?>/7/<?=$sd?>/<?=$ed?>/1"><?=$ttd->p?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/2/<?=$bdid?>/7/<?=$sd?>/<?=$ed?>/1"><?=$ttd->q?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/3/<?=$bdid?>/7/<?=$sd?>/<?=$ed?>/1"><?=$ttd->p-$ttd->q?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/7/<?=$bdid?>/7/<?=$sd?>/<?=$ed?>/1"><?=$ttd->r?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/8/<?=$bdid?>/7/<?=$sd?>/<?=$ed?>/1"><?=$ttd->s?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/10/<?=$bdid?>/7/<?=$sd?>/<?=$ed?>/1"><?=$ttd->t?></a></td>
                                        <td><a href="<?=base_url();?>/Menu/ATaskDetail/9/<?=$bdid?>/7/<?=$sd?>/<?=$ed?>/1"><?=$ttd->u?></a></td>
                                    </tr>
                                    <?php }}} ?>  
                                  </tbody>
                                </table> 
                            </div>
                        </div>
                    </form>            <!--END OF FORM ^^-->
                </fieldset>
            
        </div>
    </div></div></div></div>
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
</body>
</html>