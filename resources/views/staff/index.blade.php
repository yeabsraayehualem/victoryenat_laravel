@extends('staff.base')
@section('content')
<div class="container-fluid px-4">
    <!-- Welcome Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="mb-0 text-gray-600">Welcome back, {{ auth()->user()->first_name }}!</p>
        </div>
        <div class="d-flex gap-2">

            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                <i class="fas fa-download"></i> Generate Report
            </button>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="card-icon bg-primary-subtle">
                            <i class="fas fa-user-graduate text-primary"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('staff.students') }}">View All</a></li>
                                <li><a class="dropdown-item" href="#">Export List</a></li>
                            </ul>
                        </div>
                    </div>
                    <h3 class="mb-1">{{ number_format(count($students)) }}</h3>
                    <p class="text-muted mb-0">Total Students</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar" role="progressbar" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="card-icon bg-success-subtle">
                            <i class="fas fa-chalkboard-teacher text-success"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('staff.teachers') }}">View All</a></li>
                                <li><a class="dropdown-item" href="#">Export List</a></li>
                            </ul>
                        </div>
                    </div>
                    <h3 class="mb-1">{{ number_format(count($teachers)) }}</h3>
                    <p class="text-muted mb-0">Total Teachers</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="card-icon bg-warning-subtle">
                            <i class="fas fa-user-shield text-warning"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('staff.managers') }}">View All</a></li>
                                <li><a class="dropdown-item" href="#">Export List</a></li>
                            </ul>
                        </div>
                    </div>
                    <h3 class="mb-1">{{ number_format(count($school_managers)) }}</h3>
                    <p class="text-muted mb-0">School Managers</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="card-icon bg-info-subtle">
                            <i class="fas fa-school text-info"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('staff.schools') }}">View All</a></li>
                                <li><a class="dropdown-item" href="#">Export List</a></li>
                            </ul>
                        </div>
                    </div>
                    <h3 class="mb-1">{{ number_format(count($schools)) }}</h3>
                    <p class="text-muted mb-0">Total Schools</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- User Growth Chart -->
        <div class="col-xl-8">
            <div class="dashboard-card h-100">
                <div class="card-header border-0 bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">User Growth</h5>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary btn-sm active">Monthly</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm">Weekly</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm">Daily</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="usersCanvas" height="300"></canvas>
                </div>
            </div>
        </div>
        <!-- Users by Role Chart -->
        <div class="col-xl-4">
            <div class="dashboard-card h-100">
                <div class="card-header border-0 bg-transparent">
                    <h5 class="mb-0">Users by Role</h5>
                </div>
                <div class="card-body">
                    <canvas id="usersPieChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Quick Stats -->
    <div class="row g-4 mb-4">
        <!-- Recent Activity -->
        <div class="col-xl-8">
            <div class="dashboard-card h-100">
                <div class="card-header border-0 bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Activity</h5>
                        <a href="#" class="btn btn-link">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="activity-icon bg-primary-subtle text-primary rounded-circle p-2 me-3">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0">New student registration</p>
                                    <small class="text-muted">John Doe registered as a new student</small>
                                </div>
                                <small class="text-muted">2m ago</small>
                            </div>
                        </div>
                        <div class="list-group-item px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="activity-icon bg-success-subtle text-success rounded-circle p-2 me-3">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0">Course completed</p>
                                    <small class="text-muted">Sarah Wilson completed Mathematics 101</small>
                                </div>
                                <small class="text-muted">1h ago</small>
                            </div>
                        </div>
                        <div class="list-group-item px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="activity-icon bg-warning-subtle text-warning rounded-circle p-2 me-3">
                                    <i class="fas fa-school"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0">New school added</p>
                                    <small class="text-muted">Victory Academy was added to the system</small>
                                </div>
                                <small class="text-muted">3h ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick Stats -->
        <div class="col-xl-4">
            <div class="dashboard-card h-100">
                <div class="card-header border-0 bg-transparent">
                    <h5 class="mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Active Students</span>
                            <span class="text-dark">{{ number_format(count($students)) }}</span>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ (count($students) / count($users)) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Teacher Attendance</span>
                            <span class="text-dark">{{count($teachers)}}</span>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ (count($teachers) / count($users)) * 100 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">School Capacity</span>
                            <span class="text-dark">{{count($active_schools)}}</span>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ (count($active_schools) / count($schools)) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add School Modal -->
<div class="modal fade" id="addSchoolModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New School</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">School Name</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">School Type</label>
                        <select class="form-select">
                            <option>Primary School</option>
                            <option>Secondary School</option>
                            <option>High School</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add School</button>
            </div>
        </div>
    </div>
</div>

<!-- Generate Report Modal -->
<div class="modal fade" id="generateReportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Report Type</label>
                        <select class="form-select">
                            <option>Student Performance</option>
                            <option>Teacher Attendance</option>
                            <option>School Statistics</option>
                            <option>Financial Report</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date Range</label>
                        <select class="form-select">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                            <option>Last 3 Months</option>
                            <option>Custom Range</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Format</label>
                        <select class="form-select">
                            <option>PDF</option>
                            <option>Excel</option>
                            <option>CSV</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Generate</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
</script>
@endsection
