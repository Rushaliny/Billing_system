@extends('layouts.app')
@section('title', 'Pay Bill')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title"><b>Pay Bill </b></div>
    </div>
    <div class="card-body">
        <form id="payBillForm">
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
                    <input type="text" class="form-control" name="mobile" required>
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

                <label class="col-sm-2 col-form-label">Units Consumed</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="units_consumed" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Base Amount (Rs)</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="base_amount" required>
                </div>

                <label class="col-sm-2 col-form-label">Additional Charges</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="additional_charges" readonly placeholder="Auto-calculated">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Total Amount (Rs)</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="total_amount" readonly placeholder="Auto-calculated">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Payment Status</label>
                <div class="col-sm-4">
                    <select class="form-control" name="payment_status" required>
                        <option value="Pending">Pending</option>
                        <option value="Paid">Paid</option>
                    </select>
                </div>

                <label class="col-sm-2 col-form-label">Payment Method</label>
                <div class="col-sm-4">
                    <select class="form-control" name="payment_method" required>
                        <option value="Cash">Cash</option>
                        <option value="Card">Card</option>
                        <option value="Online">Online</option>
                    </select>
                </div>
            </div>

            <hr>

            {{-- Actions --}}
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-0">
                    <button type="button" class="btn btn-success" id="redirectToGateway">Pay Now</button>
                    <a href="" class="btn btn-info">Submit</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- JS to handle redirect --}}
<script>
    document.getElementById('redirectToGateway').addEventListener('click', function () {
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
</script>

@endsection
