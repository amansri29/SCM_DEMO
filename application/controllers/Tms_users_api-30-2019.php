<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tms_users_api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		  $this->load->database();
		  $this->load->model('tms_users_api_model');
		  $this->load->model('update_webservice_data_model');
		  $this->load->model('sms');
		  $this->load->model('notification_save');
		  $this->load->model('sms_save');
		  $this->load->model('email_save');
		  $this->load->helper(array('form', 'url'));
        date_default_timezone_set("Asia/Calcutta");
    }
	public function users_login()
	{

		$json              = array();
        $mobile           = $this->input->post('mobile');
        $global_id           = $this->input->post('global_id');
        $password           = $this->input->post('password');
        $device_type         = $this->input->post('device_type');
        $device_token         = $this->input->post('device_token');
		$otp = mt_rand(1111,9999);
        $Isvalidated       = true;
       
       
		 if ($password == '') {
            $message     = ' password is blank';
            $Isvalidated = false;
        }
        if ($device_type == '') {
            $message     = ' device_type is blank';
            $Isvalidated = false;
        }
		 if ($device_token == '') {
            $message     = ' device_token is blank';
            $Isvalidated = false;
        }
        if ($Isvalidated) {
            $data = $this->tms_users_api_model->users_login($mobile,$password,$global_id);
			//print_r($data); die;
           if($data)
		   {
			   foreach($data as $get)
			   {
				   $response['name']=$get['name'];
				   $response['user_type']=$get['user_role'];
				  
				   $user_id=$get['user_id'];
				   $global_id=$get['global_id'];
				   $user_type=$get['user_role'];
				   $image=$get['image'];
				   if($image=='')
				   {
					   $response['image']='';
				   }
				   else{
					    $response['image']=base_url('upload/users/').$image;
				   }
			   }
			    if($user_type=='driver')
				{
					$user_id=$get['id'];
					
				}
			  
			    /*******save otp*********/
			   $save_otp=array(
		
				'otp' => $otp ,
				'device_type' => $device_type ,
				'device_token' => $device_token ,
				);
                if($user_type=='customer')
				{
					$this->db->where('global_id', $global_id);
		            $sql=$this->db->update('dbo.customer', $save_otp);
				}else if($user_type=='transporter')
				{
				    $this->db->where('global_id', $global_id);
		            $sql=$this->db->update('dbo.transporter', $save_otp);
				}
				else if($user_type=='driver')
				{
					 $otp_message=$otp.' Is your login OTP';
				     $data = $this->sms->sms($mobile,$otp_message);

					$this->db->where('id', $user_id);
		            $sql=$this->db->update('dbo.driver', $save_otp);
				}
				/*******send sms otp**********/
				//$otp_message=$otp.' Is your login OTP';
				//$data = $this->sms->sms($mobile,$otp_message);
				
                $response['user_id'] = $user_id;
                $response['global_id'] = $global_id;
                $response['otp'] = $otp;
				$response['status']  = "success";
                $response['message'] = "Login Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Invalid Details";
                echo json_encode($response);
            }
        } else {
            $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function otp_verify()
	{
		$json              = array();
        $otp           = $this->input->post('otp');
        $user_id           = $this->input->post('user_id');
        $global_id           = $this->input->post('global_id');
        $device_type         = $this->input->post('device_type');
        $device_token         = $this->input->post('device_token');
		$user_type           = $this->input->post('user_type');
        $Isvalidated       = true;
        if ($user_id == '') {
            $message     = 'user id is blank';
            $Isvalidated = false;
        }
		if ($device_type == '') {
            $message     = 'device type is blank';
            $Isvalidated = false;
        }
		
		if ($device_token == '') {
            $message     = 'device token is blank';
            $Isvalidated = false;
        }
		if ($otp == '') {
            $message     = 'otp  is blank';
            $Isvalidated = false;
        }
		if ($user_type == '') {
            $message     = 'user type is blank';
            $Isvalidated = false;
        }
		if (!($user_type == 'driver' OR $user_type == 'customer' OR $user_type == 'transporter')) {
			$message     = 'user type error.. use(driver,customer,transporter)';
            $Isvalidated = false;
		}
		 
        if ($Isvalidated) {
            $data = $this->tms_users_api_model->otp_check($user_id,$otp,$device_type,$device_token,$user_type,$global_id);
           if($data)
		   {
			   foreach($data as $get)
			   {
				   $response['name']=$get['name'];
				   $response['user_type']=$get['user_role'];
				   $image=$get['image'];
				   if($image=='')
				   {
					   $response['image']='';
				   }
				   else{
					    $response['image']=base_url('upload/users/').$image;
				   }
			   }

			   $value=array(
                 'device_token' => $device_token,
                 'device_type' => $device_type,
			   );
			     if($user_type=='driver')
                 {
                 	$this->db->where('id', $user_id);
					$sql=$this->db->update('dbo.driver', $value);
                 }
                 if($user_type=='customer')
                 {
                 	$this->db->where('global_id', $global_id);
					$sql=$this->db->update('dbo.customer', $value);
                 }
                 if($user_type=='transporter')
                 {
                 	$this->db->where('global_id', $global_id);
					$sql=$this->db->update('dbo.transporter', $value);
                 }
			         
                
                $response['user_id'] = $user_id;
				$response['global_id'] = $global_id;
                $response['otp'] = $otp;
				$response['status']  = "success";
                $response['message'] = "Login Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Invalid OTP";
                echo json_encode($response); 
            }
        } else {
            $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function resend_otp()
	{
	    $user_id           = $this->input->post('user_id');
	    $global_id           = $this->input->post('global_id');
		$user_type           = $this->input->post('user_type');
		$mobile           = $this->input->post('mobile');
		$otp = mt_rand(1111,9999);
		 $Isvalidated       = true;
        if ($user_id == '') {
            $message     = 'user id is blank';
            $Isvalidated = false;
        }
		if ($user_type == '') {
            $message     = 'user type is blank';
            $Isvalidated = false;
        }
		if ($mobile == '') {
            $message     = 'mobile  is blank';
            $Isvalidated = false;
        }
		if (!($user_type == 'driver' OR $user_type == 'customer' OR $user_type == 'transporter')) {
			$message     = 'user type error.. use(driver,customer,transporter)';
            $Isvalidated = false;
		}
		 
        if ($Isvalidated) {
	    $data = $this->tms_users_api_model->update_otp($user_id,$otp,$user_type,$global_id);
		if($data)
		{
			/*******send sms otp**********/
			$otp_message=$otp.' Is your login OTP';
			$data = $this->sms->sms($mobile,$otp_message);
			$response['otp']  = $otp;
			$response['status']  = "success";
			$response['message'] = "OTP Send Sucessfully";
			echo json_encode($response);
		}
		else{
		    $response['status']  = "error";
			$response['message'] = "Something Went Wrong";
			echo json_encode($response);
		}
		}
		else{
			$response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
		}
		
	}
	
	public function users_logout()
	{
		$json              = array();
        $user_id           = $this->input->post('user_id');
        $global_id           = $this->input->post('global_id');
        $user_type           = $this->input->post('user_type');
        $Isvalidated       = true;
        if ($user_id == '') {
            $message     = 'user id is blank';
            $Isvalidated = false;
        }
        
		if ($user_type == '') {
            $message     = 'user type is blank';
            $Isvalidated = false;
        }
		if (!($user_type == 'driver' OR $user_type == 'customer' OR $user_type == 'transporter')) {
			$message     = 'user type error.. use(driver,customer,transporter)';
            $Isvalidated = false;
		}
		
        if ($Isvalidated) {
        	 $value=array(
                 'device_token' => '',
                 'device_type' => '',
			   );
			     if($user_type=='driver')
                 {
                 	$this->db->where('id', $user_id);
					$sql=$this->db->update('dbo.driver', $value);
                 }
                 if($user_type=='customer')
                 {
                 	$this->db->where('global_id', $global_id);
					$sql=$this->db->update('dbo.customer', $value);
                 }
                 if($user_type=='transporter')
                 {
                 	$this->db->where('global_id', $global_id);
					$sql=$this->db->update('dbo.transporter', $value);
                 }
           $data = $this->tms_users_api_model->users_logout($user_id,$user_type, $global_id);
           if($data)
		   {
                $response['status']  = "success";
                $response['message'] = "Logout Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function forgot_password()
   {
					
			$mobile          = $this->input->post('mobile');
			$otp = mt_rand(1111,9999);
			$Isvalidated       = true;
			
			if ($mobile == '') {
				$message     = 'mobile is blank';
				$Isvalidated = false;
			}

			
			$json             = array();
			if ($Isvalidated) {
				 $result = $this->tms_users_api_model->forgot_password($mobile);
				if(!$result)
				{
					$response['status']  = "error";
					$response['message'] = 'Invalid Mobile Number';
					echo json_encode($response);
				}
				else{
					foreach($result as $get)
					{
					  $user_id=$get['user_id'];
					  $global_id=$get['global_id'];
					  $user_type=$get['user_role'];
					  
					  if($user_type=='driver')
				{
					$user_id=$get['id'];
					
				}
				
				$update = array(
				'otp' => $otp,
				);
				if($user_type=='customer')
				{
					$this->db->where('global_id', $global_id);
					$sql=$this->db->update('dbo.customer', $update);
				}else if($user_type=='transporter')
				{
					$this->db->where('global_id', $global_id);
					$sql=$this->db->update('dbo.transporter', $update);
				}
				else if($user_type=='driver')
				{
					$this->db->where('id', $user_id);
					$sql=$this->db->update('dbo.driver', $update);
				}
					/*******send sms otp**********/
				$otp_message=$otp.' Is Your Forgot Password OTP';
				$data = $this->sms->sms($mobile,$otp_message);
				$response['user_id'] = $user_id;
				$response['name'] = $get['name'];
				$response['global_id'] = $global_id;
				$response['user_type'] = $user_type;
				$response['otp'] = $otp;
				$response['status']  = "success";
				$response['message'] = "OTP Send Sucessfully";
					echo json_encode($response);
					}
				}
					
				} else {
					$response['status']  = "error";
					$response['message'] = $message;
					echo json_encode($response);
				}
			}
			public function update_password()
           {	
			$password          = $this->input->post('password');
			$user_id           = $this->input->post('user_id');
			$global_id           = $this->input->post('global_id');
            $user_type           = $this->input->post('user_type');
			$Isvalidated       = true;
			if ($user_id == '') {
				$message     = 'user id is blank';
				$Isvalidated = false;
			}
			
			if ($user_type == '') {
				$message     = 'user type is blank';
				$Isvalidated = false;
			}
			if (!($user_type == 'driver' OR $user_type == 'customer' OR $user_type == 'transporter')) {
				$message     = 'user type error.. use(driver,customer,transporter)';
				$Isvalidated = false;
			}
			if ($password == '') {
					$message     = 'password is blank';
					$Isvalidated = false;
			}

			
			$json             = array();
			if ($Isvalidated) {
				
				
				$update = array(
				'password' => $password,
				);
				if($user_type=='customer')
				{
					$this->db->where('global_id', $global_id);
					$sql=$this->db->update('dbo.customer', $update);
				}else if($user_type=='transporter')
				{
					$this->db->where('global_id', $global_id);
					$sql=$this->db->update('dbo.transporter', $update);
				}
				else if($user_type=='driver')
				{
					$this->db->where('id', $user_id);
					$sql=$this->db->update('dbo.driver', $update);
				}
					if($sql)
					{
				    $response['status']  = "success";
				    $response['message'] = "Update Password Sucessfully";
					echo json_encode($response);
				}
				else{
					$response['status']  = "error";
				    $response['message'] = "Something Went Wrong";
					echo json_encode($response);
				}
			}
				 else {
					$response['status']  = "error";
					$response['message'] = $message;
					echo json_encode($response);
				}
			}
	public function get_users_profile()
	{
		$json              = array();
        $user_id           = $this->input->post('user_id');
        $global_id           = $this->input->post('global_id');
        $user_type           = $this->input->post('user_type');
        $Isvalidated       = true;
		if ($user_type == '') {
            $message     = 'user type is blank';
            $Isvalidated = false;
        }
		if (!($user_type == 'driver' OR $user_type == 'customer' OR $user_type == 'transporter')) {
			$message     = 'user type error.. use(driver,customer,transporter)';
            $Isvalidated = false;
		}
		
        if ($Isvalidated) {
           $data = $this->tms_users_api_model->get_users_profile($global_id,$user_type,$user_id);
           if($data)
		   {
			 
				   $image=$data->image;
				   $contact_person=$data->contact_person;
				   if($contact_person==null)
				   {
					    $contact_person='';
				   }
				   if($image==''){
					$json['image']='';
				   }
				   else{ 
					$json['image']=base_url('upload/users/').$image;
				   }
				    $json['name'] =$data->name;
				    $json['email'] = $data->email;
				    $json['address'] = $data->address;
				    $json['mobile'] =  $data->mobile;
				    $json['global_id'] = $global_id;
				    $json['contact_person'] = $contact_person;
				    $json['user_id'] = $user_id;
                    $json['user_type'] = $user_type;
					$array[]=$json;
				   
			 
	                $response['data']=$array;
	                $response['status']  = "success";
	                $response['message'] = "Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=[];
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	
	public function edit_users_profile()
	{
		$json              = array();
        $user_id           = $this->input->post('user_id');
        $global_id           = $this->input->post('global_id');
        $user_type           = $this->input->post('user_type');
		//$name           = $this->input->post('name');
		//$email           = $this->input->post('email');
		//$mobile           = $this->input->post('mobile');
		//$password           = $this->input->post('password');
		//$contact_person           = $this->input->post('contact_person');
        $Isvalidated       = true;
        /*if ($user_id == '') {
            $message     = 'user id is blank';
            $Isvalidated = false;
        }
        if ($global_id == '') {
            $message     = 'global id is blank';
            $Isvalidated = false;
        }*/
        
		if ($user_type == '') {
            $message     = 'user type is blank';
            $Isvalidated = false;
        }
		if (!($user_type == 'driver' OR $user_type == 'customer' OR $user_type == 'transporter')) {
			$message     = 'user type error.. use(driver,customer,transporter)';
            $Isvalidated = false;
		}
		
        if ($Isvalidated) {
			
			$this->load->library('upload');
			$config = array(
				'upload_path' => 'upload/users',
				'allowed_types' => '*',
				//'file_name' => $img,
				'encrypt_name' => true,
			);
			$image='';
			if(!empty($_FILES['image']['name']))
			{
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('image'))
				{
						$res = $this->upload->data();
						$image=$res['file_name'];
				}
			
						$update = array(
                        //'name' => $name,
                        //'email' => $email,
                        'image' => $image,
                       // 'mobile' => $mobile,
                       // 'password' => $password,
                       // 'contact_person' => $contact_person,
                    );
           $data = $this->tms_users_api_model->edit_users_profile($user_id,$user_type,$update,$global_id);
           if($data)
		   {
			    $response['status']  = "success";
                $response['message'] = "Update Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
       }
       else
       {
       	        $response['status']  = "error";
                $response['message'] = "Please select iamge";
                echo json_encode($response);
       }
  
	}
	 else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
}

        public function update_driver_latlong()
           {
					
			$latitude          = $this->input->post('latitude');
			$user_id           = $this->input->post('user_id');
            $longitude           = $this->input->post('longitude');
			$Isvalidated       = true;
			if ($user_id == '') {
				$message     = 'user id is blank';
				$Isvalidated = false;
			}
			
			if ($latitude == '') {
					$message     = 'latitude is blank';
					$Isvalidated = false;
			}
			if ($longitude == '') {
					$message     = 'longitude is blank';
					$Isvalidated = false;
			}

			
			$json             = array();
			if ($Isvalidated) {
				$update = array(
				'latitude' => $latitude,
				'longitude' => $longitude,
				'travel_date_time' => date('Y-m-d H:i:s'),
				);
			
				$this->db->where('id', $user_id);
				$sql=$this->db->update('dbo.driver', $update);
			if($sql)
			{
				$response['status']  = "success";
				$response['message'] = "Update lat long Sucessfully";
					echo json_encode($response);
			}
					else{
					$response['status']  = "error";
				$response['message'] = "Something Went Wrong";
					echo json_encode($response);
				}
				}
				 else {
					$response['status']  = "error";
					$response['message'] = $message;
					echo json_encode($response);
				}
			}
			public function get_orders()
	     {
		    $json              = array();
	        $user_id           = $this->input->post('user_id');
	        $user_type           = $this->input->post('user_type');
	        $global_id           = $this->input->post('global_id');
			$order_type           = $this->input->post('order_type');
	        $Isvalidated       = true;
	        if ($user_id == '') {
	            $message     = 'user id is blank';
	            $Isvalidated = false;
	        }
	        
			if ($order_type == '') {
	            $message     = 'order type is blank';
	            $Isvalidated = false;
	        }
			if ($user_type == '') {
	            $message     = 'user type is blank';
	            $Isvalidated = false;
	        }
			if (!($user_type == 'driver' OR $user_type == 'customer' OR $user_type == 'transporter')) {
				$message     = 'user type error.. use(driver,customer,transporter)';
	            $Isvalidated = false;
			}
			if (!($order_type == 'inprocess' OR $order_type == 'dispatched' OR $order_type == 'completed')) {
				$message     = 'user type error.. use(inprocess,dispatched,completed)';
	            $Isvalidated = false;
			}
			
	        if ($Isvalidated) {
	          $data = $this->tms_users_api_model->get_orders($user_id,$user_type,$order_type,$global_id);
	           if($data)
			   { 
	                $response['data']=$data;
	                $response['status']  = "success";
	                $response['message'] = "Orders Fetch Sucessfully";
	                echo json_encode($response);
	            } else {
					$response['data']=$data;
	                $response['status']  = "error";
	                $response['message'] = "No Orders Found";
	                echo json_encode($response);
	            }
	        } else {
	             $response['status']  = "error";
	            $response['message'] = $message;
	            echo json_encode($response);
	        }
  
	}
	public function orders_full_view()
	{
		$json              = array();
        $order_id           = $this->input->post('order_id');
        $user_type           = $this->input->post('user_type');
        $Isvalidated       = true;
        if ($order_id == '') {
            $message     = 'order id is blank';
            $Isvalidated = false;
        }
		if ($user_type == '') {
            $message     = 'user type is blank';
            $Isvalidated = false;
        }
		if (!($user_type == 'driver' OR $user_type == 'customer' OR $user_type == 'transporter')) {
			$message     = 'user type error.. use(driver,customer,transporter)';
            $Isvalidated = false;
		}
		
        if ($Isvalidated) {
         $data = $this->tms_users_api_model->orders_full_view($order_id,$user_type);
           if($data)
		   { 
                $response['data']=$data;
                $response['status']  = "success";
                $response['message'] = "Orders Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$data;
                $response['status']  = "error";
                $response['message'] = "No Orders Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function get_today_dispatched()
	{
		$json              = array();
        $global_id           = $this->input->post('global_id');
        $Isvalidated       = true;
        if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
		
        if ($Isvalidated) {
         $sales = $this->tms_users_api_model->get_today_dispatched_order($global_id);
		 $posted = $this->tms_users_api_model->get_today_posted_dispatched_order($global_id);
		   
		   $result=array_merge($sales,$posted);
		   // print_r($result);
		  // die; 
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Orders Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$posted;
                $response['status']  = "error";
                $response['message'] = "No Orders Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function get_bidding_orders()
	{
	    $json              = array();
        $global_id           = $this->input->post('global_id');
        $Isvalidated       = true;
        if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_bidding_orders($global_id);
		
           if($result)
		   { 
                $response['data']    = $result;
                $response['status']  = "success";
                $response['message'] = "Orders Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']    = $result;
                $response['status']  = "error";
                $response['message'] = "No Orders Found";
                echo json_encode($response);
            }
       }
         else {
             $response['status']  = "error";
             $response['message'] = $message;
            echo json_encode($response);
        }
	}
	public function get_awarded_orders()
	{
		$json              = array();
        $global_id           = $this->input->post('global_id');
        $Isvalidated       = true;
        if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
		
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_awarded_orders($global_id);
		// print_r($result); die;
		
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Orders Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=[];
                $response['status']  = "error";
                $response['message'] = "No Orders Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
             $response['message'] = $message;
             echo json_encode($response);
        }
  
	}
	public function accept_and_reject_orders()
	{
		$json              = array();
        $order_id          = $this->input->post('order_id');
        $global_id         = $this->input->post('global_id');
        $reason            = $this->input->post('reason');
        $status            = $this->input->post('status');
        $Isvalidated       = true;
        if ($order_id == '') {
            $message     = 'order id is blank';
            $Isvalidated = false;
        }
           if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
		if ($Isvalidated) {
			if($status=='accept')
			{
				 
				 $res = $this->tms_users_api_model->get_orders_details_orders($order_id);
				if($res)
				{
                    $response['status']  = "success";
	                $response['message'] = "Saved Sucessfully";
	                echo json_encode($response);
				}
				else
				{
					$data = $this->tms_users_api_model->get_orders_details($order_id);
				 foreach($data as $row)
				 {
				 	$trans_no=$row['trans_no'];
				 	$cust_no=$row['cust_no'];
				 }
			    	$value=array(
					'order_id' => $order_id,
					'global_id' => $global_id,
					'trans_no' => $trans_no,
					'cust_no' => $cust_no,  
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
			 
		 // print_r($value); die;
		    $query = $this->db->insert('dbo.order_details',$value);
           if($query)
		   {      

                    $response['status']  = "success";
	                $response['message'] = "Saved Sucessfully";
	                echo json_encode($response);

		           $sender='transporter';
			       $receiver='admin';
			       $result = $this->notification_save->save_notification_all($order_id,'order_accept',$sender,$receiver);

			         /**************end send notification to admin**************/

			       $sender='transporter';
			       $receiver='admin';
			       $result = $this->sms_save->save_sms_all($order_id,'order_accept',$sender,$receiver);

				   $sender='transporter';
	               $receiver='admin';
	               $result = $this->email_save->save_email_all($order_id,'order_accept',$sender,$receiver);

	              
            } else {
	                $response['status']  = "error";
	                $response['message'] = "Something Went Wrong";
	                echo json_encode($response);
            }
			}
		}
			else if($status=='reject')
			{
				 $data = $this->tms_users_api_model->get_orders_details($order_id);
				  $res = $this->tms_users_api_model->get_orders_details_order_rejects($order_id);
				  if($res)
				  {
                     $response['status']  = "success";
	                 $response['message'] = "Saved Sucessfully";
	                 echo json_encode($response);
				  }
				  else
				  {
				 foreach($data as $row)
		         {
		            $trans_no=$row['trans_no'];
				 	$cust_no=$row['cust_no'];	
				 	$delivery_date = $row['delivery_date'];
		         }
				    $update=array(
					'order_id' => $order_id,
					'global_id' => $global_id,
					'customer_no' => $cust_no,
					'transporter_no' => $trans_no, 
					'reason' => 'Rejected by vendor<br>
					             Reason :'.$reason,
					'delivery_date' => $delivery_date,
					);
					//  print_r($update); die;
		     
					$query = $this->db->insert('dbo.attn_required',$update);
					$query = $this->db->insert('dbo.missed_orders',$update);
					if(! $query)
					{
						   $response['status']  = "error";
			               $response['message'] = "Something Went Wrong";
			               echo json_encode($response);
					}
					else{

			 /**************send notification to admin**************/

					       $sender='transporter';
					       $receiver='admin';
					       $result = $this->notification_save->save_notification_all($order_id,'order_decline',$sender,$receiver);

					         /**************end send notification to admin**************/

					       $sender='transporter';
					       $receiver='admin';
					       $result = $this->sms_save->save_sms_all($order_id,'order_decline',$sender,$receiver);

					       $sender='transporter';
						   $receiver='admin';
						   $result = $this->email_save->save_email_all($order_id,'order_decline',$sender,$receiver);
							if($query)
							   { 
					                $response['status']  = "success";
					                $response['message'] = "Saved Sucessfully";
					                echo json_encode($response);
					            }
		       }
		  }
	   }
	}
     else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
 }
	
	public function get_driver_list()
	{
		$json              = array();
        $global_id           = $this->input->post('global_id');
        $Isvalidated       = true;
        if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
		
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_driver_list($global_id);
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Drivers Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$result;
                $response['status']  = "error";
                $response['message'] = "No Drivers Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function get_vehicle_list()
	{
		$json              = array();
        $global_id           = $this->input->post('global_id');
        $Isvalidated       = true;
        if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
		
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_vehicle_list($global_id);
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Vehicles Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$result;
                $response['status']  = "error";
                $response['message'] = "No Vehicles Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function get_vehicle_for_assign_order()
	{

		$json              = array();
        $global_id           = $this->input->post('global_id');
         $order_id           = $this->input->post('order_id');
        $Isvalidated       = true;
        if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
         if ($order_id == '') {
            $message     = 'order_id is blank';
            $Isvalidated = false;
        }
		
        if ($Isvalidated) {
			$data = $this->input->post();
		    $id =$order_id;
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
		    $this->db->select('DISTINCT (v.registration_no) as registration_no,v.id as id,cast (sdo.qty_to_ship AS VARCHAR(max)) as qty_to_ship,v.capacity as capacity ,v.insurance as insurance_no');
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
					$json['insurance_no']=$value['insurance_no'];
					$json['rcapacity']=$remaining;
					$json['tcapacity']=$total_capacity;
					$json['status']='enabled';
					$array2[]=$json;
					
				}
				else{
					//echo 'd';
					$json['id']=$value['id'];
					$json['registration_no']=$value['registration_no'];
					$json['insurance_no']=$value['insurance_no'];
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
			
			$this->db->select('DISTINCT (v.registration_no) as registration_no,v.id as id ,v.capacity as capacity,v.insurance as insurance_no');
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
					$json['insurance_no']=$value1['insurance_no'];
					$json['tcapacity']=$total_capacity;
					$json['rcapacity']=$total_capacity;
					$json['status']='enabled';
					$array[]=$json;
					
				}
				else{
					
					$json['id']=$value1['id'];
					$json['registration_no']=$value1['registration_no'];
					$json['insurance_no']=$value1['insurance_no'];
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
			    $response['data']  = $final;
			    $response['status']  = "success";
                $response['message'] ='Fetch Sucessfully';
			    echo json_encode($response);
			}
			 else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
				
	}
	public function get_driver_for_assign_order()
	{
			$json              = array();
         $global_id           = $this->input->post('global_id');
         $order_id           = $this->input->post('order_id');
        $Isvalidated       = true;
        if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
         if ($order_id == '') {
            $message     = 'order_id is blank';
            $Isvalidated = false;
        }
		
        if ($Isvalidated) {
		    $id =  $order_id;
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
					$json['mobile']=$value['mobile'];
					$json['license_no']=$value['license_no'];
					$json['status']='disabled';
					$array2[]=$json;
					   
				}
			   }
			     // echo json_encode($array2);
			/* $this->db->select('dr.id as did,dr.name as name');
			$this->db->from('dbo.driver as dr');
	     	$this->db->where('dr.id NOT IN (select d.id from dbo.order_details as od inner join dbo.driver as d on d.id = od.driver_id)'); 
			$this->db->where('dr.global_id', $global_id ); */
			$this->db->select('dr.name as name,dr.id as did,dr.mobile,dr.license_no');
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
			$this->db->select('DISTINCT (dr.id)as did,dr.name as name,dr.mobile,dr.license_no');
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
			    $response['data']  = $final;
			    $response['status']  = "success";
                $response['message'] ='Fetch Sucessfully';
			    echo json_encode($response);
			}
			 else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }												
	}
	public function assign_vehicle_and_driver()
	{
		$json              = array();
        $order_id           = $this->input->post('order_id');
        $global_id          = $this->input->post('global_id');
        $user_id            = $this->input->post('user_id');
        $vehicle_id         = $this->input->post('vehicle_id');
        $insurance_no       = $this->input->post('insurance_no');
        $gps_enabled        = $this->input->post('gps_enabled');
        $driver_id          = $this->input->post('driver_id');
        $lr_rr_no           = $this->input->post('lr_rr_no');
        $lr_rr_date           = $this->input->post('lr_rr_date');
        $mobile           = $this->input->post('mobile');
        $dname           = $this->input->post('name');
        $vehicle_no           = $this->input->post('registration_no');
    
        $Isvalidated       = true;
        if ($order_id == '') {
            $message     = 'order id is blank';
            $Isvalidated = false;
        } 
		if ($global_id == '') {
            $message     = 'global id is blank';
            $Isvalidated = false;
        }
		 if ($user_id == '') {
            $message     = 'user id is blank';
            $Isvalidated = false;
        }
		 if ($vehicle_id == '') {
            $message     = 'vehicle id is blank';
            $Isvalidated = false;
        }
		 if ($insurance_no == '') {
            $message     = 'insurance no is blank';
            $Isvalidated = false;
        } 
		if ($gps_enabled == '') {
            $message     = 'gps enabled is blank';
            $Isvalidated = false;
        } 
		if ($driver_id == '') {
            $message     = 'driver id is blank';
            $Isvalidated = false;
        } 
		if ($vehicle_no == '') {
            $message     = 'vehicle no  is blank';
            $Isvalidated = false;
        } 
		if ($lr_rr_no == '') {
            $message     = 'lr_rr_no is blank';
            $Isvalidated = false;
        } 
		if ($lr_rr_date == '') {
            $message     = 'lr_rr_date is blank';
            $Isvalidated = false;
        } 
		if ($mobile == '') {
            $message     = 'mobile is blank';
            $Isvalidated = false;
        } 
		if ($dname == '') {
            $message     = 'driver name is blank';
            $Isvalidated = false;
        }
		if ($Isvalidated) {
		 
					 $value=array(
					'vehicle_id' => $vehicle_id,
					'driver_id' => $driver_id,
					'global_id' => $global_id,
					'trans_no' => $user_id,
					'order_status' => 'Inprocess',
					'shipping_status' => 'Awaiting For Arrival',
					'lr_rr_no' => $lr_rr_no,
					'lr_rr_date' => $lr_rr_date,
					'gps_enabled' => $gps_enabled,
					'insurance_no' => $insurance_no,
		    );
			        $this->db->where('order_id',$order_id);
		            $this->db->where('global_id',$global_id);
		            $query = $this->db->update('dbo.order_details',$value);
				
           if($query)
		   { 

		   	                
 
	           $data = $this->update_webservice_data_model->change_webservice_data($global_id,$order_id,$mobile,$dname,$vehicle_no,$lr_rr_no,$lr_rr_date,$gps_enabled,$vehicle_id,$driver_id);
	          
	                       
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

                           $response['status']  = "success";
                           $response['message'] = "Saved Sucessfully";
                           echo json_encode($response);  
               
            
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function get_transporter_list()
	{
		$json              = array();
        $Isvalidated       = true;
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_transporter_list();
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Transporters Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$result;
                $response['status']  = "error";
                $response['message'] = "No Transporters Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function add_driver()
	{
		$json              = array();
        $user_id           = $this->input->post('user_id');
		$global_id           = $this->input->post('global_id');
        $mobile           = $this->input->post('mobile');
        $name           =      $this->input->post('name');
        $license_no           = $this->input->post('license_no');
        $valid_upto           = $this->input->post('valid_upto');
        $transporter_id           = $this->input->post('transporter_id');
    
        $Isvalidated       = true;
      /*  if ($user_id == '') {
            $message     = 'user id is blank';
            $Isvalidated = false;
        }*/
		if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
		 if ($license_no == '') {
            $message     = 'license no is blank';
            $Isvalidated = false;
        }
		 if ($valid_upto == '') {
            $message     = 'valid upto is blank';
            $Isvalidated = false;
        } 
		if ($transporter_id == '') {
            $message     = 'transporter id is blank';
            $Isvalidated = false;
        } 
		if ($mobile == '') {
            $message     = 'mobile is blank';
            $Isvalidated = false;
        } 
		if ($name == '') {
            $message     = 'driver name is blank';
            $Isvalidated = false;
        }
		if ($Isvalidated) {
		 
			$user_id1 = 'DRI'.rand(1000, 9999);
		$value=array(
			 'user_id' =>$user_id1,
			 'global_id' =>$global_id,
			 'name' =>$name ,
			 'mobile' =>$mobile,
			 'license_no' => $license_no,
			 'valid_upto' => $valid_upto,
			 'password' => '123456',
			 'email' => '',
			 'address' => '',
			 'image' => '',
			 'device_token' => '',
			 'device_type' => '',
			 'wallet_amount' => '',
			 'transporter_id' => $transporter_id,
			 'user_role' => 'driver',
   
		);
		/* print_r($value);
		die; */
		$query = $this->db->insert('dbo.driver',$value);
           if($query)
		   { 
                $response['status']  = "success";
                $response['message'] = "Saved Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function add_vehicle()
	{
		$json              = array();
        $registration_no           = $this->input->post('registration_no');
		$global_id           = $this->input->post('global_id');
        $vehicle_type           = $this->input->post('vehicle_type');
        $owner_name           =      $this->input->post('owner_name');
        $owner_contact           = $this->input->post('owner_contact');
       // $valid_upto           = $this->input->post('valid_upto');
        $transporter_id           = $this->input->post('transporter_id');
        $capacity           = $this->input->post('capacity');
        $unit           = $this->input->post('unit');
        $insurance           = $this->input->post('insurance');
    
        $Isvalidated       = true;
        if ($global_id == '') {
            $message     = 'global_id  is blank';
            $Isvalidated = false;
        }
		if ($registration_no == '') {
            $message     = 'registration no is blank';
            $Isvalidated = false;
        }
		 if ($vehicle_type == '') {
            $message     = 'vehicle type is blank';
            $Isvalidated = false;
        }
		/* if ($valid_upto == '') {
            $message     = 'valid upto is blank';
            $Isvalidated = false;
        } */ 
		if ($transporter_id == '') {
            $message     = 'transporter id is blank';
            $Isvalidated = false;
        } 
		if ($owner_contact == '') {
            $message     = 'owner contact is blank';
            $Isvalidated = false;
        } 
		if ($owner_name == '') {
            $message     = 'owner name is blank';
            $Isvalidated = false;
        }
		if ($capacity == '') {
            $message     = 'capacity is blank';
            $Isvalidated = false;
        }
		if ($insurance == '') {
            $message     = 'insurance is blank';
            $Isvalidated = false;
        }
		if ($unit == '') {
            $message     = 'unit is blank';
            $Isvalidated = false;
        }
		if ($Isvalidated) {
		  $value=array(
			'global_id' => $global_id,
			'registration_no' => $registration_no,
			'valid_upto' => '',
			'vehicle_type' => $vehicle_type,  
			'owner_name' => $owner_name,
			'owner_contact' => $owner_contact,
			'capacity' => $capacity,
			'unit' => $unit,
			'transporter_id' => $transporter_id,
			'insurance' => $insurance,
            );
		/*print_r($value);
		die; */
		$query = $this->db->insert('dbo.vehicle',$value);
           if($query)
		   { 
                $response['status']  = "success";
                $response['message'] = "Saved Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function get_wallet_amount()
	{
		$json              = array();
		$user_id           = $this->input->post('user_id');
    
        $Isvalidated       = true;
        if ($user_id == '') {
            $message     = 'user_id is blank';
            $Isvalidated = false;
        }
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_wallet_amount($user_id);
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Amount Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$result;
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function get_lat_long_gps_on()
	{
		$json              = array();
		$driver_id           = $this->input->post('driver_id');
    
        $Isvalidated       = true;
        if ($driver_id == '') {
            $message     = 'driver id is blank';
            $Isvalidated = false;
        }
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_lat_long_gps_on($driver_id);
		   
           if($result)
		   { 
                $response['data']    = $result;
                $response['status']  = "success";
                $response['message'] = "Lat Long Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']    = $result;
                $response['status']  = "error";
                $response['message'] = "No Lat Long Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function get_milestone_setting()
	{
		$json              = array();
        $Isvalidated       = true;
        
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_milestone_setting();
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Milestone Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$result;
                $response['status']  = "error";
                $response['message'] = "No Setting Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	
	public function save_milestone_details()
	{
		$json              = array();	
		$order_id           = $this->input->post('order_id');
		$global_id           = $this->input->post('global_id');
		$delivery_date           = $this->input->post('delivery_date');
		$transporter_id           = $this->input->post('transporter_id');
		$pickup_address           = $this->input->post('pickup_address');
		$shipping_address           = $this->input->post('shipping_address');
		$driver_id           = $this->input->post('driver_id');
		$distance           = $this->input->post('distance');
		$amount           = $this->input->post('amount');
		$estimated_time           = $this->input->post('estimated_time');
		$total_time_taken           = $this->input->post('total_time_taken');
		$status           = $this->input->post('status');
    
        $Isvalidated       = true;
        if ($order_id == '') {
            $message     = 'order_id is blank';
            $Isvalidated = false;
        } 
		if ($delivery_date == '') {
            $message     = 'delivery_date is blank';
            $Isvalidated = false;
        }
		/*if ($transporter_id == '') {
            $message     = 'transporter_id is blank';
            $Isvalidated = false;
        }*/
        if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
		if ($pickup_address == '') {
            $message     = 'pickup_address is blank';
            $Isvalidated = false;
        }
		if ($shipping_address == '') {
            $message     = 'shipping_address is blank';
            $Isvalidated = false;
        }
		if ($driver_id == '') {
            $message     = 'driver_id is blank';
            $Isvalidated = false;
        }
		if ($distance == '') {
            $message     = 'distance is blank';
            $Isvalidated = false;
        }
		if ($estimated_time == '') {
            $message     = 'estimated_time is blank';
            $Isvalidated = false;
        }
		if ($total_time_taken == '') {
            $message     = 'total_time_taken is blank';
            $Isvalidated = false;
        }
		if ($status == '') {
            $message     = 'status is blank';
            $Isvalidated = false;
        }
		if ($amount == '') {
            $message     = 'amount is blank';
            $Isvalidated = false;
        }
       
        if ($Isvalidated) {
		$value=array(
			'order_id' => $order_id,
			'global_id' => $global_id,
			'delivery_date' => $delivery_date,
			'transporter_id' => '',  
			'pickup_address' => $pickup_address,
			'shipping_address' => $shipping_address,
			'driver_id' => $driver_id,
			'distance' => $distance,
			'estimated_time' => $estimated_time,
			'total_time_taken' => $total_time_taken,
			'amount' => $amount,
			'status' => $status,
			'approvel_status' => 'Not Approved',
            );
		/*print_r($value);
		die; */
		$query = $this->db->insert('dbo.milestone',$value); 
           if($query)
		   { 
		   	   
			   /*START :: CALCULATE ORDER RATING */
				$this->db->select('*');
				$this->db->from('dbo.trans_rating');
				$this->db->where('order_id', $order_id);
				$this->db->where('global_id', $global_id);
				$query = $this->db->get()->row();
				$accept=$query->accept_and_assign;
				$veh=$query->vehicle_condition;
				$track=$query->track_and_trace;
				$cust=$query->customer;
				$prating=$query->previous_rating;
                
                /* 
				distance
				estimated_time >> hours and mins
				total_time_taken >> in mins
				*/
				$result = $this->tms_users_api_model->get_milestone_setting();
				if( !empty($result)){
				   $AdditionalRating = 0;
				   if( $total_time_taken > 0 &&  $distance > 0){
					    $ExpectedDays = "";
					    $ActualDaysTaken = $total_time_taken / 24*60;// NUMBER OF DAYS TAKEN
					    if( $ActualDaysTaken > 0 ){ 
						  /*$ActualDaysTaken = $distance / $TotalTimeTakenInDays ; */
						  if( $result[0]['per_day_travel_km'] > 0 ){
							 $ExpectedDays  =  $distance / $result[0]['per_day_travel_km'];
						  }
						  
						  if( $ActualDaysTaken <= $ExpectedDays ){
							 $AdditionalRating = 2.5;
							 $accept = $accept + $AdditionalRating;
						  }else{
						     $AdditionalRating = 0;
							 $accept = $accept + $AdditionalRating;
						  }
					    } 
						$Str = "ActualDaysTaken : ".$ActualDaysTaken." distance:".$distance." ExpectedDays: ".$ExpectedDays." accept: ". $accept." AdditionalRating: ".$AdditionalRating	;	
                        						
				   }
				} 				
				$t=($track*30)/100;
				$v=($veh*15)/100;
				$a=($accept*30)/100;
				$c=($cust*25)/100;
				$total=$t+$a+$v+$c;
				$total_rating=($total+$prating)/2;
				 
				$value=array(
					'rating' => $total_rating,
				);
				$this->db->where('global_id',$global_id);
				$query = $this->db->update('dbo.transporter',$value);
				
				$value1=array(
					'avg_rating' => $total,
					'accept_and_assign'=>$accept
				);
				$this->db->where('global_id',$global_id);
				$this->db->where('order_id',$order_id);
				$query = $this->db->update('dbo.trans_rating',$value1);
			    /*END :: CALCULATE ORDER RATING */
				$sender='driver';
				$receiver='transporter,admin';
				$result = $this->notification_save->save_notification_all($order_id,'mliestone',$sender,$receiver);

				$sender='driver';
				$receiver='transporter,admin';
				$result = $this->email_save->save_email_all($order_id,'mliestone',$sender,$receiver);

				$response['status']  = "success";
				$response['message'] = "Saved Sucessfully ";
				echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function order_delivered()
	{
		$json              = array();	
		$order_id          = $this->input->post('order_id');
		$status            = $this->input->post('status');
		$driver_id         = $this->input->post('driver_id');
		$otp               = $this->input->post('otp');
		$global_id         = $this->input->post('global_id');
    
        $Isvalidated       = true;
        if ($order_id == '') {
            $message     = 'order_id is blank';
            $Isvalidated = false;
        } 
		
		if ($status == '') {
            $message     = 'status is blank';
            $Isvalidated = false;
        }
		if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
        if ($Isvalidated) {
			
			  $result = $this->tms_users_api_model->match_otp($otp,$driver_id,$order_id);
			  if(!$result)
			  {
				$response['status']  = "success";
                $response['message'] = "Wrong OTP";
                echo json_encode($response);
			  }
			  else{
			  $value=array(
			'shipping_status' => 'Delivered',
			'order_status' => $status ,
            );
		/*print_r($value);
		die; */
		$this->db->where('order_id',$order_id);
		$query = $this->db->update('dbo.order_details',$value);
           if($query)
		   { 
	            $result = $this->tms_users_api_model->submit_rating($order_id,$global_id);
               $sender='driver';
               $receiver='transporter,admin,customer,driver';
               $result = $this->sms_save->save_sms_all($order_id,'delivered',$sender,$receiver);
	           $sender='driver';
               $receiver='transporter,admin,customer,driver';
               $result = $this->notification_save->save_notification_all($order_id,'delivered',$sender,$receiver);
                 
               $sender='driver';
               $receiver='transporter,admin,customer,driver';
               $result = $this->email_save->save_email_all($order_id,'delivered',$sender,$receiver);


                $response['status']  = "success";
                $response['message'] = "Delivered Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        } }else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function mark_delivered()
	{
		$json              = array();	
		$order_id           = $this->input->post('order_id');
		$status           = $this->input->post('status');
		$global_id           = $this->input->post('global_id');
        $Isvalidated       = true;
        if ($order_id == '') {
            $message     = 'order_id is blank';
            $Isvalidated = false;
        } 
		
		if ($status == '') {
            $message     = 'status is blank';
            $Isvalidated = false;
        }
		if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
        if ($Isvalidated) {
			
			  
			  $value=array(
			'shipping_status' => 'Delivered',
			'order_status' => $status ,
            );
		/*print_r($value);
		die; */
		$this->db->where('order_id',$order_id);
		$query = $this->db->update('dbo.order_details',$value);
		$query=true;
           if($query)
		   { 
	         $res = $this->tms_users_api_model->get_all_mobile($order_id);
			 //print_r($res); die;
			 $dmobile=$res->dmobile;
			 $tmobile=$res->tmobile;
			 $cmobile=$res->cmobile;
				$cmobile_number[0] = explode(',',trim($cmobile));
				$tmobile_number[0] = explode(',',trim($tmobile));
	         /*******send sms otp**********/
			    /*$message = $order_id.'Order Delivered Successfully';
			    $data = $this->sms->delivery_sms($tmobile_number[0],$cmobile_number[0],$dmobile,$message);
				$result = $this->tms_users_api_model->submit_rating($order_id,$global_id);*/

			   $sender='driver';
               $receiver='transporter,admin,customer,driver';
               $result = $this->sms_save->save_sms_all($order_id,'delivered',$sender,$receiver);

               $sender='driver';
               $receiver='transporter,admin,customer,driver';
               $result = $this->email_save->save_email_all($order_id,'delivered',$sender,$receiver);

             /*******send notification  otp**********/
               $sender='driver';
               $receiver='transporter,admin,customer,driver';
               $result = $this->notification_save->save_notification_all($order_id,'delivered',$sender,$receiver);

                $response['status']  = "success";
                $response['message'] = "Delivered Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        }else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function get_milestone_details()
	{
		$json              = array();
        $driver_id           = $this->input->post('driver_id');
    
        $Isvalidated       = true;
        if ($driver_id == '') {
            $message     = 'driver_id is blank';
            $Isvalidated = false;
        } 
        
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_milestone_details($driver_id);
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Milestone Details Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$result;
                $response['status']  = "error";
                $response['message'] = "No Order Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	
	public function get_driver_transaction()
	{
		$json              = array();
        $driver_id           = $this->input->post('driver_id');
    
        $Isvalidated       = true;
        if ($driver_id == '') {
            $message     = 'driver_id is blank';
            $Isvalidated = false;
        } 
        
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_driver_transaction($driver_id);
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Transaction Details Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$result;
                $response['status']  = "error";
                $response['message'] = "No Transaction Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	
	public function save_address_off_gps()
	{
		$json              = array();
        $order_id           = $this->input->post('order_id');
        $date           = $this->input->post('date');
        $time           =      $this->input->post('time');
        $address           = $this->input->post('address');
        $latitude           = $this->input->post('latitude');
        $longitude           = $this->input->post('longitude');
        $Isvalidated       = true;
		
        if ($order_id == '') {
            $message     = 'order_id no is blank';
            $Isvalidated = false;
        }
		 if ($date == '') {
            $message     = 'date is blank';
            $Isvalidated = false;
        }
		 if ($time == '') {
            $message     = 'time  is blank';
            $Isvalidated = false;
        } 
		if ($address == '') {
            $message     = 'address  is blank';
            $Isvalidated = false;
        } 
		if ($latitude == '') {
            $message     = 'latitude  is blank';
            $Isvalidated = false;
        } 
		if ($longitude == '') {
            $message     = 'longitude is blank';
            $Isvalidated = false;
        }
		if ($Isvalidated) {
			$value=array();
			$count = count($address);
			for($i=0; $i<$count; $i++)
			{
		     $value=array(
			'order_id' => $order_id[$i],
			'date' => $date[$i],
			'time' => $time[$i],  
			'address' => $address[$i],
			'latitude' => $latitude[$i],
			'longitude' => $longitude[$i],
            );
			$query = $this->db->insert('dbo.location',$value);
		/*print_r($value);
		die; */
		}
           if($query)
		   { 
                $response['status']  = "success";
                $response['message'] = "Saved Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	
	public function get_address_off_gps()
	{
		$json              = array();
        $order_id          = $this->input->post('order_id');
    
        $Isvalidated       = true;
        if ($order_id == '') {
            $message     = 'order_id is blank';
            $Isvalidated = false;
        } 
        
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_address_off_gps($order_id);
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Address Details Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$result;
                $response['status']  = "error";
                $response['message'] = "No Address Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
	public function get_order_id_for_map()
	{
	    $driver_id           = $this->input->post('driver_id');
        $Isvalidated       = true;
        if ($driver_id == '') {
            $message     = 'driver_id is blank';
            $Isvalidated = false;
        } 
        
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_order_id_for_map($driver_id);
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "order id Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$result;
                $response['status']  = "error";
                $response['message'] = "No order id Found";
                echo json_encode($response);
            }
		}
		else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
    }
	
	public function driver_dashboard_data()
	{
	  $user_id           = $this->input->post('user_id');
    
        $Isvalidated       = true;
        if ($user_id == '') {
            $message     = 'user_id is blank';
            $Isvalidated = false;
        } 
        
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->driver_dashboard_data($user_id);
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "data Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=$result;
                $response['status']  = "error";
                $response['message'] = "No data Found";
                echo json_encode($response);
            }
		}
		else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
    }
    	public function transporter_dashboard_data()
	{
	  $global_id           = $this->input->post('global_id');
    
        $Isvalidated       = true;
        if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        } 
        
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->transporter_dashboard_data($global_id);
		   
           if($result)
		   { 
                $response['data']    = $result;
                $response['status']  = "success";
                $response['message'] = "data Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']    = $result;
                $response['status']  = "error";
                $response['message'] = "No data Found";
                echo json_encode($response);
            }
		}
		else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
    }
    public function get_reason_list()
	{
		$json              = array();
        $Isvalidated       = true;
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_reason_list($global_id,$order_id);
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Reason Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']=[];
                $response['status']  = "error";
                $response['message'] = "No Reason Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
  public function cust_order_delivered()
	{
		$json              = array();	
		$order_id          = $this->input->post('order_id');
		$status            = $this->input->post('status');
		$user_id           = $this->input->post('user_id');
		$global_id         = $this->input->post('global_id');
		$otp               = $this->input->post('otp');
    
        $Isvalidated       = true;
        if ($order_id == '') {
            $message     = 'order_id is blank';
            $Isvalidated = false;
        } 
		
		if ($status == '') {
            $message     = 'status is blank';
            $Isvalidated = false;
        }
		if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
        if ($Isvalidated) {
			
			  $result = $this->tms_users_api_model->cust_match_otp($otp,$user_id,$order_id);
			  if(!$result)
			  {
				$response['status']  = "error";
                $response['message'] = "Wrong OTP";
                echo json_encode($response);
			  }
			  else{
			  $value=array(
			'shipping_status' => 'Delivered',
			'order_status' => $status ,
            );
		/*print_r($value);
		die; */
		$this->db->where('order_id',$order_id);
		$this->db->where('cust_no',$user_id);
		$query = $this->db->update('dbo.order_details',$value);
           if($query)
		   { 
	         $result = $this->tms_users_api_model->submit_rating($order_id,$global_id);
               $sender='customer';
               $receiver='transporter,admin,customer,driver';
               $result = $this->sms_save->save_sms_all($order_id,'delivered',$sender,$receiver);
               
               $sender='customer';
               $receiver='transporter,admin,customer,driver';
               $result = $this->email_save->save_email_all($order_id,'delivered',$sender,$receiver);

               $sender='customer';
               $receiver='transporter,admin,customer,driver';
               $result = $this->notification_save->save_notification_all($order_id,'delivered',$sender,$receiver); 

                $response['status']  = "success";
                $response['message'] = "Delivered Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
        } }else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
  
	}
		public function getlocation()
		{
			
			 $address='Khasara No.94-96,355-409, 
						Mauza Balyana,Ind. Area
						174103
						Barotiwala';
			if(!empty($address)){
				//Formatted address
				$formattedAddr = str_replace(' ','+',$address);
				//Send request and receive json data by address
			   $geocodeFromAddr = file_get_contents($details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$formattedAddr."&key=AIzaSyA2_9Lpcxc2d-E1Z3oseySOeYX9aWQL2BA&sensor=false"); 
				$output = json_decode($geocodeFromAddr);
				//Get latitude and longitute from json data
				$data['latitude']  = $output->results[0]->geometry->location->lat; 
				$data['longitude'] = $output->results[0]->geometry->location->lng;
				//Return latitude and longitude of the given address
				if(!empty($data)){
					print_r($data);
				}else{
					echo 'not found';
				}
			}else{
				echo 'not found';
			}
		}
		
		public function save_rating()
	 {
		  $rating           = $this->input->post('rating');
		  //$global_id           = $this->input->post('global_id');
		  $order_id           = $this->input->post('order_id');
    
			$Isvalidated       = true;
			if ($order_id == '') {
				$message     = 'order_id is blank';
				$Isvalidated = false;
			} 
			if ($rating == '') {
				$message     = 'rating is blank';
				$Isvalidated = false;
			} 
        
        if ($Isvalidated) {
			        $this->db->select('*');
					$this->db->from('dbo.order_details');
					$this->db->where('order_id', $order_id);
					$query1 = $this->db->get();
					$row1 = $query1->row();
					$global_id=$row1->global_id;
					//echo $global_id;
			
			        $this->db->select('*');
					$this->db->from('dbo.transporter');
					$this->db->where('global_id', $global_id);
					$query = $this->db->get();
					$row = $query->row();
					$previous_rating=$row->rating;
					        $this->db->select('*');
							$this->db->from('dbo.trans_rating');
							$this->db->where('order_id', $order_id);
							$this->db->where('global_id', $global_id);
							$query2 = $this->db->get()->row();
						if($query2->order_id==$order_id)
						{
						    $update=array(
							 'vehicle_condition' => $rating,
							 'previous_rating' => $previous_rating,
							 );
						   // print_r($update);
				            $this->db->where('global_id',$global_id);
							$this->db->where('order_id',$order_id);
		                    $data = $this->db->update('dbo.trans_rating',$update); 
						}
                       else	
					   {
						 $insert=array(
						 'order_id' => $order_id,
						 'global_id' => $global_id,
						 'vehicle_condition' => $rating,
						 'previous_rating' => $previous_rating,
						 );
					   $data=$this->db->insert('dbo.trans_rating', $insert);
					   }
					
				   
           if($data)
		   { 
                $response['status']  = "success";
                $response['message'] = "Rate Sucessfully again";  
                echo json_encode($response);
           } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
		}
		else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
    }
	public function track_and_trace_rating()
    {
	  $global_id           = $this->input->post('global_id');
	  $order_id           = $this->input->post('order_id');
	  $driver_id           = $this->input->post('driver_id');
    
        $Isvalidated       = true;
        if ($driver_id == '') {
            $message     = 'driver_id is blank';
            $Isvalidated = false;
        } 
		if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        } 
		if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        } 
        
        if ($Isvalidated) {
				    $this->db->select('*');
					$this->db->from('dbo.driver');
					$this->db->where('id', $driver_id);
					$query = $this->db->get();
					$row = $query->row();
					$date1=$row->travel_date_time;
					$date2= date('Y-m-d H:i:s');
			        $seconds = strtotime($date2) - strtotime($date1);
                    $last_hours = $seconds / 60 /  60;
					//echo $last_hours; 
					$this->db->select('*');
					$this->db->from('dbo.settings');
					$query = $this->db->get();
					$res = $query->row();
					$hours=$res->track_and_trace_hours;
					//echo $hours; die;
					
					            $this->db->select('*');
								$this->db->from('dbo.transporter');
								$this->db->where('global_id', $global_id);
								$query = $this->db->get();
								$row = $query->row();
								$previous_rating=$row->rating;
					if($last_hours >=$hours)
					{
						
						    $this->db->select('*');
							$this->db->from('dbo.trans_rating');
							$this->db->where('order_id', $order_id );
							$this->db->where('global_id', $global_id);
							$query = $this->db->get();
							$rating = $query->row();
							if($rating->order_id==$order_id)
							{
							$update=array(
							
								 'order_id' => $rating->order_id,
								 'global_id' => $rating->global_id,
								 'track_and_trace' => '0',
							);
							$this->db->where('order_id', $order_id);
							$this->db->where('global_id', $global_id);
							$data=$this->db->update('dbo.trans_rating', $update);
							}
							else{
								
								
								$insert=array(
								 'order_id' => $order_id,
								 'global_id' => $global_id,
								 'track_and_trace' => '0',
								 'previous_rating' => $previous_rating,
								 );
							   $data=$this->db->insert('dbo.trans_rating', $insert);
							}
						
					}
					else{
						//echo 'hii';
							$this->db->select('*');
							$this->db->from('dbo.trans_rating');
							$this->db->where('order_id', $order_id );
							$this->db->where('global_id', $global_id);
							$query = $this->db->get();
							$rating = $query->row();
							if($rating->order_id==$order_id)
							{
								$get_rating=$rating->vehicle_condition;
								if($get_rating=='0')
								{
                                     $update=array(
									
										 'order_id' => $rating->order_id,
										 'track_and_trace' => '0',
										 'global_id' => $rating->global_id,
									);
									$this->db->where('order_id', $order_id);
									$this->db->where('global_id', $global_id);
									$data=$this->db->update('dbo.trans_rating', $update);
								}
								else
								{
									$update=array(
									
										 'order_id' => $rating->order_id,
										 'track_and_trace' => '5',
										 'global_id' => $rating->global_id,
									);
									$this->db->where('order_id', $order_id);
									$this->db->where('global_id', $global_id);
									$data=$this->db->update('dbo.trans_rating', $update);
							}
						}
							else{
								
								$insert=array(
								 'order_id' => $order_id,
								 'global_id' => $global_id,
								 'track_and_trace' => '5',
								 'previous_rating' => $previous_rating,
								 );
							   $data=$this->db->insert('dbo.trans_rating', $insert);
							}
					}
		   
           if($data)
		   { 
                $response['status']  = "success";
                $response['message'] = "Rate Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "error";
                $response['message'] = "Something Went Wrong";
                echo json_encode($response);
            }
		}
		else {
             $response['status']  = "error";
             $response['message'] = $message;
             echo json_encode($response);
        }
    }
	public function customer_rating()
	   {
		  $rating           = $this->input->post('rating');
		  $global_id           = $this->input->post('global_id');
		  $order_id           = $this->input->post('order_id');
	    
	        $Isvalidated       = true;
	        if ($order_id == '') {
	            $message     = 'order_id is blank';
	            $Isvalidated = false;
	        } 
			if ($rating == '') {
	            $message     = 'rating is blank';
	            $Isvalidated = false;
	        } 
			if ($global_id == '') {
	            $message     = 'global_id is blank';
	            $Isvalidated = false;
	        } 
        
        if ($Isvalidated) {
			
			  $this->db->select('*');
								$this->db->from('dbo.transporter');
								$this->db->where('global_id', $global_id);
								$query = $this->db->get();
								$row = $query->row();
								$previous_rating=$row->rating;
								
							$this->db->select('*');
							$this->db->from('dbo.trans_rating');
							$this->db->where('order_id', $order_id);
							$this->db->where('global_id', $global_id);
							$query = $this->db->get()->row();
						if($query->order_id==$order_id)
						{
						    $update=array(
							 'customer' => $rating,
							 'previous_rating' => $previous_rating,
							 );
				            $this->db->where('global_id',$global_id);
							$this->db->where('order_id',$order_id);
		                    $data = $this->db->update('dbo.trans_rating',$update); 
						}
                       else	
					   {
						   $insert=array(
							 'order_id' => $order_id,
							 'global_id' => $global_id,
							 'customer' => $rating,
							 'previous_rating' => $previous_rating,
							 );
				
		                    $data = $this->db->insert('dbo.trans_rating',$insert); 
					   }						   
		  // $data=true;
           if($data)
		   { 
	                        $this->db->select('*');
							$this->db->from('dbo.trans_rating');
							$this->db->where('order_id', $order_id);
							$this->db->where('global_id', $global_id);
							$query = $this->db->get()->row();
							$accept=$query->accept_and_assign;
							$veh=$query->vehicle_condition;
							$track=$query->track_and_trace;
							$cust=$query->customer;
							$prating=$query->previous_rating;
							
							$t=($track*30)/100;
							$v=($veh*15)/100;
							$a=($accept*30)/100;
							$c=($cust*25)/100;
							$total=$t+$a+$v+$c;
							$total_rating=($total+$prating)/2;
							//print_r($total_rating);
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
					$response['status']  = "success";
					$response['message'] = "Rate Sucessfully";
					echo json_encode($response);
				} else {
					$response['status']  = "error";
					$response['message'] = "Something Went Wrong";
					echo json_encode($response);
				}
		}
		else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
    }

   public function get_help_details()
    {
    
        $Isvalidated       = true;
        $json=array();
        if ($Isvalidated) {

         $this->db->select('*');
		 $this->db->from('dbo.help');
		 $sql = $this->db->get()->row();

        $json['trans_details']=$sql->trans_help_message;
        $json['driver_details']=$sql->driver_help_message;
        $json['cust_details']=$sql->cust_help_message;

        if($sql)
        {
                    $json['status']  = "success";
					$json['message'] = "fetch Sucessfully";
					echo json_encode($json);
        }
        else
        {
                    $json['status']  = "error";
					$json['message'] = "Something Went Wrong";
					echo json_encode($json);
        }

}
}

public function get_cust_company()
    {
	  $global_id           = $this->input->post('global_id');
      $Isvalidated       = true;
		if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        } 
        $json=array();
        if ($Isvalidated) {

          $result = $this->tms_users_api_model->get_cust_company($global_id); 

        if($result)
        {
        	        $json['data']  = $result;
                    $json['status']  = "success";
					$json['message'] = "fetch Sucessfully";
					echo json_encode($json);
        }
        else
        {           $json['data']  = [];
                    $json['status']  = "error";
					$json['message'] = "Company Not Found";
					echo json_encode($json);
        }

     }
     else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
}
 public function get_cust_state_list()
    {
	   $global_id           = $this->input->post('global_id');
	   $company           = $this->input->post('company');
      $Isvalidated       = true;
		if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        } 
        if ($company == '') {
            $message     = 'company is blank';
            $Isvalidated = false;
        } 
        $json=array();
        if ($Isvalidated) {

          $result = $this->tms_users_api_model->get_cust_state_list($global_id,$company); 

        if($result)
        {
                    $json['data']  = $result;
                    $json['status']  = "success";
					$json['message'] = "fetch Sucessfully";
					echo json_encode($json);
        }
        else
        {
                   $json['data']  = [];
                    $json['status']  = "error";
					$json['message'] = "State List Not Found";
					echo json_encode($json);
        }

     }
     else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
}
public function get_cust_address()
    {
	   $user_id           = $this->input->post('user_id');
	   $company           = $this->input->post('company');
      $Isvalidated       = true;
		if ($user_id == '') {
            $message     = 'user_id is blank';
            $Isvalidated = false;
        } 
        if ($company == '') {
            $message     = 'company is blank';
            $Isvalidated = false;
        } 
        $json=array();
        if ($Isvalidated) {

          $result = $this->tms_users_api_model->get_address($user_id,$company); 

        if($result)
        {
        	   foreach ($result as $key => $value) {
        	   if($value=='')
        	   {
        	      	$json['data']  = [];
                    $json['status']  = "error";
					$json['message'] = "Address Not Found";
					echo json_encode($json);
        	   }
        	   else{
        	   
                    $json['data']  = $result;
                    $json['status']  = "success";
					$json['message'] = "fetch Sucessfully";
					echo json_encode($json);
				}
			}
        }
        else
        {
                    $json['data']  = [];
                    $json['status']  = "error";
					$json['message'] = "Address Not Found";
					echo json_encode($json);
        }

     }
     else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
}
public function get_cust_product()
    {
	   $user_id           = $this->input->post('user_id');
	   $company           = $this->input->post('company');
      $Isvalidated       = true;
		if ($user_id == '') {
            $message     = 'user_id is blank';
            $Isvalidated = false;
        } 
        if ($company == '') {
            $message     = 'company is blank';
            $Isvalidated = false;
        } 
        $json=array();
        if ($Isvalidated) {

          $result = $this->tms_users_api_model->get_product($user_id,$company); 

        if($result)
        {
            foreach ($result as $key => $value) {
        	   if($value=='')
        	   {
        	      	$json['data']  = [];
                    $json['status']  = "error";
					$json['message'] = "Product Not Found";
					echo json_encode($json);
        	   }
        	   else{
        	   
                    $json['data']  = $result;
                    $json['status']  = "success";
					$json['message'] = "Product Found";
					echo json_encode($json);
				}
			}
        }
        else
        {          
                    $json['data']  = [];
                    $json['status']  = "error";
					$json['message'] = "Product Not Found";
					echo json_encode($json);
        }
     }
     else {
             $response['status']  = "error";
            $response['message'] = $message;
            echo json_encode($response);
        }
}
public function save_order()
	{
		$res = $this->input->post();
		$company=$res['company'];
		$state=$res['state'];
		$address=$res['address'];
		$product1=$res['product'];
		$date=$res['date'];
		$qty=$res['qty'];
		$product=implode(',',$product);
		$qty=implode(',',$qty);
		$date=implode(',',$date);
		$porder_no=$res['porder_no'];
		$validation=true;
		
       if($company=='')
	   {
			 $message     = 'Please Select Company';
			 $validation=false;
	   }
	   if($state=='')
	   {
			 $message     = 'Please Select State';
			 $validation=false;
	   } 
	   if($address=='')
	   {
			 $message     = 'Please Select Ship Address';
			 $validation=false;
	   }
	   if($product1=='')
	   {
			 $message     = 'Please Select Product';
			 $validation=false;
	   } 
	   if($porder_no=='')
	   {
			 $message     = 'purched order no is blank';
			 $validation=false;
	   }
	   if(empty($_FILES["image"]["tmp_name"])) 
		{
			 $message     = 'Please Select Image or file';
			 $validation=false;
		}

	   if($validation)
	   {
	        $check = getimagesize($_FILES["image"]["tmp_name"]);
			$path  = $_FILES['image']['name'];
		    $ext   = pathinfo($path, PATHINFO_EXTENSION);
			$data  = base64_encode(file_get_contents( $_FILES["image"]["tmp_name"] ));
			$base64code = $data;
	$result = $this->tms_users_api_model->save_order($company,$state,$address,$product,$porder_no,$base64code,$date,$qty,$ext); 
			if($result)
	        {
	                    $json['status']  = "success";
						$json['message'] = "Order Placed Sucessfully";
						echo json_encode($json);
	        }
	        else
	        {
	                    $json['status']  = "error";
						$json['message'] = "Something Went Wrong";
						echo json_encode($json);
	        }
       }
	     else
			 {
					 	 $response['status']  = "error";
			             $response['message'] = $message;
			             echo json_encode($response);
		  
	        }
	}
	 public function bid_now()
	{
		$global_id           = $this->input->post('global_id');
		$order_id            = $this->input->post('order_id');
		$amount              = $this->input->post('amount');
		$unit                = $this->input->post('unit');
		$user_id             = $this->input->post('user_id');
       $Isvalidated       = true;
		if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        } 
       if ($order_id == '') {
            $message     = 'order_id is blank';
            $Isvalidated = false;
        } 
         if ($amount == '') {
            $message     = 'amount is blank';
            $Isvalidated = false;
        } 
          if ($unit == '') {
            $message     = 'unit is blank';
            $Isvalidated = false;
        } 
        if ($user_id == '') {
            $message     = 'user_id is blank';
            $Isvalidated = false;
        } 
       
        $json=array();
        if ($Isvalidated) {

          $result = $this->tms_users_api_model->bidnow($global_id,$order_id,$amount,$unit,$user_id); 

        if($result)
        {
            $json['status']  = "success";
			$json['message'] = "Saved Sucessfully";
			echo json_encode($json);
			
        }
        else
        {          
            $json['status']  = "error";
			$json['message'] = "Your Amount is grater than actual amount";
			echo json_encode($json);
}

     }
     else {
            $response['status']  = "error";
            $response['message']  = $message;
            echo json_encode($response);
        }
	}
	public function get_my_bid_list()
	{
		$json              = array();
        $global_id         = $this->input->post('global_id');
        $order_id          = $this->input->post('order_id');
        $Isvalidated       = true;
        if ($global_id == '') {
            $message     = 'global_id is blank';
            $Isvalidated = false;
        }
        if ($order_id == '') {
            $message     = 'order_id is blank';
            $Isvalidated = false;
        }
		
        if ($Isvalidated) {
         $result = $this->tms_users_api_model->get_my_bid_list($global_id,$order_id);
		   
           if($result)
		   { 
                $response['data']=$result;
                $response['status']  = "success";
                $response['message'] = "Drivers Fetch Sucessfully";
                echo json_encode($response);
            } else {
				$response['data']    = $result;
                $response['status']  = "error";
                $response['message'] = "No List Found";
                echo json_encode($response);
            }
        } else {
             $response['status']  = "error";
            $response['message']  = $message;
            echo json_encode($response);
        }
  
	}
	public function update_transporter()
	{
		$res = $this->input->post();
		$trans_id=$res['trans_id'];
		$company=$res['company'];
		$order_key=$res['order_key'];

		$res = $this->update_webservice_data_model->update_transporter_api_update_webservice($trans_id,$company,$order_key);	                   
	    return $res;
		
	}
	public function send_notification()
		{
		       // old firebase // $server_key='AAAA9TlbBq4:APA91bF5hB1gBZy_8x9kZJS0GsC89sXYyB7d8L7XjKCZPjqFm7qaBbBFVbdZibkbA8bvujnzH0HVVmkoGddXeLokUCAmQboe3zLEdFVlyeeEFADEA_s94RQZb9H0hsGsiPizqji4Xpey';

			   $server_key='AAAAzdN-fRs:APA91bE0Yy6goCYE5gPvl-Ruvmu1z_RsYP7jMyVB2GtjIAN7VknPMZZ9VjAUfbNZYikZy9orQc1H3_GqEDGB2qp0_Rkp2ulB79EqZfpvcX6MyMjLIpgpFxgOAsv51FENaQBsL8IXb8rg';

			   
			   //registration_ids
			   $new_message='sdsa';
			    $new_title='erfesr';
			   $msg=array(
			   'message' => $new_message,	
			   'title'   => $new_title,		  
			   );
				$fields = array(
					'to' => $device_id,
                    'data' => $msg,
					'priority' => 'high',
					'notification' => array(
						'title' => $new_title,
						'body' => $new_message,
					)
				 );
				//print_r($fields);
				
				$headers = array(
					'Authorization: key=' . $server_key,
					'Content-Type: application/json'
				);
				//print_r($fields);
				//die;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
				$result = curl_exec($ch);
				curl_close($ch);
				echo $result;
				

	}	
	
    public function updateDispatchOrder(){
		echo "<pre>";print_r("Ruchi");die();

		$username = 'scm';
		$password = 'scm@3112';
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_PORT => "1132",
		CURLOPT_URL =>"http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Page/DispatchOrders",
		CURLOPT_USERPWD => $username.':'.$password,
		CURLOPT_HTTPAUTH => CURLAUTH_ANY,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <Weigh_Out_Time>".$time."</Weigh_Out_Time>\n                <Weigh_Out_Date>".$date."</Weigh_Out_Date>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
		CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache",
		"content-type: text/xml",
		"postman-token: 98746a29-cbcf-a33d-35ac-1471ec049b12",
		"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
		),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		// echo "cURL Error #:" . $err;
		} else {
		// echo $response;
		}
	}
}

?>