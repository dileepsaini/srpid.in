<div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
        <h6 class="page-title mb-0">{{ __($pageTitle) }}</h6>
        <a href="https://wa.me/91{{ \App\Models\Admin::find(1)->mobile ?? '' }}?text=Hello%20sir%20I'm%20from%20{{ urlencode(auth()->guard('admin')->user()->name) }}" target="_blank" class="text-success" style="font-size: 24px; line-height: 1;" title="Contact Admin">
            <i class="lab la-whatsapp"></i>
        </a>
    </div>
    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
        @if(request()->route()->getName() != 'admin.dashboard')
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline--dark">
            <i class="las la-arrow-left"></i>@lang('Back')
        </a>
        @endif
        @stack('breadcrumb-plugins')
    </div>
</div>
