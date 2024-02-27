<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Demo</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>assets/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url();?>assets/css/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url();?>assets/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">

<a href="main">Home Page</a>

<div class="card p-5">
   <lable>STATE</lable>
   <select class="form-control">
       <option value="">Select State</option>
       <?php $gstate=$this->Menu_model->get_gstate();
       foreach($gstate as $gs){?>
       <option value="<?=$gs->id?>"><?=$gs->name?></option>
       <?php } ?>
   </select>
   <lable>DISTRICT</lable>
   <select class="form-control">
       <option>1</option>
   </select>
   <lable>TEHSIL</lable>
   <select class="form-control">
       <option>1</option>
   </select>
   <lable>R.I.</lable>
   <select class="form-control">
       <option>1</option>
   </select>
   <lable>VILLAGE</lable>
   <select>
       <option>1</option>
   </select>
   <input type="text" placeholder="KHASARA NUMBER"  class="form-control">
   <input type="text" placeholder="AREA IN HECTARE"  class="form-control">
   <input type="text" placeholder="AREA IN ACRE"  class="form-control">
   <lable>LAND TYPE</lable>
   <select class="form-control">
       <option>1</option>
   </select>
   <input type="text" placeholder="LAND USE"  class="form-control">
   <input type="text" placeholder="OWNER NAME"  class="form-control">
   <input type="text" placeholder="REMARKS"  class="form-control">
   <lable>Google </lable>
   <input type="file"  class="form-control">
</div>

    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type='text/javascript'>

$('#nextpurpose').on('change', function g() {
var purpose_id = document.getElementById("nextpurpose").value;
$.ajax({
url:'<?=base_url();?>Menu/actionremark',
type: "POST",
data: {
purpose_id: purpose_id
},
cache: false,
success: function a(result){
$("#next_action_remark").html(result);
}
});
});
</script>
<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>
</html>
