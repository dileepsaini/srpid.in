@extends('admin.layouts.app')
@section('panel')
    <form action="{{ route('admin.student.import') }}" id="myform" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Select School</label>
                    <select class="form-control" name="school_id" id="select_school" required>
                        <option value="_0" selected>Please choose school</option>
                        @foreach ($schools as $key => $school)
                          
                            <option value="{{ $school->id }}">{{ $school->name }} </option>
                        @endforeach


                    </select>
                    <div class="text-danger" id="select_school_error"></div>
                </div>
            </div>
        </div>
        <div class="row d-none" id="show_fileds" >
            <div class="col-md-6 my-3">
                <input class="form-control" type="file" name="upload_file" id="upload_file" accept=".csv,.xls,.xlsx">    
            </div>
            <div class="col-md-6 my-3"></div>
            @php
                $fields = [
                    'student_name', 'father_name', 'father_image', 'mother_name', 'mother_image', 'guardian_image', 'dob',
                    'mobile', 'address', 'class', 'section', 'session', 'medium','adm_no', 'bus', 'blood_group', 'roll_no', 'email_id',
                    'designation', 'husband_name', 'emp_id', 'emp_name', 'blank_1', 'blank_2'
                ];
            @endphp

            @foreach ($fields as $key => $field)
                @continue(!in_array($field, $allowedFields)) {{-- ❌ Skip agar allowedFields me nahi hai --}}

                <div class="col-md-5 col-5 form-group">
                    <label>Select Field</label>
                    <select name="field_value[]" id="field_value_{{ $key }}" class="form-control sl-flt">
                        <option value="">Select Field</option>
                    </select>
                </div>
                <div class="col-md-1 col-2 swipe-datalist d-flex align-items-center">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </div>
                <div class="col-md-5 col-5 form-group">
                    <label>Field Name</label>
                    <select name="field_name[]" id="field_name_{{ $key }}" class="form-control">
                        <option value="{{ $field }}">{{ $field }}</option>
                    </select>
                </div>
            @endforeach

            {{-- @foreach ($fields as $key => $field)
                <div class="col-md-5 col-5 form-group">
                    <label>Select Field </label>
                    <select name="field_value[]" id="field_value_{{ $key }}" class="form-control sl-flt" >
                        <option value="">Select Field</option>
                    </select>
                </div>
                <div class="col-md-1 col-2 swipe-datalist d-flex align-items-center">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </div>
                <div class="col-md-5 col-5 form-group">
                    <label>Field Name </label>
                    <select name="field_name[]" id="field_name_{{ $key }}" class="form-control" >
                        <option value="{{ $field }}">{{ $field }}</option>
                    </select>
                </div>
            @endforeach --}}
        </div>

        <div class="row">
            <div class="col-md-6">
                <button type="submit" id="save_btn" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection

@push('breadcrumb-plugins')
    {{-- @permit('admin.studen.import')
        <li>
            <a class="dropdown-item importBtn" href="javascript:void(0)">
                <i class="las la-cloud-upload-alt"></i> @lang('Import CSV')</a>
        </li>
    @endpermit --}}

@endpush

<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

@push('script')
    <script>
        (function($) {
            "use strict"
            $(".importBtn").on('click', function(e) {
                let importModal = $("#importModal");
                importModal.modal('show');
            });
        })(jQuery);

        $(document).ready(function() {
            $('#select_school').select2()
            $('.sl-flt').select2()

           

            $(document).on('click', '#save_btn', function(){
                  const submitBtn = document.getElementById('save_btn');
                    $('#myform').submit();
                submitBtn.disabled = true;
                submitBtn.textContent = 'Submitting...'; // optional
            })
            $(document).on('click', '#final_submit', function(){
                var id = $('#select_school').val();
                 $('#select_school_error').text('');
                if(id == 0){
                     $('#show_fileds').addClass('d-none')
                  $('#select_school_error').text('This field is required!');
                  return false;
                }

                $('#myform').submit();
            })
            $(document).on('change', '#select_school',  function(){
                var id = $(this).val();
                $('#select_school_error').text('');
                if(id == 0){
                     $('#show_fileds').addClass('d-none')
                  $('#select_school_error').text('This field is required!');
                }

                $.ajax({
                    type: 'get',
                    url: '{{ route('admin.student.getSchool') }}',
                    data: {
                        id: id
                    },
                    success: function(resource){
                        console.log(resource);
                        if (resource && resource.fields) {

                            $('#show_fileds').removeClass('d-none')
                            let selectedFields = typeof resource.fields === 'string'
                                ? [...new Set(resource.fields.split(',').map(f => f.trim()))]
                                : resource.fields;

                            // Loop through each field_name[] <select>
                            $("select[name='field_name[]']").each(function (index) {
                                let fieldName = $(this).val(); // e.g., student_name
                                let valueSelect = $("select[name='field_value[]']").eq(index);

                                // Get the label element for this select
                                let labelElement = valueSelect.closest('.form-group').find('label').first();

                                if (selectedFields.includes(fieldName)) {
                                    // Add required attribute
                                    valueSelect.prop('required', true);

                                    // Add asterisk * if not already added
                                    if (!labelElement.html().includes('*')) {
                                        labelElement.html(labelElement.html() + ' <span style="color:red">*</span>');
                                    }
                                } else {
                                    // Optional: remove required and asterisk if not selected
                                    valueSelect.prop('required', false);
                                    labelElement.html(labelElement.html().replace(/<span style="color:red">\*<\/span>/g, ''));
                                }
                            });
                        }


                    }
                })
            });

            //  document.getElementById('upload_file').addEventListener('change', function (e) {
            //     const file = e.target.files[0];
            //     if (!file || file.type !== 'text/csv') {
            //         alert('Please upload a valid CSV file.');
            //         return;
            //     }

            //     const reader = new FileReader();
            //     reader.onload = function (event) {
            //         const csvText = event.target.result;
            //         const lines = csvText.split('\n');
            //         const headers = lines[0].split(',').map(h => h.trim().replace(/['"]+/g, ''));

            //         document.querySelectorAll('select[name="field_value[]"]').forEach(select => {
            //             select.innerHTML = '<option value="">Select Field</option>';

            //             headers.forEach((header, index) => {
            //                 const option = document.createElement('option');
            //                 option.value = columnIndexToLetter(index); // A, B, C...
            //                 option.textContent = header;               // student_name, etc.
            //                 select.appendChild(option);
            //             });
            //         });
            //     };

            //     reader.readAsText(file);
            //  });

            //         // Helper to convert 0 -> A, 1 -> B, 26 -> AA, etc.
            //     function columnIndexToLetter(index) {
            //         let letters = '';
            //         while (index >= 0) {
            //             letters = String.fromCharCode((index % 26) + 65) + letters;
            //             index = Math.floor(index / 26) - 1;
            //         }
            //         return letters;
            //     }

        });
    </script>
    <script>
document.getElementById('upload_file').addEventListener('change', function (e) {
    const file = e.target.files[0];

    // Validate Excel file type
    const allowedTypes = [
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
        'application/vnd.ms-excel'                                           // .xls
    ];

    if (!file || !allowedTypes.includes(file.type)) {
        alert('Please upload a valid Excel file (.xlsx or .xls).');
        return;
    }

    const reader = new FileReader();

    reader.onload = function (event) {
        const data = new Uint8Array(event.target.result);
        const workbook = XLSX.read(data, { type: 'array' });

        const sheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[sheetName];

        const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 }); // raw rows

        const headers = jsonData[0]; // First row is header

        // Populate select options
        document.querySelectorAll('select[name="field_value[]"]').forEach(select => {
            select.innerHTML = '<option value="">Select Field</option>';

            headers.forEach((header, index) => {
                const option = document.createElement('option');
                option.value = columnIndexToLetter(index); // A, B, C, etc.
                option.textContent = header || `Column ${columnIndexToLetter(index)}`;
                select.appendChild(option);
            });
        });
    };

    reader.readAsArrayBuffer(file); // Important: read as binary buffer
});

// Converts 0 => A, 1 => B, ... 26 => AA
function columnIndexToLetter(index) {
    let letters = '';
    while (index >= 0) {
        letters = String.fromCharCode((index % 26) + 65) + letters;
        index = Math.floor(index / 26) - 1;
    }
    return letters;
}
</script>

@endpush
<style>
    .col-lg-1.col-2.swipe-datalist {
    margin-top: 25px;
}
   .swipe-datalist i {
    background-color: #071251;
    display: block;
    /* / width: 55px; / */
    text-align: center;
    color: #fff;
    /* / bottom: 14%; / */
     /* position: absolute;  */
    /* / left: 0; / */
    /* / right: 0; / */
    padding: 10px;
    font-size: 22px;
    margin: auto;
    cursor: pointer;
}
</style>