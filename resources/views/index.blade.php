<x-app-layout>

    @section('title', 'Dashboard')

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

/* #cebIncomeChart {
    max-width: 100%;
    height: 400px !important;
  } */


            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

        <div class="container-fluid">
            <h4 class="page-title mb-4">Dashboard</h4>

            <div class="row">

                {{-- Cancelled Payments --}}
                <div class="col-md-3">
                    <div class="card card-stats card-danger">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-big text-center me-3">
                                <i class="la la-ban" style="font-size: 36px;"></i>
                            </div>
                            <div>
                                <p class="card-category mb-1">Cancel Payments</p>
                                <h4 class="card-title">
                                    Rs. {{ number_format($cancelPayments ?? 0, 2) }}
                                </h4>
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
                                <h4 class="card-title">
                                    Rs. {{ number_format($pendingPayments ?? 0, 2) }}
                                    {{-- {{ $pendingPayments ?? 0 }} --}}
                                </h4>
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
                                <h4 class="card-title">
                                    Rs. {{ number_format($paidPayments ?? 0, 2) }}

                                    {{-- {{ $paidPayments ?? 0 }}</h4> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
           <div class="row mt-4">
   </div>
    {{-- Quick Links (optional)
            <div class="mt-5">
                <a href="{{ route('reports.filter') }}" class="btn btn-primary me-3">
                    <i class="la la-file-alt"></i> View Reports
                </a>

            </div> --}}


{{-- <div class="container my-5">
  <h3 class="text-center mb-4">Monthly CEB Income Chart</h3>
  <div class="card">
    <div class="chart-container" style="position: relative; height:400px;">
      <canvas id="cebIncomeChart" ></canvas>
    </div>
  </div>
</div> --}}

<div class="container my-4">
  <h3 class="text-center mb-4">Monthly Income Charts</h3>
  <div class="row">

    <!-- CEB Income Chart -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header text-center">CEB Income</div>
        <div class="chart-container" style="position: relative; height:250px;">
          <canvas id="cebIncomeChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Water Bill Income Chart -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header text-center">Water Bill Income</div>
        <div class="chart-container" style="position: relative; height:250px;">
          <canvas id="waterIncomeChart"></canvas>
        </div>
      </div>
    </div>

  </div>
</div>





        </div>

      <!-- Bootstrap 5 CDN -->
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- First load the library --> --}}


{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch('/api/paybills-monthly-income')
            .then(res => res.json())
            .then(data => {
                const labels = Object.keys(data);
                const values = Object.values(data);

                const ctx = document.getElementById('cebIncomeChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Monthly Income (LKR)',
                            data: values,
                            borderColor: 'rgba(0, 123, 255, 1)',
                            backgroundColor: 'rgba(0, 123, 255, 0.2)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top' }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Income (LKR)' }
                            },
                            x: {
                                title: { display: true, text: 'Month' }
                            }
                        }
                    }
                });
            });
    });
</script> --}}

<script>
  document.addEventListener("DOMContentLoaded", function () {

    // CEB Income Chart
    fetch('{{url ('/api/paybills-monthly-income')}}')
      .then(res => res.json())
      .then(data => {
        new Chart(document.getElementById('cebIncomeChart').getContext('2d'), {
          type: 'line',
          data: {
            labels: Object.keys(data),
            datasets: [{
              label: 'CEB Monthly Income (LKR)',
              data: Object.values(data),
              borderColor: 'rgba(0, 123, 255, 1)',
              backgroundColor: 'rgba(0, 123, 255, 0.2)',
              fill: true,
              tension: 0.4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: { beginAtZero: true },
              x: {}
            }
          }
        });
      });

    // Water Bill Income Chart
    fetch('{{url ('/api/waterbills-monthly-income')}}')
      .then(res => res.json())
      .then(data => {
        new Chart(document.getElementById('waterIncomeChart').getContext('2d'), {
          type: 'line',
          data: {
            labels: Object.keys(data),
            datasets: [{
              label: 'Water Bill Monthly Income (LKR)',
              data: Object.values(data),
              borderColor: 'rgba(40, 167, 69, 1)',
              backgroundColor: 'rgba(40, 167, 69, 0.2)',
              fill: true,
              tension: 0.4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: { beginAtZero: true },
              x: {}
            }
          }
        });
      });

  });
</script>
@if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif


    @endsection

</x-app-layout>
