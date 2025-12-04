<!DOCTYPE html>
<html>
@php
    $setting = App\Models\Setting::first();
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="600">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMCT Admin Panel</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="shortcut icon" href="{{asset('images/logo/'.($setting)?$setting->favicon:'favicon.ico')}}" type="image/x-icon" > --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <!-- Admin Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skin-black.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-iconpicker.min.css') }}">
    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!--fONTS-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"
        integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w=="
        crossorigin="anonymous" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"
        integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA=="
        crossorigin="anonymous"></script>
    <!-- Pusher -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script>
        var pusher = new Pusher('061e9baad7be01269391', {
            encrypted: true,
            cluster: 'ap1'
        });
        var channel = pusher.subscribe('exam-channel');
        channel.bind('exam-event', function(data) {
            $("span").remove();
            $(".notif").empty();
            if (data['notify'].length > 0) {
                $("#notify").append("<span class='badge custom-badge'>" + data['notify'].length + "</span>");
                data['notify'].forEach(function(value) {
                    $(".notif").append(
                        "<li> <a id='app_modal' data-id =" + value['id'] +
                        " href='javascript:void(0)'>" +
                        "<div class='row'>" +
                        " <div class='col-sm-2'><div class=\"profile-circle-ex\" ><p>{{ substr("+value['name']+", 0, 1) }}</p></div></div>" +
                        "<div class='col-sm-8' style='line-height: .5;'>" +
                        "<p style='font-size: 1.6rem'>" + value['name'] + "</p>" +
                        "<p style='font-size: 1.2rem'>Just Completed the exam.</p>" +
                        "<p class='text-sm text-muted'><i class='fa fa-clock mr-1'></i> 4 Hours Ago</p>" +
                        "</div>" +
                        "<div class='col-sm-2 text-success'><i class='fa fa-star fa-lg'></i></div>" +
                        "</div></div></a>" +
                        "</li><div class='dropdown-divider'>"
                    );
                });

            }
        });
    </script>

    <!-- end Pusher -->
    @include('partial.scripts')
</head>

<body class="hold-transition skin-black sidebar-mini">
    @if ($auth)
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="logo"
                    style="background-color:#192A53;border:none;border-bottom:1px solid #14213f">
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">
                        @if ($setting)
                            <img src="{{ asset('images/logo/' . $setting->logo) }}" class="ad-logo img-responsive"
                                alt="SMCT Logo">
                        @endif
                    </span>
                </a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <p class="sidebar-toggle">{{ date('l , F j, Y') }}</p>
                    <!-- Sidebar toggle button-->
                    {{-- <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a> --}}
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">

                        <ul class="navbar-nav menu">
                            <!-- User Account Menu -->
                            <li class="dropdown">
                                <!-- Menu Toggle Button -->
                                <div id="notify" class="dropdown-toggle" data-toggle="dropdown">
                                    <a href="javascript:void(0)" style="color:#3F2668">
                                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                                    </a>
                                    <span></span>
                                    @if (count($notify) > 0)
                                        <span class="badge custom-badge">{{ count($notify) }}</span>
                                    @endif
                                </div>
                                <ul class="dropdown-menu notif" style="max-height: 500px; overflow-y: auto;">
                                    @if (count($notify) > 0)
                                        @foreach ($notify as $key)
                                            <li>
                                                <a
                                                    href="javascript:ajaxCall('{{ route('exam.result', ['id' => $key->id]) }}','exam-result')">
                                                    <div class="row" style="padding: 10px 5px">
                                                        <div class="col-sm-3">
                                                            <div class="profile-circle-ex">
                                                                <p>{{ substr($key->name, 0, 1) }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-7" style="line-height: .5;">
                                                            <p style="font-size: 1.6rem">{{ $key->name }}</p>
                                                            <p style="font-size: 1.2rem">Just Completed the exam.</p>
                                                            <p class="text-sm text-muted"><i
                                                                    class="fa fa-clock mr-1"></i> 4 Hours Ago</p>
                                                        </div>
                                                        <div class="col-sm-2 text-success"><i
                                                                class="fa fa-star fa-lg"></i></div>
                                                    </div>
                                                </a>
                                            </li>
                                            <div class="dropdown-divider"></div>
                                        @endforeach
                                    @else
                                        <center>
                                            <li>
                                                <p class="text-md text-muted">No Notification</p>
                                            </li>
                                        </center>
                                    @endif
                                </ul>
                            </li>
                            <li style="color: dimgray;">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                    style="border:none ;color:rgb(74, 74, 75)">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <i class="fa fa-user-circle fa-lg" aria-hidden="true"></i>
                                </a>

                                <ul class="dropdown-menu">
                                    <!-- Menu Body -->
                                    <li><a href="#" title="Profile"><i class="fa fa-user"></i>My Profile</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}" title="Logout"
                                            onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <br>
                    @php
                        $color = App\Models\Color::where('user_id', $auth->id)->select('profile_color')->first();
                    @endphp

                    @if ($color)
                        <center>
                            <div class="profile-circle" style="background-color: {{ $color->profile_color }}">
                                <p>{{ substr($auth->name, 0, 1) }}</p>
                            </div>
                        </center>
                        <center>
                            <h3 style="color:white" class="text-muted">{{ ucwords($auth->name) }}</h3>
                        </center>
                    @else
                        <center>
                            <div class="profile-circle" style="background-color: #ccc">
                                <p>{{ substr($auth->name, 0, 1) }}</p>
                            </div>
                        </center>
                        <center>
                            <h3 style="color:white" class="text-muted">{{ ucwords($auth->name) }}</h3>
                        </center>
                    @endif

                    <hr style="border-color: #14213f">

                    <!-- Sidebar Menu -->
                    <center>
                        <p class="text-muted">MAIN MENU</p>
                    </center>

                    <ul class="sidebar-menu" data-widget="tree">
                        <!-- Optionally, you can add icons to the links -->
                        <li id='dash' class="{{ $dash }}">
                            <a href="/admin" title="Dashboard">
                                <i class="fa fa-home"></i> <span>DASHBOARD</span>
                            </a>
                        </li>

                        <li class="treeview {{ $examinees }}">
                            <a href="#">
                                <i class="fa fa-users"></i> <span>Users</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li id='examinees' class="{{ $examinees }}">
                                    <a href="/admin/examinees" title="Examinees">
                                        <i class="fa fa-user"></i> <span>EXAMINEES</span>
                                    </a>
                                </li>
                                <li id='adminlist'>
                                    <a href="{{ route('admin.list') }}" title="Administrators">
                                        <i class="fa fa-shield"></i> <span>Administrators</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li id='questions' class="{{ $questions }}">
                            <a href="/admin/questions" title="Questions">
                                <i class="fa fa-question-circle-o"></i> <span>SUBJECTS</span>
                            </a>
                        </li>

                        <li id='sett' class="{{ $sett }}">
                            <a href="/admin/settings" title="Settings">
                                <i class="fa fa-gear"></i> <span>SETTINGS</span>
                            </a>
                        </li>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>

                <!-- /.sidebar -->

            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @if (Session::has('added'))
                    <div class="alert alert-success sessionmodal">
                        {{ session('added') }}
                    </div>
                @elseif (Session::has('updated'))
                    <div class="alert alert-info sessionmodal">
                        {{ session('updated') }}
                    </div>
                @elseif (Session::has('deleted'))
                    <div class="alert alert-danger sessionmodal">
                        {{ session('deleted') }}
                    </div>
                @endif
                <!-- Main content -->
                <section class="content container-fluid" id="container-fluid">
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <script>
                const type = @json(config('app.env'));
                console.log(type)

                function ajaxCall(url, id) {
                    if (type === 'production') {
                        console.log("test")
                        url = url?.replace('http://', 'https://');
                    }
                    $.ajax({
                        type: "GET",
                        url: url,
                        contentType: false,
                        data: {
                            'id': id
                        },
                        dataType: "html",
                        success: function(data) {
                            $(".content").html(data);
                            $('ul.sidebar-menu > li').removeClass('active');
                            $('#' + id).addClass('active');
                            window.history.pushState("", "", url);

                        },
                        error: function(xhr, status, error) {
                            alert(xhr.responseText);
                        }
                    });
                }
            </script>

    @endif

    <!-- ./wrapper -->
    <!-- REQUIRED JS SCRIPTS -->
    <!-- jQuery 3 -->

    {{-- <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- DataTable -->
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome-iconpicker.min.js') }}"></script> --}}

    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function() {

            $(document).ready(function() {
                $('.sessionmodal').addClass("active");
                setTimeout(function() {
                    $('.sessionmodal').removeClass("active");
                }, 4500);

                $('.dropdown').mouseleave(function() {
                    $('.notif').hide();
                });
                $('.dropdown').mouseenter(function() {
                    $('.notif').show();
                });

            });

            $('#questions_table').DataTable();

            $('#search').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': false,
                'info': false,
                'autoWidth': true,
            });

            $('#topTable').DataTable({
                "order": [
                    [4, "desc"]
                ],
                "lengthMenu": [
                    [5, 10, 15, -1],
                    [5, 10, 15, "All"]
                ],
            });
            //Initialize Select2 Elements
            $('.select2').select2()
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
    </script>


    @if ($setting['right_setting'] == 1)
        <script type="text/javascript" language="javascript">
            // Right click disable
            $(function() {
                $(this).bind("contextmenu", function(inspect) {
                    inspect.preventDefault();
                });
            });
            // End Right click disable
        </script>
    @endif

    @if ($setting['element_setting'] == 1)
        <script type="text/javascript" language="javascript">
            //all controller is disable
            $(function() {
                var isCtrl = false;
                document.onkeyup = function(e) {
                    if (e.which == 17) isCtrl = false;
                }

                document.onkeydown = function(e) {
                    if (e.which == 17) isCtrl = true;
                    if (e.which == 85 && isCtrl == true) {
                        return false;
                    }
                };
                $(document).keydown(function(event) {
                    if (event.keyCode == 123) { // Prevent F12
                        return false;
                    } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
                        return false;
                    }
                });
            });
            // end all controller is disable
        </script>
    @endif
    @yield('scripts')

</body>

</html>
