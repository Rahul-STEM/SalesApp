
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Planner Task Details Page | STEM APP | WebAPP</title>
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
    .taskaprroveform.text-right {
    align-items: revert;
    justify-content: right;
    display: flex;
}
.formselect {
    margin-top: 10px;
}
span.tsby {
    background: bisque;
    padding: 1px 6px;
    margin-top: 4px;
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

            <?php if ($this->session->flashdata('success_message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong> <?php echo $this->session->flashdata('success_message'); ?></strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error_message')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong> <?php echo $this->session->flashdata('error_message'); ?></strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php endif; ?>

            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="m-0"> <i>Planned Task Status</i> </h4>
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
                <?php
                $bd = $this->Menu_model->get_userbyaid($uid);
                ?>
                <!-- Main content -->
                <section class="content">
                  <div class="container-fluid">
                    <div class="row">
                    <div class="col-md-4">
                    <form class="setpaldate" action="<?=base_url();?>Menu/UserTaskViewPage" method="post">
                      <input type="date" class="form-control m-2" name="adate" value="<?=$adate?>" required="" id="plandate"  max="<?= date('Y-m-d') ?>">
                      <input type="submit" class="btn btn-warning m-2" value="Set Date">
                    </form>
                    </div>
                    </div>  
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <div class="body-content">
                            <div class="page-header">
                            <?php 
                            // echo "<pre>";
                            // print_r($totalttaskdata);
                            // die;
                             ?>
                              <!-- <form method="post" action="<?=base_url();?>Menu/UserTaskViewPage"> -->
                              <!-- <input type="hidden" name="selected_date" id="selected_date" value="<?= $date ?>">
                              //<button class="btn btn-primary m-2" type="submit" >Submit</button> -->

                              <fieldset>
                                 <div class="card">
                                
                                    <div class="text-center p-2 bg-info">
                                       <h5><i>Task Planned By - 
                                        <?php  
                                        $udetail = $this->Menu_model->get_userbyid($uid);
                                        echo $udetail[0]->name;
                                       ?>  </i></h5>
                                       <p><i><b><?= $taskdate ?></b></i></p>
                                    </div>
                                    <br>
                                <div class="table-responsive">
                                  <div class="table-responsive">
                                    <div class="pdf-viwer">
                                        <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Sr. no</th>
                                                    <th>Company Name</th>
                                                    <th>Action Name</th>
                                                    <th>Status</th>
                                                    <th>Task Time</th>
                                                    <th>Task Appointment date time</th>
                                                    <th>Plan By</th>
                                                    <th>Filter By</th>
                                                    <th>Task Work Status</th>
                                                    
                                                    <th>Action Status</th>
                                                    <th>Approved/Rejected By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $i = 1;
                                                $selectDate = isset($selected_date) ? $selected_date: $date;
                                                 //echo"$selected_date";
                                                $totalttaskdata = $this->Menu_model->get_totalDetailsForTask($uid, $selectDate);

                                              // echo"<pre>totalttaskdata ";print_r($totalttaskdata);exit;

                                                foreach ($totalttaskdata as $taskdata) { 
                                                    $taid = $taskdata->actiontype_id;
                                                    $tblId = $taskdata->id;
                                                    $taid = $this->Menu_model->get_actionbyid($taid);
                                                    $time = $taskdata->appointmentdatetime;
                                                    $reminder = $taskdata->reminder;
                                                    $rimby = $taskdata->reminderby;
                                                    $rimat = $taskdata->reminderat;
                                                    $status = $taskdata->approved_status;
                                                    $approver = $taskdata->approved_by;
                                                    $filter_by = json_decode($taskdata->filter_by, true);
                                                    $selectby = $taskdata->selectby;
                                                    $selfAssign = $taskdata->self_assign;
                                                    $rimbyname = $this->Menu_model->get_userbyid($rimby);
                                                    $time = date('h:i a', strtotime($time));
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $taskdata->compname ?></td>
                                                    <td><?= $taid[0]->name ?></td>
                                                    <td><span class="p-3" style="color:<?= $taskdata->color ?>;"><?= $taskdata->name ?></span></td>
                                                    <td><?= $time ?></td>
                                                    <td><?= $taskdata->appointmentdatetime ?></td>
                                                    <td><?= $selectby ?></td>
                                                    <td>
                                                        <?php if (is_array($filter_by)) : ?>
                                                            <?php foreach ($filter_by as $key => $value) : ?>
                                                                <?= $key ?> - <?= $value ?><br>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><span class="p-1 bg-warning mr-2">Pending</span></td>
                                                  
                                                    
                                                      <td>
                                                          <span class="p-1 bg-<?= ($status == 1) ? 'success' : (($status === null) ? 'secondary' : 'danger')?> mr-2">
                                                          <?= ($status == 1) ? 'Approved' : (($status === null) ? 'No Action Taken' : 'Rejected'); ?>

                                                          </span>
                                                      </td>

                                                      <td><?php
                                                      $userData = $this->Menu_model->get_userbyid($approver);
                                                      $name = $userData[0]->name;
                                                      echo $name;
                                                       ?></td>
                                                      <td>
                                                      <?php if($selfAssign == 1){?>
                                                          <div>                                                         
                                                          <button type="button" class="btn btn-primary" onclick="window.location.href='<?= base_url(); ?>Menu/selfTaskAssignPage/<?= $tblId ?>'">Self Assign task</button>
                                                    
                                                          </div>
                                                        <?php }?>
                                                    </td>

                                                <?php $i++; }?>
                                                      
                                                </tr>
                                                <?php 
                                              
                                                $j = $i;
                                                $barg = $this->Menu_model->get_bargdetail1($tuser_uid, $taskdate);
                                                foreach ($barg as $brg) {
                                                    $bs = $brg->status;
                                                    $cid = $brg->cid;
                                                    $cd = $this->Menu_model->get_cdbyid($cid);
                                                    if ($bs == 'Pending') { 
                                                        $time1 = date('h:i a', strtotime($brg->storedt));
                                                ?>
                                                <tr>
                                                    <td><?= $j ?></td>
                                                    <td><?= $cd[0]->compname ?></td>
                                                    <td>Visit Meeting</td>
                                                    <td>
                                                        <?php if (!empty($cd[0]->city)) { echo $cd[0]->city . ' | '; } ?>
                                                        <?php if (!empty($cd[0]->state)) { echo $cd[0]->state; } ?>
                                                    </td>
                                                    <td><?= $time1 ?></td>
                                                    <td><?= $brg->storedt ?></td>
                                                    <td><span class="p-1 bg-warning mr-2">Pending</span></td>
                                                    <td>
                                                        <div>
                                                            <p><a href="<?= base_url(); ?>Menu/plannertaskApproved/<?= $brg->id ?>/Approve" class="btn btn-success mr-2" onclick="return confirm('Are you sure you want to Approve it?');">Approve</a></p>
                                                            <p><button type="button" class="btn btn-primary" onclick="Reject(<?= $j ?>,<?= $brg->id ?>,'Reject')">Reject</button></p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php 
                                                        $j++;
                                                    } 
                                                }
                                                ?>
                                            </tbody>
                                        </table>

                                    </div>
                                  </div>
                                </fieldset>
                               
                                 <!-- </form> -->
                                
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
                  <div class="modal fade" id="exampleModalCenterdata" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Add Reject Remark</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="<?=base_url();?>Menu/momReject" method="post" >
                            <input type="hidden" id="rejectid" value="" name="reject">
                            <div class="mb-3 mt-3">
                              <textarea id="rejectreamrk" name="rejectreamrk" cols="30" placeholder="Add Remark " class="form-control"  rows="4"></textarea>
                            </div>
                            <div class="form-group text-center">
                              <button type="submit" class="btn btn-success mt-2">Submit</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
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
                $(document).ready(function() {
                    $("#example1").DataTable({
                        "responsive": false, 
                        "lengthChange": false, 
                        "autoWidth": false,
                        "buttons": ["csv", "excel", "pdf", "print"],
                        "columnDefs": [
                            { "width": "200px", "targets": 0 },  // Change the width of the first column
                            { "width": "300px", "targets": 7 }   // Change the width of the second column
                            // Add more columns if needed
                        ]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                });
                </script>

              <script type='text/javascript'>
              function RejectButton(mid,id,val){
              $('#exampleModalCenter'+mid).modal('show');
              $('#exampleModalCenter'+mid+' #rejectid').val(id);
              }
              
              function Reject(mid,id,val){
              $('#exampleModalCenterdata').modal('show');
              $('#rejectid').val(id);
              }

              // function setSelectedDate(date) {
              // document.getElementById('selected_date').value = date;
              // }

              </script>

            <!-- <script>
                $(document).ready(function() {
                    $('#plandate').on('change', function() {
                        var selectedDate = $(this).val();
                       alert(selectedDate); return false;
                        $.ajax({
                            url: '<?= base_url(); ?>Menu/UserTaskViewPage',
                            type: 'POST',
                            data: selectedDate,
                            success: function(response) {
                                // Handle the response from the server
                                console.log('Data sent successfully');
                                // You can also update your page content here based on the response
                            },
                            error: function(error) {
                                // Handle any errors
                                console.log('Error in sending data');
                            }
                        });
                    });
                });
            </script> -->

            </body>
          </html>