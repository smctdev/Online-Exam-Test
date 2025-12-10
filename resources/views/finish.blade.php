@extends('layouts.app')

@section('top_bar')
    <nav class="navbar navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/vectors/samp.png') }}" class="img-fluid" alt="{{ $setting->welcome_txt ?? 'Logo' }}"
                    style="height: 40px;">
            </a>
        </div>
    </nav>
@endsection

@section('content')
    <div class="min-vh-100 bg-light">
        @if (Auth::user()?->status === 'finish')
            <!-- Success Modal -->
            <div class="modal fade show d-block" id="successModal" tabindex="-1" style="background: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-body p-0">
                            <!-- Success Illustration -->
                            <div class="text-center p-5 bg-success bg-opacity-10">
                                <div class="mb-4">
                                    <div class="position-relative d-inline-block">
                                        <div class="bg-success rounded-circle p-3">
                                            <i class="bi bi-check-lg text-white" style="font-size: 2.5rem;"></i>
                                        </div>
                                        <div class="position-absolute top-0 start-100 translate-middle">
                                            <div class="bg-white rounded-circle p-2 border border-success">
                                                <i class="bi bi-flag-fill text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-success mb-3">Assessment Completed!</h3>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('images/vectors/finish.png') }}" class="img-fluid mb-4 mx-auto"
                                        alt="Completed" style="max-height: 150px;">
                                </div>

                                <div class="text-center">
                                    <p class="text-muted mb-4">
                                        We have successfully received your submission. Our team will review your
                                        application and contact you if there are positive results.
                                    </p>

                                    <div class="alert alert-light border mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-info-circle text-primary me-3 fs-4"></i>
                                            <div class="text-start">
                                                <small class="fw-bold d-block">Important Note</small>
                                                <small class="text-muted">Please check your email regularly for
                                                    updates.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-success w-100 py-3 rounded-pill"
                                        onclick="window.location.href='/'">
                                        <i class="bi bi-house-door me-2"></i>
                                        Return to Homepage
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Prevent closing modal by clicking outside
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = document.getElementById('successModal');

                    // Auto redirect after 15 seconds
                    setTimeout(function() {
                        window.location.href = '/';
                    }, 15000);

                    // Close on escape key (optional)
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            window.location.href = '/';
                        }
                    });
                });
            </script>
        @else
            <!-- Normal Content -->
            <div class="container py-5">
                <div class="text-center py-5">
                    <h1 class="display-5 fw-bold mb-4">Welcome to Assessment System</h1>
                    <p class="lead text-muted mb-4">
                        Complete your assessment to proceed with your application.
                    </p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Login to Continue
                        </a>
                        <a href="/register" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-person-plus me-2"></i>
                            Register
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .modal-content {
            border-radius: 20px;
            overflow: hidden;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .btn-success {
            background: linear-gradient(to right, #28a745, #20c997);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
        }

        .rounded-pill {
            border-radius: 50rem !important;
        }
    </style>
@endsection
