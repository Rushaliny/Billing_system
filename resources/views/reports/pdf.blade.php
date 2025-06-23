<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Paybills PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h3>All Pay Bills Report</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                {{-- <th>Customer</th> --}}
                {{-- <th>NIC</th>
                <th>Mobile</th> --}}
                <th>Service Type</th>
                <th>Payee Acc.No</th>
                <th>Mobile</th>
                <th>ZB Account No</th>
                {{-- <th>District</th> --}}
                <th>Month</th>
                <th>Base</th>
                <th>Charges</th>
                <th>Total</th>
                <th>Status</th>
                <th>Method</th>
                <th>Cancel Reason</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paybills as $i => $bill)
                <tr>
                    <td>{{ $i+1 }}</td>
                    {{-- <td>{{ $bill->customer_name }}</td> --}}
                    {{-- <td>{{ $bill->nic }}</td> --}}
                    {{-- <td>{{ $bill->mobile }}</td> --}}
                    <td>{{ $bill->service_type }}</td>
                    <td>{{ $bill->payee_account_number }}</td>
                    <td>{{ $bill->mobile }}</td>
                    <td>{{ $bill->account_number }}</td>
                    {{-- <td>{{ $bill->district }}</td> --}}
                    <td>{{ \Carbon\Carbon::parse($bill->bill_month)->format('F Y') }}</td>
                    <td>{{ $bill->base_amount }}</td>
                    <td>{{ $bill->additional_charges }}</td>
                    <td>{{ $bill->total_amount }}</td>
                    <td>{{ $bill->payment_status }}</td>
                    <td>{{ $bill->payment_method }}</td>
                    <td>{{ $bill->cancel_reason ?? '-' }}</td>
                    <td>{{ $bill->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
