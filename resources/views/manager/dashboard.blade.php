@extends('manager.base')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <!-- <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                <i class="fas fa-user-plus"></i> Add New Teacher
            </button>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#assignClassesModal">
                <i class="fas fa-chalkboard-teacher"></i> Assign Classes
            </button>
        </div> -->
    </div>

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
                        <div class="flex-shrink-0 teacher-stat-icon bg-primary-subtle">
                            <i class="fas fa-chalkboard-teacher text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Students</h6>
                            <h3 class="mb-0">{{ $totalStudents ?? 0 }}</h3>
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
                            <h6 class="text-muted mb-1">Active Students</h6>
                            <h3 class="mb-0">{{ $activeStudents ?? 0 }}</h3>
                            <small class="text-muted">Currently Learning</small>
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
                    <h5 class="mb-0">Users Overview ( {{$totalUsers ?? 0}} users)</h5>
                    <!-- <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" data-bs-toggle="dropdown">
                           
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">This Week</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div> -->
                </div>
                <div class="card-body">
                    <canvas id="usersOverview" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0 p-1 text-center">Up Comming Exams {{ count($upcomingExams ?? []) }}</h5>
                </div>
                <div class="card-body " style="height: 300px; overflow-y: auto;">
                    <div class="schedule-timeline">
                        @if (! $upcomingExams || count($upcomingExams) == 0)
                        <p class="text-center mt-5"><i class="fa fa-smile text-warning fa-3x"></i> <br> No Exam Scheduled </p>
                        @else
                        @foreach($upcomingExams ?? [] as $exam)
                        <div class="schedule-item">
                            <div class="schedule-time">{{ $exam->name }}</div>
                            <div class="schedule-content">
                                <h6 class="mb-1">{{ $exam->subject->name }}</h6>
                                <p class="mb-0 text-muted">
                                    {{ $exam->date }} • {{ $exam->time }}
                                    <br>
                                    @php
                                        $now = new DateTime();
                                        $then = new DateTime($exam->date.' '.$exam->time);
                                        $interval = $now->diff($then);
                                        $endTime = new DateTime($exam->date.' '.$exam->time);
                                        $endTime->modify('+'.$exam->duration.' minutes');
                                    @endphp
                                    @if($now < $endTime && $now > $then)
                                    <span class="badge rounded-pill bg-success">Ongoing</span>
                                    @endif
                                    {{ $interval->format('%d days, %h hours, %i minutes') }} left

                                </p>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
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