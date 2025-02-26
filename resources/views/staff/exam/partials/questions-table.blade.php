<table id="questionsTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Question</th>
            <th>Subject</th>
            <th>Chapter</th>
            <th>Created By</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($questions as $question)
            <tr>
                <td>{!! Str::limit(strip_tags($question->question), 100) !!}</td>
                <td>{{ $question->subject->name }}</td>
                <td>{{ $question->chapter }}</td>
                <td>{{ $question->user->first_name }} {{ $question->user->last_name }}</td>
                <td>
                    @if($question->is_victory_approved)
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i> Fully Approved
                        </span>
                    @elseif($question->is_school_approved)
                        <span class="badge bg-info">
                            <i class="fas fa-school me-1"></i> School Approved
                        </span>
                    @else
                        <span class="badge bg-warning">
                            <i class="fas fa-clock me-1"></i> Pending
                        </span>
                    @endif
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" 
                                class="btn btn-info btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#viewQuestionModal{{ $question->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <a href="{{ route('staff.exam.edit-question', $question->id) }}" 
                           class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" 
                                class="btn btn-danger btn-sm delete-question" 
                                data-id="{{ $question->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <!-- View Modal -->
                    <div class="modal fade" id="viewQuestionModal{{ $question->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Question Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Question content -->
                                    <div class="mb-3">
                                        <h6>Question:</h6>
                                        <div class="p-3 bg-light rounded">
                                            <div class="tinymce-content">{!! $question->question !!}</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h6>Option A:</h6>
                                            <div class="p-2 bg-light rounded">
                                                <div class="tinymce-content">{!! $question->option1 !!}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Option B:</h6>
                                            <div class="p-2 bg-light rounded">
                                                <div class="tinymce-content">{!! $question->option2 !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h6>Option C:</h6>
                                            <div class="p-2 bg-light rounded">
                                                <div class="tinymce-content">{!! $question->option3 !!}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Option D:</h6>
                                            <div class="p-2 bg-light rounded">
                                                <div class="tinymce-content">{!! $question->option4 !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Correct Answer:</h6>
                                        <div class="p-2 bg-success text-white rounded">
                                            Option {{ strtoupper($question->answer) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No questions found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-4">
    {{ $questions->links() }}
</div>
