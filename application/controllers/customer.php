<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Customer extends CI_Controller
{
public function __construct()
{
parent::__construct();
$this->load->helper(array('form', 'url'));
$this->load->helper('date');
$this->load->helper('file');
$this->load->library('form_validation');
$this->load->model('Model_customer','home');
$this->load->model('update_webservice_data_model');
$this->load->database();
$this->load->library('session');
$this->load->library('image_lib');
$this->load->helper('cookie');
$this->load->helper('text');
$this->load->helper('url');
$this->load->library('email');
session_start();

	
}

	public function dashboard()
	{
		if($this->session->userdata('user_role') == 'customer')  
	   {
		  
		   $inprocess = $this->home->get_inprocess_orders();
		   $delivered = $this->home->get_delivered_orders();
		   $sales = $this->home->get_sales_orders();
		   $posted = $this->home->get_posted_orders();
		   
		  
		  
		   $result['inprocess']= $inprocess;
		   $result['delivered']= $delivered;
		   $result['data']=array_merge($sales,$posted);
		  
		   //print_r($result1); die; 
		   $this->load->view('customer/customer-dashboard',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function orders()
	{
		if($this->session->userdata('user_role') == 'customer')  
	   {
		    $inprocess = $this->home->get_inprocess_orders();
			$delivered = $this->home->get_delivered_orders();
		  		  
		   $result['inprocess']= $inprocess;
		   $result['delivered']= $delivered;
		  $this->load->view('customer/orders',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function order_view()
	{
		if($this->session->userdata('user_role') == 'customer')  
	   {
		    $this->load->view('customer/order_view');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function create_order()
	{
		if($this->session->userdata('user_role') == 'customer')  
	   {
		   
		    $this->load->view('customer/create_order');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function get_state_list()
	{
		$data = $this->input->post();
		$company=$data['company'];
	    $global_id = $this->session->userdata('global_id');
		$this->db->select('*');
		$this->db->from('dbo.customer');
		$this->db->where('global_id', $global_id);
		$this->db->where('company', $company);
		$query = $this->db->get();
		$list = $query->result_array(); 	
		echo json_encode($list);
	}
	public function get_address()
	{
		$res = $this->input->post();
		$user_id=$res['user_id'];
		$company=$res['company'];

		 $res = $this->update_webservice_data_model->get_address_webservice($user_id,$company);	 
		 if($res)
		 {                  
	     echo json_encode($res);  
	     } 
	}
	public function get_product()
	{
		$res = $this->input->post();
		$user_id=$res['user_id'];
		$company=$res['company'];
		//echo $user_id;
        $res = $this->update_webservice_data_model->get_product_webservice($user_id,$company);	 
		 if($res)
		 {                  
	     echo json_encode($res);  
	     } 
		       
	}
	public function save_order()
	{
		$res = $this->input->post();
		$company=$res['company'];
		$state=$res['state'];
		$address=$res['address'];
		$product=$res['product'];
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
	   if($product=='')
	   {
			 $message     = 'Please Select Product';
			 $validation=false;
	   } 
	   if($porder_no=='')
	   {
			 $message     = 'purched order no is blank';
			 $validation=false;
	   }
	   if($validation)
	   {
		           /*convert image or file in base64*/
		   
		                    $check = getimagesize($_FILES["image"]["tmp_name"]);
							/*if($check !== false){*/
					    	if($_FILES["image"]["tmp_name"]) 
							{
							$path = $_FILES['image']['name'];
						    $ext = pathinfo($path, PATHINFO_EXTENSION);
							$data = base64_encode(file_get_contents( $_FILES["image"]["tmp_name"] ));
							//$base64code = "data:".$check["mime"].";base64,".$data;
							$base64code = $data;
							 $res = $this->update_webservice_data_model->save_order_webservice($company,$state,$address,$product,$porder_no,$base64code,$date,$qty,$ext);	 
							 if($res)
							 {                  
						        $this->session->set_flashdata('item',array('message' => 'Save Order Successfully','class' => 'success'));
								$d = $this->session->flashdata('item');
								redirect(base_url().'index.php/customer/create_order');
						     } 
								
							
							
							} else {
								$this->session->set_flashdata('item',array('message' => 'Please Select Image or file','class' => 'error'));
								$d = $this->session->flashdata('item');
								redirect(base_url().'index.php/customer/create_order');
							}
		         
		
			           }
			         else
						 {
					    	$this->session->set_flashdata('item',array('message' => '"'.$message.'"','class' => 'error'));
							$d = $this->session->flashdata('item');
							redirect(base_url().'index.php/customer/create_order');
			       }
	}
	public function placed_order()
	{
		if($this->session->userdata('user_role') == 'customer')  
	   {
		     $result['placed_order'] = $this->home->get_placed_order();
		     $this->load->view('customer/placed_order',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function track_order()
	{
		if($this->session->userdata('user_role') == 'customer')  
	   {
		     $this->load->view('customer/track_order');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function track_orderss()
	{
		$data = $this->input->post();
		$id=$data['driver_id1'];
	    $url = base_url().'index.php/customer/vehicle_track?id='.$id;	
	    redirect($url);
	}
	public function vehicle_track()
	{
		if($this->session->userdata('user_role') == 'customer')  
	   {
		    $this->load->view('customer/vehicle_tracking');
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	public function notification_seen()
	{
           $global_id = $this->session->userdata('global_id');
           $update = array('cust_seen' => '1' );
           $this->db->where("receiver_id like '%$global_id%'");
           $sql=$this->db->update('dbo.notification', $update);
}
 public function notification()
	{
		if($this->session->userdata('user_role') == 'customer')  
	   {
		    $result['data'] = $this->home->get_notifications();
		   $this->load->view('customer/notification',$result);
	   }
	    else  
	   {  
			redirect(base_url() . 'index.php/login/index');  
	   }  
	}
	
}
?>