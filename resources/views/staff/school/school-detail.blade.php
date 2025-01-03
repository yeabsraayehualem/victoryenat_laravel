@extends('staff.base')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Schools</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">All Schools</li>
                    <li class="breadcrumb-item active">{{ $school->name }}</li>
                </ol>

                <div class="row mt-4">
                    <div class=" col-12 mb-4">
                        <div class="card h-100" style="height: 250px;">
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/' . $school->logo) }}" class="rounded-circle img-fluid mb-3"
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

                                <form action="{{ route('staff.updateSchool', $id = $school->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $school->name) }}"
                                                required>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $school->address) }}"
                                                required>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="email" class="form-label"> Email</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $school->email) }}"
                                                required>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $school->phone) }}"
                                                required>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="website" class="form-label">Website</label>
                                            <input type="text" class="form-control" id="website" name="website" value="{{ old('website', $school->website) }}"
                                                required>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="logo" class="form-label">Logo</label>
                                            <input type="file" class="form-control" id="logo" name="logo" value="{{ old('logo', $school->logo) }}"
                                                >
                                        </div>
                                    </div>
                                    <div class="d-flex mx-3 justify-content-between">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-danger">Clear</button>
                                    </div>
                                </form>

                            </div>
                        </div>
        </main>
    </div>
@endsection


@section('js')
@endsection
