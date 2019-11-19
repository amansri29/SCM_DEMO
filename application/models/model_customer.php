<?php
class Model_customer extends CI_Model{
function __construct() {
	$this->load->database();
	$this->load->model('update_webservice_data_model');
parent::__construct();
}
	function get_inprocess_orders()
	{
		$user_id = $this->session->userdata('user_id');
		$global_id = $this->session->userdata('global_id');
		$this->db->select('DISTINCT(sdo.order_id) as order_id,od.order_status as order_status ,od.shipping_status as shipping_status,sdo.delivery_date as delivery_date,cast (sdo.item_code AS VARCHAR(max)) as item_code , cast (sdo.description AS VARCHAR(max)) AS description ,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (sdo.route AS VARCHAR(max)) AS route,cast (sdo.quantity AS VARCHAR(max)) AS quantity,sdo.ship_to_address,sdo.ship_to_address_2,sdo.Ship_to_Post_Code,sdo.ship_to_city,d.name as driver_name,d.mobile as driver_mobile,c.mobile as cust_mobile,d.id');
		$this->db->from('dbo.sales_dispatched_order as sdo');
		$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id ' , 'LEFT OUTER');
		$this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and sdo.company =c.company','LEFT OUTER');
		$this->db->join('dbo.driver as d','d.id = od.driver_id ' , 'LEFT OUTER');
		$this->db->where('od.order_status', 'Inprocess' );
		$this->db->where('od.shipping_status!=', 'Dispatched');
		$this->db->where('od.shipping_status!=', 'Delivered');
		$this->db->where('c.global_id', $global_id);
		$this->db->where('sdo.status', 'Released');
		$this->db->like('sdo.cust_no', 'c', 'after');
		return $this->db->get()->result_array() ;
	}
	function get_delivered_orders()
	{
		$user_id = $this->session->userdata('user_id');
		$global_id = $this->session->userdata('global_id');
		$this->db->select('DISTINCT(psdo.order_id) as order_id,od.order_status as order_status , od.shipping_status as shipping_status,cast (psdo.item_code AS VARCHAR(max)) as item_code , cast (psdo.description AS VARCHAR(max)) AS description ,cast (psdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship , cast (psdo.route AS VARCHAR(max)) AS route,psdo.posting_date as delivery_date, cast (psdo.quantity AS VARCHAR(max)) AS quantity,psdo.ship_to_address,psdo.ship_to_address_2,psdo.Ship_to_Post_Code,psdo.ship_to_city,d.name as driver_name,d.mobile as driver_mobile,c.mobile as cust_mobile,d.id as driver_id');
		$this->db->from('dbo.posted_sales_dispatch_order as psdo');
		$this->db->join('dbo.order_details as od','psdo.order_id = od.order_id ' , 'LEFT OUTER'); 
		$this->db->join('dbo.customer as c', 'c.user_id = od.cust_no and psdo.company =c.company','left outer');
		$this->db->join('dbo.driver as d','d.id = od.driver_id ' , 'LEFT OUTER');
		$this->db->where('od.order_status', 'Inprocess' );
		$this->db->where('od.shipping_status', 'Dispatched' );
		$this->db->where('c.global_id', $global_id);
		$this->db->where('psdo.status', 'Released');
		$this->db->like('psdo.cust_no', 'c', 'after');
		return $this->db->get()->result_array() ;
	}
	function get_sales_orders()
	{
		$date = date('Y-m-d');
		$user_id = $this->session->userdata('user_id');
		$this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order as sdo');
		$this->db->where('sdo.delivery_date',$date);
		$this->db->where('sdo.cust_no', $user_id);
		return $this->db->get()->result_array();
	}
	function get_posted_orders()
	{
		$date = date('Y-m-d');
		$user_id = $this->session->userdata('user_id');
		$this->db->select('*');
		$this->db->from('dbo.posted_sales_dispatch_order as sdo');
		$this->db->where('sdo.posting_date',$date);
		$this->db->where('sdo.cust_no', $user_id);
		return $this->db->get()->result_array();
	}
	function get_placed_order()
	{
		$global_id = $this->session->userdata('global_id');
		$res = $this->update_webservice_data_model->get_placed_order_webservice($global_id);
        return $res; 
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
?>