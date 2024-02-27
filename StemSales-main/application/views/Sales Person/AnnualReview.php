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
            <h1 class="m-0">Annual Review of Last FY 2022-23</h1>
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
                  
                 <?php 
                 
                     $bdrp=$this->Menu_model->get_pstrpbybd($uid);
                     $fannal=$this->Menu_model->get_fannal($uid);
                     $mdata = $this->Menu_model->new_tbmd($uid,'2022-04-01','2023-03-31');
                     $rpcity = $this->Menu_model->get_rpcity($uid,'2022-04-01','2023-03-31');
                     $topspender = $this->Menu_model->get_top_spender($uid);
                     $topspenderrp = $this->Menu_model->get_top_spender_rp($uid);
                     $mbdc=$this->Menu_model->get_mbdc($uid);
                     $clousercd=$this->Menu_model->get_clousercd($uid);
                     $keyclient=$this->Menu_model->get_keyclient($uid);
                     $tt=0;$trp=0;$tfm=0;$trm=0;$pmom=0;$fmeet=0;$rmeet=0;$ymom=0;$nmom=0;$rpm=0;$csr=0;$govt=0;$pschool=0;$other=0;$ngo=0;$fmeetwwdl=0;
                        foreach($mdata as $dt){
                            $tt++;
                            $cmpid = $dt->cmpid;
                            $cid = $dt->cid;
                            $tid = $dt->tid;
                            $rp = $this->Menu_model->get_checkrpbytid($tid);
                            if($rp){$rpm++;
                                $comp = $this->Menu_model->get_bargdetailcid($cmpid);
                                $init = $this->Menu_model->get_initcallbyid($cmpid);
                                $cmprp = $this->Menu_model->get_tblrpcid($cid);
                                $cmrp = $cmprp[0]->cont;
                                if($cmrp==1){$fmeet++;}else{$rmeet++;}
                                if($init[0]->cstatus!=10 || $init[0]->cstatus!=11){
                                    $comp = sizeof($comp);
                                    if($cmrp==1){
                                        $fmeetwwdl++;
                                        $cmpdetail = $this->Menu_model->get_cdbyid($cmpid);
                                        $partnerType = $cmpdetail[0]->partnerType_id;
                                        if($partnerType==1 || $partnerType==2 || $partnerType==13){$csr++;}
                                        elseif($partnerType==8 || $partnerType==16){$govt++;}
                                        elseif($partnerType==4){$pschool++;}
                                        elseif($partnerType==3 || $partnerType==12){$ngo++;}
                                        else{$other++;}
                                    }
                                }
                            }
                        }
                 
                 ?>
              <!-- form start -->
            <form method="post" action="<?=base_url();?>Menu/ardata"  enctype="multipart/form-data">
            <div class="form-row">
              <div class="col-sm-12 col-lg-6 p-3">
                <div class="was-validated">
                    <div class="form-row">
                        <div class="col-12 col-md-12">
                            <label for="validationSample01">BD Name: <?=$user['name']?></label>
                            <input type="hidden" name="uname" value="<?=$user['name']?>">
                            <input type="hidden" name="uid" value="<?=$uid?>">
                        </div>
                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample02">No. of RP Meeting completed</label>
                            <div class="row">
                                <?php 
                                
                                $ddd = $bdrp[0]->a - $bdrp[0]->b - $bdrp[0]->c - $bdrp[0]->d - $bdrp[0]->e;
                                
                                ?>
                                <div class="col-3 mt-3">
                                    <lable>Total</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control" name="data[]" value="<?=$bdrp[0]->a?>" required="" readonly>
                                </div><br><br>
                                <div class="col-3 mt-3">
                                    <lable>CSR</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control"   name="data[]" value="<?=$bdrp[0]->b?>" required="" readonly>
                                </div><br><br>
                                <div class="col-3 mt-3">
                                    <lable>Govt</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control"   name="data[]" value="<?=$bdrp[0]->c?>" required="" readonly>
                                </div><br><br>
                                <div class="col-3 mt-3">
                                    <lable>NGO</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control"   name="data[]" value="<?=$bdrp[0]->d?>" required="" readonly>
                                </div><br><br>
                                <div class="col-3 mt-3">
                                    <lable>Private School</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control"   name="data[]" value="<?=$bdrp[0]->e?>" required="" readonly>
                                </div><br><br>
                                <div class="col-3 mt-3">
                                    <lable>Other</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control"   name="data[]" value="<?=$ddd?>" required="" readonly>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please provide a company's website.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        
                        <div class="col-12 col-md-12 mb-12 mt-2">
                            <label for="validationSample02">Districts travelled</label>
                            <div class="row">
                                <div class="col-3 mt-3">
                                    <lable>Name od District</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <textarea class="form-control" name="data[]" required="" readonly><?=$rpcity[0]->city?></textarea>
                                </div><br><br>
                                <div class="col-3 mt-3">
                                    <lable>Total Meeting </lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control"  value="<?=$tt?>" name="data[]"  required="" readonly>
                                </div><br><br>
                                <div class="col-3 mt-3">
                                    <lable>RP Meeting</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control" value="<?=$rpm?>"  name="data[]"  required="" readonly>
                                </div>
                                
                                <div class="col-3 mt-3">
                                    <lable>Fresh Meeting</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control" value="<?=$fmeet?>"  name="data[]"  required="" readonly>
                                </div>
                                
                                <div class="col-3 mt-3">
                                    <lable>Re-meeting</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control" value="<?=$rmeet?>"  name="data[]"  required="" readonly>
                                </div>
                                
                            </div>
                            <div class="invalid-feedback">Please provide a company's website.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample03">Potential district/ Top district of respective region: </label>
                            <textarea class="form-control" name="data[]"></textarea>
                            <div class="invalid-feedback">Please provide a valid district.</div>
                        </div>

                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample04">Aspirational district of your respective region</label>
                            <textarea class="form-control" name="data[]"></textarea>
                            <div class="invalid-feedback">Please provide a valid state.</div>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample04">Top spender companies</label>
                            <textarea class="form-control" name="data[]" readonly><?=$topspender[0]->tops?></textarea>
                            <div class="invalid-feedback">Please provide a valid companies.</div>
                        </div>
                        
                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample04">Top Spender RP Companies Completed</label>
                            <textarea class="form-control" name="data[]" readonly><?=$topspenderrp[0]->topsrp?></textarea>
                            <div class="invalid-feedback">Please provide a valid city.</div>
                        </div>
                        
                        <div class="col-12 col-md-12 mb-12 ">
                            
                            <label for="validationSample04">LinkedIn connect:</label>
                            <div class="row">
                                <div class="col-6 ">
                                <input type="number" class="form-control" name="data[]" required="">
                              </div>
                                <div class="col-6 mt-1">
                                <label for="myfile">Screenshot to be attached</label> <input type="file" name="filea[]" multiple readonly> 
                                <div class="invalid-feedback">Please provide a valid city.</div>
                                </div>
                            </div>    
                        </div>
                        
                        <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample01">Broadcast list</label>
                            <div class="row">
                                <div class="col-3 mt-3">
                                    <lable>CSR</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="number" class="form-control" name="data[]" required="">
                                    <label for="myfile">Screenshot to be attached</label><input type="file" name="fileb[]" multiple readonly>
                                </div><br><br>
                                <div class="col-3 mt-3">
                                    <lable>Private school</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="number" class="form-control" name="data[]" required="">
                                    <label for="myfile">Screenshot to be attached</label> <input type="file" name="filec[]" multiple readonly>
                                </div><br><br>
                                <div class="col-3 mt-3">
                                    <lable>Govt</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="number" class="form-control" name="data[]" required="">
                                    <label for="myfile">Screenshot to be attached</label> <input type="file" name="filed[]" multiple readonly>
                                </div><br><br>
                            </div>
                            <div class="invalid-feedback">Please provide a company's website.</div>
                        </div>
                       
                    </div>
                </div>
                
              </div>
              <div class="col-sm-12 col-lg-6 p-3">
                        <div class="col-12 col-md-12 mb-12 mt-2">
                            <label for="validationSample02">Current funnel report (in separate format)</label>
                            <div class="row">
                                <div class="col-4">
                                    <lable>Total Companies</lable>
                                    <input type="text" class="form-control"  name="data[]" value="<?=$mbdc[0]->a?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>Open</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->b?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>Open [RPEM]</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->i?>"  required="" readonly>
                                </div><br><br>
                                <div class="col-4">
                                    <lable>Reachout</lable>
                                    <input type="text" class="form-control"  name="data[]" value="<?=$mbdc[0]->c?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>Tentative</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->d?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>Will-Do-Later</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->e?>"  required="" readonly>
                                </div><br><br>
                                <div class="col-4">
                                    <lable>Not-Interest</lable>
                                    <input type="text" class="form-control"  name="data[]" value="<?=$mbdc[0]->f?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>TTD-Reachout</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->k?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>WNO-Reachout</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->l?>"  required="" readonly>
                                </div><br><br>
                                <div class="col-4">
                                    <lable>Positive</lable>
                                    <input type="text" class="form-control"  name="data[]" value="<?=$mbdc[0]->g?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>Very Positive</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->j?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>Positive NAP</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->o?>"  required="" readonly>
                                </div><br><br>
                                <div class="col-4">
                                    <lable>Very Positive NAP</lable>
                                    <input type="text" class="form-control"  name="data[]" value="<?=$mbdc[0]->p?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>Focus Funnel</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->m?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>Upsell Client</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->n?>"  required="" readonly>
                                </div><br><br>
                                <div class="col-4">
                                    <lable>Closure</lable>
                                    <input type="text" class="form-control"  name="data[]" value="<?=$mbdc[0]->h?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>Key Client</lable>
                                    <input type="text" class="form-control" name="data[]" value="<?=$mbdc[0]->q?>"  required="" readonly>
                                </div><br><br>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-12 mb-12 mt-2">
                            <label for="validationSample02">Model school visit/ readyness:</label>
                           <div id="schoolvisit">
                            <div class="row" id="svdata">
                                <div class="col-3 mt-3" "form-group">
                                    <lable>School Name</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text" class="form-control"   name="svsname[]"  required="">
                                </div>
                                <div class="col-3 mt-3">
                                    <lable>Location</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text"  class="form-control"   name="svlocation[]"  required="">
                                </div>
                            </div>
                            </div>
                            <b onclick="addsvisit()" class="text-primary">+Add More</b>
                            </div>
                        
                        <div class="col-12 col-md-12 mb-12 mt-2">
                            <label for="validationSample02">Client visit to model school</label>
                            <div id="cschoolvisit">
                            <div class="row" id="csvdata">
                                <div class="col-3 mt-3">
                                 <lable>Client Name</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text"  class="form-control"   name="csvcname[]"  required="">
                                </div>
                                <div class="col-3 mt-3">
                                    <lable>School Name</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text"  class="form-control"   name="csvsname[]"  required="">
                                </div>
                                
                                <div class="col-3 mt-3">
                                    <lable>Location</lable>
                                </div>
                                <div class="col-9 mt-3">
                                    <input type="text"  class="form-control"   name="csvlocation[]"  required="">
                                </div>
                            </div>
                            </div>
                            <b onclick="addcsvisit()" class="text-primary">+Add More</b>
                        </div>
                        
                        <div class="col-12 col-md-12 mb-12 mt-2">
                            <label for="validationSample02">Closure done:</label>
                            <?php foreach($clousercd as $colcd){?>
                            <div class="row">
                                <div class="col-4">
                                    <lable>Name of the Company</lable>
                                    <input type="text" class="form-control"  name="cdcdata[]" value="<?=$colcd->compname?>"  required="" readonly>
                                </div>
                                <div class="col-4">
                                    <lable>No. of School</lable>
                                    <input type="number" class="form-control"  name="cdsdata[]" value="<?=$colcd->noofschools?>"  required="" readonly>
                                </div><br><br>
                                <div class="col-4">
                                    <lable>Revenue</lable>
                                    <input type="text" class="form-control"  name="cdrdata[]" value="<?=$colcd->fbudget?>"  required="" readonly>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        
                        <div class="col-12 col-md-12 mb-12 mt-2">
                            <label>Active Key client for FY 2023-24 (in separate format)</label>
                            <div id="kc">
                            <div class="row" id="kcdata">
                                <div class="col-4">
                                    <lable>Name of Companies</lable>
                                    <input list="client" type="text" class="form-control" name="kccompany[]" required="">
                                    <datalist id="client">
                                    <select class="custom-select rounded-0">
                                        <option>Select Client</option>
                                        <?php foreach($fannal as $f){?>
                                        <option><?=$f->compname?></option>
                                            <?php } ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <lable>No. of School</lable>
                                    <input type="number" class="form-control" name="kcsno[]"  required="">
                                </div><br><br>
                                <div class="col-4">
                                    <lable>Revenue</lable>
                                    <input type="text" class="form-control" name="kcrevenue[]"  required="">
                                    <lable></lable>
                                </div>
                                
                            </div>
                            </div>
                            <b onclick="kcclick()" class="text-primary">+Add More</b>
                            </div>
                            
                            
                        <div class="col-12 col-md-12 mb-12 mt-2">
                            <label>Active Key client for FY 2023-24 (Q1)</label>
                            <div id="kcq1">
                            <div class="row" id="kcq1data">
                                <div class="col-4">
                                    <lable>Name of Companies</lable>
                                    <input list="client" type="text" class="form-control" name="kcqcompany[]" required="">
                                    <datalist id="client">
                                    <select class="custom-select rounded-0">
                                        <option>Select Client</option>
                                        <?php foreach($fannal as $f){?>
                                        <option><?=$f->compname?></option>
                                            <?php } ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <lable>No. of School</lable>
                                    <input type="number" class="form-control" name="kcqsno[]" required="">
                                </div><br><br>
                                <div class="col-4">
                                    <lable>Revenue</lable>
                                    <input type="text" class="form-control" name="kcqrevenue[]" required="">
                                    <lable></lable>
                                </div>
                                
                            </div>
                            </div>
                            <b onclick="kcq1click()" class="text-primary">+Add More</b>
                            </div>
                        
                        <div class="col-12 col-md-12 mb-12 mt-2">
                            <label for="validationSample01">Achievement in the last FY:</label>
                            <textarea type="text" name="achievement" id="draft" class="form-control" placeholder="Achievement..." required=""></textarea><br>
                            <div class="invalid-feedback">Please provide a company's website.</div>
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




function addsvisit() {
    
      var schoolvisit = document.getElementById("schoolvisit");
      var svdata = document.getElementById("svdata");
      schoolvisit.appendChild(svdata.cloneNode(true));
}


function addcsvisit() {
    
      var cschoolvisit = document.getElementById("cschoolvisit");
      var csvdata = document.getElementById("csvdata");
      cschoolvisit.appendChild(csvdata.cloneNode(true));
}


function kcclick() {
    
      var kc = document.getElementById("kc");
      var kcdata = document.getElementById("kcdata");
      kc.appendChild(kcdata.cloneNode(true));
}


function kcq1click() {
    
      var kcq1 = document.getElementById("kcq1");
      var kcq1data = document.getElementById("kcq1data");
      kcq1.appendChild(kcq1data.cloneNode(true));
}








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
url:'<?=base_url();?>Menu/getcitybystate',
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