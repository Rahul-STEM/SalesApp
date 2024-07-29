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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script> -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
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
    font-size: 19px;
    text-align: left;
}
.small-box>.small-box-footer {
    background: #c5eb4d !important;
    font-weight: 500;
}
.dropdown-menu {
            /* max-height: 200px; */
            /* overflow-y: auto; */
        }

</style>
<!-- <style>
        .bootstrap-select {
            width: 100%;
        }
    </style> -->
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<!-- Preloader -->
<!-- Navbar -->
<?php require('nav.php');?>
<?php require('addpop.php');?>
<!-- /.navbar -->
<?php
$bd = $this->Menu_model->get_userbyaid($uid);
$day = $this->Menu_model->get_daydbyad($uid,$tdate);
$tttd = $this->Menu_model->get_tteamtd($uid,$tdate);
$psttttd = $this->Menu_model->get_psttteamtd($uid,$tdate);
$mytaskd = $this->Menu_model->get_admintteamtd($uid,$tdate);
$tbmeetd = $this->Menu_model->get_tbmeetdbyaid($uid,$tdate);
// $teamfu = $this->Menu_model->get_mbdcbyaid($uid);

//////////////////////////////// New Function To Fetch Counts on Dashboard ////////////////////////////////

$TeamFunnelDetails = $this->Menu_model->getFunnelDetails($uid);
$TeamDayDetails = $this->Menu_model->getTeamDeatilsByDate($uid,$tdate);
$TeamDayTasks = $this->Menu_model->getTeamTasks($uid,$tdate);



// var_dump($TeamDayTasks);die;

// $teamDayTasks = [
//     // 'TotalTasks' => '317',
//     // 'TotalPending' => '165',
//     // 'TotalCompleted' => '152',
//     'd' => '166',
//     'e' => '66',
//     'f' => '122',
//     'g' => '77',
//     'h' => '0',
//     'i' => '0',
//     'j' => '22',
//     'k' => '18',
//     'l' => '0',
//     'm' => '0',
//     'n' => '1',
//     'o' => '0',
//     'p' => '3',
//     'q' => '1',
//     'r' => '83',
//     's' => '69',
//     't' => '83',
//     'u' => '69'
// ];

$mdata = $this->Menu_model->get_alluserbyaid($uid);
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
    <div class="container-fluid">
        <button class="btn btn-warning font-weight-bold" type="button" data-toggle="collapse" data-target="#DashboardAnalysis" aria-expanded="false" aria-controls="DashboardAnalysis">
            Dashboard Analysis
            <i class="fa fa-bar-chart"></i>
        </button>
        <br>
            <div class="collapse" id="DashboardAnalysis" >
                <div class="card card-body dashboard">
                    <!-- <form action="<?=base_url();?>Menu/DashboardFilter_New" method="POST" >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select Role</label>
                                    <select class="custom-select rounded-0" name="userType[]" id="userType" multiple>
                                        <option value="select_all">Select All</option>
                                        <?php foreach($roles as $r) {
                                            if ($r->id <= $user['type_id']) {
                                                continue;
                                            }
                                        ?>
                                        <option value="<?= $r->id ?>"><?= $r->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select User</label>
                                    <select id="user" class="custom-select rounded-0" name="user[]" data-live-search="true" multiple>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select Zones</label>
                                    <select class="custom-select rounded-0" name="zone[]" id="zone" multiple>
                                        <option>Select Zone</option>
                                        <option value="select_all">Select All</option>
                                        <?php 
                                            foreach($zones as $zone){ ?>
                                                <option value="<?=$zone->id?>"> <?=$zone->name?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div> 
                    </form> -->
                    <hr>
                    <div class="row DataCards">
                        <div class="col-lg-12 col-md-3 col-sm-12">
                            <div class="card card-primary collapsed-card">
                                <div class="card-header text-center">
                                    <b>Team and Funnel Details</b>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                </div>
                                <div class="card-body" id="funnelBody">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-secondary">
                                                <div class="card-header text-center">
                                                    <b>Team Detail</b>
                                                    <p>
                                                        <strong><a href="BDDetail/<?=$uid?>">Total Team Members - <?= sizeof($mdata)?></a></strong>
                                                    </p>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a href="BDDayDetail/<?=$tdate?>/1" class="nav-link">
                                                            Total Team Members Present - <span class="badge bg-success">
                                                            <?=$TeamDayDetails[0]->TotalTeamMembers?></span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="BDDayDetail/<?=$tdate?>/2" class="nav-link">
                                                            Total Work in Office - <span class="badge bg-success">
                                                            <?=$TeamDayDetails[0]->WorkFromOffice?></span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="BDDayDetail/<?=$tdate?>/3" class="nav-link">
                                                            Total Work From Field - <span class="badge bg-success">
                                                            <?=$TeamDayDetails[0]->WorkFromField?></span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="BDDayDetail/<?=$tdate?>/4" class="nav-link">
                                                            Total Work From Field + Office - <span class="badge bg-success">
                                                            <?=$TeamDayDetails[0]->WorkFromOfficeandField?></span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?=base_url();?>Management/CheckingDayManagement" class="nav-link">
                                                                Check Day Management System 
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?=base_url();?>Management/SpecialRestrictionOnTaskPlanner" class="nav-link">
                                                                Special Restrication on Task Planner
                                                            </a>
                                                        </li>
                                                    </ul> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-secondary">
                                                <div class="card-header text-center">
                                                    <b>Active + Inactive BD Companies</b>
                                                </div>
                                                <div class="card-body">
                                                    <?php
                                                        foreach($TeamFunnelDetails as $TeamFunnelDetail){?>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <ul class="nav flex-column">
                                                                <li class="nav-item">
                                                                    <a href="companies/0" class="nav-link">
                                                                    Total Companies - <span class="badge bg-success">
                                                                        <?= $TeamFunnelDetail->total ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/1" class="nav-link">
                                                                    Open - <span class=" badge bg-success">
                                                                        <?= $TeamFunnelDetail->open ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/8" class="nav-link">
                                                                    Open [RPEM] - <span class=" badge bg-success">
                                                                        <?= $TeamFunnelDetail->OpenRPEM ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/2" class="nav-link">
                                                                    Reachout - <span class=" badge bg-success">
                                                                        <?= $TeamFunnelDetail->reachout ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/3" class="nav-link">
                                                                    Tentative - <span class=" badge bg-warning">
                                                                        <?= $TeamFunnelDetail->tentative ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/4" class="nav-link">
                                                                    Will-Do-Later - <span class=" badge bg-danger">
                                                                        <?= $TeamFunnelDetail->willDoLate ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/5" class="nav-link">
                                                                    Not-Interest - <span class=" badge bg-danger">
                                                                        <?= $TeamFunnelDetail->NotIntrested ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/10" class="nav-link">
                                                                    TTD-Reachout - <span class=" badge bg-success">
                                                                        <?= $TeamFunnelDetail->TTDReachout ?></span>
                                                                    </a>
                                                                </li>
                                                                <!-- <li class="nav-item">
                                                                    <a href="companies/24" class="nav-link">
                                                                    Potential Partner This FY - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->PotentialPartnerFY ?></span>
                                                                    </a>
                                                                </li> -->
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <ul class="nav flex-column">
                                                                <li class="nav-item">
                                                                    <a href="companies/11" class="nav-link">
                                                                    WNO-Reachout - <span class=" badge bg-success">
                                                                        <?= $TeamFunnelDetail->WNOReachout ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/6" class="nav-link">
                                                                    Positive - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->Positive ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/9" class="nav-link">
                                                                    Very Positive - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->VeryPositive ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/7" class="nav-link">
                                                                    Closure - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->Closure ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="#" class="nav-link">
                                                                    Focus Funnel - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->FocusFunnelYes ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="#" class="nav-link">
                                                                    Upsell Client - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->FocusFunnelYes ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="#" class="nav-link">
                                                                    EX-BD Transfer - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->ExBD ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/10" class="nav-link">
                                                                    TTD-Reachout - <span class=" badge bg-success">
                                                                        <?= $TeamFunnelDetail->TTDReachout ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/20" class="nav-link">
                                                                    MP's/MLA - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->MP_MLA ?></span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <ul class="nav flex-column">
                                                                <li class="nav-item">
                                                                    <a href="companies/20" class="nav-link">
                                                                    Potential Partner BD - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->PotentialPartnerBD ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/21" class="nav-link">
                                                                    Non Potential Partner BD - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->NonPotentialPartner ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/26" class="nav-link">
                                                                    Pending Potential Marking - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->PotentialPartnerMarkingPending ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/22" class="nav-link">
                                                                    Potential Partner PST - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->PotentialPartnerPST ?></span>
                                                                    </a>
                                                                </li>
                                                                <!-- <li class="nav-item">
                                                                    <a href="companies/23" class="nav-link">
                                                                    Potential Partner This QTR - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->PotentialPartnerQR ?></span>
                                                                    </a>
                                                                </li> -->
                                                                <li class="nav-item">
                                                                    <a href="companies/20" class="nav-link">
                                                                    Potential Partner BD - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->PotentialPartnerBD ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/21" class="nav-link">
                                                                    Non Potential Partner BD - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->NonPotentialPartner ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="companies/26" class="nav-link">
                                                                    Pending Potential Marking - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->PotentialPartnerMarkingPending ?></span>
                                                                    </a>
                                                                </li>
                                                                <!-- <li class="nav-item">
                                                                    <a href="companies/22" class="nav-link">
                                                                    Potential Partner PST - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->PotentialPartnerPST ?></span>
                                                                    </a>
                                                                </li> -->
                                                                <!-- <li class="nav-item">
                                                                    <a href="companies/23" class="nav-link">
                                                                    Potential Partner This QTR - <span class="float-right badge bg-primary">
                                                                        <?= $TeamFunnelDetail->PotentialPartnerQR ?></span>
                                                                    </a>
                                                                </li> -->
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-secondary">
                                                <div class="card-header text-center">
                                                <?php
                                                    foreach($TeamDayTasks as $TeamDayTask){ ?>
                                                    
                                                    <b>Today's Team Task Details</b>
                                                    <p>
                                                        <strong><a href="ATaskDetail/4/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0">Total Task Assigned/Planned -  <span class="badge bg-success"><?= $TeamDayTask->TotalTasks ?></span></a></strong>
                                                    </p>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <ul class="nav flex-column">
                                                            <?php
                                                                //foreach($TeamDayTasks as $TeamDayTask){
                                                                ?>
                                                                <li class="nav-item">
                                                                    <a href="ATaskDetail/5/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Total Task Pending - <span class="badge bg-danger">
                                                                    <?= $TeamDayTask->TotalPending ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/3/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Calls Done - <span class="badge bg-primary">
                                                                    <?= $TeamDayTask->CallsDone ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/3/<?=$uid?>/2/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Emails Done - <span class="badge bg-primary">
                                                                    <?= $TeamDayTask->EmailDone ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/3/<?=$uid?>/3/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Meeting Done - <span class="badge bg-primary">
                                                                    <?= $TeamDayTask->MeetingDone ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/3/<?=$uid?>/4/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Barg in Meeting Done - <span class="badge bg-primary">
                                                                    <?= $TeamDayTask->BargeMeetingDone ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/3/<?=$uid?>/5/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    WhatsApp Done - <span class="badge bg-primary">
                                                                    <?= $TeamDayTask->WhatsAppDone ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/3/<?=$uid?>/6/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    MOM Done - <span class="badge bg-primary">
                                                                    <?= $TeamDayTask->MoMDone ?></span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <ul class="nav flex-column">
                                                                <li class="nav-item">
                                                                    <a href="ATaskDetail/6/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Total Task Completed - <span class=" badge bg-success">
                                                                        <?= $TeamDayTask->TotalCompleted ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/3/<?=$uid?>/7/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Proposal Done - <span class="badge bg-primary">
                                                                    <?= $TeamDayTask->ProposalDone ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/7/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Action taken Yes - <span class="badge bg-primary">
                                                                    <?= $TeamDayTask->ActionTakenYes ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/8/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Action taken No - <span class="badge bg-danger">
                                                                    <?= $TeamDayTask->ActionTakenNo ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/9/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Purpose Achieved Yes - <span class="badge bg-sucess">
                                                                    <?= $TeamDayTask->PurposeAchievedYes ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="Menu/ATaskDetail/10/<?=$uid?>/1/<?=$tdate?>/<?=$tdate?>/0" class="nav-link">
                                                                    Purpose Achieved No - <span class="badge bg-danger">
                                                                    <?= $TeamDayTask->PurposeAchievedNo ?></span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <!-- <div class="row">
                                                        <canvas id="donutChart" ></canvas>
                                                    </div> -->
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
        </p>

    </div>
        


<div class="row">
<div class="col-lg-8 col-sm">
<div class="row">
<div class="col-lg-12 col-sm">
    <div class="card card-primary card-outline card-outline-tabs">
        <h4 class="p-3">Today's Task Planned</h4>
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
            
            
            <div class="card card-primary card-outline card-outline-tabs">
                <?php $patd = $this->Menu_model->get_atptd($uid,$tdate);
                $patsd = $this->Menu_model->get_atptsd($uid,$tdate);
                ?>
                <div class="card-header text-center bg-info"><b>Auto Pending Task to be Schedule</b></div>
                <div class="card-header text-center bg-light"><b>
                    Total Task <?=$patd[0]->ab?> | Call(<?=$patd[0]->a?>) | Email(<?=$patd[0]->b?>) | Whatsapp(<?=$patd[0]->e?>) | Meeting(<?=$patd[0]->c+$patd[0]->d?>) | MOM(<?=$patd[0]->f?>) | Proposal(<?=$patd[0]->g?>)
                </b></div>
                <div class="card-header text-center bg-light"><b>
                    Open(<?=$patsd[0]->a?>) | Open RPEM(<?=$patsd[0]->b?>) | Rechaout(<?=$patsd[0]->c?>) | Tentative(<?=$patsd[0]->d?>) | WDL(<?=$patsd[0]->e?>) | NI(<?=$patsd[0]->f?>) | TTD(<?=$patsd[0]->g?>) | WNO(<?=$patsd[0]->h?>) | Positive(<?=$patsd[0]->i?>) | Very Positive(<?=$patsd[0]->j?>) | Closure(<?=$patsd[0]->k?>)
                </b></div>
                <div class="card-body">
                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
                    <ul id="myUL">
                        <?php $ai=0;foreach($totalt as $tt){if($tt->plan==0){if($tt->autotask==0){?>
                        <li><a>
                            <?=$tt->aname?> |
                            <strong class="text-secondary"><?=$tt->compname?> | <b style="color:<?=$tt->color?>"><?=$tt->csname?></b></strong>
                            <button id="add_plan<?=$ai?>" value="<?=$tt->id?>">Plan</button>
                        </a>
                        
                    </li><?php $ai++;}}} ?>
                </ul>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
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
<!-- <script src="plugins/jquery-knob/jquery.knob.min.js"></script> -->
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

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> -->

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
    $(document).ready(function() {
        
    });
</script>
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

<!-- New scrip Tag for new dashboard <==================== START ==========> -->

<script>
    $(document).ready(function() {

        $("#userType").change(function(){
            // var selectedValues = $("#userType").val();
            // console.log(selectedValues);
            var selectedValues = $(this).val(); 
            if (selectedValues.includes('select_all')) {
            // Select all options
                $('#userType option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedValues = $('#userType option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();
            }
            // var selectedValues = $("#userType").val(); // Get selected values
            console.log(selectedValues);

            $.ajax({
                url: '<?=base_url();?>Menu/getRoleUser_New',
                type: 'POST', 
                data: {RoleId: selectedValues},
                success: function(response) {
                    // alert(response);
                $("#user").html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    
        $("#user").change(function(){

            var selectedUser = $(this).val(); 
            if (selectedUser.includes('select_all')) {
            // Select all options
                $('#user option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedUser = $('#user option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();
            }
            // var selectedValues = $("#userType").val(); // Get selected values
            console.log(selectedUser);
        });

        $("#zone").change(function(){

            var selectedZone = $(this).val(); 
            if (selectedZone.includes('select_all')) {
            // Select all options
                $('#zone option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedZone = $('#zone option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();
            }
            // var selectedValues = $("#userType").val(); // Get selected values
            console.log(selectedZone);
            });
    });
</script>
<script>
     const teamDayTasks = <?php echo json_encode($TeamDayTasks); ?>;

    const data = {
        labels: Object.keys(teamDayTasks[0]),
        datasets: [{
            data: Object.values(teamDayTasks[0]),
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#FF6384', '#36A2EB', '#FFCE56',
                '#FF6384', '#36A2EB', '#FFCE56', '#FF6384', '#36A2EB', '#FFCE56',
                '#FF6384', '#36A2EB', '#FFCE56', '#FF6384', '#36A2EB', '#FFCE56',
                '#FF6384', '#36A2EB'
            ]
        }]
    };

    const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Team Day Tasks'
                    }
                }
            },
        };
    //
    window.onload = function() {
            const ctx = document.getElementById('donutChart').getContext('2d');
            new Chart(ctx, config);
        };
</script>
</body>
</html>