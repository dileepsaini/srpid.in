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
