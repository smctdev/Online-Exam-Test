@extends('layouts.app')

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <!-- Main Card -->
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <!-- Header Section -->
                        <div class="card-header bg-primary text-white py-4 border-0">
                            <div class="text-center">
                                <img src="{{ asset('images/logo/logo.png') }}" class="img-fluid mb-3 mx-auto"
                                    style="max-height: 80px;" alt="Logo">
                                <h1 class="display-5 fw-bold mb-0">{{ ucwords($topic->title) }}</h1>
                            </div>
                        </div>

                        <!-- Body Section -->
                        <div class="card-body p-4 p-lg-5">
                            <!-- Description (if exists) -->
                            @if ($topic->description)
                                <div class="alert alert-info border-0 bg-light mb-5">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-info-circle text-primary fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fw-semibold mb-2">Description</h5>
                                            <p class="mb-0">{{ ucfirst($topic->description) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Exam Details -->
                            <div class="row justify-content-center mb-5">
                                <div class="col-12">
                                    <div class="card border-0 bg-light shadow-sm">
                                        <div class="card-body p-4">
                                            <h4 class="fw-bold text-center text-primary mb-4">
                                                <i class="bi bi-card-checklist me-2"></i>
                                                Exam Details
                                            </h4>

                                            <div class="table-responsive">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="py-3 border-bottom p-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                                        <i class="bi bi-clock text-warning fs-5"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="fw-semibold mb-1">Time Allotted</h6>
                                                                        <p class="text-muted mb-0">Total duration for this
                                                                            exam</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="py-3 border-bottom text-end p-2">
                                                                <span
                                                                    class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3 py-2 fs-6">
                                                                    <strong>{{ $topic->timer }} minutes</strong>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="py-3 p-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                                        <i class="bi bi-file-text text-info fs-5"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="fw-semibold mb-1">Total Questions</h6>
                                                                        <p class="text-muted mb-0">Number of questions to
                                                                            answer</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="py-3 text-end p-2">
                                                                <span
                                                                    class="badge bg-info bg-opacity-10 text-info border border-info px-3 py-2 fs-6">
                                                                    <strong>{{ $topic->question_count }} items</strong>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Important Instructions -->
                            <div class="alert alert-warning border-0 mb-5">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-exclamation-triangle-fill text-warning fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="fw-semibold mb-2">Important Instructions</h5>
                                        <ul class="mb-0">
                                            <li>Time cannot be paused once the exam starts</li>
                                            <li>Ensure stable internet connection</li>
                                            <li>Do not refresh or close the browser during exam</li>
                                            <li>All answers are auto-saved</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Start Button -->
                            <div class="text-center">
                                <a href="{{ route('aptitude_exam', [$topic->slug, 'exam_id' => Session::get('userID')]) }}"
                                    class="btn btn-warning btn-lg fw-semibold px-5 py-3 shadow-sm">
                                    <i class="bi bi-play-circle me-2"></i>
                                    Start Exam Now
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </a>

                                <!-- Back Button -->
                                <div class="mt-4">
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-arrow-left me-1"></i>
                                        Back to Instructions
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card border-0 bg-white shadow-sm h-100">
                                <div class="card-body text-center p-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 60px; height: 60px;">
                                        <i class="bi bi-shield-check text-primary fs-4"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-2">Secure Exam</h6>
                                    <p class="text-muted small mb-0">Protected environment</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 bg-white shadow-sm h-100">
                                <div class="card-body text-center p-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 60px; height: 60px;">
                                        <i class="bi bi-clock-history text-success fs-4"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-2">Timed</h6>
                                    <p class="text-muted small mb-0">{{ $topic->timer }} minutes limit</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 bg-white shadow-sm h-100">
                                <div class="card-body text-center p-3">
                                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 60px; height: 60px;">
                                        <i class="bi bi-question-circle text-info fs-4"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-2">Questions</h6>
                                    <p class="text-muted small mb-0">{{ $topic->question_count }} items total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="startExamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Ready to Start?
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-clock text-warning fs-1"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Time starts immediately!</h5>
                        <p class="text-muted">Once you click "Start Now", the {{ $topic->timer }}-minute timer will begin.
                        </p>
                    </div>

                    <div class="alert alert-info border-0 bg-light">
                        <h6 class="fw-semibold mb-2">Final Checklist:</h6>
                        <ul class="mb-0">
                            <li>Stable internet connection</li>
                            <li>Undisturbed environment</li>
                            <li>Browser notifications enabled</li>
                            <li>No other applications running</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left me-1"></i>Review Again
                    </button>
                    <a href="{{ route('aptitude_exam', [$topic->slug, 'exam_id' => Session::get('userID')]) }}"
                        class="btn btn-warning fw-semibold">
                        <i class="bi bi-play-circle me-2"></i>Start Exam Now
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Intercept start exam button click
            $('.btn-warning.btn-lg').on('click', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');

                // Show confirmation modal
                const modal = new bootstrap.Modal(document.getElementById('startExamModal'));
                modal.show();

                // Update modal start button URL
                $('#startExamModal .btn-warning').attr('href', url);
            });

            // Countdown timer display
            const totalMinutes = {{ $topic->timer }};
            const totalSeconds = totalMinutes * 60;

            function formatTime(seconds) {
                const hrs = Math.floor(seconds / 3600);
                const mins = Math.floor((seconds % 3600) / 60);
                const secs = seconds % 60;

                if (hrs > 0) {
                    return `${hrs}h ${mins}m`;
                }
                return `${mins}m ${secs}s`;
            }

            // Update time display
            $('.badge.bg-warning').append(` <small>(${formatTime(totalSeconds)})</small>`);

            // Add animation to start button
            const startBtn = $('.btn-warning.btn-lg');
            startBtn.hover(
                function() {
                    $(this).css({
                        'transform': 'scale(1.05)',
                        'transition': 'all 0.3s'
                    });
                },
                function() {
                    $(this).css('transform', 'scale(1)');
                }
            );

            // Add pulse animation every 10 seconds
            setInterval(function() {
                startBtn.addClass('pulse-animation');
                setTimeout(function() {
                    startBtn.removeClass('pulse-animation');
                }, 1000);
            }, 10000);

            // Keyboard shortcut for starting exam (Space/Enter)
            $(document).on('keydown', function(e) {
                if ((e.key === ' ' || e.key === 'Enter') && !$('input:focus, textarea:focus').length) {
                    e.preventDefault();
                    $('.btn-warning.btn-lg').click();
                }
            });

            // Show loading when starting exam
            $('#startExamModal .btn-warning').on('click', function() {
                const btn = $(this);
                const originalHtml = btn.html();

                btn.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Loading Exam...
            `);

                // Redirect after a short delay to show loading state
                setTimeout(() => {
                    window.location.href = btn.attr('href');
                }, 500);
            });
        });
    </script>

    <style>
        .card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
        }

        .card-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        }

        /* Background opacity utilities */
        .bg-primary.bg-opacity-10 {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }

        .bg-warning.bg-opacity-10 {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .bg-info.bg-opacity-10 {
            background-color: rgba(13, 202, 240, 0.1) !important;
        }

        .bg-success.bg-opacity-10 {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        /* Button styling */
        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
            border: none;
            color: #212529;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #ffca2c 0%, #ffcd39 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);
            color: #212529;
        }

        /* Badge styling */
        .badge {
            font-weight: 600;
            border-width: 1px;
            border-style: solid;
        }

        /* Table styling */
        .table-borderless td {
            padding: 1rem 0;
        }

        /* Alert styling */
        .alert {
            border-radius: 12px;
            border: none;
        }

        /* Pulse animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
            }
        }

        .pulse-animation {
            animation: pulse 1s;
        }

        /* Modal styling */
        .modal-content {
            border-radius: 20px;
            overflow: hidden;
        }

        /* Feature cards */
        .card.h-100 {
            transition: all 0.3s;
        }

        .card.h-100:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .display-5 {
                font-size: 2rem;
            }

            .card-body {
                padding: 1.5rem !important;
            }

            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1.1rem;
            }

            .row.mt-4 .col-md-4 {
                margin-bottom: 1rem;
            }
        }

        /* Smooth transitions */
        .card,
        .btn,
        .badge,
        .alert {
            transition: all 0.3s ease;
        }
    </style>
@endpush
