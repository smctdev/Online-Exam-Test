@extends('layouts.admin', [
    'page_header' => 'Examinees',
    'dash' => '',
    'examinees' => 'active',
    'quiz' => '',
    'users' => '',
    'questions' => '',
    'sett' => '',
])

@section('content')
    @include('message')

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Administrator Panel</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#createAdmin">
                                <i class="fas fa-user-shield"></i> Create Admin Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($auth->role == 'S')
            <div class="row">
                <!-- Current Admin Profile Card -->
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Current Administrator Profile</h3>
                            <div class="card-tools">
                                <button type="button" id="edit" class="btn btn-info btn-sm" title="Edit Profile">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center mb-4 mb-md-0">
                                    @php
                                        $color = App\Models\Color::where('user_id', $auth->id)
                                            ->select('profile_color')
                                            ->first();
                                        $userInfo = $userInfo[0] ?? null;
                                        $profileColor = $color?->profile_color ?? '#007bff';
                                    @endphp
                                    <div class="profile-circle-admin mx-auto"
                                        style="background-color: {{ $profileColor }}; width: 120px; height: 120px;">
                                        <span id="admin-name-profile" class="display-4 text-white">
                                            {{ substr($userInfo->name ?? 'A', 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">Click a row in the admin list to view details</small>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <form id="adminForm">
                                        <input type="hidden" id="id" value="{{ $userInfo->id ?? '' }}">
                                        <div class="mb-3">
                                            <label for="dname" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="dname"
                                                value="{{ $userInfo->name ?? '' }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="demail" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="demail"
                                                value="{{ $userInfo->email ?? '' }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="drole" class="form-label">Role</label>
                                            <input type="text" class="form-control" id="drole"
                                                value="{{ isset($userInfo->role) ? ($userInfo->role == 'S' ? 'SuperAdmin' : 'Administrator') : '' }}"
                                                disabled>
                                        </div>

                                        <div id="btn-box" class="d-flex gap-2 mt-4" style="display: none !important;">
                                            <button type="button" class="btn btn-secondary" id="cancel">Cancel</button>
                                            <button type="button" id="cpassbtn" data-id="{{ $userInfo->id ?? '' }}"
                                                data-bs-toggle="modal" data-bs-target="#changepass" class="btn btn-warning">
                                                <i class="fas fa-key"></i> Change Password
                                            </button>
                                            <button type="submit" class="btn btn-primary" id="submit">
                                                <i class="fas fa-save"></i> Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Administrator List Card -->
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Administrator List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="admin-table" class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($users && count($users) > 0)
                                            @foreach ($users as $key => $user)
                                                <tr data-id="{{ $user->id }}" class="cursor-pointer">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-circle-sm mr-2"
                                                                style="background-color: #{{ substr(md5($user->email), 0, 6) }}">
                                                                {{ substr($user->name, 0, 1) }}
                                                            </div>
                                                            {{ $user->name }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        @if ($user->role == 'S')
                                                            <span class="badge bg-danger">SuperAdmin</span>
                                                        @else
                                                            <span class="badge bg-info">Administrator</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">
                                                    No administrators found
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Create Admin Modal -->
    <div class="modal fade" id="createAdmin" tabindex="-1" aria-labelledby="createAdminLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="createAdminLabel">
                        <i class="fas fa-user-shield me-2"></i>Create Administrator Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ action([App\Http\Controllers\UsersController::class, 'store']) }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="role" value="S">

                        <div class="mb-3">
                            <label for="name" class="form-label">Administrator Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="eg: admin@example.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter Password" required id="password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Password must be at least 6 characters long</small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Retype Password" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="reset" class="btn btn-warning">Clear</button>
                        <button type="submit" class="btn btn-primary">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changepass" tabindex="-1" aria-labelledby="changepassLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="changepassLabel">
                        <i class="fas fa-key me-2"></i>Change Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cpass-form">
                        <input type="hidden" id="cpid" value="">

                        <div class="mb-3">
                            <label for="cpassword" class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" id="cpassword" name="current_password" class="form-control"
                                    required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small id="cpassword_error" class="text-danger"></small>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input id="new_password" type="password" class="form-control" name="new_password"
                                    required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small id="new_pass_error" class="text-danger"></small>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input id="confirm_password" type="password" class="form-control"
                                    name="confirm_password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="match-pass" class="mt-1"></div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning" id="submit-password">
                                <i class="fas fa-sync-alt me-1"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        .cursor-pointer:hover {
            background-color: #f5f5f5 !important;
        }

        .profile-circle-admin {
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .avatar-circle-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        .table tr.selected {
            background-color: #e3f2fd !important;
        }

        .input-group-text {
            cursor: pointer;
        }

        .badge {
            font-size: 0.85em;
            padding: 0.35em 0.65em;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#admin-table').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 10,
                "order": [
                    [0, 'asc']
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-chevron-left'></i>",
                        "next": "<i class='fas fa-chevron-right'></i>"
                    }
                }
            });

            // Row click event for admin table
            $("#admin-table tbody").on("click", "tr", function() {
                // Remove selection from all rows
                $("#admin-table tbody tr").removeClass('selected');
                // Add selection to clicked row
                $(this).addClass('selected');

                var data_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    url: "{{ route('details') }}",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'id': data_id
                    },
                    success: function(response) {
                        $('#dname').val(response.data.name);
                        $('#demail').val(response.data.email);
                        $('#id').val(response.data.id);
                        $('#cpassbtn').data('id', response.data.id);
                        $('#admin-name-profile').text(response.fl);
                        $('#drole').val(response.data.role == 'S' ? 'SuperAdmin' :
                            'Administrator');
                        if (response.color && response.color.profile_color) {
                            $('.profile-circle-admin').css('background-color', response.color
                                .profile_color);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading admin details:", error);
                    }
                });
            });

            // Edit button click
            $("#edit").on('click', function(event) {
                event.preventDefault();
                $('#dname').prop("disabled", false);
                $('#demail').prop("disabled", false);
                $('#btn-box').show();
            });

            // Cancel button click
            $("#cancel").on('click', function(event) {
                event.preventDefault();
                $('#dname').prop("disabled", true);
                $('#demail').prop("disabled", true);
                $('#btn-box').hide();
            });

            // Admin form submission
            $('#adminForm').on('submit', function(event) {
                event.preventDefault();
                let id = $('#id').val();
                let name = $('#dname').val();
                let email = $('#demail').val();

                if (!id || !name || !email) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please select an administrator first!',
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('updateAdmin') }}",
                    type: "POST",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': id,
                        'name': name,
                        'email': email,
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Admin details have been updated successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Something went wrong!'
                        });
                    }
                });
            });

            // Password change form
            $("#cpassbtn").on('click', function() {
                let id = $(this).data('id');
                if (!id) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Please select an administrator first!',
                    });
                    return false;
                }
                $('#cpid').val(id);
            });

            $('#cpass-form').on('submit', function(event) {
                event.preventDefault();
                let current_pass = $('#cpassword').val();
                let password = $('#new_password').val();
                let password_confirmation = $('#confirm_password').val();
                let user_id = $('#cpid').val();

                // Validate passwords match
                if (password !== password_confirmation) {
                    $('#match-pass').html('<span class="text-danger">Passwords do not match!</span>');
                    return;
                }

                // Validate password length
                if (password.length < 6) {
                    $('#new_pass_error').text('Password must be at least 6 characters!');
                    return;
                }

                $.ajax({
                    url: "{{ route('change.password') }}",
                    type: "POST",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'current_password': current_pass,
                        'password': password,
                        'password_confirmation': password_confirmation,
                        'user_id': user_id,
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Password has been changed successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $('#changepass').modal('hide');
                                $('#cpass-form')[0].reset();
                                $('#match-pass').empty();
                                $('#new_pass_error').empty();
                                $('#cpassword_error').empty();
                            });
                        } else {
                            $('#cpassword_error').text(response.message ||
                                'Current password is incorrect!');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Something went wrong!'
                        });
                    }
                });
            });

            // Password match validation
            $('#confirm_password').on('keyup', function() {
                if ($('#new_password').val() == $('#confirm_password').val()) {
                    $('#match-pass').html(
                        '<span class="text-success"><i class="fas fa-check"></i> Passwords match</span>'
                        );
                } else {
                    $('#match-pass').html(
                        '<span class="text-danger"><i class="fas fa-times"></i> Passwords do not match</span>'
                        );
                }
            });

            // New password validation
            $('#new_password').on('blur', function() {
                var npass = $(this).val();
                if (npass.length > 0 && npass.length < 6) {
                    $('#new_pass_error').text('Password must be at least 6 characters long!');
                } else {
                    $('#new_pass_error').empty();
                }
            });

            // Toggle password visibility
            function togglePasswordVisibility(inputId, buttonId) {
                $(buttonId).on('click', function() {
                    const input = $(inputId);
                    const icon = $(this).find('i');
                    if (input.attr('type') === 'password') {
                        input.attr('type', 'text');
                        icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        input.attr('type', 'password');
                        icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });
            }

            // Initialize password toggles
            togglePasswordVisibility('#password', '#togglePassword');
            togglePasswordVisibility('#cpassword', '#toggleCurrentPassword');
            togglePasswordVisibility('#new_password', '#toggleNewPassword');
            togglePasswordVisibility('#confirm_password', '#toggleConfirmPassword');

            // Reset form when modal closes
            $('#changepass').on('hidden.bs.modal', function() {
                $('#cpass-form')[0].reset();
                $('#match-pass').empty();
                $('#new_pass_error').empty();
                $('#cpassword_error').empty();
            });
        });
    </script>
@endpush
