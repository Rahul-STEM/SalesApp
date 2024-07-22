<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STEM APP| WebAPP</title>
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
    <style>
      .ApprovedStatus{
      padding:6px 10px;
      border-radius:4px;
      }
      .ApprovedStatus.Pending{
      background:orange;
      color:white;
      }
      .ApprovedStatus.Reject{
      background:red;
      color:white;
      }
      .ApprovedStatus.approved{
      background:green;
      color:white;
      }
      .colapsboxsha{
          border-radius:22px;
         box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset; 
      }
      div.collapse.show{
          background-color:red!important;
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
        <section class="content">
          <div class="container-fluid">
            <div class="row p-3">
              <div class="col-sm col-md-12 col-lg-12 m-auto">
                <?php if ($this->session->flashdata('action_message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong> <?php echo $this->session->flashdata('action_message'); ?></strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php endif; ?>
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                    <?php  
                      $comcount = sizeof($revDatatar);
                      
                       
                       
                            //   echo "<pre>";
                            //   print_r($revDatatar);
                            //   die;
                      
                      
                      ?>
                    <!--<input type="hidden" id="compcount" value="<?=$comcount?>">-->
                    <!--<form  action="<?=base_url();?>Menu/startAnnualReview" method="post">-->
                      <input type="hidden" name="user_id" value="<?=$user['user_id']?>">
                      <div class="card p-2 bg-dark">
                        <center>
                          <h3>Annual Review Report</h3>
                        </center>
                      </div>
                      
                      <button class="btn btn-primary colapsboxsha col-md-12 col-lg-12 mt-2 d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#collapseExample22" aria-expanded="false" aria-controls="collapseExample">
                        Summary Of Report
                      </button>
                      <div class="collapse" id="collapseExample22">
                          <div class="card card-body">
                              <?php $getbdteam = $this->Menu_model->getTeamDetails($uid);
                            //   var_dump($getbdteam); exit;
                              ?>
                              <div class="table-responsive">
                                <table id="ourreview" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                    <tr>
                                      <th>sr. no</th>
                                      <th>User Name</th>
                                      <th>Total Companies</th>
                                      <th>Review Done</th>
                                      <th>Pending Review</th>
                                      <th>Cluster Manager Approve</th>
                                      <th>Cluster Manager Reject</th>
                                      <th>PST Approve</th>
                                      <th>PST Reject</th>
                                      <th>Total Admin Approved</th>
                                      <th>Total Admin Rejected</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $j=1;
                                        foreach($getbdteam as $t){
                                        $udata = $this->Menu_model->getReviewDetailsByUser($t->user_id,$t->type_id);
                                        // echo "<pre>";
                                        // print_r($udata );
                                        // die;
                                    ?>
                                    <tr>
                                      <td><?= $j++;?></td>
                                      <td><?=$t->name?></td>
                                      <td><?=$udata['totalcmp'][$t->user_id]?></td>
                                      <td><?=$udata['reviewDone'][$t->user_id]?></td>
                                      <td><?=abs($udata['totalcmp'][$t->user_id] - $udata['reviewDone'][$t->user_id])?></td>
                                      <td><?=$udata['cluster_approve'][$t->user_id]?></td>
                                      <td><?=$udata['cluster_reject'][$t->user_id]?></td>
                                      <td><?=$udata['pst_approve'][$t->user_id]?></td>
                                      <td><?=$udata['pst_reject'][$t->user_id]?></td>
                                      <td><?=$udata['approved'][$t->user_id]?></td>
                                      <td><?=$udata['rejected'][$t->user_id]?></td>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                                <!-- Modal -->
            
                              </div>
                          </div>
                        </div>
                        
                        <button class="btn btn-primary colapsboxsha col-md-12 col-lg-12 mt-2 d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#collapseExample90" aria-expanded="false" aria-controls="collapseExample">
                        Summary Of Financial year 2024-25
                      </button>
                      <div class="collapse" id="collapseExample90">
                          <div class="card card-body">
                              
                              <div class="table-responsive">
                                <table id="examplereview1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                    <tr>
                                      <th>sr. no</th>
                                      <th>User Name</th>
                                      <th>Top Spender</th>
                                      <th>Upsell Client</th>
                                      <th>Focus For Quarter 1</th>
                                      <th>Focus For Quarter 2</th>
                                      <th>Focus For Quarter 3</th>
                                      <th>Focus For Quarter 4</th>
                                      <th>Transfer Company</th>
                                      <th>Open</th>
                                      <th>Open RPM</th>
                                      <th>Total Companies</th>
                                      <th>Total Schools</th>
                                      <th>Total Revenue</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <?php $k=1;
                                        foreach($getbdteam as $t){
                                        $udata = $this->Menu_model->getReviewDetailsByUser($t->user_id,$t->type_id);
                                        // echo "<pre>";
                                        // print_r($udata);
                                    ?>
                                    <tr>
                                        <td><?=$k++?></td>
                                        <td><?=$t->name?></td>
                                        <td><a href="<?=base_url();?>Menu/newFinancialYearData/<?=$t->user_id?>/topspender"><?=$udata['topspender'][$t->user_id]?></a></td>
                                        <td><a href="<?=base_url();?>Menu/newFinancialYearData/<?=$t->user_id?>/upsell"><?=$udata['upsell'][$t->user_id]?></a></td>
                                        <td><a href="<?=base_url();?>Menu/newFinancialYearData/<?=$t->user_id?>/quarter1"><?=$udata['focusQuarter1'][$t->user_id]?></a></td>
                                        <td><a href="<?=base_url();?>Menu/newFinancialYearData/<?=$t->user_id?>/quarter2"><?=$udata['focusQuarter2'][$t->user_id]?></a></td>
                                        <td><a href="<?=base_url();?>Menu/newFinancialYearData/<?=$t->user_id?>/quarter3"><?=$udata['focusQuarter3'][$t->user_id]?></a></td>
                                        <td><a href="<?=base_url();?>Menu/newFinancialYearData/<?=$t->user_id?>/quarter4"><?=$udata['focusQuarter4'][$t->user_id]?></a></td>
                                        <td><a href="<?=base_url();?>Menu/newFinancialYearData/<?=$t->user_id?>/transfer"><?=$udata['keepcompany'][$t->user_id]?></a></td>
                                        <td><a href="<?=base_url();?>Menu/newFinancialYearData/<?=$t->user_id?>/open"><?=$udata['open'][$t->user_id]?></a></td>
                                        <td><a href="<?=base_url();?>Menu/newFinancialYearData/<?=$t->user_id?>/openrpm"><?=$udata['openrpm'][$t->user_id]?></a></td>
                                        <td><?=$udata['totalcmp'][$t->user_id]?></td>
                                        <td><?=number_format($udata['totalSchool'][$t->user_id])?></td>
                                        <td><?=number_format($udata['revenue'][$t->user_id])?></td>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                                <!-- Modal -->
            
                              </div>
                          </div>
                        </div>
                        
                        
                       
                        
                        
                      <div class="was-validated">
                        <div class="btn btn-primary colapsboxsha col-md-12 col-lg-12 mt-2 d-flex justify-content-between align-items-center" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                          Check Our Annual Company Report: 
                        </div>
                        <div class="collapse mt-3" id="collapseExample">
                          <div class="card card-body" style="background: azure;"  >
                            <div class="ApprovedStatus">
                              <!--<h4 class="ApprovedStatus Pending">Changes For Academic year 2024-24</h4> -->
                              <div class="table-responsive">
                                <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                    <tr>
                                      <th>sr. no</th>
                                      <th>Company Name</th>
                                      <th>Last Status</th>
                                      <th>Current Status</th>
                                      <th>Will be keeping this company with you?</th>
                                      <th>Remark why to not keeping company</th>
                                      <th>Did you have any face to face or virtual meeting with client?</th>
                                      <th>Cluster Name</th>
                                      <th>Focus And Positive Key Client For FY 2024-25</th>
                                      <th>Focus Lead For this Quarter 1?</th>
                                      <th>Top Spender For this Year?</th>
                                      <th>Is This Upsell Client?</th>
                                      <th> Do You Need Any Intervention or Support From ?</th>
                                      <th>What Support You Required In Detail?</th>
                                      <th> No of school</th>
                                      <th>Expected Revenue</th>
                                      <th>Current year Status</th>
                                      <th>Reachout</th>
                                      <th>Tentative</th>
                                      <th>Positive</th>
                                      <th>Very Positive</th>
                                      <th>Positive nap</th>
                                      <th>Closure</th>
                                      <th>Is First Approved</th>
                                      <th>First Approved By</th>
                                      <th>Is Admin Approved</th>
                                      <!--<th>Actions</th>-->
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $j=1; 
                                      foreach($revDatatar as $a){
                                      $companyStatus = $this->Menu_model->companyStatusInitcall($a->company_id);
                                      $revTarget = $this->Menu_model->companyannualreviewtarget($a->company_id,$a->user_id);
                                      // echo "<pre>";
                                      // print_r($revTarget);
                                      // die;
                                      $cstatus = $companyStatus->cstatus;
                                      $lstatus = $companyStatus->lstatus;
                                      $noofschools = $companyStatus->noofschools;
                                      
                                      $topspender = $companyStatus->topspender;
                                      $upsell_client = $companyStatus->upsell_client;
                                      $keycompany = $companyStatus->keycompany;
                                      $focus_funnel = $companyStatus->focus_funnel;
                                      
                                      $currentStatus = $this->Menu_model->get_statusbyid($cstatus);
                                      $currentStatusname = $currentStatus[0]->name; 
                                      
                                      $lastStatus = $this->Menu_model->get_statusbyid($lstatus);
                                      $lastStatusname = $lastStatus[0]->name; 
                                      
                                      ?>
                                    <tr>
                                      <td><?= $j; ?></td>
                                      <td>
                                        <a target="_BLANK" href="https://stemapp.in/Menu/AnnualReviewDetails/<?=$a->company_id ?>">
                                        <?=$this->Menu_model->get_cdbyid($a->company_id)[0]->compname .' - '.$a->company_id?> 
                                        </a>
                                      </td>
                                      <td><?= $lastStatusname ?></td>
                                      <td><?= $currentStatusname ?></td>
                                      <td><?= $revTarget->keep_company; ?></td>
                                      <td><?= $revTarget->keepremark; ?></td>
                                      <td><?php if($revTarget->keep_company == 'yes'){echo $revTarget->vmeeting; } ?></td>
                                      <td>
                                        <?php
                                          $revTarget->cluster_id;
                                          if($revTarget->cluster_id != 0){
                                             $clusterData = $this->Menu_model->getClusterByid($revTarget->cluster_id);
                                           echo $clusterData[0]->clustername;
                                          }else{
                                           //   echo "Not Select";
                                           echo $revTarget->cluster_id;
                                          }
                                          ?>
                                      </td>
                                      <td><?php if($revTarget->keep_company == 'yes'){ echo $revTarget->focuspositive;} ?></td>
                                      <td><?php if($revTarget->keep_company == 'yes'){ echo  $revTarget->focusfunnel;} ?></td>
                                      <td><?php if($revTarget->keep_company == 'yes'){ echo $revTarget->topspender;} ?></td>
                                      <td><?php if($revTarget->keep_company == 'yes'){ echo $revTarget->upsell;} ?></td>
                                      <td><?php if($revTarget->keep_company == 'yes'){
                                        $utype = $this->Menu_model->get_userbyid($revTarget->intervention);
                                        echo $utype[0]->name;}
                                        ?></td>
                                      <td><?=  $revTarget->support ?></td>
                                      <td><?=  $revTarget->noofschool ?></td>
                                      <td><?=  $revTarget->revenue ?> ₹ </td>
                                      <td><?= $this->Menu_model->get_statusbyid($revTarget->status)[0]->name ?></td>
                                      <td><?= $revTarget->reachout ?></td>
                                      <td><?= $revTarget->tentative ?></td>
                                      <td><?= $revTarget->positive ?></td>
                                      <td><?= $revTarget->very_positive ?></td>
                                      <td><?= $revTarget->positivenap ?></td>
                                      <td><?= $revTarget->closure ?></td>
                                      <td><?php 
                                        if($revTarget->is_approved == ''){ ?>
                                        <span class="p-2 bg-warning mr-2">Pending</span>
                                        <?php }else if($revTarget->is_approved == 'Approve'){ ?>
                                        <span class="p-2 bg-success mr-2">Approved</span>
                                        <?php }else{ ?>
                                        <span class="p-2 bg-danger mr-2">Reject</span><br>
                                        <div class="p-2 bg-info mt-3">Reject Reason - <?=$revTarget->reject_remark?></div>
                                        <?php }?>
                                      </td>
                                      <td>  
                                        <?php 
                                          if($revTarget->is_fapproved_name == ''){ ?>
                                        <span class="p-2 bg-warning mr-2">Pending</span>
                                        <?php }else{ ?>
                                        <span><?= $revTarget->is_fapproved_name ?></span>
                                        <?php } ?>
                                      </td>
                                      <td><?php
                                        if($revTarget->is_admin_approved == ''){ ?>
                                        <span class="p-2 bg-warning mr-2">Pending</span>
                                        <?php }else if($revTarget->is_admin_approved == 'Approve'){ ?>
                                        <span class="p-2 bg-success mr-2">Approved</span>
                                        <?php }else{ ?>
                                        <span class="p-2 bg-danger mr-2">Reject</span>
                                        <?php }?>
                                      </td>
                                      <!--<td>-->
                                      <!--  <div>-->
                                          <?php //if($revTarget->is_approved == ''){ ?>
                                      <!--    <p><a href="<?=base_url();?>Menu/firstApproveAnnualReview/<?= $a->id?>/Approve" class="btn btn-success mr-2">Approve</a></p>-->
                                          <!--<p><a href="<?=base_url();?>Menu/firstApproveAnnualReview/<?= $a->id?>/Reject" class="btn btn-danger">Reject</a></p>-->
                                      <!--      <p><a href="javascript:void(0)" onclick="RejectButton(<?= $j ?>,<?= $a->id?>,'Reject')" class="btn btn-danger">Reject</a></p>-->
                                        <?php// }else{?>
                                      <!--   <span class="p-2 bg-success mr-2">Done</span>-->
                                        <?php //} ?>
                                      <!--  </div>-->
                                      <!--</td>-->
                                    </tr>
                                    <?php  $j++; }?>
                                  </tbody>
                                </table>
                                <!-- Modal -->
            
                              </div>
                            </div>
                            <br>
                          </div>
                             
                          <!-- </div> -->
                        </div>
                        <br/>
                        <div class="bg-warning colapsboxsha text-center mt-2 mb-2">
                          <h3><i>Our Team Report</i></h3>
                        </div>
                        <?php
                        // echo $uid;
                          $getbdteam = $this->Menu_model->getTeamDetails($uid);
                          
                          ?>
                       
                             <div class="table-responsive">
                                <table id="examplereview1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                    <tr>
                                      <th>sr. no</th>
                                      <th>Name</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                   <?php
                                  $k=1;
                                  foreach($getbdteam as $bdteam){ 
                                    ?>
                                    <tr>
                                        <td><?=$k?></td>
                                        <td><?=$bdteam->name?></td>
                                        <td>
                                            <a href="<?=base_url();?>Menu/ShowCompanyReviewData/<?=$bdteam->user_id?>" target="_BLANK" >
                                                Click Here 
                                            </a>
                                            </td>
                                       
                                    </tr>
                                    <?php $k++; } ?>
                                  </tbody>
                                </table>
                                <!-- Modal -->
            
                              </div>
                     
                        
                      </div>
                    <!--</form>-->
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type='text/javascript'>
            function RejectButton(mid,id,val){
            $('#exampleModalCenter'+mid).modal('show');
            $('#exampleModalCenter'+mid+' #rejectid').val(id);
            }
            
            function Reject(mid,id,val){
                // alert(mid);
                $('#exampleModalCenterdata').modal('show');
                $('#rejectid').val(id);
            }
            
        </script>
        <!-- /.row (main row) -->
      </div>
      <!-- /.container-fluid -->
      <!-- </section> -->
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
      $( document ).ready(function() {
      var compcount = $("#compcount").val();
    //   alert(compcount);
      for(var i = 1; i <= compcount; i++)
      {
      var str = 'exampledata'+i+'_wrapper';
      $("#exampledata"+i).DataTable({
      "responsive": true, 
      "lengthChange": true, 
      "autoWidth": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "paging": true,
      "dom": 'Bfrtip', 
      "buttons": [
      'copy', 'csv', 'excel', 'pdf', 'print'
      ]
      }).buttons().container().appendTo('#'+str+' .col-md-6:eq(0)');
      }
      
      });
      
      
      $("#example1").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      
      $("#examplereview1").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#examplereview1_wrapper .col-md-6:eq(0)');
      
      $("#ourreview").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#ourreview_wrapper .col-md-6:eq(0)');
    </script>
  </body>
</html>