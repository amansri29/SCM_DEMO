<?php
class Send_notification extends CI_Model
{
	 // old firebase // public  $server_key = 'AAAA9TlbBq4:APA91bF5hB1gBZy_8x9kZJS0GsC89sXYyB7d8L7XjKCZPjqFm7qaBbBFVbdZibkbA8bvujnzH0HVVmkoGddXeLokUCAmQboe3zLEdFVlyeeEFADEA_s94RQZb9H0hsGsiPizqji4Xpey';

	public  $server_key = 'AAAAzdN-fRs:APA91bE0Yy6goCYE5gPvl-Ruvmu1z_RsYP7jMyVB2GtjIAN7VknPMZZ9VjAUfbNZYikZy9orQc1H3_GqEDGB2qp0_Rkp2ulB79EqZfpvcX6MyMjLIpgpFxgOAsv51FENaQBsL8IXb8rg';


    function __construct()
    {
		  parent::__construct();
          $this->load->database();
        date_default_timezone_set("Asia/Calcutta");
    }


    public function send_notification($device_token,$new_title,$new_message)
		{
		       $device_id='dGyhzrkI9LY:APA91bE9ahWJr8KerT2bXSHk-A8n31f8VjXofHvKH1Wi-ytn18Iy2Q0oLbFINErrzYdvpWmUAomfV3RvzyzjdppJMhTxNptLLDoUAbyUEkMZgc3M6vcfcClz8Vk2KIL8IAJaarHzTo74';

		    
			   $msg=array(
			   'message' => $new_message,	
			   'title'   => $new_title,		  
			   );
				$fields = array(
					'to' => $device_token,
                    'data' => $msg,
					'priority' => 'high',
					'notification' => array(
						'title' => $new_title,
						'body' => $new_message,
					)
				 );
				//print_r($fields);
				
				$headers = array(
					'Authorization: key=' . $this->server_key,
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
			//	echo $result;
				

		}	
		public function send_notification_ios($device_token,$new_title,$new_message)
	{
	    $token=$device_token;
		
        $header=array('Content-Type: application/json',
            "Authorization: key='".$this->server_key."'");
        $arr_value=array(
		"success"=>"true"
		);
         
		$arr = array(
		          "success"=>true,
				  "result"=>$arr_value
		);
		$main_array = array(
			"to" => $token,
			"priority"=>10,
			"notification" => array("body" => $message,"title" =>$subject ,"icon" => "myicon"),
			"data" => $arr 
		);
        $ch = curl_init("https://fcm.googleapis.com/fcm/send");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($main_array));
		curl_exec($ch);
        curl_close($ch);
        echo $result;
    }
}