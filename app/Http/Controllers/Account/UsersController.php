<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('account.users');
    }

    public function getUsers(Request $request)
    {
        return Datatables::of(User::get())
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->firstname . ' ' . $row->lastname;
            })->editColumn('created_at', function ($row) {
            return Carbon::parse($row->created_at)->diffForHumans();
        })->addColumn('status', function ($row) {
            return "<span class='badge bg-primary'>Active</span>";
        })->addColumn('role', function ($row) {
            return "<span class='text-muted'>User</span>";
        })->addColumn('action', function ($row) {
            $actionBtn = '<div style="white-space: nowrap;" class="text-end">' .
                '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a> ' . '
                                <a href="javascript:void(0)" class="delete btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View</a>'
                . '</div>';
            return $actionBtn;
        })
            ->escapeColumns([])
            ->make(true);
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => 'required|integer|min:0',
            'name' => 'required|max:255|string',
            'email' => 'required|email|string|unique:users,email,' . $request->id,
            'password' => 'required|string|min:8|same:confirm_password'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $user = new User;
        if ($request->id > 0) {
            $user = User::findOrFail($request->id);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            return response()->json(['success' => 'User updated successfully!']);
        } else {
            return response()->json(['error' => 'Unable to update user!']);
        }
    }

    public function roles()
    {
        return view('account.roles');
    }
    public function getRoles(Request $request)
    {
        return Datatables::of(Role::get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->addColumn('status', function ($row) {
            return "<span class='badge bg-primary'>Active</span>";
        })->addColumn('role', function ($row) {
            return "<span class='text-muted'>User</span>";
        })->addColumn('action', function ($row) {
            $actionBtn = '<div style="white-space: nowrap;" class="text-end"><span class="d-none id">' . $row->id . '</span>' .
                '<button class="btn btn-primary btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#roleModal"><i class="fas fa-edit"></i> Edit</button> ' . '
                            <a href="' . url('users/roles/view/' . $row->id) . '" class="delete btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i> View</a>'
                . '</div>';
            return $actionBtn;
        })
            ->escapeColumns([])
            ->make(true);
    }
    public function addRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => 'required|integer|min:0',
            'name' => 'required|string|unique:roles,name,' . $request->id,
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $role = new Role;
        if ($request->id > 0) {
            $role = Role::findOrFail($request->id);
        }
        $role->name = $request->name;
        if ($role->save()) {
            return response()->json(['success' => 'Role updated successfully!']);
        } else {
            return response()->json(['error' => 'Unable to update role!']);
        }
    }

    public function viewRole(Request $request)
    {
        if (Permission::where('name', 'view profile')->count() == 0) {
            Permission::create(["name" => "view profile"]);
            Permission::create(["name" => "edit profile"]);
        }
        $role = Role::findOrFail($request->id);
        if ($role == null) {
            return back()->with('error', 'Invalid role id');
        }
        return view('account.role', ['role' => $role]);
    }

    public function searchPermissions(Request $request)
    {
        return json_encode(Permission::where('name', 'LIKE', '%' . $request->q . '%')
            ->orderBy('name', 'asc')->get());
    }


    public function getRolePermissions(Request $request)
    {
        return Datatables::of(Permission::whereHas('roles', function ($query) use ($request) {
            $query->where('id', $request->id);
        })->get())
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->diffForHumans();
            })->addColumn('status', function ($row) {
            return "<span class='badge bg-primary'>Active</span>";
        })->addColumn('role', function ($row) {
            return "<span class='text-muted'>User</span>";
        })->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" name="id[]" value="'.$row->id.'">';
        })->addColumn('action', function ($row) {
            $actionBtn = '<div style="white-space: nowrap;" class="text-end"><span class="d-none id">' . $row->id . '</span>' .
                            '<button class="btn btn-warning btn-sm btn-edit"><i class="fas fa-trash"></i> Delete</button> '
                        . '</div>';
            return $actionBtn;
        })
            ->escapeColumns([])
            ->make(true);
    }

    public function addRolePermission(Request $request){

    }
}