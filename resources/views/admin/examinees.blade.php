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
        <!-- Page header with button -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Examinees Management</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                <i class="fas fa-user-plus"></i> Add Examinee
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($auth->role == 'S')
            <!-- Examinees Table Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Examinees</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#AllDeleteModal">
                            <i class="fas fa-trash"></i> Delete All
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Position Applied</th>
                                    <th>Exam Started</th>
                                    <th>Exam End</th>
                                    <th>Exam Sent On</th>
                                    <th>Exam Sent By</th>
                                    <th>Exam Status</th>
                                    <th>Added On</th>
                                    <th>Added By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users)
                                    @foreach ($users as $key => $user)
                                        <?php
                                        $exam = \DB::table('exam')->where('user_id', $user->id)->first();
                                        ?>
                                        <tr>
                                            <td><strong>{{ strtoupper($user->name) }}</strong></td>
                                            <td>{{ $user->applied_position }}</td>
                                            <td>
                                                @if (!empty($exam))
                                                    <span class="badge bg-info">{{ $exam->started_at }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Not Started</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($exam))
                                                    <span class="badge bg-info">{{ $exam->end_at }}</span>
                                                @else
                                                    <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($exam))
                                                    <span class="badge bg-info">{{ $exam->created_at }}</span>
                                                @else
                                                    <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($exam))
                                                    {{ $exam->sent_by }}
                                                @else
                                                    <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (empty($user->status))
                                                    <span class="badge bg-warning">Link not sent</span>
                                                @elseif ($user->status == 'sent')
                                                    <span class="badge bg-primary">Pending</span>
                                                @elseif ($user->status == 'retry')
                                                    <span class="badge bg-info">Retrying</span>
                                                @elseif ($user->status == 'progress')
                                                    <span class="badge bg-secondary">In Progress</span>
                                                @elseif ($user->status == 'finish')
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-danger">Violated Rules</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>{{ $user->added_by }}</td>
                                            <td>
                                                <?php
                                                $user_has_result = \DB::table('result')->where('user_id', $user->id)->first();
                                                $user_has_essay = \DB::table('essay')->where('user_id', $user->id)->first();
                                                ?>

                                                <div class="dropdown">
                                                    <button class="btn btn-outline-primary btn-sm" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        @if ($user->status !== 'violator' && $user->status !== 'retry')
                                                            @if (empty($user_has_result) && empty($user_has_essay))
                                                                <li>
                                                                    <button type="button"
                                                                        class="dropdown-item text-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#chooseTopic-{{ $user->id }}">
                                                                        <i class="fas fa-envelope me-2"></i>
                                                                        Invite Exam
                                                                    </button>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <a class="dropdown-item text-primary"
                                                                        href="{{ route('exam.result', ['id' => $user->id]) }}">
                                                                        <i class="fas fa-file me-2"></i>
                                                                        Exam Result
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endif

                                                        <li>
                                                            <button type="button" class="dropdown-item text-info"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal-{{ $user->id }}">
                                                                <i class="fas fa-edit me-2"></i>
                                                                Edit
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button type="button" class="dropdown-item text-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal-{{ $user->id }}">
                                                                <i class="fas fa-trash me-2"></i>
                                                                Remove
                                                            </button>
                                                        </li>

                                                        @if ($user->result || $user->status === 'violator')
                                                            <li>
                                                                <button type="button" class="dropdown-item text-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#retryModal-{{ $user->id }}">
                                                                    <i class="fas fa-history me-2"></i>
                                                                    Retry
                                                                </button>
                                                            </li>
                                                        @endif

                                                        <!-- Optional: Add divider if needed -->
                                                        {{-- @if ($user->status !== 'violator' && $user->status !== 'retry' && ($user->result || $user->status === 'violator'))
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fas fa-eye me-2"></i>
                                                                    View Profile
                                                                </a>
                                                            </li>
                                                        @endif --}}
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        @endif
    </div>

    <!-- All Delete Modal -->
    <div class="modal fade" id="AllDeleteModal" tabindex="-1" aria-labelledby="AllDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="AllDeleteModalLabel">Confirm Delete All</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                    </div>
                    <h4>Are You Sure?</h4>
                    <p>Do you really want to delete <strong>ALL examinees</strong>? This process cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('destroy-all-examinees') }}">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete All</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="createModalLabel">Add New Examinee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('store-admin') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="role" value="E">
                                <input type="hidden" name="auth" value="{{ $auth->name }}">

                                <div class="mb-3">
                                    <label for="name" class="form-label">Examinee Name <span
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
                                        placeholder="eg: info@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile No. <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="mobile" value="{{ old('mobile') }}"
                                        class="form-control @error('mobile') is-invalid @enderror"
                                        placeholder="+639xxxxxxxxx" required>
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="applied_position" class="form-label">Position Applied <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="applied_position" value="{{ old('applied_position') }}"
                                        class="form-control @error('applied_position') is-invalid @enderror"
                                        placeholder="Position Applied" required>
                                    @error('applied_position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3"
                                        placeholder="Enter Address">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-primary">Add Examinee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals for each user (placed at the end for better organization) -->
    @if ($users)
        @foreach ($users as $user)
            <!-- Delete Modal for {{ $user->id }} -->
            <div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title">Delete Examinee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-trash fa-3x text-danger"></i>
                            </div>
                            <h4>Are You Sure?</h4>
                            <p>Do you really want to delete <strong>{{ $user->name }}</strong>? This process cannot be
                                undone.</p>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="{{ route('delete-examinees', $user->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Retry Modal for {{ $user->id }} -->
            <div class="modal fade" id="retryModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title">Retry Exam</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-redo fa-3x text-warning"></i>
                            </div>
                            <h4>Are You Sure?</h4>
                            <p>Do you really want to make <strong>{{ $user->name }}</strong> retry the exam?</p>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                <strong>Warning:</strong> Past exams and records of this examinee will be deleted/cleared.
                            </div>
                            <p class="text-muted">This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="{{ route('retry.exam', $user->id) }}">
                                @csrf
                                @method('POST')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning">Retry Exam</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Choose Topic Modal for {{ $user->id }} -->
            <div class="modal fade" id="chooseTopic-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title">Select Examination Topics</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form method="POST"
                            action="{{ route('send.invite', [$user->token, $user->name, $user->email, $user->id]) }}">
                            @csrf
                            <div class="modal-body">
                                <p>Select topics for <strong>{{ $user->name }}</strong>:</p>
                                <input type="hidden" name="auth" value="{{ $auth->name }}">
                                <div class="mb-3">
                                    @foreach ($topics as $subject)
                                        <div class="form-check mb-2">
                                            <input type="checkbox" name="sub{{ $subject->id }}"
                                                value="{{ $subject->id }}" class="form-check-input exambox"
                                                id="sub{{ $subject->id }}_{{ $user->id }}">
                                            <label class="form-check-label"
                                                for="sub{{ $subject->id }}_{{ $user->id }}">
                                                {{ $subject->title }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" id="sendinvite{{ $user->id }}"
                                    disabled>
                                    <i class="fas fa-paper-plane"></i> Send Invite
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Modal for {{ $user->id }} -->
            <div class="modal fade" id="editModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title">Edit Examinee Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('dashboard.update', $user->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="id" value="{{ $user->id }}">

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                                class="form-control @error('name') is-invalid @enderror" required
                                                placeholder="Enter Name">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="form-control @error('email') is-invalid @enderror" required
                                                placeholder="eg: info@example.com">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="mobile" class="form-label">Mobile No.</label>
                                            <input type="text" name="mobile"
                                                value="{{ old('mobile', $user->mobile) }}"
                                                class="form-control @error('mobile') is-invalid @enderror"
                                                placeholder="+639xxxxxxxxx">
                                            @error('mobile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="applied_position" class="form-label">Position Applied <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="applied_position"
                                                value="{{ old('applied_position', $user->applied_position) }}"
                                                class="form-control @error('applied_position') is-invalid @enderror"
                                                required placeholder="Position Applied">
                                            @error('applied_position')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3"
                                                placeholder="Enter Address">{{ old('address', $user->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-info">Update Information</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const userId = "{{ $user->id }}";
                    const button = document.getElementById(`sendinvite${userId}`);
                    const checkboxes = document.querySelectorAll(`.exambox[id^="sub"][id$="_${userId}"]`);

                    function toggleButton() {
                        button.disabled = !Array.from(checkboxes).some(cb => cb.checked);
                    }

                    checkboxes.forEach(cb => cb.addEventListener('change', toggleButton));
                });
            </script>
        @endforeach
    @endif

    <script>
        $(function() {
            // Initialize DataTable
            $('#example1').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "order": [
                    [0, 'asc']
                ],
                "pageLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-chevron-left'></i>",
                        "next": "<i class='fas fa-chevron-right'></i>"
                    }
                }
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection

@push('styles')
    <style>
        .badge {
            font-size: 0.85em;
            padding: 0.35em 0.65em;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .modal-header {
            color: white;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endpush
