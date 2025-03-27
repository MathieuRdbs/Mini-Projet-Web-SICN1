@extends('layouts.admindash')
@section('title')
    Profile
@endsection

@section('main')
    <div class="form-container">
        <h1 class="page-title-c">Profile</h1>
        
        <div class="profile-form bg-white p-4 rounded-3 shadow-sm" style="max-width: 700px; margin: 0 auto;">
            <form method="POST" action="{{ route('updateprofile', $admin->id) }}" id="profileForm">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="fullname" 
                               value="{{ $admin->fullname }}" readonly>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ $admin->email }}" readonly>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label for="phonenumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phonenumber" 
                               value="{{ $admin->phonenumber}}" readonly>
                    </div>
                </div>

                <div id="passwordFields" class="col-10 mt-2" style="display: none;">
                    <hr>
                        <h5 class="mb-2">Change Password</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                    <hr>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="button" id="changePasswordBtn" class="btn btn-outline-primary">
                        <i class="fas fa-key me-1"></i> Change Password
                    </button>
                    
                    <div class="action-buttons d-flex gap-2">
                        <button type="button" id="editBtn" class="btn btn-primary px-4">
                            <i class="fas fa-edit me-2"></i> Edit Profile
                        </button>
                        <div class="edit-mode-buttons" style="display: none;">
                            <button type="submit" id="saveBtn" class="btn btn-success px-4 me-4">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                            <button type="button" id="cancelBtn" class="btn btn-danger px-4">
                                <i class="fas fa-times me-2"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('editBtn');
            const saveBtn = document.getElementById('saveBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const changePasswordBtn = document.getElementById('changePasswordBtn');
            const editModeButtons = document.querySelector('.edit-mode-buttons');
            const passwordFields = document.getElementById('passwordFields');
            const formInputs = document.querySelectorAll('#profileForm input:not([type="password"])');
            const passwordInputs = document.querySelectorAll('#profileForm input[type="password"]');
            const originalValues = {};
            
            formInputs.forEach(input => {
                originalValues[input.name] = input.value;
            });
            
            editBtn.addEventListener('click', function() {
                formInputs.forEach(input => {
                    input.readOnly = false;
                });
                editBtn.style.display = 'none';
                editModeButtons.style.display = 'flex';
            });
            
            cancelBtn.addEventListener('click', function() {
                formInputs.forEach(input => {
                    input.value = originalValues[input.name];
                    input.readOnly = true;
                });
                passwordFields.style.display = 'none';
                passwordInputs.forEach(input => input.value = '');
                changePasswordBtn.innerHTML = '<i class="fas fa-key me-1"></i> Change Password';
                changePasswordBtn.classList.remove('btn-outline-danger');
                changePasswordBtn.classList.add('btn-outline-primary');

                editBtn.style.display = 'block';
                editModeButtons.style.display = 'none';
            });
            
            changePasswordBtn.addEventListener('click', function() {
                if (passwordFields.style.display === 'none') {
                    passwordFields.style.display = 'block';
                    changePasswordBtn.innerHTML = '<i class="fas fa-times me-1"></i> Cancel Password Change';
                    changePasswordBtn.classList.remove('btn-outline-primary');
                    changePasswordBtn.classList.add('btn-outline-danger');
                } else {
                    passwordFields.style.display = 'none';
                    passwordInputs.forEach(input => input.value = '');
                    changePasswordBtn.innerHTML = '<i class="fas fa-key me-1"></i> Change Password';
                    changePasswordBtn.classList.remove('btn-outline-danger');
                    changePasswordBtn.classList.add('btn-outline-primary');
                }
            });
        });
    </script>
@endsection