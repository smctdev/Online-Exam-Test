@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.Laravel = @json_encode([
            'csrfToken' => csrf_token(),
        ]);
    </script>
@endsection

@section('top_bar')
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            @if ($setting)
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}"
                    title="{{ $setting->welcome_txt }}">
                    @if ($setting->logo)
                        <img src="{{ asset('images/logo/' . $setting->logo) }}" class="img-fluid me-2"
                            style="max-height: 30px;" alt="{{ $setting->welcome_txt }}">
                    @endif
                    <h4 class="fw-bold text-primary mb-0">{{ $setting->welcome_txt }}</h4>
                </a>
            @endif

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}" title="Login">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}" title="Register">
                                <i class="bi bi-person-plus me-1"></i>Register
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('how-it-works') }}">
                                <i class="bi bi-info-circle me-1"></i>How it works
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('about-us') }}">
                                <i class="bi bi-building me-1"></i>About us
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px;">
                                    <span class="text-white fw-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                @if ($auth->role == 'A')
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/admin') }}" title="Dashboard">
                                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                        </a>
                                    </li>
                                @elseif ($auth->role == 'S')
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/admin/my_reports') }}" title="Dashboard">
                                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('how-it-works') }}">How it works</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('about-us') }}">About us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('faq.get') }}">
                                <i class="bi bi-question-circle me-1"></i>FAQ
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center"
        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container py-5">
            @if (Session::has('error'))
                <div class="row justify-content-center mb-4">
                    <div class="col-md-6 col-lg-5">
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-header bg-primary text-white py-4 border-0">
                            <div class="text-center">
                                @if ($setting)
                                    <a href="{{ url('/') }}" title="{{ $setting->welcome_txt }}"
                                        class="text-decoration-none">
                                        <img src="{{ asset('images/logo/' . $setting->logo) }}" class="img-fluid mb-3 mx-auto"
                                            style="max-height: 60px;"
                                            alt="{{ $setting->welcome_txt }}">
                                    </a>
                                @endif
                                <h3 class="fw-bold mb-0">Reset Your Password</h3>
                                <p class="mb-0 opacity-75">Enter your email to receive a reset link</p>
                            </div>
                        </div>

                        <div class="card-body p-5">
                            <!-- Success Message -->
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4"
                                    role="alert">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                                            <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-1">Email Sent Successfully!</h6>
                                            <p class="mb-0">{{ session('status') }}</p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Instructions -->
                            <div class="alert alert-info border-0 bg-light mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-info-circle text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0">Enter the email address associated with your account and we'll
                                            send you a link to reset your password.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Reset Form -->
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-1"></i>Email Address
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-envelope-at text-muted"></i>
                                        </span>
                                        <input id="email" type="email"
                                            class="form-control form-control-lg border-start-0 @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}"
                                            placeholder="Enter your email address" required autocomplete="email"
                                            autofocus>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg fw-semibold py-3">
                                        <i class="bi bi-send me-2"></i>Send Reset Link
                                    </button>
                                </div>

                                <!-- Alternative Options -->
                                <div class="text-center mb-4">
                                    <p class="text-muted mb-2">Remember your password?</p>
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-arrow-left me-1"></i>Back to Login
                                    </a>
                                </div>
                            </form>

                            <!-- Security Note -->
                            <div class="border-top pt-4 mt-4">
                                <div class="d-flex align-items-start">
                                    <div class="bg-light p-2 rounded-circle me-3">
                                        <i class="bi bi-shield-check text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-2">Security Information</h6>
                                        <p class="text-muted small mb-0">
                                            The reset link will expire in 60 minutes. If you don't see the email, check your
                                            spam folder.
                                        </p>
                                    </div>
                                </div>
                            </div>
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
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

            // Form validation
            $('form').on('submit', function(e) {
                const email = $('#email').val();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    $('#email').addClass('is-invalid');

                    const alertDiv = $(
                        '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">' +
                        '<i class="bi bi-exclamation-triangle me-2"></i>Please enter a valid email address!' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>');

                    $('.card-body').prepend(alertDiv);

                    setTimeout(function() {
                        alertDiv.alert('close');
                    }, 5000);
                }
            });

            // Real-time email validation
            $('#email').on('input', function() {
                const email = $(this).val();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email.length > 0) {
                    if (emailRegex.test(email)) {
                        $(this).removeClass('is-invalid').addClass('is-valid');
                    } else {
                        $(this).addClass('is-invalid').removeClass('is-valid');
                    }
                } else {
                    $(this).removeClass('is-invalid is-valid');
                }
            });

            // Add loading state to submit button
            $('form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true);
                submitBtn.html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending...'
                    );
            });

            // Remove loading state if form validation fails
            $('form').on('submit', function(e) {
                if ($(this).find('.is-invalid').length > 0) {
                    e.preventDefault();
                    const submitBtn = $(this).find('button[type="submit"]');
                    submitBtn.prop('disabled', false);
                    submitBtn.html('<i class="bi bi-send me-2"></i>Send Reset Link');
                }
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

        .navbar {
            background: white !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .btn-outline-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(13, 110, 253, 0.2);
        }

        /* Success alert styling */
        .alert-success .bg-opacity-10 {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        /* Info alert styling */
        .alert-info {
            background-color: rgba(13, 110, 253, 0.05);
            border-left: 4px solid #0d6efd;
        }

        /* User avatar in navbar */
        .bg-primary.rounded-circle {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        }

        /* Dropdown menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 10px;
        }

        .dropdown-item {
            border-radius: 5px;
            margin: 2px 5px;
            padding: 8px 12px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        /* Animation for form */
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

        .card {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Success/Error states */
        .is-valid {
            border-color: #198754 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .is-invalid {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 2rem !important;
            }

            .container.py-5 {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }

            .navbar-brand h4 {
                font-size: 1.1rem;
            }

            .card-header {
                padding: 1.5rem !important;
            }
        }

        /* Smooth transitions */
        .form-control,
        .btn,
        .alert,
        .input-group-text {
            transition: all 0.3s ease;
        }

        /* Spinner animation */
        .spinner-border {
            vertical-align: middle;
        }
    </style>
@endsection
