@extends('staff.base')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Exams</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Exams</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-calendar-alt me-1"></i>
                All Exams
            </div>
            <a href="{{ route('staff.exam.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Create Exam
            </a>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="subject" class="form-label">Subject</label>
                    <select class="form-select" 
                            name="subject" 
                            hx-get="{{ route('staff.exams') }}"
                            hx-trigger="change"
                            hx-target="#examsTableContainer"
                            hx-include="[name='status']"
                            hx-indicator="#loading">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" 
                            name="status"
                            hx-get="{{ route('staff.exams') }}"
                            hx-trigger="change"
                            hx-target="#examsTableContainer"
                            hx-include="[name='subject']"
                            hx-indicator="#loading">
                        <option value="">All Status</option>
                        <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
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

            <!-- Exams table container -->
            <div id="examsTableContainer">
                @include('staff.exam.partials.exams-table')
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Handle exam deletion
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.delete-exam')) {
            const examId = e.target.closest('.delete-exam').dataset.id;
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This exam will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/staff/exam/${examId}/delete`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            Swal.fire('Deleted!', data.message, 'success')
                                .then(() => window.location.reload());
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Failed to delete exam', 'error');
                    });
                }
            });
        }
    });
</script>
@endsection
