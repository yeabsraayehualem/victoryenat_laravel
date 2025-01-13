 @extends('manager.base')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <div class="d-flex gap-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#announcementModal">
                    <i class="fas fa-bullhorn"></i> Make Announcement
                </button>
                <button class="btn btn-success" onclick="window.print()">
                    <i class="fas fa-download"></i> Generate Report
                </button>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row g-4 mb-4">
            <!-- Total Teachers Card -->
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 teacher-stat-icon bg-primary-subtle">
                                <i class="fas fa-chalkboard-teacher text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total Teachers</h6>
                                <h3 class="mb-0">{{ $totalTeachers }}</h3>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> 8% increase
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Teachers Card -->
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 teacher-stat-icon bg-success-subtle">
                                <i class="fas fa-user-check text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Active Teachers</h6>
                                <h3 class="mb-0">{{ $activeTeachers }}</h3>
                                <small class="text-muted">Currently teaching</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Students Card -->
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 teacher-stat-icon bg-warning-subtle">
                                <i class="fas fa-user-graduate text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total Students</h6>
                                <h3 class="mb-0">{{ $totalStudents }}</h3>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> 8% increase
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Students Card -->
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 teacher-stat-icon bg-info-subtle">
                                <i class="fas fa-user text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Active Students</h6>
                                <h3 class="mb-0">{{ $activeStudents }}</h3>
                                <small class="text-muted">Currently enrolled</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Analytics and Activity Section -->
        <div class="row g-4">
            <!-- Performance Chart -->
            <div class="col-lg-8">
                <div class="dashboard-card h-100">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Performance Overview</h5>
                        <select class="form-select form-select-sm w-auto">
                            <option>This Week</option>
                            <option selected>This Month</option>
                            <option>This Year</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <canvas id="performanceChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="col-lg-4">
                <div class="dashboard-card h-100">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">Recent Activities</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach($recentActivities ?? [] as $activity)
                            <div class="timeline-item">
                                <i class="fas fa-circle"></i>
                                <div class="timeline-content">
                                    <p class="mb-0">{{ $activity->description }}</p>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Section -->
        <div class="row g-4 mt-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">Upcoming Events</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingExams ?? [] as $exam)
                                    <tr>
                                        <td>{{ $exam->title }}</td>
                                        <td>{{ $exam->date }}</td>
                                        <td>{{ $exam->time }}</td>
                                        <td>{{ $exam->location }}</td>
                                        <td><span class="badge bg-primary">Upcoming</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
        }
        .teacher-stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .timeline {
            position: relative;
            padding-left: 1.5rem;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
            border-left: 2px solid #e9ecef;
            padding-left: 20px;
        }
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        .timeline-item i {
            position: absolute;
            left: -7px;
            top: 0;
            font-size: 0.5rem;
            color: #0d6efd;
            background: #fff;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Performance Chart
        const ctx = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Students Performance',
                    data: [65, 59, 80, 81, 56, 55],
                    borderColor: '#0d6efd',
                    tension: 0.4
                }, {
                    label: 'Teachers Performance',
                    data: [28, 48, 40, 19, 86, 27],
                    borderColor: '#198754',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
