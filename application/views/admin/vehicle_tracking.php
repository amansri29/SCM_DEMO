<!DOCTYPE html>
<html>
    <head>
        <style>
		html, body, #map-canvas {
    height: 100%;
    width: 100%;
    margin: 0px;
    padding: 0px
}

.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    margin: auto;
    border: 1px solid #888;
    width: 40%; 
	background-color: rgba(0,0,0,0.8);
    padding: 10px;
}
.modal-content1 {
    margin: auto;
    border: 1px solid #888;
    width: 40%; 
	background-color: rgba(0,0,0,0.8);
    padding: 10px;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close1 {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    text-decoration: none;
    cursor: pointer;
}
.close1:hover,
.close1:focus {
    color: red;
    text-decoration: none;
    cursor: pointer;
}
        </style>
    </head>

    <body>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p style='font-size: 32px;
    text-align: center;
    text-transform: uppercase;color:red'>Driver Is Offline Now!!!</p>
  </div>

</div>


<div id="myModal1" class="modal">

  <!-- Modal content -->
  <div class="modal-content1">
    <span class="close1">&times;</span>
    <p style='font-size: 32px;
    text-align: center;
    text-transform: uppercase;color:red'>Address Not Found!!!</p>
  </div>

</div>
	<?php        $id=$_REQUEST['id'];
	
				$this->db->select('*');
				$this->db->from('dbo.posted_sales_dispatch_order as sdo');
				$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id ' , 'LEFT OUTER');
				$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
				$this->db->where('od.shipping_status', 'Dispatched' );
				$this->db->where('sdo.status', 'Released');
				$this->db->where('d.id', $id); 
				$sql= $this->db->get()->result_array() ;
				//print_r($sql); 
				foreach($sql  as  $get)
				{
					$arr = explode('To',trim($get['route']));
			        $pickup_address=$arr[0];
					//print_r($pickup_address);
					if($pickup_address=='Mandalghar ')
					{
						 $pic_lat ='25.19107';
					     $pic_long= '75.07153';
					} else if($pickup_address=='Bapi ')
					{
						 $pic_lat ='26.98766';
					     $pic_long= '76.28054';
					}
					 else if($pickup_address=='Dausa ')
					{
						 $pic_lat ='26.90080';
					     $pic_long= '76.32970';
					}
					else if($pickup_address=='Ghewaria ')
					{
						 $pic_lat ='25.40681';
					     $pic_long= '75.05411';
					}
					 else if($pickup_address=='Bhilwara ')
					{
						 $pic_lat ='25.34202';
					     $pic_long= '74.63085';
					}
					else
					{
                            $pic_lat ='26.9124';
					        $pic_long= '77.7873';
					}
					$ship_to_address =  $get['ship_to_address'];
					$ship_to_address_2 =  $get['ship_to_address_2'];
					$ship_to_post_code =  $get['Ship_to_Post_Code'];
					$ship_to_city =  $get['ship_to_city'];
					$shipping_address=$ship_to_address.' '.$ship_to_address_2.' '.$ship_to_post_code.' '.$ship_to_city;
					
					
					if(!empty($shipping_address)){
						//Formatted address
						$formattedAddr = str_replace(' ','+',$shipping_address);
						//Send request and receive json data by address
					   $geocodeFromAddr = file_get_contents($details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$formattedAddr."&key=AIzaSyA2_9Lpcxc2d-E1Z3oseySOeYX9aWQL2BA&sensor=false"); 
						$output = json_decode($geocodeFromAddr);
						//Get latitude and longitute from json data
						$ship_lat  = $output->results[0]->geometry->location->lat; 
						$ship_long = $output->results[0]->geometry->location->lng;
						//Return latitude and longitude of the given address
						 if($ship_lat!=''){
							// echo $shipping_address.'</br>';
							 $ship_lat= $ship_lat;
							 $ship_long= $ship_long;
							 
						}else{
							 echo  '<script>alert(Shipping Address Not Found)</script>';
						}
					}else{
						     echo  '<script>alert(Shipping Address Not Found)</script>';
					}
					/*if(!empty($pickup_address)){
						//Formatted address
						/*$formattedAddr1 = str_replace(' ','+',$pickup_address);
						//Send request and receive json data by address
					   $geocodeFromAddr1 = file_get_contents($details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$formattedAddr1."&key=AIzaSyA2_9Lpcxc2d-E1Z3oseySOeYX9aWQL2BA&sensor=false"); 
						$output = json_decode($geocodeFromAddr1);
						//Get latitude and longitute from json data
						$pic_lat  = $output->results[0]->geometry->location->lat; 
						$pic_long = $output->results[0]->geometry->location->lng;
						//Return latitude and longitude of the given address*/
						
							 //$pic_lat =$pic_lat1;
							// $pic_long= $pic_long1;
						
					/*}else{
						    echo  '<script>alert(Pickup Address Not Found)</script>';
					}*/
					
				}
			
	?>
	    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
	  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2_9Lpcxc2d-E1Z3oseySOeYX9aWQL2BA"></script>
      <div id="map-canvas"></div>
	  <script src="https://www.gstatic.com/firebasejs/5.5.5/firebase.js"></script>
		 <script>
		// var simple = '<?php echo $POST['id']; ?>';
			//alert(simple);
		  // Initialize Firebase
		  var config = {
			apiKey: "AIzaSyATvFhW6WxZBsWzCodmIlzWehaR_ayeH9c",
			authDomain: "transport-manage-1530871780765.firebaseapp.com",
			databaseURL: "https://transport-manage-1530871780765.firebaseio.com",
			projectId: "transport-manage-1530871780765",
			storageBucket: "transport-manage-1530871780765.appspot.com",
			messagingSenderId: "1053229254318"
		  };
		  firebase.initializeApp(config);
		</script>
   <script>
  function mapLocation() {
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;
    var markers = [];
    var cars_count = 0;  	
    function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();
        var mapOptions = {
            zoom: 7,
            center: new google.maps.LatLng(26.52011, 75.368604),
			mapTypeId: 'terrain'
        };
		 
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        directionsDisplay.setMap(map);
       
		           var start = new google.maps.LatLng(<?php echo $pic_lat; ?>, <?php echo $pic_long; ?>);
					
					var end = new google.maps.LatLng(<?php echo $ship_lat; ?>, <?php echo $ship_long; ?>);
					
					var bounds = new google.maps.LatLngBounds();
					bounds.extend(start);
					bounds.extend(end);
					map.fitBounds(bounds);
					var request = {
						origin: start,
						destination: end,
						travelMode: google.maps.TravelMode.DRIVING
					}; 
					directionsService.route(request, function (response, status) {
						if (status == google.maps.DirectionsStatus.OK) {
							directionsDisplay.setDirections(response);
							directionsDisplay.setMap(map);
						} else {
								 var modal = document.getElementById('myModal1');
							     var span = document.getElementsByClassName("close1")[0];
								 modal.style.display = "block";
								 span.onclick = function() {
								 modal.style.display = "none";
									}

									// When the user clicks anywhere outside of the modal, close it
								    window.onclick = function(event) {
									if (event.target == modal) {
										modal.style.display = "none";
									}
								}
						    }
					});
					 AddCar();
       }
	                 
				 
	   /*************running **************/
	       var count=0;
			function AddCar(data) {
				    
				   
					
					/*var startMarker = new google.maps.Marker({
						position: start,
						map: map,
						draggable: true
					});
					var endMarker = new google.maps.Marker({
						position: end,
						map: map,
						draggable: true
					});*/
					var icon = { // car icon
           
					//url: '<?php echo  base_url(); ?>upload/map_truck.png',
					path: 'M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805',
					scaledSize: new google.maps.Size(100, 60),
                    fillColor: "#427af4", //<-- Car Color, you can change it 
                    fillOpacity: 1, 
                    strokeWeight: 1,
                    anchor: new google.maps.Point(0.5, 0.5),
                    rotation: data.val().angle //<-- Car angle
                };
                      var a =data.val().id;
                     
					 
												
					var did = <?php echo $id ?> ;
			     //alert(a);
	
				   var b = 0;
				   
		
				if(a==did)
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
							 
							 var infowindow = new google.maps.InfoWindow();
							  google.maps.event.addListener(marker, 'click', (function(marker)
								 {
								   return function() {
									
									  infowindow.setContent('<div>'+
										'<div>'+
										'</div>'+
										'<h4>Driver Details</h4>'+
										'<div id="bodyContent">'+
										'<p><b>ID: </b>'+id+'</p>'+
										'<p><b>Name: </b>'+name+'</p>'+
										'<p><b>Order ID </b><a target="blank" href="<?php echo base_url();?>index.php/admin/order_view?id='+order_id+'">'+order_id+'</a></p>'+
										'</div>'+
										'</div>');
									  infowindow.open(map, marker);
								   }
					          })(marker));
							  
							});  
                           
                               							
						    }
									else{		
										alert('asdasd');
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
				else{
					/*
					var modal = document.getElementById('myModal');
				    var span = document.getElementsByClassName("close")[0];
				     modal.style.display = "block";
					 */
				    span.onclick = function() {
					  modal.style.display = "none";
						}

						// When the user clicks anywhere outside of the modal, close it
					/*
					window.onclick = function(event) {
						if (event.target == modal) {
							modal.style.display = "none";
						}
					}
					*/
			   }
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

				
				  /************* end running **************/
				 
		

    google.maps.event.addDomListener(window, 'load', initialize);
}
mapLocation();
</script>
		
		
    
    </body>
</html>