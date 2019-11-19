<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Transporter extends CI_Controller
{
public function __construct()
{
parent::__construct();
$this->load->helper(array('form', 'url'));
$this->load->helper('date');
$this->load->helper('file');
$this->load->library('form_validation');
$this->load->model('Model_transporter','home');
$this->load->model('update_webservice_data_model');
$this->load->database();
$this->load->library('session');
$this->load->library('image_lib');
$this->load->helper('cookie');
$this->load->helper('text');
$this->load->helper('url');
$this->load->library('email');
$this->load->model('notification_save');
$this->load->model('sms_save');
$this->load->model('email_save');

session_start();

	
}

	public function dashboard()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $status='today';
		   $sales = $this->home->get_today_dispatched_order();
		   $posted = $this->home->get_today_posted_dispatched_order();
		   $result['data']=array_merge($sales,$posted);
		  //print_r($posted);
		   $result['awarded_orders'] = $this->home->get_awarded_orders();
		   $result['inprocess_orders'] = $this->home->get_inprocess_orders();
		   $result['vehicle_dispatched'] = $this->home->get_todays_vehicle_dispatched();
		   $result['vehicle_arrived'] = $this->home->get_todays_vehicle_arrived();
		   $result['dispatch_planned'] = $this->home->get_todays_dispatch_planned();
		   $result['vehicle_confirmed'] = $this->home->get_todays_vehicle_confirmed();
		   $result['vehicle_notconfirmed'] = $this->home->get_todays_vehicle_notconfirmed();
		   $result['open_orders'] = $this->home->get_open_orders();			   
		   $attn_required = $this->home->get_attention_required_order($status);
		   $all_attn_required = $this->home->get_all_attention_required_order($status);
		   $result['attn_required']=array_merge($attn_required,$all_attn_required);
		   $this->load->view('transporter/transporter-dashboard',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function todays_dispatch()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		    $sales = $this->home->get_today_dispatched_order();
		   $posted = $this->home->get_today_posted_dispatched_order();
		  /*  print_r($sales);
		   die; */
		   $result['data']=array_merge($sales,$posted);
		   $this->load->view('transporter/todays_dispatch',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	/********************* Driver ***********************/
	public function view_driver()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/view_driver');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function add_driver()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/add_driver');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function save_driver()
	{
		
		 $data = $this->input->post();
		
		$this->db->select('*');
		$this->db->from('dbo.driver');
		$this->db->where('mobile', $data['mobile'] );
		$sql = $this->db->get();
		if($sql->num_rows() > 0)
		{
			$this->session->set_flashdata('item',array('message' => 'Mobile Number Already Exist','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/add_driver';	
				redirect($url);
		}
		
		else
		{
			$this->db->select('*');
			$this->db->from('dbo.driver');
			$this->db->where('license_no', $data['license_no'] );
			$sql = $this->db->get();
			if($sql->num_rows() > 0)
			{
				$this->session->set_flashdata('item',array('message' => 'license Number Already Exist','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/transporter/add_driver';	
					redirect($url);
			}
			else
			{
				if($this->home->driver_details($data))  
				{
					$this->session->set_flashdata('item',array('message' => 'Driver Added Successfully','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/transporter/add_driver';	
					redirect($url);
				}else {
					
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/transporter/add_driver';	
					redirect($url);
				}
			}
		}		
		
	}
	public function driver_delete()
	{
		$data=$_POST;
            
       $cate=$this->home->deleteDriver($data);
               // print_r($res);
       echo $cate;
		
	}
	public function edit_driver()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		    $this->load->view('transporter/edit_driver');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function update_driver()
	{
		
		 $data = $this->input->post();
		
		 if($this->home->updateDriver($data))  
			{
			    $this->session->set_flashdata('item',array('message' => 'Driver Updated Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/view_driver';
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/edit_driver?id='.$data['id'];	
				redirect($url);
			}
			
					
		
	}
	/********************** Vehicle**********************/
	public function view_vehicle()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/view_vehicle');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function add_vehicle()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/add_vehicle');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function save_vehicle()
	{
		
		 $data = $this->input->post();
		$this->db->select('*');
		$this->db->from('dbo.vehicle');
		$this->db->where('registration_no', $data['registration_no'] );
		$sql = $this->db->get();
		//$sql = $this->db->query('Select * From dbo.vehicle where registration_no = "'.$data['registration_no'].'"');
		/*if($sql->num_rows() > 0)
		{
			$this->session->set_flashdata('item',array('message' => 'Registration Number Already Exist','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/add_vehicle';	
				redirect($url);
		}
		else
		{*/
			if($this->home->vehicle_details($data))  
			{
			    $this->session->set_flashdata('item',array('message' => 'Vehicle Added Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/add_vehicle';	
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/add_vehicle';	
				redirect($url);
			}
		/*}*/
			
	}
	public function vehicle_delete()
	{
		$data=$_POST;
            
        $cate=$this->home->deleteVehicle($data);
               // print_r($res);
        echo $cate;
		
	}
	public function edit_vehicle()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		    $this->load->view('transporter/edit_vehicle');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function update_vehicle()
	{
		
		
		$data = $this->input->post();
		$this->db->select('*');
		$this->db->from('dbo.vehicle');
		$this->db->where('registration_no', $data['registration_no'] );
		$this->db->where('id' !=  $data['id'] );
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{
			$this->session->set_flashdata('item',array('message' => 'Registration Number Already Exist','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/edit_vehicle?id='.$data['id'];	
				redirect($url);
		}
		else
		{
			if($this->home->updateVehicle($data))  
			{
			    $this->session->set_flashdata('item',array('message' => 'Vehicle Updated Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/view_vehicle';
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/edit_vehicle?id='.$data['id'];	
				redirect($url);
			}
			
		}			
		
	}
	/******************** Orders *************************/
	public function pending_orders()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $result['awarded_orders'] = $this->home->get_awarded_orders();
		   $this->load->view('transporter/pending_orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function accept_order()
	{
		
		$data = $this->input->post();
		
		if($this->home->insertOrder($data))  
			{
			    $this->session->set_flashdata('item',array('message' => 'Order Accepted Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/pending_orders';
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/pending_orders';	
				redirect($url);
			} 
	}
	public function reject_order()
	{
		
		$data = $this->input->post();
		
		if($this->home->rejectOrder($data))  
			{
			    $this->session->set_flashdata('item',array('message' => 'Order rejected Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/dashboard';
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/dashboard';	
				redirect($url);
			} 
			
					
		
	}
	public function get_driver_details()
	{
		$data = $this->input->post();
		$id = $data['id'];
	 
		$this->db->select('*');
		$this->db->from('dbo.driver');
		$this->db->where('id', $id );
		$sql = $this->db->get();
 
		$datas['d'] = $sql->result();
		
		echo json_encode($datas);
	}
	public function driver_list_for_map()
	{
		$global_id = $this->session->userdata('global_id');
		$data = $this->input->post();
		$id=$data['id'];
                $this->db->select('od.order_id as order_id, d.name,d.id');
				$this->db->from('dbo.posted_sales_dispatch_order as sdo');
				$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id' , 'LEFT OUTER');
				$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
				$this->db->where('od.order_status', 'Inprocess'); 
				$this->db->where('od.shipping_status', 'Dispatched'); 
				$this->db->where('d.id', $id);
				$this->db->where('od.global_id',$global_id);
			    $list = $this->db->get()->result_array();
				
			//print_r($list);
        echo json_encode($list);
		
	}
	public function track_driver()
	{
		$data = $this->input->post();
		$id=$data['driver_id'];
	    $url = base_url().'index.php/transporter/vehicle_track?id='.$id;	
	    redirect($url);
	}
	public function track_orderss()
	{
		$data = $this->input->post();
		$id=$data['driver_id1'];
	    $url = base_url().'index.php/transporter/vehicle_track?id='.$id;	
	    redirect($url);
	}
	public function vehicle_track()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		    $this->load->view('transporter/vehicle_tracking');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function get_vehicle_details()
	{
		
		$data = $this->input->post();
		$id = $data['id'];
	 
		$this->db->select('*');
		$this->db->from('dbo.vehicle');
		$this->db->where('id', $id );
		$sql = $this->db->get();
 
		$datas['d'] = $sql->result();
		
		echo json_encode($datas);
	}
	private function set_file_upload_transporter() {   
	    
	    $config = array();
	    $config['upload_path'] = 'upload/transporter';
	    $config['allowed_types'] = '*';
	    $config['max_size']      = '5000';
	    $config['overwrite']     = FALSE;
		
	    return $config;
	}
	public function assign_order()
	{
		
		$data = $this->input->post();

		 /* $data['img_url']="";
			$this->load->library('ciqrcode');
			$qr_image=rand().'.png';
			$params['data'] = $data['order_id'];
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] ="qr_image/".$qr_image;
			
			if($this->ciqrcode->generate($params))
			{
				$data['img_url']=$qr_image;	
			}
		 */
		if($this->home->updateOrder($data))  
			{
			    $this->session->set_flashdata('item',array('message' => 'Order Assigned Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/inprocess_orders';
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'You can not update same order multiple time..please try after some time','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/pending_orders';	
				redirect($url);
			} 
			
					
		
	}
	public function chnage_details_order()
	{
		
		$data = $this->input->post();
		$order_id = $this->input->post('order_id');
		
	
		 /* $data['img_url']="";
			$this->load->library('ciqrcode');
			$qr_image=rand().'.png';
			$params['data'] = $data['order_id'];
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] ="qr_image/".$qr_image;
			
			if($this->ciqrcode->generate($params))
			{
				$data['img_url']=$qr_image;	
			}
		 */
		if($this->home->chnage_details_order($data))  
			{
			   $sender='transporter';
               $receiver='admin,driver';
               $result = $this->notification_save->save_notification_all($data['order_id'],'edit_assignment_request',$sender,$receiver);

               $sender='transporter';
               $receiver='admin,driver';
               $result = $this->sms_save->save_sms_all($data['order_id'],'edit_assignment_request',$sender,$receiver);

               $sender='transporter';
               $receiver='admin,driver';
               $result = $this->email_save->save_email_all($data['order_id'],'edit_assignment_request',$sender,$receiver);

			    $this->session->set_flashdata('item',array('message' => 'Order changed Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/inprocess_orders';
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/inprocess_orders';	
				redirect($url);
			} 
			
					
		
	}
	/**************** In Process *****************/
	public function inprocess_orders()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		     $result['inprocess_orders'] = $this->home->get_inprocess_orders();
		   $this->load->view('transporter/inprocess_orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function invoice()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/invoice');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function completed_orders()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		     $result['completed_orders'] = $this->home->get_completed_orders();
		   $this->load->view('transporter/completed_orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function dispatched_orders()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $result['dispatched_orders'] = $this->home->get_dispatched_orders();
		   $this->load->view('transporter/dispatched_orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function open_orders()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/open_orders');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	/*************** Bid Now *****************/
	public function bid_now()
	{
		
		$data = $this->input->post();
		$order_id = $data['order_id'];
		if($this->home->bidnow($data))  
		{
			$this->session->set_flashdata('item',array('message' => 'Bid Placed Successfully','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/transporter/order_overview?id='.$order_id;
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'Your Amount is grater than actual amount','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/transporter/order_overview?id='.$order_id;
			redirect($url);
		} 			
		
	}
	public function get_bidding_data()
	{
		
		$data = $this->input->post();
		/* print_r($data); */
		$id = $data['id'];
		$order_id = $data['order_id'];
	 
		$this->db->select('*');
		$this->db->from('dbo.bidding_orders');
		$this->db->where('transporter_no', $id );
		$this->db->where('order_id', $order_id );
		$sql = $this->db->get();
		/* print_r($sql); */
		$datas['d'] = $sql->result();
		
		echo json_encode($datas);
		
	}
	/****************** Update Bid ********************/
	public function update_bid()
	{
		
		$data = $this->input->post();
		$order_id = $data['order_id'];
		if($this->home->bidnow($data))  
		{
			$this->session->set_flashdata('item',array('message' => 'Bid Updated Successfully','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/transporter/order_overview?id='.$order_id;
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/transporter/order_overview?id='.$order_id;
			redirect($url);
		} 			
		
	}
	
	public function order_overview()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/order_overview');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function track_now()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/track_order');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function order_view()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/order-view');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function milestone()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/milestone');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function add_location()
	{
		$data = $this->input->post();
		if($this->home->insertLocation($data))  
		{
			$this->session->set_flashdata('item',array('message' => 'Driver Location Added Successfully','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/transporter/milestone';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/transporter/milestone';	
			redirect($url);
		} 
	}
	public function get_location_details()
	{
		$data = $this->input->post();
		$this->db->select('*');
		$this->db->from('dbo.location');
		$this->db->where('order_id',$data['order_id']);
		$query = $this->db->get()->result_array();
		echo json_encode($query);
	}
	public function settings()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $this->load->view('transporter/settings');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function change_password()
	{
		
		$data = $this->input->post();
		$this->db->select('*');
		$this->db->from('dbo.transporter');
		$this->db->where('password', $data['old_pass'] );
		$sql = $this->db->get();
		if($sql->num_rows() > 0)
		{
			
			if($data['new_password']==$data['confirm_password'])
			{
				
				if($this->home->change_password($data))  
				{
					$this->session->set_flashdata('item',array('message' => 'Change Successfully','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/transporter/settings';	
					redirect($url);
				}
				else{
					
					
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/transporter/settings';	
					redirect($url);
				
				}
			}
			else{
				$this->session->set_flashdata('item',array('message' => 'Password not matched','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/transporter/settings';	
					redirect($url);
			}
				
		}
		else
		{
		    	$this->session->set_flashdata('item',array('message' => 'Invalid Password','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/settings';	
				redirect($url);
			
				
			}			
		
	}
	public function driver_list()
	{
		 $user_id = $this->session->userdata('user_id');
		$this->db->select('*');
		$this->db->from('dbo.driver');
		$this->db->where('transporter_id',$user_id);
		$query = $this->db->get();
		$list = $query->result_array();
       
        echo json_encode($list);
	}
	public function vehicle_list()
	{
		 $user_id = $this->session->userdata('user_id');
		$this->db->select('*');
		$this->db->from('dbo.vehicle');
		$this->db->where('transporter_id',$user_id);
		$query = $this->db->get();
		$list = $query->result_array();
       
        echo json_encode($list);
	}
	public function cancel_order()
	{
		
		$data = $this->input->post();
		$reason = $this->input->post('reason');
	
		if($this->home->cancel_order($data,$reason))  
			{
				  

			    $this->session->set_flashdata('item',array('message' => 'Cancel Order Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/inprocess_orders';
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/inprocess_orders';	
				redirect($url);
			} 
			
					
		
	}
	public function otp_verify()
	{
		
		$data = $this->input->post();
		$otp = $this->input->post('otp');
	    $order_id=$data['delivered_order_id'];
		$global_id = $this->session->userdata('global_id');
	    //print_r($order_id); die;
		if($this->home->otp_verify($data,$otp))  
			{
				
				$value=array(
			      'shipping_status' => 'Delivered',
			      'order_status' => 'Completed' ,
            );
			     $result = $this->tms_users_api_model->submit_rating($order_id,$global_id);
				 $this->db->where('order_id',$order_id);
				 $query = $this->db->update('dbo.order_details',$value);
			    $this->session->set_flashdata('item',array('message' => 'Order Delivered Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/completed_orders';
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Wrong OTP','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/transporter/dashboard';	
				redirect($url);
			} 
			
					
		
	}
	public function attn_required()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		   $status='inside';
		    $attn_required = $this->home->get_attention_required_order($status);
		   $all_attn_required = $this->home->get_all_attention_required_order($status);
		   $result['attn_required']=array_merge($attn_required,$all_attn_required);
		   $this->load->view('transporter/missed_orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function get_vehicle()
	{
			$global_id = $this->session->userdata('global_id');
			$data = $this->input->post();
		    $id = $data['id'];
			$array2=array();
			$final=array();
			$array3=array();
			/* echo $id; */
			                           $this->db->select('*');
									   $this->db->from('dbo.sales_dispatched_order');
									   $this->db->where('order_id', $id );
									   $result = $this->db->get()->row();
									   $qty=$result->qty_to_ship;
									   $qty2=explode(',',$qty);
			                           $bbb=array_sum($qty2);
		    $this->db->select('DISTINCT (v.registration_no) as registration_no,v.id as id,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship,v.capacity as capacity');
			$this->db->from('dbo.order_details as d');
			$this->db->join('dbo.sales_dispatched_order as sdo', 'sdo.order_id = d.order_id');
			$this->db->join('dbo.transporter as t', 't.global_id = d.global_id');
			$this->db->join('dbo.vehicle as v', 'd.vehicle_id = v.id');
			$this->db->where("(d.shipping_status != 'Dispatched' OR d.order_status !='Completed') AND t.global_id='". $global_id."'");
			$query = $this->db->get();
			$row1 = $query->result_array();
			//print_r($row1);
			
		   
			
			   $this->db->select('*');
			   $this->db->from('dbo.settings');
			   $res = $this->db->get()->row();
			   $tolerance=$res->tolerance;

								
															   
		
			   foreach( $row1 as $value ) {
				$capacity=$value['capacity'];
				$qty1=explode(',',$value['qty_to_ship']);
				$aaa=array_sum($qty1);				   
				
				$total_capacity=$capacity+$tolerance;
				
				                  
				foreach($qty1 as $key=>$value2)
				{
				   $sum= $value2;
				}
				foreach($qty2 as $key=>$value3)
				{
				   $sum1= $value3;
				}
				
				$qty_to_ship=$aaa; //$sum
				$remaining=($total_capacity-$qty_to_ship);
				
				
			if($remaining >= $bbb)
				{
					//echo 'e';
					$json['id']=$value['id'];
					$json['registration_no']=$value['registration_no'];
					$json['rcapacity']=$remaining;
					$json['tcapacity']=$total_capacity;
					$json['status']='enabled';
					$array2[]=$json;
					
				}
				else{
					//echo 'd';
					$json['id']=$value['id'];
					$json['registration_no']=$value['registration_no'];
					//$json['capacity']=$total_capacity;
					$json['rcapacity']=$remaining;
					$json['tcapacity']=$total_capacity;
					$json['status']='disabled';
					$array2[]=$json;
					   
				}
			   }
			  // echo json_encode($array2);
			/* $this->db->select('DISTINCT (v.registration_no) as registration_no,v.id as id,v.capacity as capacity');
			$this->db->from('dbo.vehicle as v');
			$this->db->where('v.id NOT IN (select od.id from dbo.order_details as od inner join dbo.vehicle as v on v.id=od.vehicle_id)');
			$this->db->where('v.global_id', $global_id ); */
			
			$this->db->select('DISTINCT (v.registration_no) as registration_no,v.id as id ,v.capacity as capacity');
			$this->db->from('dbo.vehicle as v');
			$this->db->join('dbo.order_details as d', 'd.vehicle_id = v.id','left outer');
			$this->db->where('d.vehicle_id IS NULL');
			$this->db->where('v.global_id', $global_id );
			$query = $this->db->get();
			$res3 = $query->result_array();
			  $array=array();
			  foreach( $res3 as $value1 ) {
				
				$capacity=$value1['capacity'];
				$total_capacity=($capacity+$tolerance);
				$qty_to_ship1=explode(',',$qty);
				 
				foreach($qty_to_ship1 as $key=>$value)
				{
				   $sum3= $value;
				   //echo $qty.'<br>';
				}
				//echo $bbb;
				if($total_capacity>=$bbb ) // $sum3
				{
					$json['id']=$value1['id'];
					$json['registration_no']=$value1['registration_no'];
					$json['tcapacity']=$total_capacity;
					$json['rcapacity']=$total_capacity;
					$json['status']='enabled';
					$array[]=$json;
					
				}
				else{
					
					$json['id']=$value1['id'];
					$json['registration_no']=$value1['registration_no'];
					$json['tcapacity']=$total_capacity;
					$json['rcapacity']=$total_capacity;
					$json['status']='disabled';
					$array[]=$json;
					   
				}
		
			  }
		    $this->db->select('DISTINCT (v.registration_no) as registration_no,v.id as id,v.capacity as capacity');
			$this->db->from('dbo.order_details as d');
			$this->db->join('dbo.posted_sales_dispatch_order as sdo', 'sdo.order_id = d.order_id');
			$this->db->join('dbo.vehicle as v', 'd.vehicle_id = v.id');
			$this->db->where("(d.shipping_status = 'Dispatched' OR d.order_status ='Completed') AND v.global_id='". $global_id."' ");
			$query5 = $this->db->get();
			$row4 = $query5->result_array();
			
			
			  foreach($row4 as $value1 ) {
				
				$capacity=$value1['capacity'];
				$total_capacity=($capacity+$tolerance);
				$qty_to_ship1=explode(',',$qty);
				foreach($qty_to_ship1 as $key=>$value)
				{
				   $sum3= $value;
				   //echo $qty.'<br>';
				}
				//echo $bbb.'<br>';
				
				if($total_capacity>=$bbb ) // $sum3
				{
					$json['id']=$value1['id'];
					$json['registration_no']=$value1['registration_no'];
					$json['tcapacity']=$total_capacity;
					$json['rcapacity']=$total_capacity;
					$json['status']='enabled';
					$array3[]=$json;
					
				}
				else{
					
					$json['id']=$value1['id'];
					$json['registration_no']=$value1['registration_no'];
					$json['tcapacity']=$total_capacity;
					$json['rcapacity']=$total_capacity;
					$json['status']='disabled';
					$array3[]=$json;
					   
				}
		  
		
			  }
			  $final=array_merge($array,$array2,$array3);
			   echo json_encode($final);
			
				
	}
	public function get_driver()
	{
			$global_id = $this->session->userdata('global_id');
			$data = $this->input->post();
		    $id = $data['id'];
			$array2=array();
			$final=array();
			$array3=array();
			/* echo $id; */
			// echo $global_id; 
			
			 $this->db->select('*');
									   $this->db->from('dbo.sales_dispatched_order');
									   $this->db->where('order_id', $id );
									   $result = $this->db->get()->row();
									   $qty=$result->qty_to_ship;
									   $qty2=explode(',',$qty);
			                           $bbb=array_sum($qty2);
		    $this->db->select('DISTINCT (dr.id)as did, v.registration_no as registration_no,v.id as id,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship,v.capacity as capacity,dr.name as name,dr.mobile,dr.license_no');
			$this->db->from('dbo.order_details as d');
			$this->db->join('dbo.sales_dispatched_order as sdo', 'sdo.order_id = d.order_id');
			$this->db->join('dbo.transporter as t', 't.global_id = d.global_id and t.company=sdo.company');
			$this->db->join('dbo.vehicle as v', 'd.vehicle_id = v.id');
			$this->db->join('dbo.driver as dr', 'd.driver_id = dr.id');
			$this->db->where("(d.shipping_status != 'Dispatched' OR d.shipping_status !='Delivered') AND t.global_id='". $global_id."' ");
			$query = $this->db->get();
			$row1 = $query->result_array();
			
			   $this->db->select('*');
			   $this->db->from('dbo.settings');
			   $res = $this->db->get()->row();
			   $tolerance=$res->tolerance;
			   foreach( $row1 as $value ) {
				$qty1=explode(',',$value['qty_to_ship']);
				$capacity=$value['capacity'];
				$qty_to_ship=array_sum($qty1);				   
				$total_capacity=$capacity+$tolerance;
				
				    
				foreach($qty1 as $key=>$value2)
				{
				   $sum= $value2;
				}
				foreach($qty2 as $key=>$value3)
				{
				   $sum1= $value3;
				}
				
				//$qty_to_ship=$aaa; //$sum
				$remaining=($total_capacity-$qty_to_ship);
					if($remaining >= $bbb)
				{
					//echo 'e';
				
					$json['did']=$value['did'];
					$json['name']=$value['name'];
					$json['mobile']=$value['mobile'];
					$json['license_no']=$value['license_no'];
					$json['status']='enabled';
					$array2[]=$json;
					
				}
				else{
					//echo 'd';
				
					$json['did']=$value['did'];
					$json['name']=$value['name'];
					$json['status']='disabled';
					$array2[]=$json;
					   
				}
			   }
			     // echo json_encode($array2);
			/* $this->db->select('dr.id as did,dr.name as name');
			$this->db->from('dbo.driver as dr');
	     	$this->db->where('dr.id NOT IN (select d.id from dbo.order_details as od inner join dbo.driver as d on d.id = od.driver_id)'); 
			$this->db->where('dr.global_id', $global_id ); */
			$this->db->select('dr.name as name,dr.id as did,,dr.mobile,dr.license_no');
			$this->db->from('dbo.driver as dr');
			$this->db->join('dbo.order_details as od', 'od.driver_id = dr.id','left outer');
			$this->db->where('od.driver_id IS NULL');
			$this->db->where('dr.global_id', $global_id );
			$query1 = $this->db->get();
			$res3 = $query1->result_array();
			  $array=array();
			  foreach( $res3 as $value1 ) {
					$json['did']=$value1['did'];
					$json['name']=$value1['name'];
					$json['mobile']=$value1['mobile'];
					$json['license_no']=$value1['license_no'];
					$json['status']='enabled';
					$array[]=$json;
			} 
			$this->db->select('DISTINCT (dr.id)as did,dr.name as name,,dr.mobile,dr.license_no');
			$this->db->from('dbo.order_details as d');
			$this->db->join('dbo.posted_sales_dispatch_order as sdo', 'sdo.order_id = d.order_id');
			$this->db->join('dbo.driver as dr', 'd.driver_id = dr.id');
			$this->db->where("(d.shipping_status = 'Dispatched' OR d.shipping_status = 'Delivered') AND d.global_id='". $global_id."' ");
			$query = $this->db->get();
			$res4 = $query->result_array();
			  foreach( $res4 as $value1 ) {
					$json['did']=$value1['did'];
					$json['name']=$value1['name'];
					$json['mobile']=$value1['mobile'];
					$json['license_no']=$value1['license_no'];
					$json['status']='enabled';
					$array3[]=$json;
			}
			$final=array_merge($array,$array2,$array3);
			echo json_encode($final);												
	}
	public function update_transporter()
	{
		 $res = $this->input->post();
		// print_r($res);
		 $data = $this->update_webservice_data_model->update_transporter_update_webservice($res);	                   
	      return $data;
	}
	public function notification_seen()
	{
           $global_id = $this->session->userdata('global_id');
           $update = array('trans_seen' => '1' );
           $this->db->where("receiver_id like '%$global_id%'");
           $sql=$this->db->update('dbo.notification', $update);
    }
    public function notification()
	{
		if($this->session->userdata('user_role') == 'transporter')  
	   {
		    $result['data'] = $this->home->get_notifications();
		   $this->load->view('transporter/notification',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
 	
}
?>