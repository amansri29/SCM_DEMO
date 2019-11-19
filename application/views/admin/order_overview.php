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
	 $access_role1 = $this->session->userdata('access_role');
     $access_role=explode(',',$access_role1);
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
              <!-- page start-->
              <div class="row">
					<div class="col-lg-12">
						<h3 class="left">Order Details</h3>
					</div>
					<?php
						$order_id = $_GET['id'];
						$this->db->select('*,sdo.delivery_date as dispatch_date,sdo.cust_no as custom_no , c.mobile as cust_mobile,sdo.order_id as order_id,sdo.delivery_date as delivery_date,c.name as cust_name');
						$this->db->from('dbo.sales_dispatched_order as sdo');
						$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
						$this->db->where('sdo.order_id', $order_id);
						$query = $this->db->get()->row();
					?>
					<div class="col-lg-12">
                        <section class="panel">
							
							<div class="panel-body">
							<section class="panel">
								<div class="panel-body">
									<div class="col-md-4">
										<div class="pro-img-details">
											<img style='width:100%!important' src="<?php echo base_url();?>images/cargoprojectbydefaultpic.jpg" alt=""/>
										</div>
										<br/>
										<div class="bid">
											<div class="equal" style="height: 44px;">
												<span>Total Bid</span><br>
												<?php
													$this->db->select('*');
													$this->db->from('dbo.bidding_orders');
													$this->db->where('order_id', $order_id);
													$q1 = $this->db->get()->result_array();
													if(!empty($q1))
													{
														echo count($q1) ;
													}
													else
													{
														echo "0";
													}
												?>

											</div>
										</div>
										<div class="bid">
											<div class="equal" style="height: 44px;">
												<span>Lowest Bid</span><br>
												<?php
													$this->db->select('MIN(bid_amount) as lowest_amount, unit');
													$this->db->from('dbo.bidding_orders');
													$this->db->where('order_id', $order_id);
													 $this->db->group_by('unit'); 
													$q2 = $this->db->get()->row();
													if(!empty($q2->lowest_amount))
													{
														echo $q2->lowest_amount."  ".$q2->unit;
													}
													else
													{
														echo "-";
													}
													
													
												?>
											</div>
										</div><br/>
										<div class="bid-now" id="bid-now">
											<button class="btn btn-lg btn-danger" type="button"> Bidding process</button>
										
										</div>
                                  
									</div>
									<div class="col-md-8">
										<div class=" product_meta row">
											
											<div class=" col-md-12">
											<div class="col-md-6" style="padding: 0px 0px">
												<h4><strong class="highlight"><?php echo $order_id;?></strong></h4>
												<span class="posted_in"> <strong>Customer No. :</strong> <a rel="tag"><?php echo $query->custom_no;?></a>
													</span>
												<span class="posted_in"> <strong>Customer Name :</strong> <a rel="tag"><?php echo $query->cust_name;?></a>
												</span>

												<span class="posted_in"> <strong>Contact :</strong> <a rel="tag"><?php echo $query->cust_mobile;?></a><br>
												</span>
												
											</div>
											<div class="col-md-6">
												<?php 
												if($query->order_status == 'Inprocess')
												{
												?>
													<img src="" id='result' >
												<?php
												}
												?>
												
											</div>	
											</div>
										</div>
										<div class="form-group">
											
											<div class="col-md-12 border">
												<div class="add_pic col-md-6">
													<h6>Pickup Address :</h6>
													<p>
													<?php $a= $query->route;
														
																$arr = explode('To',trim($a));
																echo $arr[0];
														?>
														<!-- Nr, BSNL Office,<br>Lati Bazar,<br>Surendranagar,Gujarat,<br>363001-->
													</p>
												</div>

												<div class="add_pic col-md-6">
													<h6>Shipping Address :</h6>
													<p>
														<?php echo $query->ship_to_address.'<br>'?>
														<?php if(!empty($query->ship_to_address_2)){ echo $query->ship_to_address_2.'<br>';}?>
														<?php echo $query->Ship_to_Post_Code.'<br>';?>
														<?php echo $query->ship_to_city.'<br>';?>
													</p>
												</div>
											</div>
											
											
											
										</div>
										<div class="form-group">
										<?php
											$item_code = explode(',', $query->item_code);
											$description = explode(',', $query->description);
											$qty_to_ship = explode(',', $query->qty_to_ship);
											 $quantity =    explode(',', $query->quantity);
											$req_delivery_date = explode(',', $query->req_delivery_date);
											$promised_delivery_date = explode(',', $query->promised_delivery_date);
											$dispatch_date = new DateTime($query->dispatch_date);
											$count = count($item_code);
											 $qty= array_sum($quantity);
											for($i =0 ; $i < $count; $i++)
											{
												if($qty_to_ship[$i] > 0)
												{
											?>
												<div class="col-md-12 border">
												<div class="col-md-6" >
												<h4 class="pro-d-title ">
													<h4><strong class="highlight">
														<?php echo $item_code[$i];?>
													</strong></h4>
												</h4>
												<p>
													<?php echo $description[$i];?>
												</p>
												<p>
													<strong>Quantity :</strong> <a rel="tag"><?php echo $qty_to_ship[$i];?></a>
												</p>
												</div>
												<div class="col-md-6">
													<div class="product_meta">
													
														<span class="posted_in"> <strong>Dispatch Date :</strong> <a rel="tag"><?php echo $query->dispatch_date;?></a><br>
														</span>
														<span class="posted_in"> <strong>Requested Delivery Date :</strong> <a rel="tag"><?php echo $req_delivery_date[$i];?></a><br>
														</span>
														<span class="posted_in"> <strong>Promised Delivery Date :</strong> <a rel="tag"><?php echo $promised_delivery_date[$i];?></a>
														</span>
													</div>
												</div>
												</div>
												
												
											<?php
												}
											}
										?>
										</div>
										
										

										
									</div>
								  
								</div>
								
							</section>
							
							<?php
								$this->db->select('DISTINCT (bid.order_id) as order_id,t.name as name,bid.created as created,bid.pickup_date as pickup_date,bid.fleet_type as fleet_type,bid.transit_time as transit_time,cast (bid.comments AS VARCHAR(max)) AS comments,bid.bid_amount as bid_amount,bid.unit as unit,bid.edit_amount,bid.edit_date');
								$this->db->from('dbo.bidding_orders as bid');
								$this->db->join('dbo.transporter as t', 't.global_id = bid.global_id','left outer');
								$this->db->where('bid.order_id', $order_id);
								
								$q3 = $this->db->get();
								$data = $q3->result_array();
									
								if(!empty($data))
								{
							?>
							<section class="panel" >
								<div class="panel-body"><br/>
									
									<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
											<tr>
											  <th>Vendor</th>
											  <th>Bidding Date</th>
											  <th>Bidding Time</th>
											  <th>Current Amount</th>
											  <th>Total Amount</th>
											  <?php if (in_array("bid_history", $access_role) OR in_array("all", $access_role)) { ?>
											  <th class='width-20'>History</th>
											<?php } ?>
											 
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($data as  $key => $value)
											{
												  
											?>
										  <tr>
											  <td class="tdLong_Wrp"><a class="usr_wrp"><?php echo $value['name']?></a><ul><li class="mycustomclassforrating lft"><span class="ratingcls" style="display:none;">0</span><div id="fixture2015"><span class="stars-container stars-0">★★★★★</span></div></li></ul></td>
											 <td><?php echo  date('d-m-Y',strtotime($value['created']));?></td>
                                             <td><?php echo date('H:i:s',strtotime($value['created']));?></td>
											  <td> <strong class="highlight" style="font-size:20px;"><?php echo $value['bid_amount'];?> <?php echo $value['unit'];?></strong></td>
											 <td><strong class="highlight" style="font-size:20px;"><?php echo  $value['bid_amount']*$qty;?> <span style="font-size:15px;"><?php echo $value['unit'];?></span></strong></td>
											 <?php if (in_array("bid_history", $access_role) OR in_array("all", $access_role)) { ?>
											  <!--<th><button id="<?php echo $key ?>" value="<?php echo $value['order_id'];?>" class='button' style=' padding: 5px;text-align: center; background-color: #78CD51; border: solid 1px #c3c3c3; width:100%;color:white'>View History</button></th>-->
											  <th><a id="<?php echo $key ?>" value="<?php echo $value['order_id'];?>" class="btn btn-primary btn-sm add_field_button abc"><i class="fa fa-plus"></i></a></th>
											<?php } ?>
										  </tr>
										  <?php 
										  if (in_array("bid_history", $access_role) OR in_array("all", $access_role)) { 

                                               $edit_amount  = explode(',',$value['edit_amount']); 
			                                   $edit_date  = explode(',',$value['edit_date']); 
			                                    $count=count($edit_amount);
			                                    for ($i = 0; $i < $count; $i++)
			                                    {
			                                       if($edit_amount[$i]!='')
			                                       {
										  	?>
										  <tr id="od_<?php echo $key ?>" class='panel' style=' background-color: #e5eecc;padding: 50px; display: none;'>
										  	
										       <td class="tdLong_Wrp">
                                          <a class="usr_wrp"><?php echo $value['name'];?></a>
                                          <ul>
                                             <li class="mycustomclassforrating lft">
                                                <span class="ratingcls" style="display:none;">0</span>
                                                <div id="fixture2015"><span class="stars-container stars-0">★★★★★</span></div>
                                             </li>
                                          </ul>
                                       </td>
                                      <td><?php echo  date('d-m-Y',strtotime($edit_date[$i]));?></td>
                                       <td><?php echo date('H:i:s',strtotime($edit_date[$i]));?></td>
                                            <td> <strong class="highlight" style="font-size:20px;"><?php echo $edit_amount[$i];?> <span style="font-size:15px;"><?php echo $value['unit'];?></span></strong></td>
                                          <td><strong class="highlight" style="font-size:20px;"><?php echo $edit_amount[$i]*$qty;?> <span style="font-size:15px;"><?php echo $value['unit'];?></span></strong></td>
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
								
								</div>
								
							</section>
							<?php
								}
								?>
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
  <script>
$(document).ready(function()
{
	 $(".js-example-basic-single").select2();

   $("#dynamic-table").dataTable();
	
});
      //knob
      $(".knob").knob();

  </script>
  <script>

$(document).on('click','.abc',function(){
	$id = $(this).attr('id');
	$value = $(this).val();

	$("#od_"+$id).slideToggle();
    //$("#od_"+$id).fadeToggle("slow");
  //  $("#od_"+$id).fadeToggle(3000);
});
</script>
    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>

