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
						<h3>Edit Admin</h3>
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
$access_role=array();
	$id = $_GET['id'];
	/* print($id); */
	$this->db->select('*');
	$this->db->from('dbo.admin');
	$this->db->where('id', $id );
	$query = $this->db->get();
	$row = $query->row();
	$access_role=explode(',',$row->access_role);
?>
                      <section class="panel">
                          <header class="panel-heading">
                              Admin Information
                          </header>
						   <div class="panel-body">
                               <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/update_admin">
								<div class="col-lg-6">
									<input type="hidden" name="id" value="<?php echo $row->id?>">
									<div class="form-group">
                                          <label class="col-lg-3 col-sm-2 control-label">Image Upload</label>
                                          <div class="col-md-9">
                                              <div class="fileupload fileupload-exists" data-provides="fileupload">
                                                  <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                                      <img src="<?php echo $row->image?>"  alt="" />
                                                  </div>
                                                  
                                                  <div>
                                                   <span class="btn btn-white btn-file">
													<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span> 
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                   <input type="file" name="image" value="<?php echo $row->image?>" class="default" />
                                                   </span>
                                                     
                                                  </div>
                                              </div>
                                              
                                          </div>
                                      </div>
									<div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Name</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" required id="name" value="<?php echo $row->name?>" name="name" placeholder="Enter Name">
                                      </div>
									</div>
									<!--<div class="form-group">
                                      <label for="username" class="col-lg-3 col-sm-2 control-label">Username</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                                      </div>
									</div>-->
									
									
									
									
								</div>
								<div class="col-lg-6">
									
									<div class="form-group">
                                      <label for="email" class="col-lg-3 col-sm-2 control-label">Email</label>
                                      <div class="col-lg-8">
                                          <input type="email" class="form-control" required id="email" value="<?php echo $row->email?>" name="email" placeholder="Enter Email">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="mobile" class="col-lg-3 col-sm-2 control-label">Mobile Number</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" required id="mobile" value="<?php echo $row->mobile?>" name="mobile" placeholder="Enter Number">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="password" class="col-lg-3 col-sm-2 control-label">Change Password</label>
                                      <div class="col-lg-8">
                                          <input type="password" class="form-control" id="password" value="" name="password" placeholder="Enter Password">
                                      </div>
									</div>
									
									<div class="form-group">
                                      <label for="address" class="col-lg-3 col-sm-2 control-label">Address</label>
                                      <div class="col-lg-8">
                                          <textarea  id="item_description" required class="form-control" name="address" cols="30" rows="3"><?php echo $row->address?></textarea>
                                      </div>
									</div>
									<!--<div class="form-group">
                                      <label for="zip_code" class="col-lg-3 col-sm-2 control-label">Zip Code</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Enter Zip Code">
                                      </div>
									</div>-->
									
								</div>
								 <div class="col-lg-12">
								 <header class="panel-heading ">
                              SUB ADMIN ACCESS ROLE
                          </header>
								 <div class="col-lg-6">
                              <section class="panel">
                                  <header class="panel-heading">
                                    <label class="label_check" for="checkbox-03">
                                              <input name="checkAll" id="checkAll" class='checkbox-01'  type="checkbox" /> MANAGEMENT</label> 
                                  </header>
                                  <div class="panel-body">
                                 
                                          <div class="checkboxes">
                                              <label class="label_check" for="checkbox-01">
                                                 
												  <input type="checkbox" name="management[]" id="checkbox-01" value="view_customer" 
                                                    <?php if (in_array("view_customer", $access_role)) echo 'checked="checked"';?> />VIEW CUSTOMERS</label>
                                              <label class="label_check c_on" for="checkbox-02">
                                              <input name="management[]" class='checkbox-01' id="checkbox-01" value="view_driver" type="checkbox"  <?php if (in_array("view_driver", $access_role)) echo 'checked="checked"';?>/> VIEW DRIVER </label>
                                              <label class="label_check" for="checkbox-03">
                                              <input name="management[]" class='checkbox-01' id="checkbox-01" value="view_transporter" type="checkbox"  <?php if (in_array("view_transporter", $access_role)) echo 'checked="checked"';?> /> VIEW TRANSPORTER</label> 
											  <label class="label_check" for="checkbox-03">
                                              <input name="management[]" class='checkbox-01' id="checkbox-01" value="view_vehicle" type="checkbox"  <?php if (in_array("view_vehicle", $access_role)) echo 'checked="checked"';?>/> VIEW VEHICLE</label>
											   <label class="label_check" for="checkbox-03">
                                              <input name="management[]" class='checkbox-01' id="checkbox-01" value="av_suser" type="checkbox"  <?php if (in_array("av_suser", $access_role)) echo 'checked="checked"';?>/> ADD  & VIEW SCANNER USERS</label>

                                          </div>
                                          
                                     
                                  </div>

                              </section>

                          </div>
						   <div class="col-lg-6">
                              <section class="panel">
                                  <header class="panel-heading">
                                    <label class="label_check" for="checkbox-03">
                                              <input name="checkAll1" id="checkAll1" class='checkbox-02'  type="checkbox" />  ORDERS</label> 
                                  </header>
                                  <div class="panel-body">
                                    
                                          <div class="checkboxes">
                                              <label class="label_check" for="checkbox-01">
                                                  <input name="management[]" class='checkbox-02' id="checkbox-02" value="edit_request" type="checkbox" <?php if (in_array("edit_request", $access_role)) echo 'checked="checked"';?> />EDIT REQUEST</label>
                                              <label class="label_check c_on" for="checkbox-02">
                                              <input name="management[]" class='checkbox-02' id="checkbox-02" value="cancel_request" type="checkbox" <?php if (in_array("cancel_request", $access_role)) echo 'checked="checked"';?> /> CANCEL REQUEST </label>
                                              <label class="label_check" for="checkbox-03">
                                              <input name="management[]"  class='checkbox-02' id="checkbox-02" value="today_dispatched" type="checkbox" <?php if (in_array("today_dispatched", $access_role)) echo 'checked="checked"';?> /> TODAY'S DISPATCHED</label> 
											  <label class="label_check" for="checkbox-03">
                                              <input name="management[]"  class='checkbox-02' id="checkbox-02" value="confirm_pending" type="checkbox" <?php if (in_array("confirm_pending", $access_role)) echo 'checked="checked"';?> /> CONFIRMED PENDING DISPATCHES</label>
											   <label class="label_check" for="checkbox-03">
                                              <input name="management[]"  class='checkbox-02' id="checkbox-02" value="pending_dispatches" type="checkbox" <?php if (in_array("pending_dispatches", $access_role)) echo 'checked="checked"';?> /> PENDING DISPATCHES</label>
											  <label class="label_check" for="checkbox-03">
                                              <input name="management[]"  class='checkbox-02' id="checkbox-02" value="live_bidding" type="checkbox" <?php if (in_array("live_bidding", $access_role)) echo 'checked="checked"';?> /> LIVE BIDDING STATUS</label>
											   <label class="label_check" for="checkbox-03">
                                              <input name="management[]" class='checkbox-02'  id="checkbox-02" value="attn_required" type="checkbox" <?php if (in_array("attn_required", $access_role)) echo 'checked="checked"';?> /> ATTN. REQUIRED</label>
											  <label class="label_check" for="checkbox-03">
                                              <input name="management[]" class='checkbox-02' id="checkbox-02" value="dispatched_order" type="checkbox" <?php if (in_array("dispatched_order", $access_role)) echo 'checked="checked"';?> /> DISPATCHED ORDERS</label>
											   <label class="label_check" for="checkbox-03">
                                              <input name="management[]" class='checkbox-02' id="checkbox-02" value="vehicle_track" type="checkbox" <?php if (in_array("vehicle_track", $access_role)) echo 'checked="checked"';?> /> VEHICLE TRACK</label>
											   <label class="label_check" for="checkbox-03">
                                              <input name="management[]" class='checkbox-02' id="checkbox-02" value="missed_order" type="checkbox" <?php if (in_array("missed_order", $access_role)) echo 'checked="checked"';?> /> MISSED ORDER BY TRANSPORTERS</label>



                                          </div>
                                          
                                    
                                  </div>

                              </section>

                          </div>
						  </div>
						  <div class="col-lg-12">
								
								 <div class="col-lg-6">
                              <section class="panel">
                                  <header class="panel-heading">
                                    <label class="label_check" for="checkbox-03">
                                              <input name="checkAll2" id="checkAll2" class='checkbox-03'  type="checkbox" type="checkbox"  />  DRIVER'S APPRECIATION</label> 
                                  </header>
                                  <div class="panel-body">
                                    
                                          <div class="checkboxes">
                                       
                                              <label class="label_check c_on" for="checkbox-02">
                                              <input name="management[]" class='checkbox-03' id="checkbox-03" value="driver_wallet" type="checkbox" <?php if (in_array("driver_wallet", $access_role)) echo 'checked="checked"';?> /> DRIVER WALLET </label>
											  <label class="label_check c_on" for="checkbox-02">
                                              <input name="management[]" class='checkbox-03' id="checkbox-03" value="assign_milestone" type="checkbox" <?php if (in_array("assign_milestone", $access_role)) echo 'checked="checked"';?> /> ASSIGN MILESTONE</label>
                                             

                                          </div>
                                          
                                   
                                  </div>

                              </section>

                          </div>
						   <div class="col-lg-6">
                              <section class="panel">
                                  <header class="panel-heading">
                                    <label class="label_check" for="checkbox-03">
                                              <input name="checkAll3" id="checkAll3" class='checkbox-04'  type="checkbox" />   REPORTS & CONFIGURATION</label> 
                                  </header>
                                  <div class="panel-body">
                                      
                                          <div class="checkboxes">
                                              <label class="label_check" for="checkbox-01">
                                                  <input name="management[]" class='checkbox-04' id="checkbox-04" value="report" type="checkbox" <?php if (in_array("report", $access_role)) echo 'checked="checked"';?> />REPORTS</label>
                                              <label class="label_check c_on" for="checkbox-02">
                                              <input name="management[]" class='checkbox-04' id="checkbox-04" value="setting" type="checkbox" <?php if (in_array("setting", $access_role)) echo 'checked="checked"';?> /> SETTINGS </label>
											  <label class="label_check c_on" for="checkbox-02">
                                              <input name="management[]" class='checkbox-04' id="checkbox-04" value="rating" type="checkbox" <?php if (in_array("rating", $access_role)) echo 'checked="checked"';?> /> RATINGS </label>
                                              



                                          </div>
                                          
                                   
                                  </div>

                              </section>

                          </div>
						  </div>
              <div class="col-lg-12">
                
                 
               <div class="col-lg-6">
                              <section class="panel">
                                  <header class="panel-heading">
                                    <label class="label_check" for="checkbox-03">
                                              <input name="checkAll4" id="checkAll4" class='checkbox-05'  type="checkbox" />   Access View Transporters Bidding History</label> 
                                  </header>
                                  <div class="panel-body">
                                      
                                          <div class="checkboxes">
                                              <label class="label_check" for="checkbox-01">
                                                  <input name="management[]" class='checkbox-05' id="checkbox-05" value="bid_history" type="checkbox" <?php if (in_array("bid_history", $access_role)) echo 'checked="checked"';?> />Bidding Hostory</label>
                                              </div>
                                          
                                   
                                  </div>

                              </section>

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
<script>

$("#checkAll").click(function() {
      var allChecked = $(this);
      $(".checkbox-01").each(function() {
        $(this).prop("checked", allChecked.is(':checked'));
      })
    });
	
	$("#checkAll1").click(function() {
      var allChecked = $(this);
      $(".checkbox-02").each(function() {
        $(this).prop("checked", allChecked.is(':checked'));
      })
    });
	$("#checkAll2").click(function() {
      var allChecked = $(this);
      $(".checkbox-03").each(function() {
        $(this).prop("checked", allChecked.is(':checked'));
      })
    });
	$("#checkAll3").click(function() {
      var allChecked = $(this);
      $(".checkbox-04").each(function() {
        $(this).prop("checked", allChecked.is(':checked'));
      })
    });
    $("#checkAll4").click(function() {
      var allChecked = $(this);
      $(".checkbox-05").each(function() {
        $(this).prop("checked", allChecked.is(':checked'));
      })
    });
</script>
  </body>
</html>

