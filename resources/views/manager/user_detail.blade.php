@extends('manager.base')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                @if ($user->role == 'student')
                    Student Detail
                @else
                    Teacher Detail
                @endif
            </h1>
          
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" id="first_name" value="{{ $user->first_name }}" readonly>
            </div>
            <div class="col-md-6">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="last_name" value="{{ $user->last_name }}" readonly>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
            </div>
            <div class="col-md-6">
                @if ($user->role == 'student')
                    <label for="grade" class="form-label">Grade</label>
                    <input type="number" class="form-control" id="grade" value="{{ $user->grade }}" readonly>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" value="{{ $user->phone }}" readonly>
            </div>
            <div class="col-md-6">
                <label for="school" class="form-label">School</label>
                <input type="text" class="form-control" id="school" value="{{ $user->school->name }}" readonly>
            </div>
        </div>

        <div class="d-flex m-3 justify-content-end gap-2">
            <a href="{{ route('manager.students') }}" class="btn btn-danger">Back</a>
            @if ($user->role == 'teacher')
                @if ($user->status == 'active')
                    <a href="{{ route('manager.activateTeacher', $user->id) }}" class="btn btn-warning">Deactivate</a>
                @else
                    <a href="{{ route('manager.activateTeacher', $user->id) }}" class="btn btn-success">Activate</a>
                @endif
            @else
                @if ($user->status == 'active')
                    <a href="{{ route('manager.activateStudent', $user->id) }}" class="btn btn-warning">Deactivate</a>
                @else
                    <a href="{{ route('manager.activateStudent', $user->id) }}" class="btn btn-success">Activate</a>
                @endif
            @endif
        </div>

        @if ($user->role == 'teacher')
            <div class="row mt-3">
                <div class="col-md-12">
                    <label for="subject_id" class="form-label">Assign Subject</label>
                    <select class="form-select" id="subject_id">
                        <option value="">Select Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">
                                {{ $subject->name }} - {{ $subject->grade }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary mt-3" onclick="assignSubject('{{ $user->id }}')">Assign</button>
                </div>

                <div class="col-md-12 mt-4">
                    <h2 class="h4">Assigned Subjects</h2>
                    <table class="table" id="assigned-subjects-table">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Short Code</th>
                                <th>Grade</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="assigned-subjects-body">
                            @foreach ($techersubjects as $teacher)
                                <tr>
                                    <td>{{ $teacher->subject->name}}</td>
                                    <td>{{  $teacher->subject->shore_code }}</td>
                                    <td>{{  $teacher->subject->grade }}</td>
                                    <td>
                                        <button class="btn btn-danger" onclick="unassignSubject('{{ $user->id }}', '{{ $subject->id }}')">
                                            Unassign
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')
    <script>
        function assignSubject(userId) {
            const subjectId = document.getElementById('subject_id').value;
            if (!subjectId) {
                alert('Please select a subject');
                return;
            }

            fetch(`/manager/assignSubject/${subjectId}/${userId}`, {
                method: "GET"
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    fetchAssignedSubjects(userId);
                } else {
                    alert('Error assigning subject. Please try again.');
                }
            })
            .catch(error => {
                console.log(error);
                alert('Error assigning subject. Please try again.');
            });
        }

        function unassignSubject(userId, subjectId) {
            $.ajax({
                url: `/manager/unassignSubject/${subjectId}/${userId}`,
                type: "GET",
                success: function(response) {
                    if (response.status === 'success') {
                        fetchAssignedSubjects(userId);
                    }
                },
                error: function() {
                    alert('Error unassigning subject. Please try again.');
                }
            });
        }

        function fetchAssignedSubjects(userId) {
            fetch(`/manager/getTeacherSubjects/${userId}`, {
                method: "GET"
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const tableBody = document.getElementById('assigned-subjects-body');
                    tableBody.innerHTML = '';

                    data.data.forEach(subject => {
                        const row = `
                            <tr>
                                <td>${subject.name}</td>
                                <td>${subject.short_code}</td>
                                <td>${subject.grade}</td>
                                <td>
                                    <button class="btn btn-danger" onclick="unassignSubject(${userId}, ${subject.id})">
                                        Unassign
                                    </button>
                                </td>
                            </tr>
                        `;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                }
            })
            .catch(error => {
                console.log(error);
                alert('Error fetching assigned subjects. Please try again.');
            });
        }

       document.addEventListener('DOMContentLoaded', () => {
            fetchAssignedSubjects({{ $user->id }});
        });
    </script>
@endsection
