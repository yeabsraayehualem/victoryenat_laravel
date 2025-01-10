@extends('students.base')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Upcoming Exams</h3>
        </div>
        <div class="card-body">
            @if($upcomingExams->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No upcoming exams scheduled at this time.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingExams as $exam)
                                <tr>
                                    <td>{{ $exam->subject->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exam->date)->format('F j, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exam->time)->format('g:i A') }}</td>
                                    <td>{{ $exam->duration }} minutes</td>
                                    <td>
                                        <span class="badge {{ $exam->status() === 'upcoming' ? 'bg-primary' : 'bg-success' }}">
                                            {{ ucfirst($exam->status()) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('student.exam.detail', $exam->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
