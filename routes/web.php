<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
//Route::resource('invoice',InvoiceController::class);
Route::post('invoice/get-product-by-id',[InvoiceController::class,'get_product']);
Route::post('invoice/get-row',[InvoiceController::class,'get_row'])->name('invoice.get_row');
Route::resource('invoice',InvoiceController::class);



