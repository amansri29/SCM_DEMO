<?php
class Model_admin extends CI_Model{
function __construct() {
parent::__construct();
$this->load->database();
$this->load->model('update_webservice_data_model');
date_default_timezone_set("Asia/Calcutta");
}
 public function get_today_dispatched_order()
    {
      
			$date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as status,sdo.delivery_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,sdo.planned_delivery_date as planned_delivery_date,sdo.ship_to_name as ship_to_name, sdo.status as sales_status ');
			$this->db->from('dbo.sales_dispatched_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			//$this->db->where('sdo.status', 'Released');
			$this->db->where('d.shipping_status!=', 'Pending');
		    $this->db->where('sdo.delivery_date', $date);
			$this->db->like('sdo.cust_no', 'c', 'after');
			return $this->db->get()->result_array();
		
    }
	public function get_today_posted_dispatched_order()
    {
      
			$date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as status,sdo.posting_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date,sdo.ship_to_name as ship_to_name ,sdo.status as sales_status ');
			$this->db->from('dbo.posted_sales_dispatch_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			
			
			$this->db->like('sdo.cust_no', 'c', 'after');
			//$this->db->where('sdo.posting_date', $date);
			$this->db->where('sdo.status', 'Released');
			$this->db->where("(d.shipping_status = 'Dispatched' OR d.order_status ='Completed') AND sdo.posting_date='".$date."' ");
			
			return $this->db->get()->result_array();
			//print_r($data); 
		
    }
	
	
	public function get_pending_dispatched_order()
    {
   
		    $date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as status,sdo.delivery_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,sdo.planned_delivery_date as planned_delivery_date,sdo.ship_to_name as ship_to_name, sdo.status as sales_status ');
			$this->db->from('dbo.sales_dispatched_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id');
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			//$this->db->where('sdo.status', 'Released');
			$this->db->like('sdo.cust_no', 'c', 'after');
			$this->db->where('d.shipping_status!=', 'Dispatched');
		    $this->db->where('d.order_status', 'Inprocess');
			return $this->db->get()->result_array();
		
    }
	
	public function get_not_accepted_orders()
    {
           $date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,t.name as trans_name,d.shipping_status as status,sdo.delivery_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,sdo.planned_delivery_date as planned_delivery_date,sdo.ship_to_name as ship_to_name,t.global_id as global_id , sdo.status as sales_status,d.order_created_status as ocs_status,cast (sdo.order_key AS VARCHAR(max)) as order_key,ar.reason as reason,t.company as company');
			$this->db->from('dbo.sales_dispatched_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			//$this->db->where('sdo.status', 'Released');
			$this->db->where('sdo.trans_no!=', '');
			$this->db->like('sdo.cust_no', 'c', 'after');
			
			return $this->db->get()->result_array();
		
    }
	public function get_attention_required_order()
    {
     
		$this->db->select('DISTINCT (ar.order_id) as order_id,c.name as cust_name,t.name as trans_name,sdo.delivery_date as delivery_date,c.name as cust_name,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,sdo.planned_delivery_date as planned_delivery_date,sdo.ship_to_name as ship_to_name,ar.reason as reason , sdo.status as sales_status,');
	    $this->db->from('dbo.attn_required  as ar'); 
		$this->db->join('dbo.sales_dispatched_order as sdo', 'sdo.order_id = ar.order_id');
		$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
		$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
		//$this->db->where('sdo.status', 'Released');
		$this->db->like('sdo.cust_no', 'c', 'after'); 
		//$this->db->group_by('sdo.order_id'); 
	    $this->db->order_by('sdo.delivery_date', "ASC");  
		return $this->db->get()->result_array();  
		
    }
	public function get_dispatched_orders()
    {
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as status,sdo.posting_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date,sdo.ship_to_name as ship_to_name , sdo.status as sales_status');
			$this->db->from('dbo.posted_sales_dispatch_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			//$this->db->where('sdo.status', 'Released');
			$this->db->where('d.shipping_status', 'Dispatched');
		    $this->db->or_where('d.shipping_status', 'Delivered');
			$this->db->like('sdo.cust_no', 'c', 'after');
			return $this->db->get()->result_array();
    }
	public function get_todays_vehicle_dispatched()
	{
		$date = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('dbo.order_details as d');
		$this->db->join('dbo.posted_sales_dispatch_order as psdo', 'd.order_id = psdo.order_id');
		$this->db->where('d.shipping_status','Dispatched');
		$this->db->where('psdo.posting_date',$date);
		return $this->db->get()->result_array();
	}
	public function get_todays_vehicle_arrived()
	{
		
		$date = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('dbo.order_details');
		$this->db->where('convert(DATE,gate_in_date)',$date);
		return $this->db->get()->result_array();
	}
	public function get_todays_dispatch_planned()
	{
		$date = date('Y-m-d');
		$query = $this->db->query("SELECT sdo.order_id FROM sales_dispatched_order as sdo inner join customer as c on sdo.cust_no=c.user_id where sdo.delivery_date ='".$date."' and sdo.status='Released' and sdo.cust_no LIKE 'c%' UNION SELECT psdo.order_id FROM posted_sales_dispatch_order as psdo inner join order_details as d on d.order_id=psdo.order_id where psdo.posting_date='".$date."' and psdo.cust_no LIKE 'c%'");
		return $query->result_array();
	}
	public function old_get_in()
	{
	 
	    $date = date('Y-m-d');
		/*
		$this->db->select('DISTINCT(sdo.order_id)');
		$this->db->from('dbo.sales_dispatched_order as sdo');
		$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id');
		$this->db->where('convert(DATE,d.gate_in_date) < ',$date);
		$this->db->where('d.shipping_status','Gate In');
		//$this->db->group_start();
			$this->db->or_where('d.shipping_status','Tare Weight (Weighbridge)');
			$this->db->or_where('d.shipping_status','Loading');
			$this->db->or_where('d.shipping_status','Loading Out');
			$this->db->or_where('d.shipping_status','Gross Weight (Weighbridge)');
		//$this->db->group_end();
		$Object = $this->db->get();
		$sql = $this->db->last_query(); 
		*/
		$SQL = "SELECT DISTINCT(sdo.order_id) FROM dbo.sales_dispatched_order as sdo,dbo.order_details as d
		 WHERE sdo.order_id = d.order_id AND 
		 ( convert(DATE,d.gate_in_date) < '".$date."' ) 
		 AND 
		 (
			d.shipping_status IN( 'Gate In','Tare Weight (Weighbridge)','Loading','Loading','Gross Weight (Weighbridge)')
		  )
		";
	 
		$Object = $this->db->query($SQL);
		return $Object->result_array();
		
	}
	public function attention()
	{
	  
	   $date = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order as sdo');
		$this->db->join("dbo.order_details as od", "od.order_id = sdo.order_id");
		$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id');
		$this->db->where('sdo.delivery_date', $date);
		//$this->db->where('sdo.status', 'Released');
		$this->db->like('sdo.cust_no', 'c', 'after');
		return $this->db->get()->result_array();
		
	}
	public function awating_for_arrival()
	{
	
		$date = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order as sdo');
		$this->db->join("dbo.order_details as od", "od.order_id = sdo.order_id");
		$this->db->where('sdo.delivery_date', $date);
		$this->db->where('sdo.status', 'Released');
		$this->db->like('sdo.cust_no', 'c', 'after');
		$this->db->where('od.shipping_status','Awaiting For Arrival');
		return $this->db->get()->result_array();
		
	}
	public function get_open_orders()
	{
		    $date=date('Y-m-d');
			/*$this->db->select('DISTINCT (sdo.order_id) as order_id,t.name as trans_name,d.shipping_status as status,sdo.delivery_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as custom_no,c.mobile as cust_mobile,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,sdo.planned_delivery_date as planned_delivery_date,sdo.ship_to_name as ship_to_name,t.global_id as global_id , sdo.status as sales_status,ar.reason as reason,sdo.company as company ,cast (sdo.order_key AS VARCHAR(max)) AS order_key');
			$this->db->from('dbo.sales_dispatched_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			//$this->db->where('sdo.status', 'Released');
			$this->db->where('sdo.trans_no', '');
			$this->db->like('sdo.cust_no', 'c', 'after');
			return $this->db->get()->result_array();*/
			
		  $this->db->select('sdo.*,c.name as cust_name');
		  $this->db->from('dbo.sales_dispatched_order as sdo');
		  $this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
		  $this->db->where('sdo.trans_no', '' );
		  $this->db->like('sdo.cust_no', 'c', 'after');
		  $this->db->where('sdo.status', 'Released' );								 
		  $query = $this->db->get();
		  return $query->result_array();
	}
	public function get_bid_applied_order()
	{
		    $date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,t.name as trans_name,bid.created as created,bid.pickup_date as pickup_date,bid.fleet_type as fleet_type,bid.transit_time as transit_time,cast (bid.comments AS VARCHAR(max)) AS comments,bid.bid_amount as amount,ar.reason as reason');
			$this->db->from('dbo.sales_dispatched_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 'sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			$this->db->join('dbo.bidding_orders as bid', 'bid.order_id = sdo.order_id and t.global_id = bid.global_id');
			//$this->db->where('sdo.status', 'Released');
			//$this->db->where('sdo.trans_no', '');
			$this->db->like('sdo.cust_no', 'c', 'after');
			return $this->db->get()->result_array();
	}
	
	public function get_inventory()
    {
               $res = $this->update_webservice_data_model->get_inventory_webservice();
               return $res;
             
					
						
    }
	public function get_dispatches()
    {
      
		    $res = $this->update_webservice_data_model->get_dispatches_webservice();
               return $res;                	
		
    }
	public function get_customers()
    {
      
		$this->db->select('*');
	    $this->db->from('dbo.customer');
		return $this->db->get()->result_array(); 
		
    }
	public function get_transporter()
    {
    
		$this->db->select('*');
	    $this->db->from('dbo.transporter');
		return $this->db->get()->result_array(); 
		
    }
	public function get_driver()
    {
    
		$this->db->select('DISTINCT (d.user_id) as user_id,d.name as dname,d.mobile as dmobile ,d.user_id as driver_id, d.id as id, t.name as tname,d.license_no as license_no,d.valid_upto as valid_upto,d.transporter_id as transporter_id,d.global_id as global_id');
	    $this->db->from('dbo.driver as d');
		//$this->db->join('dbo.transporter as t', 't.user_id = d.transporter_id and ','left outer');
		$this->db->join('dbo.transporter as t', 't.user_id = d.transporter_id and t.global_id = d.global_id','left outer');
		return $this->db->get()->result_array(); 
		
    }
	public function get_vehicle()
    {
    
		$this->db->select('DISTINCT (v.id) as id, v.registration_no as registration_no,v.valid_upto as valid_upto,v.vehicle_type as vehicle_type,v.capacity as capacity,v.global_id as global_id,v.owner_name as owner_name,t.name as name');
	    $this->db->from('dbo.vehicle as v');
		$this->db->join('dbo.transporter as t', 't.user_id = v.transporter_id and t.global_id = v.global_id','left outer');
		return $this->db->get()->result_array(); 
		
    }
	public function get_admin()
    {
    
		$this->db->select('*');
	    $this->db->from('dbo.admin');
		return $this->db->get()->result_array(); 
		
    }
	public function get_scanner_users()
    {
    
		$this->db->select('*');
	    $this->db->from('dbo.scanner_login');
		return $this->db->get()->result_array(); 
		
    }
	public function get_reject_reason()
    {
    
		$this->db->select('*');
	    $this->db->from('dbo.reject_reason');
		return $this->db->get()->result_array(); 
		
    }
	public function tolerance($data)
    {
		
		$value=array(
				'tolerance' => $data['tolerance'],
			 );
			$this->db->where('id',$data['id']);
			return $query = $this->db->update('dbo.settings',$value);
		
    }
	function allowance_settings($data)
	{
		
		
		/***********attn require check************/
		
		$this->db->select('*');
		$this->db->from('dbo.attn_required');
		$this->db->where('reason', 'Not accepted in given time frame by vendor');
		$res= $this->db->get()->result_array();
		$allowance_hours = $data['allowance_hours'];
		$assign_hours = $data['assign_hours'];
		$time = "00:00:00";
		foreach($res as $val)
		{
			$delivery_date=$val['delivery_date'];
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
					
			$today_date=date('Y-m-d H:i:s');
			/* print($newdate);
			print($today_date);die; */
			if(strtotime($today_date) > strtotime($newdate))
			{
				
			}
			else
			{
				$this->db->where('order_id', $val['order_id']);
		        $this->db->delete('dbo.attn_required');
				
			}
		}
		$this->db->select('*');
		$this->db->from('dbo.attn_required');
		$this->db->where('reason', 'No Bidding placed');
		$result= $this->db->get()->result_array();
		$bidding_hours = $data['bidding_hours'];
		$time = "00:00:00";
		foreach($result as $val)
		{
			$delivery_date=$val['delivery_date'];
			$acutal_date1 = $delivery_date." ".$time;
			
			if($bidding_hours<0)
			{
				$hours1=(-$bidding_hours);
				$bidding_hours_newdate = date("Y-m-d H:i:s", strtotime('+'.$hours1.' hours', strtotime($acutal_date1)));
			
			}
			else{			
				/* echo $acutal_date;  */
				$newdate1 = strtotime ( '-'.$bidding_hours.' hour' , strtotime ($acutal_date1 ) ) ;
				$bidding_hours_newdate = date ( 'Y-m-d H:i:s' , $newdate1 );
			}
					
			$today_date=date('Y-m-d H:i:s');
			/* print($newdate);
			print($today_date);die; */
			if(strtotime($today_date) > strtotime($bidding_hours_newdate))
			{
				
			}
			else
			{
				$this->db->where('order_id', $val['order_id']);
		        $this->db->delete('dbo.attn_required');
				
			}
			
			
		}
		
		$this->db->select('*');
		$this->db->from('dbo.attn_required as ar');
		$this->db->join('dbo.order_details as d', 'd.order_id = ar.order_id');
		$this->db->where('ar.reason', 'Not assigned in given time frame by vendor');
		$res1= $this->db->get()->result_array();
		$assign_hours = $data['assign_hours'];
		$assign_bidding_hours = $data['assign_bidding_hours'];
		$assign_bidding_hours_second = $data['assign_bidding_hours_second'];
		$time = "00:00:00";
		foreach($res1 as $val)
		{
			$delivery_date=$val['delivery_date'];
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
			if($assign_bidding_hours<0)
			{
				$hours=(-$assign_bidding_hours);
				$bid_time = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
			
			}
			else{			
				/* echo $acutal_date;  */
				$newdate1 = strtotime ( '-'.$assign_bidding_hours.' hour' , strtotime ($acutal_date ) ) ;
				$bid_time = date ( 'Y-m-d H:i:s' , $newdate1 );
			}
			if($assign_bidding_hours_second<0)
			{
				$hours=(-$assign_bidding_hours_second);
				$bid_time_second = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
			
			}
			else{			
				/* echo $acutal_date;  */
				$newdate2 = strtotime ( '-'.$assign_bidding_hours_second.' hour' , strtotime ($acutal_date ) ) ;
				$bid_time_second = date ( 'Y-m-d H:i:s' , $newdate2 );
			}
					
			$today_date=date('Y-m-d H:i:s');
			/* print($newdate);
			print($today_date);die; */
			if(strtotime($today_date) > strtotime($newdate) && $val['order_created_status']=='Admin')
			{
				$this->db->where('order_id', $val['order_id']);
		        $this->db->delete('dbo.order_details');
			}
			else
			{
				$this->db->where('order_id', $val['order_id']);
		        $this->db->delete('dbo.attn_required');
				/* $this->db->where('order_id', $val['order_id']);
		        $this->db->delete('dbo.order_details'); */
				
			}
			if(strtotime($today_date) > strtotime($bid_time) && $val['order_created_status']=='Bid')
			{
				/* $this->db->where('order_id', $val['order_id']);
		        $this->db->delete('dbo.order_details'); */
			}
			else{
				$this->db->where('order_id', $val['order_id']);
		        $this->db->delete('dbo.attn_required');
			}
			if(strtotime($today_date) > strtotime($bid_time_second) && $val['order_created_status']=='Bid')
			{
				/*$this->db->where('order_id', $val['order_id']);
		        $this->db->delete('dbo.order_details');*/
			}
			else
			{  
				$this->db->where('order_id', $val['order_id']);
		        $this->db->delete('dbo.attn_required');
				/* $this->db->where('order_id', $val['order_id']);
		        $this->db->delete('dbo.order_details'); */
				
			}
		
		}
		
		
		$this->db->select('*');
		$this->db->from('dbo.settings');
		$sql = $this->db->get();
		$query = $sql->result_array();
		if($sql->num_rows() > 0)
		{
			$value=array(
				'allowance_hours' => $data['allowance_hours'],
				'assign_hours' => $data['assign_hours'],
				'bidding_hours' => $data['bidding_hours'],
				'assign_bidding_hours' => $data['assign_bidding_hours'],
				'assign_bidding_hours_second' => $data['assign_bidding_hours_second'],
			 );
			$this->db->where('id',$data['id']);
			$query = $this->db->update('dbo.settings',$value);
		}
		else
		{
			$value=array(
				'allowance_hours' => $data['allowance_hours'],
				'benefit_type' => '',
				'benfit' => '',
				'appreciation_rate' => '',
				'assign_hours' => $data['assign_hours'],
				'bidding_hours' => $data['bidding_hours'],
				'assign_bidding_hours' => $data['assign_bidding_hours'],
				'assign_bidding_hours_second' => $data['assign_bidding_hours_second'],
				
			 );
			$query = $this->db->insert('dbo.settings',$value);
		}
	
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function update_order_details($data)
	{
		//print_r($data); die;
		$order_id = $data['order_id'];
       $this->db->select('*');
	        $this->db->from('dbo.sales_dispatched_order');
								   
	   $this->db->where('order_id',$data['order_id']);
			$data1= $this->db->get()->result_array(); 
			//print_r($data);
			foreach($data1 as $get1)
			{
				$key=$get1['order_key'];
			}
		$delivery_date = date("Y-m-d", strtotime($data['delivery_date']));
		$transporter_id = $data['transporter_id'];
		
		$this->db->select('*');
		$this->db->from('dbo.attn_required');
		$this->db->where('order_id',$order_id);
		$sql = $this->db->get();
		$query = $sql->row();
		
		if($query->transporter_no != $transporter_id)
		{
				
				 $res = $this->update_webservice_data_model->update_order_details_update_webservice($data);	                   
			     return $res;

			
		}
		else if($query->delivery_date != $delivery_date)
		{
			
			    $res = $this->update_webservice_data_model->update_order_details_update_webservice($data);	                      
		        return $res;
	    }
	}
	
	/************** Driver ****************/
	function driver_details($data)
	{
		$user_id = 'DRI'.rand(1000, 9999);
		$id = $this->session->userdata('user_id');
		/* print($user_id);die; */
		$value=array(
			 'user_id' =>$user_id,
			 'name' =>$data['name'] ,
			 'mobile' =>$data['mobile'],
			 'license_no' =>$data['license_no'],
			 'valid_upto' =>$data['valid_upto'],
			 'password' => '123456',
			 'email' => '',
			 'address' => '',
			 'image' => '',
			 'device_token' => '',
			 'device_type' => '',
			'wallet_amount' => '',
			'transporter_id' => $data['transporter_id'],
			'user_role' => 'driver',
   
		);
		/* print_r($value);
		die; */
		$query = $this->db->insert('dbo.driver',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function updateDriver($data)
	{
		
		$id = $data['id'];
		/* print($user_id);die; */
		$value=array(
			 'name' =>$data['name'] ,
			 'mobile' =>$data['mobile'],
			 'license_no' =>$data['license_no'],
			 'valid_upto' =>$data['valid_upto'],
			 'transporter_id' =>$data['transporter_id'],
			 
   
		);
		/* print_r($value);
		die; */
		$this->db->where('id',$id);
		$query = $this->db->update('dbo.driver',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function deleteDriver($data){
	
		$id = $data['id'];
		$this->db->where('id', $id);
		if($this->db->delete('dbo.driver'))
	    {
			echo 1;
        }
        else{
			echo 0;
        }
	}
	function scanner_user_delete($data){
	
		$id = $data['id'];
		$this->db->where('id', $id);
		if($this->db->delete('dbo.scanner_login'))
	    {
			echo 1;
        }
        else{
			echo 0;
        }
	}
	/************** Vehicle ****************/
	function vehicle_details($data)
	{
		
		$value=array(
			'registration_no' => $data['registration_no'],
			'valid_upto' => $data['valid_upto'],
			'vehicle_type' => $data['vehicle_type'],  
			'owner_name' => $data['owner_name'],
			'owner_contact' => $data['owner_contact'],
			'capacity' => $data['capacity'],
			'unit' => $data['unit'],
			'transporter_id' => $data['transporter_id'],
			'insurance' => $data['insurance'],
   
   
		);
		/* print_r($value);
		die; */
		$query = $this->db->insert('dbo.vehicle',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function updateVehicle($data)
	{
		
		
		$value=array(
			'registration_no' => $data['registration_no'],
			'valid_upto' => $data['valid_upto'],
			'vehicle_type' => $data['vehicle_type'],  
			'owner_name' => $data['owner_name'],
			'owner_contact' => $data['owner_contact'],
			'capacity' => $data['capacity'],
			'unit' => $data['unit'],
			'insurance' => $data['insurance'],
			'transporter_id' => $data['transporter_id'],
			
		);
		/* print_r($value);
		die; */
		$this->db->where('id',$id);
		$query = $this->db->update('dbo.vehicle',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function deleteVehicle($data){
	
		$id = $data['id'];
		$this->db->where('id', $id);
		if($this->db->delete('dbo.vehicle'))
	    {
			echo 1;
        }
        else{
			echo 0;
        }
	}
	/************** Admin ****************/
	function admin_details($data,$user_id)
	{
		
		$id = $this->session->userdata('user_id');
		/* print($user_id);die; */
		$management = implode(',', $data['management']);
		$value=array(
			 'user_id' =>$user_id,
			 'user_role' =>'admin',
			 'name' =>$data['name'] ,
			 'mobile' =>$data['mobile'],
			 'email' =>$data['email'],
			 'password' => $data['password'],
			 'address' => $data['address'],
			 'image' => $data['image'],
			 'access_role' => $management,
			 
		);
		/* print_r($value);
		die; */
		$query = $this->db->insert('dbo.admin',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function scanner_details($data)
	{
	    $type=implode(',',$data['user_type']);
		$value=array(
		
		     'name' =>$data['name'] ,
			 'mobile' =>$data['mobile'],
			 'email' =>$data['email'],
			 'user_type' =>$type,
			 'password' =>'',
			 'address' =>'',
			 'image' =>'',
		);
		 $query = $this->db->insert('dbo.scanner_login',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function update_scanner_user($data)
	{
	$id = $data['id'];
	 $type=implode(',',$data['user_type']);
		$value=array(
		
		     'name' =>$data['name'] ,
			 'mobile' =>$data['mobile'],
			 'email' =>$data['email'],
			 'email' =>$data['email'],
			 'user_type' =>$type,
			 'password' =>'',
			 'address' =>'',
			 'image' =>'',
		);
		$this->db->where('id',$id);
		$query = $this->db->update('dbo.scanner_login',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function deleteAdmin($data){
	
		$id = $data['id'];
		$this->db->where('id', $id);
		if($this->db->delete('dbo.admin'))
	    {
			echo 1;
        }
        else{
			echo 0;
        }
	}
	function updateAdmin($data)
	{
		//print_r($data); die;
		$password = $data['password'];
		$img = $data['image'];
		$management = implode(',', $data['management']);
		if((!empty($img)) && (!empty($password)))
		{
			$value=array(
				'name' =>$data['name'] ,
				'mobile' =>$data['mobile'],
				'email' =>$data['email'],
				'password' =>$password,
				'address' => $data['address'],
				'image' => $img, 
				'access_role' => $management,
			 
			);
		}
		else if((!empty($img)) && (empty($password)))
		{	
			
			$value=array(
				'name' =>$data['name'] ,
				'mobile' =>$data['mobile'],
				'email' =>$data['email'],
				'address' => $data['address'],
				'image' => $img,
				'access_role' => $management,
			 
			);
			 
		}
		else if ((empty($img)) && (!empty($password)))
		{
			
			$value=array(
				'name' =>$data['name'] ,
				'mobile' =>$data['mobile'],
				'email' =>$data['email'],
				'password' =>$password,
				'address' => $data['address'],
				'access_role' => $management,			 
			);
		}
		else
		{
			
			$value=array(
				'name' =>$data['name'] ,
				'mobile' =>$data['mobile'],
				'email' =>$data['email'],
				'address' => $data['address'],
				'access_role' => $management,			 
			);
		}
		/* print_r($value);die; */
		$this->db->where('id',$data['id']);
		$query = $this->db->update('dbo.admin',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function change_password($data)
	{
	 $id = $this->session->userdata('user_id');
		$value=array(
		
		     'password' => $data['new_password'] ,
			
		);
		$this->db->where('user_id',$id);
		$query = $this->db->update('dbo.admin',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	public function get_driver_wallet()
	{
		$this->db->select('DISTINCT (d.user_id) as duser_id, t.name as tname,d.name as dname,d.mobile as dmobile,d.user_id as duser_id,d.wallet_amount as wallet_amount');
		$this->db->from('dbo.driver as d');
		$this->db->join('dbo.transporter as t', 't.user_id = d.transporter_id and d.global_id=t.global_id');
		return $this->db->get()->result_array();	 
	}
	public function get_milestone()
	{
		$this->db->select('DISTINCT (m.order_id) as order_id,d.name as dname,t.name as tname,m.pickup_address as pickup_address,m.distance as distance,m.estimated_time as estimated_time,m.total_time_taken as total_time_taken,m.amount as amount');
		$this->db->from('dbo.milestone as m');
		$this->db->join('dbo.transporter as t', 't.user_id = m.transporter_id and t.global_id = m.global_id','left outer');
		$this->db->join('dbo.driver as d', 'd.id = m.driver_id');
		$this->db->where('m.approvel_status', 'Not Approved');
		$this->db->where('m.status', 'Achived');
		return $this->db->get()->result_array();	 
	}
	function add_time_and_rate($data)
	{
	$id = $data['id'];
		$value=array(
		
		     'benefit_type' =>$data['type'] ,
			 'benfit' =>$data['time'],
			 'appreciation_rate' => $data['rate'],
			 'per_day_travel_km' => $data['per_day_km'],
			 'track_and_trace_hours' => $data['track_trace_hour'],
		
		);
		$this->db->where('id',$id);
		$query = $this->db->update('dbo.settings',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	public function get_approvel_orders()
    {
       
        $date=date('Y-m-d');
		$this->db->select('DISTINCT (d.order_id)as order_id,t.name as tname ,dr.name as dname,d.driver_id as did,ocd.driver_id as ocd_driver_id,d.vehicle_id as dveh_id,ocd.vehicle_id as ocdveh_id,sdo.delivery_date as del_id ,ocd.delivery_date as ocd_del_date,ocd.id as ocd_id,v.registration_no as registration_no,ocd.delivery_date as delivery_date ,cast (ocd.change_reason as VARCHAR(MAX)) as change_reason');
	    $this->db->from('dbo.order_details as d');
		$this->db->join('dbo.orders_change_details as ocd','d.order_id = ocd.order_id ');
		$this->db->join('dbo.sales_dispatched_order as sdo','d.order_id = sdo.order_id ' , 'LEFT OUTER');
		$this->db->join('dbo.transporter as t', 't.user_id = ocd.trans_no and t.global_id=ocd.global_id','left outer');
		$this->db->join('dbo.driver as dr', 'dr.id = ocd.driver_id' ,'left outer');
		$this->db->join('dbo.vehicle as v', 'v.id = ocd.vehicle_id' ,'left outer');
		$this->db->where('d.shipping_status', 'Not Approved');
		return $this->db->get()->result_array(); 
		
    }
	function reject_order($data)
	{
	     $id = $data['order_id'];
	     $reject_id = $data['reject_id'];
		// print_r($id); die;
		$value=array(
		
		     'shipping_status' => 'Awaiting For Arrival' ,
			
		
		);
		$this->db->where('order_id',$id);
		$query = $this->db->update('dbo.order_details',$value);
		$this->db->where('id',$reject_id);
		$query1 = $this->db->delete('dbo.orders_change_details');
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function accept_order($data)
	{
		$res = $this->update_webservice_data_model->accept_order_update_webservice($data);	                   
	    return $res;
	}
	function cancel_order($data)
	{ 
								  
									  ////11111//////
														/*	$curl = curl_init();
															$username = 'scm';
                                                            $password = 'scm@3112';
															  curl_setopt_array($curl, array(
															  CURLOPT_PORT => "1132",
															  CURLOPT_URL => "http://myerp.golchagroup.com:1132/DummyGST/WS/UMDS%20Pvt.Ltd./Page/DispatchOrders",
															  CURLOPT_USERPWD => $username.':'.$password,
															  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
															  CURLOPT_RETURNTRANSFER => true,
															  CURLOPT_ENCODING => "",
															  CURLOPT_MAXREDIRS => 10,
															  CURLOPT_TIMEOUT => 30,
															  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
															  CURLOPT_CUSTOMREQUEST => "POST",
															 CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Delete xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <Key>".$key."</Key>\n        </Delete>\n    </Body>\n</Envelope>",
															  CURLOPT_HTTPHEADER => array(
																"cache-control: no-cache",
																"content-type: text/xml",
																"postman-token: 72339cd3-dea6-eb7c-5399-f253e5d3164e",
																"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Delete"
															  ),
															));

															$response = curl_exec($curl);
															$err = curl_error($curl);

															curl_close($curl);

															if ($err) {
															//  echo "cURL Error #:" . $err; 
															} else {
															//  echo $response; 
															}
															////22///////////////////////
															$curl = curl_init();
															$username = 'scm';
                                                            $password = 'scm@3112';
															  curl_setopt_array($curl, array(
															  CURLOPT_PORT => "1132",
															  CURLOPT_URL => "http://myerp.golchagroup.com:1132/DummyGST/WS/S.ZORASTER%20%26%20COMPANY/Page/DispatchOrders",
															  CURLOPT_USERPWD => $username.':'.$password,
															  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
															  CURLOPT_RETURNTRANSFER => true,
															  CURLOPT_ENCODING => "",
															  CURLOPT_MAXREDIRS => 10,
															  CURLOPT_TIMEOUT => 30,
															  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
															  CURLOPT_CUSTOMREQUEST => "POST",
															   CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Delete xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <Key>".$key."</Key>\n        </Delete>\n    </Body>\n</Envelope>",
															  CURLOPT_HTTPHEADER => array(
																"cache-control: no-cache",
																"content-type: text/xml",
																"postman-token: 72339cd3-dea6-eb7c-5399-f253e5d3164e",
																"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Delete"
															  ),
															));

															$response = curl_exec($curl);
															$err = curl_error($curl);

															curl_close($curl);

															if ($err) {
															//  echo "cURL Error #:" . $err; 
															} else {
															//  echo $response; 
															}
															////333///////////////////////
															$curl = curl_init();
															$username = 'scm';
                                                            $password = 'scm@3112';
															  curl_setopt_array($curl, array(
															  CURLOPT_PORT => "1132",
															  CURLOPT_URL => "http://myerp.golchagroup.com:1132/DummyGST/WS/Jaipur%20Mineral%20Development%20Syn/Page/DispatchOrders",
															  CURLOPT_USERPWD => $username.':'.$password,
															  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
															  CURLOPT_RETURNTRANSFER => true,
															  CURLOPT_ENCODING => "",
															  CURLOPT_MAXREDIRS => 10,
															  CURLOPT_TIMEOUT => 30,
															  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
															  CURLOPT_CUSTOMREQUEST => "POST",
															   CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Delete xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <Key>".$key."</Key>\n        </Delete>\n    </Body>\n</Envelope>",
															  CURLOPT_HTTPHEADER => array(
																"cache-control: no-cache",
																"content-type: text/xml",
																"postman-token: 72339cd3-dea6-eb7c-5399-f253e5d3164e",
																"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Delete"
															  ),
															));

															$response = curl_exec($curl);
															$err = curl_error($curl);

															curl_close($curl);

															if ($err) {
															//  echo "cURL Error #:" . $err; 
															} else {
															//  echo $response; 
															}
															////44///////////////////////
															$curl = curl_init();
															$username = 'scm';
                                                            $password = 'scm@3112';
															  curl_setopt_array($curl, array(
															  CURLOPT_PORT => "1132",
															  CURLOPT_URL => "http://myerp.golchagroup.com:1132/DummyGST/WS/Golcha%20Talc/Page/DispatchOrders",
															  CURLOPT_USERPWD => $username.':'.$password,
															  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
															  CURLOPT_RETURNTRANSFER => true,
															  CURLOPT_ENCODING => "",
															  CURLOPT_MAXREDIRS => 10,
															  CURLOPT_TIMEOUT => 30,
															  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
															  CURLOPT_CUSTOMREQUEST => "POST",
															   CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Delete xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <Key>".$key."</Key>\n        </Delete>\n    </Body>\n</Envelope>",
															  CURLOPT_HTTPHEADER => array(
																"cache-control: no-cache",
																"content-type: text/xml",
																"postman-token: 72339cd3-dea6-eb7c-5399-f253e5d3164e",
																"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Delete"
															  ),
															));

															$response = curl_exec($curl);
															$err = curl_error($curl);

															curl_close($curl);

															if ($err) {
															//  echo "cURL Error #:" . $err; 
															} else {
															//  echo $response; 
															}
															////555///////////////////////
															$curl = curl_init();
															$username = 'scm';
                                                            $password = 'scm@3112';
															  curl_setopt_array($curl, array(
															  CURLOPT_PORT => "1132",
															  CURLOPT_URL => "http://myerp.golchagroup.com:1132/DummyGST/WS/Golcha%20Minerals%20%28I%29%20Pvt.Ltd./Page/DispatchOrders",
															  CURLOPT_USERPWD => $username.':'.$password,
															  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
															  CURLOPT_RETURNTRANSFER => true,
															  CURLOPT_ENCODING => "",
															  CURLOPT_MAXREDIRS => 10,
															  CURLOPT_TIMEOUT => 30,
															  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
															  CURLOPT_CUSTOMREQUEST => "POST",
															   CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Delete xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <Key>".$key."</Key>\n        </Delete>\n    </Body>\n</Envelope>",
															  CURLOPT_HTTPHEADER => array(
																"cache-control: no-cache",
																"content-type: text/xml",
																"postman-token: 72339cd3-dea6-eb7c-5399-f253e5d3164e",
																"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Delete"
															  ),
															));

															$response = curl_exec($curl);
															$err = curl_error($curl);

															curl_close($curl);

															if ($err) {
															//  echo "cURL Error #:" . $err; 
															} else {
															//  echo $response; 
															}*/
								  $id = $data['cancel_order_id'];
								  $this->db->select('*');
	                              $this->db->from('dbo.sales_dispatched_order as sdo');
			                      $this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			                      $this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
								  $this->db->where('order_id',$id);
										$data1= $this->db->get()->result_array(); 
										//print_r($data);
										foreach($data1 as $get1)
										{
											$key=$get1['order_key'];
											$cust_no=$get1['cust_no'];
											$trans_no=$get1['trans_no'];
											$global_id=$get1['global_id'];
											$delivery_date=$get1['delivery_date'];
										}
															$response=true;
															if($response)
															{
																	$this->db->where('order_id',$id);
																	$query = $this->db->delete('dbo.order_details');
																	$this->db->where('order_id',$id);
																	$query1 = $this->db->delete('dbo.orders_change_details');
																		
																		
																		$update=array(
																		'order_id' => $id,
																		'global_id' => $global_id,
																		'customer_no' => $cust_no,
																		'transporter_no' => $trans_no,
																		'reason' => 'Rejected And Canceled By Admin',
																		'delivery_date' => $delivery_date,
								
																	); 
																	$this->db->where('order_id',$id);
																	$res = $this->db->update('dbo.attn_required',$update);
																	if(! $query)
																	{
																		print_r($this->db->error());
																		die;
																	}
																	else{
																	return $res;
																	}
															}
															else{
																return false;
															}
																	
	 
	}
	public function cancel_orders()
	{
		$this->db->select('DISTINCT(od.order_id) as order_id,  d.name as dname,t.name as tname,');
		$this->db->from('dbo.order_details as od');
		$this->db->join('dbo.transporter as t', 't.user_id = od.trans_no and t.global_id= od.global_id');
		$this->db->join('dbo.driver as d', 'd.id = od.driver_id');
		$this->db->where('od.shipping_status', 'Canceled');
		return $this->db->get()->result_array();	 
	}
	public function trans_cancel_approvel()
	{
		$this->db->select('DISTINCT(od.order_id) as order_id,v.registration_no as registration_no,cast(od.change_reason as VARCHAR(MAX)) as change_reason,d.name as dname,t.name as tname,od.id as cid,t.global_id as global_id,od.delivery_date as delivery_date,t.company as company,t.state_code ');
		$this->db->from('dbo.orders_change_details as od');
		$this->db->join('dbo.sales_dispatched_order as sdo', 'od.order_id = sdo.order_id','left outer');
		$this->db->join('dbo.transporter as t', 't.user_id = od.trans_no and t.global_id = od.global_id and sdo.company=t.company','left outer');
		$this->db->join('dbo.driver as d', 'd.id = od.driver_id','left outer');
		$this->db->join('dbo.vehicle as v', 'v.id = od.vehicle_id','left outer');
		$this->db->where('od.status', 'Canceled'); 
		return $this->db->get()->result_array();	 
	}
	function cancel_reject_order($data)
	{
		$order_id=$data['order_id'];
		$reject_id=$data['reject_id'];
		

        $this->db->select('*');
		$this->db->from('dbo.orders_change_details');
		$this->db->where('order_id', $order_id);
		$query = $this->db->get()->result_array();
		foreach($query as $get)
		{
			$status=$get['previous_order_status'];
		}
		$value=array(
			 'shipping_status' => $status,
		);
		
		$this->db->where('order_id',$order_id);
		$query = $this->db->update('dbo.order_details',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		$this->db->where('id',$reject_id);
		$query1 = $this->db->delete('dbo.orders_change_details');
		return $query; 
	}
	function cancel_accept_order($data)
	{
		$res = $this->update_webservice_data_model->cancel_accept_order_update_webservice($data);	                   
	    return $res;
	}
	
	public function get_missed_order()
    { 
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,mo.delivery_date as delivery_date,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route ,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date,mo.reason as reason,sdo.ship_to_name as ship_to_name, sdo.status as sales_status');
			 $this->db->from('dbo.missed_orders as mo');
	     	$this->db->join('dbo.sales_dispatched_order as sdo', 'sdo.order_id = mo.order_id','left outer');
			$this->db->join('dbo.transporter as t', 't.user_id = mo.transporter_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = mo.customer_no and sdo.company =c.company','left outer');
			//$this->db->where('sdo.status', 'Released');
			return $query = $this->db->get()->result_array();
    }
	public function get_missed_order_post()
    {
		$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,mo.delivery_date as delivery_date,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route ,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date,mo.reason as reason,sdo.ship_to_name as ship_to_name');
			$this->db->from('dbo.missed_orders as mo');
	     	$this->db->join('dbo.posted_sales_dispatch_order as sdo', 'sdo.order_id = mo.order_id','left outer');
			$this->db->join('dbo.transporter as t', 't.user_id = mo.transporter_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = mo.customer_no and sdo.company =c.company','left outer');
			$this->db->where('sdo.status', 'Released');
			return $query = $this->db->get()->result_array();
    }
	public function get_rating($global_id)
    { 
			$this->db->select('DISTINCT (r.order_id) as order_id,r.global_id,t.rating,r.avg_rating,t.name,r.accept_and_assign,r.vehicle_condition,,r.track_and_trace,r.customer,od.shipping_status,t.rating,sdo.delivery_date');
			$this->db->from('dbo.trans_rating as r');
			$this->db->join('dbo.transporter as t', 't.global_id = r.global_id');
			$this->db->join('dbo.order_details as od', 'od.order_id = r.order_id');
			$this->db->join('dbo.sales_dispatched_order as sdo', 'sdo.order_id = r.order_id');
	        $this->db->where('r.global_id',$global_id);			
			//$this->db->order_by("r.id", "DESC");
			$query = $this->db->get()->result_array();
			
				
			$this->db->select('DISTINCT (r.order_id) as order_id,r.global_id,t.rating,r.avg_rating,t.name,r.accept_and_assign,r.vehicle_condition,,r.track_and_trace,r.customer,od.shipping_status,t.rating,sdo.posting_date as delivery_date');
			$this->db->from('dbo.trans_rating as r');
			$this->db->join('dbo.transporter as t', 't.global_id = r.global_id');
			$this->db->join('dbo.order_details as od', 'od.order_id = r.order_id');
			$this->db->join('dbo.posted_sales_dispatch_order as sdo', 'sdo.order_id = r.order_id');
			$this->db->where('r.global_id',$global_id);			
			$sql= $this->db->get()->result_array();
			
$query3 = array();			
				
			/*
			$SQL = "SELECT order_id, global_id, 0, 0,'unkhown',0,0, 0, 0, 'missed', 0,  delivery_date
					FROM dbo.missed_orders where global_id =  '".$global_id."'";
			*/
            /*
    		   $SQL = "SELECT order_id, 			global_id,'rating','avg_rating','name','accept_and_assign','vehicle_condition','no','track_and_trace','customer',
				'shipping_status','rating','delivery_date'
					FROM dbo.missed_orders where global_id =  '".$global_id."'";			
				$GetDataSql = $this->db->query($SQL);
				$query3 = $GetDataSql->result_array();	
				 
			*/ 

			 
			 $abc=array_merge($query,$sql,$query3 ); 
				 
				return $abc;
			
    }
	public function get_tans_rating($global_id)
    {
		    $this->db->select('t.rating,name');
			$this->db->from('dbo.transporter as t');
	        $this->db->where('t.global_id',$global_id);			
			return $query = $this->db->get()->row();
    }
    public function get_notifications()
    {
		    $this->db->select('*');
			$this->db->from('dbo.notification');
	        $this->db->where("receiver_id like '%Admin%'");	
	        $this->db->order_by("created","desc");
			return $query = $this->db->get()->result_array();
    }
	
	
}
?>