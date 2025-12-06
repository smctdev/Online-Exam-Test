@extends('layouts.admin', [
    'page_header' => 'Exam Results',
    'dash' => '',
    'examinees' => 'active',
    'quiz' => '',
    'users' => '',
    'questions' => '',
    'sett' => '',
])

@section('content')
    @php
        $average = 0;
        $overallScore = 0;
        $perfectScore = 0;
        $score = [];
        $x = 0;
        $max = 0;
        $semi_result = json_decode($result, true);

        if (!empty($semi_result)) {
            $semi_result = $semi_result[0];
            $semi_result = json_decode($semi_result['score'], true);
            foreach ($semi_result as $key => $value) {
                $max += $value['max'];
            }
            foreach ($semi_result as $key => $value) {
                $score[$x] = ($value['score'] / $max) * 100;
                $x++;
            }
        }
    @endphp

    <div class="container-fluid">
        <!-- Header with User Selection -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line me-2"></i>Exam Results Dashboard
                        </h3>
                        <div class="card-tools">
                            <div class="input-group" style="width: 300px;">
                                <select id="selUser"
                                    onchange="window.location.href='{{ route('exam.result', '') }}/' + this.value"
                                    class="form-select select2">
                                    @if ($users)
                                        @foreach ($users as $key => $user_list)
                                            <option value="{{ $user_list->id }}"
                                                {{ $user_list->id == $user->id ? 'selected' : '' }}>
                                                {{ $user_list->name }} - {{ $user_list->applied_position }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Results Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Examination Results</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary btn-sm me-2" id="btnprintResult">
                                <i class="fas fa-print me-1"></i> Print
                            </button>
                            <button class="btn btn-danger btn-sm" id="btnExportPDF" title="Save As PDF">
                                <i class="fas fa-file-pdf me-1"></i> Export PDF
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="printResult">
                            <!-- User Info Section -->
                            <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                <div class="text-center">
                                    <div class="avatar-circle-lg bg-primary text-white mx-auto mb-3">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <h4 class="mb-1">{{ ucwords($user->name) }}</h4>
                                    <p class="text-muted mb-2">Examinee ID: {{ hash('crc32b', $user->id) }}</p>
                                    <span class="badge bg-info fs-6 mb-3">{{ $user->applied_position }}</span>

                                    @if (!empty($semi_result))
                                        <div class="mt-4">
                                            <h5>Overall Rating</h5>
                                            <div class="chart-container" style="height: 250px; width: 100%;">
                                                <canvas id="myChart"></canvas>
                                            </div>
                                            @php
                                                $overallScore = 0;
                                                $perfectScore = 0;
                                                $subjectCount = 0;
                                                $totalAverage = 0;

                                                foreach ($semi_result as $subject => $exam) {
                                                    $overallScore += $exam['score'];
                                                    $perfectScore += $exam['max'];
                                                    $percentage = round(($exam['score'] / $exam['max']) * 100, 2);
                                                    $totalAverage += $percentage;
                                                    $subjectCount++;
                                                }

                                                if ($subjectCount > 0) {
                                                    $average = round($totalAverage / $subjectCount, 2);
                                                    $finalStats = $average >= 75 ? 'Passed' : 'Failed';
                                                }
                                            @endphp
                                            <div class="mt-3">
                                                <h4>
                                                    <span
                                                        class="badge bg-{{ ($finalStats ?? '') == 'Passed' ? 'success' : 'danger' }} fs-6">
                                                        {{ $finalStats ?? 'N/A' }}
                                                    </span>
                                                </h4>
                                                @if (isset($average))
                                                    <p class="text-muted mb-0">Average: {{ $average }}%</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Results Table Section -->
                            <div class="col-lg-9 col-md-12">
                                @if (!empty($semi_result))
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Subject</th>
                                                    <th class="text-center">Score</th>
                                                    <th class="text-center">Over</th>
                                                    <th class="text-center">Percentage</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $overallScore = 0;
                                                    $perfectScore = 0;
                                                    $totalAverage = 0;
                                                    $subjectCount = 0;
                                                @endphp

                                                @foreach ($semi_result as $subject => $exam)
                                                    @php
                                                        $overallScore += $exam['score'];
                                                        $perfectScore += $exam['max'];
                                                        $percentage = round(($exam['score'] / $exam['max']) * 100, 2);
                                                        $status = $percentage >= 75 ? 'Passed' : 'Failed';
                                                        $totalAverage += $percentage;
                                                        $subjectCount++;
                                                    @endphp
                                                    <tr>
                                                        <td><strong>{{ $subject }}</strong></td>
                                                        <td class="text-center">{{ $exam['score'] }}</td>
                                                        <td class="text-center">{{ $exam['max'] }}</td>
                                                        <td class="text-center">
                                                            <span
                                                                class="badge bg-{{ $percentage >= 75 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger') }}">
                                                                {{ $percentage }}%
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span
                                                                class="badge bg-{{ $status == 'Passed' ? 'success' : 'danger' }}">
                                                                {{ $status }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @if ($subjectCount > 0)
                                                    @php
                                                        $average = round($totalAverage / $subjectCount, 2);
                                                        $finalStats = $average >= 75 ? 'Passed' : 'Failed';
                                                    @endphp
                                                    <tr class="table-active">
                                                        <td colspan="2" class="text-end"><strong>Average:</strong></td>
                                                        <td class="text-center"><strong>{{ $perfectScore }}</strong></td>
                                                        <td class="text-center">
                                                            <strong
                                                                class="text-{{ $average >= 75 ? 'success' : ($average >= 50 ? 'warning' : 'danger') }}">
                                                                {{ $average }}%
                                                            </strong>
                                                        </td>
                                                        <td class="text-center">
                                                            <strong>
                                                                <span
                                                                    class="badge bg-{{ $finalStats == 'Passed' ? 'success' : 'danger' }}">
                                                                    {{ $finalStats }}
                                                                </span>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between mt-4">
                                        @if (isset($essay) && count($essay) > 0)
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#situationModal">
                                                <i class="fas fa-book-reader me-1"></i> View Essay Answers
                                            </button>
                                        @endif
                                        <div>
                                            <button class="btn btn-info me-2" data-bs-toggle="modal"
                                                data-bs-target="#detailedModal">
                                                <i class="fas fa-chart-bar me-1"></i> Detailed View
                                            </button>
                                            <a href="{{ route('examinees.lists') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left me-1"></i> Back to Examinees
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="fas fa-chart-bar fa-4x text-muted"></i>
                                        </div>
                                        <h4 class="text-muted">No Results Available</h4>
                                        <p class="text-muted">This examinee has not completed any exams yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Essay Answers Modal -->
    <div class="modal fade" id="situationModal" tabindex="-1" aria-labelledby="situationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white" id="situationModalLabel">
                        <i class="fas fa-book-reader me-2"></i>Reading Comprehension - Essay Answers
                    </h5>
                    <div class="modal-tools">
                        <button class="btn btn-light btn-sm me-2" id="btnPrintEssay">
                            <i class="fas fa-print me-1"></i> Print
                        </button>
                        <button class="btn btn-light btn-sm" id="btnExportEssayPDF">
                            <i class="fas fa-file-pdf me-1"></i> Save as PDF
                        </button>
                    </div>
                </div>
                <div class="modal-body" id="printJS-form">
                    <div class="mb-4" id="pname" style="display: none;">
                        <h5>Applicant Name: <strong>{{ ucwords($user->name) }}</strong></h5>
                        <p>Position Applied: {{ $user->applied_position }}</p>
                        <hr>
                    </div>

                    <div class="text-center mb-4">
                        <h4>Reading Comprehension Assessment</h4>
                        <p class="text-muted">Essay Answers</p>
                    </div>

                    <div class="essay-answers">
                        @foreach ($essay as $index => $es)
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Question {{ $index + 1 }}</h5>
                                        <span class="badge bg-primary">Essay Question</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-2">
                                            <i class="fas fa-question-circle me-1"></i> Situation:
                                        </h6>
                                        <div class="bg-light p-3 rounded border">
                                            <p class="mb-0">{{ $es->situation }}</p>
                                        </div>
                                    </div>

                                    <div>
                                        <h6 class="text-success mb-2">
                                            <i class="fas fa-pen-alt me-1"></i> Applicant's Answer:
                                        </h6>
                                        <div class="bg-light p-3 rounded border">
                                            <pre style="white-space: pre-wrap; font-family: inherit; margin: 0; line-height: 1.6;">{{ $es->answer }}</pre>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i> Answered on:
                                                {{ \Illuminate\Support\Carbon::parse($es->created_at)->format('M d, Y h:i A') }}
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <small class="text-muted">
                                                Word Count: {{ str_word_count($es->answer) }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (!$loop->last)
                                <div class="text-center my-3">
                                    <hr class="w-50 mx-auto">
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if (count($essay) === 0)
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-book fa-3x text-muted"></i>
                            </div>
                            <h4 class="text-muted">No Essay Answers Available</h4>
                            <p class="text-muted">This examinee has not completed any essay questions.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Essay Answers Modal -->
    <div class="modal fade" id="situationModal" tabindex="-1" aria-labelledby="situationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white" id="situationModalLabel">
                        <i class="fas fa-book-reader me-2"></i>Reading Comprehension - Essay Answers
                    </h5>
                    <div class="modal-tools">
                        <button class="btn btn-light btn-sm me-2" id="btnPrintEssay">
                            <i class="fas fa-print me-1"></i> Print
                        </button>
                        <button class="btn btn-light btn-sm" id="btnExportEssayPDF">
                            <i class="fas fa-file-pdf me-1"></i> Save as PDF
                        </button>
                    </div>
                </div>
                <div class="modal-body" id="printJS-form">
                    <div class="mb-4" id="pname" style="display: none;">
                        <h5>Applicant Name: <strong>{{ ucwords($user->name) }}</strong></h5>
                        <p>Position Applied: {{ $user->applied_position }}</p>
                        <hr>
                    </div>

                    <div class="text-center mb-4">
                        <h4>Reading Comprehension Assessment</h4>
                        <p class="text-muted">Essay Answers</p>
                    </div>

                    <div class="essay-answers">
                        @foreach ($essay as $index => $es)
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Question {{ $index + 1 }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6>Situation:</h6>
                                        <p class="mb-0">{{ $es->situation }}</p>
                                    </div>
                                    <div>
                                        <h6>Answer:</h6>
                                        <div class="bg-light p-3 rounded">
                                            <pre style="white-space: pre-wrap; font-family: inherit; margin: 0;">{{ $es->answer }}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Results Modal -->
    <div class="modal fade" id="detailedModal" tabindex="-1" aria-labelledby="detailedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="detailedModalLabel">
                        <i class="fas fa-chart-bar me-2"></i>Detailed Examination Results
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <h5>Applicant Name: <strong>{{ ucwords($user->name) }}</strong></h5>
                        <p>Examinee ID: {{ hash('crc32b', $user->id) }}</p>
                        <p>Position Applied: {{ $user->applied_position }}</p>
                    </div>

                    @if (!empty($semi_result))
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Subject</th>
                                        <th class="text-center">Score</th>
                                        <th class="text-center">Maximum</th>
                                        <th class="text-center">Percentage</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Performance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semi_result as $subject => $exam)
                                        @php
                                            $percentage = round(($exam['score'] / $exam['max']) * 100, 2);
                                            $status = $percentage >= 75 ? 'Passed' : 'Failed';
                                        @endphp
                                        <tr>
                                            <td><strong>{{ $subject }}</strong></td>
                                            <td class="text-center">{{ $exam['score'] }}</td>
                                            <td class="text-center">{{ $exam['max'] }}</td>
                                            <td class="text-center">{{ $percentage }}%</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $status == 'Passed' ? 'success' : 'danger' }}">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-{{ $percentage >= 75 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger') }}"
                                                        role="progressbar" style="width: {{ $percentage }}%"
                                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        {{ $percentage }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar-circle-lg {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 48px;
            margin: 0 auto;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .progress {
            border-radius: 10px;
            overflow: hidden;
        }

        .badge {
            font-size: 0.85em;
            padding: 0.35em 0.65em;
        }

        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        }

        .essay-answers pre {
            font-size: 14px;
            line-height: 1.6;
        }

        .chart-container {
            position: relative;
            margin: auto;
        }

        @media print {

            .card-header,
            .modal-header,
            .btn,
            .card-tools {
                display: none !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            .table {
                border: 1px solid #dee2e6 !important;
            }

            #pname {
                display: block !important;
            }
        }

        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px;
            border-color: #ced4da;
        }
    </style>
@endpush

@push('scripts')
    <script>
        @if (!empty($score) && isset($average))
            var data = @json($score);
            var average = @json($average);

            // Check if chart container exists
            if (document.getElementById('myChart')) {
                var ctx = document.getElementById('myChart').getContext('2d');

                // Prepare labels based on subjects
                var labels = [];
                @if (!empty($semi_result))
                    @foreach ($semi_result as $subject => $exam)
                        labels.push("{{ $subject }}");
                    @endforeach
                @endif

                // Create chart
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels.length > 0 ? labels : ['Overall Score'],
                        datasets: [{
                            data: data.length > 0 ? data : [average],
                            backgroundColor: [
                                '#2ecc71', '#3498db', '#9b59b6', '#f1c40f',
                                '#e74c3c', '#1abc9c', '#34495e', '#d35400',
                                '#7f8c8d', '#27ae60', '#8e44ad', '#f39c12'
                            ],
                            borderWidth: 2,
                            borderColor: '#fff',
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        var label = context.label || '';
                                        var value = context.parsed || 0;
                                        return label + ': ' + value.toFixed(1) + '%';
                                    }
                                }
                            }
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });

                // Add center text plugin
                Chart.register({
                    id: 'centerText',
                    afterDraw: function(chart) {
                        if (chart.data.datasets[0].data.length > 0) {
                            var width = chart.width,
                                height = chart.height,
                                ctx = chart.ctx;

                            ctx.restore();

                            // Calculate average
                            var total = 0;
                            chart.data.datasets[0].data.forEach(function(value) {
                                total += value;
                            });
                            var avg = average || (total / chart.data.datasets[0].data.length);

                            // Set font
                            var fontSize = Math.min(width, height) / 5;
                            ctx.font = "bold " + fontSize + "px Arial";
                            ctx.textBaseline = "middle";
                            ctx.textAlign = "center";
                            ctx.fillStyle = avg >= 75 ? '#2ecc71' : (avg >= 50 ? '#f39c12' :
                                '#e74c3c');

                            // Draw percentage
                            var textX = Math.round(width / 2);
                            var textY = Math.round(height / 2) - (fontSize * 0.2);
                            ctx.fillText(avg.toFixed(1) + "%", textX, textY);

                            // Draw label
                            ctx.font = "bold " + (fontSize * 0.4) + "px Arial";
                            ctx.fillStyle = '#666';
                            ctx.fillText('Average', textX, textY + (fontSize * 0.7));

                            ctx.save();
                        }
                    }
                });

                // Make chart responsive on window resize
                $(window).on('resize', function() {
                    myChart.resize();
                });
            }
        @else
            // If no data, show a placeholder message
            if (document.getElementById('myChart')) {
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['No Data'],
                        datasets: [{
                            data: [100],
                            backgroundColor: ['#e9ecef'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        @endif

        $(document).ready(function() {
            // Initialize Select2
            $('#selUser').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Select examinee...',
                allowClear: false
            });

            // Handle user selection change
            $('#selUser').on('change', function(e) {
                var id = $(this).val();
                if (id) {
                    var url = "{{ route('exam.result', ':id') }}";
                    url = url.replace(':id', id);
                    window.location.href = url;
                }
            });

            // Print results
            $('#btnprintResult').on('click', function() {
                var printContents = document.getElementById('printResult').innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = `
                <html>
                    <head>
                        <title>Exam Results - {{ $user->name }}</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            body { padding: 20px; }
                            .badge { padding: 0.35em 0.65em; }
                            .table { margin-bottom: 1rem; }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h2 class="text-center mb-4">Examination Results</h2>
                            ${printContents}
                        </div>
                    </body>
                </html>
            `;

                window.print();
                document.body.innerHTML = originalContents;
                window.location.reload();
            });

            // Print essay answers
            $('#btnPrintEssay').on('click', function() {
                var printContents = document.getElementById('printJS-form').innerHTML;
                var originalContents = document.body.innerHTML;

                // Show the hidden name section
                document.getElementById('pname').style.display = 'block';

                document.body.innerHTML = `
                <html>
                    <head>
                        <title>Essay Answers - {{ $user->name }}</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            body { padding: 20px; }
                            .card { border: 1px solid #dee2e6; margin-bottom: 20px; }
                            pre { white-space: pre-wrap; font-family: inherit; }
                        </style>
                    </head>
                    <body>
                        ${printContents}
                    </body>
                </html>
            `;

                window.print();
                document.body.innerHTML = originalContents;
                window.location.reload();
            });

            // Export PDF function for main results
            $('#btnExportPDF').on('click', function() {
                exportPDF('{{ route('examresult.pdf') }}', {{ $user->id }});
            });

            // Export PDF function for essay answers
            $('#btnExportEssayPDF').on('click', function() {
                exportPDF('{{ route('situation.pdf') }}', {{ $user->id }});
            });

            // Initialize chart if data exists

        });
    </script>
@endpush
