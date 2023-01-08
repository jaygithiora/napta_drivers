<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        return view('index');
    }
    public function searchCountries(Request $request){
        return json_encode(Country::where('name', 'LIKE', '%'.$request->q.'%')->where('status', '=', true)
        ->orderBy('name', 'asc')->get());
    }
}
