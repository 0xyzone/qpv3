<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function print(Order $order)
    {
        // Retrieve the order details
        $orderDetails = $order;
        // $company = Company::latest()->first();

        // You can customize the view name and pass data to it
        $pdf = app()->make(PDF::class)->loadView('invoices.invoice', ['order' => $orderDetails]);

        // You can return the PDF as a downloadable file
        // return $pdf->download('invoice_' . $order->id . '.pdf');
        
        // Or you can return the PDF as a viewable document in the browser
        return $pdf->stream('invoice_' . $order->id . '.pdf');
    }
}
