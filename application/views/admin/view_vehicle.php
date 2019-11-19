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
						<h3 class="left">Vehicles</h3>
						<!--<a href="<?php echo base_url();?>index.php/admin/add_vehicle" class="btn btn-danger right">Add Vehicle</a>-->
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
											
											  <th class="width-150">Registration No.</th>
											  <th class="width-200">Owner Name</th>
											  <th class="width-150">Registration Valid Upto</th>
											  <th class="width-150">Vehicle Type</th>
											  <th class="width-100">Capacity</th>
											  <th class="width-150">Registerd By</th>
											 <!-- <th class="width-100">Action</th>-->
											</tr>
										</thead>
										<tbody>
										<?php
										foreach ($data as $get)
							  { 
							$tid= $get['global_id'];
							  if($tid=='')
							  {
								  $register_by='Admin';
							  }
							  else
							  {
								  $register_by=$get['name'];
							  }
							  ?>
										  <tr>
											  <td><?php echo $get['registration_no']?></td>
											  <td><?php echo $get['owner_name']?></td>
											  <td><?php echo $get['valid_upto']?></td>
											  <td><?php echo $get['vehicle_type']?></td>
											  <td><?php echo $get['capacity']?></td>
											  <td><?php echo $register_by?></td>
											  <!-- <td><a class='btn btn-danger btn-xs' href="<?php echo base_url();?>index.php/admin/edit_vehicle?id=<?php echo $get['id']?>"><i class="fa fa-pencil"></i></a>
											  <a class="btn btn-danger btn-xs delete" name="<?php echo $get['id'];?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></a>
											  </td>-->
											  
										  </tr>
										 
							  <?php } ?>
										</tbody>
										<tfoot>
											<th >Registration No.</th>
											  <th >Owner Name</th>
											  <th>Registration Valid Upto</th>
											  <th>Vehicle Type</th>
											  <th>Capacity</th>
											  <th>Registerd By</th>
											 <!-- <th>Action</th>-->
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
<script>
$(function () {
 $(document).on('click',"#dynamic-table .delete",function(){
        
		
		
			var r = confirm("Are you sure want to delete vehicle details ");
			if (r == true) {
				var th=$(this);			
				var id = $(this).attr('name');
				
				 $.ajax({
					url:'<?php echo base_url();?>index.php/admin/vehicle_delete',
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

