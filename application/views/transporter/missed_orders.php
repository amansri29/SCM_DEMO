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
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
           <section class="wrapper">
              <!-- page start-->
              <div class="row">
                
                  <div class="col-lg-12">
				  <h3 class="left">Missed Orders</h3>
					
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
									<table  class="display table table-bordered table-striped" id="dynamic-table">
								<thead>
									<tr>
										<th class="width-150">Dispatch Date</th>
										<th class="width-80">Order ID</th>
										<th class="width-150">State Code</th>
									     
										<th class="width-150">Item Code</th>
										<th class="width-250">Description</th>
										<th class="width-200">Route</th>
										<th class="width-200">Planned date</th>
										<th class="width-200">Qty_to_ship</th>
										
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
									/* foreach($qty_to_ship as $qty_key => $qty) { */
                                        if(in_array(0, $qty_to_ship, true))
										 {
										   
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
								 
								  <td><?php echo $get['reason']?></td>
								
                                  
                              </tr>
							  <?php } } ?>
                            
                              </tbody>
							  <tfoot>
										
											<th>Dispatch Date</th>
											<th>Order ID</th>
											<th class="width-150">State Code</th>
									      
											<th>Item Code</th>
											<th>Description</th>
											<th>Route</th>
											<th>Planned date</th>
											<th>Quantity to ship</th>
											<th>Reason</th>
											
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
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  <h4 class="modal-title">Are you sure you want to open order for bid?</h4>
                                              </div>
                                              <!--<div class="modal-body">

                                                  Body goes here...

                                              </div>-->
                                              <div class="modal-footer">
                                                  <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                                                  <button class="btn btn-danger" type="button"> Yes</button>
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
			
			$.ajax({
				
                type:'post',
                url:'<?php echo base_url();?>index.php/admin/transporter_list',
                
                success:function(res){
					/*  alert(res); */
					var obj= jQuery.parseJSON(res);
					if(obj){         
						 $(obj).each(function(){       
						var option = $('<option />'); 
						if(this.name == $trans_name)
						{
							option.attr({'value': this.user_id, 'selected':"selected"}).text(this.name);  
						}
						else
						{
							option.attr('value', this.user_id).text(this.name);  
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

  </body>
</html>

