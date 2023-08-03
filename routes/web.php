<?php

use App\Http\Controllers\FormController;
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

Route::redirect('/', '/all_invoices');
Route::get('/all_invoices', [FormController::class, 'allInvoices']);
Route::match(['get', 'post'], '/form', [FormController::class, 'showForm']);
Route::post('/send-email', [FormController::class, 'sendEmail']);
Route::get('/invoice-pdf/{invoice}', [FormController::class, 'createPdf']);
// Route::match(['get', 'post'], '/testForm', [FormController::class, 'testForm']);