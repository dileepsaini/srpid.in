<?php

use Illuminate\Support\Facades\Route;


Route::namespace('Auth')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::controller('LoginController')->group(function () {
            Route::get('/', 'showLoginForm')->name('login');
            Route::post('/', 'login')->name('login');
            Route::get('logout', 'logout')->middleware('admin')->withoutMiddleware('admin.guest')->name('logout');
        });

        // Admin Password Reset
        Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
            Route::get('reset', 'showLinkRequestForm')->name('reset');
            Route::post('reset', 'sendResetCodeEmail');
            Route::get('code-verify', 'codeVerify')->name('code.verify');
            Route::post('verify-code', 'verifyCode')->name('verify.code');
        });

        Route::controller('ResetPasswordController')->group(function () {
            Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
            Route::post('password/reset/change', 'reset')->name('password.change');
        });
    });
});

Route::middleware(['admin', 'admin.permission'])->group(function () {
    Route::controller('AdminController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');
        Route::get('banned', 'banned')->name('banned');

        // //Notification
        // Route::get('notifications', 'notifications')->name('notifications');
        // Route::get('notification/read/{id}', 'notificationRead')->name('notification.read');
        // Route::get('notifications/read-all', 'readAllNotification')->name('notifications.read.all');
        // Route::post('notifications/delete-all', 'deleteAllNotification')->name('notifications.delete.all');
        // Route::post('notifications/delete-single/{id}', 'deleteSingleNotification')->name('notifications.delete.single');

        //Report Bugs
        Route::get('request-report', 'requestReport')->name('request.report');
        Route::post('request-report', 'reportSubmit')->name('request.report.store');

        Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
    });

    Route::controller('StaffController')->prefix('school')->name('school.')->group(function () {
        Route::get('all', 'index')->name('index');
        Route::post('save/{id?}', 'save')->name('save');
        Route::post('switch-status/{id}', 'status')->name('status');
        Route::get('login/{id}', 'login')->name('login');
        Route::get('add', 'add')->name('add');
        Route::get('edit', 'edit')->name('edit');
    });

    Route::controller('RolesController')->prefix('roles')->name('roles.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('save/{id?}', 'save')->name('save');
    });

    // permission
    Route::controller('PermissionController')->prefix('permissions')->name('permissions.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('update-permissions', 'updatePermissions')->name('update');
    });

  

    // employe
    Route::controller('EmployeController')->name('student.')->prefix('student')->group(function () {
        Route::get('all', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
        Route::get('csv', 'studentCSV')->name('csv');
        Route::post('import', 'import')->name('import');
        Route::get('import/all', 'importAll')->name('importAll');
        Route::post('/students/bulk-delete', 'bulkDelete')->name('bulkDelete');

        Route::get('get_data', 'getSchool')->name('getSchool');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('delete/{id}', 'delete')->name('delete');
        Route::get('add/{school_id?}', 'create')->name('create');
        Route::get('download-student-photos', 'downloadPhotos')->name('download');
        Route::post('ImgUpdate', 'ImgUpdate')->name('ImgUpdate');

        Route::get('upload', 'upload')->name('upload');
    });

    


   

   






    // Plugin
    Route::controller('ExtensionController')->prefix('extensions')->name('extensions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('status/{id}', 'status')->name('status');
    });



    Route::controller('GeneralSettingController')->group(function () {

        Route::get('system-setting', 'systemSetting')->name('setting.system');

        // General Setting
        Route::get('general-setting', 'general')->name('setting.general');
        Route::post('general-setting', 'generalUpdate')->name('setting.general.update');

        //configuration
        Route::get('setting/system-configuration', 'systemConfiguration')->name('setting.system.configuration');
        Route::post('setting/system-configuration', 'systemConfigurationSubmit')->name('setting.system.configuration.update');

        // Logo-Icon
        Route::get('setting/logo-icon', 'logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'logoIconUpdate')->name('setting.logo.icon');

    });



    //Notification Setting
    // Route::name('setting.notification.')->controller('NotificationController')->prefix('notification')->group(function () {
    //     //Template Setting
    //     Route::get('global/email', 'globalEmail')->name('global.email');
    //     Route::post('global/email/update', 'globalEmailUpdate')->name('global.email.update');

    //     Route::get('global/sms', 'globalSms')->name('global.sms');
    //     Route::post('global/sms/update', 'globalSmsUpdate')->name('global.sms.update');

    //     Route::get('templates', 'templates')->name('templates');
    //     Route::get('template/edit/{type}/{id}', 'templateEdit')->name('template.edit');
    //     Route::post('template/update/{type}/{id}', 'templateUpdate')->name('template.update');

    //     //Email Setting
    //     Route::get('email/setting', 'emailSetting')->name('email');
    //     Route::post('email/setting', 'emailSettingUpdate')->name('email.update');
    //     Route::post('email/test', 'emailTest')->name('email.test');

    //     //SMS Setting
    //     Route::get('sms/setting', 'smsSetting')->name('sms');
    //     Route::post('sms/setting', 'smsSettingUpdate')->name('sms.update');
    //     Route::post('sms/test', 'smsTest')->name('sms.test');
    // });


    //System Information
    Route::controller('SystemController')->name('system.')->prefix('system')->group(function () {
        Route::get('info', 'systemInfo')->name('info');
        Route::get('server-info', 'systemServerInfo')->name('server.info');
        Route::get('optimize', 'optimize')->name('optimize');
        Route::get('optimize-clear', 'optimizeClear')->name('optimize.clear');
        Route::get('system-update', 'systemUpdate')->name('update');
        Route::post('system-update', 'systemUpdateProcess')->name('update.process');
        Route::get('system-update/log', 'systemUpdateLog')->name('update.log');
    });
});
