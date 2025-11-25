@extends('layouts.app')

@section('content')
<div class="container">
  <div style="display:flex;">
    <div style="flex-grow: 2;text-align:center;color:white">
        <center><img src="{{asset('images/logo/logo.png')}}" style="width: 30%;margin:2% 0 2% 0 "></center>
        <center><h1 style="margin-bottom:6%"><strong>{{ucwords($topic->title)}}</strong></h1></center>
        {{-- <h3>{{ucfirst($topic->description)}}</h3> --}}
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td>Time <i class=" fa fa-clock-o"></i></td>
                  <td>{{$topic->timer}} mins</td>
                </tr>
                <tr>
                  <td>Items <i class=" fa fa-file-text-o"></i></td>
                  <td>{{ $topic->question_count }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-4"></div>
        </div>
        <br>
        <center><a class="btn btn-warning btn-lg" style="width: 20%;margin:2% 0 5% 0" href="{{route('aptitude_exam',[$topic->slug,'exam_id'=>Session::get('userID')])}}">Continue <i class="fa fa-arrow-circle-right"></i></a></center>
    </div>
  </div>
</div>
@endsection
