@extends('staff.base')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ $school->name }} Report</h1>
    
    <!-- Navigation tabs -->
    <ul class="nav nav-tabs mt-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#students">
                Students ({{ $school->students->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#teachers">
                Teachers ({{ $school->teachers->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#managers">
                Managers ({{ $school->managers->count() }})
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content mt-4">
        <!-- Students Tab -->
        <div class="tab-pane fade show active" id="students">
            <div class="card">
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="studentSearch"
                                   placeholder="Search by name..."
                                   hx-get="{{ route('staff.reports.school.students', $school->id) }}"
                                   hx-trigger="keyup changed delay:500ms"
                                   hx-target="#studentsTable"
                                   hx-indicator="#loading-indicator">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="gradeFilter"
                                    hx-get="{{ route('staff.reports.school.students', $school->id) }}"
                                    hx-trigger="change"
                                    hx-target="#studentsTable"
                                    hx-indicator="#loading-indicator">
                                <option value="">All Grades</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">Grade {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="sortFilter"
                                    hx-get="{{ route('staff.reports.school.students', $school->id) }}"
                                    hx-trigger="change"
                                    hx-target="#studentsTable"
                                    hx-indicator="#loading-indicator">
                                <option value="name_asc">Name (A-Z)</option>
                                <option value="name_desc">Name (Z-A)</option>
                                <option value="grade_high">Grade (High-Low)</option>
                                <option value="grade_low">Grade (Low-High)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="htmx-indicator">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Students Table -->
                    <div id="studentsTable">
                        @include('staff.reports.partials.students-table', ['students' => $school->students])
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers Tab -->
        <div class="tab-pane fade" id="teachers">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($school->teachers as $teacher)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $teacher->profile_photo ?? asset('images/default-avatar.png') }}" 
                                                 class="rounded-circle me-2" width="40" height="40"
                                                 alt="{{ $teacher->get_full_name() }}">
                                            <div>
                                                <div class="fw-bold">{{ $teacher->get_full_name() }}</div>
                                                <div class="small text-muted">ID: {{ $teacher->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $teacher->subject }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>
                                        <span class="badge bg-{{ $teacher->is_active ? 'success' : 'danger' }}">
                                            {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="text-muted">No teachers found</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Managers Tab -->
        <div class="tab-pane fade" id="managers">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($school->managers as $manager)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $manager->profile_photo ?? asset('images/default-avatar.png') }}" 
                                                 class="rounded-circle me-2" width="40" height="40"
                                                 alt="{{ $manager->get_full_name() }}">
                                            <div>
                                                <div class="fw-bold">{{ $manager->get_full_name() }}</div>
                                                <div class="small text-muted">ID: {{ $manager->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ ucfirst($manager->role) }}</td>
                                    <td>{{ $manager->phone }}</td>
                                    <td>
                                        <span class="badge bg-{{ $manager->is_active ? 'success' : 'danger' }}">
                                            {{ $manager->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="text-muted">No managers found</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
