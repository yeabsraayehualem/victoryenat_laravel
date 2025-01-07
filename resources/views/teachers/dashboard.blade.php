@extends('staff.base')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Teacher Management</h1>
            <p class="mb-0 text-gray-600">Monitor and manage all teachers across schools</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                <i class="fas fa-user-plus"></i> Add New Teacher
            </button>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#assignClassesModal">
                <i class="fas fa-chalkboard-teacher"></i> Assign Classes
            </button>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card teacher-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 teacher-stat-icon bg-primary-subtle">
                            <i class="fas fa-chalkboard-teacher text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Teachers</h6>
                            <h3 class="mb-0">{{ $totalTeachers ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> 8% increase
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card teacher-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 teacher-stat-icon bg-success-subtle">
                            <i class="fas fa-user-check text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Active Teachers</h6>
                            <h3 class="mb-0">{{ $activeTeachers ?? 0 }}</h3>
                            <small class="text-muted">Currently teaching</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card teacher-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 teacher-stat-icon bg-warning-subtle">
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Performance Rating</h6>
                            <h3 class="mb-0">4.8</h3>
                            <small class="text-success">Above average</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card teacher-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 teacher-stat-icon bg-info-subtle">
                            <i class="fas fa-clock text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Attendance Rate</h6>
                            <h3 class="mb-0">96%</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> 2% increase
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance and Schedule -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Teacher Performance Overview</h5>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" data-bs-toggle="dropdown">
                            This Month
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">This Week</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="teacherPerformanceChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Today's Schedule</h5>
                </div>
                <div class="card-body">
                    <div class="schedule-timeline">
                        @foreach($todaySchedule ?? [] as $schedule)
                        <div class="schedule-item">
                            <div class="schedule-time">{{ $schedule->time }}</div>
                            <div class="schedule-content">
                                <h6 class="mb-1">{{ $schedule->subject }}</h6>
                                <p class="mb-0 text-muted">
                                    {{ $schedule->teacher }} • {{ $schedule->class }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers Table -->
    <div class="dashboard-card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Teachers</h5>
            <div class="d-flex gap-2">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="teacherSearch" placeholder="Search teachers...">
                </div>
                <button class="btn btn-outline-primary">
                    <i class="fas fa-filter"></i>
                </button>
                <button class="btn btn-outline-primary">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover teacher-table">
                    <thead>
                        <tr>
                            <th>Teacher</th>
                            <th>ID</th>
                            <th>Subject</th>
                            <th>Classes</th>
                            <th>Performance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers ?? [] as $teacher)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . ($teacher->photo ?? 'default.jpg')) }}" 
                                         class="rounded-circle me-2" 
                                         width="32" 
                                         height="32"
                                         alt="{{ $teacher->name }}">
                                    <div>
                                        <h6 class="mb-0">{{ $teacher->name }}</h6>
                                        <small class="text-muted">{{ $teacher->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $teacher->teacher_id }}</td>
                            <td>{{ $teacher->subject }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @foreach($teacher->classes as $class)
                                    <span class="badge bg-light text-dark me-1">{{ $class }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1" style="height: 5px;">
                                        <div class="progress-bar bg-success" style="width: {{ $teacher->performance }}%"></div>
                                    </div>
                                    <span class="ms-2">{{ $teacher->performance }}%</span>
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
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>Schedule</a></li>
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

<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addTeacherForm" class="teacher-form">
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
                            <input type="tel" class="form-control" name="phone" required>
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
                            <label class="form-label">Subject</label>
                            <select class="form-select" name="subject" required>
                                <option value="">Select Subject</option>
                                <option value="mathematics">Mathematics</option>
                                <option value="english">English</option>
                                <option value="science">Science</option>
                                <!-- Add more subjects -->
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
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Qualification</label>
                            <input type="text" class="form-control" name="qualification" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Experience (Years)</label>
                            <input type="number" class="form-control" name="experience" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Teacher Photo</label>
                            <input type="file" class="form-control" name="photo" accept="image/*">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addTeacherForm" class="btn btn-primary">Add Teacher</button>
            </div>
        </div>
    </div>
</div>

<!-- Assign Classes Modal -->
<div class="modal fade" id="assignClassesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Classes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="assignClassesForm">
                    <div class="mb-3">
                        <label class="form-label">Teacher</label>
                        <select class="form-select" name="teacher_id" required>
                            <option value="">Select Teacher</option>
                            @foreach($teachers ?? [] as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Classes</label>
                        <select class="form-select" name="classes[]" multiple required>
                            <option value="class1">Class 1</option>
                            <option value="class2">Class 2</option>
                            <option value="class3">Class 3</option>
                            <!-- Add more classes -->
                        </select>
                        <small class="text-muted">Hold Ctrl/Cmd to select multiple classes</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="assignClassesForm" class="btn btn-primary">Assign Classes</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
// Initialize performance chart
const ctx = document.getElementById('teacherPerformanceChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Average Performance',
            data: [85, 87, 84, 86, 89, 88],
            borderColor: '#4e73df',
            tension: 0.3,
            fill: false
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: false,
                min: 80,
                max: 90
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Search functionality
document.getElementById('teacherSearch').addEventListener('keyup', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const table = document.querySelector('.teacher-table');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Initialize select2 for multiple select
$(document).ready(function() {
    $('select[multiple]').select2({
        placeholder: 'Select classes',
        closeOnSelect: false
    });
});
</script>
@endsection
