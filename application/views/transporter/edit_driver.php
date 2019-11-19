 <?php
	 include "includes/header.php";
	 ?>
  <body>

  <section id="container" class="">
    
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
	/* print($id); die; */
	$this->db->select('*');
	$this->db->from('dbo.driver');
	$this->db->where('id', $id );
	$query = $this->db->get();
	$row = $query->row();

?>
                      <section class="panel">
                          <header class="panel-heading">
                              Driver Information
                          </header>
						  <div class="panel-body">
                             <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/transporter/update_driver">
							 <input type="hidden" value="<?php echo $id;?>" name="id">
								<div class="col-lg-6">
									<div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Driver Name</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name='name' value="<?php echo $row->name;?>" required id="name" placeholder="Enter Name">
                                      </div>
									</div>
									
									<div class="form-group">
                                      <label for="mobile" class="col-lg-3 col-sm-2 control-label">Phone Number</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="mobile" value="<?php echo $row->mobile;?>" required name='mobile' placeholder="Enter Number">
                                      </div>
									</div>
									
								</div>
								<div class="col-lg-6">
									<div class="form-group">
                                      <label for="license_no" class="col-lg-3 col-sm-2 control-label">License No.</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="license_no" value="<?php echo $row->license_no;?>" required name='license_no' placeholder="Enter License No.">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="city" class="col-lg-3 col-sm-2 control-label">Valid Upto</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control form-control-inline input-medium default-date-picker" value="<?php echo $row->valid_upto;?>" required id="date" name='valid_upto' placeholder="Enter Date">
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


	
  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
			  autoPlay:true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

      $(window).on("resize",function(){
          var owl = $("#owl-demo").data("owlCarousel");
          owl.reinit();
      });

  </script>

  </body>
</html>
