<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $payment->order_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .invoice-details div {
            flex: 1;
            padding: 10px;
        }
        .table-container {
            overflow-x: auto;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total-cell {
            font-weight: bold;
        }
        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <h1 class="invoice-header">
            <img src="{{ $base64Image }}" alt="Logo" style="width:150px" />
        </h1>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="text-align: left;">
                    <strong>Receipt No:</strong> #BMF{{ $payment->id }}<br>
                    <strong>Receipt Date:</strong> {{ $payment->created_at->format('d-m-Y') }}<br>
                    @if($payment->payment_mode == 'Online')
                        <strong>Transaction ID:</strong> {{ $payment->provider_reference_id }}<br>
                    @endif
                    <strong>Tornament:</strong> {{ $payment->tournament->title }}<br>
                    <strong>Tornament Date:</strong> {{ $payment->tournament->start_date }}<br>
                </td>
                <td style="text-align: right;">
                    <strong>Order Number:</strong> {{ $payment->order_id }}<br>
                    <strong>Name:</strong> {{ $user->name }}<br>
                    <strong>Email:</strong> {{ $user->email }}
                </td>
            </tr>
        </table>

        <div class="table-container">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($players as $player)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $player->player_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($player->dob)->age }}</td>
                        <td>{{ $player->gender }}</td>
                        <td>{{ $player->mobile_1 }}</td>
                        <td>{{ $player->fide_rating }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right">Total</td>
                        <td class="total-cell">{{ $payment->amount }}/-</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">Payment Mode</td>
                        <td class="total-cell">{{ $payment->payment_mode }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="footer-text">
            <p>Thank you for choosing Book My Fee! Our Best Wishes to you!</p>
        </div>
    </div>
</body>
</html>
