@extends('teachers.base')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Add Question</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Question</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Add Question
        </div>
        <div class="card-body">
            <form action="{{ route('teacher.addQuestion') }}" method="POST">
                @csrf
               <div class="row">
               <div class="col-md-6 col-12 form-group">
                    <label for="subject_id">Subject</label>
                    <select name="subject_id" id="subject_id" class="form-control">
                        <option value="">Select Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }} -{{ $subject->grade }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 col-12 form-group">
                    <label for="subject_id">Chapter</label>
                   <input type="text" class="form-control" name="chapter" id="chapter" required   >
                </div>

               </div>
                <div class="form-group">
                    <label for="question">Question</label>
                    <textarea name="question" id="question" class="form-control" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="option1">Option 1</label>
                    <textarea name="option1" id="option1" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="option2">Option 2</label>
                    <textarea name="option2" id="option2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="option3">Option 3</label>
                    <textarea name="option3" id="option3" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="option4">Option 4</label>
                    <textarea name="option4" id="option4" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="answer">Answer</label>
                    <textarea name="answer" id="answer" class="form-control"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Question</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.tiny.cloud/1/gn50jnhq3ryp9lwxb8xw7n1o07tbqbklb8g94dbtybedjept/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#question, #option1, #option2, #option3, #option4, #answer',
            menubar: false,
            plugins: 'lists link image preview',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | preview | subscript superscript | link image',
            images_upload_url: `{{ route('tinymce.upload') }}`,
            automatic_uploads: true,
            file_picker_types: 'image',
            setup: function(editor) {
                editor.on('init', function() {
                    console.log('TinyMCE initialized successfully');
                });
                editor.on('error', function(error) {
                    alert('Error initializing TinyMCE: ' + error.message);
                });
            },
        });
    </script>
@endsection
