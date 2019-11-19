 <?php
	 include "includes/header.php";
	 ?>
	  <style>
       .blink-one {
         animation: blinker-one 1s linear infinite;
       }
       @keyframes blinker-one {  
         0% { opacity: 0; }
       }
	   </style>
  <body>

  <section id="container" class="">
    
      <!--sidebar start-->
      <?php
	 include "includes/transporter_sidebar.php";
	  $user_id = $this->session->userdata('user_id');
	  $global_id = $this->session->userdata('global_id');
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
              <!-- page start-->
			    <?php

if(($this->session->flashdata('item'))) {

  $message = $this->session->flashdata('item');

  ?>
              <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
<?php } ?>
              <div class="row">
                
                  <div class="col-lg-12">
				  <h3 class="left">Inprocess Orders</h3>
					<a class="left">Awarded orders.</a>
                      <div class="row">
                         
                          <div class="col-lg-12">
                              <!--widget start-->
							<section class="panel">
							<div class="panel-body">
								<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
										  <tr>
											    <th class="width-100">Order ID</th>
											    <th class="width-50">SC</th>
												<th class="width-200">Item Code</th>
												<th class="width-250">Description</th>
												<th class="width-100">Quantity</th>
												<th class="width-200">Route</th>
												<th class="width-150">Dispatch Date</th>
												<th class="width-180">Status</th>
											  <th class="width-200">Action</th>
										  </tr>
										</thead>
										<tbody>
										<?php
										 
		
										  foreach( $inprocess_orders as $value ) {
											$items = explode(',', $value['item_code']);
											$descriptions = explode(',', $value['description']);
											$quantity = explode(',', $value['qty_to_ship']);
											$route = explode(',', $value['route']);
											$planned_delivery_date = explode(',', $value['planned_delivery_date']);
											$order_status = $value['order_status'];
											
										?>
										  <tr>
											
                                  <td><strong><a href='<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $value['order_id']?>'><?php echo $value['order_id']?></a></strong><br>
								  <?php echo $value['company']?>
								  </td>
											   <td><?php echo $value['state_code'];?></td>
									       
											  <td><?php foreach($quantity as $qty_key => $qty) {
												 if ($qty > '0')
												 {
												  if (array_key_exists($qty_key, $items)) {
														print($items[$qty_key].'<br>');   
												 }}}?></td>
											  <td><?php foreach($quantity as $qty_key => $qty) {
												 if ($qty > '0')
												 {
												  if (array_key_exists($qty_key, $descriptions)) {
														print($descriptions[$qty_key].'<br>');   
												 }}}?></td>
											  <td><?php foreach($quantity as $qty_key => $qty) {
												 if ($qty > '0')
												 {
												  if (array_key_exists($qty_key, $quantity)) {
														print($quantity[$qty_key].'<br>');   
												 }}}?></td>
											  <td><?php foreach($quantity as $qty_key => $qty) {
												 if ($qty > '0')
												 {
												  if (array_key_exists($qty_key, $route)) {
														print($route[$qty_key].'<br>');   
												 }}}?></td>
											 
											<td> <?php echo date('d-m-Y',strtotime($value['delivery_date'])) ?></td>
												 
											   <?php if($value['shipping_status']=='Awaiting For Arrival') { ?>
											  <td class=''><a class='btn btn-primary width-150'><?php echo $value['shipping_status']?></button></td>
											  <?php }  else if($value['shipping_status']=='Gate In') { ?>
											  <td class=''><a class='btn btn-info width-150'><?php echo $value['shipping_status']?></button></td>
											  <?php }else if($value['shipping_status']=='Tare Weight (Weighbridge)') { ?>
											  <td class=''><a class='btn btn-warning width-150'><?php echo 'Weigh In'?></button></td>
											  <?php } else if($value['shipping_status']=='Loading') { ?>
											  <td class='left'><a class='btn btn-danger width-150'>Loading In</button></td>
											  <?php } else if($value['shipping_status']=='Loading Out') { ?>
											  <td class='left'><a class='btn btn-danger width-150'><?php echo $value['shipping_status']?></button></td>
											  <?php }  else if($value['shipping_status']=='Gross Weight (Weighbridge)') { ?>
											  <td class=''><a class='btn btn-warning width-150'><?php echo 'Weigh Out'?></button></td>
											  <?php }  else if($value['shipping_status']=='Dispatched') { ?>
											  <td class=''><a class='btn btn-success width-150'><?php echo $value['shipping_status']?></button></td>
											 <?php }  else if($value['shipping_status']=='Not Approved') { ?>
											  <td class='left'><a class='btn btn-danger width-150'><?php echo $value['shipping_status']?></button></td>
												  <?php }  else if($value['shipping_status']=='Awaiting For Approvel') { ?>
											  <td class='left'><a class='btn btn-danger width-165'><?php echo $value['shipping_status']?></button></td>
												 <?php }  ?>
												 <?php if($value['sales_status']=='Reopened') { ?>
									 <td class=''><a class='btn btn-danger blink-one width-150'><?php echo $value['sales_status']?> </button></td>
									<?php } else if($value['sales_status']=='Released') { ?>
											  <td> <a class='btn btn-primary btn-sm ' data-tooltip="top" title="View Details" href="<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $value['order_id'];?>"><i class="fa fa-eye"></i></a>
											<!--  <a class='btn btn-danger btn-sm' data-tooltip="top" title="Track Orders" href='<?php echo base_url();?>index.php/transporter/track_now' ><i class="fa fa-map-marker"></i></a>-->
											  <a class='btn btn-default btn-sm' data-tooltip="top" data-toggle="" title="Add Location" href='#myModal'><i class="fa fa-location-arrow"></i></a>
											   <?php if($value['shipping_status']=='Awaiting For Arrival' or $value['shipping_status']=='Not Approved') { 
											   
												$this->db->select('*');
												$this->db->from('dbo.orders_change_details');
												$this->db->where('order_id',$value['order_id']);
												$this->db->where('global_id',$global_id);
												$q = $this->db->get()->row();
												/* print_r($q); */
												if(!empty($q))
												{
												?>
												 <a  class='btn btn-success btn-sm abc' data-tooltip="top" id="<?php echo $value['order_id']?>" value='<?php echo $q->delivery_date?>' name='<?php echo $q->driver_id?>' data-title='<?php echo $q->vehicle_id;?>' data='<?php echo $q->gps_enabled?>' title="Edit Details" href="#change_model" data-toggle="modal"><i class="fa fa-edit"></i></a>
												 <?php
												}
												else
												{
												?>
												<a  class='btn btn-success btn-sm abc' data-tooltip="top" id="<?php echo $value['order_id']?>" value='<?php echo $value['delivery_date']?>' name='<?php echo $value['driver_id']?>' data-title='<?php echo $value['vehicle_id'];?>' data='<?php echo $value['gps_enabled']?>' title="Edit Details" href="#change_model" data-toggle="modal"><i class="fa fa-edit"></i></a>
												<?php
												}
											   } else { ?>
											     <a disabled class='btn btn-danger btn-sm' data-tooltip="top"  title="Not Change" ><i class="fa fa-edit"></i></a>
												  <?php } ?>
												  <?php if($value['shipping_status']=='Awaiting For Arrival' and $value['shipping_status']!='Awaiting For Approvel' ) { ?>
											<a  class='btn btn-danger btn-sm cancel' data-tooltip="top" id="<?php echo $value['order_id']?>"  title="Cancel Order" name='<?php echo $value['order_id'];?>' href="#cancel_order" data-toggle="modal"><i class="fa fa-times-circle"></i></a>
											   <?php } else { ?>
											     <a disabled class='btn btn-danger btn-sm abc' data-tooltip="top" id="<?php echo $value['order_id']?>"  title="Cancel Order"  data-toggle="modal"><i class="fa fa-times-circle"></i></a>
												  <?php } ?>
											  <button data-content="Assigned From Admin" data-placement="left" data-trigger="hover" class="btn btn-info right popovers btn-round"><i class="fa fa-user"></i></button>
											  
											 </td>
									<?php } ?>
										  </tr>
										 <?php
										 
											
										  }
											?>
										 
										</tbody>
										<tfoot>
										  <th>Order ID</th>
										   <th class="width-50">SC</th>
                                           <th>Item Code</th>
											<th>Description</th>
											<th>Quantity</th>
											<th>Root</th>
											<th>Dispatch Date</th>
											<th>Status</th>
											<th>Action</th>
										</tfoot>
										</table>
								</div>
									 
							</div>
                            </section>              
                        </div>
                    </div>
                              </section>
                              <!--widget end-->
							  
							  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="change_model" class="modal fade">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                              <h4 class="modal-title">Change Details</h4>
                                          </div>
                                          <div class="modal-body">

                                               <form action="<?php echo base_url();?>index.php/transporter/chnage_details_order" method="post" class='form-horizontal' enctype="multipart/form-data" >
													<input type="hidden" name="order_id" value='' id='orderIds'>
													<div class="form-group">
													  <label class="col-lg-3 col-sm-2 control-label">Vehicle No.</label>
														<div class="col-lg-8">
															<select class="js-example-basic-single vehicle" id='vehiclelist' required name='vehicle_id'>
																											
															</select>
														</div>
													</div>
													
													
													
													
													<div class="form-group">
													  <label class="col-lg-3 col-sm-2 control-label">Driver</label>
														<div class="col-lg-8">
															<select class="js-example-basic-single " id='driverlist' name='driver_id'>
																
																
																
															</select>
														</div>
													</div>
													<div class="form-group">
														<label for="insurance" class="col-lg-3 col-sm-2 control-label">GPS Availability</label>
														<div class="col-md-3">
															<div class="radio radio-info radio-inline">
															<input id="inlineRadio1" value="yes" name="gps_enabled[]" checked="" type="radio">
															<label for="inlineRadio1">Yes</label>
														</div>
														</div>
														<div class="col-md-3">
															<div class="radio radio-info radio-inline">
															<input id="inlineRadio2" value="no" name="gps_enabled[]" type="radio">
															<label for="inlineRadio2">No</label>
														  </div>
														 </div>
													</div>
													
												
												
													<div class="form-group">
													<label for="lr_rr_date" class="col-lg-3 col-sm-2 control-label">Delivery Date</label>
													<div data-date-viewmode="years" data-date-format="dd-mm-yyyy" class="input-append date dpYears col-lg-4">
															  <input type="text" readonly="" size="5" name="delivery_date" id='delivery_d' class="form-control">
															  <span class="input-group-btn add-on">
																<button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
															  </span>
															</div> 
															</div>
															<div class="form-group ">
														<label for="insurance" class="col-lg-3 col-sm-2 control-label">Reason For Change</label>
														<div class="col-lg-8">
														<textarea class="form-control"  name='reason' placeholder="Enter Reason" >
															</textarea>
															</div>
														</div>
														<div class="form-group">
													  <div class="col-lg-offset-5 col-lg-2">
													  <button type="submit" class="btn btn-danger">Change</button>
													  </div>
													</div>
													</div>
													
                                              </form>
                                          </div>
                                      </div>
                                  </div>
 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                              <h4 class="modal-title">Add Address</h4>
                                          </div>
                                          <div class="modal-body">

                                              <form role="form" class="form-horizontal">
												
													<div class="form-group">
													  <label class="col-lg-3 col-sm-2 control-label">Address</label>
														<div class="col-lg-7">
															<input type="text" class="form-control" id="address" placeholder="Enter Address">
														</div>
														<div class="col-lg-1">
															<a class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></i></a>
														</div>
													</div>
													
													<div class="form-group">
													  <div class="col-lg-offset-5 col-lg-2">
													  <button type="submit" class="btn btn-danger">Add</button>
													  </div>
													</div>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
							  
                          </div>
                      </div>
                      
                  </div>

              </div>
            <div class="modal modal-dialog-center fade" id="cancel_order">
            <div class="modal-dialog modal-sm">
              <div class="v-cell">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url();?>index.php/transporter/cancel_order" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to Cancel order?</p>
					  <input type="hidden" value='' name='cancel_order_id' id='cancel_order_id'>
					  <div class="form-group ">
					<label for="insurance" class="col-lg-3 col-sm-2 control-label">Reason For Cancel</label>
					<div class="col-lg-8">
					<textarea class="form-control"  name='reason' placeholder="Enter Reason" >
						</textarea><br>
						</div>
					</div>
                      <div class="text-center">
                      <button type="submit" class="btn btn-success paper-shadow relative">Yes</button>
                      <button type="button" data-dismiss="modal" class="btn btn-danger paper-shadow relative no">No</button>
					  </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
               
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
	  $('.cancel').click(function() {
           $id = $(this).attr("name");
			$('#cancel_order_id').val($id);
        });
	$('.abc').click(function(){
			$order_id = $(this).attr("id");
			$driver_id = $(this).attr("name");
			$vehicle_id = $(this).attr("data-title");
			$delivery_date = $(this).attr("value");
			$gps_enabled = $(this).attr("data");
			
			/* alert($order_id+' '+$driver_id+' '+$vehicle_id+' '+$delivery_date+' '+$gps_enabled); */
			$('#orderIds').val($order_id);
			$('#delivery_d').val($delivery_date);
			if($gps_enabled == 'yes')
			{
				$("#yes").prop("checked", true); 
			}
			else
			{
				$("#no").prop("checked", true); 
			}
			$.ajax({
				
                type:'post',
                url:'<?php echo base_url();?>index.php/transporter/driver_list',
                
                success:function(res){
					/* alert(res); */
					var obj= jQuery.parseJSON(res);
					/* alert(obj); */
					if(obj){         
						 $(obj).each(function(){       
						var option = $('<option />'); 
						if(this.id == $driver_id)
						{
							option.attr({'value': this.id, 'selected':"selected"}).text(this.name);  
						}
						else
						{
							option.attr('value', this.id).text(this.name);  
						}
						
						$('#driverlist').append(option);     
						});              
					 }
					else{		
						$('#driverlist').html('<option value="">Driver not available</option>');  
					}      
                }
			});

			$.ajax({
				
                type:'post',
                url:'<?php echo base_url();?>index.php/transporter/vehicle_list',
                
                success:function(res){
					/* alert(res); */
					var obj= jQuery.parseJSON(res);
					/* alert(obj); */
					if(obj){         
						 $(obj).each(function(){       
						var option = $('<option />'); 
						if(this.id == $vehicle_id)
						{
							option.attr({'value': this.id, 'selected':"selected"}).text(this.registration_no);  
						}
						else
						{
							option.attr('value', this.id).text(this.registration_no);  
						}
						
						$('#vehiclelist').append(option);     
						});              
					 }
					else{		
						$('#vehiclelist').html('<option value="">Vehicle not available</option>');  
					}      
                }
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
