<?php include('header.php');?>
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
                          <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th>S.No.</th>
                                <th>BD Name</th>
                                <th>CIN</th>
                                <th>Company Name</th>
                                <th>Photo</th>
                                <th>Started At</th>
                                <th>Close AT</th>
                                <th>Start Location</th>
                                <th>Close Location</th>
                                <th>RP Yes/No</th>
                                <th>Potential Yes/No</th>
                                <th>Priority Yes/No</th>
                                <th>MOM Yes/No</th>
                                <th>Thanks Mail Yes/No</th>
                                <th>PST Assign Yes/No</th>
                                <th>Review</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i=1;
                              foreach($achivedDataListByCategory as $dt){
                              ?>
                              <tr>
                                <td><?=$i?></td>
                                <td><?=$dt->name?></td>
                                <td><?=$dt->cmpid;?></td>
                                <td><a href="<?=base_url();?>/Menu/CompanyDetails/<?=$cmpid?>"><?=$dt->company_name?></a></td>
                                <td>
                                    <img src="<?=base_url();?><?=$dt->cphoto?>" alt="image not found" width="200">
                                    <?php 
                                    $photourl = $dt->cphoto;
                                   
                                    if($photourl !=='uploads/day/'){ ?>
                                        <a href="<?=base_url();?><?=$dt->cphoto?>"?>Download</a>
                                    <?php } ?>
                                   
                                </td>
                                <td><?=$time1=$dt->startm?></td>
                                <td><?=$time2=$dt->closem?></td>
                                <td><a href="https://www.google.com/maps?q=<?=$dt->slatitude?>,<?=$dt->slongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a></td>
                                <td><a href="https://www.google.com/maps?q=<?=$dt->clatitude?>,<?=$dt->clongitude?>"><i class="fas fa-map-marker-alt" style="font-size:36px" aria-hidden="true"></i></a></td>
                                <td><?=$dt->mtype?></td>
                                <td><?=$dt->potential?></td>
                                <td><?=$dt->priority?></td>
                                <td><?=$momc?></td>
                                <td><?=$emailc?></td>
                                <td><?=$psta?></td>
                                <td><?=$dt->queans?><hr><?=$dt->mcomment?></td>
                                <?php $i++;
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