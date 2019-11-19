<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Admin extends CI_Controller
{
public function __construct()
{
parent::__construct();
$this->load->helper(array('form', 'url'));
$this->load->helper('date');
$this->load->helper('file');
$this->load->library('form_validation');
$this->load->model('Model_admin','home');
$this->load->model('notification_save');
$this->load->model('sms_save');
$this->load->model('email_save');
$this->load->model('sms');
$this->load->model('send_email');
$this->load->model('update_webservice_data_model');
$this->load->database();
$this->load->library('session');
$this->load->library('Simplexml');
$this->load->library('image_lib');
$this->load->helper('cookie');
$this->load->helper('text');
$this->load->helper('url');
$this->load->library('email');
session_start();
}
	
	public function dashboard()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $sales = $this->home->get_today_dispatched_order();
		   $posted = $this->home->get_today_posted_dispatched_order();
		   $result['data']=array_merge($sales,$posted);
		  // print_r($posted);
		   $not_accept = $this->home->get_not_accepted_orders();
		   $attn_required = $this->home->get_attention_required_order();
		   $result['not_accept']=$not_accept;
		   $result['attn']=$attn_required;
		   $result['pending'] = $this->home->get_pending_dispatched_order();
		   $result['vehicle_dispatched'] = $this->home->get_todays_vehicle_dispatched();
		   $result['vehicle_arrived'] = $this->home->get_todays_vehicle_arrived();
		   $result['dispatch_planned'] = $this->home->get_todays_dispatch_planned();
		   $result['old_get_in'] = $this->home->old_get_in();
		   $result['awating_for_arrival'] = $this->home->awating_for_arrival();
		   $result['attention'] = $this->home->attention();
		   $result['get_inventory'] = $this->update_webservice_data_model->get_inventory_webservice();
		   $result['get_dispatches'] = $this->update_webservice_data_model->get_dispatches_webservice();
		   $result['open_orders'] = $this->home->get_open_orders();	
		   $result['get_bid_applied_order'] = $this->home->get_bid_applied_order();	
		   //print_r($result['get_inventory']); die; 
		   $this->load->view('admin/admin-dashboard',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	/******************* Client **********************/
	public function view_client()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['data'] = $this->home->get_customers();
		   $this->load->view('admin/view_client',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	/*************** Transporter *******************/
	public function view_transporter()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		    $result['data'] = $this->home->get_transporter();
		   $this->load->view('admin/view_transporter',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	/********************* Driver ***********************/
	public function view_driver()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['data'] = $this->home->get_driver();
		   $this->load->view('admin/view_driver',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function add_driver()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/add_driver');
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
				$url = base_url().'index.php/admin/add_driver';	
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
					$url = base_url().'index.php/admin/add_driver';	
					redirect($url);
			}
			else
			{
				if($this->home->driver_details($data))  
				{
					$this->session->set_flashdata('item',array('message' => 'Driver Added Successfully','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/add_driver';	
					redirect($url);
				}else {
					
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/add_driver';	
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
		if($this->session->userdata('user_role') == 'admin')  
	   {
		    $this->load->view('admin/edit_driver');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	
	public function update_driver()
	{
		
		$data = $this->input->post();
		$this->db->select('*');
		$this->db->from('dbo.driver');
		$this->db->where('mobile', $data['mobile'] );
		$this->db->where('id' !=  $data['id'] );
		$sql = $this->db->get();
		if($sql->num_rows() > 0)
		{
			$this->session->set_flashdata('item',array('message' => 'Mobile Number Already Exist','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/edit_driver?id='.$data['id'];	
				redirect($url);
		}
		else
		{
			$this->db->select('*');
			$this->db->from('dbo.driver');
			$this->db->where('license_no', $data['license_no'] );
			$this->db->where('id' !=  $data['id'] );
			$sql = $this->db->get();
			if($sql->num_rows() > 0)
			{
				$this->session->set_flashdata('item',array('message' => 'license Number Already Exist','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/edit_driver?id='.$data['id'];	
					redirect($url);
			}
			else
			{
				if($this->home->updateDriver($data))  
				{
					$this->session->set_flashdata('item',array('message' => 'Driver Updated Successfully','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/view_driver';
					redirect($url);
				}else {
					
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/edit_driver?id='.$data['id'];	
					redirect($url);
				}
			}
		}
					
		
	}
	/********************** Vehicle**********************/
	public function view_vehicle()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['data'] = $this->home->get_vehicle();
		   $this->load->view('admin/view_vehicle',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function add_vehicle()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/add_vehicle');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function view_scanner_user()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['data'] = $this->home->get_scanner_users();
		   $this->load->view('admin/view_scanner_user',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function add_scanner_user()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/add_scanner_user');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function edit_scanner_user()
	{
		
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/edit_scanner_user');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function save_scanner_user()
	{
		
		$data = $this->input->post();
		$this->db->select('*');
		$this->db->from('dbo.scanner_login');
		$this->db->where('mobile', $data['mobile'] );
		$sql = $this->db->get();
		if($sql->num_rows() > 0)
		{
			$this->session->set_flashdata('item',array('message' => 'Mobile Number Already Exist','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/add_scanner_user';	
				redirect($url);
		}
		else
		{
			$this->db->select('*');
			$this->db->from('dbo.scanner_login');
			$this->db->where('email', $data['email'] );
			$sql = $this->db->get();
			if($sql->num_rows() > 0)
			{
				$this->session->set_flashdata('item',array('message' => 'Email Already Exist','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/add_scanner_user';	
					redirect($url);
			}
			else
			{
				
				if($this->home->scanner_details($data))  
				{
					$this->session->set_flashdata('item',array('message' => 'Scanner Added Successfully','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/add_scanner_user';	
					redirect($url);
				}else {
					
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/add_scanner_user';	
					redirect($url);
				}
			}
		}			
		
	}
	public function update_scanner_user()
	{
		$id=$data['id'];
		$data = $this->input->post();
		$this->db->select('*');
		$this->db->from('dbo.scanner_login');
		$this->db->where('mobile', $data['mobile'] );
		$this->db->where('id' !=  $data['id'] );
		$sql = $this->db->get();
		if($sql->num_rows() > 0)
		{
			$this->session->set_flashdata('item',array('message' => 'Mobile Number Already Exist','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/edit_scanner_user';	
				redirect($url);
		}
		else
		{
			$this->db->select('*');
			$this->db->from('dbo.scanner_login');
			$this->db->where('email', $data['email'] );
			$this->db->where('id' !=  $data['id'] );
			$sql = $this->db->get();
			if($sql->num_rows() > 0)
			{
				$this->session->set_flashdata('item',array('message' => 'Email Already Exist','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/edit_scanner_user';	
					redirect($url);
			}
			else
			{
				
				if($this->home->update_scanner_user($data))  
				{
					$this->session->set_flashdata('item',array('message' => 'Scanner Update Successfully','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/view_scanner_user';	
					redirect($url);
				}else {
					
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/edit_scanner_user';	
					redirect($url);
				}
			}
		}			
		
	}
	public function scanner_user_delete()
	{
		$data=$_POST;
            
       $cate=$this->home->scanner_user_delete($data);
               // print_r($res);
       echo $cate;
		
	}
	public function save_vehicle()
	{
		
		$data = $this->input->post();
		$this->db->select('*');
		$this->db->from('dbo.vehicle');
		$this->db->where('registration_no', $data['registration_no'] );
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{
			$this->session->set_flashdata('item',array('message' => 'Registration Number Already Exist','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/add_vehicle';	
				redirect($url);
		}
		else
		{
			if($this->home->vehicle_details($data))  
			{
			    $this->session->set_flashdata('item',array('message' => 'Vehicle Added Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/add_vehicle';	
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/add_vehicle';	
				redirect($url);
			}
		}
			
	}
	public function edit_vehicle()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/edit_vehicle');
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
				$url = base_url().'index.php/admin/edit_vehicle?id='.$data['id'];	
				redirect($url);
		}
		else
		{
			if($this->home->updateVehicle($data))  
			{
			    $this->session->set_flashdata('item',array('message' => 'Vehicle Updated Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/view_vehicle';
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/edit_vehicle?id='.$data['id'];	
				redirect($url);
			}
		}	
					
		
	}
	public function vehicle_delete()
	{
		$data=$_POST;
            
       $cate=$this->home->deleteVehicle($data);
               // print_r($res);
       echo $cate;
		
	}
	/********************* Admin ***********************/
	public function view_admin()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['data'] = $this->home->get_admin();
		   $this->load->view('admin/view_admin',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function add_admin()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/add_admin');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	private function set_file_upload_admin() {   
	    
	    $config = array();
	    $config['upload_path'] = 'upload/admin_img';
	    $config['allowed_types'] = 'jpeg|jpg|png';
	    $config['max_size']      = '5000';
	    $config['overwrite']     = FALSE;
	    $config['detect_mime']     = TRUE;
	  
	    return $config;
	}
	public function save_admin()
	{
		
		$data = $this->input->post();
		$user_id = 'AD'.rand(1000, 9999);
		$this->db->select('*');
		$this->db->from('dbo.admin');
		$this->db->where('mobile', $data['mobile'] );
		$sql = $this->db->get();
		if($sql->num_rows() > 0)
		{
			$this->session->set_flashdata('item',array('message' => 'Mobile Number Already Exist','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/add_admin';	
				redirect($url);
		}
		else
		{
			$this->db->select('*');
			$this->db->from('dbo.admin');
			$this->db->where('email', $data['email'] );
			$sql = $this->db->get();
			if($sql->num_rows() > 0)
			{
				$this->session->set_flashdata('item',array('message' => 'Email Already Exist','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/add_admin';	
					redirect($url);
			}
			else
			{
				if(isset($_FILES['image'])) {  
					$config = $this->set_file_upload_admin();
					$path = $_FILES['image']['name'];
					$ext = pathinfo($path, PATHINFO_EXTENSION);
					$new_name = time().".".$ext;
					$config['file_name'] = $new_name;
					$this->upload->initialize($config);
					if(!$this->upload->do_upload('image')) {
						unset($data['image']);
						$this->session->set_flashdata('item',array('message' => 'Please upload only jpg or png files','class' => 'error'));
						$d = $this->session->flashdata('item');
						redirect(base_url().'index.php/admin/add_admin');	
					}else {
						$this->session->set_flashdata('item',array('message' => 'Uploaded Successfully','class' => 'success'));
						$upload_data = $this->upload->data();
						$data['image'] = base_url().$config['upload_path']."/".$upload_data['file_name'];
					}
				}
				if($this->home->admin_details($data,$user_id))  
				{

						 $this->db->select('*');
						 $this->db->from('dbo.email_string');
						 $this->db->where('email_type', 'add_subadmin');
						 $sql = $this->db->get()->row();
				         $subject=$sql->subject;
						 $message=$sql->message;

						 $this->db->select('*');
						 $this->db->from('dbo.sms_string');
						 $this->db->where('sms_type', 'add_subadmin');
						 $sql = $this->db->get()->row();
				         $title=$sql->title;
						 $message=$sql->message;

							$email=$data['email'];
							$password=$data['password'];
							$name=$data['name'];
							$email_message =  $message.'<br>';
							$email_message .=' User Id: '.$user_id.'<br>';
							$email_message .=' Name: '.$data['name'].'<br>';
							$email_message .=' Email: '.$data['email'].'<br>';
							$email_message .=' Password: '.$data['password'].'<br>';

					$sms_string= $message.' User Id : '.$user_id.'Name: '.$data['name'].' Email: '.$data['email'].' password: '.$data['password'];


		                $data = $this->sms->delivery_sms($data['mobile'],'','',$sms_string);
		                $data = $this->send_email->delivery_mail($email,'','',$email_message,$subject);

					$this->session->set_flashdata('item',array('message' => 'Admin Added Successfully','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/add_admin';	
					redirect($url);
				}else {
					
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/add_admin';	
					redirect($url);
				}
			}
		}			
		
	}
	public function admin_delete()
	{
		$data=$_POST;
            
       $cate=$this->home->deleteAdmin($data);
               // print_r($res);
       echo $cate;
		
	}
	public function edit_admin()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/edit_admin');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function update_admin()
	{
		
		$data = $this->input->post();
		$this->db->select('*');
		$this->db->from('dbo.admin');
		$this->db->where('mobile', $data['mobile'] );
		$this->db->where('id' != $data['id'] );
		$sql = $this->db->get();
		if($sql->num_rows() > 0)
		{
			$this->session->set_flashdata('item',array('message' => 'Mobile Number Already Exist','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/edit_admin?id='.$data['id'];
				redirect($url);
		}
		else
		{
			$this->db->select('*');
			$this->db->from('dbo.admin');
			$this->db->where('email', $data['email'] );
			$this->db->where('id' != $data['id'] );
			$sql = $this->db->get();
			if($sql->num_rows() > 0)
			{
				$this->session->set_flashdata('item',array('message' => 'Email Already Exist','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/edit_admin?id='.$data['id'];
					redirect($url);
			}
			else
			{
				if(!empty($_FILES['image']['name']))
				{
					if(isset($_FILES['image'])) {  
						$config = $this->set_file_upload_admin();
						$path = $_FILES['image']['name'];
						$ext = pathinfo($path, PATHINFO_EXTENSION);
						$new_name = time().".".$ext;
						$config['file_name'] = $new_name;
						$this->upload->initialize($config);
						if(!$this->upload->do_upload('image')) {
							unset($data['image']);
							$this->session->set_flashdata('item',array('message' => 'Please upload only jpg or png files','class' => 'error'));
							$d = $this->session->flashdata('item');
							redirect(base_url().'index.php/admin/edit_admin?id='.$data['id']);
						}else {
							$this->session->set_flashdata('item',array('message' => 'Uploaded Successfully','class' => 'success'));
							$upload_data = $this->upload->data();
							$data['image'] = base_url().$config['upload_path']."/".$upload_data['file_name'];
						}
					}
				}
				else
				{
					$data['image'] = '';
				}
				if($this->home->updateAdmin($data))  
				{
					$this->session->set_flashdata('item',array('message' => 'Details Updated Successfully','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/edit_admin?id='.$data['id'];	
					redirect($url);
				}else {
					
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/edit_admin?id='.$data['id'];
					redirect($url);
				}
			}
		}			
		
	}
	/******************** Orders *************************/
	public function completed_orders()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		    $result['data'] = $this->home->get_dispatched_orders();
			//print_r($result); die;
		   $this->load->view('admin/completed_orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function todays_dispatch()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		  $sales = $this->home->get_today_dispatched_order();
		   $posted = $this->home->get_today_posted_dispatched_order();
		    $result['data']=array_merge($sales,$posted);
		   $this->load->view('admin/todays_dispatch',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function pending_dispatches()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['pending'] = $this->home->get_pending_dispatched_order();
		   $this->load->view('admin/pending_dispatches',$result);
	   }
	    else   
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function not_accepted_orders()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['all_not_accept'] = $this->home->get_not_accepted_orders();
		   $this->load->view('admin/not_accepted_orders',$result);
	   }
	    else   
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function live_bidding()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['get_open_orders'] = $this->home->get_open_orders();
		   $this->load->view('admin/open_orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function get_bid_applied_order()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['get_bid_applied_order'] = $this->home->get_bid_applied_order();
		   $this->load->view('admin/bid_applied_order',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function attn_required()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		    $result['attn_required'] = $this->home->get_attention_required_order();
		   $this->load->view('admin/attn_required',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function transporter_list()
	{
		$data = $this->input->post();
		$com=$data['company'];
         //echo "<script>alert('".$com."')</script>";
			/* $this->db->select('DISTINCT(t.global_id) as global_id,t.name as name');
			$this->db->from('dbo.transporter as t');
			$this->db->where('t.company',$com);
			$this->db->where('t.name!=',''); */
			$query = $this->db->query("SELECT t.global_id as global_id,t.name as name,t.user_id as user_id,t.state_code as state_code FROM transporter AS t WHERE t.company = '".$com."' AND t.name!=''");
			
			$list = $query->result_array();


       
        echo json_encode($list);
		
	}
	public function driver_list()
	{
		$data = $this->input->post();
		$id=$data['id'];
		//print_r($id);
                $this->db->select('od.order_id as order_id, d.name,d.id');
				$this->db->from('dbo.posted_sales_dispatch_order as sdo');
				$this->db->join('dbo.order_details as od','sdo.order_id = od.order_id' , 'LEFT OUTER');
				$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
				$this->db->where('od.order_status', 'Inprocess'); 
				$this->db->where('od.shipping_status', 'Dispatched'); 
				$this->db->where('d.id', $id);
			    $list = $this->db->get()->result_array();
			//print_r($list);
        echo json_encode($list);
		
	}
	public function get_driver_list()
	{

                $this->db->select('od.order_id as order_id, d.name,d.id');
				$this->db->from('dbo.order_details as od');
				$this->db->join('dbo.driver as d','d.id = od.driver_id' , 'LEFT OUTER');
				$this->db->where('od.order_status', 'Inprocess'); 
				$this->db->where('od.shipping_status', 'Dispatched'); 
			    $list = $this->db->get()->result_array();
			//print_r($list);
        echo json_encode($list);
		
	}
	public function track_driver()
	{
		$data = $this->input->post();
		$id=$data['driver_id'];
	    $url = base_url().'index.php/admin/vehicle_track?id='.$id;	
	    redirect($url);
	}
	public function track_orderss()
	{
		$data = $this->input->post();
		$id=$data['driver_id1'];
	    $url = base_url().'index.php/admin/vehicle_track?id='.$id;	
	    redirect($url);
	}
	public function update_order_details()
	{
		$data = $this->input->post();
		if($this->home->update_order_details($data))
		{
			$this->session->set_flashdata('item',array('message' => 'Order Details Successfully Updated!!','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/dashboard';	
			redirect($url);
		}
		else
		{
			$this->session->set_flashdata('item',array('message' => 'You can not update same order multiple time..please try after some time !!','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/dashboard';	
			redirect($url);
		}
	}
	public function update_order_detail()
	{
		$data = $this->input->post();
		if($this->home->update_order_details($data))
		{
			   $sender='admin';
               $receiver='transporter';
               $result = $this->notification_save->save_notification_all($order_id,'order_assigned_to_vendor_attn',$sender,$receiver);

               $sender='admin';
               $receiver='transporter';
               $result = $this->sms_save->save_sms_all($order_id,'order_assigned_to_vendor_attn',$sender,$receiver);

               $sender='admin';
               $receiver='transporter';
               $result = $this->email_save->save_email_all($order_id,'order_assigned_to_vendor_attn',$sender,$receiver);

			$this->session->set_flashdata('item',array('message' => 'Order Details Successfully Updated!!','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/attn_required';	
			redirect($url);
		}
		else
		{
			$this->session->set_flashdata('item',array('message' => 'You can not update same order multiple time..please try after some time!!','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/attn_required';	
			redirect($url);
		}
	}
	
	public function track_now()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/track_order');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	/************** Order Full view ********************/
	public function order_view()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/order_view');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function order_overview()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/order_overview');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	/******************* Invoice *********************/
	public function invoice()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $this->load->view('admin/invoice');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	/******************* Appreciation ***********************/
	public function milestone()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $data['data']=$this->home->get_milestone();
		   $this->load->view('admin/milestone',$data);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function approve_milestone()
	{
		  $id      = $this->input->post('order_id');
		  $amount      = $this->input->post('amount');
		  $driver_id      = $this->input->post('driver_id');
		//  print_r( $id);
		//  print_r( $amount);
		//  print_r( $driver_id);
		  //die;
		    $this->db->select('*');
			$this->db->from('dbo.driver');
			$this->db->where('id', $driver_id );
			$query = $this->db->get();
			$row = $query->row();
			$wallet = $row->wallet_amount;
			$total=($wallet+$amount);
		  $update=array(
		  'Approvel_status' => 'Approved',
		  'Approvel_date' => date('Y-m-d H:i:s'),
		  );
		 	$this->db->where('order_id', $id);
			$result = $this->db->update('dbo.milestone',$update);
			if($result)
			{
				 $update=array(
		        'wallet_amount' => $total,
		         );
		 	    $this->db->where('id', $driver_id);
			    $query = $this->db->update('dbo.driver',$update);


			   
               $sender='admin';
               $receiver='transporter,driver';
               $result = $this->notification_save->save_notification_all($order_id,'appreciation_approved',$sender,$receiver);
               $sender='admin';
               $receiver='transporter,driver';
               $result = $this->sms_save->save_sms_all($order_id,'appreciation_approved',$sender,$receiver);

               $sender='admin';
               $receiver='transporter,driver';
               $result = $this->email_save->save_email_all($order_id,'appreciation_approved',$sender,$receiver);

				 $this->session->set_flashdata('item',array('message' => 'Approved Successfully ','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/milestone';
					redirect($url);  
			}
			else{
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/milestone';	
					redirect($url); 
			} 

	}
	public function wallet()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $data['data']=$this->home->get_driver_wallet();
		   $this->load->view('admin/driver_wallet',$data);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');
	   }  
	} 
	/****************** Settings **********************/
	public function settings()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $data['data']=$this->home->get_reject_reason();
		   $this->load->view('admin/settings',$data);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function allowance_setting()
	{
		$data = $this->input->post();
		
		if($this->home->allowance_settings($data))  
		{
			$this->session->set_flashdata('item',array('message' => 'Allowance Settings Successfully Saved','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/settings';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/settings';	
			redirect($url);
		} 
	}
	public function tolerance()
	{
		$data = $this->input->post();
		
		if($this->home->tolerance($data))  
		{
			$this->session->set_flashdata('item',array('message' => 'Successfully Saved','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/settings';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/settings';	
			redirect($url);
		} 
	}
	public function add_reject_reason()
	{
		  $id      = $this->input->post('id');
		  $reject_reason      = $this->input->post('reject_reason');
		  $add=array(
		  
		  'reject_reason' => $reject_reason,
		  
		  );
		 $result = $this->db->insert('dbo.reject_reason',$add);
			if($result)
			{
				 $this->session->set_flashdata('item',array('message' => 'Add Successfully ','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/settings';
					redirect($url);  
			}
			else{
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/settings';	
					redirect($url); 
			} 

	}
	public function delete_reason()
	{
		  $id      = $this->input->post('id');
		  $this->db->where('id', $id);
          $result = $this->db->delete('dbo.reject_reason'); 
			if($result)
			{
				  $this->session->set_flashdata('item',array('message' => 'Delete Successfully ','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/settings';
					redirect($url);   
			}
			else{
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/settings';	
					redirect($url);   
			} 

	}
	public function change_password()
	{
		
		$data = $this->input->post();
		$this->db->select('*');
		$this->db->from('dbo.admin');
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
					$url = base_url().'index.php/admin/settings';	
					redirect($url);
				}
				else{
					
					
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/settings';	
					redirect($url);
				
				}
			}
			else{
				$this->session->set_flashdata('item',array('message' => 'Password not matched','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/settings';	
					redirect($url);
			}
				
		}
		else
		{
		    	$this->session->set_flashdata('item',array('message' => 'Invalid Password','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/settings';	
				redirect($url);
			
				
			}			
		
	}
	public function add_time_and_rate()
	{
		
		$data = $this->input->post();
	//	print_r($data); die;
		
			if($this->home->add_time_and_rate($data))  
			{
			    $this->session->set_flashdata('item',array('message' => 'Added Successfully','class' => 'success'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/settings';	
				redirect($url);
			}else {
				
				$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
				$d = $this->session->flashdata('item');
				$url = base_url().'index.php/admin/settings';	
				redirect($url);
			}
	
			
	}
	public function approvel_orders()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['data'] = $this->home->get_approvel_orders();
		   $this->load->view('admin/approvel_orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function reject_order()
	{
		$data = $this->input->post();
		
		if($this->home->reject_order($data))  
		{
			   $sender='admin';
               $receiver='transporter,driver';
               $result = $this->notification_save->save_notification_all($order_id,'edit_Request_rejected',$sender,$receiver);
              /* $sender='admin';
               $receiver='transporter,driver';
               $result = $this->sms_save->save_sms_all($order_id,'order_cancelletion',$sender,$receiver);*/

               $sender='admin';
               $receiver='transporter,driver';
               $result = $this->email_save->save_email_all($order_id,'edit_Request_rejected',$sender,$receiver);

			$this->session->set_flashdata('item',array('message' => 'Reject Order Successfully Saved','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/approvel_orders';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/approvel_orders';	
			redirect($url);
		} 
	}
	public function accept_order()
	{
		$data = $this->input->post();
		
		if($this->home->accept_order($data))  
		{
			   $sender='admin';
               $receiver='transporter,driver';
               $result = $this->notification_save->save_notification_all($order_id,'edit_request_approved',$sender,$receiver);
              /* $sender='admin';
               $receiver='transporter,driver';
               $result = $this->sms_save->save_sms_all($order_id,'order_cancelletion',$sender,$receiver);*/

               $sender='admin';
               $receiver='transporter,driver';
               $result = $this->email_save->save_email_all($order_id,'edit_request_approved',$sender,$receiver);

			$this->session->set_flashdata('item',array('message' => 'Approved Order Successfully Saved','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/approvel_orders';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'You can not update same order multiple time..please try after some time','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/approvel_orders';	
			redirect($url);
		} 
	}
	
	public function cancel_order()
	{
		$data = $this->input->post();
		
		if($this->home->cancel_order($data))  
		{
			   $sender='admin';
               $receiver='transporter,driver';
               $result = $this->notification_save->save_notification_all($order_id,'order_cancelletion',$sender,$receiver);
               $sender='admin';
               $receiver='transporter,driver';
               $result = $this->sms_save->save_sms_all($order_id,'order_cancelletion',$sender,$receiver);
               
               $sender='admin';
               $receiver='transporter,driver';
               $result = $this->email_save->save_email_all($order_id,'order_cancelletion',$sender,$receiver);


			$this->session->set_flashdata('item',array('message' => 'cancel Order Successfully','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/dashboard';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'You can not update same order multiple time..please try after some time','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/dashboard';	
			redirect($url);
		} 
	}
	public function cancel_orders()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['data'] = $this->home->cancel_orders();
		   $this->load->view('admin/cancel_orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function trans_cancel_approvel()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $result['data'] = $this->home->trans_cancel_approvel();

		   $this->load->view('admin/trans_cancel_approvel',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function cancel_reject_order()
	{
		$data = $this->input->post();
		
		if($this->home->cancel_reject_order($data))  
		{
			$sender='admin';
               $receiver='transporter,driver';
               $result = $this->notification_save->save_notification_all($order_id,'cancelletion_request_rejected',$sender,$receiver);
              /* $sender='admin';
               $receiver='transporter,driver';
               $result = $this->sms_save->save_sms_all($order_id,'cancelletion_request_rejected',$sender,$receiver);*/

               $sender='admin';
               $receiver='transporter,driver';
               $result = $this->email_save->save_email_all($order_id,'cancelletion_request_rejected',$sender,$receiver);


			$this->session->set_flashdata('item',array('message' => 'Reject Order Successfully','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/trans_cancel_approvel';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/trans_cancel_approvel';	
			redirect($url);
		} 
	}
	public function cancel_accept_order()
	{
		$data = $this->input->post();
		
		if($this->home->cancel_accept_order($data))  
		{
			   $sender='admin';
               $receiver='transporter,driver';
               $result = $this->notification_save->save_notification_all($order_id,'cancelleation_request_approved',$sender,$receiver); 
               /*$sender='admin';
               $receiver='transporter,driver';
               $result = $this->sms_save->save_sms_all($order_id,'cancelleation_request_approved',$sender,$receiver);*/

               $sender='admin';
               $receiver='transporter,driver';
               $result = $this->email_save->save_email_all($order_id,'cancelleation_request_approved',$sender,$receiver);

			$this->session->set_flashdata('item',array('message' => 'Canceled Order Successfully','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/trans_cancel_approvel';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'You can not update same order multiple time..please try after some time','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/trans_cancel_approvel';	
			redirect($url);
		} 
	}
	public function missed_orders()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		    $get_missed_order = $this->home->get_missed_order();
		    $get_missed_order_post = $this->home->get_missed_order_post();
			$result['attn_required']=array_merge($get_missed_order, $get_missed_order_post);
		    $this->load->view('admin/missed_orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function vehicle_track()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		    $this->load->view('admin/vehicle_tracking');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function open_for_bid_order()
	{
		 $res = $this->input->post();
		$data = $this->update_webservice_data_model->open_for_bid_order_update_webservice($res);	                   
	  if($data)
	  {
		  	$this->session->set_flashdata('item',array('message' => 'Open For Bid Successfully','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/dashboard';
			redirect($url);	

	  }else
	  {
	  	  $this->session->set_flashdata('item',array('message' => 'Some thing Went Wrong','class' => 'error'));
		  $d = $this->session->flashdata('item');
		  $url = base_url().'index.php/admin/dashboard';	
		  redirect($url);
	  }
                    			
	}
	public function rating()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $global_id = $_GET['id'];
		   $data['data']=$this->home->get_rating($global_id);
		   $data['rating']=$this->home->get_tans_rating($global_id);
		   $this->load->view('admin/rating',$data);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function all_rating()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		  // $global_id = $_GET['id'];
		  // $data['data']=$this->home->get_rating($global_id);
		   $this->load->view('admin/all_trans_rating');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function get_all_rating_order_id()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   $data = $this->input->post();
		   $global_id = $data['global_id'];
		  // echo $global_id;
		   $data=$this->home->get_rating($global_id);
		   //$data['rating']=$this->home->get_tans_rating($global_id);
		  // $this->load->view('admin/all_trans_rating',$data);
		    echo json_encode($data);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function get_all_rating_data()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		   
	    $this->db->select('*');
		$this->db->from('dbo.transporter'); 
		$list = $this->db->get()->result_array();
		 
		    echo json_encode($list);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function noti_sms_email()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {

        $this->db->select('*');
		$this->db->from('dbo.notification_string');
		$sql = $this->db->get()->result_array();
		foreach ($sql as $key => $value) {
		
		if($value['noti_type']=='order_accept')
		{
			$data['accept_order_title']=$value['title'];
			$data['accept_order_message']=$value['message'];
		}
		if($value['noti_type']=='order_decline')
		{
			$data['decline_order_title']=$value['title'];
			$data['decline_order_message']=$value['message'];
		}
		if($value['noti_type']=='order_assign')
		{
			$data['assign_order_title']=$value['title'];
			$data['assign_order_message']=$value['message'];
		}
		if($value['noti_type']=='gate_in')
		{
			$data['gate_in_order_title']=$value['title'];
			$data['gate_in_order_message']=$value['message'];
		}
		if($value['noti_type']=='gate_out')
		{
			$data['gate_out_order_title']=$value['title'];
			$data['gate_out_order_message']=$value['message'];
		}
		if($value['noti_type']=='loading_in')
		{
			$data['loading_in_order_title']=$value['title'];
			$data['loading_in_order_message']=$value['message'];
		}
		if($value['noti_type']=='loading_out')
		{
			$data['loading_out_order_title']=$value['title'];
			$data['loading_out_order_message']=$value['message'];
		}
		if($value['noti_type']=='weight_in')
		{
			$data['weight_in_order_title']=$value['title'];
			$data['weight_in_order_message']=$value['message'];
		}
		if($value['noti_type']=='weight_out')
		{
			$data['weight_out_order_title']=$value['title'];
			$data['weight_out_order_message']=$value['message'];
		}
		if($value['noti_type']=='dispatched')
		{
			$data['dispatched_order_title']=$value['title'];
			$data['dispatched_order_message']=$value['message'];
		}
		if($value['noti_type']=='delivered')
		{
			$data['delivered_order_title']=$value['title'];
			$data['delivered_order_message']=$value['message'];
		}
		if($value['noti_type']=='order_not_accept')
		{
			$data['order_not_accept_title']=$value['title'];
			$data['order_not_accept_message']=$value['message'];
		}
		if($value['noti_type']=='order_not_assign')
		{
			$data['order_not_assign_title']=$value['title'];
			$data['order_not_assign_message']=$value['message'];
		}
		if($value['noti_type']=='cancel_assignment_request')
		{
			$data['cancel_assignment_request_title']=$value['title'];
			$data['cancel_assignment_request_message']=$value['message'];
		}
		if($value['noti_type']=='edit_assignment_request')
		{
			$data['edit_assignment_request_title']=$value['title'];
			$data['edit_assignment_request_message']=$value['message'];
		}
		if($value['noti_type']=='cancelleation_request_approved')
		{
			$data['cancelleation_request_approved_title']=$value['title'];
			$data['cancelleation_request_approved_message']=$value['message'];
		}
		if($value['noti_type']=='edit_request_approved')
		{
			$data['edit_request_approved_title']=$value['title'];
			$data['edit_request_approved_message']=$value['message'];
		}
		if($value['noti_type']=='cancelletion_request_rejected')
		{
			$data['cancelletion_request_rejected_title']=$value['title'];
			$data['cancelletion_request_rejected_message']=$value['message'];
		}
		if($value['noti_type']=='edit_Request_rejected')
		{
			$data['edit_Request_rejected_title']=$value['title'];
			$data['edit_Request_rejected_message']=$value['message'];
		}
		if($value['noti_type']=='order_assigned_to_vendor_attn')
		{
			$data['order_assigned_to_vendor_attn_title']=$value['title'];
			$data['order_assigned_to_vendor_attn_message']=$value['message'];
		}
		if($value['noti_type']=='appreciation_approved')
		{
			$data['appreciation_approved_title']=$value['title'];
			$data['appreciation_approved_message']=$value['message'];
		}
		if($value['noti_type']=='order_cancelletion')
		{
			$data['order_cancelletion_title']=$value['title'];
			$data['order_cancelletion_message']=$value['message'];
		}
		if($value['noti_type']=='mliestone')
		{
			$data['mliestone_title']=$value['title'];
			$data['mliestone_message']=$value['message'];
		}
		if($value['noti_type']=='no_bidding_place')
		{
			$data['no_bidding_place_title']=$value['title'];
			$data['no_bidding_place_message']=$value['message'];
		}
		if($value['noti_type']=='assign_order_transporter')
		{
			$data['assign_order_transporter_title']=$value['title'];
			$data['assign_order_transporter_message']=$value['message'];
		}

		  
	   }
	    $this->db->select('*');
		$this->db->from('dbo.sms_string');
		$sql = $this->db->get()->result_array();
		foreach ($sql as $key => $value) {
		
		if($value['sms_type']=='order_accept')
		{
			$data['s_accept_order_title']=$value['title'];
			$data['s_accept_order_message']=$value['message'];
		}
		if($value['sms_type']=='order_decline')
		{
			$data['s_decline_order_title']=$value['title'];
			$data['s_decline_order_message']=$value['message'];
		}
		if($value['sms_type']=='order_assign')
		{
			$data['s_assign_order_title']=$value['title'];
			$data['s_assign_order_message']=$value['message'];
		}
		if($value['sms_type']=='edit_assignment_request')
		{
			$data['s_edit_assignment_request_title']=$value['title'];
			$data['s_edit_assignment_request_message']=$value['message'];
		}
		if($value['sms_type']=='cancel_assignment_request')
		{
			$data['s_cancel_assignment_request_title']=$value['title'];
			$data['s_cancel_assignment_request_message']=$value['message'];
		}
		
		if($value['sms_type']=='dispatched')
		{
			$data['s_dispatched_order_title']=$value['title'];
			$data['s_dispatched_order_message']=$value['message'];
		}
		if($value['sms_type']=='delivered')
		{
			$data['s_delivered_order_title']=$value['title'];
			$data['s_delivered_order_message']=$value['message'];
		}
		if($value['sms_type']=='order_assigned_to_vendor_attn')
		{
			$data['s_order_assigned_to_vendor_attn_title']=$value['title'];
			$data['s_order_assigned_to_vendor_attn_message']=$value['message'];
		}
		if($value['sms_type']=='appreciation_approved')
		{
			$data['s_appreciation_approved_title']=$value['title'];
			$data['s_appreciation_approved_message']=$value['message'];
		}
		if($value['sms_type']=='order_cancelletion')
		{
			$data['s_order_cancelletion_title']=$value['title'];
			$data['s_order_cancelletion_message']=$value['message'];
		}
		if($value['sms_type']=='add_transporter')
		{
			$data['s_add_transporter_title']=$value['title'];
			$data['s_add_transporter_message']=$value['message'];
		}
		if($value['sms_type']=='add_customer')
		{
			$data['s_add_customer_title']=$value['title'];
			$data['s_add_customer_message']=$value['message'];
		}
		if($value['sms_type']=='add_subadmin')
		{
			$data['s_add_subadmin_title']=$value['title'];
			$data['s_add_subadmin_message']=$value['message'];
		}
		if($value['sms_type']=='add_driver')
		{
			$data['s_add_driver_title']=$value['title'];
			$data['s_add_driver_message']=$value['message'];
		}

		  
	   }
	   $this->db->select('*');
		$this->db->from('dbo.email_string');
		$sql = $this->db->get()->result_array();
		foreach ($sql as $key => $value) {
		
		if($value['email_type']=='order_accept')
		{
			$data['e_accept_order_subject']=$value['subject'];
			$data['e_accept_order_message']=$value['message'];
		}
		if($value['email_type']=='order_decline')
		{
			$data['e_decline_order_subject']=$value['subject'];
			$data['e_decline_order_message']=$value['message'];
		}
		if($value['email_type']=='order_assign')
		{
			$data['e_assign_order_subject']=$value['subject'];
			$data['e_assign_order_message']=$value['message'];
		}
		if($value['email_type']=='gate_in')
		{
			$data['e_gate_in_order_subject']=$value['subject'];
			$data['e_gate_in_order_message']=$value['message'];
		}
		if($value['email_type']=='gate_out')
		{
			$data['e_gate_out_order_subject']=$value['subject'];
			$data['e_gate_out_order_message']=$value['message'];
		}
		if($value['email_type']=='loading_in')
		{
			$data['e_loading_in_order_subject']=$value['subject'];
			$data['e_loading_in_order_message']=$value['message'];
		}
		if($value['email_type']=='loading_out')
		{
			$data['e_loading_out_order_subject']=$value['subject'];
			$data['e_loading_out_order_message']=$value['message'];
		}
		if($value['email_type']=='weight_in')
		{
			$data['e_weight_in_order_subject']=$value['subject'];
			$data['e_weight_in_order_message']=$value['message'];
		}
		if($value['email_type']=='weight_out')
		{
			$data['e_weight_out_order_subject']=$value['subject'];
			$data['e_weight_out_order_message']=$value['message'];
		}
		if($value['email_type']=='dispatched')
		{
			$data['e_dispatched_order_subject']=$value['subject'];
			$data['e_dispatched_order_message']=$value['message'];
		}
		if($value['email_type']=='delivered')
		{
			$data['e_delivered_order_subject']=$value['subject'];
			$data['e_delivered_order_message']=$value['message'];
		}
		if($value['email_type']=='order_not_accept')
		{
			$data['e_order_not_accept_subject']=$value['subject'];
			$data['e_order_not_accept_message']=$value['message'];
		}
		if($value['email_type']=='order_not_assign')
		{
			$data['e_order_not_assign_subject']=$value['subject'];
			$data['e_order_not_assign_message']=$value['message'];
		}
		if($value['email_type']=='cancel_assignment_request')
		{
			$data['e_cancel_assignment_request_subject']=$value['subject'];
			$data['e_cancel_assignment_request_message']=$value['message'];
		}
		if($value['email_type']=='edit_assignment_request')
		{
			$data['e_edit_assignment_request_subject']=$value['subject'];
			$data['e_edit_assignment_request_message']=$value['message'];
		}
		if($value['email_type']=='cancelleation_request_approved')
		{
			$data['e_cancelleation_request_approved_subject']=$value['subject'];
			$data['e_cancelleation_request_approved_message']=$value['message'];
		}
		if($value['email_type']=='edit_request_approved')
		{
			$data['e_edit_request_approved_subject']=$value['subject'];
			$data['e_edit_request_approved_message']=$value['message'];
		}
		if($value['email_type']=='cancelletion_request_rejected')
		{
			$data['e_cancelletion_equest_rejected_subject']=$value['subject'];
			$data['e_cancelletion_equest_rejected_message']=$value['message'];
		}
		if($value['email_type']=='edit_Request_rejected')
		{
			$data['e_edit_Request_rejected_subject']=$value['subject'];
			$data['e_edit_Request_rejected_message']=$value['message'];
		}
		if($value['email_type']=='order_assigned_to_vendor_attn')
		{
			$data['e_order_assigned_to_vendor_attn_subject']=$value['subject'];
			$data['e_order_assigned_to_vendor_attn_message']=$value['message'];
		}
		if($value['email_type']=='appreciation_approved')
		{
			$data['e_appreciation_approved_subject']=$value['subject'];
			$data['e_appreciation_approved_message']=$value['message'];
		}
		if($value['email_type']=='order_cancelletion')
		{
			$data['e_order_cancelletion_subject']=$value['subject'];
			$data['e_order_cancelletion_message']=$value['message'];
		}
        if($value['email_type']=='mliestone')
		{
			$data['e_mliestone_subject']=$value['subject'];
			$data['e_mliestone_message']=$value['message'];
		}
		if($value['email_type']=='assign_order_transporter')
		{
			$data['e_assign_order_transporter_subject']=$value['subject'];
			$data['e_assign_order_transporter_message']=$value['message'];
		}
		if($value['email_type']=='add_transporter')
		{
			$data['e_add_transporter_subject']=$value['subject'];
			$data['e_add_transporter_message']=$value['message'];
		}
		if($value['email_type']=='add_customer')
		{
			$data['e_add_customer_subject']=$value['subject'];
			$data['e_add_customer_message']=$value['message'];
		}
		if($value['email_type']=='add_subadmin')
		{
			$data['e_add_subadmin_subject']=$value['subject'];
			$data['e_add_subadmin_message']=$value['message'];
		}
			if($value['email_type']=='add_driver')
		{
			$data['e_add_driver_subject']=$value['subject'];
			$data['e_add_driver_message']=$value['message'];
		}
		  
	   }

	    $this->load->view('admin/noti_sms_email',$data);
	}
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
      public function save_noti_string()
	{
		 $data = $this->input->post();
         $this->db->select('*');
		 $this->db->from('dbo.notification_string');
		 $sql = $this->db->get()->result_array();
		/* print_r($sql);
		 die;*/
		 $type=array();
		 if($sql)
		 {
			foreach ($sql as $key => $value) {
				$type[]=$value['noti_type'];
			}
				
			if(in_array($data['type'], $type))
			{
				$update=array(
			   'title' => $data['title'],
	           'message' => $data['message'],
	           'noti_type' => $data['type'],
			  );
			 	$this->db->where('noti_type',$data['type'] );
				$result = $this->db->update('dbo.notification_string',$update);
			}
			else
			{
				
			$add=array(
	         'title' => $data['title'],
	         'message' => $data['message'],
	         'noti_type' => $data['type'],
			);
			 $result = $this->db->insert('dbo.notification_string',$add);
			}
	}
	else
	{
      	$add=array(
         'title' => $data['title'],
         'message' => $data['message'],
         'noti_type' => $data['type'],
		);
		 $result = $this->db->insert('dbo.notification_string',$add);
	}
		if($result)  
		{
			$this->session->set_flashdata('item',array('message' => 'Saved Successfully Saved','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/noti_sms_email';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'error','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/noti_sms_email';	
			redirect($url);
		} 
	}

	
   public function save_sms_string()
	{
		 $data = $this->input->post();
         $this->db->select('*');
		 $this->db->from('dbo.sms_string');
		 $sql = $this->db->get()->result_array();
		/* print_r($sql);
		 die;*/
		 $type=array();
		 if($sql)
		 {
			foreach ($sql as $key => $value) {
				$type[]=$value['sms_type'];
			}
				
			if(in_array($data['type'], $type))
			{
				$update=array(
			   'title' => $data['title'],
	           'message' => $data['message'],
	           'sms_type' => $data['type'],
			  );
			 	$this->db->where('sms_type',$data['type'] );
				$result = $this->db->update('dbo.sms_string',$update);
			}
			else
			{
				
			$add=array(
	         'title' => $data['title'],
	         'message' => $data['message'],
	         'sms_type' => $data['type'],
			);
			 $result = $this->db->insert('dbo.sms_string',$add);
			}
	}
	else
	{
      	$add=array(
         'title' => $data['title'],
         'message' => $data['message'],
         'sms_type' => $data['type'],
		);
		 $result = $this->db->insert('dbo.sms_string',$add);
	}
		if($result)  
		{
			$this->session->set_flashdata('item',array('message' => 'Saved Successfully Saved','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/noti_sms_email';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'error','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/noti_sms_email';	
			redirect($url);
		} 
	}
  public function save_email_string()
	{
		 $data = $this->input->post();
         $this->db->select('*');
		 $this->db->from('dbo.email_string');
		 $sql = $this->db->get()->result_array();
		/* print_r($sql);
		 die;*/
		 $type=array();
		 if($sql)
		 {
			foreach ($sql as $key => $value) {
				$type[]=$value['email_type'];
			}
				
			if(in_array($data['type'], $type))
			{
				$update=array(
			   'subject' => $data['subject'],
	           'message' => $data['message'],
	           'email_type' => $data['type'],
			  );
			 	$this->db->where('email_type',$data['type'] );
				$result = $this->db->update('dbo.email_string',$update);
			}
			else
			{
				
			$add=array(
	         'subject' => $data['subject'],
	         'message' => $data['message'],
	         'email_type' => $data['type'],
			);
			 $result = $this->db->insert('dbo.email_string',$add);
			}
	}
	else
	{
      	$add=array(
         'subject' => $data['subject'],
         'message' => $data['message'],
         'email_type' => $data['type'],
		);
		 $result = $this->db->insert('dbo.email_string',$add);
	}
		if($result)  
		{
			$this->session->set_flashdata('item',array('message' => 'Saved Successfully','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/noti_sms_email';
			redirect($url);
		}else {
			
			$this->session->set_flashdata('item',array('message' => 'error','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/noti_sms_email';	
			redirect($url);
		} 
	}

	public function help()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
	    $this->db->select('*');
		 $this->db->from('dbo.help');
		 $sql = $this->db->get()->row();
		 $data['trans']=$sql->trans_help_message;
		  $data['cust']=$sql->cust_help_message; 
		   $data['driver']=$sql->driver_help_message;
		  // $global_id = $_GET['id'];
		  // $data['data']=$this->home->get_rating($global_id);
		   $this->load->view('admin/help',$data);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}

	public function save_help_details()
	{
		$data = $this->input->post();

		if($data['type']=='customer')
		{
         $value=array(
            
            'cust_help_message' => $data['details'],

         );
		}
		if($data['type']=='driver')
		{
           $value=array(
            
            'driver_help_message' => $data['details'],

         );
		}
		if($data['type']=='transporter')
		{
           $value=array(
            
            'trans_help_message' => $data['details'],

         );
		}
         $this->db->select('*');
		 $this->db->from('dbo.help');
		 $sql = $this->db->get()->row();
		 if($sql)
		 {
		 	$this->db->where('id',$sql->id);
            $result = $this->db->update('dbo.help',$value);
		 }
		 else
		 {
              $result = $this->db->insert('dbo.help',$value);
		 }

		if($result)
		{
			$this->session->set_flashdata('item',array('message' => 'Successfully Updated!!','class' => 'success'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/help';	
			redirect($url);
		}
		else
		{
			$this->session->set_flashdata('item',array('message' => 'error','class' => 'error'));
			$d = $this->session->flashdata('item');
			$url = base_url().'index.php/admin/help';	
			redirect($url);
		}
	}
	public function notification_seen()
	{
       
           $update = array('admin_seen' => '1' );
           $this->db->where("receiver_id like '%Admin%'");
           $sql=$this->db->update('dbo.notification', $update);
    }
    public function notification()
	{
		if($this->session->userdata('user_role') == 'admin')  
	   {
		    $result['data'] = $this->home->get_notifications();
		   $this->load->view('admin/notification',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function save_auth_details()
	{
		
		$data = $this->input->post();
		 $this->db->select('*');
		 $this->db->from('dbo.auth_details');
		 $sql = $this->db->get()->row();

		$value=array(

           'crypto_protocol' => $data['crpto_protocol'],
           'protocol' =>        $data['protocol'],
           'smtp_host' =>       $data['host'],
           'smtp_port' =>       $data['port'],
           'smtp_user' =>       $data['username'],
           'smtp_pass' =>       $data['password'],
		);
         if($sql)
          {
          	$this->db->where('id',$sql->id);
		    $result = $this->db->update('dbo.auth_details',$value);
    	 }
    	 else
    	 {
    	 	$result = $this->db->insert('dbo.auth_details',$value);
    	 }
		
				if($result)  
				{
					$this->session->set_flashdata('item',array('message' => 'Saved Successfully','class' => 'success'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/settings';
					redirect($url);
				}else {
					
					$this->session->set_flashdata('item',array('message' => 'Error Occurred','class' => 'error'));
					$d = $this->session->flashdata('item');
					$url = base_url().'index.php/admin/settings';	
					redirect($url);
				}
		
	}
}
?> 