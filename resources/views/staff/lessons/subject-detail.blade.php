@extends('staff.base')
@section('content')
<div class="container-fluid py-4">
    <!-- Header Section with Parallax Effect -->
    <div class="subject-header mb-4 position-relative">
        <div class="overlay"></div>
        <div class="header-content position-relative z-index-1 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-4 text-white mb-0">{{ $subject->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}" class="">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('staff.subjects.all') }}" class="">Subjects</a></li>
                            <li class="breadcrumb-item active " aria-current="page">{{ $subject->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('staff.subjects.edit', $subject->id) }}" class="btn btn-light">
                        <i class="fas fa-edit me-2"></i>Edit Subject
                    </a>
                    <a href="{{ route('staff.subjects.all') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Section -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-book-reader fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Students</h6>
                            <h2 class="mb-0">{{ count($students) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-graduation-cap fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Average Score</h6>
                            {{-- <h2 class="mb-0">{{ $averageScore }}%</h2> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Hours</h6>
                            {{-- <h2 class="mb-0">{{ $totalHours }}</h2> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-tasks fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Lessons</h6>
                            <h2 class="mb-0">{{ count($lessons) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Details & Lessons Tabs -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#details">
                        <i class="fas fa-info-circle me-2"></i>Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#lessons">
                        <i class="fas fa-book me-2"></i>Lessons
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#students">
                        <i class="fas fa-users me-2"></i>Students
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <!-- Details Tab -->
                <div class="tab-pane fade show active" id="details">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                @if($subject->image)
                                    <img src="{{ asset('storage/' . $subject->image) }}"
                                         class="img-fluid rounded-circle subject-image mb-3"
                                         alt="{{ $subject->name }}">
                                @else
                                    <div class="subject-placeholder mb-3">
                                        <i class="fas fa-book-open fa-4x text-primary"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="info-card p-4 bg-light rounded">
                                <h5 class="border-bottom pb-2 mb-3">Quick Information</h5>
                                <div class="mb-3">
                                    <label class="text-muted">Department</label>
                                    <p class="mb-0 fw-bold">{{ $subject->department }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted">Grade Level</label>
                                    <p class="mb-0 fw-bold">Grade {{ $subject->grade }}</p>
                                </div>
                                <div>
                                    <label class="text-muted">Created</label>
                                    <p class="mb-0 fw-bold">{{ $subject->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4 class="mb-4">Subject Description</h4>
                            <p class="lead">{{ $subject->description }}</p>

                            <div class="mt-4">
                                {{-- <h5 class="mb-3">Learning Objectives</h5>
                                <div class="row g-3">
                                    @foreach($subject->objectives as $objective)
                                    <div class="col-md-6">
                                        <div class="objective-card p-3 bg-light rounded">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            {{ $objective }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lessons Tab -->
                <div class="tab-pane fade" id="lessons">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Subject Lessons</h4>
                        <a href="{{ route('staff.lessons.add', ['subject_id' => $subject->id]) }}"
                           class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New Lesson
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Lesson Title</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lessons as $lesson)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="lesson-icon me-3">
                                                <i class="fas fa-book-open text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $lesson->title }}</h6>
                                                <small class="text-muted">
                                                    {{ $lesson->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $lesson->duration }} mins</td>
                                    <td>
                                        <span class="badge bg-{{ $lesson->status == 'active' ? 'success' : 'warning' }}">
                                            {{ ucfirst($lesson->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar" role="progressbar"
                                                 style="width: {{ $lesson->progress }}%"
                                                 aria-valuenow="{{ $lesson->progress }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('staff.lessons.detail', $lesson->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('staff.lessons.detail', $lesson->id) }}"
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>No lessons available for this subject yet.</p>
                                            <a href="{{ route('staff.lessons.add', ['subject_id' => $subject->id]) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-2"></i>Add First Lesson
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Students Tab -->
                <div class="tab-pane fade" id="students">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">Name</th>
                                    <th class="border-0">Email</th>
                                    <th class="border-0">Grade</th>
                                    <th class="border-0">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td>{{ $student->first_name }} {{ $student->last_name }} </td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->grade }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('staff.editUser', $student->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>No students have enrolled for this subject yet.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    .subject-header {
        background: linear-gradient(45deg, #4e73df, #224abe);
        border-radius: 15px;
        overflow: hidden;
    }
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
    }
    .stat-card {
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .subject-image {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .subject-placeholder {
        width: 200px;
        height: 200px;
        background: rgba(13, 110, 253, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    .lesson-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: rgba(13, 110, 253, 0.1);
    }
    .objective-card {
        transition: transform 0.2s;
    }
    .objective-card:hover {
        transform: translateX(5px);
    }
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        padding: 1rem 1.5rem;
    }
    .nav-tabs .nav-link.active {
        color: #4e73df;
        border-bottom: 2px solid #4e73df;
    }
    .progress {
        border-radius: 10px;
        background-color: rgba(13, 110, 253, 0.1);
    }
    .progress-bar {
        background-color: #4e73df;
    }
</style>
@endsection
