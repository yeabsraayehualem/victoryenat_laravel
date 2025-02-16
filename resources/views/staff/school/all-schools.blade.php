@extends('staff.base')
@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">School Management</h1>
            <p class="text-muted small mb-0">Manage and monitor all registered schools</p>
        </div>
        <button type="button" id="add_school" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New School
        </button>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="fas fa-school fa-2x text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Schools</h6>
                            <h2 class="mb-0">{{ $totalSchools ?? 0 }}</h2>
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
                            <i class="fas fa-user-graduate fa-2x text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Students</h6>
                            <h2 class="mb-0">{{ $totalStudents ?? 0 }}</h2>
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
                            <h2 class="mb-0">{{ $totalTeachers ?? 0 }}</h2>
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
                            <h6 class="text-muted mb-0">Active Schools</h6>
                            <h2 class="mb-0">{{ $activeSchools ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="#" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search schools..." name="search">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="type">
                        <option value="">All Types</option>
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Schools Grid -->
    <div class="row g-4">
        @foreach($schools as $school)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm school-card">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $school->logo) }}"
                         class="card-img-top school-image"
                         width="200" height="200"
                         alt="{{ $school->name }}">
                    <div class="school-overlay">
                        <span class="badge bg-{{ $school->status == 'active' ? 'success' : 'warning' }}">
                            {{ ucfirst($school->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $school->name }}</h5>
                    <p class="text-muted small mb-2">{{ $school->location }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-user-graduate me-1"></i> {{ count($school->students()) ?? 0 }} Students
                        </span>
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-chalkboard-teacher me-1"></i> {{ count($school->teachers()) ?? 0 }} Teachers
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('staff.schooldetail', $school->id) }}" class="btn btn-sm btn-outline-primary view-details"
                                data-id="{{ $school->id }}">
                            <i class="fas fa-eye me-1"></i> View Details
</a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                               
                                <li>
                                    @if($school->status == 'active')
                                    <a class="dropdown-item" href="{{ route('staff.deactivateSchool' , ['id' => $school->id])}}">
                                        <i class="fas fa-pause-circle me-2"></i>Deactivate
                                    </a>
                                    @else
                                    <a class="dropdown-item" href="{{ route('staff.activateSchool' , ['id' => $school->id])}}">
                                        <i class="fas fa-play-circle me-2"></i>Activate
                                    </a>
                                    @endif
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('staff.deleteSchool' , ['id' => $school->id])}}">
                                        <i class="fas fa-trash-alt me-2"></i>Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-4">
        {{ $schools->links() }}
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
    .school-card {
        transition: transform 0.2s;
        border-radius: 15px;
        overflow: hidden;
    }
    .school-card:hover {
        transform: translateY(-5px);
    }
    .school-image {
        height: 160px;
        object-fit: cover;
    }
    .school-overlay {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }
    .form-select, .form-control {
        border-radius: 8px;
        padding: 0.6rem 1rem;
    }
    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 8px;
    }
    .dropdown-item {
        padding: 0.5rem 1rem;
    }
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    .badge {
        padding: 0.5em 0.75em;
    }
</style>
@endsection

@section('js')
<script>
    // Preserve the existing JavaScript functionality
    document.getElementById('add_school').addEventListener('click', function() {
        Swal.fire({
            title: 'Add New School',
            html: `<form id="add_school_form" action="{{ route('staff.school.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label">School Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" name="address" required>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label">School Type</label>
<select name="school_type" id="school_type" required class="form-control">
<option value="">Select School Type</option>
<option value="public">Public</option>
<option value="private">Private</option>

</select>
                    </div>
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label">School Logo</label>
                    <input type="file" class="form-control" name="logo" required>
                </div>
                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label">Phone No</label>
                    <input type="number" class="form-control" name="phone" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Save School</button>
                </div>
            </div>
            </form>`,
            showCancelButton: false,
            showConfirmButton: false,
            width: '500px'
        });
    });
</script>
@endsection
