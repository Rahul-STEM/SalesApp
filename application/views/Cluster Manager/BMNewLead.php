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
  <?php require('addlog.php');?>
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
              <h4><?php $uid=$user['user_id']?></h4>
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
          <div class="col-lg-12 col-md-12 col-12 m-auto">
            <!-- Default box -->
            <div class="card card-primary">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body box-profile p-5">
              <!-- form start -->
            <form method="post" action="<?=base_url();?>Menu/addbmcompany">
                <input type="hidden" name="uid" value="<?=$uid?>">
                <input type="hidden" name="bmid" value="<?=$bmid?>">
                   <input type="hidden" name="cid" value="<?=$bmdata[0]->cid?>">
                   <input type="hidden" name="ccid" value="<?=$bmdata[0]->ccid?>">
                   <input type="hidden" name="inid" value="<?=$bmdata[0]->inid?>">
                   <input type="hidden" name="tid" value="<?=$bmdata[0]->tid?>">
            <div class="form-row">
              <div class="col-sm-12 col-lg-6 p-3">
                <div class="was-validated">
                    <div class="form-row">
                        <div class="col-12 col-md-12">
                            <label for="validationSample01">Company Name</label>
                            <input type="text" class="form-control"  placeholder="Company Name" value="<?=$bmdata[0]->compname?>" required=""  id="compname" name="compname" >
                            <div class="invalid-feedback">Please provide a Company name.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample02">Website Link</label>
                            <input type="text" class="form-control" id="website" placeholder="Website Link" name="website"  required="">
                            <div class="invalid-feedback">Please provide a company's website.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample03">Country</label>
                            <select type="text" class="form-control" id="country" name="country" placeholder="City" required="">
                                <option value="1" selected>India</option>
                            </select>
                            <div class="invalid-feedback">Please provide a valid city.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample04">State</label>
                            <select name="state" id="id_state" required class="form-control">
                                <option value="">Select State</option>
                                <?php foreach($states as $st){?>
                                    <option value="<?=$st->id?>"><?=$st->state?></option>
                                <?php }?>
                            </select>
                            <div class="invalid-feedback">Please provide a valid state.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample04">District</label>
                            <select id="city" class="form-control" name="city" required>
                            </select>
                            <div class="invalid-feedback">Please provide a valid city.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                        <div class="col-12 col-md-12">
                            <label for="validationSample01">Draft <sup>optional</sup></label>
                            <textarea type="text" name="draft" id="draft" class="form-control"  placeholder="Draft" ></textarea>
                        </div>
                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample02">Address</label>
                            <textarea class="form-control" name="address" id="address" placeholder="Full Address" value="<?=$bmdata[0]->address?>" required=""></textarea>
                            <div class="invalid-feedback">Please provide a company's address.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
              </div>
              <div class="col-sm-12 col-lg-6 p-3">
                <div class="was-validated">
                    <div class="form-row">
                    <div class="col-12 col-md-12 mb-12">
                        <label for="validationSample02">Company Type</label>
                        <select id="ctype" name="ctype" class="form-control" required>
                            <option value="">Select Partner Type</option>
                            <?php foreach($partner as $p){?>
                                <option value="<?=$p->id?>"><?=$p->name?></option>
                            <?php }?>
                        </select>
                        <div class="invalid-feedback">Please provide a valid Company Type.</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                     <div class="col-12 col-md-12" id="budgetdiv">
                        <label for="validationSample01">Budget</label>
                            <input type="text" name="budget" class="form-control" id="budget" placeholder="Budget" value="" required=""  >
                        <div class="invalid-feedback">Please provide a Company's budget.</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-md-12">
                            <label for="validationSample01">Contact person name</label>
                                <input type="text" class="form-control"  placeholder="Contact person name" value="<?=$bmdata[0]->contactperson?>" required=""  id="contactperson" name="compconname" >
                            <div class="invalid-feedback">Please provide a contact person name.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="form-row">
                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample01">Designation</label>
                            <input type="text" name="designation" class="form-control" id="designation" placeholder="Designation" value="<?=$bmdata[0]->designation?>" required=""  >
                            <div class="invalid-feedback">Please provide a designation.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample02">Email ID</label>
                            <input type="email" class="form-control" id="emailid" placeholder="Email Id" value="<?=$bmdata[0]->emailid?>" name="emailid"  required="">
                            <div class="invalid-feedback">Please provide a email id.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample03">Mobile Number</label>
                            <input type="number" minlength="10" maxlength="10"  class="form-control" id="phoneno" value="<?=$bmdata[0]->phoneno?>" name="phoneno" placeholder="Mobile Number" required="">
                            <div class="invalid-feedback">Please provide a valid number.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                <div class="col-12 col-md-12">
                <label for="validationSample01">Top Spender</label> &nbsp;
                <input
                  type="radio"
                  name="top_spender"
                  value="yes"
                  required=""
                />
               YES
                <input
                  type="radio"
                  name="top_spender"
                  value="no"
                  required=""
                  checked
                />
                &nbsp;NO &nbsp;
                <div class="invalid-feedback">
                  Please provide a Company's budget.
                </div>
                <div class="valid-feedback">Looks good!</div>
              </div>
              </div>
              <div class="form-row">
                <div class="col-12 col-md-12" style="margin-top: 10px">
                <label for="validationSample01">Upsell Client</label> &nbsp;
                <input
                  type="radio"
                  name="upsell_client"
                  value="yes"
                  required=""
                />
                YES 
                <input
                  type="radio"
                  name="upsell_client"
                  value="no"
                  required=""
                  checked
                />
                &nbsp;NO &nbsp;
                <div class="invalid-feedback">
                  Please provide a Company's budget.
                </div>
                <div class="valid-feedback">Looks good!</div>
              </div>
              </div>
              <div class="form-row">
                <div class="col-12 col-md-12" style="margin-top: 10px">
                <label for="validationSample01">Focus Funnel</label> &nbsp;
                <input
                  type="radio"
                  name="focus_funnel"
                  value="yes"
                  required=""
                />
                YES
                <input
                  type="radio"
                  name="focus_funnel"
                  value="no"
                  required=""
                  checked
                />
                &nbsp;NO &nbsp;
                <div class="invalid-feedback">
                  Please provide a Company's budget.
                </div>
                <div class="valid-feedback">Looks good!</div>
              </div>
              
              
              
            </div>
            
          </div>
          <button class="btn btn-primary" type="submit">Submit</button>
        </form>
              
              
            </div>
            <!-- /.card -->
  </div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type='text/javascript'>

$('#currentStatus').on('change', function b() {
var sid = document.getElementById("currentStatus").value;
$.ajax({
url:'<?=base_url();?>Menu/getremark',
type: "POST",
data: {
sid: sid
},
cache: false,
success: function a(result){
$("#remarks").html(result);
}
});
});

$('#action_type').on('change', function b() {
var aid = document.getElementById("action_type").value;
var sid = document.getElementById("currentStatus").value;
$.ajax({
url:'<?=base_url();?>Menu/getpurpose',
type: "POST",
data: {
aid: aid,
sid: sid
},
cache: false,
success: function a(result){
$("#purpose").html(result);
}
});
});


$('#purpose').on('change', function b() {
var pid = document.getElementById("purpose").value;
$.ajax({
url:'<?=base_url();?>Menu/getnextaction',
type: "POST",
data: {
pid: pid
},
cache: false,
success: function a(result){
$("#next_action").html(result);
}
});
});


$('#id_state').on('change', function b() {
var stid = document.getElementById("id_state").value;
$.ajax({
url:'<?=base_url();?>Menu/getcity',
type: "POST",
data: {
stid: stid
},
cache: false,
success: function a(result){
$("#city").html(result);
}
});
});
function replaceBudget(){                    
    var budgetdiv= document.getElementById('budgetdiv');
    var id_partnerType= document.getElementById('id_partnerType').value;
    if(id_partnerType=="4"){
    budgetdiv.innerHTML='<label for="validationSample01">Category</label><select id="budget" class="form-control" name="budget" required><option>A</option><option>B</option><option>C</option></select>';    
    }
    alert('budget checking '+id_partnerType);
}
var id_partnerType=document.getElementById('id_partnerType');
id_partnerType.addEventListener("change", replaceBudget);


</script>
          
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    
    </div></div></div>
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