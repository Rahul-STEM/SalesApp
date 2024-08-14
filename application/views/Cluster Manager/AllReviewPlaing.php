<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STEM Operation | WebAPP</title>
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
      div#cmpmanytime {
      background: aliceblue;
      padding:10px;
      }
      thead {
    background: black;
    color: white;
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
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <h4></h4>
              </ol>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <?php //dd($user['type_id']); ?>
      <section class="content">
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
          <div class="row p-3">
            <?php
              $revst = $this->Menu_model->get_reviewstarted($uid);
              if($revst){$bdid = $revst[0]->bdid;}else{$bdid=0;}
              
              if($bdid==0){
              ?>
            <div class="col-md-6 offset-lg-3 m-auto">
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <h3 class="text-center">Start Review/Calling Task</h3>
                  <hr>
                  <form action="<?=base_url();?>Menu/startreview" method="post">
                    <div class="was-validated">
                      <div class="form-group">
                        <input type="hidden" name="uida" value="<?=$uid?>">
                        <?php date_default_timezone_set("Asia/Kolkata"); ?>
                        <input type="datetime-local" name="startt" value="<?=date('Y-m-d H:i:s')?>" class="form-control" readonly>
                        <div class="invalid-feedback">Please provide Start Date Time.</div>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="mt-4">
                          <select class="form-control" name="reviewid" required="">
                            <?php $reviewid = $this->Menu_model->get_reviewid($uid);
                              foreach($reviewid as $rev){
                              ?>
                            <option value="<?=$rev->rid?>"><?=$rev->name?> (<?=$rev->reviewtype?>) (<?=$rev->plant?>)</option>
                            <?php } ?>
                          </select>
                          <div class="invalid-feedback">Please Create Plan First.</div>
                          <div class="valid-feedback">Looks good!</div>
                        </div>
                      </div>
                      <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" onclick="this.form.submit(); this.disabled = true;">Srart Review</button>
                      </div>
                  </form>
                  </div>
                </div>
              </div>
            </div>
            <?php }else{ ?>
            <div class="col-sm col-md-6 col-lg-6 m-auto">
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <h4 class="text-center"><?=$revst[0]->reviewtype;?> Review/Calling</h4>
                  <h5 class="text-center"><?=$revst[0]->name;?></h5>
                  <hr>
                  <div class="was-validated">
                    <div class="form-group">
                      <input type="hidden" name="uidaa" value="<?=$uid?>">
                      <input type="hidden" id="bdid" value="<?=$revst[0]->bdid;?>">
                      <?php date_default_timezone_set("Asia/Kolkata"); ?>
                      <input type="date" id="fdate" name="fdate" value="<?=$revst[0]->fixdate;?>" class="form-control" readonly>
                      <input type="hidden" id="pstid" value="<?=$uid?>">
                      <div class="invalid-feedback">Please provide Start Date Time.</div>
                      <div class="valid-feedback">Looks good!</div>
                      <div class="mt-4">
                        <select class="form-control" id="statusid" name="statusid" required="">
                          <option value="">Select Status</option>
                          <?php 
                            $typeid = $user['type_id'];
                            if($typeid == 3 || $typeid == 5){
                                $status_array = [1,4,5,8];
                            }else if($typeid == 13){
                                $status_array = [2,3];
                            }else if($typeid == 4){
                                $status_array = [6,9,12,13];
                            }else if($typeid == 9){
                                $status_array = [2,3,6,9,12,13];
                            }else{
                                $status_array = [1,2,3,4,5,6,7,8,9,10,11,12,13,14];
                            }
                            
                            $status = $this->Menu_model->get_status(); foreach($status as $st){?>
                          <?php if(in_array($st->id, $status_array)){ ?>
                          <option value="<?=$st->id?>"><?=$st->name?></option>
                          <?php }} ?>
                        </select>
                        <div class="invalid-feedback">Please Create Plan First.</div>
                        <div class="valid-feedback">Looks good!</div>
                      </div>
                      <div class="mt-4">
                        <lable>note: showing only those companies which are not involved PST</lable>
                        <select class="form-control" name="inid" required="" id="inid">
                        </select>
                        <div class="invalid-feedback">Please Select Status First.</div>
                        <div class="valid-feedback">Looks good!</div>
                      </div>
                    </div>
                    <a href="<?=base_url();?>Menu/AllReviewac"><button type="button" class="btn btn-outline-danger">Go to Action wise Review</button></a><br>
                  </div>
                  <div class="card p-3 mt-3">
                    <div class="was-validated">
                      <form action="<?=base_url();?>Menu/closereview" method="post">
                        <input type="hidden" name="rrid" value="<?=$revst[0]->rid;?>">
                        <b class="text-danger mt-3">Are you sure you want to close review task ?</b>
                        <div class="form-group">
                          <textarea class="form-control mt-3" name="closeremark" placeholder="Review Close Final Remark..."  required=""></textarea>
                          <input type="datetime-local" name="closetdate" value="<?=date('Y-m-d H:i:s');?>" class="form-control mt-3" required="">
                          <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-danger" onclick="this.form.submit(); this.disabled = true;">Close Review</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card p-3" id="graphlog"></div>
            </div>
            <div class="col-sm col-md-6 col-lg-6 m-auto">
              <div class="card card-primary card-outline">
                <img src="http://localhost/StemSales/assets/image/2391280.jpg" id="hideimage" alt="">
                <div id="loadcompinfo">
                  <form action="<?=base_url();?>Menu/bdrtaskc" method="post">
                    <input type="hidden" id="rtype" name="rtype" value="<?=$revst[0]->reviewtype;?>">
                    <div class="was-validated m-3">
                      <div class="card-body box-profile" id="cmpdata">
                      </div>
                      <div class="form-group">
                        <textarea class="form-control" name="remark" placeholder="Review Remark..."  required=""></textarea>
                      </div>
                      <hr>
                      <input type="hidden" name="pstuid" value="<?=$uid?>">
                      <input type="hidden" name="bduid" value="<?=$bdid?>">
                      <input type="hidden" name="rid" value="<?=$revst[0]->rid;?>">
                      <div id="cmpfirsttime">
                        <input type="hidden" id="review_time" name="review_time" value="">
                        <div id="orrr">
                          <lable>Potential / Non-Potential Clients? <span id="potentialclient"></span> </lable>
                          <select class="form-control" id="potential" name="potential">
                            <option value='yes'>Potential</option>
                            <option value='no'>Non-Potential</option>
                          </select>
                          <lable>1st Remark</lable>
                          <select class="form-control" id="otherremark">
                            <option value="">Select Remark</option>
                          </select>
                          <input type="text" class="form-control" name="otherremark" id="otherremark1">
                          <lable>Call Remark</lable>
                          <select class="form-control" id="ans1">
                            <option value="">Select Remark</option>
                          </select>
                          <input type="text" class="form-control" name="ans1" id="ans11">
                          <lable>Email Remark</lable>
                          <select class="form-control" id="ans2">
                            <option value="">Select Remark</option>
                          </select>
                          <input type="text" class="form-control" name="ans2" id="ans21">
                          <lable>Meeting Remark</lable>
                          <select class="form-control" id="ans3">
                            <option value="">Select Remark</option>
                          </select>
                          <input type="text" class="form-control" name="ans3" id="ans31">
                          <lable>Add CSR Budget</lable>
                          <select class="form-control" id="csrbudget" name="csrbudget">
                            <option>More than 2.5 csr budget</option>
                            <option>Between 50 lacs to 2 cr</option>
                            <option>Less than 50 lacs</option>
                          </select>
                          <lable>Add Number of schools</lable>
                          <input type="number" class="form-control" name="bdscholl" id="bdscholl">
                        </div>
                        <lable>Is the Current Status right? </lable>
                        <select class="form-control" id="statusright" name="statusright">
                          <option>Yes</option>
                          <option>No</option>
                        </select>
                        <div id="statusno">
                          <select class="form-control" name="requeststatus" required="">
                            <?php $status = $this->Menu_model->get_status($uid);
                              foreach($status as $st){?>
                            <option value="<?=$st->id?>"><?=$st->name?></option>
                            <?php } ?>
                          </select>
                          <textarea name="ans4" class="form-control" placeholder="Remark...."></textarea>
                        </div>
                        <lable>Need to Delete This Company From Your Funnel? </lable>
                        <input type="text" class="form-control" name="deletef" value="No">
                        <lable>Need to Change Patner Type? </lable>
                        <select class="form-control" name="patnertype">
                          <option>No</option>
                          <option>yes</option>
                        </select>
                        <lable>Top Spender? </lable>
                        <select class="form-control" name="topspender">
                          <option>No</option>
                          <option>Yes</option>
                        </select>
                        <lable>Key Client? </lable>
                        <select class="form-control" name="keyclient">
                          <option>No</option>
                          <option>Yes</option>
                        </select>
                        <lable>Positive Key Client? </lable>
                        <select class="form-control" name="pkeyclient">
                          <option>No</option>
                          <option>Yes</option>
                        </select>
                        <lable>Priority Client? </lable>
                        <select class="form-control" name="priorityclient">
                          <option>No</option>
                          <option>Yes</option>
                        </select>
                        <lable>Upsell Client? </lable>
                        <select class="form-control" name="upsellclient">
                          <option>No</option>
                          <option>Yes</option>
                        </select>
                        <lable>Focus Funnel? </lable>
                        <select class="form-control" name="focusyclient">
                          <option>No</option>
                          <option>Yes</option>
                        </select>
                        <hr>
                        <div class="col-12 col-md-12 mb-12">
                          <lable>Travel Cluster is Right or not </lable>
                          <select class="form-control" id="travelcluster" name="travelcluster">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                        </div>
                        <div class="col-12 col-md-12 mb-12" id ="travelclustercard">
                          <label for="validationSample04">Select Travel Cluster</label>
                          <?php $clusterData = $this->Menu_model->getClusterByUserId($uid);  ?>
                          <select id="cluster" class="form-control" name="cluster_id" required>
                            <option selected value="">Select Cluster</option>
                            <?php foreach($clusterData as $cdata): ?>
                            <option value="<?=$cdata->id?>"><?=$cdata->clustername ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>


                      <div id="rosterform">

                              <div class="card" id="expeted_status">
                                <table class="table table-striped thead-dark">
                                  <thead>
                                    <th>Review Date</th>
                                    <th>Review Type</th>
                                    <th>Expected Status</th>
                                    <th>Expected Date</th>
                                    <th>Current Status</th>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><span id="review_date"></span></td>
                                      <td><span id="review_type"></span></td>
                                      <td><span id="expected_status"></span></td>
                                      <td><span id="expected_date"></span></td>
                                      <td><span id="current_status"></span></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                      </div>



                      <div id="cmpmanytime">
                        <div>
                          <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample04"> How many task were done</label>
                            <input type="number" class="form-control" name="how_many_task"> 
                          </div>
                          <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample04"> Is the frequency of the task right? </label>
                            <select id="frequency_of_the_task" class="form-control" name="frequency_of_the_task" required>
                              <option selected value="">Select</option>
                              <option value="yes">Yes</option>
                              <option value="no">No</option>
                            </select>
                          </div>
                          <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample04"> Are the type of task right? </label>
                            <select id="type_of_task" class="form-control" name="type_of_task" required>
                              <option selected value="">Select</option>
                              <option value="yes">Yes</option>
                              <option value="no">No</option>
                            </select>
                          </div>
                          <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample04"> RP Meeting done (y/n) </label>
                            <select id="rp_meeting_done" class="form-control" name="rp_meeting_done" required>
                              <option selected value="">Select</option>
                              <option value="yes">Yes</option>
                              <option value="no">No</option>
                            </select>
                          </div>
                          <hr>
                          <div class="card p-2" style="background: antiquewhite">
                            <div class="col-12 col-md-12 mb-12" id="mom_done_card">
                              <label for="validationSample04">write MOM Done (y/n)</label>
                              <select id="mom_done" class="form-control" name="mom_done" required>
                                <option selected value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <div class="col-12 col-md-12 mb-12" id="social_networking_done_card">
                              <label for="validationSample04">Social networking done (y/n)</label>
                              <select id="social_networking_done" class="form-control" name="social_networking_done" required>
                                <option selected value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <div class="col-12 col-md-12 mb-12" id="category_right_card">
                              <label for="validationSample04">Is this category right? (y/n) </label>
                              <select id="category_right" class="form-control" name="category_right" required>
                                <option selected value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <div class="col-12 col-md-12 mb-12" id="slct_category_card">
                              <label for="validationSample02">Select Category</label>
                              <?php  $category=$this->Menu_model->GetCategories(); ?>
                              <select id="slct_category" name="slct_category" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php foreach($category as $p){?>
                                <option value="<?=$p->id?>"><?=$p->name?></option>
                                <?php }?>
                              </select>
                            </div>
                            <div class="col-12 col-md-12 mb-12" id="current_status_right_card">
                              <label for="validationSample04">Is this current status right?</label>
                              <select id="current_status_right" class="form-control" name="current_status_right" required>
                                <option selected value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <div class="col-12 col-md-12 mb-12" id="many_times_barge_meeting_card">
                              <label for="validationSample04">How many times barge meeting done?</label>
                              <select id="many_times_barge_meeting" class="form-control" name="many_times_barge_meeting" required>
                                <option selected value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <div class="col-12 col-md-12 mb-12" id="research_prospecting_card">
                              <label for="validationSample04">Research prospecting ?</label>
                              <select id="research_prospecting" class="form-control" name="research_prospecting" required>
                                <option selected value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <div class="col-12 col-md-12 mb-12" id="base_or_travel_location_card">
                              <label for="validationSample04">Base location or out station travel?</label>
                              <select id="base_or_travel_location" class="form-control" name="base_or_travel_location" required>
                                <option selected value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                          </div>

                          <div class="col-12 col-md-12 mb-12" id="base_or_travel_location_card">
                              <label for="validationSample04">Is this Partner Type is right? <span id="partner_type_set"></span></label>
                              <select id="partner_type_right" class="form-control" name="partner_type_right" required>
                                <option selected value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                              </select>
                            </div>

                          <div class="col-12 col-md-12 mb-12" id="slct_partner_type_card">
                            <label for="validationSample02"> Partner Type </label>
                            <?php  $partner=$this->Menu_model->get_partner(); ?>
                            <select id="slct_partner_type" name="slct_partner_type" class="form-control" required>
                              <option value="">Select Partner Type</option>
                              <?php foreach($partner as $p){?>
                              <option value="<?=$p->id?>"><?=$p->name?></option>
                              <?php }?>
                            </select>
                          </div>
                          <div class="col-12 col-md-12 mb-12">
                            <label for="validationSample02">Do you need any intervention or suppert from? </label>
                            <select id="intervention_or_suppert" name="intervention_or_suppert" class="form-control" required>
                              <option value="">Select</option>
                              <option value="Cluster manager">Cluster manager</option>
                              <option value="PST">PST </option>
                              <option value="Sales Head">Sales Head</option>
                            </select>
                          </div>
                        </div>
                      </div>



                      <hr>
                      <div class="card p-2" id="rosterhide">
                        <center>
                          <h5>Create Task</h5>
                        </center>
                        <input type="datetime-local" id="ntdate" name="ntdate" value="<?=date('Y-m-d H:i:s');?>" class="form-control" required="">
                        <lable>Select Action</lable>
                        <select id="ntaction" name="ntaction" class="form-control"  required="">
                          <option value="">Select Action</option>
                          <?php $action = $this->Menu_model->get_action();
                            $action_array = [1,3,4];
                            foreach($action as $a){
                            if(in_array($a->id, $action_array)){ ?> 
                          <option value="<?=$a->id?>"><?=$a->name?></option>
                          <?php }} ?>
                        </select>
                        <lable>Select Purpose</lable>
                        <select id="ntppose" class="form-control" name="ntppose" required="">
                        </select>
                        <lable>Expected Status</lable>
                        <select class="form-control" id="exsid" name="exsid" required="">
                          <option value="">Select Status</option>
                          <?php $status = $this->Menu_model->get_status($uid);
                            foreach($status as $st){
                            ?>
                          <option value="<?=$st->id?>"><?=$st->name?></option>
                          <?php } ?>
                        </select>
                        <lable>Expected Date</lable>
                        <input type="date" id="exdate" name="exdate" value="" class="form-control" required="" min="<?=date('Y-m-d');?>">
                      </div>
                      <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-success" onclick="this.form.submit(); this.disabled = true;">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-sm col-md-12 col-lg-12 m-auto">
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="table-responsive">
                    <div class="table-responsive">
                      <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>SNO</th>
                            <th>Updated By</th>
                            <th>Assign Date</th>
                            <th>Updated Date</th>
                            <th>Current Action</th>
                            <th>Action Taken</th>
                            <th>Purpose Achieved</th>
                            <th>Remarks</th>
                            <th>MOM</th>
                            <th>Last Status</th>
                            <th>Current Status</th>
                            <th>Next Status</th>
                          </tr>
                        </thead>
                        <tbody id="cmplogs">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
      </section>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script type='text/javascript'>
        $( document ).ready(function() {
            $("#cmpfirsttime").hide();
            $("#cmpmanytime").hide();
            $("#rosterform").hide();
            $("#loadcompinfo").hide();
            $("#travelclustercard").hide();
           
            $("#many_times_barge_meeting_card").hide();
            $("#research_prospecting_card").hide();
            $("#base_or_travel_location_card").hide();
            $("#slct_category_card").hide();
        
            $("#mom_done_card").hide();
            $("#social_networking_done_card").hide();
            $("#category_right_card").hide();
            $("#current_status_right_card").hide();
            $("#slct_partner_type_card").hide();
        
        });
        
        
        
        $('#otherremark').on('change', function b() {
            var val = this.value;
            if(val=='Other'){document.getElementById("otherremark1").readOnly = false;}else{
            document.getElementById("otherremark1").value=val;document.getElementById("otherremark1").readOnly = true;}
        });
        
        $('#rp_meeting_done').on('change', function b() {
            var val = this.value;
           if(val =='yes'){
        
            $("#rp_meeting_done_yes").show();
            $("#mom_done_card").show();
            $("#social_networking_done_card").show();
            $("#category_right_card").show();
            $("#current_status_right_card").show();
        
            $("#many_times_barge_meeting_card").hide();
            $("#research_prospecting_card").hide();
            $("#base_or_travel_location_card").hide();
           }
           if(val =='no'){
            $("#mom_done_card").hide();
            $("#social_networking_done_card").show();
            $("#category_right_card").show();
            $("#current_status_right_card").show();
            $("#many_times_barge_meeting_card").show();
            $("#research_prospecting_card").show();
            $("#base_or_travel_location_card").show();
           }
           
        });
        
        
        
        
        $('#travelcluster').on('change', function b() {
            var val = this.value;
            if(val=='yes'){
                $("#travelclustercard").hide();
            }else{
                $("#travelclustercard").show();
            }
        });
        $('#category_right').on('change', function b() {
            var val = this.value;
            if(val=='yes'){
                $("#slct_category_card").hide();
            }else{
                $("#slct_category_card").show();
            }
        });

        $('#partner_type_right').on('change', function b() {
            var val = this.value;
            if(val=='yes'){
                $("#slct_partner_type_card").hide();
            }else{
                $("#slct_partner_type_card").show();
            }
        });
        
        
        $('#ans1').on('change', function b() {
            var val = this.value;
            if(val=='Other'){document.getElementById("ans11").readOnly = false;}else{
            document.getElementById("ans11").value=val;document.getElementById("ans11").readOnly = true;}
        });
        
        $('#ans2').on('change', function b() {
            var val = this.value;
            if(val=='Other'){document.getElementById("ans21").readOnly = false;}else{
            document.getElementById("ans21").value=val;document.getElementById("ans21").readOnly = true;}
        });
        
        $('#ans3').on('change', function b() {
            var val = this.value;
            if(val=='Other'){document.getElementById("ans31").readOnly = false;}else{
            document.getElementById("ans31").value=val;document.getElementById("ans31").readOnly = true;}
        });
        
        
        $('#csrbudget').on('change', function b() {
            var val = this.value;
            if(val=='More than 2.5 csr budget'){
                var bdscholl = document.getElementById("bdscholl");
                bdscholl.min = 5;
                bdscholl.max = 10;
            }
            if(val=='Between 50 lacs to 2 cr'){
                var bdscholl = document.getElementById("bdscholl");
                bdscholl.min = 2;
                bdscholl.max = 5;
                
            }
            if(val=='Less than 50 lacs'){
                var bdscholl = document.getElementById("bdscholl");
                bdscholl.min = 1;
                bdscholl.max = 2;
                ''
            }
        });
        
        $("#orrr").hide();
        $('#statusid').on('change', function b() {
        var stid = document.getElementById("statusid").value;
        
        if(stid==1){$("#orrr").show();}
        else if(stid==8){$("#orrr").show();}
        else if(stid==2){$("#orrr").show();}
        else{$("#orrr").show();}
        
        
        
        $.ajax({
        url:'<?=base_url();?>Menu/getotherremark',
        type: "POST",
        data: {
        stid: stid
        },
        cache: false,
        success: function a(result){
        $("#otherremark").html(result);
        }
        });
        
        $.ajax({
        url:'<?=base_url();?>Menu/getcallremark',
        type: "POST",
        data: {
        stid: stid
        },
        cache: false,
        success: function a(result){
        $("#ans1").html(result);
        }
        });
        
        $.ajax({
        url:'<?=base_url();?>Menu/getemailremark',
        type: "POST",
        data: {
        stid: stid
        },
        cache: false,
        success: function a(result){
        $("#ans2").html(result);
        }
        });
        
        
        $.ajax({
        url:'<?=base_url();?>Menu/getmeetremark',
        type: "POST",
        data: {
        stid: stid
        },
        cache: false,
        success: function a(result){
        $("#ans3").html(result);
        }
        });
        
        
        
        });
        
        
        
        $('#reviewtype').on('change', function b() {
          var reviewtype = document.getElementById("reviewtype").value;
          var currentDate = new Date();
          
          if(reviewtype=='Weekly'){
              currentDate.setDate(currentDate.getDate() - 7);
          }
          if(reviewtype=='Fortnightly'){
              currentDate.setDate(currentDate.getDate() - 15);
          }
          if(reviewtype=='Monthly'){
              currentDate.setDate(currentDate.getDate() - 30);
          }
          if(reviewtype=='Querterly'){
              currentDate.setDate(currentDate.getDate() - 90);
          }
          var formattedDate = currentDate.toISOString().slice(0,10);
          document.getElementById("fixdate").value = formattedDate;
        });
        
        function myFunction() {
          var checkBox = document.getElementById("myCheckbox");
          if (checkBox.checked == true){
            document.getElementById("fixdate").readOnly = false;
          } else {
            document.getElementById("fixdate").readOnly = true;
          }
          
        }
        
        
        $('#statusid').on('change', function b() {
        var pstid = document.getElementById("pstid").value;
        var stid = document.getElementById("statusid").value;
        var bdid = document.getElementById("bdid").value;
        var fdate = document.getElementById("fdate").value;
        $.ajax({
        url:'<?=base_url();?>Menu/getcmpdbybd',
        type: "POST",
        data: {
        pstid: pstid,
        stid: stid,
        bdid: bdid,
        fdate: fdate,
        },
        cache: false,
        success: function a(result){
        $("#inid").html(result);
        }
        });
        });
        
        document.getElementById("statusno").style.display = "none";
        $('#statusright').on('change', function b() {
        var statusright = this.value;
        if(statusright=='No'){
            document.getElementById("statusno").style.display = "block";
        }else{
           document.getElementById("statusno").style.display = "none";
        }
        });
        
        $('#inid').on('change', function b() {
        var uid = '<?=$uid?>';
        var inid = document.getElementById("inid").value;
        var fdate = document.getElementById("fdate").value;
        $.ajax({
        url:'<?=base_url();?>Menu/getgraphlog',
        type: "POST",
        data: {
        inid: inid,
        fdate: fdate,
        uid: uid
        },
        cache: false,
        success: function a(result){
        $("#graphlog").html(result);
        }
        });
        
        $.ajax({
        url:'<?=base_url();?>Menu/CheckFirstTimeReviewInYear',
        type: "POST",
        data: {
        inid: inid,
        uid: uid
        },
        cache: false,
        success: function a(result){
            $("#loadcompinfo").show();
            $("#hideimage").hide();
            var rtype = document.getElementById("rtype").value;
            if(rtype=='Roaster'){
            $("#rosterform").show();
            var bdid = $("#bdid").val();
            $.ajax({
            url:'<?=base_url();?>Menu/GetTaskOfReciewCompany',
            type: "POST",
            data: {
            inid: inid,
            bdid: bdid
            },
            cache: false,
            success: function a(result){
              var jsonArray = JSON.parse(result);
              var review_date           = jsonArray.review_date; 
              var review_type           = jsonArray.review_type; 
              var expet_status_name     = jsonArray.expet_status_name; 
              var expet_status_date     = jsonArray.expet_status_date;
              var current_status_name   = jsonArray.current_status_name;
                $("#review_date").text(review_date);
                $("#review_type").text(review_type);
                $("#expected_status").text(expet_status_name);
                $("#expected_date").text(expet_status_date);
                $("#current_status").text(current_status_name);
                // console.log(result);
                // console.log(expet_status_name);
                // console.log(expet_status_date);
                // console.log(current_status_name);
            }
            });
              



            }else{
            if(result == 0){
            $("#cmpfirsttime").show();
            $("#cmpmanytime").hide();
            $("#review_time").val('First Time');
        
            $.ajax({
            url:'<?=base_url();?>Menu/GetCompnayDetailsUsiingInit',
            type: "POST",
            data: {
            inid: inid,
            uid: uid
            },
            cache: false,
            success: function a(result){
                var jsonArray       = JSON.parse(result);
                var companyName     = jsonArray[0].compname; 
                var pkclient        = jsonArray[0].pkclient; 
                var fbudget         = jsonArray[0].fbudget; 
                var noofschools     = jsonArray[0].noofschools; 
                var cstatus         = jsonArray[0].cstatus; 
                var partnerType_id  = jsonArray[0].partnerType_id; 
                var topspender      = jsonArray[0].topspender; 
                var pkclient        = jsonArray[0].pkclient; 
                var priorityc       = jsonArray[0].priorityc; 
                var upsell_client   = jsonArray[0].upsell_client; 
                var focus_funnel    = jsonArray[0].focus_funnel; 
                var cluster_id      = jsonArray[0].cluster_id; 
                
                // console.log(companyName);
                console.log(result);
            }
            });
        
        }else if(result > 0){
            $("#cmpfirsttime").hide();
            $("#cmpmanytime").show();
            $("#review_time").val('Many Time');


            $.ajax({
            url:'<?=base_url();?>Menu/GetCompnayDetailsUsiingInit',
            type: "POST",
            data: {
            inid: inid,
            uid: uid
            },
            cache: false,
            success: function a(result){
                var jsonArray       = JSON.parse(result);
                // var companyName     = jsonArray[0].compname; 
                // var pkclient        = jsonArray[0].pkclient; 
                // var fbudget         = jsonArray[0].fbudget; 
                // var noofschools     = jsonArray[0].noofschools; 
                var cstatus         = jsonArray[0].cstatus; 
                var partnerType_id  = jsonArray[0].partnerType_id; 
                // var topspender      = jsonArray[0].topspender; 
                // var pkclient        = jsonArray[0].pkclient; 
                // var priorityc       = jsonArray[0].priorityc; 
                // var upsell_client   = jsonArray[0].upsell_client; 
                // var focus_funnel    = jsonArray[0].focus_funnel; 
                // var cluster_id      = jsonArray[0].cluster_id; 
                
                

                    $.ajax({
                    url:'<?=base_url();?>Menu/getPartnerBYID',
                    type: "POST",
                    data: {
                    name: 'Partner',
                    pid: partnerType_id
                    },
                    cache: false,
                    success: function a(result){
                        $("#partner_type_set").html("<b> : "+result+"<b>");
                    }
                    });


            }
            });
        
        }
      }
        }
        });
        });
        
        
        $('#inid').on('change', function b() {
        var inid = document.getElementById("inid").value;
        var fdate = document.getElementById("fdate").value;
        $.ajax({
        url:'<?=base_url();?>Menu/getcmpnlog',
        type: "POST",
        data: {
        inid: inid,
        fdate: fdate
        },
        cache: false,
        success: function a(result){
        $("#cmpdata").html(result);
        }
        });
        });
        
        
        $('#inid').on('change', function b() {
    
        var rtype = document.getElementById("rtype").value;
        if(rtype=='Roaster'){
              $("#rosterhide").hide();
              $("#taskupdate").show();
              document.getElementById("ntaction").required = false;
              document.getElementById("ntdate").required = false;
              document.getElementById("ntppose").required = false;
              document.getElementById("exsid").required = false;
              document.getElementById("exdate").required = false;
        }else{
              $("#rosterhide").show();
              $("#taskupdate").hide();
              document.getElementById("ntaction").required = true;
              document.getElementById("ntdate").required = true;
              document.getElementById("ntppose").required = true;
              document.getElementById("exsid").required = true;
              document.getElementById("exdate").required = true;
        }  
            
        var inid = document.getElementById("inid").value;
        var fdate = document.getElementById("fdate").value;
        $.ajax({
        url:'<?=base_url();?>Menu/getcmplogs',
        type: "POST",
        data: {
        inid: inid,
        fdate: fdate
        },
        cache: false,
        success: function a(result){
        $("#cmplogs").html(result);
        }
        });
        });
        
        
        $('#ntaction').on('change', function f() {
            var sid = document.getElementById("ntstatus").value;
            var aid = document.getElementById("ntaction").value;
            $.ajax({
                url:'<?=base_url();?>Menu/getpurpose',
                type: "POST",
                data: {
                sid: sid,
                aid: aid
                },
                cache: false,
                success: function a(result){
                $("#ntppose").html(result);
                }
            });
        });
        
        
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
      "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
      "buttons": ["excel", "pdf"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    </script>
  </body>
</html>