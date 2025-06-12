<!DOCTYPE html>
<html>
<head>
    <title>KOT - {{ $order->id }}</title>
    <style>
        @page {
            size: 72mm 297mm;
            margin: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 5px;
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
            padding: 8px 0;
            border-bottom: 1px dashed #333;
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

        .kot-header {
            text-align: center;
            margin: 8px 0;
            font-weight: bold;
        }

        .kot-no {
            font-size: 13px;
            text-transform: uppercase;
            background-color: black;
            color: white;
            padding: 4px 5px;
        }

        .time-date {
            font-size: 10px;
            margin: 3px 0;
        }

        .item-row {
            display: flex;
            margin-bottom: 4px;
        }

        .item-qty {
            width: 15%;
            font-weight: bold;
        }

        .item-name {
            width: 65%;
        }

        .instructions {
            font-style: italic;
            padding-left: 15%;
            font-size: 10px;
            color: #555;
            margin-bottom: 5px;
        }

        .divider {
            border-top: 1px solid #333;
            margin: 8px 0;
        }

        .kot-footer {
            text-align: center;
            font-size: 10px;
            margin-top: 10px;
            color: #666;
        }

        .text-center {
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="kot-header">
        <div class="kot-no">KOT #{{ $order->id }}</div>
        @if($order->bill)
        <div style="padding-top: 4px;">Table: {{ $order->bill->table_number }}</div>
        @endif
        <div class="time-date">
            {{ $order->created_at->format('h:i A') }} • {{ $order->created_at->format('jS M, Y') }}
        </div>
    </div>

    <div class="divider"></div>

    <table>
        <thead></thead>
            <tr>
                <th style="width: 85%;">Item</th>
                <th class="text-center" style="width: 15%;">Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
            <tr>
                <td style="width: 75%;">{{ $item->item->name }}<br>{{ $item->special_instructions ? '(' . $item->special_instructions . ')' : '' }}
                </td>
                <td class="text-center">{{ formatNumber($item->quantity) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="kot-footer">
        Thank you! • Please prepare with care
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
            window.print();
        };

    </script>
</body>
</html>
