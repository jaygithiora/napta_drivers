<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
class CountryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function countries(){
        return view('account.countries');
    }
    
    public function getCountries(Request $request)
    {
        return Datatables::of(Country::get())
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
    public function addCountry(Request $request){
        $validator = Validator::make($request->all(), [
            "id"=>'required|integer|min:0',
            'name' => 'required|max:255|string|unique:countries,name,'.$request->id,
            'country_code' => 'required|max:255|string|unique:countries,country_code,'.$request->id,
            'phone_code'=>'required|string|unique:countries,phone_code,'.$request->id,
            'status' => 'required|integer|min:0|max:1'
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $country = new Country;
        if ($request->id  > 0){
            $country = Country::findOrFail($request->id);
        }
        $country->name = $request->name;
        $country->country_code = $request->country_code;
        $country->phone_code = $request->phone_code;
        $country->status = $request->status;
        if ($country->save()){
            return response()->json(['success' => 'Country updated successfully!']);
        } else {
            return response()->json(['error' => 'Unable to update country!']);
        }
    }
    
    public function searchCountries(Request $request){
        return json_encode(Country::where('name', 'LIKE', '%'.$request->q.'%')->orderBy('name', 'asc')->get());
    }
}

