<?php
class Notification_save extends CI_Model
{

function __construct() {
parent::__construct();
$this->load->database();
$this->load->model('Send_notification', 'notification');

//date_default_timezone_set("Asia/Calcutta");
}

	public function save_notification_all($order_id,$type,$sender,$receiver)
	{
		$receiver_id=array();
		 $this->db->select('t.name as tname,c.name as cname,d.name as dname,od.global_id,d.device_token,d.device_type,v.registration_no as veh_name,d.id as driver_id,od.global_id as trans_id,c.global_id as cust_id');
		 $this->db->from('dbo.order_details as od');
		 $this->db->join('dbo.transporter as t', 't.global_id = od.global_id','left outer');
		 $this->db->join('dbo.customer as c', 'c.user_id = od.cust_no','left outer');
		 $this->db->join('dbo.driver as d', 'd.id = od.driver_id','left outer');
		 $this->db->join('dbo.vehicle as v', 'v.id = od.vehicle_id','left outer');
		 $this->db->where('od.order_id',$order_id );
		 $row = $this->db->get()->row();
		 if($row)
		 {
		 $trans_name=$row->tname;
		 $cust_name=$row->cname;
		 $driver_name=$row->dname;
		 $veh_name=$row->veh_name;
		 $driver_id=$row->driver_id;
		 $trans_id=$row->trans_id;
		 $cust_id=$row->cust_id;
		}
		else
		{
         $this->db->select('t.name as tname,c.name as cname,t.global_id as trans_id,c.global_id as cust_id');
		 $this->db->from('dbo.sales_dispatched_order as sdo');
		 $this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and t.company = sdo.company','left outer');
		 $this->db->join('dbo.customer as c', 'c.user_id = sdo.cust_no and c.company = sdo.company','left outer');
		 $this->db->where('sdo.order_id',$order_id );
		 $row = $this->db->get()->row();
		 $trans_name=$row->tname;
		 $cust_name=$row->cname;
         $trans_id=$row->trans_id;
		 $cust_id=$row->cust_id;
		}
		 if($sender=='driver')
		 {
             $sender_id= $driver_id;

		 }if($sender=='transporter')
		 {
		 	$sender_id= $trans_id;

		 }if($sender=='customer')
		 {
		 	$sender_id= $cust_id;
		 }
		 if($sender=='admin')
		 {
           $sender_id= 'Admin';
		 }
		
         if(strpos($receiver, 'transporter') !== false)
         {
         $this->db->select('t.device_type,t.device_token');
		 $this->db->from('dbo.transporter as t');
		 $this->db->where('t.global_id', $trans_id );
		 $row1 = $this->db->get()->row();
		 $device_type=$row1->device_type;
		 $device_token=$row1->device_token; 
		 $receiver_id[]=$trans_id;   
         }
         if(strpos($receiver, 'driver') !== false)
         {
         $this->db->select('d.device_type,d.device_token');
		 $this->db->from('dbo.driver as d');
		 $this->db->where('d.id', $driver_id );
		 $row = $this->db->get()->row();
		 $device_type=$row->device_type;
		 $device_token=$row->device_token;    
		 $receiver_id[] = $driver_id;   
         }
          if(strpos($receiver, 'customer') !== false)
         {
         $this->db->select('c.device_type,c.device_token');
		 $this->db->from('dbo.customer as c');
		 $this->db->where('c.global_id', $cust_id );
		 $row = $this->db->get()->row();
		 $device_type=$row->device_type;
		 $device_token=$row->device_token;   
		 $receiver_id[]= $cust_id;    
         }
         if(strpos($receiver, 'admin') !== false)
         {
		 $receiver_id[]= 'admin';    
         }
         $receiver_id1=implode(',',$receiver_id);

		  //$receiver_id=$receiver_id.','.$receiver_id1.','.$receiver_id2.','.$receiver_id3;

         $this->db->select('*');
		 $this->db->from('dbo.notification_string');
		 $this->db->where('noti_type', $type);
		 $sql = $this->db->get()->row();
         $title=$sql->title;
		 $message=$sql->message;

		       $searchArray = array("{}", "()", "[]","Admin",'<>','@@',"\\");
             $replaceArray = array($order_id, $cust_name, $trans_name, 'Admin',$driver_name,$veh_name,'/');

             $new_title = str_replace($searchArray, $replaceArray, $title);
             $new_message = str_replace($searchArray, $replaceArray, $message);
              $device_type='Android';
             if($device_type=='Android')
		  {
             $result=$this->notification->send_notification($device_token,$new_title,$new_message);

		  }else if($device_type=='Ios')
		  {
            $result=$this->notification->send_notification_ios($device_token,$new_title,$new_message);
		  }
             $save=array(
                 'order_id'=> $order_id,
                 'sender_type'=> $sender,
                 'sender_id'=>  $sender_id,
                 'receiver_type'=> $receiver,
                 'receiver_id'=> $receiver_id1,
                 'title'=> $new_title,
                 'message'=> $new_message,
               
             );
            // print_r($save); 
            // die;
             $result = $this->db->insert('dbo.notification',$save);

         /**************end send notification to admin**************/
		
   }
}
  
        

  ?>