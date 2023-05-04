<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserServices;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class UserController extends Controller
{

    public function register(Request $request){

        $validated = $request->validate([
            'name' => 'required|',
            'email' => 'required|email',
            'password' => 'required',
            'password_compare' => 'required'
        ]);

        $registerUser = UserServices::register($request);
        return response()->json($registerUser, $registerUser['code']);
    }

    public function confirmOtp(Request $requests){
        $confirmOtp = UserServices::confirmOtp($requests->otp, $requests->email);

        $data['message'] = "FAILED";
        if ( $confirmOtp ){
            $data['message'] = "SUCCESS";
        }
        return response()->json($data);
    }

    public function login(Request $requests){
       $login = UserServices::login($requests);
       return response()->json($login, $login['code']);
    }

    public function profile(Request $requests){
       $profile = UserServices::profile($requests);
       return response()->json($profile, $profile['code']);
    }

    public function approveUser(Request $request){
        $approveUser = UserServices::approveUser($request);
        return response()->json($approveUser, $approveUser['code']);
    }

    public function guest(Request $requests){
        $guest = UserServices::guest();
        return response()->json($guest, $guest['code']);
    }

}
