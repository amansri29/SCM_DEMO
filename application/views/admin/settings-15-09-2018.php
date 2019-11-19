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
                                      <div class="col-lg-3 radios">
                                         
                                              <label class="label_radio" for="radio-01" >
                                                  <input name="type" id="radio-01" value="Fixed" type="radio" checked /> Fixed
                                              </label>
                                              <label class="label_radio" for="radio-02">
                                                  <input name="type" id="radio-02" value="Percentage" type="radio" /> Percentage
                                              </label>
                                          
                                      </div>
									  <div class="col-lg-3">
                                          <input type="text" class="form-control" id="" name='time' value='<?php echo $row->benfit; ?>' placeholder="Enter Time in minutes">
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
                              Time Settings
                          </header>
						   <div class="panel-body">
						   <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/allowance_setting">
								<input type='hidden' name='id' value='<?php echo $row->id; ?>'>
								<div class="col-lg-12">
									<div class="form-group">
                                      <label for="name" class="col-lg-2 col-sm-2 control-label">Allowance Time To Accept<span class="">(in hrs)</span></label>
                                      
									  <div class="col-lg-3">
                                          <input type="number" class="form-control" id="" name='allowance_hours' value='<?php echo $row->allowance_hours; ?>' placeholder="Enter Time in Hours">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="name" class="col-lg-2 col-sm-2 control-label">Allowance Time To Assign<span class="">(in hrs)</span></label>
                                      
									  <div class="col-lg-3">
                                          <input type="number" class="form-control" id="" name='assign_hours' value='<?php echo $row->assign_hours; ?>' placeholder="Enter Time in Hours">
                                      </div>
									</div>
									
									<span>(<strong>Calculation Info :</strong> Vendor should accept order before allowance hours from delivery date. <br/>
									When time crossed order will move to attention required section.</span><br/>
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
						</section>
						<section class="panel">
                  
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

