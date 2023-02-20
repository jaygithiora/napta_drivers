<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Driver;
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
        return DataTables::of(Driver::with(['user'])->get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->addColumn('status', function ($row) {
                return "<span class='badge bg-primary'>Active</span>";
            })->addColumn('action', function ($row) {
                $actionBtn = '<div style="white-space: nowrap;" class="text-end">' .
                                '<span class="d-none id">'.$row->id.'</span>'.
                                '<span class="d-none name">'.$row->name.'</span>'.
                                '<span class="d-none phone_code">'.$row->phone_code.'</span>'.
                                '<span class="d-none country_code">'.$row->country_code.'</span>'.
                                '<span class="d-none status">'.$row->status.'</span>'.
                                '<button class="btn-edit btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#countryModal"><i class="fas fa-edit"></i> Edit</button> ' . '
                                <!--<a href="javascript:void(0)" class="delete btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View</a>-->'
                            . '</div>';
                return $actionBtn;
            })->escapeColumns([])
            ->make(true);
    }
    public function driverRequests(){
        return view('account.driver_requests');
    }

    public function viewDocumentUpload(Request $request){
        return view('account.document_upload');
    }
}
