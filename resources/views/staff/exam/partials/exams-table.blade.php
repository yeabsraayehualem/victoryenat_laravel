<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Subject</th>
            <th>Date & Time</th>
            <th>Duration</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($exams as $exam)
            <tr>
                <td>{{ $exam->name }}</td>
                <td>{{ $exam->subject->name }}</td>
                <td>{{ $exam->getFormattedStartTime() }}</td>
                <td>{{ $exam->duration }} minutes</td>
                <td>
                    @php
                        $status = $exam->status();
                        $statusClass = match($status) {
                            'upcoming' => 'bg-info',
                            'on going' => 'bg-success',
                            'completed' => 'bg-secondary',
                            default => 'bg-warning'
                        };
                        $statusIcon = match($status) {
                            'upcoming' => 'fa-clock',
                            'on going' => 'fa-play',
                            'completed' => 'fa-check',
                            default => 'fa-exclamation-triangle'
                        };
                    @endphp
                    <span class="badge {{ $statusClass }}">
                        <i class="fas {{ $statusIcon }} me-1"></i>
                        {{ ucfirst($status) }}
                    </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('staff.exam.questions.list', $exam->id) }}" 
                       class="btn btn-info btn-sm me-2" 
                       title="Manage Questions">
                        <i class="fas fa-list-check"></i>
                    </a>
                    <a href="{{ route('staff.exam.edit', $exam->id) }}" 
                       class="btn btn-primary btn-sm me-2" 
                       title="Edit Exam">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-sm delete-exam" 
                            data-id="{{ $exam->id }}"
                            title="Delete Exam">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No exams found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-4">
    {{ $exams->links() }}
</div>
