@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Header -->
    <div class="card border-0 bg-gradient-primary text-white mb-4 overflow-hidden">
        <div class="card-body position-relative py-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="lead mb-0 opacity-75">
                        Here's what's happening with your schools today.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="current-time">
                        <i class="far fa-clock me-2"></i>
                        <span id="currentTime"></span>
                    </div>
                    <div class="current-date text-white-50">
                        <i class="far fa-calendar me-2"></i>
                        <span id="currentDate"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="fas fa-school fa-2x text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Schools</h6>
                            <h2 class="mb-0 counter">{{ $totalSchools }}</h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>12% increase
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success bg-opacity-10">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Students</h6>
                            <h2 class="mb-0 counter">{{ $totalStudents }}</h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>8% increase
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info bg-opacity-10">
                            <i class="fas fa-chalkboard-teacher fa-2x text-info"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Teachers</h6>
                            <h2 class="mb-0 counter">{{ $totalTeachers }}</h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>5% increase
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning bg-opacity-10">
                            <i class="fas fa-chart-line fa-2x text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Overall Performance</h6>
                            <h2 class="mb-0">{{ $performance }}%</h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>3% increase
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="row g-4">
        <!-- Performance Chart -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Performance Overview</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
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
                    <canvas id="performanceChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="card-title mb-0">Recent Activities</h5>
                </div>
                <div class="card-body p-0">
                    <div class="timeline">
                        @foreach($recentActivities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-icon bg-{{ $activity->type }}-subtle">
                                <i class="fas fa-{{ $activity->icon }}"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ $activity->title }}</h6>
                                <p class="mb-0 text-muted small">{{ $activity->description }}</p>
                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
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
    .timeline {
        position: relative;
        padding: 1rem;
    }
    .timeline-item {
        position: relative;
        padding-left: 3rem;
        padding-bottom: 1.5rem;
        border-left: 2px solid #e9ecef;
    }
    .timeline-icon {
        position: absolute;
        left: -1rem;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 2px solid #e9ecef;
    }
    .current-time {
        font-size: 1.5rem;
        font-weight: 600;
    }
    .counter {
        font-weight: 600;
    }
    .card {
        transition: box-shadow 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15)!important;
    }
</style>
@endsection

@section('js')
<script>
    // Initialize performance chart
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->labels) !!},
            datasets: [{
                label: 'Performance',
                data: {!! json_encode($chartData->values) !!},
                borderColor: '#4e73df',
                tension: 0.3,
                fill: true,
                backgroundColor: 'rgba(78, 115, 223, 0.05)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [2, 2]
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Update current time
    function updateTime() {
        const now = new Date();
        document.getElementById('currentTime').textContent = now.toLocaleTimeString();
        document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
    
    updateTime();
    setInterval(updateTime, 1000);

    // Initialize counters
    $('.counter').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 2000,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>
@endsection