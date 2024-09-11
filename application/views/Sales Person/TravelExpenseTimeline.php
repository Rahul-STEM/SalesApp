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
.main-timeline{ font-family: 'Poppins', sans-serif; }
.main-timeline:after{
    content: '';
    display: block;
    clear: both;
}
.main-timeline .timeline{
    width: calc(50% - 1px);
    padding: 3px 0;
    margin: 0 2px 0 0;
    float: left;
}
.main-timeline .timeline-content{
    color: #777;
    background-color: #fff;
    text-align: center;
    padding: 20px 60px 20px 0;
    display: block;
    position: relative;
    padding:10px;
}
.main-timeline .timeline-content:hover{ text-decoration: none; }
.main-timeline .timeline-content:before{
    content: '';
    background: #629BDD;
    width: 40px;
    transform: skewY(-20deg);
    position: absolute;
    right: -20px;
    top: 0;
    bottom: 0;
}
.main-timeline .timeline-year {
    color: #555;
    background-color: #629BDD;
    font-size: 25px;
    font-weight: 600;
    height: 100px;
    width: 100px;
    border-radius: 50%;
    transform: translateY(-50%);
    position: absolute;
    top: 50%;
    right: -50px;
    z-index: 1;
    align-items: center;
    justify-content: center;
    display: flex;
}
.main-timeline .timeline-year:before{
    content: '';
    background-color: #fff;
    border-radius: 50%;
    box-shadow: 5px 5px 7px rgba(0,0,0,0.4);
    position: absolute;
    left: 10px;
    right: 10px;
    top: 10px;
    bottom: 10px;
    z-index: -1;
}
.main-timeline .title{
    color: #629BDD;
    font-size: 22px;
    font-weight: 600;
    text-transform: capitalize;
    letter-spacing: 0.5px;
    margin: 0 0 5px;
}
.main-timeline .description{
    font-size: 14px;
    letter-spacing: 1px;
    line-height: 22px;
    margin: 0;
}
.main-timeline .timeline:nth-child(even){ float: right; }
.main-timeline .timeline:nth-child(even) .timeline-content{ padding: 20px 0 20px 60px; }
.main-timeline .timeline:nth-child(even) .timeline-content:before{
    right: auto;
    left: -20px;
}
.main-timeline .timeline:nth-child(even) .timeline-year{
    right: auto;
    left: -50px;
}
.main-timeline .timeline:nth-child(4n+2) .timeline-content:before,
.main-timeline .timeline:nth-child(4n+2) .timeline-year{
    background: #345DAC;
}
.main-timeline .timeline:nth-child(4n+2) .title{ color: #345DAC; }
.main-timeline .timeline:nth-child(4n+3) .timeline-content:before,
.main-timeline .timeline:nth-child(4n+3) .timeline-year{
    background: #BC6ADC;
}
.main-timeline .timeline:nth-child(4n+3) .title{ color: #BC6ADC; }
.main-timeline .timeline:nth-child(4n+4) .timeline-content:before,
.main-timeline .timeline:nth-child(4n+4) .timeline-year{
    background: #ba2574;
}
.main-timeline .timeline:nth-child(4n+4) .title{ color: #ba2574; }
@media screen and (max-width:767px){
    .main-timeline .timeline,
    .main-timeline .timeline:nth-child(even){
        width: 100%;
        margin: 0 0 2px;
    }
    .main-timeline .timeline-content,
    .main-timeline .timeline:nth-child(even) .timeline-content{
        padding: 20px 0 20px 120px;
    }
    .main-timeline .timeline-content:before,
    .main-timeline .timeline:nth-child(even) .timeline-content:before{
        left: 30px;
    }
    .main-timeline .timeline-year,
    .main-timeline .timeline:nth-child(even) .timeline-year{
        left: 0;
        right: auto;
    }
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
  <div class="content-wrapper" style="background: navy;">
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
        <div class="card text-center" style="background:#fff200;color:black;">
            <h3 class="p-2 text-uppercase">Travel Advance Tracking</h3>
        </div>
      <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main-timeline">

            <?php for($i=1;$i<= 3; $i++){
                if($i ==1){
                    $title = "CLUSTER MANAGER";
                }
                if($i ==2){
                    $title = "ADMIN";
                }
                if($i ==3){
                    $title = "ACCOUNT";
                }
                
                ?>
                <div class="timeline">
                    <a href="#" class="timeline-content">
                        <div class="timeline-year"><?= $i; ?></div>
                        <h3 class="title"><?= $title; ?></h3>
                        <p class="description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer males uada tellus lorem, et condimentum neque commodo Integer males uada tellus lorem, et condimentum neque commodo
                        </p>
                    </a>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<br>
    <br>

    <br>
        </div>
        </div>
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
      "responsive": false, "lengthChange": false, "autoWi$dth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appen$dto('#example1_wrapper .col-md-6:eq(0)');
</script>
</body>
</html>