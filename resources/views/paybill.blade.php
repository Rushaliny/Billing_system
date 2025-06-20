<x-app-layout>
    @section('title', 'Pay Bill')

    @section('content')

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        <div class="card">
            <div class="card-header">
                <div class="card-title"><b>Pay Bill </b></div>
            </div>



            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                <form id="payBillForm" action="{{ route('paybill.store') }}" method="POST">
                    @csrf

                    {{-- Customer Details --}}
                    <h6> <b>Customer Details</b></h6>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Customer Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="customer_name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="customer_address" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">NIC </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nic" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="mobile" required>
                        </div>

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
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="account_number" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Area / District</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="district" required>
                        </div>
                    </div>

                    <hr>

                    {{-- Bill Information --}}
                    <h6> <b>Bill Information</b></h6>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Bill Month</label>
                        <div class="col-sm-4">
                            <input type="month" class="form-control" name="bill_month" required>
                        </div>

                        <label class="col-sm-2 col-form-label">Base Amount (Rs)</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="base_amount" name="base_amount" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Additional Charges</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="additional_charges" name="additional_charges"
                                readonly placeholder="Auto-calculated">
                        </div>

                        <label class="col-sm-2 col-form-label font-weight-bold">Total Amount (Rs)</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="total_amount" name="total_amount" readonly
                                placeholder="Auto-calculated">
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
                            <select class="form-control" name="payment_method" id="payment_method" required>
                                {{-- <option value="" disabled selected>Select</option> --}}
                                <option value="Online" selected>Online</option>
                            </select>
                        </div>
                    </div>

                    {{-- Reason for Cancellation --}}
                    <div class="form-group row" id="cancelReasonDiv" style="display: none;">
                        <label class="col-sm-2 col-form-label text-danger">Reason for Cancellation</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="cancel_reason" placeholder="Enter reason for cancellation..."></textarea>
                        </div>
                    </div>

                    <hr>

                    {{-- Actions --}}
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
            // Handle Payment Gateway Redirection
            document.getElementById('redirectToGateway').addEventListener('click', function() {
                const billType = document.getElementById('service_type').value;

                if (!billType) {
                    alert('Please select a bill type.');
                    return;
                }

                let gatewayUrl = '';

                if (billType === 'CEB') {
                    gatewayUrl = 'https://payment.ceb.lk/instantpay';
                } else if (billType === 'Water') {
                    gatewayUrl = 'https://ebis.waterboard.lk/smartzone/English/OnlinePayments';
                }

                if (confirm("You will be redirected to the official payment gateway. Continue?")) {
                    window.open(gatewayUrl, '_blank');
                }
            });

            // Auto-calculate additional and total amounts
            document.getElementById('base_amount').addEventListener('input', function() {
                const base = parseFloat(this.value) || 0;
                const extraCharge = 50;

                document.getElementById('additional_charges').value = extraCharge;
                document.getElementById('total_amount').value = base + extraCharge;
            });

            // Show/hide cancel reason box
            document.getElementById('payment_status').addEventListener('change', function() {
                const cancelDiv = document.getElementById('cancelReasonDiv');
                if (this.value === 'Cancelled') {
                    cancelDiv.style.display = 'flex';
                } else {
                    cancelDiv.style.display = 'none';
                }
            });
        </script>
    @endpush
</x-app-layout>
