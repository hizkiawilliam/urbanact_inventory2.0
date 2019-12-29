<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>var $j = jQuery.noConflict(true);</script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Add New Marketplace</h1>
    <ol class="breadcrumb">
      <li><a href="/advance_inventory/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Marketplaces</li>
    </ol>
  </section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

      <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <div class="box">
            <!-- /.box-header -->
            <form role="form" action="<?php base_url('users/create') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="marketplace_name">Marketplace name</label>
                  <input type="text" class="form-control" id="marketplace_name" name="marketplace_name" placeholder="Enter marketplace name" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="link">URL Address of Marketplace</label>
                    <input type="text" class="form-control" id="link" name="link" placeholder="Enter URL address" value="<?php echo set_value('link'); ?>" autocomplete="off">
                </div>             
                <div class="form-group">
                    <label for="active">Status</label>
                    <select class="form-control" id="active" name="active">
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('Controller_Marketplace/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
         <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->