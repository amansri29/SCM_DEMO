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
						<h3>Add Driver</h3>
					</div>
					<div class="col-lg-12">
	<?php

if(($this->session->flashdata('item'))) {

  $message = $this->session->flashdata('item');

  ?>
              <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
              <?php

}else{

}
	$id = $_GET['id'];
	/* print($id); */
	$this->db->select('*');
	$this->db->from('dbo.driver');
	$this->db->where('id', $id );
	$query = $this->db->get();
	$row = $query->row();
	/* print_r($row); */
?>
                      <section class="panel">
                          <header class="panel-heading">
                              Driver Information
                          </header>
						   <div class="panel-body">
                             <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/update_driver">
								<div class="col-lg-6">
								<input type="hidden" value="<?php echo $id?>" name="id">
									<div class="form-group">
									
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Transporter</label>
                                      <div class="col-lg-8">
                                         <select class="js-example-basic-single vehicle" id='transporter' required name='transporter_id'>
											<option value="0">Select Transporter</option>
											<?php
												$this->db->select('*');
												$this->db->from('dbo.transporter');
												$query = $this->db->get();
												$rows = $query->result_array();
											
												foreach( $rows as $value ) {
													if($row->transporter_id == $value['user_id'])
													{
											?>
												
													<option value="<?php echo $value['user_id']?>" selected ><?php echo $value['name']?></option>
											<?php
													}
													else
													{
												?>
													<option value="<?php echo $value['user_id']?>" ><?php echo $value['name']?></option>
												<?php
													}
												}
											?>																
										</select>
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Driver Name</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="name" value="<?php echo $row->name?>" required id="name" placeholder="Enter Name">
                                      </div>
									</div>
									
									<div class="form-group">
                                      <label for="mobile" class="col-lg-3 col-sm-2 control-label">Phone Number</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $row->mobile?>" required placeholder="Enter Number">
                                      </div>
									</div>
									
								</div>
								<div class="col-lg-6">
									<div class="form-group">
                                      <label for="license_no" class="col-lg-3 col-sm-2 control-label">License No.</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="license_no" name="license_no" value="<?php echo $row->license_no?>" required placeholder="Enter License No.">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="city" class="col-lg-3 col-sm-2 control-label">Valid Upto</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control form-control-inline input-medium default-date-picker" value="<?php echo $row->valid_upto?>" name="valid_upto" required id="date" placeholder="Enter Date">
                                      </div>
									</div>
									
								</div>
								<div class="form-group">
								  <div class="col-lg-offset-5 col-lg-2">
									  <button type="submit" class="btn btn-danger btn-block">Save</button>
								  </div>
								</div>
							  </form>
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

