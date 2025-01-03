@extends('staff.base')
@section('content')
<div id="layoutSidenav_content">
    <main class="p-4">
        <div class="container-fluid px-4">
            <h1 class="mt-4">Users</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb">
                    <a href="">All Users</a>
                </li>
            </ol>
        </div>
        <div class="d-flex justify-content-between">

            <form action="#" method="GET" class="d-flex">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="row mt-4">
            @foreach ($users as $user)
            <div class="col-md-4 col-lg-4 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        @if ($user->profile == null)

                            <img src="https://avatar.iran.liara.run/public/50" class="rounded-circle img-fluid mb-3"
                                alt="User Photo" style="width: 100px; height: 100px;">

                        @else
                        <img src="{{ asset('storage/' . $user->profile) }}" class="rounded-circle img-fluid mb-3"
                            alt="User Photo" style="width: 100px; height: 100px;">
                            @endif

                       <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text"><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                        <p class="card-text"><i class="fas fa-phone"></i> {{ $user->phone }}</p>
                        <div class="d-flex justify-content-center mt-3">
                            <a href="{{ route('staff.editUser',$id = $user->id)}}" class="btn btn-primary btn-sm mx-1">
                                <i class="fas fa-info-circle"></i> Details
                            </a>
                            <a href="#" class="btn btn-danger btn-sm mx-1" onclick="confirmDelete({{ $user->id }})">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </main>
</div>
@endsection
