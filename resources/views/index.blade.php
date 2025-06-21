<x-app-layout>

@section('title', 'Dashboard')

@section('content')

<style>
    .footer {
  position: fixed;
  bottom: 0;
  left: 260px; /* adjust this if your sidebar is a different width */
  width: calc(100% - 260px); /* match the main panel width */
  border-top: 1px solid #eee;
  padding: 15px;
  background: #ffffff;
  z-index: 999;
}
</style>
<div class="container-fluid">
    <h4 class="page-title mb-4">Dashboard</h4>

    <div class="row">

        {{-- Total Paybills --}}
        <div class="col-md-3">
            <div class="card card-stats card-primary">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-big text-center me-3">
                        <i class="la la-file-invoice-dollar" style="font-size: 36px;"></i>
                    </div>
                    <div>
                        <p class="card-category mb-1">Total Paybills</p>
                        <h4 class="card-title">{{ $totalPaybills ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Income --}}
        <div class="col-md-3">
            <div class="card card-stats card-success">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-big text-center me-3">
                        <i class="la la-money" style="font-size: 36px;"></i>
                    </div>
                    <div>
                        <p class="card-category mb-1">Total Income (Rs)</p>
                        <h4 class="card-title">Rs. {{ number_format($totalIncome ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Payments --}}
        <div class="col-md-3">
            <div class="card card-stats card-warning">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-big text-center me-3">
                        <i class="la la-clock" style="font-size: 36px;"></i>
                    </div>
                    <div>
                        <p class="card-category mb-1">Pending Payments</p>
                        <h4 class="card-title">{{ $pendingPayments ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Paid Payments --}}
        <div class="col-md-3">
            <div class="card card-stats card-info">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-big text-center me-3">
                        <i class="la la-check-circle" style="font-size: 36px;"></i>
                    </div>
                    <div>
                        <p class="card-category mb-1">Paid Payments</p>
                        <h4 class="card-title">{{ $paidPayments ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Quick Links (optional) --}}
    <div class="mt-5">
        <a href="{{ route('reports.filter') }}" class="btn btn-primary me-3">
            <i class="la la-file-alt"></i> View Reports
        </a>
        {{-- <a href="{{ route('paybills.create') }}" class="btn btn-success">
            <i class="la la-plus"></i> Add New Paybill
        </a> --}}
    </div>

</div>

@endsection

</x-app-layout>
