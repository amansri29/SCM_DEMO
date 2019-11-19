<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Login extends CI_Controller
{
public function __construct()
{
parent::__construct();
$this->load->helper(array('form', 'url'));
$this->load->helper('date');
$this->load->helper('file');
$this->load->library('form_validation');
$this->load->database();
$this->load->model('Model_login','home');
 $this->load->model('sms');
$this->load->library('session');
$this->load->library('image_lib');
$this->load->helper('cookie');
$this->load->helper('text');
$this->load->helper('url');
$this->load->library('email');
session_start();

	
}

	public function index()
	{
		$user_role = $this->session->userdata['user_role'];
		if(empty($user_role))
		{
			$this->load->view('login');
		}
		else
		{
			redirect(base_url() . 'index.php/login/enter');
		}
	}
	function login_validation()  
    {  
         
               $data=$_POST;
                //$user_id = $data['user_id'];
				$result = $this->home->login($data);
				foreach($result as $row)
				{
					$user_role=$row['user_role'];
					$global_id=$row['global_id'];
					$user_id=$row['user_id'];
					$name=$row['name'];
					$access_role=$row['access_role'];
				}
                if($result) 
                {  
					if($user_role=='admin')
					{
						$session_data = array(  
                          'user_id'     =>  $user_id,
                          'user_role'     =>  'admin',
                          'name'     =>  $name,
                          'access_role'     =>  $access_role, 
						);  
						$this->session->set_userdata($session_data);  
						redirect(base_url() . 'index.php/login/enter');  
					}
					else if($user_role=='transporter')
					{
						$session_data = array(  
                          'user_id'     =>  $user_id,
                          'global_id'     =>  $global_id,
                          'user_role'     =>  'transporter',
						   'name'     =>  $name,
						);  
						$this->session->set_userdata($session_data);  
						redirect(base_url() . 'index.php/login/enter');  
					}
					else if($user_role=='customer')
					{
						$session_data = array(  
                          'user_id'     =>  $user_id,
                          'global_id'     =>  $global_id,
                          'user_role'     =>  'customer',
						  'name'     =>  $name,
						);  
						$this->session->set_userdata($session_data);  
						redirect(base_url() . 'index.php/login/enter');  
					}
				
				}	
				else  
                {  
                     $this->session->set_flashdata('error', 'Invalid Username and Password');  
                     redirect(base_url() . 'index.php/login/index');  
                }				
				
           
	}

		function enter()
	{  
		$role = $this->session->userdata('user_role');
		if($role == 'admin')
		{
			redirect(base_url() . 'index.php/admin/dashboard'); 
		}
		else if($role == 'transporter')
		{
			redirect(base_url() . 'index.php/transporter/dashboard'); 
		}
		else if($role = 'customer')
		{
			redirect(base_url() . 'index.php/customer/dashboard'); 
		}
		else
		{
			redirect(base_url() . 'index.php/login/index');  
		}
		 
	}  	
	function forgot_password()  
      {  
			
		$data = $this->input->post();
		$mobile = $data['mobile'];
		$otp = mt_rand(1111,9999);
		$res = $this->home->forgotpassword($data);
		if($res)
		{
			
			foreach($res as $get)
			{
				$user_id=$get['user_id'];
				$user_type=$get['user_role'];
				$name=$get['name'];
				$access_role=$get['access_role'];
				$global_id=$get['global_id'];
			}
			
	  
		/*******save otp*********/
		   $save_otp=array(

			'otp' => $otp ,
			);
			
			if($user_type=='customer')
			{
				$session_data = array(  
                          'user_id1'     =>  $user_id,
                          'global_id1'     =>  $global_id,
                          'user_role1'     =>  'customer',
                          'name'     =>  $name,
                          'mobile'     =>  $mobile,
						);  
						$this->session->set_userdata($session_data); 
				
				$this->db->where('global_id', $global_id);
				$sql=$this->db->update('dbo.customer', $save_otp);
			}
			else if($user_type=='transporter')
			{
				$session_data = array(  
                          'user_id1'     =>  $user_id,
                          'user_role1'     =>  'transporter',
						   'global_id1'     =>  $global_id,
                          'name'     =>  $name,
						   'mobile'     =>  $mobile,
						);  
						$this->session->set_userdata($session_data); 
				$this->db->where('global_id', $global_id);
				$sql=$this->db->update('dbo.transporter', $save_otp);
			}
			else if($user_type=='admin')
			{
				$session_data = array(  
                          'user_id1'     =>  $user_id,
                          'user_role1'     =>  'admin',
                          'name'     =>  $name,
						   'mobile'     =>  $mobile,
						   'access_role'     =>  $access_role,
						);  
						$this->session->set_userdata($session_data); 
				$this->db->where('user_id', $user_id);
				$sql=$this->db->update('dbo.admin', $save_otp);
			}
				/*******send sms otp**********/
			$otp_message = $otp.' Is your Forgot Password OTP. Do not share with any one';
			$data = $this->sms->sms($mobile,$otp_message);
				redirect(base_url() . 'index.php/login/otp');
				
		} else {
			 $this->session->set_flashdata('error1', 'error !! Please enter valid Number.');
			redirect(base_url() . 'index.php/login'); 
		}
					   
	}	
	public function otp()
	{
		$user_role = $this->session->userdata['user_role'];
		if(empty($user_role))
		{
			$this->load->view('otp');
		}
		else
		{
			redirect(base_url() . 'index.php/login/enter');
		}
	}
	 public function otp_verify()
	{
		$user_type = $this->session->userdata('user_role1');
		$user_id = $this->session->userdata('user_id1');
		$global_id = $this->session->userdata('global_id1');
		$name = $this->session->userdata('name');
		$data = $this->input->post();
		$otp = $data['otp'];
		/*print_r($otp);
		print_r($user_type);
		print_r($user_id);
		die;*/
		if($user_type=='customer')
		 {
			 
		      /*************otp_check*************/
			 $this->db->where('otp', $otp);
			  $this->db->where('global_id', $global_id);
			   $sql= $this->db->get('dbo.customer')->result_array();
		 }
		 else if($user_type=='transporter')
		 {
			 
		    /*************otp_check*************/
			 $this->db->where('otp', $otp);
			 $this->db->where('global_id', $global_id);
			   $sql= $this->db->get('dbo.transporter')->result_array();
			 
		 }
		 else if($user_type=='admin')
		 {
			 
		  /*************otp_check*************/
			 $this->db->where('otp', $otp);
			  $this->db->where('user_id', $user_id);
			  $sql= $this->db->get('dbo.admin')->result_array();
			 
		 }
		if($sql)
		{
		
				redirect(base_url() . 'index.php/login/update_password');
		}
		else
		{
			
			    	  $this->session->set_flashdata('error1', 'Error !! Invalid OTP.');
					$d = $this->session->flashdata('error1');
					redirect(base_url() . 'index.php/login/otp');
			}
	} 
	 public function update_new_password()
	{
		$user_type = $this->session->userdata('user_role1');
		$user_id = $this->session->userdata('user_id1');
		$global_id = $this->session->userdata('global_id1');
		$name = $this->session->userdata('name');
		$data = $this->input->post();
		$new_pass = $data['new_pass'];
		$con_pass = $data['con_pass'];
	    if($new_pass==$con_pass)
		{
			$save_pass=array(

			'password' => $new_pass  ,
			);
		if($user_type=='customer')
			{
				$session_data = array(  
                          'user_id'     =>  $user_id,
                          'global_id'     =>  $global_id,
                          'user_role'     =>  'customer',
                          'name'     =>  $name,
						);  
						$this->session->set_userdata($session_data); 
						$this->db->where('global_id', $global_id);
						$sql=$this->db->update('dbo.customer', $save_pass);

			}
			else if($user_type=='transporter')
			{
				$session_data = array(  
                          'user_id'     =>  $user_id,
						  'global_id'     =>  $global_id,
                          'user_role'     =>  'transporter',
                          'name'     =>  $name,
						);  
						$this->session->set_userdata($session_data); 
				        $this->db->where('global_id', $global_id);
				        $sql=$this->db->update('dbo.transporter', $save_pass);
			}
			else if($user_type=='admin')
			{
				$session_data = array(  
                          'user_id'     =>  $user_id,
                          'user_role'     =>  'admin',
                          'name'     =>  $name,
                          'access_role'     =>  $access_role,
						);  
						$this->session->set_userdata($session_data); 
						$this->db->where('user_id', $user_id);
						$sql=$this->db->update('dbo.admin', $save_pass);
			}
		if($sql)
		{
		          
				redirect(base_url() . 'index.php/login/enter');
		}
		else
		{
			
			    	
					   $this->session->set_flashdata('error1', 'Error !! Somthing Went Wrong.');
					$d = $this->session->flashdata('error1');
					redirect(base_url() . 'index.php/login/update_password');
		}
		}
		else{
			       $this->session->set_flashdata('error1', 'Error !! Password Not Match.');
					$d = $this->session->flashdata('error1');
					redirect(base_url() . 'index.php/login/update_password');
		
	} 
	}
	
	public function update_password()
	{
		$user_role = $this->session->userdata['user_role'];
		if(empty($user_role))
		{
			$this->load->view('update_password');
		}
		else
		{
			redirect(base_url() . 'index.php/login/enter');
		}
	}
	
	function resend_otp()  
      {  
		$user_type = $this->session->userdata('user_role1');
		$user_id = $this->session->userdata('user_id1');
        $global_id = $this->session->userdata('global_id1');		
		$mobile = $this->session->userdata('mobile');	
		
		$otp = mt_rand(1111,9999);
		
		/*******save otp*********/
		   $save_otp=array(

			'otp' => $otp ,
			);
			
			if($user_type=='customer')
			{
				 
				$this->db->where('global_id', $global_id);
				$sql=$this->db->update('dbo.customer', $save_otp);
			}
			else if($user_type=='transporter')
			{
				$this->db->where('global_id', $global_id);
				$sql=$this->db->update('dbo.transporter', $save_otp);
			}
			else if($user_type=='admin')
			{
				$this->db->where('user_id', $user_id);
				$sql=$this->db->update('dbo.admin', $save_otp);
			}
				/*******send sms otp**********/
			$otp_message = $otp.' Is your Forgot Password OTP. Do not share with any one';
			$data = $this->sms->sms($mobile,$otp_message);
			$this->session->set_flashdata('success', 'Success !! OTP Send Successfully.');
			$d = $this->session->flashdata('success');
			redirect(base_url() . 'index.php/login/otp');
				
		} 
					   
	public function logout()
	{
		$session_data = array(  
				  'user_id' => '',
				  'user_role' =>''
				);  
		$this->session->unset_userdata($session_data);
		session_destroy();
		redirect('index.php/login', 'refresh');
			
	}
}
?>