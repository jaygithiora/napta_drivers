<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $vehicle_types = VehicleType::skip(0)->take(6)->get();
        return view('index', ['vehicle_types'=>$vehicle_types]);
    }
    public function searchCountries(Request $request){
        return json_encode(Country::where('name', 'LIKE', '%'.$request->q.'%')->where('status', '=', true)
        ->orderBy('name', 'asc')->get());
    }
}
