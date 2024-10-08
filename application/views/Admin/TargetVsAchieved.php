<?php include('header.php'); ?>
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
              <div class="container-fluid body-content">
                <div class="page-header">
                  <fieldset>
                    <?php 
                  // dd($sdate);
                     ?>
                    <div class="table-responsive">
                      <div class="table-responsive">
                        <div class="pdf-viwer">
                        <div class="container">
                          <form name="targetVsachivementform" method="post" action="targetVsAchievedData">
                            <div class="row g-2 align-items-center">
                              <div class="col-sm-3">
                                <input type="date" class="form-control" name="sdate" value="<?php echo isset($sdate) ? $sdate : ''; ?> " required id="sdate" min="">
                              </div>
                              <div class="col-sm-3">
                                <input type="date" class="form-control" name="edate" value="<?php echo isset($edate) ? $edate : ''; ?>" required id="edate" min="">
                              </div>
                              <div class="col-sm-3">
                                <input type="submit" value="Show Report" class="btn btn-primary w-100">
                              </div>
                            </div>
                          </form>
                        </div>
                          <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <input type="hidden" name="hidden_mdata" value="<?php print_r($targetVsAchieved);?>"/>
                            <thead>
                                <tr>
                                    <th>BD</th>
                                    <th colspan=2>Prospecting Schools</th>
                                    <th colspan=2>Proposal Count</th>
                                    <th colspan=2>Proposal Revenue</th>
                                    <th colspan=2>Closure Clients</th>
                                    <th colspan=2>Closure Schools</th>
                                    <th colspan=2>Closure Revenue</th>
                                </tr>
                              <tr>
                                <th></th>
                                <th>Target</th>
                                <th>Achieved</th>
                                <th>Target</th>
                                <th>Achieved</th> 
                                <th>Target</th>
                                <th>Achieved</th>
                                <th>Target</th>
                                <th>Achieved</th>
                                 <th>Target</th>
                                <th>Achieved</th>
                              </tr>
                            </thead>
                                <tbody>
                                    <?php
                                    foreach($targetVsAchieved as $key=>$val){
                                      if($val['target']){

                                      
                                       ?>
                                          <tr>
                                             <!-- <td><?php //echo getUserNameById($key['targetUserId']); ?></td> -->
                                               <td><?php echo getUserNameById($val['targetUserId']); ?></td>
                                              <td><?php echo $val['prospecting_target']; ?></td>
                                              <td><?php echo $val['prospective_achieved']; ?></td>
                                              <td><?php echo $val['proposal_target']; ?></td>
                                              <td><?php echo $val['proposal_achieved']; ?></td>
                                              <td><?php echo $val['proposal_revenue']; ?></td>
                                              <td><?php echo $val['proposal_revenue_achieved'];?></td>
                                              <td><?php echo $val['closure_client_target']; ?></td>
                                              <td><?php echo $val['closure_clients_achieved']; ?></td>
                                              <td><?php echo $val['closure_revenue_target']; ?></td>
                                              <td><?php echo $val['closure_schools_achieved']; ?></td>
                                              <td><?php echo $val['closure_revenue']; ?></td>
                                              <td><?php echo $val['closure_evenue_achieved']; ?></td>
                                          </tr>
                                       <?php }
                                    }?>
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
      
      <?php include('footer.php') ;?>