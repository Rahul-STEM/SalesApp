<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="wi$dth=device-wi$dth, initial-scale=1">
    <title>STEM APP |Edit MOM | WebAPP</title>
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
    background: blanchedalmond;
}
.form-control {
    background: azure !important;
}
    </style>
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php require('nav.php');?>
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <?php 
                
                // dd($momdata);
                ?>
                <div class="card mt-2">
                  <div class="card-header bg-info">
                    <h3 class="text-center">MINUTES OF MEETING (Edit MoM)</h3>
                  </div>     
                  <div class="card-body">
                    <div class="container body-content">
                      <div class="page-header">
                        <div class="form-group">
                          <fieldset>
                            <?php foreach($momdata as $mdata): ?>
                                <?php 
                                    unset($mdata->cm_call_task);
                                    unset($mdata->bd_request_task);
                                    unset($mdata->school_visit_task);
                                    unset($mdata->pst_assign);
                                    unset($mdata->cdate);
                                    unset($mdata->approved_status);
                                    unset($mdata->approved_by);
                                    unset($mdata->approved_date);
                                    unset($mdata->reject_remarks);
                                    unset($mdata->edit_cnt);
                                    // echo "<pre>";
                                    // print_r($mdata);
                                   
                                    ?>
                                 

                                <form method="post" action="<?=base_url();?>/Management/UpdateEditMomData">
                                    
                                <?php 
                                 foreach ($mdata as $key => $value):
                                
                                if($key == 'id'){ ?>
                                     <input type="hidden" class="form-control" value="<?= $value ?>" id="id" name="id">
                                     <input type="hidden" class="form-control" value="<?= $tardate ?>" name="tardate">
                                <?php } ?>
                                <?php if($key == 'ccstatus'){ ?>
                                     <input type="hidden" class="form-control" value="<?= $value ?>" id="ccstatus" name="ccstatus">
                                <?php } ?>
                                <?php if($key == 'tid'){ ?>
                                     <input type="hidden" class="form-control" value="<?= $value ?>" id="ccstatus" name="tid">
                                <?php } ?>
                                <?php if($key == 'action_id'){ ?>
                                     <input type="hidden" class="form-control" value="<?= $value ?>" id="action_id" name="action_id">
                                <?php } ?>
                                <?php if($key == 'user_id'){ ?>
                                     <input type="hidden" class="form-control" value="<?= $value ?>" id="user_id" name="user_id">
                                <?php } ?>
                                <?php if($key == 'init_cmpid'){ ?>
                                     <input type="hidden" class="form-control" value="<?= $value ?>" id="init_cmpid" name="init_cmpid">
                                <?php } ?>
                                <?php if($key == 'actontaken'){ ?>
                                     <input type="hidden" class="form-control" value="<?= $value ?>" id="actontaken" name="actontaken">
                                <?php } ?>


                                <?php if($key == 'meetingdonewinitiator'){ ?>
                                    <label for="meetingdonewinitiator">Meeting done with Initiator or infulencer or discision maker of the company</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="meetingdonewinitiator" name="meetingdonewinitiator">
                                     <hr>
                                <?php } ?>
                                
                                <?php if($key == 'presentation'){ ?>
                                    <label for="presentation">Presentation and pitching is done for which offering :</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="presentation" name="presentation">
                                     <hr>
                                <?php } ?>

                                <?php if($key == 'project_intervention_select'){ ?>
                                    <label for="project_intervention_select">What is the client's thematic Area for Project Intervention in the current financial Year</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="project_intervention_select" name="project_intervention_select">
                                     <hr>
                                <?php } ?>

                                <?php if($key == 'project_intervention'){ ?>
                                    <label for="project_intervention">What is the client's Other thematic Area for Project Intervention in the current financial Year</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="project_intervention" name="project_intervention">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'client_has_adopted_select'){ ?>
                                    <label for="client_has_adopted_select">Does the client has adopted any schools ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="client_has_adopted_select" name="client_has_adopted_select">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'client_has_adopted'){ ?>
                                    <label for="client_has_adopted">Specify details of client has adopted any schools</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="client_has_adopted" name="client_has_adopted">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'approving_autorities'){ ?>
                                    <label for="approving_autorities">Who are the approving autorities of the proposal ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="approving_autorities" name="approving_autorities">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'budget_for_cfyear'){ ?>
                                    <label for="budget_for_cfyear">What is the left over budget for the current financial year ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="budget_for_cfyear" name="budget_for_cfyear">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'fund_sanstion_limit'){ ?>
                                    <label for="fund_sanstion_limit">what is the fund sanstion limit at their level ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="fund_sanstion_limit" name="fund_sanstion_limit">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'other_specific_remarks'){ ?>
                                    <label for="other_specific_remarks">Any other specific remarks regards to the meeting ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="other_specific_remarks" name="other_specific_remarks">
                                     <hr>
                                <?php } ?>

                                <?php if($key == 'submit_proposal'){ ?>
                                    <label for="submit_proposal">Do we need to submit the proposal ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="submit_proposal" name="submit_proposal">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'proposal_no_of_school'){ ?>
                                    <label for="proposal_no_of_school">Number of school for Proposal</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="proposal_no_of_school" name="proposal_no_of_school">
                                     <hr>
                                <?php } ?>

                                <?php if($key == 'proposal_of_budget'){ ?>
                                    <label for="proposal_of_budget">Budget of Proposal</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="proposal_of_budget" name="proposal_of_budget">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'identify_school'){ ?>
                                    <label for="identify_school">Do we need to identify school ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="identify_school" name="identify_school">
                                     <hr>
                                <?php } ?>

                                <?php if($key == 'identify_school_state'){ ?>
                                    <label for="identify_school_state">Name of State to identify school</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="identify_school_state" name="identify_school_state">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'identify_school_district'){ ?>
                                    <label for="identify_school_district">Name of District to identify school</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="identify_school_district" name="identify_school_district">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'no_of_school'){ ?>
                                    <label for="no_of_school">Number of identify school</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="no_of_school" name="no_of_school">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'permission_letter'){ ?>
                                    <label for="permission_letter">School permission letter required ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="permission_letter" name="permission_letter">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'permission_letter_rech'){ ?>
                                    <label for="permission_letter_rech">Letter should be address to whom in the organization, along with Name and designation and Location</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="permission_letter_rech" name="permission_letter_rech">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'Letter_organization_name'){ ?>
                                    <label for="Letter_organization_name">Letter Organization Name</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="Letter_organization_name" name="Letter_organization_name">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'Letter_organization_designation'){ ?>
                                    <label for="Letter_organization_designation">Organization Designation Name</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="Letter_organization_designation" name="Letter_organization_designation">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'Letter_organization_location'){ ?>
                                    <label for="Letter_organization_location">Organization Location Name</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="Letter_organization_location" name="Letter_organization_location">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'client_int_school_visit'){ ?>
                                    <label for="client_int_school_visit">Client is interested for School Visit ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="client_int_school_visit" name="client_int_school_visit">
                                <?php } ?>
                                <?php if($key == 'client_int_school_date'){ ?>
                                    <label for="client_int_school_date">Date for Client is interested for School Visit ?</label>
                                     <input type="date" class="form-control" value="<?= $value ?>" id="client_int_school_date" name="client_int_school_date">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'client_int_school_state'){ ?>
                                    <label for="client_int_school_state">State for Client is interested for School Visit ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="client_int_school_state" name="client_int_school_state">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'client_int_school_district'){ ?>
                                    <label for="client_int_school_district">District for Client is interested for School Visit ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="client_int_school_district" name="client_int_school_district">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'client_int_no_of_school'){ ?>
                                    <label for="client_int_no_of_school">Number of School for Client is interested for School Visit ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="client_int_no_of_school" name="client_int_no_of_school">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'intervention_cm_pst_sh'){ ?>
                                    <label for="intervention_cm_pst_sh">Do you need intervention from Cluster/PST/ Sales Head ?</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="intervention_cm_pst_sh" name="intervention_cm_pst_sh">
                                     <hr>
                                <?php } ?>
                                <?php if($key == 'rpmmom'){ ?>
                                    <label for="rpmmom">Short MOM Remarks</label>
                                     <input type="text" class="form-control" value="<?= $value ?>" id="rpmmom" name="rpmmom">
                                     <hr>
                                <?php } ?>
                                    


                                     <?php endforeach; ?>
                                     <hr>
                                     <button type="submit" class="btn btn-primary">Submit</button>
                                </form>












                           
                            <?php endforeach; ?>
                          </fieldset>
                        </div>
                        <hr />
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
    </section>
    </div>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type='text/javascript'></script>
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
        "buttons": ["csv", "excel", "pdf", "print",]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    </script>
  </body>
</html>