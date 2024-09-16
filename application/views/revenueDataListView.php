<?php include('header.php');?>

  <!-- /.content-header -->
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
                            <h4><?php echo $username; ?>'s Proposal Achieved Data Between <?php echo $sdate;?> And <?php echo $edate;?>
                            </h4>
                          <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th>S.No.</th>
                                <th>CIN</th>
                                <th>Company Name</th>
                                <th>No. Of Schools</th>
                                <th>Key Company</th>
                                <th>Potential</th>
                                <th>Created Date</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $i=1;
                            dd($proposal_achieved);exit;
                              foreach($proposal_achieved as $dt){
                                // echo $dt->cmpid_id;exit;
                                // $username = $this->Menu_model->getAchievedDataList($dt->mainbd);
                              ?>
                              <tr>
                                <td><?=$i?></td>
                                <td><?=$dt->cmpid_id;?></td>
                                <td><a target="_blank" href="<?=base_url();?>Menu/CompanyDetails/<?=$dt->cmpid_id?>"><?php echo $this->Menu_model->getCompanyNameByCmpid($dt->cmpid_id);?></a></td>
                                <td><?=$dt->noofschools;?></td>
                                <td><?=$dt->keycompany;?></td>
                                <td><?=$dt->potential;?></td>
                                <td><?=date(('d-m-Y'),strtotime($dt->createDate))?></td>
                                <?php $i++;
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