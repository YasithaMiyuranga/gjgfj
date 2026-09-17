@extends('layouts.userapp')

@section('content')

    <!--Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">User Profile</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!--Banner Section ======================-->

    <!--User Profile Section ======================-->
    <section class="profile pt-50 pt-lg-100 pt-xxl-150 pb-50 pb-lg-100 pb-xxl-120">
        <div class="container">
            <div class="col-lg-12">
                <div class="row gy-50 gy-lg-0 gx-80 justify-content-lg-between d-flex align-items-lg-center">
                    <div class="col-lg-3">
                        <div class="wow fadeInRight">
                            <div class="author-wrap">
                                <div class="author-inner">
                                    {{-- <div class="user-thumbnail">
                                        <img alt="" src="{{asset('/images/user-img.png')}}" width="100  ">
                                    </div> --}}
                                    <form method="POST" enctype="multipart/form-data" id="profile-picture-form">
                                        @csrf
                                        <div class="profile-pic">
                                            <label class="-label" for="file">
                                                <span class="glyphicon glyphicon-camera"></span>
                                                <span>Change Image</span>
                                            </label>
                                            <input id="file" type="file"
                                                onchange="loadFile(event); updateProfilePicture(this.files[0])" />
                                            <img alt="Profile Picture"
                                                src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('/images/user-img.png') }}"
                                                width="75" height="75" id="output">
                                        </div>
                                        <span class="text-danger"id="file-error"></span>
                                    </form>
                                    <div class="rn-author-info-content">
                                        <h3 class="title text-uppercase user-name">{{ Auth::user()->name }}</h3>
                                        <h6 class="title gmail">{{ Auth::user()->email }}</h6>
                                        {{-- <a href="mailto:{{ Auth::user()->email }}" class="social-follow"><i class="fas fa-envelope"></i></a>
                                        <a href="tel:{{ Auth::user()->phone_number }}" class="social-follow"><i class="fas fa-phone"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="widget-wrapper" style="top: 100px;">
                                    <nav class="left-nav">
                                        <div class="nav text-nowrap" role="tablist">
                                            <ul
                                                class="contact-lists d-flex flex-column gap-0 list-unstyled mb-0 mt-20 fs=6">
                                                <li class="mb-0">
                                                    <button class="nav-link active box-tab" id="nav-home-tab"
                                                        data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                                                        role="tab" aria-controls="nav-home" aria-selected="true"><i
                                                            class="fas fa-ticket-alt"></i> My Tickets</button>
                                                </li>
                                                <li class="mb-0">
                                                    <button
                                                        class="nav-link box-tab{{ session('tab') == 'nav-info' ? 'active' : '' }}"
                                                        id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info"
                                                        type="button" role="tab" aria-controls="nav-info"
                                                        aria-selected="false"><i class="fas fa-user"></i> Personal
                                                        Information</button>
                                                </li>
                                                <li class="mb-0">
                                                    <button
                                                        class="nav-link box-tab{{ session('tab') == 'nav-password' ? 'active' : '' }}"
                                                        id="nav-password-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-password" type="button" role="tab"
                                                        aria-controls="nav-password" aria-selected="false"><i
                                                            class="fas fa-unlock-alt"></i> Change Password</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="container">
                            <div class="row">
                                <div class="wow fadeInLeft">
                                    <div class="mt_sm-30">
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                                aria-labelledby="nav-home-tab">
                                                <div class="information">
                                                    {{-- <div class="text-start">
                                                        <h6 class="text-primary">My Tickets</h6>
                                                        <hr class="mt-4">
                                                        Total:{{$ticketsCount}} Ticket(s)
                                                    </div> --}}
                                                    <div class="">
                                                        <div class="section-title section-title-style-1">
                                                            <span
                                                                class="fs-4 straight-line-wrapper fw-semibold position-relative">
                                                                <span class="straight-line"></span>User Profile</span>
                                                            <h3
                                                                class="sub-title display-6 fw-extra-bold primary-text-shadow tab-title">
                                                                My Tickets</h3>
                                                        </div>
                                                        <!-- section-title -->
                                                    </div>
                                                </div>
                                                <div
                                                    class="tickets-wrap mt-3 g-3 d-flex flex-column custom-inner-bg timeline-wrapper">
                                                    @if (isset($userTickets) && $userTickets->count())
                                                        @foreach ($userTickets as $ticket)
                                                            <div style="height: fit-content !important"
                                                                class="ticket-container custom-inner-bg">


                                                                <!-- Ticket Section ====================== -->
                                                                <div class="ticket-section about-ticket">
                                                                    <div class="ticket-wrapper position-relative"
                                                                        style="position: relative; overflow: hidden;">

                                                                        <!-- Background image with dark overlay -->
                                                                        <div
                                                                            style="
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset($ticket->banner) }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            z-index: 0;">
                                                                            <div
                                                                                style="
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);">
                                                                            </div>
                                                                        </div>

                                                                        <!-- Foreground content -->
                                                                        <div class="p-3 ticket-inner d-flex align-items-center position-relative"
                                                                            style="z-index: 1; max-width: 100% !important;">
                                                                            <div class="ticket-qr me-3">
                                                                                <img src="{{ asset('storage/' . $ticket->qr_code) }}"
                                                                                    alt="QR Code"
                                                                                    class="img-fluid rounded qr-code-image"
                                                                                    style="width: 100px; aspect-ratio: 1;">
                                                                            </div>
                                                                            <div
                                                                                class="ticket-details flex-grow-1 text-white p-2">
                                                                                <h4 class="fw-bold mb-1">
                                                                                    {{ $ticket->event_name }}</h4>
                                                                                <h6 class="mb-1">
                                                                                    {{ $ticket->start_datetime }} -
                                                                                    {{ $ticket->end_datetime }}</h6>
                                                                                <div class="ticket-info">
                                                                                    <p class="mb-1">
                                                                                        <strong>Category :</strong>
                                                                                        {{ ucwords($ticket->tickets_category) }}
                                                                                    </p>
                                                                                    <p class="mb-1">
                                                                                        <strong>Price :</strong>
                                                                                        {{ number_format($ticket->price, 2) }}
                                                                                        {{ $ticket->currency }}
                                                                                    </p>
                                                                                    <p class="mb-1">
                                                                                        <strong>Seat :</strong>
                                                                                        {{ ucwords($ticket->tickets_category) }}
                                                                                        {{ $ticket->seat_number }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="ticket-qr p-2 rounded"
                                                                                style="background-color: white; height: 100%;">
                                                                                <img src="{{ asset('storage/' . $ticket->bar_code) }}"
                                                                                    alt="Bar Code"
                                                                                    class="img-fluid qr-code-image"
                                                                                    style="height: 150%;">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <!-- Ticket Section ====================== -->
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-muted overflow-hidden timeline-wrapper">No tickets
                                                            available at the moment.</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="tab-pane fade {{ session('tab') == 'nav-info' ? 'show active' : '' }}"
                                                id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                                                <!-- Personal Information content -->
                                                <div class="information">
                                                    {{-- <div class="text-start">
                                                    <h6 class="text-primary">Personal Information</h6>
                                                    <hr class="mt-4">
                                                </div> --}}
                                                    <div class="col-lg-12">
                                                        <div class="section-title section-title-style-1">
                                                            <span
                                                                class="fs-4 straight-line-wrapper fw-semibold position-relative">
                                                                <span class="straight-line"></span>User Profile</span>
                                                            <h3
                                                                class="sub-title display-6 fw-extra-bold primary-text-shadow tab-title">
                                                                Personal Information</h3>
                                                        </div>
                                                        <!-- section-title -->
                                                    </div>
                                                    <div class="contact-us-form">
                                                        <form action="{{ route('user.updatePersionalDetails') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @method('PUT')
                                                            @csrf
                                                            <div
                                                                class="form-wrapper-one shadow-sm rounded d-flex flex-column mt-20">
                                                                <div class="mb-2 mb-lg-3 col-lg-12">
                                                                    {{-- <label for="name" class="form-label">Name</label>
                                                                    <input type="name" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" required> --}}
                                                                    <input type="name" id="name"
                                                                        class="form-control" name="name"
                                                                        value="{{ Auth::user()->name }}"
                                                                        placeholder="Name*" required>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6 mb-lg-3 mb-2">
                                                                        {{-- <label for="email" class="form-label">Email</label>
                                                                        <input type="text" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly> --}}
                                                                        <input type="email" id="email"
                                                                            class="form-control" name="email"
                                                                            value="{{ Auth::user()->email }}"
                                                                            placeholder="Email*" readonly>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        {{-- <label for="phone_number" class="form-label">Phone Number</label>
                                                                        <input type="number" id="phone_number" name="phone_number" class="form-control" value="{{ Auth::user()->phone_number }}" placeholder="Name*" required> --}}
                                                                        <input type="number" id="phone_number"
                                                                            class="form-control" name="phone_number"
                                                                            value="{{ Auth::user()->phone_number }}"
                                                                            placeholder="Phone Number*" readonly>
                                                                    </div>
                                                                </div>





                                                                <div class="mb-2 mb-lg-3 col-lg-12">
                                                                    {{-- <label for="name" class="form-label">Name</label>
                                                                    <input type="name" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" required> --}}
                                                                    <input type="name" id="address"
                                                                        class="form-control" name="address"
                                                                        value="{{ Auth::user()->address }}"
                                                                        placeholder="Address" required>
                                                                </div>

                                                                <div class="row">

                                                                    <div class="col-lg-6">
                                                                        {{-- <label for="phone_number" class="form-label">Phone Number</label>
                                                                        <input type="number" id="phone_number" name="phone_number" class="form-control" value="{{ Auth::user()->phone_number }}" placeholder="Name*" required> --}}
                                                                        <input type="text" id="postalCode"
                                                                            class="form-control" name="postal_code"
                                                                            value="{{ Auth::user()->postal_code }}"
                                                                            placeholder="Postal Code" required>
                                                                    </div>

                                                                    <div class="col-lg-6 mb-lg-3 mb-2">
                                                                        {{-- <label for="email" class="form-label">Email</label>
                                                                        <input type="text" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly> --}}
                                                                        <input type="text" id="city"
                                                                            class="form-control" name="city"
                                                                            value="{{ Auth::user()->city }}"
                                                                            placeholder="City" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-gradient d-inline-flex mt-2"
                                                                type="submit">Save</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade {{ session('tab') == 'nav-password' ? 'show active' : '' }}"
                                                id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
                                                <!-- Change Password content -->
                                                <div class="information">
                                                    {{-- <div class="text-start">
                                                        <h6 class="text-primary">Create Your Password</h6>
                                                        <hr class="mt-4">
                                                    </div> --}}
                                                    <div class="col-lg-12">
                                                        <div class="section-title section-title-style-1">
                                                            <span
                                                                class="fs-4 straight-line-wrapper fw-semibold position-relative">
                                                                <span class="straight-line"></span>User Profile</span>
                                                            <h3
                                                                class="sub-title display-6 fw-extra-bold primary-text-shadow tab-title">
                                                                Change Password</h3>
                                                        </div>
                                                        <!-- section-title -->
                                                    </div>

                                                    @if (session('error'))
                                                        <div class="alert alert-danger mt-2">
                                                            {{ session('error') }}
                                                        </div>
                                                    @endif
                                                    <div class="contact-us-form">
                                                        <form id="changePasswordForm"
                                                            action="{{ route('user.updatePassword') }}" method="POST"
                                                            enctype="multipart/form-data">
                                                            @method('PUT')
                                                            @csrf
                                                            <div
                                                                class="form-wrapper-one shadow-sm rounded d-flex flex-column gap-2 mt-20">
                                                                <div class="col-lg-12">
                                                                    <div class="row d-flex gap-10 gap-lg-0">
                                                                        <div class="mb-lg-3 col-lg-6">
                                                                            {{-- <label for="emailForm2" class="form-label"> Email</label>
                                                                            <input type="text" id="emailForm2" name="emailForm2" class="form-control"  value="{{ Auth::user()->email }}" readonly> --}}
                                                                            <input type="text" class="form-control"
                                                                                id="emailForm2" name="emailForm2"
                                                                                value="{{ Auth::user()->email }}"
                                                                                placeholder="Email*" required="">
                                                                        </div>
                                                                        <div class="mb-lg-3 col-lg-6">
                                                                            {{-- <label for="OldPassword" class="form-label">Enter Your Old Password</label>
                                                                            <input type="password" id="OldPassword" name="OldPassword" class="form-control"  required> --}}
                                                                            <input type="password" id="OldPassword"
                                                                                class="form-control" name="OldPassword"
                                                                                placeholder="Enter Your Old Password*"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            {{-- <label for="NewPassword" class="form-label">Enter Your New Password</label>
                                                                            <input type="password" id="NewPassword" name="NewPassword" class="form-control"  required> --}}
                                                                            <input type="password" id="NewPassword"
                                                                                class="form-control" name="NewPassword"
                                                                                placeholder="Enter Your New Password*"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            {{-- <label for="confirmePassword" class="form-label">Confirme Your Password</label>
                                                                            <input type="password" id="confirmePassword" name="confirmePassword" class="form-control"  required> --}}
                                                                            <input type="password" id="confirmePassword"
                                                                                class="form-control"
                                                                                name="confirmePassword"
                                                                                placeholder="Confirme Your Password*"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button id="changePasswordBtn"
                                                                class="btn btn-gradient d-inline-flex mt-4
                                                            "
                                                                type="submit">Save</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center my-3">
                                                <a href="tel:{{ env('COMPANY_CONTACT') }}"
                                                    class="btn btn-primary btn-lg">
                                                    Contact Us
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Add event listener to the phone number input
        document.getElementById('phone_number').addEventListener('input', function(e) {
            const phoneInput = e.target;
            const phonePattern = /^[0-9]{10}$/;

            if (phoneInput.value === '') {
                phoneInput.setCustomValidity('Phone number is required');
            } else if (phonePattern.test(phoneInput.value)) {
                phoneInput.setCustomValidity(''); // Clear any previous error message
            } else {
                phoneInput.setCustomValidity('Invalid phone number');
            }
        });
        var loadFile = function(event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };
        var updateProfilePicture = function(file) {
            var formData = new FormData();
            formData.append('profile_picture', file);
            var userId = {{ Auth::user()->id }};
            // Send the form data to the backend using AJAX
            $.ajax({
                type: 'POST',
                url: 'update-profile-picture/' + userId,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.message) {
                        //  Remove error message
                        $('#file-error').text('');
                    } else {
                        var image = document.getElementById("output");
                        image.src =
                            "{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : asset('/images/user-img.png') }}";
                        // display an error message file-error
                        $('#file-error').text('Failed to update profile picture!');
                    }
                },
                error: function(error) {
                    // remove the uploaded file from the input field
                    $('#file-error').text('Failed to update profile picture!');
                }
            });
        };
    </script>
@endsection
