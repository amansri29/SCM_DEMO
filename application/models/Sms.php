<?php
class Sms extends CI_Model
{
    function __construct()
    {
		  parent::__construct();
        $this->load->database();
        date_default_timezone_set("Asia/Calcutta");
    }
	
	public function sms($mobile,$message)
	{ 

		$data=' { 
		"sender":"MSGIND",
		"route": "4",
		"country": "91", 
		"sms": [ { "message": "'.$message.'", "to": [ "'.$mobile.'" ] } ] }';
	  
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://api.msg91.com/api/v2/sendsms",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $data,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_HTTPHEADER => array(
				"authkey: 236173AHqsMCeBq5b922e34",
				"content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			 // echo $response;
			}
		}
		public function delivery_sms($tmobile_number,$cmobile_number,$dmobile,$message)
	{
		//echo $message;
   
		$data=' { 
		
		"sender":"MSGIND",
		"route": "4",
		"country": "91", 
		"sms": [ { "message": "'.$message.'", "to": [ "'.$tmobile_number.'","'.$cmobile_number.'","'.$dmobile.'" ] } ] }';
	  
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://api.msg91.com/api/v2/sendsms",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $data,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_HTTPHEADER => array(
				"authkey: 236173AHqsMCeBq5b922e34",
				"content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			 // echo $response;
			}
	}
}
?>