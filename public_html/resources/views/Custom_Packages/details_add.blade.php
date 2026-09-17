@extends('layouts.userapp')

@section('content')
    <!-- Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Checkout</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item" style="color: #fff">Complete Order</li>
                        <li class="breadcrumb-item">Billing Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner Section ======================-->

    <section class="custom-package-complete">
        <div class="container">
            <div class="row">
                <div class="col-md-8 billing-details-wrap">
                    <form action="{{ route('custom.package.complate.store') }}" method="POST" enctype="multipart/form-data" id="order-form">
                        @csrf
                        <div class="col-md-12 billing-item">
                            <label class="label-name" for="customer_name_txt">Name&#42;</label>
                            <input type="text" name="customer_name_txt" id="customer_name_txt" class="form-control" value="{{ auth()->user()->name ?? '' }}">
                            @error('customer_name_txt')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 billing-item">
                            <label class="label-name" for="mobile_no_txt">Mobile No&#42;</label>
                            <input type="text" name="mobile_no_txt" id="mobile_no_txt" class="form-control" value="{{ auth()->user()->phone_number ?? '' }}">
                            @error('mobile_no_txt')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 billing-item">
                            <label class="label-name" for="location_txt">Location&#42;</label>
                            <input type="text" name="location_txt" id="location_txt" class="form-control" value="{{ auth()->user()->address ?? '' }}">
                            @error('location_txt')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 billing-item">
                            <label class="label-name" for="category_txt">Category&#42;</label>
                            <select name="category_txt" id="category_txt"  class="form-control">
                                <option value="">Select Category</option>
                                <option value="Wedding">Wedding</option>
                                <option value="Private Party">Private Party</option>
                                <option value="Corporate Event">Corporate Event</option>
                                <option value="Beach Party">Beach Party</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('category_txt')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 billing-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="label-name" for="StartDatetime">Start Date Time&#42;</label>
                                    <input type="date" name="StartDatetime" id="StartDatetime"  class="form-control">
                                    @error('StartDatetime')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="label-name" for="EndDatetime_txt">End Date Time&#42;</label>
                                    <input type="date" name="EndDatetime" id="EndDatetime_txt"  class="form-control">
                                    @error('EndDatetime')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 billing-item">
                            <label class="label-name" for="details_txt">Order Notes</label>
                            <textarea name="details_txt" id="details_txt" cols="30" rows="10"  class="form-control"></textarea>
                            @error('details_txt')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="col-md-4 order-place-details">
                    <h6 class="order-title">Your Order</h6>
                    <hr>
                    <span>
                        Your personal data will be used to process
                        your order, support your experience
                        throughout this website, and for other
                        purposes described in our privacy policy.
                    </span>
                    <hr>
                    <span>
                        Custom Pricing Available. Please Place
                        Your Order with Your Details
                        and We'll Reach Out Soon to Provide a
                        Personalized Quotation.
                    </span>
                    <div class="top-design"></div>
                    <hr>
                    <div class="btn-wrap">
                        <button type="submit" class="btn btn-primary btn-custom" id="place-order-btn" >Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#place-order-btn').click(function(e) {

            e.preventDefault();
            let valid = true;

            // Clear previous errors
            $('p.text-danger').remove();

            // Name validation
            if ($('#customer_name_txt').val().trim() === '') {
                valid = false;
                $('#customer_name_txt').after('<p class="text-danger">Name is required.</p>');
            }

            // Location validation
            if ($('#location_txt').val().trim() === '') {
                valid = false;
                $('#location_txt').after('<p class="text-danger">Location is required.</p>');
            }

            // Category validation
            if ($('#category_txt').val() === '') {
                valid = false;
                $('#category_txt').after('<p class="text-danger">Please select a category.</p>');
            }

            // Start Date validation
            if ($('#StartDatetime').val().trim() === '') {
                valid = false;
                $('#StartDatetime').after('<p class="text-danger">Start Date is required.</p>');
            }

            // End Date validation
            if ($('#EndDatetime_txt').val().trim() === '') {
                valid = false;
                $('#EndDatetime_txt').after('<p class="text-danger">End Date is required.</p>');
            }

            // Submit the form if valid
            if (valid === true) {
                $('#order-form').submit();
            }
        });
    });
</script>
@endsection
