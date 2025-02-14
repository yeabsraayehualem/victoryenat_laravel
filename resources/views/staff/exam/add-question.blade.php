@extends('staff.base')
@section('content')
    
            <div class="container-fluid px-4">
                <h1 class="mt-4">Add Question</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Questions</li>
                    <li class="breadcrumb-item active">Add Question</li>
                </ol>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Question</h4>
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
                                <form action="{{ route('staff.questions.add') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="question">Question</label>
                                        <textarea name="question" id="question" class="form-control" rows="5">{{ old('question') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="option1">Option 1</label>
                                        <textarea name="option1" id="option1" class="form-control">{{ old('option1') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="option2">Option 2</label>
                                        <textarea name="option2" id="option2" class="form-control">{{ old('option2') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="option3">Option 3</label>
                                        <textarea name="option3" id="option3" class="form-control">{{ old('option3') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="option4">Option 4</label>
                                        <textarea name="option4" id="option4" class="form-control">{{ old('option4') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="answer">Correct Answer (1-4)</label>
                                        <textarea  name="answer" id="answer" class="form-control"  required value="{{ old('answer') }}"></textarea>
                                        <small class="form-text text-muted">Enter the number of the correct option (1-4)</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject_id">Subject</label>
                                        <select name="subject_id" id="subject_id" class="form-control">
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}" >{{ $subject->name }}-{{$subject->grade}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-between mx-auto mt-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-danger">Clear</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       
@endsection

@section('js')
    <script src="https://cdn.tiny.cloud/1/gn50jnhq3ryp9lwxb8xw7n1o07tbqbklb8g94dbtybedjept/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#question, #option1, #option2, #option3, #option4,#answer',
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
