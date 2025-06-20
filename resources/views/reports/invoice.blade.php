<!DOCTYPE html>
<html>

<head>
    <title>Paybill Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Paybill Report</h2>
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Account Number</th>
                <th>Bill Month</th>
                <th>Admin Paid (Rs)</th>
                <th>Actual Amount (Rs)</th>
                <th>Income (Rs)</th>
                <th>Paid On</th>
            </tr>
        </thead>
        <tbody>
             @php
                                $total_income = 0;
                                $adminpaidtotal = 0;
                                $systemCharge = 50; // Your assumed system charge
                            @endphp
                            @foreach ($paybills as $bill)
                                @php
                                    $adminPaid = $bill->total_amount;
                                    $actual = $adminPaid - $systemCharge;
                                    $income = $adminPaid - $actual;
                                    $adminpaidtotal += $adminPaid;
                                    $total_income += $income;
                                @endphp
                                <tr>
                                    <td>{{ $bill->customer_name }}</td>
                                    <td>{{ $bill->account_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill->bill_month)->format('F Y') }}</td>
                                    <td>{{ number_format($adminPaid, 2) }}</td>
                                    <td>{{ number_format($actual, 2) }}</td>
                                    <td>{{ number_format($income, 2) }}</td>
                                    <td>{{ $bill->created_at ? $bill->created_at->format('Y-m-d') : '-' }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-light font-weight-bold">
                                <td colspan="4" class="text-end">Total Income (Rs)</td>
                                <td>{{ number_format($adminpaidtotal, 2) }}</td>
                                <td colspan="2">{{ number_format($total_income, 2) }}</td>
                            </tr>
        </tbody>
    </table>
</body>

</html>
