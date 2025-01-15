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
    <div class="row g-4">
        <!-- School Information -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title mb-0">School Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <span class="text-muted">School Type:</span>
                            <span class="badge bg-primary">{{ $school->type }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="text-muted">Established:</span>
                            <strong>{{ $school->established_date }}</strong>
                        </li>
                        <li class="mb-3">
                            <span class="text-muted">Email:</span>
                            <strong>{{ $school->email }}</strong>
                        </li>
                        <li class="mb-3">
                            <span class="text-muted">Phone:</span>
                            <strong>{{ $school->phone }}</strong>
                        </li>
                        <li class="mb-3">
                            <span class="text-muted">Website:</span>
                            <a href="{{ $school->website }}" target="_blank">{{ $school->website }}</a>
                        </li>
                        <li>
                            <span class="text-muted">Address:</span>
                            <strong>{{ $school->address }}</strong>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- School Manager -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title mb-0">School Manager</h5>
                </div>
                @foreach($managers as $manager)
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/' . $manager->avatar) }}"
                             class="rounded-circle me-3"
                             width="50"
                             height="50"
                             alt="{{ $manager->name }}">
                        <div>
                            <h6 class="mb-0">{{ $manager->name }}</h6>
                            <small class="text-muted">{{ $manager->email }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Performance Charts -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title mb-0">Academic Performance</h5>
                </div>
                <div class="card-body">
                    <canvas id="performanceChart" height="300"></canvas>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Activities</h5>
                    <button class="btn btn-sm btn-outline-primary">View All</button>
                </div>
               
            </div>
        </div>
    </div>
</div>
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

