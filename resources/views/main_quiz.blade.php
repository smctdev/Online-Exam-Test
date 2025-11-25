@extends('layouts.app')
@section('top_bar')
    @include('includes.app_nav')
@endsection
@section('content')
    <?php
    $auth = Auth::user()?->token;
    $user = App\Models\User::where('token', $auth)->select('id')->get();
    $user = $user[0];
    $users = \DB::table('result')->where('user_id', $user->id)->first();
    $que = App\Models\Question::where('topic_id', $topic->id)->first();
    $que2 = App\Models\Question::where('topic_id', $topic->id)->get();
    $tID = App\Models\Exam::where('user_id', $user->id)->select('exam')->get();
    $tID = explode(',', $tID[0]['exam']);
    $topics = App\Models\Topic::all();
    $topic_ids = [];
    $topic_slugs = [];
    $indx = 0;
    $progessWidth = 100 / count($tID);
    ?>

    <div class="container-fluid">
        @php
            for ($x = 0; $x < count($tID); $x++) {
                foreach ($topics as $item) {
                    if ($tID[$x] == $item->id) {
                        $topic_ids[$indx] = $item->id;
                        $topic_slugs[$indx] = $item->slug;
                        $indx++;
                    }
                }
            }
        @endphp

        <div class="home-main-block">

            @if (!empty($users))
                <div class="alert alert-danger">
                    You have already Given the test ! Try to give other Quizes
                </div>
            @else
                <div id="question_block" class="question-block">
                    <question ref="foo" :topic_id="{{ $topic->id }}"></question>
                </div>
            @endif
            @if (empty($que))
                <div class="alert alert-danger">
                    No Questions in this quiz
                </div>
            @endif
        </div>
    </div>
    <br /><br />
@endsection
@section('scripts')
    <!-- jQuery 3 -->

    <!-- Bootstrap 3.3.7 -->
    {{-- <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.js') }}"></script> --}}
    <script>
        $(document).on('click', '.review-btn', function(event) {
            $(".sidepanel").slideToggle("fast");
        });
    </script>

    @if (empty($users) && !empty($que))
        <script>
            var topic_id = @json($topic->id);
            var questions = @json(sizeof($que2));
            let topics = @json($topic_ids);
            let slugs = @json($topic_slugs);
            var timer = @json($topic->timer);

            $(document).ready(function() {

                // Disable F5 and Ctrl+R
                $(document).on("keydown", function(e) {
                    let key = e.which || e.keyCode;
                    if (key == 116 || key == 82) e.preventDefault();
                });

                // UI Initialization
                setTimeout(function() {
                    $(".myQuestion:first-child").addClass("active");

                    // NEXT BUTTON
                    $(document).on('click', '.nextbtn', function() {
                        let queIndex = $(".myQuestion.active input:hidden[name=queIndex]").val();
                        let active = $(".myQuestion.active");

                        if (queIndex > questions) {
                            console.log('end');
                        } else {
                            active.removeClass("active");
                            active.next().addClass("active");
                            $(".myForm")[0].reset();
                        }

                        setTimeout(function() {
                            if (window.App && App.$refs && App.$refs.foo) {
                                App.$refs.foo.nxtClick();
                            } else {
                                console.error("App.$refs.foo is not available yet.");
                            }
                        }, 100);
                    });

                    // PREVIOUS BUTTON
                    $(".prebtn").click(function() {
                        var i = $(this).val() - 1;
                        var indx = '#que' + i;
                        var active = $(".myQuestion.active");

                        active.removeClass("active");

                        if (i == questions - 1) {
                            $(indx).next().addClass("active");
                        } else {
                            $(indx).prev().addClass("active");
                        }

                        $(".myForm")[0].reset();

                        setTimeout(function() {
                            if (window.App && App.$refs && App.$refs.foo) {
                                App.$refs.foo.prvClick(i);
                            }
                        }, 100);
                    });

                    // SUBMIT BUTTON
                    $(document).on('click', '.submitBtn', function() {
                        check();
                    });

                }, 1000);

                // Disable Browser Back Button
                history.pushState(null, null, document.URL);
                window.addEventListener("popstate", function() {
                    history.pushState(null, null, document.URL);
                });


                // ============================
                // CHECK FUNCTION
                // ============================
                function check() {
                    console.log(topics[topics.length - 1]);

                    setTimeout(function() {

                        // Has next topic?
                        if (topic_id != topics[topics.length - 1]) {
                            for (let i = 0; i < topics.length; i++) {
                                if (topics[i] > topic_id) {
                                    var url = @json(route('category_title', ['slug' => 'slug']));
                                    url = url.replace('slug', slugs[i]);
                                    location.href = url;
                                    break;
                                }
                            }
                        }

                        // FINAL TOPIC → calculate
                        else {
                            Cookies.remove("time");

                            $.ajax({
                                type: 'GET',
                                beforeSend: function() {
                                    $('.ajax-loader').css("visibility", "visible");
                                },
                                url: '/calculate',
                                success: function(data) {
                                    $('.ajax-loader').css("visibility", "hidden");
                                    location.href = @json(route('exam.completed'));
                                }
                            });
                        }

                    }, 1000);
                }


                // ============================
                // PURE JS COUNTDOWN (NO PLUGIN)
                // ============================

                function startCountdown(endTime) {
                    const clock = $("#clock");

                    let interval = setInterval(function() {

                        let now = Date.now();
                        let diff = endTime - now;

                        // Time expired
                        if (diff <= 0) {
                            clearInterval(interval);
                            clock.html("<span>Time's Up!</span>");
                            Swal.fire({
                                icon: 'info',
                                title: "Time's Up!",
                                text: "Time's up! This exam is over and auto submitted.",
                            })
                            check();
                            return;
                        }

                        let hours = Math.floor(diff / (1000 * 60 * 60));
                        let minutes = Math.floor((diff / (1000 * 60)) % 60);
                        let seconds = Math.floor((diff / 1000) % 60);

                        clock.html(
                            "<span>" +
                            String(hours).padStart(2, "0") + ":" +
                            String(minutes).padStart(2, "0") + ":" +
                            String(seconds).padStart(2, "0") +
                            "</span>"
                        );

                    }, 1000);
                }

                // Create end time
                var now = Date.now();
                var endTime = now + timer * 60000; // timer in minutes → ms

                // If cookie exists → resume countdown
                if (Cookies.get("time") && Cookies.get("topic_id") == topic_id) {
                    let saved = parseInt(Cookies.get("time"));
                    startCountdown(saved);
                }
                // No cookie → create new
                else {
                    Cookies.set("time", endTime, {
                        expires: 1
                    });
                    Cookies.set("topic_id", topic_id, {
                        expires: 1
                    });
                    startCountdown(endTime);
                }

            });
        </script>


        {{-- <script>
            var count = 0;
            $(document).ready(function() {
                var body = document.querySelector('body');

                function checkPageFocus() {
                    count++;
                    if (count <= 5) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Violation Warning!',
                            text: `Warning: Please avoid opening new tab or new browser! Violation: ${count}/5`,
                        })
                    } else {
                        $.ajax({
                            type: 'GET',
                            beforeSend: function() {
                                $('.ajax-loader').css("visibility", "visible");
                            },
                            url: '/violation',
                            success: function(data) {
                                $('.ajax-loader').css("visibility", "hidden");
                                location.href = @json(route('violation'));
                            }
                        });
                    }
                }
                body.onblur = checkPageFocus;
            });
        </script> --}}
    @else
        {{ '' }}
    @endif
    @if ($setting->right_setting == 1)
        <script type="text/javascript" language="javascript">
            $(function() {
                $(this).bind("contextmenu", function(inspect) {
                    inspect.preventDefault();
                });
            });
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
