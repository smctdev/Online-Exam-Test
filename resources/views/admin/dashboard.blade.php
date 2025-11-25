@extends('layouts.admin', [
  'dash' => 'active',
  'examinees' => '',
  'quiz' => '',
  'users' => '',
  'questions' => '',
  'sett' => ''
])

@section('content')
@include('message')
<!---->

<div class="container" >
  <h2>Welcome to Smct Online Exam Administration Panel.</h2>
  <br><br>
  <div class="row">
    <div class="col-md-6">
      <div style="display: flex;flex-flow: row wrap; justify-content:space-between">
        <div class="dash-box">
          <div class="dash">
            <p>{{$admin_count}}</p>
            <div class="dash-icons">
              <i class="fa fa-shield"></i> Administrators
            </div>
          </div>
        </div>
        <div class="dash-box" style="background-color: #34495E !important">
          <div class="dash">
            <p>{{$examinee_count}}</p>
            <div class="dash-icons">
              <i class="fa fa-users"></i> Examinees
            </div>
          </div>
        </div>
        <div class="dash-box" style="background-color: #7DCE56 !important">
          <div class="dash">
            <p>{{$topics}}</p>
            <div class="dash-icons">
              <i class="fa fa-book"></i> Subjects
            </div>
          </div>
        </div>
        <div class="dash-box">
          <div class="dash">
            <p>{{$completed_count}}</p>
            <div class="dash-icons">
              <i class="fa fa-check-circle-o"></i> Completed
            </div>
          </div>
        </div>
        <div class="dash-box">
          <div class="dash">
            <p>{{$pending_count}}</p>
            <div class="dash-icons">
              <i class="fa fa-spinner"></i> Pending Exams
            </div>
          </div>
        </div>
        <div class="dash-box">
          <div class="dash">
            <p>0</p>
            <div class="dash-icons">
              <i class="fa fa-shield"></i> Administrators
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="notify-panel">
        <h5>Notification Panel</h5>
        <div class="notify-panel-box">
          @if(!empty($notify))
          <ul class="d-flex gap-2">
            @foreach ($notify  as $key)
            <li>
              <a href="javascript:ajaxCall('{{route('exam.result', ['id' => $key->id])}}','exam-result')">
                <div class="row">
                  <div class="col-sm-2"><div class="profile-circle-ex" ><p>{{substr($key->name,0,1)}}</p></div></div>
                  <div class="col-sm-6" style="line-height:.9;">
                    <p style="font-size: 1.6rem">{{$key->name}}</p>
                    <p style="font-size: 1.3rem" class="text-muted">Just Completed the exam.</p>
                  </div>
                  <div class="col-md-2" style="padding: 0 !important;">
                    <p class="text-sm text-muted"><i class="fa fa-clock mr-1"></i> 4 hrs Ago</p>
                  </div>
                  <div class="col-md-2 text-success"><i class="fa fa-star fa-2x"></i></div>
                </div>
              </a>
            </li>
            @endforeach
          </ul>
          @else
          <center><img src="{{asset('/images/vectors/zeronotif.jpeg')}}" style="width:90%"></center>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
