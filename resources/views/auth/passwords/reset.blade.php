@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('top_bar')
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            @if ($setting)
                <a class="navbar-brand" href="{{ url('/') }}" title="{{ $setting->welcome_txt }}">
                    <img src="{{ asset('images/logo/' . $setting->logo) }}" class="img-fluid" style="max-height: 40px;"
                        alt="{{ $setting->welcome_txt }}">
                </a>
            @endif

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}" title="Login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}" title="Register">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('how-it-works') }}">How it works</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('about-us') }}">About us</a>
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
                                    <li><a class="dropdown-item" href="{{ url('/admin') }}" title="Dashboard">
                                            <i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                                    </li>
                                @elseif ($auth->role == 'S')
                                    <li><a class="dropdown-item" href="{{ url('/admin/my_reports') }}" title="Dashboard">
                                            <i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
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
                            <a class="nav-link" href="{{ route('faq.get') }}">FAQ</a>
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
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body p-5">
                            <!-- Logo -->
                            <div class="text-center mb-4">
                                @if ($setting)
                                    <a href="{{ url('/') }}" title="{{ $setting->welcome_txt }}"
                                        class="text-decoration-none">
                                        <img src="{{ asset('images/logo/' . $setting->logo) }}" class="img-fluid mb-3"
                                            style="max-height: 50px;" alt="{{ $setting->welcome_txt }}">
                                    </a>
                                @endif
                            </div>

                            <!-- Header -->
                            <div class="text-center mb-5">
                                <h3 class="fw-bold text-primary">Reset Password</h3>
                                <p class="text-muted">Enter your new password below</p>
                            </div>

                            <!-- Reset Password Form -->
                            <form method="POST" action="{{ route('password.request') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-envelope text-muted"></i>
                                        </span>
                                        <input id="email" type="email"
                                            class="form-control form-control-lg border-start-0 @error('email') is-invalid @enderror"
                                            name="email" value="{{ $email ?? old('email') }}"
                                            placeholder="Enter your email address" required autofocus
                                            autocomplete="email">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input id="password" type="password"
                                            class="form-control form-control-lg border-start-0 @error('password') is-invalid @enderror"
                                            name="password" placeholder="Enter new password" required
                                            autocomplete="new-password">
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
                                <div class="mb-5">
                                    <label for="password-confirm" class="form-label fw-semibold">Confirm New
                                        Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock-fill text-muted"></i>
                                        </span>
                                        <input id="password-confirm" type="password"
                                            class="form-control form-control-lg border-start-0 @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation" placeholder="Confirm new password" required
                                            autocomplete="new-password">
                                        <button class="btn btn-outline-secondary border-start-0" type="button"
                                            id="toggleConfirmPassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div id="passwordMatch" class="mt-2 d-none">
                                        <small class="text-success">
                                            <i class="bi bi-check-circle-fill me-1"></i>Passwords match
                                        </small>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg fw-semibold py-3">
                                        <i class="bi bi-key me-2"></i>Reset Password
                                    </button>
                                </div>

                                <!-- Back to Login -->
                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="text-decoration-none text-primary">
                                        <i class="bi bi-arrow-left me-1"></i>Back to Login
                                    </a>
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
            // Auto-dismiss alerts
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

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
            togglePasswordVisibility('#password-confirm', '#toggleConfirmPassword');

            // Password strength indicator
            $('#password').on('input', function() {
                const password = $(this).val();
                const strengthBar = $('#passwordStrength');
                const hint = $('#passwordHint');

                // Update requirements icons
                const reqLength = $('#reqLength');
                const reqUppercase = $('#reqUppercase');
                const reqNumber = $('#reqNumber');
                const reqSpecial = $('#reqSpecial');

                let strength = 0;
                let criteriaMet = 0;

                // Check password criteria
                if (password.length >= 8) {
                    strength += 25;
                    criteriaMet++;
                    reqLength.removeClass('text-muted').addClass('text-success');
                } else {
                    reqLength.removeClass('text-success').addClass('text-muted');
                }

                if (/[A-Z]/.test(password)) {
                    strength += 25;
                    criteriaMet++;
                    reqUppercase.removeClass('text-muted').addClass('text-success');
                } else {
                    reqUppercase.removeClass('text-success').addClass('text-muted');
                }

                if (/[0-9]/.test(password)) {
                    strength += 25;
                    criteriaMet++;
                    reqNumber.removeClass('text-muted').addClass('text-success');
                } else {
                    reqNumber.removeClass('text-success').addClass('text-muted');
                }

                if (/[^A-Za-z0-9]/.test(password)) {
                    strength += 25;
                    criteriaMet++;
                    reqSpecial.removeClass('text-muted').addClass('text-success');
                } else {
                    reqSpecial.removeClass('text-success').addClass('text-muted');
                }

                // Update progress bar
                strengthBar.css('width', strength + '%');

                // Update colors and hint text
                if (strength < 25) {
                    strengthBar.removeClass('bg-success bg-warning').addClass('bg-danger');
                    hint.text('Very weak').removeClass('text-success text-warning').addClass('text-danger');
                } else if (strength < 50) {
                    strengthBar.removeClass('bg-success bg-danger').addClass('bg-warning');
                    hint.text('Weak').removeClass('text-success text-danger').addClass('text-warning');
                } else if (strength < 75) {
                    strengthBar.removeClass('bg-success bg-danger').addClass('bg-warning');
                    hint.text('Good').removeClass('text-success text-danger').addClass('text-warning');
                } else {
                    strengthBar.removeClass('bg-warning bg-danger').addClass('bg-success');
                    hint.text('Strong').removeClass('text-warning text-danger').addClass('text-success');
                }

                // Check password match
                checkPasswordMatch();
            });

            // Password match validation
            function checkPasswordMatch() {
                const password = $('#password').val();
                const confirmPassword = $('#password-confirm').val();
                const matchDiv = $('#passwordMatch');

                if (confirmPassword && password === confirmPassword && password.length > 0) {
                    $('#password-confirm').removeClass('is-invalid').addClass('is-valid');
                    matchDiv.removeClass('d-none').addClass('d-block');
                } else if (confirmPassword) {
                    $('#password-confirm').removeClass('is-valid').addClass('is-invalid');
                    matchDiv.removeClass('d-block').addClass('d-none');
                } else {
                    $('#password-confirm').removeClass('is-invalid is-valid');
                    matchDiv.removeClass('d-block').addClass('d-none');
                }
            }

            $('#password-confirm').on('input', checkPasswordMatch);

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
                const confirmPassword = $('#password-confirm').val();

                if (password !== confirmPassword) {
                    e.preventDefault();
                    $('#password-confirm').addClass('is-invalid');
                    const alertDiv = $(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<i class="bi bi-exclamation-triangle me-2"></i>Passwords do not match!' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>');
                    $('.container.py-5').prepend(alertDiv);

                    // Auto-dismiss alert
                    setTimeout(function() {
                        alertDiv.alert('close');
                    }, 5000);
                }
            });
        });
    </script>

    <style>
        .card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
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

        /* Password strength indicator */
        .progress {
            background-color: #e9ecef;
            border-radius: 3px;
        }

        .progress-bar {
            border-radius: 3px;
            transition: width 0.3s ease;
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 2rem !important;
            }

            .container.py-5 {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }

            .navbar-nav {
                padding-top: 1rem;
                padding-bottom: 1rem;
            }

            .nav-item {
                margin: 5px 0;
            }
        }

        /* Animation for password requirements */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card.shadow-sm {
            animation: fadeIn 0.5s ease-out;
        }

        /* Smooth transitions */
        .form-control,
        .btn,
        .alert {
            transition: all 0.3s ease;
        }

        /* Success/Error states */
        .is-valid {
            border-color: #198754 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>
@endsection
