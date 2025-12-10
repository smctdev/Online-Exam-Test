@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.Laravel = @json_encode([
            'csrfToken' => csrf_token(),
        ]);
    </script>
@endsection

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center"
        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <!-- Left Column - Illustration/Info -->
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="text-center mb-5">
                        @if ($setting)
                            <a href="{{ url('/') }}" title="{{ $setting->welcome_txt }}" class="text-decoration-none">
                                <img src="{{ asset('images/logo/' . $setting->logo) }}" class="img-fluid mb-4 mx-auto"
                                    style="max-width: 300px;" alt="{{ $setting->welcome_txt }}">
                            </a>
                        @endif
                    </div>
                    <div class="text-center px-5">
                        <h2 class="fw-bold text-primary mb-4">Join Our Community</h2>
                        <div class="row g-4 text-start">
                            <div class="col-12">
                                <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="bi bi-shield-check text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Secure & Reliable</h5>
                                        <p class="text-muted mb-0">Your data is protected with industry-standard encryption
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="bi bi-lightning text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Fast Setup</h5>
                                        <p class="text-muted mb-0">Get started in less than 2 minutes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="bi bi-headset text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">24/7 Support</h5>
                                        <p class="text-muted mb-0">Our team is always here to help you</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Registration Form -->
                <div class="col-lg-5 col-md-8">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body p-5">
                            <!-- Mobile Logo -->
                            <div class="text-center mb-4 d-block d-lg-none">
                                @if ($setting)
                                    <a href="{{ url('/') }}" title="{{ $setting->welcome_txt }}"
                                        class="text-decoration-none">
                                        <img src="{{ asset('images/logo/' . $setting->logo) }}" class="img-fluid mb-3"
                                            style="max-width: 150px;" alt="{{ $setting->welcome_txt }}">
                                    </a>
                                @endif
                            </div>

                            <!-- Header -->
                            <div class="text-center mb-5">
                                <h3 class="fw-bold text-primary">Create Account</h3>
                                <p class="text-muted">Fill in your details to get started</p>
                            </div>

                            <!-- Registration Form -->
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Name Field -->
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-person text-muted"></i>
                                        </span>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            class="form-control form-control-lg border-start-0 @error('name') is-invalid @enderror"
                                            placeholder="Enter your full name" required autocomplete="name" autofocus>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-envelope text-muted"></i>
                                        </span>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                            class="form-control form-control-lg border-start-0 @error('email') is-invalid @enderror"
                                            placeholder="eg: john@example.com" required autocomplete="email">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-lg border-start-0 @error('password') is-invalid @enderror"
                                            placeholder="Create a strong password" required autocomplete="new-password">
                                        <button class="btn btn-outline-secondary border-start-0" type="button"
                                            id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirm
                                        Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock-fill text-muted"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control form-control-lg border-start-0 @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Confirm your password" required autocomplete="new-password">
                                        <button class="btn btn-outline-secondary border-start-0" type="button"
                                            id="toggleConfirmPassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Terms & Conditions -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label text-muted" for="terms">
                                            I agree to the <a href="#" class="text-decoration-none">Terms &
                                                Conditions</a> and <a href="#" class="text-decoration-none">Privacy
                                                Policy</a>
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg fw-semibold py-3">
                                        <i class="bi bi-person-plus me-2"></i>Create Account
                                    </button>
                                </div>

                                <!-- Login Link -->
                                <div class="text-center">
                                    <p class="text-muted mb-0">
                                        Already have an account?
                                        <a href="{{ route('login') }}"
                                            class="text-decoration-none fw-semibold text-primary">Sign in</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Toggle password visibility
            function togglePasswordVisibility(fieldId, buttonId) {
                $(buttonId).click(function() {
                    const field = $(fieldId);
                    const icon = $(this).find('i');

                    if (field.attr('type') === 'password') {
                        field.attr('type', 'text');
                        icon.removeClass('bi-eye').addClass('bi-eye-slash');
                    } else {
                        field.attr('type', 'password');
                        icon.removeClass('bi-eye-slash').addClass('bi-eye');
                    }
                });
            }

            togglePasswordVisibility('#password', '#togglePassword');
            togglePasswordVisibility('#password_confirmation', '#toggleConfirmPassword');

            // Password strength indicator
            $('#password').on('input', function() {
                const password = $(this).val();
                const strengthBar = $('#passwordStrength');
                const hint = $('#passwordHint');

                let strength = 0;
                let hintText = '';

                // Check password criteria
                if (password.length >= 8) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 25;
                if (/[^A-Za-z0-9]/.test(password)) strength += 25;

                // Update progress bar
                strengthBar.css('width', strength + '%');

                // Update colors and hint text
                if (strength < 25) {
                    strengthBar.removeClass('bg-success bg-warning').addClass('bg-danger');
                    hintText = 'Very weak';
                } else if (strength < 50) {
                    strengthBar.removeClass('bg-success bg-danger').addClass('bg-warning');
                    hintText = 'Weak';
                } else if (strength < 75) {
                    strengthBar.removeClass('bg-success bg-danger').addClass('bg-warning');
                    hintText = 'Good';
                } else {
                    strengthBar.removeClass('bg-warning bg-danger').addClass('bg-success');
                    hintText = 'Strong';
                }

                hint.text(hintText);
            });

            // Confirm password validation
            $('#password_confirmation').on('input', function() {
                const password = $('#password').val();
                const confirmPassword = $(this).val();

                if (confirmPassword && password !== confirmPassword) {
                    $(this).addClass('is-invalid');
                    $(this).removeClass('is-valid');
                } else if (confirmPassword) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                } else {
                    $(this).removeClass('is-invalid is-valid');
                }
            });

            // Form validation styles
            $('input').on('blur', function() {
                if ($(this).val().trim() !== '' && !$(this).hasClass('is-invalid')) {
                    $(this).addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid');
                }
            });

            // Form submission validation
            $('form').on('submit', function(e) {
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();

                if (password !== confirmPassword) {
                    e.preventDefault();
                    $('#password_confirmation').addClass('is-invalid');
                    alert('Passwords do not match!');
                }
            });
        });
    </script>

    <style>
        .card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .input-group-text {
            transition: all 0.3s;
        }

        .input-group:focus-within .input-group-text {
            background-color: #e3f2fd;
            border-color: #0d6efd;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            border: none;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .bg-primary.bg-opacity-10 {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }

        /* Password strength indicator */
        .progress {
            background-color: #e9ecef;
        }

        .progress-bar {
            transition: width 0.3s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 2rem !important;
            }

            .container {
                padding: 1rem;
            }

            .row.g-4>.col-12 {
                padding: 0.5rem;
            }
        }

        /* Animation for form elements */
        .form-group {
            animation: fadeInUp 0.5s ease-out;
            animation-fill-mode: both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stagger animations */
        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.4s;
        }

        .form-group:nth-child(5) {
            animation-delay: 0.5s;
        }
    </style>
@endsection
