@extends('staff.base')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Question</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('staff.exam.questions') }}">Questions</a></li>
        <li class="breadcrumb-item active">Edit Question</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Question
        </div>
        <div class="card-body">
            <form hx-post="{{ route('staff.exam.update-question', $question->id) }}" 
                  hx-swap="outerHTML"
                  class="needs-validation" 
                  novalidate>
                @csrf
                
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <textarea name="question" id="question" class="form-control tinymce" required>{!! $question->question !!}</textarea>
                    <div class="invalid-feedback">
                        Please enter the question.
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="option1" class="form-label">Option A</label>
                        <textarea name="option1" id="option1" class="form-control tinymce" required>{!! $question->option1 !!}</textarea>
                        <div class="invalid-feedback">
                            Please enter option A.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="option2" class="form-label">Option B</label>
                        <textarea name="option2" id="option2" class="form-control tinymce" required>{!! $question->option2 !!}</textarea>
                        <div class="invalid-feedback">
                            Please enter option B.
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="option3" class="form-label">Option C</label>
                        <textarea name="option3" id="option3" class="form-control tinymce" required>{!! $question->option3 !!}</textarea>
                        <div class="invalid-feedback">
                            Please enter option C.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="option4" class="form-label">Option D</label>
                        <textarea name="option4" id="option4" class="form-control tinymce" required>{!! $question->option4 !!}</textarea>
                        <div class="invalid-feedback">
                            Please enter option D.
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="answer" class="form-label">Correct Answer</label>
                        <select name="answer" id="answer" class="form-select" required>
                            <option value="">Select correct answer</option>
                            <option value="a" {{ $question->answer == 'a' ? 'selected' : '' }}>Option A</option>
                            <option value="b" {{ $question->answer == 'b' ? 'selected' : '' }}>Option B</option>
                            <option value="c" {{ $question->answer == 'c' ? 'selected' : '' }}>Option C</option>
                            <option value="d" {{ $question->answer == 'd' ? 'selected' : '' }}>Option D</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select the correct answer.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select name="subject_id" id="subject_id" class="form-select" required>
                            <option value="">Select subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $question->subject_id == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select a subject.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="chapter" class="form-label">Chapter</label>
                        <input type="text" 
                               name="chapter" 
                               id="chapter" 
                               class="form-control" 
                               value="{{ $question->chapter }}"
                               required>
                        <div class="invalid-feedback">
                            Please enter the chapter.
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('staff.exam.questions') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Questions
                    </a>
                    <div>
                        @if(!$question->is_victory_approved)
                        <button type="button" 
                                class="btn btn-success me-2"
                                onclick="approveQuestion({{ $question->id }})">
                            <i class="fas fa-check me-1"></i> Approve Question
                        </button>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Question
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="approvalResult" class="d-none"></div>
@endsection

@section('js')
<script src="https://cdn.tiny.cloud/1/gn50jnhq3ryp9lwxb8xw7n1o07tbqbklb8g94dbtybedjept/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Initialize TinyMCE configuration
    function initTinyMCE() {
        tinymce.init({
            selector: '.tinymce',
            height: 200,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; line-height: 1.6; }',
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });
    }

    // Initialize TinyMCE on page load
    initTinyMCE();

    // Re-initialize TinyMCE after HTMX swaps
    document.body.addEventListener('htmx:afterSwap', function(evt) {
        initTinyMCE();
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        this.classList.add('was-validated');
    });

    // Question approval function
    function approveQuestion(questionId) {
        Swal.fire({
            title: 'Approve Question',
            text: 'Are you sure you want to approve this question?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Approving...',
                    text: 'Please wait while we process your request',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                        const url = '{{ route("staff.exam.approve-question", ":id") }}'.replace(':id', questionId);
                        
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw new Error(err.message || 'Server error occurred');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Approved!',
                                    text: 'Question has been approved successfully.',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '{{ route("staff.exam.questions") }}';
                                });
                            } else {
                                throw new Error(data.message || 'Failed to approve question');
                            }
                        })
                        .catch(error => {
                            console.error('Approval error:', error);
                            Swal.fire({
                                title: 'Approval Failed',
                                html: `
                                    <div class="text-left">
                                        <p class="mb-2"><strong>Error Details:</strong></p>
                                        <p class="text-danger">${error.message}</p>
                                        ${error.details ? `
                                            <p class="mt-2 mb-1"><small>Additional Information:</small></p>
                                            <pre class="text-muted"><small>${JSON.stringify(error.details, null, 2)}</small></pre>
                                        ` : ''}
                                    </div>
                                `,
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            });
                        });
                    }
                });
            }
        });
    }
</script>
@endsection
