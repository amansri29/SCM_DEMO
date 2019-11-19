 <?php
	 include "includes/header.php";
	 ?>
  <body>

  <section id="container">
      
      <!--sidebar start-->
     <?php
	 include "includes/customer_sidebar.php";
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                
                  <div class="col-lg-12">
				  <h3 class="left">Orders</h3>
					<a href='<?php echo base_url();?>index.php/customer/create_order' class="btn btn-danger right">New Order</a>
                      <div class="row">
                         
                          <div class="col-lg-12">
                              <!--widget start-->
                              <section class="panel">
                                  <header class="panel-heading tab-bg-dark-navy-blue">
                                      <ul class="nav nav-tabs nav-justified ">
                                          <li class="active">
                                              <a href="#orders" data-toggle="tab">
                                                  Inprocess
                                              </a>
                                          </li>
                                          <li>
                                              <a href="#delivered" data-toggle="tab">
                                                  Delivered
                                              </a>
                                          </li>
                                          
                                      </ul>
                                  </header>
                                  <div class="panel-body">
                                      <div class="tab-content tasi-tab">
                                          <div class="tab-pane active" id="orders">
                                             <div class="adv-table">
											  <table  class="display table table-bordered table-striped" id="dynamic-table1">
											  <thead>
												<tr>
													<th class="width-100">Order ID</th>
													<th class="width-100">Item Code</th>
													<th class="width-200">Description</th>
													<th class="width-50">Quantity</th>
													<th class="width-100">Delivery Date</th>
													<th class="width-150">Status</th>
													<th class="width-200">Action</th>
												</tr>
											  </thead>
											  <tbody>
													<?php
													foreach($inprocess as $value)
													{
														/* print_r($value); */
														$items = explode(',', $value['item_code']);
														$descriptions = explode(',', $value['description']);
														$quantity = explode(',', $value['qty_to_ship']);
														$route = explode(',', $value['route']);
														$planned_delivery_date = explode(',', $value['planned_delivery_date']);
													
												  ?>
												  <tr>
														<td><a href='<?php echo base_url();?>index.php/customer/order_view?id=<?php echo $value['order_id'];?>'><?php echo $value['order_id'];?></td>
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
														 
														<td><?php echo $value['delivery_date'];?></td>
														  
														<?php if($value['shipping_status']=='Dispatched') { ?>
														  <td class=''><a class='btn btn-success width-200'><?php echo $value['shipping_status']?></button></td>
														  <?php }  else { ?>
														  <td class=''><a class='btn btn-primary width-200'><?php echo "Awaiting For Dispatch"?></button></td>
														  <?php }?>
													 
														<td>
															<a class="btn btn-primary" data-tooltip="top" title="View Details" href="<?php echo base_url();?>index.php/customer/order_view?id=<?php echo $value['order_id'];?>" type="button"><i class="fa fa-eye"></i></a>
															<!--<a class="btn btn-danger" data-tooltip="top" title="Track Orders" href="#" type="button"><i class="fa fa-map-marker"></i></a>-->
														</td>
												  </tr>
												  <?php
													}
													?>
											  </tbody>
											  <tfoot>
													<th class="width-100">Order ID</th>
													<th class="width-100">Item Code</th>
													<th class="width-200">Description</th>
													<th class="width-50">Quantity</th>
													<th class="width-100">Delivery Date</th>
													<th class="width-150">Status</th>
													<th class="width-200">Action</th>									
											</tfoot>
											  </table>
											  </div>
                                          </div>
                                          <div class="tab-pane" id="delivered">
                                              <div class="adv-table">
											  <table  class="display table table-bordered table-striped" id="dynamic-table2">
											  <thead>
												<tr>
													<th class="width-100">Order ID</th>
													<th class="width-100">Item Code</th>
													<th class="width-200">Description</th>
													<th class="width-50">Quantity</th>
													<th class="width-100">Delivery Date</th>
													<th class="width-150">Status</th>
													<th class="width-200">Action</th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												foreach($delivered as $value)
												{
													$items = explode(',', $value['item_code']);
													$descriptions = explode(',', $value['description']);
													$quantity = explode(',', $value['qty_to_ship']);
													$route = explode(',', $value['route']);
													$delivery_date = explode(',', $value['delivery_date']);
												
												?>
											  <tr>
												<td><a href='<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $value['order_id'];?>'><?php echo $value['order_id'];?></a></td>
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
												<td><?php echo $value['delivery_date'];?></td>
												<td>
												<?php echo $value['shipping_status'];?>
												</td>
												<td>
													<a class="btn btn-primary" href="<?php echo base_url();?>index.php/customer/order_view?id=<?php echo $value['order_id'];?>" type="button"> View Details</a>
												</td>
											  </tr>
											  <?php
												}
												?>
											  
											  </tbody>
											  <tfoot>
												<th class="width-100">Order ID</th>
												<th class="width-100">Item Code</th>
												<th class="width-200">Description</th>
												<th class="width-50">Quantity</th>
												<th class="width-100">Delivery Date</th>
												<th class="width-150">Status</th>
												<th class="width-200">Action</th>
											  </tfoot>
											  </table>
											  </div>
                                          </div>
                                          
                                      </div>
                                  </div>
                              </section>
                              <!--widget end-->

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
	$(document).ready(function(){
	$("#dynamic-table1").dataTable();
	$("#dynamic-table2").dataTable();
	});
</script>
    <!-- js placed at the end of the document so the pages load faster -->
   


  </body>
</html>
