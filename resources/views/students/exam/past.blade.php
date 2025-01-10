@extends('students.base')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Past Exams</h3>
        </div>
        <div class="card-body">
            @if($pastExams->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No past exams found.
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
                                <th>Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pastExams as $exam)
                                @php
                                    $studentAnswer = $exam->studentAnswers->first();
                                @endphp
                                <tr>
                                    <td>{{ $exam->subject->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exam->date)->format('F j, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exam->time)->format('g:i A') }}</td>
                                    <td>{{ $exam->duration }} minutes</td>
                                    <td>
                                        @if($studentAnswer)
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-danger">Missed</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($studentAnswer)
                                            <span class="badge {{ $studentAnswer->score >= 50 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $studentAnswer->score }}%
                                            </span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($studentAnswer)
                                            <a href="{{ route('student.exam.result', $exam->id) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-chart-bar me-1"></i>
                                                View Result
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                                <i class="fas fa-times-circle me-1"></i>
                                                Not Taken
                                            </button>
                                        @endif
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
