<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\DocumentTypeRole;
use App\Models\DocumentUpload;
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
            $documentTypes = DocumentTypeRole::with('document_type')->where('role_id', $role->id)->get();
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
        \Log::info($request->all());
        $validator = Validator::make($request->all(), [
            "document_type_id" => 'required|integer|min:1',
            'file' => 'required|file',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $image = $request->file('file');
        $fileInfo = $image->getClientOriginalName();
        $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
        $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
        $fileName = $filename . '-' . time() . '.' . $extension;
        $image->move(public_path('uploads'), $fileName);

        $documentUpload = new DocumentUpload;
        $documentUpload->upload_name = $fileInfo;
        $documentUpload->name = $fileName;
        $documentUpload->user_id = Auth::user()->id;
        $documentUpload->document_type_id = $request->document_type_id;
        if ($documentUpload->save()) {
            return response()->json(['success' => $fileName]);
        } else {
            return response()->json(['error' => "Unable to save file!"], 401);
        }
    }
    public function getDocuments(Request $request)
    {
        $documentUploads = DocumentUpload::with("document_type")->where('user_id', Auth::user()->id)->get()->toArray();
        foreach ($documentUploads as $doc) {
            $obj['name'] = $doc['name'];
            $filePath = public_path('uploads/') . $doc['name'];
            $obj['size'] = filesize($filePath);
            $obj['path'] = url('uploads/' . $doc['name']);
            $obj['document_type'] = $doc['document_type']['name'];
            $data[] = $obj;
        }
        return response()->json($data);
    }
    public function removeDocument(Request $request){
        $filename =  $request->get('filename');
        DocumentUpload::where('name',$filename)->delete();
        $path = public_path('uploads').$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success'=>$filename]);
    }

    public function uploadProfilePicture(Request $request){
        $folderPath = public_path('upload/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $imageName = uniqid() . '.png';

        $imageFullPath = $folderPath.$imageName;

        file_put_contents($imageFullPath, $image_base64);

         $saveFile = new Image;
         $saveFile->title = $imageName;
         $saveFile->save();

        return response()->json(['success'=>'Crop Image Saved/Uploaded Successfully using jQuery and Ajax In Laravel']);
    }
}
