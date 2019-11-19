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
						<h3 class="left">Users</h3>
						<a href="<?php echo base_url();?>index.php/admin/add_scanner_user" class="btn btn-danger right">Add Scanner Users</a>
					</div>
					
					
					<div class="col-lg-12">
					<div id="mess1" style="display:none" class="success"><?php echo "users successfully deleted" ?></div>
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
											  <th>S.No</th>
											  <th>Name</th>
											  <th>Phone No</th>
											  <th>Email</th>
											<th>User Type</th>
											   <th>Action</th>
											</tr>
										</thead>
										<tbody>
										 <?php
										 $i=1;
										  foreach ($data as $get)
										{ 
										 
							  ?>
										  <tr>
											  <td><?php echo $i++ ?></td>
											  <td><?php echo $get['name']?></td>
											  <td><?php echo $get['mobile']?></td>
											  <td><?php echo $get['email']?></td>
											  <td><?php echo $get['user_type']?></td>
											  <td><a class='btn btn-danger btn-xs' href="<?php echo base_url();?>index.php/admin/edit_scanner_user?id=<?php echo $get['id']?>"><i class="fa fa-pencil"></i></a>
											  <a class="btn btn-danger btn-xs delete" name="<?php echo $get['id'];?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></a>
											  </td>
											 
										  </tr>
							  <?php } ?>
										  
							  
										</tbody>
										<tfoot>
											<th>S.No</th>
											  <th>Name</th>
											  <th>Phone No</th>
											  <th>Email</th>
											  <th>User type</th>
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
$(function () {
 $(document).on('click',"#dynamic-table .delete",function(){
        
		
		
			var r = confirm("Are you sure want to delete driver details ");
			if (r == true) {
				var th=$(this);			
				var id = $(this).attr('name');
				
				 $.ajax({
					url:'<?php echo base_url();?>index.php/admin/scanner_user_delete',
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

