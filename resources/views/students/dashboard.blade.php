@extends('students.base')
@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Student Dashboard</h1>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="dashboard-card student-stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 student-stat-icon bg-primary-subtle">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total Exams Taken</h6>
                                <h3 class="mb-0">{{ $totalStudents ?? 0 }}</h3>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> 12% increase
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="dashboard-card student-stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 student-stat-icon bg-success-subtle">
                                <i class="fas fa-user-check text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Passed Exams</h6>
                                <h3 class="mb-0">{{ $activeStudents ?? 0 }}</h3>
                                <small class="text-muted">Out of total students</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="dashboard-card student-stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 student-stat-icon bg-warning-subtle">
                                <i class="fas fa-graduation-cap text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Failed Exams</h6>
                                <h3 class="mb-0">{{ $graduatingStudents ?? 0 }}</h3>
                                <small class="text-muted">In next 3 months</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar for Upcoming Exams -->
        <div class="dashboard-card mb-4">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">Upcoming Exam Schedules</h5>
            </div>
            <div class="card-body">
                <div id="examCalendar"></div>
            </div>
        </div>

        
    </div>


@endsection
@section('js')
  <!-- Include FullCalendar Library -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
        fetch('/student/exam-schedules')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.status === 'success') {
            const events = data.data.map(exam => ({
                title: `${exam.subject} (${exam.time})`, // Event title
                start: exam.date, // Event date
                url: exam.url, // Link to exam detail
            }));

            const calendarEl = document.getElementById('examCalendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events,
            });

            calendar.render();
        } else {
            console.error('Invalid response status:', data);
        }
    })
    .catch(error => console.error('Error fetching exam schedules:', error));

      });
  </script>


@endsection
