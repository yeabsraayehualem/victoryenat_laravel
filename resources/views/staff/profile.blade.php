@extends('staff.base')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Staff Profile</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user me-1"></i>
            Profile Information
        </div>
        <div class="card-body">
            <form action="{{ route('staff.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <div class="profile-image-container position-relative d-inline-block">
                            <img id="profile-preview" 
                                 src="{{ auth()->user()->profile ? asset('storage/' . auth()->user()->profile) : asset('default-avatar.png') }}" 
                                 alt="Profile Picture" 
                                 class="rounded-circle img-fluid" 
                                 style="width: 200px; height: 200px; object-fit: cover;">
                            <label for="profile" class="profile-image-overlay position-absolute bottom-0 end-0 mb-2 me-2 btn btn-primary btn-sm">
                                <i class="fas fa-camera"></i>
                                <input type="file" 
                                       name="profile" 
                                       id="profile" 
                                       accept="image/*" 
                                       class="d-none"
                                       onchange="previewImage(event)">
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                       value="{{ auth()->user()->first_name }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                       value="{{ auth()->user()->last_name }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ auth()->user()->email }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="{{ auth()->user()->phone }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="school" class="form-label">School</label>
                                <input type="text" class="form-control" id="school" name="school" 
                                       value="{{ auth()->user()->school->name }}" readonly>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Current Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" {{ auth()->user()->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ auth()->user()->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <i class="fas fa-lock me-1"></i>
                        Change Password
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Leave blank if no change">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('profile-preview');
            preview.src = e.target.result;
        }
        
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const firstName = document.getElementById('first_name');
            const lastName = document.getElementById('last_name');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            
            if (!firstName.value.trim()) {
                e.preventDefault();
                toastr.error('First Name is required');
                firstName.focus();
                return;
            }
            
            if (!lastName.value.trim()) {
                e.preventDefault();
                toastr.error('Last Name is required');
                lastName.focus();
                return;
            }
            
            if (!email.value.trim() || !email.value.includes('@')) {
                e.preventDefault();
                toastr.error('Please enter a valid email address');
                email.focus();
                return;
            }
            
            // Password validation
            if (password.value.trim() !== '') {
                if (password.value.length < 6) {
                    e.preventDefault();
                    toastr.error('Password must be at least 6 characters long');
                    password.focus();
                    return;
                }
                
                if (password.value !== passwordConfirmation.value) {
                    e.preventDefault();
                    toastr.error('Password and Confirmation do not match');
                    passwordConfirmation.focus();
                    return;
                }
            }
        });
    });
</script>
@endpush