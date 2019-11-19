<?php
class Tms_api_model extends CI_Model
{
    function __construct()
    {
		  parent::__construct();
        $this->load->database();
        date_default_timezone_set("Asia/Calcutta");
    }

    public function scanner_login($mobile)
    {

		$this->db->where('mobile', $mobile);
        return $this->db->get('dbo.scanner_login')->result_array();
		
    }
	 public function otp_check($user_id,$otp)
    {

		$this->db->where('otp', $otp);
		$this->db->where('id', $user_id);
        return $this->db->get('dbo.scanner_login')->result_array();
		
    }
	public function get_today_dispatched_order($status)
    {
		if($status=='')
		{
			//$this->db->where('od.shipping_status', 'Awaiting For Arrival');
		}
		else if($status=='Dispatched')
		{
			$this->db->where('od.shipping_status', 'Dispatched');
		}
        $date=date('Y-m-d');
		//$this->db->distinct();
		$this->db->select('sdo.order_id as order_id,t.name as transporter_name,sdo.item_code as item_code,sdo.delivery_date as delivery_date,d.name as driver_name,v.registration_no as vehicle_no,sdo.quantity as quantity,sdo.description as description,sdo.qty_to_ship as qty_to_ship,od.shipping_status as status,t.state_code as state_code,t.company as company,sdo.status as sales_status');
	    $this->db->from('dbo.sales_dispatched_order as sdo');
		$this->db->join('dbo.order_details as od', 'od.order_id = sdo.order_id');
		$this->db->join('dbo.transporter as t', 't.user_id = sdo.trans_no and sdo.company = t.company','left outer');
		$this->db->join('dbo.driver as d', 'd.id = od.driver_id','left outer');
		$this->db->join('dbo.vehicle as v', 'v.id = od.vehicle_id','left outer');
		//$this->db->where('sdo.status', 'Released');
		//$this->db->where('sdo.delivery_date', $date);
		//$this->db->group_by('od.order_id');
		return $this->db->get()->result_array(); 
		
    }
	public function change_status($order_id, $save)
    {
        
        $this->db->where('order_id', $order_id);
		$sql=$this->db->update('dbo.order_details', $save);
        if ($sql) {
            return TRUE;
        }
      
    }
	 public function check_invoice($order_id)
    {
		 $this->db->where('order_id', $order_id);
        return $this->db->get('dbo.posted_sales_dispatch_order')->result_array();
		
    }
	 public function update_date_time_webservice_get_in($date, $time,$order_id)
    {       
	    $this->db->where('order_id', $order_id);
        $res= $this->db->get('dbo.sales_dispatched_order')->row();
		$key=$res->order_key;
		//print_r($key); die;
	          /****1****/
              $username = 'scm';
			  $password = 'scm@3112';
			  $curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_PORT => "7048",
			  CURLOPT_URL =>"http://myerp.golchagroup.com:7048/DummyGST/WS/UMDS%20Pvt.Ltd./Page/DispatchOrders",
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
			// echo "cURL Error #:" . $err;
			} else {
			// echo $response;
			}
			/****2****/
              $username = 'scm';
			  $password = 'scm@3112';
			  $curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_PORT => "7048",
			  CURLOPT_URL =>"http://myerp.golchagroup.com:7048/DummyGST/WS/S.ZORASTER%20%26%20COMPANY/Page/DispatchOrders",
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
			 // echo "cURL Error #:" . $err;
			} else {
			 // echo $response;
			}
			/****3****/
              $username = 'scm';
			  $password = 'scm@3112';
			  $curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_PORT => "7048",
			  CURLOPT_URL =>"http://myerp.golchagroup.com:7048/DummyGST/WS/Jaipur%20Mineral%20Development%20Syn/Page/DispatchOrders",
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
			 // echo "cURL Error #:" . $err;
			} else {
			 // echo $response;
			}
			/****4****/
              $username = 'scm';
			  $password = 'scm@3112';
			  $curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_PORT => "7048",
			  CURLOPT_URL =>"http://myerp.golchagroup.com:7048/DummyGST/WS/Golcha%20Talc/Page/DispatchOrders",
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
			 // echo "cURL Error #:" . $err;
			} else {
			 // echo $response;
			}
			/****5****/
              $username = 'scm';
			  $password = 'scm@3112';
			  $curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_PORT => "7048",
			  CURLOPT_URL =>"http://myerp.golchagroup.com:7048/DummyGST/WS/Golcha%20Minerals%20%28I%29%20Pvt.Ltd./Page/DispatchOrders",
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
			 // echo "cURL Error #:" . $err;
			} else {
			//  echo $response;
			} 
    }
	public function update_date_time_webservice_weight_out($date, $time,$order_id)
    {       
	    $this->db->where('order_id', $order_id);
        $res= $this->db->get('dbo.sales_dispatched_order')->row();
		$key=$res->order_key;

		$company =$res->company;
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
	          /****1****/
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
			/****2****/
   //            $username = 'scm';
			//   $password = 'scm@3112';
			//   $curl = curl_init();
			//   curl_setopt_array($curl, array(
			//   CURLOPT_PORT => "7048",
			//   CURLOPT_URL =>"http://myerp.golchagroup.com:7048/DummyGST/WS/S.ZORASTER%20%26%20COMPANY/Page/DispatchOrders",
			//   CURLOPT_USERPWD => $username.':'.$password,
   //            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
			//   CURLOPT_RETURNTRANSFER => true,
			//   CURLOPT_ENCODING => "",
			//   CURLOPT_MAXREDIRS => 10,
			//   CURLOPT_TIMEOUT => 30,
			//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			//   CURLOPT_CUSTOMREQUEST => "POST",
			//   CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <Weigh_Out_Time>".$time."</Weigh_Out_Time>\n                <Weigh_Out_Date>".$date."</Weigh_Out_Date>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
			//   CURLOPT_HTTPHEADER => array(
			// 	"cache-control: no-cache",
			// 	"content-type: text/xml",
			// 	"postman-token: 98746a29-cbcf-a33d-35ac-1471ec049b12",
			// 	"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
			//   ),
			// ));

			// $response = curl_exec($curl);
			// $err = curl_error($curl);

			// curl_close($curl);

			// if ($err) {
			//  // echo "cURL Error #:" . $err;
			// } else {
			//  // echo $response;
			// }
			// /****3****/
   //            $username = 'scm';
			//   $password = 'scm@3112';
			//   $curl = curl_init();
			//   curl_setopt_array($curl, array(
			//   CURLOPT_PORT => "7048",
			//   CURLOPT_URL =>"http://myerp.golchagroup.com:7048/DummyGST/WS/Jaipur%20Mineral%20Development%20Syn/Page/DispatchOrders",
			//   CURLOPT_USERPWD => $username.':'.$password,
   //            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
			//   CURLOPT_RETURNTRANSFER => true,
			//   CURLOPT_ENCODING => "",
			//   CURLOPT_MAXREDIRS => 10,
			//   CURLOPT_TIMEOUT => 30,
			//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			//   CURLOPT_CUSTOMREQUEST => "POST",
			//   CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <Weigh_Out_Time>".$time."</Weigh_Out_Time>\n                <Weigh_Out_Date>".$date."</Weigh_Out_Date>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
			//   CURLOPT_HTTPHEADER => array(
			// 	"cache-control: no-cache",
			// 	"content-type: text/xml",
			// 	"postman-token: 98746a29-cbcf-a33d-35ac-1471ec049b12",
			// 	"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
			//   ),
			// ));

			// $response = curl_exec($curl);
			// $err = curl_error($curl);

			// curl_close($curl);

			// if ($err) {
			//   //echo "cURL Error #:" . $err;
			// } else {
			//   //echo $response;
			// }
			// ***4***
   //            $username = 'scm';
			//   $password = 'scm@3112';
			//   $curl = curl_init();
			//   curl_setopt_array($curl, array(
			//   CURLOPT_PORT => "7048",
			//   CURLOPT_URL =>"http://myerp.golchagroup.com:7048/DummyGST/WS/Golcha%20Talc/Page/DispatchOrders",
			//   CURLOPT_USERPWD => $username.':'.$password,
   //            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
			//   CURLOPT_RETURNTRANSFER => true,
			//   CURLOPT_ENCODING => "",
			//   CURLOPT_MAXREDIRS => 10,
			//   CURLOPT_TIMEOUT => 30,
			//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			//   CURLOPT_CUSTOMREQUEST => "POST",
			// CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <Weigh_Out_Time>".$time."</Weigh_Out_Time>\n                <Weigh_Out_Date>".$date."</Weigh_Out_Date>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
			//   CURLOPT_HTTPHEADER => array(
			// 	"cache-control: no-cache",
			// 	"content-type: text/xml",
			// 	"postman-token: 98746a29-cbcf-a33d-35ac-1471ec049b12",
			// 	"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
			//   ),
			// ));

			// $response = curl_exec($curl);
			// $err = curl_error($curl);

			// curl_close($curl);

			// if ($err) {
			//  // echo "cURL Error #:" . $err;
			// } else {
			//  // echo $response;
			// }
			// /****5****/
   //            $username = 'scm';
			//   $password = 'scm@3112';
			//   $curl = curl_init();
			//   curl_setopt_array($curl, array(
			//   CURLOPT_PORT => "7048",
			//   CURLOPT_URL =>"http://myerp.golchagroup.com:7048/DummyGST/WS/Golcha%20Minerals%20%28I%29%20Pvt.Ltd./Page/DispatchOrders",
			//   CURLOPT_USERPWD => $username.':'.$password,
   //            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
			//   CURLOPT_RETURNTRANSFER => true,
			//   CURLOPT_ENCODING => "",
			//   CURLOPT_MAXREDIRS => 10,
			//   CURLOPT_TIMEOUT => 30,
			//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			//   CURLOPT_CUSTOMREQUEST => "POST",
			// CURLOPT_POSTFIELDS => "<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">\n    <Body>\n        <Update xmlns=\"urn:microsoft-dynamics-schemas/page/dispatchorders\">\n            <DispatchOrders>\n                <Key>".$key."</Key>\n                <Weigh_Out_Time>".$time."</Weigh_Out_Time>\n                <Weigh_Out_Date>".$date."</Weigh_Out_Date>\n            </DispatchOrders>\n        </Update>\n    </Body>\n</Envelope>",
			//   CURLOPT_HTTPHEADER => array(
			// 	"cache-control: no-cache",
			// 	"content-type: text/xml",
			// 	"postman-token: 98746a29-cbcf-a33d-35ac-1471ec049b12",
			// 	"soapaction: urn:microsoft-dynamics-schemas/page/dispatchorders:Update"
			//   ),
			// ));

			// $response = curl_exec($curl);
			// $err = curl_error($curl);

			// curl_close($curl);

			// if ($err) {
			//   //echo "cURL Error #:" . $err;
			// } else {
			//  // echo $response;
			// } 
		
    }
	
}
?>