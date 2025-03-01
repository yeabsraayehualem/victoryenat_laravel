@extends('staff.base')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Exam</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('staff.exams') }}">Exams</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Edit Exam
                </div>
                <div class="card-body">
                    <form hx-put="{{ route('staff.exam.update', $exam->id) }}"
                          hx-indicator="#submit-indicator">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Exam Name</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $exam->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject_id" class="form-label">Subject</label>
                            <select class="form-select @error('subject_id') is-invalid @enderror" 
                                    id="subject_id" 
                                    name="subject_id" 
                                    required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" 
                                            {{ old('subject_id', $exam->subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       id="date" 
                                       name="date" 
                                       value="{{ old('date', $exam->date->format('Y-m-d')) }}" 
                                       required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" 
                                       class="form-control @error('time') is-invalid @enderror" 
                                       id="time" 
                                       name="time" 
                                       value="{{ old('time', $exam->time) }}" 
                                       required>
                                @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration (minutes)</label>
                            <input type="number" 
                                   class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" 
                                   name="duration" 
                                   value="{{ old('duration', $exam->duration) }}" 
                                   min="1" 
                                   required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="total_marks" class="form-label">Total Marks</label>
                                <input type="number" 
                                       class="form-control @error('total_marks') is-invalid @enderror" 
                                       id="total_marks" 
                                       name="total_marks" 
                                       value="{{ old('total_marks', $exam->total_marks) }}" 
                                       min="1" 
                                       required>
                                @error('total_marks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="passing_marks" class="form-label">Passing Marks</label>
                                <input type="number" 
                                       class="form-control @error('passing_marks') is-invalid @enderror" 
                                       id="passing_marks" 
                                       name="passing_marks" 
                                       value="{{ old('passing_marks', $exam->passing_marks) }}" 
                                       min="1" 
                                       required>
                                @error('passing_marks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('staff.exams') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <span id="submit-indicator" class="htmx-indicator">
                                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                    Updating...
                                </span>
                                <span class="htmx-indicator-none">
                                    <i class="fas fa-save me-1"></i> Update Exam
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection