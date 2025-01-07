@extends('staff.base')
@section('content')
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Exam</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Exams</li>
                    <li class="breadcrumb-item active">Edit Exam</li>
                </ol>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Exam</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('staff.exams.update', $exam->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="title">Exam Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name', $exam->name) }}"></input>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="subject_id">Subject</label>
                                        <select name="subject_id" id="subject_id" class="form-control">
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ $subject->id == $exam->subject_id ? 'selected' : '' }}>
                                                    {{ $subject->name }} {{ $subject->grade }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="date">Exam Date</label>
                                            <input type="date" name="date" id="date" class="form-control"
                                                value="{{ old('date', $exam->date) }}"></input>
                                        </div>

                                        <div class="form-group col-md-4 mb-3">
                                            <label for="time">Exam Time</label>
                                            <input type="time" name="time" id="time" class="form-control"
                                                value="{{ old('time', $exam->time) }}"></input>
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="duration">Exam Duration</label>
                                            <input type="text" name="duration" id="duration" class="form-control"
                                                value="{{ old('duration', $exam->duration) }}"></input>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="total_marks">Total Marks</label>
                                            <input type="text" name="total_marks" id="total_marks" class="form-control"
                                                value="{{ old('total_marks', $exam->total_marks) }}"></input>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="passing_marks">Passing Marks</label>
                                            <input type="text" name="passing_marks" id="passing_marks"
                                                class="form-control"
                                                value="{{ old('passing_marks', $exam->passing_marks) }}"></input>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-primary">Edit Exam</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Questions</h4>
                        </div>
                        <div class="card-body">
                            <form id="add-question-form">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="question_id">Select Question</label>
                                    <select name="question_id" id="question_id" class="form-control">
                                        <option value="">Select Question</option>
                                        @foreach ($questions as $question)
                                            <option value="{{ $question->id }}">{!! Str::limit($question->question, 50) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary" id="add-question-btn">Add Question</button>
                            </form>
                            <div id="questions-list" class="mt-4">
                                <!-- List of added questions will appear here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Exam Questions</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Question</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="questions-table">
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
           
            </div>
      
@endsection
@section('js')
<script>
                document.addEventListener('DOMContentLoaded', ()=>{
                    fetchQuestions();

                });
               

                function fetchQuestions() {
                    console.log("hererher");
                    const examId = {{ $exam->id }};
                    fetch(`/staff/examsheet/questions/${examId}`)
                        .then(response => response.json())
                        .then(data => {
                            const tbody = document.getElementById('questions-table');
                            tbody.innerHTML = ''; // Clear previous questions
                            data.forEach(question => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${question.id}</td>
                                    <td>${question.question}</td>
                                    <td>
                                           <i class="fa fa-trash btn btn-danger" id="delete-question-${question.id}" onclick="deleteQuestion(${question.id})"></i>
                                           
                                    </td>
                                `;
                                tbody.appendChild(row);
                            });
                        });
                }

                function deleteQuestion(questionId) {
                    const examId = {{ $exam->id }};
                    fetch(`/staff/exams/${examId}/removeQuestion/${questionId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            fetchQuestions();
                            // document.getElementById(`delete-question-${questionId}`).parentElement.parentElement.remove();
                        } else {
                            alert('Failed to remove question');
                        }
                    });
                }
                
          
                document.getElementById('add-question-btn').addEventListener('click', function() {
                    var questionId = document.getElementById('question_id').value;
                    var examId = {{ $exam->id }};
                    var token = document.querySelector('input[name="_token"]').value;

                    if (questionId) {
                        fetch("{{ route('staff.exams.addQuestion') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                exam_id: examId,
                                question_id: questionId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                            fetchQuestions();
                            } else {
                                alert('Failed to add question');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    } else {
                        alert('Please select a question');
                    }
                });
            </script>
@endsection