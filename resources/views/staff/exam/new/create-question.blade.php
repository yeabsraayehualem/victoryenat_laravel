@extends('staff.base')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Create Exam Question</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Create Question</li>
    </ol>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-question-circle me-1"></i>
                    New Question
                </div>
                <div class="card-body">
                    <form hx-post="{{ route('staff.exam.store-question') }}"
                          hx-swap="outerHTML"
                          class="needs-validation"
                          novalidate>
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                                    <select name="subject_id" id="subject_id" class="form-select" required>
                                        <option value="">Select Subject</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }} - {{ $subject->grade }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a subject
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chapter" class="form-label">Chapter <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="chapter" id="chapter" required>
                                    <div class="invalid-feedback">
                                        Please enter the chapter
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                            <textarea name="question" id="question" class="form-control tinymce" required></textarea>
                            <div class="invalid-feedback">
                                Please enter the question
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="option1" class="form-label">Option A <span class="text-danger">*</span></label>
                                    <textarea name="option1" id="option1" class="form-control tinymce" required></textarea>
                                    <div class="invalid-feedback">
                                        Please enter option A
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="option2" class="form-label">Option B <span class="text-danger">*</span></label>
                                    <textarea name="option2" id="option2" class="form-control tinymce" required></textarea>
                                    <div class="invalid-feedback">
                                        Please enter option B
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="option3" class="form-label">Option C <span class="text-danger">*</span></label>
                                    <textarea name="option3" id="option3" class="form-control tinymce" required></textarea>
                                    <div class="invalid-feedback">
                                        Please enter option C
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="option4" class="form-label">Option D <span class="text-danger">*</span></label>
                                    <textarea name="option4" id="option4" class="form-control tinymce" required></textarea>
                                    <div class="invalid-feedback">
                                        Please enter option D
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="answer" class="form-label">Correct Answer <span class="text-danger">*</span></label>
                            <select name="answer" id="answer" class="form-select" required>
                                <option value="">Select Correct Answer</option>
                                <option value="a">Option A</option>
                                <option value="b">Option B</option>
                                <option value="c">Option C</option>
                                <option value="d">Option D</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select the correct answer
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </button>
                            <button type="submit" class="btn btn-primary" hx-indicator="#spinner">
                                <i class="fas fa-save me-1"></i> Create Question
                            </button>
                        </div>

                        <!-- Loading Indicator -->
                        <div id="spinner" class="htmx-indicator">
                            <div class="d-flex justify-content-center mt-3">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.tiny.cloud/1/gn50jnhq3ryp9lwxb8xw7n1o07tbqbklb8g94dbtybedjept/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Show notification if there's a flash message
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif

    // Handle HTMX events
    document.body.addEventListener('htmx:beforeRequest', function(evt) {
        // Disable form submission if validation fails
        if (!evt.detail.elt.checkValidity()) {
            evt.preventDefault();
            return;
        }
    });

    document.body.addEventListener('htmx:responseError', function(evt) {
        const response = JSON.parse(evt.detail.xhr.response);
        Swal.fire({
            title: 'Error!',
            text: response.error || 'Failed to create question. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });

    // Initialize TinyMCE
    function initTinyMCE() {
        tinymce.init({
            selector: '.tinymce',
            menubar: false,
            plugins: 'lists link image preview',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | preview | subscript superscript | link image',
            images_upload_url: `{{ route('tinymce.upload') }}`,
            automatic_uploads: true,
            file_picker_types: 'image',
            height: 200,
            setup: function(editor) {
                editor.on('init', function() {
                    console.log('TinyMCE initialized successfully');
                });
                editor.on('error', function(error) {
                    console.error('Error initializing TinyMCE:', error.message);
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
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
@endsection