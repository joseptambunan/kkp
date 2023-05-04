<?php
namespace App\Services;

class MailServices {

	public static function email($email,$otp){
		$message = "OTP ".$otp;
		$body = array(
			"email" => $email,
			"subject" => "OTP Register",
			"message" => $message,
			"token" => "1dy09eODblmBUCTnIwiY-hbXdzCpZC3jyR4l0ZJgqQqO9L7J3zsZOobdJ"
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_URL => "https://script.google.com/macros/s/AKfycbxFNsyMXW8chGL8YhdQE1Q1yBbx5XEsq-BJeNF1a6sKoowaL_9DtcUvE_Pp0r5ootgMhQ/exec",// your preferred link
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => "",
		    CURLOPT_TIMEOUT => 30000,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => "POST",
		    CURLOPT_HTTPHEADER => array(
		        // Set Here Your Requesred Headers
		        'Content-Type: application/json',
		    ),
		    CURLOPT_POSTFIELDS => json_encode($body)
		));
		$response = curl_exec($curl);
		$error = curl_error($curl);
		curl_close($curl);
		return $response;
	}

}


?>