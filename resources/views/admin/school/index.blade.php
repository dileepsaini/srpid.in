@extends('admin.layouts.app')
@section('panel')
<style>
/* Override theme's custom responsive table stacking */
.table-responsive table td, .table-responsive table th,
table.table--light.style--two tbody td,
table.table--light.style--two thead th {
    display: table-cell !important;
    text-align: left !important;
    font-size: large !important;
    white-space: nowrap !important;
    padding-left: 10px !important;
}

.table-responsive table tr {
    display: table-row !important;
}

.table-responsive table thead {
    display: table-header-group !important;
}

.table-responsive table tbody {
    display: table-row-group !important;
}

.table-responsive table td::before {
    display: none !important;
}

.table-responsive {
    max-height: 600px;
    overflow-y: auto;
    overflow-x: auto; /* Enable horizontal scrolling */
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
}
table.table--light thead th {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: #4634ff !important;
    color: #ffffff !important;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive--md table-responsive">
                    <table class="table table--light style--two" id="schoolTable">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('School Username')</th>
                                <th>@lang('School Name')</th>
                                <th>@lang('School Email')</th>
                                <th>@lang('School Partner')</th>
                                <th>@lang('School Phone')</th>
                                <th>@lang('School Addresh')</th>
                                <th>@lang('School Code')</th>
                                <th>@lang('Allowed Fields')</th>
                                <th>@lang('Role')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
<x-confirmation-modal />

<!-- Create Update Modal -->
<div class="fade modal modal-xl" id="cuModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>

            <form action="{{ route('admin.school.save') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label>@lang('School Name')</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Partner')</label>
                        <input type="text" class="form-control" name="partner">
                    </div>

                    <div class="form-group">
                        <label>@lang('School Username')</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>

                    <div class="form-group">
                        <label>@lang('School Email')</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('School Mobile No')</label>
                        <input type="text" class="form-control" name="mobile" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('School Address')</label>
                        <input type="text" class="form-control" name="addresh" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('School Code')</label>
                        <input type="text" class="form-control" name="code" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Upload Photo')</label>
                        <input type="file" class="form-control" name="image" >
                    </div>
                       @php
                                use Illuminate\Support\Facades\Auth;

                                   $adminId       = auth()->guard('admin')->id();
                        @endphp
                       @if ($adminId == 1)
                              
                             <div class="form-group">
                        <label>Select Student Field </label><br>

                        <label  style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="student_name"> Student Name</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]"  value="profile"> Student Image</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]"  value="father_name"> Father Name</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" value="father_image"> Father Image</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]"  value="mother_name"> Mother Name</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" value="mother_image"> Mother Image</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" value="guardian_image"> Guardian Image</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]"  value="dob"> DOB</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]"  value="mobile"> Mobile</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]"  value="address"> Address</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="class"> Class</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="section"> Section</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="session"> Session</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="adm_no"> Admission no.</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="studen_signature"> Student Signature</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="employe_signature"> Employe Signature</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="medium"> Medium(Hindi, English)</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="bus"> Bus no.</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="blood_group"> Blood Group</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="roll_no"> Roll no</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" value="email_id"> E mail</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" value="designation"> Designation</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" value="husband_name"> Husband Name</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" value="emp_id"> Emp ID</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" value="emp_name"> Employee Name</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" value="blank_1"> Blank 1</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" value="blank_2"> Blank 2</label><br>
                        <label style="font-size: 18px;"><input style="width: 23px; height: 20px; vertical-align: middle; margin-right: 8px;" type="checkbox" name="fields[]" checked value="created_at"> Created At</label><br>
                    </div>

                     @endif
                    <div class="form-group">
                     
                        <label>@lang('Role')</label>
                       <select name="role_id" class="form-control" required>
                            <option value="" disabled selected>@lang('Select One')</option>
                        
                            @if ($adminId == 1)
                                {{-- Admin: Show Super Admin + all roles --}}
                                <option value="0">@lang('Super Admin')</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            @else
                                {{-- Non-admin: Show only assigned role --}}
                              
                               @foreach ($roles as $role)
                                    @if($role->id != 1)
                                    <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>

                    </div>

                    <div class="form-group">
                        <label>@lang('Password')</label>
                        <div class="input-group">
                            <input class="form-control" name="password" type="text" required>
                            <button class="input-group-text generatePassword" type="button">@lang('Generate')</button>
                        </div>
                    </div>
                </div>
                {{-- @permit('admin.school.save') --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                </div>
                {{-- @endpermit --}}
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
<x-search-form placeholder="Username" />
@if(auth()->guard('admin')->id() == 1)
<a href="{{ route('admin.school.excel') }}" class="btn btn-sm btn-outline--success">
    <i class="las la-file-excel"></i>@lang('Excel Export')
</a>
@endif
@permit('admin.school.add')
<!-- Modal Trigger Button -->
<button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New School')">
    <i class="las la-plus"></i>@lang('Add New')
</button>
@endpermit
@endpush

@push('script-lib')
<script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>
@endpush

@push('script')
<script>
    (function($) {
        "use strict";

        $('#schoolTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            scrollX: true,
            autoWidth: false,
            ajax: "{{ route('admin.school.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'username', name: 'username'},
                {data: 'school_name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'partner', name: 'partner'},
                {data: 'mobile', name: 'mobile'},
                {data: 'addresh', name: 'addresh'},
                {data: 'code', name: 'code'},
                {data: 'fields_allowed', name: 'fields_allowed', orderable: false, searchable: false},
                {data: 'role_name', name: 'role_name', orderable: false, searchable: false},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('.generatePassword').on('click', function() {
            $(this).siblings('[name=password]').val(generatePassword());
        });

        $(document).on('click', '.cuModalBtn', function() {
            let passwordField = $('#cuModal').find($('[name=password]'));
            let label = passwordField.parents('.form-group').find('label')
            if ($(this).data('resource')) {
                passwordField.removeAttr('required');
                label.removeClass('required')
            } else {
                passwordField.attr('required', 'required');
                label.addClass('required')
            }
        });

        function generatePassword(length = 12) {
            let charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+<>?/";
            let password = '';

            for (var i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(Math.floor(Math.random() * n));
            }

            return password
        }
    })(jQuery);

</script>
@endpush
