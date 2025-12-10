<!DOCTYPE html>
<html lang="en">
@php
    $setting = App\Models\Setting::first();
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="600">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMCT Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- AdminLTE v3 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    @stack('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom styles for dropdowns */
        .dropdown-menu {
            border: 1px solid rgba(0, 0, 0, .15);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.375rem;
        }

        .dropdown-header {
            border-radius: 0.375rem 0.375rem 0 0;
            padding: 0.75rem 1rem;
            font-weight: 600;
        }

        .dropdown-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .avatar-circle-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .list-group-item {
            transition: background-color 0.2s;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .badge {
            font-size: 0.65rem;
            padding: 0.25em 0.5em;
        }

        /* Ensure dropdown doesn't overflow on mobile */
        @media (max-width: 576px) {
            .dropdown-menu-lg {
                width: 300px !important;
                right: 0 !important;
                left: auto !important;
                transform: none !important;
            }
        }

        /* For very small screens */
        @media (max-width: 360px) {
            .dropdown-menu-lg {
                width: 280px !important;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    @if ($auth)
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <p class="nav-link">{{ date('l, F j, Y') }}</p>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ms-auto">
                    <!-- Notifications -->
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" data-bs-toggle="dropdown" href="#" id="notify"
                            role="button" aria-expanded="false">
                            <i class="far fa-bell"></i>
                            @if (count($notify) > 0)
                                <span
                                    class="position-absolute top-4 start-70 translate-middle badge rounded-pill bg-danger">
                                    {{ count($notify) }}
                                    <span class="visually-hidden">unread notifications</span>
                                </span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0"
                            style="width: 350px; max-width: 95vw; max-height: 500px; overflow-y: auto;">
                            @if (count($notify) > 0)
                                <div class="dropdown-header bg-primary text-white text-start">
                                    <i class="fas fa-bell me-2"></i>
                                    Notifications ({{ count($notify) }})
                                </div>

                                <div class="list-group list-group-flush">
                                    @foreach ($notify as $key)
                                        <a href="{{ route('exam.result', $key->id) }}"
                                            class="list-group-item list-group-item-action border-0 py-3 px-4 relative">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="avatar-circle-sm bg-primary text-white d-flex align-items-center justify-content-center">
                                                        {{ substr($key?->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-1 fw-bold">{{ $key?->name }}</h6>
                                                    </div>
                                                    <p class="mb-0 text-muted">
                                                        <i class="fas fa-check-circle text-success me-1"></i>
                                                        Completed the exam
                                                    </p>
                                                </div>
                                            </div>
                                            <small class="text-muted text-bold"
                                                style="font-size: 10px; position: absolute; top: 2px; right: 10px;">{{ Illuminate\Support\Carbon::parse($key?->result?->created_at)?->diffForHumans() }}</small>
                                        </a>
                                        @if (!$loop?->last)
                                            <hr class="my-0">
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="dropdown-header bg-primary text-white">
                                    <i class="fas fa-bell me-2"></i>
                                    Notifications
                                </div>
                                <div class="text-center py-4">
                                    <div class="mb-3">
                                        <i class="far fa-bell fa-3x text-muted"></i>
                                    </div>
                                    <p class="text-muted mb-0">No new notifications</p>
                                </div>
                            @endif
                        </div>
                    </li>

                    <!-- User Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle-sm bg-info text-white me-2">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" style="min-width: 200px;">
                            <div class="dropdown-header bg-light">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-primary text-white me-3">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                        <small class="text-muted">{{ auth()->user()->email }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user me-2"></i> My Profile
                            </a>
                            <a href="{{ route('settings.index') }}" class="dropdown-item">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item text-danger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="brand-link">
                    @if ($setting)
                        <img src="{{ asset('images/logo/' . $setting->logo) }}" alt="SMCT Logo"
                            class="brand-image img-circle elevation-3" style="opacity: .8">
                    @endif
                    <span class="brand-text font-weight-light">SMCT Admin</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- User Panel -->
                    @php
                        $color = App\Models\Color::where('user_id', $auth->id)->select('profile_color')->first();
                    @endphp
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center justify-items-center">
                        <div class="d-flex justify-content-center mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; background-color: {{ $color ? $color->profile_color : '#ccc' }};">
                                <span
                                    class="text-white fs-6 fw-bold">{{ strtoupper(substr($auth->name, 0, 1)) }}</span>
                            </div>
                        </div>

                        <div class="info">
                            <a href="#" class="d-block">{{ ucwords($auth->name) }}</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                            <li class="nav-item">
                                <a href="/admin"
                                    class="nav-link {{ request()->routeIs('dashboard') ? 'bg-primary' : '' }}">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>DASHBOARD</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#"
                                    class="nav-link {{ request()->routeIs('examinees.lists') || request()->routeIs('admin.list') ? 'bg-primary menu-is-opening menu-open' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Users
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" @style(request()->routeIs('examinees.lists') || request()->routeIs('admin.list') ? 'display: block;' : '')>
                                    <li class="nav-item">
                                        <a href="/admin/examinees"
                                            class="nav-link {{ request()->routeIs('examinees.lists') ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Examinees</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.list') }}"
                                            class="nav-link {{ request()->routeIs('admin.list') ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Administrators</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ request()->routeIs('questions.index') ? 'bg-primary' : '' }}">
                                <a href="/admin/questions" class="nav-link">
                                    <i class="nav-icon fas fa-question-circle"></i>
                                    <p>SUBJECTS</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('settings.index') ? 'bg-primary' : '' }}">
                                <a href="/admin/settings" class="nav-link">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>SETTINGS</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                @if (Session::has('added'))
                    <div class="alert alert-success sessionmodal">{{ session('added') }}</div>
                @elseif(Session::has('updated'))
                    <div class="alert alert-info sessionmodal">{{ session('updated') }}</div>
                @elseif(Session::has('deleted'))
                    <div class="alert alert-danger sessionmodal">{{ session('deleted') }}</div>
                @endif

                <section class="content">
                    <div class="container-fluid" id="container-fluid">
                        @yield('content')
                    </div>
                </section>
            </div>

        </div>
    @endif

    <script>
        $(function() {
            // Session alert
            $('.sessionmodal').addClass('active');
            setTimeout(() => $('.sessionmodal').removeClass('active'), 4500);

            // Notification toggle
            $('.dropdown').hover(
                () => $('.notif').show(),
                () => $('.notif').hide()
            );

            // DataTables initialization
            $('#questions_table').DataTable();
            $('#search').DataTable({
                paging: false,
                lengthChange: false,
                searching: true,
                ordering: false,
                info: false,
                autoWidth: true
            });
            $('#topTable').DataTable({
                order: [
                    [4, 'desc']
                ],
                lengthMenu: [
                    [5, 10, 15, -1],
                    [5, 10, 15, 'All']
                ]
            });

            // Select2 & Iconpicker
            $('.select2').select2();
            $('.currency-icon-picker').iconpicker({
                title: 'Currency Symbols',
                icons: ['fa fa-dollar', 'fa fa-euro', 'fa fa-gbp', 'fa fa-ils', 'fa fa-inr', 'fa fa-krw',
                    'fa fa-money', 'fa fa-rouble', 'fa fa-try'
                ],
                selectedCustomClass: 'label label-primary',
                mustAccept: true,
                placement: 'topRight',
                showFooter: false,
                hideOnSelect: true
            });
        });

        const type = @json(config('app.env'));

        function ajaxCall(url, id) {
            if (type === 'production') {
                url = url?.replace('http://', 'https://');
            }
            $.ajax({
                type: "GET",
                url: url,
                contentType: false,
                data: {
                    id: id
                },
                dataType: "html",
                success: function(data) {
                    $(".content").html(data);
                    $('ul.nav-sidebar > li').removeClass('active');
                    $('#' + id).addClass('active');
                    window.history.pushState("", "", url);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>

    @include('partial.scripts')
    @stack('scripts')
    <script>
        $(document).ready(function() {
            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });

            // Mark notifications as read when dropdown opens
            $('#notify').on('click', function() {
                if ($(this).find('.badge').length) {
                    // You could add an AJAX call here to mark notifications as read
                    console.log('Notifications viewed');
                }
            });

            // Prevent dropdown close when clicking inside
            $('.dropdown-menu').on('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>

</html>
