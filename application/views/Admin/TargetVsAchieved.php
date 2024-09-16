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
                    // dd($mdata);
                     ?>
                    <div class="table-responsive">
                      <div class="table-responsive">
                        <div class="pdf-viwer">
                        <div><div>Start Date</div><div>End Date</div></div>
                          <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <input type="hidden" name="hidden_mdata" value="<?php print_r($targetVsAchieved);?>"/>
                              
                            <thead>
                                <tr>
                                    <th>BD</th>
                                    <th colspan=2>Prospective</th>
                                    <th colspan=2>Proposal</th>
                                    <th colspan=2>Revenue</th>
                                    <th colspan=2>Closure</th>
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
                              </tr>
                            </thead>
                                <tbody>
                                    <?php
                                    // echo "<pre>"; print_r($targetVsAchieved);exit;
                                    foreach($targetVsAchieved as $key=>$val){
                                       ?>
                                          <tr>
                                             <!-- <td><?php //echo getUserNameById($key['targetUserId']); ?></td> -->
                                               <td><?php echo $val['targetUserId']; ?></td>
                                              <td><?php echo $val['prospective']; ?></td>
                                              <td><?php echo $val['prospective_achieved']; ?></td>
                                              <td><?php echo $val['proposal']; ?></td>
                                              <td><?php echo $val['proposal_achieved']; ?></td>
                                              <td><?php echo $val['revenue']; ?></td>
                                              <td><?php echo $val['revenue_achieved'];?></td>
                                              <td><?php echo $val['closure']; ?></td>
                                              <td><?php echo $val['closure_achieved']; ?></td>
                                          </tr>
                                       <?php 
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