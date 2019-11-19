<?php

echo "<pre>";print_r($_POST);die();

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

?>