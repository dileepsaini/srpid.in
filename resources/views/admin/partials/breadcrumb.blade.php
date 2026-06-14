<div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
    <h6 class="page-title">{{ __($pageTitle) }}</h6>
    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
        @if(request()->route()->getName() != 'admin.dashboard')
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline--dark">
            <i class="las la-arrow-left"></i>@lang('Back')
        </a>
        @endif
        @stack('breadcrumb-plugins')
    </div>
</div>
