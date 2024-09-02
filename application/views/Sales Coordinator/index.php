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

<?php

 $udetail = $this->Menu_model->get_userbyid($uid);
 $admid = $udetail[0]->aadmin;
  $bd = $this->Menu_model->get_userbyaSCid($admid);

$day = $this->Menu_model->get_daydbyad1($admid,$tdate);
$tttd = $this->Menu_model->get_tteamtdSC($admid,$tdate);
$tbmeetd = $this->Menu_model->get_tbmeetdbyaid($admid,$tdate);
$teamfu = $this->Menu_model->get_mbdcbyaidSC($admid);
$mytaskd = $this->Menu_model->get_admintteamtd($myid,$tdate);

// echo "<pre>";
// print_r($mytaskd);
// die;

?>


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
            <!-- Default box -->
    <!-- Main content -->
    
  
    <button class="btn btn-link" data-toggle="collapse" data-target="#maindata" aria-expanded="true" aria-controls="maindata">

<i class="fas fa-bars"></i> Dashboard Data Analysis

</button>



<div id="maindata" class="collapse" aria-labelledby="maindata" data-parent="#accordion">     
    
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>Team Detail</h5></center><hr>
                <p><a href="BDDetail/<?=$admid?>">Total BD - <b><?=$day[0]->a?></b></p></a><hr>
                <p><a href="BDDayDetail/<?=$tdate?>/1">Total BD Present - <b><?=$day[0]->b?></b></p></a><hr>
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
          <!-- ./col -->
          <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>Today's Team Task Detail</h5></center><hr>
                
                <?php 
                foreach($tttd as $tttd){?>
                    <p><a href="ATaskDetail/4/<?=$admid?>/1/<?=$tdate?>/<?=$tdate?>/0">Total Task Assign/Planned - <b><?=$tttd->a?></b></p></a><hr>
                    <p><a href="ATaskDetail/5/<?=$admid?>/1/<?=$tdate?>/<?=$tdate?>/0">Total Task Pending - <b><?=$tttd->b?></b></p></a><hr>
                    <p><a href="ATaskDetail/6/<?=$admid?>/1/<?=$tdate?>/<?=$tdate?>/0">Total Task Completed - <b><?=$tttd->c?></b>
                    <a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">Read More</a></p><hr>
                <div class="collapse" id="collapse2">
                    <a href="ATaskDetail/3/<?=$admid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Call Done- <b><?=$tttd->d-$tttd->e?></b></a>
                    <a href="ATaskDetail/3/<?=$admid?>/2/<?=$tdate?>/<?=$tdate?>/0"><p>Email Done- <b><?=$tttd->f-$tttd->g?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$admid?>/3/<?=$tdate?>/<?=$tdate?>/0"><p>Meeting Done- <b><?=$tttd->h-$tttd->i?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$admid?>/4/<?=$tdate?>/<?=$tdate?>/0"><p>Barg in Done- <b><?=$tttd->j-$tttd->k?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$admid?>/5/<?=$tdate?>/<?=$tdate?>/0"><p>Whatsapp Done- <b><?=$tttd->l-$tttd->m?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$admid?>/6/<?=$tdate?>/<?=$tdate?>/0"><p>MOM Done- <b><?=$tttd->n-$tttd->o?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$admid?>/7/<?=$tdate?>/<?=$tdate?>/0"><p>Proposal Done- <b><?=$tttd->p-$tttd->q?></b></p></a><hr>
                    <a href="ATaskDetail/7/<?=$admid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Action Taken Yes- <b><?=$tttd->r?></b></p></a><hr>
                    <a href="ATaskDetail/8/<?=$admid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Action Taken No- <b><?=$tttd->s?></b></p></a><hr>
                    <a href="ATaskDetail/9/<?=$admid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Purpose Achieved Yes- <b><?=$tttd->t?></b></p></a><hr>
                    <a href="ATaskDetail/10/<?=$admid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Purpose Achieved No- <b><?=$tttd->u?></b></p></a>
                <?php }?>
              </div>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="TeamWork" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                  <?php $ttswwork = $this->Menu_model->new_ttsw($admid,$tdate,0);
                  foreach($ttswwork as $tw){?>
                <center><h5>Today's Team Completed Task Against Status</h5></center><hr>
                <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/1/0">Open - <b><?=$tw->a?></b></p></a><hr>
                <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/8/0">Open [RPEM] - <b><?=$tw->b?></b></p></a><hr>
                <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/2/0">Reachout - <b><?=$tw->c?></b><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">Read More</a></p><hr>
                <div class="collapse" id="collapse2">
                    <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/3/0">Tentative - <b><?=$tw->d?></b></a></p><hr>
                    <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/4/0">Will-Do-Later - <b><?=$tw->e?></b></p></a><hr>
                    <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/5/0">Not-Interest - <b><?=$tw->f?></b></p></a><hr>
                    <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/10/0">TTD-Reachout - <b><?=$tw->j?></b></p></a><hr>
                    <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/11/0">WNO-Reachout - <b><?=$tw->k?></b></p></a><hr>
                    <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/6/0">Positive - <b><?=$tw->g?></b></p></a><hr>
                    <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/12/0">Positive NAP - <b><?=$tw->l?></b></p></a><hr>
                    <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/9/0">Very Positive - <b><?=$tw->i?></b></p></a><hr>
                    <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/13/0">Very Positive NAP - <b><?=$tw->m?></b></p></a><hr>
                    <p><a href="StatusTask/<?=$admid?>/<?=$tdate?>/7/0">Closure - <b><?=$tw->h?></b></p></a><hr>
                    <?php } ?>
                </div>    
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="StatusTaskD" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          
          <!-- ./col -->
          
          <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                  <?php
                  $sca = $this->Menu_model->get_sconbyadmin($admid,$tdate);
                  $tdate = date('Y-m-d');
                  $or=0;$ort=0;$rr=0;$rt=0;$tp=0;$pvp=0;$vph=0;$other=0;
                  foreach($sca as $m){
                    $lsid = $m->status_id;
                    $csid = $m->nstatus_id;
                    if($lsid!=$csid){
                    if($lsid==1 && $csid ==8){$or++;}
                    elseif($lsid==8 && $csid ==2){$ort++;}
                    elseif($lsid==2 && $csid ==3){$rr++;}
                    elseif($lsid==3 && $csid ==6){$rt++;}
                    elseif($lsid==6 && $csid ==9){$tp++;}
                    elseif($lsid==9 && $csid ==7){$pvp++;}
                    elseif($lsid==7 && $csid ==12){$vph++;}
                    else{$other++;}
                }}?>
                <center><h5>Today's Team Status Conversion</h5></center><hr>
                <p><a href="Conversion/<?=$admid?>/<?=$tdate?>/1/8/0">Open To Open [RPEM] - <b><?=$or?></b></a></p><hr>
                <p><a href="Conversion/<?=$admid?>/<?=$tdate?>/8/2/0">Open [RPEM] to Reachout - <b><?=$ort?></b></a></p><hr>
                <p><a href="Conversion/<?=$admid?>/<?=$tdate?>/2/3/0">Reachout to Tentative - <b><?=$rr?></b>
                <a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">Read More</a>
                </p><hr>
                <div class="collapse" id="collapse1">
                   <p><a href="Conversion/<?=$admid?>/<?=$tdate?>/3/6/0">Tentative to Positive - <b><?=$rt?></b></a></p><hr>
                    <p><a href="Conversion/<?=$admid?>/<?=$tdate?>/6/9/0">Positive To Very Positive - <b><?=$tp?></b></a></p><hr>
                    <p><a href="Conversion/<?=$admid?>/<?=$tdate?>/6/7/0">Positive to Closure - <b><?=$pvp?></b></a></p><hr>
                    <p><a href="Conversion/<?=$admid?>/<?=$tdate?>/9/7/0">Very Positive To Closure - <b><?=$vph?></b></a></p><hr>
                    <p><a href="Conversion/<?=$admid?>/<?=$tdate?>/0/0/0">Others - <b><?=$other?></b></a></p></div>
                </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="SConversion" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
        </div>
          
        <div class="row">
          <!-- ./col -->
          <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>New Client Request</h5></center><hr>
                <?php 
                $cont=0;$pass=0;$tass=0;$ini=0;$pend=0;$close=0;

                foreach ($bd as $b){
                 
                    $bdid = $b->user_id;
                    $bdallrequest=$this->Menu_model->bdrequest($bdid);
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
                <p><a href="TotalBDRequest/5">Total Request Pending - <b><?=$pend;?></b></a><br><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse6" role="button" aria-expanded="false" aria-controls="collapse6">Read More</a></p><hr>
                <div class="collapse" id="collapse6">
                <p><a href="TotalBDRequest/6">Total Request Completed - <b><?=$close;?></b></a></p>
                
                <p><a href="CreateRequest">Create Request</a></p>
               </div></div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                  <?php 
                  foreach($teamfu as $mc){
                  ?>
                <center><h5>Total Funnel </h5></center><hr>
                <p><a href="BDTOBDCTF"><b>Company TF BD to Other BD</b></a></p><hr>
                <p><a href="BDFunnal/<?=$admid?>">All BD Funnel</p></a><hr>
                <p><a href="ProposalApr"><b>Proposal Approval</b>
                <a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">Read More</a></p><hr>
                <div class="collapse" id="collapse3">
                    <p><a href="BDNotWorkDD"><b>No Work B/W Date</b></p></a><hr>
                    <p><a href="BDWorkBWD"><b>Work B/W Date</b></p></a><hr>
                    <p><a href="companies/0">Total Companies - <b><?=$mc->a?></b></p></a><hr>
                    <p><a href="companies/1">Open - <b><?=$mc->b?></b></p></a><hr>
                    <p><a href="companies/8">Open [RPEM] - <b><?=$mc->i?></b></p></a><hr>
                    <p><a href="companies/2">Reachout - <b><?=$mc->c?></b></a>
                    
                        <p><a href="companies/3">Tentative - <b><?=$mc->d?></b></p></a><hr>
                        <p><a href="companies/4">Will-Do-Later - <b><?=$mc->e?></b></p></a><hr>
                        <p><a href="companies/5">Not-Interest - <b><?=$mc->f?></b></p></a><hr>
                        <p><a href="companies/10">TTD-Reachout - <b><?=$mc->k?></b></p></a><hr>
                        <p><a href="companies/11">WNO-Reachout - <b><?=$mc->l?></b></p></a><hr>
                        <p><a href="companies/6">Positive - <b><?=$mc->g?></b></p></a><hr>
                        <p><a href="companies/9">Very Positive - <b><?=$mc->j?></b></p></a><hr>
                        <p><a href="companies/7">Closure - <b><?=$mc->h?></b></p></a><hr>
                        <p><a href="">Focus Funnel - <b><?=$mc->m?></b></p></a><hr>
                        <p><a href="">Upsell Client - <b><?=$mc->n?></b></p></a><hr>
                        <p><a href="">EX-BD Tf - <b><?=$mc->o?></b></p></a><hr>
                        <p><a href="companies/20">MP's/MLA - <b><?=$mc->p?></b></p></a><hr>
                        <p><a href="companies/21">Potential Partner BD - <b><?=$mc->q?></b></p></a><hr>
                        <p><a href="companies/25">Non Potential Partner BD - <b><?=$mc->u?></b></p></a><hr>
                        <p><a href="companies/26">Pending Potential Marking - <b><?=$mc->v?></b></p></a><hr>
                        <p><a href="companies/22">Potential Partner PST - <b><?=$mc->r?></b></p></a><hr>
                        <p><a href="companies/23">Potential Partner This QTR - <b><?=$mc->s?></b></p></a><hr>
                        <p><a href="companies/24">Potential Partner This FY - <b><?=$mc->t?></b></p></a><hr>
                        <?php } ?>
                        <!-- <p><a href="NewLead">Add New Lead</a></p> -->
                    </div></div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="BDFunnal/<?=$admid?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                  <?php 
                  $apstc=$this->Menu_model->get_apstcSC($admid);
                  foreach($apstc as $mc){
                 ?>
                <center><h5>PST Total Funnel </h5></center><hr>
                <p><a href="pstcompanies/0">Total Companies - <b><?=$mc->a?></b></p></a><hr>
                    <p><a href="pstcompanies/1">Open - <b><?=$mc->b?></b></p></a><hr>
                    <p><a href="pstcompanies/8">Open [RPEM] - <b><?=$mc->i?></b><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">Read More</a></p><hr>
                    <div class="collapse" id="collapse3">
                        <p><a href="pstcompanies/2">Reachout - <b><?=$mc->c?></b></p></a><hr>
                        <p><a href="pstcompanies/3">Tentative - <b><?=$mc->d?></b></p></a><hr>
                        <p><a href="pstcompanies/4">Will-Do-Later - <b><?=$mc->e?></b></p></a><hr>
                        <p><a href="pstcompanies/5">Not-Interest - <b><?=$mc->f?></b></p></a><hr>
                        <p><a href="pstcompanies/10">TTD-Reachout - <b><?=$mc->k?></b></p></a><hr>
                        <p><a href="pstcompanies/5">WNO-Reachout - <b><?=$mc->l?></b></p></a><hr>
                        <p><a href="pstcompanies/6">Positive - <b><?=$mc->g?></b></p></a><hr>
                        <p><a href="pstcompanies/9">Very Positive - <b><?=$mc->j?></b></p></a><hr>
                        <p><a href="pstcompanies/7">Closure - <b><?=$mc->h?></b></p></a><hr>
                        <p><a href="">Focus Funnel - <b><?=$mc->m?></b></p></a><hr>
                        <p><a href="">Upsell Client - <b><?=$mc->n?></b></p></a><hr>
                        <?php } ?>
              </div>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          







        
        
          <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>Team Bargin Meeting Detail</h5></center><hr>
                <p><a href="PMTFTOBD"><b>Meeting TF to Other BD</b></a></p><hr>
                <?php foreach($tbmeetd as $tmd){ ?>
                <p><a href="plannerareport">Action Planner</b></a></p><hr>
                <p><a href="plannerreport">Status Planner</b><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse5" role="button" aria-expanded="false" aria-controls="collapse5">Read More</a></p><hr>
                <div class="collapse" id="collapse5">
                    <p><a href="momdetail">MOM Detail</b></a></p><hr>
                    <p><a href="TBMDF">Total RP Meeting</b></a></p><hr>
                    <p><a href="MeetingDetail/1/<?=$admid?>/<?=$tdate?>"><b>Meeting Detail</b></a></p><hr>
                    <p><a href="TBMD/1/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Total Bargin Plan - <b><?=$tmd->ab?></b></a></p><hr>
                    <p><a href="TBMD/2/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Not Started Bargin - <b><?=$tmd->a?></b></a></p><hr>
                    <p><a href="TBMD/2/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Started Bargin - <b><?=$tmd->i?></b></a></p><hr>
                    <p><a href="TBMD/3/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Not Close Bargin - <b><?=$tmd->b?></b></a></p><hr>
                    <p><a href="TBMD/3/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Close Bargin - <b><?=$tmd->b?></b></a></p><hr>
                    <p><a href="TBMD/3/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Lead not Updated - <b><?=$tmd->h?></b></a></p><hr>
                    <p><a href="TBMD/4/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Completed Bargin - <b><?=$tmd->c?></b></a></p><hr>
                    <p><a href="TBMD/5/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Total RP Meeting - <b><?=$tmd->d?></b></a></p><hr>
                    <p><a href="TBMD/6/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Total Non RP Meeting - <b><?=$tmd->e?></b></a></p><hr>
                    <p><a href="TBMD/7/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Total RP Priority - <b><?=$tmd->f?></b></a></p><hr>
                    <p><a href="TBMD/8/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Total RP Not Priority - <b><?=$tmd->g?></b></a></p><hr>
                    <p><a href="TBMD/9/<?=$admid?>/<?=$tdate?>/<?=$tdate?>">Total Only Got Detail - <b><?=$tmd->k?></b></a></p><hr>
                    
                <?php } ?>
                </div>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="TBMDetail" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          
          <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>Today's BD Task on PST Funnel</h5></center><hr>
                <?php 
                $bdtofpstf = $this->Menu_model->get_bdtofpstf($admid,$tdate);
                foreach($bdtofpstf as $tttd){?>
                    <p><a href="#">Total Task Assign/Planned - <b><?=$tttd->a?></b></p></a><hr>
                    <p><a href="#">Total Task Pending - <b><?=$tttd->b?></b></p></a><hr>
                    <p><a href="#">Total Task Completed - <b><?=$tttd->c?></b><a style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">Read More</a></p><hr>
                <div class="collapse" id="collapse2">
                    <a href="ATaskDetail/3/<?=$admid?>/1/<?=$tdate?>"><p>Call Done- <b><?=$tttd->d-$tttd->e?></b></a>
                    <a href="ATaskDetail/3/<?=$admid?>/2/<?=$tdate?>"><p>Email Done- <b><?=$tttd->f-$tttd->g?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$admid?>/3/<?=$tdate?>"><p>Meeting Done- <b><?=$tttd->h-$tttd->i?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$admid?>/4/<?=$tdate?>"><p>Barg in Done- <b><?=$tttd->j-$tttd->k?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$admid?>/5/<?=$tdate?>"><p>Whatsapp Done- <b><?=$tttd->l-$tttd->m?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$admid?>/6/<?=$tdate?>"><p>MOM Done- <b><?=$tttd->n-$tttd->o?></b></p></a><hr>
                    <a href="ATaskDetail/3/<?=$admid?>/7/<?=$tdate?>"><p>Proposal Done- <b><?=$tttd->p-$tttd->q?></b></p></a><hr>
                    <a href="#"><p>Action Taken Yes- <b><?=$tttd->r?></b></p></a><hr>
                    <a href="#"><p>Action Taken No- <b><?=$tttd->s?></b></p></a><hr>
                    <a href="#"><p>Purpose Achieved Yes- <b><?=$tttd->t?></b></p></a><hr>
                    <a href="#"><p>Purpose Achieved No- <b><?=$tttd->u?></b></p></a>
                <?php }?>
              </div>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="PSTData" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
    
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-light text-secondary">
              <div class="inner">
                <center><h5>Today's MY Task Detail</h5></center><hr>
                <?php 
                foreach($mytaskd as $mytd){?>
                    <p><a href="<?=base_url();?>Menu/AMyTaskDetail/4/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0">Total Task Assign/Planned - <b><?=$mytd->a?></b></p></a><hr>
                    <p><a href="<?=base_url();?>Menu/AMyTaskDetail/5/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0">Total Task Pending - <b><?=$mytd->b?></b></p></a><hr>
                    <p><a href="<?=base_url();?>Menu/AMyTaskDetail/6/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0">Total Task Completed - <b><?=$mytd->c?></b></a><span style="font-size:10px;color:red;margin-left:20px" data-toggle="collapse" href="#collapse25" role="button" aria-expanded="false" aria-controls="collapse25">Read More</p><hr>
                <div class="collapse" id="collapse25">
                    <a href="<?=base_url();?>Menu/AMyTaskDetail/3/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Call Done- <b><?=$mytd->d-$mytd->e?></b></p></a><hr>
                    <a href="<?=base_url();?>Menu/AMyTaskDetail/3/<?=$uid?>/2/<?=$tdate?>/<?=$tdate?>/0"><p>Email Done- <b><?=$mytd->f-$mytd->g?></b></p></a><hr>
                    <a href="<?=base_url();?>Menu/AMyTaskDetail/7/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Action Taken Yes- <b><?=$mytd->r?></b></p></a><hr>
                    <a href="<?=base_url();?>Menu/AMyTaskDetail/8/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Action Taken No- <b><?=$mytd->s?></b></p></a><hr>
                    <a href="<?=base_url();?>Menu/AMyTaskDetail/9/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Purpose Achieved Yes- <b><?=$mytd->t?></b></p></a><hr>
                    <a href="<?=base_url();?>Menu/AMyTaskDetail/10/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0"><p>Purpose Achieved No- <b><?=$mytd->u?></b></p></a>
                <?php }?>
              </div>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="MyWork" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          
      
          <!-- ./col -->
          
          <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            
          </div>
          <!-- ./col -->
          
          
          
          
        </div>
          
          
          
          
          
           
        </div>
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
                                      <?php  $ttbytime = $this->Menu_model->get_ttbytime($uid,$tdate,'17:00:00','19:00:00');
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
                                $bs = $brg->status;?>
                                <?php if($bs=='Pending'){?>
                                    <button type="button" value="<?=$brg->id?>" class="btn btn-success" id="startm">Start Meeting</button>
                                <?php }if($bs=='Start'){?>
                                    <button type="button" value="<?=$brg->id?>" class="btn btn-info" id="closem">Close Meeting</button>
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
            <div class="card card-primary card-outline card-outline-tabs">

            <div class="card p-3">

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalReminder">
  Create A Reminder
</button>

      
<?php 
        $reminderData = $this->Menu_model->GetTodaysTeamReminder($uid);
        $reminderDatacnt = sizeof($reminderData);
        if($reminderDatacnt > 0){ ?>
        <div class="ourreminder">
        <hr>
        <h6 class='text-center bg-danger p-2 '>Team Reminder</h6>
        <hr>
        <?php foreach($reminderData as $remi){ ?>

          <div class="card p-2" style="background: #ffafaf;">
          <span class="p-1"> <b>Reminder Name : </b> <?= $remi->name; ?></span>
          <span class="p-1"> <b>Reminder Type : </b> <?= $this->Menu_model->remindermessagebyid($remi->type)[0]->message; ?></span>
          <span class="p-1"> <b>Message : </b> <?= $remi->message; ?></span>
          <span class="p-1"> <b>Request Time : </b> <?= $remi->created_at; ?></span>
          <span class="p-1"> <b>Reminder Acknowledge : </b>
          <?php 
          if($remi->status == 0){
            echo "<span class='p-1 bg-warning btn btn-warning'><a href='".base_url()."Management/ConfirmReminder/".$remi->id."'>Checked</a></span>";
          }
          ?>
          </span>
          </div>
        <?php } ?>
        </div>
        <?php } ?>
        
        <?php 
        $reminderData = $this->Menu_model->GetTodaysOurReminder($uid);
        $reminderDatacnt = sizeof($reminderData);
        if($reminderDatacnt > 0){ ?>
        <div class="ourreminder">
        <hr>
        <h6 class='text-center bg-info p-2'>Our Reminder</h6>
        <hr>
        <?php foreach($reminderData as $remi){ ?>

          <div class="card p-2" style="background: azure;">
          <span class="p-1"> <b>Reminder Type : </b> <?= $remi->type; ?></span>
          <span class="p-1"> <b>Message : </b> <?= $remi->message; ?></span>
          <span class="p-1"> <b>Request Time : </b> <?= $remi->created_at; ?></span>
          <?php 
      if($remi->status == 0){
          echo "<span class='p-1'> <b>Reminder Acknowledge : </b><span class='p-1 bg-warning'>Pending</span>";
      }else{ ?>
          <span class="p-1"> <b>Acknowledge By : </b> <?= $this->Menu_model->get_userbyid($remi->acknowledge_by)[0]->name; ?></span>
          <span class="p-1"> <b>Acknowledge Message: </b> <?= $remi->acknowledge_message; ?>
     <?php }  ?>
          </span>
          </div>
        <?php } ?>
        </div>
        <?php } ?>
        
  </div>


<!-- Modal -->
<div class="modal fade" id="exampleModalReminder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header bg-info text-center">
<h5 class="modal-title" id="exampleModalLabel">Create Reminder</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form action="<?=base_url();?>Management/SendReminder" method="post">
<div class="form-group">
<label>Select Reminder Type : </label>
<select class="form-control" name="reminder_type">
<?php 
    $rmmess = $this->Menu_model->remindermessage();
    foreach($rmmess as $mess){
    ?>
    <option value="<?=$mess->id; ?>"><?=$mess->message; ?></option>
      <?php } ?>
</select>
</div>
<div class="form-group">
  <label>Reminder Message: </label>
  <textarea class="form-control" name="reminder_message" rows="3"></textarea>
</div>
<div class="form-group text-center">
<button type="submit" class="btn btn-primary">Send Reminder</button>
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
        </div>
</div>
        
            
            
            
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

