@extends('staff.base')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-md-8">
                <h1 class="h3 text-gray-800 mb-2">
                    <i class="fas fa-book-open text-primary mr-2"></i>
                    {{ isset($subject) ? 'Edit' : 'Add New' }} Subject
                </h1>
                <p class="text-muted mb-0">
                    {{ isset($subject) ? 'Modify the details of an existing subject' : 'Create a new educational subject' }}
                </p>
            </div>
            <div class="col-12 col-md-4 text-right">
                <a href="{{ route('staff.subjects.all') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Subjects
                </a>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="row">
            <div class="col-12  ">
                <div class="card shadow-sm border-0">
                    <div class="card-header  text-white py-3">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-edit mr-2"></i>
                            {{ isset($subject) ? 'Edit Subject Details' : 'Create New Subject' }}
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Oops! There were some errors with your submission:</strong>
                                <ul class="mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form action="{{ isset($subject) ? route('staff.subjects.update', $subject->id) : route('staff.subjects.create') }}" 
                              method="POST" 
                              enctype="multipart/form-data">
                            @csrf
                          

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="font-weight-bold">Subject Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                            </div>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $subject->name ?? '') }}" 
                                                   placeholder="Enter subject name"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shore_code" class="font-weight-bold">Shore Code</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-code"></i></span>
                                            </div>
                                            <input type="text" 
                                                   class="form-control @error('shore_code') is-invalid @enderror" 
                                                   id="shore_code" 
                                                   name="shore_code" 
                                                   value="{{ old('shore_code', $subject->shore_code ?? '') }}" 
                                                   placeholder="Enter shore code"
                                                   required>
                                            @error('shore_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="font-weight-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Provide a brief description of the subject"
                                          required>{{ old('description', $subject->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="grade" class="font-weight-bold">Grade Level</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                            </div>
                                            <input type="number" 
                                                   class="form-control @error('grade') is-invalid @enderror" 
                                                   id="grade" 
                                                   name="grade" 
                                                   value="{{ old('grade', $subject->grade ?? '') }}" 
                                                   placeholder="Enter grade level"
                                                   min="1" 
                                                   max="12">
                                            @error('grade')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image" class="font-weight-bold">Subject Image</label>
                                        <div class="custom-file">
                                            <input type="file" 
                                                   class="custom-file-input @error('image') is-invalid @enderror" 
                                                   id="image" 
                                                   name="image" 
                                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/svg">
                                            <label class="custom-file-label" for="image">
                                                {{ isset($subject) && $subject->image ? 'Change image' : 'Choose image' }}
                                            </label>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if(isset($subject) && $subject->image)
                                            <small class="text-muted">Current image: {{ $subject->image }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-right mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save mr-2"></i>
                                    {{ isset($subject) ? 'Update Subject' : 'Create Subject' }}
                                </button>
                                <a href="{{ route('staff.subjects.all') }}" class="btn btn-outline-secondary btn-lg ml-2">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Custom file input label
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
    @endpush
@endsection
