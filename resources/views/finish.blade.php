@extends('layouts.app')
@section('top_bar')
    <nav class="navbar navbar-default navbar-static-top">
        <div class="nav-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="navbar-header">
                            <!-- Branding Image -->
                            @if ($setting)
                                <a href="{{ url('/') }}" title="{{ $setting->welcome_txt }}"><img
                                        src="{{ asset('/images/vectors/samp.png') }}" class="login-logo img-responsive"
                                        alt="{{ $setting->welcome_txt }}"></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endsection
@section('content')
    <!--<img src="{{ asset('/images/vectors/office.png') }}" class="login-logo img-responsive" alt="{{ $setting->welcome_txt }}" style="width: 100%; height: auto;">-->
    @if (Auth::user()?->status === 'finish')
        <div id="completed" class="delete-modal modal" data-backdrop="static" data-keyboard="false" role="dialog">
            <!-- All Delete Modal -->
            <div class="modal-dialog" style="width: 380px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="{{ asset('/images/vectors/finish.png') }}" class="img-responsive">
                    </div>
                    <div class="modal-body text-center">
                        <h4 style="color:green;"><i class="fa fa-check-circle-o fa-lg"></i><strong> Assessment
                                Completed!</strong></h4>
                        <p>We received your submission and we will just contact you if the overall assessment of your
                            application has positive result.</p>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <a href="/" class="btn btn-success" style="width:50%;">Done</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script type="application/javascript">
    window.addEventListener('load', function() {
        var myModal = new bootstrap.Modal(document.getElementById('completed'));

        document.getElementById('completed').addEventListener('hidden.bs.modal', function () {
            window.location.href = "/login";
        });
        myModal.show();
    });
</script>
@endsection
