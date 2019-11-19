<?php
	 include "includes/header.php";
	 ?>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <body>

  <section id="container" class="">
      <?php
	 include "includes/admin_sidebar.php";
	 ?>
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row" id='print'>
			                           <div class="col-lg-12" >
									   <section class="panel" >
										<div class="panel-body" style='margin-top:0px;padding:0px'>
										<div><h3 style='text-align:center'>Rating Information</br></h3></div>
										</div>

										</section>
										</div>
					
						  
               <div class="col-md-9" style='float:right'>
              <div class="tab-content">
             	<div class="inside-tab-content">
				 </div>
				 
				 <div class="col-lg-12 remove">
				 <section class="panel">
				 <div class="panel-body" style="height:100%"><div>
				 <h3 style="text-align:center">No Rating Found</br></br>Please Select Transporter!!!</h3>
				 </div>
				 </div>
				 </section>
				 </div>
                 </div>
			          </div>	  
                         <!--<div class="abc">
								   
						</div>		-->			  
                <div class="col-md-3" id='list' style='float:left!important'>
				<div class="form-group">
									
								  </div>
								  
								  <ul class="vertical-menu tran">
								  <li class="active">
										<a>
											Select Transpoters
										</a>
									</li>
								  </ul>
								  <input id="myInput" class="form-control" type="text" placeholder="Search Transpoters...">
                                   <br>
                    <ul class="vertical-menu" id="myList">
					
					<!--<div class='trans'></div>-->
					 <?php 
								    $this->db->select('*');
								    $this->db->from('dbo.transporter'); 
									$list = $this->db->get()->result_array();
									?>
									 
									 
									<?php foreach($list as $get)
									{
										$rt=$get['rating'];
								$image1  = base_url('images/star.gif');
							    $image2  = base_url('images/star2.gif');
								$img="";
								$i=1;
								while($i<=$rt){
								$img=$img."<img height='15' widht='15' src='".$image1."' >";
								$i=$i+1;
								}
								while($i<=5){
								$img=$img."<img height='15' widht='15' src='".$image2."' >";
								$i=$i+1;
								}
				                     ?>
                        <li><a href="#tab_2" class='click'data-toggle="tab"  value='<?php echo $get['global_id']?>'><i class="fa fa-user"></i> <?php echo $get['name']?><div style='float:right'>(<?php echo  number_format((float)$get['rating'], 2, '.', ''); ?>)</div></a></li>
                 		<?php } ?>
                    </ul>
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
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/respond.min.js" ></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
<script>
  $(document).ready(function() {
      //
      	$('.click').on('click',function(){
			
      		$id = $(this).attr("value");
			var wrapper = $(".inside-tab-content"); 
			//var rating = $(".rating"); 
			$('.inside-tab-content').empty();
      		/*  alert($id);  */
      		$.ajax({
                     type:'post',
                     url:'<?php echo base_url();?>index.php/admin/get_all_rating_order_id',
                     data:'global_id='+$id,
                     success:function(res){
      				 /*  alert(res);   */
					if(res)
					{
      				var obj= jQuery.parseJSON(res);
      				if(obj!=''){
						
						$i =0;
                         $.each(obj,function(){
								$i++;
								order_id="";
								global_id="";
								delivery_date="";
								name="";
								shipping_status="";
								accept_and_assign="";
								vehicle_condition="";
								track_and_trace="";
								customer="";
								avg_rating="";
								Cal_accept=0;
								Cal_veh=0;
								Cal_track=0;
								Cal_prating=0;
								previous_rating = 0 ;
								Cal_t = 0;
								Cal_v = 0;
								Cal_a = 0 ;
								Cal_total = 0 ;
								TotalAVG = 0 ;
								Cal_total_rating = 0  
								  $order_id=this.order_id;
								  $global_id=this.global_id;
								  if (typeof this.delivery_date === "undefined") {
									 delivery_date = 'N/A';
								  }else{
									
									  delivery_date = this.delivery_date;
								  }
								  if (typeof this.name === "undefined") {
									name = 'N/A';
								  }else{
									  name = this.name;
								  }
								  if (typeof this.shipping_status === "undefined") {
									shipping_status = 'N/A'; 
								  }else{
									 shipping_status = this.shipping_status;
								  }
								  if (typeof this.accept_and_assign === "undefined") {
									 accept_and_assign = '0'; 
								  }else{
									accept_and_assign = this.accept_and_assign;
								  }
								  if (typeof this.vehicle_condition === "undefined") {
									vehicle_condition = '0'; 
								  }else{
									 vehicle_condition = this.vehicle_condition;
								  }
								  if (typeof this.track_and_trace === "undefined") {
									 track_and_trace = '0';
								  }else{
									 track_and_trace = this.track_and_trace;
								  } 
								  if (typeof this.customer === "undefined") {
									customer = 'N/A'; 
								  }else{
									 customer = this.customer;
								  }  
								  if (typeof this.avg_rating === "undefined") {
									 avg_rating = '0';
								  }else{
									 avg_rating = this.avg_rating;
								  }
								  if (typeof this.rating === "undefined") {
									 rating = '0';
								  }else{
									 rating = this.rating;
								  }
								   if (typeof this.previous_rating === "undefined") {
									 previous_rating = '0';
								  }else{
									 previous_rating = this.previous_rating;
								  }
							  
									Cal_accept=parseInt(accept_and_assign);
									Cal_veh=parseInt(vehicle_condition);
									Cal_track=parseInt(track_and_trace);
									Cal_prating=parseInt(previous_rating);
                                
								
								if(Cal_track > 0 ){
									Cal_t=(Cal_track*20)/100;
								}else{
								    Cal_t=0;	
								}	
								if(Cal_veh > 0 ){
									Cal_v=(Cal_veh*40)/100;
								}else{
								    Cal_v=0;	
								}
								if(Cal_accept > 0 ){
									Cal_a=(Cal_accept*40)/100;
								}else{
								    Cal_a=0;	
								}
								Cal_total=Cal_t+Cal_a+Cal_v;
								 stringTot = Cal_t+"+"+Cal_a+"+"+Cal_v;
								if( Cal_prating > 0 ){
									TotalAVG = Cal_total+Cal_prating;
								}else{
								   	TotalAVG = Cal_total;
								}
								if( TotalAVG > 0 ){
									
									 if( customer > 0 ){
										Cal_total_rating=(TotalAVG)/4;
										avg_rating = Cal_total_rating; 
									 }else{
									    /*
											Timeliness -  (30/(30 + 15 +30)) * 100  = 40 % >> 	  ( 5*40)/100 = 2 
											Hygiene -  (30/(30 + 15 +30)) * 100  = 40 % > 3        (3*40)/100 = 1.2 
											Track & Trace -  (15/(30 + 15 +30)) * 100  = 20 % >>  ( 5*20)/100  = 1 
											     
										*/ 
										Cal_total_rating=(TotalAVG);
										avg_rating = Cal_total_rating;
										customer = '-';
									 }
								} 
							     
							 
							  
							//$(wrapper).append('<div class="panel-heading"><h4 class="panel-title"><a href="#accordion2_1" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">'+$i+' '+this.order_id+' </a> </h4></div>');
							$('.remove').empty();
							//$('.remove_print').empty();
							$(wrapper).append('<div id="p"><div class="tab-pane" id="tab_2"><div class="panel-group" id="accordion2"><div class="panel panel-success"><div class="panel-heading"><h4 class="panel-title"><a href="#accordion2_'+$i+'" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed" aria-expanded="false">'+$i+'.&nbsp&nbsp&nbsp'+this.order_id+'<span style="margin-left: 282px;">'+delivery_date+'</span><div style="float:right">Avarage Rating: <span id="stars2_'+$i+'"></span></div></h4></div></a><div class="panel-collapse collapse" id="accordion2_'+$i+'"><div class="panel-body"><section><div class="panel panel-primary"><div class="panel-body"><div class="row invoice-list"><div class="text-center corporate-id"><h1 class="highlight">'+name+'('+this.global_id+')</h1></div><div class="col-lg-4 col-sm-4"><h4><b>Order ID</b></h4><p>'+this.order_id+'</p></div><div class="col-lg-4 col-sm-4"><h4><b>Delivery Date</b></h4><p>'+delivery_date+'</p></div><div class="col-lg-4 col-sm-4"><h4><b>Order Status</b></h4><p>'+shipping_status+'</p></div></div><table class="table table-striped table-hover"><thead><tr><th>#</th><th>Timelines</th><th class="hidden-phone">Hygiene</th><th class="">Track And Trace</th><th>Customer Satisfaction</th><th>Avg Rating</th></tr></thead><tbody><tr><td>'+$i+'</td><td>'+accept_and_assign+'</td><td class="hidden-phone">'+vehicle_condition+'</td><td class="">'+track_and_trace+'</td><td>'+customer+'</td><td>'+avg_rating+'</td></tr></tbody></table><div class="abcd"></div><div class="row"><div class="col-lg-4 invoice-block pull-right" style="width:60%"><ul class="unstyled amounts"><li><h3><strong> Avarage Rating :</strong><span id="stars_'+$i+'"></span>('+avg_rating+')</h3></li><li style="display:none;"><h2><strong>Current Rating :</strong><span id="stars3_'+$i+'"></span>('+rating+')</h2></li></ul></div></div><div class="text-center invoice-btn"></div><div class="text-center invoice-btn remove_print"><a class="btn btn-info btn-lg" onclick="PrintMe()"><i class="fa fa-print"></i> Print </a></div></div></div></section></div> </div></div></div></div></div>');
							
							
							
							//	$(rating).append('<span>'+this.rating+'</span>');
							document.getElementById("stars_"+$i).innerHTML = getStars(avg_rating);
							
							 
								function getStars(rating) {

								  // Round to nearest half
								  rating = Math.round(rating * 2) / 2;
								  let output = [];

								  // Append all the filled whole stars
								  for (var i = rating; i >= 1; i--)
									output.push('<i class="fa fa-star" aria-hidden="true" style="color: black;"></i>&nbsp;');

								  // If there is a half a star, append it
								  if (i == .5) output.push('<i class="fa fa-star-half-o" aria-hidden="true" style="color: blue;"></i>&nbsp;');

								  // Fill the empty stars
								  for (let i = (5 - rating); i >= 1; i--)
									output.push('<i class="fa fa-star-o" aria-hidden="true" style="color: blue;"></i>&nbsp;');

								  return output.join('');

								}
									
								document.getElementById("stars2_"+$i).innerHTML = getStars(avg_rating);
								document.getElementById("stars3_"+$i).innerHTML = getStars(avg_rating); 
								function getStars1(rating1) {

								  // Round to nearest half
								  rating1 = Math.round(rating1 * 2) / 2;
								  let output = [];

								  // Append all the filled whole stars
								  for (var i = rating1; i >= 1; i--)
									output.push('<i class="fa fa-star" aria-hidden="true" style="color: black;"></i>&nbsp;');

								  // If there is a half a star, append it
								  if (i == .5) output.push('<i class="fa fa-star-half-o" aria-hidden="true" style="color: blue;"></i>&nbsp;');

								  // Fill the empty stars
								  for (let i = (5 - rating1); i >= 1; i--)
									output.push('<i class="fa fa-star-o" aria-hidden="true" style="color: blue;"></i>&nbsp;');

								  return output.join('');

								}
					    
						});	
						
										
      				 }
      				else{		
					        $('.remove').empty();
					        $(wrapper).append('<div class="col-lg-12 abc"><section class="panel"><div class="panel-body" style="height:100%"><div><h3 style="text-align:center">No Rating Found</br></br>Please Select Transporter!!!</h3></div></div></section></div>');				  
                     }
					} 
					 else{
						 alert('error');
				 
      			   
      				}   
					 }
					 
      		});  
      		 
             });
      	
           });
		   
		 
  </script>
<script>

  function PrintMe(){
	 var divName = 'print';
	$('#myList').css('display','none');
	$('.remove_print').css('display','none');
	$('.tran').css('display','none');
	var printContents = document.getElementById(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;
	$('#myList').css('display','block');
	$('.remove_print').css('display','block');
	$('.tran').css('display','block');
	
}
</script>
  </body>
</html>
