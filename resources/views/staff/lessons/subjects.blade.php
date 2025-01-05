@extends('staff.base')
@section('content')
  
            <div class="container-fluid px-4">
                <h1 class="mt-4">Subjects</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb">All Subjects</li>
                </ol>
            </div>
            <div class="d-flex justify-content-between">
                <a type="button" id="add_subject" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Subject</a>
                <form action="#" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." aria-label="Search..."
                            aria-describedby="button-search">
                        <button class="btn btn-primary" type="button" id="button-search"><i
                                class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="row mt-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @foreach ($subjects as $subject)
                    <div class="col-md-4 col-lg-4 col-12 mb-4">
                        <div class="card h-100" style="height: 250px;">
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/' . $subject->image) }}" class="rounded-circle img-fluid mb-3"
                                    alt="School Logo" style="width: 100px; height: 100px;">

                                <h5 class="card-title">{{ $subject->name }}</h5>
                                <p class="card-text"><i class="fas fa-book"></i> {{ $subject->description }}</p>
                                <div class="d-flex justify-content-center mt-3">
                                    <a href="{{ route('staff.subjectdetail', $id = $subject->id) }}"
                                        class="btn btn-primary btn-sm mx-1"><i class="fas fa-info-circle"></i> Details</a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
      
@endsection
@section('js')
    <script>
        document.getElementById('add_subject').addEventListener('click', function() {
            Swal.fire({
                subject: 'Add New Subject',
                html: `<form id="add_subject_form" method="POST" action="{{ route('staff.subjects.add') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Subject Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                     <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label for="short_code">Short Code</label>
                            <input type="text" class="form-control" id="short_code" name="short_code" required>
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label for="grade">Grade</label>
                            <select class="form-control" id="grade" name="grade" required>
                                <option value="9">Grade 9</option>
                                <option value="10">Grade 10</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
 <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" ></textarea>
                    </div>
<div class="d-flex justify-content-center mt-3 mx-3">
    <button type="submit" class="btn btn-primary text-white">Save</button>
    <button type="reset" class="btn btn-danger mx-2 text-white">Reset</button>
</div>
</form>`,
                showCancelButton: false,
                showConfirmButton: false,
            })
        });
    </script>
@endsection
