@extends('staff.base')

@section('css')
<style>
    .htmx-indicator {
        display: none;
    }
    .htmx-request .htmx-indicator {
        display: inline-block;
    }
    .htmx-request.htmx-indicator {
        display: inline-block;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Exam Questions</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('staff.exams') }}">Exams</a></li>
        <li class="breadcrumb-item active">{{ $exam->name }}</li>
    </ol>

    <div class="row">
        <!-- Available Questions -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-list me-1"></i>
                        Available Questions
                    </div>
                    <div class="input-group" style="width: 300px;">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Search questions..." 
                               hx-get="{{ route('staff.exam.questions.list', $exam->id) }}"
                               hx-trigger="keyup changed delay:500ms, search"
                               hx-target="#availableQuestionsList"
                               name="search">
                        <span class="input-group-text htmx-indicator">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div id="availableQuestionsList">
                        @include('staff.exam.partials.available-questions')
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Questions -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-check-circle me-1"></i>
                    Assigned Questions
                </div>
                <div class="card-body">
                    <div id="assignedQuestionsList">
                        @include('staff.exam.partials.assigned-questions')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.body.addEventListener('click', function(e) {
        // Add question to exam
        if (e.target.closest('.add-question')) {
            const questionId = e.target.closest('.add-question').dataset.id;
            
            fetch(`{{ route('staff.exam.questions.add', $exam->id) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ question_id: questionId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    // Update both lists
                    document.getElementById('availableQuestionsList').innerHTML = data.available_html;
                    document.getElementById('assignedQuestionsList').innerHTML = data.assigned_html;
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Failed to add question', 'error');
            });
        }
        
        // Remove question from exam
        if (e.target.closest('.remove-question')) {
            const questionId = e.target.closest('.remove-question').dataset.id;
            const examId = {{ $exam->id }};
            
            Swal.fire({
                title: 'Are you sure?',
                text: "Remove this question from the exam?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/staff/exam/${examId}/questions/${questionId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            // Update both lists
                            document.getElementById('availableQuestionsList').innerHTML = data.available_html;
                            document.getElementById('assignedQuestionsList').innerHTML = data.assigned_html;
                            
                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Failed to remove question', 'error');
                    });
                }
            });
        }
    });
</script>
@endsection
