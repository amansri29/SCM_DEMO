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
						<h3 class="left">Bid Applied from Transporter</h3>
						
					</div>
					<div class="col-md-12">
                      <section class="panel">
                          <div class="panel-body">
							<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
										  <tr>
											  <th class="width-80">Order ID</th>
                                    <th class="width-200">Bidding Date</th>
                                    <th class="width-250">Bidding Time</th>
                                    <th class="width-200">Lowest Bid</th>
                                    <th class="width-200">Transporter Name</th>
                                    <th class="width-100">Current Bid</th>
										  </tr>
										</thead>
										<tbody>
										<?php
			
                                    /* print_r($open_orders); */
                                    foreach ($get_bid_applied_order as $get)
                                    {
                                    $created =   date('m-d-Y' ,strtotime($get['created']));
                                    $time = date('H:i:s',strtotime($get['created']));
                                    $pickup_date =  date('m-d-Y' ,strtotime($get['pickup_date']));
                                    $fleet_type =  $get['fleet_type'];
                                    $transit_time = $get['transit_time'];
                                    $comments = $get['comments'];
                                    $amount =  $get['amount'];
                                    $trans_name =  $get['trans_name'];

                                       $this->db->select('MIN(bid_amount) as lowest_amount, unit');
                                       $this->db->from('dbo.bidding_orders');
                                       $this->db->where('order_id', $get['order_id']);
                                       $this->db->group_by('unit'); 
                                       $q2 = $this->db->get()->row();              
                                    ?>
                                 <tr>
                                    <td><a href='<?php echo base_url();?>index.php/admin/order_overview?id=<?php echo $get['order_id']?>'><?php echo $get['order_id']?></a></td>
                                    <td><?php echo $created; ?></td>
                                    <td><?php echo $time; ?></td>
                                    <td> <strong class="highlight" style="font-size:20px;"><?php echo $q2->lowest_amount ; ?> <span style="font-size:15px;"><?php echo $q2->unit; ?></span></strong></td>
                                    <td><?php echo $get['trans_name']?></td>
                                    <td><?php echo $amount?></td>
                                   
                                 </tr>
                                 <?php
                                    }
                                    ?>
										 
										</tbody>
										<tfoot>
											  <th class="width-80">Order ID</th>
                                    <th class="width-200">Bidding Date</th>
                                    <th class="width-250">Bidding Time</th>
                                    <th class="width-200">Lowest Bid</th>
                                    <th class="width-200">Transporter Name</th>
                                    <th class="width-100">Current Bid</th>
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
 <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.countdown.min.js"></script>
	
	 <script>
		 $(function(){
			  
			$('.countdown').each(function(){
				$a=$(this).attr('value');
				//alert($a);
				$(this).countdown($(this).attr('value'), function(event) {
				$(this).text(
				event.strftime('%D %H:%M:%S')
			  );
				});
			});
		});
     </script>

    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>

