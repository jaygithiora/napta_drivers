<?php

namespace App\Http\Controllers\account;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('account.vehicles');
    }
    public function getVehicles(Request $request)
    {
        return Datatables::of(Vehicle::with(['vehicle_model.vehicle_make', 'user'])->get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->addColumn('make', function ($row) {
                return $row->vehicle_model != null?($row->vehicle_model->vehicle_make != null?$row->vehicle_model->vehicle_make->name:''):'';
            })->addColumn('model', function ($row) {
                return $row->vehicle_model != null?$row->vehicle_model->name :'';
            })->addColumn('status', function ($row) {
                return "<span class='badge bg-primary'>Active</span>";
            })->addColumn('action', function ($row) {
                $actionBtn = '<div style="white-space: nowrap;" class="text-end">' .
                    '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a> ' . '
                                    <a href="javascript:void(0)" class="delete btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View</a>'
                    . '</div>';
                return $actionBtn;
            })->escapeColumns([])
            ->make(true);
    }
    public function addVehicle(Request $request){
        $validator = Validator::make($request->all(), [
            "id"=>'required|integer|min:0',
            'vehicle_make'=>'required|integer|min:1',
            'vehicle_model'=>'required|integer|min:1',
            'plate' => 'required|max:255|string|unique:vehicles,plate,'.$request->id,
            'country'=>'required|integer|min:1',
            'engine_number'=>'required|string',
            'chasis_number'=>'required|string',
            'registration_date'=>'required|date',
            'expiry_date'=>'required|date',
            'status' => 'required|integer|min:0|max:1'
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $vehicle = new Vehicle;
        if ($request->id  > 0){
            $vehicle = Vehicle::findOrFail($request->id);
        }
        $vehicle->plate = $request->plate;
        $vehicle->engine_number = $request->engine_number;
        $vehicle->chasis_number = $request->chasis_number;
        $vehicle->registration_date = $request->registration_date;
        $vehicle->expiry_date = $request->expiry_date;
        $vehicle->user_id = Auth::user()->id;
        $vehicle->vehicle_make_id = $request->vehicle_make;
        $vehicle->vehicle_model_id = $request->vehicle_model;
        $vehicle->country_id = $request->country;
        $vehicle->status = $request->status;
        if ($vehicle->save()){
            return response()->json(['success' => 'Vehicle updated successfully!']);
        } else {
            return response()->json(['error' => 'Unable to update vehicle!']);
        }
    }

    public function vehicleMake()
    {
        return view('account.vehicles_make');
    }

    public function getVehiclesMake(Request $request)
    {
        return Datatables::of(VehicleMake::get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->addColumn('status', function ($row) {
            return "<span class='badge bg-primary'>Active</span>";
        })->addColumn('action', function ($row) {
            $actionBtn = '<div style="white-space: nowrap;" class="text-end">' .
                '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a> ' . '
                                <a href="javascript:void(0)" class="delete btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View</a>'
                . '</div>';
            return $actionBtn;
        })->escapeColumns([])
        ->make(true);
    }
    public function addVehicleMake(Request $request){
        $validator = Validator::make($request->all(), [
            "id"=>'required|integer|min:0',
            'name' => 'required|max:255|string|unique:vehicle_makes,name,'.$request->id,
            'status' => 'required|integer|min:0|max:1'
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $vehicleMake = new VehicleMake;
        if ($request->id  > 0){
            $vehicleMake = VehicleMake::findOrFail($request->id);
        }
        $vehicleMake->name = $request->name;
        $vehicleMake->status = $request->status;
        if ($vehicleMake->save()){
            return response()->json(['success' => 'Vehicle Make updated successfully!']);
        } else {
            return response()->json(['error' => 'Unable to update vehicle make!']);
        }
    }
    public function searchVehiclesMake(Request $request){
        return json_encode(VehicleMake::where('name', 'LIKE', '%'.$request->q.'%')
        ->orderBy('name', 'asc')->get());
    }

    public function vehicleModels(){
        return view('account.vehicles_models');
    }
    
    public function getVehiclesModel(Request $request)
    {
        return Datatables::of(VehicleModel::with('vehicle_make')->get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->addColumn('make', function ($row) {
                return $row->vehicle_make != null?$row->vehicle_make->name:"";
            })->addColumn('status', function ($row) {
                return "<span class='badge bg-primary'>Active</span>";
            })->addColumn('action', function ($row) {
                $actionBtn = '<div style="white-space: nowrap;" class="text-end">' .
                                '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a> ' . '
                                <a href="javascript:void(0)" class="delete btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View</a>'
                            . '</div>';
                return $actionBtn;
            })->escapeColumns([])
            ->make(true);
    }
    public function addVehicleModel(Request $request){
        $validator = Validator::make($request->all(), [
            "id"=>'required|integer|min:0',
            'name' => 'required|max:255|string',
            'vehicle_make_id'=>'required|min:1|numeric',
            'status' => 'required|integer|min:0|max:1'
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $vehicleModel = new VehicleModel;
        if ($request->id  > 0){
            $vehicleModel = VehicleModel::findOrFail($request->id);
        }
        $vehicleModel->name = $request->name;
        $vehicleModel->vehicle_make_id = $request->vehicle_make_id;
        $vehicleModel->status = $request->status;
        if ($vehicleModel->save()){
            return response()->json(['success' => 'Vehicle Model updated successfully!']);
        } else {
            return response()->json(['error' => 'Unable to update vehicle model!']);
        }
    }
    public function searchVehiclesModel(Request $request){
        return json_encode(VehicleModel::where('name', 'LIKE', '%'.$request->q.'%')->where('vehicle_make_id', $request->vehicle_make_id)
        ->orderBy('name', 'asc')->get());
    }
    public function vehicleOwners(){
        return view('account.vehicles_owners');
    }
}
