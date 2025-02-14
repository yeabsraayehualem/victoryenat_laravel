@extends('students.base')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Exam Results: {{ $exam->name }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center p-3 border rounded bg-light">
                        <h4 class="mb-3">Score Summary</h4>
                        <h2 class="mb-2 {{ $score['percentage'] >= 50 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($score['percentage'], 1) }}%
                        </h2>
                        <p class="mb-1">Correct Answers: {{ $score['correct_answers'] }} / {{ $score['total_questions'] }}</p>
                        <p class="mb-0">Status: 
                            <span class="badge {{ $score['percentage'] >= 50 ? 'bg-success' : 'bg-danger' }}">
                                {{ $score['percentage'] >= 50 ? 'PASSED' : 'FAILED' }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Below you can review all questions, your answers, and the correct answers.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h4 class="mb-0">Detailed Review</h4>
        </div>
        <div class="card-body">
            @foreach($exam->examSheets as $index => $sheet)
                @php
                    $studentAnswer = $studentAnswers[$sheet->question->id] ?? null;
                    $isCorrect = $studentAnswer && $studentAnswer->correct;
                @endphp
                <div class="question-review mb-4 p-3 border rounded {{ $isCorrect ? 'border-success' : 'border-danger' }}">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="mb-0">
                            Question {{ $index + 1 }}
                            @if($isCorrect)
                                <span class="badge bg-success ms-2">Correct</span>
                            @else
                                <span class="badge bg-danger ms-2">Incorrect</span>
                            @endif
                        </h5>
                    </div>
                    
                    <div class="question-text mb-3">
                        {!! $sheet->question->question !!}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="options-list">
                                @foreach(['1' => 'option1', '2' => 'option2', '3' => 'option3', '4' => 'option4'] as $value => $option)
                                    <div class="option mb-2 p-2 rounded 
                                        {{ $value == $sheet->question->answer ? 'bg-success text-white' : '' }}
                                        {{ $studentAnswer && $value == $studentAnswer->answer && !$isCorrect ? 'bg-danger text-white' : '' }}">
                                        <i class="fas fa-{{ $value == $sheet->question->answer ? 'check' : ($studentAnswer && $value == $studentAnswer->answer ? 'times' : 'circle') }} me-2"></i>
                                        {!! $sheet->question->{$option} !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="answer-details p-3 bg-light rounded">
                                <p class="mb-2">
                                    <strong>Your Answer:</strong>
                                    @if($studentAnswer)
                                        {{ $sheet->question->{'option' . $studentAnswer->answer} }}
                                    @else
                                        Not answered
                                    @endif
                                </p>
                                <p class="mb-0">
                                    <strong>Correct Answer:</strong>
                                 {{ $sheet->question->answer}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="{{ route('student.dashboard') }}" class="btn btn-primary">
            <i class="fas fa-home me-2"></i>Back to Dashboard
        </a>
    </div>
</div>
@endsection

@section('css')
<style>
    .question-review {
        transition: all 0.3s ease;
    }
    .question-review:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .option {
        transition: all 0.3s ease;
    }
    .option:not(.bg-success):not(.bg-danger):hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
