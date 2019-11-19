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
						<h3 class="left">Customers</h3>
						<!--<a href="add-client.html" class="btn btn-danger right">Add Client</a>-->
					</div>
					<div class="col-lg-12">
                      <section class="panel">
                         
							<div class="panel-body">
								<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
											<tr>
											 <th>Code</th>
											  <th>Global Id</th>
											  <th>Name</th>
											  <th>City</th>
											  <th>State Code</th>
											  <th>Company</th>
											  <th>Contact Person</th>
											  <th>Phone No</th>
											  <th>Email</th>
											  <th>Credit Limit</th>
											</tr>
										</thead>
										
										
										<tbody>
										<?php
										  foreach ($data as $get)
							  { ?>
										  <tr>
											   <td><?php echo $get['user_id']?></td>
											  <td><?php echo $get['global_id']?></td>
											  <td><?php echo $get['name']?></td>
											  <td><?php echo $get['city']?></td>
											  <td><?php echo $get['state_code']?></td>
											  <td><?php echo $get['company']?></td>
											  <td><?php echo $get['contact_person']?></td>
											  <td><?php echo $get['mobile']?></td>
											  <td><?php echo $get['email']?></td>
											  <td><?php echo $get['credit_limit']?></td>
										  </tr>
							  <?php } ?>
							  
										</tbody>
										<tfoot>
											  <th>Code</th>
											 <th>Global Id</th>
											  <th>Name</th>
											  <th>City</th>  
											  <th>State Code</th>
											  <th>Company</th>
											  <th>Contact Person</th>
											  <th>Phone No</th>
											  <th>Email</th>
											  <th>Credit Limit</th>
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



      <!--footer start-->
       <?php
	 include "includes/footer.php";
	 ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>
