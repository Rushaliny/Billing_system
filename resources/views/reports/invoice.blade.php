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
        th, td {
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
                <th>Account</th>
                <th>Month</th>
                <th>Admin Paid</th>
                <th>Actual</th>
                <th>Income</th>
                <th>Paid Date</th>
            </tr>
        </thead>
        <tbody>
            @php $total_income = 0; $adminpaidtotal = 0; @endphp
            @foreach($paybills as $bill)
            @php
                $adminPaid = $bill->amount;
                $actual = $adminPaid - 50;
                $income = $adminPaid - $actual;
                $adminpaidtotal +=$adminPaid ; 
                $total_income += $income;
            @endphp
            <tr>
                <td>{{ $bill->customer_name }}</td>
                <td>{{ $bill->account_number }}</td>
                <td>{{ \Carbon\Carbon::parse($bill->bill_month)->format('F Y') }}</td>
                <td>{{ number_format($adminPaid, 2) }}</td>
                <td>{{ number_format($actual, 2) }}</td>
                <td>{{ number_format($income, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($bill->paid_at)->format('Y-m-d') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total Income (Rs)</strong></td>
                <td>{{ number_format($adminpaidtotal, 2) }}</td>
                <td colspan="2"><strong>{{ number_format($total_income, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
