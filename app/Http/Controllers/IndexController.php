<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Driver;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $drivers = Driver::with('user.country')->where('status', 1)->skip(0)->take(12)->get();
        $vehicleTypes = VehicleType::skip(0)->take(12)->get();
        return view('index', ['vehicle_types'=>$vehicleTypes, 'drivers'=>$drivers]);
    }
    public function searchCountries(Request $request){
        return json_encode(Country::where('name', 'LIKE', '%'.$request->q.'%')->where('status', '=', true)
        ->orderBy('name', 'asc')->get());
    }
}
