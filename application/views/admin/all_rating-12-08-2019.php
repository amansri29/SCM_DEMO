  <?php
	 include "includes/header.php";
	 ?>
	<style>
	.stars-outer {
  display: inline-block;
  position: relative;
  font-family: FontAwesome;
}
 
.stars-outer::before {
  content: "\f006 \f006 \f006 \f006 \f006";
}
 
.stars-inner {
  position: absolute;
  top: 0;
  left: 0;
  white-space: nowrap;
  overflow: hidden;
  width: 0;
}
 
.stars-inner::before {
  content: "\f005 \f005 \f005 \f005 \f005";
  color: #f8ce0b;
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
						<h3 class="left">Transporters Ratings</h3>
						<!--<a href="<?php echo base_url();?>index.php/admin/add_driver" class="btn btn-danger right">Add Driver</a>-->
					</div>
					
				<?php
							 $rt=round($rating->rating);  
                           						  
							$image1  = base_url('images/star.gif');
							    $image2  = base_url('images/star2.gif');
								$img="";
								$i=1;
								while($i<=$rt){
								$img=$img."<img height='25' widht='20' src='".$image1."' >";
								$i=$i+1;
								}
								while($i<=5){
								$img=$img."<img height='25' widht='20' src='".$image2."' >";
								$i=$i+1;
								}
							  
								?>
							  
					<div class="col-lg-12">
				   <section class="panel">
                         <header class="panel-heading">
                            <b>  Rating Information </b>
							 </div>
                          </header>
						  <div class="col-lg-12">
						   <section class="panel">
							<div class="panel-body">
									<?php
                            
								?>
									<form   role="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/get_all_rating_order_id">
									
										  <div class="col-lg-3">
									
										  <select class="js-example-basic-single" id='order' name='global_id'>
										  <option>Select Transporter name </option>
										  <?php 
								    $this->db->select('*');
								    $this->db->from('dbo.transporter'); 
									$list = $this->db->get()->result_array();
									foreach($list as $get)
									{
				                     ?>
											
											<option value="<?php echo $get['global_id']?>"><?php echo $get['name']?></option>
											 <?php } ?>
										  </select>
										  
										  </div>
										  
										 <div class="col-lg-2"> 
				                      <div class="form-group">
									  <button type="submit" id='abc' class="btn btn-danger btn-block">Search</button>
								      </div>
								</div>
								
							  </form>
							  <div class="col-lg-6">
										  <div id="over_map">
											<div style='text-align:right'>
												<!--<span class="width-120"  >Online Trucks: </span><span id="cars">0</span>-->
												<h3>Current Rating : <?php echo $img  ?></h3>
											</div>
											
							                </div>
											</div>
									</div>
								
							
						</section>
						</div>
						  <div class="col-lg-12">
						<section class="panel">
							<div class="panel-body">
							
							<?php
							 $rt=round($rating->rating);  
                             if($rt==0)
							 {
							 }
                             else	
							  {								  
							$image1  = base_url('images/star.gif');
							    $image2  = base_url('images/star2.gif');
								$img="";
								$i=1;
								while($i<=$rt){
								$img=$img."<img height='25' widht='20' src='".$image1."' >";
								$i=$i+1;
								}
								while($i<=5){
								$img=$img."<img height='25' widht='20' src='".$image2."' >";
								$i=$i+1;
								}
							  
								?>
								<div class="col-lg-12"> 
								<div class="col-lg-4">
								<div style='text-align:left'>
							 <h3>Current Rating : <?php echo $img  ?>&nbsp <?php echo '('.$rating->rating.')' ?></h3>
							 </div>
							 </div>
							 <div class="col-lg-8">
							 <div style='text-align:right'>
							 <h3 style='color:#f60'>Trans Name :  <?php echo '('.$rating->name.')' ?></h3></br>
							 </div>
							 </div>
							 </div>
							  <?php } ?>
							   <div class="col-lg-12">
							 <div style='text-align:center'>
							 <h3 style='color:#f60'>All Ratings Particular Order</h3></br>
							 </div>
							 </div>
							
							<?php 
							        if(!empty($data))
									{
										$i=0;
										 foreach ($data as $key=> $row) {
											  $i++;
											
											$order_id = $row['order_id'];
											$global_id = $row['global_id'];
											$this->db->select('*');
											$this->db->from('dbo.rating');
											$this->db->where('order_id', $order_id);
											$this->db->where('global_id', $global_id);
											$query = $this->db->get()->result_array();
											
								?>
								  
									<button id="<?php echo $key ?>" value="<?php echo $row['order_id'];?>" class='button' style=' padding: 5px;text-align: center; background-color: #e5eecc; border: solid 1px #c3c3c3; width:100%'>Order ID : <?php echo $row['order_id'];?>&nbsp Click here</button><br><br>	 
									<div id="od_<?php echo $key ?>" class='panel' style=' background-color: #e5eecc;padding: 50px; display: none;width:100%' >
									<h2>Rating (<?php echo $row['order_id'];?>) </h2>
                                     <p>All Rating : Global ID (<?php echo $row['global_id'];?>)</p>     
									
									<div class="container">
                                       <table class="table">
										<thead>
										  <tr>
											<th>Rating Type</th>
											<th>Date</th>
											<th>Rating</th>
											<th></th>
										  </tr>
										</thead>
										<tbody>
										<?php foreach ($query as $key => $res) {
										if($res['rating_type']=='Vehicle Condition')
										{
											$type='Hygiene';
										}
										if($res['rating_type']=='Customer')
										{
											$type='Customer Satisfaction';
										}
										if($res['rating_type']=='Track And Trace')
										{
											$type='Track And Trace';
										}
										if($res['rating_type']=='Accept And Assign')
										{
											$type='Timelines';
										}
										
											?>
										  <tr>
											<td><?php echo $type; ?></td>
											<td><?php echo $res['created']; ?></td>
											<td><?php echo $res['rating']; ?></td>
										  </tr>
										  
										  <?php } ?>
										  <tr><td colspan="3" style='text-align:right' ><h5 style='margin-right:150px'> Average Rating : &nbsp<?php echo $res['avg_rating']; ?> </h5></td></tr>
										  <tr><td colspan="3" style='text-align:right' ><h5 style='margin-right:150px'> Current Rating : &nbsp<?php echo  $img; ?> </h5></td></tr>
										</tbody>
									  </table>
									</div>
																		
									</div>
									<?php
									}
									} 
									else
									{
									?>
									<div class="col-lg-12">
								   <section class="panel">
									<div class="panel-body" style='height:100%'>
									<div><h3 style='text-align:center'>No Rating Found</br></br>Please Select Transporter!!!</h3></div>
									</div>
									</section>
									</div>
									<?php } ?>
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
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<script>

$(document).on('click','.button',function(){
	$id = $(this).attr('id');
	$value = $(this).val();

	$("#od_"+$id).slideToggle();
    //$("#od_"+$id).fadeToggle("slow");
  //  $("#od_"+$id).fadeToggle(3000);
});

 $(document).ready(function() {
         $(".js-example-basic-single").select2();
         
               $("#owl-demo").owlCarousel({
                   navigation : true,
                   slideSpeed : 300,
                   paginationSpeed : 400,
                   singleItem : true,
      		  autoPlay:true
      		  
      
               });
 });
</script>
  </body>
</html>

