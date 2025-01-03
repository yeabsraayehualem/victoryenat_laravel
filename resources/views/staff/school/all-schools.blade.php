@extends('staff.base')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Schools</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">All Schools</li>
                </ol>
                <div class="d-flex justify-content-between">
                    <a type="button" id="add_school" class="btn btn-primary"><i class="fas fa-plus"></i> Add New School</a>
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
                    @foreach ($schools as $school)


                        <div class="col-md-4 col-lg-4 col-12 mb-4">
                            <div class="card h-100" style="height: 250px;">
                                <div class="card-body text-center">
                                    <img src="{{ asset('storage/' . $school->logo) }}"
                                        class="rounded-circle img-fluid mb-3" alt="School Logo" style="width: 100px; height: 100px;">
                                    <h5 class="card-title">{{$school->name}}</h5>

                                    <p class="card-text"><i class="fas fa-map-marker-alt"></i> {{$school->address}}</p>
                                    <div class="d-flex justify-content-between">
                                        <p class="m-2"><i class="fas fa-envelope"></i> {{$school->email}}</p>
                                        <p class="m-2"><i class="fas fa-phone"></i> {{$school->phone}}</p>

                                    </div>

                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="{{route('staff.schooldetail', $id=$school->id)}}" class="btn btn-primary btn-sm mx-1"><i
                                                class="fas fa-info-circle"></i> Details</a>

                                    <a href="#" class="btn btn-danger btn-sm mx-1" onclick="confirmDelete({{ $school->id }})"><i class="fas fa-trash-alt"></i> Delete</a>


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

document.getElementById('add_school').addEventListener('click', function () {
    Swal.fire({
        title: 'School Registration Form',
        html: `
        <form method="post" action="{{route('staff.addSchool')}}" id="add_school_form" enctype="multipart/form-data">
    @csrf
    <div class="row">
    <div class="mb-3 col-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3 col-6">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="mb-3 col-6">
        <label for="email" class="form-label"> Email</label>
        <input type="text" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3 col-6">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="mb-3 col-6">
        <label for="website" class="form-label">Website</label>
        <input type="text" class="form-control" id="website" name="website" required>
    </div>
    <div class="mb-3 col-6">
        <label for="logo" class="form-label">Logo</label>
<input type="file" class="form-control" id="logo" name="logo" required>
    </div>
    </div>
    <div class="d-flex mx-3 justify-content-between">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Clear</button>
        </div>
</form>
        `,
        showConfirmButton: false,
        focusConfirm: false,
        preConfirm: () => {
            const form = Swal.getPopup().querySelector('#add_school_form');
            return fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: new FormData(form),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Submission failed');
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(error.message);
                });
        },
    });
});

    </script>
    <script>
        function confirmDelete(schoolId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/staff/schools/delete/${schoolId}`;
                }
            });
        }
        </script>
@endsection
