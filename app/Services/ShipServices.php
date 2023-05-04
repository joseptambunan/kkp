<?php
namespace App\Services;
use App\Models\Ships;
use Exception;
use App\Services\UserServices;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ShipServices {

	public static function register($request){
		try {

			$user = UserServices::profile($request);
			if ( !($user->hasAnyRole("member"))) {
				$response['message'] = "Unauthorized";
	            $response['code'] = 401;

	            return $response;
			}

			$ship = Ships::updateOrCreate(
		    ['code' => $request->ship_code],
		    ['ship_name' => $request->ship_name, 
		    	'ship_owner' => $request->ship_owner,
		    	'address_owner' => $request->address_owner,
		    	'ship_size' => $request->ship_size,
		    	'captain' => $request->captain,
		    	'member' => $request->member,
		    	'ship_images' => $request->ship_images,
		    	'permit_number' => $request->permit_number,
		    	'permit_document' => $request->permit_document,
		    	'created_by' => $request->created_by
		    ]);

			$response['message'] = "SUCCESS";
			$response['code'] = 200;
		}catch ( Exception $e ){
			$response['message'] = $e->getMessage();
			$response['code'] = 401;
		}

		return $response;
	}


	public static function approve($request){

		$user = UserServices::profile($request);
		if ( !($user->hasAnyRole("admin"))) {
			$response['message'] = "Unauthorized";
            $response['code'] = 401;

            return $response;
		}

		switch ( $request->status){
			case "approve":
				$approvedData['approved_at'] = date("Y-m-d H:i:s");
				$approvedData['approved_by'] = $request->user_id;
				$approvedData['deleted_at'] = NULL;
				$approvedData['reason'] = NULL;
				break;
			case "reject": 
				$approvedData['deleted_at'] = date("Y-m-d H:i:s");
				$approvedData['approved_at'] = NULL;
				$approvedData['approved_by'] = NULL;
				$approvedData['reason'] = $request->reason;
				break;
		}

		try {
			$update = Ships::where("code", $request->ship_code)->update($approvedData);
			$response['message'] = "SUCCESS ".$request->status;
			$response['code'] = 200;
		}catch ( Exception $e){
			$response = $e->getMessage();
			$response['code'] = 401;
		}

		return $response;

	}

	public static function getData($request){
		$user = UserServices::profile($request);
		$key = env('JWT_SECRET');
		$algo = env('JWT_ALGO');
		$token = $request->header("token");
		$decoded = JWT::decode($token, new Key($key, $algo));

		try {
			if ( !($decoded->sub == "guest")) {
				$response['message'] = "Unauthorized";
	            $response['code'] = 401;

	            return $response;
			}

			$dataShip = Ships::where("code", $request->ship_code)->get();
			$response['message'] = "NOT FOUND";
			if ( count($dataShip) > 0 ){
				$response['message'] = $dataShip;
			}
			$response['code'] = 200;
			return $response;
		}catch ( Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = 401;
			return $response;
		}
		
	}
}