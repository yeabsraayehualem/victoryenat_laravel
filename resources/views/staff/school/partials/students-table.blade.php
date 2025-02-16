<div class="table-responsive">
    @if(isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endif

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Grade</th>
                <th>Parent Contact</th>
                <th>Status</th>
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
                <td>{{ $student->parent_phone }}</td>
                <td>
                    <span class="badge bg-{{ $student->is_active ? 'success' : 'danger' }}">
                        {{ $student->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
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
