@extends('manager.base')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Question Detail</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Questions</li>
            <li class="breadcrumb-item active">Question Detail</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Question Detail
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Question</th>
                            <td>{!! $question->question !!}</td>
                        </tr>
                        <tr>
                            <th>Option 1</th>
                            <td>{!! $question->option1 !!}</td>
                        </tr>
                        <tr>
                            <th>Option 2</th>
                            <td>{!! $question->option2 !!}</td>
                        </tr>
                        <tr>
                            <th>Option 3</th>
                            <td>{!! $question->option3 !!}</td>
                        </tr>
                        <tr>
                            <th>Option 4</th>
                            <td>{!! $question->option4 !!}</td>
                        </tr>
                        <tr>
                            <th>Answer</th>
                            <td>{!! $question->answer !!}</td>
                        </tr>
                        <tr>
                            <th>Subject</th>
                            <td>{!! $question->subject->name !!}</td>
                        </tr>
                        <tr>
                            <th>Added By</th>
                            <td>{!! $question->user->first_name !!} {!! $question->user->last_name !!}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('manager.questions.approve', $question->id) }}" class="btn btn-success">Approve</a>
                    <a href="{{ route('manager.questions.reject', $question->id) }}" class="btn btn-danger">Reject</a>
                </div>
            </div>
        </div>
    </div>
@endsection
