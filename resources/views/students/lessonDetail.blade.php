@extends('students.base')

@section('content')
    <style>
        body {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
            -webkit-user-drag: none;
            pointer-events: none;
        }
        img {
            pointer-events: none;
            -webkit-user-drag: none;
        }
    </style>

    <div class="container" id="lesson-content">
        <h2>Lesson Details</h2>

        <!-- Display the lesson details -->
        <div class="lesson-details">
            <h3>Title: {{ $lesson->title }}</h3>
            <p><strong>Subject: </strong>{{ $lesson->subject->name }}</p> <!-- Accessing the subject's name -->
            <p><strong>Description: </strong>{!! $lesson->description !!}</p> <!-- Display the description with HTML formatting -->
        </div>
    </div>

    <script>
        // Disable right-click
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Prevent developer tools
        document.addEventListener('keydown', function(e) {
            if (e.keyCode == 123) { // F12
                e.preventDefault();
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                e.preventDefault();
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                e.preventDefault();
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                e.preventDefault();
            }
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                e.preventDefault();
            }
        });

        // Prevent copying
        document.addEventListener('copy', function(e) {
            e.preventDefault();
        });

        // Prevent cut
        document.addEventListener('cut', function(e) {
            e.preventDefault();
        });

        // Prevent paste
        document.addEventListener('paste', function(e) {
            e.preventDefault();
        });
    </script>
@endsection
