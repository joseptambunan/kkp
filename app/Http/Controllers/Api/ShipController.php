<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipRequest;
use Illuminate\Http\Request;
use App\Services\ShipServices;

class ShipController extends Controller
{


    public function register(Request $shipRequest){
        $response['data'] = "OK";
        $shipRegister = ShipServices::register($shipRequest);
        return response()->json($shipRegister, $shipRegister['code']);
    }

    public function approve(Request $requests){

        $approve = ShipServices::approve($requests);
        return response()->json($approve, $approve['code']);
    }

    public function getShip(Request $requests){
        $dataShip = ShipServices::getData($requests);
        return response()->json($dataShip, $dataShip['code']);
    }
}
