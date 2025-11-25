@extends('layouts.app')

@section('content')
    <div class="container">
        <div style="display:flex;">
            <img src="{{ asset('images/vectors/woman.png') }}" style="width:22%;margin-left:-300px;">
            <div style="flex-grow: 2">
                @php
                    $fname = Session::get('fname');
                    //$tID = \Crypt::encryptString($topic->id);
                @endphp
                <h2 class="name" style="display:none;">Welcome, <span style="color:yellow">{{ ucwords($fname) }}</span> !
                </h2>
                <h4 class="h-title" style="color: white;display:none;">Before getting started, please read all the
                    instructions carefully.</h4>
                <br>
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8 ">
                        @if (!$exam || !$topic)
                            <div class="instruction">
                                <h4 class="text-center"><strong>No exams yet!</strong></h4>
                            </div>
                        @else
                            <div class="instruction">
                                <h4 class="text-center"><strong>Guidelines During The Exam</strong></h4>
                                <ol>
                                    <li>Time can't be paused
                                        <ul>
                                            <li>Make sure you have stable internet connection.</li>
                                            <li>Answer the exam without any interruption.</li>
                                        </ul>
                                    </li>
                                    <li>Don't resize (minimize) the browser during the exam.</li>
                                    <li>Avoid clicking refresh and back button of the browser or else you will lose all your
                                        answers while your time continues running.</li>
                                    </li>
                                    <li>Avoid opening new tab or other browser, the system can detect it and you will be out
                                        of
                                        the exam.</li>
                                    <li>Exam consist of {{ count($topic) }} categories.
                                        <ul>
                                            @foreach ($topic as $category => $sub)
                                                <li style="display: inline;margin-left:10px">{{ $sub['title'] }}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li>Each category has an allocated time, so answer all the questions before time runs
                                        out.
                                    </li>
                                    <li>You can review your answer if you still have remaining time.</li>
                                    <li>Click the <strong>"Submit"</strong> button in the bottom right corner when you are
                                        ready
                                        to move to the next exam or when you are done.</li>
                                </ol>
                            </div><br>
                            <div class="box">
                                <div class="text-center" style="color: white;"><input type="checkbox" name="read"
                                        id="read" style="cursor:pointer;">&nbsp;I already read and fully understand the
                                    guidelines. </div>
                                <div class="text-center">
                                    <a id ="startexam"class="btn btn-success btn-lg float-right text-center"
                                        style="width: 30%; pointer-events: none" disabled
                                        href="{{ route('category_title', $topic[0]['slug']) }}">Start Exam</a>
                                </div>
                            </div><br>
                        @endif
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("img").animate({
                marginLeft: "0px"
            }, 1000, function() {
                $(".name").fadeIn("slow", function() {
                    $(".h-title").fadeIn("fast", function() {
                        $(".instruction").fadeIn("fast", function() {
                            $(".box").fadeIn();
                        });
                    });
                });
            });

            $('input:checkbox').click(function() {
                if ($(this).is(':checked')) {
                    $('#startexam').removeAttr('disabled');
                    $('#startexam').css("pointer-events", "");
                } else {
                    $('#startexam').attr('disabled', true);
                    $('#startexam').css("pointer-events", "none");
                }
            });

        });
    </script>
@endsection
