  <?php
	 include "includes/header.php";
	 ?>
<head>
 <style type="text/css">
@media print
{
body * { visibility: hidden; }
#printcontent * { visibility: visible; }
#printcontent { position: absolute; top: 40px; left: 30px; }
}


       .blink-one {
         animation: blinker-one 1s linear infinite;
       }
       @keyframes blinker-one {  
         0% { opacity: 0; }
       }
	   
</style>
</head>
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
              <div id='print' class="row">
					<div class="col-lg-12">
						<h3 class="left">Order Details</h3>
					</div>
			<?php
				$order_id = $_GET['id'];
				if($order_id)
				{
					$this->db->select('order_id');
					$this->db->from('dbo.sales_dispatched_order');
					$this->db->where('order_id', $order_id);
					$q = $this->db->get();
					/* print_r($q->row()); */
				}
				
				if($q->num_rows() > 0)
				{
					/* print('in'); */
					$this->db->select('*,dr.name as driver_name,sdo.delivery_date as dispatch_date,ar.order_id as o_id, dr.mobile as driver_contact, c.name as cust_name,sdo.cust_no as custom_no , c.mobile as cust_mobile,t.name as trans_name,d.shipping_status as status,sdo.order_id as order_id,sdo.delivery_date as delivery_date,c.name as cust_name,d.gate_in_date as gate_in_date, d.gate_out_date as gate_out_date, d.tare_weight_date as tare_weight_date, d.gross_weight_date as gross_weight_date, d.loading_date as loading_date, d.delivered_date as delivered_date,t.state_code as state_code,t.company as company ,t.global_id as global_id,sdo.status as sales_status');
					$this->db->from('dbo.sales_dispatched_order as sdo');
					$this->db->join('dbo.order_details as d', 'd.order_id = sdo.order_id','left outer');
					$this->db->join('dbo.attn_required as ar', 'sdo.order_id = ar.order_id','left outer');
					$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			        $this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company = c.company','left outer');
					$this->db->join('dbo.driver as dr', 'dr.id = d.driver_id','left outer');
					$this->db->join('dbo.vehicle as v', 'v.id = d.vehicle_id','left outer');
					$this->db->where('sdo.order_id', $order_id);
					$query = $this->db->get()->row();
				}
				else
				{	
					/* print('post'); */
					$this->db->select('*,dr.name as driver_name,sdo.posting_date as dispatch_date, dr.mobile as driver_contact,c.name as cust_name,sdo.cust_no as custom_no ,c.mobile as cust_mobile, t.name as trans_name,d.shipping_status as status,sdo.order_id as order_id,c.name as cust_name, d.gate_in_date as gate_in_date, d.gate_out_date as gate_out_date, d.tare_weight_date as tare_weight_date, d.gross_weight_date as gross_weight_date, d.loading_date as loading_date, d.delivered_date as delivered_date,t.state_code as state_code,t.company as company ,t.global_id as global_id');
					$this->db->from('dbo.posted_sales_dispatch_order as sdo');
					$this->db->join('dbo.order_details as d', 'd.order_id = sdo.order_id','left outer');
					$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			        $this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
					$this->db->join('dbo.driver as dr', 'dr.id = d.driver_id','left outer');
					$this->db->join('dbo.vehicle as v', 'v.id = d.vehicle_id','left outer');
					$this->db->where('sdo.order_id', $order_id);
					$query = $this->db->get()->row();
				}
				
				
				/* print_r($query); */
			
			?>
					<div class="col-lg-12">
                        <section class="panel">
							<input type='hidden' value='<?php  echo $order_id;?>' id='order_id'>

							<div class="panel-body">
							<section class="panel">
								<div class="panel-body">
									<div class="col-md-4">
										<div id='qr' class="pro-img-details text-center">
											<img src="" id='result' >
										</div>
										<br/>
										<div class="text-center">
											<div class="bid-now" id="bid-now">
												
											<?php 
											if($query->sales_status=='Released')
											{
											if(!empty($query->order_status))
											{
												if($query->shipping_status =='Awaiting For Arrival')
												{ 
											?>
												<button type="button" class='btn btn-lg btn-primary'><?php echo $query->shipping_status?></button>
												
											<?php 
												} 
												else if($query->shipping_status =='Gate In') 
												{ 
											?>
												<button type="button" class='btn btn-lg btn-info'><?php echo $query->shipping_status?></button>
												
											<?php 
												}
												else if($query->shipping_status =='Tare Weight (Weighbridge)') 
												{ 
											?>
												<button type="button" class='btn btn-lg btn-warning'><?php echo 'Weigh In'?></button>
											<?php
												} 
												else if($query->shipping_status=='Loading') 
												{ 
											?>
												<button type="button" class='btn btn-lg btn-danger'>Loading In</button>
											<?php 
												}
												else if($query->shipping_status=='Loading Out') 
												{ 
											?>
												<button type="button" class='btn btn-lg btn-danger'><?php echo $query->shipping_status?></button>
											<?php 
												}
												else if($query->shipping_status =='Gross Weight (Weighbridge)')
												{ 
											?>
												<button type="button" class='btn btn-lg btn-warning'><?php echo 'Weigh Out'?></button>
												
											<?php
												}  
												else if($query->shipping_status =='Dispatched')
												{
											?>
												<button type="button" class='btn btn-lg btn-success'><?php echo $query->shipping_status;?></button>
												
											<?php 
												} else if($query->shipping_status =='Not Approved')
												{
												?>
											     <button type="button" class='btn btn-lg btn-danger'><?php echo $query->shipping_status;?></button>
											<?php }else if($query->shipping_status =='Awaiting For Approvel')
												{
												?>
											<button type="button" class='btn btn-lg btn-danger'><?php echo $query->shipping_status;?></button>
											<?php }}
											else
											{
												if(!empty($query->reason))
												{
											?>
												<button type="button" class='btn btn-lg btn-danger'>Missed order</button>
												<h5><?php echo $query->reason;?></h5>
											<?php	
												}
												else
												{
											?>
												<button type="button" class='btn btn-lg btn-primary'>Awaiting For Acceptance</button>
											<?php
												}
											}
											}
											else if($query->sales_status=='Reopened')
											{ ?>
												<button type="button" class='btn btn-lg btn-danger blink-one'><?php echo $query->sales_status ?></button>
												<h5><?php echo $query->reason;?></h5>
											<?php }
											
											?>
											
											
											</div>
										</div>  

										<br/>
										<!--<div id='dates' class="text-center">
											<p><strong class="highlight">Initial Posting Date :</strong> <?php echo $query->initial_posting_date?></p>
											<p><strong class="highlight">Actual Posting Date :</strong> <?php echo $query->dispatch_date?></p>
										</div>-->
										<br/>
										<?php 
										if($query->shipping_status == 'Gate In' || $query->shipping_status == 'Tare Weight (Weighbridge)' || $query->shipping_status == 'Loading' || $query->shipping_status == 'Gross Weight (Weighbridge)' || $query->shipping_status =='Dispatched' || $query->shipping_status =='Delivered')
										{
										?>
										<div class="text-center">
										<div class="table-responsive">
										  <table class="table table-bordered">
											  <thead>
											  <tr>
												  <th>Status</th>
												  <th>Date</th>
												  <th>Time</th>
												 
											  </tr>
											  </thead>
											  <tbody>
											  <?php 
												if(!empty($query->gate_in_date))	
												{
													$time = new DateTime($query->gate_in_date);
													$date = $time->format('d-m-Y');
													$time = $time->format('H:i');


												?>
												<tr>
												    <td><?php echo "Gate In";?></td>
													<td><?php echo $date;?></td>
													<td><?php echo $time;?></td>
												</tr>
											<?php
												}		
												if(!empty($query->tare_weight_date))	
												{	
													$time = new DateTime($query->tare_weight_date);
													$date = $time->format('d-m-Y');
													$time = $time->format('H:i');											
											  ?>
											 
											  <tr>
												   <td><?php echo "Weigh In";?></td>
													<td><?php echo $date;?></td>
													<td><?php echo $time;?></td>
												
											  </tr>
											  <?php
												}		
												if(!empty($query->loading_date))	
												{	
													$time = new DateTime($query->loading_date);
													$date = $time->format('d-m-Y');
													$time = $time->format('H:i');
											  ?>
											  <tr>
												  <td><?php echo "Loading In";?></td>
												 <td><?php echo $date;?></td>
													<td><?php echo $time;?></td>
												
											  </tr>
											  <?php
												}	
                                                if(!empty($query->loading_out_date))	
												{	
													$time = new DateTime($query->loading_out_date);
													$date = $time->format('d-m-Y');
													$time = $time->format('H:i');
											  ?>
											  <tr>
												  <td><?php echo "Loading Out";?></td>
												 <td><?php echo $date;?></td>
													<td><?php echo $time;?></td>
												
											  </tr>
											  <?php
												}												
												if(!empty($query->gross_weight_date))	
												{		
													$time = new DateTime($query->gross_weight_date);
													$date = $time->format('d-m-Y');
													$time = $time->format('H:i');
											  ?>
											  <tr>
												 
												  <td><?php echo "Weigh Out";?></td>
												  <td><?php echo $date;?></td>
													<td><?php echo $time;?></td>
												
											  </tr>
											   <?php
												}		
												if(!empty($query->gate_out_date))	
												{		
													$time = new DateTime($query->gate_out_date);
													$date = $time->format('d-m-Y');
													$time = $time->format('H:i');
											  ?>
											  <tr>
												 
												  <td><?php echo "Dispatched";?></td>
												  <td><?php echo $date;?></td>
													<td><?php echo $time;?></td>
												
											  </tr>
											   <?php
												}		
												if(!empty($query->delivered_date))	
												{		
													$time = new DateTime($query->delivered_date);
													$date = $time->format('d-m-Y');
													$time = $time->format('H:i');
											  ?>
											  <tr>
												  <td><?php echo "Delivered";?></td>
												  <td><?php echo $date;?></td>
													<td><?php echo $time;?></td>
												
											  </tr>
											  <?php
												}
												?>
											  </tbody>
											</table>
										</div>
										</div>
										<?php
										}
										?>										
									</div>
									
									<div id='details'  class="col-md-8">
										<div class=" product_meta row">
											
											<div class=" col-md-12">
											<div class="col-md-6" style="padding: 0px 0px">
												<h4><strong class="highlight"><?php echo $order_id;?></strong></h4>
													
													</div>
											
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
											
											<div class="col-md-6" style="padding: 0px 0px">
												<div class="">
													<p><strong class="highlight">Transporter Name :</strong> <?php echo $query->trans_name;?><p>
													<p><strong class="highlight">Global ID :</strong> <?php echo $query->global_id;?><p>
													<p><strong class="highlight">State Code :</strong> <?php echo $query->state_code;?><p>
													<p><strong class="highlight">Company Name :</strong> <?php echo $query->company;?><p>
												</div>
												<?php if($query->driver_id)
												{
													?>
												<div class="">
													<p><strong class="highlight">Driver Name :</strong> <?php echo $query->driver_name;?><p>
												</div>
												<div class="">
													<p><strong class="highlight">Driver Contact :</strong> <?php echo $query->driver_contact;?><p>
												</div>
												<div class="">
													<p><strong class="highlight">Vehicle No. :</strong> <?php echo $query->registration_no;?><p>
												</div>
												<?php
												}
												?>
											</div>
											<div class="col-md-6">
												<div class="">
													<p><strong class="highlight">Shipment Name :</strong> <?php echo $query->ship_to_name;?>  <p>
												</div>
												<?php
												if($query->sales_order_no)
												{
												?>
												<div class="">
													<p><strong class="highlight">Sales Order No. : </strong> <?php echo $query->sales_order_no;?> <p>
												</div>
												<?php
												}
												 if($query->party_order_no)
												{
												?>
												<div class="">
													<p><strong class="highlight">Party Order No. : </strong> <?php echo $query->party_order_no;?><p>
												</div>
												<?php
												}
												if($query->rawana_no)
												{
												?>
												<div class="">
													<p><strong class="highlight">Rawana No. : </strong> <?php echo $query->rawana_no;?><p>
												</div>
												<?php
												}
												?>
												
												
												
											</div>	

												
											</div>
											<div class="col-md-12 border">
												<div class="add_pic col-md-6">
													<h6>Pickup Address :</h6>
													<p>
														<!--Nr, BSNL Office,<br>Lati Bazar,<br>Surendranagar,Gujarat,<br>363001-->
														<?php $a= $query->route;
														
																$arr = explode('To',trim($a));
																echo $arr[0];
														?>
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
											$req_delivery_date = explode(',', $query->req_delivery_date);
											$promised_delivery_date = explode(',', $query->promised_delivery_date);
											$count = count($item_code);
											
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
														
														<!--<span class="posted_in"> <strong>Requested Delivery Date :</strong> <a rel="tag"><?php echo $req_delivery_date[$i];?></a><br>
														</span>
														<span class="posted_in"> <strong>Promised Delivery Date :</strong> <a rel="tag"><?php echo $promised_delivery_date[$i];?></a>
														</span>-->
													</div>
												</div>
												</div>
												
												
											<?php
												}
											}
										?>
										</div>
										
										

										
									</div><br/>
									
									
								</div>
							</section>
							
							</div>
						</section>
					</div>
					</div>
					<div class="col-md-12">
										<div class="text-center invoice-btn">
											<a class="btn btn-info btn-lg" onclick="PrintMe('print')"><i class="fa fa-print"></i> Print </a>
											
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
<script language="javascript">
function PrintMe(DivID) {
var disp_setting="toolbar=yes,location=no,";
disp_setting+="directories=yes,menubar=yes,";
disp_setting+="scrollbars=yes,width=650, height=600, left=100, top=25";
   var content_vlue = document.getElementById('print').innerHTML;
   var qr = document.getElementById('qr').innerHTML;
   //var dates = document.getElementById('dates').innerHTML;
   var details = document.getElementById('details').innerHTML;
   var docprint=window.open("","",disp_setting);
   docprint.document.open();
   docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
   docprint.document.write('<head><title style="font-size:20px;font:bold">Transport Managment System</title>');
   docprint.document.write('</head><body onLoad="self.print()"><center>');
   docprint.document.write(content_vlue);
   docprint.document.write(qr);
   docprint.document.write('</center></body></html>');
  
   docprint.document.close();
   docprint.focus();
}
</script>
  <script language="javascript" type="text/javascript">
  
  
function printerDiv(divID) {
//Get the HTML of div

var divElements = document.getElementById('print').innerHTML;

//Get the HTML of whole page
var oldPage = document.body.innerHTML;

//Reset the pages HTML with divs HTML only

     document.body.innerHTML = 

     "<html><head><title></title></head><body>" + 
     divElements + "</body>";



//Print Page
window.print();

//Restore orignal HTML
document.body.innerHTML = oldPage;

}
</script>
  <script>
$(document).ready(function()
{
	
	$order_id = $('#order_id').val();
	
	//alert($order_id);
	var url=" https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=" + $order_id;
	document.getElementById('result').src = url; 
	
	 $(".js-example-basic-single").select2();

      //knob
      $(".knob").knob();
});
  </script>
    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>

