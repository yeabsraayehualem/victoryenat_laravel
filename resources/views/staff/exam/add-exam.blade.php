@extends('staff.base')
@section('content')
  
            <div class="container-fluid px-4">
                <h1 class="mt-4">Add Exam</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Exams</li>
                    <li class="breadcrumb-item active">Add Exam</li>
                </ol>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Exam</h4>
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
                                <form action="{{ route('staff.exams.add') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="title">Exam Name</label>
                                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="subject_id">Subject</label>
                                        <select name="subject_id" id="subject_id" class="form-control" onchange="fetchQuestions()">
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }} {{$subject->grade}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="date">Exam Date</label>
                                            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}">
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="time">Exam Time</label>
                                            <input type="time" name="time" id="time" class="form-control" value="{{ old('time') }}">
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="duration">Exam Duration</label>
                                            <input type="text" name="duration" id="duration" class="form-control" value="{{ old('duration') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="total_marks">Total Marks</label>
                                        <input type="text" name="total_marks" id="total_marks" class="form-control" value="{{ old('total_marks') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="passing_marks">Passing Marks</label>
                                        <input type="text" name="passing_marks" id="passing_marks" class="form-control" value="{{ old('passing_marks') }}">
                                    </div>


                                    <button type="submit" class="btn btn-primary">Add Exam</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
      

    <script>
        function fetchQuestions() {
            const subjectId = document.getElementById('subject_id').value;
            if (subjectId) {
                fetch(`/api/questions/${subjectId}`)
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.querySelector('#questionsTable tbody');
                        tbody.innerHTML = ''; // Clear previous questions
                        data.forEach(question => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td><input type="checkbox" name="questions[]" value="${question.id}"></td>
                                <td>${question.text}</td>
                                <td><input type="number" name="marks[${question.id}]" class="form-control" value="${question.marks}"></td>
                            `;
                            tbody.appendChild(row);
                        });
                    });
            }
        }
    </script>
@endsection

