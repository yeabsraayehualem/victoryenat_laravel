@extends('staff.base')
@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Schools</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">All Managers</li>
            </ol>
            <div class="d-flex justify-content-between">
                <button id="add_manager" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Manager
                </button>
                <form action="#" method="GET" class="d-flex">
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="row mt-4">
                @foreach ($users as $manager)
                <div class="col-md-4 col-lg-4 col-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <img src="{{ asset('storage/' . $manager->profile) }}" class="rounded-circle img-fluid mb-3"
                                alt="Manager Photo" style="width: 100px; height: 100px;">
                            <h5 class="card-title">{{ $manager->name }}</h5>
                            <p class="card-text"><i class="fas fa-building"></i> {{ $manager->school }}</p>
                            <p class="card-text"><i class="fas fa-envelope"></i> {{ $manager->email }}</p>
                            <p class="card-text"><i class="fas fa-phone"></i> {{ $manager->phone }}</p>
                            <div class="d-flex justify-content-center mt-3">
                                <a href="#" class="btn btn-primary btn-sm mx-1">
                                    <i class="fas fa-info-circle"></i> Details
                                </a>
                                <a href="#" class="btn btn-danger btn-sm mx-1" onclick="confirmDelete({{ $manager->id }})">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
@endsection

@section('js')
<script>
    document.getElementById('add_manager').addEventListener('click', function () {
        Swal.fire({
            title: 'Add New Manager',
            html: `
                <form id="managerForm" method="POST" action="{{ route('staff.addManager') }}">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter first name" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter last name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="09..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label for="school" class="form-label">School</label>
                            <select name="school" id="school" class="form-control" required>
                                <option value="">Select School</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                        </div>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Submit',
            focusConfirm: false,
            preConfirm: () => {
                const form = Swal.getPopup().querySelector('#managerForm');
                if (!form.checkValidity()) {
                    Swal.showValidationMessage('Please fill out the form correctly.');
                    return false;
                }
                form.submit();
            }
        });
    });
</script>
@endsection
