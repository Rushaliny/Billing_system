<x-app-layout>

@section('title', 'Dashboard')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">Chargers Table</div>
    </div>
    <div class="card-body">
        <div class="card-sub d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal" id="addChargerBtn">
                Add Chargers
            </button>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Applicable To</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chargers as $charger)
                    <tr>
                        <td>{{ $charger->applicable_to }}</td>
                        <td>{{ $charger->amount }} RS</td>
                        <td>
                            <button class="btn btn-sm btn-primary editBtn" data-toggle="modal"
                                data-target="#editModal"
                                data-id="{{ $charger->id }}"
                                data-amount="{{ $charger->amount }}"
                                data-applicable="{{ $charger->applicable_to }}">
                                <i class="la la-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $charger->id }}"
                                data-toggle="modal" data-target="#deleteModal">
                                <i class="la la-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="addChargerForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Charger</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Applicable To</label>
                        <select class="form-control" id="add_applicable_to" required>
                            <option value="" disabled selected>Select</option>
                            <option value="CEB">CEB</option>
                            <option value="Water">Water</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount (RS)</label>
                        <input type="number" class="form-control" id="add_amount" required>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="editChargerForm">
            @csrf
            <input type="hidden" id="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Charger</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Applicable To</label>
                        <select class="form-control" id="edit_applicable_to" required>
                            <option value="CEB">CEB</option>
                            <option value="Water">Water</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount (RS)</label>
                        <input type="number" class="form-control" id="edit_amount" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this charge?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
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
        // Add
        $('#addChargerForm').submit(function (e) {
            e.preventDefault();
            $.post('/chargers', {
                applicable_to: $('#add_applicable_to').val(),
                amount: $('#add_amount').val(),
                _token: '{{ csrf_token() }}'
            }, function () {
                location.reload();
            });
        });

        // Edit - fill modal
        $('.editBtn').click(function () {
            $('#edit_id').val($(this).data('id'));
            $('#edit_applicable_to').val($(this).data('applicable'));
            $('#edit_amount').val($(this).data('amount'));
        });

        // Edit - submit
        $('#editChargerForm').submit(function (e) {
            e.preventDefault();
            let id = $('#edit_id').val();
            $.ajax({
                url: '/chargers/' + id,
                type: 'PUT',
                data: {
                    applicable_to: $('#edit_applicable_to').val(),
                    amount: $('#edit_amount').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    location.reload();
                }
            });
        });

        // Delete
        let deleteId = null;
        $('.deleteBtn').click(function () {
            deleteId = $(this).data('id');
        });

        $('#deleteForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: '/chargers/' + deleteId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    location.reload();
                }
            });
        });
    });
</script>
@endpush

</x-app-layout>
