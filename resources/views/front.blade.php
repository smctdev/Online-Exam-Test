@extends('layouts.app')

@section('content')
    <div class="container-fluid min-vh-100" style="background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);">
        <div class="container py-5">
            <div class="row align-items-center">
                <!-- Left Column - Illustration -->
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="position-relative">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="card-body p-4">
                                <img src="{{ asset('images/vectors/woman.png') }}" class="img-fluid rounded-3"
                                    alt="Exam Illustration">
                            </div>
                        </div>
                        <!-- Decorative Elements -->
                        <div class="position-absolute top-0 start-0 mt-3 ms-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-lightbulb text-primary fs-2"></i>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 end-0 mb-3 me-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-clock text-success fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Instructions -->
                <div class="col-lg-7">
                    <!-- Welcome Header -->
                    <div class="text-center text-lg-start mb-5">
                        @php
                            $fname = Session::get('fname');
                        @endphp
                        <h1 class="display-5 fw-bold text-white mb-3 animate-fade-in" style="display:none;">
                            Welcome, <span class="text-warning">{{ ucwords($fname) }}</span>!
                        </h1>
                        <p class="lead text-light opacity-75 animate-fade-in-delay" style="display:none;">
                            Before getting started, please read all the instructions carefully.
                        </p>
                    </div>

                    <!-- Exam Content -->
                    <div class="row justify-content-center">
                        <div class="col-12">
                            @if (!$exam || !$topic)
                                <!-- No Exam Available -->
                                <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate-fade-in">
                                    <div class="card-header bg-danger text-white py-4 border-0">
                                        <h4 class="mb-0 text-center">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                            No Exams Available
                                        </h4>
                                    </div>
                                    <div class="card-body p-5 text-center">
                                        <div class="py-4">
                                            <i class="bi bi-calendar-x text-danger" style="font-size: 4rem;"></i>
                                        </div>
                                        <h5 class="text-muted mb-4">There are no exams scheduled for you at the moment.</h5>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            class="btn btn-primary btn-lg">
                                            <i class="bi bi-box-arrow-left me-2"></i>Return to Dashboard
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @else
                                <!-- Exam Instructions -->
                                <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate-fade-in">
                                    <div class="card-header bg-primary text-white py-4 border-0">
                                        <h3 class="mb-0 text-center">
                                            <i class="bi bi-journal-text me-2"></i>
                                            Exam Instructions & Guidelines
                                        </h3>
                                    </div>

                                    <div class="card-body p-4 p-lg-5">
                                        <!-- Important Warning -->
                                        <div class="alert alert-warning alert-dismissible fade show mb-4 border-0"
                                            role="alert">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-exclamation-triangle-fill text-warning fs-3 me-3"></i>
                                                <div>
                                                    <h5 class="alert-heading mb-2">Important: Read Carefully</h5>
                                                    <p class="mb-0">Violation of any guideline may result in exam
                                                        termination.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Guidelines List -->
                                        <div class="mb-5">
                                            <h4 class="fw-bold text-primary mb-4">
                                                <i class="bi bi-list-check me-2"></i>
                                                Guidelines During The Exam
                                            </h4>

                                            <div class="row">
                                                <!-- Left Column Guidelines -->
                                                <div class="col-md-6">
                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-start mb-2">
                                                            <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                                                <i class="bi bi-clock-history text-danger"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-semibold mb-1">Time Management</h6>
                                                                <p class="text-muted mb-0">Time cannot be paused once
                                                                    started.</p>
                                                            </div>
                                                        </div>
                                                        <ul class="text-muted ps-5">
                                                            <li>Ensure stable internet connection</li>
                                                            <li>Complete exam without interruptions</li>
                                                        </ul>
                                                    </div>

                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-start mb-2">
                                                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                                <i class="bi bi-window text-warning"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-semibold mb-1">Browser Management</h6>
                                                                <p class="text-muted mb-0">Avoid browser manipulation.</p>
                                                            </div>
                                                        </div>
                                                        <ul class="text-muted ps-5">
                                                            <li>Don't resize or minimize the browser</li>
                                                            <li>Avoid refresh and back buttons</li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <!-- Right Column Guidelines -->
                                                <div class="col-md-6">
                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-start mb-2">
                                                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                                <i class="bi bi-shield-exclamation text-info"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-semibold mb-1">Security Rules</h6>
                                                                <p class="text-muted mb-0">Maintain exam integrity.</p>
                                                            </div>
                                                        </div>
                                                        <ul class="text-muted ps-5">
                                                            <li>Avoid opening new tabs/browsers</li>
                                                            <li>System detects suspicious activity</li>
                                                        </ul>
                                                    </div>

                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-start mb-2">
                                                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                                <i class="bi bi-journal-code text-success"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-semibold mb-1">Exam Structure</h6>
                                                                <p class="text-muted mb-0">{{ count($topic) }} categories
                                                                    total.</p>
                                                            </div>
                                                        </div>
                                                        <ul class="text-muted ps-5">
                                                            <li>Each category has allocated time</li>
                                                            <li>Answer all questions before time expires</li>
                                                            <li>Review answers if time permits</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Categories List -->
                                            @if (count($topic) > 0)
                                                <div class="mt-4">
                                                    <h6 class="fw-semibold mb-3">
                                                        <i class="bi bi-layers me-2"></i>
                                                        Exam Categories
                                                    </h6>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach ($topic as $category => $sub)
                                                            <span
                                                                class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2">
                                                                <i class="bi bi-check-circle me-1"></i>
                                                                {{ $sub['title'] }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Final Instruction -->
                                        <div class="alert alert-info border-0 bg-light mb-4">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-info-circle-fill text-primary fs-4 me-3"></i>
                                                <div>
                                                    <h6 class="fw-semibold mb-2">Important Note</h6>
                                                    <p class="mb-0">
                                                        Click the <strong>"Submit"</strong> button in the bottom right
                                                        corner
                                                        when you are ready to move to the next exam or when you are done.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Agreement and Start Button -->
                                        <div class="border-top pt-4 mt-4">
                                            <div class="row align-items-center">
                                                <div class="col-md-8 mb-3 mb-md-0">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="read"
                                                            id="read"
                                                            style="cursor: pointer; width: 1.2em; height: 1.2em;">
                                                        <label class="form-check-label fw-semibold ms-2" for="read">
                                                            I have read and fully understand all the guidelines and
                                                            instructions.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-md-end">
                                                    <a id="startexam" class="btn btn-success btn-lg px-4 py-3 fw-semibold"
                                                        style="pointer-events: none; opacity: 0.6; transition: all 0.3s;"
                                                        href="{{ route('category_title', $topic[0]['slug']) }}">
                                                        <i class="bi bi-play-circle me-2"></i>
                                                        Start Exam
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Animation sequence
            function startAnimations() {
                // Animate illustration card
                $('.col-lg-5 .card').css({
                    'opacity': '0',
                    'transform': 'translateX(-50px)'
                }).animate({
                    'opacity': '1',
                    'transform': 'translateX(0)'
                }, 800, function() {
                    // Show welcome text
                    $('.animate-fade-in').fadeIn(600, function() {
                        $('.animate-fade-in-delay').delay(300).fadeIn(400, function() {
                            // Show instructions with staggered effect
                            $('.animate-fade-in').each(function(index) {
                                $(this).delay(index * 100).fadeIn(400);
                            });
                        });
                    });
                });

                // Animate decorative elements
                $('.position-absolute').css('opacity', '0');
                setTimeout(() => {
                    $('.position-absolute').each(function(index) {
                        $(this).delay(index * 200).animate({
                            opacity: 1
                        }, 400);
                    });
                }, 500);
            }

            // Start animations after page load
            setTimeout(startAnimations, 300);

            // Checkbox functionality
            $('#read').on('change', function() {
                const startBtn = $('#startexam');

                if ($(this).is(':checked')) {
                    startBtn.css({
                        'pointer-events': 'auto',
                        'opacity': '1',
                        'transform': 'scale(1.05)'
                    });

                    // Add pulse animation
                    startBtn.addClass('pulse');

                    // Success feedback
                    $(this).closest('.form-check').addClass('text-success');
                    $(this).closest('.form-check').find('label').append(
                        ' <i class="bi bi-check-circle-fill text-success"></i>'
                    );
                } else {
                    startBtn.css({
                        'pointer-events': 'none',
                        'opacity': '0.6',
                        'transform': 'scale(1)'
                    });

                    // Remove pulse animation
                    startBtn.removeClass('pulse');

                    // Remove success feedback
                    $(this).closest('.form-check').removeClass('text-success');
                    $(this).closest('.form-check').find('label .bi-check-circle-fill').remove();
                }
            });

            // Start exam button hover effect
            $('#startexam').hover(
                function() {
                    if ($(this).css('pointer-events') !== 'none') {
                        $(this).css('transform', 'scale(1.1)');
                    }
                },
                function() {
                    if ($(this).css('pointer-events') !== 'none') {
                        $(this).css('transform', 'scale(1.05)');
                    }
                }
            );

            // Confirmation before starting exam
            $('#startexam').on('click', function(e) {
                if (!$('#read').is(':checked')) {
                    e.preventDefault();
                    return false;
                }

                e.preventDefault();
                const url = $(this).attr('href');

                Swal.fire({
                    title: 'Are you ready to begin?',
                    html: `
                    <div class="text-start">
                        <p class="mb-3"><strong>Final Check:</strong></p>
                        <ul class="text-start">
                            <li>Stable internet connection</li>
                            <li>No other browser tabs open</li>
                            <li>Undisturbed environment</li>
                            <li>Time starts immediately</li>
                        </ul>
                    </div>
                `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Start Exam',
                    cancelButtonText: 'Review Again',
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Loading Exam...',
                            text: 'Please wait while we prepare your exam',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Redirect after short delay
                        setTimeout(() => {
                            window.location.href = url;
                        }, 1000);
                    }
                });
            });

            // Add keyboard shortcut for checkbox (Space/Enter)
            $(document).on('keydown', function(e) {
                if ((e.key === ' ' || e.key === 'Enter') && !$('input:focus, textarea:focus').length) {
                    e.preventDefault();
                    const checkbox = $('#read');
                    checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                }
            });
        });
    </script>
@endpush
