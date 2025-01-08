@extends('teachers.base')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Subjects</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">All Subjects</li>
        </ol>
    </div>
    <div class="card mb-4">
        <div class="card-body">
        <table id="datatablesSimple">
        <thead>
                    <tr>
                        <th>Name</th>
                        <th>Short Code</th>
                        <th>Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{ $subject->subject->name }}</td>
                            <td>{{ $subject->subject->shore_code }}</td>
                            <td>{{ $subject->subject->grade }}</td>
                            <td>
                                <a href="{{ route('teacher.subjectdetail', $subject->subject_id) }}" class="btn btn-primary">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
