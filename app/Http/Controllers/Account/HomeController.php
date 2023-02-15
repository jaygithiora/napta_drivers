<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use App\Models\DocumentTypeRole;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::with('roles')->where('id', Auth::user()->id)->first();
        $can_proceed = true;
        $driver = Driver::where('id', Auth::user()->id)->first();
        if($user->hasRole('Driver')){
            $role = Role::where('name', 'Driver')->first();
            $uploads = DocumentTypeRole::where('role_id', $role->id)->with('document_type.document_uploads')->whereHas("document_type", function ($query) {
                $query->where('required', 1);
            })->get();
            foreach($uploads as $upload){
                if($upload->document_type->required){
                    if($upload->document_type->document_uploads->count() == 0){
                        $can_proceed = false;
                    }
                }
            }
            if($driver == null){
                $driver = new Driver;
                $driver->user_id = Auth()->user()->id;
                $driver->save();
            }
        }
        return view('account.home', ['user'=>$user, 'can_proceed'=>$can_proceed, 'driver'=>$driver]);
    }
}
