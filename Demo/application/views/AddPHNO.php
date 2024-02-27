<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Demo</title>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  


<div class="card p-3 text-center">
  <form class="p-3" method="POST" action="phnoadd">
    <select id="stateid" class="form-control">
       <option value="">Select State</option>
       <?php foreach($state as $gs){?>
       <option value="<?=$gs->id?>"><?=$gs->name?></option>
       <?php } ?>
    </select>
    <select id="districtid" name="districtid" class="form-control"></select>
    <select id="tehsilid" name="tehsilid" class="form-control"></select>
    <select id="blockid" name="blockid" class="form-control"></select>
    <select id="riid" name="riid" class="form-control"></select>
    <lable>Patwari Halka No</lable>
    <input type="text" name="phno" class="form-control">
    <button type="submit" class="bg-primary text-light">Add</button>
</form>
</div>


    
    
    
    
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->


<script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type='text/javascript'>

$('#stateid').on('change', function g() {
var stateid = document.getElementById("stateid").value;
$.ajax({
url:'<?=base_url();?>Menu/statetodistrict',
type: "POST",
data: {
stateid: stateid
},
cache: false,
success: function a(result){
$("#districtid").html(result);
}
});
});

$('#districtid').on('change', function g() {
var districtid = document.getElementById("districtid").value;
$.ajax({
url:'<?=base_url();?>Menu/districttotehsil',
type: "POST",
data: {
districtid: districtid
},
cache: false,
success: function a(result){
$("#tehsilid").html(result);
}
});
});

$('#tehsilid').on('change', function g() {
var tehsilid = document.getElementById("tehsilid").value;
$.ajax({
url:'<?=base_url();?>Menu/tehsiltoblock',
type: "POST",
data: {
tehsilid: tehsilid
},
cache: false,
success: function a(result){
$("#blockid").html(result);
}
});
});

$('#blockid').on('change', function g() {
var blockid = document.getElementById("blockid").value;
$.ajax({
url:'<?=base_url();?>Menu/blocktori',
type: "POST",
data: {
blockid: blockid
},
cache: false,
success: function a(result){
$("#riid").html(result);
}
});
});


$('#riid').on('change', function g() {
var riid = document.getElementById("riid").value;
$.ajax({
url:'<?=base_url();?>Menu/ritophno',
type: "POST",
data: {
riid: riid
},
cache: false,
success: function a(result){
$("#phnoid").html(result);
}
});
});




$('#phnoid').on('change', function g() {
var phnoid = document.getElementById("phnoid").value;
$.ajax({
url:'<?=base_url();?>Menu/phnotovillage',
type: "POST",
data: {
phnoid: phnoid
},
cache: false,
success: function a(result){
$("#villageid").html(result);
}
});
});


$('#phnoid').on('change', function g() {
var riid = document.getElementById("riid").value;
$.ajax({
url:'<?=base_url();?>Menu/ritovillage',
type: "POST",
data: {
phnoid: phnoid
},
cache: false,
success: function a(result){
$("#villageid").html(result);
}
});
});

$('#villageid').on('change', function g() {
var villageid = document.getElementById("villageid").value;
$.ajax({
url:'<?=base_url();?>Menu/villagetocategory',
type: "POST",
data: {
villageid: villageid
},
cache: false,
success: function a(result){
$("#category").html(result);
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
