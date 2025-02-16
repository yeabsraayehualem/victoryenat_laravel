@extends('staff.base')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ $exam->title }} - Results Analysis</h1>
    
    <!-- Questions Analysis -->
    <div class="card mt-4">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Questions Analysis by Chapter
        </div>
        <div class="card-body">
            @foreach($exam->questions->groupBy('chapter') as $chapter => $questions)
            <div class="mb-4">
                <h5>Chapter {{ $chapter }}</h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Correct Answer</th>
                                <th>Success Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $question)
                            @php
                                $stats = $questionStats->firstWhere('question_id', $question->id);
                                $successRate = $stats ? ($stats->correct_answers / $stats->total_attempts) * 100 : 0;
                            @endphp
                            <tr>
                                <td>{{ $question->question_text }}</td>
                                <td>{{ $question->correct_answer }}</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar {{ $successRate >= 70 ? 'bg-success' : ($successRate >= 40 ? 'bg-warning' : 'bg-danger') }}"
                                             role="progressbar"
                                             style="width: {{ $successRate }}%"
                                             aria-valuenow="{{ $successRate }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                            {{ number_format($successRate, 1) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Student Results -->
    <div class="card mt-4">
        <div class="card-header">
            <i class="fas fa-users me-1"></i>
            Student Results
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Score</th>
                            <th>Correct/Total</th>
                            <th>Time Taken</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $result->student->profile_photo ?? asset('images/default-avatar.png') }}" 
                                         class="rounded-circle me-2" width="40" height="40"
                                         alt="{{ $result->student->get_full_name() }}">
                                    <div>
                                        <div class="fw-bold">{{ $result->student->get_full_name() }}</div>
                                        <div class="small text-muted">Grade {{ $result->student->grade }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $result->score >= 50 ? 'success' : 'danger' }}">
                                    {{ $result->score }}%
                                </span>
                            </td>
                            <td>{{ $result->correct_answers }}/{{ $result->total_questions }}</td>
                            <td>{{ $result->time_taken }} minutes</td>
                            <td>
                                <button class="btn btn-sm btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#resultModal{{ $result->id }}">
                                    View Details
                                </button>
                            </td>
                        </tr>

                        <!-- Result Detail Modal -->
                        <div class="modal fade" id="resultModal{{ $result->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $result->student->get_full_name() }}'s Answers</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Question</th>
                                                        <th>Student's Answer</th>
                                                        <th>Correct Answer</th>
                                                        <th>Result</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($result->answers as $answer)
                                                    <tr>
                                                        <td>{{ $answer->question->question_text }}</td>
                                                        <td>{{ $answer->answer }}</td>
                                                        <td>{{ $answer->question->correct_answer }}</td>
                                                        <td>
                                                            @if($answer->is_correct)
                                                                <i class="fas fa-check text-success"></i>
                                                            @else
                                                                <i class="fas fa-times text-danger"></i>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
