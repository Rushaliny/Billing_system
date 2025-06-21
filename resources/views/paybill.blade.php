<x-app-layout>
    @section('title', 'Pay Bill')

    @section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header"><div class="card-title"><b>Pay Bill</b></div></div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form id="payBillForm" action="{{ route('paybill.store') }}" method="POST">
                @csrf

                <h6><b>Customer Details</b></h6>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Customer Name</label>
                    <div class="col-sm-10"><input type="text" class="form-control" name="customer_name" required></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10"><input type="text" class="form-control" name="customer_address" required></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NIC</label>
                    <div class="col-sm-10"><input type="text" class="form-control" name="nic" required></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mobile</label>
                    <div class="col-sm-10"><input type="number" class="form-control" name="mobile" required></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Service Type</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="service_type" id="service_type" required>
                            <option value="" disabled selected>Select</option>
                            <option value="CEB">CEB</option>
                            <option value="Water">Water</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Account No</label>
                    <div class="col-sm-4"><input type="text" class="form-control" name="account_number" required></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Area / District</label>
                    <div class="col-sm-10"><input type="text" class="form-control" name="district" required></div>
                </div>

                <hr>

                <h6><b>Bill Information</b></h6>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bill Month</label>
                    <div class="col-sm-4"><input type="month" class="form-control" name="bill_month" required></div>

                    <label class="col-sm-2 col-form-label">Pay Amount (Rs)</label>
                    <div class="col-sm-4"><input type="number" class="form-control" id="base_amount" name="base_amount" required></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Additional Charges</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="additional_charges" name="additional_charges" readonly placeholder="Auto-calculated">
                    </div>

                    <label class="col-sm-2 col-form-label font-weight-bold">Total Amount (Rs)</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="total_amount" name="total_amount" readonly placeholder="Auto-calculated">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Payment Status</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="payment_status" id="payment_status" required>
                            <option value="Pending">Pending</option>
                            <option value="Paid">Paid</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>

                    <label class="col-sm-2 col-form-label">Payment Method</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="payment_method" required>
                            <option value="Online" selected>Online</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="cancelReasonDiv" style="display: none;">
                    <label class="col-sm-2 col-form-label text-danger">Reason for Cancellation</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="cancel_reason" placeholder="Enter reason for cancellation..."></textarea>
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-0">
                        <button type="button" class="btn btn-success" id="redirectToGateway">Pay Now</button>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @endsection

    @push('scripts')
    <script>
        let additionalCharge = 0;

        // Fetch charge dynamically on service type change
        document.getElementById('service_type').addEventListener('change', function () {
            const serviceType = this.value;

            if (serviceType) {
                fetch(`/get-charge/${serviceType}`)
                    .then(response => response.json())
                    .then(data => {
                        additionalCharge = parseFloat(data.charge) || 0;
                        document.getElementById('additional_charges').value = additionalCharge;

                        const base = parseFloat(document.getElementById('base_amount').value) || 0;
                        document.getElementById('total_amount').value = base + additionalCharge;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });

        // Auto-calculate total
        document.getElementById('base_amount').addEventListener('input', function () {
            const base = parseFloat(this.value) || 0;
            document.getElementById('total_amount').value = base + additionalCharge;
        });

        // Cancel Reason show/hide
        document.getElementById('payment_status').addEventListener('change', function () {
            document.getElementById('cancelReasonDiv').style.display = this.value === 'Cancelled' ? 'flex' : 'none';
        });

        // Redirect to gateway
        document.getElementById('redirectToGateway').addEventListener('click', function () {
            const type = document.getElementById('service_type').value;
            let url = '';

            if (type === 'CEB') {
                url = 'https://payment.ceb.lk/instantpay';
            } else if (type === 'Water') {
                url = 'https://ebis.waterboard.lk/smartzone/English/OnlinePayments';
            } else {
                alert('Please select a bill type.');
                return;
            }

            if (confirm("You will be redirected to the official payment gateway. Continue?")) {
                window.open(url, '_blank');
            }
        });
    </script>
    @endpush
</x-app-layout>
