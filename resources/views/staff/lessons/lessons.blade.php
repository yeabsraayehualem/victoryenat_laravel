@extends('staff.base')
@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Lessons Management</h1>
            <p class="text-muted small mb-0">Manage and organize your educational content</p>
        </div>
        <a href="{{ route('staff.lessons.add') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Lesson
        </a>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 bg-primary bg-opacity-10 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-primary mb-1">Total Lessons</h6>
                            <h3 class="mb-0">{{ count($lessons) }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-book fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-success bg-opacity-10 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success mb-1">Active Lessons</h6>
                            <h3 class="mb-0">{{ count($lessons) }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-info bg-opacity-10 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-info mb-1">Total Subjects</h6>
                            <h3 class="mb-0">{{ count($subjects) }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-bookmark fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-warning bg-opacity-10 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-warning mb-1">Total Materials</h6>
                            {{-- <h3 class="mb-0">{{ $totalMaterials }}</h3> --}}
                        </div>
                        <div class="bg-warning bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-file-alt fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('staff.lessons.all') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="subject" class="form-select">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="grade" class="form-select">
                        <option value="">All Grades</option>
                        @foreach(range(1, 12) as $grade)
                            <option value="{{ $grade }}" {{ request('grade') == $grade ? 'selected' : '' }}>
                                Grade {{ $grade }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search lessons..."
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lessons Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4">Lesson</th>
                            <th class="border-0">Subject</th>
                            <th class="border-0">Grade</th>
                            <th class="border-0">Duration</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Materials</th>
                            <th class="border-0 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lessons as $lesson)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="lesson-icon me-3">
                                        <i class="fas fa-book-open fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $lesson->title }}</h6>
                                        <small class="text-muted">Created {{ $lesson->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $lesson->subject->name }}</td>
                            <td>Grade {{ $lesson->grade_level }}</td>
                            <td>{{ $lesson->duration }} mins</td>
                            <td>
                                <span class="badge bg-{{ $lesson->status == 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($lesson->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $lesson->materials_count ?? 0 }} files
                                </span>
                            </td>
                            <td class="text-end px-4">
                                <div class="btn-group">
                                    <a href="{{ route('staff.lessons.detail', $lesson->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('staff.lessons.editLesson', $lesson->id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="deleteLesson({{ $lesson->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>No lessons found. Start by adding a new lesson.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-4">
        {{ $lessons->links() }}
    </div>
</div>

@endsection

@section('css')
<style>
    .card {
        border-radius: 15px;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    .lesson-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(13, 110, 253, 0.1);
    }
    .btn-group .btn {
        padding: 0.375rem 0.75rem;
    }
    .badge {
        padding: 0.5em 0.75em;
    }
    .pagination {
        margin-bottom: 0;
    }
    .form-select, .form-control {
        border-radius: 8px;
        padding: 0.6rem 1rem;
    }
</style>
@endsection

@section('js')
<script>
function deleteLesson(lessonId) {
    if(confirm('Are you sure you want to delete this lesson?')) {
        axios.delete(`/staff/lessons/${lessonId}`)
            .then(response => {
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete lesson');
            });
    }
}
</script>
@endsection
