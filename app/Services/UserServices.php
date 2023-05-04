<?php
namespace App\Services;
use App\Models\User;
use App\Helper\Kkp;
use App\Services\MailServices;
use Illuminate\Support\Facades\Hash;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class UserServices {
	
	public static function register($request){

		try {

			if ( !(Kkp::checkPassword($request->password, $request->password_compare))) {
				$response['message'] = "PASSWORD NOT MATCH";
				return $response;
			}

        	$createOtp = Kkp::createOtp();
        	$password = Hash::make($request->password);
			$user = User::updateOrCreate(
				[ "email" => $request->email ],
				["name" => $request->name, "password" => $password, "otp" => $createOtp]
			);
			$user->assignRole("member");

        	$sendEmail = MailServices::email($request->email, $createOtp);
			$response['message'] = "SUCCESS";
			$response['email'] = $sendEmail;
			$response['code'] = 200;
		}catch ( Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = 401;
		
		}

		return $response;
	}

	public static function confirmOtp($otp, $email){
		try {
			$checkUser = User::where("email", $email)->where("otp", $otp)->get();
			if ( count($checkUser) <= 0 ){
				return false;
			}

			$updateVerified = User::find($checkUser->first()->id);
			$updateVerified->email_verified_at = date("Y-m-d H:i:s");
			$updateVerified->otp = NULL;
			$updateVerified->save();

			$response['message'] = "SUCCESS";
            $response['code'] = 200;
		}catch ( Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = 401;
		}

		return $response;
	}

	public static function profile($request){
		$key = env('JWT_SECRET');
		$algo = env('JWT_ALGO');
		$token = $request->header("token");
		$decoded = JWT::decode($token, new Key($key, $algo));
		
		$response = User::find($decoded->sub);
		return $response;
	}

	public static function approveUser($request){
		try {
            $profile = UserServices::profile($request);

            if ( $profile->hasAnyRole("admin")) {
                $approveUser = User::find($request->user_id);
                $approveUser->approved_at = date("Y-m-d H:i:s");
                $approveUser->approved_by = $profile->id;
                $approveUser->save();
                $response['message'] = "SUCCESS";
                $response['code'] = 200;
            }else{
                $response['message'] = "FAILED";
                $response['code'] = 401;
            }

        }catch ( Exception $e){
            $response['message'] = $e->getMessage();
            $response['code'] = 401;
        }

        return $response;
	}
	
	protected static function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public static function login($requests){
    	$credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            $response['message'] = "Unauthorized";
        	$response['code'] = 401;
        	return $response;
        }

        if ( auth()->user()->deleted_at != NULL || auth()->user()->approved_at == NULL ){
           	$response['message'] = "Unauthorized";
        	$response['code'] = 401;
        	return $response;
        }

        $response['message'] = UserServices::respondWithToken($token);
        $response['code'] = 200;

        return $response;
    }

    public static function guest(){
    	$payload = [
		    'iat' => 1356999524,
		    'nbf' => 1357000000,
		    'sub' => 'guest'
		];
		$key = env('JWT_SECRET');
		$algo = env('JWT_ALGO');
		$token = JWT::encode($payload, $key, $algo);
    	$response['message'] = $token;
        $response['code'] = 200;

        return $response;
    }
}