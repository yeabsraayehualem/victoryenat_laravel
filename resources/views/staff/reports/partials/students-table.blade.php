<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Student</th>
                <th>Grade</th>
                <th>Average Score</th>
                <th>Last Exam</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="{{ $student->profile_photo ?? asset('images/default-avatar.png') }}" 
                             class="rounded-circle me-2" width="40" height="40"
                             alt="{{ $student->get_full_name() }}">
                        <div>
                            <div class="fw-bold">{{ $student->get_full_name() }}</div>
                            <div class="small text-muted">ID: {{ $student->student_id }}</div>
                        </div>
                    </div>
                </td>
                <td>Grade {{ $student->grade }}</td>
                <td>
                    @if($student->exam_results_count > 0)
                        {{ number_format($student->exam_results_avg_score, 1) }}%
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($student->latest_exam_result)
                        {{ $student->latest_exam_result->score }}%
                        <small class="text-muted d-block">
                            {{ $student->latest_exam_result->created_at->format('M d, Y') }}
                        </small>
                    @else
                        No exams taken
                    @endif
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-primary">View Results</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4">
                    <div class="text-muted">
                        @if(request()->filled('search') || request()->filled('grade'))
                            No students found matching your filters
                        @else
                            No students found
                        @endif
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
