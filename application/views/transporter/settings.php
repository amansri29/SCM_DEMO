  <?php
	 include "includes/header.php";
	 ?>

  <body>

  <section id="container" class="">
      <!--header start-->
     
      <!--header end-->
      <!--sidebar start-->
        <?php
	 include "includes/transporter_sidebar.php";
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
           <section class="wrapper">
              <!-- page start-->
				<div class="row">
					<div class="col-lg-12">
						<h3>Transporter Settings</h3>
					</div>
					<div class="col-lg-12">
					<div id="mess1" style="display:none" class="success"><?php echo "Driver successfully deleted" ?></div>
					<?php

if(($this->session->flashdata('item'))) {

  $message = $this->session->flashdata('item');

  ?>
              <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
              <?php

}else{

}
		$this->db->select('*');
		$this->db->from('dbo.settings');
		$query = $this->db->get();
		 $row = $query->row();
		
?>
                      <section class="panel">
                          <header class="panel-heading">
                             Change Password
                          </header>
						   <div class="panel-body">
						   <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/transporter/change_password">
								<input type='hidden' name='id' value='<?php echo $row->id; ?>'>
								<div class="col-lg-12">
									<div class="form-group">
                                      <label for="name" class="col-lg-2 col-sm-2 control-label">Old Password</label>
                                      
									  <div class="col-lg-3">
                                          <input type="password" class="form-control" id="" name='old_pass' placeholder="Enter Old Password">
                                      </div>
									  </div>
									  </div>
									  <div class="col-lg-12">
									<div class="form-group">
									  <label for="name" class="col-lg-2 col-sm-2 control-label">New Password</label>
									  <div class="col-lg-3">
                                          <input type="password" class="form-control" id="" name='new_password'  placeholder="Enter New Password">
                                      </div>
									  </div></div>
									  <div class="col-lg-12">
									<div class="form-group">
									  <label for="name" class="col-lg-2 col-sm-2 control-label">Confirm Password</label>
									    <div class="col-lg-3">
                                          <input type="password" class="form-control" id="" name='confirm_password'  placeholder="Enter Confirm Password">
                                      </div>
									</div>
									</div>
									<div class="col-lg-12">
								<br/>
								<div class="form-group">
								  <div class=" col-lg-2">
									  <button type="submit" class="btn btn-danger btn-block">Update Password</button>
								  </div>
								</div>
								</div>
								</div>
								
							  </form>
							
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

