 <?php
	 include "includes/header.php";
	 ?>
  <body>

  <section id="container" class="">
    
      <!--sidebar start-->
      <?php
	 include "includes/transporter_sidebar.php";
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
		 <?php

if(($this->session->flashdata('item'))) {

  $message = $this->session->flashdata('item');

  ?>
              <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
              <?php

} ?>
              <!-- page start-->
              <div class="row">
                
                  <div class="col-lg-12">
				  <h3 class="left">Delivered Orders</h3>
					
                      <div class="row">
                         
                          <div class="col-lg-12">
                              <!--widget start-->
							<section class="panel">
							<div class="panel-body">
								<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
										  <tr>
											   <th class="width-80">Order ID</th>
											   <th class="width-50">SC</th>
									          <th class="width-100">Trans. Company</th>
												<th class="width-200">Item Code</th>
												<th class="width-250">Description</th>
												<th class="width-100">Quantity</th>
												<th class="width-250">route</th>
												<th class="width-150">Dispatch Date</th>
											  <th class="width-200">Status</th>
										  </tr>
										</thead>
										<tbody>
										<?php
										 
										  foreach( $completed_orders as $value ) {
											$items = explode(',', $value['item_code']);
											$descriptions = explode(',', $value['description']);
											$quantity = explode(',', $value['qty_to_ship']);
											$route = explode(',', $value['route']);
											$order_status = $value['order_status'];
											
											
										?>
										  
										 
										 
									     <tr>
											  <td><a href='<?php echo base_url();?>index.php/transporter/order_view?id=<?php echo $value['order_id'];?>'><?php echo $value['order_id'];?></a></td>
											  <td><?php echo $value['state_code'];?></td>
									          <td><?php echo $value['company'];?></td>
											  <td><?php foreach($quantity as $qty_key => $qty) {
												 if ($qty > '0')
												 {
												  if (array_key_exists($qty_key, $items)) {
														print($items[$qty_key].'<br>');   
												 }}}?></td>
											  <td><?php foreach($quantity as $qty_key => $qty) {
												 if ($qty > '0')
												 {
												  if (array_key_exists($qty_key, $descriptions)) {
														print($descriptions[$qty_key].'<br>');   
												 }}}?></td>
											  <td><?php foreach($quantity as $qty_key => $qty) {
												 if ($qty > '0')
												 {
												  if (array_key_exists($qty_key, $quantity)) {
														print($quantity[$qty_key].'<br>');   
												 }}}?></td>
											  <td><?php foreach($quantity as $qty_key => $qty) {
												 if ($qty > '0')
												 {
												  if (array_key_exists($qty_key, $route)) {
														print($route[$qty_key].'<br>');   
												 }}}?></td>
											 
											  <td><?php echo $value['posting_date'] ?></td>
											  <td><?php echo $value['order_status'] ?></td>
										 
										  </tr>
										 <?php
											
											
										  }
										  ?>
											
										</tbody>
										<tfoot>
										  <th>Order ID</th>
										    <th class="width-50">SC</th>
									        <th class="width-150">Company</th>
											<th >Item Code</th>
											<th>Description</th>
											<th>Quantity</th>
											<th>route</th>
											<th>Dispatch Date</th>
											  <th>Status</th>
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


	
  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
			  autoPlay:true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

      $(window).on("resize",function(){
          var owl = $("#owl-demo").data("owlCarousel");
          owl.reinit();
      });

  </script>

  </body>
</html>
