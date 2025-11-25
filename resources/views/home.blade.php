@extends('layouts.app')

@section('top_bar')
    <!--<nav class="navbar navbar-default navbar-static-top">
                        <div class="nav-bar">
                          <div class="container">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="navbar-header">
                                   Branding Image
                                  @if ($setting)
    <img src="{{ asset('/images/vectors/samp.png') }}" class="login-logo img-responsive" alt="{{ $setting->welcome_txt }}">
    @endif
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </nav>--><br><br>
@endsection

@section('content')
    <div class="container  h-100">
        <div class="row  h-100 justify-content-center align-items-center">
            <div class="col-md-8 col-md-offset-2">
                <div class="home-main-block">
                    <h1 class="main-block-heading text-center font-weight-bold" style="color: antiquewhite;">Online
                        Assessment</h1>
                    <br />
                    <div class="row one-edge-shadow">
                        <div class="col-xs-6 ">
                            @if ($setting)
                                <img src="{{ asset('/images/vectors/hello.svg') }}" class="img-responsive"
                                    alt="{{ $setting->welcome_txt }}">
                            @endif
                        </div>
                        <div class="col-xs-6 ">
                            <div>
                                @php
                                    $utoken = $user->token;
                                    $names = \App\Helper\Helper::splitname($user->name);
                                    $fname = $names[0];
                                    Session::put('fname', $fname);
                                    Session::put('utoken', $utoken);
                                    Session::put('userID', bin2hex(random_bytes($user->id)));
                                @endphp
                                <h2 style="color:#2F3180;"><strong> Hello {{ $fname }}!</strong></h2>
                                <h4 style="color:#2F3180;">Please verify your email to proceed.</h4>
                                <br />
                                <div id="sendcode">
                                    <br>
                                    <form id="sendForm" method="POST">
                                        @csrf
                                        <input type="hidden" name="email" id="email" value="{{ $user->email }}">
                                        <button type="submit" class="btn btn-primary btn-lg" style="width: 80%;">
                                            <i class="fa fa-envelope"></i> <span>Verify Email</span>
                                        </button>
                                    </form>
                                </div>
                                <a href="{{ route('logout') }}" class="btn btn-danger" style="width: 80%; margin-top: 10px;">Logout</a>
                                <div id="verifycode" style="display: none">
                                    <p>Verification code was sent to your email.</p>
                                    <p>Did not recieve a code: <a id="resend" style="cursor:pointer">Resend Code</a></p>
                                    <form id="verifyForm">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="hidden" id="id" value="{{ $user->id }}">
                                            <center><input id="code" type="text" class="form-control text-center"
                                                    style="font-weight: bold" required autofocus></center>
                                            <center><strong id='codeError' style="color: red;display:none;">Code
                                                    Incorrect!</strong></center>
                                        </div>
                                        <button class="btn btn-primary btn-lg" type="submit" style="width: 100%"> <i
                                                class="fa fa-check-circle"></i><span>Verify Code</span> </button>
                                    </form>
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
        const isProduction = @json(config('app.env') === 'production');
        const verify = isProduction ? @json(route('verify.email')).replace('http://', 'https://') :
            @json(route('verify.email'));
        const check = isProduction ? @json(route('check.code')).replace('http://', 'https://') :
            @json(route('check.code'));
        const startQuiz = isProduction ? @json(route('start_quiz')).replace('http://', 'https://') :
            @json(route('start_quiz'));
        $(document).ready(function() {
            $('#resend').on('click', function() {
                $('#sendForm').submit();
            });
            $('#sendForm').on('submit', function(event) {
                event.preventDefault();
                let email = $('#email').val();
                $(this).find('button').children('span').empty();
                $(this).find('button').children('i').removeClass("fa fa-envelope").addClass(
                    "fa fa-spinner fa-pulse fa-fw");
                $.ajax({
                    url: verify,
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'email': email,
                    },

                    success: function(response) {
                        $('#sendcode').hide();
                        $('#verifycode').show();
                    },
                    error: function(response) {
                        console.log(response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                });
            });
            $('#verifyForm').on('submit', function(event) {
                event.preventDefault();
                let code = $('#code').val();
                let id = $('#id').val();
                let formID = $(this);
                formID.find('button').children('span').empty();
                formID.find('button').children('i').removeClass("fa fa-check-circle").addClass(
                    "fa fa-spinner fa-pulse fa-fw");
                $.ajax({
                    url: check,
                    type: "GET",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'code': code,
                        'id': id
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#codeError').hide();
                            window.location.href = startQuiz;

                        } else {
                            $('#codeError').show();
                            formID.find('button').children('i').removeClass(
                                "fa fa-spinner fa-pulse fa-fw").addClass(
                                "fa fa-check-circle");
                            formID.find('button').children('span').text('Verify Code');

                        }
                    },
                    error: function(response) {
                        console.log(response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                });
            });
        });
    </script>

    @if ($setting->right_setting == 1)
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

    @if ($setting->element_setting == 1)
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
@endsection
