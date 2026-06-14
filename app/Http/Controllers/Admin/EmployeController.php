<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Admin;
use App\Models\Student;
use DB;
use Log;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployeController extends Controller
{
    protected $pageTitle;

    public function __construct()
    {
        $this->pageTitle = 'All Student';
    }

    protected function getEmploye()
    {
        return Student::searchable(['name', 'mobile', 'email', 'address'], false)->orderBy('id', 'desc');
    }

   public function index(Request $request)
{
    $pageTitle = "Student List";
    $adminId = auth()->guard('admin')->id();
    $admins  = Admin::find($adminId);

    $allowedFields = array_filter(explode(',', $admins->fields ?? ''));
    

    // Queries for $distinctClasses and $all_school moved below AJAX block

    if ($request->ajax()) {
        $students = DB::table('tbl_student')
            ->leftJoin('admins', 'admins.id', '=', 'tbl_student.school_id')
            ->select(array_merge(
                array_map(fn($field) => "tbl_student.$field", $allowedFields),
                ['tbl_student.id', 'admins.name as school_name']
            ))
            ->orderBy('tbl_student.id', 'desc');

           $students->where('tbl_student.deleted', 0);
        if ($adminId != 1) {
            $students->where('tbl_student.school_id', $adminId);
        }

        $select_school = $request->filter['select_school'] ?? [];
        if (!is_array($select_school)) $select_school = [$select_school];
        $select_school = array_filter($select_school, function($value) { return $value !== '' && $value !== null; });
        if (!empty($select_school)) {
            $students->whereIn('tbl_student.school_id', $select_school);
        }

        $select_class = $request->filter['select_class'] ?? [];
        if (!is_array($select_class)) $select_class = [$select_class];
        $select_class = array_filter($select_class, function($value) { return $value !== '' && $value !== null; });
        if (!empty($select_class)) {
            $students->whereIn('tbl_student.class', $select_class);
        }

        $select_status = $request->filter['select_status'] ?? [];
        if (!is_array($select_status)) $select_status = [$select_status];
        $select_status = array_filter($select_status, function($value) { return $value !== '' && $value !== null; });
        if (!empty($select_status)) {
            if (in_array('0', $select_status) && ! in_array('1', $select_status)) {
                $students->whereNull('tbl_student.profile');
            } elseif (! in_array('0', $select_status) && in_array('1', $select_status)) {
                $students->whereNotNull('tbl_student.profile');
            }
        }

        if ($request->has('mobile')) {
            $page = $request->input('page', 1);
            $perPage = 15;

            // Pagination
            $data = $students->skip(($page - 1) * $perPage)->take($perPage)->get();

            foreach ($data as $student) {
                $actions = '';
                if (permit('admin.student.edit')) {
                    $actions .= '<a href="' . route('admin.student.edit', $student->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                }
                if (permit('admin.student.delete')) {
                    $actions .= '<a href="' . route('admin.student.delete', $student->id) . '" class="btn btn-sm btn-danger mx-2" onclick="return confirm(\'Are you sure?\')">Delete</a>';
                }
                $student->action = $actions;
            }

            return response()->json(['data' => $data]);
        }

        return datatables()->of($students)
            ->addColumn('action', function ($row) {
                $actions = '';
                if (permit('admin.student.edit')) {
                    $actions .= '<a href="' . route('admin.student.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                }
                if (permit('admin.student.delete')) {
                    $actions .= '<a href="' . route('admin.student.delete', $row->id) . '" class="btn btn-sm btn-danger mx-2" onclick="return confirm(\'Are you sure?\')">Delete</a>';
                }
                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    if ($adminId != 1) {
        $distinctClasses = Student::select(DB::raw('MIN(id) as id'), 'class')
            ->whereNotNull('class')
            ->where('school_id', $adminId)
            ->groupBy('class')
            ->orderBy('class')
            ->get();

        $all_school = Admin::where('status', 1)->where('id', $adminId)->get();
    } else {
        $all_school = Admin::where('status', 1)->get();
        $distinctClasses = Student::select(DB::raw('MIN(id) as id'), 'class')
            ->whereNotNull('class')
            ->groupBy('class')
            ->orderBy('class')
            ->get();
    }

        if (!empty($admins->name)) {
             array_unshift($allowedFields, 'school_name');
        }

// optional: duplicates remove
$allowedFields = array_unique($allowedFields);
// DD($allowedFields);

    return view('admin.student.index', compact('pageTitle', 'allowedFields', 'all_school', 'distinctClasses'));
}


    public function importAll()
    {
        $pageTitle = 'Import Student';
        $adminId = auth()->guard('admin')->id();
        if($adminId == 1){
                    $schools   = Admin::where('status', 1)->get();

        }else{
                     $schools   = Admin::where('status', 1)->where('id',$adminId)->get();

        }
        $admins  = Admin::find($adminId);
        $allowedFields = array_filter(explode(',', $admins->fields ?? ''));
        return view('admin.student.import', compact('pageTitle', 'schools','allowedFields'));
    }

    public function downloadPhotos(Request $request)
    {
        
     
        $filter = $request->filter ?? [];
  
        $students = Student::query();
        $students->where('deleted', 0);
       $getschool_name = '';
        if (!empty($filter['school_id'])) {
            $students->whereIn('school_id', $filter['school_id']);
            
            $school_name = Admin::find($filter['school_id']);
              $getschool_name = $school_name->pluck('name');
        }else{
             $getschool_name = 'student_profiles';
        }

        if (!empty($filter['class'])) {
            $students->whereIn('class', $filter['class']);
        }

        $students = $students->get();
      
    //   echo '<pre>';
    //   print_r($students);
    //   echo '</pre>';die;
        
        $zipFolder = public_path('zip');
       
     

        
        
        $zipFileName = $getschool_name .'_'. time() . '.zip';
        $zipPath = $zipFolder . DIRECTORY_SEPARATOR . $zipFileName;
        
        if (!File::exists($zipFolder)) {
            File::makeDirectory($zipFolder, 0775, true);
        }
        
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach ($students as $student) {
                if ($student->profile) {
                    $imagePath = public_path('students/' . $student->profile);
        
                    if (file_exists($imagePath)) {
                        $zip->addFile($imagePath, $student->profile);
                        Log::info("Added to ZIP: " . $imagePath);
                    } else {
                        Log::warning("Not found: " . $imagePath);
                    }
                }
            }
        
            $zip->close();
        } else {
            return response()->json(['error' => 'Could not create ZIP file.'], 500);
        }
        
        
    
        
        if (!file_exists($zipPath)) {
            Log::error('ZIP NOT FOUND at: ' . $zipPath);
            return response()->json(['error' => 'ZIP file not found after creation.'], 500);
        }
            // DD($zipPath);
        return response()->json([
            'success' => true,
            'url' => asset('zip/' . $zipFileName),
            'path' => $zipPath
        ]);

    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Student::whereIn('id', $ids)->update(['deleted' => 1]);
            return response()->json(['message' => 'Selected students deleted successfully.']);
        }

        return response()->json(['message' => 'No students selected.'], 400);
    }



    public function getSchool(Request $request)
    {

        $school = Admin::find($request->id);

        return response()->json($school, 200);
    }
    public function edit($id)
    {
        $pageTitle     = "Update Student";
        $adminId       = auth()->guard('admin')->id();
       
       $student       = Student::find($id);
        
        $get_school_id = 0;
        if($student){
            $get_school_id = $student->school_id;
        }else{
              $get_school_id = $adminId;
        }

      
       $admin         = Admin::find($get_school_id);
        $allowedFields = array_filter(explode(',', $admin->fields ?? ''));
       
        //  DD($student);
        return view('admin.student.edit', compact('pageTitle', 'allowedFields', 'student'));
    }

    public function create(Request $request)
    {
        $school_id = $request->school_id;
        $pageTitle     = "Add Student";
        $adminId       = auth()->guard('admin')->id();
        $admin         = Admin::find($school_id);
        $allowedFields = array_filter(explode(',', $admin->fields ?? ''));
        return view('admin.student.create', compact('pageTitle', 'allowedFields','school_id'));
    }

    public function studentCSV(Request $request)
    {
        $pageTitle = $this->pageTitle;
         $students = Student::query();
        $students->where('deleted', 0);
        // Correct keys from $request->filter
        $filter = $request->filter ?? [];

        $school_ids = $filter['school_id'] ?? [];
        if (!empty($school_ids)) {
            $students->whereIn('school_id', $school_ids);
        }

        $class_list = $filter['class'] ?? [];
        if (!empty($class_list)) {
            $students->whereIn('class', $class_list);
        }

        $students = $students->get();

        $filename  = $this->downloadCsv($pageTitle, $students);
        return response()->download(...$filename);
    }

    protected function downloadCsv($pageTitle, $data)
    {

        $adminId     = auth()->guard('admin')->id();
        $get_student = Admin::find($adminId);

        // Get allowed fields for this admin (as array)
        $allowedFields = array_filter(explode(',', $get_student->fields ?? ''));

        // Human-readable column titles
        $fieldLabels = [
            'student_name' => 'Student Name',
            'profile'      => 'Student Profile',
            'mobile'       => 'Phone Number',
            'email_id'     => 'Student Email',
            'father_name'  => 'Father Name',
            'mother_name'  => 'Mother Name',
            'address'      => 'Address',
            'dob'          => 'DOB',
            'class'        => 'Class',
            'section'      => 'Section',
            'session'      => 'Session',
            'adm_no'       => 'Admission no',
            'bus'          => 'Bus no',
            'blood_group'  => 'Blood Group',
            'roll_no'      => 'Roll no',
            'designation'  => 'Designation',
            'husband_name' => 'Husband Name',
            'emp_id'       => 'Emp ID',
            'emp_name'     => 'Employee Name',
            'blank_1'      => 'Blank 1',
            'blank_2'      => 'Blank 2',
            'created_at'   => 'Created At',
        ];

        // Prepare CSV output
        $filename = "assets/files/csv/example.csv";
        $myFile   = fopen($filename, 'w');

        // Header row
        $headerRow = [];
        foreach ($allowedFields as $field) {
            $headerRow[] = $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field));
        }
        fputcsv($myFile, $headerRow);

        // Data rows
        foreach ($data as $employe) {
            $row = [];
            foreach ($allowedFields as $field) {
                $row[] = $employe->$field ?? '';
            }
            fputcsv($myFile, $row);
        }

        fclose($myFile);

        $headers = [
            'Content-Type' => 'application/csv',
        ];
        $name = $pageTitle . time() . '.csv';
        return [$filename, $name, $headers];

    }

    public function studentExcel(Request $request)
    {
        $pageTitle = $this->pageTitle;
        $students = Student::query();
        $students->where('deleted', 0);
        $filter = $request->filter ?? [];

        $school_ids = $filter['school_id'] ?? [];
        if (!empty($school_ids)) {
            $students->whereIn('school_id', $school_ids);
        }

        $class_list = $filter['class'] ?? [];
        if (!empty($class_list)) {
            $students->whereIn('class', $class_list);
        }

        $students = $students->get();

        return $this->downloadExcelFile($pageTitle, $students);
    }

    protected function downloadExcelFile($pageTitle, $data)
    {
        $adminId     = auth()->guard('admin')->id();
        $get_student = Admin::find($adminId);

        $allowedFields = array_filter(explode(',', $get_student->fields ?? ''));

        $fieldLabels = [
            'student_name' => 'Student Name',
            'profile'      => 'Student Profile',
            'mobile'       => 'Phone Number',
            'email_id'     => 'Student Email',
            'father_name'  => 'Father Name',
            'mother_name'  => 'Mother Name',
            'address'      => 'Address',
            'dob'          => 'DOB',
            'class'        => 'Class',
            'section'      => 'Section',
            'session'      => 'Session',
            'adm_no'       => 'Admission no',
            'bus'          => 'Bus no',
            'blood_group'  => 'Blood Group',
            'roll_no'      => 'Roll no',
            'designation'  => 'Designation',
            'husband_name' => 'Husband Name',
            'emp_id'       => 'Emp ID',
            'emp_name'     => 'Employee Name',
            'blank_1'      => 'Blank 1',
            'blank_2'      => 'Blank 2',
            'created_at'   => 'Created At',
        ];

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headerRow = [];
        foreach ($allowedFields as $field) {
            $headerRow[] = $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field));
        }

        $sheet->fromArray($headerRow, NULL, 'A1');

        $rowData = [];
        foreach ($data as $employe) {
            $row = [];
            foreach ($allowedFields as $field) {
                $row[] = $employe->$field ?? '';
            }
            $rowData[] = $row;
        }

        $sheet->fromArray($rowData, NULL, 'A2');

        $fileName = $pageTitle . time() . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }


public function ImgUpdate(Request $request)
{
    // Validation (optional to uncomment)
    // $request->validate([
    //     'id' => 'required|integer',
    //     'image' => 'required|file|image|mimes:jpeg,png,jpg,gif,webp',
    //     'type' => 'required|string|in:profile,father_image,mother_image,guardian_image'
    // ]);

    $student = Student::findOrFail($request->id);
    $admin = Admin::find(auth()->guard('admin')->id());

    $file = $request->file('image');

    // Unique JPG filename
    $filename = $admin->code . '_' . time() . '_' . $request->type . '.jpg';

    $destinationPath = public_path('students');

    // Create directory if it doesn't exist
    if (!File::exists($destinationPath)) {
        File::makeDirectory($destinationPath, 0755, true);
    }

    // Convert and save image as JPG using Intervention
    $image = Image::make($file)->encode('jpg', 90); // 90 is quality
    $image->save($destinationPath . '/' . $filename);

    // Update student record
    $student->{$request->type} = $filename;
    $student->save();

    return response()->json([
        'success' => true,
        'image_path' => asset('students/' . $filename)
    ]);
}



    public function store(Request $request, $id = 0)
    {

        //   DD($request->all());
        // Get current admin
        $adminId = auth()->guard('admin')->id();

        // Get allowed fields (only those will be saved)
        $admin         = Admin::find($adminId);
        $allowedFields = array_filter(explode(',', $admin->fields ?? ''));

        // All possible fields
        $allFields = [
            'student_name', 'profile', 'email_id', 'mobile', 'address', 'father_name', 'father_image',
            'mother_name', 'mother_image', 'guardian_image', 'dob', 'class', 'section', 'session', 'adm_no',
            'studen_signature', 'employe_signature', 'medium', 'bus', 'blood_group', 'roll_no',
            'designation', 'husband_name', 'emp_id', 'emp_name', 'blank_1', 'blank_2',
        ];

        // Validate only required fields
        $rules = [];
        foreach ($allFields as $field) {
            if (in_array($field, $allowedFields)) {
                if (in_array($field, ['profile', 'father_image', 'mother_image', 'guardian_image'])) {
                    $rules[$field] = 'nullable|image|mimes:jpeg,png,jpg';
                } elseif (in_array($field, ['email_id'])) {
                    $rules[$field] = 'nullable|email';
                } elseif (in_array($field, ['dob'])) {
                    $rules[$field] = 'nullable|date';
                } elseif (in_array($field, ['studen_signature', 'employe_signature'])) {
                    $rules[$field] = 'nullable|string';
                } else {
                    $rules[$field] = 'required|string';
                }
            }
        }

        // $request->validate($rules);

        // Insert or update
        $student = $id ? Student::findOrFail($id) : new Student();
        if($id){
            $schoolId = $student->school_id;
        }else{
              $schoolId = $request->school_id;
        }

         $student->school_id = $schoolId;

        // Handle file/image upload
       foreach (['profile','father_image', 'mother_image', 'guardian_image'] as $imgField) {
                if ($request->hasFile($imgField)) {
                    $file = $request->file($imgField);
                    
                    $destinationPath = public_path('students');
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true);
                    }
            
                    $filename = $admin->code . '_' . time() . $imgField . '.jpg';
                    $image = Image::make($file)->encode('jpg', 90);
                    $image->save($destinationPath . '/' . $filename);
            
                    $student->$imgField = $filename;
                }
            }

        if ($request->has('cropped_profile')) {
            $croppedImage = $request->input('cropped_profile');
        
            if (preg_match('/^data:image\/(\w+);base64,/', $croppedImage)) {
                $croppedImage = substr($croppedImage, strpos($croppedImage, ',') + 1);
                $decoded = base64_decode($croppedImage);
        
                if ($decoded === false) {
                    throw new \Exception('Base64 decode failed');
                }
        
                $filename = $admin->code . '_' . time() . 'profile.jpg';
                $destinationPath = public_path('students');
        
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
        
                // Convert decoded base64 data to image and save as JPG
                $image = Image::make($decoded)->encode('jpg', 90);
                $image->save($destinationPath . '/' . $filename);
        
                $student->profile = $filename;
            }
        }

        // Handle signatures (base64 images)
      foreach (['studen_signature', 'employe_signature'] as $sigField) {
            $signature = $request->$sigField;
        
            if ($signature && preg_match('/^data:image\/(\w+);base64,/', $signature)) {
                $signature = str_replace(' ', '+', $signature);
                $signature = substr($signature, strpos($signature, ',') + 1);
        
                $decoded = base64_decode($signature);
        
                if ($decoded === false || strlen($decoded) < 100) {
                    throw new \Exception("Base64 decode failed or content too small");
                }
        
                $fileName = uniqid($sigField . '_') . '.png';
                $destinationPath = public_path('students/signatures');
        
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
        
                // Convert and save as PNG to preserve transparency
                $image = Image::make($decoded)->encode('png');
                $image->save($destinationPath . '/' . $fileName);
        
                $student->$sigField = '/signatures/' . $fileName;
            }
        }



        // Store other data fields
        foreach ($allFields as $field) {
            if (! in_array($field, ['profile', 'father_image', 'mother_image', 'guardian_image', 'studen_signature', 'employe_signature'])) {
                $student->$field = $request->$field;
            }
        }

        $student->save();

        return redirect()->route('admin.student.index')->with('success', 'Student saved successfully!');
    }

    protected function saveEmploye($request, $employe, $id)
    {
        $employe->name         = $request->name;
        $employe->email        = strtolower(trim($request->email));
        $employe->mobile       = $request->mobile;
        $employe->company_name = $request->company_name;
        $employe->address      = $request->address;
        $employe->save();
        Action::newEntry($employe, $id ? 'UPDATED' : 'CREATED');
    }

    protected function validation($request, $id = 0)
    {
        $request->validate([
            'name'         => 'required|string|max:40',
            'email'        => 'required|string|email|unique:employes,email,' . $id,
            'mobile'       => 'required|regex:/^([0-9]*)$/|unique:employes,mobile,' . $id,
            'company_name' => 'nullable|string|max:40',
            'address'      => 'nullable|string|max:500',
        ]);
    }

   public function import(Request $request)
{
    $fieldValues = $request->input('field_value', []);
    $fieldNames  = $request->input('field_name', []);
    $excelFile   = $request->file('upload_file');

    if (! $excelFile || ! $excelFile->isValid()) {
        return back()->with('error', 'Invalid Excel file.');
    }

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile->getRealPath());
    $sheetData   = $spreadsheet->getActiveSheet()->toArray();

    $headerRow = array_shift($sheetData); // Remove headers

    $columnIndexMap = [];
    foreach ($fieldValues as $i => $colLetter) {
        if (!empty($colLetter) && !empty($fieldNames[$i])) {
            $index = ord(strtoupper($colLetter)) - 65;
            $columnIndexMap[$fieldNames[$i]] = $index;
        }
    }

    $existingMobiles = Student::pluck('mobile')->filter()->toArray();
    $existingEmails  = Student::pluck('email_id')->filter()->toArray();

    $importedData = [];

    foreach ($sheetData as $row) {
        $data = ['school_id' => $request->input('school_id')];
        foreach ($columnIndexMap as $fieldName => $index) {
            $data[$fieldName] = $row[$index] ?? null;
        }

        Student::create($data);
        $importedData[] = $data;
    }

    if (!empty($importedData)) {
        return redirect()->route('admin.student.index')->with('success', 'Excel data imported successfully!');
    } else {
        return redirect()->route('admin.student.index')->with('error', 'No valid data to import.');
    }
}

    public function delete($id){
        $delete = Student::find($id);
       if ($delete) {
            $delete->deleted = 1;
            $delete->save();
        }
       return redirect()->route('admin.student.index')->with('success', 'Student deleted successfully!');
    }
}
