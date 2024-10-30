<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionsController;
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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/invoices', InvoicesController::class);
Route::get('/section/{id}', [InvoicesController::class,'getProducts']);

Route::resource('/sections', SectionsController::class);

Route::resource('/products', ProductController::class);

Route::resource('/a', InvoiceAttachmentController::class);

require __DIR__.'/auth.php';

Route::get('/{page}', [AdminController::class,'index']);


