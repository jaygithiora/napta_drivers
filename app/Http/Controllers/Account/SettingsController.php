<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use App\Models\DocumentTypeRole;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends HomeController
{
    public function documentSettings(){
        return view('account.document_settings');
    }
    public function getDocumentTypes(Request $request)
    {
        return Datatables::of(DocumentType::get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->editColumn('required', function ($row) {
                return $row->required?"<span class='badge text-primary border border-primary'>Yes</span>":"<span class='badge text-muted border'>No</span>";
            })->editColumn('status', function ($row) {
                return $row->status?"<span class='badge bg-primary'>Active</span>":"<span class='badge bg-secondary'>In-Active</span>";
            })->addColumn('action', function ($row) {
                $actionBtn = '<div style="white-space: nowrap;" class="text-end">' .
                                '<span class="d-none id">'.$row->id.'</span>'.
                                '<span class="d-none name">'.$row->name.'</span>'.
                                '<span class="d-none description">'.$row->description.'</span>'.
                                '<span class="d-none required">'.$row->required.'</span>'.
                                '<span class="d-none status">'.$row->status.'</span>'.
                                '<button class="btn-edit btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#documentTypeModal"><i class="fas fa-edit"></i> Edit</button> ' . '
                                 <a href="'.url('/settings/document_types/view/'.$row->id).'" class="delete btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View</a>'
                            . '</div>';
                return $actionBtn;
            })->escapeColumns([])
            ->make(true);
    }
    public function addDocumentType(Request $request){
        $validator = Validator::make($request->all(), [
            "id"=>'required|integer|min:0',
            'name' => 'required|max:255|string|unique:countries,name,'.$request->id,
            'description' => 'nullable|string',
            'required' => 'required|integer|min:0|max:1',
            'status' => 'required|integer|min:0|max:1'
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $documentType = new DocumentType;
        if ($request->id  > 0){
            $documentType = DocumentType::findOrFail($request->id);
        }
        $documentType->name = $request->name;
        $documentType->description = $request->description;
        $documentType->required = $request->required;
        $documentType->status = $request->status;
        if ($documentType->save()){
            return response()->json(['success' => 'Document Type updated successfully!']);
        } else {
            return response()->json(['error' => 'Unable to update Document Type!']);
        }
    }

    public function viewDocumentType(Request $request){
        $documentType = DocumentType::findOrFail($request->id);
        if($documentType == null){
            return back()->with(['error' => 'Invalid document type id']);
        }
        return view('account.document_setting', ['document_type'=>$documentType]);
    }

    public function getDocumentTypeRoles(Request $request){
        return DataTables::of(DocumentTypeRole::with(['role', 'document_type'])->where('document_type_id', $request->id)->get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->addColumn('action', function ($row) {
                $actionBtn = '<div style="white-space: nowrap;" class="text-end">' .
                                '<button class="btn-edit btn btn-warning btn-sm"><i class="fas fa-trash"></i> Delete</button> ' . '
                                 <!--<a href="'.url('/settings/document_types/view/'.$row->id).'" class="delete btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View</a>-->'
                            . '</div>';
                return $actionBtn;
            })->escapeColumns([])
            ->make(true);
    }
    public function addDocumentTypeRoles(Request $request){
        $validator = Validator::make($request->all(), [
            "id"=>'required|integer|min:1',
            'roles.*' => 'required|integer|min:1'
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $documentType = DocumentType::findOrFail($request->id);
        if ($documentType != null) {
            foreach($request->roles as $roleId){
                $documentTypeRole = DocumentTypeRole::where('role_id', $roleId)->where('document_type_id', $request->id)->first();
                if($documentTypeRole == null){
                $documentTypeRole = new DocumentTypeRole;
                    $documentTypeRole->role_id = $roleId;
                    $documentTypeRole->document_type_id = $request->id;
                    $documentTypeRole->save();
                }
            }
            return response()->json(['success' => 'Document Type Role pdated successfully!']);
        }else{
            return response()->json(['error' => 'Invalid Document Type Id!']);
        }
    }

    public function vehicleTypes(){
        return view('account.vehicle_types');
    }
    public function getVehicleTypes(Request $request){
        return Datatables::of(VehicleType::get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->editColumn('status', function ($row) {
                return $row->status?"<span class='badge bg-primary'>Active</span>":"<span class='badge bg-secondary'>In-Active</span>";
            })->addColumn('action', function ($row) {
                $actionBtn = '<div style="white-space: nowrap;" class="text-end">' .
                                '<span class="d-none id">'.$row->id.'</span>'.
                                '<span class="d-none name">'.$row->name.'</span>'.
                                '<span class="d-none description">'.$row->description.'</span>'.
                                '<span class="d-none status">'.$row->status.'</span>'.
                                '<button class="btn-edit btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#vehicleTypeModal"><i class="fas fa-edit"></i> Edit</button> ' . '
                                 <!--<a href="'.url('/settings/document_types/view/'.$row->id).'" class="delete btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View</a>-->'
                            . '</div>';
                return $actionBtn;
            })->escapeColumns([])
            ->make(true);
    }
    public function addVehicleType(Request $request){
        $validator = Validator::make($request->all(), [
            "id"=>'required|integer|min:0',
            "name"=>'required|string|unique:vehicle_types,name,'.$request->id,
            "description"=>"nullable|string",
            "status"=>"required|min:0|max:1"
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $vehicleType = new VehicleType;
        if ($request->id > 0) {
            $vehicleType = VehicleType::findOrFail($request->id);
        }
        $vehicleType->name = $request->name;
        $vehicleType->description = $request->description;
        $vehicleType->status = $request->status;

        if ($vehicleType->save()) {
            return response()->json(['success' => 'Vehicle Type updated successfully!']);
        }else{
            return response()->json(['error' => 'Unable to update Vehicle Type!']);
        }
    }
}
