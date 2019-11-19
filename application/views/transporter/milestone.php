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
			 <div class="row">
				<div class="col-lg-12">
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
						<header class="panel-heading">
                              Add Milestone
                          </header>
						<div class="panel-body">
							<div class="form-group">
								  <label class="col-lg-3 col-sm-2 control-label">Order</label>
									<div class="col-lg-7">
										<select class="js-example-basic-single " id='order' name='order'>
											<option value="0">Select Order</option>
											<?php
											  $this->db->select('*');
											  $this->db->from('dbo.order_details');
											  $this->db->where('global_id', $global_id );
											  $this->db->where('order_status', 'Inprocess' );
											  $this->db->where('gps_enabled', 'no' );
												$query = $this->db->get();
												$row = $query->result_array();
										
											foreach( $row as $value ) {
											?>
												
													<option value="<?php echo $value['order_id']?>"><?php echo $value['order_id']?></option>
											<?php
												}
											?>	
											
											
										</select>
									</div>
									<div class="col-lg-1">
												<a class="btn btn-primary btn-sm add_field_button"><i class="fa fa-plus"></i></i></a>
											</div>
									
									
								</div>
							<form action="<?php echo base_url();?>index.php/transporter/add_location" method="post" class='form-horizontal' enctype="multipart/form-data" >
								<div class="form-group">
								<input type="hidden" value="" id="order_id" name="order_id">
								 									
								</div>
								<div class="input_fields_wrap">
								<div class="panel panel-default ">
									<div class="panel-body" name="mytext[]">
										<div class="form-group">
										<input type="hidden" value="" name="id[]">
										  <label class="col-lg-3 col-sm-2 control-label">Address</label>
											<div class="col-lg-7">
												<input type="text" class="form-control" id="address" required name="address[]" placeholder="Enter Address">
											</div>
											
										</div>
										<div class="form-group">
										  <label class="col-lg-3 col-sm-2 control-label">Date & Time</label>
											<div class="col-lg-3">
												<input size="16" type="date" placeholder="dd-mm-yy"  data-date-format="DD-MM-YYYY" required name="date[]" class="form-control">
											</div>
											<div class="col-lg-3">
												<input size="16" type="time" placeholder="H:i" required name="time[]" class="form-control">
											</div>
											
										</div>
									</div>
								</div>
								</div>
									<div class="form-group">
									  <div class="col-lg-offset-5 col-lg-2">
									  <button type="submit" class="btn btn-danger">Add</button>
									  </div>
								</div>
							</form>
						</div>
					</section>
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


<script type="text/javascript">

$(document).ready(function () {
       var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
		
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
          

			$(wrapper).append('<div class="panel panel-default input_fields_wrap"><div class="panel-body" name="mytext[]"><div class="form-group"><input type="hidden" value="" name="id[]"><label class="col-lg-3 col-sm-2 control-label">Address</label><div class="col-lg-7"><input type="text" class="form-control" required name="address[]" id="address" placeholder="Enter Address">	</div><div class="col-lg-1"><a class="btn btn-danger btn-sm remove_field"><i class="fa fa-minus"></i></i></a></div></div><div class="form-group"><label class="col-lg-3 col-sm-2 control-label">Date & Time</label><div class="col-lg-3"><input size="16" type="date" required name="date[]" placeholder="dd-mm-yy" data-date-format="DD-MM-YYYY" class="form-control"></div><div class="col-lg-3"><input size="16" type="time" required name="time[]" placeholder="H:i" class="form-control"></div></div></div></div>');			//add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').parent().remove(); x--;
    });

	
	$('#order').on('change',function()
	{
		 var wrapper         = $(".input_fields_wrap"); 
		$id = $(this).val();
		/* alert($id); */
		$('#order_id').val($id);
		 $.ajax({
			type:'POST',
			url:'<?php echo base_url();?>index.php/transporter/get_location_details',
			data:'order_id='+$id,
			success:function(res){
				/* alert(res); */
				if(res != ''){
					
					$( ".input_fields_wrap" ).empty();
				}
				var obj= JSON.parse(res);
				
				$.each(obj,function(key,val){
					$(wrapper).append('<div class="panel panel-default input_fields_wrap"><div class="panel-body" name="mytext[]"><div class="form-group"><input type="hidden" value="'+val.id+'" name="id[]"><label class="col-lg-3 col-sm-2 control-label">Address</label><div class="col-lg-7"><input type="text" class="form-control" required name="address[]" id="address" value='+val.address+' placeholder="Enter Address">	</div></div><div class="form-group"><label class="col-lg-3 col-sm-2 control-label">Date & Time</label><div class="col-lg-3"><input size="16" type="date" required name="date[]" value='+val.date+' placeholder="dd-mm-yy" data-date-format="DD-MM-YYYY" class="form-control"></div><div class="col-lg-3"><input size="16" type="time" value='+val.time+' required name="time[]" placeholder="H:i" class="form-control"></div></div></div></div>');
					
				});

				
			}
		}); 
		
	});
});
  </script>
	


  </body>
</html>
