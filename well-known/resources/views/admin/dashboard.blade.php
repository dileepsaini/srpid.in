@extends('admin.layouts.app')

@section('panel')
    <div class="row gy-4">
        
        {{-- <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_supplier'] }}" title="Total Suppliers" style="6" link="{{ route('admin.supplier.index') }}"
                icon="las la-user-friends" bg="purple" outline=false />
        </div> --}}
        
    </div>

      <div class="row mt-2 gy-4">
        <div class="col-xxl-6">
            <div class="card box-shadow3 h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="card-title">@lang('Orders')</h5>
                        </div>
                      
                    </div>
                    <div class="widget-card-wrapper">
                        <div class="widget-card bg--success">
                            @permit('admin.school.index')
                            <a class="widget-card-link" href="{{ route('admin.school.index') }}"></a>
                            @endpermit
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                   <img src="{{ asset('assets/icon/Add-School.jpg') }}" alt="{{ asset('assets/icon/Add-School.jpg') }}">

                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $widget['school_count'] }}</h6>
                                    <p class="widget-card-title">@lang('Total School')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--warning">
                            @permit('admin.student.index')
                            <a class="widget-card-link" href="{{ route('admin.student.index') }}"></a>
                            @endpermit
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                      <img src="{{ asset('assets/icon/Add-Students.jpg') }}" alt="{{ asset('assets/icon/Add-Students.jpg') }}">
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $widget['student_count'] }}</h6>
                                    <p class="widget-card-title">@lang('Total Student')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                           @permit('admin.school.index')
                        <div class="widget-card bg--warning">
                         
                            <a class="widget-card-link" href="{{ route('admin.school.index') }}"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                      <img src="{{ asset('assets/icon/List-School.webp') }}" alt="{{ asset('assets/icon/List-School.webp') }}">
                                </div>
                                <div class="widget-card-content">
                                    <p class="widget-card-title">@lang('School List')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                            @endpermit

                      


                    </div>
                </div>
            </div>
        </div>
        {{--      
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h5 class="card-title">@lang('Orders Report Chart')</h5>
                        <div class="border p-1 cursor-pointer rounded" id="saleSaleReturnDatePicker">
                            <i class="la la-calendar"></i>&nbsp;
                            <span></span> <i class="la la-caret-down"></i>
                        </div>
                    </div>

                    <div id="sSrChartArea"></div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="row mb-none-30 mt-30">
      
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
@endpush

@push('style-lib')
    <link type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}" rel="stylesheet">
@endpush

@push('script')
  
@endpush
@push('style')
    <style>
        .apexcharts-menu {
            min-width: 120px !important;
        }
   
  

  .nav-icon svg {
    width: 32px;
    height: 32px;
  }
  .bottom-nav {
    background-color: #fff;
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    border-top: 1px solid #ddd;
  }
  .bottom-nav button {
    background: none;
    border: none;
    font-size: 0.75rem;
    color: #444;
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
    gap: 0.25rem;
  }
  .bottom-nav button span {
    line-height: 1;
  }
  .bottom-nav button:focus {
    outline: 2px solid #2E90FF;
  }
</style>
@endpush
