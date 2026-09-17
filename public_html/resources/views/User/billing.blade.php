@extends('layouts.userapp')

@section('content')
    <!-- Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Checkout</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item" style="color: #fff">Billing Details</li>
                        <li class="breadcrumb-item">payments</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner Section ======================-->
    <div id="nic-alert" class="alert alert-warning" style="display: none; margin: 20px; padding: 15px; font-size: 16px;">
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="social-share-media form-wrapper-one p-4 shadow-sm rounded">
                <h4 class="text-primary">Billing History</h4><br><br>
                <div class="mb-3">
                    {{-- store the category names and quantities here --}}
                    <input type="hidden" id="categoryNames" name="categoryNames" value="{{ json_encode($categoryNames) }}">

                    <input type="hidden" id="seats" name="seats" value="{{ json_encode($seats) }}">

                    <input type="hidden" id="quantityValues" name="quantityValues"
                        value="{{ json_encode($quantityValues) }}">

                    {{-- Iterate over the category names and quantities  --}}
                    @foreach ($categoryNames as $categoryId => $categoryName)
                        <h6>{{ $categoryName }}:{{ $quantityValues[$categoryId] ?? 'N/A' }}</h6>
                    @endforeach
                </div> <br></br>
                <h4 id="total-display" class="bg-dark p-2 rounded text-light w-75">Total: LKR {{ $total }}</h4>
                <input type="hidden" id="total" name="total" value="{{ $total }}">
                <input type="hidden" id="couponId" name="couponId" value="">
                <input type="hidden" id="couponDiscount" name="couponDiscount" value="0">
            </div>

            {{-- coupon box --}}
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="social-share-media form-wrapper-one p-6 shadow-sm rounded">
                    <h4 class="text-primary">Enter Coupon Code</h4><br><br>
                    <div class="mb-6">
                        <input type="text" id="couponCode" name="couponCode" class="form-control"
                            placeholder="Enter your coupon code">
                    </div>

                </div>
                <br>
                <button id="applyCouponBtn" class="btn btn-medium btn-primary" type="submit">Apply
                    Coupon</button><br><br>
                {{-- Display coupon message --}}
                <span id="couponMessage" name="couponMessage" class="bg-dark  rounded text-light "></span>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 ">
            <div class="form-wrapper-one p-4 shadow-sm rounded">
                <h4 class="text-primary">Billing Details</h4>
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name *</label>
                    <input type="text" id="firstName" name="firstName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name *</label>
                    <input type="text" id="lastName" name="lastName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nicNumber" class="form-label">NIC Number *</label>
                    <input name="nicNumber" id="nicNumber" type="text" placeholder="" class="form-control"
                        value="{{ old('nicNumber') }}" required>
                </div>
                <div class="mb-3">
                    <label for="phone_no" class="form-label">Phone Number *</label>
                    <input name="phone_no" id="phone_no" type="number" placeholder="" class="form-control" required
                        value="{{ auth()->user()?->phone_number }}">

                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ Auth::user()?->email }}" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address *</label>
                    <input type="text" value="{{ Auth::user()?->address }}" id="address" name="address"
                        class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City *</label>
                    <input type="text" value="{{ Auth::user()?->city }}" id="city" name="city"
                        class="form-control"required>
                </div>
                <div class="mb-3">
                    <label for="postalCode" class="form-label">Postal/ZIP Code *</label>
                    <input type="text" value="{{ Auth::user()?->postal_code }}" id="postalCode" name="postalCode"
                        class="form-control" required>
                </div>
                <div class="mb-5 rn-check-box">
                    <input type="checkbox" class="rn-check-box-input" id="exampleCheck1" name="exampleCheck1" required>
                    <label class="rn-check-box-label" for="exampleCheck1">I accept Terms & Conditions</label><br>
                </div>
                {{-- <button class="btn btn-medium btn-primary" type="submit">Checkout</button> --}}



                <button type="submit" class="btn btn-medium btn-primary" id="payhere-payment">Checkout</button>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    {{-- payhere .js --}}
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>


    {{-- payhere script --}}
    <script>
        function validateSriLankanNIC(nic) {
            // Remove spaces
            nic = nic.trim();

            const oldNICPattern = /^[0-9]{9}[vVxX]$/;
            const newNICPattern = /^[0-9]{12}$/;

            if (oldNICPattern.test(nic)) {
                return true; // Valid old NIC
            }

            if (newNICPattern.test(nic)) {
                const year = parseInt(nic.substring(0, 4), 10);
                // Optional: check year range (e.g., 1900 - current year)
                const currentYear = new Date().getFullYear();
                return year >= 1900 && year <= currentYear;
            }

            return false; // Doesn't match either pattern
        }


        function showCustomAlert(message, type = 'warning', duration = 3000) {
            const alertBox = document.getElementById('nic-alert');
            alertBox.innerText = message;
            alertBox.className = `alert alert-${type}`;
            alertBox.style.display = 'block';

            // if (duration > 0) {
            //     setTimeout(() => {
            //         alertBox.style.display = 'none';
            //     }, duration);
            // }
        }

        payhere.onCompleted = function onCompleted(orderId) {

            fetch('/user/pay/token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const token = data["access_token"];


                    fetch('/user/pay/payment-details?order_id=' + orderId, {
                            method: 'GET',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Payment Details:', data);


                            // TODO : validate Payment details

                            window.location.href = '/user/profile';

                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });


                })
                .catch(error => {
                    console.error('Error:', error);
                });




        };

        payhere.onDismissed = function onDismissed() {
            console.log("dissmissed");
        };

        payhere.onError = function onError(error) {
            showCustomAlert(error);
            console.log("Error:" + error);
        };





        document.getElementById('payhere-payment').onclick = function(e) {



            const firstName = document.getElementById("firstName").value;
            const lastName = document.getElementById("lastName").value;
            const email = document.getElementById("email").value;
            const phone = document.getElementById("phone_no").value;
            const address = document.getElementById("address").value;
            const city = document.getElementById("city").value;
            const accept = document.getElementById("exampleCheck1").checked;
            const couponDiscount = document.getElementById("couponDiscount").value;
            const couponCode = document.getElementById("couponCode").value;


            const postalCode = document.getElementById("postalCode").value;
            const nic = document.getElementById("nicNumber").value;





            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const mobilerRegex = /^(?:\+94|94|0)?7[01245678]\d{7}$/;



            if (firstName.trim() == "") {
                showCustomAlert("Enter First Name");
            } else if (lastName.trim() == "") {
                showCustomAlert("Enter Last Name");

            } else if (nic.trim() == "") {
                showCustomAlert("Enter NIC");

            } else if (!validateSriLankanNIC(nic)) {
                showCustomAlert("Invalid NIC");

            } else if (phone.trim() == "") {
                showCustomAlert("Enter Phone Number");

            } else if (!mobilerRegex.test(phone)) {
                showCustomAlert("Invalid Phone Number");

            } else if (email.trim() == "") {
                showCustomAlert("Enter Email Address");

            } else if (!emailRegex.test(email)) {
                showCustomAlert("Invalid Emial Address");

            } else if (address.trim() == "") {
                showCustomAlert("Enter Address");

            } else if (city.trim() == "") {
                showCustomAlert("Enter City");

            } else if (postalCode.trim() == "") {
                showCustomAlert("Enter PostalCode");

            } else if (!accept) {
                showCustomAlert("Accept Terms and Conditions");
            } else {



                const categoryNames = JSON.parse(document.getElementById("categoryNames").value);
                const quantityValues = JSON.parse(document.getElementById("quantityValues").value);

                const seats = JSON.parse(document.getElementById("seats").value);

                

                const trimmedCategoryNames = Object.fromEntries(
                    Object.entries(categoryNames).map(([key, value]) => [
                        key,
                        typeof value === 'string' ? value.trim() : value
                    ])
                );

                const trimmedquantityValues = Object.fromEntries(
                    Object.entries(quantityValues).map(([key, value]) => [
                        key,
                        typeof value === 'string' ? value.trim() : value
                    ])
                );


                const cuponId = document.getElementById("couponId").value;



                $.ajax({
                    url: '{{ route('user.process') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        categoryNames: JSON.stringify(trimmedCategoryNames),
                        quantityValues: JSON.stringify(trimmedquantityValues),
                        cuponId: cuponId,
                        seats:JSON.stringify(seats)
                    },
                    success: function(response) {
                        console.log('Data successfully sent to backend:', response);



                        const custom_1 = {};

                        custom_1.postal_code = postalCode;
                        custom_1.nic = nic;
                        custom_1.firstname = firstName;
                        custom_1.lastName = lastName;
                        custom_1.email = email;
                        custom_1.phone_no = phone;
                        custom_1.address = address;
                        custom_1.city = city;
                        custom_1.catrgory_names = trimmedCategoryNames;
                        custom_1.quantity_values = trimmedquantityValues;
                        custom_1.coupon_id = cuponId;
                        custom_1.coupon_discount = couponDiscount;
                        custom_1.couponCode = couponCode;
                        custom_1.event_id = {{ $eid }}
                        custom_1.user_id = {{ auth()->user()?->id ?? 'null' }};
                        custom_1.seats=JSON.stringify(seats);

                        const payment = {
                            "sandbox": true,
                            "merchant_id": response.merchant_id,
                            "return_url": 'https://2c9f-112-135-187-2.ngrok-free.app/user/profile', // Important
                            "cancel_url": 'https://2c9f-112-135-187-2.ngrok-free.app/user/profile', // Important
                            "notify_url": response.notify_link,
                            "order_id": response.order_id,
                            "items": response.items,
                            "amount": response.total,
                            "currency": response.currency,
                            "hash": response.hash,
                            "first_name": firstName,
                            "last_name": lastName,
                            "email": email,
                            "phone": phone,
                            "address": address,
                            "city": city,
                            "country": "Sri Lanka",
                            "delivery_address": address,
                            "delivery_city": city,
                            "delivery_country": "Sri Lanka",
                            "custom_1": JSON.stringify(custom_1),
                            "custom_2": ''
                        };


                        payhere.startPayment(payment);

                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'An error occurred';

                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        } else if (xhr.responseText) {
                            errorMessage = xhr.responseText;
                        }

                        showCustomAlert(`Error: ${errorMessage}`);
                    }

                });





            }






        };
    </script>








    <script>
        // Add event listener to the phone number input
        document.getElementById('phone_no').addEventListener('input', function(e) {
            const phoneInput = e.target;
            const phonePattern = /^[0-9]{10}$/; // Adjust this pattern based on your phone number format

            if (phoneInput.value === '') {
                phoneInput.setCustomValidity('Phone number is required');
            } else if (phonePattern.test(phoneInput.value)) {
                phoneInput.setCustomValidity(''); // Clear any previous error message
            } else {
                phoneInput.setCustomValidity('Invalid phone number');
            }
        });




        /**
         * This script is responsible for handling the application of a coupon code.
         * It prevents the default form submission behavior, retrieves the coupon code
         * from the input field, makes an AJAX POST request to the server with the coupon code,
         * and displays an alert message based on the server's response.
         */

        $(document).ready(function() {

            // Hide the coupon message initially
            $('#couponMessage').hide();
            /**
             * Handle the application of a coupon code.
             *
             * This function prevents the default form submission behavior, retrieves the coupon code
             * from the input field, makes an AJAX POST request to the server with the coupon code,
             * and displays an alert message based on the server's response.
             */
            $('#applyCouponBtn').click(function(e) {

                e.preventDefault();
                var couponCode = $('#couponCode').val();

                // Make an AJAX POST request to the server with the coupon code
                $.ajax({

                    url: '{{ route('user.apply.coupon', [$eid]) }}',
                    type: 'POST',
                    data: {

                        // Include the CSRF token in the request
                        _token: '{{ csrf_token() }}',
                        // Include the coupon code in the request
                        couponCode: couponCode
                    },

                    success: function(response) {

                        // Check if the response is successful
                        if (response.success) {

                            // Get the coupon ID from the response
                            var coupon_id = response.coupon_id;
                            // Get the discount percentage from the response
                            var discountPercentage = response.discountPercentage;

                            // Set the coupon ID and discount percentage in the form
                            $('#couponId').val(coupon_id);

                            // Calculate the discount amount
                            var discount = (discountPercentage / 100) * $('#total').val();

                            // Set the discount amount in the form
                            $('#couponDiscount').val(discount);

                            // Disable the apply coupon button and input field
                            $('#applyCouponBtn').prop('disabled', true).css({
                                'background-color': 'orange',
                                'opacity': 0.6,
                                'border': 'none',
                            });
                            $('#couponCode').prop('disabled', true);

                            // Show the success message
                            $('#couponMessage').html(response.message).show();

                            // Update the total amount in the form
                            var total = $('#total').val();
                            var newTotal = total - discount;

                            $('#total').val(newTotal);
                            $('#total-display').text('Total: LKR ' + newTotal);

                        } else {

                            // Show the error message
                            $('#couponMessage').html(response.message).show();

                            // Enable the apply coupon button and input field
                            $('#applyCouponBtn').prop('disabled', false);
                            $('#couponCode').prop('disabled', false);
                        }
                    },

                    error: function(xhr, status, error) {

                        // Log the error in the console
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
