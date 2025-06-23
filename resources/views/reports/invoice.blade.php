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
                {{-- <th>Customer</th> --}}
                <th>Service Type</th>
                <th>Payee Acc Number</th>
                <th>ZB Account Number</th>
                <th>Bill Month</th>
                <th>Paid On</th>
                <th>Payment Status</th>
                <th>Admin Paid (Rs)</th>
                <th>Actual Amount (Rs)</th>
                <th>Income (Rs)</th>

            </tr>
        </thead>
        <tbody>
            @php
                                $total_income = 0;
                                $adminpaidtotal = 0;
                                $actualtotal = 0;
                            @endphp

                            @foreach ($paybills as $bill)
                                @php
                                    if ($bill->payment_status === 'Paid') {
                                        $adminPaid = $bill->total_amount;
                                        $actual = $bill->base_amount;
                                        $income = $adminPaid - $actual;

                                        $adminpaidtotal += $adminPaid;
                                        $actualtotal += $actual;
                                        $total_income += $income;
                                    }
                                @endphp
                                <tr>
                                    {{-- <td>{{ $bill->customer_name }}</td> --}}
                                    <td>{{ $bill->service_type }}</td>
                                    <td>{{ $bill->payee_account_number }}</td>
                                    <td>{{ $bill->account_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill->bill_month)->format('F Y') }}</td>
                                    <td>{{ $bill->created_at ? $bill->created_at->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        @if ($bill->payment_status == 'Paid')
                                            <span style="background-color: #28a745; color: white; padding: 2px 8px; border-radius: 4px;">Paid</span>
                                        @elseif ($bill->payment_status == 'Pending')
                                            <span style="background-color: #dc3545; color: white; padding: 2px 8px; border-radius: 4px;">Pending</span>
                                        @elseif ($bill->payment_status == 'Cancelled')
                                            <span style="background-color: #ffc107; color: black; padding: 2px 8px; border-radius: 4px;">Cancelled</span>
                                        @else
                                            <span  style="background-color: #6c757d; color: white; padding: 2px 8px; border-radius: 4px;">Unknown</span>
                                        @endif
                                    </td>
                                    <td>{{ $bill->total_amount, 2 }}</td>
                                    <td>{{ $bill->base_amount, 2 }}</td>
                                    <td>
                                        @if ($bill->payment_status === 'Paid')
                                            {{ number_format($income, 2) }}
                                        @else
                                            0.00
                                        @endif
                                    </td>


                                </tr>
                            @endforeach
                            <tr class="bg-light font-weight-bold">
                                <td colspan="6" class="text-end">Total Income (Rs)</td>
                                <td>{{ number_format($adminpaidtotal, 2) }}</td>
                                <td>{{ number_format($actualtotal, 2) }}</td>
                                <td>{{ number_format($total_income, 2) }}</td>
                            </tr>
                        </tbody>
    </table>
</body>

</html>
