<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\DocumentTypeRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::with('roles')->findOrFail(\Auth::user()->id);
        $documentTypes = null;
        if($user->roles->count() > 0){
            $role = $user->roles->first();
            $documentTypes = DocumentTypeRole::with('document_type')->get();
        }
        return view('account.profile', ['user'=>$user, 'documentTypes'=>$documentTypes]);
    }
    public function editProfileName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->fails()], 400);
        }
        //save name here
        $user = User::findOrFail($request->id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        if ($user->save()) {
            return response()->json(['success' => "Name updated successfully!"]);
        } else {
            return response()->json(['error' => 'Unable to save'], 401);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|min:8|string|same:confirm_password',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }
        if (Hash::check($request->current_password, auth()->user()->password)) {
            //save
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            if ($user->save()) {
                return response()->json(['success' => 'Password update successfully!']);
            } else {
                return response()->json(['error' => 'Unable to update password!'], 401);
            }
        } else {
            return response()->json(['error' => 'Current Password is incorrect!'], 401);
        }
    }

    public function uploadDocuments(Request $request){

    }
}