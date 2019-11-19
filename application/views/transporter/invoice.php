 <?php
	 include "includes/header.php";
	 ?>
  <body>

  <section id="container" class="">
    
      <!--sidebar start-->
      <?php
	 include "includes/transporter_sidebar.php";
	  $user_id = $this->session->userdata('user_id');
	  $order_id = $this->input->get('order_id');
	 ?>
      <!--sidebar end-->
      <!--main content start-->
       <section id="main-content">
          <section class="wrapper">
              <!-- invoice start-->
              <section>
                  <div class="panel panel-primary">
                      <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                      <div class="panel-body">
                          <div class="row invoice-list">
                              <div class="text-center corporate-id">
                                  <h1 class="highlight">Transport Management System</h1>
                              </div>
							  <input type='hidden' value='<?php  echo $order_id;?>' id='order_id'>
					<?php
						
						$this->db->select('*,c.mobile as customer_mobile');
						$this->db->from('dbo.order_details as od');
						$this->db->join('dbo.sales_dispatched_order as sdo','od.order_id = sdo.order_id ' , 'LEFT OUTER');
						$this->db->join('dbo.transporter as t', 't.user_id = od.trans_no','left outer');
						$this->db->join('dbo.customer as c', 'c.user_id = od.cust_no','left outer');
						$this->db->where('od.order_id', $order_id );
					 
						$row = $this->db->get()->result_array();
						/* print_r($row); */
						foreach($row as $value)
						{
					?>
                              <!--<div class="col-lg-4 col-sm-4">
                                  <h4>BILLING ADDRESS</h4>
                                  <p>
                                      Jonathan Smith <br>
                                      44 Dreamland Tower, Suite 566 <br>
                                      ABC, Dreamland 1230<br>
                                      Tel: +12 (012) 345-67-89
                                  </p>
                              </div>-->
                              <div class="col-lg-4 col-sm-4">
								<h4 class='highlight'><?php echo $value['order_id'];?></h4>
                                  <h4>SHIPPING ADDRESS</h4>
                                  <p>
                                      <?php echo $value['ship_to_address'];?><br>
									  <?php if($value['customer_mobile'] !=''){?>
                                      P: <?php echo $value['customer_mobile'];?><br><?PHP } ?>
                                      
                                  </p>
                              </div>
                              <!--<div class="col-lg-4 col-sm-4">
                                  <h4>INVOICE INFO</h4>
                                  <ul class="unstyled">
                                      <li>Invoice Number		: <strong>69626</strong></li>
                                      <li>Invoice Date		: 2013-03-17</li>
                                      <li>Due Date			: 2013-03-20</li>
                                      <li>Invoice Status		: Paid</li>
                                  </ul>
                              </div>-->
                          </div>
                          <table class="table table-striped table-hover">
                              <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Item Code</th>
                                  <th class="hidden-phone">Description</th>
                                  
                                  <th class="">Quantity</th>
                                  
                              </tr>
                              </thead>
                              <tbody>
							  <?php
									$items = explode(',', $value['item_code']);
									$descriptions = explode(',', $value['description']);
									$quantity = explode(',', $value['qty_to_ship']);
									$count = count($items);
									
									for($i = 0; $i < $count ; $i++)
									{
										$j = $i+1;
										if($quantity[$i] != 0)
										{
										echo"<tr>
											<td>".$j."</td>
											<td>".$items[$i]."</td>
											<td class='hidden-phone'>".$descriptions[$i]."</td>
										  
											<td class=''>".$quantity[$i]."</td>
											
										</tr>";
										}
									}
								?>
                              
                              </tbody>
                          </table>
                          <div class="row">
						  <div class="col-lg-12">
                              <div class="col-lg-2 left padding">
								
								<img src="" id='result'>
									
								
								
								<div class="margin-top" style='margin-left: -25px;'><a class="btn btn-danger btn-lg" href="<?php echo base_url();?>index.php/transporter/print_qr?order_id=<?php echo $value['order_id']; ?>">Scan for Gate IN & OUT </a></div>
								
                              </div>
							  
							 </div>
                          </div>
						   
                          <div class="text-center invoice-btn">
                              
                              <a class="btn btn-info btn-lg" onClick="javascript:window.print();"><i class="fa fa-print"></i> Print </a>
                          </div>
                      </div>
					 
                  </div>
				  <?php
						}
						?>
              </section>
              <!-- invoice end-->
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
	
   
	$order_id = $('#order_id').val();
	
	//alert($order_id);
	var url=" https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" + $order_id;
	document.getElementById('result').src = url; 
	
	
});

</script>
	
 

  </body>
</html>
