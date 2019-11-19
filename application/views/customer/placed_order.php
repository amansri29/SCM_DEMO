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
	 include "includes/customer_sidebar.php";
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                
                  <div class="col-lg-12">
				  <h3 class="left">Placed Order</h3>
					
                      <div class="row">
                         
                          <div class="col-lg-12">
                              <!--widget start-->
							<section class="panel">
							<div class="panel-body">
								<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
										  <tr>
											<th class="width-120">Dispatch Date</th>
											<th class="width-90">Order ID</th>
											<th class="width-90">SC</th>
											<th class="width-100">Item Code</th>
											<th class="width-200">Description</th>
								
											<th class="width-200">Request date</th>
											<th class="width-200">Quantity to ship</th>
											<th class="width-200">Shipping Status</th>
											
											<th class="width-100">Status</th>
											<th class="width-20">Action</th>
										  </tr>
										</thead>
										<tbody>
										 
										 <?php
										 
										  foreach ($placed_order as $get)
										  {
											   $item_data= $get['SalesLines']['Sales_Order_Line'];
												if(array_key_exists('0', $item_data))
												{
												$result=$get['SalesLines']['Sales_Order_Line'];
												}
												else{
												$result[]=$get['SalesLines']['Sales_Order_Line'];
												}
												$item_code=array();
												$description=array();
												$requested_Delivery_Date=array();
												$qty_to_ship=array();
												foreach ($result as $row)
                                              {
											  $qty_to_ship[] =$row['Qty_to_Ship'];
											  $item_code[] =  $row['No'];
											  $description[] =  $row['Description'];
											  $requested_Delivery_Date[] = $row['Requested_Delivery_Date'];
											  }
							              ?>
										  <tr>
											   <td> <?php echo date('d-m-Y',strtotime($get['Posting_Date'])) ?><strong></td>
                                  <td><strong><a href='<?php echo base_url();?>index.php/admin/order_view?id=<?php echo $get['order_id']?>'><?php echo $get['No']?></a></strong><br>
								  <?php echo $get['company']?>
								  </td>
								    <td><?php echo $get['Location_State_Code']?></td>
									<td><?php foreach ($item_code as $key => $value)
										  {
					                             print($value.'</br>');   
										  }
								    ?>
									</td>
								    <td><?php foreach ($description as $key => $value)
										  {
					                             print($value.'</br>');   
										  }
								    ?></td>
											  
								    <td><?php foreach ($requested_Delivery_Date as $key => $value)
										  {
					                             print($value.'</br>');   
										  }
								    ?></td>
								  <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                          
                                         if ($qty > '0')
										 {
					                      
                                                print($qty.'<br>');   
								  }}?></td>
											  <td><?php echo $get['Ship_to_Address'].' '.$get['Ship_to_Address_2'].' '.$get['Ship_to_Post_Code'].' '.$get['Ship_to_City']?></td>
											  <td><?php echo $get['Status']?></td>
											  <td><a href="http://45.114.141.43:88/scm-live/index.php/customer/order_view?id=DIS\OCT18\0968" class="btn btn-primary btn-xs left "><i class="fa fa-eye"></i></a></td>
										  </tr>
										 
										  <?php } ?>
										  
										</tbody>
										<tfoot>
										
											<th>Dispatch Date</th>
											<th>Order ID</th>
											<th class="width-90">SC</th>
											<th>Item Code</th>
											<th>Description</th>
											
											<th>Request date</th>
											<th>Quantity to ship</th>
											<th>Shipping Status</th>
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

