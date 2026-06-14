<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{

    public function index()
    {
        $pageTitle = 'All School';
         $adminId = auth()->guard('admin')->id();
         if($adminId == 1){
             $allStaff  = Admin::with('role')->searchable(['username', 'name', 'mobile'])->orderBy('name', 'asc')->paginate(getPaginate());
            $roles     = Role::all();
         }else{
             $allStaff  = Admin::with('role')->where('id', $adminId)->searchable(['username', 'name', 'mobile'])->orderBy('name', 'asc')->paginate(getPaginate());
       
             $roles     = Role::all();
         }

         
        return view('admin.school.index', compact('pageTitle', 'allStaff', 'roles'));
    }

    public function status($id)
    {
        return Admin::changeStatus($id);
    }

    public function save(Request $request, $id = 0)
    {

        // DD($request->all());

        $this->validation($request, $id);
        if ($id) {
            $staff   = Admin::findOrFail($id);
            $message = "School updated successfully";
        } else {
            $staff   = new Admin();
            $message = "New School added successfully";
        }

         if ($request->hasFile('image')) {
            try {
                $old = $staff->image;
                $staff->image = fileUploader($request->image, getFilePath('adminProfile'), getFileSize('adminProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $staff->name     = $request->name;
        $staff->username = $request->username;
        $staff->email    = $request->email;
        $staff->mobile    = $request->mobile;
        $staff->partner    = $request->partner;
        $staff->addresh    = $request->addresh;
        $staff->code    = $request->code;
        $staff->fields = implode(',', $request->fields);

        if($request->role_id != 0){
             $staff->role_id  = $request->role_id;
        }
        $staff->password = $request->password ? Hash::make($request->password) : $staff->password;
        $staff->save();
        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function add(){
        ///
    }
    public function edit(){
        ///
    }
    private function validation($request, $id)
    {
        $request->validate([
            'username' => 'required|unique:admins,username,' . $id,
            'code' => 'required|unique:admins,code,' . $id,
            'name'     => 'required',
            'email'    => 'required|unique:admins,email,' . $id,
            'password' => !$id ? 'required|min:6' : 'nullable',
        ]);
    }

    public function login($id)
    {
        Auth::guard('admin')->loginUsingId($id);
        return to_route('admin.dashboard');
    }
}
