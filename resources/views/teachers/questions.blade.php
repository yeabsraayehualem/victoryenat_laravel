@extends('teachers.base')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Questions</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Questions</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Questions List
            <a href="{{ route('teacher.addQuestion') }}" class="btn btn-primary float-end">Add New Question</a>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Subject</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                        <tr>
                            <td>{!! Str::limit($question->question, 50) !!}</td>
                            <td>{{ $question->subject->name }}</td>
                            <td>
                                <a href="{{ route('teacher.questionDetail', $question->id) }}" class="btn btn-primary">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
