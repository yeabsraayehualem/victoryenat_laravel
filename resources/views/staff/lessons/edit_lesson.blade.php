@extends('staff.base')

@section('content')
    
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Lesson</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staff.lessons.all') }}">All Lessons</a></li>
                    <li class="breadcrumb-item active">Edit Lesson</li>
                </ol>
            </div>

            <div class=" mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Lesson</h4>
                        </div>
                        <div class="card-body">
                            <form id="lessonForm" action="{{ route('staff.lessons.editLesson', $id= $lesson->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row">

                                    <div class="mb-3 col-md-6 col-12">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $lesson->title }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6 col-12">
                                        <label for="subject_id" class="form-label">Subject</label>
                                        <select class="form-select @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                                            <option selected>Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}" {{ $lesson->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}- {{ $subject->grade }}</option>
                                            @endforeach
                                        </select>
                                        @error('subject_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="10" required>{{ $lesson->description }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12 col-md-6">
                                        <label for="image" class="form-label">Image</label>
                                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                   

                                </div>
                                <button type="button" onclick="submitForm()" class="btn btn-primary">Update Lesson</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- Add this closing div tag -->
      
@endsection

@section('js')
    <script src="https://cdn.tiny.cloud/1/gn50jnhq3ryp9lwxb8xw7n1o07tbqbklb8g94dbtybedjept/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
function submitForm(){
    document.getElementById('lessonForm').submit();
}

        tinymce.init({
            selector: '#description',
            menubar: false,
            plugins: 'lists link image preview',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | preview | subscript superscript | link image',
            images_upload_url: `{{ route('tinymce.upload') }}`,
            automatic_uploads: true,
            file_picker_types: 'image',
            images_upload_handler: function (blobInfo, success, failure) {
                let xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route('tinymce.upload') }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.onload = function() {
                    let json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function() {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            },
            apiKey: 'gn50jnhq3ryp9lwxb8xw7n1o07tbqbklb8g94dbtybedjept',
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
