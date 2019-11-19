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
						<h3>Add Vehicle</h3>
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

?>
                      <section class="panel">
                          <header class="panel-heading">
                              Vehicle Information
                          </header>
						   <div class="panel-body">
                              <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/transporter/save_vehicle">
								<div class="col-lg-6">
									<div class="form-group">
                                      <label for="registration" class="col-lg-3 col-sm-2 control-label">Registration No.</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" required id="registration" name='registration_no' placeholder="Enter Registration No">
                                      </div>
									</div>
									<!--<div class="form-group">
                                      <label for="city" class="col-lg-3 col-sm-2 control-label">Valid Upto</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control form-control-inline input-medium default-date-picker" name='valid_upto' id="date" placeholder="Enter Date">
                                      </div>
									</div>-->
									<div class="form-group">
                                      <label class="col-lg-3 col-sm-2 control-label">Vehicle Type</label>
										<div class="col-lg-8">
											<select class="js-example-basic-single " required name="vehicle_type">
												<option disabled >Select Vehice Type</option>
												<option value="Closed Truck">Closed Truck</option>
												<option value="Flat Bed / Container">Flat Bed / Container</option>
												<option value="ODC">ODC</option>
												<option value="Open Truck">Open Truck</option>
												<option value="Refrigerated Truck">Refrigerated Truck</option>
												<option value="Tanker">Tanker</option>
												<option value="Tipper(Dumper)">Tipper(Dumper)</option>
												<option value="Transit Mixer">Transit Mixer</option>
												<option value="Vehicle Carrier">Vehicle Carrier</option>
												<option value="Trailer">Trailer</option>
											</select>
										</div>
									</div>
									<div class="form-group">
                                      <label for="owner_name" class="col-lg-3 col-sm-2 control-label">Owner Name</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" required id="owner_name" name="owner_name" placeholder="Enter name">
                                      </div>
									</div>
									
								</div>
								<div class="col-lg-6">
									
									
									<div class="form-group">
                                      <label for="owner_name" class="col-lg-3 col-sm-2 control-label">Insurance No</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" required id="insurance" name="insurance" placeholder="Enter name">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="owner_contact" class="col-lg-3 col-sm-2 control-label">Owner Contact</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control"  required id="owner_contact" name="owner_contact" placeholder="Enter number">
                                      </div>
									</div>
									<div class="form-group">
										<label for="capacity" class="col-lg-3 col-sm-2 control-label">Capacity</label>
										<div class="col-lg-4">
											<input type="text" class="form-control" required vid="capacity" name="capacity" placeholder="Enter Capacity">
										</div>
										<div class="col-lg-4">
											<select class="js-example-basic-single" required name="unit">
												<option Disabled value="0">Select unit</option>
												<option value="ton">Ton</option>
												<!--<option value="KGs">KGs</option>
												<option value="MT">MT</option>
												<option value="Litre">Litre</option>
												<option value="Gallons">Gallons</option>-->
											</select>
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

  <script type="text/javascript">

      $(document).ready(function () {
          $(".js-example-basic-single").select2();

          $(".js-example-basic-multiple").select2();
      });
  </script>
  <script>

      //knob
      $(".knob").knob();

  </script>

  </body>
</html>
