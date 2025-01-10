@extends('students.base')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h1 class="h3 mb-3">{{ $exam->name }}</h1>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge {{ $exam->status() === 'upcoming' ? 'bg-primary' : ($exam->status() === 'on going' ? 'bg-success' : 'bg-secondary') }} px-3 py-2">
                                {{ ucfirst($exam->status()) }}
                            </span>
                            @php
                                $studentAnswer = \App\Models\StudentAnswer::where('student_id', auth()->id())
                                    ->where('exam_id', $exam->id)
                                    ->exists();
                            @endphp
                            @if($studentAnswer)
                                <span class="badge bg-info ms-2 px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i> Completed
                                </span>
                            @endif
                        </div>
                        
                    </div>

                    <div class="exam-info">
                        <div class="info-item mb-3">
                            <i class="fas fa-book text-primary me-2"></i>
                            <strong>Subject:</strong>
                            <span class="ms-2">{{ $exam->subject->name }}</span>
                        </div>
                        
                        <div class="info-item mb-3">
                            <i class="fas fa-calendar text-primary me-2"></i>
                            <strong>Start Time:</strong>
                            <span class="ms-2">{{ $exam->getFormattedStartTime() }}</span>
                        </div>

                        <div class="info-item mb-3">
                            <i class="fas fa-clock text-primary me-2"></i>
                            <strong>End Time:</strong>
                            <span class="ms-2">{{ $exam->getFormattedEndTime() }}</span>
                        </div>

                        <div class="info-item mb-3">
                            <i class="fas fa-hourglass-half text-primary me-2"></i>
                            <strong>Duration:</strong>
                            <span class="ms-2">{{ $exam->duration }} minutes</span>
                        </div>

                        <div class="info-item mb-3">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            <strong>Requirements:</strong>
                            <span class="ms-2">This exam must be taken using Safe Exam Browser (SEB)</span>
                            <div class="mt-2">
                                <a href="https://safeexambrowser.org/download_en.html" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download me-1"></i>
                                    Download SEB
                                </a>
                            </div>
                        </div>

                        @if($studentAnswer)
                            <div class="mt-4">
                                <a href="{{ route('student.exam.result', $exam->id) }}" 
                                   class="btn btn-info btn-lg">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    View Results
                                </a>
                            </div>
                        @elseif($exam->status() === 'on going')
                            <div class="mt-4">
                                <a href="{{ route('student.exam.start', $exam->id) }}" 
                                   class="btn btn-primary btn-lg">
                                    <i class="fas fa-play-circle me-2"></i>
                                    Start Exam
                                </a>
                            </div>
                        @elseif($exam->status() === 'upcoming')
                            <div class="alert alert-info mt-4">
                                <i class="fas fa-info-circle me-2"></i>
                                This exam has not started yet. Please check back at the scheduled time.
                            </div>
                        @else
                            <div class="alert alert-secondary mt-4">
                                <i class="fas fa-clock me-2"></i>
                                This exam has ended.
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="subject-image-container rounded overflow-hidden shadow-sm">
                        <img src="{{ asset('storage/' .$exam->subject->image) }}" 
                             alt="{{ $exam->subject->name }} Image" 
                             class="img-fluid w-100 h-100 object-fit-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.exam-info .info-item {
    font-size: 1.1rem;
}

.countdown-timer {
    border-left: 4px solid var(--bs-primary);
}

.subject-image-container {
    height: 300px;
    background-color: #f8f9fa;
}

.object-fit-cover {
    object-fit: cover;
}

.badge {
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}


</style>

@endsection

@section('js')
<script>
   
</script>
@endsection