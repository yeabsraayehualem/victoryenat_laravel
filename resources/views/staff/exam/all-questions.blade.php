@extends('staff.base')
@section('content')
   
            <div class="container-fluid px-4">
                <h1 class="mt-4">All Questions</h1>
                <ol class="breadcrumb
                    mb-4">
                    <li class="breadcrumb
                        -item active">All Questions</li>
                </ol>

            </div>
            <div class="container">
                <div class="card mb-4 col-12">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        All Questions
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Option A</th>
                                    <th>Option B</th>
                                    <th>Option C</th>
                                    <th>Option D</th>
                                    <th>Correct Answer</th>
                                    <th>Subject</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $question)
                                    <tr>
                                        <td>{!! Str::limit($question->question, 50) !!}</td>
                                        <td>{!! Str::limit($question->option1, 50) !!}</td>
                                        <td>{!! Str::limit($question->option2, 50) !!}</td>
                                        <td>{!! Str::limit($question->option3, 50) !!}</td>
                                        <td>{!! Str::limit($question->option4, 50) !!}</td>
                                        <td>{{ Str::limit(e($question->answer), 50) }}</td>
                                        <td>{{ Str::limit(e($question->subject->name), 50) }}</td>
                                        <td>
                                            <a href="{{ route('staff.questions.edit', $question->id) }}"
                                                class="btn btn-primary">Edit</a>
                                            <a href=""
                                                class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    
@endsection
