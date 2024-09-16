<?php include('header.php'); ?>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
            </div>
            <form class="p-3" method="POST" action="<?=base_url();?>/Menu/targetVsAchievedData/<?=$uid?>">
          <input type="date" name="sdate" class="mr-2" value="<?=$sd?>">
          <input type="date" name="edate" class="mr-2" value="<?=$ed?>">
          <select name="userName">
                <option value=""></option>   
          </select>
          <button type="submit" class="bg-primary text-light">Filter</button>
          </form>
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
                          <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                                    foreach($targetVsAchieved as $key=>$val){
                                        if(!empty($val['prospective_target'])){
                                        $userName = $this->Menu_model->getUserNameById($val['targetUserId']);
                                       ?>
                                          <tr>
                                             <td><?php echo $userName; ?></td> 
                                              <td><?php echo isset($val['prospective_target'])?$val['prospective_target']:"0"; ?></td>
                                              <?php if(isset($val['prospective_achieved'])) { ?>
                                              <td><a target="_blank" href="<?=base_url();?>/Menu/getAchievedDataList/<?=$val['targetUserId'] ?>/prospective_achieved/<?=$sdate?>/<?=$edate?>"><?php echo $val['prospective_achieved']; ?> </a></td>
                                              <?php } 
                                              else{ ?>
                                                      <td>0</td>
                                              <?php }?>
                                              <td><?php echo $val['proposal_target']; ?></td>
                                              <?php if(isset($val['proposal_achieved'])) { ?>
                                                <td><a target="_blank" href="<?=base_url();?>/Menu/getAchievedDataList/<?=$val['targetUserId'] ?>/proposal_achieved/<?=$sdate?>/<?=$edate?>"><?php echo $val['proposal_achieved']; ?></a></td>
                                                <?php } 
                                              else{ ?>
                                                      <td>0</td>
                                              <?php }?>
                                              <td><?php echo $val['revenue_target']; ?></td>
                                              <?php if(isset($val['revenue_achieved'])) { ?>
                                                <td><a target="_blank" href="<?=base_url();?>/Menu/getAchievedDataList/<?=$val['targetUserId'] ?>/revenue_achieved/<?=$sdate?>/<?=$edate?>"><?php echo $val['revenue_achieved'];?></a></td>
                                                <?php } 
                                              else{ ?>
                                                      <td>0</td>
                                              <?php }?>
                                              <td><?php echo $val['closure_target']; ?></td>
                                              <?php if(isset($val['closure_achieved'])) { ?>
                                                <td><a target="_blank" href="<?=base_url();?>/Menu/getAchievedDataList/<?=$val['targetUserId'] ?>/closure_achieved/<?=$sdate?>/<?=$edate?>"><?php echo $val['closure_achieved']; ?></a></td>
                                                <?php } 
                                              else{ ?>
                                                        <td>0</td>
                                              <?php }?>
                                          </tr>
                                       <?php } 
                                      } ?>
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