<x-app-layout>

@section('title', 'Dashboard')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">Chargers Table</div>
    </div>
    <div class="card-body">
        <!-- Add Button -->
        <div class="card-sub d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#chargerModal" id="addChargerBtn">
                Add Chargers
            </button>
        </div>

        <!-- Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Applicable to</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dummy Data -->
                @for ($i = 0; $i < 3; $i++)
                <tr>
                    <td>CEB / Water </td>
                    <td>50 RS</td>
                    <td>
                        <button class="btn btn-sm btn-primary editBtn"
                                data-toggle="modal"
                                data-target="#chargerModal2"
                                data-id="1"
                                data-type="Service Charge"
                                data-amount="50"
                                data-applicable="Both"
                                data-date="2025-05-25">
                            <i class="la la-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-toggle="modal" data-target="#deleteModal">
                            <i class="la la-trash"></i>
                        </button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="chargerModal" tabindex="-1" role="dialog" aria-labelledby="chargerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="chargerForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Charger</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="charge_id">
                    <div class="form-group">
                        <label for="applicable_to">Applicable To</label>
                        <select class="form-control" id="applicable_to">
                            <option value="" disabled selected>Select Applicable</option>
                            <option value="CEB">CEB</option>
                            <option value="Water">Water</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount (RS)</label>
                        <input type="number" class="form-control" id="amount" required>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- Edit Modal --}}

<div class="modal fade" id="chargerModal2" tabindex="-1" role="dialog" aria-labelledby="chargerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="chargerForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Charger</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="charge_id">
                    <div class="form-group">
                        <label for="applicable_to">Applicable To</label>
                        <select class="form-control" id="applicable_to">
                            <option value="" disabled selected>Select Applicable</option>
                            <option value="CEB">CEB</option>
                            <option value="Water">Water</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount (RS)</label>
                        <input type="number" class="form-control" id="amount" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="deleteForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this charge?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Open Add Modal
        $('#addChargerBtn').click(function () {
            $('#chargerForm')[0].reset();
            $('#charge_id').val('');
            $('#chargerModal .modal-title').text('Add Charger');
        });

        // Open Edit Modal
        $('.editBtn').click(function () {
            $('#charge_id').val($(this).data('id'));
            $('#type').val($(this).data('type'));
            $('#amount').val($(this).data('amount'));
            $('#applicable_to').val($(this).data('applicable'));
            $('#effective_date').val($(this).data('date'));
            $('#chargerModal .modal-title').text('Edit Charger');
        });

        // Optional: Handle form submit here (e.g., AJAX or Laravel form action)
    });
</script>
@endpush

</x-app-layout>
