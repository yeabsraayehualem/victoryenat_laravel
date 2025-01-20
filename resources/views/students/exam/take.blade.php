<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->name }} - Online Exam</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .question-nav-btn {
            width: 50px;
            height: 50px;
            margin: 5px;
        }
        .sticky-top {
            top: 20px;
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="row">
        <!-- Question Navigation Sidebar -->
        <div class="col-md-3 bg-light border-end">
            <div class="sticky-top pt-3">
                <h4 class="mb-3">Exam Navigation</h4>
                <div id="question-navigation" class="d-grid gap-2">
                    @foreach($exam->examSheets as $index => $sheet)
                        <button 
                            type="button" 
                            class="btn btn-outline-secondary question-nav-btn" 
                            data-question-id="{{ $sheet->question->id }}"
                            data-question-index="{{ $index }}"
                        >
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    <h5>Exam Status</h5>
                    <div class="d-flex align-items-center">
                        <span class="me-2 badge bg-success">Answered</span>
                        <span class="me-2 badge bg-white text-dark border">Unanswered</span>
                        <span class="badge bg-danger">Flagged</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam Content -->
        <div class="col-md-9">
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
                        <div 
                            class="question-container mb-4 p-3 border rounded" 
                            id="question-{{ $sheet->question->id }}"
                            style="display: {{ $index == 0 ? 'block' : 'none' }}"
                        >
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">{{ $index + 1 }}. {!! $sheet->question->question !!}</h5>
                                <button 
                                    type="button" 
                                    class="btn btn-sm btn-outline-warning flag-question" 
                                    data-question-id="{{ $sheet->question->id }}"
                                >
                                    <i class="fas fa-flag"></i> Flag Question
                                </button>
                            </div>
                            <div class="options">
                                <div class="form-check mb-2">
                                    <input 
                                        class="form-check-input question-radio" 
                                        type="radio" 
                                        name="answers[{{ $sheet->question->id }}]" 
                                        value="1" 
                                        data-question-id="{{ $sheet->question->id }}"
                                        required
                                    >
                                    <label class="form-check-label">{!! $sheet->question->option1 !!}</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input 
                                        class="form-check-input question-radio" 
                                        type="radio" 
                                        name="answers[{{ $sheet->question->id }}]" 
                                        value="2" 
                                        data-question-id="{{ $sheet->question->id }}"
                                        required
                                    >
                                    <label class="form-check-label">{!! $sheet->question->option2 !!}</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input 
                                        class="form-check-input question-radio" 
                                        type="radio" 
                                        name="answers[{{ $sheet->question->id }}]" 
                                        value="3" 
                                        data-question-id="{{ $sheet->question->id }}"
                                        required
                                    >
                                    <label class="form-check-label">{!! $sheet->question->option3 !!}</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input 
                                        class="form-check-input question-radio" 
                                        type="radio" 
                                        name="answers[{{ $sheet->question->id }}]" 
                                        value="4" 
                                        data-question-id="{{ $sheet->question->id }}"
                                        required
                                    >
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
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questionContainers = document.querySelectorAll('.question-container');
        const questionNavButtons = document.querySelectorAll('.question-nav-btn');
        const questionRadios = document.querySelectorAll('.question-radio');
        const flagButtons = document.querySelectorAll('.flag-question');

        // Question Navigation
        questionNavButtons.forEach(button => {
            button.addEventListener('click', function() {
                const questionId = this.getAttribute('data-question-id');
                const questionIndex = this.getAttribute('data-question-index');

                // Hide all question containers
                questionContainers.forEach(container => {
                    container.style.display = 'none';
                });

                // Show selected question
                document.getElementById(`question-${questionId}`).style.display = 'block';

                // Update active navigation button
                questionNavButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Track answered questions
        questionRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const questionId = this.getAttribute('data-question-id');
                const navButton = document.querySelector(`.question-nav-btn[data-question-id="${questionId}"]`);
                
                if (this.checked) {
                    navButton.classList.remove('btn-outline-secondary', 'btn-outline-danger');
                    navButton.classList.add('btn-success');
                }
            });
        });

        // Flag Question
        flagButtons.forEach(button => {
            button.addEventListener('click', function() {
                const questionId = this.getAttribute('data-question-id');
                const navButton = document.querySelector(`.question-nav-btn[data-question-id="${questionId}"]`);
                
                this.classList.toggle('btn-warning');
                navButton.classList.toggle('btn-danger');
            });
        });

        // Timer logic
        const duration = {{ $exam->duration }};
        const examDate = "{{ $exam->date }}";
        const examTime = "{{ $exam->time }}";
        
        const options = { timeZone: 'Africa/Addis_Ababa' };
        const startTime = new Date(examDate + ' ' + examTime);
        const endTime = new Date(startTime.getTime() + duration * 60000);

        function updateTimer() {
            const now = new Date();
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
    });
</script>
</body>
</html>
