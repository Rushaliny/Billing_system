<x-app-layout>

    @section('title', 'Reports')

    @section('content')

        <div class="card">
            <div class="card-header">
                <div class="card-title">Reports</div>
            </div>
            <div class="card-body">
                @if (isset($hasData) && $hasData)
                    <div class="alert alert-success text-center">
                        ✅ Records found for the selected filters you can see below table.
                    </div>
                @elseif (isset($hasData) && !$hasData)
                    <div class="alert alert-warning text-center">
                        🚫 No records found for the selected filters.
                    </div>
                @endif


            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mt-4">
            <div class="card-header">
                <div class="card-title">Filter Reports</div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.filter') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="from_date">From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="to_date">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="service_type">Service Type</label>
                            <select name="service_type" id="service_type" class="form-control">
                                <option value="">-- Select Service Type --</option>
                                @foreach ($serviceTypes as $type)
                                    <option value="{{ $type }}"
                                        {{ request('service_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-3">
                            <label for="year">Year</label>
                            <select name="year" id="year" class="form-control">
                                <option value="">-- Select Year --</option>
                                @for ($y = now()->year; $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary"><i class="la la-filter"></i> Filter</button>
                        <button type="button" class="btn btn-secondary" id="downloadReportBtn"><i
                                class="la la-download"></i> Download</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Generate Buttons -->
        <div class="card mt-4">
            <div class="card-header">
                <div class="card-title">Quick Generate</div>
            </div>
            <div class="card-body">
                {{-- <a href="{{ route('reports.filter', ['month' => now()->month, 'year' => now()->year]) }}"
                    class="btn btn-info me-2">
                    <i class="la la-calendar"></i> This Month's Report
                </a>
                <a href="{{ route('reports.filter', ['year' => now()->year]) }}" class="btn btn-warning me-2">
                    <i class="la la-calendar-check"></i> This Year's Report
                </a> --}}
                <a href="{{ route('reports.download', ['month' => now()->month, 'year' => now()->year]) }}"
                    class="btn btn-success me-2">
                    <i class="la la-calendar"></i> Download This Month
                </a>
                <a href="{{ route('reports.download', ['year' => now()->year]) }}" class="btn btn-secondary">
                    <i class="la la-download"></i> Download This Year
                </a>
            </div>
        </div>

        <!-- Filtered Paybill Results -->
        @if (isset($paybills) && count($paybills) > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <div class="card-title">Filtered Paybill Details</div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                {{-- <th>Customer</th> --}}
                                <th>Service Type</th>
                                <th>Payee Acc Number</th>
                                <th>Zb Account Number</th>
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
                                            <span class="badge bg-success">Paid</span>
                                        @elseif ($bill->payment_status == 'Pending')
                                            <span class="badge bg-danger">Pending</span>
                                        @elseif ($bill->payment_status == 'Cancelled')
                                            <span class="badge bg-warning">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($bill->total_amount, 2) }}</td>
                                    <td>{{ number_format($bill->base_amount, 2) }}</td>
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
                </div>
            </div>
        @endif

    @endsection

    @push('scripts')
        <script>
            document.getElementById('downloadReportBtn').addEventListener('click', function() {
                const queryParams = new URLSearchParams(window.location.search).toString();
                const downloadUrl = "{{ route('reports.download') }}" + (queryParams ? '?' + queryParams : '');

                // Open download link in new tab to trigger download
                window.open(downloadUrl, '_blank');

                // Refresh the page after 2 seconds to the base reports page
                setTimeout(() => {
                    window.location.href = "{{ route('reports.index') }}";
                }, 2000);
            });
        </script>
    @endpush

</x-app-layout>
