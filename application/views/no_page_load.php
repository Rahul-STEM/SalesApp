<?php 
    include('header.php'); 
    ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid" style="width:70%;align:centre;">
          <?php if ($this->session->flashdata('warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?php echo $this->session->flashdata('warning'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?></div> 
<div><a href="<?php echo base_url();?>Menu/dashboard">Click here to go to Home Page</a>
</div>
</div></div>

    <?php
    include('footer.php'); 

?>