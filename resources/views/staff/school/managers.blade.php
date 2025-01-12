@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">School Managers</h1>
            <p class="text-muted small mb-0">Manage and monitor all school managers in the system</p>
        </div>
        <button type="button" id="add_manager" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Manager
        </button>
    </div>

    <!-- Stats Overview -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="fas fa-user-tie fa-2x text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Total Managers</h6>
                            <h2 class="mb-0">{{ $totalManagers ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success bg-opacity-10">
                            <i class="fas fa-user-check fa-2x text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Active Managers</h6>
                            <h2 class="mb-0">{{ $activeManagers ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info bg-opacity-10">
                            <i class="fas fa-school fa-2x text-info"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Schools Managed</h6>
                            <h2 class="mb-0">{{ $schoolsManaged ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning bg-opacity-10">
                            <i class="fas fa-chart-pie fa-2x text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Performance</h6>
                            <h2 class="mb-0">{{ $averagePerformance ?? 0 }}%</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('staff.managers.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Search managers..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="school">
                        <option value="">All Schools</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ request('school') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Managers List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 ps-4">Manager</th>
                            <th class="border-0">School</th>
                            <th class="border-0">Contact</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Performance</th>
                            <th class="border-0 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($managers as $manager)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-wrapper me-3">
                                        @if($manager->avatar)
                                            <img src="{{ asset('storage/'.$manager->avatar) }}" 
                                                 class="rounded-circle" width="40" height="40"
                                                 alt="{{ $manager->name }}">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ substr($manager->name, 0, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $manager->name }}</h6>
                                        <small class="text-muted">{{ $manager->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $manager->school->name ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span>{{ $manager->phone }}</span>
                                    <small class="text-muted">{{ $manager->address }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $manager->status == 'active' ? 'success' : 'warning' }}-subtle text-{{ $manager->status == 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($manager->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 5px;">
                                        <div class="progress-bar bg-success" 
                                             style="width: {{ $manager->performance }}%"></div>
                                    </div>
                                    <span class="text-muted small">{{ $manager->performance }}%</span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary view-details" 
                                            data-id="{{ $manager->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info edit-manager" 
                                            data-id="{{ $manager->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-manager" 
                                            data-id="{{ $manager->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                                    <h5>No Managers Found</h5>
                                    <p class="text-muted">Start by adding your first manager</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-4">
        {{ $managers->links() }}
    </div>
</div>

@endsection

@section('css')
<style>
    .stat-card {
        transition: transform 0.2s;
        border-radius: 15px;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .avatar-wrapper {
        position: relative;
        width: 40px;
        height: 40px;
    }
    .avatar-placeholder {
        width: 40px;
        height: 40px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #6c757d;
        text-transform: uppercase;
    }
    .empty-state {
        padding: 2rem;
        text-align: center;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .progress {
        border-radius: 10px;
    }
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    .badge {
        padding: 0.5em 0.75em;
    }
</style>
@endsection