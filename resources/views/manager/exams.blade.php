@extends('manager.base')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">All Exams</h1>
        <ol class="breadcrumb
            mb-4">
            <li class="breadcrumb-item active">All Exams</li>
        </ol>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Duration</th>
                        <th>Passing Marks</th>
                        <th>Subject</th>
                        <th>Remaining Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr>
                            <td>{{ $exam->name }}</td>
                            <td>{{ $exam->date }}</td>
                            <td>{{ $exam->time }}</td>
                            <td>{{ $exam->duration }} minutes</td>
                            <td>{{ $exam->passing_marks }}/{{ $exam->total_marks }}</td>
                            <td>{{ $exam->subject->name }}</td>
                            <td>
                                @php
                                    $now = new DateTime();
                                    $then = new DateTime($exam->date.' '.$exam->time);
                                    $interval = $now->diff($then);
                                @endphp
                                {{ $interval->format('%d days, %h hours, %i minutes') }} left
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
