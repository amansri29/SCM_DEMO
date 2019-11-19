 <?php
	 include "includes/header.php";
	 ?>
  <body>

  <section id="container" class="">
    
      <!--sidebar start-->
      <?php
	 include "includes/transporter_sidebar.php";
	 $user_id = $this->session->userdata('user_id');
	 $global_id = $this->session->userdata('global_id');
	
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
				<div class="row">
					<div class="col-lg-12">
						<h3 class="left">Drivers</h3>
						<a href="<?php echo base_url();?>index.php/transporter/add_driver" class="btn btn-danger right">Add Driver</a>
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
											  <th>Code</th>
											  <th>Name</th>
											  <th>Phone No</th>
											  <th>License No.</th>
											  <th>Valid Upto</th>
											  <th>Registered By</th>
											   <th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
										 
										  $this->db->select('d.*, t.name as trans_name');
										  $this->db->from('dbo.driver as d');
										  $this->db->where('d.global_id', $global_id );
										  $this->db->join('dbo.transporter as t', 't.user_id = d.transporter_id','left outer');
										  $query = $this->db->get();
										  $row = $query->result_array();
      									
											foreach( $row as $value ) {
											
										?>
										  <tr>
											  <td><?php echo $value['user_id'];?></td>
											  <td><?php echo $value['name'];?></td>
											  <td><?php echo $value['mobile'];?></td>
											  <td><?php echo $value['license_no'];?></td>
											  <td><?php echo $value['valid_upto'];?></td>
											  <td><?php echo $value['trans_name'];?></td>
											  <td>
											   <a href="<?php echo base_url();?>index.php/transporter/edit_driver?id=<?php echo $value['id'];?>" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
												<a class="btn btn-danger btn-xs delete" name="<?php echo $value['id'];?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></a>
											  </td>
											 
										  </tr>
										 <?php
											}
											?>
										  
							  
										</tbody>
										<tfoot>
											<th>Code</th>
											  <th>Name</th>
											  <th>Phone No</th>
											  <th>License No.</th>
											  <th>Valid Upto</th>
											  <th>Registered By</th>
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
<script>
$(function () {
 $(document).on('click',"#dynamic-table .delete",function(){
        
		
		
			var r = confirm("Are you sure want to delete driver details ");
			if (r == true) {
				var th=$(this);			
				var id = $(this).attr('name');
				
				 $.ajax({
					url:'<?php echo base_url();?>index.php/transporter/driver_delete',
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
  </body>
</html>
