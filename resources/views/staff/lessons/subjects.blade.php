@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Subject Management</h1>
            <p class="text-muted small mb-0">Organize and manage your educational subjects</p>
        </div>
        <a href="{{ route('staff.subjects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Subject
        </a>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="fas fa-book fa-2x text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Subjects</h6>
                            <h2 class="mb-0">{{ $totalSubjects }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success bg-opacity-10">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Active Students</h6>
                            <h2 class="mb-0">{{ $totalStudents }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info bg-opacity-10">
                            <i class="fas fa-chalkboard-teacher fa-2x text-info"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Teachers</h6>
                            <h2 class="mb-0">{{ $totalTeachers }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning bg-opacity-10">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Hours</h6>
                            <h2 class="mb-0">{{ $totalHours }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('staff.subjects.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="grade" class="form-select">
                        <option value="">All Grades</option>
                        @foreach(range(9, 12) as $grade)
                            <option value="{{ $grade }}" {{ request('grade') == $grade ? 'selected' : '' }}>
                                Grade {{ $grade }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="department" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search subjects..."
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

    <!-- Subjects Grid -->
    <div class="row g-4">
        @forelse($subjects as $subject)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm subject-card">
                <div class="position-relative">
                    @if($subject->image)
                        <img src="{{ asset('storage/' . $subject->image) }}" 
                             class="card-img-top subject-image"
                             alt="{{ $subject->name }}">
                    @else
                        <div class="subject-placeholder">
                            <i class="fas fa-book-open fa-3x text-primary"></i>
                        </div>
                    @endif
                    <div class="subject-overlay">
                        <span class="badge bg-primary">Grade {{ $subject->grade }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $subject->name }}</h5>
                    <p class="text-muted small mb-2">{{ $subject->shore_code }}</p>
                    <p class="card-text text-truncate">{{ $subject->description }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="small text-muted">
                            <i class="fas fa-users me-1"></i> {{ $subject->students_count ?? 0 }} Students
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('staff.subject.detail', $subject->id) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('staff.subject.edit', $subject->id) }}" 
                               class="btn btn-sm btn-outline-info">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-books fa-3x text-muted mb-3"></i>
                <h5>No Subjects Found</h5>
                <p class="text-muted">Start by adding your first subject</p>
                <a href="{{ route('staff.subjects.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Add New Subject
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-4">
        {{ $subjects->links() }}
    </div>
</div>

@endsection

@section('css')
<style>
    .stat-card {
        transition: transform 0.2s;
        border-radius: 15px;
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
    .subject-card {
        transition: transform 0.2s;
        border-radius: 15px;
        overflow: hidden;
    }
    .subject-card:hover {
        transform: translateY(-5px);
    }
    .subject-image {
        height: 200px;
        object-fit: cover;
    }
    .subject-placeholder {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(13, 110, 253, 0.1);
    }
    .subject-overlay {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }
    .form-select, .form-control {
        border-radius: 8px;
        padding: 0.6rem 1rem;
    }
    .btn-group .btn {
        padding: 0.375rem 0.75rem;
    }
    .badge {
        padding: 0.5em 0.75em;
    }
</style>
@endsection