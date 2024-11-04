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
                            <h5><?php echo $username; ?>'s Proposal Achieved Data Between <?php echo $sdate;?> And <?php echo $edate;?></h5>
                            <hr>
                          <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th>S.No.</th>
                                <th>CIN</th>
                                <th>Company Name</th>
                                <th>Proposal</th>
                              
                                <th>No.Of.School</th>
                                <th>Created Date</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $i=1;
                            // dd($proposal_achieved);exit;
                              foreach($proposal_achieved as $dt){
                              ?>
                              <tr>
                                <td><?=$i?></td>
                                <td><?=$dt->cmpid_id;?></td>
                                <td><a target="_blank" href="<?=base_url();?>Menu/CompanyDetails/<?=$dt->cmpid_id?>"><?php echo $this->Menu_model->getCompanyNameByCmpid($dt->cmpid_id);?></a></td>
                                <td><a href="<?=base_url();?><?=$dt->proattach?>"><?=$dt->proattach;?></a></td>
                                <td><?=$dt->noofsc;?></td>
                                <td><?=date(('d-m-Y'),strtotime($dt->sdatet))?></td>
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