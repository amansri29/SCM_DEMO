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
						<h3 class="left">Open Orders</h3>
						
					</div>
					<div class="col-md-12">
                      <section class="panel">
                          <div class="panel-body">
							<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
										  <tr>
											<th class="width-200">Order ID</th>
											<th class="width-100">Item Code</th>
											<th class="width-220">Description</th>
											<th class="width-100">Quantity</th>
											<th class="width-220">Route</th>
											<th class="width-120">Client Name</th>
											<th class="width-150">Dispatch Date</th>
											<th class="width-120">Time Left</th>
											<th class="width-100">Action</th>
										  </tr>
										</thead>
										<tbody>
										<?php
										 
										
										  
										   foreach( $get_open_orders as $value ) {
											   $this->db->select('*');
											$this->db->from('dbo.settings');
											$q1 = $this->db->get()->row();
											$bid_hours = $q1->bidding_hours;
											
										
											$posting_date=$value['delivery_date'];
											$time = "00:00:00";
											$acutal_date = $posting_date." ".$time;
											if($bid_hours<0)
										{
											$hours=(-$bid_hours);
											
										  $newdate = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
										
										}
										else{
											
											
											/* echo $acutal_date;  */
										$newdate = strtotime ( '-'.$bid_hours.' hour' , strtotime ($acutal_date ) ) ;
										
										$newdate = date ( 'Y-m-d H:i:s' , $newdate );
										}
										$current_date = date("Y-m-d H:i:s");
										if(strtotime($current_date) >= strtotime($newdate))
                                    		{
											}
											else{
												
											$items = explode(',', $value['item_code']);
											$descriptions = explode(',', $value['description']);
											$quantity = explode(',', $value['qty_to_ship']);
											$route = explode(',', $value['route']);
											$planned_delivery_date = explode(',', $value['planned_delivery_date']);
											
										 ?>
										   <tr>
											  <td><a href="<?php echo base_url();?>index.php/admin/order_overview?id=<?php echo $value['order_id'];?>" class="message-img"><span><?php echo $value['order_id'];?></span></a></td>
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
												 <td><?php echo $value['cust_name']?></td>
								                 <td><?php echo $value['delivery_date']?></td>
														 <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time left for Bidding <br>
										  <h4><strong >[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4> </td>
										  <td>
											<a href="<?php echo base_url();?>index.php/admin/order_overview?id=<?php echo $value['order_id']?>" class="btn btn-primary btn-xs right "><i class="fa fa-eye"></i></a>
										  </td>
										  </tr>
										 <?php
										   }
										   }
										   ?>
										 
										</tbody>
										<tfoot>
											<th>Order ID</th>
											<th>Item Code</th>
											<th>Description</th>
											<th>Quantity</th>
											<th>Root</th>
											<th>Client Name</th>
											<th>Dispatch Date</th>
											<th>Time Left</th>
											<th>Action</th>
										</tfoot>
										</table>
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
 <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.countdown.min.js"></script>
	
	 <script>
		 $(function(){
			  
			$('.countdown').each(function(){
				$a=$(this).attr('value');
				//alert($a);
				$(this).countdown($(this).attr('value'), function(event) {
				$(this).text(
				event.strftime('%D %H:%M:%S')
			  );
				});
			});
		});
     </script>

    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>

