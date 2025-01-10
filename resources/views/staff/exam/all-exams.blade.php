@extends('staff.base')
@section('content')

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
                                <p class="card-text">{{ \Carbon\Carbon::parse($exam->date)->format('F j, Y') }} at {{ \Carbon\Carbon::parse($exam->time)->format('g:i A') }}</p>
                                <p class="card-text">{{$exam->status()}}</p>
                                <a href="{{ route('staff.exams.edit', $exam->id) }}" class="btn btn-primary">View Exam</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
      
@endsection
