@extends('staff.base')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Subjects</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item ">Subject</li>
                    <li class="breadcrumb-item active">{{ $subject->shore_code }}</li>
                </ol>

                <div class="row mt-4">
                    <div class=" col-12 mb-4">
                        <div class="card h-100" style="height: 250px;">
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/' . $subject->image) }}" class="rounded-circle img-fluid mb-3"
                                    alt="School Logo" style="width: 100px; height: 100px;" />

                                <!-- Display Validation Errors -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('staff.subject.edit', $id = $subject->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label for="name" class="form-label">Subject</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name', $subject->name) }}" required>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="short_code" class="form-label">Short Code</label>
                                            <input type="text" class="form-control" id="short_code" name="short_code"
                                                value="{{ old('shore_code', $subject->shore_code) }}" required>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="name" class="form-label">Grade</label>
                                            <select name="grade" id="grade" class="form-control" required>
                                                <option value="9" {{ $subject->grade == 9 ? 'selected' : '' }}>Grade 9
                                                </option>
                                                <option value="10" {{ $subject->grade == 10 ? 'selected' : '' }}>Grade
                                                    10</option>
                                                <option value="11" {{ $subject->grade == 11 ? 'selected' : '' }}>Grade
                                                    11</option>
                                                <option value="12" {{ $subject->grade == 12 ? 'selected' : '' }}>Grade
                                                    12</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="image" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="image" name="image"
                                                value="{{ old('image', $subject->image) }}">
                                        </div>

                                        <div class="mb-3 col-12">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description"
                                                value="{{ old('description', $subject->description) }}"></textarea>
                                        </div>

                                    </div>
                                    <div class="d-flex mx-3 justify-content-between">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-danger">Clear</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="container-fluid px-4">

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                           Subject Lessons
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($lessons as $lesson )


                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$lesson->title}}</td>
                                        <td>{{$lesson->created_at}}</td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>
                                            <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </main>


    </div>
@endsection


@section('js')
@endsection
