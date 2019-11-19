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
						<h3>Edit Vehicle</h3>
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
	$this->db->from('dbo.vehicle');
	$this->db->where('id', $id );
	$query = $this->db->get();
	$row = $query->row();

?>
                      <section class="panel">
                          <header class="panel-heading">
                              vehicle Information
                          </header>
						  <div class="panel-body">
                             <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/transporter/update_vehicle">
								<div class="col-lg-6">
								<input type="hidden" name="id" value="<?php echo $id;?>">
									<div class="form-group">
                                      <label for="registration" required class="col-lg-3 col-sm-2 control-label">Registration No.</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="registration" name='registration_no' value="<?php echo $row->registration_no;?>" placeholder="Enter Registration No">
                                      </div>
									</div>
									<!--<div class="form-group">
                                      <label for="city" class="col-lg-3 col-sm-2 control-label">Valid Upto</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control form-control-inline input-medium default-date-picker" value="<?php echo $row->valid_upto;?>" name='valid_upto' id="date" placeholder="Enter Date">
                                      </div>
									</div>-->
									<div class="form-group">
									<?php $databaseValue = $row->vehicle_type; ?>
                                      <label class="col-lg-3 col-sm-2 control-label">Vehicle Type</label>
										<div class="col-lg-8">
											<select class="js-example-basic-single"  required name="vehicle_type">
												<option value="0">Select Vehice Type</option>
												<option value="Closed Truck" <?php echo (($databaseValue=='Closed Truck')?"selected":"") ?>>Closed Truck</option>
												<option value="Flat Bed / Container" <?php echo (($databaseValue=='Flat Bed / Container')?"selected":"") ?>>Flat Bed / Container</option>
												<option value="ODC" <?php echo (($databaseValue=='ODC')?"selected":"") ?>>ODC</option>
												<option value="Open Truck" <?php echo (($databaseValue=='Open Truck')?"selected":"") ?>>Open Truck</option>
												<option value="Refrigerated Truck" <?php echo (($databaseValue=='Refrigerated Truck')?"selected":"") ?>>Refrigerated Truck</option>
												<option value="Tanker" <?php echo (($databaseValue=='Tanker')?"selected":"") ?>>Tanker</option>
												<option value="Tipper(Dumper)" <?php echo (($databaseValue=='Tipper(Dumper)')?"selected":"") ?>>Tipper(Dumper)</option>
												<option value="Transit Mixer" <?php echo (($databaseValue=='Transit Mixer')?"selected":"") ?>>Transit Mixer</option>
												<option value="Vehicle Carrier" <?php echo (($databaseValue=='Vehicle Carrier')?"selected":"") ?>>Vehicle Carrier</option>
												<option value="Trailer" <?php echo (($databaseValue=='Trailer')?"selected":"") ?>>Trailer</option>
											</select>
										</div>
									</div>
									<div class="form-group">
                                      <label for="owner_name" class="col-lg-3 col-sm-2 control-label">Owner Name</label>
                                      <div class="col-lg-8">
                                          <input type="text" required class="form-control" id="owner_name" value="<?php echo $row->owner_name;?>" name="owner_name" placeholder="Enter name">
                                      </div>
									</div>
									
								</div>
								<div class="col-lg-6">
									
									
									<div class="form-group">
                                      <label for="owner_name" class="col-lg-3 col-sm-2 control-label">Insurance No</label>
                                      <div class="col-lg-8">
                                          <input type="text" required class="form-control" id="insurance" value="<?php echo $row->insurance;?>" name="insurance" placeholder="Enter name">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="owner_contact" class="col-lg-3 col-sm-2 control-label">Owner Contact</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control"required  id="owner_contact" name="owner_contact" value="<?php echo $row->owner_contact;?>" placeholder="Enter number">
                                      </div>
									</div>
									<div class="form-group">
										<label for="capacity" class="col-lg-3 col-sm-2 control-label">Capacity</label>
										<div class="col-lg-4">
											<input type="text" class="form-control" required id="capacity" name="capacity" value="<?php echo $row->capacity;?>" placeholder="Enter Capacity">
										</div>
										<div class="col-lg-4">
										<?php $databaseValue = $row->unit; ?>
											<select class="js-example-basic-single " required name="unit">
												<option value="0">Select unit</option>
												<option value="ton" <?php echo (($databaseValue=='ton')?"selected":"") ?>>Ton</option>
											
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
