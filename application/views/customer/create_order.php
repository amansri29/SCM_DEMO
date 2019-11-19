  <?php
	 include "includes/header.php";
	 ?>

  <body>

  <section id="container" class="">
      <!--header start-->
     
      <!--header end-->
      <!--sidebar start-->
        <?php
	 include "includes/customer_sidebar.php";
	 ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
           <section class="wrapper">
              <!-- page start-->
				<div class="row">
					<div class="col-lg-12">
						<h3>Create Order</h3>
					</div>
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
                              Order Information
                          </header>
						   <div class="panel-body">
                               <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/customer/save_order">
								<div class="col-lg-6">
									
									<div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Select Company</label>
                                      <div class="col-lg-8">
									   <select class="js-example-basic-single vehicle"  id='company' required name='company'>
									   <option>Select Company</option>
									           <?php  
											        $global_id = $this->session->userdata('global_id');
											        $this->db->select('*');
													$this->db->from('dbo.customer');
													$this->db->where('global_id', $global_id);
													$query = $this->db->get();
													$row = $query->result_array(); 
													foreach($row as $get)
													{
													?>
                                        
											
											<option value='<?php echo $get['company'] ?>' ><?php echo $get['company'] ?></option>
											
											<?php
													}
											?>													
										</select>
										
                                      </div>
									</div>
									
									<div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Select State</label>
                                     
									
									<div class="col-lg-8">
                                         <select class="js-example-basic-single vehicle"  id='state' required name='state'>
											<option  >Select State</option>
											

																						
										</select>
										
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Select Shipping Address</label>
                                     
									
									<div class="col-lg-8">
                                         <select class="js-example-basic-single vehicle"  id='address' required name='address'>
											<option>Select Shipping Address</option>										
										</select>
                                      </div>
									</div>
									
								</div>
								<div class="col-lg-6">
									
									<div class="form-group">
                                      <label for="email" class="col-lg-3 col-sm-2 control-label">Add Product</label>
                                      <div class="col-lg-8">
									  <div class="col-lg-1">
												<a class="btn btn-primary btn-sm add_field_button" onclick='load_product()'><i class="fa fa-plus"></i></i></a>
											</div>
                                         <!--<select class="js-example-basic-multiple vehicle" id='product' required name='product[]'>
											<option >Select User Type</option>
											<option value='1'>Gate User</option>
											<option value='2'>Weighbridge User</option>
											<option value='3'>Loading User</option>
																						
										</select>-->
										
                                      </div>
									</div>
									
									<div class="input_fields_wrap">
								     
								     </div>
									
									<div class="form-group">
                                      <label for="mobile" class="col-lg-3 col-sm-2 control-label">Purchase Order Number</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" required id="porder_no" name="porder_no" placeholder="Enter Number">
                                      </div>
									</div>
									<div class="form-group">
                                      <label for="mobile" class="col-lg-3 col-sm-2 control-label">Select Image or File</label>
                                      <div class="col-lg-8">
                                          <input type="file" class="form-control" required id="image" name="image" placeholder="Enter Number">
                                      </div>
									</div>
									
								</div>
								<div class="form-group">
								  <div class="col-lg-offset-5 col-lg-2">
									  <button type="submit" class="btn btn-danger btn-block">Save</button>
								  </div>
								</div>
							  </form>
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
<script>
$(document).ready(function(){
	
	 $(".js-example-basic-single").select2();

      $(".js-example-basic-multiple").select2();
		  
  $('#company').change(function(){
	  $com=$(this).find(':selected').val();
    loadState($(this).find(':selected').val())
  })
  $('#state').change(function(){
    load_address($(this).find(':selected').val())
	 $id=$(this).find(':selected').val();
    load_product($(this).find(':selected').val())
  })
})

function loadState(company){
	/*alert(company);*/
        $("#state").children().remove()
        $.ajax({
            type: "POST",
             url:'<?php echo base_url();?>index.php/customer/get_state_list',
			  data: "company=" + company
            }).done(function( result ) {
				var obj= jQuery.parseJSON(result);
					/*alert(obj); */
					if(obj){         
						 $(obj).each(function(){ 
                              if(this.state_code)
							 {						 
						   var option = $('<option />'); 
						    $('#state').html('<option>State State</option>');
							option.attr('value', this.user_id).text(this.state_code);  
						    $('#state').append(option);
							 }
                               else	{
								     $('#state').html('<option value="">State not available</option>'); 
							   }								   
						});              
					 }
					else{		
						    $('#state').html('<option value="">State not available</option>');  
					}
            });
}
function load_address(state){
        $("#address").children().remove()
		//alert($com);
        $.ajax({
            type: "POST",
            url:'<?php echo base_url();?>index.php/customer/get_address',
            data: "user_id=" + state+'&company='+$com,
            }).done(function( result ) {
				//alert(result); 
                var obj= jQuery.parseJSON(result);
					
					if(obj){		
						 $(obj).each(function(){
                             if(this.Address)
							 {								 
						    var option = $('<option />'); 
						   // $('#address').html('<option>Select Address</option>') 
							option.attr('value', this.Code).text(this.Address+','+this.Address_2+','+this.Post_Code+','+this.City);  
						  
							 }
                              else	{
								  $('#address').html('<option value="">Address not available</option>'); 
							  }	
                              $('#address').append(option); 							  
						});
						 						
					 }
					else{		
						$('#address').html('<option value="">Address not available</option>');  
					}
            });
}
function load_product(state){
        $(".product").children().remove()
		//alert($com);
        $.ajax({
            type: "POST",
            url:'<?php echo base_url();?>index.php/customer/get_product',
            data: "user_id=" + $id+'&company='+$com,
             }).done(function( result ) {
				/* alert(result);  */
                var obj= jQuery.parseJSON(result);
					//alert(obj); 
					if(obj){		
						 $(obj).each(function(index,element){
							 var option = $('<option />');
								//$('.product1').html('<option>Select Product</option>');									
                             if(this.Description!='')
							 {								 
						    
							option.attr('value', this.Item_No).text(this.Description+','+this.Description_2);
						   $('.product1').append(option);
							 }
                              else	{
								  $('.product').html('<option value="">Product not available</option>'); 
							  } 
							 							  
						});
						 						
					 }
					else{		
						$('.product1').html('<option value="">Product not available</option>');  
					}
				
            });
		
}
// init the countries
//loadCountry();
</script>
<script type="text/javascript">

$(document).ready(function () {
       var max_fields      = 50; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
		
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
         
			$(wrapper).append('<div class="panel panel-default input_fields_wrap"><div class="panel-body" name="mytext[]"><div class="form-group"><input type="hidden" value="" name="id[]"><label class="col-lg-3 col-sm-2 control-label">Select Product</label><div class="col-lg-7"><select class="js-example-basic-single form-control product1" id="product" required name="product[]"><option  >Select Product</option></select>	</div><div class="col-lg-1"><a class="btn btn-danger btn-sm remove_field"><i class="fa fa-minus"></i></i></a></div></div><div class="form-group"><label class="col-lg-3 col-sm-2 control-label">Requested Date</label><div class="col-lg-3"><input size="16" type="date" required name="date[]" placeholder="dd-mm-yy" data-date-format="YYYY-MM-DD" class="form-control"></div><label class="col-lg-2 control-label">Quantity</label><div class="col-lg-3"><input size="16" type="text" required name="qty[]" placeholder="Enter Quantity" class="form-control"></div></div></div></div>');			//add input box
        }
    });
	 $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').parent().remove(); x--;
    });
});

     </script>
  </body>
</html>

