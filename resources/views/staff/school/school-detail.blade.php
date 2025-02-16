@extends('staff.base')
@section('content')
<div class="container-fluid py-4">
    <!-- School Header -->
    <div class="card border-0 bg-primary bg-gradient text-white mb-4 overflow-hidden">
        <div class="card-body position-relative py-5">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="school-logo-wrapper">
                        <img src="{{ asset('storage/' . $school->logo) }}"
                             class="rounded-circle border border-3 border-white shadow"
                             width="120" height="120"
                             alt="{{ $school->name }}">
                    </div>
                </div>
                <div class="col">
                    <h1 class="display-5 mb-0">{{ $school->name }}</h1>
                    <p class="lead mb-0 opacity-75">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ $school->location }}
                    </p>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2">
                        <button class="btn btn-light">
                            <i class="fas fa-edit me-2"></i>Edit School
                        </button>
                        <button class="btn btn-light">
                            <i class="fas fa-cog me-2"></i>Settings
                        </button>
                    </div>
                </div>
            </div>
            <div class="school-header-overlay"></div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Students</h6>
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
                        <div class="stat-icon bg-success bg-opacity-10">
                            <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
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
                        <div class="stat-icon bg-info bg-opacity-10">
                            <i class="fas fa-book fa-2x text-info"></i>
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
                        <div class="stat-icon bg-warning bg-opacity-10">
                            <i class="fas fa-chart-line fa-2x text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Performance</h6>
                            <h2 class="mb-0">{{ $performance }}%</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="managers-tab" data-bs-toggle="tab" data-bs-target="#managers" type="button" role="tab">
                        <i class="fas fa-user-tie me-2"></i>School Managers
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab">
                        <i class="fas fa-user-graduate me-2"></i>Students
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#teachers" type="button" role="tab">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Teachers
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <!-- School Managers Tab -->
                <div class="tab-pane fade show active" id="managers" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">School Managers</h4>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-circle me-2"></i>Add Manager
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schoolManagers as $manager)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $manager->profile_photo ?? asset('images/default-avatar.png') }}" 
                                                 class="rounded-circle me-2" width="40" height="40">
                                            <div>
                                                <div class="fw-bold">{{ $manager->name }}</div>
                                                <div class="small text-muted">Joined {{ $manager->created_at->format('M Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $manager->email }}</td>
                                    <td>{{ $manager->phone }}</td>
                                    <td>
                                        <span class="badge bg-{{ $manager->is_active ? 'success' : 'danger' }}">
                                            {{ $manager->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">No school managers found</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Students Tab -->
                <div class="tab-pane fade" id="students" role="tabpanel">
                    <!-- Filters and Sorting -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <form class="row g-3">
                                <!-- Grade Filter -->
                                <div class="col-md-3">
                                    <label class="form-label">Grade</label>
                                    <select class="form-select" name="grade" id="gradeFilter"
                                            hx-get="{{ route('staff.school.students', ['schoolId' => $school->id]) }}"
                                            hx-trigger="change"
                                            hx-target="#studentsTableContent"
                                            hx-indicator="#loading-indicator">
                                        <option value="">All Grades</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request('grade') == $i ? 'selected' : '' }}>
                                                Grade {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Sort By -->
                                <div class="col-md-3">
                                    <label class="form-label">Sort By</label>
                                    <select class="form-select" name="sort" id="sortFilter"
                                            hx-get="{{ route('staff.school.students', ['schoolId' => $school->id]) }}"
                                            hx-trigger="change"
                                            hx-target="#studentsTableContent"
                                            hx-indicator="#loading-indicator">
                                        <option value="name_asc">Name (A-Z)</option>
                                        <option value="name_desc">Name (Z-A)</option>
                                        <option value="grade_asc">Grade (Low-High)</option>
                                        <option value="grade_desc">Grade (High-Low)</option>
                                    </select>
                                </div>

                                <!-- Search -->
                                <div class="col-md-6">
                                    <label class="form-label">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" class="form-control" name="search" id="searchInput"
                                               placeholder="Search by name or ID..."
                                               hx-get="{{ route('staff.school.students', ['schoolId' => $school->id]) }}"
                                               hx-trigger="keyup changed delay:500ms"
                                               hx-target="#studentsTableContent"
                                               hx-indicator="#loading-indicator">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="htmx-indicator position-fixed top-50 start-50 translate-middle">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table Content -->
                    <div id="studentsTableContent">
                        @include('staff.school.partials.students-table')
                    </div>
                </div>
                <!-- Teachers Tab -->
                <div class="tab-pane fade" id="teachers" role="tabpanel">
                   
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $teacher->profile_photo ?? asset('images/default-avatar.png') }}" 
                                                 class="rounded-circle me-2" width="40" height="40">
                                            <div>
                                                <div class="fw-bold">{{ $teacher->get_full_name() }}</div>
                                                <div class="small text-muted">Joined {{ $teacher->created_at->format('M Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $teacher->subject }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>
                                        <span class="badge bg-{{ $teacher->is_active ? 'success' : 'danger' }}">
                                            {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">No teachers found</div>
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
</div>
@endsection

@section('head')
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
@endsection

@section('css')
<style>
    .school-logo-wrapper {
        position: relative;
        z-index: 1;
    }
    .school-header-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(0,0,0,0.2), transparent);
        z-index: 0;
    }
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
    .activity-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 10px;
        color: #6c757d;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show active tab based on URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab');
        if (activeTab) {
            const tab = document.querySelector(`#${activeTab}-tab`);
            if (tab) {
                tab.click();
            }
        }

        // Handle filter form submission
        const filterForm = document.getElementById('studentFiltersForm');
        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(filterForm);
                const searchParams = new URLSearchParams(formData);
                window.location.href = `${window.location.pathname}?${searchParams.toString()}`;
            });
        }
    });
</script>
@endsection
