@extends('students.base')

@section('content')
<div class="container">
    <h1>Exam Details</h1>
    <div class="row">
        <div class="col-md-6 exam-details">
            <p><strong>Exam Name:</strong> {{ $exam->name }}</p>
            <p><strong>Subject:</strong> {{ $exam->subject->name }}</p>
            <p><strong>Date:</strong> {{ $exam->date }}</p>
            <p><strong>Duration:</strong> {{ $exam->duration }} minutes</p>
            <p><strong>Time Left to Start:</strong> <span id="time-left"></span></p>
            <script>
                function calculateTimeLeft(endTime) {
                    const now = new Date().getTime();
                    const distance = endTime - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    return `${days}d ${hours}h ${minutes}m ${seconds}s`;
                }

                function updateTimeLeft() {
                    const endTime = new Date("{{ $exam->date }}").getTime();
                    document.getElementById('time-left').innerText = calculateTimeLeft(endTime);
                }

                setInterval(updateTimeLeft, 1000);
                updateTimeLeft();
            </script>
        </div>
<div class="col-md-6">
    <img src="{{ asset('storage/' .$exam->subject->image) }}" alt="Subject Image" style="max-width: 100%; height: auto;">
</div>
</div>
    </div>


    @if($exam->isOngoing())
        <a href="{{ route('students.startExam', $exam->id) }}" class="btn btn-primary">Start Exam</a>
    @endif
</div>
@endsection
