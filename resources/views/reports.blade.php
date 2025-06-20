<x-app-layout>

    @section('title', 'Reports')

    @section('content')

        <div class="card">
            <div class="card-header">
                <div class="card-title">Reports</div>
            </div>
            <div class="card-body">
                <p>Here you can view and generate reports related to billing and payments.</p>
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
                            <label for="month">Month</label>
                            <select name="month" id="month" class="form-control">
                                <option value="">-- Select Month --</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endfor
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
                <a href="{{ route('reports.filter', ['month' => now()->month, 'year' => now()->year]) }}"
                    class="btn btn-info me-2">
                    <i class="la la-calendar"></i> This Month's Report
                </a>
                <a href="{{ route('reports.filter', ['year' => now()->year]) }}" class="btn btn-warning me-2">
                    <i class="la la-calendar-check"></i> This Year's Report
                </a>
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
