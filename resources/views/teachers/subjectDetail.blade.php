@extends('teachers.base')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Subject Detail</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Subject Detail</li>
        </ol>
        <div class="card mb-4">
            <div class="row g-0">
                <div class="col-md-3">
                    <img src="{{ asset('storage/' . $subject->image) }}" class="img-fluid rounded-start" alt="subject image">
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <h5 class="card-title">{{ $subject->name }}</h5>
                        <p class="card-text">{{ $subject->shore_code }}</p>
                        <p class="card-text">Grade: {{ $subject->grade }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Students List</h5>
                <table id="datatablesSimple">
                <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->email }}</td>
                                
                                <td>{{ $student->grade }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
