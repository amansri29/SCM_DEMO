<?php
class Update_webservice_data_model extends CI_Model
{

     public $username = 'scm';
	 public $password = 'scm@3112';

     /************update data webservice url********/
     public  $port           = '7048';
     public  $umds_url       = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Page/DispatchOrders';
     public  $zoraster_url   = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/S.ZORASTER%20%26%20COMPANY/Page/DispatchOrders';  
     public  $jp_min_url     = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Jaipur%20Mineral%20Development%20Syn/Page/DispatchOrders';
     public  $golcha_url     = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Talc/Page/DispatchOrders';
     public  $golcha_min_url ='http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Minerals%20%28I%29%20Pvt.Ltd./Page/DispatchOrders';

     /************get address webservice url ********/
     public  $add_port           = '7048';
	 public  $umds_add_url       = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Page/ShiptoAddress';
	 public  $zoraster_add_url   = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/S.ZORASTER%20%26%20COMPANY/Page/ShiptoAddress';  
     public  $jp_min_add_url     = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Jaipur%20Mineral%20Development%20Syn/Page/ShiptoAddress';
	 public  $golcha_add_url     = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Talc/Page/ShiptoAddress';
     public  $golcha_min_add_url = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Minerals%20%28I%29%20Pvt.Ltd./Page/ShiptoAddress';
		

	  /************get product webservice url ********/
     public  $pord_port           = '7048';	
	 public	 $umds_prod_url       = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Page/SalesPrice';
	 public	 $zoraster_prod_url   = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/S.ZORASTER%20%26%20COMPANY/Page/SalesPrice';  
     public  $jp_min_prod_url     = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Jaipur%20Mineral%20Development%20Syn/Page/SalesPrice';
     public  $golcha_prod_url     = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Talc/Page/SalesPrice';
     public  $golcha_min_prod_url = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Minerals%20%28I%29%20Pvt.Ltd./Page/SalesPrice';

     /************save product webservice url ********/
     public $save_port            = '7048';
	 public	$umds_save_url        = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Codeunit/CreateSalesOrder';
	 public $zoraster_save_url    = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/S.ZORASTER%20%26%20COMPANY/Codeunit/CreateSalesOrder';  
	 public $jp_min_save_url      = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Jaipur%20Mineral%20Development%20Syn/Codeunit/CreateSalesOrder';
	 public	$golcha_save_url      = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Talc/Codeunit/CreateSalesOrder';
	 public	$golcha_min_save_url  = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Minerals%20%28I%29%20Pvt.Ltd./Codeunit/CreateSalesOrder';

	   /************save product webservice url ********/
     public $placed_port            = '7048';
	 public	$umds_placed_url        = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Page/SalesOrder';
	 public $zoraster_placed_url    = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/S.ZORASTER%20%26%20COMPANY/Page/SalesOrder';  
	 public $jp_min_placed_url      = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Jaipur%20Mineral%20Development%20Syn/Page/SalesOrder';
	 public	$golcha_placed_url      = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Talc/Page/SalesOrder';
	 public	$golcha_min_placed_url  = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Minerals%20%28I%29%20Pvt.Ltd./Page/SalesOrder';

	 /************ get inventory webservice url ********/	
	 public $inventory_port         = '7048';		  	  
     public	$get_inventory          ='http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Page/FGDateandLocationWiseRating';
    
     /************get dispatches webservice url ********/	
	 public $dispatches_port        = '7048';		  	  
     public	$get_dispatches         ='http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Page/DispatchRating';

    function __construct()
    {
		parent::__construct();
		$this->load->model('notification_save');
        $this->load->model('sms_save');
        $this->load->model('email_save');
        $this->load->database();
        date_default_timezone_set("Asia/Calcutta");
            

    }
     public function save_product_url($company)
    {
    	      if($company=='UMDS')
			   {
				  return $this->umds_save_url;
			  }
			  if($company=='S.ZORASTER')
			  {
				 return  $this->zoraster_save_url;
			  } 
			  if($company=='Jaipur Mineral Development')
			  {
				 return $this->jp_min_save_url;
				
			  }
			  if($company=='Golcha Talc')
			  {
				 return $this->golcha_save_url;
				
			  }
			  if($company=='Golcha Minerals Pvt.Ltd.')
			  {
			      return $this->golcha_min_save_url;
			  }
    }
     public function get_product_url($company)
    {
    	      if($company=='UMDS')
			   {
				  return $this->umds_prod_url;
			  }
			  if($company=='S.ZORASTER')
			  {
				 return  $this->zoraster_prod_url;
			  } 
			  if($company=='Jaipur Mineral Development')
			  {
				 return $this->jp_min_prod_url;
				
			  }
			  if($company=='Golcha Talc')
			  {
				 return $this->golcha_prod_url;
				
			  }
			  if($company=='Golcha Minerals Pvt.Ltd.')
			  {
			      return $this->golcha_min_prod_url;
			  }
    }
    public function get_address_url($company)
    {
    	      if($company=='UMDS')
			   {
				  return $this->umds_add_url;
			  }
			  if($company=='S.ZORASTER')
			  {
				 return  $this->zoraster_add_url;
			  } 
			  if($company=='Jaipur Mineral Development')
			  {
				 return $this->jp_min_add_url;
				
			  }
			  if($company=='Golcha Talc')
			  {
				 return $this->golcha_add_url;
				
			  }
			  if($company=='Golcha Minerals Pvt.Ltd.')
			  {
			      return $this->golcha_min_add_url;
			  }
    }
     public function get_url($company)
    {
    	      if($company=='UMDS')
			   {
				  return $this->umds_url;
			  }
			  if($company=='S.ZORASTER')
			  {
				 return  $this->zoraster_url;
			  } 
			  if($company=='Jaipur Mineral Development')
			  {
				 return $this->jp_min_url;
				
			  }
			  if($company=='Golcha Talc')
			  {
				 return $this->golcha_url;
				
			  }
			  if($company=='Golcha Minerals Pvt.Ltd.')
			  {
			      return $this->golcha_min_url;
			  }
    }
	public function change_webservice_data($global_id,$order_id,$mobile,$dname,$vehicle_no,$lr_rr_no,$lr_rr_date)
    {
		$this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order');
		$this->db->where('order_id',$order_id);
		$data1= $this->db->get()->result_array(); 
		//print_r($data);
		foreach($data1 as $get1)
		{
		 $key=$get1['order_key'];
		 $company=$get1['company'];
		}
		
		$timestamp = strtotime($lr_rr_date); 
		$lr_rr_date = date('Y-m-d', $timestamp);

            $url = $this->update_webservice_data_model->get_url($company);
              
					$curl = curl_init();
					$username = $this->username;
					$password = $this->password;
					$port=$this->port;
              
					  curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $url,
					  CURLOPT_USERPWD => $username.':'.$password,
					  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <LR_RR_No>".$lr_rr_no."</LR_RR_No>\n                <LR_RR_Date>".$lr_rr_date."</LR_RR_Date>\n                <Vehicle_No>".$vehicle_no."</Vehicle_No>\n                <Driver_Name>".$dname."</Driver_Name>\n                <Driver_Contact_No>".$mobile."</Driver_Contact_No>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 29fb60bf-b1ef-ce9c-4392-85aeec6f728f",
						"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					  //echo "cURL Error #:" . $err;
					} else {
					  //echo $response;
					}
                 
					if($response)
					{
						$res=array();
						  $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
			              $xml = new SimpleXMLElement($response);
			              $body = $xml->xpath('//SoapBody')[0];
			              $array = json_decode(json_encode((array)$body), TRUE); 
			              $res[] =$array['Update_Result']['DispatchOrders'];
			              foreach ($res as $value) {
			              	$key=$value['Key'];
			              }

			              $value=array(
										 'order_key' =>$key,
									 );
									$this->db->where('order_id', $order_id);
									$res = $this->db->update('dbo.sales_dispatched_order',$value);

					  return true;
				}
				 else{
							
				   return false;
			   }

		}

 public function update_date_time_webservice_get_in($date, $time,$order_id)
    {       
	    $this->db->where('order_id', $order_id);
        $res= $this->db->get('dbo.sales_dispatched_order')->row();
		$key=$res->order_key;
		$company=$res->company;
		//print_r($key); die;
	          /****1****/
	           $url = $this->update_webservice_data_model->get_url($company);

             $username = $this->username;
			 $password = $this->password;
			 $port=$this->port;

			  $curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_PORT => $port,
			  CURLOPT_URL => $url,
			  CURLOPT_USERPWD => $username.':'.$password,
              CURLOPT_HTTPAUTH => CURLAUTH_ANY,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <Gate_In_Time>".$time."</Gate_In_Time>\n                <Gate_In_Date>".$date."</Gate_In_Date>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
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
			 //echo "cURL Error #:" . $err;
			} else {
			// echo $response;
			}
              $res=array();
			  $response1 = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
              $xml = new SimpleXMLElement($response1);
              $body = $xml->xpath('//SoapBody')[0];
              $array = json_decode(json_encode((array)$body), TRUE); 
              $res[]=$array['Update_Result']['DispatchOrders'];
              foreach ($res as  $value) {
              	$key=$value['Key'];
              }

              $value=array(
							 'order_key' =>$key,
						 );
						$this->db->where('order_id', $order_id);
						$res = $this->db->update('dbo.sales_dispatched_order',$value);
              	
			
    }
    public function update_date_time_webservice_weight_out($date, $time,$order_id)
    {       
	    $this->db->where('order_id', $order_id);
        $res= $this->db->get('dbo.sales_dispatched_order')->row();
		$key=$res->order_key;
		$company=$res->company;
	          /****1****/

	           $url = $this->update_webservice_data_model->get_url($company);

              $username = $this->username;
			  $password = $this->password;
			  $port=$this->port;

			  $curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_PORT => $port,
			  CURLOPT_URL => $url,
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
			//  echo "cURL Error #:" . $err;
			} else {
			 // echo $response;
			}
			  $res=array();
			  $response1 = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
              $xml = new SimpleXMLElement($response1);
              $body = $xml->xpath('//SoapBody')[0];
              $array = json_decode(json_encode((array)$body), TRUE); 
              $res[]=$array['Update_Result']['DispatchOrders'];
              foreach ($res as $value) {
              	$key=$value['Key'];
              }

              $value=array(
							 'order_key' =>$key,
						 );
						$this->db->where('order_id', $order_id);
						$res = $this->db->update('dbo.sales_dispatched_order',$value);
			
    }
    function update_order_details_update_webservice($data)
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
				$company=$get1['company'];
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
				  $username = $this->username;
			      $password = $this->password;
			      $port=$this->port;
			      $url = $this->update_webservice_data_model->get_url($company);

                    $curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $url,
					  CURLOPT_USERPWD => $username.':'.$password,
				      CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <Posting_Date>".$delivery_date."</Posting_Date>\n                <Transporter_No>".$transporter_id."</Transporter_No>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 5ee9ab01-56a4-d1a4-6d84-3d19055888cb",
						"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					 // echo "cURL Error #:" . $err.'<br>';
					} else {
					 // echo $response;
					}
					if($response)
					{
						//echo 'hello';
						
						//die;
					$this->db->where('order_id', $order_id);
					$query1 = $this->db->delete('dbo.order_details');
					$this->db->where('order_id', $order_id);
					if($this->db->delete('dbo.attn_required'))
				    {
					
					$value=array(
						 'delivery_date' =>$delivery_date,
						 'trans_no' =>$transporter_id ,
						 
					 );
					$this->db->where('order_id', $order_id);
					$res = $this->db->update('dbo.sales_dispatched_order',$value);
					return $res;
					}
					else{
						 return false;
					}
					}
                   else		{
					   return false;
				   }										   

		}
		else if($query->delivery_date != $delivery_date)
		{
			      $username = $this->username;
			      $password = $this->password;
			      $port=$this->port;
			      $url = $this->update_webservice_data_model->get_url($company);

                    $curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_PORT => "7048",
					  CURLOPT_URL => "http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Page/DispatchOrders",
					  CURLOPT_USERPWD => $username.':'.$password,
					  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <Posting_Date>".$delivery_date."</Posting_Date>\n                <Transporter_No>".$transporter_id."</Transporter_No>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 5ee9ab01-56a4-d1a4-6d84-3d19055888cb",
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
					if($response)
					{
						
					$this->db->where('order_id', $order_id);
					$query1 = $this->db->delete('dbo.order_details');
					$this->db->where('order_id', $order_id);
					if($this->db->delete('dbo.attn_required'))
					{
						$value=array(
							 'delivery_date' =>$delivery_date,
							 'trans_no' =>$transporter_id ,
							 
						 );
						$this->db->where('order_id', $order_id);
						$res = $this->db->update('dbo.sales_dispatched_order',$value);
					    return $res;
					}
					else{
						
						 return false; 
					}
					}
                   else	
					   {
					   return false;
				   }	
		
	     }
	}
	function accept_order_update_webservice($data)
	{
		//print_r($data); die;
        date_default_timezone_set("Asia/Calcutta");
     	$this->db->select('*');
        $this->db->from('dbo.orders_change_details');
	    $this->db->where('order_id',$data['order-id']);
		$data1= $this->db->get()->result_array(); 
			//print_r($data1);
			foreach($data1 as $get)
			{
				$vehicle_id=$get['vehicle_id'];
				$driver_id=$get['driver_id'];
				$delivery_date=$get['delivery_date'];
				$gps_enabled=$get['gps_enabled'];
			}
			$timestamp = strtotime($delivery_date); 
		    $delivery_date = date('Y-m-d', $timestamp);

        $this->db->select('*');
        $this->db->from('dbo.sales_dispatched_order');
	    $this->db->where('order_id',$data['order-id']);
			$data1= $this->db->get()->result_array(); 
			//print_r($data);
			foreach($data1 as $get1)
			{
				$key=$get1['order_key'];
				$company=$get1['company'];
			}
			    $this->db->select('*');
					$this->db->from('dbo.vehicle');
				$this->db->where('id', $vehicle_id );
				$query = $this->db->get();
				$row = $query->result_array();
			
				foreach( $row as $value ) {
					$vehicle_no=$value['registration_no'];
					$insurance_no=$value['insurance'];
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


                  $username = $this->username;
			      $password = $this->password;
			      $port=$this->port;
			      $url = $this->update_webservice_data_model->get_url($company);

								////11111//////
								  $curl = curl_init();
								  curl_setopt_array($curl, array(
								  CURLOPT_PORT => $port,
								  CURLOPT_URL => $url,
								  CURLOPT_USERPWD => $username.':'.$password,
								  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 30,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "POST",
								  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <Posting_Date>".$delivery_date."</Posting_Date>\n                <Vehicle_No>".$vehicle_no."</Vehicle_No>\n                <Driver_Name>".$dname."</Driver_Name>\n                <Driver_Contact_No>".$mobile."</Driver_Contact_No>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
									  CURLOPT_HTTPHEADER => array(
										"cache-control: no-cache",
										"content-type: text/xml",
										"postman-token: bdf215dd-402d-6c91-4a1c-5364e2289738",
										"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
									  ),
									));
								$response = curl_exec($curl);
								$err = curl_error($curl);

								curl_close($curl);

								if ($err) {
								  //echo "cURL Error #:" . $err; 
								} else {
								  //echo $response; 
								}
								if($response)
								{
									
									$value=array(
											'vehicle_id' => $vehicle_id,
											'driver_id' => $driver_id,
											'order_status' => 'Inprocess',
											'shipping_status' => 'Awaiting For Arrival',
											'gps_enabled' => $gps_enabled,
											'insurance_no' => $insurance_no,
												 
										);
										/* 
										 print_r($value);
										die;  */
										$this->db->where('order_id',$data['order-id']);
										$query = $this->db->update('dbo.order_details',$value);
										if(! $query)
										{
											
											print_r($this->db->error());
											die;
										}
										else{
											
									      $value=array(
											
											'delivery_date' => $delivery_date,
										); 
										
										/* print_r($value);
										die; */
										$this->db->where('order_id',$data['order-id']);
										$query = $this->db->update('dbo.sales_dispatched_order',$value);
										$this->db->where('id',$data['accept_id']);
										$query1 = $this->db->delete('dbo.orders_change_details');
										return $query; 
								   }
								}
								else
								{	
									return false;
								}
		}

	function cancel_accept_order_update_webservice($data)
	{
		$order_id=$data['order-id'];
		$accept_id=$data['accept_id'];
		$trans_no=$data['trans_no'];
		$delivery_date = date("Y-m-d", strtotime($data['delivery_date']));
		$this->db->select('*');
		$this->db->from('dbo.order_details as d');
		$this->db->join('dbo.sales_dispatched_order as s', 's.order_id = d.order_id');
		$this->db->where('d.order_id', $order_id);
		$res = $this->db->get()->result_array();
		foreach($res as $val)
		{
			$delivery=$val['delivery_date'];
			$trans=$val['trans_no'];
		}
		if($trans_no=='')
		{
			$trans_no=$trans;
		}
		else
		{
			$trans_no=$trans_no;
		}
		if($delivery_date=='')
		{
			$delivery_date=$delivery;
		}
		else
		{
			$delivery_date=$delivery_date;
		}
		$delivery_date = date("Y-m-d", strtotime($delivery_date));

		//echo  $trans_no;
		//echo  $data['delivery_date']; die;
		
           $this->db->select('*');
           $this->db->from('dbo.sales_dispatched_order');
		   $this->db->where('order_id',$order_id);
				$data1= $this->db->get()->result_array(); 
				foreach($data1 as $get1)
				{
					$key=$get1['order_key'];
					$company=$get1['company'];
				}
				  $username = $this->username;
			      $password = $this->password;
			      $port=$this->port;
			      $url = $this->update_webservice_data_model->get_url($company);

				     $curl = curl_init();
					 curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $url,
					  CURLOPT_USERPWD => $username.':'.$password,
					  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <Posting_Date>".$delivery_date."</Posting_Date>\n                <Transporter_No>".$trans_no."</Transporter_No>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 1d203c25-d7d1-bfe0-24d7-e2ca0b2f6758",
						"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					 // echo "cURL Error #:" . $err;
					} else {
					  //echo $response;
					}
					if($response)
					{
							$value=array(
									'delivery_date' => $delivery_date,
									'trans_no' => $trans_no,	
							);
							$this->db->where('order_id',$order_id);
							$query = $this->db->update('dbo.sales_dispatched_order',$value);
							if(! $query)
							{
								print_r($this->db->error());
								die;
							}
							$this->db->where('id',$accept_id);
							$query1 = $this->db->delete('dbo.orders_change_details');
							$this->db->where('order_id', $order_id);
							$query1 = $this->db->delete('dbo.order_details');
							return $query; 
					}
					else{
						return false;
					}
					
	    }
	    public function open_for_bid_order_update_webservice($res)
	   {
			$res = $this->input->post();
			$order_id=$res['open_bid_id'];
			$this->db->select('*');
			$this->db->from('dbo.sales_dispatched_order');
			$this->db->where('order_id', $order_id );
			$sql = $this->db->get()->row();
			$company=$sql->company;
			$order_key=$sql->order_key;
			$transporter='';
			
	                  $username = $this->username;
				      $password = $this->password;
				      $port=$this->port;
				      $url = $this->update_webservice_data_model->get_url($company);
					 
			          $curl = curl_init();
					  curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $url,
					  CURLOPT_USERPWD => $username.':'.$password,
	                  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					 CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$order_key."</Key>\n                <Transporter_No>".$transporter."</Transporter_No>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 348c9a71-e2fa-e820-67b7-a96af4cf24bc",
						"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);
		    		if ($err) {
						// echo "cURL Error #:" . $err;
					  
					} else {
					}
					 if($response)
					 {
					//echo $response;
					    $this->db->where('order_id', $order_id);
	                    $result = $this->db->delete('dbo.attn_required'); 
						$this->db->where('order_id', $order_id);
	                    $result = $this->db->delete('dbo.order_details'); 
						
						$update=array(
			            'trans_no' => '',
			            );
			 	       $this->db->where('order_id', $order_id);
				       $query = $this->db->update('dbo.sales_dispatched_order',$update);
				       return $query;
					}
					else
					{
					  return false;	
					}	      			
	      }

 public function update_transporter_update_webservice()
	{
		 $res = $this->input->post();
		// print_r($res);
		$trans_id=$res['trans_id'];
		$company=$res['company'];
		$order_key=$res['order_key'];
		//echo $company;
		              $username = $this->username;
				      $password = $this->password;
				      $port=$this->port;
				      $url = $this->update_webservice_data_model->get_url($company);
                  
		          $curl = curl_init();
				  curl_setopt_array($curl, array(
				  CURLOPT_PORT => $port,
				  CURLOPT_URL => $url,
				  CURLOPT_USERPWD => $username.':'.$password,
                  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				 CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$order_key."</Key>\n                <Transporter_No>".$trans_id."</Transporter_No>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
				  CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"content-type: text/xml",
					"postman-token: 348c9a71-e2fa-e820-67b7-a96af4cf24bc",
					"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);
				if($response)
				{
				echo json_encode($err); 
			   }
					else
					{
						return false;
					}
	}
	 public function update_transporter_api_update_webservice($trans_id,$company,$order_key)
	{
		 
       
		              $username = $this->username;
				      $password = $this->password;
				      $port=$this->port;
				      $url = $this->update_webservice_data_model->get_url($company);
                  
		          $curl = curl_init();
				  curl_setopt_array($curl, array(
				  CURLOPT_PORT =>  $port,
				  CURLOPT_URL => $url,
				  CURLOPT_USERPWD => $username.':'.$password,
                  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				 CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$order_key."</Key>\n                <Transporter_No>".$trans_id."</Transporter_No>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
				  CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"content-type: text/xml",
					"postman-token: 348c9a71-e2fa-e820-67b7-a96af4cf24bc",
					"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);
				if($response)
				{
				return true;
			   }
				else
				{
					return false;
				}
	}	
	public function get_address_webservice($user_id,$company)
	{
		
		              $username = $this->username;
				      $password = $this->password;
				      $port=$this->add_port;
				      $url = $this->update_webservice_data_model->get_address_url($company);

		          $curl = curl_init();
				  curl_setopt_array($curl, array(
				  CURLOPT_PORT => $port,
				  CURLOPT_URL => $url,
				  CURLOPT_USERPWD => $username.':'.$password,
                  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <ReadMultiple xmlns=\"urn:microsoft-dynamics-schemas/page/shiptoaddress\">\n            <filter>\n                <Field>Code</Field>\n                <Criteria>".$user_id."*</Criteria>\n            </filter>\n        </ReadMultiple>\n    </Body>\n</Envelope>",
				  CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"content-type: text/xml",
					"postman-token: a8e26b31-fd6a-3153-b09d-d089005f3926",
					"soapaction: urn:microsoft-dynamics-schemas/page/shiptoaddress:ReadMultiple"
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				  //echo "cURL Error #:" . $err;
				} else {
					//echo $response;
				$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
				$xml = new SimpleXMLElement($response);
				$body = $xml->xpath('//SoapBody')[0];
				$array = json_decode(json_encode((array)$body), TRUE); 
				$total=$array['ReadMultiple_Result']['ReadMultiple_Result']['ShiptoAddress'];
				if(array_key_exists('0', $total))
				{
				$data=$array['ReadMultiple_Result']['ReadMultiple_Result']['ShiptoAddress'];
				}
				else{
				$data[]=$array['ReadMultiple_Result']['ReadMultiple_Result']['ShiptoAddress'];
				}
	
				if(empty($data)) 
				{
                  return false;
				}
				else
				{
				  return $data;
			   }
		} 
		       
	}
	public function get_product_webservice($user_id,$company)
	{
		
		              $username = $this->username;
				      $password = $this->password;
				      $port=$this->prod_port;
				      $url = $this->update_webservice_data_model->get_product_url($company);

		              $curl = curl_init();
					  curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $url,
					  CURLOPT_USERPWD => $username.':'.$password,
                      CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <ReadMultiple xmlns=\"urn:microsoft-dynamics-schemas/page/salesprice\">\n            <filter>\n                <Field>Sales_Code</Field>\n                <Criteria>".$user_id."</Criteria>\n            </filter>\n        </ReadMultiple>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 7a9723d7-473a-b63d-a781-67f5f38a0236",
						"soapaction: urn:microsoft-dynamics-schemas/page/salesprice:ReadMultiple"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					 // echo "cURL Error #:" . $err;

				} else {
					//echo $response;
				$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
				$xml = new SimpleXMLElement($response);
				$body = $xml->xpath('//SoapBody')[0];
				$array = json_decode(json_encode((array)$body), TRUE); 
				$total=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesPrice'];
				if(array_key_exists('0', $total))
				{
				$data=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesPrice'];
				}
				else{
				$data[]=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesPrice'];
				}
				
				if(empty($data)) 
				{
                  return false;
				}
				else
				{
				  return $data;
			   }
		} 
				//print_r($data);
		       
	}
	public function save_order_webservice($company,$state,$address,$product,$porder_no,$base64code,$date,$qty,$ext)
	{
		
				      $username = $this->username;
				      $password = $this->password;
				      $port=$this->save_port;
				      $url = $this->update_webservice_data_model->save_product_url($company);

					  $curl = curl_init();
					  curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $url,
					  CURLOPT_USERPWD => $username.':'.$password,
                      CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <CreateSaleOrder xmlns=\"urn:microsoft-dynamics-schemas/codeunit/CreateSalesOrder\">\n            <sellToCustomerNo>".$state."</sellToCustomerNo>\n            <shipToCode>".$address."</shipToCode>\n            <requestDate>".$date."</requestDate>\n            <pONo>".$porder_no."</pONo>\n            <itemNo>".$product."</itemNo>\n            <quantity>".$qty."</quantity>\n            <base64EncodedText>".$base64code."</base64EncodedText>\n            <fileExtension>".$ext."</fileExtension>\n        </CreateSaleOrder>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: dd4de1fe-05aa-0d08-e441-8099b02bc2c8",
						"soapaction: urn:microsoft-dynamics-schemas/codeunit/CreateSalesOrder:CreateSaleOrder"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					 return false;
					} else {
						return $response;
					}
	}
	public function get_inventory_webservice()
    {
      /* $auth=array(

             'username' => $this->username,
			 'password' => $this->password,
		     'port'     => $this->inventory_port

       );
       return $auth;*/
                                $username = $this->username;
								$password = $this->password;

                             	 $curl = curl_init();

								  curl_setopt_array($curl, array(
								  CURLOPT_PORT => $this->inventory_port,
								  CURLOPT_URL => $this->get_inventory,
							      CURLOPT_USERPWD => $username.':'.$password,
								  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 30,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "POST",
								  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <ReadMultiple xmlns=\"urn:microsoft-dynamics-schemas/page/fgdateandlocationwiserating\">\n             \n        </ReadMultiple>\n    </Body>\n</Envelope>",
								  CURLOPT_HTTPHEADER => array(
									"cache-control: no-cache",
									"content-type: text/xml",
									"postman-token: 481fa8b6-e085-b152-53ef-5dc98e4477c4",
									"soapaction: urn:microsoft-dynamics-schemas/page/fgdateandlocationwiserating:ReadMultiple"
								  ),
								));

								$response = curl_exec($curl);
								$err = curl_error($curl);

								curl_close($curl);

								if ($err) {
								  echo "cURL Error #:" . $err;
								} else {
								 $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
								$xml = new SimpleXMLElement($response);
								$body = $xml->xpath('//SoapBody')[0];
								$array = json_decode(json_encode((array)$body), TRUE); 
								$total=$array['ReadMultiple_Result']['ReadMultiple_Result']['FGDateandLocationWiseRating'];
								//print_r($data);
								if(array_key_exists('0', $total))
								{
								$data=$array['ReadMultiple_Result']['ReadMultiple_Result']['FGDateandLocationWiseRating'];
								}
								else{
								$data[]=$array['ReadMultiple_Result']['ReadMultiple_Result']['FGDateandLocationWiseRating'];
								}
                                 return $data;
									
								}

		
    }
    public function get_dispatches_webservice()
    {
      
                    	$username = $this->username;
				        $password = $this->password;
				        $port     = $this->dispatches_port;
						$curl = curl_init();

						  curl_setopt_array($curl, array(
						  CURLOPT_PORT => $this->dispatches_port,
						  CURLOPT_URL => $this->get_dispatches,
						  CURLOPT_USERPWD => $username.':'.$password,
						  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 30,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => "POST",
						  CURLOPT_POSTFIELDS => "<Envelope xmlns='http://schemas.xmlsoap.org/soap/envelope/'>
												<Body>
													<ReadMultiple xmlns='urn:microsoft-dynamics-schemas/page/dispatchrating'>
													</ReadMultiple>
												</Body>
											</Envelope>",
						  CURLOPT_HTTPHEADER => array(
							"cache-control: no-cache",
							"content-type: text/xml",
							"postman-token: 481fa8b6-e085-b152-53ef-5dc98e4477c4",
							"soapaction: urn:microsoft-dynamics-schemas/page/dispatchrating:ReadMultiple"
						  ),
						));

						$response = curl_exec($curl);
						$err = curl_error($curl);

						curl_close($curl);

						if ($err) {
						  echo "cURL Error #:" . $err;
						} else {
						 $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
						$xml = new SimpleXMLElement($response);
						$body = $xml->xpath('//SoapBody')[0];
						$array = json_decode(json_encode((array)$body), TRUE); 
						$total=$array['ReadMultiple_Result']['ReadMultiple_Result']['DispatchRating'];
						//print_r($data);
						if(array_key_exists('0', $total))
						{
						$data=$array['ReadMultiple_Result']['ReadMultiple_Result']['DispatchRating'];
						}
						else{
						$data[]=$array['ReadMultiple_Result']['ReadMultiple_Result']['DispatchRating'];
						}
                         return $data;
							
						}
						
								
		
    }
	function get_placed_order_webservice($global_id)
	{
		$this->db->select('DISTINCT(user_id) as user_id');
		$this->db->from('dbo.customer');
		$this->db->where('global_id',$global_id);
		$sql= $this->db->get()->result_array();
		//print_r($sql);
		$user_id=array();
		foreach($sql as $get)
		{
			$user_id[]=$get['user_id'];
			$count=count($user_id);
			
			//print_r($user_id);
		} 
		for($i=0;$i<$count;$i++)
		{
		          $username = $this->username;
			      $password = $this->password;
			      $port=$this->placed_port;

					  $curl = curl_init();
					  curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $this->umds_placed_url,
					  CURLOPT_USERPWD => $username.':'.$password,
                      CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <ReadMultiple xmlns=\"urn:microsoft-dynamics-schemas/page/salesorder\">\n            <filter>\n                <Field>Sell_to_Customer_No</Field>\n                <Criteria>".$user_id[$i]."</Criteria>\n            </filter>\n        </ReadMultiple>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 1c3705dd-02b4-b0a0-0831-944c594c0be0",
						"soapaction: urn:microsoft-dynamics-schemas/page/salesorder:ReadMultiple"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					  echo "cURL Error #:" . $err;
					} else {
					   // echo $response;
					    $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
						$xml = new SimpleXMLElement($response);
						$body = $xml->xpath('//SoapBody')[0];
						$array = json_decode(json_encode((array)$body), TRUE); 
						$total=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
						if(array_key_exists('0', $total))
						{
						$data=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
						}
						else{
						$data[]=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
				       }
					}
					/*2*/
					
					  $curl = curl_init();
					  curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $this->zoraster_placed_url,
					  CURLOPT_USERPWD => $username.':'.$password,
                      CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <ReadMultiple xmlns=\"urn:microsoft-dynamics-schemas/page/salesorder\">\n            <filter>\n                <Field>Sell_to_Customer_No</Field>\n                <Criteria>".$user_id[$i]."</Criteria>\n            </filter>\n        </ReadMultiple>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 1c3705dd-02b4-b0a0-0831-944c594c0be0",
						"soapaction: urn:microsoft-dynamics-schemas/page/salesorder:ReadMultiple"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					  echo "cURL Error #:" . $err;
					} else {
					   // echo $response;
					    $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
						$xml = new SimpleXMLElement($response);
						$body = $xml->xpath('//SoapBody')[0];
						$array = json_decode(json_encode((array)$body), TRUE); 
						$total1=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
						if(array_key_exists('0', $total1))
						{
						$data1=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
						}
						else{
						$data1[]=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
				       }
					}
					   /*3*/
					 
					  $curl = curl_init();
					  curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $this->jp_min_placed_url,
					 
					  CURLOPT_USERPWD => $username.':'.$password,
                      CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <ReadMultiple xmlns=\"urn:microsoft-dynamics-schemas/page/salesorder\">\n            <filter>\n                <Field>Sell_to_Customer_No</Field>\n                <Criteria>".$user_id[$i]."</Criteria>\n            </filter>\n        </ReadMultiple>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 1c3705dd-02b4-b0a0-0831-944c594c0be0",
						"soapaction: urn:microsoft-dynamics-schemas/page/salesorder:ReadMultiple"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					  echo "cURL Error #:" . $err;
					} else {
					   // echo $response;
					    $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
						$xml = new SimpleXMLElement($response);
						$body = $xml->xpath('//SoapBody')[0];
						$array = json_decode(json_encode((array)$body), TRUE); 
						$total2=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
						if(array_key_exists('0', $total2))
						{
						$data2=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
						}
						else{
						$data2[]=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
				       }
					}
					     /*4*/
					
					  $curl = curl_init();
					  curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $this->golcha_placed_url,
					  CURLOPT_USERPWD => $username.':'.$password,
                      CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <ReadMultiple xmlns=\"urn:microsoft-dynamics-schemas/page/salesorder\">\n            <filter>\n                <Field>Sell_to_Customer_No</Field>\n                <Criteria>".$user_id[$i]."</Criteria>\n            </filter>\n        </ReadMultiple>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 1c3705dd-02b4-b0a0-0831-944c594c0be0",
						"soapaction: urn:microsoft-dynamics-schemas/page/salesorder:ReadMultiple"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					  echo "cURL Error #:" . $err;
					} else {
					   // echo $response;
					    $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
						$xml = new SimpleXMLElement($response);
						$body = $xml->xpath('//SoapBody')[0];
						$array = json_decode(json_encode((array)$body), TRUE); 
						$total3=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
						if(array_key_exists('0', $total3))
						{
						$data3=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
						}
						else{
						$data3[]=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
				       }
					}
					   /*5*/
					
					  $curl = curl_init();
					  curl_setopt_array($curl, array(
					  CURLOPT_PORT => $port,
					  CURLOPT_URL => $this->golcha_min_placed_url,
					  CURLOPT_USERPWD => $username.':'.$password,
                      CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <ReadMultiple xmlns=\"urn:microsoft-dynamics-schemas/page/salesorder\">\n            <filter>\n                <Field>Sell_to_Customer_No</Field>\n                <Criteria>".$user_id[$i]."</Criteria>\n            </filter>\n        </ReadMultiple>\n    </Body>\n</Envelope>",
					  CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: text/xml",
						"postman-token: 1c3705dd-02b4-b0a0-0831-944c594c0be0",
						"soapaction: urn:microsoft-dynamics-schemas/page/salesorder:ReadMultiple"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					  echo "cURL Error #:" . $err;
					} else {
					   // echo $response;
					    $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
						$xml = new SimpleXMLElement($response);
						$body = $xml->xpath('//SoapBody')[0];
						$array = json_decode(json_encode((array)$body), TRUE); 
						$total4=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
						if(array_key_exists('0', $total4))
						{
						$data4=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
						}
						else{
						$data4[]=$array['ReadMultiple_Result']['ReadMultiple_Result']['SalesOrder'];
				       }
					   
					}
					$res = array_merge($data,$data1,$data2,$data3,$data4);
				 return $res;
	
		}
	}					
}
?>