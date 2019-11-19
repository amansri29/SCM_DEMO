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
	include "includes/transporter_sidebar.php";
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                
                  <div class="col-lg-12">
				  <h3 class="left">Today's Dispatches</h3>
					
                      <div class="row">
                         
                          <div class="col-lg-12">
                              <!--widget start-->
							<section class="panel">
							<div class="panel-body">
								<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
										  <tr>
											<th class="width-120">Delivery Date</th>
											<th class="width-90">Order ID</th>
											<th class="width-50">SC</th>
											<th class="width-50">Item Code</th>
											<th class="width-200">Description</th>
											<th class="width-150">Route</th>
											<th class="width-200">Planned date</th>
											<th class="width-200">Quantity to ship</th>
											<th class="width-100">Status</th>
											<th class="width-180">Action</th>
										  </tr>
										</thead>
										<tbody>
										  
										 <?php
										  foreach ($data as $get)
									{
								  $qty_to_ship = explode(',', $get['qty_to_ship']);
								  $item_code = explode(',', $get['item_code']);
								  $description = explode(',', $get['description']);
								    $planned_delivery_date = explode(',', $get['planned_delivery_date']);
								  $route = explode(',', $get['route']);
									  if(array_fill(0,count($qty_to_ship),'0') === array_values($qty_to_ship)){
  
										 }
										 else{
							   ?>
										  <tr>
											 <td> <?php echo date('d-m-Y',strtotime($get['delivery_date'])) ?></td>
                                  <td><strong><a href='<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $get['order_id']?>'><?php echo $get['order_id']?></a></strong><br>
								  <?php echo $get['company']?>
								  </td>
											    <td><?php echo $get['state_code'];?></td>
									     
											  <td><?php
                                           foreach($qty_to_ship as $qty_key => $qty) {
                                         if ($qty > '0' || $posting_date)
										 {
					                      if (array_key_exists($qty_key, $item_code)) {
                                                print($item_code[$qty_key].'<br>');   
										 }}}
								    ?></td>
											  <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                         if ($qty > '0' || $posting_date)
										 {
					                      if (array_key_exists($qty_key, $description)) {
                                                print($description[$qty_key].'<br>');   
										 }}} ?> </td>
											  <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                         if ($qty > '0' || $posting_date)
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
									<?php if($get['sales_status']=='Reopened') { ?>
									 <td class=''><a class='btn btn-danger blink-one width-150'><?php echo $get['sales_status']?> </button></td>
									<?php } else if($get['sales_status']=='Released') { ?>
											  <?php if($get['shipping_status']=='Awaiting For Arrival') { ?>
											  <td class=''><a class='btn btn-primary width-150'><?php echo $get['shipping_status']?></button></td>
											  <?php }  else if($get['shipping_status']=='Gate In') { ?>
											  <td class=''><a class='btn btn-info width-150'><?php echo $get['shipping_status']?></button></td>
											  <?php }else if($get['shipping_status']=='Tare Weight (Weighbridge)') { ?>
											  <td class=''><a class='btn btn-warning width-150'><?php echo 'Weigh In'?></button></td>
											  <?php } else if($get['shipping_status']=='Loading') { ?>
											  <td class='left'><a class='btn btn-danger width-150'>Loading In</button></td>
											  <?php } else if($get['shipping_status']=='Loading Out') { ?>
											  <td class='left'><a class='btn btn-danger width-150'><?php echo $get['shipping_status']?></button></td>
											  <?php }  else if($get['shipping_status']=='Gross Weight (Weighbridge)') { ?>
											  <td class=''><a class='btn btn-warning width-150'><?php echo 'Weigh Out'?></button></td>
											  <?php }  else if($get['shipping_status']=='Dispatched') { ?>
											  <td class=''><a class='btn btn-success width-150'><?php echo $get['shipping_status']?></button></td>
											  <?php }  else if($get['shipping_status']=='Delivered') { ?>
											  <td class=''><a class='btn btn-success width-150'><?php echo $get['shipping_status']?></button></td>
											 <?php }  else if($get['shipping_status']=='Not Approved') { ?>
											  <td class='left'><a class='btn btn-danger width-150'><?php echo $get['shipping_status']?></button></td>
												<?php }  else if($get['shipping_status']=='Awaiting For Approvel') { ?>
											  <td class='left'><a class='btn btn-danger width-165'><?php echo $get['shipping_status']?></button></td>
												 <?php }  ?>
											  <td> <a class='btn btn-primary btn-sm ' href='<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $get['order_id'];?>'><i class="fa fa-eye"></i></a>
											  <a class='btn btn-danger btn-sm ' href='<?php echo base_url();?>admin/track_now' >  <i class="fa fa-map-marker" style="padding:0 3px;"> </i> </a>
											  <!--<a class='btn btn-warning btn-sm' data-tooltip="top" title="Download Voucher" href="<?php echo base_url();?>admin/invoice"><i class="fa fa-download"></i></a>-->
											 <button data-content="Awarded From Bid" data-placement="left" data-trigger="hover" class="btn btn-success right popovers btn-round"><i class="fa fa-legal"></i></button>
											  </td>
									<?php } ?>
										  </tr>
										 
									<?php } } ?>
										  
										</tbody>
										<tfoot>
										
											<th>Delivery Date</th>
											<th>Order ID</th>
											<th class="width-50">SC</th>
									   
											<th>Item Code</th>
											<th>Description</th>
											<th>Route</th>
											<th>Planned date</th>
											<th>Quantity to ship</th>
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



      <!--footer start-->
       <?php
	 include "includes/footer.php";
	 ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>

