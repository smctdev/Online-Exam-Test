@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center">
        <div class="container">
            @if (Session::has('error'))
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 d-none d-lg-block">
                    <div class="text-center mb-5">
                        <img src="{{ asset('images/vectors/smct logo.png') }}" class="img-fluid mb-4"
                            style="max-width: 600px;" alt="Strong Moto Centrum">
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('images/vectors/loginvector.svg') }}" class="img-fluid" style="max-width: 600px;"
                            alt="Login Illustration">
                    </div>
                </div>

                <div class="col-lg-5 col-md-8">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <h3 class="fw-bold text-primary">Welcome Back</h3>
                                <p class="text-muted">Sign in to your account</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-envelope text-muted"></i>
                                        </span>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                                            class="form-control form-control-lg border-start-0 @error('email') is-invalid @enderror"
                                            placeholder="Enter your email" required autofocus>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input id="password" type="password" name="password"
                                            class="form-control form-control-lg border-start-0 @error('password') is-invalid @enderror"
                                            placeholder="Enter your password" required>
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

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label text-muted" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">
                                        Forgot Password?
                                    </a>
                                </div>

                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg fw-semibold py-3">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-4 d-block d-lg-none">
                        <img src="{{ asset('images/vectors/smct logo.png') }}" class="img-fluid" style="max-width: 200px;"
                            alt="Strong Moto Centrum">
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
            $('.alert').delay(4000).fadeOut(500);

            // Toggle password visibility
            $('#togglePassword').click(function() {
                const password = $('#password');
                const icon = $(this).find('i');

                if (password.attr('type') === 'password') {
                    password.attr('type', 'text');
                    icon.removeClass('bi-eye').addClass('bi-eye-slash');
                } else {
                    password.attr('type', 'password');
                    icon.removeClass('bi-eye-slash').addClass('bi-eye');
                }
            });

            // Form validation styles
            $('input').on('blur', function() {
                if ($(this).val().trim() !== '') {
                    $(this).addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid');
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
            box-shadow: none;
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

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
        }

        .sessionmodal {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 2rem !important;
            }

            .container {
                padding: 1rem;
            }
        }
    </style>
@endsection
