<?php
class Model_transporter extends CI_Model{
function __construct() {
parent::__construct();
//$this->load->model('Send_notification', 'notification');
$this->load->model('notification_save');
$this->load->model('sms_save');
$this->load->model('email_save');
$this->load->model('sms');
$this->load->model('send_email');
$this->load->model('update_webservice_data_model');
$this->load->database();
}

	
	public function get_today_dispatched_order()
    {
            $user_id = $this->session->userdata('user_id');
	        $global_id = $this->session->userdata('global_id');
			$date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.delivery_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,sdo.planned_delivery_date as planned_delivery_date , sdo.status as sales_status, c.T10Status');
			$this->db->from('dbo.sales_dispatched_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.CustomersExt as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			//$this->db->where('sdo.status', 'Released');
			$this->db->like('sdo.cust_no', 'c', 'after');
			$this->db->where('d.shipping_status!=', 'Pending');
		    $this->db->where('sdo.delivery_date', $date);
			$this->db->where('t.global_id', $global_id );
			return $this->db->get()->result_array();
		
    }
	public function get_today_posted_dispatched_order()
    {
		    $user_id = $this->session->userdata('user_id');
	        $global_id = $this->session->userdata('global_id');
			$date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.posting_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date,sdo.status as sales_status, c.T10Status ');
			$this->db->from('dbo.posted_sales_dispatch_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.CustomersExt as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			$this->db->where('sdo.status', 'Released');
			$this->db->like('sdo.cust_no', 'c', 'after');
			$this->db->where('t.global_id', $global_id );
			$this->db->where("(d.shipping_status = 'Dispatched' OR d.order_status ='Completed') AND sdo.posting_date='".$date."' ");
			return $this->db->get()->result_array();
		
    }
    
	public function get_awarded_orders()
    {
		    $user_id = $this->session->userdata('user_id');
	        $global_id = $this->session->userdata('global_id');
			$date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as status,sdo.delivery_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date, sdo.status as sales_status,d.order_created_status as ocs_status, cast (sdo.order_key AS VARCHAR(max)) as order_key,ar.reason as reason, c.T10Status'); 
			$this->db->from('dbo.sales_dispatched_order as sdo'); 
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.CustomersExt as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			//$this->db->where('sdo.status', 'Released');
			$this->db->like('sdo.cust_no', 'c', 'after');
			$this->db->where('sdo.trans_no!=', '');
			$this->db->where('t.global_id', $global_id );
			return $this->db->get()->result_array(); 

    }

	public function get_inprocess_orders()
    {
			$user_id = $this->session->userdata('user_id');
			$global_id = $this->session->userdata('global_id');
			// echo $global_id;
			$date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.delivery_date as delivery_date,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route ,d.gps_enabled as gps_enabled,d.driver_id as driver_id, d.vehicle_id as vehicle_id,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date, sdo.status as sales_status, c.T10Status');
			$this->db->from('dbo.sales_dispatched_order as sdo');
			$this->db->join('dbo.order_details as d','sdo.order_id = d.order_id ' , 'left outer');
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.CustomersExt as c', 'c.user_id = d.cust_no and sdo.company =c.company','left outer');
			$this->db->where('t.global_id', $global_id );
			//$this->db->where('sdo.status', 'Released');
		    $this->db->where('d.order_status', 'Inprocess' );
			$this->db->like('sdo.cust_no', 'c', 'after');
			return $query = $this->db->get()->result_array();
		
    }
	public function get_dispatched_orders()
    {
		    $user_id = $this->session->userdata('user_id');
	        $global_id = $this->session->userdata('global_id');
			$date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.posting_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route ,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date, c.T10Status');
			$this->db->from('dbo.posted_sales_dispatch_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.CustomersExt as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			$this->db->where('sdo.status', 'Released');
			$this->db->like('sdo.cust_no', 'c', 'after');
			$this->db->where('t.global_id', $global_id );
			$this->db->where('d.shipping_status', 'Dispatched' );
			return $this->db->get()->result_array();
    }

	public function get_completed_orders()
    {
		    $user_id = $this->session->userdata('user_id');
	        $global_id = $this->session->userdata('global_id');
			$date=date('Y-m-d');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,d.shipping_status as shipping_status,sdo.posting_date as delivery_date,c.name as cust_name,d.order_status as order_status,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route ,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date , c.T10Status');
			$this->db->from('dbo.posted_sales_dispatch_order as sdo');
			$this->db->join('dbo.order_details as d', 'sdo.order_id = d.order_id','left outer' );
			$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.CustomersExt as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','left outer');
			$this->db->join('dbo.attn_required as ar', 'ar.order_id = sdo.order_id','left outer');
			$this->db->where('sdo.status', 'Released');
			$this->db->like('sdo.cust_no', 'c', 'after');
			$this->db->where('t.global_id', $global_id );
			$this->db->where('d.shipping_status', 'Delivered' );
			return $this->db->get()->result_array();
    }
	
	public function get_bid_orders()
	{
		$user_id = $this->session->userdata('user_id');
       $date=date('Y-m-d');
		$this->db->select('*,c.name as cust_name,t.name as trans_name,d.shipping_status as status,psdo.order_id as order_id,psdo.posting_date as delivery_date,c.name as cust_name, c.T10Status');
	    $this->db->from('dbo.posted_sales_dispatch_order as psdo');
		$this->db->join('dbo.order_details as d', 'd.order_id = psdo.order_id');
		$this->db->join('dbo.transporter as t', 't.user_id = psdo.trans_no','left outer');
		$this->db->join('dbo.CustomersExt as c', 'c.user_id = psdo.cust_no','left outer');
		$this->db->where('psdo.status', 'Released');
		$this->db->where('psdo.posting_date', $date);
		$this->db->where('psdo.trans_no', $user_id);
		$this->db->like('psdo.cust_no', 'c', 'after');
		return $this->db->get()->result_array(); 
	}
	public function get_todays_vehicle_dispatched()
	{
		$uid = $this->session->userdata('user_id');
		$global_id = $this->session->userdata('global_id');
		$date = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('dbo.order_details as d');
		$this->db->join('dbo.posted_sales_dispatch_order as psdo', 'd.order_id = psdo.order_id');
		$this->db->where('d.shipping_status','Dispatched');
		$this->db->where('d.global_id',$global_id);
		$this->db->where('psdo.posting_date',$date);
		return $this->db->get()->result_array();
	}
	public function get_todays_vehicle_arrived()
	{   
	    $date = date('Y-m-d');
		$uid = $this->session->userdata('user_id');
		$global_id = $this->session->userdata('global_id');
		
		$this->db->select('*');
		$this->db->from('dbo.order_details');
		$this->db->where('global_id',$global_id);
		$this->db->where('convert(DATE,gate_in_date)',$date);
		return $this->db->get()->result_array();
	}
	public function get_todays_dispatch_planned()
	{
		
		$date = date('Y-m-d');
		$uid = $this->session->userdata('user_id');
		$global_id = $this->session->userdata('global_id');
		/*$this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order as sdo');
		$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no','left outer');
		$this->db->where('sdo.delivery_date',$date);
		$this->db->where('sdo.status', 'Released');
		$this->db->where('c.name!=', ''); 
		$this->db->where('sdo.trans_no',$uid);*/
	/*$query = $this->db->query("SELECT sdo.order_id FROM sales_dispatched_order as sdo where sdo.delivery_date ='".$date."' and sdo.trans_no ='".$uid."' and sdo.status='Released' and sdo.cust_no LIKE 'c%'
	UNION 
     SELECT psdo.order_id FROM posted_sales_dispatch_order as psdo inner join order_details as d on d.order_id=psdo.order_id where 
	psdo.posting_date='".$date."' and psdo.cust_no LIKE 'c%' AND psdo.trans_no ='".$uid."'");
		return $query->result_array();*/
		 $query = $this->db->query("SELECT sdo.order_id FROM sales_dispatched_order as sdo INNER JOIN transporter as t on t.user_id=sdo.trans_no where sdo.delivery_date ='".$date."' and t.global_id ='".$global_id."' and sdo.status='Released' and sdo.cust_no LIKE 'c%'
	     UNION 
        SELECT psdo.order_id FROM posted_sales_dispatch_order as psdo inner join order_details as d on d.order_id=psdo.order_id INNER JOIN transporter as t on t.user_id=psdo.trans_no where 
	    psdo.posting_date='".$date."' and psdo.cust_no LIKE 'c%' AND t.global_id ='".$global_id."'");

		return $query->result_array();
	
	}
	public function get_todays_vehicle_confirmed()
	{
		$date = date('Y-m-d');
		$uid = $this->session->userdata('user_id');
		$global_id = $this->session->userdata('global_id');
		/* $this->db->select('*');
		$this->db->from('dbo.order_details as od');
		$this->db->join('dbo.sales_dispatched_order as sdo', 'od.order_id = sdo.order_id','left outer');
		$this->db->join('dbo.posted_sales_dispatch_order as psdo', 'od.order_id = psdo.order_id','left outer');
		$this->db->where('od.trans_no', $uid);
		$this->db->where('sdo.delivery_date', $date);
		$this->db->or_where('psdo.posting_date', $date); */
		
		/*$query = $this->db->query("select * from dbo.order_details as od left outer join dbo.sales_dispatched_order as sdo on od.order_id = sdo.order_id left outer join dbo.posted_sales_dispatch_order as psdo on od.order_id = psdo.order_id where od.order_status!='Pending' and  od.trans_no = '".$uid."' AND (sdo.delivery_date = '".$date."' OR psdo.posting_date = '".$date."')");
		return $query->result_array();*/
		
		$query = $this->db->query("SELECT sdo.order_id FROM sales_dispatched_order as sdo left outer join order_details as d on sdo.order_id=d.order_id where sdo.delivery_date ='".$date."' and sdo.status='Released' and sdo.cust_no LIKE 'c%' and d.order_status!='Pending' and  d.global_id = '".$global_id."' UNION SELECT psdo.order_id FROM posted_sales_dispatch_order as psdo inner join order_details as d on d.order_id=psdo.order_id where psdo.posting_date='".$date."' and psdo.cust_no LIKE 'c%' and  d.global_id = '".$global_id."' and  d.order_status!='Pending' ");
		return $query->result_array(); 
	}
	public function get_todays_vehicle_notconfirmed()
	{
		$date = date('Y-m-d');
		$uid = $this->session->userdata('user_id');
		$this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order as sdo');
		$this->db->join("dbo.order_details as od", "od.order_id = sdo.order_id","left outer");
		$this->db->where('sdo.delivery_date', $date);
		$this->db->where('sdo.status', 'Released');
		$this->db->like('sdo.cust_no', 'c', 'after');
		$this->db->where('sdo.trans_no =', $uid); 
		return $this->db->get()->result_array();
		
		
	}
	public function get_open_orders()
	{
		 $this->db->select('sdo.*');
		  $this->db->from('dbo.sales_dispatched_order as sdo');
		  $this->db->where('sdo.trans_no', '' );
		  $this->db->like('sdo.cust_no', 'c', 'after');
		  $this->db->where('sdo.status', 'Released' );								 
		  $query = $this->db->get();
		  return $query->result_array();
	}
	
	/************** Driver ****************/
	function driver_details($data)
	{
		$user_id = 'DRI'.rand(1000, 9999);
		$id = $this->session->userdata('user_id');
		$global_id = $this->session->userdata('global_id');
		/* print($user_id);die; */
		$value=array(
			 'user_id' =>$user_id,
			 'global_id' =>$global_id,
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
			'transporter_id' => $id,
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
		else
		{
			             $this->db->select('*');
						 $this->db->from('dbo.email_string');
						 $this->db->where('email_type', 'add_driver');
						 $sql = $this->db->get()->row();
				         $subject=$sql->subject;
						 $message=$sql->message;

						 $this->db->select('*');
						 $this->db->from('dbo.sms_string');
						 $this->db->where('sms_type', 'add_driver');
						 $sql = $this->db->get()->row();
				         $title=$sql->title;
						 $message=$sql->message;

							//$email=$data['email'];
						//	$password=$data['password'];
							$name=$data['name'];
							$email_message =  $message.'<br>';
							$email_message .=' User Id: '.$user_id.'<br>';
							$email_message .=' Name: '.$data['name'].'<br>';
							$email_message .=' Password: 123456 <br>';

					$sms_string= $message.' User Id : '.$user_id.'Name: '.$data['name'].' password: 123456';


		                $data = $this->sms->delivery_sms($data['mobile'],'','',$sms_string);
		              //  $data = $this->send_email->delivery_mail($email,'','',$email_message,$subject);
		              return $query; 
	}
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
	function updateDriver($data)
	{
		
		$id = $data['id'];
		/* print($user_id);die; */
		$value=array(
			 'name' =>$data['name'] ,
			 'mobile' =>$data['mobile'],
			 'license_no' =>$data['license_no'],
			 'valid_upto' =>$data['valid_upto'],
			 
   
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
	/************** Vehicle ****************/
	function vehicle_details($data)
	{
		$id = $this->session->userdata('user_id');
		$global_id = $this->session->userdata('global_id');
		//$date = date('Y-m-d',strtotime($data['valid_upto']));
		/* print($user_id);die; */
		$value=array(
			'registration_no' => $data['registration_no'],
			'valid_upto' => '',
			'vehicle_type' => $data['vehicle_type'],  
			'owner_name' => $data['owner_name'],
			'owner_contact' => $data['owner_contact'],
			'capacity' => $data['capacity'],
			'unit' => $data['unit'],
			'transporter_id' => $id,
			'global_id' => $global_id,
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
	function updateVehicle($data)
	{
		
		$id = $data['id'];
		/* print($user_id);die; */
		$value=array(
			'registration_no' => $data['registration_no'],
			'valid_upto' => '',
			'vehicle_type' => $data['vehicle_type'],  
			'owner_name' => $data['owner_name'],
			'owner_contact' => $data['owner_contact'],
			'capacity' => $data['capacity'],
			'unit' => $data['unit'],
			'insurance' => $data['insurance'],
			
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
	/****************** Order Details *********************/
	function insertOrder($data)
	{
		$global_id = $this->session->userdata('global_id');
		$this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order');
		$this->db->where('order_id', $data['order_id'] );
		$query = $this->db->get();
		$rows = $query->result_array();
		
		 foreach($rows as $row)
		 {
		 	$trans_no=$row['trans_no'];
		$value=array(
			'order_id' => $data['order_id'],
			'global_id' => $global_id,
			'trans_no' => $row['trans_no'],
			'cust_no' => $row['cust_no'],  
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
			'order_created_status' => 'Admin',
			     
    	);
		 }
		/* print_r($value);
		die; */
		$query = $this->db->insert('dbo.order_details',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		else
		{
         /**************send notification to admin**************/

       $sender='transporter';
       $receiver='admin';
       $result = $this->notification_save->save_notification_all($data['order_id'],'order_accept',$sender,$receiver);

         /**************end send notification to admin**************/

       $sender='transporter';
       $receiver='admin';
       $result = $this->sms_save->save_sms_all($data['order_id'],'order_accept',$sender,$receiver);

       $sender='transporter';
       $receiver='admin';
       $result = $this->email_save->save_email_all($data['order_id'],'order_accept',$sender,$receiver);

		    return $query;
		} 
	}
	function rejectOrder($data)
	{
		$global_id = $this->session->userdata('global_id');
		$this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order');
		$this->db->where('order_id', $data['order_id'] );
		$query = $this->db->get();
		$rows = $query->result_array();
		
		 foreach($rows as $row)
		 {
			 $update=array(
			 
				'order_id' => $data['order_id'],
				'global_id' => $global_id,
				'customer_no' => $row['cust_no'],
				'transporter_no' => $row['trans_no'], 
				'reason' => 'Rejected by vendor<br>
				             Reason :'.$data['reject_reason'],
				'delivery_date' => $row['delivery_date'],
				);
		
		 }
		/* print_r($value);
		die; */
		
		$query = $this->db->insert('dbo.attn_required',$update);
		$query = $this->db->insert('dbo.missed_orders',$update);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		else{

			 /**************send notification to admin**************/

       $sender='transporter';
       $receiver='admin';
       $result = $this->notification_save->save_notification_all($data['order_id'],'order_decline',$sender,$receiver);

         /**************end send notification to admin**************/

       $sender='transporter';
       $receiver='admin';
       $result = $this->sms_save->save_sms_all($data['order_id'],'order_decline',$sender,$receiver);

       $sender='transporter';
       $receiver='admin';
       $result = $this->email_save->save_email_all($data['order_id'],'order_decline',$sender,$receiver);
		return $query; 
		}
	}
	function chnage_details_order($data)
	{
		$user_id = $this->session->userdata('user_id');
		$global_id = $this->session->userdata('global_id');
		$gps_enabled = implode(",", $data['gps_enabled']);
		
		$this->db->select('*');
		$this->db->from('dbo.orders_change_details');
		$this->db->where('order_id', $data['order_id'] );
		$query = $this->db->get();
		$rows = $query->result_array();
		if($rows)
		{
		 foreach($rows as $row)
		 {
			 if($data['vehicle_id']=='0')
	{
		$vehicle_id=$row['vehicle_id'];
	}
	else{
		$vehicle_id=$data['vehicle_id'];
	}
	if($data['driver_id']=='0')
	{
		$driver_id=$row['driver_id'];
	}
	else{
		$driver_id=$data['driver_id'];
	}
	if($data['delivery_date']=='')
	{
		$delivery_date=date('Y-m-d', strtotime($row['delivery_date']));
	}
	else{
		$delivery_date=date('Y-m-d', strtotime($data['delivery_date']));
	}
	if($data['change_reason']=='')
	{
		$change_reason=$row['change_reason'];
	}
	else{
		$change_reason=$data['change_reason'];
	}
																	
		 $value=array(
			'vehicle_id' => $vehicle_id,
			'driver_id' => $driver_id,
			'gps_enabled' => $gps_enabled,
			'status' => 'Not Approved',
			'change_reason' => $change_reason,
			'trans_no' => $user_id,
			'order_id' => $data['order_id'],
			'global_id' => $global_id,
			'delivery_date' =>  $delivery_date,
			     
    	);
		
		/* print_r($value);
		die; */
		$this->db->where('order_id',$data['order_id']);
		$query = $this->db->update('dbo.orders_change_details',$value);
		 $update=array(
			
			'shipping_status' => 'Not Approved',
    	);
		
		$this->db->where('order_id',$data['order_id']);
		$query = $this->db->update('dbo.order_details',$update);
		
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		else{
		return $query; 
		}
		 }
		}else{
	$this->db->select('*');
	$this->db->from('dbo.order_details as d');
	$this->db->join('dbo.sales_dispatched_order as sdo','d.order_id = sdo.order_id ' , 'LEFT OUTER');
	$this->db->where('d.order_id', $data['order_id'] );
	$query = $this->db->get()->result_array();
	//print_r($query); die;
	foreach($query as $get)
	{
		
	
	if($data['vehicle_id']=='0')
	{
		$vehicle_id=$get['vehicle_id'];
	}
	else{
		$vehicle_id=$data['vehicle_id'];
	}
	if($data['driver_id']=='0')
	{
		$driver_id=$get['driver_id'];
	}
	else{
		$driver_id=$data['driver_id'];
	}
	if($data['delivery_date']=='')
	{
		$delivery_date=date('Y-m-d', strtotime($get['delivery_date']));
	}
	else{
		$delivery_date=date('Y-m-d', strtotime($data['delivery_date']));
	}
	}
	
	
			 $value=array(
			'vehicle_id' =>$vehicle_id ,
			'driver_id' => $driver_id,
			'gps_enabled' => $gps_enabled,
			'status' => 'Not Approved',
			'change_reason' => $data['reason'],
			'trans_no' => $user_id,
			'order_id' => $data['order_id'],
			'global_id' => $global_id,
			'delivery_date' => $delivery_date,
			     
    	);
		
		/* print_r($value);
		die; */
	
		$query = $this->db->insert('dbo.orders_change_details',$value);
		
		$update=array(
			
			'shipping_status' => 'Not Approved',
    	);
		
		$this->db->where('order_id',$data['order_id']);
		$query = $this->db->update('dbo.order_details',$update);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		else{

			       $sender='transporter';
                   $receiver='admin,driver';
                   $result = $this->notification_save->save_notification_all($order_id,'edit_assignment_request',$sender,$receiver);

	               $sender='transporter';
	               $receiver='admin,driver';
	               $result = $this->sms_save->save_sms_all($order_id,'edit_assignment_request',$sender,$receiver);

	                $sender='transporter';
                    $receiver='admin,driver';
                    $result = $this->email_save->save_email_all($order_id,'edit_assignment_request',$sender,$receiver);

		return $query; 
		}	
		}
		
	}
	function updateOrder($data)
	{
		date_default_timezone_set("Asia/Calcutta");
		$global_id = $this->session->userdata('global_id');
		$gps_enabled = implode(",", $data['gps_enabled']);
		$veh_id=$data['vehicle_id'];
		$driver_id=$data['driver_id'];
		$lr_rr_no=$data['lr_rr_no'];
		$lr_date=$data['lr_rr_date'];
		$order_id=$data['order_id'];
		$timestamp = strtotime($lr_date); 
        $lr_rr_date = date('Y-m-d', $timestamp);
		// echo $lr_rr_date; die;
		$this->db->select('*');
        $this->db->from('dbo.sales_dispatched_order');
	    $this->db->where('order_id',$data['order_id']);
	    $data1= $this->db->get()->result_array(); 
			//print_r($data);
			foreach($data1 as $get1)
			{
				$key=$get1['order_key'];
			}
                $this->db->select('*');
				$this->db->from('dbo.vehicle');
				$this->db->where('id', $veh_id );
				$query = $this->db->get();
				$row = $query->result_array();
			
				foreach( $row as $value ) {
					$vehicle_no=$value['registration_no'];
				}
				$this->db->select('*');
				$this->db->from('dbo.driver');
				$this->db->where('id', $driver_id );
				$query = $this->db->get();
				$row = $query->result_array();
			
				foreach( $row as $value ) {
					$dname=$value['name'];
					$mobile=$value['mobile'];
				}
		
	               $data = $this->update_webservice_data_model->change_webservice_data($global_id,$order_id,$mobile,$dname,$vehicle_no,$lr_rr_no,$lr_rr_date);						
					if ($data)
					{
                        $value=array(

						'vehicle_id'  => $veh_id,
						'driver_id'   => $driver_id,
						'order_status' => 'Inprocess',
						'shipping_status' => 'Awaiting For Arrival',
						'eway_no' => '',
						'lr_rr_no' => $lr_rr_no,
						'lr_rr_date' => $lr_rr_date,
						'gps_enabled' => $gps_enabled,
						//'insurance_no' => $data['insurance_no'],
							 
					);
					
					$this->db->where('order_id',$order_id);
					$query = $this->db->update('dbo.order_details',$value);
					if(! $query)
					{
						return false;
					}
					else{ 
					
						/**********rating*******/
						if( strtolower($gps_enabled) == 'yes'){
								$insert=array(
								 'order_id' => $order_id,
								 'global_id' => $global_id,
								 'accept_and_assign' => '2.5',
								 'track_and_trace' => '0'
								 );
							$data1=$this->db->insert('dbo.trans_rating', $insert);
						}else{
							$insert=array(
						     'order_id' => $order_id,
							 'global_id' => $global_id,
							 'accept_and_assign' => '2.5',
							 'track_and_trace' => '0'
					         ); 
							 $data1=$this->db->insert('dbo.trans_rating', $insert);
						}		
							
						  
						 
						   /*****end rating*****/
		                        
					          /**************send notification to admin**************/

					       $sender='transporter';
					       $receiver='admin,driver';
					       $result = $this->notification_save->save_notification_all($order_id,'order_assign',$sender,$receiver);
					         

					         /**************end send notification to admin**************/

					       $sender='transporter';
					       $receiver='admin,driver';
					       $result = $this->sms_save->save_sms_all($order_id,'order_assign',$sender,$receiver);

					       $sender='transporter';
					       $receiver='admin,driver';
					       $result = $this->email_save->save_email_all($order_id,'order_assign',$sender,$receiver);
							return $query; 
					 }
					}
					else
					{
                             return false;
					}
		
	
	}
	
	function insertLocation($data)
	{
		
		$order_id = $data['order_id'];
		$address = $data['address'];
		$date = $data['date'];
		$time = $data['time'];
		$ids = $data['id'];
		
		$this->db->select('*');
		$this->db->from('dbo.location');
		$this->db->where('order_id',$order_id);
		$query = $this->db->get();
		$num_row = $query->num_rows();
		
		if($num_row == 0)
		{
			$count = count($address);
			
		
			for($i=0; $i < $count ; $i++)
			{
				
				$value = $address[$i];
				$value1 = $date[$i]; 
				$value2 = $time[$i]; 
				$order_id = $data['order_id'];
				$values=array(
						'order_id' => $order_id,
						'address' => $value,
						'date' => $value1,
						'time' => $value2,
							 
					);
				$this->db->insert('dbo.location',$values);
				
				
			}
				$this->session->set_flashdata('item', array('message' => 'Location added successfully','class' => 'success') );
				$this->session->flashdata('item');
			
				redirect(base_url().'index.php/transporter/milestone');
			
			
		}
		else
		{
			$rows = $query->num_rows();
			$count = count($address);
			if($rows == $count)
			{
				for($i=0; $i < $rows ; $i++)
				{
					
					$value = $address[$i];
					$value1 = $date[$i]; 
					$value2 = $time[$i]; 
					$id = $ids[$i];
					$order_id = $data['order_id'];
					$values=array(
						'order_id' => $order_id,
						'address' => $value,
						'date' => $value1,
						'time' => $value2,
							 
					);
						$this->db->where('id',$id); 
						$query1 = $this->db->update('dbo.location',$values);
					
					
					
				}
				$this->session->set_flashdata('item', array('message' => 'Location updates successfully','class' => 'success') );
					$this->session->flashdata('item');
			
				redirect(base_url().'index.php/transporter/milestone');
			}
			else
			{
				for($i=0; $i < $rows ; $i++)
				{
					
					$value = $address[$i];
					$value1 = $date[$i]; 
					$value2 = $time[$i]; 
					$id = $ids[$i];
					$order_id = $data['order_id'];
					$values=array(
						'order_id' => $order_id,
						'address' => $value,
						'date' => $value1,
						'time' => $value2,
							 
					);
						$this->db->where('id',$id); 
						$query1 = $this->db->update('dbo.location',$values);
									
				}
				for($j=$rows; $j < $count; $j++ )
				{
					
					$value = $address[$j];
					$value1 = $date[$j]; 
					$value2 = $time[$j]; 
					$id = $ids[$j];
					$order_id = $data['order_id'];
					$values=array(
						'order_id' => $order_id,
						'address' => $value,
						'date' => $value1,
						'time' => $value2,
							 
					);
					$this->db->insert('dbo.location',$values);
					
				}
				$this->session->set_flashdata('item', array('message' => 'Location updates successfully','class' => 'success') );
					$this->session->flashdata('item');
			
				redirect(base_url().'index.php/transporter/milestone');
			}
			
		}
	}
	
	function change_password($data)
	{
	 $id1 = $this->session->userdata('user_id');
	 $global_id = $this->session->userdata('global_id');
		$value=array(
		
		     'password' => $data['new_password'] ,
			
		);
		$this->db->where('global_id',$global_id);
		$query = $this->db->update('dbo.transporter',$value);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		return $query; 
	}
	function bidnow($data)
	{
		$global_id = $this->session->userdata('global_id');
		$user_id = $data['id'];
		//echo $user_                    id;
		$company = $data['company'];
		//echo $company;
		$this->db->select('name');
		$this->db->from('dbo.transporter');
		$this->db->where('global_id', $global_id);
		//$this->db->where('company', $company);
		$query = $this->db->get()->row();
		/* print_r($query); */
		$date = date('Y-m-d',strtotime($data['pickup_date']));
		$value=array(
			'order_id' => $data['order_id'],
			'global_id' => $global_id,
			'transporter_no' => $data['id'],
			'transporter_name' => $query->name,
			//'transit_time' => $data['transit_time'],
			'bid_amount' => $data['bid_amount'],		
			'unit' => $data['unit'],	
			'edit_amount' => $data['bid_amount'],	
			'edit_date' => date('Y-m-d H:i:s'),		
			//'comments' => $data['comments'],	
			//'fleet_type' => $data['fleet_type'],	
			//'pickup_date' => $date,	
		);
                   $this->db->select('MIN(bid_amount) as lowest_amount, unit');
                   $this->db->from('dbo.bidding_orders');
                   $this->db->where('order_id', $data['order_id']);
                   $this->db->group_by('unit'); 
                   $min_bid_amount = $this->db->get()->row();
                   $min_amount=$min_bid_amount->lowest_amount;
		
        $this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order');
		$this->db->where('order_id', $data['order_id'] );
		$res = $this->db->get();
		$order = $res->row();
		$amount= $order->bidding_amount;

		$this->db->select('*');
		$this->db->from('dbo.bidding_orders as b');
		$this->db->where('b.order_id', $data['order_id'] );
		$res = $this->db->get();
		$exit = $res->row();
		if(!$exit)
		{
             if($amount >= $data['bid_amount'])
             {
					$bid=array(
					'order_id' => $data['order_id'],
					'global_id' => $global_id,
					'transporter_no' => $data['id'],
					'transporter_name' => $query->name,
					'bid_amount' => $data['bid_amount'],		
					'unit' => $data['unit'],
					'edit_amount' => $data['bid_amount'],	
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
         if($min_amount >= $data['bid_amount'] )
         {
		$this->db->select('*');
		$this->db->from('dbo.bidding_orders');
		$this->db->where('transporter_no', $user_id );
		$this->db->where('order_id', $data['order_id'] );
		$q = $this->db->get();
		$q1 = $q->row();
		$a=array(); 
		if($q->num_rows > 0)
		{
			$edit_amount  = explode(',',$q1->edit_amount);
			$edit_date    = explode(',',$q1->edit_date);
			//print_r($edit_amount);
			$d=date('Y-m-d H:i:s');
			array_push($edit_amount, $data['bid_amount']);
			array_push($edit_date, $d);
			$total_amount= implode(',',$edit_amount);
			$date= implode(',',$edit_date); 
			//print_r($total_amount);
			//$total_amount = $edit_amount.','.$data['bid_amount'];
            $total=array(
			'order_id' => $data['order_id'],
			'global_id' => $global_id,
			'transporter_no' => $data['id'],
			'transporter_name' => $query->name,
			'bid_amount' => $data['bid_amount'],
			'edit_amount' => $total_amount,	
			'edit_date' => $date,		
			'unit' => $data['unit'],			
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
	function cancel_order($data,$reason)
	{
		$global_id = $this->session->userdata('global_id');
		$order_id=$data['cancel_order_id'];
		//echo $order_id;
	//	echo $reason;
	//	die;
		$this->db->select('*');
		$this->db->from('dbo.order_details as od');
		$this->db->join("dbo.sales_dispatched_order as sdo", "od.order_id = sdo.order_id","left outer");
		$this->db->where('od.order_id', $order_id);
		$query = $this->db->get();
		$rows = $query->result_array();
		
		 foreach($rows as $row)
		 {
			 $timestamp = strtotime($row['delivery_date']); 
             $delivery_date = date('Y-m-d', $timestamp);
			    $insert=array(
				'driver_id' => $row['driver_id'],
     			'order_id' => $order_id,
     			'global_id' => $global_id,
				'trans_no' => $row['trans_no'], 
				'change_reason' => 'Cancel request by vendor<br>
				             Reason :'.$reason,
				'vehicle_id' => $row['vehicle_id'],
				'delivery_date' => $delivery_date,
				'gps_enabled' => '',
				'previous_order_status' => $row['shipping_status'],
				'status' => 'Canceled',
				);
		
		 }
		/* print_r($value);
		die; */
		
		$query = $this->db->insert('dbo.orders_change_details',$insert);
		if(! $query)
		{
			print_r($this->db->error());
			die;
		}
		else{
			 $update=array(
			
				'shipping_status' => 'Awaiting For Approvel',
				);
			$this->db->where('order_id',$order_id);
			$sql = $this->db->update('dbo.order_details',$update);

			       $sender='transporter';
                   $receiver='admin,driver';
                   $result = $this->notification_save->save_notification_all($order_id,'cancel_assignment_request',$sender,$receiver);

	               $sender='transporter';
	               $receiver='admin,driver';
	               $result = $this->sms_save->save_sms_all($order_id,'cancel_assignment_request',$sender,$receiver);

	               $sender='transporter';
                   $receiver='admin,driver';
                   $result = $this->email_save->save_email_all($order_id,'cancel_assignment_request',$sender,$receiver);
			      
		    return $query; 
		}
	}
	public function otp_verify($data,$otp)
	{
		$order_id=$data['delivered_order_id'];
		$user_id = $this->session->userdata('user_id');
		$global_id = $this->session->userdata('global_id');
		$this->db->select('*');
		$this->db->from('dbo.order_details');
		$this->db->where('otp', $otp);
		$this->db->where('order_id', $order_id);
		$this->db->where('global_id', $global_id);
		return $this->db->get()->result_array(); 
	}
	public function get_attention_required_order($status)
    {
		$date=date('Y-m-d');
		if($status=='today')
		{
			$this->db->where('mo.delivery_date', $date);
		}
			else if($status=='inside'){
			
		}
		    $user_id = $this->session->userdata('user_id');
			$global_id = $this->session->userdata('global_id');
			
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,mo.delivery_date as delivery_date,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route ,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date,mo.reason as reason,sdo.ship_to_name as ship_to_name');
			 $this->db->from('dbo.missed_orders as mo');
	     	$this->db->join('dbo.sales_dispatched_order as sdo', 'sdo.order_id = mo.order_id','left outer');
			$this->db->join('dbo.transporter as t', 't.user_id = mo.transporter_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = mo.customer_no and sdo.company =c.company','left outer');
			$this->db->where('mo.global_id', $global_id );
			$this->db->where('sdo.status', 'Released');
			
			return $query = $this->db->get()->result_array();
    }
	public function get_all_attention_required_order($status)
    {
		$date=date('Y-m-d');
		if($status=='today')
		{
			$this->db->where('mo.delivery_date', $date);
		}
		else if($status=='inside'){
			
		}
		    $user_id = $this->session->userdata('user_id');
			$global_id = $this->session->userdata('global_id');
			$this->db->select('DISTINCT (sdo.order_id) as order_id,c.name as cust_name,t.name as trans_name,mo.delivery_date as delivery_date,sdo.cust_no as cust_no,sdo.trans_no as trans_no,t.state_code as state_code,t.company as company,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route ,cast (sdo.planned_delivery_date AS VARCHAR(max)) AS planned_delivery_date,mo.reason as reason,sdo.ship_to_name as ship_to_name');
			 $this->db->from('dbo.missed_orders as mo');
	     	$this->db->join('dbo.posted_sales_dispatch_order as sdo', 'sdo.order_id = mo.order_id','left outer');
			$this->db->join('dbo.transporter as t', 't.user_id = mo.transporter_no and sdo.company = t.company','left outer');
			$this->db->join('dbo.customer as c', 'c.user_id = mo.customer_no and sdo.company =c.company','left outer');
			$this->db->where('mo.global_id', $global_id );
			$this->db->where('sdo.status', 'Released');
			return $query = $this->db->get()->result_array();
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
     public function get_notifications()
    {
    	    $global_id = $this->session->userdata('global_id');
		    $this->db->select('*');
			$this->db->from('dbo.notification');
	        $this->db->where("receiver_id like '%$global_id%'");	
	         $this->db->order_by("created","desc");
			return $query = $this->db->get()->result_array();
    }
	
	
	
}