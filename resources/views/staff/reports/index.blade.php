@extends('staff.base')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">School Reports</h1>
    
    <!-- Schools List -->
    <div class="row mt-4">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-school me-1"></i>
                    All Schools
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>School Name</th>
                                    <th>City</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schools as $school)
                                <tr>
                                    <td>{{ $school->name }}</td>
                                    <td>{{ $school->city }}</td>
                                    <td>{{ $school->type }}</td>
                                    <td>
                                        <a href="{{ route('staff.schooldetail', $school->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schools by City -->
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-city me-1"></i>
                    Schools by City
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>City</th>
                                    <th>Number of Schools</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schoolsByCity as $cityData)
                                <tr>
                                    <td>{{ $cityData->city }}</td>
                                    <td>{{ $cityData->total }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
