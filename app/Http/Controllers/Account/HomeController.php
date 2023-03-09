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
        $driver = null;
        if($user->hasRole('Driver')){
            if(Driver::where('user_id', Auth::user()->id)->count() == 0){
                $driver = new Driver;
                $driver->user_id = Auth::user()->id;
                $driver->save();
            }
            $driver = Driver::with(['user'])->where('user_id', Auth::user()->id)->first();
        }
        $roleIds = $user->roles->pluck('id');
        $uploads = DocumentTypeRole::whereIn('role_id', $roleIds)->with(['document_type.document_uploads'=>function($query){
            $query->where('user_id', Auth::user()->id);
        }])->whereHas("document_type", function ($query) {
            $query->where('required', 1);
        })->get();
        foreach($uploads as $upload){
            if($upload->document_type->required){
                if($upload->document_type->document_uploads->count() == 0){
                    return redirect()->to('documents/upload/'.$upload->id);
                }
            }
        }
        return view('account.home', ['user'=>$user, 'driver'=>$driver]);
    }
}
