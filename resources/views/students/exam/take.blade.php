@extends('students.base')

@section('content')
<div class="container py-4">
    <div id="sebCheck" style="display: none;" class="alert alert-warning mb-4">
        <h4 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Safe Exam Browser Required!</h4>
        <p>This exam must be taken using Safe Exam Browser (SEB) for security reasons.</p>
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button onclick="checkSEBInstalled()" class="btn btn-primary me-2">
                    <i class="fas fa-external-link-alt me-2"></i>Open in SEB
                </button>
                <a href="https://safeexambrowser.org/download_en.html" target="_blank" class="btn btn-secondary">
                    <i class="fas fa-download me-2"></i>Download SEB
                </a>
            </div>
        </div>
    </div>

    <div id="examContent" style="display: none;">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ $exam->name }}</h3>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-clock me-2"></i>Time Left: 
                        <span id="timer" class="badge bg-light text-dark"></span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="exam-form" action="{{ route('student.exam.submit', $exam->id) }}" method="POST">
                    @csrf
                    @foreach($exam->examSheets as $index => $sheet)
                    <div class="question-container mb-4 p-3 border rounded">
                        <h5 class="mb-3">{{ $index + 1 }}. {!! $sheet->question->question !!}</h5>
                        <div class="options">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="answers[{{ $sheet->question->id }}]" value="1" required>
                                <label class="form-check-label">{!! $sheet->question->option1 !!}</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="answers[{{ $sheet->question->id }}]" value="2" required>
                                <label class="form-check-label">{!! $sheet->question->option2 !!}</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="answers[{{ $sheet->question->id }}]" value="3" required>
                                <label class="form-check-label">{!! $sheet->question->option3 !!}</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="answers[{{ $sheet->question->id }}]" value="4" required>
                                <label class="form-check-label">{!! $sheet->question->option4 !!}</label>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="d-grid gap-2 col-md-6 mx-auto">
                        <button type="submit" class="btn btn-primary btn-lg">Submit Exam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    function isSafeExamBrowser() {
        return navigator.userAgent.indexOf('SEB') !== -1;
    }

    function checkSEBInstalled() {
        // Try to open the exam in SEB using the seb:// protocol
        window.location.href = 'seb://' + window.location.href;
        
        // After a short delay, check if we're still here (meaning SEB isn't installed)
        setTimeout(function() {
            if (!isSafeExamBrowser()) {
                alert('Safe Exam Browser is not installed. Please download and install it first.');
                window.location.href = 'https://safeexambrowser.org/download_en.html';
            }
        }, 1000);
    }

    // Check if we're in SEB when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        if (isSafeExamBrowser()) {
            document.getElementById('examContent').style.display = 'block';
            document.getElementById('sebCheck').style.display = 'none';
            initializeExam(); // Your existing exam initialization function
        } else {
            document.getElementById('examContent').style.display = 'none';
            document.getElementById('sebCheck').style.display = 'block';
        }
    });

    // Calculate end time in Addis Ababa timezone
    const duration = {{ $exam->duration }};
    const examDate = "{{ $exam->date }}";
    const examTime = "{{ $exam->time }}";
    
    // Create a date object in Addis Ababa timezone
    const options = { timeZone: 'Africa/Addis_Ababa' };
    const startTime = new Date(examDate + ' ' + examTime);
    const endTime = new Date(startTime.getTime() + duration * 60000);

    function updateTimer() {
        const now = new Date();
        // Convert to Addis Ababa time
        const nowAddis = new Date(now.toLocaleString('en-US', options));
        const timeLeft = endTime - nowAddis;

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            document.getElementById('exam-form').submit();
            return;
        }

        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        document.getElementById('timer').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    // Update timer immediately and then every second
    updateTimer();
    const timerInterval = setInterval(updateTimer, 1000);

    // Warn before leaving page
    window.onbeforeunload = function() {
        return "Are you sure you want to leave? Your answers will not be saved!";
    };

    // Remove warning when submitting form
    document.getElementById('exam-form').onsubmit = function() {
        window.onbeforeunload = null;
    };
</script>
@endsection
