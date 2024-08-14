<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="wi$dth=device-wi$dth, initial-scale=1">

    <title>STEM APP | WebAPP</title>

    <!-- Google Font: Source Sans Pro -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">

    <!-- Font Awesome -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/all.min.css">

    <!-- Ionicons -->

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Tempusdominus Bootstrap 4 -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/tempusdominus-bootstrap-4.min.css">

    <!-- iCheck -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/icheck-bootstrap.min.css">

    <!-- JQVMap -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jqvmap.min.css">

    <!-- Theme style -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/adminlte.min.css">

    <!-- overlayScrollbars -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/OverlayScrollbars.min.css">

    <!-- Daterange picker -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/daterangepicker.css">

    <!-- summernote -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/summernote-bs4.min.css">

    <!-- DataTables -->

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/buttons.bootstrap4.min.css">

    <style>
        .scrollme {

            overflow-x: auto;

        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<?php 
// var_dump($mdata);die;
?>
    <div class="wrapper">
        <!-- Preloader -->

        <!-- Navbar -->

        <?php require ('nav.php'); ?>

        <!-- /.navbar -->
        <!-- Content Wrapper. Contains page content -->

        <div class="content-wrapper">

            <!-- Content Header (Page header) -->

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <!-- <div class="col-sm-12">
                            <form action="<?=base_url();?>Menu/BDDayDetail_New/<?=$tdate?>/1" method="POST" >
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>From Date</label>
                                            <input type="date" name="FromDate" id="FromDate">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>To Date</label>
                                            <input type="date" name="ToDate" id="ToDate">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div> 
                            </form>
                        </div> -->
                        <!-- /.col -->
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
                                    <p class="text-center text-secondary font-weight-bold">Team Detail</p>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="container body-content">
                                        <div class="col-sm-12">
                                            <form action="<?=base_url();?>Dashboard/BDDayDetail_New/<?=$tdate?>/<?=$code?>" method="POST" id="filterForm">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>From Date</label>
                                                            <input type="date" name="FromDate" id="FromDate" value="<?=$startDate?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>To Date</label>
                                                            <input type="date" name="ToDate" id="ToDate" value="<?=$endDate?>">
                                                            
                                                        </div>
                                                    </div>
                                                    <?php 
                                                    
                                                    
                                                    ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Select Role</label>
                                                            <select class="custom-select rounded-0" name="userType[]" id="userType" multiple>
                                                                <option value="select_all">Select All</option>
                                                                <?php foreach($roles as $r) {

                                                                ?>
                                                                <option value="<?= $r->id ?>"><?= $r->name ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Select User</label>
                                                            <select id="user" class="custom-select rounded-0" name="user[]" data-live-search="true" multiple>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="submit" class="btn btn-primary">Filter</button>
                                                    </div>
                                                    <!-- <div class="col-md-3">
                                                        <input type="hidden" name="clear" id="clear">
                                                        <button type="submit" class="btn btn-danger">Clear Filter</button>
                                                    </div> -->
                                                </div> 
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <p class="text-center text-secondary font-weight-bold">Team Details Graph View</p>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="container body-content">
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <canvas id="donutChart" style="width: 100%; height: 200px;"></canvas>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>BD Name</th>
                                                                <th>Work From</th>
                                                                <th>Date</th>
                                                                <th>Started Day @</th>
                                                                <th>Start selfie</th>
                                                                <th>Start Location</th>
                                                                <th>Start Review</th>
                                                                <th>Close Day @</th>
                                                                <th>Close selfie</th>
                                                                <th>Close Location</th>
                                                                <th>Close Review</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                $i=1;
                                                                foreach($mdata as $dt){
                                                                    // var_dump($dt);
                                                            ?>
                                                            <tr>
                                                                <td><?=$i?></td>
                                                                <td><?=$dt->bdname?></td>
                                                                <td>
                                                                    <?php 
                                                                    if($dt->wffo==1){echo 'Work From Office';}
                                                                    if($dt->wffo==2){echo 'Work From Field';}
                                                                    if($dt->wffo==3){echo 'Work From Field+Office';}?></td>
                                                                    <td><?= $dt->sdate?></td>
                                                                <td><?=$dt->start?></td>
                                                                <td>
                                                                    <img src="<?=base_url();?><?=$dt->usimg?>" alt="image not found" style="width:100px;" >
                                                                    <?php if($dt->usimg !== 'uploads/day/'){ ?>
                                                                    <a href="<?=base_url();?><?=$dt->usimg?>">Download</a>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <a href="https://www.google.com/maps?q=<?=$dt->slatitude?>,<?=$dt->slongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a>
                                                                </td>
                                                                <td><?=$dt->scomment?><hr><?=$dt->queans?></td>
                                                                <td><?=$dt->close?></td>
                                                                <td>
                                                                    <img src="<?=base_url();?><?=$dt->ucimg?>" alt="image not found" style="width:100px;" >
                                                                </td>
                                                                <td>
                                                                    <a href="https://www.google.com/maps?q=<?=$dt->clatitude?>,<?=$dt->clongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a>
                                                                </td>
                                                                <td><?=$dt->ccomment?><hr><?=$dt->queansc?></td>
                                                            </tr>
                                                            <?php $i++;} ?>
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

        <strong>Copyright &copy; 2021-2022 <a href="<?= base_url(); ?>">Stemlearning</a>.</strong>

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
    <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>

    <!-- jQuery UI 1.11.4 -->

    <script src="<?= base_url(); ?>assets/js/jquery-ui.min.js"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <script>

        $.widget.bridge('uibutton', $.ui.button)

    </script>

    <!-- Bootstrap 4 -->

    <script src="<?= base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>

    <!-- ChartJS -->

    <script src="<?= base_url(); ?>assets/js/Chart.min.js"></script>

    <!-- Sparkline -->

    <script src="<?= base_url(); ?>assets/js/sparkline.js"></script>

    <!-- JQVMap -->

    <script src="<?= base_url(); ?>assets/js/jquery.vmap.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/jquery.vmap.usa.js"></script>

    <!-- jQuery Knob Chart -->

    <!-- <script src="plugins/jquery-knob/jquery.knob.min.js"></script> -->

    <!-- daterangepicker -->

    <script src="<?= base_url(); ?>assets/js/moment.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/daterangepicker.js"></script>

    <!-- Tempusdominus Bootstrap 4 -->

    <script src="<?= base_url(); ?>assets/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Summernote -->

    <script src="<?= base_url(); ?>assets/js/summernote-bs4.min.js"></script>

    <!-- overlayScrollbars -->

    <script src="<?= base_url(); ?>assets/js/jquery.overlayScrollbars.min.js"></script>

    <!-- DataTables  & Plugins -->

    <script src="<?= base_url(); ?>assets/js/jquery.dataTables.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/dataTables.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/dataTables.responsive.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/dataTables.buttons.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/buttons.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/jszip.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/pdfmake.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/vfs_fonts.js"></script>

    <script src="<?= base_url(); ?>assets/js/buttons.html5.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/buttons.print.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/buttons.colVis.min.js"></script>

    <!-- AdminLTE App -->

    <script src="<?= base_url(); ?>assets/js/adminlte.js"></script>



    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

    <script src="<?= base_url(); ?>assets/js/dashboard.js"></script>



<script>

    $("#example1").DataTable({

        "responsive": false, "lengthChange": false, "autoWidth": false,

        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

</script>
<script>
    // Assuming $count is the PHP variable containing your data array
    const count = <?php echo json_encode($count); ?>;
    console.log(count);

    // Extract labels and data from the count array
    const labels = count.map(item => item.status_description);
    const dataValues = count.map(item => item.wffo_count);

    // Define chart data and configuration
    const data = {
        labels: labels,
        datasets: [{
            data: dataValues,
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56','#007bff', // Add more colors if there are more data points
            ],
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
        const ctx = document.getElementById('donutChart').getContext('2d');
        new Chart(ctx, config);
    };
</script>

<script>
    $(document).ready(function() {

        $("#userType").change(function(){
            // var selectedValues = $("#userType").val();
            // console.log(selectedValues);
            var selectedValues = $(this).val(); 
            if (selectedValues.includes('select_all')) {
            // Select all options
                $('#userType option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedValues = $('#userType option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();

                selectedValues = selectedValues.filter(function(value) {
                    return value !== null;
                });
            }
            // var selectedValues = $("#userType").val(); // Get selected values
            console.log(selectedValues);

            $.ajax({
                url: '<?=base_url();?>Dashboard/getRoleUser_New',
                type: 'POST', 
                data: {RoleId: selectedValues},
                success: function(response) {
                    // alert(response);
                $("#user").html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $("#user").change(function(){

            var selectedUser = $(this).val(); 
            if (selectedUser.includes('select_all')) {
            // Select all options
                $('#user option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedUser = $('#user option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();

                selectedUser = selectedUser.filter(function(value) {
                    return value !== null;
                });
            }
            // var selectedValues = $("#userType").val(); // Get selected values
            console.log(selectedUser);
        });
    });
</script>
</body>

</html>