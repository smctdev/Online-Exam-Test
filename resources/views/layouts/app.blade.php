<!DOCTYPE html>
@php
    $setting = App\Models\Setting::first();
@endphp
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/ico"
        href="{{ asset('images/logo/' . $setting ? $setting['favicon'] : 'favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partial.scripts')
    {{-- <script src="{{ asset('js/jquery.min.js') }}"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"> --}}
    </script>
    <script>
        window.Laravel = @json(['csrfToken' => csrf_token()]);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>SMCT Online Exam</title>
</head>

<body style="background-image: url({{ asset('images/vectors/back1.jpg') }});">
    <div class="ajax-loader">
        <img src="{{ asset('images/vectors/loading.gif') }}" class="img-responsive" />
    </div>
    <div id="app" style="position: relative;">
        @yield('top_bar')
        @yield('content')
    </div>
    @yield('scripts')
</body>

</html>
