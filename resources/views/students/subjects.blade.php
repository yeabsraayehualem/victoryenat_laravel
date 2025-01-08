@extends('students.base')
@section('content')



<div class="row p-3">
    @foreach($subjects as $subject)
        <div class="col-md-4">
            <a class="card" href="{{ route('student.subject.lessons', $subject->id)}}">
                <img src="{{ asset('storage/'.$subject->image) }}" class="card-img-top" alt="{{ $subject->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $subject->name }}</h5>
                    <p class="card-text">{{ $subject->description }}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection