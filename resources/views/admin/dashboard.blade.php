@extends('admin.layouts.app')

@section('panel')
<div class="app-dashboard">
    <div class="app-header">
        <div class="app-header-left">
            <img src="{{ asset('assets/images/logo_icon/logo.png') }}" alt="logo">
        </div>
        <div class="app-header-right">
            <img src="{{ getImage(getFilePath('adminProfile').'/'. auth()->guard('admin')->user()->image,getFileSize('adminProfile')) }}" alt="profile">
            <span>Partner</span>
        </div>
    </div>

    <div class="app-grid">
        @permit('admin.school.index')
        <a href="{{ route('admin.school.index') }}" class="app-card">
            <img src="{{ asset('assets/icon/List-School.webp') }}" alt="School List">
            <span>School List</span>
        </a>
        @endpermit

        @permit('admin.student.import')
        <a href="javascript:void(0)" class="app-card">
            <img src="{{ asset('assets/icon/Add-Students.jpg') }}" alt="Import Students">
            <span>Import Students</span>
        </a>
        @endpermit

        @permit('admin.student.store')
        <a href="{{ route('admin.student.create') }}" class="app-card">
            <img src="{{ asset('assets/icon/Add-Students.jpg') }}" alt="Add Student">
            <span>Add Student</span>
        </a>
        @endpermit

        @permit('admin.student.index')
        <a href="{{ route('admin.student.index') }}" class="app-card">
            <img src="{{ asset('assets/icon/Add-Students.jpg') }}" alt="List Students">
            <span>List Students</span>
        </a>
        @endpermit

        <a href="https://wa.me/91{{ \App\Models\Admin::find(1)->mobile ?? '' }}?text=hello%20sir" target="_blank" class="app-card">
            <i class="lab la-whatsapp" style="color: #25D366;"></i>
            <span>{{ \App\Models\Admin::find(1)->mobile ?? 'Contact' }}</span>
        </a>
    </div>
</div>

<div class="app-bottom-nav">
    <a href="{{ route('admin.dashboard') }}" class="app-bottom-nav-item">
        <i class="las la-home" style="color: #ff8c00;"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('admin.dashboard') }}" class="app-bottom-nav-item">
        <i class="las la-desktop" style="color: #5c6bc0;"></i>
        <span style="color: #333; font-weight: 600;">Dashboard</span>
    </a>
    <a href="{{ route('admin.profile') }}" class="app-bottom-nav-item">
        <i class="las la-user" style="color: #42a5f5;"></i>
        <span>Profile</span>
    </a>
    <a href="{{ route('admin.logout') }}" class="app-bottom-nav-item">
        <i class="las la-power-off" style="color: #ff5722;"></i>
        <span>Log Out</span>
    </a>
</div>
@endsection

@push('style')
<style>
    /* Hide the default layout elements for this specific page */
    .sidebar { display: none !important; }
    .navbar-wrapper { display: none !important; }
    .body-wrapper { margin-left: 0 !important; }
    .breadcrumb-nav { display: none !important; }
    .d-flex.mb-30.flex-wrap.gap-3.justify-content-between.align-items-center { display: none !important; }
    
    .page-wrapper { 
        background: linear-gradient(135deg, #e01292, #3f51b5) !important; 
        min-height: 100vh; 
    }
    .bodywrapper__inner { 
        padding: 0 !important; 
        background: transparent !important; 
    }
    .container-fluid {
        padding: 0 !important;
    }

    .app-dashboard {
        padding: 15px 0 80px 0;
    }

    .app-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        color: white;
    }

    .app-header-left {
        background: white;
        border-radius: 20px;
        padding: 5px 20px;
        display: flex;
        align-items: center;
    }

    .app-header-left img {
        height: 35px;
    }

    .app-header-right {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        font-size: 18px;
    }

    .app-header-right img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .app-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        padding: 15px;
    }

    .app-card {
        background: white;
        border-radius: 12px;
        border: 2px solid #2874f0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px 10px;
        text-align: center;
        text-decoration: none;
        color: #555;
        min-height: 140px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .app-card:hover {
        transform: translateY(-3px);
    }

    .app-card img {
        height: 60px;
        margin-bottom: 15px;
        object-fit: contain;
    }

    .app-card i {
        font-size: 60px;
        margin-bottom: 15px;
    }

    .app-card span {
        font-size: 16px;
        font-weight: 500;
        color: #555;
    }

    .app-bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: white;
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 12px 0;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        box-shadow: 0 -5px 15px rgba(0,0,0,0.1);
        z-index: 1000;
    }

    .app-bottom-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: #555;
        font-size: 14px;
        font-weight: 500;
        gap: 5px;
    }

    .app-bottom-nav-item i {
        font-size: 28px;
    }

</style>
@endpush
