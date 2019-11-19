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
   <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
	
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
		  <?php

if(($this->session->flashdata('item'))) {

  $message = $this->session->flashdata('item');

  ?>
              <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
              <?php

} ?>
              <!-- page start-->
				<div class="row state-overview">
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="fa fa-user"></i>
                          </div>
                          <div class="value">
							<span>Today's</span>
                              <h1 class="count">
                                  <?php echo count($dispatch_planned) ;?>
                              </h1>
                              <p>Dispatch Planned</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                              <i class="fa fa-truck"></i>
                          </div>
                          <div class="value">
							<span>Today's</span>
                              <h1 class="count2">
                                   <?php echo count($vehicle_confirmed) ;?>/
								   <?php
                                    $a=count($dispatch_planned)-count($vehicle_confirmed);
 

								   echo $a;
								
								   
								   
								   ?>
                              </h1>
                              <p>Vehicle Status</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="fa fa-legal"></i>
                          </div>
                          <div class="value">
							<span>Today's</span>
                              <h1 class=" count3">
                                   <?php echo count($vehicle_arrived) ;?>
                              </h1>
                              <p>Vehicles Arrived</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="fa fa-shopping-cart"></i>
                          </div>
                          <div class="value">
							<span>Today's</span>
                              <h1 class=" count4">
                                  <?php echo count($vehicle_dispatched) ;?>
                              </h1>
                              <p>Vehicles Dispatched</p>
                          </div>
                      </section>
                  </div>
              </div>
			  
			  <marquee behavior="scroll" direction="left"><img src="<?php echo base_url();?>images/premium.png" height="60" width="55">
			 	 <div class="top-left" style="position: absolute;top: 10px; left: 70px;"><h4 style="color: black">This icon repersents, the order belongs to our premium customers. Please make sure the Driver carry the smart mobile and have Golcha SCM Driver App installed.</h4></div></marquee>
			 	 
			 <div class="row">
			 <div class="col-lg-12">
					<section class="panel">
						<div class="panel-body">
							<div class="task-progress">
                                  <h1>Today's Dispatch</h1>
								  <p>Track Now</p>
                            </div>
							<div class="adv-table">
							<table  class="display table table-bordered table-striped personal-task" id="dynamic-table1">
								<thead>
									<tr>
										<th class="width-80"></th>
										<th class="width-120">Dispatch Date</th>
										<th class="width-80">Order ID</th>
										<th class="width-150">Item Code</th>
										<!-- <th class="width-50">SC</th> -->
										<th class="width-250">Description</th>
										<th class="width-200">Quantity</th>
										<th class="width-200">Route</th>
										<th class="width-250">Status</th>
									</tr>
									
								</thead>
                              <tbody>
							  <?php
								
								  
								foreach( $data as $value ) 
								{
									$posting_date=$value['delivery_date'];
									$items = explode(',', $value['item_code']);
									$descriptions = explode(',', $value['description']);
									$quantity = explode(',', $value['qty_to_ship']);
									$route = explode(',', $value['route']);
									$order_status = $value['order_status'];
									{
										  if(array_fill(0,count($quantity),'0') === array_values($quantity)){
  
										 }
										 else{
							  ?>
                              <tr>
                              	<?php
                                    $base_url = base_url();
                                    // print( $base_url);
                                    
                                       if($value['T10Status'] =='Yes')
                                       {
                                         echo '<td> <img src="' . $base_url . 'images/premium.png" height="70" width="65"> </td>';
                                          // echo '<td></td>';
                                       }
                                       else
                                       {
                                          echo '<td></td>';
                                       }
                                    
                                    ?>
								 <td> <?php echo date('d-m-Y',strtotime($value['delivery_date'])) ?></td>
                                  <td><strong><a href='<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $value['order_id']?>'><?php echo $value['order_id']?></a></strong><br>
								  <?php echo $value['company']?>
								  </td>
								  <td><?php foreach($quantity as $qty_key => $qty) {
									 if ($qty > '0' || $posting_date)
									 {
									  if (array_key_exists($qty_key, $items)) {
											print($items[$qty_key].'<br>');   
									 }}}?></td>
									  <!-- <td><?php echo $value['state_code'];?></td> -->
									 
								  <td><?php foreach($quantity as $qty_key => $qty) {
									 if ($qty > '0' || $posting_date)
									 {
									  if (array_key_exists($qty_key, $descriptions)) {
											print($descriptions[$qty_key].'<br>');   
									 }}}?></td>
								  <td><?php foreach($quantity as $qty_key => $qty) {
									 if ($qty > '0' || $posting_date)
									 {
									  if (array_key_exists($qty_key, $quantity)) {
											print($quantity[$qty_key].'<br>');   
									 }}}?></td>
								  <td><?php foreach($quantity as $qty_key => $qty) {
									 if ($qty > '0'|| $posting_date)
									 {
									  if (array_key_exists($qty_key, $route)) {
											print($route[$qty_key].'<br>');   
									 }}}?></td>
									  <?php if($value['sales_status']=='Reopened') { ?>
									 <td class=''><a class='btn btn-danger blink-one width-150'><?php echo $value['sales_status']?> </button></td>
									<?php } else if($value['sales_status']=='Released') { ?>
								  <?php if($value['shipping_status']=='Awaiting For Arrival') { ?>
								  <td class='left'><a class='btn btn-primary width-150'><?php echo $value['shipping_status']?></button></td>
                                  <?php }  else if($value['shipping_status']=='Gate In') { ?>
								  <td class='left'><a class='btn btn-info width-150'><?php echo $value['shipping_status']?></button></td>
                                  <?php }else if($value['shipping_status']=='Tare Weight (Weighbridge)') { ?>
								  <td class='left'><a class='btn btn-warning width-150'><?php echo 'Tare Weight'?></button></td>
                                  <?php } else if($value['shipping_status']=='Loading') { ?>
								  <td class='left'><a class='btn btn-danger width-150'>Loading In</button></td>
								  <?php } else if($value['shipping_status']=='Loading Out') { ?>
								  <td class='left'><a class='btn btn-danger width-150'><?php echo $value['shipping_status']?></button></td>
                                  <?php }  else if($value['shipping_status']=='Gross Weight (Weighbridge)') { ?>
								  <td class='left'><a class='btn btn-warning width-150'><?php echo 'Gross Weight'?></button></td>
                                  <?php }  else if($value['shipping_status']=='Dispatched') { ?>
								  <td class='left'><a class='btn btn-success width-150'><?php echo $value['shipping_status']?>
								   <?php }  else if($value['shipping_status']=='Delivered') { ?>
								  <td class='left'><a class='btn btn-success width-150'><?php echo $value['shipping_status']?></button></td>
                                  <?php }  else if($value['shipping_status']=='Not Approved') { ?>
											  <td class='left'><a class='btn btn-danger width-150'><?php echo $value['shipping_status']?></button></td>
												<?php }  else if($value['shipping_status']=='Awaiting For Approvel') { ?>
											  <td class='left'><a class='btn btn-danger width-165'><?php echo $value['shipping_status']?></button></td>
									<?php } }  ?>
								  
								 
                              </tr>
							  <?php
									}}
								}
								?>
                              
                              </tbody>
                          </table>
						  </div>
						  <div class="task-progress col-md-12 allview">
                              <div class="row"> 
								  <a class="btn btn-primary" href="<?php echo base_url();?>index.php/transporter/todays_dispatch">View All</a>
                            </div>
                            </div>
						</div>
					</section>
				</div>
				
				<div class="col-lg-12">
					<section class="panel">
						<div class="panel-body">
							<div class="task-progress">
                                  <h1>Your Bidding Status</h1>
								  <p>Check Your Latest bids</p>
                            </div>
							<div class="adv-table">
							<table  class="display table table-bordered table-striped personal-task" id="dynamic-table2">
								<thead>
									<tr>
										<th class="width-80">Order ID</th>
										<th class="width-100">Item Code</th>
										<th class="width-50">SC</th>
										<th class="width-250">Description</th>
										<th class="width-80">Quantity</th>
										<th class="width-200">Route</th>
										<th class="width-100">My Bid</th>
										<th class="width-100">Lowest Bid</th>
										<th class="width-160">Time Left for bidding</th>
										<th class="width-240 text-center">Action</th>
									</tr>
									
								</thead>
                              <tbody>
							 
                               <?php
							  
							  // print_r($open_orders);
									/* $this->db->select('*');
									$this->db->from('dbo.settings');
									$q1 = $this->db->get()->row(); */
									/* print_r($q1); */
								  foreach($open_orders as $value ) {
									   
									  
										$this->db->select('*');
										$this->db->from('dbo.bidding_orders');
										$this->db->where('transporter_no', $user_id );
										$this->db->where('global_id', $global_id );
										$this->db->where('order_id', $value['order_id']);
										$sql = $this->db->get()->row();
										
										if(!empty($sql))
						                 {
											
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
											//$newdate = date("Y-m-d H:i:s", strtotime('-'.$bid_hours.' hours', strtotime($acutal_date)));
											$current_date = date("Y-m-d H:i:s");
											//print_r($newdate1);
											if(strtotime($current_date) >= strtotime($newdate))
											{
											
												$k= $this->db->query("SELECT transporter_no,global_id FROM dbo.bidding_orders WHERE bid_amount = (SELECT MIN(bid_amount) FROM dbo.bidding_orders WHERE order_id = '".$value['order_id']."' )");
												$sql1 = $k->row();
												 
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
														//print_r($this->db->error());
														//die;
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
															//print_r($this->db->error());
															//die;
														}
														else{
															        $company=$value['company'];
															       $order_key=$value['order_key'];
															     
																	echo '<script type="text/javascript">
                                                                   $(document).ready(function(){ update_transporter("'.$sql1->transporter_no.'","'.$company.'","'.$order_key.'");
																   })
                                                                    </script>';
														}
															//$this->db->where('order_id', $value['order_id']);
														  //  $this->db->delete('dbo.bidding_orders');
													}
												}
											}
									   $this->db->select('MIN(bid_amount) as lowest_amount, unit');
                                       $this->db->from('dbo.bidding_orders');
                                       $this->db->where('order_id', $value['order_id']);
                                       $this->db->group_by('unit'); 
                                       $q2 = $this->db->get()->row();              
																   
												
											$posting_date = $value['deivery_date'];
											$items = explode(',', $value['item_code']);
											$descriptions = explode(',', $value['description']);
											$quantity = explode(',', $value['qty_to_ship']);
											$route = explode(',', $value['route']);
											$planned_delivery_date = explode(',', $value['planned_delivery_date']);
								?>
									<tr>
										  <td><a href="<?php echo base_url();?>index.php/transporter/order_overview?id=<?php echo $value['order_id'];?>" class="message-img"><?php echo $value['order_id'];?></a></td>
										  <td><?php foreach($quantity as $qty_key => $qty) {
											 if ($qty > '0')
											 {
											  if (array_key_exists($qty_key, $items)) {
													print($items[$qty_key].'<br>');   
											 }}}?></td>
											 <td><?php echo $value['state_code'];?></td>
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
										 
										   <td><strong class="highlight"><?php echo $sql->bid_amount." ".$sql->unit?></strong></td>
										   <td><strong class="highlight"><?php echo $q2->lowest_amount." ".$sql->unit?></strong></td>
										  
											 <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time left for Bidding <br>
								  <h4><strong >[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4> </td>
											
										  <td>
												<a href="<?php echo base_url();?>index.php/transporter/order_overview?id=<?php echo $value['order_id']?>" class="btn btn-success width-80">Edit Bid</a>
											
											<!--	<a href="<?php echo base_url();?>index.php/transporter/order_overview?id=<?php echo $value['order_id']?>" class="btn btn-primary">More Details</a>-->
										  </td>
									</tr>
							 <?php
										}
								  }
								  ?>
                              </tbody>
                          </table>
						  </div>
						  <div class="task-progress col-md-12 allview">
                              <div class="row"> 
                                  
								  <a class="btn btn-primary" href="<?php echo base_url();?>index.php/transporter/open_orders">View All</a>
                            </div>
                            </div>
						</div>
					</section>
				</div>
				
				<div class="col-lg-12">
					<section class="panel">
						<div class="panel-body">
							<div class="task-progress">
                                  <h1>Awarded Orders</h1>
								  <p>Accept order</p>
                            </div>
							<div class="adv-table">
							<table  class="display table table-bordered table-striped personal-task" id="dynamic-table3">
								<thead>
									<tr>
										<th class="width-80"></th>
										<th class="width-100">Dispatch Date</th>

										<th class="width-80">Order ID</th>
										<!-- <th class="width-50">SC</th> -->
										<th class="width-150">Item Code</th>
										<th class="width-200">Description</th>
										<th class="width-100">Quantity</th>
										<th class="width-250">Route</th>
										<th class="width-200">Time Left</th>
										<!--<th class="width-150">Assignment Type</th>-->
										<th class="width-250 text-center">Action</th>
									</tr>
									
								</thead>
                              <tbody>
							  <?php
										 // print_r($awarded_orders);
								//print_r($awarded_orders);
								$current_date = date("Y-m-d H:i:s");
								  foreach( $awarded_orders as $value1 )
								  {
									date_default_timezone_set("Asia/Calcutta");
								
								  /****bid assign order******/
								  if($value1['ocs_status']=='Bid')
								  {
									  if ($value1['order_status']=='Pending' && $value1['ocs_status']=='Bid' )
								      {
										 
										   $this->db->select('*');
	                                       $this->db->from('dbo.settings');
										   $data1= $this->db->get()->result_array(); 
										 
										$time = "00:00:00";
										foreach($data1 as $get1)
										{
											
											$bid_hours=$get1['assign_bidding_hours'];
											$assign_bidding_hours_second=$get1['assign_bidding_hours_second'];
											//echo $bid_hours;
										}
										
										$delivery_date=$value1['delivery_date'];
										$acutal_date = $delivery_date." ".$time;
                                         if($bid_hours<0)
										{
										$hours=(-$bid_hours);
										//echo $hours;
										$bid_newdate = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
										
										}
										else{
											
										$bid_newdate = strtotime ( '-'.$bid_hours.' hour' , strtotime ($acutal_date ) ) ;
										
										$bid_newdate = date ( 'Y-m-d H:i:s' , $bid_newdate );
										}
										if($assign_bidding_hours_second<0)
										{
										$hours=(-$assign_bidding_hours_second);
										//echo $hours;
										$bid_newdate_second = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
										
										}
										else{
											
										$bid_newdate1 = strtotime ( '-'.$assign_bidding_hours_second.' hour' , strtotime ($acutal_date ) ) ;
										
										$bid_newdate_second = date ( 'Y-m-d H:i:s' , $bid_newdate1 );
										}
										
								  }
								      $this->db->select('*');
	                                  $this->db->from('dbo.attn_required');
								      $this->db->where('order_id', $value1['order_id']);
									  $result= $this->db->get()->result_array();
									 //print_r( $value1['order_id']);
									       $current_date = date("Y-m-d H:i:s");
											if((strtotime($current_date) >= strtotime($bid_newdate)) OR $result)
											{
												//echo 'sfsdfsd';
												$k= $this->db->query("SELECT bid_amount,transporter_no,global_id FROM bidding_orders e WHERE 2=(SELECT COUNT(DISTINCT bid_amount) FROM bidding_orders p WHERE e.bid_amount>=p.bid_amount AND e.order_id = '".$value1['order_id']."' )");
												$sql1 = $k->row();
												
												if(!empty($sql1))
												{
													
													$this->db->select('*');
													$this->db->from('dbo.sales_dispatched_order');
													$this->db->where('order_id', $value1['order_id'] );
													$query = $this->db->get();
													$rows = $query->row();
													
													 
													$value=array(
														'order_id' => $rows->order_id,
														'trans_no' => $sql1->transporter_no,
														'global_id' => $sql1->global_id,
														'cust_no' => $rows->cust_no,  
															 
													);
												     
													
													$this->db->where('order_id',$value1['order_id']);
													$query = $this->db->update('dbo.order_details',$value);
													if(! $query)
													{
														print_r($this->db->error());
														die;
													}
													else
													{
														
														$values=array(
															'trans_no' => $sql1->transporter_no, 
														);
														$this->db->where('order_id',$value1['order_id']);
														$sql = $this->db->update('dbo.sales_dispatched_order',$values);
														if(!$sql)
														{
															print_r($this->db->error());
															die;
														}
														else{
															       $company=$value1['company'];
															       $order_key=$value1['order_key'];
															     
																	echo '<script type="text/javascript">
                                                                   $(document).ready(function(){ update_transporter("'.$sql1->transporter_no.'","'.$company.'","'.$order_key.'");})
                                                                    </script>';
																
														}
															 
													}
													if(strtotime($current_date) >= strtotime($bid_newdate_second)){
														
														 /*********rating*******/
													$this->db->select('*');
													$this->db->from('dbo.trans_rating');
													$this->db->where('order_id', $value1['order_id'] );
													$this->db->where('global_id', $value1['global_id'] );
													
													$query = $this->db->get();
													$rating = $query->row();
													if($rating->order_id==$value1['order_id'])
									              	{
													$update=array(
													
													     'order_id' => $rating->order_id,
														 'global_id' => $rating->global_id,
													);
													$this->db->where('order_id', $value1['order_id']);
									               
                                                    $data=$this->db->update('dbo.trans_rating', $update);
													}
													else{
														
														$insert=array(
													
													     'order_id' => $value1['order_id'],
														 'global_id' => $sql1->global_id,
														 'accept_and_assign' => '0',
														
													);
													   $data=$this->db->insert('dbo.trans_rating', $insert);
													} 
													/*****end rating*****/ 
								      $this->db->select('*');
	                                  $this->db->from('dbo.attn_required');
								      $this->db->where('order_id', $value1['order_id']);
									  $this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res= $this->db->get()->result_array(); 
										foreach($res as $get_data)
										{
											$id=$get_data['id'];
											$customer_no=$get_data['customer_no'];
											$order_id=$get_data['order_id'];
											$global_id1=$get_data['global_id'];
											$transporter_no=$get_data['transporter_no'];
											$delivery_date=$get_data['delivery_date'];
											$reason=$get_data['reason'];
										}
										if($order_id==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.attn_required', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $sql1->global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $sql1->transporter_no, 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.attn_required', $save);
                                   $this->load->model('notification_save');
                                   $sender='transporter';
				                   $receiver='admin';
				                   $result = $this->notification_save->save_notification_all($order_id,'order_not_assign',$sender,$receiver);
                                       }
									    /********end attn required****/
								   /********missed orders****/
								    $this->db->select('*');
	                                $this->db->from('dbo.missed_orders');
								    $this->db->where('order_id', $value1['order_id']);
									$this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res1= $this->db->get()->result_array(); 
										foreach($res1 as $get_data1)
										{
											$id=$get_data1['id'];
											$customer_no=$get_data1['customer_no'];
											$order_id1=$get_data1['order_id'];
											$global_id1=$get_data1['global_id'];
											$transporter_no=$get_data1['transporter_no'];
											$delivery_date=$get_data1['delivery_date'];
											$reason=$get_data1['reason'];
										}
										if($order_id1==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id1);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.missed_orders', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $sql1->global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $sql1->transporter_no, 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.missed_orders', $save);
								   
                                       } 
											    $this->db->where('order_id', $value1['order_id']);
											    $this->db->delete('dbo.bidding_orders');
												$this->db->where('order_id', $value1['order_id']);
                                                $this->db->delete('dbo.order_details');
												    }
												}
												 
												else{
													 /*********rating*******/
													 $this->db->select('*');
													$this->db->from('dbo.trans_rating');
													$this->db->where('order_id', $value1['order_id'] );
													$this->db->where('global_id', $value1['global_id'] );
												
													$query = $this->db->get();
													$rating = $query->row();
													if($rating->order_id==$value1['order_id'])
									              	{
													$update=array(
													     'order_id' => $rating->order_id,
														 'global_id' => $rating->global_id,
													);
													$this->db->where('order_id', $value1['order_id']);
									          
                                                    $data=$this->db->update('dbo.trans_rating', $update);
													}
													else{
														
														$insert=array(
													
													     'order_id' => $value1['order_id'],
														 'global_id' => $sql1->global_id,
														 'accept_and_assign' => '0',
														 
													);
													   $data=$this->db->insert('dbo.trans_rating', $insert);
													} 
													/*****end rating*****/ 

													
													/********attn required****/
									  $this->db->select('*');
	                                  $this->db->from('dbo.attn_required');
								      $this->db->where('order_id', $value1['order_id']);
									  $this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res= $this->db->get()->result_array(); 
										foreach($res as $get_data)
										{
											$id=$get_data['id'];
											$customer_no=$get_data['customer_no'];
											$order_id=$get_data['order_id'];
											$global_id1=$get_data['global_id'];
											$transporter_no=$get_data['transporter_no'];
											$delivery_date=$get_data['delivery_date'];
											$reason=$get_data['reason'];
										}
										if($order_id==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.attn_required', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $sql1->global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $sql1->transporter_no, 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.attn_required', $save);
								   $this->db->where('order_id', $order_id);
								   $query1 = $this->db->delete('dbo.order_details');

								   $this->load->model('notification_save');
                                   $sender='transporter';
				                   $receiver='admin';
				                   $result = $this->notification_save->save_notification_all($order_id,'order_not_assign',$sender,$receiver);
                                       }
									    /********end attn required****/
								   /********missed orders****/
								   $this->db->select('*');
	                               $this->db->from('dbo.missed_orders');
								   $this->db->where('order_id', $value1['order_id']);
								   $this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res1= $this->db->get()->result_array(); 
										foreach($res1 as $get_data1)
										{
											$id=$get_data1['id'];
											$customer_no=$get_data1['customer_no'];
											$order_id1=$get_data1['order_id'];
											$global_id1=$get_data1['global_id'];
											$transporter_no=$get_data1['transporter_no'];
											$delivery_date=$get_data1['delivery_date'];
											$reason=$get_data1['reason'];
										}
										if($order_id1==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id1);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.missed_orders', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $sql1->global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $sql1->transporter_no,
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.missed_orders', $save);
								   
                                       } 
									                $this->db->where('order_id', $value1['order_id']);
		                                            $this->db->delete('dbo.order_details');
													$this->db->where('order_id', $value1['order_id']);
												    $this->db->delete('dbo.bidding_orders');

                                                    $this->db->where('order_id', $value1['order_id']);
                                                    $this->db->where("(reason LIKE 'Rejected%'");
												    $this->db->delete('dbo.attn_required');
											 	    }
											}
											
									
									$items = explode(',', $value1['item_code']);
									$descriptions = explode(',', $value1['description']);
									$quantity = explode(',', $value1['qty_to_ship']);
									$route = explode(',', $value1['route']);
									$order_status = $value1['order_status'];
									$attn_reason = $value1['reason'];
									//print_r($attn_reason);
									/* foreach($quantity as $qty_key => $qty) { */
                                       if(array_fill(0,count($quantity),'0') === array_values($quantity)){


										  
										 }
										 else{
										 
									/*if( $order_status == '' OR $attn_reason!='Rejected by vendor' OR $order_status == 'Pending')
										
									{*/
									$arr = explode(' ',trim($attn_reason));
									$reject= $arr[0];
									
									if($reject!='Not')
										{
									if( $value1['order_status']!='Inprocess')
								  {
								?>
                              <tr>
							 <td> <?php echo date('d-m-Y',strtotime($value1['delivery_date'])) ?></td>
                                  <td><strong><a href='<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $value1['order_id']?>'><?php echo $value1['order_id']?></a></strong><br>
								  <?php echo $value1['company']?>
								  </td>
								    <td><?php echo $value1['state_code'];?></td>
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
									 
								<?php if($value1['order_status']=='') { ?>
								  <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time left for acceptance <br>
								  <h4><strong >[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4> </td>
                                  <?php }  else if($value1['order_status']=='Pending' && $value1['ocs_status']=='Admin' ) { ?>
								  <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time Left for Assign order<br>
								  <h4><strong>[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4>
								  </td>
								  <?php } else if($value1['order_status']=='Pending' && $value1['ocs_status']=='Bid' ) {
                                     if((strtotime($current_date) >= strtotime($bid_newdate)) OR $result)
											{
								          ?>
								  <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time Left for Assign order<br>
								  <h4><strong>[ <span class='countdown' value='<?php echo $bid_newdate_second ?>'></span> ]</strong></h4>
								  </td><?php } else { ?>
								  <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time Left for Assign order<br>
								  <h4><strong>[ <span class='countdown' value='<?php echo $bid_newdate ?>'></span> ]</strong></h4>
								  </td>
                                  <?php }} ?>

								  <!--<td>
									<button data-content="Awarded From Admin" data-placement="left" data-trigger="hover" class="btn btn-primary popovers btn-round"><i class="fa fa-user"></i></button>
								  </td>-->
								   <?php if($value1['sales_status']=='Reopened') { ?>
									 <td class=''><a class='btn btn-danger blink-one width-150'><?php echo $value1['sales_status']?> </button></td>
									<?php } else if($value1['sales_status']=='Released') { ?>
                                   <td>
											  <?php 
												if($order_status == 'Pending')
												{
												?> 
													<a class='btn btn-success btn-sm assign' data-toggle="modal" data-id="<?php echo $value1['order_id'];?>" href="#myModal" name='<?php echo $value1['order_id'];?>'>Assign Order</a>
													<?php if($value1['order_status']=='Pending' && $value1['ocs_status']=='Bid' ) {
                                                      if((strtotime($current_date) >= strtotime($bid_newdate)) OR $result)
											              { } else { ?>
													<a class="btn btn-default reject" type="button" href="#confirmModal1" data-toggle="modal" name='<?php echo $value1['order_id'];?>'> Reject</a>
														  <?php
													}
												}
												}
												else
												{
												?>	
													<a class="btn btn-danger accept" type="button" href="#confirmModal" data-toggle="modal" name='<?php echo $value1['order_id'];?>'> Accept</a>
													<a class="btn btn-default reject" type="button" href="#confirmModal1" data-toggle="modal" name='<?php echo $value1['order_id'];?>'> Reject</a>
													<!--<button class="btn btn-default" type="button">Reject</button>-->
												<?php
												}
												?>
												<button data-content="Awarded From Bid" data-placement="left" data-trigger="hover" class="btn btn-success popovers btn-round"><i class="fa fa-legal"></i></button>
											  
											 </td>
								  <?php }?>
                              </tr>
							  <?php
									}
								  }
								 }
						
								   }
												
									  /****end bid assign order******/ 
								 
									 
								  else{
                                     	
								  if($value1['order_status']=='')
								  {
									 
								       $this->db->select('*');
	                                   $this->db->from('dbo.settings');
										$data= $this->db->get()->result_array(); 
										
										$time = "00:00:00";
										foreach($data as $get1)
										{
											$allowance_hours=$get1['allowance_hours'];
										}
										
										$delivery_date=$value1['delivery_date'];
										$acutal_date = $delivery_date." ".$time;
										if($allowance_hours<0)
										{
											$hours=(-$allowance_hours);
											
										$newdate = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
										
										}
										else{
											
											
											/* echo $acutal_date;  */
										$newdate = strtotime ( '-'.$allowance_hours.' hour' , strtotime ($acutal_date ) ) ;
										
										$newdate = date ( 'Y-m-d H:i:s' , $newdate );
										}
								  }
								  else if ($value1['order_status']=='Pending' && $value1['ocs_status']=='Admin' )
								  {
									 
								       $this->db->select('*');
	                                   $this->db->from('dbo.settings');
										$data= $this->db->get()->result_array();
										
										$time = "00:00:00";
										foreach($data as $get1)
										{
											$assign_hours=$get1['assign_hours'];
										
										}
										
										$delivery_date=$value1['delivery_date'];
										$acutal_date = $delivery_date." ".$time;
										if($assign_hours<0)
										{
											$hours=(-$assign_hours);
											
										$newdate = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
										
										}
										else{
											
											
											/* echo $acutal_date;  */
										$newdate = strtotime ( '-'.$assign_hours.' hour' , strtotime ($acutal_date ) ) ;
										
										$newdate = date ( 'Y-m-d H:i:s' , $newdate );
										}
								     }								 
                              	   
							     if(strtotime($current_date) >= strtotime($newdate))
								{
									
									//echo $newdate;

								if($value1['order_status']=='')
								  {
									  /********attn required****/
								   $this->db->select('*');
	                               $this->db->from('dbo.attn_required');
								    $this->db->where('order_id', $value1['order_id']);
									 $this->db->where('reason', 'Not accepted in given time frame by vendor');
										$res= $this->db->get()->result_array(); 
										foreach($res as $get_data)
										{
											$id=$get_data['id'];
											$customer_no=$get_data['customer_no'];
											$order_id=$get_data['order_id'];
											$transporter_no=$get_data['transporter_no'];
											$delivery_date=$get_data['delivery_date'];
											$reason=$get_data['reason'];
											$global_id1=$get_data['global_id'];
										}
										if($order_id==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id);
									 $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                     $data=$this->db->update('dbo.attn_required', $update);
								  }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $value1['trans_no'], 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not accepted in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.attn_required', $save);

                                   $this->load->model('notification_save');
                                   $sender='transporter';
				                   $receiver='admin';
				                   $result = $this->notification_save->save_notification_all($order_id,'order_not_accept',$sender,$receiver);
                                   }
								   /********end attn required****/
								   /********missed orders****/
								     $this->db->select('*');
	                               $this->db->from('dbo.missed_orders');
								    $this->db->where('order_id', $value1['order_id']);
									 $this->db->where('reason', 'Not accepted in given time frame by vendor');
										$res1= $this->db->get()->result_array(); 
										foreach($res1 as $get_data1)
										{
											$id=$get_data1['id'];
											$customer_no=$get_data1['customer_no'];
											$order_id1=$get_data1['order_id'];
											$global_id1=$get_data1['global_id'];
											$transporter_no=$get_data1['transporter_no'];
											$delivery_date=$get_data1['delivery_date'];
											$reason=$get_data1['reason'];
										}
										if($order_id1==$value1['order_id'])
										{
											
									$update=array(
									'order_id' => $order_id1,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id1);
									 $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                     $data=$this->db->update('dbo.missed_orders', $update);
								  }
										else{
											
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $value1['trans_no'], 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not accepted in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.missed_orders', $save);
								   
								  
								  }
								   /********end missed orders****/
								  }
								  else if ($value1['order_status']=='Pending' && $value1['ocs_status']=='Admin' )
								  {
									  
									  
									                /*********rating*******/
													$this->db->select('*');
													$this->db->from('dbo.trans_rating');
													$this->db->where('order_id', $value1['order_id'] );
													$this->db->where('global_id', $value1['global_id'] );
													$query = $this->db->get();
													$rating = $query->row();
													if($rating->order_id==$value1['order_id'])
									              	{
													$update=array(
													
													     'order_id' => $rating->order_id,
														 'global_id' => $rating->global_id,
													);
													$this->db->where('order_id', $value1['order_id']);
                                                    $data=$this->db->update('dbo.trans_rating', $update);
													}
													else{
														
														$insert=array(
													
													     'order_id' => $value1['order_id'],
														 'global_id' => $global_id,
														 'accept_and_assign' => '0',
														 
													);
													   $data=$this->db->insert('dbo.trans_rating', $insert);
													} 
													/*****end rating*****/ 
									  /********attn required****/
									$this->db->select('*');
	                                $this->db->from('dbo.attn_required');
								    $this->db->where('order_id', $value1['order_id']);
									$this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res= $this->db->get()->result_array(); 
										foreach($res as $get_data)
										{
											$id=$get_data['id'];
											$customer_no=$get_data['customer_no'];
											$order_id=$get_data['order_id'];
											$global_id1=$get_data['global_id'];
											$transporter_no=$get_data['transporter_no'];
											$delivery_date=$get_data['delivery_date'];
											$reason=$get_data['reason'];
										}
										if($order_id==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.attn_required', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $value1['trans_no'], 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.attn_required', $save);
								   $this->db->where('order_id', $order_id);
								   $query1 = $this->db->delete('dbo.order_details');

								   $this->load->model('notification_save');
                                   $sender='transporter';
				                   $receiver='admin';
				                   $result = $this->notification_save->save_notification_all($order_id,'order_not_assign',$sender,$receiver);
                                       }
									    /********end attn required****/
								   /********missed orders****/
								   $this->db->select('*');
	                               $this->db->from('dbo.missed_orders');
								    $this->db->where('order_id', $value1['order_id']);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res1= $this->db->get()->result_array(); 
										foreach($res1 as $get_data1)
										{
											$id=$get_data1['id'];
											$customer_no=$get_data1['customer_no'];
											$order_id1=$get_data1['order_id'];
											$global_id1=$get_data1['global_id'];
											$transporter_no=$get_data1['transporter_no'];
											$delivery_date=$get_data1['delivery_date'];
											$reason=$get_data1['reason'];
										}
										if($order_id1==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id1);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.missed_orders', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $value1['trans_no'], 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.missed_orders', $save);
                                       }
								  }
								  }
								  else{
								 
									$items = explode(',', $value1['item_code']);
									$descriptions = explode(',', $value1['description']);
									$quantity = explode(',', $value1['qty_to_ship']);
									$route = explode(',', $value1['route']);
									$order_status = $value1['order_status'];
									$attn_reason = $value1['reason'];
									//print_r($attn_reason);
									/* foreach($quantity as $qty_key => $qty) { */
                                       if(array_fill(0,count($quantity),'0') === array_values($quantity)){


										  
										 }
										 else{
										 
									/*if( $order_status == '' OR $attn_reason!='Rejected by vendor' OR $order_status == 'Pending')
										
									{*/
									$arr = explode(' ',trim($attn_reason));
									$reject= $arr[0];
									
									if(!$reject=='Rejected' or !$reject=='Not')
										{
										if( $value1['order_status']!='Inprocess')
								  {
								?>
                              <tr>
                              	<?php
                                    $base_url = base_url();
                                    // print( $base_url);
                                    
                                       if($value1['T10Status'] =='Yes')
                                       {
                                         echo '<td> <img src="' . $base_url . 'images/premium.png" height="70" width="65"> </td>';
                                          // echo '<td></td>';
                                       }
                                       else
                                       {
                                          echo '<td></td>';
                                       }
                                    
                                    ?>
							 	  <td> <?php echo date('d-m-Y',strtotime($value1['delivery_date'])) ?></td>
                                  <td><strong><a href='<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $value1['order_id']?>'><?php echo $value1['order_id']?></a></strong><br>
								  <?php echo $value1['company']?>
								  </td>
								    <!-- <td><?php echo $value1['state_code'];?></td> -->
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
									 
								<?php if($value1['order_status']=='') { ?>
								  <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time left for acceptance <br>
								  <h4><strong >[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4> </td>
                                  <?php }  else if($value1['order_status']=='Pending' && $value1['ocs_status']=='Admin' ) { ?>
								  <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time Left for Assign order<br>
								  <h4><strong>[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4>
								  </td>
								  <?php } else if($value1['order_status']=='Pending' && $value1['ocs_status']=='Bid' ) { ?>
								  <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time Left for Assign order<br>
								  <h4><strong>[ <span class='countdown' value='<?php echo $bid_newdate ?>'></span> ]</strong></h4>
								  </td>
                                  <?php } ?>

								  <!--<td>
									<button data-content="Awarded From Admin" data-placement="left" data-trigger="hover" class="btn btn-primary popovers btn-round"><i class="fa fa-user"></i></button>
								  </td>-->
								   <?php if($value1['sales_status']=='Reopened') { ?>
									 <td class=''><a class='btn btn-danger blink-one width-150'><?php echo $value1['sales_status']?> </button></td>
									<?php } else if($value1['sales_status']=='Released') { ?>
                                   <td>
											  <?php 
												if($order_status == 'Pending')
												{
												?> 
													<a class='btn btn-success btn-sm assign' data-toggle="modal" data-id="<?php echo $value1['order_id'];?>" href="#myModal" name='<?php echo $value1['order_id'];?>'>Assign Order</a>
												<?php
												}
												else
												{
												?>	
													<a class="btn btn-danger accept" type="button" href="#confirmModal" data-toggle="modal" name='<?php echo $value1['order_id'];?>'> Accept</a>
													<a class="btn btn-default reject" type="button" href="#confirmModal1" data-toggle="modal" name='<?php echo $value1['order_id'];?>'> Reject</a>
													<!--<button class="btn btn-default" type="button">Reject</button>-->
												<?php
												}
												?>
												<button data-content="Assigned From Admin" data-placement="left" data-trigger="hover" class="btn btn-info right popovers btn-round"><i class="fa fa-user"></i></button>
											  
											 </td>
								  <?php }?>
                              </tr>
							  <?php
									}
								  }
								  }
								   }
									}
								  }
								
							 ?>
                             
                              </tbody>
                          </table>
						  </div>
						    <div class="task-progress col-md-12 allview">
                              <div class="row"> 
                                  
								  <a class="btn btn-primary" href="<?php echo base_url();?>index.php/transporter/pending_orders">View All</a>
                            </div>
                            </div>
						</div>
					</section>
				</div>
				
				<div class="col-lg-12">
					<section class="panel">
						<div class="panel-body">
							<div class="task-progress">
                                  <h1>Inprocess Orders</h1>
								  <p>Check Your Order Status</p>
                            </div>
							<div class="adv-table">
							<table  class="display table table-bordered table-striped personal-task" id="dynamic-table4">
								<thead>
									<tr>
										<th class="width-80"></th>
										<th class="width-100">Delivery Date</th>
										<th class="width-100">Order ID</th>
										<!-- <th class="width-50">SC</th> -->
										<th class="width-100">Item Code</th>
										<th class="width-100">Description</th>
										<th class="width-50">Quantity</th>
										<th class="width-150">Route</th>
										<th class="width-150">Dispatch Date</th>
										<th class="width-150">Status</th>
										<th class="width-220">Action</th>
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
											 $order_id=$value['order_id'];
											
										?>
										  <tr>
										  	<?php
                                    		$base_url = base_url();
                                      //       print( $base_url);
                                    		// print'('aman'.$get['T10Status']);
		                                    
		                                       if($value['T10Status'] =='Yes')
		                                       {
		                                         echo '<td> <img src="' . $base_url . 'images/premium.png" height="70" width="65"> </td>';
		                                          // echo '<td></td>';
		                                       }
		                                       else
		                                       {
		                                          echo '<td></td>';
		                                       }
		                                    
		                                    ?>
											   <td> <?php echo date('d-m-Y',strtotime($value['delivery_date'])) ?></td>
                                  <td><strong><a href='<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $value['order_id']?>'><?php echo $value['order_id']?></a></strong><br>
								  <?php echo $value['company']?>
								  </td>
											   <!-- <td><?php echo $value['state_code'];?></td> -->
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
												 
												
											  <?php if($value['shipping_status']=='Awaiting For Arrival') { ?>
											  <td class='left'><a class='btn btn-primary width-150'><?php echo $value['shipping_status']?></button></td>
											  <?php }  else if($value['shipping_status']=='Gate In') { ?>
											  <td class='left'><a class='btn btn-info width-150'><?php echo $value['shipping_status']?></button></td>
											  <?php }else if($value['shipping_status']=='Tare Weight (Weighbridge)') { ?>
											  <td class='left'><a class='btn btn-warning width-150'><?php echo 'Weigh In'?></button></td>
											  <?php } else if($value['shipping_status']=='Loading') { ?>
                                              <td class='left'><a class='btn btn-danger width-150'>Loading In</button></td>
											  <?php } else if($value['shipping_status']=='Loading Out') { ?>
											  <td class='left'><a class='btn btn-danger width-150'><?php echo $value['shipping_status']?></button></td>
											  <?php }  else if($value['shipping_status']=='Gross Weight (Weighbridge)') { ?>
											  <td class='left'><a class='btn btn-warning width-150'><?php echo 'Weigh Out'?></button></td>
											  <?php }  else if($value['shipping_status']=='Dispatched') { ?>
											  <td class='left'><a class='btn btn-success width-150'><?php echo $value['shipping_status']?></button></td>
												 <?php }  else if($value['shipping_status']=='Not Approved') { ?>
											  <td class='left'><a class='btn btn-danger width-150'><?php echo $value['shipping_status']?></button></td>
												 <?php }  else if($value['shipping_status']=='Awaiting For Approvel') { ?>
											  <td class='left'><a class='btn btn-danger width-165'><?php echo $value['shipping_status']?></button></td>
												 <?php }  ?>
									<?php if($value['sales_status']=='Reopened') { ?>
									 <td class=''><a class='btn btn-danger blink-one width-150'><?php echo $value['sales_status']?> </button></td>
									<?php } else if($value['sales_status']=='Released') { ?>
											  <td> <a class='btn btn-primary btn-sm ' data-tooltip="top" title="View Details" href="<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $value['order_id'];?>"><i class="fa fa-eye"></i></a>
											  <!--<a class='btn btn-danger btn-sm' data-tooltip="top" title="Track Orders" ><i class="fa fa-map-marker"></i></a>-->
											  <?php
												if($value['gps_enabled']== 'no')
												{
													?>
													<a class='btn btn-default btn-sm' data-tooltip="top" data-toggle="modal" title="Add Location" href='#addModal'><i class="fa fa-location-arrow"></i></a>
													<?php
												}
											  ?>
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
												  <?php if($value['shipping_status']=='Dispatched' ) { ?>
												  <a class='btn btn-info btn-sm delivered' data-tooltip="top" data-toggle="modal" title="order deliveerd" href='#otp' id="<?php echo $value['order_id']?>" name="<?php echo $value['order_id']?>"><i class="fa fa-truck"></i></a>
												  <?php } else {?>
												   <a disabled class='btn btn-info btn-sm delivered' data-tooltip="top" data-toggle="modal" title="order delivered" id="<?php echo $value['order_id']?>" name="<?php echo $value['order_id']?>"><i class="fa fa-truck"></i></a>
												  <?php } ?>
											  <button data-content="Assigned From Admin" data-placement="left" data-trigger="hover" class="btn btn-info right popovers btn-round"><i class="fa fa-user"></i></button>
											  
											 </td>
									<?php } ?>
										  </tr>
										 <?php
										 
											
										  }
										  
								  ?>
                              
                              </tbody>
                          </table>
						  </div>
						   <div class="task-progress col-md-12 allview">
                              <div class="row"> 
                                  
								  <a class="btn btn-primary" href="<?php echo base_url();?>index.php/transporter/inprocess_orders">View All</a>
                            </div>
                            </div>
						</div>
					</section>
				</div>
				
				<div class="col-lg-12">
					<section class="panel">
						<div class="panel-body">
							<div class="task-progress">
                                  <h1>Oders Open for Bid</h1>
								  <p>Check Orders for bid</p>
                            </div>
							<div class="adv-table">
							<table  class="display table table-bordered table-striped personal-task" id="dynamic-table5">
								<thead>
									<tr>
										<th class="width-100">Order ID</th>
										<th class="width-100">Item Code</th>
										<th class="width-200">Description</th>
										<th class="width-100">Quantity</th>
										<th class="width-220">Route</th>
										<th class="width-150">Delivery Date</th>
										<th class="width-120">Time Left</th>
										<th class="width-200">Action</th>
									</tr>
									
								</thead>
                              <tbody>
							  <?php
								date_default_timezone_set("Asia/Calcutta");
								  foreach($open_orders as $value ) {
										$this->db->select('*');
										$this->db->from('dbo.bidding_orders');
										$this->db->where('transporter_no', $user_id );
										$this->db->where('global_id', $global_id );
										$this->db->where('order_id', $value['order_id']);
										$sql = $this->db->get()->row();
										
										if(!empty($sql))
										{
											
										}
										else
										{
											
											$this->db->select('*');
											$this->db->from('dbo.settings');
											$q1 = $this->db->get()->row();
											$bid_hours = $q1->bidding_hours;
											$items = explode(',', $value['item_code']);
											$descriptions = explode(',', $value['description']);
											$quantity = explode(',', $value['qty_to_ship']);
											$route = explode(',', $value['route']);
											$planned_delivery_date = explode(',', $value['planned_delivery_date']);
											$posting_date = $value['delivery_date'];
											$attn_reason = $value['reason'];
											//print_r($posting_date);
											//print_r($bid_hours);
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
											//print_r($newdate1);
											if(strtotime($current_date) >= strtotime($newdate))
											{
												
												$k= $this->db->query("SELECT transporter_no FROM dbo.bidding_orders WHERE bid_amount = (SELECT MIN(bid_amount) FROM dbo.bidding_orders WHERE order_id = '".$value['order_id']."' )");
												$sql1 = $k->row();
												//echo $k; 
												//print_r($sql1); 
												if(!empty($sql1))
												{
													/*$this->db->select('*');
													$this->db->from('dbo.sales_dispatched_order');
													$this->db->where('order_id', $value['order_id'] );
													$query = $this->db->get();
													$rows = $query->row();
													
													 
													$value=array(
														'order_id' => $rows->order_id,
														'trans_no' => $sql1->transporter_no,
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
													/*$query = $this->db->insert('dbo.order_details',$value);
													if(! $query)
													{
														print_r($this->db->error());
														die;
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
															print_r($this->db->error());
															die;
														}
															//$this->db->where('order_id', $value['order_id']);
														  //  $this->db->delete('dbo.bidding_orders');
													}*/
												}
												else{
													//echo 'dasd';
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
											
								
																$arr = explode(' ',trim($attn_reason));
																$reject= $arr[0];
																//print_r($reject);
											if($reject!='No')
										    {
								?>
									<tr>
										  <td><a href="<?php echo base_url();?>index.php/transporter/order_overview?id=<?php echo $value['order_id'];?>" class="message-img"><?php echo $value['order_id'];?></a></td>
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
										 
										   <td><?php foreach($quantity as $qty_key => $qty) {
											 if ($qty > '0')
											 {
											  if (array_key_exists($qty_key, $planned_delivery_date)) {
												  $date = date('d-m-Y',strtotime($planned_delivery_date[$qty_key]));
													print($date.'<br>');   
											 }}}?></td>
											<td style='background-color:#27313b;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time Left for bidding  order<br>
							             	  <h4><strong>[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4>
								  </td>
								          
												
										  <td>
										 
											<a href="<?php echo base_url();?>index.php/transporter/order_overview?id=<?php echo $value['order_id']?>" class="btn btn-danger width-80">Bid Now</a>
											<a href="<?php echo base_url();?>index.php/transporter/order_overview?id=<?php echo $value['order_id']?>" class="btn btn-primary">More Details</a>
										  </td>
									</tr>
							 <?php
										}
								  }
										}
								  }
								  ?>
                              
                              </tbody>
                          </table>
						  </div>
						  <div class="task-progress col-md-12 allview">
                              <div class="row"> 
                                  
								  <a class="btn btn-primary" href="<?php echo base_url();?>index.php/transporter/open_orders">View All</a>
                            </div>
                            </div>
						</div>
					</section>
				</div>
				<div class="col-lg-12">
				
					<section class="panel">
						<div class="panel-body">
							<div class="task-progress">
                                  <h1>Missed orders</h1>
								  <p>Rejected</p>
                            </div>
							<div class="adv-table">
							<table  class="display table table-bordered table-striped personal-task" style='background-color:#CFCAC8' id="dynamic-table6">
						
								<thead>
									<tr>
										<th class="width-100">Dispatch Date</th>
										<th class="width-80">Order ID</th>
										<th class="width-50">SC</th>
								          <th class="width-120">Item Code</th>
										<th class="width-180">Description</th>
										<th class="width-150">Route</th>
										<th class="width-100">Planned date</th>
										<th class="width-100">Qty to ship</th>
										<th class="width-150">Customer Name</th>
										<th class="width-150">Shipment Name</th>
										<th class="width-200">Reason</th>
									</tr>
									
								</thead>
                              <tbody>
                             <?php 
							 // print_r($data); die;
							 
							  foreach ($attn_required as $get)
							  {
								  $qty_to_ship = explode(',', $get['qty_to_ship']);
								  $item_code = explode(',', $get['item_code']);
								  $description = explode(',', $get['description']);
								   $planned_delivery_date = explode(',', $get['planned_delivery_date']);
								  $route = explode(',', $get['route']);
								  /* foreach($qty_to_ship as $qty_key => $qty) {  */
                                          if(array_fill(0,count($qty_to_ship),'0') === array_values($qty_to_ship)){
										  
										 }
										 else{
									//print_r($attn);
							   ?>
                              <tr>
								  <td> <?php echo date('d-m-Y',strtotime($get['delivery_date'])) ?></td>
                                  <td><strong><a href='<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $get['order_id']?>'><?php echo $get['order_id']?></a></strong><br>
								  <?php echo $get['company']?>
								  </td>
								   <td><?php echo $get['state_code'];?></td>
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
										 }}} ?></td>
								  <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                         if ($qty > '0')
										 {
					                      if (array_key_exists($qty_key, $route)) {
                                                print($route[$qty_key].'<br>');   
										 }}} ?></td>
										 <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                          
                                         if ($qty > '0')
										 {
					                      if (array_key_exists($qty_key, $planned_delivery_date)) {
                                                print($planned_delivery_date[$qty_key].'<br>');   
								  }}}?></td>
								  <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                          
                                         if ($qty > '0')
										 {
					                      
                                                print($qty.'<br>');   
								  }}?></td>
								  <td><?php echo $get['cust_name']?></td>
								  <td><?php echo $get['ship_to_name']?></td>
								  <td><?php echo $get['reason']?></td>
                                  
                              </tr>
							  <?php } }
							 ?>
                              </tbody>
                          </table>
						  </div>
						   <div class="task-progress col-md-12 allview">
                              <div class="row"> 
                                  
								  <a class="btn btn-primary" href="<?php echo base_url();?>index.php/transporter/attn_required">View All</a>
                            </div>
                            </div>
						</div>
					</section>
				</div>
			 </div>
				
			

			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="change_model" class="modal fade">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                              <h4 class="modal-title">Change Details</h4>
                                          </div>
                                          <div class="modal-body">

                                               <form action="<?php echo base_url();?>index.php/transporter/chnage_details_order" method="post" class='form-horizontal' enctype="multipart/form-data" >
													<input type="hidden" name="order_id" value='' id='orderIds'>
												<!--	<input type="text" name="order_id" value='<?php echo $_GET['userid'] ?>' id='orderIds'>-->
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
															<input id="yes" value="yes" name="gps_enabled[]" checked="" type="radio">
															<label for="inlineRadio1">Yes</label>
														</div>
														</div>
														<div class="col-md-3">
															<div class="radio radio-info radio-inline">
															<input id="no" value="no" name="gps_enabled[]" type="radio">
															<label for="inlineRadio2">No</label>
														  </div>
														 </div>
													</div>
												
												
													<div class="form-group">
													<label for="lr_rr_date" class="col-lg-3 col-sm-2 control-label">Delivery Date</label>
													<div data-date-viewmode="years" data-date-format="dd-mm-yyyy" class="input-append date dpYears col-lg-4">
															  <input type="text" readonly="" size="5" id="delivery_d" name="delivery_date" class="form-control">
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
                             
			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"  id="myModal" class="modal fade">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                              <h4 class="modal-title">Assign Vehicle & Driver</h4>
                                          </div>
                                          <div class="modal-body">

                                               <form action="<?php echo base_url();?>index.php/transporter/assign_order" method="post" class='form-horizontal' enctype="multipart/form-data" >
													<input type="hidden" name="order_id" value='' id='orderId'>
													<div class="form-group">
													  <label class="col-lg-3 col-sm-2 control-label">Vehicle No.</label>
														<div class="col-lg-8">
															<select class="js-example-basic-single vehicle" id='vehicle' required name='vehicle_id'>
															<option disabled value="0">Select vehicle</option>
																							
															</select>
														</div>
													</div>
													
													<div class="form-group">
														<label for="insurance" class="col-lg-3 col-sm-2 control-label">Insurance</label>
														<div class="col-lg-8">
															<input type="text" class="form-control" disabled readonly id="insurance" name='insurance_no' placeholder="Enter Insurance No">
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
													  <label class="col-lg-3 col-sm-2 control-label">Driver</label>
														<div class="col-lg-8">
															<select class="js-example-basic-single " id='driver' name='driver_id'>
																<option value="0">Select driver</option>
																<?php
															/*$this->db->select('*');
															$this->db->from('dbo.driver');
															$this->db->where('global_id', $global_id );
															$query = $this->db->get();
															$row = $query->result_array();
														
															foreach( $row as $value ) {
														?>
															
																<option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
														<?php
															}*/
														?>	
																
																
															</select>
														</div>
													</div>
													<div class="form-group">
														<label for="mobile" class="col-lg-3 col-sm-2 control-label">Mobile</label>
														<div class="col-lg-8">
															<input type="text" class="form-control" disabled required readonly id="mobile" name='mobile' placeholder="Enter Mobile">
														</div>
													</div>
													<div class="form-group">
														<label for="license" class="col-lg-3 col-sm-2 control-label">License No.</label>
														<div class="col-lg-8">
															<input type="text" class="form-control" id="license" name='license_no' required readonly  disabled placeholder="Enter License No">
														</div>
													</div>
													<div class="form-group">
														<label for="lr_no" class="col-lg-3 col-sm-2 control-label">LR/RR No.</label>
														 <div class="col-lg-4">
															<input type="text" class="form-control" id="lr_no" name='lr_rr_no' placeholder="Enter Number">
														</div> 
														<div class="col-lg-4">
															<input type="file" class="" id="lr" name='lr_rr_file'><br/>
														</div>
													</div>
													<!--<div class="form-group">
														<label for="eway_no" class="col-lg-3 col-sm-2 control-label">Eway No.</label>
														<div class="col-lg-4">
															<input type="text" class="form-control" required id="eway_no" name='eway_no' placeholder="Enter Number">
														</div>
														<div class="col-lg-4">
															<input type="file" class="" id="eway" name="eway_file" ><br/>
														</div>
													</div>-->
													<div class="form-group">
													<label for="lr_rr_date" class="col-lg-3 col-sm-2 control-label">LR/RR Date.</label>
													<div data-date-viewmode="years" data-date-format="dd-mm-yyyy" class="input-append date dpYears col-lg-4">
															  <input type="text" readonly="" size="5" name="lr_rr_date" class="form-control">
															  <span class="input-group-btn add-on">
																<button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
															  </span>
															</div> 
															</div>
													<div class="form-group">
													  <div class="col-lg-offset-5 col-lg-2">
													  <button type="submit" class="btn btn-danger">Assign</button>
													  </div>
													</div>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
          </section>
      </section>
      <!--main content end-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addModal" class="modal fade">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                              <h4 class="modal-title">Add Address</h4>
                                          </div>
                                          <div class="modal-body">

                                              <form role="form" class="form-horizontal">
												<div class="input_fields_wrap">
												<div class="panel panel-default ">
													<div class="panel-body" name="mytext[]">
														<div class="form-group">
														  <label class="col-lg-3 col-sm-2 control-label">Address</label>
															<div class="col-lg-7">
																<input type="text" class="form-control" id="address" placeholder="Enter Address">
															</div>
															<div class="col-lg-1">
																<a class="btn btn-primary btn-sm add_field_button"><i class="fa fa-plus"></i></i></a>
															</div>
														</div>
														<div class="form-group">
														  <label class="col-lg-3 col-sm-2 control-label">Date & Time</label>
															<div class="col-lg-7">
																<input size="16" type="text" value="2012-06-15 14:45" readonly class="form_datetime form-control">
															</div>
															
														</div>
													</div>
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
<div class="modal modal-dialog-center fade" id="confirmModal">
            <div class="modal-dialog modal-sm">
              <div class="v-cell">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url();?>index.php/transporter/accept_order" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to accept order assignment?</p>
					  <input type="hidden" value='' name='order_id' id='order_id'>
					  
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
		  <div class="modal modal-dialog-center fade" id="confirmModal1">
            <div class="modal-dialog modal-sm">
              <div class="v-cell">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url();?>index.php/transporter/reject_order" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to reject order assignment?</p>
					  <input type="hidden" value='' name='order_id' id='order-id'>
					  <div class="form-group">

                                      <div class="col-lg-12">
                                         <select class="js-example-basic-single vehicle" id='reject_reason' required name='reject_reason'>
											<option disabled value="0">Select Reason</option>
											<?php
												$this->db->select('*');
												$this->db->from('dbo.reject_reason');
												$query = $this->db->get();
												$row = $query->result_array();
											
												foreach( $row as $value ) {
											?>
												
													<option value="<?php echo $value['reject_reason']?>"><?php echo $value['reject_reason']?></option>
											<?php
												}
											?>																
										</select>
                                      </div>
									</div>
									
                      <div class="text-center"><br><br>
                      <button type="submit" class="btn btn-success paper-shadow relative">Yes</button>
                      <button type="button" data-dismiss="modal" class="btn btn-danger paper-shadow relative no">No</button>
					  </div>
                    </form>
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
		  
		  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="otp" class="modal fade">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                              <h4 class="modal-title">OTP Verification for delivered order</h4>
                                          </div>
                                          <div class="modal-body" style='margin-top: -64px;'>

                                               <form class="form-signin" style="background-color: #e2e2e2;" enctype="multipart/form-data" method="post"  action="<?php echo base_url(); ?>index.php/transporter/otp_verify">
	                                           <input type="hidden" value='' name='delivered_order_id' id=' '>
        <h2 class="form-signin-heading">Otp Verification</h2></br>
		  <img src="https://cdn2.iconfinder.com/data/icons/luchesa-part-3/128/SMS-512.png" class="img-responsive" style="width:100px; height:100px;margin:0 auto;">
		  <h3 class="text-center">Enter Your Order OTP</h3>
		  <p color='black'> Thanks for giving your details. Please enter the 4 digit OTP below for order delivered successfully</p>
        <div class="login-wrap">
			
            <input type="text" class="form-control" required placeholder="Enter Your OTP Number" name='otp' autofocus>
           
            <button class="btn btn-lg btn-login btn-block" type="submit">Delivered order</button>
           

        </div>
          <!-- Modal -->
       
          <!-- modal -->
		 <?php if($this->session->flashdata("error1"))
						{ ?>
					<div class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $this->session->flashdata("error1") ?></a></div>
					<?php
						}
                     ?>
            <?php if($this->session->flashdata("success"))
						{ ?>
					<div class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $this->session->flashdata("success") ?></a></div>
					<?php
						}
                     ?>

      </form>
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
  function update_transporter(trans_id,company,order_key)
  {
 	$.ajax({
			
                type:'post',
                url:'<?php echo base_url();?>index.php/transporter/update_transporter',
                data:'trans_id='+trans_id+'&company='+company+'&order_key='+order_key,
                success:function(res){
					/*  alert(res); */ 
					
                }
			}); 
  }
  </script>
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
<script type="text/javascript">

$(document).ready(function () {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
		
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
          

			$(wrapper).append('<div class="panel panel-default input_fields_wrap"><div class="panel-body" name="mytext[]"><div class="form-group"><label class="col-lg-3 col-sm-2 control-label">Address</label><div class="col-lg-7"><input type="text" class="form-control" id="address" placeholder="Enter Address">	</div><div class="col-lg-1"><a class="btn btn-danger btn-sm remove_field"><i class="fa fa-minus"></i></i></a></div></div><div class="form-group"><label class="col-lg-3 col-sm-2 control-label">Date & Time</label><div class="col-lg-7"><input size="16" type="text" name='+x+' value="2012-06-15 14:45" readonly class="form_datetime form-control"/></div></div></div></div>');			//add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').parent().remove(); x--;
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
		   $('.accept').click(function() {
			
           $id = $(this).attr("name");
		  
			$('#order_id').val($id);
        });
		$('.reject').click(function() {
           $id = $(this).attr("name");
			$('#order-id').val($id);
        });
		 $('.assign').click(function() {
			 
	      $("#vehicle option").remove();
		   $("#driver option").remove();
           $id = $(this).attr("name");
			$('#orderId').val($id);
			var id = $(this).val();
			$.ajax({
				 type:'POST',
                url:'<?php echo base_url();?>index.php/transporter/get_vehicle',
                data:'id='+$id,
                success:function(result){
					
					var obj= jQuery.parseJSON(result);
					/* alert(obj); */
					if(obj){         
						$('#vehicle').append("<option value=''>Select vehicle</option>");
						 $(obj).each(function(){       
						var option = $('<option />'); 
						//option.attr({'selected':'selected'}).text('select vehicles');  
						if(this.status=='disabled')
						{
							
							option.attr({'value': this.id, 'disabled':this.status,'style':'background-color: gray'}).text(this.registration_no+'   TC('+this.tcapacity+'),'+'   RC('+this.rcapacity+')');  
						
						     
						 }
                          else if(this.status=='enabled')	
						  {
							  option.attr({'value': this.id, 'enabled':this.status}).text(this.registration_no+'   TC('+this.tcapacity+'),'+'   RC('+this.rcapacity+')');
						
						    
						  }		
						   $('#vehicle').append(option);  					  
						});              
					 }
					else{		
						$('#vehicle').html('<option value="">Vehicle not available</option>');  
					}   
               
             }});
			 
			 
			 $.ajax({
				 type:'POST',
                url:'<?php echo base_url();?>index.php/transporter/get_driver',
                data:'id='+$id,
                success:function(result){
					
					var obj= jQuery.parseJSON(result);
					/* alert(obj); */
					if(obj){      
						$('#driver').append("<option value=''>Select Driver</option>");

						 $(obj).each(function(){ 

						var option = $('<option />'); 
						
						if(this.status=='disabled')
						{
							
							option.attr({'value': this.did, 'disabled':this.status}).text(this.name);  
						    
						 }
                          else if(this.status=='enabled')	
						  {
							 option.attr({'value': this.did, 'enabled':this.status}).text(this.name);  
						
						  }	
						   $('#driver').append(option);  
						 // document.getElementById('mobile').value = this.mobile;
						  //document.getElementById('license').value = this.license_no;  						  
						}); 

						           
					 }
					else{		
						$('#driver').html('<option value="">Vehicle not available</option>');  
					}   
               
             }});
			 
			 
        });
		
		$('.cancel').click(function() {
           $id = $(this).attr("name");
			$('#cancel_order_id').val($id);
        });
		$('.delivered').click(function() {
           $id = $(this).attr("name");
			$('#delivered_order').val($id);
        });
	
		$(".form_datetime").datetimepicker({Format: 'yy-mm-dd H:i:s'}); 
		
		
		$('#driver').on('change',function(){
		
        var id = $(this).val();
        if(id){
		
            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>index.php/transporter/get_driver_details',
                data:'id='+id,
                success:function(res){
					/* alert(res); */
					var obj= JSON.parse(res);
					var mobile = obj.d[0].mobile;
					var license = obj.d[0].license_no;
					
						document.getElementById('mobile').value = mobile;
						document.getElementById('license').value = license;
					
					
                }
            }); 
        }
    });
	
	$('#vehicle').on('change',function(){
		
        var id = $(this).val();
        if(id){
		
            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>index.php/transporter/get_vehicle_details',
                data:'id='+id,
                success:function(res){
					/* alert(res); */
					var obj= JSON.parse(res);
					var insurance = obj.d[0].insurance;
					
						document.getElementById('insurance').value = insurance;
					
                }
				}); 
			}
		});
		
			$("#dynamic-table1").dataTable();
	$("#dynamic-table2").dataTable();
	$("#dynamic-table3").dataTable();
	$("#dynamic-table4").dataTable();
	$("#dynamic-table5").dataTable();
	$("#dynamic-table6").dataTable();
});
  </script>
	


  </body>
</html>
