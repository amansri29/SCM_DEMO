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
						<h3>Edit Scanner User</h3>
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
	$this->db->from('dbo.scanner_login');
	$this->db->where('id', $id );
	$query = $this->db->get();
	$row = $query->row();
								
?>
                      <section class="panel">
                          <header class="panel-heading">
                              Scanner Information
                          </header>
						   <div class="panel-body">
                               <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/update_scanner_user">
								<div class="col-lg-6">
									<input type="hidden" value="<?php echo $id?>" name="id">
									<div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Name</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo $row->name?>"  required id="name" name="name" placeholder="Enter Name">
                                      </div>
									</div>
									<div class="form-group">
									
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">User Type</label>
                                      <div class="col-lg-8">
                                        <select class="js-example-basic-single vehicle" id='transporter' multiple required name='user_type[]'>
											<option disabled >Select User Type</option>
											
												 <?php 
												// $type=array();
												 $type=explode(',',$row->user_type);
												 print_r($type);
												 ?>
												   <option <?=(in_array('Gate User',$type))?'selected':''?> value="Gate User">Gate User</option>
												   <option <?=(in_array('Loading User',$type))?'selected':''?> value="Loading User">Loading User</option>
												   <option <?=(in_array('Weighbridge User',$type))?'selected':''?> value="Weighbridge User">Weighbridge User</option>
													<!--<option value="Gate User" <?php echo (($type=='Gate User')?"selected":"") ?>>Gate User</option>
													<option value="Weighbridge User" <?php echo (($type=='Weighbridge User')?"selected":"") ?>>Weighbridge User</option>
													<option value="Loading User" <?php echo (($row=='Loading User')?"selected":"") ?>>Loading User</option>-->
										
																									
										</select>
                                      </div>
									</div>
								
									
								</div>
								<div class="col-lg-6">
									
									<div class="form-group">
                                      <label for="email" class="col-lg-3 col-sm-2 control-label">Email</label>
                                      <div class="col-lg-8">
                                          <input type="email" class="form-control" value='<?php echo $row->email ?>' required id="email" name="email" placeholder="Enter Email">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="mobile" class="col-lg-3 col-sm-2 control-label">Mobile Number</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" required id="mobile" value='<?php echo  $row->mobile ?>' name="mobile" placeholder="Enter Number">
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

