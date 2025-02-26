@if($availableQuestions->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        No available questions found for this subject
    </div>
@else
    <div class="list-group">
        @foreach($availableQuestions as $question)
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
                    <button class="btn btn-primary btn-sm add-question ms-3" 
                            data-id="{{ $question->id }}"
                            title="Add to exam">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif
