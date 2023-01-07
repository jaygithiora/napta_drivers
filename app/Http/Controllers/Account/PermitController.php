<?php

namespace App\Http\Controllers\account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermitController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function permits(){
        return view('account.permits');
    }
}
