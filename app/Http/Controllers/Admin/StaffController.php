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

    public function index(Request $request)
    {
        $pageTitle = 'All School';
        $adminId = auth()->guard('admin')->id();

        if ($request->ajax()) {
            if ($adminId == 1) {
                $query = Admin::with('role');
            } else {
                $query = Admin::with('role')->where('id', $adminId);
            }

            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('school_name', function ($row) {
                    return __($row->name);
                })
                ->addColumn('fields_allowed', function ($row) {
                    return implode(', ', explode(',', $row->fields));
                })
                ->addColumn('role_name', function ($row) {
                    return $row->role ? $row->role->name : __('Super Admin');
                })
                ->addColumn('status', function ($row) {
                    return $row->statusBadge;
                })
                ->addColumn('action', function ($row) {
                    return view('admin.school.action', ['staff' => $row])->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $roles = Role::all();
        return view('admin.school.index', compact('pageTitle', 'roles'));
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

    public function schoolExcel(Request $request)
    {
        // Only allow super admin
        if (auth()->guard('admin')->id() != 1) {
            abort(403);
        }

        $schools = Admin::with('role')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headerRow = [
            'ID', 'School Username', 'School Name', 'School Email', 
            'School Partner', 'School Phone', 'School Address', 
            'School Code', 'Allowed Fields', 'Role', 'Status'
        ];

        $sheet->fromArray($headerRow, NULL, 'A1');

        $rowData = [];
        foreach ($schools as $school) {
            $rowData[] = [
                $school->id,
                $school->username,
                $school->name,
                $school->email,
                $school->partner,
                $school->mobile,
                $school->addresh,
                $school->code,
                implode(', ', explode(',', $school->fields)),
                $school->role ? $school->role->name : 'Super Admin',
                $school->status == 1 ? 'Active' : 'Inactive'
            ];
        }

        $sheet->fromArray($rowData, NULL, 'A2');

        $fileName = 'Schools_' . time() . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
