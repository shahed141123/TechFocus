<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HR\HRController;
use App\Http\Controllers\HR\TaskController;
use App\Http\Controllers\Rfq\RfqController;
use App\Http\Controllers\Rfq\DealController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\RowController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\HR\HolidayController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Content\BlogController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\BankingController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\HR\ProjectKpiController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\HrPolicyController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BioMetricController;
use App\Http\Controllers\Admin\BrandPageController;
use App\Http\Controllers\Admin\NewsTrendController;
use App\Http\Controllers\Admin\VatAndTaxController;
use App\Http\Controllers\HR\EmployeeTaskController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DynamicCssController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductSasController;
use App\Http\Controllers\Admin\WebSettingController;
use App\Http\Controllers\Site\DynamicSiteController;
use App\Http\Controllers\Admin\IndustryPageController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Admin\SolutionCardController;
use App\Http\Controllers\HR\EmployeeProjectController;
use App\Http\Controllers\Content\ClientStoryController;
use App\Http\Controllers\Content\TechContentController;
use App\Http\Controllers\HR\LeaveApplicationController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\TermsAndPolicyController;
use App\Http\Controllers\Admin\UserPermissionController;
use App\Http\Controllers\Admin\DynamicCategoryController;
use App\Http\Controllers\Admin\SolutionDetailsController;
use App\Http\Controllers\Sales\SalesTeamTargetController;
use App\Http\Controllers\Sales\SalesYearTargetController;
use App\Http\Controllers\Admin\CountryStateCityController;
use App\Http\Controllers\Admin\EmployeeCategoryController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\EmployeeDepartmentController;
use App\Http\Controllers\Accounts\AccountsDocumentController;
use App\Http\Controllers\Admin\PolicyAcknowledgmentController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('administrator')->name('admin.')->group(static function () {

    // Guest routes
    Route::middleware('guest:admin')->group(static function () {
        // Auth routes
        Route::get('login', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'store']);
        // Forgot password
        Route::get('forgot-password', [\App\Http\Controllers\Admin\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [\App\Http\Controllers\Admin\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
        // Reset password
        Route::get('reset-password/{token}', [\App\Http\Controllers\Admin\Auth\NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [\App\Http\Controllers\Admin\Auth\NewPasswordController::class, 'store'])->name('password.update');
    });

    // Verify email routes
    Route::middleware(['auth:admin'])->group(static function () {
        Route::get('verify-email', [\App\Http\Controllers\Admin\Auth\EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', [\App\Http\Controllers\Admin\Auth\VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
        Route::post('email/verification-notification', [\App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    });

    // Authenticated routes
    Route::middleware(['auth:admin', 'verified'])->group(static function () {
        // Confirm password routes
        Route::get('confirm-password', [\App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('confirm-password', [\App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'store']);
        // Logout route
        Route::post('logout', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
        // General routes
        Route::get('/dashboard', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');
        // Route::get('profile', [\App\Http\Controllers\Admin\HomeController::class, 'profile'])->name('profile');

        Route::get('web-setting', [WebSettingController::class, 'index'])->name('web.setting');
        Route::put('seo-setting', [WebSettingController::class, 'seo'])->name('seo.setting');
        Route::put('smtp-setting', [WebSettingController::class, 'smtp'])->name('smtp.setting');
        Route::put('site/setting', [WebSettingController::class, 'site'])->name('site.setting');

        // Leave
        Route::get('leave-application/history', [LeaveApplicationController::class, 'history'])->name('leave-application.history');
        Route::get('leave-application/dashboard', [LeaveApplicationController::class, 'dashboard'])->name('leave-application.dashboard');

        //Attribute
        Route::controller(AttributeController::class)->group(function () {
            Route::get('/attribute', 'index')->name('attribute.index');
            Route::post('/attribute/store', 'store')->name('attribute.store');
            Route::put('/attribute/{id}/update', 'update')->name('attribute.update');
            Route::delete('/attribute/{id}/destroy', 'destroy')->name('attribute.destroy');
        });
        Route::controller(AttributeValueController::class)->group(function () {
            Route::post('/attribute-value/store', 'store')->name('attribute-value.store');
            Route::post('/attribute-value/update', 'update')->name('attribute-value.update');
            // Route::put('/attribute-value/{id}/update', 'update')->name('attribute-value.updfate');
            Route::delete('/attribute-value/{id}/destroy', 'destroy')->name('attribute-value.destroy');
        });
        // Dynamic CSS
        Route::controller(DynamicCssController::class)->group(function () {
            Route::get('/dynamic-css', 'index')->name('css.index');
            Route::put('/dynamic-css/{id}/update', 'update')->name('css.update');
        });
        //Product
        Route::controller(ProductController::class)->group(function () {
            Route::get('/completed-products', 'index')->name('product.index');
            Route::get('/sourced-products', 'sourcedProducts')->name('sourced.products');
            Route::get('/saved-products', 'savedProducts')->name('saved.products');
            Route::get('/product/create', 'create')->name('product.create');
            Route::post('/product/create', 'store')->name('product.store');
            Route::get('/product/{id}/edit', 'edit')->name('product.edit');
            Route::put('/product/{id}/update', 'update')->name('product.update');
            Route::delete('/product/{id}/destroy', 'destroy')->name('product.destroy');
        });
        // HR
        Route::prefix('hr')->controller(HRController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('hr.dashboard');
        });

        // RFQ
        Route::controller(RfqController::class)->group(function () {
            Route::get('/rfq/list', 'index')->name('rfq.index');
        });
        Route::controller(DealController::class)->group(function () {
            Route::get('/deals/list', 'index')->name('deal.index');
        });

        // Monthly tasks
        Route::get('/employee/monthly-tasks/{employeeId}', [EmployeeTaskController::class, 'employeeTasks'])->name('monthly.tasks');


        Route::resources(
            [
                // 'product'          => ProductController::class,
                'product-sas'      => ProductSasController::class,
                'brand-page'       => BrandPageController::class,
                'solution-details' => SolutionDetailsController::class,
                'industry-page'    => IndustryPageController::class,
                'industry'         => IndustryController::class,
                'row'              => RowController::class,
                'homepage'         => HomePageController::class, 
                'aboutpage'        => AboutPageController::class, 
                'solution-card'    => SolutionCardController::class,
                'employee'         => EmployeeController::class,
                'employee-project' => EmployeeProjectController::class,
                'project-kpi'      => ProjectKpiController::class,
                'catalog'          => CatalogController::class,
                'banner'           => BannerController::class,
                'employee-task'    => EmployeeTaskController::class,
                'task'             => TaskController::class,
                'dynamic-site'     => DynamicSiteController::class,
            ]
        );
        Route::resources(
            [
                'profile'               => ProfileController::class,
                'vat-tax'               => VatAndTaxController::class,
                'employee-category'     => EmployeeCategoryController::class,
                'employee-department'   => EmployeeDepartmentController::class,
                'category'              => CategoryController::class,
                'brand'                 => BrandController::class,
                'product-attribute'     => ProductAttributeController::class,
                'product-color'         => ProductColorController::class,
                'company'               => CompanyController::class,
                'address'               => AddressController::class,
                'leave-application'     => LeaveApplicationController::class,
                'dynamic-category'      => DynamicCategoryController::class,
                'event'                 => EventController::class,
                'faq'                   => FaqController::class,
                'sales-year-target'     => SalesYearTargetController::class,
                'sales-team-target'     => SalesTeamTargetController::class,
                'news-trend'            => NewsTrendController::class,
                'hr-policy'             => HrPolicyController::class,
                'policy-acknowledgment' => PolicyAcknowledgmentController::class,
                'terms-and-policy'      => TermsAndPolicyController::class,
                'banking'               => BankingController::class,
                'holiday'               => HolidayController::class,
                'attendance'            => AttendanceController::class, //not my work
                'accounts-document'     => AccountsDocumentController::class,
                'currency'              => CurrencyController::class,
            ],
            ['except' => ['create', 'show', 'edit'],]
        );
        Route::resources(
            [
                'blog'         => BlogController::class,
                'story'        => ClientStoryController::class,
                'tech-content' => TechContentController::class,

            ],
            ['except' => ['store', 'update', 'show'],]
        );
        // Content







        Route::resource('contact', ContactController::class)->except(['create', 'show', 'edit'])
            ->middleware(['throttle:10,1', 'checkBan'], 'only', ['store']);

        Route::get('country-state-city', [CountryStateCityController::class, 'index'])->name('country.state.city.index');

        Route::put('country/{id}/update', [CountryStateCityController::class, 'updateCountry'])->name('country.update');
        Route::delete('country/{id}/destroy', [CountryStateCityController::class, 'destroyCountry'])->name('country.destroy');

        Route::put('state/{id}/update', [CountryStateCityController::class, 'updateState'])->name('state.update');
        Route::delete('state/{id}/destroy', [CountryStateCityController::class, 'destroyState'])->name('state.destroy');

        Route::put('city/{id}/update', [CountryStateCityController::class, 'updateCity'])->name('city.update');
        Route::delete('city/{id}/destroy', [CountryStateCityController::class, 'destroyCity'])->name('city.destroy');

        Route::resource('company', CompanyController::class)->except(['show']); // dd uncommitted changes
        Route::resource('news-trend', NewsTrendController::class)->except(['show']); // dd uncommitted changes

        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);


        // Route to display the role permission management page
        // Assuming you have a method in your controller to show the page
        Route::get('/role/{role}/permission', [RolePermissionController::class, 'show'])
            ->name('role-permission.show');

        // Route to assign a permission to a role
        Route::post('/role/{role}/permission/assign', [RolePermissionController::class, 'assignPermission'])
            ->name('role-permission.assign');

        // Route to remove a permission from a role
        Route::delete('/role/{role}/permission/{permission}', [RolePermissionController::class, 'removePermission'])
            ->name('role-permission.remove');

        // Route to display form for assigning permission to a user
        Route::get('/user/{user}/permission/create', [UserPermissionController::class, 'create'])
            ->name('user-permission.create');

        // Route to store the assigned permission for a user
        Route::post('/user/{user}/permission', [UserPermissionController::class, 'store'])
            ->name('user-permission.store');

        // Route to display form for removing permission from a user
        Route::get('/user/{user}/permission/edit', [UserPermissionController::class, 'edit'])
            ->name('user-permission.edit');

        // Route to remove a specific permission from a user
        Route::delete('/user/{user}/permission/{permission}', [UserPermissionController::class, 'destroy'])
            ->name('user-permission.destroy');


        // Display a listing of the admins with their roles
        Route::get('/user-roles', [UserRoleController::class, 'index'])
            ->name('user-roles.index');

        // Show the form for assigning a role to an admin
        Route::get('/user-roles/{user}/edit', [UserRoleController::class, 'edit'])
            ->name('user-roles.edit');

        // Update the specified admin's roles
        Route::put('/user-roles/{user}', [UserRoleController::class, 'update'])
            ->name('user-roles.update');

        // Remove the specified role from the admin
        Route::delete('/user-roles/{user}/role/{role}', [UserRoleController::class, 'destroy'])
            ->name('user-roles.destroy');
    });

    // Route::get('/subscribers', [NewsletterController::class, 'index'])->name('newsletter.index');
    // Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

    // Route::get('/verify/{token}', [NewsletterController::class, 'verify'])->name('newsletter.verify');

    Route::get('/verified', function () {
        return view('newsletter.verified');
    })->name('newsletter.verified');

    Route::get('/verify-failed', function () {
        return view('newsletter.verify-failed');
    })->name('newsletter.verify-failed');

    // Route::post('/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');


    // Route::resource('example', ExampleController::class)->except(['create', 'show', 'edit']); //example

    Route::get('/machine-devicesetip-index', [BioMetricController::class, 'index'])->name('attendance.dashboard');
    // Route::get('/attendance-data/single/{id}', [BioMetricController::class, 'attendanceDataSingle'])->name('attendance.single');
    Route::post('/device-setip', [BioMetricController::class, 'device_setip'])->name('machine.devicesetip');
    // Route::get('/device-information', [BioMetricController::class, 'device_information'])->name('machine.deviceinformation');
    // Route::get('/device-user-data', [BioMetricController::class, 'device_user_data'])->name('machine.deviceuserdata');
    // Route::get('/device-attendance-data', [BioMetricController::class, 'device_attendance_data'])->name('machine.deviceattendancedata');
    // Route::get('/device-adduser', [BioMetricController::class, 'device_adduser'])->name('machine.deviceadduser');
    // Route::post('/device-setuser', [BioMetricController::class, 'device_setuser'])->name('machine.devicesetuser');
    // Route::get('/device-removeuser-single/{id}', [BioMetricController::class, 'device_removeuser_single'])->name('machine.deviceremoveusersingle');
    // Route::get('/device-viewuser-single/[id]', [BioMetricController::class, 'device_viewuser_single'])->name('machine.deviceviewusersingle');
    // Route::get('/device-data/clear-attendance', [BioMetricController::class, 'device_data_clear_attendance'])->name('machine.devicedata.clear.attendance');
    // Route::get('/device-restart', [BioMetricController::class, 'device_restart'])->name('machine.devicerestart');
    // Route::get('/device-shutdown', [BioMetricController::class, 'device_shutdown'])->name('machine.deviceshutdown');
});
