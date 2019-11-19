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
						<h3>Milestone</h3>
					</div>
					<div class="col-lg-12">
					<?php

if(($this->session->flashdata('item'))) {

  $message = $this->session->flashdata('item');
?>
              <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
			  <?php } ?>
                      <section class="panel">
                         
							<div class="panel-body">
								<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
											<tr>
											  <th>Order ID</th>
											  <th>Driver</th>
											  <th>Pickup Address</th>
											  <th>Distance</th>
											  <th>Estimated Time</th>
											  <th>Total Time Taken</th>
											  <th>Appreciation Amount</th>
											  <th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach ($data as $get) { 
										$amount = $get['amount'];
										$driver_id = $get['driver_id'];
										$order_id = $get['order_id'];
										?>
										  <tr>
											  <td><?php echo $get['order_id']?></td>
											  <td><?php echo $get['dname']?></td>
											  <td><?php echo $get['pickup_address']?></td>
											  <td><?php echo $get['distance']?> km.</td>
											  <td><?php echo $get['estimated_time']?> Min.</td>
											  <td><?php echo $get['total_time_taken']?> Min.</td>
											  <td><?php echo $get['amount']?>  INR</td>
											  <td><a class="btn btn-primary approve" type="button" href="#confirmModal1" data-toggle="modal" name='<?php echo $get['order_id'];?>'> Approve</a>
											  </td>
										  </tr>
										<?php } ?>
										 
										</tbody>
										<tfoot>
											<th>Order ID</th>
									         <th>Driver</th>
											  <th>Pickup Address</th>
											  <th>Distance</th>
											  <th>Estimated Time</th>
											  <th>Total Time Taken</th>
											  <th>Appreciation Amount</th>
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

<div class="modal modal-dialog-center fade" id="confirmModal1">
            <div class="modal-dialog modal-sm">
              <div class="v-cell">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                    <form action="<?php echo base_url();?>index.php/admin/approve_milestone" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to Approve order Milestone?</p>
					  <input type="hidden" value='<?php echo $order_id; ?>' name='order_id' id='order-id'>
					  <input type="hidden" value='<?php echo $driver_id; ?>' name='driver_id' id='order-id'>
					  <input type="hidden" value='<?php echo $amount; ?>' name='amount' id='order-id'>
                      <div class="text-center"><br><br>
                      <button type="submit" id='save' class="btn btn-success paper-shadow relative">Yes</button>
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

    <!-- js placed at the end of the document so the pages load faster -->
	

  </body>
</html>

