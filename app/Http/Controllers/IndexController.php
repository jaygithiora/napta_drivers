<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Driver;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $drivers = Driver::with('user.country')->where('status', 1)->skip(0)->take(20)->get();
        $vehicleTypes = VehicleType::skip(0)->take(12)->get();
        return view('index', ['vehicle_types'=>$vehicleTypes, 'drivers'=>$drivers]);
    }
    public function searchCountries(Request $request){
        return json_encode(Country::where('name', 'LIKE', '%'.$request->q.'%')->where('status', '=', true)
        ->orderBy('name', 'asc')->get());
    }
    public function drivers(Request $request){ 
        $drivers = Driver::with(['user.country', 'vehicle_types'])->where('status', 1)->paginate(20);
        return view('drivers', @compact('drivers'));
    }

    public function getDrivers(Request $request){
        $names = explode(' ',$request->search);
        $drivers = Driver::with(['user.country', 'vehicle_types']);
        if(count($names) > 1){
            $drivers = $drivers->whereHas('user', function($query) use($names, $request){
                $query->where('firstname', 'LIKE', '%'.$names[0].'%')->orWhere('lastname', 'LIKE', '%'.$names[1].'%');
            });
        }else{
            $drivers = $drivers->whereHas('user', function($query) use($names, $request){
                $query->where('firstname', 'LIKE', '%'.$request->search.'%')->orWhere('lastname', 'LIKE', '%'.$request->search.'%');
            });
        }
        if($request->has('vehicle_types')){
            $drivers = $drivers->whereHas('vehicle_types', function($query) use($request){
                $query->where('id', $request->vehicle_types);
            });
        }
        $drivers = $drivers->where('status', 1)->paginate(20);
        //die(json_encode($drivers));
        return view('includes/drivers_data', @compact('drivers'))->render();
        //return response()->json(['links'=>utf8_encode($drivers->links()), 'drivers'=>$drivers]);
    }
    public function searchVehicleTypes(Request $request){
        return json_encode(VehicleType::where('name', 'LIKE', '%'.$request->q.'%')->where('status', '=', true)
        ->orderBy('name', 'asc')->get());
    }
}
