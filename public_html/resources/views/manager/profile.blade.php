@extends('layouts.manager')
@section('page-title', __('Manager Profile'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Profile Update') }}</h3>
                    </div>
                    <div class="card-body">
                        <form id="ProfileForm" action="{{ Route('manager.man.updateprofile') }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                           <img src="{{ !empty(Auth::guard('manager')->user()->profile_image) ? asset(Auth::guard('manager')->user()->profile_image) : asset('assets/images/profile/Avatar.png') }}"
                                alt="Manager Image"
                                style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; margin-bottom: 20px;align: CENTER">
                            <div class="form-wrapper-one shadow-sm rounded">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Profile Image</label>
                                    <input type="file" name="image" class=" form-control"
                                        accept=".jpeg,.png,.jpg,.gif,.svg,.jfif">
                                </div>
                                <div class="mb-3">
                                    <label for="emailForm1" class="form-label">Email</label>
                                    <input type="text" id="emailForm1" name="email" class="form-control"
                                    value="{{ old('email', auth()->user()->email) }}" readonly>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="emailForm1" class="form-label">Phone Number</label>
                                    <input type="text" id="mobile" name="mobile" class="form-control"
                                        value="{{ old('mobile', auth()->user()->mobile) }}" old="mobile" >
                                    <span id="mobileError" class="text-danger" style="display: none;">Invalid Phone Number.</span>
                                    @if ($errors->has('mobile'))
                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" max="255"
                                        value="{{ old('name', auth()->user()->name) }}" readonly required>
                                    <span id="nameError" class="text-danger" style="display: none;">Name is required.</span>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                               
                                <button id="updateBtn" class="btn btn-medium btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-header">
                        <h3>{{ __('manager Password Change') }}</h3>
                    </div>
                    <div class="card-body">
                        <form id="changePasswordForm" action="{{ Route('manager.man.changepassword') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-wrapper-one shadow-sm rounded">
                                <div class="mb-3">
                                    <label for="emailForm2" class="form-label">Email</label>
                                    <input type="text" id="emailForm2" name="email" class="form-control"
                                        value="{{ auth()->user()->email }}" readonly>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="OldPassword" class="form-label">Enter Your Old Password</label>
                                    <input type="password" id="OldPassword" name="old_password" class="form-control" value="{{ old('old_password') }}"
                                        required>
                                    @if ($errors->has('old_password'))
                                        <span class="text-danger">{{ $errors->first('old_password') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="NewPassword" class="form-label">Enter Your New Password</label>
                                    <input type="password" id="NewPassword" name="new_password" class="form-control" value="{{ old('new_password') }}"
                                        required>
                                    @if ($errors->has('new_password'))
                                        <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="confirmePassword" class="form-label">Confirm Your Password</label>
                                    <input type="password" id="confirmePassword" name="confirm_password" value="{{ old('confirm_password') }}"
                                        class="form-control" required>
                                    @if ($errors->has('confirm_password'))
                                        <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                    @endif
                                </div>
                                <button id="changePasswordBtn" class="btn btn-medium btn-primary"
                                    type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#ProfileForm').submit(function(e) {
                // Call the validateForm function to check the form before submitting
                if (!validateForm()) {
                    e.preventDefault(); // Prevent form submission if validation fails
                }
            });

            function validateForm() {
                // Clear previous error messages
                document.getElementById("nameError").style.display = "none";
                document.getElementById("mobileError").style.display = "none";

                let isValid = true;

                // Name validation
                const name = document.getElementById("name").value;
                if (!name.trim()) {
                    document.getElementById("nameError").style.display = "inline";
                    isValid = false;
                }

               // Mobile validation (optional; checks only if a 10-digit number is entered)
                const mobile = document.getElementById("mobile").value;
                const mobilePattern = /^\d{10}$/;

                // Validate only if mobile is not empty
                if (mobile && !mobilePattern.test(mobile)) {
                    document.getElementById("mobileError").style.display = "inline";
                    isValid = false;
                }


                return isValid; // Form will only submit if isValid is true
            }
        });
    </script>
@endsection
