  <?php
	 include "includes/header.php";
	 ?>

  <body>

  <section id="container" class="">
      <!--header start-->
     
      <!--header end-->
      <!--sidebar start-->
        <?php
	 include "includes/admin_sidebar.php";
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
<section class="wrapper">
              <!-- page start-->
				<div class="row">
                          <div class="col-lg-12">
                              <section class="panel">
                                  <header class="panel-heading">
                                     Transporters
                                  </header>
                                  <div class="panel-body"> 
                                      <div class="form">
                                          <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_help_details">
                                              <div class="form-group">
                                                  <label class="col-sm-2 control-label col-sm-2">Help Details</label>
                                                  <div class="col-sm-10">
                                                      <textarea class="form-control ckeditor" name="details" rows="10"><?php echo $trans ?></textarea>
                                                       <input type='hidden' name='type' value='transporter'>
                                                  </div>
                                              </div>
                                              <div class="form-group">
								  <div class="col-lg-offset-5 col-lg-2">
									  <button type="submit" id='abc' class="btn btn-danger btn-block">Update</button>
								  </div>
								</div>
                                          </form>
                                      </div>
                                  </div>
                              </form>
                              </section>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-lg-12">
                              <section class="panel">
                                  <header class="panel-heading">
                                      Customers
                                  </header>
                                  <div class="panel-body">
                                      <div class="form">
                                         <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_help_details">
                                              <div class="form-group">
                                                  <label class="col-sm-2 control-label col-sm-2">Help Details</label>
                                                  <div class="col-sm-10">
                                                      <textarea class="form-control ckeditor" name="details" rows="10"><?php echo $cust ?></textarea>
                                                      <input type='hidden' name='type' value='customer'>
                                                  </div>
                                              </div>
                                              <div class="form-group">
								  <div class="col-lg-offset-5 col-lg-2">
									  <button type="submit" id='abc' class="btn btn-danger btn-block">Update</button>
								  </div>
								</div>
                                          </form>
                                      </div>
                                  </div>
                              </section>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-lg-12">
                              <section class="panel">
                                  <header class="panel-heading">
                                      Drivers
                                  </header>
                                  <div class="panel-body">
                                      <div class="form">
                                          <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_help_details">
                                              <div class="form-group">
                                                  <label class="col-sm-2 control-label col-sm-2">Help Details</label>
                                                  <div class="col-sm-10">
                                                      <textarea class="form-control ckeditor" name="details" rows="10"><?php echo $driver ?></textarea>
                                                       <input type='hidden' name='type' value='driver'>
                                                  </div>
                                              </div>
                                              <div class="form-group">
								  <div class="col-lg-offset-5 col-lg-2">
									  <button type="submit" id='abc' class="btn btn-danger btn-block">Update</button>
								  </div>
								</div>
                                          </form>
                                      </div>
                                  </div>
                              </section>
                          </div>
                      </div>
                 
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
       <?php

	 include "includes/footer.php";
	 ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
	

  </body>
</html>

