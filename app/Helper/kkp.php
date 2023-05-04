<?php

namespace App\Helper;


class Kkp {
	
	public static function checkPassword($password, $password_compare){

		if ( md5($password) == md5($password_compare)){
			return true;
		}

		return false;
	}

	public static function createOtp(){
		$otp = '0123456789';
		$defaultOtp = "";
		for ( $i=0; $i <=6 ; $i++ ){
			$randomIndex = rand(1, strlen($otp));
			$getString = substr($otp, $randomIndex, 1);
			$defaultOtp .= $getString;
		}

		return $defaultOtp;
	}
}


?>