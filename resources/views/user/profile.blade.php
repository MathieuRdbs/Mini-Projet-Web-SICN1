<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    
</head>
<body>


    <div class="form-container">
    <h1 class="text-center mb-4">Your Profile</h1>

    <div class="text-center mb-3">
        <a href="{{ route('homepage') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Retour à l'accueil
        </a>
    </div>
        
        <div class="profile-form bg-white p-4 rounded-3 shadow-sm" style="max-width: 700px; margin: 0 auto;">
            <form method="POST" action="{{route('user.update')}}" id="profileForm">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="fullname" 
                               value="{{ $user->fullname }}" readonly>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ $user->email }}" readonly>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label for="phonenumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phonenumber" 
                               value="{{ $user->phonenumber}}" readonly>
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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>

        // Script pour le navbar fixed
        document.addEventListener("DOMContentLoaded", function() {
        let navbarHeight = document.querySelector("header").offsetHeight;
        document.body.style.paddingTop = (navbarHeight) + "px";
        });

        //Script pour le formulaire de modification de profile
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
</body>
</html>