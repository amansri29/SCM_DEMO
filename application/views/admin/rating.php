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
						<h3 class="left">Transporter Rating Reports</h3>
						<!--<a href="<?php echo base_url();?>index.php/admin/add_driver" class="btn btn-danger right">Add Driver</a>-->
					</div>
					
					
					<div class="col-lg-12">
					<div id="mess1" style="display:none" class="success"><?php echo "Driver successfully deleted" ?></div>
				   <section class="panel">
                         <header class="panel-heading">
                             <b> Rating Information </b>
							 
                          </header>
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
										foreach ($data as $key=> $row) {
											
											$order_id = $row['order_id'];
											$global_id = $row['global_id'];
											$this->db->select('*');
											$this->db->from('dbo.trans_rating');
											$this->db->where('order_id', $order_id);
											$this->db->where('global_id', $global_id);
											$query = $this->db->get()->result_array();
											
								?>
								   
									<button id="<?php echo $key ?>" value="<?php echo $row['order_id'];?>" class='button' style=' padding: 5px;text-align: center; background-color: #e5eecc; border: solid 1px #c3c3c3; width:100%'><?php echo $row['order_id'];?>&nbsp Click here</button><br><br>	 
									<div id="od_<?php echo $key ?>" class='panel' style=' background-color: #e5eecc;padding: 50px; display: none;width:100%' >
									<h2>Rating (<?php echo $row['order_id'];?>) </h2>
                                     <p>All Rating : Global ID (<?php echo $row['global_id'];?>)</p>     
									
									<div class="container">
                                       <table class="table">
										<thead>
										  <tr>
											<th>#</th>
											<th>Timelines</th>
											<th>Hygiene</th>
											<th>Track And Trace</th>
											<th>Customer</th>
											<th>Average Rating</th>
									
											<th></th>
										  </tr>
										</thead>
										<tbody>
										<?php
										$i=0;
										foreach ($query as $key => $res) {
										$i++;
										
											?>
										  <tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $res['accept_and_assign']; ?></td>
											<td><?php echo $res['vehicle_condition']; ?></td>
											<td><?php echo $res['track_and_trace']; ?></td>
											<td><?php echo $res['customer']; ?></td>
											<td><?php echo $res['avg_rating']; ?></td>
										  </tr>
										  
										  <?php } ?>
										  <tr><td colspan="6" style='text-align:right' ><h4 style='margin-right:150px'> Average Rating : &nbsp<?php echo $res['avg_rating']; ?></h5></td></tr>
										  <tr><td colspan="6" style='text-align:right' ><h3 style='margin-right:150px'> Current Rating : &nbsp<?php echo $row['rating']; ?> </h5></td></tr>
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
									<div><h3 style='text-align:center'>No Rating Found</h3></div>
									</div>
									</section>
									</div>
									<?php } ?>
										
							<!--<div class="adv-table">
									<table  class="display table table-bordered table-striped" id="dynamic-table">
										<thead>
											<tr>
											  <th>Global Id</th>
											  <th>Order Id</th>
											  <th>Timelines</th>
											  <th>Hygiene</th>
											  <th>Track And Trace</th>
											  <th>Customer Satisfaction</th>
											  <th>Avg. Rating</th>
											  <!-- <th>Action</th>-->
											</tr>
										</thead>
										<tbody>
										 <?php
										 /*$data1 = [];
										foreach($data as $row){
										  $data1[$row['rating']][] = $row['rating'];
										}
										
										foreach ($data1 as $rows) {
											echo "<tr>";
											echo "<td>". $row['global_id']."</td>";
											echo "<td>". $row['order_id']."</td>";
											foreach ($rows as $answer) {
												echo "<td>" . $answer['Customer'] . "</td>";
											 } 
										    echo "<td>". $row['avg_rating']."</td>";
										    echo "<td>". $row['avg_rating']."</td>";
											echo "</tr>";
										}*/
							  ?>
										 <!-- <tr>
										  
											  <td><?php echo $get['global_id']?></td>
											  <td><?php echo $get['order_id']?></td>
											  
											  <td><?php echo $get['rating']?></td>
											  <td><?php echo $get['license_no']?></td>
											  <td><?php echo $get['valid_upto']?></td>
											  <td><?php echo $get['tname']?></td>
											  <td><?php echo $get['avg_rating']?></td>
											<!--  <td><a class='btn btn-danger btn-xs' href="<?php echo base_url();?>index.php/admin/edit_driver?id=<?php echo $get['id']?>"><i class="fa fa-pencil"></i></a>
											  <a class="btn btn-danger btn-xs delete" name="<?php echo $get['id'];?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></a>
											  </td>-->
											 
										 <!-- </tr>  -->
										  
							  
										<!--</tbody>
										<tfoot>
											<th>Code</th>
											  <th>Name</th>
											  <th>Phone No</th>
											  <th>License No.</th>
											  <th>Valid Upto</th>
											  <th>Transporter</th>
											  <th>Register By</th>
											 <!-- <th>Action</th>-->
										<!--</tfoot>
									</table>
								</div>-->
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
<script>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

$(document).on('click','.button',function(){
	$id = $(this).attr('id');
	$value = $(this).val();

	$("#od_"+$id).slideToggle();
    //$("#od_"+$id).fadeToggle("slow");
  //  $("#od_"+$id).fadeToggle(3000);
});
</script>
  </body>
</html>

