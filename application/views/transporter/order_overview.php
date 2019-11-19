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
         $global_id = $this->session->userdata['global_id'];
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
               
               $this->db->select('*');
               	$this->db->from('dbo.sales_dispatched_order as sdo');
               	$this->db->where('sdo.order_id', $order_id);
               	$query = $this->db->get()->row();
               /* 				print_r($query); */
               
               
               ?>
            <div class="col-lg-12">
               <?php
                  if(($this->session->flashdata('item'))) {
                  
                  $message = $this->session->flashdata('item');
                  
                  ?>
               <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
               <?php
                  }
                  ?>
               <section class="panel">
                  <input type='hidden' value='<?php  echo $order_id;?>' id='order_id'>
                  <div class="panel-body">
                     <section class="panel">
                        <div class="panel-body">
                           <div class="col-md-4">
                              <div class="pro-img-details text-center">
                                 <img style="width:100%!important" src="<?php echo base_url();?>images/cargoprojectbydefaultpic.jpg" >
                              </div>
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
                                       	echo $q2->lowest_amount." ".$q2->unit;
                                       }
                                       else
                                       {
                                       	echo "-";
                                       }
                                       ?>
                                 </div>
                              </div>
                              <br/>
                              <div class="text-center">
                                 <?php
                                    $this->db->select('DISTINCT (bid.order_id) as order_id,t.name as name,bid.created as created,bid.pickup_date as pickup_date,bid.fleet_type as fleet_type,bid.transit_time as transit_time,cast (bid.comments AS VARCHAR(max)) AS comments,bid.bid_amount as bid_amount,bid.unit as unit,bid.edit_amount,bid.edit_date');
                                    $this->db->from('dbo.bidding_orders as bid');
                                    $this->db->join('dbo.transporter as t', 't.global_id = bid.global_id','left outer');
                                    $this->db->where('bid.order_id', $order_id);
                                    $this->db->where('bid.global_id', $global_id);
                                    // $this->db->order_by('bid.edit_amount', 'DESC');
                                     $this->db->order_by("bid.edit_amount",'DESC');
                                    $q3 = $this->db->get();
                                    
                                    	if($q3->num_rows() > 0)
                                    	{
                                    	?>
                                 <div class="bid-now" id="edit_bid">
                                    <button class="btn btn-lg btn-primary" type="button"> Edit Bid</button>
                                 </div>
                                 <?php
                                    }
                                    else
                                    {
                                    ?>
                                 <div class="bid-now" id="bid-now">
                                    <button class="btn btn-lg btn-danger" type="button"> Bid Now</button>
                                 </div>
                                 <?php
                                    }
                                    ?>
                              </div>
                              <br/>
                           </div>
                           <div class="col-md-8">
                              <div class=" product_meta row">
                                 <div class=" col-md-12">
                                    <div class="col-md-6" style="padding: 0px 0px">
                                       <h4><strong class="highlight"><?php echo $order_id;?></strong></h4>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
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
                                    $item_code =   explode(',', $query->item_code);
                                    $description = explode(',', $query->description);
                                    $qty_to_ship = explode(',', $query->qty_to_ship);
                                    $quantity =    explode(',', $query->quantity);
                                    $req_delivery_date = explode(',', $query->req_delivery_date);
                                    $promised_delivery_date = explode(',', $query->promised_delivery_date);
                                    $count = count($item_code);
                                    $qty= array_sum($quantity);
                                   // die;
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
                                             </strong>
                                          </h4>
                                       </h4>
                                       <p>
                                          <?php echo $description[$i];?>
                                       </p>
                                       <p>
                                          <strong>Quantity To Ship :</strong> <a rel="tag"><?php echo   $qty_to_ship[$i];?></a>
                                          </p>
                                       <p>
                                         <strong>Quantity :</strong> <a rel="tag"><?php echo   $qty ?></a>
                                       </p>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="product_meta">
                                          <span class="posted_in"> <strong>Dispatch Date :</strong> <a rel="tag"><?php echo $query->delivery_date;?></a><br>
                                          </span>
                                          <!--<span class="posted_in"> <strong>Requested Delivery Date :</strong> <a rel="tag"><?php echo $req_delivery_date[$i];?></a><br>
                                             </span>
                                             <span class="posted_in"> <strong>Promised Delivery Date :</strong> <a rel="tag"><?php echo $promised_delivery_date[$i];?></a>-->
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
                           <br/>
                        </div>
                     </section>
                      <section class="panel" id="bid-form">
                        <div class="panel-body" id="transport_form_con">
                           <br/>
                           <div class="col-lg-12" >
                              <form class="form-horizontal" id="form" enctype="multipart/form-data" method="post" action="<?php echo base_url();?>index.php/transporter/bid_now" role="form">
                                 <input type="hidden" id="trans_id" name="id" value="<?php echo $user_id?>"> 
                                 <input type="hidden" id="o_id" name="order_id" value="<?php echo $order_id?>"> 
                                 <input type="hidden" id="company" name="company" value="<?php echo $query->company?>"> 
                                 <div class="col-lg-6">
                                    <!--<div class="form-group">
                                       <label class="col-lg-3 col-sm-2 control-label">Fleet Type</label>
                                       <div class="col-lg-8">
                                          <select class="js-example-basic-single" required id="fleet_type" name="fleet_type">
                                             <option value="0">Select Fleet Type</option>
                                             <option value="Closed Truck">Closed Truck</option>
                                             <option value="Flat Bed / Container">Flat Bed / Container</option>
                                             <option value="ODC">ODC</option>
                                             <option value="Open Truck">Open Truck</option>
                                             <option value="Refrigerated Truck">Refrigerated Truck</option>
                                             <option value="Tanker">Tanker</option>
                                             <option value="Tipper(Dumper)">Tipper(Dumper)</option>
                                             <option value="Transit Mixer">Transit Mixer</option>
                                             <option value="Vehicle Carrier">Vehicle Carrier</option>
                                             <option value="Trailer">Trailer</option>
                                          </select>
                                       </div>
                                    </div>-->
                                    <!--<div class="form-group">
                                       <label for="transit_time" class="col-lg-3 col-sm-2 control-label">Transit Time<span>(in days)</span></label>
                                       <div class="col-lg-8">
                                          <input type="text" required class="form-control" id="transit_time" name="transit_time" placeholder="Enter Days">
                                       </div>
                                    </div>-->
                                    <div class="form-group">
                                       <label for="amount" class="col-lg-3 col-sm-2 control-label"><strong>Bid Amount</strong><span>(INR/MT Ton)</span></label>
                                       <div class="col-lg-6">
                                          <input class="form-control" required id="bid_amount" placeholder="Enter Amount" name="bid_amount" type="text">
                                       </div>
                                       <input type="hidden" name="unit" value="INR/MT">
                                       <!--<div class="col-lg-3">
                                          <select class="js-example-basic-single " name="unit">
                                             <option value="0">Select unit</option>
                                             <option value="KGs">KGs</option>
                                             <option value="Ton">Ton</option>
                                             <option value="Litre">Litre</option>
                                             <option value="Gallons">Gallons</option>
                                          </select>
                                          </div>-->
                                       <div class="col-lg-2">
                                          <button type="submit" class="btn btn-danger ">Submit</button>
                                       </div>
                                    </div>
                                 </div>
                                 <!--<div class="col-lg-6">
                                    <div class="form-group">
                                       <label for="date" class="col-lg-3 col-sm-2 control-label">Pickup Date</label>
                                       <div class="col-lg-8">
                                          <input type="text" class="form-control form-control-inline input-medium datepicker" style="width: 100%;" name="pickup_date" id="datepicker" required placeholder="Enter Date">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="comments" class="col-lg-3 col-sm-2 control-label">Proposal</label>
                                       <div class="col-lg-8">
                                          <textarea name="comments" required id="comments" class="form-control" cols="30" rows="3"></textarea>
                                       </div>
                                    </div>
                                 </div>-->
                              </form>
                           </div>
                        </div>
                     </section>
                     <?php 
                        $data = $q3->row();
                        				
                        	if(!empty($data))
                        	{
                        			?>
                     <section class="panel" id="tbl">
                        <div class="panel-body">
                           <br/>
                           <div class="adv-table">
                              <table  class="display table table-bordered table-striped" id="" >
                                 <thead>
                                    <tr>
                                       <th>Vendor</th>
                                       <th>Bidding Date</th>
                                        <th>Bidding Time</th>
                                       <!--<th>Pickup Date</th>-->
                                       <!--<th>Fleet Type</th>
                                       <th>Transit Time</th>-->
                                       <th>My Bid</th>
                                       <th>Total Amount</th>
                                        
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <!--<tr>
                                       <td class="tdLong_Wrp">
                                          <a class="usr_wrp"><?php echo $data->name;?></a>
                                          <ul>
                                             <li class="mycustomclassforrating lft">
                                                <span class="ratingcls" style="display:none;">0</span>
                                                <div id="fixture2015"><span class="stars-container stars-0">★★★★★</span></div>
                                             </li>
                                          </ul>
                                       </td>
                                       <td><?php $date = date('d-m-Y',strtotime($data->created)); echo $date;?></td>
                                       <td><?php $date = date('H:i:s',strtotime($data->created)); echo $date;?></td>
                                       <!--<td><?php $date = date('d-m-Y',strtotime($data->pickup_date)); echo $date;?></td>-->
                                      <!-- <td><?php echo $data->fleet_type;?></td>
                                       <td><?php echo $data->transit_time;?> days</td>-->
                                       <!--<td> <strong class="highlight" style="font-size:20px;"><?php echo $data->bid_amount;?> <?php echo $data->unit;?></strong></td>
                                      <!-- <td><?php echo $data->comments;?></td>-->
                                     <!-- <td>Bid Added</td>

                                    </tr>-->
                                    <?php
                                    //$edit_amount=array();
                                   // $edit = $data->edit_amount;
                                    $edit_amount  = explode(',',$data->edit_amount); 
                                    $edit_date  = explode(',',$data->edit_date); 
                                    $count=count($edit_amount);
                                    $amount=$data->bid_amount;

                                    for ($i = 0; $i < $count; $i++)
                                    {
                                       if($edit_amount[$i]!='')
                                       {
                                      ?>
                                      <tr style="background-color: #DEDCDB">
                                      <td class="tdLong_Wrp">
                                          <a class="usr_wrp"><?php echo $data->name;?></a>
                                          <ul>
                                             <li class="mycustomclassforrating lft">
                                                <span class="ratingcls" style="display:none;">0</span>
                                                <div id="fixture2015"><span class="stars-container stars-0">★★★★★</span></div>
                                             </li>
                                          </ul>
                                       </td>
                                      <td><?php echo  date('d-m-Y',strtotime($edit_date[$i]));?></td>
                                       <td><?php echo date('H:i:s',strtotime($edit_date[$i]));?></td>
                                            <td> <strong class="highlight" style="font-size:20px;"><?php echo $edit_amount[$i];?> <span style="font-size:15px;"><?php echo $data->unit;?></span></strong></td>
                                          <td><strong class="highlight" style="font-size:20px;"><?php echo $edit_amount[$i]*$qty;?> <span style="font-size:15px;"><?php echo $data->unit;?></span></strong></td>
                                    </tr>
                                 <?php }
                                 } ?>
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
      var form = document.getElementById('bid-form');
      var tbl = document.getElementById('tbl');
      	form.style.display = 'none';
      	
      	$('#bid-now').on('click',function()
      	{
      		$("#bid-form").toggle();
      	});
      	$('#edit_bid').on('click',function()
      	{
      		var id = $('#trans_id').val();
      		var order_id = $('#o_id').val();
      		/* alert(id+' '+order_id); */
      		$.ajax({
      			type:'POST',
      			url:'<?php echo base_url();?>index.php/transporter/get_bidding_data',
      			data:'id='+id+'&order_id='+order_id,
      			success:function(res){
      				/* alert(res); */
      				
      				var obj= JSON.parse(res);
      				var transit_time = obj.d[0].transit_time;
      				var bid_amount = obj.d[0].bid_amount;
      				var comments = obj.d[0].comments;
      				var pickup_date = obj.d[0].pickup_date;
      				var fleet_type = obj.d[0].fleet_type;
      				
      					document.getElementById('transit_time').value = transit_time;
      					document.getElementById('bid_amount').value = bid_amount;
      					document.getElementById('comments').value = comments;
      					document.getElementById('datepicker').value = pickup_date; 
      					$("#fleet_type [value='"+fleet_type+"']").attr("selected","selected");
      				 
      				$('#form').attr('action', '<?php echo base_url('index.php/transporter/update_bid');?>');	
      			}
      		}); 
      		$("#bid-form").toggle();
      		//tbl.style.display = 'none';

      	});
      	
      	$(function () {
          $("#datepicker").datepicker({
      		startDate: "+0d" ,
      		autoclose: true
      	});
      });
            //knob
            $(".knob").knob();
      });
        
   </script>
   <!-- js placed at the end of the document so the pages load faster -->
</body>
</html>