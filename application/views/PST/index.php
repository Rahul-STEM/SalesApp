<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
.content-wrapper>.content {
    background: azure;
}
.inner h5{
    background: blanchedalmond;
    line-height: 35px;
    font-size: 17px;
    border-radius: 26px;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;
    font-weight: 700;
}
.bg-light, .bg-light>a {
    color: #1f2d3d !important;
    background: #ebf5cb !important;
    border-radius: 40px;
    position: relative;
    overflow: hidden;
    /* box-shadow: rgba(0, 0, 0, .1) 0 1px 2px 0; */
    /* cursor: pointer; */
    font-size: 19px;
    text-align: left;
}
.small-box>.small-box-footer {
    background: #c5eb4d !important;
    font-weight: 500;
}
</style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<!-- Preloader -->
<!-- Navbar -->
<?php require('nav.php');?>
<?php require('addpop.php');?>
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
<h4></h4>
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
<div class="col-12">


<?php 
$bd = $this->Menu_model->get_userbyaaid($uid);
$day = $this->Menu_model->get_daydbyaad($uid,$tdate);
$tttd = $this->Menu_model->get_tteaamtd($uid,$tdate);
$tbmeetd = $this->Menu_model->get_PSTtbmeetdbyaid($uid,$tdate);
// echo $str = $this->db->last_query(); 
// $teamfu = $this->Menu_model->get_mbdcbyaaid($uid);
?>


<button class="btn btn-link" data-toggle="collapse" data-target="#maindata" aria-expanded="true" aria-controls="maindata">
<i class="fas fa-bars"></i> Dashboard Data Analysis
</button>
<div id="maindata" class="collapse" aria-labelledby="maindata" data-parent="#accordion">
<!-- Main content -->
<section class="content">
<div class="container-fluid">
<!-- Small boxes (Stat box) -->
<div class="row">


<div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>Team Detail</h5></center><hr>
                <p><a href="BDDetail1/<?=$uid?>">Total BD - <b><?=$day[0]->a?></b></p></a><hr>
                <p><a href="BDDayDetail/<?=$tdate?>/1">Total BD Present - <b><?=$day[0]->b?></b></p></a><hr>
                <p><a href="https://stemapp.in//Management/CheckingDayManagement">Checking Day Management System - <b><?=$day[0]->b?></b></p></a><hr>
                <p><a href="BDDayDetail/<?=$tdate?>/2">Total Work in Office - <b><?=$day[0]->c?></b></a><span style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" data-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">Read More</span></p><hr>
                <div id="accordion">
                  <div class="icon">
                    <div id="collapsethree" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="card-body">
                <p><a href="BDDayDetail/<?=$tdate?>/3">Total Work in Field - <b><?=$day[0]->d?></b></a></p><hr>
                <p><a href="BDDayDetail/<?=$tdate?>/4">Total Work From Field+Office - <b><?=$day[0]->e?></b></a></p>
              </div>
              </div>
              </div>
              </div>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="TeamDetail" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>Today's our and our Team Task Detail</h5></center><hr>
                
                <?php 
                foreach($tttd as $tttd){?>
                    <p><a href="ATaskDetail/4/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0">Total Task Assign/Planned - <b><?=$tttd->a?></b></p></a><hr>
                    <p><a href="ATaskDetail/5/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0">Total Task Pending - <b><?=$tttd->b?></b></p></a><hr>
                    <p><a href="ATaskDetail/6/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0">Total Task Completed - <b><?=$tttd->c?></b></a><span style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">Read More</span></p><hr>
                <div class="collapse" id="collapse2">
                    <a href="ATaskDetail/3/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Call Done- <b><?=$tttd->d-$tttd->e?></b></a>
                    <a href="ATaskDetail/3/<?=$uid?>/2/<?=$tdate?>/<?=$tdate?>/0"><p>Email Done- <b><?=$tttd->f-$tttd->g?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/3/<?=$tdate?>/<?=$tdate?>/0"><p>Meeting Done- <b><?=$tttd->h-$tttd->i?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/4/<?=$tdate?>/<?=$tdate?>/0"><p>Barg in Done- <b><?=$tttd->j-$tttd->k?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/5/<?=$tdate?>/<?=$tdate?>/0"><p>Whatsapp Done- <b><?=$tttd->l-$tttd->m?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/6/<?=$tdate?>/<?=$tdate?>/0"><p>MOM Done- <b><?=$tttd->n-$tttd->o?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/7/<?=$tdate?>/<?=$tdate?>/0"><p>Proposal Done- <b><?=$tttd->p-$tttd->q?></b></p></a><hr>
                    <a href="ATaskDetail/7/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Action Taken Yes- <b><?=$tttd->r?></b></p></a><hr>
                    <a href="ATaskDetail/8/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Action Taken No- <b><?=$tttd->s?></b></p></a><hr>
                    <a href="ATaskDetail/9/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Purpose Achieved Yes- <b><?=$tttd->t?></b></p></a><hr>
                    <a href="ATaskDetail/10/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Purpose Achieved No- <b><?=$tttd->u?></b></p></a>
                <?php }?>
              </div>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="TeamWork" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


<div class="col-lg-3 col-md-6 col-sm-12">
<div class="small-box bg-light text-secondary">
<div class="inner">
    <?php $ttswwork = $this->Menu_model->new_ttswPST($uid,$tdate,0);
   
    foreach($ttswwork as $tw){?>
    <center><h5>Today's Team Completed Task Against Status</h5></center><hr>
    <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/1/0">Open - <b><?=$tw->a?></b></p></a><hr>
    <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/8/0">Open [RPEM] - <b><?=$tw->b?></b></a><br><span style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse11" role="button" aria-expanded="false" aria-controls="collapse11">Read More</p><hr>
    <div class="collapse" id="collapse11">
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/2/0">Reachout - <b><?=$tw->c?></b></p></a><hr>
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/3/0">Tentative - <b><?=$tw->d?></b></a></p><hr>
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/4/0">Will-Do-Later - <b><?=$tw->e?></b></p></a><hr>
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/5/0">Not-Interest - <b><?=$tw->f?></b></p></a><hr>
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/10/0">TTD-Reachout - <b><?=$tw->j?></b></p></a><hr>
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/11/0">WNO-Reachout - <b><?=$tw->k?></b></p></a><hr>
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/6/0">Positive - <b><?=$tw->g?></b></p></a><hr>
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/12/0">Positive NAP - <b><?=$tw->l?></b></p></a><hr>
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/9/0">Very Positive - <b><?=$tw->i?></b></p></a><hr>
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/13/0">Very Positive NAP - <b><?=$tw->m?></b></p></a><hr>
        <p><a href="StatusTask/<?=$uid?>/<?=$tdate?>/7/0">Closure - <b><?=$tw->h?></b></p></a><hr>
        <?php } ?>
    </div>
</div>
<div class="icon">
    <i class="ion ion-stats-bars"></i>
</div>
<a href="StatusTaskDGroup" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>



<div class="col-lg-3 col-md-6 col-sm-12">
<div class="small-box bg-light text-secondary">
<div class="inner">
    <?php $ttswwork = $this->Menu_model->new_ttswPSTSelf($uid,$tdate,0);
   
    foreach($ttswwork as $tw){?>
    <center><h5>Today's PST Completed Task Against Status</h5></center><hr>
    <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/1/0">Open - <b><?=$tw->a?></b></p></a><hr>
    <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/8/0">Open [RPEM] - <b><?=$tw->b?></b></a><br><span style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse11" role="button" aria-expanded="false" aria-controls="collapse11">Read More</p><hr>
    <div class="collapse" id="collapse11">
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/2/0">Reachout - <b><?=$tw->c?></b></p></a><hr>
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/3/0">Tentative - <b><?=$tw->d?></b></a></p><hr>
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/4/0">Will-Do-Later - <b><?=$tw->e?></b></p></a><hr>
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/5/0">Not-Interest - <b><?=$tw->f?></b></p></a><hr>
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/10/0">TTD-Reachout - <b><?=$tw->j?></b></p></a><hr>
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/11/0">WNO-Reachout - <b><?=$tw->k?></b></p></a><hr>
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/6/0">Positive - <b><?=$tw->g?></b></p></a><hr>
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/12/0">Positive NAP - <b><?=$tw->l?></b></p></a><hr>
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/9/0">Very Positive - <b><?=$tw->i?></b></p></a><hr>
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/13/0">Very Positive NAP - <b><?=$tw->m?></b></p></a><hr>
        <p><a href="StatusTaskSelf/<?=$uid?>/<?=$tdate?>/7/0">Closure - <b><?=$tw->h?></b></p></a><hr>
        <?php } ?>
    </div>
</div>
<div class="icon">
    <i class="ion ion-stats-bars"></i>
</div>
<a href="StatusTaskPSTSelf" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>




<div class="col-lg-3 col-md-6 col-sm-12">
<!-- small box -->
<div class="small-box bg-light text-secondary">
<?php
$sca = $this->Menu_model->final_scon1_PST($uid,$tdate,$tdate,0);
// echo $str = $this->db->last_query();
?>
<div class="inner">
    <center><h5>Today's Team Status Conversion</h5></center><hr>
    <?php  foreach($sca as $scid){
    $string = $scid->scname;
    $parts = explode(" -to- ", $string);
    $firstS = $parts[0];
    $secondS = $parts[1];
    $firstS = $this->Menu_model->get_statusbyname($firstS);
    $fsid = $firstS[0]->id;
    $secondS = $this->Menu_model->get_statusbyname($secondS);
    $ssid = $secondS[0]->id; ?>
    <a href="FinalSConversionByTeam/<?=$uid?>/<?=$tdate?>/<?=$tdate?>/<?=$fsid?>/<?=$ssid?>">
        <?=$string?> - <b><?=$this->Menu_model->final_scon2inPST($uid,$tdate,$tdate,0,$fsid,$ssid);?></b><hr>
    </a>
    <?php } ?>
</div>
<div class="icon">
    <i class="ion ion-person-add"></i>
</div>
<a href="SConversion" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>Today's Task Detail</h5></center><hr>
                <?php foreach($ttd as $tttd){?>
                    <p><a href="ATaskDetail/4/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/1">Total Task Assign/Planned - <b><?=$tttd->a?></b></p></a><hr>
                    <p><a href="ATaskDetail/5/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/1">Total Task Pending - <b><?=$tttd->b?></b></p></a><hr>
                    <p><a href="ATaskDetail/6/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/1">Total Task Completed - <b><?=$tttd->c?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/1"><p>Call Done- <b><?=$tttd->d-$tttd->e?></b></a>
                    <a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">Read More</a></p><hr>
                <div class="collapse" id="collapse2">
                    <a href="ATaskDetail/3/<?=$uid?>/2/<?=$tdate?>/<?=$tdate?>/1"><p>Email Done- <b><?=$tttd->f-$tttd->g?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/3/<?=$tdate?>/<?=$tdate?>/1"><p>Meeting Done- <b><?=$tttd->h-$tttd->i?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/4/<?=$tdate?>/<?=$tdate?>/1"><p>Barg in Done- <b><?=$tttd->j-$tttd->k?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/5/<?=$tdate?>/<?=$tdate?>/1"><p>Whatsapp Done- <b><?=$tttd->l-$tttd->m?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/6/<?=$tdate?>/<?=$tdate?>/1"><p>MOM Done- <b><?=$tttd->n-$tttd->o?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$uid?>/7/<?=$tdate?>/<?=$tdate?>/1"><p>Proposal Done- <b><?=$tttd->p-$tttd->q?></b></p></a><hr>
                    <a href="ATaskDetail/7/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/1"><p>Action Taken Yes- <b><?=$tttd->r?></b></p></a><hr>
                    <a href="ATaskDetail/8/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/1"><p>Action Taken No- <b><?=$tttd->s?></b></p></a><hr>
                    <a href="ATaskDetail/9/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/1"><p>Purpose Achieved Yes- <b><?=$tttd->t?></b></p></a><hr>
                    <a href="ATaskDetail/10/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/1"><p>Purpose Achieved No- <b><?=$tttd->u?></b></p></a>
                <?php }?>
              </div></div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="TDetail/<?=$tdate?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

<div class="col-lg-3 col-md-6 col-sm-12">
    <!-- small box -->
    <div class="small-box bg-light text-secondary">
        <div class="inner">
            <center><h5>Today's PST Call Detail</h5></center><hr>
            <?php $pstcalld = $this->Menu_model->get_pstcalldbyad($uid,$tdate,1);
            foreach($pstcalld as $psc){?>
            <p><a href="TaskDetail/1/<?=$uid?>/1/<?=$tdate?>">Total No of Call - <b><?=$psc->ab?></b></a></p><hr>
            <p><a href="#">Very Positive- <b><?=$psc->i?></b></p></a><hr>
            <p><a href="#">Positive- <b><?=$psc->f?></b></a><br><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">Read More</a></p><hr>
            <div class="collapse" id="collapse1">
                <p><a href="#">WDL - <b><?=$psc->d?></b></p></a><hr>
                <p><a href="#">Reachout - <b><?=$psc->b?></b></p></a><hr>
                <p><a href="#">Tentative - <b><?=$psc->c?></b></p></a><hr>
                <p><a href="#">Not interested - <b><?=$psc->e?></b></p></a><hr>
                <p><a href="#">Transfer to BD - <b><?=$psc->j?></b></p></a><hr>
                <p><a href="#">Wrong Number - <b><?=$psc->k?></b></p></a><hr>
                <p><a href="#">Action no - <b><?=$psc->o?></b></p></a><hr>
                <p><a href="#">Action yes - <b><?=$psc->p?></b></p></a><hr>
                <p><a href="#">Purpose no - <b><?=$psc->q?></b></p></a><hr>
                <p><a href="#">Purpose yes - <b><?=$psc->r?></b></p></a>
            </div>
            <?php } ?>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="PSTData" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-md-6 col-sm-12">
    <!-- small box -->
    <div class="small-box bg-light text-secondary">
        <div class="inner">
            <center><h5>PST Task Conversion</h5></center><hr>
            <p><a href="PSTCConversion"><b>PST Conversion Detail</b></p></a>
            <p><a href="PSTAllReviewData"><b>PST Team Review</b></p></a>
            <?php $pstcc = $this->Menu_model->get_pstcc($uid,$tdate,1);
            $s=0;$c=0;$vp=0;$p=0;$t=0;$ot=0;$n=0;
            $ca=0;$cb=0;$cc=0;$cd=0;$ce=0;$cf=0;$cg=0;$ch=0;$ci=0;
            foreach($pstcc as $pscc){
            $psid = $pscc->sid;
            $pnsid = $pscc->nsid;
            
            if($psid==$pnsid){$s++;}
            if($psid!=$pnsid){$c++;}
            if($psid==9 && $pnsid==9){$vp++;}
            elseif($psid==6 && $pnsid==6){$p++;}
            elseif($psid==3 && $pnsid==3){$t++;}
            elseif($psid==5 && $pnsid==5){$n++;}
            
            elseif($psid==3 && $pnsid==6){$ca++;}
            elseif($psid==6 && $pnsid==9){$cb++;}
            elseif($psid==9 && $pnsid==7){$cc++;}
            elseif($psid==3 && $pnsid==4){$cd++;}
            elseif($psid==3 && $pnsid==5){$ce++;}
            elseif($psid==3 && $pnsid==10){$cf++;}
            elseif($psid==3 && $pnsid==11){$cg++;}
            elseif($psid==6 && $pnsid==4){$ch++;}
            elseif($psid==9 && $pnsid==4){$ci++;}
            else{$ot++;}
            
            }
            ?>
            <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/1">Same Status - <b><?=$s?></b></p></a><hr><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse6" role="button" aria-expanded="false" aria-controls="collapse6">Read More</a></p><hr>
            <div class="collapse" id="collapse6">
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/9/">Very positive to Very positive - <b><?=$vp?></b></a>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/6">Positive to Positive - <b><?=$p?></b></p></a><hr>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/3">Tentative to Tentative - </b><?=$t?></p></a><hr>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/5">NI to NI - <b><?=$n?></b></p></a><hr><hr>
                <!-- <p><a href="">Change Status - <b><?=$c?></b></p></a><hr> -->
                <p><a href="PSTDataCDetailData1/<?=$uid?>/<?=$tdate?>/3/6">Tentative to Positive - <b><?=$ca?></b></p></a><hr>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/8">Positive to Very Positive - <b><?=$cb?></b></p></a><hr>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/9">Very Positive to Closure - <b><?=$cc?></b></p></a><hr>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/10">Tentative to WDL - <b><?=$cd?></b></p></a><hr>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/11">Tentative to NI - <b><?=$ce?></b></p></a><hr>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/12">Tentative to TTD Reachout - <b><?=$cf?></b></p></a><hr>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/13">Tentative to WNO Reachout - <b><?=$cg?></b></p></a><hr>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/14">Positive to WDL - <b><?=$ch?></b></p></a><hr>
                <p><a href="PSTDataCDetailData/<?=$uid?>/<?=$tdate?>/15">Very positive to wdl - <b><?=$ci?></b></p></a><hr>
                <!-- <p><a href="">Other - <b><?=$ot?></b></p></a><hr> -->
            </div>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="PSTDataCData" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>


<!-- <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-light text-secondary">
        <div class="inner">
            <center><h5>Today's Proposal Detail</h5></center><hr>
            <p><a href="#">Total Proposal Submited - <b>0</b></p></a><hr>
            <p><a href="#">Total No of School - <b>0</b></p></a><hr>
            <p><a href="PSTSRData">Total Budget - <b>0</b></a></p><hr><br>
        </div>
        <div class="icon">
            <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div> -->


<div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                
                <center><h5>Our Proposal Detail</h5></center><hr>
                <p><a href="AllProposalDetail"><b>Proposal Detail</b></a></p> <hr>
                <p><a href="ProposalDetailbydate"><b>Proposal by Date</b></a></p>
                
                  </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="companies/0" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                
                <center><h5>Teams Proposal Detail</h5></center><hr>
                <p><a href="PSTProposalApr"><b>Teams Proposal Approval</b></a></p> <hr>
                <p><a href="AllProposalDetail_PSTTeam"><b>Teams Proposal Detail</b></a></p> <hr>
                <p><a href="ProposalDetailbydate_PSTTeam"><b>Teams Proposal by Date</b></a></p>
                
                  </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>







<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-light text-secondary">
        <div class="inner">
            <?php
            foreach($pstc as $mc){
            ?>
            <center><h5>Total My Companies </h5></center><hr>
            <button type="button" class="btn btn-secondary" id="crt">Create Review</button><hr>
            <p><a href="pcompanies/0">Total Companies - <b><?=$mc->a?></b></p></a><hr>
            <p><a href="pcompanies/1">Open - <b><?=$mc->b?></b></a><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">Read More</a></p><hr>
            <div class="collapse" id="collapse3">
                <p><a href="pcompanies/8">Open [RPEM] - <b><?=$mc->i?></b></p></a><hr>
                <p><a href="pcompanies/2">Reachout - <b><?=$mc->c?></b></p></a><hr>
                <p><a href="pcompanies/3">Tentative - <b><?=$mc->d?></b></p></a><hr>
                <p><a href="pcompanies/4">Will-Do-Later - <b><?=$mc->e?></b></p></a><hr>
                <p><a href="pcompanies/5">Not-Interest - <b><?=$mc->f?></b></p></a><hr>
                <p><a href="pcompanies/10">TTD-Reachout - <b><?=$mc->k?></b></p></a><hr>
                <p><a href="pcompanies/11">WNO-Reachout - <b><?=$mc->l?></b></p></a><hr>
                <p><a href="pcompanies/6">Positive - <b><?=$mc->g?></b></p></a><hr>
                <p><a href="pcompanies/9">Very Positive - <b><?=$mc->j?></b></p></a><hr>
                <p><a href="pcompanies/12">Positive NAP - <b><?=$mc->o?></b></p></a><hr>
                <p><a href="pcompanies/13">Very Positive NAP - <b><?=$mc->p?></b></p></a><hr>
                <p><a href="pcompanies/7">Closure - <b><?=$mc->h?></b></p></a><hr>
                <p><a href="pcompanies/14">Focus Funnel - <b><?=$mc->m?></b></p></a><hr>
                <p><a href="pcompanies/15">Upsell Client - <b><?=$mc->n?></b></p></a><hr>
                <p><a href="pcompanies/16">Key Client - <b><?=$mc->q?></b></p></a><hr>
                <p><a href="pcompanies/18">Priority Calling  - <b><?=$mc->s?></b></p></a><hr>
                <p><a href="pcompanies/19">Priority Tentative Calling Pending  - <b><?=$mc->t?></b></p></a><hr>
                <p><a href="pcompanies/17">Positive Key Client - <b><?=$mc->r?></b></p></a><hr>
                <p><a href="BDNotWorkDD"><b>No Work B/W Date</b></a></p><hr>
                <p><a href="BDFunnal/<?=$uid;?>">All BD Funnel</p></a>
                <?php } ?>
                
            </div>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="pcompanies/0" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>






<div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                  <?php 
                  $mbdc = $this->Menu_model->get_PSTbdpstteammcompany($uid);
                //   echo $str = $this->db->last_query();
                  foreach($mbdc as $mc){
                  ?>
                <center><h5>Total My Team Funnel </h5></center><hr>
                        <p><a href="PSTbdcompanies/0/<?=$uid?>">Total Companies - <b><?=$mc->a?></b></a><hr>
                        <p><a href="PSTbdcompanies/1/<?=$uid?>">Open - <b><?=$mc->b?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/8/<?=$uid?>">Open [RPEM] - <b><?=$mc->i?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/2/<?=$uid?>">Reachout - <b><?=$mc->c?></b></p></a><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse27" role="button" aria-expanded="false" aria-controls="collapse27">Read More</a></p><hr>
                        <div class="collapse" id="collapse27">
                        <p><a href="PSTbdcompanies/3/<?=$uid?>">Tentative - <b><?=$mc->d?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/4/<?=$uid?>">Will-Do-Later - <b><?=$mc->e?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/5/<?=$uid?>">Not-Interest - <b><?=$mc->f?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/10/<?=$uid?>">TTD-Reachout - <b><?=$mc->k?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/11/<?=$uid?>">WNO-Reachout - <b><?=$mc->l?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/6/<?=$uid?>">Positive - <b><?=$mc->g?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/9/<?=$uid?>">Very Positive - <b><?=$mc->j?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/12/<?=$uid?>">Positive NAP - <b><?=$mc->o?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/13/<?=$uid?>">Very Positive NAP - <b><?=$mc->p?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/7/<?=$uid?>">Closure - <b><?=$mc->h?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/14/<?=$uid?>">Focus Funnel - <b><?=$mc->m?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/15/<?=$uid?>">Upsell Client - <b><?=$mc->n?></b></p></a><hr>
                        <p><a href="PSTbdcompanies/16/<?=$uid?>">Key Client - <b><?=$mc->q?></b></p></a><hr>
                        <?php } ?>
                       
                    </div></div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="companies/0" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>


<div class="col-lg-3 col-md-6 col-sm-12">
<div class="small-box bg-light text-secondary">
    <div class="inner">
        <center><h5>Team Bargin Meeting Detail</h5></center><hr>
                    
        <?php 
  
        foreach($tbmeetd as $tmd){
            
            ?>
        <p><a href="plannerareport">Action Planner</b></a></p><hr>
        <p><a href="plannerreport">Status Planner</b></a></p><hr>
        <p><a href="momdetail">MOM Detail</b></a><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse15" role="button" aria-expanded="false" aria-controls="collapse15">Read More</a></p><hr>
        <div class="collapse" id="collapse15">
            <p><a href="TBMDF">Total RP Meeting</b></a></p><hr>
            <p><a href="MeetingDetail/1/<?=$uid?>/<?=$tdate?>"><b>Meeting Detail</b></a></p><hr>
            <p><a href="TBMD_PST/1/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Total Bargin Plan - <b><?=$tmd->ab?></b></a></p><hr>
            <p><a href="TBMD_PST/2/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Not Started Bargin - <b><?=$tmd->a?></b></a></p><hr>
            <p><a href="TBMD_PST/3/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Started Bargin - <b><?=$tmd->i?></b></a></p><hr>
            <p><a href="TBMD_PST/3/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Not Close Bargin - <b><?=$tmd->b?></b></a></p><hr>
            <p><a href="TBMD_PST/4/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Close Bargin - <b><?=$tmd->c?></b></a></p><hr>
            <p><a href="TBMD_PST/5/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Lead not Updated - <b><?=$tmd->h?></b></a></p><hr>
            <p><a href="TBMD_PST/6/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Completed Bargin - <b><?=$tmd->c?></b></a></p><hr>
            <p><a href="TBMD_PST/7/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Total RP Meeting - <b><?=$tmd->d?></b></a></p><hr>
            <p><a href="TBMD_PST/8/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Total Non RP Meeting - <b><?=$tmd->e?></b></a></p><hr>
            <p><a href="TBMD_PST/9/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Total RP Priority - <b><?=$tmd->f?></b></a></p><hr>
            <p><a href="TBMD_PST/13/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Total RP Not Priority - <b><?=$tmd->g?></b></a></p><hr>
            <p><a href="TBMD_PST/14/<?=$uid?>/<?=$tdate?>/<?=$tdate?>">Total Only Got Detail - <b><?=$tmd->k?></b></a></p><hr>
            
            <?php } ?>
        </div>
    </div>
    <div class="icon">
        <i class="ion ion-pie-graph"></i>
    </div>
    <a href="TBMDetail" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-md-6 col-sm-12">
<div class="small-box bg-light text-secondary">
    <div class="inner">
        <center><h5>New Team Client Request</h5></center><hr>
        <?php
        $cont=0;$pass=0;$tass=0;$ini=0;$pend=0;$close=0;
        foreach ($bd as $b){
        $bdid = $b->user_id;
        $bdallrequest=$this->Menu_model->bdrequestinPSTTEAM($bdid);
        foreach($bdallrequest as $bdar){
        $cont = $cont + $bdar->cont;
        $pass = $pass + $bdar->pass;
        $ini = $ini + $bdar->ini;
        $pend = $pend + $bdar->pend;
        $close = $close + $bdar->close;
        }
        }
        ?>
        <p><a href="TBDRequest/1">Total Request - <b><?=$cont;?></b></a></p><hr>
        <p><a href="TotalRequest">Pending Apr - <b><?=$pass;?></b></a></p><hr>
        <p><a href="TotalBDRequest/3">Total Apr - <b><?=$cont-$pass;?></b></a></p><hr>
        <p><a href="TotalBDRequestinPST/5">Total Request Pending - <b><?=$pend;?></b></a><br><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse6" role="button" aria-expanded="false" aria-controls="collapse6">Read More</a></p><hr>
        <div class="collapse" id="collapse6">
            <p><a href="TotalBDRequestinPST/6">Total Request Completed - <b><?=$close;?></b></a></p>
            
            <p><a href="CreateRequest">Create Request</a></p>
        </div></div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
    </div>
</div>

<div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>On Boarded Client</h5></center><hr>
                <!-- <a href="HandoverCompany"><p>Handover to Operation</p></a><hr> -->
                <a href="artworkaprinPST"><p>Artwork Apr Pending</p></a><hr>
                <a href="artworkaprdoneinPST"><p>Artwork Apr Done</p></a><hr>
                <a href="ProgramDetailinPST"><p>Total Handover</a></p><hr>
                <!-- <a href="HandoverDetail"><p>Boarded Client Detail</a></p><hr> -->
                </div>
                <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="HandoverDetail" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>



</div>
<div class="row">

<!-- <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box bg-light text-secondary">
        <div class="inner">
            <center><h5>New Client Request To Operation</h5></center><hr>
            <p><a href="#">Total Request - <b>0</b></p></a><hr>
            <p><a href="#">Total Request Inisiated - <b>0</b></a></p><hr>
            <p><a href="#">Total Request Completed - <b>0</b></a><span style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" data-target="#collapsefive" aria-expanded="true" aria-controls="collapsefive">Read More</span></p><hr>
            <div id="accordion">
                <div class="icon">
                    <div id="collapsefive" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <p><a href="#">Total Request Pending - <b>0</b></p></a><hr>
                            <p><a href="CreateRequest">Create Request</a></p>
                        </div>
                    </div>
                </div>
            </div></div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div> -->
    
</div>
<!-- /.row -->
</div>
<!-- /.row (main row) -->
</div>
</div>

<div class="row">
<div class="col-lg-8 col-sm">
<div class="row">
<div class="col-lg-12 col-sm">
    <div class="card card-primary card-outline card-outline-tabs">
        <h4 class="p-3">Today's Task Calendar</h4>
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                    <?php $ttbyd = $this->Menu_model->get_ttbyd($uid,$tdate);
                    ?>
                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">
                        All <span class="badge badge-success"><?=$ttbyd[0]->ab?></span>
                    </a>
                    
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-call-tab" data-toggle="pill" href="#custom-tabs-four-call" role="tab" aria-controls="custom-tabs-four-call" aria-selected="false">
                        Call <span class="badge badge-success"><?=$ttbyd[0]->a?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-email-tab" data-toggle="pill" href="#custom-tabs-four-email" role="tab" aria-controls="custom-tabs-four-email" aria-selected="false">
                        Email <span class="badge badge-success"><?=$ttbyd[0]->b?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-meeting-tab" data-toggle="pill" href="#custom-tabs-four-meeting" role="tab" aria-controls="custom-tabs-four-meeting" aria-selected="false">
                        Meeting <span class="badge badge-success"><?=$ttbyd[0]->c?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-whatsapp-tab" data-toggle="pill" href="#custom-tabs-four-whatsapp" role="tab" aria-controls="custom-tabs-whatsapp" aria-selected="false">
                        WA<span class="badge badge-success"><?=$ttbyd[0]->e?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-review-tab" data-toggle="pill" href="#custom-tabs-four-review" role="tab" aria-controls="custom-tabs-review" aria-selected="false">
                        Review<span class="badge badge-success"><?=$ttbyd[0]->f?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-proposal-tab" data-toggle="pill" href="#custom-tabs-four-proposal" role="tab" aria-controls="custom-tabs-proposal" aria-selected="false">
                        Proposal<span class="badge badge-success"><?=$ttbyd[0]->g?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-barg-tab" data-toggle="pill" href="#custom-tabs-four-barg" role="tab" aria-controls="custom-tabs-four-barg" aria-selected="false">
                        Visit Meeting <span class="badge badge-success"><?=$ttbyd[0]->d?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-taskcheck-tab" data-toggle="pill" href="#custom-tabs-four-taskcheck" role="tab" aria-controls="custom-tabs-taskcheck" aria-selected="false">
                      <?php 
                      $gettodaysmom = $this->Menu_model->geTodaysMOMCheckTask($uid,$tdate);
                      $gettodaysmomcnt = sizeof($gettodaysmom);
                       ?>
                    Task Check <span class="badge badge-success"><?=$gettodaysmomcnt;?></span>
                    </a>
                  </li>
                
            </ul>
            
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header bg-info" id="headingOne" data-toggle="collapse" data-target="#collapse0911" aria-expanded="true" aria-controls="collapse0911">
                                <?php $ttbytime = $this->Menu_model->get_ttbytime($uid,$tdate,'09:00:00','11:00:00');
                                $ted = $this->Menu_model->get_ttbytimed($uid,$tdate,'09:00:00','11:00:00');
                                ?>
                                <b>9:00 AM to 11:00 AM</b><br>
                                Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) | Proposal(<?=$ted[0]->g?>)
                            </div>
                            <div id="collapse0911" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <?php
                                    foreach($ttbytime as $tt){
                                    $taid = $tt->actiontype_id;
                                    $taid=$this->Menu_model->get_action($taid);
                                    $time = $tt->appointmentdatetime;
                                    $time = date('h:i a', strtotime($time));
                                    ?>
                                    <div class="list-group-item list-group-item-action">
                                        <span class="mr-3 align-items-center">
                                            <i class="fa-solid fa-circle"></i>
                                        </span>
                                        <span class="flex"><?=$taid[0]->name?> |
                                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                            <small class="text-muted">Task Time:- <?=$time?></small>
                                        </span>
                                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span>
                                        <span class="text-right">
                                            <i class="fa-solid fa-forward"></i>
                                        </span>
                                    </div>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-light" id="headingTwo" data-toggle="collapse" data-target="#collapse1113" aria-expanded="false" aria-controls="collapse1113">
                                <?php $ttbytime = $this->Menu_model->get_ttbytime($uid,$tdate,'11:00:00','13:00:00');
                                $ted = $this->Menu_model->get_ttbytimed($uid,$tdate,'11:00:00','13:00:00');
                                ?>
                                <b>11:00 AM to 01:00 PM</b><br>
                                Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) | Proposal(<?=$ted[0]->g?>)
                            </div>
                            <div id="collapse1113" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    <?php
                                    foreach($ttbytime as $tt){
                                    $taid = $tt->actiontype_id;
                                    $taid=$this->Menu_model->get_action($taid);
                                    $time = $tt->appointmentdatetime;
                                    $time = date('h:i a', strtotime($time));
                                    ?>
                                    <div class="list-group-item list-group-item-action">
                                        <span class="mr-3 align-items-center">
                                            <i class="fa-solid fa-circle"></i>
                                        </span>
                                        <span class="flex"><?=$taid[0]->name?> |
                                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                            <small class="text-muted">Task Time:- <?=$time?></small>
                                        </span>
                                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span>
                                        <span class="text-right">
                                            <i class="fa-solid fa-forward"></i>
                                        </span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-info" id="headingThree" data-toggle="collapse" data-target="#collapse1315" aria-expanded="false" aria-controls="collapse1315">
                                <?php $ttbytime = $this->Menu_model->get_ttbytime($uid,$tdate,'13:00:00','15:00:00');
                                $ted = $this->Menu_model->get_ttbytimed($uid,$tdate,'13:00:00','15:00:00');
                                ?>
                                <b>01:00 PM to 03:00 PM</b><br>
                                Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) | Proposal(<?=$ted[0]->g?>)
                            </div>
                            <div id="collapse1315" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    <?php
                                    foreach($ttbytime as $tt){
                                    $taid = $tt->actiontype_id;
                                    $taid=$this->Menu_model->get_action($taid);
                                    $time = $tt->appointmentdatetime;
                                    $time = date('h:i a', strtotime($time));
                                    ?>
                                    <div class="list-group-item list-group-item-action">
                                        <span class="mr-3 align-items-center">
                                            <i class="fa-solid fa-circle"></i>
                                        </span>
                                        <span class="flex"><?=$taid[0]->name?> |
                                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                            <small class="text-muted">Task Time:- <?=$time?></small>
                                        </span>
                                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span>
                                        <span class="text-right">
                                            <i class="fa-solid fa-forward"></i>
                                        </span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-light" id="headingThree" data-toggle="collapse" data-target="#collapse1517" aria-expanded="false" aria-controls="collapse1517">
                                <?php $ttbytime = $this->Menu_model->get_ttbytime($uid,$tdate,'15:00:00','17:00:00');
                                $ted = $this->Menu_model->get_ttbytimed($uid,$tdate,'15:00:00','17:00:00');
                                ?>
                                <b>03:00 PM to 05:00 PM</b><br>
                                Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) |  Proposal(<?=$ted[0]->g?>)
                            </div>
                            <div id="collapse1517" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    <?php
                                    foreach($ttbytime as $tt){
                                    $taid = $tt->actiontype_id;
                                    $taid=$this->Menu_model->get_action($taid);
                                    $time = $tt->appointmentdatetime;
                                    $time = date('h:i a', strtotime($time));
                                    ?>
                                    <div class="list-group-item list-group-item-action">
                                        <span class="mr-3 align-items-center">
                                            <i class="fa-solid fa-circle"></i>
                                        </span>
                                        <span class="flex"><?=$taid[0]->name?> |
                                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                            <small class="text-muted">Task Time:- <?=$time?></small>
                                        </span>
                                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span>
                                        <span class="text-right">
                                            <i class="fa-solid fa-forward"></i>
                                        </span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header bg-info" id="headingThree" data-toggle="collapse" data-target="#collapse1719" aria-expanded="false" aria-controls="collapse1719">
                                <?php $ttbytime = $this->Menu_model->get_ttbytime($uid,$tdate,'17:00:00','19:00:00');
                                $ted = $this->Menu_model->get_ttbytimed($uid,$tdate,'17:00:00','19:00:00'); ?>
                                <b>05:00 PM to 07:00 PM</b></br>
                                Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) |  Proposal(<?=$ted[0]->g?>)
                            </div>
                            <div id="collapse1719" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    <?php
                                    foreach($ttbytime as $tt){
                                    $taid = $tt->actiontype_id;
                                    $taid=$this->Menu_model->get_action($taid);
                                    $time = $tt->appointmentdatetime;
                                    $time = date('h:i a', strtotime($time));
                                    ?>
                                    <div class="list-group-item list-group-item-action">
                                        <span class="mr-3 align-items-center">
                                            <i class="fa-solid fa-circle"></i>
                                        </span>
                                        <span class="flex"><?=$taid[0]->name?> |
                                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                            <small class="text-muted">Task Time:- <?=$time?></small>
                                        </span>
                                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span>
                                        <span class="text-right">
                                            <i class="fa-solid fa-forward"></i>
                                        </span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <hr>
                            <?php
                                
                              $pentask = sizeof($autotasktimenew);
                              if($pentask > 0){
                               $ast1=$autotasktimenew[0]->stime;
                               $aet2=$autotasktimenew[0]->etime;
                              ?>
                              <div class="card">
                                <div class="card-header bg-primary" id="headingThree33" data-toggle="collapse" data-target="#collapse91912" aria-expanded="false" aria-controls="collapse9121">

                                    <?php 
                                    $ttbytimedata = $this->Menu_model->get_ttbytimeAutotask($uid,$tdate,$ast1,$aet2);
                                    $curentDatwv = date("Y-m-d");
                                    $ted = $this->Menu_model->get_ttbytimedAutotask($uid, $curentDatwv,$ast1,$aet2);
                                      ?>
                                      <b>Auto Task - <?= $ast1 ?> to <?= $aet2 ?></b><br>
                                      Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) | MOM(<?=$ted[0]->f?>) | Proposal(<?=$ted[0]->g?>)
                                </div>
                                <div id="collapse91912" class="collapse" aria-labelledby="headingThree33" data-parent="#accordion">
                                  <div class="card-body">
                                    <?php
                                      $atai = 0;
                                      foreach($ttbytimedata as $ttdata){
                                      $taid = $ttdata->actiontype_id;
                                      $taid=$this->Menu_model->get_actionbyid($taid);
                                      $time = $ttdata->appointmentdatetime;
                                      $reminder = $ttdata->reminder;
                                      $time = date('h:i a', strtotime($time));
                              
                                    if($ttdata->autotask == 1){
                                      $style = 'background: antiquewhite;'; 
                                      $titletask = 'Auto Task';
                                    }else{
                                      $style =''; 
                                      $titletask='';
                                    }
                                    
                                  ?>
                                  <?php if($ttdata->actiontype_id=='2'){ ?>
                                    <div class="list-group-item list-group-item-action">
                                    <button id="add_act<?=$atai?>" value="<?=$ttdata->id?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                                       <span class="mr-3 align-items-center">
                                          <i class="fa-solid fa-circle"></i>
                                       </span>
                                       <span class="flex"><?=$taid[0]->name?> |
                                           <strong class="text-secondary mr-1"><?=$ttdata->compname?></strong><br>
                                           <small class="text-muted">Task Time:- <?=$time?></small>
                                        </span>
                                        <span class="p-3" style="color:<?=$ttdata->color?>;"><?=$ttdata->name?>
                                        </span>
                                        <span class="text-right">
                                            <i class="fa-solid fa-forward"></i>
                                        </span>
                                        <b><?php if($reminder>0){echo 'Reminder for This Task';}?></b>
                                        </button>
                                    </div>
                                    <?php $atai++; } ?>

                                    <?php if($ttdata->actiontype_id=='6'){ ?>
                                    <div class="list-group-item list-group-item-action">
                                    <button id="add_act<?=$atai?>" value="<?=$ttdata->id?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                                       <span class="mr-3 align-items-center">
                                          <i class="fa-solid fa-circle"></i>
                                       </span>
                                       <span class="flex"><?=$taid[0]->name?> |
                                           <strong class="text-secondary mr-1"><?=$ttdata->compname?></strong><br>
                                           <small class="text-muted">Task Time:- <?=$time?></small>
                                        </span>
                                        <span class="p-3" style="color:<?=$ttdata->color?>;"><?=$ttdata->name?>
                                        </span>
                                        <span class="text-right">
                                            <i class="fa-solid fa-forward"></i>
                                        </span>
                                        <b><?php if($reminder>0){echo 'Reminder for This Task';}?></b>
                                        </button>
                                    </div>
                                    <?php $atai++; }elseif($ttdata->actiontype_id=='1'){ ?>
                                      <div class="list-group-item list-group-item-action">
                                    <button id="add_act<?=$atai?>" value="<?=$ttdata->id?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                                       <span class="mr-3 align-items-center">
                                          <i class="fa-solid fa-circle"></i>
                                       </span>
                                       <span class="flex"><?=$taid[0]->name?> |
                                           <strong class="text-secondary mr-1"><?=$ttdata->compname?></strong><br>
                                           <small class="text-muted">Task Time:- <?=$time?></small>
                                        </span>
                                        <span class="p-3" style="color:<?=$ttdata->color?>;"><?=$ttdata->name?>
                                        </span>
                                        <span class="text-right">
                                            <i class="fa-solid fa-forward"></i>
                                        </span>
                                        <b><?php if($reminder>0){echo 'Reminder for This Task';}?></b>
                                        </button>
                                    </div>
                                    <?php } ?>
                                  <?php } ?>
                                  </div>
                                </div>
                              </div>
                            <?php } ?>






                        </div>
                        
                        <div class="card">
                            <div class="card-header bg-light" id="headingThree" data-toggle="collapse" data-target="#collapse9121" aria-expanded="false" aria-controls="collapse9121">
                                <?php $ttbytime = $this->Menu_model->get_ttbytime($uid,$tdate,'19:00:00','21:00:00');
                                $ted = $this->Menu_model->get_ttbytimed($uid,$tdate,'19:00:00','21:00:00');
                                ?>
                                <b>19:00 PM to 21:00 PM</b><br>
                                Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) |  Proposal(<?=$ted[0]->g?>)
                            </div>
                            <div id="collapse9121" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    <?php
                                    foreach($ttbytime as $tt){
                                    $taid = $tt->actiontype_id;
                                    $taid=$this->Menu_model->get_action($taid);
                                    $time = $tt->appointmentdatetime;
                                    $time = date('h:i a', strtotime($time));
                                    ?>
                                    <div class="list-group-item list-group-item-action">
                                        <span class="mr-3 align-items-center">
                                            <i class="fa-solid fa-circle"></i>
                                        </span>
                                        <span class="flex"><?=$taid[0]->name?> |
                                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                            <small class="text-muted">Task Time:- <?=$time?></small>
                                        </span>
                                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span>
                                        <span class="text-right">
                                            <i class="fa-solid fa-forward"></i>
                                        </span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-four-call" role="tabpanel" aria-labelledby="custom-tabs-four-call-tab">
                    <?php $aai=0;foreach($totalt as $tt){if($tt->plan==1){if($tt->actiontype_id=='1'){
                    $taid = $tt->actiontype_id;
                    $taid=$this->Menu_model->get_action($taid);
                    $time = $tt->appointmentdatetime;
                    $time = date('h:i a', strtotime($time));
                    ?>
                    
                    <div class="list-group-item list-group-item-action">
                        <button id="add_act<?=$aai?>" value="<?=$tt->id?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                        <input type="hidden" value="<?=$tt->id?>" id="tid">
                        <span class="mr-3 align-items-center">
                            <i class="fa-solid fa-circle"></i>
                        </span>
                        <span class="flex"><?=$taid[0]->name?> |
                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                            <small class="text-muted">Task Time:- <?=$time?></small>
                        </span>
                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                        </span>
                        <span class="text-right">
                            <i class="fa-solid fa-forward"></i>
                        </span>
                    </button></div>
                    <?php $aai++;}}} ?>
                </div></button>
                <div class="tab-pane fade" id="custom-tabs-four-email" role="tabpanel" aria-labelledby="custom-tabs-four-email-tab">
                    <?php foreach($totalt as $tt){if($tt->plan==1){if($tt->actiontype_id=='2'){
                    ?>
                    <div class="list-group-item list-group-item-action">
                        <button id="add_act<?=$aai?>" value="<?=$tt->id?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                        
                        <span class="mr-3 align-items-center">
                            <i class="fa-solid fa-circle"></i>
                        </span>
                        <span class="flex">
                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                            <small class="text-muted">Next Task:- </small>
                        </span>
                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                        </span>
                        <span class="text-right">
                            <i class="fa-solid fa-forward"></i>
                        </span>
                    </button></div>
                    <?php $aai++;}}} ?>
                </div>
                <div class="tab-pane fade" id="custom-tabs-four-meeting" role="tabpanel" aria-labelledby="custom-tabs-four-meeting-tab">
                    <?php foreach($totalt as $tt){if($tt->plan==1){if($tt->actiontype_id=='3'){
                    ?>
                    <div class="list-group-item list-group-item-action">
                        <button id="add_act<?=$aai?>" value="<?=$tt->id?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                        
                        <span class="mr-3 align-items-center">
                            <i class="fa-solid fa-circle"></i>
                        </span>
                        <span class="flex">
                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                            <small class="text-muted">Next Task:- </small>
                        </span>
                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                        </span>
                        <span class="text-right">
                            <i class="fa-solid fa-forward"></i>
                        </span>
                    </button></div>
                    <?php $aai++;}}} ?>
                </div>
                <div class="tab-pane fade" id="custom-tabs-four-whatsapp" role="tabpanel" aria-labelledby="custom-tabs-four-whatsapp-tab">
                    <?php foreach($totalt as $tt){if($tt->plan==1){if($tt->actiontype_id=='5'){
                    ?>
                    <div class="list-group-item list-group-item-action">
                        <button id="add_act<?=$aai?>" value="<?=$tt->id?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                        <span class="mr-3 align-items-center">
                            <i class="fa-solid fa-circle"></i>
                        </span>
                        <span class="flex">
                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                            <small class="text-muted">Next Task:- </small>
                        </span>
                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                        </span>
                        <span class="text-right">
                            <i class="fa-solid fa-forward"></i>
                        </button></span>
                    </div>
                    <?php $aai++;}}} ?>
                </div>
                
                <div class="tab-pane fade" id="custom-tabs-four-proposal" role="tabpanel" aria-labelledby="custom-tabs-four-proposal-tab">
                    <?php foreach($totalt as $tt){if($tt->plan==1){if($tt->actiontype_id=='7'){
                    ?>
                    <div class="list-group-item list-group-item-action">
                        <button id="add_act<?=$aai?>" value="<?=$tt->id?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                        <span class="mr-3 align-items-center">
                            <i class="fa-solid fa-circle"></i>
                        </span>
                        <span class="flex">
                            <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                            <small class="text-muted">Next Task:- </small>
                        </span>
                        <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                        </span>
                        <span class="text-right">
                            <i class="fa-solid fa-forward"></i>
                        </button></span>
                    </div>
                    <?php $aai++;}}} ?>
                </div>
                
                <div class="tab-pane fade" id="custom-tabs-four-taskcheck" role="tabpanel" aria-labelledby="custom-tabs-four-taskcheck-tab">
                  <div class="card-header text-center bg-light" style="border-radius:unset" >
            <p>
              <?php 
            
              $groupedByActionTypes = [];
              foreach ( $gettodaysmom as $objects) {
                  $actionTypeId = $objects->actiontype_id;
                  if (!isset($groupedByActionTypes[$actionTypeId])) {
                      $groupedByActionTypes[$actionTypeId] = [];
                  }
                  $groupedByActionTypes[$actionTypeId][] = $objects;
              }

            foreach ($groupedByActionTypes as $key => $getchk){
                  $taid=$this->Menu_model->get_actionbyid($key);
                  $checkname = $taid[0]->name;
                  $getSize = sizeof($getchk); ?>
                <a class="btn btn-primary checkingreport" data-toggle="collapse" href="#collapseCheck<?=$key?>" role="button" aria-expanded="false" aria-controls="collapseCheck<?=$key?>">
                  <?= $checkname.' ('.$getSize.')'; ?>
                </a>
          <?php } ?>
          <?php
             foreach ($groupedByActionTypes as $key => $checkTasks) { ?> 
              <div class="collapse multi-collapse"  id="collapseCheck<?=$key?>">
              <div class="card card-body">
              <?php 
              foreach ($checkTasks as $checkTask) {
                  $ce_tskid = $checkTask->id;
                  $tskid = $checkTask->actiontype_id;
                  $reviewtype = $checkTask->reviewtype;
                  $taid=$this->Menu_model->get_actionbyid($tskid);

                  $time = $checkTask->appointmentdatetime;
                  $time = date('h:i a', strtotime($time));
                 
                  if($tskid == 18){
                    $reqmom = $this->Menu_model->getRequestMOMBYID($reviewtype);
                    $reqmom_user = $reqmom[0]->user_id;
                    $reqmom_uname = $this->Menu_model->get_userbyid($reqmom_user)[0]->name;
                  }
                  if($tskid == 19){
                    $reqmom_uname = '';
                  }
              ?>
              <a href="<?=base_url();?>Management/MomDataCheck/<?=$reviewtype?>/<?=$ce_tskid?>">
                  <div class="list-group-item list-group-item-action checkrepoData">
                      <span class="flex-wrap">
                          <strong class="text-secondary mr-1" style="font-size: 14px;" ><?=$checkTask->compname?> - ( <?= $checkname; ?> )</strong><br>
                          <small class="text-secondary mr-1"> Request Name - <?=$reqmom_uname?></small><br>
                          <small class="text-muted">Check Time:- <?=$time?></small>
                      </span>
                  </div>
              </a>
               <?php  } ?>
               </div>
              </div>
              <?php }  ?>
            </div>
            <hr>
            <style>
              .checkingreport{
                margin: 4px;
              }
              .checkrepoData{
                margin: 4px;
                background: beige;
                color: white !important;
              }
            </style>
                  </div>



                <div class="tab-pane fade" id="custom-tabs-four-review" role="tabpanel" aria-labelledby="custom-tabs-four-review-tab">
                    <?php $pr = $this->Menu_model->get_pstreview($uid);
                    foreach($pr as $pr){?>
                    <a href="BDUFunnel/<?=$pr->bdid?>"><div class="list-group-item list-group-item-action">
                        <span class="mr-3 align-items-center">
                            <i class="fa-solid fa-circle"></i>
                        </span>
                        <span class="flex">
                            <strong class="text-secondary mr-1"><?=$pr->meetinglink?></strong><br>
                            <small class="text-muted">BD Name :- <?=$pr->bdid?></small>
                            <small class="text-muted">Date Time :- <?=$pr->sdatet?></small>
                        </span>
                        <span class="text-right">
                            <i class="fa-solid fa-forward"></i>
                        </span>
                    </div></a>
                    <?php } ?>
                </div>
                
                <div class="tab-pane fade" id="custom-tabs-four-barg" role="tabpanel" aria-labelledby="custom-tabs-four-barg-tab">
                    
                    <div class="list-group-item list-group-item-action">
                        <?php
                        foreach($barg as $brg){
                        $bs = $brg->status;
                        $bscid = $brg->cid;
                        
                        $bscidd = $this->Menu_model->get_cdbyid($bscid);
                        $mitinfoname = $bscidd[0]->compname;
                        ?>
                        <?php if($bs=='Pending'){?>
                        <button type="button" value="<?=$brg->id?>" class="btn btn-success" id="startm"><?= $mitinfoname ?>- Start Meeting</button> <hr>
                        <?php }if($bs=='Start'){?>
                        <button type="button" value="<?=$brg->id?>" class="btn btn-info" id="closem"><?= $mitinfoname ?>- Close Meeting</button><hr>
                        <?php }} ?>
                    </div>
                    <div class="list-group-item list-group-item-action">
                        <?php foreach($barg as $br){if($br->status=='RPClose'){;?>
                        <a href="BMNewLead/<?=$br->id?>"><?=$br->company_name?><button type="button" class="btn btn-danger">Create New Lead</button></a>
                        <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
        </div><!-- /.card -->
    </div>
    <div class="col-lg-12 col-sm">
        <div class="card card-primary card-outline card-outline-tabs">
            <h4 class="p-3">Today's Task Completed</h4>
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <?php $ttbydc = $this->Menu_model->get_ttbydc($uid,$tdate);
                        ?>
                        <a class="nav-link active" id="custom-tabs-four-homea-tab" data-toggle="pill" href="#custom-tabs-four-homea" role="tab" aria-controls="custom-tabs-four-homea" aria-selected="true">
                            All <span class="badge badge-success"><?=$ttbydc[0]->ab?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-calla-tab" data-toggle="pill" href="#custom-tabs-four-calla" role="tab" aria-controls="custom-tabs-four-calla" aria-selected="false">
                            Call <span class="badge badge-success"><?=$ttbydc[0]->a?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-emaila-tab" data-toggle="pill" href="#custom-tabs-four-emaila" role="tab" aria-controls="custom-tabs-four-emaila" aria-selected="false">
                            Email <span class="badge badge-success"><?=$ttbydc[0]->b?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-meetinga-tab" data-toggle="pill" href="#custom-tabs-four-meetinga" role="tab" aria-controls="custom-tabs-four-meetinga" aria-selected="false">
                            Meeting <span class="badge badge-success"><?=$ttbydc[0]->c?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-whatsappa-tab" data-toggle="pill" href="#custom-tabs-four-whatsappa" role="tab" aria-controls="custom-tabs-whatsappa" aria-selected="false">
                            WA<span class="badge badge-success"><?=$ttbydc[0]->e?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-reviewa-tab" data-toggle="pill" href="#custom-tabs-four-reviewa" role="tab" aria-controls="custom-tabs-reviewa" aria-selected="false">
                            Review<span class="badge badge-success"><?=$ttbydc[0]->f?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-proposala-tab" data-toggle="pill" href="#custom-tabs-four-proposala" role="tab" aria-controls="custom-tabs-proposala" aria-selected="false">
                            Proposal<span class="badge badge-success"><?=$ttbydc[0]->g?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-barg-taba" data-toggle="pill" href="#custom-tabs-four-barga" role="tab" aria-controls="custom-tabs-four-barga" aria-selected="false">
                            Visit Meeting <span class="badge badge-success"><?=$ttbydc[0]->d?></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-homea" role="tabpanel" aria-labelledby="custom-tabs-four-homea-tab">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header bg-info" id="headingOne" data-toggle="collapse" data-target="#collapse0911" aria-expanded="true" aria-controls="collapse0911">
                                    <?php $ttbytime = $this->Menu_model->get_ttbytimec($uid,$tdate,'09:00:00','11:00:00');
                                    $ted = $this->Menu_model->get_ttbytimedc($uid,$tdate,'09:00:00','11:00:00');
                                    ?>
                                    <b>9:00 AM to 11:00 AM</b><br>
                                    Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) |  Proposal(<?=$ted[0]->g?>)
                                </div>
                                <div id="collapse0911" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php
                                        foreach($ttbytime as $tt){
                                        $taid = $tt->actiontype_id;
                                        $taid=$this->Menu_model->get_action($taid);
                                        $time = $tt->appointmentdatetime;
                                        $time = date('h:i a', strtotime($time));
                                        ?>
                                        <div class="list-group-item list-group-item-action">
                                       <span class="mr-3 align-items-center">
                                          <i class="fa-solid fa-circle"></i>
                                       </span>
                                       <span class="flex"><?=$taid[0]->name?> |
                                        <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span>Task Time : <?=$time?></span>
                                        </span> |
                                        Status : <span style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span> |
                                        <span class="text-right">
                                        Action : <?= $tt->actontaken; ?>
                                        </span> |
                                        <span class="text-right">
                                        Purpose  : <?= $tt->purpose_achieved; ?>
                                        </span> |
                                        <span class="text-right">
                                        Remarks  : <?php echo empty($tt->remarks) ? 'NA' : htmlspecialchars($tt->remarks); ?>
                                        </span> |
                                        <span class="text-right">
                                            Comments  : 
                                            <?php 
                                             $comment_by = $tt->comment_by;
                                             if($comment_by !== '' && $comment_by !== NULL){
                                                  $decode_comments    = base64_decode($tt->comments);
                                                  $decode_thnkscomments    = base64_decode($tt->thnkscomments);
                                                  $udetail            = $this->Menu_model->get_userbyid($comment_by);
                                                  $uname              = $udetail[0]->name;
                                                  $message = $decode_comments.' - <b>'.$uname.'</b>';
                                                  echo $message;
                                              }else{
                                                  echo $message = '';
                                              }
                                            ?>
                                            </span>
                                    </div>
                                        <?php } ?>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-light" id="headingTwo" data-toggle="collapse" data-target="#collapse1113" aria-expanded="false" aria-controls="collapse1113">
                                    <?php $ttbytime = $this->Menu_model->get_ttbytimec($uid,$tdate,'11:00:00','13:00:00');
                                    $ted = $this->Menu_model->get_ttbytimedc($uid,$tdate,'11:00:00','13:00:00');
                                    ?>
                                    <b>11:00 AM to 01:00 PM</b><br>
                                    Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) |  Proposal(<?=$ted[0]->g?>)
                                </div>
                                <div id="collapse1113" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php
                                        foreach($ttbytime as $tt){
                                        $taid = $tt->actiontype_id;
                                        $taid=$this->Menu_model->get_action($taid);
                                        $time = $tt->appointmentdatetime;
                                        $time = date('h:i a', strtotime($time));
                                        ?>
                                        <div class="list-group-item list-group-item-action">
                                       <span class="mr-3 align-items-center">
                                          <i class="fa-solid fa-circle"></i>
                                       </span>
                                       <span class="flex"><?=$taid[0]->name?> |
                                        <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span>Task Time : <?=$time?></span>
                                        </span> |
                                        Status : <span style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span> |
                                        <span class="text-right">
                                        Action : <?= $tt->actontaken; ?>
                                        </span> |
                                        <span class="text-right">
                                        Purpose  : <?= $tt->purpose_achieved; ?>
                                        </span> |
                                        <span class="text-right">
                                        Remarks  : <?php echo empty($tt->remarks) ? 'NA' : htmlspecialchars($tt->remarks); ?>
                                        </span> |
                                        <span class="text-right">
                                            Comments  : 
                                            <?php 
                                             $comment_by = $tt->comment_by;
                                             if($comment_by !== '' && $comment_by !== NULL){
                                                  $decode_comments    = base64_decode($tt->comments);
                                                  $decode_thnkscomments    = base64_decode($tt->thnkscomments);
                                                  $udetail            = $this->Menu_model->get_userbyid($comment_by);
                                                  $uname              = $udetail[0]->name;
                                                  $message = $decode_comments.' - <b>'.$uname.'</b>';
                                                  echo $message;
                                              }else{
                                                  echo $message = '';
                                              }
                                            ?>
                                            </span>
                                    </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-info" id="headingThree" data-toggle="collapse" data-target="#collapse1315" aria-expanded="false" aria-controls="collapse1315">
                                    <?php $ttbytime = $this->Menu_model->get_ttbytimec($uid,$tdate,'13:00:00','15:00:00');
                                    $ted = $this->Menu_model->get_ttbytimedc($uid,$tdate,'13:00:00','15:00:00');
                                    ?>
                                    <b>01:00 PM to 03:00 PM</b><br>
                                    Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) |  Proposal(<?=$ted[0]->g?>)
                                </div>
                                <div id="collapse1315" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php
                                        foreach($ttbytime as $tt){
                                        $taid = $tt->actiontype_id;
                                        $taid=$this->Menu_model->get_action($taid);
                                        $time = $tt->appointmentdatetime;
                                        $time = date('h:i a', strtotime($time));
                                        ?>
                                      <div class="list-group-item list-group-item-action">
                                       <span class="mr-3 align-items-center">
                                          <i class="fa-solid fa-circle"></i>
                                       </span>
                                       <span class="flex"><?=$taid[0]->name?> |
                                        <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span>Task Time : <?=$time?></span>
                                        </span> |
                                        Status : <span style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span> |
                                        <span class="text-right">
                                        Action : <?= $tt->actontaken; ?>
                                        </span> |
                                        <span class="text-right">
                                        Purpose  : <?= $tt->purpose_achieved; ?>
                                        </span> |
                                        <span class="text-right">
                                        Remarks  : <?php echo empty($tt->remarks) ? 'NA' : htmlspecialchars($tt->remarks); ?>
                                        </span> |
                                        <span class="text-right">
                                            Comments  : 
                                            <?php 
                                             $comment_by = $tt->comment_by;
                                             if($comment_by !== '' && $comment_by !== NULL){
                                                  $decode_comments    = base64_decode($tt->comments);
                                                  $decode_thnkscomments    = base64_decode($tt->thnkscomments);
                                                  $udetail            = $this->Menu_model->get_userbyid($comment_by);
                                                  $uname              = $udetail[0]->name;
                                                  $message = $decode_comments.' - <b>'.$uname.'</b>';
                                                  echo $message;
                                              }else{
                                                  echo $message = '';
                                              }
                                            ?>
                                            </span>
                                    </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-light" id="headingThree" data-toggle="collapse" data-target="#collapse1517" aria-expanded="false" aria-controls="collapse1517">
                                    <?php $ttbytime = $this->Menu_model->get_ttbytimec($uid,$tdate,'15:00:00','17:00:00');
                                    $ted = $this->Menu_model->get_ttbytimedc($uid,$tdate,'15:00:00','17:00:00');
                                    ?>
                                    <b>03:00 PM to 05:00 PM</b><br>
                                    Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) |  Proposal(<?=$ted[0]->g?>)
                                </div>
                                <div id="collapse1517" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php
                                        foreach($ttbytime as $tt){
                                        $taid = $tt->actiontype_id;
                                        $taid=$this->Menu_model->get_action($taid);
                                        $time = $tt->appointmentdatetime;
                                        $time = date('h:i a', strtotime($time));
                                        ?>
                                        <div class="list-group-item list-group-item-action">
                                       <span class="mr-3 align-items-center">
                                          <i class="fa-solid fa-circle"></i>
                                       </span>
                                       <span class="flex"><?=$taid[0]->name?> |
                                        <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span>Task Time : <?=$time?></span>
                                        </span> |
                                        Status : <span style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span> |
                                        <span class="text-right">
                                        Action : <?= $tt->actontaken; ?>
                                        </span> |
                                        <span class="text-right">
                                        Purpose  : <?= $tt->purpose_achieved; ?>
                                        </span> |
                                        <span class="text-right">
                                        Remarks  : <?php echo empty($tt->remarks) ? 'NA' : htmlspecialchars($tt->remarks); ?>
                                        </span> |
                                        <span class="text-right">
                                            Comments  : 
                                            <?php 
                                             $comment_by = $tt->comment_by;
                                             if($comment_by !== '' && $comment_by !== NULL){
                                                  $decode_comments    = base64_decode($tt->comments);
                                                  $decode_thnkscomments    = base64_decode($tt->thnkscomments);
                                                  $udetail            = $this->Menu_model->get_userbyid($comment_by);
                                                  $uname              = $udetail[0]->name;
                                                  $message = $decode_comments.' - <b>'.$uname.'</b>';
                                                  echo $message;
                                              }else{
                                                  echo $message = '';
                                              }
                                            ?>
                                            </span>
                                    </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-info" id="headingThree" data-toggle="collapse" data-target="#collapse1719" aria-expanded="false" aria-controls="collapse1719">
                                    <?php $ttbytime = $this->Menu_model->get_ttbytimec($uid,$tdate,'17:00:00','19:00:00');
                                    $ted = $this->Menu_model->get_ttbytimedc($uid,$tdate,'17:00:00','19:00:00'); ?>
                                    <b>05:00 PM to 07:00 PM</b></br>
                                    Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) |  Proposal(<?=$ted[0]->g?>)
                                </div>
                                <div id="collapse1719" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php
                                        foreach($ttbytime as $tt){
                                        $taid = $tt->actiontype_id;
                                        $taid=$this->Menu_model->get_action($taid);
                                        $time = $tt->appointmentdatetime;
                                        $time = date('h:i a', strtotime($time));
                                        ?>
                                        <div class="list-group-item list-group-item-action">
                                       <span class="mr-3 align-items-center">
                                          <i class="fa-solid fa-circle"></i>
                                       </span>
                                       <span class="flex"><?=$taid[0]->name?> |
                                        <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span>Task Time : <?=$time?></span>
                                        </span> |
                                        Status : <span style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span> |
                                        <span class="text-right">
                                        Action : <?= $tt->actontaken; ?>
                                        </span> |
                                        <span class="text-right">
                                        Purpose  : <?= $tt->purpose_achieved; ?>
                                        </span> |
                                        <span class="text-right">
                                        Remarks  : <?php echo empty($tt->remarks) ? 'NA' : htmlspecialchars($tt->remarks); ?>
                                        </span> |
                                        <span class="text-right">
                                            Comments  : 
                                            <?php 
                                             $comment_by = $tt->comment_by;
                                             if($comment_by !== '' && $comment_by !== NULL){
                                                  $decode_comments    = base64_decode($tt->comments);
                                                  $decode_thnkscomments    = base64_decode($tt->thnkscomments);
                                                  $udetail            = $this->Menu_model->get_userbyid($comment_by);
                                                  $uname              = $udetail[0]->name;
                                                  $message = $decode_comments.' - <b>'.$uname.'</b>';
                                                  echo $message;
                                              }else{
                                                  echo $message = '';
                                              }
                                            ?>
                                            </span>
                                    </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-light" id="headingThree" data-toggle="collapse" data-target="#collapse9121" aria-expanded="false" aria-controls="collapse9121">
                                    <?php $ttbytime = $this->Menu_model->get_ttbytimec($uid,$tdate,'19:00:00','21:00:00');
                                    $ted = $this->Menu_model->get_ttbytimedc($uid,$tdate,'19:00:00','21:00:00');
                                    ?>
                                    <b>19:00 PM to 21:00 PM</b><br>
                                    Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) |  Proposal(<?=$ted[0]->g?>)
                                </div>
                                <div id="collapse9121" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php
                                        foreach($ttbytime as $tt){
                                        $taid = $tt->actiontype_id;
                                        $taid=$this->Menu_model->get_action($taid);
                                        $time = $tt->appointmentdatetime;
                                        $time = date('h:i a', strtotime($time));
                                        ?>
                                     <div class="list-group-item list-group-item-action">
                                       <span class="mr-3 align-items-center">
                                          <i class="fa-solid fa-circle"></i>
                                       </span>
                                       <span class="flex"><?=$taid[0]->name?> |
                                        <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span>Task Time : <?=$time?></span>
                                        </span> |
                                        Status : <span style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span> |
                                        <span class="text-right">
                                        Action : <?= $tt->actontaken; ?>
                                        </span> |
                                        <span class="text-right">
                                        Purpose  : <?= $tt->purpose_achieved; ?>
                                        </span> |
                                        <span class="text-right">
                                        Remarks  : <?php echo empty($tt->remarks) ? 'NA' : htmlspecialchars($tt->remarks); ?>
                                        </span> |
                                        <span class="text-right">
                                            Comments  : 
                                            <?php 
                                             $comment_by = $tt->comment_by;
                                             if($comment_by !== '' && $comment_by !== NULL){
                                                  $decode_comments    = base64_decode($tt->comments);
                                                  $decode_thnkscomments    = base64_decode($tt->thnkscomments);
                                                  $udetail            = $this->Menu_model->get_userbyid($comment_by);
                                                  $uname              = $udetail[0]->name;
                                                  $message = $decode_comments.' - <b>'.$uname.'</b>';
                                                  echo $message;
                                              }else{
                                                  echo $message = '';
                                              }
                                            ?>
                                            </span>
                                    </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <?php
                              $pentask = sizeof($autotasktimenew);
                              if($pentask > 0){
                               $ast1=$autotasktimenew[0]->stime;
                               $aet2=$autotasktimenew[0]->etime;
                              ?>
                              <div class="card">
                                <div class="card-header bg-primary" id="headingThree31" data-toggle="collapse" data-target="#collapse9191" aria-expanded="false" aria-controls="collapse9121">

                                    <?php 
                                    $curddate = date("Y-m-d");
                                    $ttbytime = $this->Menu_model->get_ttbytimecAutotask1($uid,$tdate,$ast1,$aet2);
                                    $ted = $this->Menu_model->get_ttbytimedcAutotask($uid,$curddate,$ast1,$aet2);
                                      ?>
                                      <b>Auto Task - <?= $ast1 ?> to <?= $aet2 ?></b><br>
                                      Total Task <?=$ted[0]->ab?> | Call(<?=$ted[0]->a?>) | Email(<?=$ted[0]->b?>) | Whatsapp(<?=$ted[0]->e?>) | Meeting(<?=$ted[0]->c+$ted[0]->d?>) | MOM(<?=$ted[0]->f?>) | Proposal(<?=$ted[0]->g?>)
                                </div>
                                <div id="collapse9191" class="collapse" aria-labelledby="headingThree31" data-parent="#accordion">
                                  <div class="card-body">
                                   <?php
                                      foreach($ttbytime as $tt){
                                      $taid = $tt->actiontype_id;
                                      $taid=$this->Menu_model->get_actionbyid($taid);
                                      $time = $tt->appointmentdatetime;
                                      $time = date('h:i a', strtotime($time));
                                   ?>
                                   <div class="list-group-item list-group-item-action">
                                       <span class="mr-3 align-items-center">
                                          <i class="fa-solid fa-circle"></i>
                                       </span>
                                       <span class="flex"><?=$taid[0]->name?> |
                                        <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span>Task Time : <?=$time?></span>
                                        </span> |
                                        Status : <span style="color:<?=$tt->color?>;"><?=$tt->name?>
                                        </span> |
                                        <span class="text-right">
                                        Action : <?= $tt->actontaken; ?>
                                        </span> |
                                        <span class="text-right">
                                        Purpose  : <?= $tt->purpose_achieved; ?>
                                        </span> |
                                        <span class="text-right">
                                        Remarks  : <?php echo empty($tt->remarks) ? 'NA' : htmlspecialchars($tt->remarks); ?>
                                        </span> |
                                        <span class="text-right">
                                            Comments  : 
                                            <?php 
                                             $comment_by = $tt->comment_by;
                                             if($comment_by !== '' && $comment_by !== NULL){
                                                  $decode_comments    = base64_decode($tt->comments);
                                                  $decode_thnkscomments    = base64_decode($tt->thnkscomments);
                                                  $udetail            = $this->Menu_model->get_userbyid($comment_by);
                                                  $uname              = $udetail[0]->name;
                                                  $message = $decode_comments.' - <b>'.$uname.'</b>';
                                                  echo $message;
                                              }else{
                                                  echo $message = '';
                                              }
                                            ?>
                                            </span>
                                    </div>
                                  <?php } ?>
                                  </div>
                                </div>
                              </div>
<?php } ?>


                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-calla" role="tabpanel" aria-labelledby="custom-tabs-four-calla-tab">
                        <?php foreach($ttdone as $tt){if($tt->plan==1){if($tt->actiontype_id=='1'){
                        $taid = $tt->actiontype_id;
                        $taid=$this->Menu_model->get_action($taid);
                        $time = $tt->appointmentdatetime;
                        $time = date('h:i a', strtotime($time));
                        ?>
                        
                        <div class="list-group-item list-group-item-action">
                            <button id="comp_task<?=$aai?>" value="<?=$tt->id?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                            <input type="hidden" value="<?=$tt->id?>" id="tid">
                            <span class="mr-3 align-items-center">
                                <i class="fa-solid fa-circle"></i>
                            </span>
                            <span class="flex"><?=$taid[0]->name?> |
                                <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                <small class="text-muted">Task Time:- <?=$time?></small>
                            </span>
                            <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                            </span>
                            <span class="text-right">
                                <i class="fa-solid fa-forward"></i>
                            </span>
                        </div></button>
                        <?php $aai++;}}} ?>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-emaila" role="tabpanel" aria-labelledby="custom-tabs-four-emaila-tab">
                        <?php foreach($ttdone as $tt){if($tt->plan==1){if($tt->actiontype_id=='2'){
                        ?>
                        <a href="CompanyDetails/<?=$tt->cid?>/?tid=<?=$tt->id?>"><div class="list-group-item list-group-item-action">
                            <span class="mr-3 align-items-center">
                                <i class="fa-solid fa-circle"></i>
                            </span>
                            <span class="flex">
                                <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                <small class="text-muted">Next Task:- </small>
                            </span>
                            <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                            </span>
                            <span class="text-right">
                                <i class="fa-solid fa-forward"></i>
                            </span>
                        </div></a>
                        <?php }}} ?>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-meetinga" role="tabpanel" aria-labelledby="custom-tabs-four-meetinga-tab">
                        <?php foreach($ttdone as $tt){if($tt->plan==1){if($tt->actiontype_id=='3'){
                        ?>
                        <a href="CompanyDetails/<?=$tt->cid?>/?tid=<?=$tt->id?>"><div class="list-group-item list-group-item-action">
                            <span class="mr-3 align-items-center">
                                <i class="fa-solid fa-circle"></i>
                            </span>
                            <span class="flex">
                                <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                <small class="text-muted">Next Task:- </small>
                            </span>
                            <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                            </span>
                            <span class="text-right">
                                <i class="fa-solid fa-forward"></i>
                            </span>
                        </div></a>
                        <?php }}} ?>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-whatsappa" role="tabpanel" aria-labelledby="custom-tabs-four-whatsappa-tab">
                        <?php foreach($ttdone as $tt){if($tt->plan==1){if($tt->actiontype_id=='5'){
                        ?>
                        <a href="CompanyDetails/<?=$tt->cid?>/?tid=<?=$tt->id?>"><div class="list-group-item list-group-item-action">
                            <span class="mr-3 align-items-center">
                                <i class="fa-solid fa-circle"></i>
                            </span>
                            <span class="flex">
                                <strong class="text-secondary mr-1"><?=$tt->compname?></strong><br>
                                <small class="text-muted">Next Task:- </small>
                            </span>
                            <span class="p-3" style="color:<?=$tt->color?>;"><?=$tt->name?>
                            </span>
                            <span class="text-right">
                                <i class="fa-solid fa-forward"></i>
                            </span>
                        </div></a>
                        <?php }}} ?>
                    </div>
                    
                    <div class="tab-pane fade" id="custom-tabs-four-barga" role="tabpanel" aria-labelledby="custom-tabs-four-barga-tab">
                        
                        
                    </div>
                </div>
            </div>
        </div></div></div></div>
        <div class="col-lg-4 col-sm">
            
        <?php 
                $plannertime = $this->Menu_model->autotasktimenew($uid,$tdate);
                $plannertimecnt = sizeof($plannertime);
                if($plannertimecnt > 0){
                  $start_tttpft =  $plannertime[0]->start_tttpft;
                  $end_tttpft   =  $plannertime[0]->end_tttpft; ?>
                  <div class="card p-2 text-center bg-success text-white">
                    <span> <b>Todays Planner Time : <?=$start_tttpft;?> to <?=$end_tttpft;?></b> </span>
                  </div>
                <?php  } ?> 
            <div class="card card-primary card-outline card-outline-tabs">
                <?php $ptd = $this->Menu_model->get_tptd($uid,$tdate);
                $ptsd = $this->Menu_model->get_tptsd($uid,$tdate);?>
                <div class="card-header text-center bg-info"><b>Created Pending Task to be Schedule</b></div>
                <div class="card-header text-center bg-light"><b>
                    Total Task <?=$ptd[0]->ab?> | Call(<?=$ptd[0]->a?>) | Email(<?=$ptd[0]->b?>) | Whatsapp(<?=$ptd[0]->e?>) | Meeting(<?=$ptd[0]->c+$ptd[0]->d?>) | MOM(<?=$ptd[0]->f?>) | Proposal(<?=$ptd[0]->g?>)
                </b></div>
                <div class="card-header text-center bg-light"><b>
                    Open(<?=$ptsd[0]->a?>) | Open RPEM(<?=$ptsd[0]->b?>) | Rechaout(<?=$ptsd[0]->c?>) | Tentative(<?=$ptsd[0]->d?>) | WDL(<?=$ptsd[0]->e?>) | NI(<?=$ptsd[0]->f?>) | TTD(<?=$ptsd[0]->g?>) | WNO(<?=$ptsd[0]->h?>) | Positive(<?=$ptsd[0]->i?>) | Very Positive(<?=$ptsd[0]->j?>) | Closure(<?=$ptsd[0]->k?>)
                </b></div>
                <div class="card-body">
                    <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ai=0;foreach($totalt as $tt){if($tt->plan==0){if($tt->autotask==1){?>
                            <tr>
                                <td>
                                    <button id="add_plan<?=$ai?>" value="<?=$tt->id?>" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                                    <?=$tt->aname?> |
                                    <strong class="text-secondary"><?=$tt->compname?> | <b style="color:<?=$tt->color?>"><?=$tt->name?></b></strong>
                                    </button>
                                </td>
                            </tr>
                            <?php $ai++;}}} ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        
       
        
    </div>
</div>
</div>
</div>
</div>
</div>



<style>
#myInput {
background-position: 10px 12px;
background-repeat: no-repeat;
width: 100%;
font-size: 16px;
padding: 12px 20px 12px 40px;
border: 1px solid #ddd;
margin-bottom: 12px;
}
#myUL {
list-style-type: none;
padding: 0;
margin: 0;
}
#myUL li a {
border: 1px solid #ddd;
margin-top: -1px; /* Prevent double borders */
background-color: #f6f6f6;
padding: 12px;
text-decoration: none;
font-size: 18px;
color: black;
display: block
}
#myUL li a:hover:not(.header) {
background-color: #eee;
}
</style>
<script>
function myFunction() {
var input, filter, ul, li, a, i, txtValue;
input = document.getElementById("myInput");
filter = input.value.toUpperCase();
ul = document.getElementById("myUL");
li = ul.getElementsByTagName("li");
for (i = 0; i < li.length; i++) {
a = li[i].getElementsByTagName("a")[0];
txtValue = a.textContent || a.innerText;
if (txtValue.toUpperCase().indexOf(filter) > -1) {
li[i].style.display = "";
} else {
li[i].style.display = "none";
}
}
}
</script>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
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
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
animationEnabled: true,
theme: "light1",
title:{
text: "Goals of This Month"
},
axisY:{
includeZero: true
},
legend:{
cursor: "pointer",
verticalAlign: "center",
horizontalAlign: "right",
itemclick: toggleDataSeries
},
data: [{
type: "column",
name: "Real Trees",
indexLabel: "{y}",
yValueFormatString: "$#0.##",
showInLegend: true,
dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
},{
type: "column",
name: "Artificial Trees",
indexLabel: "{y}",
yValueFormatString: "$#0.##",
showInLegend: true,
dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
}]
});
chart.render();

function toggleDataSeries(e){
if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
e.dataSeries.visible = false;
}
else{
e.dataSeries.visible = true;
}
chart.render();
}

}
</script>
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
"responsive": true, "lengthChange": false, "autoWidth": false
}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

$("#example2").DataTable({
"responsive": true, "lengthChange": false, "autoWidth": false
}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
</body>
</html>