<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RegisterDriverController extends Controller
{
    public function index()
    {
        $role = Role::where('name', 'Driver')->first();
        if ($role == null) {
            Role::create(['name' => 'Driver']);
            $role = Role::where('name', 'Driver')->first();
        }
        return view('auth.register_driver', ['role'=>$role]);
    }
}