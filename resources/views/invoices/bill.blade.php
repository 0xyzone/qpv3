<!DOCTYPE html>
<html>
<head>
    <title>Bill - {{ $bill->table_number ?? 'Order '.$order->id }}</title>
    <style>
        @page { 
            size: 72mm 297mm;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            padding: 0;
            margin: 0 auto;
            table-layout: fixed;
        }
        th {
            text-align: left;
            padding-top: 8px;
        }
        tbody {
            font-size: 11px;
        }
        tbody td {
            padding: 2px 0;
        }
        .total {
            font-weight: bold;
            padding-top: 0.25rem;
        }
        .total-amount {
            font-weight: bold;
            text-align: right;
            padding-right: 10px;
        }
        .text-center {
            text-align: center;
        }
        h1 {
            margin: 0;
            padding: 2px 0;
        }
        h2 {
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h4 {
            margin: 0;
            padding: 0;
        }
        p {
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .orderNumber {
            text-align: center;
            margin-bottom: 2px;
            font-size: 1.25rem;
            color: #fff;
            background: #000;
        }
        .invoice-content {
            padding: 0 16px;
        }
        .restaurant-header {
            text-align: center;
            margin-bottom: 5px;
            border-bottom: 1px dashed #333;
            padding-bottom: 5px;
        }
        .restaurant-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 2px;
        }
        .restaurant-details {
            font-size: 10px;
            line-height: 1.2;
        }
        .bill-header {
            text-align: center;
            margin: 8px 0;
        }
        .bill-no {
            font-weight: bold;
            font-size: 13px;
            text-transform: uppercase;
        }
        .time-date {
            font-size: 10px;
            margin: 3px 0;
        }
        .order-header {
            font-weight: bold;
            margin-bottom: 3px;
            border-bottom: 1px dashed #333;
            padding-bottom: 2px;
        }
    </style>
</head>
<body>
    @php
        // Calculate totals if they're not provided
        $subtotal = $bill ? $bill->orders->sum(function($order) {
            return $order->orderItems->sum(function($item) {
                return $item->quantity * $item->item->price;
            });
        }) : $order->orderItems->sum(function($item) {
            return $item->quantity * $item->item->price;
        });
        
        $discountAmount = $bill ? $bill->discount_amount : ($order->discount_amount ?? 0);
        $deliveryCharge = $bill ? $bill->delivery_charge : ($order->delivery_charge ?? 0);
        $totalAmount = $subtotal - $discountAmount + $deliveryCharge;
    @endphp

    <div class="restaurant-header">
        <div class="restaurant-name">QuickPick • PickEat Up</div>
        <div class="restaurant-details">
            Dallu - 15, Kathmandu, Nepal<br>
            9861748449 | 9820150635 | 9767251739
        </div>
    </div>

    <div class="invoice">
        <div class="invoice-content">
            <div class="bill-header">
                <h1 class="orderNumber">BILL RECEIPT</h1>
                @if($bill)
                <div class="bill-no">Table: {{ $bill->table_number }}</div>
                @endif
                <p style="padding: 4px 0;">{{ now()->format('h:i A • jS M, Y') }}</p>
            </div>

            @foreach($orders as $order)
            <div class="order-header">
                Order #{{ $order->id }} ({{ $order->created_at->format('h:i A') }})
            </div>
            <table>
                <tbody>
                    @foreach ($order->orderItems as $item)
                    <tr>
                        <td style="width: 75%;">{{ $item->item->name }}</td>
                        <td class="text-center">{{ formatNumber($item->quantity) }}</td>
                        <td>{{ $item->item->price * $item->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endforeach

            <table>
                <tfoot>
                    <tr>
                        <td style="text-align:center;" colspan='3'>
                            <hr style="border: 2px dotted #000000; border-style: none none dotted; color: #fff; background-color: #fff;">
                        </td>
                    </tr>
                    <tr>
                        <td class="total">Sub Total</td>
                        <td class="total-amount" colspan="2">Rs. {{ formatNumber($subtotal) }}</td>
                    </tr>
                    @if($discountAmount > 0)
                    <tr>
                        <td class="total">Discount</td>
                        <td class="total-amount" colspan="2">Rs. {{ $discountAmount }}</td>
                    </tr>
                    @endif
                    @if($deliveryCharge > 0)
                    <tr>
                        <td class="total">Delivery Charge</td>
                        <td class="total-amount" colspan="2">Rs. {{ $deliveryCharge }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="total">Grand Total</td>
                        <td class="total-amount" colspan="2">Rs. {{ formatNumber($totalAmount) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;" colspan='3'>
                            <hr style="border: 2px dotted #000000; border-style: none none dotted; color: #fff; background-color: #fff;">
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="bill-footer">
                <p>Thank you for dining with us!</p>
                <p>Visit us again soon</p>
            </div>
        </div>
    </div>

    @php
    function formatNumber($number) {
        $formattedNumber = rtrim(rtrim(number_format($number, 2), '0'), '.');
        if (strpos($formattedNumber, '.5') !== false) {
            $formattedNumber = str_replace('.5', '½', $formattedNumber);
        }
        return $formattedNumber;
    }
    @endphp

    <script>
        window.onload = function() {
            adjustInvoiceHeight();
            window.print();
        };

        function adjustInvoiceHeight() {
            var invoice = document.querySelector('.invoice');
            var content = document.querySelector('.invoice-content');
            var availableHeight = window.innerHeight - (parseInt(window.getComputedStyle(invoice).paddingTop) * 2);
            content.style.maxHeight = availableHeight + 'px';
        }
    </script>
</body>
</html>