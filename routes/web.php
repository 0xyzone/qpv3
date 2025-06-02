<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\InvoiceController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/invoices/{order}', [InvoiceController::class, 'print'])->name('invoice.print');
// Menu route
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('contact-us', [HomeController::class, 'contact'])->name('contact');
Route::view('demo', 'demo')->name('demo');
