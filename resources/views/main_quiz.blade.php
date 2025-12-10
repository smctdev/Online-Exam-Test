@extends('layouts.app')
@section('content')
    <?php
    $auth = Auth::user()?->token;
    $user = App\Models\User::where('token', $auth)->select('id')->get();
    $user = $user[0];
    $users = \DB::table('result')->where('user_id', $user->id)->first();
    $que = App\Models\Question::where('topic_id', $topic->id)->first();
    $que2 = App\Models\Question::where('topic_id', $topic->id)->get();
    $tID = App\Models\Exam::where('user_id', $user->id)->select('exam', 'violation')->get();
    $exam = App\Models\Exam::where('user_id', $user->id)->select('exam', 'violation')->get();
    $tID = explode(',', $tID[0]['exam']);
    $topics = App\Models\Topic::all();
    $topic_ids = [];
    $topic_slugs = [];
    $indx = 0;
    $progessWidth = 100 / count($tID);
    ?>

    <div class="container-fluid py-4">
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

        <div class="exam-container">
            @if (!empty($users))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Already Attempted!</strong> You have already given the test! Try other quizzes.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @else
                <!-- Timer Section -->
                @if (!empty($que))
                    <div class="timer-section mb-4 sticky-top">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-4">
                                        <p class="text-muted mb-0 fw-bolder fs-4">Topic:</p>
                                        <p class="text-muted mb-0 fs-4">{{ $topic->title }}</p>
                                    </div>
                                    <div class="text-center d-flex flex-column col-4">
                                        <h5 class="card-title mb-1 fs-3 text-warning fw-bolder">Time Remaining</h5>
                                        <div id="clock" class="display-6 fw-bold text-warning"></div>
                                        <small class="text-muted fs-4 fw-bold ">HH:MM:SS</small>
                                    </div>
                                    <div class="text-end col-4">
                                        <span class="badge bg-primary fs-4">Question
                                            <span id="currentQuestion">1</span>/{{ sizeof($que2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Question Area -->
                <div id="question_block" class="question-block">
                    <question ref="foo" :topic_id="{{ $topic->id }}"></question>
                </div>
            @endif

            @if (empty($que))
                <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-8 col-sm-10">
                                <!-- Alert Message -->
                                <div class="alert alert-warning alert-dismissible fade show text-center shadow-sm"
                                    role="alert">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="mb-3">
                                            <i class="bi bi-exclamation-triangle-fill fs-1 text-warning"></i>
                                        </div>
                                        <h4 class="alert-heading mb-2">No Questions Available!</h4>
                                        <p class="mb-3">This quiz currently has no questions. You may safely click Finish
                                            Exam; your score will be submitted automatically.</p>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>

                                <!-- Finish Exam Button -->
                                <div class="text-center mt-4">
                                    <form id="finishExam" method="GET" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3 shadow-sm">
                                            <i class="bi bi-check-circle-fill me-2"></i>
                                            Finish Exam
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.review-btn', function(event) {
            $(".sidepanel").slideToggle("fast");
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('finishExam').addEventListener('submit', async function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    beforeSend: function() {
                        $('.ajax-loader').css("visibility", "visible");
                    },
                    url: '/calculate',
                    success: function(data) {
                        $('.ajax-loader').css("visibility", "hidden");
                        location.href = @json(route('exam.completed'));
                        Cookies.remove("time");
                    }
                });
            });
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
                        let queIndex = parseInt($(".myQuestion.active input:hidden[name=queIndex]")
                            .val(), 10);
                        let active = $(".myQuestion.active");

                        if (queIndex >= questions) {
                            console.log('Last question clicked - not advancing DOM');
                            return;
                        } else {
                            active.removeClass("active");
                            active.next().addClass("active");
                            $('#currentQuestion').text(queIndex + 1);
                        }

                        setTimeout(function() {
                            if (window.App && App.$refs && App.$refs.foo) {
                                App.$refs.foo.nxtClick();
                            } else {
                                console.error("App.$refs.foo is not available yet.");
                            }
                        }, 100);
                    });

                    // PREVIOUS
                    $(document).on('click', '.prebtn', function() {
                        let val = parseInt($(this).val(), 10);
                        if (!Number.isInteger(val)) return;
                        var i = val - 1;
                        if (i < 0 || i >= questions) return;
                        var indx = '#que' + i;
                        var active = $(".myQuestion.active");

                        active.removeClass("active");
                        $(indx).addClass("active");
                        $('#currentQuestion').text(i + 1);

                        setTimeout(function() {
                            if (window.App && App.$refs && App.$refs.foo) {
                                App.$refs.foo.prvClick(i);
                            } else {
                                console.error("App.$refs.foo is not available yet.");
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
                        } else {
                            $.ajax({
                                type: 'GET',
                                beforeSend: function() {
                                    $('.ajax-loader').css("visibility", "visible");
                                },
                                url: '/calculate',
                                success: function(data) {
                                    $('.ajax-loader').css("visibility", "hidden");
                                    location.href = @json(route('exam.completed'));
                                    Cookies.remove("time");
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
                            clock.html("<span class='text-danger'>Time's Up!</span>");
                            Swal.fire({
                                icon: 'info',
                                title: "Time's Up!",
                                text: "Time's up! This exam is over and auto submitted.",
                                confirmButtonColor: '#3085d6',
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

        <script>
            var count = 0;
            $(document).ready(function() {
                var body = document.querySelector('body');

                function checkPageFocus() {

                    axios.post(@json(route('violation.count')), {
                        user_id: @json($user->id)
                    }).then(function(response) {

                        count = response.data.violation;

                        if (count <= 5) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Violation Warning!',
                                text: `Warning: Please avoid opening new tab or new browser! Violation: ${count}/5`,
                                confirmButtonColor: '#3085d6',
                            });
                        } else {
                            $.ajax({
                                type: 'GET',
                                beforeSend: function() {
                                    $('.ajax-loader').css("visibility", "visible");
                                },
                                url: '/violation',
                                success: function(data) {
                                    $('.ajax-loader').css("visibility", "hidden");
                                    Cookies.remove("time");
                                    location.reload();
                                }
                            });
                        }
                    });
                }
                body.onblur = checkPageFocus;
            });
        </script>
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
@endpush

<style>
    .exam-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .timer-section .card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .timer-section .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
    }
</style>
