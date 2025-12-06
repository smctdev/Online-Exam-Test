@extends('layouts.app')

@section('top_bar')
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            @if ($setting)
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}"
                    title="{{ $setting->welcome_txt }}">
                    @if (file_exists(public_path('images/vectors/samp.png')))
                        <img src="{{ asset('images/vectors/samp.png') }}" class="img-fluid me-2" style="max-height: 40px;"
                            alt="{{ $setting->welcome_txt }}">
                    @endif
                    <span class="fw-bold">{{ $setting->welcome_txt ?? 'Online Assessment' }}</span>
                </a>
            @endif
        </div>
    </nav>
@endsection

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center mb-5">
                        <h1 class="display-4 fw-bold text-white mb-3">Online Assessment Platform</h1>
                        <p class="lead text-light opacity-75">Secure, Reliable, and Professional Testing Environment</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <!-- Left Column - Illustration -->
                                <div class="col-lg-6 d-none d-lg-block bg-primary bg-opacity-10">
                                    <div class="h-100 d-flex flex-column justify-content-center p-5">
                                        <div class="text-center mb-5">
                                            <img src="{{ asset('images/vectors/hello.svg') }}" class="img-fluid"
                                                style="max-height: 300px;" alt="Welcome Illustration">
                                        </div>
                                        <div class="text-center">
                                            <h3 class="fw-bold text-primary mb-3">Security First</h3>
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <div class="bg-white p-3 rounded-3 shadow-sm text-center">
                                                        <i class="bi bi-shield-check text-primary fs-2 mb-2"></i>
                                                        <h6 class="fw-semibold mb-0">Secure Access</h6>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="bg-white p-3 rounded-3 shadow-sm text-center">
                                                        <i class="bi bi-clock text-primary fs-2 mb-2"></i>
                                                        <h6 class="fw-semibold mb-0">Timed Assessment</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Verification -->
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        @php
                                            $utoken = $user->token;
                                            $names = \App\Helper\Helper::splitname($user->name);
                                            $fname = $names[0];
                                            Session::put('fname', $fname);
                                            Session::put('utoken', $utoken);
                                            Session::put('userID', bin2hex(random_bytes($user->id)));
                                        @endphp

                                        <!-- Welcome Message -->
                                        <div class="text-center mb-4">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                style="width: 80px; height: 80px;">
                                                <i class="bi bi-person-check text-primary fs-1"></i>
                                            </div>
                                            <h2 class="fw-bold text-primary">Hello {{ $fname }}!</h2>
                                            <p class="text-muted">Please verify your email to proceed with the assessment
                                            </p>
                                        </div>

                                        <!-- Status Message -->
                                        @if (Auth::user()?->status === 'retry')
                                            <div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4"
                                                role="alert">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-arrow-clockwise text-warning fs-4 me-3"></i>
                                                    <div>
                                                        <h6 class="fw-semibold mb-1">Retry Opportunity</h6>
                                                        <p class="mb-0">You are given a chance to retry. Good luck!</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Send Verification Code -->
                                        <div id="sendcode">
                                            <div class="card border-0 bg-light mb-4">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-start mb-3">
                                                        <i class="bi bi-envelope-check text-primary fs-4 me-3"></i>
                                                        <div>
                                                            <h5 class="fw-semibold mb-1">Email Verification Required</h5>
                                                            <p class="text-muted mb-0">We'll send a verification code to:
                                                                <strong>{{ $user->email }}</strong>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <form id="sendForm">
                                                        <input type="hidden" name="email" id="email"
                                                            value="{{ $user->email }}">
                                                        <div class="d-grid">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-lg fw-semibold py-3">
                                                                <i class="bi bi-envelope me-2"></i>
                                                                <span>Send Verification Code</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Logout Button -->
                                            <div class="d-grid">
                                                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-lg"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Verify Code Section -->
                                        <div id="verifycode" style="display: none">
                                            <div class="card border-0 bg-light mb-4">
                                                <div class="card-body p-4">
                                                    <!-- Success Alert -->
                                                    <div class="alert alert-success alert-dismissible fade show mb-4"
                                                        role="alert">
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                                                            <div>
                                                                <h6 class="fw-semibold mb-1">Code Sent Successfully!</h6>
                                                                <p class="mb-0">Verification code was sent to your email.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Resend Option -->
                                                    <div class="text-center mb-4" id="resendItem" style="display: none;">
                                                        <p class="text-muted mb-2">Did not receive a code?</p>
                                                        <form id="sendForm2">
                                                            @csrf
                                                            <input type="hidden" name="email" id="email"
                                                                value="{{ $user->email }}">
                                                            <button type="submit"
                                                                class="btn btn-link text-decoration-none"
                                                                style="cursor:pointer">
                                                                <i class="bi bi-arrow-clockwise me-1"></i>Resend Code
                                                            </button>
                                                        </form>
                                                    </div>

                                                    <!-- Verification Form -->
                                                    <form id="verifyForm">
                                                        @csrf
                                                        <div class="mb-4">
                                                            <label for="code" class="form-label fw-semibold">
                                                                <i class="bi bi-key me-1"></i>Enter Verification Code
                                                            </label>
                                                            <div class="position-relative">
                                                                <input type="hidden" id="id"
                                                                    value="{{ $user->id }}">
                                                                <input id="code" type="text"
                                                                    class="form-control form-control-lg text-center fw-bold border-2 @error('code') is-invalid @enderror"
                                                                    placeholder="Enter 6-digit code" maxlength="6"
                                                                    inputmode="numeric" required autofocus>
                                                                <div
                                                                    class="position-absolute top-50 end-0 translate-middle-y me-3">
                                                                    <i class="bi bi-patch-check text-muted"></i>
                                                                </div>
                                                            </div>
                                                            <div id="codeError" class="invalid-feedback d-none">
                                                                <i class="bi bi-exclamation-circle me-1"></i>Invalid
                                                                verification code
                                                            </div>
                                                            <small class="text-muted mt-2 d-block">
                                                                Enter the 6-digit code sent to your email
                                                            </small>
                                                        </div>

                                                        <div class="d-grid">
                                                            <button type="submit"
                                                                class="btn btn-success btn-lg fw-semibold py-3">
                                                                <i class="bi bi-check-circle me-2"></i>
                                                                <span>Verify & Proceed</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Timer (Optional) -->
                                            <div class="text-center">
                                                <div class="badge bg-light text-dark p-3">
                                                    <i class="bi bi-clock me-1"></i>
                                                    <span id="timer">Code expires in: 10:00</span>
                                                </div>
                                            </div>
                                        </div>
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

@push('scripts')
    <script>
        const isProduction = @json(config('app.env') === 'production');
        const verify = isProduction ? @json(route('verify.email')).replace('http://', 'https://') :
            @json(route('verify.email'));
        const check = isProduction ? @json(route('check.code')).replace('http://', 'https://') :
            @json(route('check.code'));
        const startQuiz = isProduction ? @json(route('start_quiz')).replace('http://', 'https://') :
            @json(route('start_quiz'));


        document.addEventListener("DOMContentLoaded", function() {
            let timerInterval;
            let timeLeft = 600; // 10 minutes

            function startTimer() {
                const timerElement = document.getElementById("timer");
                const resend = document.getElementById('resendItem');

                timerInterval = setInterval(() => {
                    timeLeft--;

                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        timerElement.innerHTML =
                            '<span class="text-danger">Code expired!</span>';

                        resend.style.display = 'block';
                        return;
                    }

                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;

                    timerElement.textContent = `Code expires in: ${minutes}:${seconds
                .toString()
                .padStart(2, "0")}`;
                }, 1000);
            }

            // Send Form (Send Code)
            document.getElementById("sendForm").addEventListener("submit", async (event) => {
                event.preventDefault();
                const email = document.getElementById("email").value;
                const button = this.querySelector("button");
                const originalText = button.innerHTML;

                button.disabled = true;
                button.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Sending...
        `;

                try {
                    let response = await axios.post(verify, {
                        email: email,
                    });

                    button.innerHTML = '<i class="bi bi-check-circle me-2"></i>Code Sent!';
                    button.classList.replace("btn-primary", "btn-success");

                    setTimeout(() => {
                        document.getElementById("sendcode").style.display = "none";
                        document.getElementById("verifycode").style.display = "block";

                        document.getElementById("code").focus();

                        button.disabled = false;
                        button.innerHTML = originalText;
                        button.classList.replace("btn-success", "btn-primary");

                        startTimer();
                    }, 1000);
                } catch (error) {
                    console.error(error);

                    button.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>Failed';
                    button.classList.replace("btn-primary", "btn-danger");

                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalText;
                        button.classList.replace("btn-danger", "btn-primary");
                    }, 2000);

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Failed to send verification code.",
                    });
                }
            });

            document.getElementById("sendForm2").addEventListener("submit", async (event) => {
                event.preventDefault();
                const email = document.getElementById("email").value;
                const button = this.querySelector("button");
                const originalText = button.innerHTML;

                button.disabled = true;
                button.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Sending...
        `;

                try {
                    let response = await axios.post(verify, {
                        email: email,
                    });

                    button.innerHTML = '<i class="bi bi-check-circle me-2"></i>Code Sent!';
                    button.classList.replace("btn-primary", "btn-success");

                    setTimeout(() => {
                        document.getElementById("sendcode").style.display = "none";
                        document.getElementById("verifycode").style.display = "block";

                        document.getElementById("code").focus();

                        button.disabled = false;
                        button.innerHTML = originalText;
                        button.classList.replace("btn-success", "btn-primary");

                        startTimer();
                    }, 1000);
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Verification code sent successfully.",
                    })
                } catch (error) {
                    console.error(error);

                    button.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>Failed';
                    button.classList.replace("btn-primary", "btn-danger");

                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalText;
                        button.classList.replace("btn-danger", "btn-primary");
                    }, 2000);

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Failed to send verification code.",
                    });
                }
            });

            // Verify Form
            document.getElementById("verifyForm").addEventListener("submit", async function(event) {
                event.preventDefault();

                const code = document.getElementById("code").value;
                const id = document.getElementById("id").value;

                const form = this;
                const button = form.querySelector("button");
                const originalText = button.innerHTML;

                document.getElementById("codeError").classList.add("d-none");
                document.getElementById("code").classList.remove("is-invalid");

                button.disabled = true;
                button.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Verifying...
        `;

                try {
                    let response = await axios.get(check, {
                        params: {
                            code,
                            id
                        },
                    });

                    if (response.data.success) {
                        button.innerHTML = '<i class="bi bi-check-circle me-2"></i>Verified!';
                        button.classList.replace("btn-success", "btn-primary");

                        setTimeout(() => {
                            window.location.href = startQuiz;
                        }, 1000);
                    } else {
                        document.getElementById("codeError").classList.remove("d-none");
                        document.getElementById("code").classList.add("is-invalid");

                        form.classList.add("shake");
                        setTimeout(() => form.classList.remove("shake"), 500);

                        button.disabled = false;
                        button.innerHTML = originalText;
                    }
                } catch (error) {
                    console.error(error);

                    button.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>Error';
                    button.classList.replace("btn-success", "btn-danger");

                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalText;
                        button.classList.replace("btn-danger", "btn-success");
                    }, 2000);

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong! Please try again.",
                    });
                }
            });

            // Auto-submit if code = 6 digits
            document.getElementById("code").addEventListener("input", function() {
                if (this.value.length === 6) document.getElementById("verifyForm");
            });

            // Allow only numbers
            document.getElementById("code").addEventListener("keypress", function(e) {
                const charCode = e.which || e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
                return true;
            });
        });


        // Security settings
        @if ($setting->right_setting == 1)
            // Right click disable
            $(function() {
                $(this).bind("contextmenu", function(inspect) {
                    inspect.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Restricted Action',
                        text: 'Right-click is disabled for security reasons.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            });
        @endif

        @if ($setting->element_setting == 1)
            // Keyboard shortcuts disable
            $(function() {
                var isCtrl = false;

                document.onkeyup = function(e) {
                    if (e.which == 17) isCtrl = false;
                }

                document.onkeydown = function(e) {
                    if (e.which == 17) isCtrl = true;
                    if (e.which == 85 && isCtrl == true) { // Ctrl+U
                        e.preventDefault();
                        return false;
                    }
                    if (e.which == 123) { // F12
                        e.preventDefault();
                        return false;
                    }
                    if (e.ctrlKey && e.shiftKey && e.which == 73) { // Ctrl+Shift+I
                        e.preventDefault();
                        return false;
                    }
                    if (e.ctrlKey && e.shiftKey && e.which == 74) { // Ctrl+Shift+J
                        e.preventDefault();
                        return false;
                    }
                    if (e.ctrlKey && e.which == 83) { // Ctrl+S
                        e.preventDefault();
                        return false;
                    }
                };
            });
        @endif
    </script>

    <style>
        /* Shake animation for error */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* Custom card styling */
        .card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
        }

        .bg-primary.bg-opacity-10 {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }

        /* Form input styling */
        .form-control-lg {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border: 2px solid #e9ecef;
            font-size: 1.25rem;
            letter-spacing: 3px;
        }

        .form-control-lg:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Button styling */
        .btn-primary,
        .btn-success {
            border: none;
            transition: all 0.3s;
            border-radius: 12px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
        }

        .btn-primary:hover,
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Navbar styling */
        .navbar-dark.bg-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .display-4 {
                font-size: 2.5rem;
            }

            .card-body {
                padding: 2rem !important;
            }
        }

        @media (max-width: 768px) {
            .display-4 {
                font-size: 2rem;
            }

            .card-body {
                padding: 1.5rem !important;
            }

            .btn-lg {
                padding: 0.75rem 1.5rem;
            }
        }

        /* Loading spinner */
        .spinner-border {
            width: 1rem;
            height: 1rem;
        }

        /* Badge styling */
        .badge {
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Alert styling */
        .alert {
            border: none;
            border-radius: 12px;
        }
    </style>
@endpush
