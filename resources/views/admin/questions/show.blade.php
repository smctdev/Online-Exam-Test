@extends('layouts.admin', [
    'page_header' => "{$topic->title} / Questions",
    'dash' => '',
    'examinees' => '',
    'quiz' => '',
    'users' => '',
    'questions' => 'active',
    'sett' => '',
])

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-question-circle me-2"></i>Questions Management
                            <small class="text-muted">for "{{ $topic->title }}"</small>
                        </h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#createModal">
                                    <i class="fas fa-plus"></i> Add Question
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#importQuestions">
                                    <i class="fas fa-file-import"></i> Import Questions
                                </button>
                                @if (!$questions->isEmpty())
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#uploadImgs">
                                        <i class="fas fa-images"></i> Upload Images
                                    </button>
                                @endif
                                <a href="{{ route('questions.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to Exams
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-primary">
                                        <i class="fas fa-question"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Questions</span>
                                        <span class="info-box-number">{{ $questions->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-success">
                                        <i class="fas fa-list-ol"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Multiple Choice</span>
                                        <span
                                            class="info-box-number">{{ $questions->where('type', 'multiple')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-warning">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Essay Questions</span>
                                        <span
                                            class="info-box-number">{{ $questions->where('type', 'essay')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-info">
                                        <i class="fas fa-image"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">With Images</span>
                                        <span
                                            class="info-box-number">{{ $questions->whereNotNull('question_img')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Question Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="createModalLabel">
                            <i class="fas fa-plus-circle me-2"></i>Add New Question
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ action([App\Http\Controllers\QuestionsController::class, 'store']) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="topic_id" value="{{ $topic->id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="question" class="form-label">Question <span
                                                class="text-danger">*</span></label>
                                        <textarea name="question" id="question" class="form-control @error('question') is-invalid @enderror" rows="6"
                                            placeholder="Enter the question here..." required>{{ old('question') }}</textarea>
                                        @error('question')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="underline" class="form-label">Words to Underline</label>
                                        <textarea name="underline" id="underline" class="form-control @error('underline') is-invalid @enderror" rows="3"
                                            placeholder="Separate words with commas">{{ old('underline') }}</textarea>
                                        @error('underline')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Separate multiple words with commas (e.g., important,
                                            key, main)</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="question_img" class="form-label">Question Image</label>
                                        <input type="file" name="question_img" id="question_img"
                                            class="form-control @error('question_img') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg">
                                        @error('question_img')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Allowed formats: JPG, JPEG, PNG (Max: 2MB)</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Question Type <span
                                                class="text-danger">*</span></label>
                                        <select name="type" id="type"
                                            class="form-select @error('type') is-invalid @enderror" required>
                                            <option value="" disabled selected>Select question type</option>
                                            <option value="multiple" {{ old('type') == 'multiple' ? 'selected' : '' }}>
                                                Multiple Choice</option>
                                            <option value="essay" {{ old('type') == 'essay' ? 'selected' : '' }}>Essay
                                            </option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3" id="choices-section">
                                        <label for="choices" class="form-label">Answer Choices</label>
                                        <textarea name="choices" id="choices" class="form-control @error('choices') is-invalid @enderror" rows="6"
                                            placeholder="Enter choices separated by commas">{{ old('choices') }}</textarea>
                                        @error('choices')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Separate each choice with a comma (e.g., Option A, Option
                                            B, Option C)</small>
                                    </div>

                                    <div class="mb-3" id="answer-section">
                                        <label for="answer" class="form-label">Correct Answer</label>
                                        <input type="text" name="answer" id="answer"
                                            class="form-control @error('answer') is-invalid @enderror"
                                            placeholder="Enter the correct answer" value="{{ old('answer') }}">
                                        @error('answer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Add Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import Questions Modal -->
        <div class="modal fade" id="importQuestions" tabindex="-1" aria-labelledby="importQuestionsLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-white" id="importQuestionsLabel">
                            <i class="fas fa-file-import me-2"></i>Import Questions from Excel
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST"
                        action="{{ action([App\Http\Controllers\QuestionsController::class, 'importExcelToDB']) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">

                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Instructions:</strong> Upload an Excel file with database field headers.
                                <a href="{{ route('export') }}" class="alert-link">Download template</a>.
                            </div>

                            <div class="mb-3">
                                <label for="question_file" class="form-label">Excel File <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="question_file" id="question_file"
                                    class="form-control @error('question_file') is-invalid @enderror"
                                    accept=".csv,.xlsx,.xls" required>
                                @error('question_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Supported formats: CSV, XLS, XLSX (Max: 5MB)</small>
                            </div>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Important:</strong> Ensure column headers match the database field names exactly.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-upload me-1"></i> Import Questions
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Upload Images Modal -->
        <div class="modal fade" id="uploadImgs" tabindex="-1" aria-labelledby="uploadImgsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title text-white" id="uploadImgsLabel">
                            <i class="fas fa-images me-2"></i>Upload Multiple Images
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST"
                        action="{{ action([App\Http\Controllers\AdminController::class, 'uploadImages']) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">

                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Upload multiple images to be associated with questions in this exam.
                            </div>

                            <div class="mb-3">
                                <label for="img" class="form-label">Select Images <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="img[]" id="img"
                                    class="form-control @error('img') is-invalid @enderror"
                                    accept="image/png,image/jpeg,image/gif,image/svg+xml" multiple required>
                                @error('img')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">You can select multiple images. Supported formats: PNG, JPEG,
                                    GIF, SVG</small>
                            </div>

                            <div class="progress d-none" id="upload-progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    style="width: 0%"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-upload me-1"></i> Upload Images
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Questions Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Questions List ({{ $questions->count() }})</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search questions...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table id="questions_table" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="40%">Question</th>
                                    <th width="20%">Choices</th>
                                    <th width="15%">Correct Answer</th>
                                    <th width="10%">Type</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($questions && count($questions) > 0)
                                    @foreach ($questions as $key => $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="question-text">
                                                    {!! nl2br(e($question->question)) !!}
                                                    @if ($question->underline)
                                                        <div class="mt-1">
                                                            <small class="text-muted">
                                                                <i class="fas fa-underline me-1"></i>
                                                                Underlined: {{ $question->underline }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if ($question->type === 'multiple' && $question->choices)
                                                    @php
                                                        $choices = json_decode($question->choices);
                                                    @endphp
                                                    @if (is_array($choices))
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($choices as $index => $choice)
                                                                <li>
                                                                    <span class="badge bg-light text-dark">
                                                                        {{ chr(65 + $index) }}. {{ $choice }}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">No choices</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">Essay</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($question->type === 'multiple')
                                                    <span class="badge bg-success">{{ $question->answer }}</span>
                                                @else
                                                    <span class="badge bg-warning">Essay Answer</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($question->type === 'multiple')
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-list-ol me-1"></i> Multiple
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-edit me-1"></i> Essay
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $question->id }}"
                                                        title="Edit Question">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $question->id }}"
                                                        title="Delete Question">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    @if ($question->question_img)
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#imageModal{{ $question->id }}"
                                                            title="View Image">
                                                            <i class="fas fa-image"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <!-- Edit Question Modal -->
                                                <div class="modal fade" id="editModal{{ $question->id }}" tabindex="-1"
                                                    aria-labelledby="editModalLabel{{ $question->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-info">
                                                                <h5 class="modal-title text-white"
                                                                    id="editModalLabel{{ $question->id }}">
                                                                    <i class="fas fa-edit me-2"></i>Edit Question
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ action([App\Http\Controllers\QuestionsController::class, 'update'], $question->id) }}"
                                                                enctype="multipart/form-data"
                                                                id="editForm{{ $question->id }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="topic_id"
                                                                        value="{{ $topic->id }}">

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for="question{{ $question->id }}"
                                                                                    class="form-label">Question <span
                                                                                        class="text-danger">*</span></label>
                                                                                <textarea name="question" id="question{{ $question->id }}"
                                                                                    class="form-control @error('question') is-invalid @enderror" rows="6"
                                                                                    placeholder="Enter the question here..." required>{{ old('question', $question->question) }}</textarea>
                                                                                @error('question')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="underline{{ $question->id }}"
                                                                                    class="form-label">Words to
                                                                                    Underline</label>
                                                                                <textarea name="underline" id="underline{{ $question->id }}"
                                                                                    class="form-control @error('underline') is-invalid @enderror" rows="3"
                                                                                    placeholder="Separate words with commas">{{ old('underline', $question->underline) }}</textarea>
                                                                                @error('underline')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                                <small class="text-muted">Separate multiple
                                                                                    words with commas (e.g., important, key,
                                                                                    main)</small>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label
                                                                                    for="question_img{{ $question->id }}"
                                                                                    class="form-label">Question
                                                                                    Image</label>

                                                                                @if ($question->question_img)
                                                                                    <div class="mb-2">
                                                                                        <div class="alert alert-info">
                                                                                            <i
                                                                                                class="fas fa-image me-2"></i>
                                                                                            Current Image:
                                                                                            {{ $question->question_img }}
                                                                                        </div>
                                                                                        <img src="{{ asset('storage/question_img/' . $question->question_img) }}"
                                                                                            class="img-thumbnail mb-2"
                                                                                            style="max-height: 150px;"
                                                                                            alt="Current Image">
                                                                                        <div class="form-check mb-2">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="remove_image"
                                                                                                id="removeImage{{ $question->id }}">
                                                                                            <label class="form-check-label"
                                                                                                for="removeImage{{ $question->id }}">
                                                                                                Remove current image
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif

                                                                                <input type="file" name="question_img"
                                                                                    id="question_img{{ $question->id }}"
                                                                                    class="form-control @error('question_img') is-invalid @enderror"
                                                                                    accept="image/jpeg,image/png,image/jpg">
                                                                                @error('question_img')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                                <small class="text-muted">Leave empty to
                                                                                    keep current image. Allowed formats:
                                                                                    JPG, JPEG, PNG (Max: 2MB)</small>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for="type{{ $question->id }}"
                                                                                    class="form-label">Question Type <span
                                                                                        class="text-danger">*</span></label>
                                                                                <select name="type"
                                                                                    id="type{{ $question->id }}"
                                                                                    class="form-select @error('type') is-invalid @enderror edit-question-type"
                                                                                    data-question-id="{{ $question->id }}"
                                                                                    required>
                                                                                    <option value="multiple"
                                                                                        {{ old('type', $question->type) == 'multiple' ? 'selected' : '' }}>
                                                                                        Multiple Choice
                                                                                    </option>
                                                                                    <option value="essay"
                                                                                        {{ old('type', $question->type) == 'essay' ? 'selected' : '' }}>
                                                                                        Essay
                                                                                    </option>
                                                                                </select>
                                                                                @error('type')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="mb-3 edit-choices-section"
                                                                                id="editChoicesSection{{ $question->id }}"
                                                                                style="{{ $question->type == 'essay' ? 'display: none;' : '' }}">
                                                                                <label for="choices{{ $question->id }}"
                                                                                    class="form-label">Answer
                                                                                    Choices</label>
                                                                                @php
                                                                                    $choicesArray = json_decode(
                                                                                        $question->choices,
                                                                                    );
                                                                                    $choicesText = is_array(
                                                                                        $choicesArray,
                                                                                    )
                                                                                        ? implode(',', $choicesArray)
                                                                                        : '';
                                                                                @endphp
                                                                                <textarea name="choices" id="choices{{ $question->id }}"
                                                                                    class="form-control @error('choices') is-invalid @enderror edit-choices" rows="6"
                                                                                    placeholder="Enter choices separated by commas" {{ $question->type == 'multiple' ? 'required' : '' }}>{{ old('choices', $choicesText) }}</textarea>
                                                                                @error('choices')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                                <small class="text-muted">Separate each
                                                                                    choice with a comma (e.g., Option A,
                                                                                    Option B, Option C)</small>
                                                                            </div>

                                                                            <div class="mb-3"
                                                                                id="editAnswerSection{{ $question->id }}">
                                                                                <label for="answer{{ $question->id }}"
                                                                                    class="form-label">Correct
                                                                                    Answer</label>

                                                                                @if ($question->type == 'multiple' && is_array($choicesArray) && count($choicesArray) > 0)
                                                                                    <select name="answer"
                                                                                        id="answer{{ $question->id }}"
                                                                                        class="form-select @error('answer') is-invalid @enderror edit-answer-select">
                                                                                        @foreach ($choicesArray as $choice)
                                                                                            <option
                                                                                                value="{{ $choice }}"
                                                                                                {{ old('answer', $question->answer) == $choice ? 'selected' : '' }}>
                                                                                                {{ $choice }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                @else
                                                                                    <input type="text" name="answer"
                                                                                        id="answer{{ $question->id }}"
                                                                                        class="form-control @error('answer') is-invalid @enderror edit-answer-input"
                                                                                        placeholder="{{ $question->type == 'multiple' ? 'Enter the correct answer from choices' : 'Enter the expected answer for essay' }}"
                                                                                        value="{{ old('answer', $question->answer) }}">
                                                                                @endif

                                                                                @error('answer')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}</div>
                                                                                @enderror

                                                                                @if ($question->type == 'multiple')
                                                                                    <small class="text-muted">Select the
                                                                                        correct answer from the choices
                                                                                        above</small>
                                                                                @else
                                                                                    <small class="text-muted">Enter the
                                                                                        expected answer for essay
                                                                                        questions</small>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-info">
                                                                        <i class="fas fa-save me-1"></i> Update Question
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                @push('scripts')
                                                    <script>
                                                        $(document).ready(function() {
                                                            // Handle question type change for edit modals
                                                            $('.edit-question-type').on('change', function() {
                                                                const questionId = $(this).data('question-id');
                                                                const type = $(this).val();
                                                                const choicesSection = $('#editChoicesSection' + questionId);
                                                                const answerSection = $('#editAnswerSection' + questionId);
                                                                const choicesInput = $('#choices' + questionId);
                                                                const answerInput = $('#answer' + questionId);

                                                                if (type === 'multiple') {
                                                                    choicesSection.show();
                                                                    choicesInput.prop('required', true);

                                                                    // Replace input with select if needed
                                                                    if (answerInput.is('input')) {
                                                                        const currentValue = answerInput.val();
                                                                        answerInput.replaceWith(
                                                                            '<select name="answer" id="answer' + questionId +
                                                                            '" class="form-select edit-answer-select">' +
                                                                            '<option value="">Select an answer</option>' +
                                                                            '</select>'
                                                                        );
                                                                    }
                                                                } else {
                                                                    choicesSection.hide();
                                                                    choicesInput.prop('required', false);

                                                                    // Replace select with input if needed
                                                                    if (answerInput.is('select')) {
                                                                        const currentValue = answerInput.val();
                                                                        answerInput.replaceWith(
                                                                            '<input type="text" name="answer" id="answer' + questionId + '" ' +
                                                                            'class="form-control edit-answer-input" ' +
                                                                            'placeholder="Enter the expected answer for essay" value="' + currentValue +
                                                                            '">'
                                                                        );
                                                                    }
                                                                }
                                                            });

                                                            // Update answer dropdown when choices change
                                                            $('.edit-choices').on('input', function() {
                                                                const textareaId = $(this).attr('id');
                                                                const questionId = textareaId.replace('choices', '');
                                                                const choicesText = $(this).val();

                                                                if ($('#type' + questionId).val() === 'multiple') {
                                                                    const choices = choicesText.split(',').map(choice => choice.trim()).filter(choice =>
                                                                        choice);
                                                                    const answerSelect = $('#answer' + questionId);

                                                                    if (answerSelect.is('select')) {
                                                                        const currentValue = answerSelect.val();
                                                                        answerSelect.empty();

                                                                        choices.forEach(choice => {
                                                                            answerSelect.append(
                                                                                $('<option>', {
                                                                                    value: choice,
                                                                                    text: choice,
                                                                                    selected: choice === currentValue
                                                                                })
                                                                            );
                                                                        });

                                                                        // If current value not in new choices, select first
                                                                        if (choices.length > 0 && !choices.includes(currentValue)) {
                                                                            answerSelect.val(choices[0]);
                                                                        }
                                                                    }
                                                                }
                                                            });

                                                            // Image preview for edit modals
                                                            $('input[name="question_img"]').on('change', function() {
                                                                const inputId = $(this).attr('id');
                                                                const questionId = inputId.replace('question_img', '');
                                                                const file = this.files[0];

                                                                if (file) {
                                                                    const reader = new FileReader();
                                                                    reader.onload = function(e) {
                                                                        $('#imagePreview' + questionId).remove();
                                                                        $(this).after(
                                                                            '<div id="imagePreview' + questionId + '" class="mt-2">' +
                                                                            '<img src="' + e.target.result +
                                                                            '" class="img-thumbnail" style="max-height: 150px;">' +
                                                                            '</div>'
                                                                        );
                                                                    }.bind(this);
                                                                    reader.readAsDataURL(file);
                                                                }
                                                            });

                                                            // Remove image checkbox handling
                                                            $('input[name="remove_image"]').on('change', function() {
                                                                const questionId = $(this).attr('id').replace('removeImage', '');
                                                                const fileInput = $('#question_img' + questionId);

                                                                if ($(this).is(':checked')) {
                                                                    fileInput.prop('disabled', true);
                                                                    fileInput.val('');
                                                                } else {
                                                                    fileInput.prop('disabled', false);
                                                                }
                                                            });

                                                            // Auto-focus on question field when modal opens
                                                            $('#editModal{{ $question->id }}').on('shown.bs.modal', function() {
                                                                $(this).find('textarea[name="question"]').focus();
                                                            });

                                                            // Form validation for edit modal
                                                            $('#editForm{{ $question->id }}').on('submit', function(e) {
                                                                const type = $('#type{{ $question->id }}').val();
                                                                const choices = $('#choices{{ $question->id }}').val();

                                                                if (type === 'multiple' && (!choices || choices.trim() === '')) {
                                                                    e.preventDefault();
                                                                    Swal.fire({
                                                                        icon: 'error',
                                                                        title: 'Validation Error',
                                                                        text: 'Please enter choices for multiple choice questions.',
                                                                    });
                                                                    $('#choices{{ $question->id }}').focus();
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                @endpush

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{ $question->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger">
                                                                <h5 class="modal-title text-white">
                                                                    <i class="fas fa-trash me-2"></i>Delete Question
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ action([App\Http\Controllers\QuestionsController::class, 'destroy'], $question->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="modal-body text-center">
                                                                    <div class="mb-3">
                                                                        <i
                                                                            class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                                                                    </div>
                                                                    <h4>Are You Sure?</h4>
                                                                    <p>Do you really want to delete this question?</p>
                                                                    <div class="alert alert-warning">
                                                                        <strong>Question:</strong>
                                                                        {{ Str::limit($question->question, 100) }}
                                                                    </div>
                                                                    <div class="alert alert-danger">
                                                                        <i class="fas fa-exclamation-circle me-1"></i>
                                                                        This action cannot be undone!
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="fas fa-trash me-1"></i> Delete
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit Modal (You'll need to implement this similar to create modal) -->
                                                <!-- Image Preview Modal -->
                                                @if ($question->question_img)
                                                    <div class="modal fade" id="imageModal{{ $question->id }}"
                                                        tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-secondary">
                                                                    <h5 class="modal-title text-white">
                                                                        <i class="fas fa-image me-2"></i>Question Image
                                                                    </h5>
                                                                    <button type="button"
                                                                        class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <img src="{{ asset('storage/question_img/' . $question->question_img) }}"
                                                                        class="img-fluid" alt="Question Image">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-question-circle fa-3x mb-3"></i>
                                                <h4>No Questions Found</h4>
                                                <p>Start by adding your first question using the "Add Question" button
                                                    above.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    @if ($questions instanceof \Illuminate\Pagination\LengthAwarePaginator && $questions->hasPages())
                        <div class="card-footer clearfix">
                            <div class="float-right">
                                {{ $questions->links() }}
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .question-text {
            max-height: 100px;
            overflow-y: auto;
        }

        .info-box {
            border-radius: .25rem;
        }

        .info-box-icon {
            border-radius: .25rem 0 0 .25rem;
        }

        .badge {
            font-size: 0.85em;
            padding: 0.35em 0.65em;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .02);
        }

        .modal-xl {
            max-width: 1200px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .list-unstyled li {
            margin-bottom: 3px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#questions_table').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pageLength": 25,
                "order": [
                    [0, 'asc']
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-chevron-left'></i>",
                        "next": "<i class='fas fa-chevron-right'></i>"
                    }
                }
            });

            // Show/hide choices based on question type
            $('#type').on('change', function() {
                const type = $(this).val();
                const choicesSection = $('#choices-section');
                const answerSection = $('#answer-section');

                if (type === 'multiple') {
                    choicesSection.show();
                    $('#choices').prop('required', true);
                    $('#answer').attr('placeholder', 'Enter the correct answer from choices');
                } else {
                    choicesSection.hide();
                    $('#choices').prop('required', false);
                    $('#answer').attr('placeholder', 'Enter the expected answer for essay');
                }
            }).trigger('change');

            // File upload preview
            $('#question_img').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview').remove();
                        $('#question_img').after(
                            '<div id="image-preview" class="mt-2">' +
                            '<img src="' + e.target.result +
                            '" class="img-thumbnail" style="max-height: 150px;">' +
                            '</div>'
                        );
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Confirm before delete
            $('form[action*="destroy"]').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Auto-focus on question input when modal opens
            $('#createModal').on('shown.bs.modal', function() {
                $(this).find('#question').focus();
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endpush
