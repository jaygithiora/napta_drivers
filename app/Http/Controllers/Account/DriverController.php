<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverApproval;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function drivers(){
        return view('account.drivers');
    }
    public function getDrivers(Request $request){
        return DataTables::of(Driver::with(['user.country', 'user.roles'])->get())
            ->addIndexColumn()
            ->editColumn('name', function($row){
                return $row->user->firstname.' '.$row->user->lastname;
            })->editColumn('role', function($row){
                $role = $row->user->roles->first();
                return $role != null?$role->name:"";
            })->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->addColumn('status', function ($row) {
                return $row->status == 0?"<span class='badge bg-secondary'>Pending</span>":($row->status == 1?"<span class='badge bg-primary'>Approved</span>":($row->status == 2?"<span class='badge bg-warning'>Suspended</span>":"<span class='badge bg-danger'>Denied</span>"));
            })->addColumn('action', function ($row) {
                $actionBtn = '<div style="white-space: nowrap;" class="text-end">' .
                                '<span class="d-none id">'.$row->id.'</span>'.
                                '<span class="d-none name">'.$row->name.'</span>'.
                                '<span class="d-none phone_code">'.$row->phone_code.'</span>'.
                                '<span class="d-none country_code">'.$row->country_code.'</span>'.
                                '<span class="d-none status">'.$row->status.'</span>'.
                                '<a href="'.url('drivers/view/'.$row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a> ' . '
                                <!--<a href="javascript:void(0)" class="delete btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View</a>-->'
                            . '</div>';
                return $actionBtn;
            })->escapeColumns([])
            ->make(true);
    }
    public function driver(Request $request){
        $driver = Driver::with('user.country')->where('id', $request->id)->first();
        $driverApproval = DriverApproval::where('driver_id', $request->id)->orderBy('id', 'DESC')->first();
        return view('account.driver', ['driver'=>$driver, 'driverApproval'=>$driverApproval]);
    }
    public function driverRequests(){
        return view('account.driver_requests');
    }

    public function viewDocumentUpload(Request $request){
        return view('account.document_upload');
    }
}
