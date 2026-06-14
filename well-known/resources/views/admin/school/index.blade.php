@extends('admin.layouts.app')
@section('panel')
<style>
    table td {
    text-align: left !important;
    font-size: large;
}
 table th {
    text-align: left !important;
    font-size: large;
}

table.table--light.style--two tbody td {
    font-size: large !important;
        padding: 3px 10px !important;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive--md table-responsive">
                    <table class="table table--light style--two">
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

                           
                            @forelse($allStaff as $staff)
                            <tr>
                                <td>{{ $loop->index + $allStaff->firstItem() }}</td>
                                <td>{{ $staff->username }}</td>
                                <td>{{ __($staff->name) }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->partner }}</td>
                                <td>{{ $staff->mobile }}</td>
                                <td>{{ $staff->addresh }}</td>
                                <td>{{ $staff->code }}</td>
                                <td>{{ implode(', ', explode(',', $staff->fields)) }}</td>
                                <td>
                                    @if ($staff->role)
                                    {{ $staff->role->name }}
                                    @else
                                    @lang('Super Admin')
                                    @endif
                                </td>

                                <td>
                                    @php
                                    echo $staff->statusBadge;
                                    @endphp
                                </td>
                                <td>
                                    <div class="button--group">
                                        @permit('admin.school.edit')
                                            <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $staff }}" data-modal_title="@lang('Update School')">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>
                                        @endpermit
                                        @if ($staff->id > 1)
                                         
                                        @if ($staff->status)
                                        <button class="btn btn-sm confirmationBtn btn-outline--danger" data-action="{{ route('admin.school.status', $staff->id) }}" data-question="@lang('Are you sure to ban this staff?')" type="button">
                                            <i class="las la-user-alt-slash"></i>@lang('Ban')
                                        </button>
                                        @else
                                        <button class="btn btn-sm confirmationBtn btn-outline--success" data-action="{{ route('admin.school.status', $staff->id) }}" data-question="@lang('Are you sure to active this staff?')" type="button">
                                            <i class="las la-user-check"></i>@lang('Active')
                                        </button>
                                        @endif
                                        <a class="btn btn-sm btn-outline--dark" href="{{ route('admin.school.login', $staff->id) }}" target="_blank">
                                            <i class="las la-sign-in-alt"></i>@lang('Login')
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($allStaff->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($allStaff) }}
            </div>
            @endif
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
        $('.generatePassword').on('click', function() {
            $(this).siblings('[name=password]').val(generatePassword());
        });

        $('.cuModalBtn').on('click', function() {
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
