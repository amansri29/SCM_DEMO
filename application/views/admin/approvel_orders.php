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
						<h3 class="left">Approvel Orders</h3>
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
											  <th>driver Name</th>
											  <th>Transporter Name</th>
											  <th>Vehicle Number.</th>
											  <th>Delivery Date</th>
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
											  <td><?php echo $get['order_id']?></td>
											  <td><?php echo $get['dname']?></td>
											  <td><?php echo $get['tname']?></td>
											  <td><?php echo $get['registration_no']?></td>
											  <td><?php echo $get['delivery_date']?></td>
											  <td><?php 
											  if($get['did']!=$get['ocd_driver_id'])
											  {
											  $reason='Driver Changed';
											   print($reason.'<br>');  
											  }
											   if($get['dveh_id']!=$get['ocdveh_id'])
											  {
											   $reason='Vehicle Changed';
											   print($reason.'<br>');  
											  }
											   if($get['del_id']!=$get['ocd_del_date'])
											  {
											  $reason='Delivery Date Changed';
											   print($reason.'<br>'); 
											  }
											  echo "<span style='font-weight: bold;'>Reason:</span>".$get['change_reason'];
											  
											  ?></td>
											
											  <td><a class="btn btn-danger accept" type="button" href="#confirmModal1" data-toggle="modal" id='<?php echo $get['ocd_id'] ?>' name='<?php echo $get['order_id'];?>'> Accept</a>
													<a class="btn btn-default reject" type="button" href="#confirmModal" data-toggle="modal" id='<?php echo $get['ocd_id'] ?>' name='<?php echo $get['order_id'];?>'> Reject</a>
											  </td>
											 
										  </tr>
							  <?php } ?>
										  
							  
										</tbody>
										<tfoot>
											<th>Order Id</th>
											  <th>driver Name</th>
											  <th>Transporter Name</th>
											  <th>Vehicle Number.</th>
											  <th>Delivery Date</th>
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
                    <form action="<?php echo base_url();?>index.php/admin/reject_order" method="post" enctype="multipart/form-data" >
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
		  <div class="modal modal-dialog-center fade" id="confirmModal1">
            <div class="modal-dialog modal-sm">
              <div class="v-cell">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url();?>index.php/admin/accept_order" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to Accept order Approvel?</p>
					  <input type="hidden" value='' name='order-id' id='order-id'>
					  <input type="hidden" value='' name='accept_id' id='accept_id'>
					  
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
           $cid = $(this).attr("id");
			$('#order_id').val($id);
			$('#reject_id').val($cid);
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

