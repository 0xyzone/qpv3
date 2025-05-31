<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/invoices/{order}', [InvoiceController::class, 'print'])->name('invoice.print');
// Menu route
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::view('demo', 'demo')->name('demo');
