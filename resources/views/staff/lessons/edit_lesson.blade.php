@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Lesson</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staff.lessons.index') }}">Lessons</a></li>
                    <li class="breadcrumb-item active">Edit Lesson</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('staff.lessons.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Lessons
        </a>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('staff.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <!-- Lesson Title -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Lesson Title</label>
                            <input type="text" 
                                   name="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $lesson->title) }}" 
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
                                    <option value="{{ $subject->id }}" 
                                            {{ old('subject_id', $lesson->subject_id) == $subject->id ? 'selected' : '' }}>
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
                                    <option value="{{ $grade }}" 
                                            {{ old('grade_level', $lesson->grade_level) == $grade ? 'selected' : '' }}>
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
                                   value="{{ old('duration', $lesson->duration) }}" 
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
                                      placeholder="Enter lesson content">{{ old('content', $lesson->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Materials -->
                    @if($lesson->materials->count() > 0)
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">Current Materials</label>
                            <div class="list-group">
                                @foreach($lesson->materials as $material)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file me-2"></i>
                                        {{ $material->filename }}
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('staff.lessons.material.download', $material->id) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="deleteMaterial({{ $material->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- New Materials -->
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">Add New Materials</label>
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
                                      placeholder="Any additional notes or instructions">{{ old('notes', $lesson->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">
                                <i class="fas fa-redo"></i> Reset Changes
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Lesson
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
    .list-group-item {
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
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

    function deleteMaterial(materialId) {
        if(confirm('Are you sure you want to delete this material?')) {
            // Add your delete logic here
            axios.delete(`/staff/lessons/materials/${materialId}`)
                .then(response => {
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to delete material');
                });
        }
    }
</script>
@endsection