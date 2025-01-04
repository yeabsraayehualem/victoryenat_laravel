@extends('staff.base')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">All Exams</h1>
                <ol class="breadcrumb
                    mb-4">
                    <li class="breadcrumb-item active">All Exams</li>
                </ol>
            </div>


            <div class="row">
                @foreach($exams as $exam)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                {{ $exam->name }}
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $exam->date }} at {{$exam->time}}</p>
                                <a href="{{ route('staff.exams.edit', $exam->id) }}" class="btn btn-primary">View Exam</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
@endsection
