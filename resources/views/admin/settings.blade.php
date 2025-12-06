@extends('layouts.admin', [
    'page_header' => 'Settings',
    'dash' => '',
    'examinees' => '',
    'quiz' => '',
    'users' => '',
    'questions' => '',
    'sett' => 'active',
])

@section('content')
    @php
        $setting = $settings[0] ?? null;
    @endphp

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cog me-2"></i>System Settings
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Configure system-wide settings including branding, security, and email
                            configuration.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- General Settings -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-sliders-h me-2"></i>General Settings
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST"
                            action="{{ action([App\Http\Controllers\SettingController::class, 'update'], $setting->id ?? 1) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="welcome_txt" class="form-label">Project Name</label>
                                <input type="text" name="welcome_txt" id="welcome_txt"
                                    class="form-control @error('welcome_txt') is-invalid @enderror"
                                    value="{{ old('welcome_txt', $setting->welcome_txt ?? '') }}"
                                    placeholder="Enter your project name">
                                <small class="text-muted">This name will appear throughout the application</small>
                                @error('welcome_txt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Logo</label>
                                        <input type="file" name="logo" id="logo"
                                            class="form-control @error('logo') is-invalid @enderror"
                                            accept="image/png,image/jpeg,image/jpg">
                                        <small class="text-muted">Recommended size: 128x128px. Formats: PNG, JPG</small>
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        @if ($setting && $setting->logo)
                                            <div class="mt-2">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle me-2"></i>Current Logo:
                                                </div>
                                                <img src="{{ asset('images/logo/' . $setting->logo) }}"
                                                    class="img-thumbnail"
                                                    style="width: 128px; height: 128px; object-fit: contain;"
                                                    alt="{{ $setting->welcome_txt ?? 'Logo' }}">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="remove_logo"
                                                        id="remove_logo">
                                                    <label class="form-check-label" for="remove_logo">
                                                        Remove current logo
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="favicon" class="form-label">Favicon</label>
                                        <input type="file" name="favicon" id="favicon"
                                            class="form-control @error('favicon') is-invalid @enderror"
                                            accept="image/png,image/x-icon,image/vnd.microsoft.icon">
                                        <small class="text-muted">Recommended: 32x32px ICO or PNG</small>
                                        @error('favicon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        @if ($setting && $setting->favicon)
                                            <div class="mt-2">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle me-2"></i>Current Favicon:
                                                </div>
                                                <img src="{{ asset('images/favicon/' . $setting->favicon) }}"
                                                    class="img-thumbnail"
                                                    style="width: 32px; height: 32px; object-fit: contain;" alt="Favicon">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="remove_favicon"
                                                        id="remove_favicon">
                                                    <label class="form-check-label" for="remove_favicon">
                                                        Remove current favicon
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label d-block">Security Settings</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="rightclick"
                                                id="rightclick" value="1"
                                                {{ ($setting->right_setting ?? 0) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rightclick">
                                                Disable Right Click
                                            </label>
                                            <small class="text-muted d-block">Prevent users from right-clicking on exam
                                                pages</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label d-block">&nbsp;</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="inspect"
                                                id="inspect" value="1"
                                                {{ ($setting->element_setting ?? 0) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inspect">
                                                Disable Inspect Element
                                            </label>
                                            <small class="text-muted d-block">Prevent users from opening browser developer
                                                tools</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Save General Settings
                                </button>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Email Configuration -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-envelope me-2"></i>Email Configuration
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#testEmailModal">
                                <i class="fas fa-paper-plane"></i> Test Email
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('settings.update', auth()->id()) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Configure SMTP settings for sending exam invitations and notifications.
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="MAIL_FROM_NAME" class="form-label">Sender Name <small
                                                class="text-muted">(e.g., Exam System)</small></label>
                                        <input type="text" name="MAIL_FROM_NAME" id="MAIL_FROM_NAME"
                                            class="form-control @error('MAIL_FROM_NAME') is-invalid @enderror"
                                            value="{{ $env_files['MAIL_FROM_NAME'] ?? '' }}" placeholder="Sender name">
                                        @error('MAIL_FROM_NAME')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="MAIL_USERNAME" class="form-label">Mail Username <small
                                                class="text-muted">(e.g., noreply@example.com)</small></label>
                                        <input type="email" name="MAIL_USERNAME" id="MAIL_USERNAME"
                                            class="form-control @error('MAIL_USERNAME') is-invalid @enderror"
                                            value="{{ $env_files['MAIL_USERNAME'] ?? '' }}" placeholder="Email address">
                                        @error('MAIL_USERNAME')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="MAIL_PASSWORD" class="form-label">Mail Password</label>
                                        <div class="input-group">
                                            <input type="password" name="MAIL_PASSWORD" id="MAIL_PASSWORD"
                                                class="form-control @error('MAIL_PASSWORD') is-invalid @enderror"
                                                value="{{ $env_files['MAIL_PASSWORD'] ?? '' }}"
                                                placeholder="Email password">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="toggleMailPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('MAIL_PASSWORD')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="MAIL_HOST" class="form-label">Mail Host <small
                                                class="text-muted">(e.g., smtp.gmail.com)</small></label>
                                        <input type="text" name="MAIL_HOST" id="MAIL_HOST"
                                            class="form-control @error('MAIL_HOST') is-invalid @enderror"
                                            value="{{ $env_files['MAIL_HOST'] ?? '' }}" placeholder="SMTP host">
                                        @error('MAIL_HOST')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="MAIL_PORT" class="form-label">Mail Port <small
                                                class="text-muted">(e.g., 587, 465)</small></label>
                                        <input type="number" name="MAIL_PORT" id="MAIL_PORT"
                                            class="form-control @error('MAIL_PORT') is-invalid @enderror"
                                            value="{{ $env_files['MAIL_PORT'] ?? '' }}" placeholder="Port number">
                                        @error('MAIL_PORT')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="MAIL_DRIVER" class="form-label">Mail Driver <small
                                                class="text-muted">(e.g., smtp, sendmail)</small></label>
                                        <select name="MAIL_DRIVER" id="MAIL_DRIVER"
                                            class="form-select @error('MAIL_DRIVER') is-invalid @enderror">
                                            <option value="smtp"
                                                {{ ($env_files['MAIL_DRIVER'] ?? '') == 'smtp' ? 'selected' : '' }}>SMTP
                                            </option>
                                            <option value="sendmail"
                                                {{ ($env_files['MAIL_DRIVER'] ?? '') == 'sendmail' ? 'selected' : '' }}>
                                                Sendmail</option>
                                            <option value="mail"
                                                {{ ($env_files['MAIL_DRIVER'] ?? '') == 'mail' ? 'selected' : '' }}>Mail
                                            </option>
                                        </select>
                                        @error('MAIL_DRIVER')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="MAIL_ENCRYPTION" class="form-label">Mail Encryption <small
                                                class="text-muted">(TLS, SSL)</small></label>
                                        <select name="MAIL_ENCRYPTION" id="MAIL_ENCRYPTION"
                                            class="form-select @error('MAIL_ENCRYPTION') is-invalid @enderror">
                                            <option value="tls"
                                                {{ ($env_files['MAIL_ENCRYPTION'] ?? '') == 'tls' ? 'selected' : '' }}>TLS
                                            </option>
                                            <option value="ssl"
                                                {{ ($env_files['MAIL_ENCRYPTION'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL
                                            </option>
                                            <option value=""
                                                {{ empty($env_files['MAIL_ENCRYPTION'] ?? '') ? 'selected' : '' }}>None
                                            </option>
                                        </select>
                                        @error('MAIL_ENCRYPTION')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="MAIL_FROM_ADDRESS" class="form-label">From Address</label>
                                        <input type="email" name="MAIL_FROM_ADDRESS" id="MAIL_FROM_ADDRESS"
                                            class="form-control @error('MAIL_FROM_ADDRESS') is-invalid @enderror"
                                            value="{{ $env_files['MAIL_FROM_ADDRESS'] ?? '' }}"
                                            placeholder="From email address">
                                        @error('MAIL_FROM_ADDRESS')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Save Email Settings
                                </button>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Email Modal -->
    <div class="modal fade" id="testEmailModal" tabindex="-1" aria-labelledby="testEmailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="testEmailModalLabel">
                        <i class="fas fa-paper-plane me-2"></i>Test Email Configuration
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('mail.update') }}" method="POST" id="testEmailForm">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Send a test email to verify your SMTP configuration is working correctly.
                        </div>

                        <div class="mb-3">
                            <label for="test_email" class="form-label">Recipient Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" name="test_email" id="test_email" class="form-control"
                                placeholder="Enter email address to send test" required>
                            <small class="text-muted">Enter a valid email address to receive the test email</small>
                        </div>

                        <div id="testResult" class="d-none"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-paper-plane me-1"></i> Send Test Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .form-check.form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
        }

        .form-check.form-switch .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .img-thumbnail {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        .alert-info {
            background-color: #e7f3ff;
            border-color: #b3d7ff;
        }

        .input-group .btn-outline-secondary:hover {
            background-color: #e9ecef;
        }

        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Toggle password visibility for mail password
            $('#toggleMailPassword').on('click', function() {
                const passwordInput = $('#MAIL_PASSWORD');
                const icon = $(this).find('i');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Image preview for logo and favicon
            $('#logo').on('change', function() {
                previewImage(this, '#logoPreview');
            });

            $('#favicon').on('change', function() {
                previewImage(this, '#faviconPreview');
            });

            function previewImage(input, previewId) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if ($(previewId).length) {
                            $(previewId).attr('src', e.target.result);
                        } else {
                            $(input).after(
                                '<div class="mt-2">' +
                                '<img src="' + e.target.result + '" id="' + previewId.substring(1) + '" ' +
                                'class="img-thumbnail" style="max-width: 128px; max-height: 128px;">' +
                                '</div>'
                            );
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Remove image checkbox handling
            $('#remove_logo').on('change', function() {
                $('#logo').prop('disabled', $(this).is(':checked'));
            });

            $('#remove_favicon').on('change', function() {
                $('#favicon').prop('disabled', $(this).is(':checked'));
            });

            // Test email form submission
            $('#testEmailForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-1"></i> Sending...');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#testResult').removeClass('d-none alert-danger').addClass(
                                    'alert alert-success')
                                .html('<i class="fas fa-check-circle me-2"></i>' + response
                                    .message);
                        } else {
                            $('#testResult').removeClass('d-none alert-success').addClass(
                                    'alert alert-danger')
                                .html('<i class="fas fa-exclamation-circle me-2"></i>' +
                                    response.message);
                        }
                    },
                    error: function(xhr) {
                        $('#testResult').removeClass('d-none alert-success').addClass(
                                'alert alert-danger')
                            .html('<i class="fas fa-exclamation-circle me-2"></i>Error: ' +
                                (xhr.responseJSON?.message || 'Failed to send test email'));
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                        // Auto-hide result after 5 seconds
                        setTimeout(function() {
                            $('#testResult').fadeOut();
                        }, 5000);
                    }
                });
            });

            // Reset test form when modal closes
            $('#testEmailModal').on('hidden.bs.modal', function() {
                $('#testEmailForm')[0].reset();
                $('#testResult').addClass('d-none').removeClass('alert alert-success alert-danger').html(
                    '');
            });

            // Form validation for settings
            $('form').on('submit', function() {
                $(this).find('button[type="submit"]').prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin me-1"></i> Saving...');
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endpush
