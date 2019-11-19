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
						<h3>Admin Settings</h3>
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


		 $this->db->select('*');
		$this->db->from('dbo.auth_details');
		$query = $this->db->get();
		 $res = $query->row();
		
?>
                      <section class="panel">
                          <header class="panel-heading">
                              Appreciation Settings
                          </header>
						   <div class="panel-body">
                            <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/add_time_and_rate">
							<input type='hidden' name='id' value='<?php echo $row->id; ?>'>
								<div class="col-lg-12">
									<div class="form-group">
                                      <label for="name" class="col-lg-2 col-sm-2 control-label">Benefit over Estimated Time</label>
                                      <div class="col-lg-2 radios">
                                         
                                             <!-- <label class="label_radio" for="radio-01" >
                                                  <input name="type" id="radio-01" value="Fixed" type="radio" checked /> Fixed
                                              </label>-->
                                              <label class="label_radio" for="radio-02">
                                                  <input name="type" id="radio-02" value="Percentage" type="radio" checked /> Percentage
                                              </label>
                                          
                                      </div>
									  <div class="col-lg-3">
									  <div class="input-group m-bot15">
                                              <span class="input-group-addon">%</span>
                                          <input type="text" class="form-control" id="" name='time' value='<?php echo $row->benfit; ?>' placeholder="Enter Time in minutes">
										  </div>
                                      </div>
									</div>
									
									<div class="form-group">
                                      <label for="mobile" class="col-lg-2 col-sm-2 control-label">Appreciation Rate <span class="">(per km)</span></label>
                                      <div class="col-lg-6">
                                          <div class="input-group m-bot15">
                                              <span class="input-group-addon">INR</span>
                                              <input class="form-control" placeholder="Enter Amount" name ='rate' value='<?php echo $row->appreciation_rate; ?>' type="text">
                                          </div>
                                      </div>
									</div>
									<div class="form-group">
									
                                      <label for="name" class="col-lg-2 col-sm-2 control-label">Per Day Travel Km <span class="">(in km) </span></label>
                                      
									  <div class="col-lg-6">
									  <div class="input-group m-bot15">
                                              <span class="input-group-addon">KM</span>
                                          <input type="number" class="form-control" id="" name='per_day_km' value='<?php echo $row->per_day_travel_km; ?>' placeholder="Enter Km">
                                      </div>
									  </div>
									</div>
									<div class="form-group">
                                      <label for="name" class="col-lg-2 col-sm-2 control-label">Driver Offline When Travel <span class="">(in hrs)</span></label>
                                      
									  <div class="col-lg-6">
									  <div class="input-group m-bot15">
                                              <span class="input-group-addon">HRS</span>
                                          <input type="number" class="form-control" id="" name='track_trace_hour' value='<?php echo $row->track_and_trace_hours; ?>' placeholder="Enter Hours">
										  </div>
                                      </div>
									</div>
									<span>(<strong>Calculation Info :</strong> Appreciation will be given to the driver if he will reach at the destination within expected time(estimated time + benefit time). <br/>
									Appreciation amount = Total destination * Appreciation Rate(per km).)</span><br/>
								</div>
								<div class="col-lg-12">
								<br/>
								<div class="form-group">
								  <div class=" col-lg-2">
									  <button type="submit" class="btn btn-danger btn-block">Save</button>
								  </div>
								</div>
								</div>
							  </form>
							</div>
						</section>
					</div>
					<div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Add Tolerance 
                          </header>
						   <div class="panel-body">
						   <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/tolerance">
								<input type='hidden' name='id' value='<?php echo $row->id; ?>'>
								<div class="col-lg-6">
								
									<div class="form-group">
                                      <label for="name" class="col-lg-4 col-sm-4 control-label">Add Tolerance <span class="">(in Ton)</span></label>
                                      
									  <div class="col-lg-7">
									   <div class="input-group m-bot15">
                                              <span class="input-group-addon">TON</span>
                                          <input type="number" class="form-control" id="" name='tolerance' value='<?php echo $row->tolerance; ?>' placeholder="Enter Tolerance in Ton">
										  </div>
                                      </div>
									</div>
								</div>
								
								<div class="col-lg-12">	
								<div class="form-group">
								  <div class=" col-lg-2">
									  <button type="submit" class="btn btn-danger btn-block">Save</button>
								  </div>
								</div>
								</div>
							  </form>
							</div>
						</section>
					</div>
					<div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Time Settings
                          </header>
						   <div class="panel-body">
						   <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/allowance_setting">
								<input type='hidden' name='id' value='<?php echo $row->id; ?>'>
								<div class="col-lg-6">
								
									<div class="form-group">
                                      <label for="name" class="col-lg-4 col-sm-4 control-label">Allowance Time To Accept<span class="">(in hrs)</span></label>
                                      
									  <div class="col-lg-7">
                                          <input type="number" class="form-control" id="" name='allowance_hours' value='<?php echo $row->allowance_hours; ?>' placeholder="Enter Time in Hours">
                                      </div>
									</div>
									
									<div class="form-group">
                                      <label for="name" class="col-lg-4 col-sm-4 control-label">Allowance Time To Assign<span class="">(in hrs)</span></label>
                                      
									  <div class="col-lg-7">
                                          <input type="number" class="form-control" id="" name='assign_hours' value='<?php echo $row->assign_hours; ?>' placeholder="Enter Time in Hours">
                                      </div>
									</div>
									
									
								</div>
								<div class="col-lg-6">
								
									<div class="form-group">
                                      <label for="name" class="col-lg-4 col-sm-4 control-label">Bid Applying Time<span class="">(in hrs)</span></label>
                                      
									  <div class="col-lg-7">
                                          <input type="number" class="form-control" id="" name='bidding_hours' value='<?php echo $row->bidding_hours; ?>' placeholder="Enter Time in Hours">
                                      </div>
									</div>
									<br/>
									<div class="form-group">
                                      <label for="name" class="col-lg-4 col-sm-4 control-label">Bid Assign Time First Vendor <span class="">(in hrs)</span></label>
                                      
									  <div class="col-lg-7">
                                          <input type="number" class="form-control" id="" name='assign_bidding_hours' value='<?php echo $row->assign_bidding_hours; ?>' placeholder="Enter Time in Hours">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="name" class="col-lg-4 col-sm-4 control-label">Bid Assign Time second Vendor <span class="">(in hrs)</span></label>
                                      
									  <div class="col-lg-7">
                                          <input type="number" class="form-control" id="" name='assign_bidding_hours_second' value='<?php echo $row->assign_bidding_hours_second; ?>' placeholder="Enter Time in Hours">
                                      </div>
									</div>
									
								</div>
								<div class="col-lg-12">
								
									<span>(<strong>Calculation Info :</strong> Vendor should accept order before allowance hours from delivery date. 
									When time crossed order will move to attention required section.</span><br/>
								<br/>
								<div class="form-group">
								  <div class=" col-lg-2">
									  <button type="submit" class="btn btn-danger btn-block">Save</button>
								  </div>
								</div>
								</div>
							  </form>
							</div>
						</section>
					</div>
					<div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Reject Order Reason
                          </header>
						   <div class="panel-body">
						   <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/add_reject_reason">
								<input type='hidden' name='id' value='<?php echo $row->id; ?>'>
								<div class="col-lg-12">
									<div class="form-group">
                                      <label for="name" class="col-lg-2 col-sm-2 control-label">Add Reject order Reason:</label>
                                      
									  <div class="col-lg-3">
                                          <input type="text" class="form-control" id="" name='reject_reason' value='' placeholder="Enter Reject Reason">
                                      </div>
									</div>
									
									<span>(<strong>Note :</strong> Vendor should reject order before give  specific reason <br/>
									And order will move to attention required section.</span><br/>
								</div>
								<div class="col-lg-12">
								<br/>
								<div class="form-group">
								  <div class=" col-lg-2">
									  <button type="submit" class="btn btn-danger btn-block">Save Reason</button>
								  </div>
								</div>
								</div>
							  </form>
							</div>
							<div class="panel-body">
                      <div class="adv-table">
                       <div class="table-responsive">

                          <table class="table table-striped table-hover table-bordered" id="dynamic-table">
                              <thead>
                              <tr>
                                  <th>S. No</th>
                                  <th>Reason Name</th>
                                 <th>Delete</th>
                              </tr>
                              </thead>
                              <tbody>
							  <?php
							  $i=0;
							  foreach($data as $get)
							  {
								  $i++;
								  ?>
                              <tr class="">
                                  <td><?php echo $i; ?></td>
                                  <td><?php echo $get['reject_reason']; ?></td>
                                  <td><form method='POST' action="<?php echo base_url();?>index.php/admin/delete_reason"><button class="fa fa-trash-o btn btn-danger" value='<?php echo $get['id']; ?>' name='id'></button></form></td>
                              </tr>
                              <?php } ?>
                              </tbody>
                          </table>

                          </div>
                      </div>
                  </div>
						</section>
					
					</div>
					
					<div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Change Password
                          </header>
						   <div class="panel-body">
						   <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/change_password">
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
								 </form>
								</div>
								
							 
							</div>
							<div class="col-lg-12">
                           <section class="panel">
                          <header class="panel-heading">
                            SMTP Configuration
                          </header>
						   <div class="panel-body">
						   <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_auth_details">
								<input type='hidden' name='id' value='<?php echo $row->id; ?>'>
								<div class="col-lg-6">
									<div class="form-group">
                                      <label for="name" class="col-lg-2 col-sm-2 control-label">Cryptographic protocol</label>
                                      
									  <div class="col-lg-7">
                                          <input type="text" class="form-control" id="" name='crpto_protocol' value='<?php echo $res->crypto_protocol ?>'  required placeholder="Enter Cryptographic protocol">
                                      </div>
									  </div>
									  <div class="form-group">
                                      <label for="name" class="col-lg-2 col-sm-2 control-label">Protocol</label>
                                      
									  <div class="col-lg-7">
                                          <input type="text" class="form-control" id="" name='protocol' value='<?php echo $res->protocol ?>' placeholder="Enter protocol" required="">
                                      </div>
									  </div>
									    <div class="form-group">
                                      <label for="name" class="col-lg-2 col-sm-2 control-label">SMTP Host</label>
                                      
									  <div class="col-lg-7">
                                          <input type="text" class="form-control" id="" name='host' value='<?php echo $res->smtp_host ?>' placeholder="Enter SMTP Host" required="">
                                      </div>
									  </div>
									  </div>
									  <div class="col-lg-6">
									  <div class="form-group">
									  <label for="name" class="col-lg-2 col-sm-2 control-label">SMTP Port</label>
									  <div class="col-lg-3">
                                          <input type="text" class="form-control" id="" name='port' value='<?php echo $res->smtp_port ?>' placeholder="Enter SMTP Port" required="">
                                      </div>
									  </div>
									  <div class="form-group">
									  <label for="name" class="col-lg-2 col-sm-2 control-label">SMTP Username</label>
									  <div class="col-lg-7">
                                          <input type="text" class="form-control" id="" name='username'  value='<?php echo $res->smtp_user ?>' placeholder="Enter SMTP Username" required="">
                                      </div>
									  </div>
									  <div class="form-group">
									  <label for="name" class="col-lg-2 col-sm-2 control-label">SMTP Password</label>
									  <div class="col-lg-7">
                                          <input type="text" class="form-control" id="" name='password' value='<?php echo $res->smtp_pass ?>' placeholder="Enter SMTP Password" required="">
                                      </div>
									  </div>
									</div>
									
									
									<div class="col-lg-12">
								<br/>
								<div class="form-group">
								  <div class=" col-lg-2">
									  <button type="submit" class="btn btn-danger btn-block">Update Details</button>
								  </div>
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

