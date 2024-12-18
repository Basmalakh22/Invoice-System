<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\InvoiceReportController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('/invoices', InvoicesController::class);
Route::get('/section/{id}', [InvoicesController::class, 'getProducts']);
Route::patch('/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])
    ->name('Status_Update');
Route::get('/Invoice_paid', [InvoicesController::class, 'Invoice_paid'])
    ->name('invoices.Invoice_paid');
Route::get('/Invoice_unpaid', [InvoicesController::class, 'Invoice_unpaid'])
    ->name('invoices.Invoice_unpaid');
Route::get('Invoice_partial', [InvoicesController::class, 'Invoice_partial'])
    ->name('invoices.Invoice_partial');
Route::get('Print_invoice/{id}', [InvoicesController::class, 'Print_invoice'])
    ->name('invoices.Print_invoice');
Route::get('/export_invoices', [InvoicesController::class, 'export']);
Route::get('/MarkAsRead_all', [InvoicesController::class, 'MarkAsRead_all'])
    ->name('MarkAsRead_all ');

Route::resource('/sections', SectionsController::class);

Route::resource('/products', ProductController::class);

Route::resource('/attachment', InvoiceAttachmentController::class);

Route::resource('/InvoiceDetail', InvoiceDetailController::class);
Route::get('/View_file/{invoice_number}/{file_name}', [InvoiceDetailController::class, 'viewFile'])
    ->name('View_file');
Route::get('/download/{invoice_number}/{file_name}', [InvoiceDetailController::class, 'download'])
    ->name('download');

Route::resource('/InvoiceAchive', InvoiceAchiveController::class);

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/invoices_report', [InvoiceReportController::class, 'index'])
    ->name('invoices.report');
Route::post('/Search_invoices', [InvoiceReportController::class, 'Search_invoices'])
    ->name('invoices.search');

Route::get('/customers_report', [CustomerReportController::class, 'index'])
    ->name('customers.report');
Route::post('/Search_customers', [CustomerReportController::class, 'Search_customers'])
    ->name('customers.search');


require __DIR__ . '/auth.php';

Route::get('/{page}', [AdminController::class, 'index']);
