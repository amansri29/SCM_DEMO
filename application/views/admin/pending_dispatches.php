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
				  <h3 class="left">Confirmed Pending Dispatches</h3>
					
                      <div class="row">
                         
                          <div class="col-lg-12">
                              <!--widget start-->
							<section class="panel">
							<div class="panel-body">
								<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
										  <tr>
											<tr>
												<th class="width-120">Dispatch Date</th>
												<th class="width-80">Order ID</th>
												<th class="width-80">SC</th>
												<th class="width-120">Item Code</th>
												<th class="width-200">Description</th>
												
												<th class="width-200">Route</th>
												<th class="width-200">Planned date</th>
										<th class="width-100">Qty to ship</th>
												<th class="width-150">Customer Name</th>
												<th class="width-150">Shipment Name</th>
												<th class="width-200">Transporter Name</th>
												<th class="width-200">Status</th>
												
												<th class="width-180 text-center">Action</th>
											</tr>
											
										  </tr>
										</thead>
										<tbody>
										  <?php
										  foreach ($pending as $get)
							  {
								  $qty_to_ship = explode(',', $get['qty_to_ship']);
								  $item_code = explode(',', $get['item_code']);
								  $description = explode(',', $get['description']);
								  $planned_delivery_date = explode(',', $get['planned_delivery_date']);
								  $route = explode(',', $get['route']);
								  $state_code = $get['state_code'];
								  $company = $get['company'];
									
							   ?>
										  <tr>
								  <td> <?php echo date('d-m-Y',strtotime($get['delivery_date'])) ?><strong></td>
                                  <td><strong><a href='<?php echo base_url();?>index.php/admin/order_view?id=<?php echo $get['order_id']?>'><?php echo $get['order_id']?></a></strong><br>
								  <?php echo $get['company']?>
								  </td>
								   <td> <?php echo $get['state_code'] ?></td>
											  <td><?php
                                           foreach($qty_to_ship as $qty_key => $qty) {
                                         if ($qty > '0')
										 {
					                      if (array_key_exists($qty_key, $item_code)) {
                                                print($item_code[$qty_key].'<br>');   
										 }}}
								    ?></td>
											  <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                         if ($qty > '0')
										 {
					                      if (array_key_exists($qty_key, $description)) {
                                                print($description[$qty_key].'<br>');   
										 }}} ?> </td>
											  <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                         if ($qty > '0')
										 {
					                      if (array_key_exists($qty_key, $route)) {
                                                print($route[$qty_key].'<br>');   
										 }}} ?></td>
										 <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                          
                                         if ($qty > '0' || $posting_date)
										 {
					                      if (array_key_exists($qty_key, $planned_delivery_date)) {
                                                print($planned_delivery_date[$qty_key].'<br>');   
								  }}}?></td>
								  <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                          
                                         if ($qty > '0' || $posting_date)
										 {
					                      
                                                print($qty.'<br>');   
								  }}?></td>
											   <td><?php echo $get['cust_name']?></td>
											  <td><?php echo $get['ship_to_name']?></td>
											  <td><?php echo $get['trans_name']?></td>
											  
											  <?php if($get['sales_status']=='Reopened') { ?>
									 <td class=''><a class='btn btn-danger blink-one width-150'><?php echo $get['sales_status']?> </button></td>
									 <td class=''><a disabled class='btn btn-danger btn-sm abc' data-tooltip="top" id="<?php echo $get['order_id']?>"  title="Cancel Order" href="" data-toggle="modal">Cancel Order</a></td>
									<?php } else if($get['sales_status']=='Released') {?>
											  <?php if($get['status']=='Awaiting For Arrival') { ?>
								  <td class=''><a class='btn btn-primary width-150'><?php echo $get['status']?></button></td>
                                  <?php }  else if($get['status']=='Gate In') { ?>
								  <td class=''><a class='btn btn-info width-150'><?php echo $get['status']?></button></td>
                                  <?php }else if($get['status']=='Tare Weight (Weighbridge)') { ?>
								  <td class=''><a class='btn btn-warning width-150'><?php echo 'Weigh In'?></button></td>
                                  <?php } else if($get['status']=='Loading') { ?>
								  <td class=''><a class='btn btn-danger width-150'>Loading In</button></td>
								   <?php } else if($get['status']=='Loading Out') { ?>
								  <td class=''><a class='btn btn-danger width-150'><?php echo $get['status']?></button></td>
                                  <?php }  else if($get['status']=='Gross Weight (Weighbridge)') { ?>
								  <td class=''><a class='btn btn-warning width-150'><?php echo 'Weigh Out'?></button></td>
                                  <?php }  else if($get['status']=='Dispatched') { ?>
								  <td class=''><a class='btn btn-success width-150'><?php echo $get['status']?></button></td>
                                 <?php } else if($get['status']=='Not Approved'){  ?>
								   <td class=''><a class='btn btn-danger width-150' href="<?php echo base_url();?>index.php/admin/approvel_orders">Not Approved</button></td>
								   <?php }  else if($get['status']=='Awaiting For Approvel') { ?>
											  <td class='left'><a class='btn btn-danger width-165' href="<?php echo base_url();?>index.php/admin/trans_cancel_approvel"><?php echo $get['status']?></button></td>
												 <?php }  ?>
											 <!-- <td > <a class='btn btn-primary btn-sm ' href='<?php echo base_url();?>index.php/admin/order_view?id=<?php echo $get['order_id']?>'><i class="fa fa-eye"></i></a>     </td> -->                             
												<td> <?php if($get['status']=='Awaiting For Arrival') { ?>
											  <a  class='btn btn-danger btn-sm cancel' data-tooltip="top" id="<?php echo $get['order_id']?>"  title="Cancel Order" href="#cancel_model" name='<?php echo $get['order_id'];?>' data-toggle="modal">Cancel Order</a>
											   <?php } else { ?>
											     <a disabled class='btn btn-danger btn-sm abc' data-tooltip="top" id="<?php echo $get['order_id']?>"  title="Cancel Order" href="" data-toggle="modal">Cancel Order</a>
									<?php } ?></td><?php } ?>
											 
											  <!--<button data-content="Assigned From Admin" data-placement="left" data-trigger="hover" class="btn btn-info right popovers btn-round"><i class="fa fa-user"></i></button>-->
											  
											 
										  </tr>
										 
							  <?php } ?>
										  
										</tbody>
										<tfoot>
										
											<th>Dispatch Date</th>
											<th>Order ID</th>
											<th class="width-80">SC</th>
											<th>Item Code</th>
											<th>Description</th>
											<th>Route</th>
											<th >Planned date</th>
										   <th>Quantity to ship</th>
											<th>Customer Name</th>
											<th>Shipment Name</th>
											<th>Transporter Name</th>
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

                          </div>
                      </div>
                  
          </section>
      </section>
      <!--main content end-->


 <div class="modal fade modal-dialog-center" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content-wrap">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title">Are you sure you want to open order for bid?</h4>
                                              </div>
                                              <!--<div class="modal-body">

                                                  Body goes here...

                                              </div>-->
                                              <div class="modal-footer">
                                                  <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                                                  <button class="btn btn-danger" type="button"> Yes</button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
<div class="modal fade modal-dialog-center" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content-wrap">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title">Change Dispatch Date</h4>
                                              </div>
                                              <div class="modal-body">
												<div class="row">
												  <div class="form-group">
													 
													  <div class="col-md-11">

														  <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-07-2018"  class="input-append date dpYears">
															  <input type="text" readonly="" value="12-07-2018" size="16" class="form-control">
															  <span class="input-group-btn add-on">
																<button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
															  </span>
															</div>
														  <span class="help-block">Select date</span>
													  </div>
												  </div>
												  </div>
												</div>
                                              <div class="modal-footer">
                                                  <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                                  <button class="btn btn-danger" type="button"> Submit</button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
							<div class="modal fade modal-dialog-center" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content-wrap">
									   <form class="form-horizontal" role="form">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title">Assign Transporter</h4>
                                              </div>
											 
                                              <div class="modal-body">
												<div class="">
												  <div class="form-group">
													 
													  <div class="col-md-12">

														  <select class="js-example-basic-single ">
														<option value="0">Select Transporter</option>
														<option value="14">Ajanta Transporter</option>
														<option value="61">Transporter 1</option>
														<option value="135">Transporter 2</option>
														<option value="13">Transporter 3</option>
														
													</select>
														  
													  </div>
												  </div>
												  </div>
												</div>
                                              <div class="modal-footer">
                                                  <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                                  <button class="btn btn-danger" type="button"> Submit</button>
                                              </div>
                                          </div>
										  </form>
                                      </div>
                                  </div>
                              </div>

<div class="modal modal-dialog-center fade" id="cancel_model">
            <div class="modal-dialog modal-sm">
              <div class="v-cell">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url();?>index.php/admin/cancel_order" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to Cancel order?</p>
					  <input type="hidden" value='' name='cancel_order_id' id='cancel_order_id'>
					  
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
	  
	  
	  $('.cancel').click(function() {
           $id = $(this).attr("name");
			$('#cancel_order_id').val($id);
        });
  </script>
    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>

