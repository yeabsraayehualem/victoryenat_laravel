@extends('teachers.base')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Teacher Dashboard</h1>
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
                            <h6 class="text-muted mb-1">Total Students</h6>
                            <h3 class="mb-0">{{ $noOfUser ?? 0 }}</h3>
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
                            <h6 class="text-muted mb-1">Total Subjects</h6>
                            <h3 class="mb-0">{{ $subjects ?? 0 }}</h3>
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
                            <h6 class="text-muted mb-1">Questions Posted</h6>
                            <h3 class="mb-0">{{$postedQuestions}}</h3>
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
                            <h6 class="text-muted mb-1">Questions Accepted</h6>
                            <h3 class="mb-0">{{$acceptedQuestions}}</h3>
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
                    <h5 class="mb-0">Questions</h5>
                   
                </div>
                <div class="card-body">
                    <canvas id="teachersQuestionPostPerMonth" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Total Questions</h5>
                </div>
                <div class="card-body">
                    <canvas id="totalQuestions" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    
</div>


@endsection
@section('js')
<script src="/assets/demo/teachersQuestionGraph.js"></script>
<script src="/assets/demo/teachersQuestionDoughnugt.js"></script>
@endsection
