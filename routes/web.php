<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invoices/{order}', [InvoiceController::class, 'print'])->name('invoice.print');
