 <?php
	 include "includes/header.php";
	 ?>
  <body>

  <section id="container" class="">
    
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
	$id = $_GET['id'];
	/* print($id); */
	$this->db->select('*');
	$this->db->from('dbo.vehicle');
	$this->db->where('id', $id );
	$query = $this->db->get();
	$row = $query->row();
	
?>
                      <section class="panel">
                          <header class="panel-heading">
                              Vehicle Information
                          </header>
						   <div class="panel-body">
                              <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/update_vehicle">
								<div class="col-lg-6">
								<input type="hidden" name="id" value="<?php echo $id;?>">
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
                                      <label for="registration" class="col-lg-3 col-sm-2 control-label">Registration No.</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="registration" value="<?php echo $row->registration_no?>" required name='registration_no' placeholder="Enter Registration No">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="city" class="col-lg-3 col-sm-2 control-label">Valid Upto</label>
                                      <div class="col-lg-8">
										<?php $date = date("d-m-Y", strtotime($row->valid_upto));?>
                                          <input type="text" class="form-control form-control-inline input-medium default-date-picker" value="<?php echo $date?>" name='valid_upto' id="date" placeholder="Enter Date" required>
                                      </div>
									</div>
									<div class="form-group">
                                      <label class="col-lg-3 col-sm-2 control-label">Vehicle Type</label>
										<div class="col-lg-8">
										<?php $databaseValue = $row->vehicle_type; ?>
											<select class="js-example-basic-single " name="vehicle_type">
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
									
									
								</div>
								<div class="col-lg-6">
									
									<div class="form-group">
                                      <label for="owner_name" class="col-lg-3 col-sm-2 control-label">Owner Name</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="owner_name" value="<?php echo $row->owner_name?>" required name="owner_name" placeholder="Enter name">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="owner_name" class="col-lg-3 col-sm-2 control-label">Insurance No</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="insurance" required name="insurance" value="<?php echo $row->insurance?>" placeholder="Enter name">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="owner_contact" class="col-lg-3 col-sm-2 control-label">Owner Contact</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="owner_contact" value="<?php echo $row->owner_contact?>" required name="owner_contact" placeholder="Enter number">
                                      </div>
									</div>
									<div class="form-group">
										<label for="capacity" class="col-lg-3 col-sm-2 control-label">Capacity</label>
										<div class="col-lg-4">
											<input type="text" class="form-control" id="capacity" value="<?php echo $row->capacity?>" required name="capacity" placeholder="Enter Capacity">
										</div>
										<div class="col-lg-4">
											<?php $databaseValue = $row->unit; ?>
											<select class="js-example-basic-single " name="unit">
												<option value="0">Select unit</option>
												<option value="KGs" <?php echo (($databaseValue=='KGs')?"selected":"") ?>>KGs</option>
												<option value="MT" <?php echo (($databaseValue=='MT')?"selected":"") ?>>MT</option>
												<option value="Litre" <?php echo (($databaseValue=='Litre')?"selected":"") ?>>Litre</option>
												<option value="Gallons" <?php echo (($databaseValue=='Gallons')?"selected":"") ?>>Gallons</option>
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
