<?php

namespace App\Http\Controllers;

use App\OrderTypes;
use App\Models\Bill;
use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function print(Order $order, Request $request)
    {
        $type = $request->input('type', 'invoice');
        $bill = $request->has('bill') ? Bill::with('orders.orderItems.item')->find($request->bill) : null;
        // dd($bill);

        // Force thermal printer formatting
        $view = match ($type) {
            'kot' => 'invoices.kot',
            'bill' => 'invoices.bill',
            default => 'invoices.invoice'
        };

        $pdf = app()->make(PDF::class);
        $pdf->setPaper([0, 0, 226.77, 1000], 'portrait'); // 80mm width thermal paper

        $pdf->loadView($view, [
            'order' => $order,
            'bill' => $bill,
            'orders' => $bill ? $bill->orders : collect([$order])
        ]);

        return $pdf->stream($type . '_' . $order->id . '.pdf');
    }
}
