@extends('layouts.admin', [
    'page_header' => 'SUBJECTS',
    'dash' => '',
    'examinees' => '',
    'quiz' => '',
    'users' => '',
    'questions' => 'active',
    'sett' => '',
])

@section('content')
    <div class="container-fluid">
        <!-- Page Header with Action Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Exam Management</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#createModal">
                                    <i class="fas fa-plus-circle"></i> Create Exam
                                </button>
                                <a href="{{ route('export') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-excel"></i> Export Template
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Manage your exams and questions. Click on an exam card to view or edit details.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Exam Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="createModalLabel">
                            <i class="fas fa-plus-circle me-2"></i>Create New Exam
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ action([App\Http\Controllers\TopicController::class, 'store']) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Exam Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" required placeholder="Enter exam title">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="timer" class="form-label">Exam Duration (minutes) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="timer"
                                            class="form-control @error('timer') is-invalid @enderror"
                                            value="{{ old('timer') }}" min="1" required placeholder="e.g., 60">
                                        @error('timer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Time limit in minutes for the exam</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="set" class="form-label">Number of Sets <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="set"
                                            class="form-control @error('set') is-invalid @enderror"
                                            value="{{ old('set', 1) }}" min="1" required>
                                        @error('set')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Different question sets for exam variation</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="10"
                                            placeholder="Enter exam description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create Exam
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Exam Cards Grid -->
        <div class="row">
            @if ($topics && count($topics) > 0)
                @foreach ($topics as $topic)
                    <?php
                    $questionCount = $questions->where('topic_id', $topic->id)->count();
                    $colorClass = match ($topic->id % 6) {
                        1 => 'card-primary',
                        2 => 'card-success',
                        3 => 'card-info',
                        4 => 'card-warning',
                        5 => 'card-danger',
                        default => 'card-secondary',
                    };
                    ?>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 {{ $colorClass }} card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-book me-2"></i>{{ $topic->title }}
                                </h3>
                                <div class="card-tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $topic->id }}" title="Edit Exam">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $topic->id }}" title="Delete Exam">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <i class="fas fa-align-left me-1"></i>
                                    {{ Str::limit($topic->description, 150) }}
                                </p>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="info-box bg-light mb-2">
                                            <span class="info-box-icon">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Questions</span>
                                                <span class="info-box-number">{{ $questionCount }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="info-box bg-light mb-2">
                                            <span class="info-box-icon">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Duration</span>
                                                <span class="info-box-number">{{ $topic->timer }} min</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="info-box bg-light mb-2">
                                            <span class="info-box-icon">
                                                <i class="fas fa-layer-group"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Sets</span>
                                                <span class="info-box-number">{{ $topic->set }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="info-box bg-light mb-2">
                                            <span class="info-box-icon">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Created</span>
                                                <span
                                                    class="info-box-number">{{ $topic->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100">
                                    <a href="{{ route('questions.show', $topic->id) }}" class="btn btn-primary">
                                        <i class="fas fa-eye me-1"></i> View Questions
                                    </a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteAll{{ $topic->id }}">
                                        <i class="fas fa-trash-alt me-1"></i> Clear All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete All Questions Modal -->
                    <div class="modal fade" id="deleteAll{{ $topic->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title text-white">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Delete All Questions
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST"
                                    action="{{ action([App\Http\Controllers\TopicController::class, 'deleteperquizsheet'], $topic->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-trash-alt fa-3x text-danger"></i>
                                        </div>
                                        <h4>Are You Sure?</h4>
                                        <p>You are about to delete <strong>ALL {{ $questionCount }} questions</strong>
                                            from:</p>
                                        <h5 class="text-primary">"{{ $topic->title }}"</h5>
                                        <div class="alert alert-danger mt-3">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>Warning:</strong> This action cannot be undone!
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt me-1"></i> Delete All Questions
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Exam Modal -->
                    <div class="modal fade" id="deleteModal{{ $topic->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title text-white">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Delete Exam
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST"
                                    action="{{ action([App\Http\Controllers\TopicController::class, 'deleteTopic'], $topic->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-trash-alt fa-3x text-danger"></i>
                                        </div>
                                        <h4>Are You Sure?</h4>
                                        <p>You are about to delete the exam:</p>
                                        <h5 class="text-primary">"{{ $topic->title }}"</h5>
                                        <div class="alert alert-warning mt-3">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            <strong>Note:</strong> This will also delete all associated questions
                                            ({{ $questionCount }} questions).
                                        </div>
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>Warning:</strong> This action cannot be undone!
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt me-1"></i> Delete Exam
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Exam Modal -->
                    <div class="modal fade" id="editModal{{ $topic->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h5 class="modal-title text-white">
                                        <i class="fas fa-edit me-2"></i>Edit Exam
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST"
                                    action="{{ action([App\Http\Controllers\TopicController::class, 'update'], $topic->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="title{{ $topic->id }}" class="form-label">Exam Title</label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{ $topic->title }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="timer{{ $topic->id }}" class="form-label">Exam Duration
                                                (minutes)</label>
                                            <input type="number" name="timer" class="form-control"
                                                value="{{ $topic->timer }}" min="1">
                                            <small class="text-muted">Set to 0 for no time limit</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description{{ $topic->id }}"
                                                class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="6">{{ $topic->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-save me-1"></i> Update Exam
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-book fa-4x text-muted"></i>
                            </div>
                            <h4 class="text-muted">No Exams Found</h4>
                            <p class="text-muted">Create your first exam by clicking the "Create Exam" button above.</p>
                            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                <i class="fas fa-plus-circle me-1"></i> Create Your First Exam
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination (if needed) -->
        @if ($topics instanceof \Illuminate\Pagination\LengthAwarePaginator && $topics->hasPages())
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                {{ $topics->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, .1);
        }

        .info-box {
            border-radius: .25rem;
            padding: .5rem;
        }

        .info-box-icon {
            float: left;
            height: 50px;
            width: 50px;
            text-align: center;
            font-size: 1.875rem;
            line-height: 50px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: .25rem;
        }

        .info-box-content {
            margin-left: 60px;
        }

        .info-box-text {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: uppercase;
            font-size: .875rem;
        }

        .info-box-number {
            display: block;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .btn-group .btn {
            border-radius: .25rem !important;
        }

        .modal-content {
            border: none;
            border-radius: .5rem;
        }

        .modal-header {
            border-top-left-radius: .5rem;
            border-top-right-radius: .5rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Form validation for timers
            $('input[name="timer"]').on('blur', function() {
                if ($(this).val() < 1 && $(this).val() !== '') {
                    $(this).val(1);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Duration',
                        text: 'Duration must be at least 1 minute',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });

            // Auto-focus on first input when modal opens
            $('#createModal').on('shown.bs.modal', function() {
                $(this).find('input[name="title"]').focus();
            });

            // Confirm before submitting delete forms
            $('form[action*="delete"]').on('submit', function(e) {
                e.preventDefault();
                var form = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
