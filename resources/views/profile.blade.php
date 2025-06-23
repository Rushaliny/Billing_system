<x-app-layout>
    @section('title', 'Admin Profile')

    @section('content')

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div class="container-fluid">
            <h4 class="page-title mb-4">Admin Profile</h4>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow rounded">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Profile Information</h5>
                            <button class="btn btn-sm btn-light" id="editToggleBtn">Edit</button>
                        </div>

                        <div class="card-body">
                            {{-- View Mode --}}
                            <div id="viewMode">
                                <dl class="row">
                                    <dt class="col-sm-4">Full Name</dt>
                                    <dd class="col-sm-8">
                                        {{ auth()->user()->name }}
                                    </dd>

                                    <dt class="col-sm-4">Email</dt>
                                    <dd class="col-sm-8">
                                        {{ auth()->user()->email }}
                                    </dd>

                                    <dt class="col-sm-4">Account Number</dt>
                                    <dd class="col-sm-8">
                                        {{ auth()->user()->account_number ?? 'Not Assigned' }}
                                    </dd>

                                    <dt class="col-sm-4">Password</dt>
                                    <dd class="col-sm-8">********</dd>
                                </dl>
                            </div>

                            {{-- Edit Mode --}}
                            <form method="POST"
                                action="
                        {{ route('profile.update') }}
                         "
                                id="editMode" style="display: none;">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ auth()->user()->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ auth()->user()->email }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="account_number" class="form-label">Account Number</label>
                                    <input type="text" class="form-control" name="account_number" id="account_number"
                                        value="{{ auth()->user()->account_number ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Leave blank to keep current password">
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" placeholder="Re-type new password">
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                    <button type="button" class="btn btn-secondary" id="cancelEdit">Cancel</button>
                                </div>
                            </form>
                        </div>

                        <div class="card-footer d-flex justify-content-end">
                            <form id="logout-form"
                                action="
                        {{ route('logout') }}
                         "
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- JavaScript for Toggle --}}
        <script>
            const editToggleBtn = document.getElementById('editToggleBtn');
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');
            const cancelEdit = document.getElementById('cancelEdit');

            editToggleBtn.addEventListener('click', () => {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
                editToggleBtn.style.display = 'none';
            });

            cancelEdit.addEventListener('click', () => {
                viewMode.style.display = 'block';
                editMode.style.display = 'none';
                editToggleBtn.style.display = 'inline-block';
            });
        </script>
    @endsection
</x-app-layout>
