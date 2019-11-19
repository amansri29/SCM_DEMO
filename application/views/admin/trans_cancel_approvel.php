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
						<h3 class="left">Transporter Cancel Approvel Orders</h3>
					</div>
					
					
					<div class="col-lg-12">
					<div id="mess1" style="display:none" class="success"><?php echo "Driver successfully deleted" ?></div>
					<?php

if(($this->session->flashdata('item'))) {

  $message = $this->session->flashdata('item');

  ?>
              <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
              <?php

}else{

}
?>
                      <section class="panel">
                         
							<div class="panel-body">
								<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
											<tr>
											  <th>Order Id</th>
											  <th>SC</th>
											  <th>driver Name</th>
											  <th>Transporter Name</th>
											  <th>Vehicle Number.</th>
											  <th>Reason</th>
											   <th>Action</th>
											</tr>
										</thead>
										<tbody>
										 <?php
										 
										  foreach ($data as $get)
										{ 
										
										
							  ?>     
										  <tr>
                                  <td><strong><a href='<?php echo base_url();?>index.php/admin/order_view?id=<?php echo $get['order_id']?>'><?php echo $get['order_id']?></a></strong><br>
								  <?php echo $get['company']?>
								  </td>
											  <td><?php echo $get['state_code']?></td>
											  <td><?php echo $get['dname']?></td>
											  <td><?php echo $get['tname']?></td>
											  <td><?php echo $get['registration_no']?></td>
											  <td><?php echo $get['change_reason']; ?></td>
											
											  <td><a class="btn btn-danger accept" type="button" href="#confirmModal1" data-toggle="modal" id='<?php echo $get['cid'];?>' name='<?php echo $get['order_id'];?>'> Accept</a>
													<a class="btn btn-default reject" type="button" href="#confirmModal" data-toggle="modal" id='<?php echo $get['cid'];?>' name='<?php echo $get['order_id'];?>'> Reject</a>
											  </td>
											 
										  </tr>
										   <div class="modal modal-dialog-center fade"  id="confirmModal1">
            <div class="modal-dialog modal-sm">
              <div class="v-cell">
                <div class="modal-content" style="width:415px;">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url();?>index.php/admin/cancel_accept_order" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to Accept order Approvel?</p>
					  <input type="hidden" value='' name='order-id' id='order-id'>
					  <input type="hidden" value='' name='accept_id' id='accept_id'>
					  <div class="form-group">
													  <label class="col-lg-3 col-sm-2 control-label">Transporter</label>
														<div class="col-lg-8">
															<select class="js-example-basic-single " id='Transporter' name='trans_no' required>
																<option disabled value="0">Select Transporter</option>
											<?php
												$this->db->select('t.global_id as global_id,t.name as name');
												$this->db->from('dbo.transporter as t');
												$this->db->where('t.name!=','');
												$this->db->where('t.company',$get['company']);
												$query = $this->db->get();
												$rows = $query->result_array();
												foreach( $rows as $value ) {
													if($value['global_id'] == $get['global_id'])
													{
														
											?>
												
													<option value="<?php echo $value['global_id']?>" selected ><?php echo $value['name'].' ('.$get['state_code'].')'?></option>
											<?php
														
													}
													else
													{
														
												?>
													<option value="<?php echo $value['global_id']?>" ><?php echo $value['name']. ' ('.$get['state_code'].')'?></option>
												<?php
												
													}
												}
											?>				
																
																
															</select><br><br>
														</div>
													</div>
													<div class="form-group">
													<label for="lr_rr_date" class="col-lg-3 col-sm-2 control-label">Delivery Date</label>
													<div data-date-viewmode="years" data-date-format="dd-mm-yyyy" class="input-append date dpYears col-lg-8">
													<?php 	$this->db->select('*');
														$this->db->from('dbo.order_details as od');
														$this->db->join("dbo.sales_dispatched_order as sdo", "od.order_id = sdo.order_id","left outer");
														$query = $this->db->get();
														$rows = $query->row();
													
															 if($rows->delivery_date == $get['delivery_date'])
													   {
										       	?>
															 
															  <input type="text" readonly="" size="5" name="delivery_date" id='delivery_d' value='<?php echo $rows->delivery_date  ?>' class="form-control" required>
															  
															  <span class="input-group-btn add-on">
																<button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
															  </span>
														 <?php } ?>
															</div> <br><br>
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
							  <?php } ?>
										  
							  
										</tbody>
										<tfoot>
											<th>Order Id</th>
											<th>SC</th>
											  <th>driver Name</th>
											  <th>Transporter Name</th>
											  <th>Vehicle Number.</th>
											   <th>Reason</th>
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

<div class="modal modal-dialog-center fade" id="confirmModal">
            <div class="modal-dialog modal-sm">
              <div class="v-cell">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url();?>index.php/admin/cancel_reject_order" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to Reject order Approvel?</p>
					  <input type="hidden" value='' name='order_id' id='order_id'>
					  <input type="hidden" value='' name='reject_id' id='reject_id'>
					  
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
		  <!--<div class="modal modal-dialog-center fade"  id="confirmModal1">
            <div class="modal-dialog modal-sm">
              <div class="v-cell">
                <div class="modal-content" style="width:415px;">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url();?>index.php/admin/cancel_accept_order" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to Accept order Approvel?</p>
					  <input type="hidden" value='' name='order-id' id='order-id'>
					  <input type="hidden" value='' name='accept_id' id='accept_id'>
					  <div class="form-group">
													  <label class="col-lg-3 col-sm-2 control-label">Transporter</label>
														<div class="col-lg-8">
															<select class="js-example-basic-single " id='Transporter' name='trans_no' required>
																<option value="0">Select Transporter</option>
																<?php
															$this->db->select('*');
															$this->db->from('dbo.transporter');
															$query = $this->db->get();
															$row = $query->result_array();
														
															foreach( $row as $value ) {
														?>
															
																<option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
														<?php
															}
														?>	
																
																
															</select><br><br>
														</div>
													</div>
													<div class="form-group">
													<label for="lr_rr_date" class="col-lg-3 col-sm-2 control-label">Delivery Date</label>
													<div data-date-viewmode="years" data-date-format="dd-mm-yyyy" class="input-append date dpYears col-lg-8">
															  <input type="text" readonly="" size="5" name="delivery_date" id='delivery_d' class="form-control" required>
															  <span class="input-group-btn add-on">
																<button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
															  </span>
															</div> <br><br>
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
          </div>-->

      <!--footer start-->
       <?php
	 include "includes/footer.php";
	 ?>
      <!--footer end-->
  </section>
<script>

$(document).ready(function () {
		  
		  $('.reject').click(function() {
           $id = $(this).attr("name");
           $oid = $(this).attr("id");
			$('#order_id').val($id);
			$('#reject_id').val($oid);
        });
	    
		  $('.accept').click(function() {
           $id = $(this).attr("name");
           $cid = $(this).attr("id");
			$('#order-id').val($id);
			$('#accept_id').val($cid);
        });
	  });
	  
$(function () {
	  
		
	
		
 $(document).on('click',"#dynamic-table .delete",function(){
        
		
		
			var r = confirm("Are you sure want to delete driver details ");
			if (r == true) {
				var th=$(this);			
				var id = $(this).attr('name');
				
				 $.ajax({
					url:'<?php echo base_url();?>index.php/admin/driver_delete',
					type:'post',
					data:{'id':id},
					success:function(cancel){
						console.log(cancel);
						if(cancel==1){
							th.hide();
							var mess = document.getElementById('mess1');
							mess.style.display ="block";
							setTimeout(location.reload(), 15000);
					
						}
						else{
						  alert("err");
						}
					}
				});   								
			}

        });
		
	});
</script>
    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>

