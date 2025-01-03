@extends('staff.base')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4 ">Update User</h1>
                <ol class="breadcrumb mb-4 ">
                    <li class="breadcrumb-item"><a href="">All Users</a></li>
                    <li class="breadcrumb-item active">Update User</li>
                </ol>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <div class="col-md-8 col-lg-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Update User Information</h3>
                        </div>
                        <div class="card-body">
                            <form id="managerForm" method="POST" action="{{ route('staff.editUser', $id=$user->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" id="first_name" name="first_name" class="form-control"
                                            placeholder="Enter first name" value="{{ $user->first_name }}" required>
                                        @error('first_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control"
                                            placeholder="Enter last name" value="{{ $user->last_name }}" required>
                                        @error('last_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Enter email" value="{{ $user->email }}" required>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            placeholder="09..." value="{{ $user->phone }}" required>
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label for="school" class="form-label">School</label>
                                        <select name="school" id="school" class="form-control" required>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}"
                                                    {{ $school->id == $user->school_id ? 'selected' : '' }}>
                                                    {{ $school->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('school')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label for="role" class="form-label">Role</label>
                                        <select name="role" id="role" class="form-control" required>
                                            <option value="">Select Role</option>
                                            <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff
                                            </option>
                                            <option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Teacher
                                            </option>
                                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>
                                                Student</option>
                                            <option value="school_manager"
                                                {{ $user->role == 'school_manager' ? 'selected' : '' }}>School Manager
                                            </option>
                                        </select>
                                        @error('role')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary">Update User</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
