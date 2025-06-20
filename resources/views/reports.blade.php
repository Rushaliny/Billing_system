@extends('layouts.app')

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
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="to_date">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
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
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="la la-filter"></i> Filter</button>
                <a href="{{ route('reports.download', request()->query()) }}" class="btn btn-secondary"><i class="la la-download"></i> Download</a>
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
        <a href="{{ route('reports.filter', ['month' => now()->month, 'year' => now()->year]) }}" class="btn btn-info me-2">
            <i class="la la-calendar"></i> This Month's Report
        </a>
        <a href="{{ route('reports.filter', ['year' => now()->year]) }}" class="btn btn-warning me-2">
            <i class="la la-calendar-check"></i> This Year's Report
        </a>
        <a href="{{ route('reports.download', ['month' => now()->month, 'year' => now()->year]) }}" class="btn btn-success me-2">
            <i class="la la-calendar"></i> Download This Month
        </a>
        <a href="{{ route('reports.download', ['year' => now()->year]) }}" class="btn btn-secondary">
            <i class="la la-download"></i> Download This Year
        </a>
    </div>
</div>

<!-- Filtered Paybill Results -->
@if(isset($paybills) && count($paybills) > 0)
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
                    <th>Units Consumed</th>
                    <th>Amount</th>
                    <th>Paid On</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paybills as $bill)
                <tr>
                    <td>{{ $bill->customer_name }}</td>
                    <td>{{ $bill->account_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->bill_month)->format('F Y') }}</td>
                    <td>{{ $bill->units_consumed }}</td>
                    <td>{{ number_format($bill->amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->paid_at)->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@elseif(request()->anyFilled(['from_date', 'to_date', 'month', 'year']))
    <div class="alert alert-warning mt-3">No records found for the selected filter.</div>
@endif

@endsection
