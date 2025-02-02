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
<!-- /.navbar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1 class="m-0">RP Meeting Report</h1>
</div><!-- /.col -->
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<h4></h4>
</ol>
</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<form class="p-3" method="POST" action="<?=base_url();?>/Menu/TBMDF">
<input type="date" name="sdate" class="mr-2" value="<?=$sd?>">
<input type="date" name="edate" class="mr-2" value="<?=$ed?>">
<select name="bdname">
<option value="<?=$uid?>">All</option>
<?php $bd = $this->Menu_model->get_userbyaid($uid);
foreach($bd as $bd){
?>
<option value="<?=$bd->user_id?>"><?=$bd->name?></option>
<?php } ?>
</select>

<button type="submit" class="bg-primary text-light">Filter</button>
</form>
<!-- Main content -->
<section class="content">
<div class="container-fluid">
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
</div>
<!-- /.card-header -->
<div class="card-body">
<div class="container body-content">
<div class="page-header">
    <fieldset>
        
        <div class="table-responsive">
            <div class="table-responsive">
                <div class="pdf-viwer">
                    <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>RP to No RP Convert</th>
                                <th>BD Name</th>
                                <th>CIN</th>
                                <th>Company Name</th>
                                <th>Photo</th>
                                <th>Started At</th>
                                <th>Close At</th>
                                <th>Start Location</th>
                                <th>Close Location</th>
                                <th>Fresh-Meeting/Re-Meeting</th>
                                <th>RP Yes/No</th>
                                <th>Potential Yes/No</th>
                                <th>Priority Yes/No</th>
                                <th>MOM Yes/No</th>
                                <th>Thanks Mail Yes/No</th>
                                <th>PST Assign Yes/No</th>
                                <th>Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($code==10){?>
                            
                            
                            <?php
                            $i=1;
                            foreach($mdata as $dt){
                            $cid = $dt->cid;
                            $tid = $dt->tid;
                            $cmpid = $dt->cmpid;
                            if($dt->cmpid_id){
                                $company_id = $dt->cmpid_id;
                            }
                            else{
                                 $company_id = 0;
                            }
                            $momc = $this->Menu_model->get_momyn($cid,$tid);
                            if($momc){$momc='yes';}else{$momc='no';}
                            $emailc = $this->Menu_model->get_temailyn($cid,$tid);
                            if($emailc){$emailc='yes';}else{$emailc='no';}
                            // $psta = $this->Menu_model->get_psta($cid);
                           
                                $psta = $dt->apst;
                            if($psta){$psta='yes';}else{$psta='no';}
                            $cmprp = $this->Menu_model->get_meetfr($tid,$cid);
                            $cmrp = $cmprp[0]->cont;
                            $frmeeting="";
                            if($cmrp==0){$frmeeting="Fresh-Meeting";}
                            if($cmrp>0){$frmeeting="Re-Meeting";}
                            if($frmeeting=='Fresh-Meeting'){
                                if($momc == 'yes'){
                            ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><button style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;" id="norp<?=$tid?>" value="<?=$tid?>">Click</button></td>
                                <td><?=$dt->name?></td>
                                <td><?=$company_id?></td>
                               
                                <td><a href="<?=base_url();?>/Menu/CompanyDetails/<?=$company_id?>"><?=$dt->company_name?></a><br></td>
                                <td>
                                  <img src="<?=base_url();?><?=$dt->cphoto?>" height="200px" alt="image not found">
                                  <a href="<?=base_url();?><?=$dt->cphoto?>"?>Image</a>
                                </td>
                                <td><?=$time1=$dt->startm?></td>
                                <td><?=$time2=$dt->closem?></td>
                                <td><a href="https://www.google.com/maps?q=<?=$dt->slatitude?>,<?=$dt->slongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a></td>
                                <td><a href="https://www.google.com/maps?q=<?=$dt->clatitude?>,<?=$dt->clongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a></td>
                                <td><?=$frmeeting?></td>
                                <td><?=$dt->mtype?></td>
                                <td><?=$dt->potential?></td>
                                <td><?=$dt->priority?></td>
                                <td><?=$momc?></td>
                                <td><?=$emailc?></td>
                                <td><?=$psta?></td>
                                <td><?=$dt->queans?><hr><?=$dt->mcomment?></td>
                                <?php $i++;}}}?>
                                
                                
                                
                                
                                
                                
                                
                                
                                <?php }elseif($code==11){?>
                                
                                
                                <?php
                                
                                $i=1;
                                foreach($mdata as $dt){
                                $cid = $dt->cid;
                                $tid = $dt->tid;
                                $cmpid = $dt->cmpid;
                                $companyid = $dt->companyid;
                                $companyname = $dt->compname;
                                if($dt->cmpid_id){
                                    $company_id = $dt->cmpid_id;
                                }
                                else{
                                     $company_id = 0;
                                }
                                $momc = $this->Menu_model->get_momyn($cid,$tid);
                                if($momc){$momc='yes';}else{$momc='no';}
                                $emailc = $this->Menu_model->get_temailyn($cid,$tid);
                                if($emailc){$emailc='yes';}else{$emailc='no';}
                                 $psta = $dt->apst;
                                if($psta){$psta='yes';}else{$psta='no';}
                                $cmprp = $this->Menu_model->get_meetfr($tid,$cid);
                                $cmrp = $cmprp[0]->cont;
                                $frmeeting="";
                                if($cmrp==0){$frmeeting="Fresh-Meeting";}
                                if($cmrp>0){$frmeeting="Re-Meeting";}
                                if($frmeeting=='Re-Meeting'){
                                      if($momc == 'yes'){
                                ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><button style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;" id="norp<?=$tid?>" value="<?=$tid?>">Click</button></td>
                                    <td><?=$dt->name?></td>
                                     <td><?=$company_id?></td>
                                    <td><a href="<?=base_url();?>/Menu/CompanyDetails/<?=$company_id?>"><?=$companyname?></a><br></td>
                                    <td>
                                    <img src="<?=base_url();?><?=$dt->cphoto?>" height="200px" alt="image not found">
                                    <a href="<?=base_url();?><?=$dt->cphoto?>"?>Image</a>
                                  </td>
                                    <td><?=$time1=$dt->startm?></td>
                                    <td><?=$time2=$dt->closem?></td>
                                    <td><a href="https://www.google.com/maps?q=<?=$dt->slatitude?>,<?=$dt->slongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a></td>
                                    <td><a href="https://www.google.com/maps?q=<?=$dt->clatitude?>,<?=$dt->clongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a></td>
                                    <td><?=$frmeeting?></td>
                                    <td><?=$dt->mtype?></td>
                                    <td><?=$dt->potential?></td>
                                    <td><?=$dt->priority?></td>
                                    <td><?=$momc?></td>
                                    <td><?=$emailc?></td>
                                    <td><?=$psta?></td>
                                    <td><?=$dt->queans?><hr><?=$dt->mcomment?></td>
                                    <?php $i++;}}
                                    } ?>
                                    
                                    
                                    <?php }elseif($code==12){?>
                                    
                                    
                                    <?php
                                    $i=1;
                                    foreach($mdata as $dt){
                                    $cid = $dt->cid;
                                    $tid = $dt->tid;
                                    $cmpid = $dt->cmpid;
                                    if($dt->cmpid_id){
                                        $company_id = $dt->cmpid_id;
                                    }
                                    else{
                                         $company_id = 0;
                                    }
                                    $momc = $this->Menu_model->get_momyn($cid,$tid);
                                    if($momc){$momc='yes';}else{$momc='no';}
                                    $emailc = $this->Menu_model->get_temailyn($cid,$tid);
                                    if($emailc){$emailc='yes';}else{$emailc='no';}
                                     $psta = $dt->apst;
                                    if($psta){$psta='yes';}else{$psta='no';}
                                    $cmprp = $this->Menu_model->get_meetfr($tid,$cid);
                                    $cmrp = $cmprp[0]->cont;
                                    $frmeeting="";
                                    if($cmrp==0){$frmeeting="Fresh-Meeting";}
                                    if($cmrp>0){$frmeeting="Re-Meeting";}
                                    if($momc=='no'){
                                    ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><button style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;" id="norp<?=$tid?>" value="<?=$tid?>">Click</button></td>
                                        <td><?=$dt->name?></td>
                                         <td><?=$dt->cmpid_id?></td>
                                        <td><a href="<?=base_url();?>/Menu/CompanyDetails/<?=$company_id?>"><?=$dt->company_name?></a><br></td>
                                        <td>
                                        <img src="<?=base_url();?><?=$dt->cphoto?>" height="200px" alt="image not found">
                                        <a href="<?=base_url();?><?=$dt->cphoto?>"?>Image</a>
                                      </td>
                                        <td><?=$time1=$dt->startm?></td>
                                        <td><?=$time2=$dt->closem?></td>
                                        <td><a href="https://www.google.com/maps?q=<?=$dt->slatitude?>,<?=$dt->slongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a></td>
                                        <td><a href="https://www.google.com/maps?q=<?=$dt->clatitude?>,<?=$dt->clongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a></td>
                                        <td><?=$frmeeting?></td>
                                        <td><?=$dt->mtype?></td>
                                        <td><?=$dt->potential?></td>
                                        <td><?=$dt->priority?></td>
                                        <td><?=$momc?></td>
                                        <td><?=$emailc?></td>
                                        <td><?=$psta?></td>
                                        <td><?=$dt->queans?><hr><?=$dt->mcomment?></td>
                                        <?php $i++;}} ?>
                                        <?php }else{?>
                                        <?php
                                        $i=1;
                                        foreach($mdata as $dt){
                                        $cid = $dt->cid;
                                        $tid = $dt->tid;
                                        $cmpid = $dt->cmpid;
                                        if($dt->cmpid_id){
                                        $company_id = $dt->cmpid_id;
                                        }
                                        else{
                                             $company_id = 0;
                                        }
                                        $momc = $this->Menu_model->get_momyn($cid,$tid);
                                        if($momc){$momc='yes';}else{$momc='no';}
                                        $emailc = $this->Menu_model->get_temailyn($cid,$tid);
                                        if($emailc){$emailc='yes';}else{$emailc='no';}
                                         $psta = $dt->apst;
                                        if($psta){$psta='yes';}else{$psta='no';}
                                        $cmprp = $this->Menu_model->get_meetfr($tid,$cid);
                                        $cmrp = $cmprp[0]->cont;
                                        $frmeeting="";
                                        if($cmrp==0){$frmeeting="Fresh-Meeting";}
                                        if($cmrp>0){$frmeeting="Re-Meeting";}
                                        if($momc =='yes'){
                                        ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td><button style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;" id="norp<?=$tid?>" value="<?=$tid?>">Click</button></td>
                                            <td><?=$dt->name?></td>
                                             <td><?=$company_id?></td>
                                            <td><a href="<?=base_url();?>/Menu/CompanyDetails/<?=$company_id?>"><?=$dt->company_name?></a><br></td>
                                            <td>
                                            <img src="<?=base_url();?><?=$dt->cphoto?>" height="200px" alt="image not found">
                                            <a href="<?=base_url();?><?=$dt->cphoto?>"?>Image</a>
                                          
                                          </td>
                                            <td><?=$time1=$dt->startm?></td>
                                            <td><?=$time2=$dt->closem?></td>
                                            <td><a href="https://www.google.com/maps?q=<?=$dt->slatitude?>,<?=$dt->slongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a></td>
                                            <td><a href="https://www.google.com/maps?q=<?=$dt->clatitude?>,<?=$dt->clongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a></td>
                                            <td><?=$frmeeting?></td>
                                            <td><?=$dt->mtype?></td>
                                            <td><?=$dt->potential?></td>
                                            <td><?=$dt->priority?></td>
                                            <td><?=$momc?></td>
                                            <td><?=$emailc?></td>
                                            <td><?=$psta?></td>
                                            <td><?=$dt->queans?><hr><?=$dt->mcomment?></td>
                                            <?php $i++;}} }?>
                                            
                                            
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </form>            <!--END OF FORM ^^-->
                        </fieldset>
                        
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
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$('[id^="norp"]').on('click', function() {
var tid = this.value;
alert('Do You Want to Change RP to No RP Meeting');
$.ajax({
url:'<?=base_url();?>Menu/changenorp',
type: "POST",
data: {
tid: tid
},
cache: false,
success: function a(result){
}
});
});
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
"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
</body>
</html>