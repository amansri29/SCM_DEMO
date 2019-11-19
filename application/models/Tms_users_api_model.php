<?php
class Tms_users_api_model extends CI_Model
{
    function __construct()
    {
		  parent::__construct();
        $this->load->database();
        $this->load->model('notification_save');
        $this->load->model('sms_save');
        $this->load->model('email_save');
        $this->load->model('update_webservice_data_model');
        date_default_timezone_set("Asia/Calcutta");
    }

    public function users_login($mobile,$password,$global_id)
    {
			$this->db->select('DISTINCT(global_id) as global_id,user_id as user_id,user_role as user_role,name as name,image');
			$this->db->from('dbo.customer');
			$this->db->where('global_id', $global_id);
			$this->db->where('password', $password);
            $query = $this->db->get()->result_array();
			 if($query)
			{
					return $query;
			}
		
		else
		{
			$this->db->select('DISTINCT(global_id) as global_id,user_id as user_id,user_role as user_role,name as name,image');
			$this->db->from('dbo.transporter');
			$this->db->where('global_id', $global_id);
			$this->db->where('password', $password);
            $query1 = $this->db->get()->result_array();
			if($query1)
			{
					return $query1;
			}
			else
			{ 
		
			$this->db->select('DISTINCT(id) as id,user_id as user_id,user_role as user_role,name as name,image');
			$this->db->from('dbo.driver');
			 $this->db->where('mobile', $mobile);
			 $this->db->where('password', $password);
            $query2 = $this->db->get()->result_array();
			 if($query2)
			{
				return $query2;
			}	
			else{
				return false; 
			}
			}
		}
	
    } 
	public function otp_check($user_id,$otp,$device_type,$device_token,$user_type,$global_id)
    {
		
		$token=array(
		
		'device_type' => $device_type ,
		'device_token' => $device_token,
		);
         if($user_type=='customer')
		 {
			  /*************save token*************/
			 $this->db->where('global_id', $global_id);
		     $sql=$this->db->update('dbo.customer', $token);
		      /*************otp_check*************/
			 $this->db->where('otp', $otp);
			  $this->db->where('user_id', $user_id);
			 return   $this->db->get('dbo.customer')->result_array();
		 }
		 else if($user_type=='transporter')
		 {
			  /*************save token*************/
			 $this->db->where('user_id', $user_id);
		     $sql=$this->db->update('dbo.transporter', $token);
		    /*************otp_check*************/
			 $this->db->where('otp', $otp);
			 $this->db->where('global_id', $global_id);
			return   $this->db->get('dbo.transporter')->result_array();
			 
		 }
		 else if($user_type=='driver')
		 {
			 /*************save token*************/
			 $this->db->where('user_id', $user_id);
		     $sql=$this->db->update('dbo.driver', $token);
		  /*************otp_check*************/
			 $this->db->where('otp', $otp);
			  $this->db->where('id', $user_id);
			return   $this->db->get('dbo.driver')->result_array();
			 
		 }
    }
	public function update_otp($user_id,$otp,$user_type,$global_id)
    {
		$otp=array(
		'otp' => $otp ,
		);
	
         if($user_type=='customer')
		 {
			  /*************update otp*************/
			 $this->db->where('global_id', $global_id);
		     $sql=$this->db->update('dbo.customer', $otp);
			 if ($sql) {
                 return TRUE;
             }
		    
		 }
		 else if($user_type=='transporter')
		 {
			 /*************update otp*************/
			 $this->db->where('global_id', $global_id);
		     $sql=$this->db->update('dbo.transporter', $otp); 
			 if ($sql) {
                 return TRUE;
             }
		  
			 
		 }
		 else if($user_type=='driver')
		 {
			 /*************update otp*************/
			$this->db->where('id', $user_id);
		     $sql=$this->db->update('dbo.driver', $otp); 
			  if ($sql) {
                 return TRUE;
             };
		 
		 }
		
    }
	public function users_logout($user_id,$user_type,$global_id)
    {
		$token=array(
		
		'device_type' => '' ,
		'device_token' => ''
		);
         if($user_type=='customer')
		 {
			 //*******update token*********
			 $this->db->where('global_id', $global_id);
		     $sql=$this->db->update('dbo.customer', $token);
			 if ($sql) {
                 return TRUE;
             }
		 }
		 else if($user_type=='transporter')
		 {
			//*******update token*********
			 $this->db->where('global_id', $global_id);
		     $sql=$this->db->update('dbo.transporter', $token); 
			 if ($sql) {
                 return TRUE;
             }
			 
		 }
		 else if($user_type=='driver')
		 {
			 
			  //*******update token*********
			 $this->db->where('id', $user_id);
		     $sql=$this->db->update('dbo.driver', $token); 
			  if ($sql) {
                 return TRUE;
             };
			 
		 }

    }
	public function forgot_password($mobile)
    {
		
			$this->db->select('DISTINCT(global_id) as global_id,user_id as user_id,user_role as user_role, name as name');
			$this->db->from('dbo.customer');
			$this->db->like('mobile', $mobile, 'both');
            $query = $this->db->get()->result_array();
			 if($query)
			{
			
					return $query;
			}
		
		else
		{
			 
			 	$this->db->select('DISTINCT(global_id) as global_id,user_id as user_id,user_role as user_role, name as name');
			$this->db->from('dbo.transporter');
			$this->db->like('mobile', $mobile, 'both');
            $query1 = $this->db->get()->result_array();
			if($query1)
			{
				
					return $query1;
			}
			else
			{ 
		
			 $this->db->like('mobile', $mobile, 'both');
			 $query2 = $this->db->get('dbo.driver')->result_array();
			 if($query2)
			{
				return $query2;
			}	
			else{
				return false;
			}
			}
		}
	
    } 
	public function get_users_profile($global_id,$user_type,$user_id)
    {
		
         if($user_type=='customer')
		 {
			$this->db->select('DISTINCT(global_id),name,email,mobile,address,contact_person,image');
			$this->db->from('dbo.customer');
			$this->db->where('global_id', $global_id);
			//$this->db->where('user_id', $user_id);
            return $this->db->get()->row();
		 }
		 else if($user_type=='transporter')
		 {
			$this->db->select('DISTINCT(global_id),name,email,mobile,address,contact_person,image');
			$this->db->from('dbo.transporter');
			$this->db->where('global_id', $global_id);
			//$this->db->where('user_id', $user_id);
            return $this->db->get()->row();
			
		 }
		 else if($user_type=='driver')
		 {
			 
			$this->db->select('*');
			$this->db->from('dbo.driver');
			$this->db->where('id', $user_id);
            return $this->db->get()->row();
			 
		 }
	}
		 public function get_orders($user_id,$user_type,$order_type,$global_id)
    {
		
         if($user_type=='customer')
		 {
			 
			 if($order_type=='inprocess')
			 {	
				$this->db->select('DISTINCT(sdo.order_id) as order_id,od.order_status as order_status ,od.shipping_status as shipping_status,sdo.delivery_date as delivery_date,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.quantity AS VARCHAR(max)) AS quantity,sdo.ship_to_address,sdo.ship_to_address_2,sdo.Ship_to_Post_Code,sdo.ship_to_city,d.name as driver_name,d.mobile as driver_mobile,c.mobile as cust_mobile,od.global_id');
				$this->db->from('dbo.sales_dispatched_order as sdo');
		        $this->db->join('dbo.order_details as od','sdo.order_id = od.order_id ' , 'LEFT OUTER');
		        $this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','LEFT OUTER');
				$this->db->join('dbo.driver as d','d.id = od.driver_id ' , 'LEFT OUTER');
		        $this->db->where('od.order_status', 'Inprocess' );
		        $this->db->where('od.shipping_status!=', 'Dispatched');
		        $this->db->where('od.shipping_status!=', 'Completed');
		        $this->db->where('c.global_id', $global_id);
				$this->db->where('sdo.status', 'Released');
				$this->db->like('sdo.cust_no', 'c', 'after');
				$sql= $this->db->get()->result_array();
				
				foreach($sql as $key => $get)
				{
					$items = explode(',', $get['item_code']);
					$qty_to_ship = explode(',', $get['qty_to_ship']);
					$quantity = explode(',', $get['quantity']);
					foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $items)) {
							$sql[$key]['item_code']= $items[$qty_key];
						  
					 }}}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  
							$sql[$key]['qty_to_ship']= $qty;
						  
				     }}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $quantity)) {
							$sql[$key]['quantity']= $quantity[$qty_key];
					 }}}									 
					if($get['shipping_status']=='Dispatched') {
						
						$status=$get['shipping_status'];
					}
					else{
						$status='Awaiting For Dispatch';
					}
					$sql[$key]['shipping_status']=$status;
					
				}
				return $sql;	
		    }
			else if($order_type=='dispatched')
			{
				//echo 'dsasd';
				$this->db->select('DISTINCT(psdo.order_id) as order_id,od.order_status as order_status , od.shipping_status as shipping_status,cast (psdo.item_code AS VARCHAR(max)) as item_code , cast (psdo.description AS VARCHAR(max)) AS description ,cast (psdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (psdo.route AS VARCHAR(max)) AS route,psdo.posting_date as delivery_date, cast (psdo.quantity AS VARCHAR(max)) AS quantity,psdo.ship_to_address,psdo.ship_to_address_2,psdo.Ship_to_Post_Code,psdo.ship_to_city,d.name as driver_name,d.mobile as driver_mobile,c.mobile as cust_mobile,d.id as driver_id,od.global_id');
				$this->db->from('dbo.posted_sales_dispatch_order as psdo');
				$this->db->join('dbo.order_details as od','psdo.order_id = od.order_id' , 'left outer'); 
				$this->db->join('dbo.customer as c', 'c.user_id = psdo.cust_no and psdo.company =c.company','left outer');
				$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'left outer');
				$this->db->where('c.global_id', $global_id);
				$this->db->where('od.order_status', 'Inprocess' );
				$this->db->where('od.shipping_status', 'Dispatched' );
				$this->db->where('psdo.status', 'Released');
				$this->db->like('psdo.cust_no', 'c', 'after');
				$sql= $this->db->get()->result_array() ;
				foreach($sql  as $key => $get)
				{
					$arr = explode('To',trim($get['route']));
			        $pickup_address=$arr[0];
					if($pickup_address=='Mandalghar ')
					{
						 $pic_lat ='25.19107';
					     $pic_long= '75.07153';
						 $sql[$key]['pic_lat']= $pic_lat;
						 $sql[$key]['pic_long']= $pic_long;
					} if($pickup_address=='Bapi ')
					{
						//print_r($pickup_address);
						 $pic_lat ='26.98766';
					     $pic_long= '76.28054';
						 $sql[$key]['pic_lat']= $pic_lat;
						 $sql[$key]['pic_long']= $pic_long;
					}
					 if($pickup_address=='Dausa ')
					{
						 $pic_lat ='26.90080';
					     $pic_long= '76.32970';
						 $sql[$key]['pic_lat']= $pic_lat;
						 $sql[$key]['pic_long']= $pic_long;
					}
					 if($pickup_address=='Ghewaria ')
					{
						 $pic_lat ='25.40681';
					     $pic_long= '75.05411';
						 $sql[$key]['pic_lat']= $pic_lat;
						 $sql[$key]['pic_long']= $pic_long;
					}
					 if($pickup_address=='Bhilwara ')
					{
						 $pic_lat ='25.34202';
					     $pic_long= '74.63085';
						 $sql[$key]['pic_lat']= $pic_lat;
						 $sql[$key]['pic_long']= $pic_long;
					} 
					$ship_to_address =  $get['ship_to_address'];
					$ship_to_address_2 =  $get['ship_to_address_2'];
					$ship_to_post_code =  $get['Ship_to_Post_Code'];
					$ship_to_city =  $get['ship_to_city'];
					//$shipping_address=$ship_to_address.$ship_to_address_2.$ship_to_post_code.$ship_to_city;
					$shipping_address=$ship_to_city;
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
							$sql[$key]['ship_lat']= $ship_lat;
							$sql[$key]['ship_long']= $ship_long;
						}else{
							$sql[$key]['message']= 'Shipping Address Not Found';
						}
					}else{
						    $sql[$key]['message']= 'Shipping Address Not Found';
					}
					if(!empty($pickup_address)){
						//Formatted address
						$formattedAddr = str_replace(' ','+',$pickup_address);
						//Send request and receive json data by address
					   $geocodeFromAddr = file_get_contents($details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$formattedAddr."&key=AIzaSyA2_9Lpcxc2d-E1Z3oseySOeYX9aWQL2BA&sensor=false"); 
						$output = json_decode($geocodeFromAddr);
						//Get latitude and longitute from json data
						//$pic_lat  = $output->results[0]->geometry->location->lat; 
						//$pic_long = $output->results[0]->geometry->location->lng;
						//Return latitude and longitude of the given address
						 if($pic_lat!=''){
							//$sql[$key]['pic_lat']= $pic_lat;
							//$sql[$key]['pic_long']= $pic_long;
						}else{
							$sql[$key]['message']= ' Pickup Address Not Found';
						}
					}else{
						    $sql[$key]['message']= 'Pickup Address Not Found';
					}
					
					$sql[$key]['pickup_address']=$pickup_address;
					$sql[$key]['shipping_address']= $shipping_address;
				}
				return $sql;
			}
			else if($order_type=='completed')
			{
				$this->db->select('DISTINCT(psdo.order_id) as order_id,od.order_status as order_status , od.shipping_status as shipping_status,cast (psdo.item_code AS VARCHAR(max)) as item_code , cast (psdo.description AS VARCHAR(max)) AS description ,cast (psdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (psdo.route AS VARCHAR(max)) AS route,psdo.posting_date as delivery_date, cast (psdo.quantity AS VARCHAR(max)) AS quantity,psdo.ship_to_address,psdo.ship_to_address_2,psdo.Ship_to_Post_Code,psdo.ship_to_city,d.name as driver_name,d.mobile as driver_mobile,c.mobile as cust_mobile,od.global_id,tr.customer,od.global_id');
				$this->db->from('dbo.posted_sales_dispatch_order as psdo');
				$this->db->join('dbo.order_details as od','psdo.order_id = od.order_id ' , 'LEFT OUTER'); 
				$this->db->join('dbo.customer as c', 'c.user_id = od.cust_no and psdo.company = c.company','left outer');
				$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
				$this->db->join('dbo.trans_rating as tr','tr.order_id = od.order_id and tr.global_id= od.global_id' , 'LEFT OUTER');
				$this->db->where('od.shipping_status', 'Delivered');
				$this->db->where('c.global_id', $global_id);
				$this->db->where('psdo.status', 'Released');
				$this->db->like('psdo.cust_no', 'c', 'after');
				return $this->db->get()->result_array() ;
			}
		 }
		 else if($user_type=='transporter')
		 {
			 if($order_type=='inprocess')
			 {	
				$this->db->select('DISTINCT(sdo.order_id)as order_id,od.order_status as order_status ,od.shipping_status as shipping_status,sdo.delivery_date as delivery_date,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.quantity AS VARCHAR(max)) AS quantity,d.id as driver_id,od.gps_enabled as gps_enabled,sdo.ship_to_address,sdo.ship_to_address_2,sdo.Ship_to_Post_Code,sdo.ship_to_city,sdo.status as sales_status,od.order_created_status as ocs_status,od.global_id');
				$this->db->from('dbo.sales_dispatched_order as sdo');
				$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id ' , 'LEFT OUTER');
				$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			    $this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			    $this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
				$this->db->join('dbo.driver as d','d.id = od.driver_id ' , 'LEFT OUTER');
				$this->db->where('od.order_status', 'Inprocess'); 
				$this->db->where('t.global_id', $global_id );
				$this->db->where('sdo.status', 'Released');
				$this->db->like('sdo.cust_no', 'c', 'after');
				$sql= $this->db->get()->result_array();
				foreach($sql as $key => $get)
				{
					$items = explode(',', $get['item_code']);
					$qty_to_ship = explode(',', $get['qty_to_ship']);
					$quantity = explode(',', $get['quantity']);
					foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $items)) {
							$sql[$key]['item_code']= $items[$qty_key];
						  
					 }}}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  
							$sql[$key]['qty_to_ship']= $qty;
						  
				     }}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $quantity)) {
							$sql[$key]['quantity']= $quantity[$qty_key];
					 }}}
					 if ($get['sales_status']=='Reopened') {
						$status='Reopened';
					}
					else
					{
					 if($get['shipping_status']==null) {
						
						$status='';
					}
					else if ($get['shipping_status']=='Tare Weight (Weighbridge)') {
						$status='Weigh In';
					}
					else if ($get['shipping_status']=='Loading') {
						$status='Loading In';
					}
					else if ($get['shipping_status']=='Loading Out') {
						$status='Loading Out';
					}
					else if ($get['shipping_status']=='Gross Weight (Weighbridge)') {
						$status='Weigh Out';
					}
					else 
						{
						$status=$get['shipping_status'];;
					}
				}
				$sql[$key]['shipping_status']=$status;
				}					 
				return $sql;
			}
				
			else if($order_type=='dispatched')
			{
			
				$this->db->select('DISTINCT(sdo.order_id)as order_id,od.order_status as order_status ,od.shipping_status as shipping_status,sdo.posting_date as delivery_date,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.quantity AS VARCHAR(max)) AS quantity,d.id as driver_id,od.gps_enabled as gps_enabled,sdo.ship_to_address,sdo.ship_to_address_2,sdo.Ship_to_Post_Code,sdo.ship_to_city,od.global_id');
				$this->db->from('dbo.posted_sales_dispatch_order as sdo');
				$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id');
				$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			    $this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			    $this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
				$this->db->join('dbo.driver as d','d.id = od.driver_id ' , 'LEFT OUTER');
				$this->db->where('od.shipping_status', 'Dispatched' );
				$this->db->where('t.global_id', $global_id );
				$this->db->where('sdo.status', 'Released');
				$this->db->like('sdo.cust_no', 'c', 'after');
				return $this->db->get()->result_array() ;
			}
			else if($order_type=='completed')
			{
				$this->db->select('DISTINCT(sdo.order_id)as order_id,od.order_status as order_status ,od.shipping_status as shipping_status,sdo.posting_date as delivery_date,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.quantity AS VARCHAR(max)) AS quantity,d.id as driver_id,od.gps_enabled as gps_enabled,sdo.ship_to_address,sdo.ship_to_address_2,sdo.Ship_to_Post_Code,sdo.ship_to_city,od.global_id');
				$this->db->from('dbo.posted_sales_dispatch_order as sdo');
				$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id');
				$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			    $this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			    $this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
				$this->db->join('dbo.driver as d','d.id = od.driver_id ' , 'LEFT OUTER');
				$this->db->where('od.shipping_status', 'Delivered' );
				$this->db->where('t.global_id', $global_id );
				$this->db->where('sdo.status', 'Released');
				$this->db->like('sdo.cust_no', 'c', 'after');
				return $this->db->get()->result_array() ;
			}
		 }
		  else if($user_type=='driver')
		 {
			 if($order_type=='inprocess')
			 {	
				$this->db->select('DISTINCT(sdo.order_id)as order_id,od.order_status as order_status ,od.shipping_status as shipping_status,sdo.delivery_date as delivery_date,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.quantity AS VARCHAR(max)) AS quantity,d.id as driver_id,od.gps_enabled as gps_enabled,sdo.ship_to_address,sdo.ship_to_address_2,sdo.Ship_to_Post_Code,sdo.ship_to_city,t.name as trans_name,od.gate_in_date,od.gate_out_date,od.tare_weight_date,od.gross_weight_date,od.loading_date,od.loading_out_date,c.mobile as cust_mobile,od.global_id');
				$this->db->from('dbo.sales_dispatched_order as sdo');
				$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id ' ,'LEFT OUTER');
				$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
				$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
				$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
				$this->db->where('od.order_status', 'Inprocess'); 
				$this->db->where('od.shipping_status!=', 'Dispatched'); 
				$this->db->where('od.shipping_status!=', 'Completed'); 
				$this->db->where('sdo.status', 'Released');
				$this->db->where('d.id', $user_id);
				$this->db->like('sdo.cust_no', 'c', 'after');
				$sql= $this->db->get()->result_array();
		       
					foreach($sql  as $key => $get)
				{
					
					//$ship_to_address =  $get['ship_to_address'];
					//$ship_to_address_2 =  $get['ship_to_address_2'];
					//$ship_to_post_code =  $get['Ship_to_Post_Code'];
					//$ship_to_city =  $get['ship_to_city'];
					$items = explode(',', $get['item_code']);
					$qty_to_ship = explode(',', $get['qty_to_ship']);
					$quantity = explode(',', $get['quantity']);
					$route = explode(',', $get['route']);
					//$sql[$key]['shipping_address']=$ship_to_address.','.$ship_to_address_2.','.$ship_to_post_code.','.$ship_to_city;
					foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $items)) {
							$sql[$key]['item_code']= $items[$qty_key];
						  
					 }}}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  
							$sql[$key]['qty_to_ship']= $qty;
						  
				     }}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $quantity)) {
							$sql[$key]['quantity']= $quantity[$qty_key];
					 }}}
                      if (array_key_exists($qty_key, $route)) {
						  
							$route1= $route[$qty_key];
							$arr = explode('To',trim($route1));
			                //$sql[$key]['pickup_address']=$arr[0];
					 }	
					 
					if($get['shipping_status']=='Gate In') {
						
						$status=$get['shipping_status'];
					}
					else if ($get['shipping_status']=='Tare Weight (Weighbridge)') {
						$status='Weigh In';
					}
					else if ($get['shipping_status']=='Loading') {
						$status='Loading In';
					}
					else if ($get['shipping_status']=='Loading Out') {
						$status='Loading Out';
					}
					else if ($get['shipping_status']=='Gross Weight (Weighbridge)') {
						$status='Weigh Out';
					}
					else{
						$status='Awaiting For Gate In';
					}
					$sql[$key]['shipping_status']=$status;
				}	
				return $sql;
				}
				
			else if($order_type=='dispatched')
			{
				$this->db->select('DISTINCT(sdo.order_id) as order_id,od.order_status as order_status ,od.shipping_status as shipping_status,sdo.posting_date as delivery_date,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.quantity AS VARCHAR(max)) AS quantity,d.id as driver_id,od.gps_enabled as gps_enabled,sdo.ship_to_address,sdo.ship_to_address_2,sdo.Ship_to_Post_Code,sdo.ship_to_city ,c.mobile as cust_mobile,t.name as trans_name,od.gate_out_date,od.global_id');
				$this->db->from('dbo.posted_sales_dispatch_order as sdo');
				$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id ' , 'LEFT OUTER');
				$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
				$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
				 $this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
				$this->db->where('od.shipping_status', 'Dispatched' );
				$this->db->where('sdo.status', 'Released');
				$this->db->where('d.id', $user_id);
			    $this->db->like('sdo.cust_no', 'c', 'after');
				$sql= $this->db->get()->result_array() ;
				foreach($sql  as $key => $get)
				{
					$arr = explode('To',trim($get['route']));
			        $pickup_address=$arr[0];
					if($pickup_address=='Mandalghar ')
					{
						 $pic_lat ='25.19107';
					     $pic_long= '75.07153';
						 $sql[$key]['pic_lat']= $pic_lat;
						 $sql[$key]['pic_long']= $pic_long;
					} if($pickup_address=='Bapi ')
					{
						//print_r($pickup_address);
						 $pic_lat1 ='26.98766';
					     $pic_long1= '76.28054';
						 $sql[$key]['pic_lat']= $pic_lat1;
						 $sql[$key]['pic_long']= $pic_long1;
					}
					 if($pickup_address=='Dausa ')
					{
						 $pic_lat2 ='26.90080';
					     $pic_long2= '76.32970';
						 $sql[$key]['pic_lat']= $pic_lat2;
						 $sql[$key]['pic_long']= $pic_long2;
					}
					 if($pickup_address=='Ghewaria ')
					{
						 $pic_lat3 ='25.40681';
					     $pic_long3= '75.05411';
						 $sql[$key]['pic_lat']= $pic_lat3;
						 $sql[$key]['pic_long']= $pic_long3;
					}
					 if($pickup_address=='Bhilwara ')
					{
						 $pic_lat3 ='25.34202';
					     $pic_long3= '74.63085';
						 $sql[$key]['pic_lat']= $pic_lat3;
						 $sql[$key]['pic_long']= $pic_long3;
					}
					$ship_to_address =  $get['ship_to_address'];
					$ship_to_address_2 =  $get['ship_to_address_2'];
					$ship_to_post_code =  $get['Ship_to_Post_Code'];
					$ship_to_city =  $get['ship_to_city'];
					//$shipping_address=$ship_to_address.$ship_to_address_2.$ship_to_post_code.$ship_to_city;
					$shipping_address=$ship_to_city;
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
							$sql[$key]['ship_lat']= $ship_lat;
							$sql[$key]['ship_long']= $ship_long;
						}else{
							$sql[$key]['message']= 'Shipping Address Not Found';
						}
					}else{
						    $sql[$key]['message']= 'Shipping Address Not Found';
					}
					/*if(!empty($pickup_address)){
						//Formatted address
						$formattedAddr = str_replace(' ','+',$pickup_address);
						//Send request and receive json data by address
					   $geocodeFromAddr = file_get_contents($details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$formattedAddr."&key=AIzaSyA2_9Lpcxc2d-E1Z3oseySOeYX9aWQL2BA&sensor=false"); 
						$output = json_decode($geocodeFromAddr);
						//Get latitude and longitute from json data
						//$pic_lat  = $output->results[0]->geometry->location->lat; 
					    //$pic_long = $output->results[0]->geometry->location->lng;
						//Return latitude and longitude of the given address
						 if($pic_lat!=''){
							//$sql[$key]['pic_lat']= $pic_lat;
							//$sql[$key]['pic_long']= $pic_long;
						}else{
							$sql[$key]['message']= ' Pickup Address Not Found';
						}
					}else{
						    $sql[$key]['message']= 'Pickup Address Not Found';
					}*/
					$sql[$key]['pickup_address']=$pickup_address;
					$sql[$key]['shipping_address']= $shipping_address;
				}
				return $sql;
			}
			else if($order_type=='completed')
			{
				$this->db->select('DISTINCT(sdo.order_id) as order_id,od.order_status as order_status ,od.shipping_status as shipping_status,sdo.posting_date as delivery_date,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.quantity AS VARCHAR(max)) AS quantity,d.id as driver_id,od.gps_enabled as gps_enabled,sdo.ship_to_address,sdo.ship_to_address_2,sdo.Ship_to_Post_Code,sdo.ship_to_city,d.mobile as driver_mobile,t.name as trans_name,,c.mobile as cust_mobile,od.global_id');
				$this->db->from('dbo.posted_sales_dispatch_order as sdo');
				$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id ' , 'LEFT OUTER');
				$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
				$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
				 $this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
				$this->db->where('od.shipping_status', 'Delivered' );
				$this->db->where('sdo.status', 'Released');
				$this->db->where('d.id', $user_id);
			    $this->db->like('sdo.cust_no', 'c', 'after');
				
				return $this->db->get()->result_array() ;
			}
		 }
    }
	public function orders_full_view($order_id,$user_type)
    {
         if($user_type=='customer')
		 {
			if($order_id)
				{
					$this->db->select('order_id');
					$this->db->from('dbo.sales_dispatched_order');
					$this->db->where('order_id', $order_id);
					$q = $this->db->get();
					
				}
				
				if($q->num_rows() > 0)
				{
					
					/*$this->db->select('sdo.order_id as order_id,sdo.item_code as item_code,sdo.description as description ,sdo.quantity as quantity,sdo.delivery_date as delivery_date ,sdo.ship_to_address as ship_to_address ,sdo.ship_to_address_2 as ship_to_address_2,sdo.Ship_to_Post_Code as ship_to_post_code,sdo.route as route,d.shipping_status as shipping_status,sdo.qty_to_ship as qty_to_ship,t.user_id as transporter_id,t.name as trans_name,dr.id as driver_id,dr.name as driver_name');*/

					$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.delivery_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.quantity AS VARCHAR(max)) AS quantity,sdo.planned_delivery_date as planned_delivery_date,t.user_id as transporter_id,t.name as trans_name,dr.id as driver_id,dr.name as driver_name');

					$this->db->from('dbo.sales_dispatched_order as sdo');
					$this->db->join('dbo.order_details as d', 'd.order_id = sdo.order_id','left outer');
					$this->db->join('dbo.attn_required as ar', 'sdo.order_id = ar.order_id','left outer');
					$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no','left outer');
					$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no','left outer');
					$this->db->join('dbo.driver as dr', 'dr.id = d.driver_id','left outer');
					$this->db->join('dbo.vehicle as v', 'v.id = d.vehicle_id','left outer');
					$this->db->where('sdo.order_id', $order_id);
					  $sql = $this->db->get()->result_array();
					  foreach($sql  as $key => $get)
				     {
						 
				    $items = explode(',', $get['item_code']);
					$qty_to_ship = explode(',', $get['qty_to_ship']);
					$quantity = explode(',', $get['quantity']);
					$description = explode(',', $get['description']);
					$route = explode(',', $get['route']);
					foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $items)) {
							$sql[$key]['item_code']= $items[$qty_key];
						  
					 }}}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  
							$sql[$key]['qty_to_ship']= $qty;
						  
				     }}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $description)) {
							$sql[$key]['description']= $description[$qty_key];
					 }}}
					  foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $quantity)) {
							$sql[$key]['quantity']= $quantity[$qty_key];
					 }}}
					  foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $route)) {
						  
							$route1= $route[$qty_key];
							$arr = explode('To',trim($route1));
			              $sql[$key]['pickup_dress']=$arr[0];
					 }}}
					if($get['shipping_status']=='Dispatched') {
						
						$status=$get['shipping_status'];
					}
					else{
						$status='Awaiting For Dispatch';
					}
					$sql[$key]['shipping_status']=$status;
				     }
				     return $sql;
				}
				else
				{	
			        
					$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.posting_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.quantity AS VARCHAR(max)) AS quantity,sdo.planned_delivery_date as planned_delivery_date,t.user_id as transporter_id,t.name as trans_name,dr.id as driver_id,dr.name as driver_name');

					$this->db->from('dbo.posted_sales_dispatch_order as sdo');
					$this->db->join('dbo.order_details as d', 'd.order_id = sdo.order_id','left outer');
					$this->db->join('dbo.attn_required as ar', 'sdo.order_id = ar.order_id','left outer');
					$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no','left outer');
					$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no','left outer');
					$this->db->join('dbo.driver as dr', 'dr.id = d.driver_id','left outer');
					$this->db->join('dbo.vehicle as v', 'v.id = d.vehicle_id','left outer');
					$this->db->where('sdo.order_id', $order_id);
					  $sql = $this->db->get()->result_array();
					  foreach($sql  as $key => $get)
				     {
						 
				    $items = explode(',', $get['item_code']);
					$qty_to_ship = explode(',', $get['qty_to_ship']);
					$quantity = explode(',', $get['quantity']);
					$description = explode(',', $get['description']);
					$route = explode(',', $get['route']);
					foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $items)) {
							$sql[$key]['item_code']= $items[$qty_key];
						  
					 }}}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  
							$sql[$key]['qty_to_ship']= $qty;
						  
				     }}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $description)) {
							$sql[$key]['description']= $description[$qty_key];
					 }}}
					  foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $quantity)) {
							$sql[$key]['quantity']= $quantity[$qty_key];
					 }}}
					  foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $route)) {
						  
							$route1= $route[$qty_key];
							$arr = explode('To',trim($route1));
			              $sql[$key]['pickup_dress']=$arr[0];
					 }}}
					if($get['shipping_status']=='Dispatched') {
						
						$status=$get['shipping_status'];
					}
					else{
						$status='Awaiting For Dispatch';
					}
					$sql[$key]['shipping_status']=$status;
				     }
				     return $sql;
				}
				
		 }
		 else if($user_type=='transporter')
		 {
			if($order_id)
				{
					$this->db->select('order_id');
					$this->db->from('dbo.sales_dispatched_order');
					$this->db->where('order_id', $order_id);
					$q = $this->db->get();
					
				}
				
				if($q->num_rows() > 0)
				{
		
					/*$this->db->select('sdo.order_id as order_id,sdo.item_code as item_code,sdo.description as description ,sdo.quantity as quantity,sdo.delivery_date as delivery_date ,sdo.ship_to_address as ship_to_address ,sdo.ship_to_address_2 as ship_to_address_2,sdo.Ship_to_Post_Code as ship_to_post_code,sdo.route as route,d.shipping_status as shipping_status,sdo.qty_to_ship as qty_to_ship,t.user_id as transporter_id,t.name as trans_name,dr.id as driver_id,dr.name as driver_name');*/
					$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.delivery_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship ,cast (sdo.quantity AS VARCHAR(max)) as quantity, cast (sdo.route AS VARCHAR(max)) AS route,sdo.planned_delivery_date as planned_delivery_date,t.user_id as transporter_id,t.name as trans_name,dr.id as driver_id,dr.name as driver_name,sdo.ship_to_address,sdo.ship_to_address_2,sdo.Ship_to_Post_Code,sdo.ship_to_city,sdo.status as sales_status,d.gate_in_date,d.gate_out_date,d.tare_weight_date,d.gross_weight_date,d.loading_date,d.loading_out_date');

					$this->db->from('dbo.sales_dispatched_order as sdo');
					$this->db->join('dbo.order_details as d', 'd.order_id = sdo.order_id','left outer');
					$this->db->join('dbo.attn_required as ar', 'sdo.order_id = ar.order_id','left outer');
					$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
					$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company = c.company','left outer');
					$this->db->join('dbo.driver as dr', 'dr.id = d.driver_id','left outer');
					$this->db->join('dbo.vehicle as v', 'v.id = d.vehicle_id','left outer');
					$this->db->where('sdo.order_id', $order_id);
					 $sql = $this->db->get()->result_array();
					//print_r($sql); die;
					  foreach($sql  as $key => $get)
				     {
						 
				   $items = explode(',', $get['item_code']);
					$qty_to_ship = explode(',', $get['qty_to_ship']);
					$quantity = explode(',', $get['quantity']);
					$description = explode(',', $get['description']);
					$route = explode(',', $get['route']);
					foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $items)) {
							$sql[$key]['item_code']= $items[$qty_key];
						  
					 }}}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  
							$sql[$key]['qty_to_ship']= $qty;
						  
				     }}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $description)) {
							$sql[$key]['description']= $description[$qty_key];
					 }}}
					  foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $quantity)) {
							$sql[$key]['quantity']= $quantity[$qty_key];
					 }}}
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $route)) {
						  
							$route1= $route[$qty_key];
							$arr = explode('To',trim($route1));
			              $sql[$key]['pickup_dress']=$arr[0];
					 }}}
					 if ($get['sales_status']=='Reopened') {
						$status='Reopened';
					}
					else
					{
					 if($get['shipping_status']==null) {
						
						$status='';
					}
					else if ($get['shipping_status']=='Tare Weight (Weighbridge)') {
						$status='Weigh In';
					}
					else if ($get['shipping_status']=='Loading)') {
						$status='Loading In';
					}
					else if ($get['shipping_status']=='Loading Out') {
						$status='Loading Out';
					}
					else if ($get['shipping_status']=='Gross Weight (Weighbridge)') {
						$status='Weigh Out';
					}
					else 
						{
						$status=$get['shipping_status'];
					}
				   }
					$sql[$key]['shipping_status']=$status;
				     }
					 return $sql;
				}
				else
				{	
		      $this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.posting_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship ,cast (sdo.quantity AS VARCHAR(max)) as quantity, cast (sdo.route AS VARCHAR(max)) AS route,sdo.planned_delivery_date as planned_delivery_date,t.user_id as transporter_id,t.name as trans_name,dr.id as driver_id,dr.name as driver_name,sdo.ship_to_address,sdo.ship_to_address_2,sdo.Ship_to_Post_Code,sdo.ship_to_city,sdo.status as sales_status,d.gate_in_date,d.gate_out_date,d.tare_weight_date,d.gross_weight_date,d.loading_date,d.loading_out_date');

					$this->db->from('dbo.posted_sales_dispatch_order as sdo');
					$this->db->join('dbo.order_details as d', 'd.order_id = sdo.order_id','left outer');
					$this->db->join('dbo.attn_required as ar', 'sdo.order_id = ar.order_id','left outer');
					$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
					$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company = c.company','left outer');
					$this->db->join('dbo.driver as dr', 'dr.id = d.driver_id','left outer');
					$this->db->join('dbo.vehicle as v', 'v.id = d.vehicle_id','left outer');
					$this->db->where('sdo.order_id', $order_id);
					 $sql = $this->db->get()->result_array();
					//print_r($sql); die;
					  foreach($sql  as $key => $get)
				     {
						 
				   $items = explode(',', $get['item_code']);
					$qty_to_ship = explode(',', $get['qty_to_ship']);
					$quantity = explode(',', $get['quantity']);
					$description = explode(',', $get['description']);
					$route = explode(',', $get['route']);
					foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $items)) {
							$sql[$key]['item_code']= $items[$qty_key];
						  
					 }}}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  
							$sql[$key]['qty_to_ship']= $qty;
						  
				     }}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $description)) {
							$sql[$key]['description']= $description[$qty_key];
					 }}}
					  foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $quantity)) {
							$sql[$key]['quantity']= $quantity[$qty_key];
					 }}}
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $route)) {
						  
							$route1= $route[$qty_key];
							$arr = explode('To',trim($route1));
			              $sql[$key]['pickup_dress']=$arr[0];
					 }}}
					 if ($get['sales_status']=='Reopened') {
						$status='Reopened';
					}
					else
					{
					 if($get['shipping_status']==null) {
						
						$status='';
					}
					else if ($get['shipping_status']=='Tare Weight (Weighbridge)') {
						$status='Weigh In';
					}
					else if ($get['shipping_status']=='Loading)') {
						$status='Loading In';
					}
					else if ($get['shipping_status']=='Loading Out') {
						$status='Loading Out';
					}
					else if ($get['shipping_status']=='Gross Weight (Weighbridge)') {
						$status='Weigh Out';
					}
					else 
						{
						$status=$get['shipping_status'];
					}
				   }
					$sql[$key]['shipping_status']=$status;
				     }
					 return $sql;
			 
		 }
		 }
		 else if($user_type=='driver')
		 {
			 if($order_id)
				{
					$this->db->select('order_id');
					$this->db->from('dbo.sales_dispatched_order');
					$this->db->where('order_id', $order_id);
					$q = $this->db->get();
					
				}
				
				if($q->num_rows() > 0)
				{
					
					$this->db->select('sdo.order_id as order_id,sdo.item_code as item_code,sdo.description as description ,sdo.quantity as quantity,sdo.delivery_date as delivery_date ,sdo.ship_to_address as ship_to_address ,sdo.ship_to_address_2 as ship_to_address_2,sdo.Ship_to_Post_Code as ship_to_post_code,sdo.route as route,d.shipping_status as shipping_status,c.name as cust_name,c.mobile as cust_mobile,sdo.qty_to_ship as qty_to_ship,t.user_id as transporter_id,t.name as trans_name,dr.id as driver_id,dr.name as driver_name');
					$this->db->from('dbo.sales_dispatched_order as sdo');
					$this->db->join('dbo.order_details as d', 'd.order_id = sdo.order_id','left outer');
					$this->db->join('dbo.attn_required as ar', 'sdo.order_id = ar.order_id','left outer');
					$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no','left outer');
					$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no','left outer');
					$this->db->join('dbo.driver as dr', 'dr.id = d.driver_id','left outer');
					$this->db->join('dbo.vehicle as v', 'v.id = d.vehicle_id','left outer');
					$this->db->where('sdo.order_id', $order_id);
					 $sql= $this->db->get()->result_array();
		
					foreach($sql  as $key => $get)
				{
					 $items = explode(',', $get['item_code']);
					$qty_to_ship = explode(',', $get['qty_to_ship']);
					$quantity = explode(',', $get['quantity']);
					$route = explode(',', $get['route']);
					foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $items)) {
							$sql[$key]['item_code']= $items[$qty_key];
						  
					 }}}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  
							$sql[$key]['qty_to_ship']= $qty;
						  
				     }}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $description)) {
							$sql[$key]['description']= $description[$qty_key];
					 }}}
					  foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $quantity)) {
							$sql[$key]['quantity']= $quantity[$qty_key];
					 }}}
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $route)) {
						  
							$route1= $route[$qty_key];
							$arr = explode('To',trim($route1));
			              $sql[$key]['pickup_dress']=$arr[0];
					 }}}
					if($get['shipping_status']=='Gate In') {
						
						$status=$get['shipping_status'];
					}
					else{
						$status='Awaiting For Gate In';
					}
					$sql[$key]['status']=$status;
				}	
				return $sql;
				}
				else
				{	
					/* print('post'); */
					$this->db->select('psdo.order_id as order_id,psdo.item_code as item_code,psdo.description as description ,psdo.quantity as quantity,psdo.posting_date as delivery_date ,psdo.ship_to_address as ship_to_address ,psdo.ship_to_address_2 as ship_to_address_2,psdo.Ship_to_Post_Code as ship_to_post_code,psdo.route as route,d.shipping_status as status,c.name as cust_name,c.mobile as cust_mobile,t.user_id as transporter_id,t.name as trans_name,dr.id as driver_id,dr.name as driver_name,psdo.qty_to_ship as qty_to_ship');
					$this->db->from('dbo.posted_sales_dispatch_order as psdo ');
					$this->db->join('dbo.order_details as d', 'd.order_id = psdo.order_id','left outer');
					$this->db->join('dbo.transporter as t', 't.user_id = psdo.trans_no','left outer');
					$this->db->join('dbo.customer as c', 'c.user_id = psdo.cust_no','left outer');
					$this->db->join('dbo.driver as dr', 'dr.id = d.driver_id','left outer');
					$this->db->join('dbo.vehicle as v', 'v.id = d.vehicle_id','left outer');
					$this->db->where('psdo.order_id', $order_id);
					 $sql= $this->db->get()->result_array();
		
						foreach($sql  as $key => $get)
					{
						$route=$get['route'];
						$arr = explode('To',trim($route));
				        $sql[$key]['pickup_dress']=$arr[0];
					}	
					return $sql;
				}
			 
		 }
		
        
		
    }
	public function edit_users_profile($user_id,$user_type,$update,$global_id)
    {
         if($user_type=='customer')
		 {
			 //*******update profile*********
			 $this->db->where('global_id', $global_id);
		     $sql=$this->db->update('dbo.customer', $update);
			 if ($sql) {
                 return TRUE;
             }
		 }
		 else if($user_type=='transporter')
		 {
			//*******update profile*********
			 $this->db->where('global_id', $global_id);
		     $sql=$this->db->update('dbo.transporter', $update); 
			 if ($sql) {
                 return TRUE;
             }
			 
		 }
		 else if($user_type=='driver')
		 {
			 
			  //*******update profile*********
			 $this->db->where('id', $user_id);
		     $sql=$this->db->update('dbo.driver', $update); 
			  if ($sql) {
                 return TRUE;
             };
			 
		 }
		
        
		
    }
	public function get_orders_details($order_id)
    {
		$this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order');
		$this->db->where('order_id', $order_id);
	   return $this->db->get()->result_array();
     
    }
    public function get_orders_details_orders($order_id)
    {
		$this->db->select('*');
		$this->db->from('dbo.order_details');
		$this->db->where('order_id', $order_id);
	   return $this->db->get()->result_array();
     
    }
     public function get_orders_details_order_rejects($order_id)
    {
		$this->db->select('*');
		$this->db->from('dbo.attn_required');
		$this->db->where('order_id', $order_id);
	   return $this->db->get()->result_array();
     
    }
	public function get_today_dispatched_order($global_id)
    {
      
	   $date=date('Y-m-d');
	   $this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.delivery_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,sdo.planned_delivery_date as planned_delivery_date , sdo.status as sales_status');
			$this->db->from('dbo.sales_dispatched_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			//$this->db->where('sdo.status', 'Released');
			$this->db->like('sdo.cust_no', 'c', 'after');
			$this->db->where('d.shipping_status!=', 'Pending');
		    $this->db->where('sdo.delivery_date', $date);
			$this->db->where('t.global_id', $global_id );
						$sql= $this->db->get()->result_array();
				foreach($sql as $key => $get)
				{
					$items = explode(',', $get['item_code']);
					$qty_to_ship = explode(',', $get['qty_to_ship']);
					$quantity = explode(',', $get['quantity']);
					foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $items)) {
							$sql[$key]['item_code']= $items[$qty_key];
						  
					 }}}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  
							$sql[$key]['qty_to_ship']= $qty;
						  
				     }}	
					 foreach($qty_to_ship as $qty_key => $qty) {
					 if ($qty > '0')
					 {
					  if (array_key_exists($qty_key, $quantity)) {
							$sql[$key]['quantity']= $quantity[$qty_key];
					 }}}
					 if ($get['sales_status']=='Reopened') {
						$status='Reopened';
					}
					else
					{
					 if($get['shipping_status']==null) {
						
						$status='';
					}
					else if ($get['shipping_status']=='Tare Weight (Weighbridge)') {
						$status='Weigh In';
					}
					else if ($get['shipping_status']=='Loading') {
						$status='Loading In';
					}
					else if ($get['shipping_status']=='Loading Out') {
						$status='Loading Out';
					}
					else if ($get['shipping_status']=='Gross Weight (Weighbridge)') {
						$status='Weigh Out';
					}
					else 
						{
						$status=$get['shipping_status'];;
					}
				}
				$sql[$key]['shipping_status']=$status;
				}					 
				return $sql;
		
    }
	public function get_today_posted_dispatched_order($global_id)
    {
		 $date=date('Y-m-d');
      $this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.posting_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship ,cast (sdo.quantity AS VARCHAR(max)) as quantity, cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date,sdo.status as sales_status,d.gate_in_date,d.gate_out_date,d.tare_weight_date,d.gross_weight_date,d.loading_date,d.loading_out_date ');
			$this->db->from('dbo.posted_sales_dispatch_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->where('sdo.status', 'Released');
			$this->db->like('sdo.cust_no', 'c', 'after');
			$this->db->where('t.global_id', $global_id );
			$this->db->where("(d.shipping_status = 'Dispatched' OR d.order_status ='Completed') AND sdo.posting_date='".$date."' ");
			return $this->db->get()->result_array();
		
    }
    public function get_bidding_orders($global_id)
    {
    	    
      $this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,sdo.delivery_date as delivery_date,c.name as cust_name,sdo.cust_no as cust_no,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship ,cast (sdo.quantity AS VARCHAR(max)) as quantity, cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date,sdo.status as sales_status,ar.reason,sdo.ship_to_address as ship_to_address ,sdo.ship_to_address_2 as ship_to_address_2,sdo.Ship_to_Post_Code as ship_to_post_code');
			$this->db->from('dbo.sales_dispatched_order as sdo');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			$this->db->where('sdo.status', 'Released');
			$this->db->like('sdo.cust_no', 'c', 'after'); 
		    $this->db->where('sdo.trans_no', '');
			$sql = $this->db->get()->result_array();
			foreach ($sql as $key => $get) {

				 $this->db->select('*');
            		$this->db->from('dbo.settings');
            		$q1 = $this->db->get()->row();
            		$bid_hours = $q1->bidding_hours;
            	    $posting_date=$get['delivery_date'];
            		$time = "00:00:00";
            		$acutal_date = $posting_date." ".$time;
            		if($bid_hours<0)
            	{
            		$hours=(-$bid_hours);
            	    $newdate = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
            	
            	}
            	else{
            	   $newdate = strtotime ( '-'.$bid_hours.' hour' , strtotime ($acutal_date ) ) ;
            	   $newdate = date ( 'Y-m-d H:i:s' , $newdate );
            	}
            	   $current_date = date("Y-m-d H:i:s");
            	   if(strtotime($current_date) >= strtotime($newdate))
            		{
					$k= $this->db->query("SELECT transporter_no,global_id FROM dbo.bidding_orders WHERE bid_amount = (SELECT MIN(bid_amount) FROM dbo.bidding_orders WHERE order_id = '".$get['order_id']."' )");
            			$sql1 = $k->row();
            			 
            			if(!empty($sql1))
            			{
            			
            				$this->db->select('order_id,cust_no');
            				$this->db->from('dbo.sales_dispatched_order');
            				$this->db->where('order_id', $get['order_id'] );
            				$query = $this->db->get();
            				$rows = $query->row();
            				
            				$insert=array(
            					'order_id' => $rows->order_id,
            					'trans_no' => $sql1->transporter_no,
            					'global_id' => $sql1->global_id,   
            					'cust_no' => $rows->cust_no,   
            					'vehicle_id' => '',
            					'driver_id' => '',
            					'shipping_status' => 'Pending',
            					'order_status' => 'Pending',
            					'time' => '',
            					'lr_rr_file' => '',
            					'eway_no' => '',
            					'lr_rr_no' => '',
            					'lr_rr_date' => '',
            					'eway_file' => '',
            					'gps_enabled' => '',
            					'qr_code' => '',
            					'qr_status' => '',
            					'insurance_no' => '',
            					'order_created_status' => 'Bid',
            						 
            				);
            			    
            				 /*print_r($value);
            				die; */
            				$query = $this->db->insert('dbo.order_details',$insert);
            				if(! $query)
            				{
            					 echo 'error';
            					//print_r($this->db->error());
            					//die;
            				}
            				else
            				{
            					$values=array(
            						'trans_no' => $sql1->transporter_no, 
            					);
            					$this->db->where('order_id',$get['order_id']);
            					$res = $this->db->update('dbo.sales_dispatched_order',$values);
            					if(!$res)
            					{
            						//print_r($this->db->error());
            						//die;
            					}
            					else{
            						       $company=$get['company'];
            						       $order_key=$get['order_key'];
            						     
            								/*echo '<script type="text/javascript">
                                                                      $(document).ready(function(){ update_transporter("'.$sql1->transporter_no.'","'.$company.'","'.$order_key.'");
            							   })
                                                                       </script>';*/

                                            $controllerInstance = & get_instance();
                                            $controllerData = $controllerInstance->update_transporter($sql1->transporter_no,$company,$order_key);
                                            return  $controllerInstance;
            					}
            						//$this->db->where('order_id', $value['order_id']);
            					  //  $this->db->delete('dbo.bidding_orders');
            				}
            			}
            			else{
            			//	echo 'aaaaaaaa';
            				/****attn required****/
            					   $this->db->select('*');
            					   $this->db->from('dbo.attn_required');
            					   $this->db->where('order_id', $get['order_id']);
            					   $this->db->where('reason', 'No Bidding placed');
            							$res= $this->db->get()->result_array(); 
            							foreach($res as $get_data)
            							{
            								$id=$get_data['id'];
            								$customer_no=$get_data['customer_no'];
            								$order_id=$get_data['order_id'];
            								$transporter_no=$get_data['transporter_no'];
            								$delivery_date=$get_data['delivery_date'];
            								$reason=$get_data['reason'];
            							}
            							if($order_id==$get['order_id'])
            							{
            								$update=array(
            								'order_id' => $order_id,
            								'customer_no' => $customer_no,
            								'transporter_no' => $transporter_no,
            								'reason' => $reason,
            								'delivery_date' => $delivery_date,
            								);
            						
            								 $this->db->where('order_id', $order_id);
            								 $this->db->where('reason', 'No Bidding placed');
            								 $data=$this->db->update('dbo.attn_required', $update);
            							}
            							else{
            									$save=array(
            									'order_id' => $get['order_id'],
            									'global_id' => '',
            									'customer_no' => $get['cust_no'],
            									'transporter_no' => '', 
            									'delivery_date' => $get['delivery_date'], 
            									'reason' => 'No Bidding placed',
            					        	   );
            					               $data=$this->db->insert('dbo.attn_required', $save);
                                          
                                           //$this->load->model('notification_save');
                                           $sender='transporter';
                                           $receiver='admin';
                                           $result = $this->notification_save->save_notification_all($order_id,'no_bidding_place',$sender,$receiver);
            					            }
            			    }
            		}
			else{
						$attn_reason = $get['reason'];
												
						$arr = explode(' ',trim($attn_reason));
						$reject= $arr[0];
						
						if($reject!='No')
					    {
						           
					   $this->db->select('MIN(bid_amount) as lowest_amount, unit');
				       $this->db->from('dbo.bidding_orders');
				       $this->db->where('order_id', $get['order_id']);
				       $this->db->group_by('unit'); 
				       $q2 = $this->db->get()->row(); 
				       $json['total_bid']=count($q2) ;
				       if($q2->lowest_amount==null)
				       {
				       	 	$json['lowest_amount']='--';
				       }
				       else
				       {
					     	$json['lowest_amount']=$q2->lowest_amount;
					     //$qty= array_sum($value['quantity']);
					   }
					    $route  =$get['route'];
							 
						$arr = explode('To',trim($route));
					    $json['pickup_address']=$arr[0];
				        $ship_to_address =  $get['ship_to_address'];
						$ship_to_address_2 =  $get['ship_to_address_2'];
						$ship_to_post_code =  $get['Ship_to_Post_Code'];
						$ship_to_city =  $get['ship_to_city'];
						$json['shipping_address']=$ship_to_address.$ship_to_address_2.$ship_to_post_code.$ship_to_city;
					   	$json['order_id']=$get['order_id'];
					   	$json['delivery_date']=$get['delivery_date'];
					   	$json['item_code']=$get['item_code'];
					   	$json['cust_name']=$get['cust_name'];
					   	$json['quantity']=$get['quantity'];
					   	$json['qty_to_ship']=$get['qty_to_ship'];
					   	$json['description']=$get['description'];
					   	$json['route']=$get['route'];
					   	$json['planned_delivery_date']=$get['planned_delivery_date'];
					   	$json['status']='Open';
					   	$json['timer']=$newdate;

			        $this->db->select('*');
					$this->db->from('dbo.bidding_orders');
					$this->db->where('global_id', $global_id );
					$this->db->where('order_id', $get['order_id']);
					$bid = $this->db->get();
					if($bid->num_rows() > 0)
						{
							if(strtotime($current_date) >= strtotime($newdate))
					         {
			                   $json['bid_status']='>Awating for Acceptance ';
					         }
					         else
					         {
			                  $json['bid_status']='Edit Bid';
					         }
					     }
					     else
					     {
			                  $json['bid_status']='Bid Now';
					     }
					    $array[]=$json;
			   
		}
	}
			
		}
		 return $array;	
             
    }
	public function get_awarded_orders($global_id)
    {
    	    $bid=array();
    	    $admin=array();
            $date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as status,sdo.delivery_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship ,cast (sdo.quantity AS VARCHAR(max)) as quantity, cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date, sdo.status as sales_status,d.order_created_status as ocs_status, cast (sdo.order_key AS VARCHAR(max)) as order_key,ar.reason as reason'); 
			$this->db->from('dbo.sales_dispatched_order as sdo'); 
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			//$this->db->where('sdo.status', 'Released');
			$this->db->like('sdo.cust_no', 'c', 'after');
			$this->db->where('sdo.trans_no!=', '');
			$this->db->where('t.global_id', $global_id);
			$result = $this->db->get()->result_array(); 
			//print_r($result);
			foreach($result as $key => $value1)
		 { 
		             
			                      if($value1['ocs_status']=='Bid')
								  {
								  	  //echo 'fclose(handle)';

									 if ($value1['order_status']=='Pending' && $value1['ocs_status']=='Bid' )
								      {
										 
										   $this->db->select('*');
	                                       $this->db->from('dbo.settings');
										   $data1= $this->db->get()->result_array(); 
										 
										$time = "00:00:00";
										foreach($data1 as $get1)
										{
											
											$bid_hours=$get1['assign_bidding_hours'];
											$assign_bidding_hours_second=$get1['assign_bidding_hours_second'];
											//echo $bid_hours;
										}
										
										$delivery_date=$value1['delivery_date'];
										$acutal_date = $delivery_date." ".$time;
                                         if($bid_hours<0)
										{
										$hours=(-$bid_hours);
										//echo $hours;
										$bid_newdate = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
										
										}
										else{
											
										$bid_newdate = strtotime ( '-'.$bid_hours.' hour' , strtotime ($acutal_date ) ) ;
										
										$bid_newdate = date ( 'Y-m-d H:i:s' , $bid_newdate );
										}
										if($assign_bidding_hours_second<0)
										{
										$hours=(-$assign_bidding_hours_second);
										//echo $hours;
										$bid_newdate_second = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
										
										}
										else{
											
										$bid_newdate1 = strtotime ( '-'.$assign_bidding_hours_second.' hour' , strtotime ($acutal_date ) ) ;
										
										$bid_newdate_second = date ( 'Y-m-d H:i:s' , $bid_newdate1 );
										}
										
								  }
								      $this->db->select('*');
	                                  $this->db->from('dbo.attn_required');
								      $this->db->where('order_id', $value1['order_id']);
									  $result= $this->db->get()->result_array();
									 //print_r( $value1['order_id']);
									       $current_date = date("Y-m-d H:i:s");
											if((strtotime($current_date) >= strtotime($bid_newdate)) OR $result)
											{
												//echo 'sfsdfsd';
												$k= $this->db->query("SELECT bid_amount,transporter_no,global_id FROM bidding_orders e WHERE 2=(SELECT COUNT(DISTINCT bid_amount) FROM bidding_orders p WHERE e.bid_amount>=p.bid_amount AND e.order_id = '".$value1['order_id']."' )");
												$sql1 = $k->row();
												
												if(!empty($sql1))
												{
													
													$this->db->select('*');
													$this->db->from('dbo.sales_dispatched_order');
													$this->db->where('order_id', $value1['order_id'] );
													$query = $this->db->get();
													$rows = $query->row();
													
													 
													$value=array(
														'order_id' => $rows->order_id,
														'trans_no' => $sql1->transporter_no,
														'global_id' => $sql1->global_id,
														'cust_no' => $rows->cust_no,  
															 
													);
												     
													
													$this->db->where('order_id',$value1['order_id']);
													$query = $this->db->update('dbo.order_details',$value);
													if(! $query)
													{
														print_r($this->db->error());
														die;
													}
													else
													{
														
														$values=array(
															'trans_no' => $sql1->transporter_no, 
														);
														$this->db->where('order_id',$value1['order_id']);
														$sql = $this->db->update('dbo.sales_dispatched_order',$values);
														if(!$sql)
														{
															print_r($this->db->error());
															die;
														}
														else{
															       $company=$value1['company'];
															       $order_key=$value1['order_key'];
															     
													 $controllerInstance = & get_instance();
                                                     $controllerData = $controllerInstance->update_transporter($sql1->transporter_no,$company,$order_key);
                                                     return  $controllerInstance;
																
														}
															 
													}
													if(strtotime($current_date) >= strtotime($bid_newdate_second)){
														
														 /*********rating*******/
												    $this->db->select('*');
													$this->db->from('dbo.trans_rating');
													$this->db->where('order_id', $value1['order_id'] );
													$this->db->where('global_id', $value1['global_id'] );
													
													$query = $this->db->get();
													$rating = $query->row();
													if($rating->order_id==$value1['order_id'])
									              	{
													$update=array(
													
													     'order_id' => $rating->order_id,
														 'global_id' => $rating->global_id,
													);
													$this->db->where('order_id', $value1['order_id']);
									               
                                                    $data=$this->db->update('dbo.trans_rating', $update);
													}
													else{
														
														$insert=array(
													
													     'order_id' => $value1['order_id'],
														 'global_id' => $sql1->global_id,
														 'accept_and_assign' => '0',
														
													);
													   $data=$this->db->insert('dbo.trans_rating', $insert);
													} 
													/*****end rating*****/ 
								      $this->db->select('*');
	                                  $this->db->from('dbo.attn_required');
								      $this->db->where('order_id', $value1['order_id']);
									  $this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res= $this->db->get()->result_array(); 
										foreach($res as $get_data)
										{
											$id=$get_data['id'];
											$customer_no=$get_data['customer_no'];
											$order_id=$get_data['order_id'];
											$global_id1=$get_data['global_id'];
											$transporter_no=$get_data['transporter_no'];
											$delivery_date=$get_data['delivery_date'];
											$reason=$get_data['reason'];
										}
										if($order_id==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.attn_required', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $sql1->global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $sql1->transporter_no, 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.attn_required', $save);
                                   $this->load->model('notification_save');
                                   $sender='transporter';
				                   $receiver='admin';
				                   $result = $this->notification_save->save_notification_all($order_id,'order_not_assign',$sender,$receiver);
                                       }
									    /********end attn required****/
								   /********missed orders****/
								    $this->db->select('*');
	                                $this->db->from('dbo.missed_orders');
								    $this->db->where('order_id', $value1['order_id']);
									$this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res1= $this->db->get()->result_array(); 
										foreach($res1 as $get_data1)
										{
											$id=$get_data1['id'];
											$customer_no=$get_data1['customer_no'];
											$order_id1=$get_data1['order_id'];
											$global_id1=$get_data1['global_id'];
											$transporter_no=$get_data1['transporter_no'];
											$delivery_date=$get_data1['delivery_date'];
											$reason=$get_data1['reason'];
										}
								if($order_id1==$value1['order_id'])
								{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id1);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.missed_orders', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $sql1->global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $sql1->transporter_no, 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.missed_orders', $save);
								   
                                       } 
											    $this->db->where('order_id', $value1['order_id']);
											    $this->db->delete('dbo.bidding_orders');
												$this->db->where('order_id', $value1['order_id']);
                                                $this->db->delete('dbo.order_details');
												    }
												}
												 
												else{
													 /*********rating*******/
												 $this->db->select('*');
													$this->db->from('dbo.trans_rating');
													$this->db->where('order_id', $value1['order_id'] );
													$this->db->where('global_id', $value1['global_id'] );
												
													$query = $this->db->get();
													$rating = $query->row();
													if($rating->order_id==$value1['order_id'])
									              	{
													$update=array(
													     'order_id' => $rating->order_id,
														 'global_id' => $rating->global_id,
													);
													$this->db->where('order_id', $value1['order_id']);
									          
                                                    $data=$this->db->update('dbo.trans_rating', $update);
													}
													else{
														
														$insert=array(
													
													     'order_id' => $value1['order_id'],
														 'global_id' => $sql1->global_id,
														 'accept_and_assign' => '0',
														 
													);
													   $data=$this->db->insert('dbo.trans_rating', $insert);
													} 
													/*****end rating*****/ 

													
													/********attn required****/
									  $this->db->select('*');
	                                  $this->db->from('dbo.attn_required');
								      $this->db->where('order_id', $value1['order_id']);
									  $this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res= $this->db->get()->result_array(); 
										foreach($res as $get_data)
										{
											$id=$get_data['id'];
											$customer_no=$get_data['customer_no'];
											$order_id=$get_data['order_id'];
											$global_id1=$get_data['global_id'];
											$transporter_no=$get_data['transporter_no'];
											$delivery_date=$get_data['delivery_date'];
											$reason=$get_data['reason'];
										}
										if($order_id==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.attn_required', $update);
									 }
										else{
								$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $sql1->global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $sql1->transporter_no, 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.attn_required', $save);
								   $this->db->where('order_id', $order_id);
								   $query1 = $this->db->delete('dbo.order_details');

								   $this->load->model('notification_save');
                                   $sender='transporter';
				                   $receiver='admin';
				                   $result = $this->notification_save->save_notification_all($order_id,'order_not_assign',$sender,$receiver);
                                       }
									    /********end attn required****/
								   /********missed orders****/
								  $this->db->select('*');
	                               $this->db->from('dbo.missed_orders');
								   $this->db->where('order_id', $value1['order_id']);
								   $this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res1= $this->db->get()->result_array(); 
										foreach($res1 as $get_data1)
										{
											$id=$get_data1['id'];
											$customer_no=$get_data1['customer_no'];
											$order_id1=$get_data1['order_id'];
											$global_id1=$get_data1['global_id'];
											$transporter_no=$get_data1['transporter_no'];
											$delivery_date=$get_data1['delivery_date'];
											$reason=$get_data1['reason'];
										}
										if($order_id1==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id1);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.missed_orders', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $sql1->global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $sql1->transporter_no,
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.missed_orders', $save);
								   
                                       } 
									                $this->db->where('order_id', $value1['order_id']);
		                                            $this->db->delete('dbo.order_details');
													$this->db->where('order_id', $value1['order_id']);
												    $this->db->delete('dbo.bidding_orders');

                                                    $this->db->where('order_id', $value1['order_id']);
                                                    $this->db->where("(reason LIKE 'Rejected%'");
												    $this->db->delete('dbo.attn_required');
											 	    }
											}
										
									$items = explode(',', $value1['item_code']);
									$descriptions = explode(',', $value1['description']);
									$qty_to_ship = explode(',', $value1['qty_to_ship']);
									$quantity = explode(',', $value1['quantity']);
									$route = explode(',', $value1['route']);
									$order_status = $value1['order_status'];
									$attn_reason = $value1['reason'];
									//print_r($attn_reason);
									/* foreach($quantity as $qty_key => $qty) { */
                                       if(array_fill(0,count($quantity),'0') === array_values($quantity)){
										 }
							 else{
	
									$arr = explode(' ',trim($attn_reason));
									$reject= $arr[0];
									
									if($reject!='Not')
									{
										if( $value1['order_status']!='Inprocess')
									  {

		                                     $json['delivery_date']= $value1['delivery_date'];
											    $json['order_id']= $value1['order_id'];
											   // $json['timer']= $timer;
												foreach($qty_to_ship as $qty_key => $qty) {
											 if ($qty > '0')
											 {
											  if (array_key_exists($qty_key, $items)) {
													$json['item_code']= $items[$qty_key];
												  
											 }}}
											 
											 foreach($qty_to_ship as $qty_key => $qty) {
											 if ($qty > '0')
											 {
											  if (array_key_exists($qty_key, $descriptions)) {
													$json['descriptions']= $descriptions[$qty_key];
											 }}}
											  foreach($qty_to_ship as $qty_key => $qty) {
											 if ($qty > '0')
											 {
											  if (array_key_exists($qty_key, $qty_to_ship)) {
													$json['quantity']= $qty_to_ship[$qty_key];
											 }}}
											 foreach($qty_to_ship as $qty_key => $qty) {
											 if ($qty > '0')
											 {
											  if (array_key_exists($qty_key, $route)) {
													$json['route']= $route[$qty_key];
											 }}}
									 
								 if($value1['order_status']=='') {
							
								  // $json['timer'] = $newdate;

                                  }  else if($value1['order_status']=='Pending' && $value1['ocs_status']=='Admin' ) {
								        $json['timer']= $newdate;
								  
								 } else if($value1['order_status']=='Pending' && $value1['ocs_status']=='Bid' ) {
                                     if((strtotime($current_date) >= strtotime($bid_newdate)) OR $result)
											{
								       
								 $json['timer']= $bid_newdate_second ;
								} else { 
								  $json['timer']=$bid_newdate ;
								 
                                 }} 

								
								   if($value1['sales_status']=='Reopened') { 
									 $json['sales_status']= $value1['sales_status'];
									} else if($value1['sales_status']=='Released') {
                                 
											 
												if($value1['order_status'] == 'Pending')
												{
												
													$json['first_button']='Assign Order';
													if($value1['order_status']=='Pending' && $value1['ocs_status']=='Bid' ) {
                                                      if((strtotime($current_date) >= strtotime($bid_newdate)) OR $result)
											              { } else { 
													       $json['second_button']='Reject';
													}
												}
												}
												else
												{
													//$json['first_button']='Accept';
													//$json['second_button']='Reject';
												}
												   $json['type']='Awarded From Bid';
								                }
  
		                                       if($json==null)
									            {

												} else {
													$bid[]=$json;
											   }
                             
									}
								  }
								 }
						        }
								 /****end bid assign order******/ 
				            else{  	
								  if($value1['order_status']=='')
								  {
									 
								       $this->db->select('*');
	                                   $this->db->from('dbo.settings');
										$data= $this->db->get()->result_array(); 
										
										$time = "00:00:00";
										foreach($data as $get1)
										{
											$allowance_hours=$get1['allowance_hours'];
										}
										
										$delivery_date=$value1['delivery_date'];
										$acutal_date = $delivery_date." ".$time;
										if($allowance_hours<0)
										{
											$hours=(-$allowance_hours);
											
										$newdate = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
										
										}
										else{
											
											
											/* echo $acutal_date;  */
										$newdate = strtotime ( '-'.$allowance_hours.' hour' , strtotime ($acutal_date ) ) ;
										
										$newdate = date ( 'Y-m-d H:i:s' , $newdate );
										}
								  }
								  else if ($value1['order_status']=='Pending' && $value1['ocs_status']=='Admin' )
								  {
									 
								       $this->db->select('*');
	                                   $this->db->from('dbo.settings');
										$data= $this->db->get()->result_array();
										
										$time = "00:00:00";
										foreach($data as $get1)
										{
											$assign_hours=$get1['assign_hours'];
										
										}
										
										$delivery_date=$value1['delivery_date'];
										$acutal_date = $delivery_date." ".$time;
										if($assign_hours<0)
										{
											$hours=(-$assign_hours);
											
										$newdate = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
										
										}
										else{
											
											
											/* echo $acutal_date;  */
									$newdate = strtotime ( '-'.$assign_hours.' hour' , strtotime ($acutal_date ) ) ;
										
										$newdate = date ( 'Y-m-d H:i:s' , $newdate );
										}
								     }								 
                              	   
							     if(strtotime($current_date) >= strtotime($newdate))
								{
									
									//echo $newdate;

								if($value1['order_status']=='')
								  {
									  /********attn required****/
								   $this->db->select('*');
	                               $this->db->from('dbo.attn_required');
								    $this->db->where('order_id', $value1['order_id']);
									 $this->db->where('reason', 'Not accepted in given time frame by vendor');
										$res= $this->db->get()->result_array(); 
										foreach($res as $get_data)
										{
											$id=$get_data['id'];
											$customer_no=$get_data['customer_no'];
											$order_id=$get_data['order_id'];
											$transporter_no=$get_data['transporter_no'];
											$delivery_date=$get_data['delivery_date'];
											$reason=$get_data['reason'];
											$global_id1=$get_data['global_id'];
										}
										if($order_id==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id);
									 $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                     $data=$this->db->update('dbo.attn_required', $update);
								  }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $value1['trans_no'], 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not accepted in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.attn_required', $save);

                                   $this->load->model('notification_save');
                                   $sender='transporter';
				                   $receiver='admin';
				                   $result = $this->notification_save->save_notification_all($order_id,'order_not_accept',$sender,$receiver);
                                   }
								   /********end attn required****/
								   /********missed orders****/
								     $this->db->select('*');
	                                 $this->db->from('dbo.missed_orders');
								     $this->db->where('order_id', $value1['order_id']);
									 $this->db->where('reason', 'Not accepted in given time frame by vendor');
										$res1= $this->db->get()->result_array(); 
										foreach($res1 as $get_data1)
										{
											$id=$get_data1['id'];
											$customer_no=$get_data1['customer_no'];
											$order_id1=$get_data1['order_id'];
											$global_id1=$get_data1['global_id'];
											$transporter_no=$get_data1['transporter_no'];
											$delivery_date=$get_data1['delivery_date'];
											$reason=$get_data1['reason'];
										}
										if($order_id1==$value1['order_id'])
										{
											
									$update=array(
									'order_id' => $order_id1,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id1);
									 $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                     $data=$this->db->update('dbo.missed_orders', $update);
								  }
										else{
											
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $value1['trans_no'], 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not accepted in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.missed_orders', $save);
								   
								  
								  }
								   /********end missed orders****/
								  }
								  else if ($value1['order_status']=='Pending' && $value1['ocs_status']=='Admin' )
								  {
									                /*********rating*******/
													$this->db->select('*');
													$this->db->from('dbo.trans_rating');
													$this->db->where('order_id', $value1['order_id'] );
													$this->db->where('global_id', $value1['global_id'] );
													$query = $this->db->get();
													$rating = $query->row();
													if($rating->order_id==$value1['order_id'])
									              	{
													$update=array(
													
													     'order_id' => $rating->order_id,
														 'global_id' => $rating->global_id,
													);
													$this->db->where('order_id', $value1['order_id']);
                                                    $data=$this->db->update('dbo.trans_rating', $update);
													}
													else{
														
														$insert=array(
													
													     'order_id' => $value1['order_id'],
														 'global_id' => $global_id,
														 'accept_and_assign' => '0',
														 
													);
													   $data=$this->db->insert('dbo.trans_rating', $insert);
													} 
													/*****end rating*****/ 
									  /********attn required****/
									$this->db->select('*');
	                                $this->db->from('dbo.attn_required');
								    $this->db->where('order_id', $value1['order_id']);
									$this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res= $this->db->get()->result_array(); 
										foreach($res as $get_data)
										{
											$id=$get_data['id'];
											$customer_no=$get_data['customer_no'];
											$order_id=$get_data['order_id'];
											$global_id1=$get_data['global_id'];
											$transporter_no=$get_data['transporter_no'];
											$delivery_date=$get_data['delivery_date'];
											$reason=$get_data['reason'];
										}
										if($order_id==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.attn_required', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $value1['trans_no'], 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.attn_required', $save);
								   $this->db->where('order_id', $order_id);
								   $query1 = $this->db->delete('dbo.order_details');

								   $this->load->model('notification_save');
                                   $sender='transporter';
				                   $receiver='admin';
				                   $result = $this->notification_save->save_notification_all($order_id,'order_not_assign',$sender,$receiver);
                                       }
									    /********end attn required****/
								   /********missed orders****/
								  $this->db->select('*');
	                               $this->db->from('dbo.missed_orders');
								    $this->db->where('order_id', $value1['order_id']);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
										$res1= $this->db->get()->result_array(); 
										foreach($res1 as $get_data1)
										{
											$id=$get_data1['id'];
											$customer_no=$get_data1['customer_no'];
											$order_id1=$get_data1['order_id'];
											$global_id1=$get_data1['global_id'];
											$transporter_no=$get_data1['transporter_no'];
											$delivery_date=$get_data1['delivery_date'];
											$reason=$get_data1['reason'];
										}
										if($order_id1==$value1['order_id'])
										{
									$update=array(
									'order_id' => $order_id,
									'global_id' => $global_id1,
									'customer_no' => $customer_no,
									'transporter_no' => $transporter_no,
									'reason' => $reason,
									'delivery_date' => $delivery_date,
									);
									
									 $this->db->where('order_id', $order_id1);
									 $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                     $data=$this->db->update('dbo.missed_orders', $update);
									 }
										else{
											$save=array(
									'order_id' => $value1['order_id'],
									'global_id' => $global_id,
									'customer_no' => $value1['cust_no'],
									'transporter_no' => $value1['trans_no'], 
									'delivery_date' => $value1['delivery_date'], 
									'reason' => 'Not assigned in given time frame by vendor',
									);
                                   $data=$this->db->insert('dbo.missed_orders', $save);
                                       }
								  }
								  }
								  else{
								 
									$items = explode(',', $value1['item_code']);
									$descriptions = explode(',', $value1['description']);
									$qty_to_ship = explode(',', $value1['qty_to_ship']);
									$quantity = explode(',', $value1['quantity']);
									$route = explode(',', $value1['route']);
									$order_status = $value1['order_status'];
									$attn_reason = $value1['reason'];
									//print_r($attn_reason);
									/* foreach($quantity as $qty_key => $qty) { */
                                      if(array_fill(0,count($quantity),'0') === array_values($quantity)){

										 }
										 else{
										 
									
									$arr = explode(' ',trim($attn_reason));
									$reject= $arr[0];
									
									if(!$reject=='Rejected' or !$reject=='Not')
										{
										if( $value1['order_status']!='Inprocess')
								  {
								       $json['delivery_date']= $value1['delivery_date'];
									    $json['order_id']= $value1['order_id'];
									    //$json['timer']= $timer;
										foreach($qty_to_ship as $qty_key => $qty) {
									 if ($qty > '0')
									 {
									  if (array_key_exists($qty_key, $items)) {
											$json['item_code']= $items[$qty_key];
										  
									 }}}
									 
									 foreach($qty_to_ship as $qty_key => $qty) {
									 if ($qty > '0')
									 {
									  if (array_key_exists($qty_key, $descriptions)) {
											$json['descriptions']= $descriptions[$qty_key];
									 }}}
									  foreach($qty_to_ship as $qty_key => $qty) {
									 if ($qty > '0')
									 {
									  if (array_key_exists($qty_key, $qty_to_ship)) {
											$json['quantity']= $qty_to_ship[$qty_key];
									 }}}
									 foreach($qty_to_ship as $qty_key => $qty) {
									 if ($qty > '0')
									 {
									  if (array_key_exists($qty_key, $route)) {
											$json['route']= $route[$qty_key];
									 }}}
									 
								  if($value1['order_status']=='') { 
								  $json['timer'] = $newdate ;
                                 }  else if($value1['order_status']=='Pending' && $value1['ocs_status']=='Admin' ) {
								   $json['timer']= $newdate ;
								  
								  } else if($value1['order_status']=='Pending' && $value1['ocs_status']=='Bid' ) { 
								   $json['timer']= $bid_newdate ;
                                 } 

								
								   if($value1['sales_status']=='Reopened') { 
									       $json['sales_status']='Reopened';
									} else if($value1['sales_status']=='Released') { 
                                   
											
												if($value1['order_status']=='Pending')
												{
												
													$json['first_button']='Assign Order';
												
												}
												else if($value1['order_status']=='')
												{
											    	$json['first_button']='Accept';
											    	$json['second_button']='Reject';
												}
											
												$json['type']='Assigned From Admin';
								   }
		                                       if($json==null)
									            {

												} else {
													$admin[]=$json;
												  }
						
									  }
									  
								    }
								  }
							   }
						 }
		}
		$new_array = array_merge($admin,$bid);
		return $new_array;
    }
	 public function get_driver_list($global_id)
    {
		$this->db->select('name as name ,mobile as mobile,license_no as license_no,id as driver_id');
	    $this->db->from('dbo.driver');
		$this->db->where('global_id', $global_id);
        return $this->db->get()->result_array();
		
    }
	public function match_otp($otp,$driver_id,$order_id)
    {
		$this->db->select('*');
	    $this->db->from('dbo.order_details');
		$this->db->where('driver_id', $driver_id);
		$this->db->where('order_id', $order_id);
		$this->db->where('otp', $otp);
        return $this->db->get()->result_array();
		
    }
	public function cust_match_otp($otp,$user_id,$order_id)
    {
		$this->db->select('*');
	    $this->db->from('dbo.order_details');
		$this->db->where('cust_no', $user_id);
		$this->db->where('order_id', $order_id);
		$this->db->where('otp', $otp);
        return $this->db->get()->result_array();
		
    }
	public function get_order_id_for_map($driver_id)
    {
		$this->db->select('order_id as order_id');
	    $this->db->from('dbo.order_details');
		$this->db->where('driver_id', $driver_id);
		$this->db->where('shipping_status', 'Dispatched');
        return $this->db->get()->result_array();
		
    }
	 public function get_vehicle_list($global_id)
    {
		$this->db->select('*');
	    $this->db->from('dbo.vehicle');
		$this->db->where('global_id', $global_id);
        return $this->db->get()->result_array();
		
    }
	public function get_transporter_list()
    {
		$this->db->select('user_id as transporter_id ,name as name');
	    $this->db->from('dbo.transporter');
        return $this->db->get()->result_array();
		
    }
	public function get_wallet_amount($user_id)
    {
		$this->db->select('wallet_amount as wallet_amount');
	    $this->db->from('dbo.driver');
		$this->db->where('id', $user_id);
        return $this->db->get()->result_array();
		
    }
	public function get_lat_long_gps_on($driver_id)
    {
		$this->db->select('latitude  as lat,longitude as long ,id as driver_id ,name as name');
	    $this->db->from('dbo.driver');
		$this->db->where('id', $driver_id);
        $res= $this->db->get()->result_array();
		foreach($res as $key => $value)
		{
			
			$lat=$value['lat'];
			$long=$value['long'];
			
		
			if($lat=='0.000000' or $long=='0.000000')
			{
				$res[$key]['altitude']='25.35688';
				$res[$key]['longitude']='75.35688';
			}
			else{
				$res[$key]['altitude']=$lat;
				$res[$key]['longitude']=$long;
			}
		}
		return $res;
		
    }
	public function get_milestone_setting()
    {
		$this->db->select('*');
	    $this->db->from('dbo.settings');
        return $this->db->get()->result_array();
		
    }
	public function get_milestone_details($driver_id)
    {
		$this->db->select('*');
	    $this->db->from('dbo.milestone');
		$this->db->where('driver_id', $driver_id);
        $sql = $this->db->get()->result_array();
         foreach($sql  as $key => $get)
				     {
						 $date=$get['approvel_date'];
						 if($date==null)
						 {
							 $new_date='';
						 }
						 else{
							 $new_date=$get['approvel_date'];
						 }
						 $sql[$key]['approvel_date']=$new_date;
					 }
					 
		             return $sql;
    }
	public function get_driver_transaction($driver_id)
    {
		$this->db->select('m.amount as amount ,m.approvel_date as date, t.name as trans_name ');
	    $this->db->from('dbo.milestone as m');
		$this->db->join('dbo.transporter as t', 't.user_id = m.transporter_id','left outer');
		$this->db->where('driver_id', $driver_id);
		$this->db->where('approvel_status','Approved');
        return $this->db->get()->result_array();
		
    }
	public function get_address_off_gps($order_id)
    {
		$this->db->select('*');
	    $this->db->from('dbo.location');
		$this->db->where('order_id', $order_id);
        return $this->db->get()->result_array();
		
    }
    public function get_reason_list()
    {
		$this->db->select('*');
	    $this->db->from('dbo.reject_reason');
        return $this->db->get()->result_array();
		
    }
	public function get_all_mobile($order_id)
    {
		$this->db->select('t.mobile as tmobile,dr.mobile as dmobile,c.mobile as cmobile');
		$this->db->from('dbo.sales_dispatched_order as sdo');
		$this->db->join('dbo.order_details as d', 'd.order_id = sdo.order_id','left outer');
		$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no','left outer');
		$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no','left outer');
		$this->db->join('dbo.driver as dr', 'dr.id = d.driver_id','left outer');
		$this->db->where('sdo.order_id', $order_id);
		return $this->db->get()->row();
		
    }
	
	public function driver_dashboard_data($driver_id)
    {
		$sql= $this->db->query("SELECT  (
        SELECT COUNT(sdo.order_id) AS count FROM sales_dispatched_order AS sdo INNER JOIN order_details AS od ON od.order_id=sdo.order_id INNER JOIN driver AS d 
	    ON d.id=od.driver_id WHERE sdo.status='Released' AND od.order_status='Inprocess' AND od.shipping_status!='Dispatched' AND shipping_status!='Completed' AND d.id = '$driver_id' AND sdo.cust_no LIKE 'c%'
        ) AS assign,
        (
        SELECT COUNT(sdo.order_id) AS count FROM posted_sales_dispatch_order AS sdo INNER JOIN order_details AS od ON od.order_id=sdo.order_id INNER JOIN driver AS d 
	    ON d.id=od.driver_id WHERE sdo.status='Released' AND od.shipping_status='Dispatched' AND d.id = '$driver_id' AND sdo.cust_no LIKE 'c%'
        ) AS dispatched,
		(
		SELECT wallet_amount FROM driver WHERE id='$driver_id'
        ) AS wallet_amount,
        (
		SELECT image FROM driver WHERE id='$driver_id'
        ) AS image,
		(
		SELECT SUM(CAST(amount AS int)) FROM milestone WHERE driver_id='$driver_id' and approvel_status='Approved'
        ) AS milestone")->result_array();
		
		foreach($sql as $key =>$value)
		{
			$milestone=$value['milestone'];
			$wallet_amount=$value['wallet_amount'];
			$image=$value['image'];
			if($image=='')
			{
                $sql[$key]['image']='';
			}
			else
			{
				$sql[$key]['image']= base_url('upload/users/').$image;
			}
			if($milestone==null)
			{
				$sql[$key]['milestone']=0;
			}
			if($wallet_amount==null)
			{
				$sql[$key]['wallet_amount']=0;
			}
			
		}
		return $sql;
		
    }
    public function transporter_dashboard_data($global_id)
    {

		$date = date('Y-m-d');
		$sql= $this->db->query("SELECT  (
        SELECT COUNT(d.id) AS count FROM dbo.driver AS d  WHERE d.global_id='$global_id'
        ) AS total_driver,
        
        (
        SELECT COUNT(v.id) AS count FROM dbo.vehicle AS v  WHERE v.global_id='$global_id'
        ) AS total_vehicle")->result_array();

        $planned = $this->db->query("SELECT sdo.order_id FROM sales_dispatched_order as sdo INNER JOIN transporter as t on t.user_id=sdo.trans_no where sdo.delivery_date ='".$date."' and t.global_id ='".$global_id."' and sdo.status='Released' and sdo.cust_no LIKE 'c%'
	     UNION 
        SELECT psdo.order_id FROM posted_sales_dispatch_order as psdo inner join order_details as d on d.order_id=psdo.order_id INNER JOIN transporter as t on t.user_id=psdo.trans_no where 
	    psdo.posting_date='".$date."' and psdo.cust_no LIKE 'c%' AND t.global_id ='".$global_id."'")->result_array();


	    $this->db->select('*');
		$this->db->from('dbo.order_details');
		$this->db->where('global_id',$global_id);
		$this->db->where('convert(DATE,gate_in_date)',$date);
		$arrived=$this->db->get()->result_array();

		$this->db->select('*');
		$this->db->from('dbo.order_details as d');
		$this->db->join('dbo.posted_sales_dispatch_order as psdo', 'd.order_id = psdo.order_id');
		$this->db->where('d.shipping_status','Dispatched');
		$this->db->where('d.global_id',$global_id);
		$this->db->where('psdo.posting_date',$date);
		$dispatched=$this->db->get()->result_array();

		$confirmed = $this->db->query("SELECT sdo.order_id FROM sales_dispatched_order as sdo left outer join order_details as d on sdo.order_id=d.order_id where sdo.delivery_date ='".$date."' and sdo.status='Released' and sdo.cust_no LIKE 'c%' and d.order_status!='Pending' and  d.global_id = '".$global_id."' UNION SELECT psdo.order_id FROM posted_sales_dispatch_order as psdo inner join order_details as d on d.order_id=psdo.order_id where psdo.posting_date='".$date."' and psdo.cust_no LIKE 'c%' and  d.global_id = '".$global_id."' and  d.order_status!='Pending' ")->result_array();
		

		$this->db->select('rating');
		$this->db->from('dbo.transporter');
		$this->db->where('global_id', $global_id);
		$query = $this->db->get()->row();
		foreach ($sql as $key => $value) {
			$sql[$key]['rating'] = $query->rating;
			$sql[$key]['dispatch_planned'] = count($planned);
			$sql[$key]['vehicle_status_before_slash'] = count($confirmed);
			$sql[$key]['vehicle_status_after_slash'] = count($planned)-count($confirmed);
			$sql[$key]['vehicle_arrived'] = count($arrived);
			$sql[$key]['vehicle_dispatched'] = count($dispatched);
		}
		return $sql;
		
    }
	public function submit_rating($order_id,$global_id)
    {
        $this->db->select('*');
		$this->db->from('dbo.trans_rating');
		$this->db->where('order_id', $order_id);
		$this->db->where('global_id', $global_id);
		$query = $this->db->get()->row();
		$accept=$query->accept_and_assign;
		$veh=$query->vehicle_condition;
		$track=$query->track_and_trace;
		$prating=$query->previous_rating;
		
		
		$t=($track*40)/100;
		$v=($veh*20)/100;
		$a=($accept*40)/100;
		$total=$t+$a+$v;
		$total_rating=($total+$prating)/2;
		
		$value=array(
		'rating' => $total_rating,
		);
		 $this->db->where('global_id',$global_id);
        $query = $this->db->update('dbo.transporter',$value); 
        $value1=array(
		'avg_rating' => $total,
		);
		$this->db->where('global_id',$global_id);
		$this->db->where('order_id',$order_id);
		$query = $this->db->update('dbo.trans_rating',$value1);
    }
    public function get_cust_company($global_id)
    {
	    $this->db->select('company,global_id');
		$this->db->from('dbo.customer');
		$this->db->where('global_id', $global_id);
		return $query = $this->db->get()->result_array();
	}
	public function get_cust_state_list($global_id,$company)
    {
	    $this->db->select('user_id,state_code');
		$this->db->from('dbo.customer');
		$this->db->where('global_id', $global_id);
		$this->db->where('company', $company);
		return $query = $this->db->get()->result_array();
	}
	public function get_address($user_id,$company)
	{
		
             $res = $this->update_webservice_data_model->get_address_webservice($user_id,$company);	                   
	         return $res;    
		       
	}
	public function get_product($user_id,$company)
	{

		     $res = $this->update_webservice_data_model->get_product_webservice($user_id,$company);	                   
	         return $res; 
		
	}
	public function save_order($company,$state,$address,$product,$porder_no,$base64code,$date,$qty,$ext)
	{
		
            $res = $this->update_webservice_data_model->save_order_webservice($company,$state,$address,$product,$porder_no,$base64code,$date,$qty,$ext);
            return $res; 
	}

	function bidnow($global_id,$order_id,$bid_amount,$unit,$user_id)
	{

		//$user_id = $data['id'];
		//echo $user_                    id;
		//$company = $data['company'];
		//echo $company;
		$this->db->select('name');
		$this->db->from('dbo.transporter');
		$this->db->where('global_id', $global_id);
		//$this->db->where('company', $company);
		$query = $this->db->get()->row();
		/* print_r($query); */
		//$date = date('Y-m-d',strtotime($data['pickup_date']));
		$value=array(
			'order_id' => $order_id,
			'global_id' => $global_id,
			'transporter_no' => $user_id,
			'transporter_name' => $query->name,
			//'transit_time' => $data['transit_time'],
			'bid_amount' => $bid_amount,		
			'unit' => $unit,	
			'edit_amount' => $bid_amount,	
			'edit_date' => date('Y-m-d H:i:s'),		
			//'comments' => $data['comments'],	
			//'fleet_type' => $data['fleet_type'],	
			//'pickup_date' => $date,	
		);
                   $this->db->select('MIN(bid_amount) as lowest_amount, unit');
                   $this->db->from('dbo.bidding_orders');
                   $this->db->where('order_id', $order_id);
                   $this->db->group_by('unit'); 
                   $min_bid_amount = $this->db->get()->row();
                   $min_amount=$min_bid_amount->lowest_amount;
		
        $this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order');
		$this->db->where('order_id', $order_id );
		$res = $this->db->get();
		$order = $res->row();
		$amount= $order->bidding_amount;

		$this->db->select('*');
		$this->db->from('dbo.bidding_orders as b');
		$this->db->where('b.order_id', $order_id);
		$res = $this->db->get();
		$exit = $res->row(); 
		if(!$exit)
		{
             if($amount >= $bid_amount)
             {
					$bid=array(
					'order_id' => $order_id,
					'global_id' => $global_id,
					'transporter_no' => $user_id,
					'transporter_name' => $query->name,
					'bid_amount' => $bid_amount,		
					'unit' => $unit,
					'edit_amount' => $bid_amount,	
			        'edit_date' => date('Y-m-d H:i:s'),				
					
				   );

				  	$sql = $this->db->insert('dbo.bidding_orders',$bid);
			 }
		  else
		  {
		  	return false;
		  }
		}
       else
       {
         if($min_amount >= $bid_amount )
         {
		$this->db->select('*');
		$this->db->from('dbo.bidding_orders');
		$this->db->where('global_id', $global_id );
		$this->db->where('order_id', $order_id );
		$q = $this->db->get();
		$q1 = $q->row();
		$a=array(); 
		if($q->num_rows > 0)
		{
			$edit_amount  = explode(',',$q1->edit_amount);
			$edit_date    = explode(',',$q1->edit_date);
			//print_r($edit_amount);
			$d=date('Y-m-d H:i:s');
			array_push($edit_amount, $bid_amount);
			array_push($edit_date, $d);
			$total_amount= implode(',',$edit_amount);
			$date= implode(',',$edit_date); 
			//print_r($total_amount);
			//$total_amount = $edit_amount.','.$data['bid_amount'];
            $total=array(
			'order_id' => $order_id,
			'global_id' => $global_id,
			'transporter_no' => $user_id,
			'transporter_name' => $query->name,
			'bid_amount' => $bid_amount,
			'edit_amount' => $total_amount,	
			'edit_date' => $date,		
			'unit' => $unit,			
		);
            //print_r($total);
           // die;
			$this->db->where('id',$q1->id);
			$sql = $this->db->update('dbo.bidding_orders',$total);
		}
		else
		{
			$sql = $this->db->insert('dbo.bidding_orders',$value);
		}
		
		
		if(!$sql)
		{
			print_r($this->db->error());
			die;
		}
	   }
	   else
	   {
	   	return false;
	   }
	}
		return $sql;
	}

	public function get_my_bid_list($global_id,$order_id)
    {
    	$array=array();
        $date=date('Y-m-d');
		 $this->db->select('DISTINCT (bid.order_id) as order_id,t.name as name,bid.created as created,bid.pickup_date as pickup_date,bid.fleet_type as fleet_type,bid.transit_time as transit_time,cast (bid.comments AS VARCHAR(max)) AS comments,bid.bid_amount as bid_amount,bid.unit as unit,bid.edit_amount,bid.edit_date,cast (sdo.quantity AS VARCHAR(max)) as quantity');
        $this->db->from('dbo.bidding_orders as bid');
        $this->db->join('dbo.transporter as t', 't.global_id = bid.global_id','left outer');
        $this->db->join('dbo.sales_dispatched_order as sdo', 'sdo.order_id = bid.order_id','left outer');
        $this->db->where('bid.order_id', $order_id);
        $this->db->where('bid.global_id', $global_id);
        // $this->db->order_by('bid.edit_amount', 'DESC');
         $this->db->order_by("bid.edit_amount",'DESC');
        $q3 = $this->db->get();
        $data = $q3->row();
       // print_r($data);
        //die;
        $edit_amount  = explode(',',$data->edit_amount); 
                                    $edit_date  = explode(',',$data->edit_date); 
                                    $count=count($edit_amount);
                                    $amount=$data->bid_amount;
                                     $quantity =    explode(',',$data->quantity);
                                    $qty= array_sum($quantity);
                                    for ($i = 0; $i < $count; $i++)
                                    {
                                       if($edit_amount[$i]!='')
                                       {
                                       	   $json['name;']   =   $data->name;
		                                   $json['bidding_date'] = date('d-m-Y',strtotime($edit_date[$i]));
		                                   $json['bidding_date'] = strtotime($edit_date[$i]);
		                                   $json['my_bid'] = $edit_amount[$i];
		                                   $json['total_amount'] = $edit_amount[$i]*$qty;
		                                   $json['unit'] = $data->unit;
		                                   $array[]=$json;
                                       }
                                   }
                                   return $array;
                                  
    }
		
}
?>