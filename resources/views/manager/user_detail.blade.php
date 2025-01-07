@extends('manager.base')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                @if ($user->role == 'student')
                    Student Detail
                @else
                    Teacher Detail
                @endif
            </h1>
            @if (!$user->status == 'active')
                <a href="{{ route('manager.activateUser', $user->id) }}" class="btn btn-success">
                    Activate User
                </a>
            @endif
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" id="first_name" value="{{ $user->first_name }}" readonly>
            </div>
            <div class="col-md-6">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="last_name" value="{{ $user->first_name }}" readonly>
            </div>
            
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
            </div>
            <div class="col-md-6">
                @if ($user->role == 'student')
                    <label for="grade" class="form-label">Grade</label>
                    <input type="number" class="form-control" id="grade" value="{{ $user->grade }}" readonly>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" value="{{ $user->phone }}" readonly>
            </div>
            <div class="col-md-6">
                <label for="school" class="form-label">School</label>
                <input type="text" class="form-control" id="school" value="{{ $user->school->name }}" readonly>
            </div>
        </div>
        <div class="d-flex m-3 justify-content-end gap-2">
            <a href="{{ route('manager.students') }}" class="btn btn-danger">
                Back
            </a>
            @if ($user->status == 'active')
                <a href="{{ route('manager.activateStudent', $user->id) }}" class="btn btn-warning">
                    Deactivate
                </a>
            @else
            <a href="{{ route('manager.activateStudent', $user->id) }}" class="btn btn-success">
                Activate
            </a>
            @endif
        </div>

    </div>
@endsection
