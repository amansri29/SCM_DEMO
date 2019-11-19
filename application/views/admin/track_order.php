  <?php
	 include "includes/header.php";
	 ?>
 <head>

        <style>
            

            #over_map {
                position: absolute;
                top: 0px;
				width:200px;
                left: 90%;
                z-index: 99;
                background-color: #ccffcc;
                padding: 10px;
            }
        </style>
    </head>
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
						<h3 class="left">Track Order</h3>
						
					</div>
					<div class="col-lg-12">
						<section class="panel">
							<div class="panel-body">
									
									<form  target="_blank" role="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="">
									<!--<div class="col-lg-2">
										  <select class="js-example-basic-single" id='driver' name='driver_id'>
										  <option>Select Drivers</option>
										  <?php 
								   $this->db->select('od.order_id as order_id, d.name,d.id');
								    $this->db->from('dbo.posted_sales_dispatch_order as sdo');
									$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id' , 'LEFT OUTER');
									$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
									$this->db->where('od.order_status', 'Inprocess'); 
									$this->db->where('od.shipping_status', 'Dispatched'); 
									$list1 = $this->db->get()->result_array();
									$count=count($list1);
									$driver=array();
									foreach($list1 as $get)
									{
										$driver[]=$get['id'];
				                     ?>
											
											<option value="<?php echo $get['id']?>"><?php echo $get['name']?></option>
											 <?php } ?>
										  </select>
										  
										  </div>-->
										  <div class="col-lg-2">
									
										  <select class="js-example-basic-single" id='order' name='driver_id1'>
										  <option>Select Order ID</option>
										  <?php 
								$this->db->select('od.order_id as order_id, d.name,d.id');
								    $this->db->from('dbo.posted_sales_dispatch_order as sdo');
									$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id' , 'LEFT OUTER');
									$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
									$this->db->where('od.order_status', 'Inprocess'); 
									$this->db->where('od.shipping_status', 'Dispatched'); 
									$list = $this->db->get()->result_array();
									foreach($list as $get)
									{
				                     ?>
											
											<option value="<?php echo $get['id']?>"><?php echo $get['order_id']?></option>
											 <?php } ?>
										  </select>
										  
										  </div>
										  
										 <div class="col-lg-2"> 
				                      <div class="form-group">
									  <button type="submit" id='abc' class="btn btn-danger btn-block">Track</button>
								      </div>
								</div>
								
							  </form>
							  <div class="col-lg-4">
										  <div id="over_map">
											<div>
												<span class="width-120" >Online Trucks: </span><span id="cars">0</span>
											</div>
							                </div>
											</div>
									</div>
								
							</div>
						</section>
						
						
						<section class="panel" id='div1'>
							
								<div class="panel-body">
									<div id="map" style="height:900px; width:100%;"></div>
                                   <input type='hidden' id='id' value='' abc='' order_id=''>
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
  $("#order").change(function () {
        var end = this.value;
        $('#form').attr('action', '<?php echo base_url('index.php/admin/track_orderss');?>');	
    });
	  $("#driver").change(function () {
        var end = this.value;
        $('#form').attr('action', '<?php echo base_url('index.php/admin/track_driver');?>');	
    });
  </script>
        <!-- Firebase -->
       <script src="https://www.gstatic.com/firebasejs/5.5.5/firebase.js"></script>
		 <script>
		  // Initialize Firebase
		  var config = {
			apiKey: "AIzaSyCDHwMf7iQPSkI3fqS4Xdzi5RrWw_m87Bo",
			authDomain: "transport-manage-1530871780765.firebaseapp.com",
			databaseURL: "https://transport-manage-1530871780765.firebaseio.com",
			projectId: "transport-manage-1530871780765",
			storageBucket: "transport-manage-1530871780765.appspot.com",
			messagingSenderId: "1053229254318"
		  };
		  firebase.initializeApp(config);
		</script>
		
		<script>
		  // counter for online cars...
             var cars_count = 0;
			
            // markers array to store all the markers, so that we could remove marker when any car goes offline and its data will be remove from realtime database...
            var markers = [];
            var map;
            function initMap() {
           
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 8,
                    center: new google.maps.LatLng(26.52011, 75.368604),
                    mapTypeId: 'terrain'
                });
				
            }
			
	  
           
            // This Function will create a car icon with angle and add/display that marker on the map
            function AddCar(data) {
                    
                var icon = { // car icon
					//url: '<?php echo  base_url(); ?>upload/image2vector.svg',
           
					path: 'M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805',
					scaledSize: new google.maps.Size(100, 60),
                    fillColor: "#427af4", //<-- Car Color, you can change it 
                    fillOpacity: 1, 
                    strokeWeight: 1,
                    anchor: new google.maps.Point(0, 5),
					rotation: data.val().angle //<-- Car angle
                };
                      var a =data.val().id;
					 // alert(a);
					                <?php 
									$this->db->select('od.order_id as order_id, d.name,d.id');
								    $this->db->from('dbo.posted_sales_dispatch_order as sdo');
									$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id' , 'LEFT OUTER');
									$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
									$this->db->where('od.order_status', 'Inprocess'); 
									$this->db->where('od.shipping_status', 'Dispatched'); 
									$list1 = $this->db->get()->result_array();
									$count=count($list1);
									$driver=array();
									foreach($list1 as $get)
									{
										$driver=$get['id'];
				                     ?>
									 
							 var did =<?php echo $driver ?>;
         							 
					if(did == a)
					{
		
					$.ajax({
					type:'post',
					url:'<?php echo base_url();?>index.php/admin/driver_list',
					data:'id='+a,
					success:function(res){
						/*  alert(res); */
						var obj= jQuery.parseJSON(res);
						if(obj){         
							 $(obj).each(function(){
								 
							   var id =this.id;
							   
							   var name =this.name;
							   var order_id =this.order_id;
							   var mobile =this.mobile;
							   //$('#id').attr('value',id);
							  // $('#id').attr('abc',name);
							 //  $('#id').attr('order_id',order_id);
					          
							  var infowindow = new google.maps.InfoWindow();
							  google.maps.event.addListener(marker, 'click', (function(marker)
					 {
					   return function() {
						  // $id=document.getElementById('id').value;
						  //$name = $('#id').attr("abc");
						 // $order_id = $('#id').attr("order_id");
						  infowindow.setContent('<div>'+
							'<div>'+
							'</div>'+
							'<h4>Driver Details</h4>'+
							'<div id="bodyContent">'+
							'<p><b>ID: </b>'+id+'</p>'+
			                '<p><b>Name: </b>'+name+'</p>'+
			                '<p><b>Order ID </b><a target="blank" href="<?php echo base_url();?>index.php/admin/order_view?id='+order_id+'">'+order_id+'</a></p>'+
							'<p><a class="btn btn-success btn-block" target="blank" href="<?php echo base_url();?>index.php/admin/vehicle_track?id='+a+'">Track here</a></p>'+
							'</div>'+
							'</div>');
						  infowindow.open(map, marker);
					   }
					 })(marker));
							  
							});  
                           
                               							
						 }
						else{		
							
						}      
                }
			});  
			
			    
                var uluru = { lat: data.val().lat, lng: data.val().lng };

                var marker = new google.maps.Marker({
                    position: uluru,
                    icon: icon,
                    map: map
                });

                markers[data.key] = marker; // add marker in the markers array...
                document.getElementById("cars").innerHTML = cars_count;
							
			
					}
			<?php } ?>
			}
				
				
				
            // get firebase database reference...
            var cars_Ref = firebase.database().ref('/');

            // this event will be triggered when a new object will be added in the database...
            cars_Ref.on('child_added', function (data) {
                cars_count++;
                AddCar(data);
            });

            // this event will be triggered on location change of any car...
            cars_Ref.on('child_changed', function (data) {
                markers[data.key].setMap(null);
                AddCar(data);
            });

            // If any car goes offline then this event will get triggered and we'll remove the marker of that car...  
            cars_Ref.on('child_removed', function (data) {
                markers[data.key].setMap(null);
                cars_count--;
                document.getElementById("cars").innerHTML = cars_count;
            }); 


                    
			
			
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDHwMf7iQPSkI3fqS4Xdzi5RrWw_m87Bo&callback=initMap">
        </script>

  <script type="text/javascript">

      $(document).ready(function () {
			
			$(".js-example-basic-single").select2();
			var div = document.getElementById('div');
			var div1 = document.getElementById('div1');
			div.style.display = 'none';
			div1.style.display = 'none';
	  
			/*$('#driver').on('change',function()
			 {
				div.style.display = 'block';
				div1.style.display = 'block';
			});
			$('#vehicle').on('change',function()
			{
				div.style.display = 'block';
				div1.style.display = 'block';
			}); */
			$('#order').on('change',function()
			{
				div1.style.display = 'block';
				div.style.display = 'block';
				
			});


          
      });
  </script>
    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>

