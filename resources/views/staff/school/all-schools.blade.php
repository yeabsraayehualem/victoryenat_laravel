@extends('staff.base')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">School Management</h1>
            <p class="mb-0 text-gray-600">Manage and monitor all schools in the system</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                <i class="fas fa-plus"></i> Add New School
            </button>
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-filter="all">All Schools</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="active">Active Schools</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="inactive">Inactive Schools</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" data-filter="primary">Primary Schools</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="secondary">Secondary Schools</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="dashboard-card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="search-box">
                        <i class="fas fa-search text-muted position-absolute ps-3" style="top: 50%; transform: translateY(-50%);"></i>
                        <input type="text" class="form-control ps-5" id="schoolSearch" placeholder="Search schools...">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <select class="form-select w-auto">
                            <option value="">Sort by</option>
                            <option value="name">School Name</option>
                            <option value="students">Number of Students</option>
                            <option value="performance">Performance</option>
                        </select>
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schools Grid -->
    <div class="row g-4">
        @foreach ($schools as $school)
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-card h-100 school-card">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $school->logo) }}" 
                         class="card-img-top school-banner" 
                         alt="{{ $school->name }}"
                         style="height: 140px; object-fit: cover;">
                    <div class="school-logo">
                        <img src="{{ asset('storage/' . $school->logo) }}" 
                             class="rounded-circle border border-3 border-white shadow-sm" 
                             alt="School Logo"
                             style="width: 80px; height: 80px; object-fit: cover; margin-top: -40px;">
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">{{ $school->name }}</h5>
                            <p class="text-muted mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $school->address }}
                            </p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-dark" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('staff.schooldetail', $school->id) }}">
                                        <i class="fas fa-info-circle me-2"></i>View Details
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editSchoolModal{{ $school->id }}">
                                        <i class="fas fa-edit me-2"></i>Edit School
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-chart-line me-2"></i>View Reports
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $school->id }})">
                                        <i class="fas fa-trash-alt me-2"></i>Delete School
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="p-2 rounded bg-light">
                                <small class="text-muted d-block">Students</small>
                                <span class="fw-bold">{{ $school->students_count ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded bg-light">
                                <small class="text-muted d-block">Teachers</small>
                                <span class="fw-bold">{{ $school->teachers_count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <small class="text-muted d-block">Performance</small>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: 75%"></div>
                            </div>
                        </div>
                        <span class="ms-2 text-success">75%</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-phone me-1 text-muted"></i>
                            <small>{{ $school->phone }}</small>
                        </div>
                        <a href="{{ route('staff.schooldetail', $school->id) }}" class="btn btn-sm btn-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Add School Modal -->
<div class="modal fade" id="addSchoolModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New School</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('staff.addSchool') }}" id="add_school_form" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">School Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">School Type</label>
                            <select class="form-select" name="type" required>
                                <option value="">Select Type</option>
                                <option value="primary">Primary School</option>
                                <option value="secondary">Secondary School</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Website</label>
                            <input type="url" class="form-control" name="website">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">School Logo</label>
                            <input type="file" class="form-control" name="logo" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="add_school_form" class="btn btn-primary">Add School</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
// Search functionality
document.getElementById('schoolSearch').addEventListener('keyup', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const schoolCards = document.querySelectorAll('.school-card');
    
    schoolCards.forEach(card => {
        const schoolName = card.querySelector('h5').textContent.toLowerCase();
        const schoolAddress = card.querySelector('.text-muted').textContent.toLowerCase();
        
        if (schoolName.includes(searchTerm) || schoolAddress.includes(searchTerm)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
});

// Delete confirmation
function confirmDelete(schoolId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `/staff/schools/delete/${schoolId}`;
        }
    });
}

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});
</script>
@endsection
