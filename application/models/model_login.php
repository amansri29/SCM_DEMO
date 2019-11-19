<?php
class Model_login extends CI_Model{
function __construct() {
	
parent::__construct();

$this->load->database();
}
	public function login($data) {
		
	
		$user_id = $data['user_id'];
		$password = $data['password'];
		$query = $this->db->query("select * from dbo.admin where (user_id ='$user_id' or email='$user_id') and password = '$password'")->result_array();
		//print_r($query); die;
		if($query)
        {
			return $query;
	    }
		else
		{

			$query1 = $this->db->query("select * from dbo.transporter where (global_id ='$user_id' or email='$user_id') and password = '$password'")->result_array();
			if($query1)
			{
				return $query1;
			}
			else
			{
				$query2 = $this->db->query("select * from dbo.customer where (global_id ='$user_id' or email='$user_id') and password = '$password'")->result_array();
			if($query2)
			{
				return $query2;
			}
			else
			{
				return false;
			}
			}
		}
	}
	 public function forgotpassword($data)
    {
		 $mobile = $data['mobile'];
			 $this->db->like('mobile', $mobile, 'both');
			 $query =  $this->db->get('dbo.customer')->result_array();
			 if($query)
			{
			
					return $query;
			}
		
		else
		{
			 
			 $this->db->like('mobile', $mobile, 'both');
			$query1 =  $this->db->get('dbo.transporter')->result_array();
			if($query1)
			{
				
					return $query1;
			}
			else
			{ 
		
			 $this->db->like('mobile', $mobile, 'both');
			 $query2 = $this->db->get('dbo.admin')->result_array();
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
	
}