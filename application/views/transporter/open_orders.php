  <?php
	 include "includes/header.php";
	 ?>

  <body>

  <section id="container" class="">
      <!--header start-->
     
      <!--header end-->
      <!--sidebar start-->
        <?php
	 include "includes/transporter_sidebar.php";
	 $user_id = $this->session->userdata['user_id'];
	 $global_id = $this->session->userdata('global_id');
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
											<th class="width-100">Order ID</th>
											<th class="width-80">Item Code</th>
											<th class="width-130">Description</th>
											<th class="width-60">Quantity</th>
											<th class="width-150">Route</th>
											<th class="width-120">Dispatch Date</th>
											<th class="width-120">bidding Time Left</th>
											<th class="width-200">Action</th>
										  </tr>
										</thead>
										<tbody>
										<?php
											$this->db->select('*');
											$this->db->from('dbo.settings');
											$q1 = $this->db->get()->row();
											$bid_hours = $q1->bidding_hours;
											/* print($bid_hours); */
											
										  $this->db->select('sdo.*,sdo.order_id as order_id,ar.reason as reason,sdo.trans_no as trans_no');
										  $this->db->from('dbo.sales_dispatched_order as sdo');
										  $this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
										  $this->db->where('sdo.trans_no', '' );
										  $this->db->where('sdo.status', 'Released' );
										   $this->db->like('sdo.cust_no', 'c', 'after');
										  $query = $this->db->get();
										  $row = $query->result_array();
										 /*  print_r($row);  */
										  foreach( $row as $value ) {
										
											$this->db->select('*');
											$this->db->from('dbo.bidding_orders');
											$this->db->where('global_id', $global_id );
											$this->db->where('order_id', $value['order_id']);
											$bid = $this->db->get();
											
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
											//$newdate = date("Y-m-d H:i:s", strtotime('-'.$bid_hours.' hours', strtotime($acutal_date)));
											$current_date = date("Y-m-d H:i:s");
											/* print($current_date);  
											print($newdate);  
											 echo 'out'; */
											if(strtotime($current_date) >= strtotime($newdate))
											{
												
												
												$k= $this->db->query("SELECT transporter_no,global_id FROM dbo.bidding_orders WHERE bid_amount = (SELECT MIN(bid_amount) FROM dbo.bidding_orders WHERE order_id = '".$value['order_id']."' )");
												$sql1 = $k->row();
												//echo $k; 
												
												if(!empty($sql1))
												{
													$this->db->select('order_id,cust_no');
													$this->db->from('dbo.sales_dispatched_order');
													$this->db->where('order_id', $value['order_id'] );
													$query = $this->db->get();
													$rows = $query->row();
													
													$insert=array(
														'order_id' => $rows->order_id,
														'trans_no' => $sql1->transporter_no,
														'global_id' => $sql1->global_id,   
														'cust_no' => $rows->cust_no,   
														'vehicle_id' => '',
														'driver_id' => '',
														'shipping_status' => 'Pending',
														'order_status' => 'Pending',
														'time' => '',
														'lr_rr_file' => '',
														'eway_no' => '',
														'lr_rr_no' => '',
														'lr_rr_date' => '',
														'eway_file' => '',
														'gps_enabled' => '',
														'qr_code' => '',
														'qr_status' => '',
														'insurance_no' => '',
														'order_created_status' => 'Bid',
															 
													);
												     
													 /*print_r($value);
													die; */
													$query = $this->db->insert('dbo.order_details',$insert);
													if(! $query)
													{
														echo 'error';
													}
													else
													{
														
														$values=array(
															'trans_no' => $sql1->transporter_no, 
														);
														$this->db->where('order_id',$value['order_id']);
														$sql = $this->db->update('dbo.sales_dispatched_order',$values);
														if(!$sql)
														{
													
														}
															//$this->db->where('order_id', $value['order_id']);
														  //  $this->db->delete('dbo.bidding_orders');
													}
												}
												else{
													/****attn required****/
														$this->db->select('*');
														   $this->db->from('dbo.attn_required');
															$this->db->where('order_id', $value['order_id']);
															 $this->db->where('reason', 'No Bidding placed');
																$res= $this->db->get()->result_array(); 
																foreach($res as $get_data)
																{
																	$id=$get_data['id'];
																	$customer_no=$get_data['customer_no'];
																	$order_id=$get_data['order_id'];
																	$transporter_no=$get_data['transporter_no'];
																	$delivery_date=$get_data['delivery_date'];
																	$reason=$get_data['reason'];
																}
																if($order_id==$value['order_id'])
																{
															$update=array(
															'order_id' => $order_id,
															'customer_no' => $customer_no,
															'transporter_no' => $transporter_no,
															'reason' => $reason,
															'delivery_date' => $delivery_date,
															);
															
															 $this->db->where('order_id', $order_id);
															 $this->db->where('reason', 'No Bidding placed');
														   $data=$this->db->update('dbo.attn_required', $update);
																}
																else{
																	$save=array(
															'order_id' => $value['order_id'],
															'global_id' => '',
															'customer_no' => $value['cust_no'],
															'transporter_no' => '', 
															'delivery_date' => $value['delivery_date'], 
															'reason' => 'No Bidding placed',
															);
														   $data=$this->db->insert('dbo.attn_required', $save);
														   $this->load->model('notification_save');
						                                   $sender='transporter';
										                   $receiver='admin';
										                   $result = $this->notification_save->save_notification_all($order_id,'no_bidding_place',$sender,$receiver);
														}
												}
											}
											else{
											
											$items = explode(',', $value['item_code']);
											$descriptions = explode(',', $value['description']);
											$quantity = explode(',', $value['qty_to_ship']);
											$route = explode(',', $value['route']);
											$posting_date = $value['delivery_date'];
											$attn_reason = $value['reason'];
										
											$arr = explode(' ',trim($attn_reason));
											$reject= $arr[0];
											
											if($reject!='No')
										    {
											
										?>
										  <tr>
											  <td><a href="<?php echo base_url();?>index.php/transporter/order_overview?id=<?php echo $value['order_id'];?>" class="message-img"><img class="avatar" src="<?php echo base_url();?>images/cargoprojectbydefaultpic.jpg" alt=""><span><?php echo $value['order_id'];?></span></a></td>
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
											 
											   <td><?php echo $value['delivery_date'] ?></td>
											
								        <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>
								       <h4><strong >[<span class='countdown' value='<?php echo $newdate ?>'></span>]</strong></h4> </td>
                                 

											  <td><?php
												if($bid->num_rows() > 0)
												{
													if(strtotime($current_date) >= strtotime($newdate))
											         {
												?>
													  <a class='btn btn-danger blink-one width-180'>Awating for Acceptance </button>
												<?php
												    }  else
														{ ?>
												             <a href="<?php echo base_url();?>index.php/transporter/order_overview?id=<?php echo $value['order_id']?>" class="btn btn-success width-80">Edit Bid</a>
												<?php }
												}
												else
												{
												?>
													<a href="<?php echo base_url();?>index.php/transporter/order_overview?id=<?php echo $value['order_id']?>" class="btn btn-danger width-80">Bid Now</a>
												<?php
												}

												?>
												
											<!-- <a href="<?php echo base_url();?>index.php/transporter/order_overview?id=<?php echo $value['order_id']?>" class="btn btn-primary">More Details</a>
											  </td>-->
										  </tr>
										<?php
										  }
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
											<th>Delivery Date</th>
											<th>bidding Time Left</th>
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
  </body>
</html>

