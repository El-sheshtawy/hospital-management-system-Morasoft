<?php

use App\Http\Controllers\Doctor\Dashboard\DiagnosticsController;
use App\Http\Controllers\Doctor\Dashboard\laboratoryController;
use App\Http\Controllers\Doctor\Dashboard\PatientDetailsController;
use App\Http\Controllers\Doctor\Dashboard\RayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RayEmployee\RayEmployeeController;
use App\Http\Controllers\User\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Authorization\PermissionController;
use App\Http\Controllers\Admin\Authorization\RoleController;
use App\Http\Controllers\Admin\Dashboard\AdminRaysEmployeeController;
use App\Http\Controllers\Admin\Dashboard\SectionController;
use App\Http\Controllers\Ambulances\AmbulancesController;
use App\Http\Controllers\Doctor\Dashboard\DoctorController;
use App\Http\Controllers\Finance\PaymentAccountController;
use App\Http\Controllers\Finance\ReceiptAccountController;
use App\Http\Controllers\Insurances\InsurancesController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Services\SingleServiceController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register All web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function () {

    require __DIR__.'/auth.php';


    // General
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => ['auth', 'permission:edit-rays|update-rays-employee-rays']], function () {
        Route::get('/completed-rays', [RayEmployeeController::class, 'showFinishedRays'])->name('rays.completed');
        Route::get('/pending-rays', [RayEmployeeController::class, 'showPendingRays'])->name('rays.pending');
        Route::get('/rays/{ray}/attachments', [RayEmployeeController::class, 'showAttachments'])
            ->name('rays.attachments.index');
    });


    Route::group(['middleware' => ['auth', 'role:admin|doctor|rays_employee']], function () {

        Route::get('/main-dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::name('admin.')->prefix('invoices')->group(function () {
            Route::view('/single-invoice', 'dashboard.invoices.single-invoice.index')
                ->name('single-invoice.index');
            Route::view('single-invoice/print', 'dashboard.invoices.single-invoice.print')
                ->name('single-invoice.print');

            Route::view('/group-invoices', 'dashboard.invoices.group-invoices.index')
                ->name('group-invoices.index');
            Route::view('group-invoice/print', 'dashboard.invoices.group-invoices.print')
                ->name('group-invoice.print');
        });

    });


    // Admins
    Route::name('admin.')->prefix('admin')->group(function () {

        Route::group(['middleware' => ['auth', 'role:super_admin|admin']], function () {

            Route::resource('/roles', RoleController::class )->except('show');
            Route::resource('/permissions', PermissionController::class );
            Route::get('give-permission-for/create', [PermissionController::class, 'createPermissionForUsers']);
            Route::post('give-permission-for/store', [PermissionController::class, 'storePermissionForUsers'])
                ->name('permission-for-users.store');


            Route::resource('/sections', SectionController::class)->except(['edit', 'show']);
            Route::get('/section/{id}/doctors',[SectionController::class, 'showDoctors'])
                ->name('section.doctors.show');

            Route::resource('/doctors', DoctorController::class)->except('show');
            Route::patch('/doctor/password/update',[DoctorController::class, 'updatePassword'])
                ->name('doctor.password.update');
            Route::patch('/doctor/status/update',[DoctorController::class, 'updateStatus'])
                ->name('doctor.status.update');

            Route::prefix('services')->group(function () {
                Route::resource('/single-service', SingleServiceController::class);

                Route::view('/group-services', 'livewire.group-services.index')
                    ->name('group-services.index');
            });

            Route::resource('/insurances', InsurancesController::class)->except('show');

            Route::resource('/ambulances', AmbulancesController::class)->except('show');
            Route::get('/driver/{id}', [AmbulancesController::class, 'showDriver'])->name('driver.show');

            Route::resource('/patients', PatientController::class);

//            Route::prefix('invoices')->group(function () {
//                Route::view('/single-invoice', 'dashboard.invoices.single-invoice.index')
//                    ->name('single-invoice.index');
//                Route::view('single-invoice/print', 'dashboard.invoices.single-invoice.print')
//                    ->name('single-invoice.print');
//
//                Route::view('/group-invoices', 'dashboard.invoices.group-invoices.index')
//                    ->name('group-invoices.index');
//                Route::view('group-invoice/print', 'dashboard.invoices.group-invoices.print')
//                    ->name('group-invoice.print');
//            });

            Route::resource('receipts', ReceiptAccountController::class)->except('show');
            Route::get('receipt/{id}/print', [ReceiptAccountController::class, 'print'])
                ->name('receipts.print');

            Route::resource('payments', PaymentAccountController::class)->except('show');
            Route::get('payment/{id}/print', [PaymentAccountController::class, 'print'])
                ->name('payments.print');

            Route::resource('rays-employees', AdminRaysEmployeeController::class)
                ->except('show', 'create', 'edit');
        });
    });

    // Doctors
        Route::group([
            'middleware' => ['auth', 'role:admin|doctor'],
            'as' => 'doctor.',
            'prefix' => 'doctor',
        ], function () {

        Route::prefix('invoices')->name('invoices.')->group(function () {
            Route::get('/all', [DoctorController::class, 'showAllInvoices'])->name('index');

            Route::get('/completed', [DoctorController::class, 'showCompletedInvoices'])
                ->name('completed.index');

            Route::get('/revisions', [DoctorController::class, 'showRevisionsInvoices'])
                ->name('revisions.index');
        });


        Route::resource('/diagnostics', DiagnosticsController::class )->except('show');

        Route::resource('/rays',RayController::class)
            ->except('index', 'create', 'edit', 'show');

        Route::resource('/laboratories', laboratoryController::class)
            ->except('index', 'create', 'edit', 'show');

        Route::get('/patient/{invoice}/show-details', [PatientDetailsController::class, 'show'])
            ->name('patient-details.show');

        Route::get('/show-patient-history/{patient}', [DiagnosticsController::class, 'showHistory'])
            ->name('patient.history');

        Route::get('/{doctor}/roles-and-permissions', [DoctorController::class, 'rolesAndPermissionsInfo'])
            ->name('roles-and-permissions');

        });



    //Rays Employee
    Route::name('rays-employee.')->prefix('rays-employee')->middleware('auth')->group(function () {
        Route::group(['middleware' => ['permission:edit-rays|update-rays-employee-rays']], function () {
            Route::resource('/rays', RayEmployeeController::class)->only(['show', 'update']);
        });
    });
 });




