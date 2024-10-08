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
 .form-group,p.tasklogp{font-weight:700}.create_task_bg,.form-group,p.tasklogp{box-shadow:rgba(9,30,66,.25) 0 1px 1px,rgba(9,30,66,.13) 0 0 1px 1px}div#cmpmanytime{background:#f0f8ff;padding:10px}thead{background:#000;color:#fff}.clrdiff{color:#f5004f}.create_task_bg,.form-group{background:#f0f8ff;padding:15px}.form-control.is-valid,.was-validated .form-control:valid{background:0 0!important;border-radius:5px}span.pccolor{color:#0830b1}#optionCountCompany{font-size:12px}p.tasklogp{align-items:center;justify-content:center;display:flex;padding:4px;margin:0;background:#faebd7;font-family:math}.card.generatetable.p-3 {background: beige;}
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
            <div class="col-sm col-md-12 col-lg-12 m-auto">
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <h4 class="text-center"><?=$revst[0]->reviewtype;?> Review/Calling</h4>
                  <h5 class="text-center"><?=$revst[0]->name;?></h5>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                    <div class="was-validated">
                    <div class="form-group <?php if($revst[0]->reviewtype == 'Roaster'){ echo "mt-5"; } ?>">
                      <input type="hidden" id="slsct_review_id" name="reviewtype" value="<?=$revst[0]->rid;?>">
                      <input type="hidden" name="uidaa" value="<?=$uid?>">
                      <input type="hidden" id="bdid" value="<?=$revst[0]->bdid;?>">
                      <?php 
                      date_default_timezone_set("Asia/Kolkata"); 
                      if($revst[0]->reviewtype == 'Roaster'){
                        $rev_startt = date("Y-m-d");
                        $revew_fixdate = date("Y-m-d", strtotime("-7 days", strtotime($rev_startt)));
                      }else{
                        $revew_fixdate = $revst[0]->fixdate;
                      }

                      ?>
                      <input type="date" id="fdate" name="fdate" value="<?= $revew_fixdate; ?>" class="form-control" readonly>
                    
                      <input type="hidden" id="pstid" value="<?=$uid?>">
                      <div class="invalid-feedback">Please provide Start Date Time.</div>
                      <div class="valid-feedback">Looks good!</div>
                      <?php  if($revst[0]->reviewtype !== 'Roaster'){ ?>
                      <div class="mt-4">
                        <select class="form-control" id="statusid" name="statusid" required="">
                          <option value="">Select Status</option>
                          <?php 
                            $typeid = $user['type_id'];
                            if($typeid == 3 || $typeid == 5){
                                $status_array = [1,4,5,8];
                            }else if($typeid == 13){
                                if($revst[0]->bdid == $revst[0]->uid){
                                  $status_array = [1,2,3,4,5,8];
                                }else{
                                  $status_array = [2,3];
                                }
                            }else if($typeid == 4){
                                $status_array = [6,9,12,13];
                            }else if($typeid == 9){
                                $status_array = [2,3,4,5,6,8,9,12,13];
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
                        <p id="optionCountCompany"></p>
                        <div class="invalid-feedback">Please Select Status First.</div>
                        <div class="valid-feedback">Looks good!</div>
                      </div>
                      <?php }else{ 
                          $user_type = $user['type_id'];
                          $revtype = $this->Menu_model->GetReviewType(1);
                          
                         ?>
                        <div class="mt-4">
                        <lable>Select Review : </lable>
                        <select class="form-control" name="inid" required="" id="inid">
                        <option value="">Select Review Type</option>
                          <?php foreach($revtype as $rtype):
                            if($rtype->name != 'Roaster'):
                            ?>
                          <option value="<?= $rtype->name; ?>"><?= $rtype->name; ?></option>
                          <?php 
                        endif;
                        endforeach; ?>
                        </select>
                        <p id="optionCountCompany"></p>
                        <div class="invalid-feedback">Please Select Status First.</div>
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="mt-4">
                        <lable>Select Date : </lable>
                        <select class="form-control" name="reviewdate" required="" id="reviewdate">
                        </select>
                        <p id="reviewdatecnt"></p>
                        <div class="invalid-feedback">Please Select Status First.</div>
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                        <?php } ?>
                    </div>
                    <a href="<?=base_url();?>Menu/AllReviewac"><button type="button" class="btn btn-outline-danger">Go to Action wise Review</button></a><br>
                  </div>
                    </div>
                    
                 
                  <div class="col-md-6">
                  <div class="card p-3 mt-3">
                    <div class="was-validated">
                      <form action="<?=base_url();?>Menu/closereview" method="post">
                        <input type="hidden" name="rrid" value="<?=$revst[0]->rid;?>">
                        
                        <div class="form-group">
                          <textarea class="form-control mt-3" name="closeremark" placeholder="Review Close Final Remark..."  required=""></textarea>
                          <input type="datetime-local" name="closetdate" value="<?=date('Y-m-d H:i:s');?>" class="form-control mt-3" required="">
                          <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to close review task ?');">Close Review</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                      </div>
                    </div>
                 
                </div>
              </div>
              <!-- <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                      <button class="btn btn-link bg-info font-weight-bold form-control" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Graph
                      </button>
                    </h5>
                  </div>
                  <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                    <div class="card p-3" id="graphlog"></div>
                    </div>
                  </div>
                </div>
              </div> -->
              
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 m-auto">
              <div class="card card-primary card-outline">
                <center><img src="http://localhost/StemSales/assets/image/2391280.jpg" id="hideimage" style="width:300px;" alt=""></center>
                <div id="loadcompinfo">
                  <form action="<?=base_url();?>Menu/bdrtaskc" method="post">
                    <input type="hidden" id="rtype" name="rtype" value="<?=$revst[0]->reviewtype;?>">
                    <div class="was-validated m-3">
                      <div class="card-body box-profile" id="cmpdata">
                      </div>
                      <input type="hidden" name="pstuid" value="<?=$uid?>">
                      <input type="hidden" id="slctbduid" name="bduid" value="<?=$bdid?>">
                      <input type="hidden" name="rid" value="<?=$revst[0]->rid;?>">
                      <div id="cmpfirsttime">
                        <input type="hidden" id="review_time" name="review_time" value="">
                        <div class="row">
                            <div class="col-md-4">
                            <div id="orrr">
                          <div class="form-group">
                          <lable>Is this Company Name is Right? : 
                            <span class="clrdiff" id="ccompanyname"></span>
                          </lable>
                          <input type="hidden" name="companyright[]" value="Is this Company Name is Right?">
                          <select class="form-control" required="" id="slct_right_company" name="companyright[]">
                            <option value="" selected disabled >Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                          <div class="form-group mt-2" id="right_company_name">
                          <input type="text" name="companyright[]" class="form-control" placeholder="Type Right Company Name" id="">
                          </div>
                          </div>
                          <hr>
                          <div class="form-group">
                          <lable>Is this Address is Right? : <span class="clrdiff" id="caddress"></span></lable>
                          <input type="hidden" name="company_address_right[]" value="Is this Address is Right?">
                          <select class="form-control" required="" name="company_address_right[]" id="address_is_right">
                          <option value="" selected disabled >Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                          <div class="form-group mt-3" id="rightAddrress">
                          <textarea name="company_address_right[]" class="form-control" placeholder="Type Right Company Address"></textarea>
                          </div>
                          </div>
                          <hr>
                          <div class="form-group">
                          <lable>Is this City is Right? :  <span class="clrdiff" id="ccity"></span></lable>
                          <input type="hidden" name="company_city_right[]" value="Is this City is Right?">
                          <select class="form-control" required="" name="company_city_right[]" id="user_slct_city">
                          <option value="" selected disabled >Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                          <div id="slctCity" class="mt-2">
                          <select class="form-control" name="company_city_right[]" required="">
                            <?php $city = $this->Menu_model->GetCity(); ?>
                          <option value="" selected disabled >Select</option>
                          <?php foreach($city as $ct){ ?>
                            <option value="<?= $ct->name; ?>"><?= $ct->name; ?></option>
                            <?php } ?>
                          </select>
                          </div> 
                          </div>
                          <hr>
                          <div class="form-group">
                          <lable>Is this State is Right? : <span class="clrdiff" id="cstate"></span></lable>
                          <input type="hidden" name="company_State_right[]" value="Is this State is Right?">
                          <select class="form-control" name="company_State_right[]" required="" id="user_slct_state" >
                          <option value="" selected disabled >Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                          <div id="slctState" class="mt-2">
                          <select class="form-control" name="company_State_right[]" required="">
                            <?php $state = $this->Menu_model->GetState(); ?>
                          <option value="" selected disabled >Select</option>
                          <?php foreach($state as $st){ ?>
                            <option value="<?= $st->state_title; ?>"><?= $st->state_title; ?></option>
                            <?php } ?>
                          </select>
                          </div> 
                          </div>
                          <hr>
                          <div class="form-group">
                          <lable>Is this Country is Right? : <span class="clrdiff" id="ccountry"></span></lable>
                          <input type="hidden" name="company_country_right[]" value="Is this Country is Right?">
                          <select class="form-control" required="" name="company_country_right[]" id="user_slct_country" >
                          <option value="" selected disabled >Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                        
                          <div id="slctCountry" class="mt-2">
                          <select class="form-control" name="company_country_right[]" required="">
                            <?php $country = $this->Menu_model->GetCountry(); ?>
                          <option value="" selected disabled >Select</option>
                          <?php foreach($country as $cty){ ?>
                            <option value="<?= $cty->name; ?>"><?= $cty->name; ?></option>
                            <?php } ?>
                          </select>
                          </div>
                          </div>
                   
                          <hr>
                          <div class="form-group">
                          <lable>Is this Primary Contact information is Right? : <br/> 
                          <div class="clrdiff" id="primary_contact"></div>
                        </lable>
                        <input type="hidden" name="company_primary_contact_right[]" value="Is this Primary Contact information is Right?">
                          <select class="form-control" name="company_primary_contact_right[]" id="primary_contact_slct" required="">
                          <option value="" selected disabled >Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                          
                          <div class="form-group mt-3" id="primarycontact_person">
                            <input type="text" class="form-control" name="company_primary_contact_right[]" placeholder="Enter Contact Person Name"> <br>
                            <input type="text" class="form-control" name="company_primary_contact_right[]" placeholder="Enter Email ID"><br>
                            <input type="text" class="form-control" name="company_primary_contact_right[]" placeholder="Enter Mobile Numaber">
                            <br>
                            <input type="text" class="form-control" name="company_primary_contact_right[]" placeholder="Type Person Designation">
                          </div>
                          </div>
                          <hr>
                          <div class="form-group">
                          <lable>Is this Secondary Contact information is Right? <br/>
                          <div class="clrdiff" id="secondary_contact"></div>
                        </lable>
                        <input type="hidden" name="company_secondary_contact_right[]" value="Is this Secondary Contact information is Right?">
                          <select class="form-control" name="company_secondary_contact_right[]" id="secondary_contact_slct" required="">
                          <option value="" selected disabled >Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                          
                          <div class="form-group mt-3" id="secondarycontact_person">
                            <input type="text" class="form-control" name="company_secondary_contact_right[]" placeholder="Enter Contact Person Name"> <br>
                            <input type="text" class="form-control" name="company_secondary_contact_right[]" placeholder="Enter Email ID"><br>
                            <input type="text" class="form-control" name="company_secondary_contact_right[]" placeholder="Enter Mobile Numaber">
                            <br>
                            <input type="text" class="form-control" name="company_secondary_contact_right[]" placeholder="Type Person Designation">
                          </div>
                          </div>
                        
                        </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group">
                        <lable>Is the Current Status right? : 
                          <span class="clrdiff" id="current_status_message"></span>
                        </lable>
                        <input type="hidden" name="company_status_right[]" value="Is the Current Status right?">
                        <select class="form-control" id="statusright" name="company_status_right[]" required="">
                        <option value="" selected disabled >Select</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                
                        <div class="form-group mt-2" id="statusno">
                          <select class="form-control" name="company_status_right[]" required="">
                            <option value="" selected disabled >Select Status</option>
                            <?php $status = $this->Menu_model->get_status();
                              foreach($status as $st){?>
                            <option value="<?=$st->id?>"><?=$st->name?></option>
                            <?php } ?>
                          </select>
                        </div>
                        </div>
                        <hr>
                        <div class="form-group">
                        <lable>Need to Delete This Company From Your Funnel? </lable>
                        <input type="hidden" name="delete_this_company[]" value="Need to Delete This Company From Your Funnel?">
                        <select class="form-control" name="delete_this_company[]" required="" id="slct_delete_this_company">
                        <option value="" selected disabled >Select</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                        <div class="form-group mt-3" id="delete_this_company">
                          <textarea name="delete_this_company[]" class="form-control" placeholder="Type Remarks Why You Want to Delete This." required="required"></textarea>
                          </div>
                        </div>
                        <hr>
                        <div class="form-group">
                        <lable>Need to Change Partner Type? : 
                        <span class="clrdiff" id="curremt_partner_type"></span>
                        </lable>
                        <input type="hidden" name="change_partner_ype[]" value="Need to Change Partner Type?">
                        <select class="form-control" name="change_partner_ype[]" required="" id="slct_partner_type">
                        <option value="" selected disabled >Select </option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                        </select>
                        <div class="form-group mt-2" id="slct_current_partner_type">
                          <select class="form-control" name="change_partner_ype[]" required="">
                            <option value="" selected disabled >Select Partner Type</option>
                            <?php $partners = $this->Menu_model->get_partner();
                              foreach($partners as $part){?>
                            <option value="<?=$part->id?>"><?=$part->name?></option>
                            <?php } ?>
                          </select>
                        </div>
                        </div>
                        <hr>
                        
                        <div class="form-group">
                          <div class="col-12 col-md-12 mb-12">
                            <lable>Travel Cluster is Right or not ? :
                            <span class="clrdiff" id="curremt_clustername"></span>    
                          </lable>
                          <input type="hidden" name="travel_cluster[]" value="Travel Cluster is Right or not ?">
                            <select class="form-control" id="travelcluster" name="travel_cluster[]" required="">
                            <option value="" selected disabled >Select</option>
                              <option value="yes">Yes</option>
                              <option value="no">No</option>
                            </select>
                          </div>
                          <div class="form-group mt-2" id="slct_cluster_card">
                          <select class="form-control" name="travel_cluster[]" required="">
                            <option value="" selected disabled >Select Travel Cluster </option>
                            <?php $clusters = $this->Menu_model->getClusterByUserId($uid);
                              foreach($clusters as $cluster){?>
                            <option value="<?=$cluster->id?>"><?=$cluster->clustername?></option>
                            <?php } ?>
                          </select>
                        </div>
                        </div>
                        <hr>
                     
                        <div class="form-group">
                          <lable>Add CSR Budget : <span class="clrdiff" id="csr_budget"></span></lable>
                          <input type="hidden" name="csrbudget[]" value="Add CSR Budget">
                          <select class="form-control" id="csrbudget" name="csrbudget[]" required="">
                          <option value="" selected disabled >Select</option>
                            <option>More than 2.5 csr budget</option>
                            <option>Between 50 lacs to 2 cr</option>
                            <option>Less than 50 lacs</option>
                          </select>
                          </div>
                          <hr>
                          <!-- <div class="form-group">
                          <lable>Add Number of Schools : <span class="clrdiff" id="number_of_schools"></span></lable>
                          <input type="number" class="form-control" name="bdscholl" id="bdscholl" required="">
                          </div> -->
                          <hr>
                          <div class="form-group">
                          <lable>Is this Website is Right? : 
                            <span class="clrdiff" id="website_is_right"></span>
                          </lable>
                          <input type="hidden" name="website_is_right[]" value="Is this Website is Right?">
                          <select class="form-control" name="website_is_right[]" required="" id="slct_website_is_right">
                          <option value="" selected disabled>Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                          <div class="form-group" id="websiteisright_card">
                          <input type="text" class="form-control" name="website_is_right[]" placeholder="Enter Right Website Address" id="websiteisright">
                          </div>
                          </div>
                            </div>
                            <div class="col-md-4">
              
                          <div class="form-group">
                          <lable>Potential / Non-Potential Clients? : <span class="clrdiff" id="potential_client"></span> </lable>
                          <input type="hidden" name="potential[]" value="Potential / Non-Potential Clients?">
                          <select class="form-control" id="potential" name="potential[]" required="">
                          <option value="" selected disabled >Select</option>
                            <option value='yes'>Potential</option>
                            <option value='no'>Non-Potential</option>
                          </select>
                          </div>
                          <hr>
        
                        
                         
                          <div class="form-group">
                        <lable>Top Spender?  : <span class="clrdiff" id="top_spender"></span></lable>
                        <input type="hidden" name="topspender[]" value="Top Spender?">
                        <select class="form-control" name="topspender[]" required="">
                        <option value="" selected disabled >Select</option>
                        <option>Yes</option>
                        <option>No</option>
                        </select>
                        </div>
                        <!-- <hr>
                        <div class="form-group">
                        <lable>Key Client? : <span class="clrdiff" id="key_client"></span></lable>
                        <select class="form-control" name="keyclient">
                          <option>No</option>
                          <option>Yes</option>
                        </select>
                        </div> -->
                        <hr>
                        <div class="form-group">
                        <lable>Positive Key Client? : <span class="clrdiff" id="p_key_client"></span></lable>
                        <input type="hidden" name="pkeyclient[]" value="Positive Key Client?">
                        <select class="form-control" name="pkeyclient[]" required="">
                        <option value="" selected disabled >Select</option>
                        <option>Yes</option>
                        <option>No</option>
                        </select>
                        </div>
                        <hr>
                        <div class="form-group">
                        <lable>Priority Client? : <span class="clrdiff" id="priority_client"></span></lable>
                        <input type="hidden" name="priorityclient[]" value="Priority Client?">
                        <select class="form-control" name="priorityclient[]" required="">
                        <option value="" selected disabled >Select</option>
                        <option>Yes</option>
                        <option>No</option>
                        </select>
                        </div>
                        <hr>
                        <div class="form-group">
                        <lable>Upsell Client? : <span class="clrdiff" id="upsell_client"></span></lable>
                        <input type="hidden" name="upsellclient[]" value="Upsell Client?">
                        <select class="form-control" name="upsellclient[]" required="">
                        <option value="" selected disabled >Select</option>
                        <option>Yes</option>
                        <option>No</option>
                        </select>
                        </div>
                        <hr>
                        <div class="form-group">
                        <lable>Focus Funnel? : <span class="clrdiff" id="focus_funnel"></span></lable>
                        <input type="hidden" name="focusyclient[]" value="Focus Funnel?">
                        <select class="form-control" name="focusyclient[]" required="">
                        <option value="" selected disabled >Select</option>
                        <option>Yes</option>
                        <option>No</option>
                        </select>
                        </div>
                        <hr>
                            </div>
                          </div>
                       
                       
                      </div>
                      <div id="rosterform">
                        <hr class="card" id="expeted_status">
                          <div class="table-responsive">
                            <div id="rosterReviewData"></div>
                          </div>
                        <hr>
                        </div>
                      </div>
                      <div id="cmpmanytime"></div>
                      <div id="common_review_slct">       
                      <div class="card bg-gray p-2 text-center">
                        <h5>Question Linked With Activity Conversion</h5>
                      </div>
                      <hr>
                      <div class="card">
                      <div>
                      <div id="accordion">
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04"> Is the total Logs Right ? : <span class="clrdiff" id="total_Logs"></span></label>
                          <input type="hidden" readonly value="Is the total Logs Right ?" class="form-control" name="total_Logs[]"> 
                          
                            <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                      Check total Log
                                    </p>
                                <div id="collapseOne" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="totaltaskdata"></div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                          <div class="form-group">
                              <textarea class="form-control" name="total_Logs[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04"> How many calls done ? : <span class="clrdiff" id="how_many_calls"></span></label>
                          <input type="hidden" readonly value="How many calls done ? " class="form-control" name="how_many_calls[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                      Check calls Log
                                    </p>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="task_how_many_calls"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="how_many_calls[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04"> How many emails done ? : <span class="clrdiff" id="totalTasks_email"></span></label>
                          <input type="hidden" readonly value="How many emails done ?" class="form-control" name="how_many_emails[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                      Check emails Log
                                    </p>
                                <div id="collapseThree" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="task_how_many_email"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="how_many_emails[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04"> Scheduled meetings done ? : <span class="clrdiff" id="scheduled_meetings_cnt"></span></label>
                          <input type="hidden" readonly value="Scheduled meetings done ?" class="form-control" name="scheduled_meetings[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                                      Check Scheduled meetings Log
                                    </p>
                                <div id="collapsefour" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="scheduled_meetings_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="scheduled_meetings[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04"> Barg-in meetings done ? : <span class="clrdiff" id="barg_in_meetings_cnt"></span> </label>
                          <input type="hidden" readonly value="Barg-in meetings done ?" class="form-control" name="barg_in_meetings[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapsefive" aria-expanded="true" aria-controls="collapsefive">
                                      Check Barg-in meetings Log
                                    </p>
                                <div id="collapsefive" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="barg_in_meetings_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="barg_in_meetings[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04">Whatsapp Activity done ? : <span class="clrdiff" id="whatsapp_activity_cnt"></span></label>
                          <input type="hidden" readonly value="Whatsapp Activity done ?" class="form-control" name="whatsapp_activity[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">
                                      Check Whatsapp Activity Log
                                    </p>
                                <div id="collapsesix" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="whatsapp_activity_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="whatsapp_activity[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04">Social networking done ? : <span class="clrdiff" id="social_networking_cnt"></span></label>
                          <input type="hidden" readonly value="Social networking done ?" class="form-control" name="social_networking[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                      Check Social networking Log
                                    </p>
                                <div id="collapseSeven" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="social_networking_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="social_networking[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04">MOMs Done ? : <span class="clrdiff" id="mom_done_cnt"></span></label>
                          <input type="hidden" readonly value="MOMs Done ?" class="form-control" name="mom_done[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                                      Check MOMs Log
                                    </p>
                                <div id="collapseEight" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="mom_done_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="mom_done[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04">Proposal Done ? : <span class="clrdiff" id="proposal_done_cnt"></span></label>
                          <input type="hidden" readonly value="Proposal Done ?" class="form-control" name="proposal_done[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                                      Check Proposal Log
                                    </p>
                                <div id="collapseNine" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="proposal_done_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="proposal_done[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04">How many research tasks done ? : <span class="clrdiff" id="how_many_research_cnt"></span></label>
                          <input type="hidden" readonly value="Proposal written?" class="form-control" name="how_many_research[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapseTen" aria-expanded="true" aria-controls="collapseTen">
                                      Check Research Log
                                    </p>
                                <div id="collapseTen" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="how_many_research_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="how_many_research[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04">How many task done by Cluster Manager? : <span class="clrdiff" id="task_done_by_cluster_cnt"></span> </label>
                          <input type="hidden" readonly value="How many task done by Cluster ?" class="form-control" name="task_done_by_cluster[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="true" aria-controls="collapseEleven">
                                      Check Log
                                    </p>
                                <div id="collapseEleven" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="task_done_by_cluster_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="task_done_by_cluster[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04">How much has the cluster Manager is status changed? : <span class="clrdiff" id="status_change_by_cluster_cnt">0</span> </label>
                          <input type="hidden" readonly value="How much has the cluster's status changed?" class="form-control" name="status_change_by_cluster[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapsethrtten" aria-expanded="true" aria-controls="collapsethrtten">
                                      Check Log
                                    </p>
                                <div id="collapsethrtten" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="status_change_by_cluster_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="status_change_by_cluster[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04">How many task done by PST ? : <span class="clrdiff" id="task_done_by_pst_cnt"></span> </label>
                          <input type="hidden" readonly value="How many task done by PST ?" class="form-control" name="task_done_by_pst[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="true" aria-controls="collapseTwelve">
                                      Check Log
                                    </p>
                                <div id="collapseTwelve" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="task_done_by_pst_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="task_done_by_pst[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-2">
                          <label for="validationSample04">How much has the PST's status changed? : <span class="clrdiff" id="status_change_by_pst_cnt">0</span></label>
                          <input type="hidden" readonly value="How much has the PST's status changed?" class="form-control" name="status_change_by_pst[]"> 
                          <div class="card">
                            <p class="tasklogp" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="true" aria-controls="collapseTwelve">
                                      Check Log
                                    </p>
                                <div id="collapseTwelve" class="collapse" data-parent="#accordion">
                                  <div class="card-body">
                                      <div class="table-responsive">
                                        <div id="status_change_by_pst_table"></div>
                                      </div>
                                  </div>
                                </div>
                          </div>
                          <div class="form-group">
                              <textarea class="form-control" name="status_change_by_pst[]" placeholder="Review Remark..."  required=""></textarea>
                          </div>
                        </div>
                        <div class="col-12 col-md-12 mb-12 card p-5" style="background: cornsilk;">
                          <label for="validationSample04"> Is the frequency of the task right? </label>
                          <input type="hidden" readonly value="Is the frequency of the task right?" class="form-control" name="task_frequency[]"> 
                          <select id="frequency_of_the_task" class="form-control" name="task_frequency[]" required>
                            <option selected value="">Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                          <label for="validationSample02">Do you need any intervention or support from? </label>
                          <input type="hidden" readonly value="Do you need any intervention or support from?" class="form-control" name="intervention_or_suppert[]"> 
                          <select id="intervention_or_suppert" name="intervention_or_suppert[]" class="form-control" required>
                            <option value="">Select</option>
                            <option value="Cluster manager">Cluster manager</option>
                            <option value="PST">PST </option>
                            <option value="Sales Head">Sales Head</option>
                          </select>
                        </div>
                        </div>
                        </div>
                      </div>
                    </div>
                      <hr>
                      <div class="card p-2 create_task_bg pb-4" id="rosterhide">
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
                      <hr>
                      <div class="form-group text-center mt-3" id="reviewmainremarks">
                          <textarea class="form-control" name="remark" placeholder="Review Remark..."  required=""></textarea>
                        <br>
                      <!-- <div class="form-group text-center mt-3" style="background: cadetblue; border-radius: 50px;"> -->
                   
                        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to submit this review form');" id="mainformbtn" value="">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-sm col-md-12 col-lg-12 m-auto" id="mainlogtable">
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
            
           
            // $("#many_times_barge_meeting_card").hide();
            // $("#research_prospecting_card").hide();
            // $("#base_or_travel_location_card").hide();
            // $("#slct_category_card").hide();
        
            // $("#mom_done_card").hide();
            // $("#social_networking_done_card").hide();
            // $("#category_right_card").hide();
            // $("#current_status_right_card").hide();
            // $("#slct_partner_type_card").hide();
            $("#slctCountry").hide();
            $("#slctState").hide();
            $("#slctCity").hide();
            $("#primarycontact_person").hide();
            $("#secondarycontact_person").hide();
            $("#rightAddrress").hide();
            $("#right_company_name").hide();
            $("#statusno").hide();
            $("#delete_this_company").hide();
            $("#slct_current_partner_type").hide();
            $("#websiteisright_card").hide();
            $("#slct_cluster_card").hide();
            $("#mainlogtable").hide();

            var rtypeslct = document.getElementById("rtype").value;
            if(rtypeslct == 'Roaster'){
              $("#common_review_slct").hide();
              $("#cmpdata").hide();
            }
        });
        
        
        
        $('#otherremark').on('change', function b() {
            var val = this.value;
            if(val=='Other'){document.getElementById("otherremark1").readOnly = false;}else{
            document.getElementById("otherremark1").value=val;document.getElementById("otherremark1").readOnly = true;}
        });
        $('#user_slct_city').on('change', function() {
          var val = this.value;
          if(val == 'no'){
            $("#slctCity").show();
            $("#slctCity select").attr('required', true);
          }else{
            $("#slctCity select").removeAttr('required');
            $("#slctCity").hide();
            
          }
      });
        $('#user_slct_state').on('change', function() {
          var val = this.value;
          if(val == 'no'){
            $("#slctState").show();
            $("#slctState").attr('required', true);
          }else{
            $("#slctState select").removeAttr('required');
            $("#slctState").hide();
          }
      });
        $('#user_slct_country').on('change', function() {
          var val = this.value;
          if(val == 'no'){
            $("#slctCountry").show();
            $("#slctCountry").attr('required', true);
          }else{
            $("#slctCountry select").removeAttr('required');
            $("#slctCountry").hide();
          }
      });
      $('#primary_contact_slct').on('change', function() {
          var val = this.value;
          if (val == 'no') {
              $("#primarycontact_person").show();
              $("#primarycontact_person input").attr('required', true);
          } else {
              $("#primarycontact_person input").removeAttr('required');
              $("#primarycontact_person").hide();
          }
      });
      $('#secondary_contact_slct').on('change', function() {
          var val = this.value;
          if (val == 'no') {
              $("#secondarycontact_person").show();
              $("#secondarycontact_person input").attr('required', true);
          } else {
              $("#secondarycontact_person input").removeAttr('required');
              $("#secondarycontact_person").hide();
          }
      });
      $('#address_is_right').on('change', function() {
          var val = this.value;
          if (val == 'no') {
              $("#rightAddrress").show();
              $("#rightAddrress textarea").attr('required', true);
          } else {
              $("#rightAddrress textarea").removeAttr('required');
              $("#rightAddrress").hide();
          }
      });
      $('#slct_delete_this_company').on('change', function() {
          var val = this.value;
          if (val == 'yes') {
              $("#delete_this_company").show();
              $("#delete_this_company textarea").attr('required', true);
          } else {
              $("#delete_this_company textarea").removeAttr('required');
              $("#delete_this_company").hide();
          }
      });
      $('#slct_right_company').on('change', function() {
          var val = this.value;
          if (val == 'no') {
              $("#right_company_name").show();
              $("#right_company_name input").attr('required', true);
          } else {
              $("#right_company_name input").removeAttr('required');
              $("#right_company_name").hide();
          }
      });
      $('#statusright').on('change', function() {
          var val = this.value;
          if (val == 'no') {
              $("#statusno").show();
              $("#statusno select").attr('required', true);
          } else {
              $("#statusno select").removeAttr('required');
              $("#statusno").hide();
          }
      });
      $('#slct_partner_type').on('change', function() {
          var val = this.value;
          if (val == 'yes') {
              $("#slct_current_partner_type").show();
              $("#slct_current_partner_type select").attr('required', true);
          } else {
              $("#slct_current_partner_type select").removeAttr('required');
              $("#slct_current_partner_type").hide();
          }
      });
      $('#slct_website_is_right').on('change', function() {
          var val = this.value;
          if (val == 'no') {
              $("#websiteisright_card").show();
              $("#websiteisright_card input").attr('required', true);
          } else {
              $("#websiteisright_card input").removeAttr('required');
              $("#websiteisright_card").hide();
          }
      });
      $('#travelcluster').on('change', function() {
          var val = this.value;
          if (val == 'no') {
              $("#slct_cluster_card").show();
              $("#slct_cluster_card select").attr('required', true);
          } else {
              $("#slct_cluster_card select").removeAttr('required');
              $("#slct_cluster_card").hide();
          }
      });
        
        // $('#rp_meeting_done').on('change', function b() {
        //     var val = this.value;
        //    if(val =='yes'){
        
        //     $("#rp_meeting_done_yes").show();
        //     $("#mom_done_card").show();
        //     $("#social_networking_done_card").show();
        //     $("#category_right_card").show();
        //     $("#current_status_right_card").show();
        
        //     $("#many_times_barge_meeting_card").hide();
        //     $("#research_prospecting_card").hide();
        //     $("#base_or_travel_location_card").hide();
        //    }
        //    if(val =='no'){
        //     $("#mom_done_card").hide();
        //     $("#social_networking_done_card").show();
        //     $("#category_right_card").show();
        //     $("#current_status_right_card").show();
        //     $("#many_times_barge_meeting_card").show();
        //     $("#research_prospecting_card").show();
        //     $("#base_or_travel_location_card").show();
        //    }
           
        // });
        
        
        
   
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
        
        
        // $('#csrbudget').on('change', function b() {
        //     var val = this.value;
        //     if(val=='More than 2.5 csr budget'){
        //         var bdscholl = document.getElementById("bdscholl");
        //         bdscholl.min = 5;
        //         bdscholl.max = 10;
        //     }
        //     if(val=='Between 50 lacs to 2 cr'){
        //         var bdscholl = document.getElementById("bdscholl");
        //         bdscholl.min = 2;
        //         bdscholl.max = 5;
                
        //     }
        //     if(val=='Less than 50 lacs'){
        //         var bdscholl = document.getElementById("bdscholl");
        //         bdscholl.min = 1;
        //         bdscholl.max = 2;
        //         ''
        //     }
        // });
        
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
        var review_id = document.getElementById("slsct_review_id").value;
        var pstid = document.getElementById("pstid").value;
        var stid = document.getElementById("statusid").value;
        var bdid = document.getElementById("bdid").value;
        var fdate = document.getElementById("fdate").value;
        $.ajax({
        url:'<?=base_url();?>Menu/getcmpdbybd',
        type: "POST",
        data: {
        review_id: review_id,
        pstid: pstid,
        stid: stid,
        bdid: bdid,
        fdate: fdate,
        },
        cache: false,
        success: function a(result){
        $("#inid").html(result);
        var optionCount = $('#inid option').length;
        var optionCount = optionCount -1;
        $("#optionCountCompany").text("Total Company is: " + optionCount);
        if(optionCount == 0){
          $("#optionCountCompany").css('color', 'red');
        }else{
          $("#optionCountCompany").css('color', 'green');
        }
        $('#inid').css('color', 'green');
        $('#inid option').css('color', 'green');
        }
        });
        });
        
        // document.getElementById("statusno").style.display = "none";
        // $('#statusright').on('change', function b() {
        // var statusright = this.value;
        // if(statusright=='No'){
        //     document.getElementById("statusno").style.display = "block";
        // }else{
        //    document.getElementById("statusno").style.display = "none";
        // }
        // });
        
        $('#inid').on('change', function b() {
        var uid = '<?=$uid?>';
        var inid = document.getElementById("inid").value;
        var fdate = document.getElementById("fdate").value;
        // $.ajax({
        // url:'<?=base_url();?>Menu/getgraphlog',
        // type: "POST",
        // data: {
        // inid: inid,
        // fdate: fdate,
        // uid: uid
        // },
        // cache: false,
        // success: function a(result){
        // $("#graphlog").html(result);
        // }
        // });
        
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
            }
            });
              
            }else{
            if(result == 0){
            $("#cmpfirsttime").show();
            $("#cmpmanytime").hide();
            $("#review_time").val('First Time');
            $("#mainformbtn").val('FirstTime');
            $("#mainlogtable").hide();
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
                var priorityc       = jsonArray[0].priorityc; 
                var upsell_client   = jsonArray[0].upsell_client; 
                var focus_funnel    = jsonArray[0].focus_funnel; 
                var cluster_id      = jsonArray[0].cluster_id; 
                var address      = jsonArray[0].address; 
                var city      = jsonArray[0].city; 
                var state      = jsonArray[0].state; 
                var country      = jsonArray[0].country; 
                var cmpid_id      = jsonArray[0].cmpid_id; 
                var website      = jsonArray[0].website; 
                var budget      = jsonArray[0].budget; 
                var potential      = jsonArray[0].potential; 
                
                $("#ccompanyname").text((companyName !== '')? companyName : 'NA');
                $("#caddress").text((address !== '')? address : 'NA');
                $("#ccity").text((city !== '')? city : 'NA');
                $("#cstate").text((state !== '')? state : 'NA');
                $("#ccountry").text((country !== '')? country : 'NA');
                $("#csr_budget").text(budget);
                $("#number_of_schools").text((noofschools != 0)? noofschools : 'NA');
                $("#website_is_right").text((website !== '')? website : 'NA');
                $("#potential_client").text((potential !== '')? potential : 'NA');
                $("#top_spender").text((topspender !== '')? topspender : 'NA');
                $("#p_key_client").text((pkclient !== '')? pkclient : 'NA');
                $("#priority_client").text((priorityc !== '')? priorityc : 'NA');
                $("#upsell_client").text((upsell_client !== '')? upsell_client : 'NA');
                $("#focus_funnel").text((focus_funnel !== '')? focus_funnel : 'NA');
                $.ajax({
                url:'<?=base_url();?>Menu/GetCompanyPrimaryContact',
                type: "POST",
                data: {
                  cmpid_id: cmpid_id,
                  ctype: 'primary'
                },
                cache: false,
                success: function a(result){
                  $("#primary_contact").html(result);
                }
              });
              $.ajax({
                url:'<?=base_url();?>Menu/GetCompanyPrimaryContact',
                type: "POST",
                data: {
                  cmpid_id: cmpid_id,
                  ctype: 'alternate'
                },
                cache: false,
                success: function a(result){
                  $("#secondary_contact").html(result);
                }
              });
      
              $.ajax({
                url:'<?=base_url();?>Menu/GetStatusName',
                type: "POST",
                data: {
                  cstatus: cstatus
                },
                cache: false,
                success: function a(result){
                  $("#current_status_message").html(result);
                }
              });
              $.ajax({
                url:'<?=base_url();?>Menu/GetPartnerTypeName',
                type: "POST",
                data: {
                  partnerType_id: partnerType_id
                },
                cache: false,
                success: function a(result){
                  $("#curremt_partner_type").html(result);
                }
              });
              $.ajax({
                url:'<?=base_url();?>Menu/GetClusterName',
                type: "POST",
                data: {
                  cluster_id: cluster_id
                },
                cache: false,
                success: function a(result){
                  $("#curremt_clustername").html(result);
                }
              });
            }
            });
        
        }else if(result > 0){
            $("#cmpfirsttime").hide();
            $("#cmpmanytime").show();
            $("#review_time").val('Many Time');
            $("#mainformbtn").val('ManyTime');
            $("#mainlogtable").hide();
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
        
        
        $("#mainformbtn").click(function() {
          var rtype = document.getElementById("rtype").value;
          var buttonValue = $(this).val(); 
       
          if (buttonValue === 'FirstTime') {
            $("#cmpmanytime input, #cmpmanytime select, #cmpmanytime textarea").removeAttr('required');
          }else if(buttonValue === 'ManyTime'){
            $("#cmpfirsttime input, #cmpfirsttime select, #cmpfirsttime textarea").removeAttr('required');

          }
          if(rtype == 'Roaster'){
            $("#mainformbtn").val('Roaster');
            $("#cmpfirsttime input, #cmpfirsttime select, #cmpfirsttime textarea").removeAttr('required');
            $("#common_review_slct input, #common_review_slct select, #common_review_slct textarea").removeAttr('required');
            $("#rosterhide input, #rosterhide select, #rosterhide textarea").removeAttr('required');
            $("#cmpmanytime input, #cmpmanytime select, #cmpmanytime textarea").removeAttr('required');
            
          }
        });
        
        var rtype = document.getElementById("rtype").value;
        var rtype_id = document.getElementById("slsct_review_id").value;
        // alert(rtype);
        $('#inid').on('change', function b() {
        var inid = document.getElementById("inid").value;
        var fdate = document.getElementById("fdate").value;
        $.ajax({
        url:'<?=base_url();?>Menu/getcmpnlog',
        type: "POST",
        data: {
        inid: inid,
        fdate: fdate,
        rtype: rtype,
        rtype_id: rtype_id
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
        var rtype = document.getElementById("rtype").value;
        var rtype_id = document.getElementById("slsct_review_id").value;

      if(rtype !=='Roaster'){

        $.ajax({
        url:'<?=base_url();?>Menu/getcmplogs',
        type: "POST",
        data: {
        inid: inid,
        fdate: fdate,
        rtype: rtype,
        rtype_id: rtype_id
        },
        cache: false,
        success: function a(result){
        $("#cmplogs").html(result);
        }
        });
        $.ajax({
        url:'<?=base_url();?>Menu/getcmpnlogAgainstReviewTask',
        type: "POST",
        data: {
        inid: inid,
        fdate: fdate,
        rtype: rtype,
        rtype_id: rtype_id
        },
        cache: false,
        success: function a(result){
          const jsonData = JSON.parse(result);
          // Total Task Data  Start
          const totalTasks = jsonData.totaltask.length;
          let tableContent = "<table id='example2' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
          var counter = 1;
            jsonData.totaltask.forEach(task => {
                tableContent += `<tr>
                  <td>${counter++}</td>
                  <td>${task.actionname}</td>
                  <td>${task.actontaken}</td>
                  <td>${task.purpose_achieved}</td>
                  <td>${task.appointmentdatetime}</td>
                  <td>${task.updated_at}</td>
                  <td>${task.username}</td>
                  <td>${task.lstatusname}</td>
                  <td>${task.cstatusname}</td>
                </tr>`;
              });
              tableContent += "</table>";
              $("#total_Logs").text(totalTasks)
              document.getElementById("totaltaskdata").innerHTML = `${tableContent}`;
              $("#example2").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
              "buttons": ["excel", "pdf"]
              }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
            // Total Task Data  End
            // Call Log Data Start
            const filteredTasks_call = jsonData.totaltask.filter(task => task.actiontype_id === "1");
            const totalTasks_call = filteredTasks_call.length;
            if(totalTasks_call > 0){
          let tableContent_call = "<table id='example3' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
          var counter = 1;
          filteredTasks_call.forEach(task => {
              tableContent_call += `<tr>
                  <td>${counter++}</td>
                  <td>${task.actionname}</td>
                  <td>${task.actontaken}</td>
                  <td>${task.purpose_achieved}</td>
                  <td>${task.appointmentdatetime}</td>
                  <td>${task.updated_at}</td>
                  <td>${task.username}</td>
                  <td>${task.lstatusname}</td>
                  <td>${task.cstatusname}</td>
                </tr>`;
              });
              tableContent_call += "</table>";
              $("#how_many_calls").text(totalTasks_call)
              document.getElementById("task_how_many_calls").innerHTML = `${tableContent_call}`;
              $("#example3").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
              "buttons": ["excel", "pdf"]
              }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
            }else{
              $("#how_many_calls").text(0)
            }
            // Call Log Data Close
          // Email Log Data Start
          const filteredTasks_email = jsonData.totaltask.filter(task => task.actiontype_id === "2");
          const totalTasks_email = filteredTasks_email.length;
          if(totalTasks_email > 0){
          let tableContent_email = "<table id='example4' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
          var counter = 1;
          filteredTasks_email.forEach(task => {
              tableContent_email += `<tr>
                  <td>${counter++}</td>
                  <td>${task.actionname}</td>
                  <td>${task.actontaken}</td>
                  <td>${task.purpose_achieved}</td>
                  <td>${task.appointmentdatetime}</td>
                  <td>${task.updated_at}</td>
                  <td>${task.username}</td>
                  <td>${task.lstatusname}</td>
                  <td>${task.cstatusname}</td>
                </tr>`;
              });
              tableContent_email += "</table>";
              $("#totalTasks_email").text(totalTasks_email)
              document.getElementById("task_how_many_email").innerHTML = `${tableContent_email}`;
              $("#example4").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
              "buttons": ["excel", "pdf"]
              }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
            }else{
              $("#totalTasks_email").text(0)
            }
            // Email Log Data Close
          // scheduled_meetings Log Data Start
          const filteredTasks_sheduled = jsonData.totaltask.filter(task => task.actiontype_id === "3");
          const totalTasks_shemeet = filteredTasks_sheduled.length;
          if(totalTasks_shemeet > 0){
          let tableContent_smeeting = "<table id='example5' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
          var counter = 1;
          filteredTasks_sheduled.forEach(task => {
            tableContent_smeeting += `<tr>
                  <td>${counter++}</td>
                  <td>${task.actionname}</td>
                  <td>${task.actontaken}</td>
                  <td>${task.purpose_achieved}</td>
                  <td>${task.appointmentdatetime}</td>
                  <td>${task.updated_at}</td>
                  <td>${task.username}</td>
                  <td>${task.lstatusname}</td>
                  <td>${task.cstatusname}</td>
                </tr>`;
              });
              tableContent_smeeting += "</table>";
              $("#scheduled_meetings_cnt").text(totalTasks_shemeet)
              document.getElementById("scheduled_meetings_table").innerHTML = `${tableContent_smeeting}`;
              $("#example5").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
              "buttons": ["excel", "pdf"]
              }).buttons().container().appendTo('#example5_wrapper .col-md-6:eq(0)');
            }else{
              $("#scheduled_meetings_cnt").text(0)
            }
            // scheduled_meetings Log Data Close
            // barg_in_meetings Log Data Start
          const filteredTasks_bargmeet = jsonData.totaltask.filter(task => task.actiontype_id === "4");
          const totalTasks_bargmeet = filteredTasks_bargmeet.length;
          if(totalTasks_bargmeet > 0){
          let tableContent_bargmeet = "<table id='example6' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
          var counter = 1;
          filteredTasks_bargmeet.forEach(task => {
            tableContent_bargmeet += `<tr>
                  <td>${counter++}</td>
                  <td>${task.actionname}</td>
                  <td>${task.actontaken}</td>
                  <td>${task.purpose_achieved}</td>
                  <td>${task.appointmentdatetime}</td>
                  <td>${task.updated_at}</td>
                  <td>${task.username}</td>
                  <td>${task.lstatusname}</td>
                  <td>${task.cstatusname}</td>
                </tr>`;
              });
              tableContent_bargmeet += "</table>";
              $("#barg_in_meetings_cnt").text(totalTasks_bargmeet)
              document.getElementById("barg_in_meetings_table").innerHTML = `${tableContent_bargmeet}`;
              $("#example6").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
              "buttons": ["excel", "pdf"]
              }).buttons().container().appendTo('#example6_wrapper .col-md-6:eq(0)');
            }else{
              $("#barg_in_meetings_cnt").text(0)
            }
            // barg_in_meetings Log Data Close
            
            // whatsapp_activity Log Data Start
          const filteredTasks_whatsapp_activity = jsonData.totaltask.filter(task => task.actiontype_id === "5");
          const totalTasks_whatsapp = filteredTasks_whatsapp_activity.length;
          if(totalTasks_whatsapp > 0){
          let tableContent_whatsapp_activity = "<table id='example7' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
          var counter = 1;
          filteredTasks_whatsapp_activity.forEach(task => {
            tableContent_whatsapp_activity += `<tr>
                  <td>${counter++}</td>
                  <td>${task.actionname}</td>
                  <td>${task.actontaken}</td>
                  <td>${task.purpose_achieved}</td>
                  <td>${task.appointmentdatetime}</td>
                  <td>${task.updated_at}</td>
                  <td>${task.username}</td>
                  <td>${task.lstatusname}</td>
                  <td>${task.cstatusname}</td>
                </tr>`;
              });
              tableContent_whatsapp_activity += "</table>";
              $("#whatsapp_activity_cnt").text(totalTasks_whatsapp)
              document.getElementById("whatsapp_activity_table").innerHTML = `${tableContent_whatsapp_activity}`;
              $("#example7").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
              "buttons": ["excel", "pdf"]
              }).buttons().container().appendTo('#example7_wrapper .col-md-6:eq(0)');
            }else{
              $("#whatsapp_activity_cnt").text(0)
            }
            // whatsapp_activity Log Data Close
            // whatsapp_activity Log Data Start
          const filteredTasks_social_networking = jsonData.totaltask.filter(task => task.actiontype_id === "13");
          const totalTasks_social_networking = filteredTasks_social_networking.length;
          if(totalTasks_social_networking > 0){
          let tableContent_social = "<table id='example8' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
          var counter = 1;
          filteredTasks_social_networking.forEach(task => {
            tableContent_social += `<tr>
                  <td>${counter++}</td>
                  <td>${task.actionname}</td>
                  <td>${task.actontaken}</td>
                  <td>${task.purpose_achieved}</td>
                  <td>${task.appointmentdatetime}</td>
                  <td>${task.updated_at}</td>
                  <td>${task.username}</td>
                  <td>${task.lstatusname}</td>
                  <td>${task.cstatusname}</td>
                </tr>`;
              });
              tableContent_social += "</table>";
              $("#social_networking_cnt").text(totalTasks_whatsapp)
              document.getElementById("social_networking_table").innerHTML = `${tableContent_social}`;
              $("#example8").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
              "buttons": ["excel", "pdf"]
              }).buttons().container().appendTo('#example8_wrapper .col-md-6:eq(0)');
            }else{
              $("#social_networking_cnt").text(0)
            }
            // whatsapp_activity Log Data Close
             // mom_done Log Data Start
          const filteredTasks_mom_done = jsonData.totaltask.filter(task => task.actiontype_id === "6");
          const totalTasks_mom_done_cnt = filteredTasks_mom_done.length;
          if(totalTasks_mom_done_cnt > 0){
          let tableContent_mom_done = "<table id='example9' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
          var counter = 1;
          filteredTasks_mom_done.forEach(task => {
            tableContent_mom_done += `<tr>
                  <td>${counter++}</td>
                  <td>${task.actionname}</td>
                  <td>${task.actontaken}</td>
                  <td>${task.purpose_achieved}</td>
                  <td>${task.appointmentdatetime}</td>
                  <td>${task.updated_at}</td>
                  <td>${task.username}</td>
                  <td>${task.lstatusname}</td>
                  <td>${task.cstatusname}</td>
                </tr>`;
              });
              tableContent_mom_done += "</table>";
              $("#mom_done_cnt").text(totalTasks_mom_done_cnt)
              document.getElementById("mom_done_table").innerHTML = `${tableContent_mom_done}`;
              $("#example9").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
              "buttons": ["excel", "pdf"]
              }).buttons().container().appendTo('#example9_wrapper .col-md-6:eq(0)');
            }else{
              $("#mom_done_cnt").text(0)
            }
            // mom_done Log Data Close
          // proposal_done Log Data Start
          const filteredTasks_proposal_done = jsonData.totaltask.filter(task => task.actiontype_id === "7");
          const totalTasks_proposal_done_cnt = filteredTasks_proposal_done.length;
          if(totalTasks_proposal_done_cnt > 0){
          let tableContent_proposal_done = "<table id='example10' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
          var counter = 1;
          filteredTasks_proposal_done.forEach(task => {
            tableContent_proposal_done += `<tr>
                  <td>${counter++}</td>
                  <td>${task.actionname}</td>
                  <td>${task.actontaken}</td>
                  <td>${task.purpose_achieved}</td>
                  <td>${task.appointmentdatetime}</td>
                  <td>${task.updated_at}</td>
                  <td>${task.username}</td>
                  <td>${task.lstatusname}</td>
                  <td>${task.cstatusname}</td>
                </tr>`;
              });
              tableContent_proposal_done += "</table>";
              $("#proposal_done_cnt").text(totalTasks_proposal_done_cnt)
              document.getElementById("proposal_done_table").innerHTML = `${tableContent_proposal_done}`;
              $("#example10").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
              "buttons": ["excel", "pdf"]
              }).buttons().container().appendTo('#example10_wrapper .col-md-6:eq(0)');
            }else{
              $("#proposal_done_cnt").text(0)
            }
            // proposal_done Log Data Close
          // how_many_research Log Data Start
          const filteredTasks_research_done = jsonData.totaltask.filter(task => task.actiontype_id === "10");
          const totalTasks_research_done_cnt = filteredTasks_research_done.length;
          if(totalTasks_research_done_cnt > 0){
          let tableContent_research_done = "<table id='example11' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
          var counter = 1;
          filteredTasks_research_done.forEach(task => {
            tableContent_research_done += `<tr>
                  <td>${counter++}</td>
                  <td>${task.actionname}</td>
                  <td>${task.actontaken}</td>
                  <td>${task.purpose_achieved}</td>
                  <td>${task.appointmentdatetime}</td>
                  <td>${task.updated_at}</td>
                  <td>${task.username}</td>
                  <td>${task.lstatusname}</td>
                  <td>${task.cstatusname}</td>
                </tr>`;
              });
              tableContent_research_done += "</table>";
              $("#how_many_research_cnt").text(totalTasks_research_done_cnt)
              document.getElementById("how_many_research_table").innerHTML = `${tableContent_research_done}`;
              $("#example11").DataTable({
              "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
              "buttons": ["excel", "pdf"]
              }).buttons().container().appendTo('#example11_wrapper .col-md-6:eq(0)');
            }else{
              $("#how_many_research_cnt").text(0)
            }
            // how_many_research Log Data Close
      // task_done_by_cluster_cnt Log Data Start
        $.ajax({
          url:'<?=base_url();?>Menu/getcmpnlogTaskDoneBy',
          type: "POST",
          data: {
          inid: inid,
          fdate: fdate,
          rtype: rtype,
          taskdoneby: 'CLUSTER'
          },
          cache: false,
          success: function a(result){
            const jsonData = JSON.parse(result);
            // Total Task Done BY Cluster Manager Data Start
            const totalTasks_cluster_done = jsonData.totaltask.length;
            if(totalTasks_cluster_done > 0){
            let tableContent_cluster_done = "<table id='example12' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
            var counter = 1;
              jsonData.totaltask.forEach(task => {
                tableContent_cluster_done += `<tr>
                    <td>${counter++}</td>
                    <td>${task.actionname}</td>
                    <td>${task.actontaken}</td>
                    <td>${task.purpose_achieved}</td>
                    <td>${task.appointmentdatetime}</td>
                    <td>${task.updated_at}</td>
                    <td>${task.username}</td>
                    <td>${task.lstatusname}</td>
                    <td>${task.cstatusname}</td>
                  </tr>`;
                });
                tableContent_cluster_done += "</table>";
                $("#task_done_by_cluster_cnt").text(totalTasks_cluster_done)
                document.getElementById("task_done_by_cluster_table").innerHTML = `${tableContent_cluster_done}`;
                $("#example12").DataTable({
                "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
                "buttons": ["excel", "pdf"]
                }).buttons().container().appendTo('#example12_wrapper .col-md-6:eq(0)');
              }else{
                $("#task_done_by_cluster_cnt").text(0)
              }
              // Total Task Done BY Cluster Manager Data End
          }
        }); 
      // task_done_by_cluster_cnt Log Data Close
       // status_change_by_cluster_cnt Log Data Start
       $.ajax({
          url:'<?=base_url();?>Menu/getcmpnlogStatusChnageTaskDoneBy',
          type: "POST",
          data: {
          inid: inid,
          fdate: fdate,
          rtype: rtype,
          taskdoneby: 'CLUSTER',
          rtype_id: rtype_id
          },
          cache: false,
          success: function a(result){
            const jsonData = JSON.parse(result);
            const totalTasks_cluster_status_chnage = jsonData.totaltask.length;
            if(totalTasks_cluster_status_chnage > 0){
            let tableContent_cluster_schnage = "<table id='example14' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
            var counter = 1;
              jsonData.totaltask.forEach(task => {
                tableContent_cluster_schnage += `<tr>
                    <td>${counter++}</td>
                    <td>${task.actionname}</td>
                    <td>${task.actontaken}</td>
                    <td>${task.purpose_achieved}</td>
                    <td>${task.appointmentdatetime}</td>
                    <td>${task.updated_at}</td>
                    <td>${task.username}</td>
                    <td>${task.lstatusname}</td>
                    <td>${task.cstatusname}</td>
                  </tr>`;
                });
                tableContent_cluster_schnage += "</table>";
                $("#status_change_by_cluster_cnt").text(totalTasks_cluster_status_chnage)
                document.getElementById("status_change_by_cluster_table").innerHTML = `${tableContent_cluster_schnage}`;
                $("#example14").DataTable({
                "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
                "buttons": ["excel", "pdf"]
                }).buttons().container().appendTo('#example14_wrapper .col-md-6:eq(0)');
              }else{
                $("#status_change_by_cluster_cnt").text(0)
              }
          }
        }); 
      // status_change_by_cluster_cnt Log Data Close
      // task_done_by_pst Log Data Start
      $.ajax({
          url:'<?=base_url();?>Menu/getcmpnlogTaskDoneBy',
          type: "POST",
          data: {
          inid: inid,
          fdate: fdate,
          rtype: rtype,
          taskdoneby: 'PST',
          rtype_id: rtype_id
          },
          cache: false,
          success: function a(result){
            const jsonData = JSON.parse(result);
            // Total Task Done BY Cluster Manager Data Start
            const totalTasks_cluster_done = jsonData.totaltask.length;
            if(totalTasks_cluster_done > 0){
            let tableContent_cluster_done = "<table id='example13' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
            var counter = 1;
              jsonData.totaltask.forEach(task => {
                tableContent_cluster_done += `<tr>
                    <td>${counter++}</td>
                    <td>${task.actionname}</td>
                    <td>${task.actontaken}</td>
                    <td>${task.purpose_achieved}</td>
                    <td>${task.appointmentdatetime}</td>
                    <td>${task.updated_at}</td>
                    <td>${task.username}</td>
                    <td>${task.lstatusname}</td>
                    <td>${task.cstatusname}</td>
                  </tr>`;
                });
                tableContent_cluster_done += "</table>";
                $("#task_done_by_pst_cnt").text(totalTasks_cluster_done)
                document.getElementById("task_done_by_pst_table").innerHTML = `${tableContent_cluster_done}`;
                $("#example13").DataTable({
                "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
                "buttons": ["excel", "pdf"]
                }).buttons().container().appendTo('#example13_wrapper .col-md-6:eq(0)');
              }else{
                $("#task_done_by_pst_cnt").text(0)
              }
              // Total Task Done BY Cluster Manager Data End
          }
        }); 
      // task_done_by_pst Log Data Close
            
    // status_change_by_pst Log Data Start
    $.ajax({
          url:'<?=base_url();?>Menu/getcmpnlogStatusChnageTaskDoneBy',
          type: "POST",
          data: {
          inid: inid,
          fdate: fdate,
          rtype: rtype,
          taskdoneby: 'PST',
          rtype_id: rtype_id
          },
          cache: false,
          success: function a(result){
            const jsonData = JSON.parse(result);
            const totalTasks_pst_status_chnage = jsonData.totaltask.length;
            if(totalTasks_pst_status_chnage > 0){
            let tableContent_pst_schnage = "<table id='example15' class='table' border='1'><thead class='thead-dark'><tr><th>Sr. No</th><th>Task</th><th>Action Taken</th><th>Purpose Achieved</th><th>Created Date</th><th>Updated Date</th><th>User Name</th><th>Last Status</th><th>Current Status Status</th></tr></thead>";
            var counter = 1;
              jsonData.totaltask.forEach(task => {
                tableContent_pst_schnage += `<tr>
                    <td>${counter++}</td>
                    <td>${task.actionname}</td>
                    <td>${task.actontaken}</td>
                    <td>${task.purpose_achieved}</td>
                    <td>${task.appointmentdatetime}</td>
                    <td>${task.updated_at}</td>
                    <td>${task.username}</td>
                    <td>${task.lstatusname}</td>
                    <td>${task.cstatusname}</td>
                  </tr>`;
                });
                tableContent_pst_schnage += "</table>";
                $("#status_change_by_pst_cnt").text(totalTasks_pst_status_chnage)
                document.getElementById("status_change_by_pst_table").innerHTML = `${tableContent_pst_schnage}`;
                $("#example15").DataTable({
                "responsive": false, "lengthChange": false, "autoWidth": false,'pageLength' : 5,
                "buttons": ["excel", "pdf"]
                }).buttons().container().appendTo('#example15_wrapper .col-md-6:eq(0)');
              }else{
                $("#status_change_by_pst_cnt").text(0)
              }
          }
        }); 
      // status_change_by_pst Log Data Close
        }
        });
      }else{
    
        var slctbduid = $("#slctbduid").val();

        $.ajax({
                url:'<?=base_url();?>Menu/GetReviewBySCDate',
                type: "POST",
                data: {
                review: inid,
                bduid:slctbduid
                },
                cache: false,
                success: function a(result){
                  $("#reviewdate").html(result);
                  var optionCount = $('#reviewdate').find('option').length;
                        optionCount = optionCount-1;
                        $("#reviewdatecnt").text('Total Date :'+ optionCount);
                }
              });

              $('#reviewdate').on('change', function() {
                var reviewdate_id = $(this).val();

                $.ajax({
                url:'<?=base_url();?>Menu/GetReviewByReview',
                type: "POST",
                data: {
                review: reviewdate_id,
                bduid:slctbduid
                },
                cache: false,
                success: function a(result){
                  $("#rosterReviewData").html("");
                  const jsonData = JSON.parse(result);
                    const revcnt = jsonData.totaltask.length;
                    if (revcnt > 0) {
                        jsonData.totaltask.forEach((task, index) => {
                            var tableId = `example${index + 1}`;
                            var taskIndex = index + 1; // Index starting from 1
                            var tableContent_roaster = `<div class='card generatetable p-3'>
                                <table id='${tableId}' class='table' border='1'>
                                    <thead class='thead-dark'>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Company Name</th>
                                            <th>Review Task</th>
                                            <th>Action Taken</th>
                                            <th>Purpose Achieved</th>
                                            <th>Expected Status</th>
                                            <th>Expected Date</th>
                                            <th>Task Date</th>
                                            <th>User Name</th>
                                            <th>Last Status</th>
                                            <th>Current Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>${task.compname}</td>
                                            <td>${task.name}</td>
                                            <td>${task.actontaken}</td>
                                            <td>${task.purpose_achieved}</td>
                                            <td>${task.exp_status}</td>
                                            <td>${task.exdate}</td>
                                            <td>${task.appointmentdatetime}</td>
                                            <td>${task.username}</td>
                                            <td>${task.lstatusname}</td>
                                            <td>${task.cstatusname}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br/>`;

                            // Add the HTML block below each table with unique names
                            var additionalHtml = `
                                <div class="row">
                                    <div class="col-6 col-md-6 mb-12 card p-2">
                                  
                                        <label for="validationSample04">Is the Task Action Complete?</label>
                                        <input type="hidden" readonly="" value="${task.id}" class="form-control" name="roster_task_action_${taskIndex}[]"> 
                                        <input type="hidden" readonly="" value="Is the Task Action Complete?" class="form-control" name="roster_task_action_${taskIndex}[]"> 
                                        <div class="form-group">
                                            <textarea class="form-control" name="roster_task_action_${taskIndex}[]" placeholder="Review Remark..." required=""></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 mb-12 card p-2">
                                          <label for="validationSample04">Is the Expected Status Achieved Or Not? </label>
                                           <input type="hidden" readonly="" value="${task.id}" class="form-control" name="roster_task_status_${taskIndex}[]">
                                          <input type="hidden" readonly="" value="Is the Expected Status Achieved Or Not?" class="form-control" name="roster_task_status_${taskIndex}[]">
                                          <div class="form-group">
                                              <textarea class="form-control" name="roster_task_status_${taskIndex}[]" placeholder="Review Remark..." required=""></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <br/></div>`; // Add a line break after each block

                              // Append the table and additional HTML to the div with id 'rosterReviewData'
                              $("#rosterReviewData").append(tableContent_roaster + additionalHtml);

                              // Initialize DataTables for each table
                              $(`#${tableId}`).DataTable({
                                  "responsive": false, 
                                  "lengthChange": false, 
                                  "autoWidth": false, 
                                  'pageLength': 5,
                                  "paging": false, // Disable pagination
                                  "searching": false, // Disable searching
                                  "buttons": ["excel", "pdf"]
                              }).buttons().container().appendTo(`#${tableId}_wrapper .col-md-6:eq(0)`);
                          });
                      }
                }
            });
               
              });
      }
        });
        
        $('#ntaction').on('change', function f() {

        var rtype = document.getElementById("rtype").value;
        if(rtype=='Roaster'){
          var main_review_id = $("#inid").val();
          $.ajax({
                url:'<?=base_url();?>Menu/GetCureentStatusByRevID',
                type: "POST",
                data: {
                mid: main_review_id,
                },
                cache: false,
                success: function a(result){
                var sid = result;
            
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
                }
            });
          }else{
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
          }
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