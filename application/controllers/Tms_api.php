<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."libraries/lib/config_paytm.php");
require_once(APPPATH."libraries/lib/encdec_paytm.php");
class Tms_api extends CI_Controller
{
    public function __construct()
    {
         parent::__construct();
		 $this->load->database();
		  $this->load->model('tms_api_model');
		  $this->load->model('sms');
		  $this->load->model('notification_save');
		  $this->load->model('email_save');
		  $this->load->model('update_webservice_data_model');
		 $this->load->helper(array('form', 'url'));
        date_default_timezone_set("Asia/Calcutta");
    }
	public function scanner_login()
	{
		$otp = mt_rand(1111,9999);
		$json              = array();
        $mobile           = $this->input->post('mobile');
        $Isvalidated       = true;
        if ($mobile == '') {
            $message     = 'mobile is blank';
            $Isvalidated = false;
        }
   
        if ($Isvalidated) {
            $data = $this->tms_api_model->scanner_login($mobile);
           if($data)
		   {
			   foreach($data as $get)
			   {
				
				   $user_id=$get['id'];
				   $user_type=$get['user_type'];
			   }
			    $save_otp=array(
		
				'otp' => $otp ,
				);
				$this->db->where('id', $user_id);
		         $sql=$this->db->update('dbo.scanner_login', $save_otp);
				
			   /*******send sms otp**********/
				$otp_message=$otp.' Is your login OTP';
				$data = $this->sms->sms($mobile,$otp_message);
				 $response['user_type'] = $user_type;
				 $response['otp'] = $otp;
                $response['status']  = "TRUE";
                $response['message'] = "SUCCESS";
               
                $response['user_id'] = $user_id;
               
                echo json_encode($response);
            } else {
                $response['status']  = "FALSE";
                $response['message'] = "You Are Not Registerd";
                echo json_encode($response);
            }
        } else {
            $json['status']  = "FALSE";
            $json['message'] = $message;
            echo json_encode($json);
        }
  
	}
	public function otp_verify()
	{
		$json              = array();
        $otp           = $this->input->post('otp');
        $user_id           = $this->input->post('user_id');
 
        $Isvalidated       = true;
        if ($user_id == '') {
            $message     = 'user id is blank';
            $Isvalidated = false;
        }
		
		if ($otp == '') {
            $message     = 'otp  is blank';
            $Isvalidated = false;
        }
		 
        if ($Isvalidated) {
			
            $data = $this->tms_api_model->otp_check($user_id,$otp);
			
			   
           if($data)
		   {
			   foreach($data as $get)
			   {
				   $user_type=$get['user_type'];
				   
			   }
			    $response['user_id']  = $user_id;
			    $response['user_type']  = $user_type;
			    $response['status']  = "TRUE";
                $response['message'] = "Login Sucessfully";
                echo json_encode($response);
            } else {
                $response['status']  = "FALSE";
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
	    $mobile           = $this->input->post('mobile');
		$otp = mt_rand(1111,9999);
		 $Isvalidated       = true;
        if ($user_id == '') {
            $message     = 'user id is blank';
            $Isvalidated = false;
        }
		
		 
        if ($Isvalidated) {
			  $save_otp=array(
		
				'otp' => $otp ,
				);
				$this->db->where('id', $user_id);
		        $sql=$this->db->update('dbo.scanner_login', $save_otp);
		if($sql)
		{
		 /*******send sms otp**********/
			$otp_message=$otp.' Is your login OTP';
			$data = $this->sms->sms($mobile,$otp_message);
			$response['otp']  = $otp;
			$response['status']  = "TRUE";
			$response['message'] = "OTP Send Sucessfully";
			echo json_encode($response);
		}
		else{
		    $response['status']  = "FALSE";
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
	public function get_today_dispatched_order()
	{
		$json              = array();
		$date     =    date('Y-m-d');
		$status           = $this->input->post('status');
        $data = $this->tms_api_model->get_today_dispatched_order($status);
		//print_r($data); die;
           if($data)
		   {
		        foreach($data as $get)
				{
					
								  $qty_to_ship = explode(',', $get['qty_to_ship']);
								  $quantity = explode(',', $get['quantity']);
								  $item_code = explode(',', $get['item_code']);
								  $description = explode(',', $get['description']);
					  $delivery_date = explode(',',$get['delivery_date']);
					  $a=array();
					  $item=array();
					  $qua=array();
					  $des=array();
					  $qty_to=array();
					  
					   /* foreach($delivery_date as $key => $pdate) {
							$s=$pdate;
						}*/
                          //  if ($pdate == $date)
							// {
								 foreach($qty_to_ship as $qty_key => $qty) {
									  
                                         if ($qty > '0')
										 {
					                      if (array_key_exists($qty_key, $item_code)) {
											  $item[]=$item_code[$qty_key];
                                                 $response['item_code'] =implode(',',$item);
								 }}}
										 foreach($qty_to_ship as $qty_key => $qty) {
											 
                                         if ($qty > '0')
										 {
                                        
					                      if (array_key_exists($qty_key, $quantity)) {
                                                 $qua[] =$quantity[$qty_key];
												  $response['quantity'] =implode(',',$qua);
										 }}}
										 foreach($qty_to_ship as $qty_key => $qty) {
											 
                                         if ($qty > '0')
										 {
											 $qty_to[]=$qty; 
                                         $response['qty_to_ship'] =implode(',',$qty_to);;
					                      }}
										 foreach($qty_to_ship as $qty_key => $qty) {
											 
                                        
                                         if ($qty > '0')
										 {
					                      if (array_key_exists($qty_key, $description)) {
                                                 $des[] =$description[$qty_key];
												  $response['description'] =implode(',',$des);
										 }}}
										foreach($qty_to_ship as $qty_key => $qty) { 
										
                                
									  if ($qty > '0')
										 {
									 if (array_key_exists($qty_key, $delivery_date)) {
                                                 $a[]=$pdate;
							        //$response['delivery_date']= implode(',',$a); 
										 }
						    
										} 	}				
							$response['transporter_name'] =$get['transporter_name'];
							
							$response['order_id'] =$get['order_id'];
							$response['order_status'] =$get['status'];
							$response['driver_name'] =$get['driver_name'];
							$response['vehicle_no'] =$get['vehicle_no'];
							$response['state_code'] =$get['state_code'];
							$response['company'] =$get['company'];
							$response['delivery_date'] =$get['delivery_date'];
							$response['sales_status'] =$get['sales_status'];
							 $json[]=$response;
							// $last_key = key(array_slice($json, -1, true));
							//list($last_key) = each(array_reverse($arr));
                              //print $last_key;
							 //}//
						 //}//
				               
				}
                $response1['status']  = "TRUE";
                $response1['message'] = "SUCCESS";
                $response1['data'] = $json;
                echo json_encode($response1);
            } else {
				$response['data'] = $data;
                $response['status']  = "FALSE";
                $response['message'] = "NO ORDERS FOUND";
                echo json_encode($response);
            }
       
  
	}
	public function order_status()
	{
		$json              = array();
        $status           = $this->input->post('status');
        $order_id           = $this->input->post('order_id');
        $time           = $this->input->post('time');
		date_default_timezone_set("Asia/Calcutta");  
        $date=date('Y-m-d');
	    $newdate=$date." ".$time;
	    //echo $newdate; die;
        $Isvalidated       = true;



        if ($status == '') {
            $message     = 'status is blank';
            $Isvalidated = false;
        }
         if ($order_id == '') {
            $message     = 'order id is blank';
            $Isvalidated = false;
        }
		 
        if ($Isvalidated) {
			if($status=='Gate In') 
			{ 
				$save=array(
		       'shipping_status' =>  $status,
		       'gate_in_date' =>  $newdate,
			   );
			   $data = $this->tms_api_model->change_status($order_id, $save);
			   $result = $this->update_webservice_data_model->update_date_time_webservice_get_in($date,$time,$order_id);
			     if($data)
		         {
                   $sender='driver';
                   $receiver='transporter,admin';
                   $result = $this->notification_save->save_notification_all($order_id,'gate_in',$sender,$receiver);

                   $sender='driver';
                   $receiver='transporter,admin';
                   $result = $this->email_save->save_email_all($order_id,'gate_in',$sender,$receiver);
                  
			    $response['status']  = "TRUE";
                $response['message'] = "SUCCESS";
                echo json_encode($response);
            } else {
                $response['status']  = "FALSE";
                $response['message'] = "SOMTHING WENT WRONG";
                echo json_encode($response);
            }
			}
			else if($status=='Tare Weight (Weighbridge)'){
			
			$save=array(
		    'shipping_status'=>  $status,
		     'tare_weight_date'=>  $newdate,
		 
		 );
		 $data = $this->tms_api_model->change_status($order_id, $save);
		   if($data)
		   {
		   	       $sender='driver';
                   $receiver='transporter,admin';
                   $result = $this->notification_save->save_notification_all($order_id,'weight_in',$sender,$receiver);
			    $response['status']  = "TRUE";
                $response['message'] = "SUCCESS";
                echo json_encode($response);
            } else {
                $response['status']  = "FALSE";
                $response['message'] = "SOMTHING WENT WRONG";
                echo json_encode($response);
            }
			}
			else if($status=='Gross Weight (Weighbridge)'){
			
			$save=array(
		    'shipping_status'=>  $status,
		     'gross_weight_date'=>  $newdate,
		 
		 );
		 $data = $this->tms_api_model->change_status($order_id, $save);
		 $result = $this->update_webservice_data_model->update_date_time_webservice_weight_out($date,$time,$order_id);
		   if($data)
		   {
		           $sender='driver';
                   $receiver='transporter,admin';
                   $result = $this->notification_save->save_notification_all($order_id,'weight_out',$sender,$receiver);

                   $sender='driver';
                   $receiver='transporter,admin';
                   $result = $this->email_save->save_email_all($order_id,'weight_out',$sender,$receiver);

			    $response['status']  = "TRUE";
                $response['message'] = "SUCCESS";
                echo json_encode($response);
            } else {
                $response['status']  = "FALSE";
                $response['message'] = "SOMTHING WENT WRONG";
                echo json_encode($response);
            }
			}
			else if($status=='Loading'){
			
			$save=array(
		    'shipping_status'=>  $status,
		     'loading_date'=>  $newdate,
		 
		 );
		 $data = $this->tms_api_model->change_status($order_id, $save);
		   if($data)
		   {
		   	       $sender='driver';
                   $receiver='transporter,admin';
                   $result = $this->notification_save->save_notification_all($order_id,'loading_in',$sender,$receiver);

                   $sender='driver';
                   $receiver='transporter,admin';
                   $result = $this->email_save->save_email_all($order_id,'loading_in',$sender,$receiver);

			    $response['status']  = "TRUE";
                $response['message'] = "SUCCESS";
                echo json_encode($response);
            } else {
                $response['status']  = "FALSE";
                $response['message'] = "SOMTHING WENT WRONG";
                echo json_encode($response);
            }
			}
			else if($status=='Loading Out'){
			
			 $save=array(
		    'shipping_status'=>  $status,
		     'loading_out_date'=>  $newdate,
		 
		 );
		 $data = $this->tms_api_model->change_status($order_id, $save);
		   if($data)
		   {
	   	       $sender='driver';
               $receiver='transporter,admin';
               $result = $this->notification_save->save_notification_all($order_id,'loading_out',$sender,$receiver);

               $sender='driver';
               $receiver='transporter,admin';
               $result = $this->email_save->save_email_all($order_id,'loading_out',$sender,$receiver);

			    $response['status']  = "TRUE";
                $response['message'] = "SUCCESS";
                echo json_encode($response);
            } else {
                $response['status']  = "FALSE";
                $response['message'] = "SOMTHING WENT WRONG";
                echo json_encode($response);
            }
			}
		 else if($status=='Dispatched')
		 {
			 $otp = mt_rand(1111,9999);
			 $res = $this->tms_api_model->check_invoice($order_id);
			// print_r($res); die;
			 if($res)
			 {
				 $save=array(
		         'shipping_status'=>  $status,
		         'gate_out_date'=>  $newdate,
		         'otp' =>  $otp,
		 
		        );
				$result = $this->tms_api_model->change_status($order_id, $save); 
				$this->db->where('order_id', $order_id);
		        $this->db->delete('dbo.sales_dispatched_order');
			
				  if($result)
		   {
				$this->db->select('*');
				$this->db->from('dbo.order_details as d');
				$this->db->join('dbo.customer as c', 'c.user_id = d.cust_no','left outer');
				$this->db->where('d.order_id', $order_id );
				$query = $this->db->get()->row(); 
				$mobile=$query->mobile;
				$mobile_number[0] = explode(',',trim($mobile));
			     /*******send sms otp**********/
			    $otp_message = $otp.'Is your Delivery order OTP.';
			    $data = $this->sms->sms($mobile_number[0],$otp_message);

               $sender='driver';
               $receiver='transporter,admin,customer';
               $result = $this->notification_save->save_notification_all($order_id,'dispatched',$sender,$receiver);
              
               $sender='driver';
               $receiver='transporter,admin,customer';
               $result = $this->sms_save->save_sms_all($order_id,'dispatched',$sender,$receiver);

               $sender='driver';
               $receiver='transporter,admin,customer';
               $result = $this->email_save->save_email_all($order_id,'dispatched',$sender,$receiver);

			    $response['status']  = "TRUE";
                $response['message'] = "SUCCESS";
                echo json_encode($response);
            } else {
                $response['status']  = "FALSE";
                $response['message'] = "SOMTHING WENT WRONG";
                echo json_encode($response);
            }
				
			} 
			else{
				$response['status']  = "FALSE";
                $response['message'] = "INVOICE NOT GANERATE";
                echo json_encode($response);
			}
		 }
		
         
        } else {
            $json['status']  = "FALSE";
            $json['message'] = $message;
            echo json_encode($json);
        }
  
	}
				public function approve_coupon_notification()
					{ 
						   $device_id1='enBuO84Ny3U:APA91bGNw8nenIfjEuLs0QTdvG3-Cx32tH8ZD31Hp6nGlaDSDaGU50Vuab6dY_7uDtiUH2HM9lCliRzk-mkMHtwz5RuI69x29P1cBE9NbQBaKsWnGtwon_fhXrWU-TFa-V8vCvsT4Orj';
						   
						   //registration_ids
						   $msg=array(
						   
						   'message' => 'hello',
						   
						   );
						   
							$fields = array(
								'to' => $device_id1,
								'data' => $msg
							 );
							$headers = array(
								'Authorization: key=' . 'AAAAdL8NcC8:APA91bFwOG36EnLGT_GMzPeVeNHeMktGw7I1SfIjOP9Bq66bdxYI_8wG1yi8MgZZEXrk9wmGzpc83BH25nlhQgFGaPEynSYWltFco3nGdw_PNlOP6vTeOJY93tK5L94KG4NFM3VF8geM',
								'Content-Type: application/json'
							);
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
							$result = curl_exec($ch);
							curl_close($ch);
							echo  $result;
							

					}
					public function paytm()
					{
					
                     // following file need to be included
					require_once("lib/encdec_paytm.php");
					$orderId = "ORDS85011264";
					$merchantMid = "Scient30971118299007";
					$merchantKey = "%@C9KoYV9b7Ba5dQ";
					$paytmParams["MID"] = $merchantMid;
					$paytmParams["ORDERID"] = $orderId; 
					$paytmChecksum = getChecksumFromArray($paytmParams, $merchantKey);
					$paytmParams['CHECKSUMHASH'] = urlencode($paytmChecksum);
					$postData = "JsonData=".json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
					$connection = curl_init(); // initiate curl
					// $transactionURL = "https://securegw.paytm.in/merchant-status/getTxnStatus"; // for production
					$transactionURL = "https://securegw-stage.paytm.in/merchant-status/getTxnStatus";
					curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($connection, CURLOPT_URL, $transactionURL);
					curl_setopt($connection, CURLOPT_POST, true);
					curl_setopt($connection, CURLOPT_POSTFIELDS, $postData);
					curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($connection, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
					$responseReader = curl_exec($connection);
					$responseData = json_decode($responseReader, true);
					echo "<pre>"; print_r($responseData); echo "</pre>";
					}	

                     public function StartPayment()
                 {
				            $mid=PAYTM_MERCHANT_MID;
				            $website=PAYTM_MERCHANT_WEBSITE;
				            $key=PAYTM_MERCHANT_KEY;
							
				    $orderId="ORDS" . rand(1000,9999999);
					$paramList["MID"] = $mid;
					$paramList["ORDER_ID"] = $orderId;      
					$paramList["CUST_ID"] = 344;   /// according to your logic
					$paramList["INDUSTRY_TYPE_ID"] = 'RETIAL';
					$paramList["CHANNEL_ID"] = 'WEB';
					$paramList["TXN_AMOUNT"] = 50;
					$paramList["WEBSITE"] = $website;
				
					$paramList["CALLBACK_URL"] = "http://45.114.141.43:88/scm-live/index.php/Tms_api/PaytmResponse";
					$paramList["MSISDN"] = '77777777'; //Mobile number of customer
					$paramList["EMAIL"] ='foo@gmail.com';
					$paramList["VERIFIED_BY"] = "EMAIL"; //
					$paramList["IS_USER_VERIFIED"] = "YES"; //
				  //  print_r($paramList);
					$checkSum = getChecksumFromArray($paramList,$key);

                   ?>

						<!--submit form to payment gateway OR in api environment you can pass this form data-->
					
						<form id="myForm" action="<?php echo PAYTM_TXN_URL ?>" method="post">
						<?php
						 foreach ($paramList as $a => $b) {
						echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
					   }
					   ?>
							<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
						</form>
						<script type="text/javascript">
							document.getElementById('myForm').submit();
						 </script>
				  
						 <?php
                    }

				/////////// response from paytm gateway////////////
				public function PaytmResponse()
				{
					
					$paytmChecksum = "";
					$paramList = array();
					$isValidChecksum = "FALSE";

					$paramList = $_POST;
					echo "<pre>";
					print_r($paramList);
				
			     $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
			
			       $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
			
			       if($isValidChecksum == "TRUE")
			        {
			            if ($_POST["STATUS"] == "TXN_SUCCESS")
			            { /// put your to save into the database // tansaction successfull
			                var_dump($paramList);
			            }
			           else {/// failed
			               var_dump($paramList);
			           }
			       }else
			       {
					   //////////////suspicious
			           // put your code here
			       
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
     function abc()
    {
 /* $this->load->library('email');
  $this->email->from('you@thevikasenterprises.com', 'scientific123');
  $this->email->to('websscientific@gmail.com');
  $this->email->subject('This is my subject');
  $this->email->message('This is my message');
  $this->email->attach('http://thevikasenterprises.com/thecouplecouponbook/img/upload/admin/75ae4890c98a0586466bdce0528bef25.jpg');
  $this->email->attach('http://thevikasenterprises.com/thecouplecouponbook/img/upload/a.xlsx'); 
  
  if($this->email->send())
  {
    echo 'sccuess';
  }
  else
  {
    echo 'not';

  }*/

        $to = 'websscientific@gmail.com';
        $subject   = 'asdasd';
        $message   = 'asdadasd';
        $header    = "From:info@45.114.141.43:88 \r\n";
        $header   .= "MIME-Version: 1.0\r\n";
        $header   .= "Content-type: text/html\r\n";
        $retval = mail($to, $subject, $message, $header);
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
    }  
    public function send_notification()
		{
		       $device_id='dGyhzrkI9LY:APA91bE9ahWJr8KerT2bXSHk-A8n31f8VjXofHvKH1Wi-ytn18Iy2Q0oLbFINErrzYdvpWmUAomfV3RvzyzjdppJMhTxNptLLDoUAbyUEkMZgc3M6vcfcClz8Vk2KIL8IAJaarHzTo74';
			   
			   //registration_ids
			   $msg=array(
			   'message' => 'hii',	
			   'title'   => 'fff',		  
			   );
				$fields = array(
					'to' => $device_id,
                    'data' => $msg,
					'priority' => 'high',
					'notification' => array(
						'title' => 'fff',
						'body' => 'dsd',
					)
				 );
				//print_r($fields);
				
				$headers = array(
				// old firebase //	'Authorization: key=' .'AAAA9TlbBq4:APA91bF5hB1gBZy_8x9kZJS0GsC89sXYyB7d8L7XjKCZPjqFm7qaBbBFVbdZibkbA8bvujnzH0HVVmkoGddXeLokUCAmQboe3zLEdFVlyeeEFADEA_s94RQZb9H0hsGsiPizqji4Xpey',

					'Authorization: key=' .'AAAAzdN-fRs:APA91bE0Yy6goCYE5gPvl-Ruvmu1z_RsYP7jMyVB2GtjIAN7VknPMZZ9VjAUfbNZYikZy9orQc1H3_GqEDGB2qp0_Rkp2ulB79EqZfpvcX6MyMjLIpgpFxgOAsv51FENaQBsL8IXb8rg',

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

		public function update_date_time_webservice_get_in(){       
	   
               $username = 'scm';
	           $password = 'scm@3112';
			
			  $curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_PORT => '1132',
			  CURLOPT_URL => 'http://myerp.golchagroup.com:1132/DummyGST/WS/UMDS%20Pvt.Ltd./Page/DispatchOrders',
			  CURLOPT_USERPWD => $username.':'.$password,
              CURLOPT_HTTPAUTH => CURLAUTH_ANY,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>56;bsMAAACLAQAAAAJ7/0QASQBTAFwARABFAEMAMQA4AFwAMAAwADAAMQ==9;2850395861;13;DispatchLines1;64;b8MAAACLAQAAAAJ7/0QASQBTAFwARABFAEMAMQA4AFwAMAAwADAAMQAAAACHECc=9;2849470890;</Key>\n                <Gate_In_Time>00:00:00.0000000</Gate_In_Time>\n                <Gate_In_Date>2019-04-06</Gate_In_Date>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
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

			}
			echo $responce;
		 	$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
              $xml = new SimpleXMLElement($response);
              $body = $xml->xpath('//SoapBody')[0];
              $array = json_decode(json_encode((array)$body), TRUE); 
              $res=$array['Update_Result']['DispatchOrders'];
              foreach ($res as $key => $value) {
              	$key=$value['Key'];
              	echo $key;
              }

              
    } 

	
    public function updateDispatchOrder(){
    	$gate_in_date           = $this->input->post('gate_in_date');
    	$gate_in_time           = $this->input->post('gate_in_time');
    	$weigh_out_date           = $this->input->post('weigh_out_date');
    	$weigh_out_time           = $this->input->post('weigh_out_time');
    	$order_id           = $this->input->post('order_id');
		  //   	echo "1".$gate_in_date."<br>";
		  //   	echo "2".$gate_in_time."<br>";
		  //   	echo "3".$weigh_out_date."<br>";
		  //   	echo "4".$weigh_out_time."<br>";
		/// echo "<pre>";print_r($order_id);die();

	    $this->db->select('*');
		$this->db->from('dbo.sales_dispatched_order');
		$this->db->where('order_id', $order_id);
		$query = $this->db->get()->row();
		$key =$query->order_key;
		$company =$query->company;
		//print_r($company);die();

		$url="http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Page/DispatchOrders";
	 	$port           = '7048';
		$umds_url       = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/UMDS%20Pvt.Ltd./Page/DispatchOrders';
		$zoraster_url   = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/S.ZORASTER%20%26%20COMPANY/Page/DispatchOrders';  
		$jp_min_url     = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Jaipur%20Mineral%20Development%20Syn/Page/DispatchOrders';
		$golcha_url     = 'http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Talc/Page/DispatchOrders';
		$golcha_min_url ='http://myerp.golchagroup.com:7048/DynamicsNAV90/WS/Golcha%20Minerals%20%28I%29%20Pvt.Ltd./Page/DispatchOrders';
		if($company=='UMDS')
			   {
				 $url = $umds_url;
			  }
			  if($company=='S.ZORASTER')
			  {
				 $url = $zoraster_url;
			  } 
			  if($company=='Jaipur Mineral Development')
			  {
				 $url = $jp_min_url;
				
			  }
			  if($company=='Golcha Talc')
			  {
				 $url = $golcha_url;
				
			  }
			  if($company=='Golcha Minerals Pvt.Ltd.')
			  {
			      $url = $golcha_min_url;
			  }
            $date = date("Y-m-d");
	        $FileName = base_url()."logs/" . $date;
	        //echo $FileName;die();
	        $datetime = date("Y-m-d h:i:sa");
	        if (file_exists($FileName)) {
                $fh = fopen($FileName, 'a');
                fwrite($fh, $datetime ."\n");
                fwrite($fh, $company ."\n");
	        } else {
                $fh = fopen($FileName, 'w');
                fwrite($fh, $datetime . "\n");
                fwrite($fh, $company ."\n");
	        }
	        fclose($fh);
		$username = 'scm';
		$password = 'scm@3112';
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_PORT => "7048",
		CURLOPT_URL =>$url,
		CURLOPT_USERPWD => $username.':'.$password,
		CURLOPT_HTTPAUTH => CURLAUTH_ANY,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <No>".$order_id."</No>\n                 <Gate_In_Time>".$gate_in_time."</Gate_In_Time>\n                <Gate_In_Date>".$gate_in_date."</Gate_In_Date>\n                <Weigh_Out_Time>".$weigh_out_time."</Weigh_Out_Time>\n                <Weigh_Out_Date>".$weigh_out_date."</Weigh_Out_Date>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
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
		 echo "cURL Error #:" . $err;
	        if (file_exists($FileName)) {
                $fh = fopen($FileName, 'a');
                fwrite($fh, $datetime ."\n");
                fwrite($fh, "cURL Error #:" . $err ."\n");
	        } else {
                $fh = fopen($FileName, 'w');
                fwrite($fh, $datetime . "\n");
                fwrite($fh, "cURL Error #:" . $err ."\n");
	        }
	        fclose($fh);
			header('Location: '.base_url().'/index.php/admin/order_view?id='.$order_id);
		} else {
		 echo $response;
	        if (file_exists($FileName)) {
                $fh = fopen($FileName, 'a');
                fwrite($fh, $datetime ."\n");
                fwrite($fh, $response ."\n");
	        } else {
                $fh = fopen($FileName, 'w');
                fwrite($fh, $datetime . "\n");
                fwrite($fh, $response ."\n");
	        }
	        fclose($fh);
			header('Location: '.base_url().'/index.php/admin/order_view?id='.$order_id);
		}
	}				

}

?>