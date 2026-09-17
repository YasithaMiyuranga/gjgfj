@extends('layouts.userapp')

@section('content')
    <!-- Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Cart</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="/cart">Cart View</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner Section ======================-->

    @if (session('cart_'.Auth::user()->id) && is_countable(session('cart_'.Auth::user()->id)) && count(session('cart_'.Auth::user()->id)) > 0)
        <div class="container cart my-50">
            <div class="row message-wrap">
                <div class="col-md-12 wrap-col">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 cart-details-wrap">                  
                    <!-- Desktop Design -->
                    <form action="{{ route('update-cart') }}" method="POST" enctype="multipart/form-data" class="qty-update-form-dsk">
                        @csrf
                        @foreach (session('cart_'.Auth::user()->id) as $id => $details)
                            <div class="item-details-wrap d-none d-md-flex">
                                <div class="img-wrap detail-col col-md-2">
                                    <img class="image" src="{{ $details['image'] }}" alt="">
                                </div>
                                @csrf
                                <div class="item-name-wrap detail-col col-md-4">
                                    <span class="item-name">{{ $details['name'] }}</span>
                                    <input class="prod-id-field" class="item-id" type="hidden" name="product_id[]"
                                    value="{{ $details['item_id'] }}">
                                </div>
                                <div class="price detail-col col-md-3">
                                    <span class="field-title">Price</span>
                                    <input class="price-field price-dsk" type="text" value="LKR: {{ $details['price'] }}" disabled>
                                </div>
                                <div class="quantity detail-col col-md-3">
                                    <span class="field-title">Qty</span>
                                    <div class="qty-wrap">
                                        <div class="quantity-decrease">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
                                            </svg>
                                        </div>
                                         <input class="quantity-field qty-dsk" type="text" inputmode="numeric" id="quantity_{{ $id }}" data-product-id="{{ $details['item_id'] }}"
                                            name="quantity[]" value="{{ $details['quantity'] }}" readonly>
                                        <div class="quantity-increase">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-custom btn-sub detail-col col-md-2">
                                    <img src="assets/images/cart/edit.svg" alt="Edit">
                                </button>
                                <div class="remove-icon col-2">
                                    <a href="{{ route('remove-from-cart', $details['item_id']) }}" class="btn btn-close"></a>
                                </div>
                            </div>
                        @endforeach
                    
                        </form>
    
                        <!-- Mobile Design -->
                        <form action="{{ route('update-cart') }}" method="POST" enctype="multipart/form-data" class="qty-update-form-mb">
                            @foreach (session('cart_'.Auth::user()->id) as $id => $details)
                                <div class="item-details-wrap-mb d-block d-md-none">
                                    <div class="img-with-name-wrap">
                                        <div class="img-wrap detail-col col-3">
                                            <img class="image" src="{{ $details['image'] }}" alt="">
                                        </div>
                                        @csrf
                                        <div class="item-name-wrap detail-col col-8">
                                            <span class="item-name">{{ $details['name'] }}</span>
                                            <input class="prod-id-field" class="item-id" type="hidden" name="product_id[]"
                                            value="{{ $details['item_id'] }}">
                                        </div>
                                    </div>
                                    <div class="price-qty-wrap">
                                        <div class="price detail-col col-6">
                                            <span class="field-title">Price</span>
                                            <input class="price-field price-mb" type="text" value="LKR: {{ $details['price'] }}"
                                                disabled>
                                        </div>
                                        <div class="quantity detail-col col-6">
                                            <span class="field-title">Qty</span>
                                            <div class="qty-wrap">
                                                <div class="quantity-decrease">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
                                                    </svg>
                                                </div>
                                                <input class="quantity-field qty-mb" type="text" id="quantity_{{ $id }}" data-product-id="{{ $details['item_id'] }}"
                                                    name="quantity[]" value="{{ $details['quantity'] }}" readonly>
                                                <div class="quantity-increase">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-custom btn-sub detail-col">
                                        <!-- <img src="assets/images/cart/edit.svg" alt="Editfddfdf"> -->
                                    </button>
                                    <div class="remove-icon">
                                        <a href="{{ route('remove-from-cart', $id) }}" class="btn btn-close"></a>
                                    </div>
                                </div>
                            @endforeach

                        </form>
                        <div class="update-cart">
                            <div class="text-right">
                                <button class="btn btn-primary btn-custom">Update Cart</button>
                            </div>
                        </div>
                   
                    <hr class="my-30">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center justify-content-md-start">
                            <div class="return-wrap">
                                <a href="/Custome-Events-Packages">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                        fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                                    </svg>
                                    Add More Items
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 sub-total-wrap">
                    <div class="detail-wrap">
                        <span class="title">Order Details</span>
                    </div>
                    <hr>
                    <div class="top-design d-none d-md-flex"></div>
                    <div class="sub-total">
                        <div class="sub-total-price">
                            <div class="sub-text">
                                <span>Total</span>
                            </div>
                            <div class="sub-price">
                                
                            </div>
                        </div>
                        <span>
                            Custom Pricing Available. Please Complete Your Order with Your Details
                            and We'll Reach Out Soon to Provide a Personalized Quotation.
                        </span>
                    </div>
                    <hr>
                    <div class="place-order">
                        <div class="text-center">
                            <a href="{{ route('custom.package.complate') }}" class="btn btn-primary btn-custom">Complete
                                Order</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container my-80">
            <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <h6>Your Cart is Empty!</h6>
                </div>
            </div>
        </div>
    @endif
    <!-- @if (session('cart') && count(session('cart')) > 0)
    <ul>
                    @foreach (session('cart') as $id => $details)
    <form action="{{ route('add-to-cart') }}" method="POST" enctype="multipart/form-data">
                        <img src="{{ $details['image'] }}" alt="">
                        @csrf
                        <input type="text" name="product_id" value="{{ $id }}">
                        <input type="number" id="quantity_{{ $id }}" name="quantity" value="{{ $details['quantity'] }}">
                        <button type="submit" class="btn btn-primary btn-lg">Change</button>
                        <a href="{{ route('remove-from-cart', $id) }}" class="btn btn-danger btn-lg">Remove</a>
                    </form>
                    {{-- Uncomment and modify this section as needed
        <h5>Name - {{ $details['name'] }}</h5>
        <li>
            <img src="{{ $details['image'] }}" alt="">
            {{ $details['name'] }} - Quantity: {{ $details['quantity'] }}
        </li>
        --}}
                    
                   {{--  <form action="{{ route('remove-from-cart') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $id }}">
            <button type="submit" class="btn btn-danger btn-lg">Remove</button>
        </form> --}}
    @endforeach
                </ul> -->
    <!-- <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <a href="{{ route('custom.package.complate') }}" class="btn btn-primary btn-lg">Complte Order</a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="text-center">
                            <a href="{{ route('custom.package') }}" class="btn btn-primary btn-lg">Add More Items</a>
                        </div>
                    </div>
                </div>

                </div>
@else
    <p>Your cart is empty.</p>
    @endif -->
@endsection
