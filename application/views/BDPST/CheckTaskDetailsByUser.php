<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="wi$dth=device-wi$dth, initial-scale=1">
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
                <h4 class="m-0"> <i>Plan Task Details</i> </h4>
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
                      <div class="col-12">
                    
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
                              <form method="post" action="<?=base_url();?>Menu/approveDailyTask">
                              <fieldset>
                                 <div class="card">
                                
                                 <div class="taskaprroveform text-right">
                                  <input type="hidden" name="suser" value="<?=$tuser_uid;?>" >
                                    <select class="form-control form-select formselect" aria-label="Default select example" name="status" style="width:300px;" >
                                      <option selected value="select" >Select Approve/Reject</option>
                                      <option value="Approve">Approve</option>
                                      <option value="Reject">Reject</option>
                                    </select>
                                    <button class="btn btn-primary m-2" type="submit" >Submit</button>
                                 </div>
                                 <hr>
                                
                                    <div class="text-center p-2 bg-info">
                                       <h5><i>Task Plan By - 
                                        <?php  
                                        $udetail = $this->Menu_model->get_userbyid($tuser_uid);
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
                                            <th>Task Work Status</th>
                                            <th>Actions</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                    <?php 
                                    $i=1;
                                    $totalttaskdata =$this->Menu_model->get_totaltdetails($tuser_uid,$taskdate);
                                    //  echo "<pre>";
                                    //   print_r($totalttaskdata);
                                    //   die;
                            // if(sizeof($totalttaskdata) == 0){
                            //     $totalttaskdata = [];
                            // }
                          
                                    foreach($totalttaskdata as $taskdata){ 
                                       
                                        // if($task->plan == 1){
                                        $taid = $taskdata->actiontype_id;
                                        $taid=$this->Menu_model->get_actionbyid($taid);
                                        $time = $taskdata->appointmentdatetime;
                                        $reminder = $taskdata->reminder;
                                        $rimby = $taskdata->reminderby;
                                        $rimat = $taskdata->reminderat;
                                        $rimbyname = $this->Menu_model->get_userbyid($rimby);
                                        $time = date('h:i a', strtotime($time));
                                    ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td> <?= $taskdata->compname ?></td>
                                         
                                            <td> <?= $taid[0]->name ?></td>
                                            <td> <span class="p-3" style="color:<?=$taskdata->color?>;"><?=$taskdata->name?></span></td>
                                            <td> <?=$time?></td>
                                        
                                            <td> <?= $taskdata->appointmentdatetime ?></td>
                                            <td> <?= $taskdata->selectby ?></td>
                                            <td>
                                            <span class="p-1 bg-warning mr-2">Pending</span>
                                            </td>
                                            <td> 
                                              <!-- <div>
                                                <p><a href="<?=base_url();?>Menu/plannertaskApproved/<?= $brg->id?>/Approve" class="btn btn-success mr-2" onclick="return confirm('Are you sure you want to Approved it?');" >Approve</a></p>
                                                <p><button type="button" class="btn btn-primary"  onclick="Reject(<?= $j ?>,<?= $brg->id?>,'Reject')">Reject</button></p>
                                              </div> -->

                                              <div>
                                                <input type="checkbox" id="scales" value="<?= $taskdata->id?>" name="tid[]" />
                                              </div>
                                            </td>
                                         </tr>
                                           <?php 
                                        $i++; } ?>
                                        <?php
                                        $j = $i;
                                            $barg=$this->Menu_model->get_bargdetail1($tuser_uid,$taskdate);
                                            $bl=0;
                                            foreach($barg as $brg):
                                                // echo "<pre>";
                                                // print_r($brg);
                                                
                                                $bs = $brg->status;
                                                $cid = $brg->cid;
                                                $cd = $this->Menu_model->get_cdbyid($cid); 
                                               
                                            if($bs=='Pending'){ 
                                                $time1 = date('h:i a', strtotime($brg->storedt));
                                                ?>
                                            <tr>
                                                <td> <?=$j?></td>
                                                <td> <?=$cd[0]->compname?></td>
                                                <td>Visit Meeting</td>
                                                <td>
                                                <?php if (!empty($cd[0]->city)) { echo $cd[0]->city . ' | '; } ?>
                                                <?php if (!empty($cd[0]->state)) { echo $cd[0]->state; } ?>
                                                </td>
                                                <td>
                                                <?= $time1 ?>
                                                </td>
                                                <td> <?=$brg->storedt?></td>
                                                <td>
                                                  <!-- <span class="p-1 bg-warning mr-2">Pending</span> -->
                                                </td>

                                                <td> 
                                            <span class="p-1 bg-warning mr-2">Pending</span>
                                            </td>
                                              <td>
                                              <div>
                                                <input type="checkbox" id="scales" value="<?= $taskdata->id?>" name="tid[]" />
                                              </div>
                                              </td>


                                            </tr>
                                        <?php $j++; } endforeach; ?>
                                    
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </fieldset>
                               
                                 </form>
                                
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
              $("#example1").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,
              "buttons": ["csv", "excel", "pdf", "print"]
              }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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
              </script>
            </body>
          </html>