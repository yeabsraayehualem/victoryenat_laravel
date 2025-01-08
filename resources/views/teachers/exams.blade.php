@extends('teachers.base')

@section('content')

    <div class="container-fluid px-4">
        <h1 class="mt-4">Exams</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Exams</li>
        </ol>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Exams
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Total Marks</th>
                        <th>Time Left</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr>
                            <td>{{ $exam->name }}</td>
                            <td>{{ $exam->date }}</td>
                            <td>{{ $exam->time }}</td>
                            <td>{{ $exam->total_marks }}</td>
                            <td>
                                @php
                                    $now = new DateTime();
                                    $then = new DateTime($exam->date.' '.$exam->time);
                                    $interval = $now->diff($then);
                                @endphp
                                {{ $interval->format('%d days, %h hours, %i minutes') }} left
                            </td>
                            <td>
                                <a href="{{ route('teacher.examDetail', $exam->id) }}" class="btn btn-primary">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
