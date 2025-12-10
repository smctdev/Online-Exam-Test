@extends('layouts.admin', [
    'dash' => 'active',
    'examinees' => '',
    'quiz' => '',
    'users' => '',
    'questions' => '',
    'sett' => '',
])

@section('content')
    @include('message')

    <div class="container-fluid py-4">
        <h2 class="mb-4">Welcome to SMCT Online Exam Administration Panel</h2>

        <div class="row g-3">
            <!-- Dashboard Cards -->
            <div class="col-lg-6 col-md-12">
                <div class="row g-3">

                    <div class="col-6">
                        <div class="card text-white bg-primary h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h3 class="card-title">{{ $admin_count }}</h3>
                                    <p class="card-text"><i class="fa fa-shield me-2"></i>Administrators</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card text-white" style="background-color: #34495E;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h3 class="card-title">{{ $examinee_count }}</h3>
                                    <p class="card-text"><i class="fa fa-users me-2"></i>Examinees</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card text-white" style="background-color: #7DCE56;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h3 class="card-title">{{ $topics }}</h3>
                                    <p class="card-text"><i class="fa fa-book me-2"></i>Subjects</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card text-white bg-success h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h3 class="card-title">{{ $completed_count }}</h3>
                                    <p class="card-text"><i class="fa fa-check-circle me-2"></i>Completed</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card text-white bg-warning h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h3 class="card-title">{{ $pending_count }}</h3>
                                    <p class="card-text"><i class="fa fa-spinner me-2"></i>Pending Exams</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Notification Panel -->
            <div class="col-lg-6 col-md-12">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Notification Panel</h5>
                    </div>
                    <div @class([
                        'card-body',
                        'p-0' => $notify->isEmpty() && $notify->count() <= 0,
                    ]) style="max-height: 500px; overflow-y:auto;">
                        @if ($notify->isNotEmpty() && $notify->count() > 0)
                            <ul class="list-unstyled">
                                @foreach ($notify as $key)
                                    <li class="mb-2">
                                        <a href="{{ route('exam.result', $key->id) }}"
                                            class="text-decoration-none text-dark">
                                            <div class="d-flex align-items-center p-2 border rounded">
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3"
                                                    style="width:40px; height:40px;">
                                                    <span
                                                        class="text-white fw-bold">{{ strtoupper(substr($key->name, 0, 1)) }}</span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-0 fw-bold">{{ $key->name }}</p>
                                                    <small class="text-muted">Just Completed the exam.</small>
                                                </div>
                                                <div class="text-end ms-2">
                                                    <small class="text-muted"><i
                                                            class="fa fa-clock me-1"></i>{{ $key->result->created_at->diffForHumans() }}</small>
                                                    <div class="text-success mt-1"><i class="fa fa-star"></i></div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center">
                                <img src="{{ asset('images/vectors/zeronotif.jpeg') }}" class="img-fluid w-100"
                                    alt="No Notifications">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
