@extends('manager.base')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Questions List</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Questions</li>
            <li class="breadcrumb-item active">Questions List</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Questions List
            </div>
            <div class="card-body">
            <table id="datatablesSimple">
            <thead>
                        <tr>
                            <th>Question</th>
                            <th> School Approved</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td>{!! Str::limit($question->question, 50) !!}</td>
                                <td>
                                    @if ($question->is_school_approved)
                                    <i class="fa fa-check btn btn-success"></i>
                                    @else
                                    <i class="fa fa-times btn btn-danger"></i>
                                    @endif
                                <td>
                                    <a href="{{ route('manager.questions.detail', $question->id) }}" class="btn btn-primary">Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
