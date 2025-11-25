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
    <div class="">
        <div class="container">
            <div class="login-page">
                <div class="logo">
                    @if ($setting)
                        <a href="{{ url('/') }}" title="{{ $setting->welcome_txt }}"><img
                                src="{{ asset('/images/logo/' . $setting->logo) }}" class="img-responsive login-logo"
                                alt="{{ $setting->welcome_txt }}"></a>
                    @endif
                </div>
                <h3 class="user-register-heading text-center">Register</h3>
                <div class="w-100 d-flex justify-content-center">
                    <form class="" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control form-control" required placeholder="Enter your name">
                            <small class="text-danger">{{ $errors->first('name') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Email address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="eg: foo@bar.com">
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required
                                placeholder="Enter Password">
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required
                                placeholder="Confirm Password">
                            <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                        </div>

                        <div class="mr-t-20">
                            <button type="submit" class="btn btn-wave">Create Account</button>
                            <a href="{{ url('/login') }}" class="text-center btn-block">Already Have Account?</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
