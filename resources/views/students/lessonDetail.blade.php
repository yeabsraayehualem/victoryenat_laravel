@extends('students.base')

@section('content')
    <div class="container">
        <h2>Lesson Details</h2>

        <!-- Display the lesson details -->
        <div class="lesson-details">
            <h3>Title: {{ $lesson->title }}</h3>
            <p><strong>Subject: </strong>{{ $lesson->subject->name }}</p> <!-- Accessing the subject's name -->
            <p><strong>Description: </strong>{!! $lesson->description !!}</p> <!-- Display the description with HTML formatting -->
        </div>
    </div>
@endsection
