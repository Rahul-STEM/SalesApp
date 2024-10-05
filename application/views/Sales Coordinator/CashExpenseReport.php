<?php date_default_timezone_set("Asia/Calcutta"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="wi$dth=device-wi$dth, initial-scale=1">
    <title>Cash Expense Report | STEM APP | WebAPP</title>
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
      
img.billesimage {
    padding: 5px;
    border: 1px solid cadetblue;
    box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
    padding: 3px;
    margin: 4px;
  }

  .cat1{background:#effaf8!important}.cat2{background:#fef2f4!important}.cat3{background:#fffaef!important}.cat4{background:#eefbf5!important}.cat5{background:#f7f3ff!important}.cat6{background:#fff7ef!important}.cat7{background:#f1fbff!important}.cat8{background:#fff0f8!important}

td.billtd {
    display: flex;
}
td.billtd a{
padding: 4px;
}

    </style>
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php require('nav.php');?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if ($this->session->flashdata('success_message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong> <?php echo $this->session->flashdata('success_message'); ?></strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php endif; ?>
            <?php
              if ($this->session->flashdata('error_message')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong> <?php echo $this->session->flashdata('error_message'); ?></strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header bg-info">
                    <h3 class="text-center">
                      <center><b>Cash Expense Details</b></center>
                    </h3>
                  </div>
                </div>
              </div>
            </div>
            <?php //dd($cashexpenseData); ?>
            <div class="table-responsive">
              <table id="exampledata" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Expense</th>
                    <th scope="col">Bills</th>
                    <th scope="col">Verify</th>
                    <th scope="col">Verify By</th>
                    <!-- <th scope="col">View Details</th> -->
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $j =1;$k=1;
                    foreach($cashexpenseData as $data){
                      
                      if($j==8){
                        $k=1;
                      }


                      ?>
                  <tr class="cat<?=$k;?>">
                    <th><?= $j ?></th>
                    <td><?= $data->name ?></td>
                    <td><?= $data->created_at ?></td>
                    <td><?= $data->compname ?></td>
                    <td><?= $data->expense ?> ₹ </td>
                    <td class="billtd">
                      <?php 
                    $bills = $data->bills;
                    $decodedArray = json_decode($bills, true);
                    foreach($decodedArray as $bill){ 
                    
                    $fileUrl = base_url().$bill;
                    $fileExtension = pathinfo($fileUrl, PATHINFO_EXTENSION);
                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                      if (@getimagesize($fileUrl)) { ?>
                      
                          <img  onclick="ViewBills(<?= $j ?>,'<?= $fileUrl; ?>')" src="<?= $fileUrl ?>" width="100px" height="100px" class="billesimage" alt="Image">
                      
                     <?php } else {
                          echo 'Image not found or not accessible.';
                      }
                      } elseif ($fileExtension === 'pdf') { ?>
                          <iframe src="<?= $fileUrl ?>" width="100px" height="100px" class="billesimage"></iframe>
                     <?php } else {
                          echo 'The file is neither an image nor a PDF.';
                      }
                    ?>
                   <?php } ?>
                     </td>
                    <td>
                      <?php
                        if($data->verify == 0){ ?>
                      <span class="p-1 bg-warning mr-2">Pending</span>
                      <?php }else if($data->verify == '1'){ ?>
                      <span class="p-1 bg-success mr-2">Approved</span>
                      <?php }elseif($data->verify == '2'){ ?>
                      <span class="p-1 bg-danger mr-2">Rejected</span>
                      <?php }?>
                    </td>
                    <td>
                      <?php
                        if($data->verify_by == 0){ ?>
                      <span class="p-1 bg-warning mr-2">Pending</span>
                      <?php }else if($data->verify_by !== ''){ ?>
                    <?= $this->Menu_model->get_userbyid($data->verify_by)[0]->name ?>
                    <?php }?>
                    </td>
                    <!-- <td>
                      <p><a href="<?=base_url();?>Menu/ViewMeetingExpenseDetails/<?= $data->id?>/">View</a></p>
                    </td> -->
                    <td>
                      <?php
                        if($data->verify == 0){ ?>
                      <div>
                        <p><a href="<?=base_url();?>Menu/CashExpenseApproved/<?= $data->id?>" class="btn btn-success mr-2" onclick="return confirm('Are you sure you want to Approved it?');" >Approve</a></p>
                        <p><button type="button" class="btn btn-danger"  onclick="Reject(<?= $j ?>,<?= $data->id?>,'Reject')">Reject</button></p>
                      </div>
                      <?php }else if($data->verify == '1'){ ?>
                      <span class="p-1 bg-success mr-2">Approved</span>
                      <?php }if($data->verify == '2'){ ?>
                      <span class="p-1 bg-danger mr-2">Rejected</span>
                      <?php }?>
                    </td>
                  </tr>
                  <?php $j++;$k++; } ?>
                </tbody>
              </table>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Bills</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <a href="" id="viewbillimageatag">
                    <img src="" id="viewbillimage" class="img-fluid" alt="">
                    <iframe src="" id="pdfViewer" class="billesimage"></iframe>
                  </a>
                  </div>
                </div>
              </div>
            </div>
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
                            <form action="<?=base_url();?>Menu/CashExpenseReject" method="post" >
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
          </div>
      </div>
    </div>
    </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type='text/javascript'>
        function ViewBills(rid,fileUrl){

          var fileExtension = fileUrl.split('.').pop().toLowerCase(); 
          if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
              $('#viewbillimage').attr('src', fileUrl).show();
              $('#viewbillimageatag').attr('href', fileUrl).show();
          } else if (fileExtension === 'pdf') {
              $('#pdfViewer').attr('src', fileUrl).show();
              $('#viewbillimageatag').attr('href', fileUrl).show();
          } else {
              alert('The file is neither an image nor a PDF.');
          }
          $('#exampleModalCenter').modal('show');
        }
        
        function Reject(mid,id,val){
        $('#exampleModalCenterdata').modal('show');
        $('#rejectid').val(id);
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
      $("#exampledata").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      "buttons": [ "excel", "pdf"]
      }).buttons().container().appendTo('#exampledata_wrapper .col-md-6:eq(0)');
    </script>
  </body>
</html>