@if($assignedQuestions->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        No questions have been assigned to this exam yet
    </div>
@else
    <div class="list-group">
        @foreach($assignedQuestions as $question)
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <div class="mb-2">
                            {!! Str::limit(strip_tags($question->question), 100) !!}
                        </div>
                        <div class="small text-muted">
                            <i class="fas fa-book me-1"></i>
                            {{ $question->subject->name }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-layer-group me-1"></i>
                            Chapter {{ $question->chapter }}
                        </div>
                    </div>
                    <button class="btn btn-danger btn-sm remove-question ms-3" 
                            data-id="{{ $question->id }}"
                            title="Remove from exam">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif
