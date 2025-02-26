@extends('staff.base')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Exam Questions</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Questions</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                All Questions
            </div>
            <a href="{{ route('staff.exam.create-question') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Create Question
            </a>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="subject" class="form-label">Subject</label>
                    <select class="form-select" 
                            name="subject" 
                            hx-get="{{ route('staff.exam.questions') }}"
                            hx-trigger="change"
                            hx-target="#questionsTableContainer"
                            hx-include="[name='chapter'],[name='school'],[name='status']"
                            hx-indicator="#loading">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="chapter" class="form-label">Chapter</label>
                    <select class="form-select" 
                            name="chapter"
                            hx-get="{{ route('staff.exam.questions') }}"
                            hx-trigger="change"
                            hx-target="#questionsTableContainer"
                            hx-include="[name='subject'],[name='school'],[name='status']"
                            hx-indicator="#loading">
                        <option value="">All Chapters</option>
                        @foreach($chapters as $chapter)
                            <option value="{{ $chapter }}" {{ request('chapter') == $chapter ? 'selected' : '' }}>
                                {{ $chapter }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="school" class="form-label">School</label>
                    <select class="form-select" 
                            name="school"
                            hx-get="{{ route('staff.exam.questions') }}"
                            hx-trigger="change"
                            hx-target="#questionsTableContainer"
                            hx-include="[name='subject'],[name='chapter'],[name='status']"
                            hx-indicator="#loading">
                        <option value="">All Schools</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ request('school') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" 
                            name="status"
                            hx-get="{{ route('staff.exam.questions') }}"
                            hx-trigger="change"
                            hx-target="#questionsTableContainer"
                            hx-include="[name='subject'],[name='chapter'],[name='school']"
                            hx-indicator="#loading">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="school_approved" {{ request('status') == 'school_approved' ? 'selected' : '' }}>School Approved</option>
                        <option value="victory_approved" {{ request('status') == 'victory_approved' ? 'selected' : '' }}>Fully Approved</option>
                    </select>
                </div>
            </div>

            <!-- Loading indicator -->
            <div id="loading" class="htmx-indicator">
                <div class="d-flex justify-content-center mb-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

            <!-- Questions table container -->
            <div id="questionsTableContainer">
                @include('staff.exam.partials.questions-table')
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.tiny.cloud/1/gn50jnhq3ryp9lwxb8xw7n1o07tbqbklb8g94dbtybedjept/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Handle question deletion
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.delete-question')) {
            const questionId = e.target.closest('.delete-question').dataset.id;
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This question will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `{{ route('staff.exam.delete-question', '') }}/${questionId}`;
                }
            });
        }
    });

    // Add TinyMCE content styles
    const tinymceContentStyle = `
        <style>
            .tinymce-content {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                line-height: 1.6;
            }
            .tinymce-content p {
                margin-bottom: 1rem;
            }
            .tinymce-content ul, .tinymce-content ol {
                margin-bottom: 1rem;
                padding-left: 2rem;
            }
            .tinymce-content img {
                max-width: 100%;
                height: auto;
                margin: 1rem 0;
            }
            .tinymce-content table {
                width: 100%;
                margin-bottom: 1rem;
                border-collapse: collapse;
            }
            .tinymce-content th, .tinymce-content td {
                padding: 0.5rem;
                border: 1px solid #dee2e6;
            }
        </style>
    `;
    document.head.insertAdjacentHTML('beforeend', tinymceContentStyle);
</script>
@endsection