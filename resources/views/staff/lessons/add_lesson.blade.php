@extends('staff.base')
@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Lesson</h1>
        <a href="{{ route('staff.lessons.all') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Lessons
        </a>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('staff.lessons.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- Lesson Title -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Lesson Title</label>
                            <input type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="Enter lesson title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Subject Selection -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Subject</label>
                            <select name="subject_id" class="form-select @error('subject_id') is-invalid @enderror">
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
                    </div>

                    <!-- Grade Level -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Grade Level</label>
                            <select name="grade_level" class="form-select @error('grade_level') is-invalid @enderror">
                                <option value="">Select Grade Level</option>
                                @foreach(range(1, 12) as $grade)
                                    <option value="{{ $grade }}" {{ old('grade_level') == $grade ? 'selected' : '' }}>
                                        Grade {{ $grade }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grade_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Duration -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Duration (minutes)</label>
                            <input type="number"
                                   name="duration"
                                   class="form-control @error('duration') is-invalid @enderror"
                                   value="{{ old('duration') }}"
                                   placeholder="Enter duration in minutes">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Lesson Content -->
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">Lesson Content</label>
                            <textarea name="content"
                                      id="lessonContent"
                                      class="form-control @error('content') is-invalid @enderror"
                                      rows="6"
                                      placeholder="Enter lesson content">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Learning Materials -->
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">Learning Materials</label>
                            <div class="input-group">
                                <input type="file"
                                       name="materials[]"
                                       class="form-control @error('materials') is-invalid @enderror"
                                       multiple>
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-paperclip"></i>
                                </span>
                            </div>
                            <small class="text-muted">Upload PDF, DOC, PPT files (Max: 10MB each)</small>
                            @error('materials')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">Additional Notes</label>
                            <textarea name="notes"
                                      class="form-control @error('notes') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Any additional notes or instructions">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Lesson
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.6rem 1rem;
    }
    .form-label {
        margin-bottom: 0.5rem;
        color: #4a5568;
    }
    .input-group-text {
        border-radius: 0 8px 8px 0;
    }
    .btn {
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
    }
    .invalid-feedback {
        font-size: 0.875em;
    }
</style>
@endsection

@section('js')
<script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#lessonContent',
        height: 300,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | \
                alignleft aligncenter alignright alignjustify | \
                bullist numlist outdent indent | removeformat | help'
    });
</script>
@endsection
