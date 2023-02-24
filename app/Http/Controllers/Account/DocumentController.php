<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\DocumentTypeRole;
use App\Models\DocumentUpload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function viewDocumentsUpload(Request $request)
    {
        // $doc = DocumentTypeRole::where('role_id', $role- >id)->with('document_type.document_uploads')->whereHas("document_type", function ($query) {
        //     $query->where('required', 1);
        // })->get();
        $user = User::with('roles')->findOrFail(\Auth::user()->id);
        $role_ids = $user->roles->pluck('id');

        $documentType = DocumentTypeRole::with('document_type')->where('id', $request->id)->whereIn('role_id', $role_ids)
            ->first();
        $documentTypes = DocumentTypeRole::with('document_type')->whereIn('role_id', $role_ids)
            ->get();
        if ($documentType == null) {
            return redirect()->to('home');
        }

        $step = 0;
        $count = 0;
        $prev_id = 0;
        $next_id = 0;
        foreach ($documentTypes as $doc) {
            $count++;
            if ($doc->id == $documentType->id) {
                $step = $count;
            }
            if($step == 0){
                $prev_id = $doc->id;
            }else if($step > 0 && $prev_id < $doc->id && $documentType->id != $doc->id){
                $next_id = $doc->id;
                break;
            }
        }
        return view('account.document_upload', ['documentType' => $documentType,
        'documentTypes' => $documentTypes, "step"=>$step, 'prev_id'=>$prev_id, 'next_id'=>$next_id]);
    }
    
    public function documents(){
        return view('account.documents');
    }

    public function getDocuments(Request $request){
        return Datatables::of(DocumentUpload::with(['document_type', 'user'])->get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->addColumn('fullname', function ($row) {
                return $row->user->firstname.' '.$row->user->lastname;
            })->addColumn('status', function ($row) {
                return "<span class='badge bg-primary'>Active</span>";
            })->addColumn('action', function ($row) {
                $actionBtn = '<div style="white-space: nowrap;" class="text-end">' .
                                '<a href="'.asset('uploads/'.$row->name).'" class="btn btn-primary btn-sm" download="'.$row->upload_name.'"><i class="fas fa-file-download"></i> Download</a>'
                            . '</div>';
                return $actionBtn;
            })->escapeColumns([])
            ->make(true);
    }
    public function myDocuments(){
        return view('account.my_documents');
    }
    public function getMyDocuments(Request $request){
        return Datatables::of(DocumentUpload::with(['document_type'])->where('user_id',$request->id)->get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->addColumn('status', function ($row) {
                return $row->status==1?"<span class='badge bg-success'>Approved</span>":($row->status==2?"<span class='badge bg-danger'>Rejected</span>":"<span class='badge bg-secondary'>Pending</span>");
            })->addColumn('action', function ($row) {
                return '<div style="white-space: nowrap;" class="text-end">' .
                                '<form class="d-none" action="driver/review" method="POST">'.csrf_field().'<input type="hidden" value="'.$row->id.'"><input type="hidden" name="status" value="'.$row->id.'"></form>'.
                                '<div class="dropdown">
                                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a href="'.asset('uploads/'.$row->name).'" class="dropdown-item" download="'.$row->upload_name.'"><i class="fas fa-cloud-download-alt"></i> Download</a></li>
                                        <li><a href="#" class="dropdown-item text-success btn-approve"><i class="fas fa-thumbs-up"></i> Approve</a></li>
                                        <li><a href="'.asset('uploads/'.$row->name).'" class="dropdown-item text-danger" download="'.$row->upload_name.'"><i class="fas fa-thumbs-down"></i> Reject</a></li>
                                    </ul>
                                </div>'.
                                '<!--<a href="'.asset('uploads/'.$row->name).'" class="btn btn-primary btn-sm" download="'.$row->upload_name.'"><i class="fas fa-cloud-download-alt"></i></a>-->'
                            . '</div>';
            })->escapeColumns([])
            ->make(true);
    }
}
