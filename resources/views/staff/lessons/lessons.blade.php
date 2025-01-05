@extends('staff.base')
@section('content')
  
            <div class="container-fluid px-4">
                <h1 class="mt-4">Lessons</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb">All Lessons</li>
                </ol>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('staff.lessons.add')}}" id="add_subject" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Lesson</a>
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

                @foreach ($lessons as $lesson)
                    <div class="col-md-4 col-lg-4 col-12 mb-4">
                        <div class="card h-100" style="height: 250px;">
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/' . $lesson->image) }}" class="rounded-circle img-fluid mb-3"
                                    alt="School Logo" style="width: 100px; height: 100px;">

                                <h5 class="card-title">{{ $lesson->title }}</h5>
                                <p class="card-text"><i class="fas fa-book"></i> {{ $lesson->subject->name }}</p>
                                <div class="d-flex justify-content-center mt-3">
                                <a href="{{ route('staff.lessons.detail', $id = $lesson->id) }}"
                                        class="btn btn-primary btn-sm mx-1"><i class="fas fa-info-circle"></i> Details</a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
     
@endsection
