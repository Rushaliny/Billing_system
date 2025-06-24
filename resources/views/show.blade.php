<x-app-layout>
    @section('title', 'All Pay Bills')

    @section('content')


        <style>
            .footer {
                position: fixed;
                bottom: 0;
                left: 260px;
                /* adjust this if your sidebar is a different width */
                width: calc(100% - 260px);
                /* match the main panel width */
                border-top: 1px solid #eee;
                padding: 15px;
                background: #ffffff;
                z-index: 999;
            }
        </style>


        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">All Pay Bills</h4>
                {{-- <form method="GET" action="{{ route('paybill.show') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Enter Payee Account Number"
                            value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </form> --}}


                {{-- Search Form --}}

                <form method="GET" action="{{ route('paybill.show') }}" class="mb-3">
                    <div class="input-group input-group-sm" style="max-width: 250px; gap: 5px;">
                        <input type="text" name="search" class="form-control" placeholder="🔍 Payee A/C No"
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>


                <div class="btn-group" role="group" aria-label="Download Reports">
                    <a href="{{ route('paybill.download.csv') }}" class="btn btn-success btn-sm me-2">Download CSV</a>
                    <a href="{{ route('paybill.download.pdf') }}" class="btn btn-danger btn-sm">Download PDF</a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            {{-- <th>Customer Name</th>
                        <th>NIC</th> --}}
                            <th>Service Type</th>
                            <th>Payee Acc.No</th>
                            <th>Mobile</th>
                            <th>ZB Account No</th>
                            {{-- <th>District</th> --}}
                            <th>Bill Month</th>
                            <th>Amount (Rs)</th>
                            <th>Additional Charges</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Receipt </th>
                            <th>Cancel Reason</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paybills as $index => $bill)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                {{-- <td>{{ $bill->customer_name }}</td>
                            <td>{{ $bill->nic }}</td> --}}
                                <td>{{ $bill->service_type }}</td>
                                <td>{{ $bill->payee_account_number }}</td>
                                <td>{{ $bill->mobile }}</td>

                                <td>{{ $bill->account_number }}</td>
                                {{-- <td>{{ $bill->district }}</td> --}}
                                <td>{{ \Carbon\Carbon::parse($bill->bill_month)->format('F Y') }}</td>
                                <td>{{ number_format($bill->base_amount, 2) }}</td>
                                <td>{{ number_format($bill->additional_charges, 2) }}</td>
                                <td>{{ number_format($bill->total_amount, 2) }}</td>
                                <td>
                                    @if ($bill->payment_status == 'Paid')
                                        <span class="badge bg-success">{{ $bill->payment_status }}</span>
                                    @elseif($bill->payment_status == 'Pending')
                                        <span class="badge bg-warning text-dark">{{ $bill->payment_status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $bill->payment_status }}</span>
                                    @endif
                                </td>
                                <td>{{ $bill->payment_method }}</td>
                                <td>
                                    @if ($bill->receipt_path)
                                        <a href="{{ asset('storage/' . $bill->receipt_path) }}" target="_blank"
                                            class="btn btn-primary btn-sm">View Receipt</a>
                                    @else
                                        <span class="text-muted">No Receipt</span>
                                    @endif
                                </td>
                                <td>{{ $bill->cancel_reason ?? '-' }}</td>
                                <td>{{ $bill->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endsection
</x-app-layout>
