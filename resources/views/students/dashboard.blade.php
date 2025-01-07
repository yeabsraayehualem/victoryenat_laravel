@extends('staff.base')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Student Management</h1>
            <p class="mb-0 text-gray-600">Monitor and manage all students across schools</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="fas fa-user-plus"></i> Add New Student
            </button>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importStudentsModal">
                <i class="fas fa-file-import"></i> Import Students
            </button>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card student-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 student-stat-icon bg-primary-subtle">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Students</h6>
                            <h3 class="mb-0">{{ $totalStudents ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> 12% increase
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card student-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 student-stat-icon bg-success-subtle">
                            <i class="fas fa-user-check text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Active Students</h6>
                            <h3 class="mb-0">{{ $activeStudents ?? 0 }}</h3>
                            <small class="text-muted">Out of total students</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card student-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 student-stat-icon bg-warning-subtle">
                            <i class="fas fa-graduation-cap text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Graduating Soon</h6>
                            <h3 class="mb-0">{{ $graduatingStudents ?? 0 }}</h3>
                            <small class="text-muted">In next 3 months</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card student-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 student-stat-icon bg-info-subtle">
                            <i class="fas fa-chart-line text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Average Performance</h6>
                            <h3 class="mb-0">78%</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> 5% increase
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions and Search -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="#" class="quick-action-card">
                                <i class="fas fa-file-alt"></i>
                                <span>Generate Reports</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="quick-action-card">
                                <i class="fas fa-envelope"></i>
                                <span>Send Notifications</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="quick-action-card">
                                <i class="fas fa-chart-bar"></i>
                                <span>View Analytics</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="quick-action-card">
                                <i class="fas fa-id-card"></i>
                                <span>ID Card Generator</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="quick-action-card">
                                <i class="fas fa-clock"></i>
                                <span>Attendance Report</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="quick-action-card">
                                <i class="fas fa-certificate"></i>
                                <span>Certificates</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Student Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="studentDistributionChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Students Table -->
    <div class="dashboard-card mb-4">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent Students</h5>
            <div class="d-flex gap-2">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="studentSearch" placeholder="Search students...">
                </div>
                <button class="btn btn-outline-primary">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover student-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>ID</th>
                            <th>School</th>
                            <th>Class</th>
                            <th>Performance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentStudents ?? [] as $student)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . ($student->photo ?? 'default.jpg')) }}" 
                                         class="rounded-circle me-2" 
                                         width="32" 
                                         height="32"
                                         alt="{{ $student->name }}">
                                    <div>
                                        <h6 class="mb-0">{{ $student->name }}</h6>
                                        <small class="text-muted">{{ $student->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->school->name }}</td>
                            <td>{{ $student->class }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1" style="height: 5px;">
                                        <div class="progress-bar bg-success" style="width: {{ $student->performance }}%"></div>
                                    </div>
                                    <span class="ms-2">{{ $student->performance }}%</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success">Active</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-link" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View Profile</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit Details</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Performance</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i>Remove</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm" class="student-form">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="dob" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">School</label>
                            <select class="form-select" name="school_id" required>
                                <option value="">Select School</option>
                                @foreach($schools ?? [] as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Class</label>
                            <select class="form-select" name="class" required>
                                <option value="">Select Class</option>
                                <!-- Add class options dynamically based on school selection -->
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Parent/Guardian Name</label>
                            <input type="text" class="form-control" name="parent_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Parent/Guardian Phone</label>
                            <input type="tel" class="form-control" name="parent_phone" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Student Photo</label>
                            <input type="file" class="form-control" name="photo" accept="image/*">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addStudentForm" class="btn btn-primary">Add Student</button>
            </div>
        </div>
    </div>
</div>

<!-- Import Students Modal -->
<div class="modal fade" id="importStudentsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Students</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="importStudentsForm">
                    <div class="mb-3">
                        <label class="form-label">Excel File</label>
                        <input type="file" class="form-control" name="excel_file" accept=".xlsx,.xls,.csv" required>
                        <small class="text-muted">Download the template <a href="#">here</a></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">School</label>
                        <select class="form-select" name="school_id" required>
                            <option value="">Select School</option>
                            @foreach($schools ?? [] as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="importStudentsForm" class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
// Initialize student distribution chart
const ctx = document.getElementById('studentDistributionChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Primary', 'Secondary', 'High School'],
        datasets: [{
            data: [45, 35, 20],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
            borderWidth: 0
        }]
    },
    options: {
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Search functionality
document.getElementById('studentSearch').addEventListener('keyup', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const table = document.querySelector('.student-table');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Dynamic class loading based on school selection
document.querySelector('select[name="school_id"]').addEventListener('change', function(e) {
    const schoolId = e.target.value;
    // Add AJAX call to load classes for selected school
});
</script>
@endsection
