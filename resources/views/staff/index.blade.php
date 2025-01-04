@extends('staff.base')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                Students
                                <h2>{{ count($students) }}</h2>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Teachers
                                <h2>{{ count($teachers) }}</h2>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">School Manager
                                <h2>{{ count($school_managers) }}</h2>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Schools
                                <h2>{{ count($schools) }}</h2>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <!-- Area Chart -->
                    <div class="card mb-4 col-12">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            User Growth - Area Chart
                        </div>
                        <div class="card-body">
                            <canvas id="usersCanvas" width="100%" height="30"></canvas>
                        </div>
                    </div>
                </div>

                <div></div>
                <div class="container">
                    <!-- Line Chart -->
                    <div class="card mb-4 col-12">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-1"></i>
                            Schools Created Per Month - Line Chart
                        </div>
                        <div class="card-body">
                            <canvas id="schoolsLineChart" width="100%" height="30"></canvas>
                        </div>
                    </div>

                    <!-- Pie Chart -->
                    <div class="card mb-4 col-12">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i>
                            Users by Role - Pie Chart
                        </div>
                        <div class="card-body">
                            <canvas id="usersPieChart" width="100%" height="30"></canvas>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        DataTable Example
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>School</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>School</th>

                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->school ? $user->school->name : 'N/A' }}</td>

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
