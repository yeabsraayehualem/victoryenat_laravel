@extends('staff.base')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Create Exam</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('staff.exams') }}">Exams</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-plus me-1"></i>
                    Create New Exam
                </div>
                <div class="card-body">
                    <form hx-post="{{ route('staff.exam.store') }}"
                          hx-indicator="#submit-indicator">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Exam Name</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
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
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
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
                                       value="{{ old('date') }}" 
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
                                       value="{{ old('time') }}" 
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
                                   value="{{ old('duration') }}" 
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
                                       value="{{ old('total_marks') }}" 
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
                                       value="{{ old('passing_marks') }}" 
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
                                    Creating...
                                </span>
                                <span class="htmx-indicator-none">
                                    <i class="fas fa-save me-1"></i> Create Exam
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
