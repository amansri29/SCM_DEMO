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
				  <h3 class="left">Driver Wallet</h3>
					
                      <div class="row">
                         
                          <div class="col-lg-12">
                              <!--widget start-->
							<section class="panel">
							<div class="panel-body">
								<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
										
										  <tr>
											  <th class="width-20">S.No.</th>
											  <th class="width-100">Code</th>
											  <th class="width-150">Driver Name</th>
											  <th class="width-150">Driver Contact</th>
											  <th class="width-150">Transporter</th>
											  <th class="width-100">Wallet Amount</th>
										  </tr>
										</thead>
										<tbody>
										<?php 
										$i=0;
										foreach ($data as $get)
										{
											$i++;?>
										  <tr>
											  <td><?php echo $i?></td>
											  <td><?php echo $get['duser_id']; ?></td>
											  <td><?php echo $get['dname']; ?></td>
											  <td><?php echo $get['dmobile']; ?></td>
											  <td><?php echo $get['tname']; ?></td>
											  <td><?php echo $get['wallet_amount']; ?></td>
											  
										  </tr>
										<?php } ?>
										    
										  
										</tbody>
										<tfoot>
											<th>S.No.</th>
											<th>Code</th>
											  <th>Driver Name</th>
											  <th>Driver Contact</th>
											  <th>Transporter</th>
											  <th>Wallet Amount</th>
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

