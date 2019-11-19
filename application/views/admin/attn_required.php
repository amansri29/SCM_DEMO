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
				  <h3 class="left">Attention Required</h3>
					
                      <div class="row">
                         
                          <div class="col-lg-12">
						  <?php

if(($this->session->flashdata('item'))) {

  $message = $this->session->flashdata('item');

  ?>
              <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
              <?php

}else{

}

?>
                              <!--widget start-->
							<section class="panel">
							<div class="panel-body">
								<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table1">
								<thead>
									<tr>
										<th class="width-150">Dispatch Date</th>
										<th class="width-80">Order ID</th>
										<th class="width-80">SC</th>
										<th class="width-150">Item Code</th>
										<th class="width-250">Description</th>
										<th class="width-200">Route</th>
										<th class="width-200">Planned date</th>
										<th class="width-200">Qty_to_ship</th>
										<th class="width-150">Customer Name</th>
										<th class="width-150">Shipment Name</th>
										<th class="width-200">Transporter Name</th>
										<th class="width-200">Reason</th>
										
										<th class="width-100 text-center">Action</th>
									</tr>
									
								</thead>
                              <tbody>
							   <?php 
							 // print_r($data); die;
							  foreach ($attn_required as $get)
							  {
								   $state_code = $get['state_code'];
								  $company = $get['company'];
								  $qty_to_ship = explode(',', $get['qty_to_ship']);
								  $item_code = explode(',', $get['item_code']);
								  $description = explode(',', $get['description']);
								   $planned_delivery_date = explode(',', $get['planned_delivery_date']);
								  $route = explode(',', $get['route']);
									/* foreach($qty_to_ship as $qty_key => $qty) { */
                                        if(in_array(0, $qty_to_ship, true))
										 {
										   
										 }
										 else{
										 
										
									
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
								  <td><?php echo $get['trans_name']?></td>
								  <td><?php echo $get['reason']?></td>
								  <?php if($get['sales_status']=='Reopened') { ?>
									 <td class=''><a class='btn btn-danger blink-one width-150'><?php echo $get['sales_status']?> </button></td>
									<?php } else if($get['sales_status']=='Released') {?>
								  <td>                                    
									<a class='btn btn-primary btn-xs open' name='<?php echo $get['order_id'];?>' data-toggle="modal" href="#myModal6" type="button"><i class="fa fa-legal"></i></a>
									<a class='btn btn-danger btn-xs update' id="<?php echo $get['delivery_date']?>" value='<?php echo $get['order_id']?>' name='<?php echo $get['trans_name']?>' data-toggle="modal" company='<?php echo $get['company']?>' href="#myModal1" type="button"><i class="fa fa-pencil"></i></a>
									</td><?php } ?>
                              </tr>
							  <?php } }  ?>
                            
                              </tbody>
							  <tfoot>
										
											<th>Dispatch Date</th>
											<th>Order ID</th>
											<th class="width-80">SC</th>
											<th>Item Code</th>
											<th>Description</th>
											<th>Route</th>
											<th>Planned date</th>
											<th>Quantity to ship</th>
											<th>Customer Name</th>
											<th>Shipment Name</th>
											<th>Transporter Name</th>
											<th>Reason</th>
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
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<h4 class="modal-title">Confirmation</h4>
										  </div>
										  <div class="modal-body">
											<form action="<?php echo base_url();?>index.php/admin/open_for_bid_order" method="post" enctype="multipart/form-data" >
											 <p>Are you sure you want to open order for bid?</p>
											  <input type="hidden" value='' name='open_bid_id' id='open_bid_id'>
											  
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

							<div class="modal fade modal-dialog-center" id="myModal1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content-wrap">
									   <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>index.php/admin/update_order_detail">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title">Edit Details</h4>
                                              </div>
											 <input type='hidden' id="orderid" name="order_id" value=''>
                                              <div class="modal-body">
												<div class="">
												  <div class="form-group">
													 <input type="hidden" id="trans_name" value="">
													  <div class="col-md-12">
												
														<select class="js-example-basic-single" id="transporter_id" name="transporter_id">
														
												
														
														
													</select>
														  
													  </div>
												  </div>
												  <div class="form-group">
													 
													  <div class="col-md-11">
														
														 <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" class="input-append date dpYears">
															  <input type="text" readonly="" size="16" id='delivery_date' name="delivery_date" class="form-control">
															  <span class="input-group-btn add-on">
																<button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
															  </span>
															</div> 
														  <span class="help-block">Select Dispatch Date</span>
													  </div>
												  </div>
												  </div>
												</div>
                                              <div class="modal-footer">
                                                  <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                                  <button class="btn btn-danger" type="submit"> Submit</button>
                                              </div>
                                          </div>
										  </form>
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
		  
		  $('.update').on('click',function(){
			$id = $(this).attr("value");
			$trans_name = $(this).attr("name");
			$delivery_date = $(this).attr("id");
			/* alert($id); */
			$('#orderid').val($id);
			$('#delivery_date').val($delivery_date);
			$('#trans_name').val($trans_name);
			$company = $(this).attr("company");
			
			$.ajax({
				
                type:'post',
                url:'<?php echo base_url();?>index.php/admin/transporter_list',
                data:'company='+$company,
                success:function(res){
					/*  alert(res); */
					var obj= jQuery.parseJSON(res);
					if(obj){         
						 $(obj).each(function(){       
						var option = $('<option />'); 
						if(this.name == $trans_name)
						{
							option.attr({'value': this.user_id, 'selected':"selected"}).text(this.name+' ('+this.state_code+')');  
						}
						else
						{
							option.attr('value', this.user_id).text(this.name+' ('+this.state_code+')');  
						}
						
						$('#transporter_id').append(option);     
						});              
					 }
					else{		
						$('#transporter_id').html('<option value="">Transporter not available</option>');  
					}      
                }
			});    
			 
        });
      });
  </script>
    <!-- js placed at the end of the document so the pages load faster -->
<script>
	$(document).ready(function(){
	$("#dynamic-table1").dataTable();
	
	});
	$( "#dynamic-table1 tbody tr" ).on( "click", function() {
  console.log( $( this ).text() );
});

$('.open').click(function() {
           $id = $(this).attr("name");
			$('#open_bid_id').val($id);
        });
	
</script>
  </body>
</html>

