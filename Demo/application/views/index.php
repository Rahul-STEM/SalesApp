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
  

<p>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Search
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
    <div class="card p-3 text-center">
    <form class="p-3" method="POST" action="<?=base_url();?>/Menu/main">
   <select id="stateid" class="form-control">
       <option value="">Select State</option>
       <?php $gstate=$this->Menu_model->get_gstate();
       foreach($gstate as $gs){?>
       <option value="<?=$gs->id?>"><?=$gs->name?></option>
       <?php } ?>
   </select>
   <select id="districtid" class="form-control"></select>
   <select id="tehsilid" class="form-control"></select>
   <select id="blockid" class="form-control"></select>
   <select id="riid" class="form-control"></select>
   <select id="phnoid" class="form-control"></select>
   <select id="villageid" name="villageid" class="form-control"></select>
   <select id="category" name="category" class="form-control"></select>
   <select id="subcategory" name="subcategory" class="form-control"></select>
   <select id="khasranoid" name="khasranoid" class="form-control"></select>
    <button type="submit" class="bg-primary text-light">Filter</button>
</form>
</div>
    
    
    
  </div>
</div>




<section class="content">
      <div class="container-fluid">
        <div class="row p-3">
<?php

if(isset($_POST["khasranoid"])){
$knno = $_POST["khasranoid"];$vid = $_POST["villageid"];$category = $_POST["category"];}else{$knno='31/1';$vid='1';$category='Owned-Land';}
$vigc=$this->Menu_model->get_villagegc($vid);
$kngc=$this->Menu_model->get_khasranotogcv($knno,$vid);
$basracode=$this->Menu_model->get_basracode($knno,$vid);
$minff=$this->Menu_model->get_khasranotomapinfo($knno,$vid);
?>




<?php if(isset($_POST["khasranoid"])){ ?>
    
<div class="col-lg-8 col-sm p-5" id="map" style="width: 100%; height: 500px;"></div>
<div class="col-lg-4 col-sm p-3"><h3><center>info</center></h3><hr>
<?php foreach($minff as $minfo){?>
<p>STATE : <?=$minfo->sname;?></p>
<p>DISTRICT : <?=$minfo->dname;?></p>
<p>TEHSIL : <?=$minfo->tname;?></p>
<p>R.I. : <?=$minfo->rname;?></p>
<p>VILLAGE : <?=$minfo->vname;?></p>
<p>KHASARA NUMBER : <?=$minfo->kname;?></p>
<p>AREA IN HECTARE : <?=$minfo->area;?></p>
<?php $ACRE = $minfo->area*2.47105381; $ACRE = number_format($ACRE, 3);?>
<p>AREA IN ACRE : <?=$ACRE;?></p>

<p>LAND TYPE : <?=$minfo->landtype;?></p>


<?php if($category=='Government'){?>
<p>LAND USE : <?=$minfo->landuse;?></p>
<p>OWNER NAME : <?=$minfo->ownern;?></p>
<p>REMARKS : <?=$minfo->remarks;?></p>
<?php } ?>

<?php if($category=='Private'){?>
<p>LAND USE : <?=$minfo->landuse;?></p>
<p>OWNER NAME : <?=$minfo->ownern;?></p>
<p>OWNER FATHER NAME : <?=$minfo->ownerfathername;?></p>
<p>OWNER ADDRESS : <?=$minfo->owneraddress;?></p>
<p>OWNER CASTE : </p>
<p>OWNER CONTACT NUMBER : </p>
<p>REMARKS : <?=$minfo->remarks;?></p>
<?php } ?>




<?php if($category=='Owned-Land'){?>
<p>PERSENT USER : <?=$minfo->presentuser;?></p>
<p>SUB LAND TYPE : <?=$minfo->sublandtype;?></p>
<p>PRESENT OWNER NAME : <?=$minfo->presentownername;?></p>
<p>OWNER FATHER NAME : <?=$minfo->ownerfathername;?></p>
<p>OWNER ADDRESS : <?=$minfo->owneraddress;?></p>
<p>SALE DEED NUMBER : <?=$minfo->saledeednumber;?></p>
<p>SALE DEED DATE : <?=$minfo->saledeeddate;?></p>
<p>PURCHASE VALUE : <?=$minfo->purchasevalue;?></p>
<p>PAYMENT MODE : <?=$minfo->paymentmode;?></p>
<p>PAYMENT DATE : <?=$minfo->paymentdate;?></p>
<p>STAMP DUTY : <?=$minfo->stampduty;?></p>
<p>REGISTRATION FEE : <?=$minfo->registrationfee;?></p>
<p>RIN PUSTIKA NUMBER : <?=$minfo->rinpustikanumber;?></p>
<p>MUTATION NO : <?=$minfo->mutationno;?></p>
<p>MUTATION DATE : <?=$minfo->mutationdate;?></p>
<p>DIVERSION ORDER NO : <?=$minfo->diversionorderno;?></p>
<p>DIVERSION DATE : <?=$minfo->diversiondate;?></p>
<p>DIVERSION RENT YEARLY : <?=$minfo->diversionrentyearly;?></p>
<p>PREVIOUS OWNER : <?=$minfo->previousowner;?></p>
<p>MORTGAGER : <?=$minfo->mortgager;?></p>
<p>MORTGAGEE : <?=$minfo->mortgagee;?></p>
<?php } ?>
<?php }?>
</div>
    
    
<?php } ?>


  

    
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->



<?php foreach($kngc as $kng){
    echo $kng->glat;  echo "     ";
    echo $kng->glong; echo "<br>";
     } ?>


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


$('#category').on('change', function g() {
var category = this.value;
var villageid = document.getElementById("villageid").value;
$.ajax({
url:'<?=base_url();?>Menu/categorytosc',
type: "POST",
data: {
villageid: villageid,
category : category
},
cache: false,
success: function a(result){
$("#subcategory").html(result);
}
});
});


$('#subcategory').on('change', function g() {
var villageid = document.getElementById("villageid").value;
var sc = document.getElementById("subcategory").value;
$.ajax({
url:'<?=base_url();?>Menu/villagetokhasrano',
type: "POST",
data: {
villageid: villageid,
sc: sc
},
cache: false,
success: function a(result){
$("#khasranoid").html(result);
}
});
});





    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: <?=$kngc[0]->glat?>, lng: <?=$kngc[0]->glong?>},
        zoom: 20,
        mapTypeId: 'satellite'
      });
    
    var boundaryCoords = [
    <?php foreach($kngc as $kng){?>
    {lat: <?=$kng->glat?>, lng: <?=$kng->glong?>},
    <?php } ?>
      ];
      var boundary = new google.maps.Polygon({
        paths: boundaryCoords,
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35
      });
      boundary.setMap(map);
      
      
      <?php $i=1;foreach($basracode as $bcode){
        $knno1= $bcode->name;
        ?>  
        
        var basraCoords<?=$i?> = [
        
        <?php $kngc1=$this->Menu_model->get_khasranotogcv($knno1,$vid);
        foreach($kngc1 as $kng1){?>
        {lat: <?=$kng1->glat?>, lng: <?=$kng1->glong?>},
        <?php } ?>
          ];
          var boundarybybasra<?=$i?> = new google.maps.Polygon({
            paths: basraCoords<?=$i?>,
            strokeColor: '#0D5084',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#0D5084',
            fillOpacity: 0.35
          });
          boundarybybasra<?=$i?>.setMap(map);
      
      <?php $i++;} ?>
      
    
    
    
      const smallerIcon1 = {
          url: 'https://cdn-icons-png.flaticon.com/128/2776/2776063.png',
          scaledSize: new google.maps.Size(32, 32),
        };
      
      const labelMarker = new google.maps.Marker({
        position: { lat: <?=$minff[0]->clat?>, lng: <?=$minff[0]->clong?> },
        map: map,
        icon: smallerIcon1,
        label: {
          text: '<?=$minff[0]->kname?>',
          color: 'white',
          fontWeight: 'bold',
          fontSize: '10px',
        },
      });
      
      labelMarker.addListener('click', function() {
            alert('Marker clicked!');
      });
      
      
      
      
      var outerboundaryCoords = [
        <?php foreach($vigc as $vig){?>
        {lat: <?=$vig->clat?>, lng: <?=$vig->clong?>},
        <?php } ?>
          ];
      var outerboundary = new google.maps.Polygon({
        paths: outerboundaryCoords,
        strokeColor: '#0059ff',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: 'transparent',
        fillOpacity: 0.35
      });
      outerboundary.setMap(map);
      
      
        
      
      
      const smallerIcon2 = {
          url: 'https://cdn-icons-png.flaticon.com/128/2776/2776063.png',
          scaledSize: new google.maps.Size(32, 32),
        };
      
      <?php $i=1; 
      foreach($basracode as $bcode){?>
      
      const labelMarker<?=$i?> = new google.maps.Marker({
        position: { lat: <?=$bcode->clat?>, lng: <?=$bcode->clong?> },
        map: map,
        icon: smallerIcon2,
        label: {
          text: '<?=$bcode->name?>',
          color: 'white',
          fontWeight: 'bold',
          fontSize: '10px',
        },
      });
      
      <?php $i++;} ?>
      
      
      
      
      
      
      
    }



</script>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>
</html>
