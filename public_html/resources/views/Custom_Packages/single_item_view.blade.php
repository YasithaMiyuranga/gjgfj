@extends('layouts.userapp')

@section('content')
    <!-- Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Item Details</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="/Packages">Single</a></li>
                        <li class="breadcrumb-item"><a href="/Custome-Events-Packages">Product</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $item->item_name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner Section ======================-->

    <section class="return-link pt-30">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center justify-content-md-end">
                    <div class="return-wrap">
                        <a href="/Custome-Events-Packages">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                                class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                            </svg>
                            Return to Previous Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-content-section package-detail item-detail py-30">
        <div class="container">
            <div class="blog-wrapper package-wrap">
                <div class="blog-content package-desc blog-content-2 custom-inner-bg p-4 mb-30 mb-lg-50">
                    <div class="row justify-content-between g-5 align-items-center">
                        <div class="col-lg-7">
                            <div class="blog-image">
                                <img class="main-img" src="{{ asset($item->image) }}" class="img-fluid"
                                    alt="{{ $item->item_name }}">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div
                                class="blog-left-content d-flex flex-wrap align-items-center justify-content-center package-title">
                                <h2 class="blog-link fs-4 fw-bold title">{{ $item->item_name }}</h2>
                            </div>
                            <div class="d-flex flex-wrap align-items-center justify-content-center">
                                <div class="price-wrap">
                                    <div class="price-title">
                                        <span class="price">LKR: {{ $item->rent_price }} (Rent)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap align-items-center justify-content-center py-15 py-lg-28">
                                <div class="category-wrap me-2">
                                    <div class="status-title">
                                        <span>{{ $item->category }}</span>
                                    </div>
                                </div>
                                <div class="category-wrap">
                                    <div class="status-title">
                                        <span>{{ $item->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 form-wrap">
                            <div class="text-center"> 
                                {{-- check user log in --}}
                                @if (Auth::check())
                                
                                <form action="{{ route('add-to-cart') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="product_id" name="product_id" value="{{ $item->item_id }}">
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" >
                                  
                                    <button type="submit" class="btn btn-primary btn-md"> Add to cart</button>
                                    <a href="/Custome-Events-Packages" class="btn btn-primary btn-md btn-custom d-block d-md-none mt-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                                            class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                                        </svg>
                                        Return to Previous Page
                                    </a>
                                </form>
                                @else          
                                    <input type="hidden" id="product_id" name="product_id" value="{{ $item->item_id }}">
                                    <input type="number" id="quantity" name="quantity" value="1" min="1">
                                    <button type="submit" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#loginModal"> Add to cart</button>
                                    <a href="/Custome-Events-Packages" class="btn btn-primary btn-md btn-custom d-block d-md-none mt-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                                            class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                                        </svg>
                                        Return to Previous Page
                                    </a> 
                                @endif
 
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            <h2 class="blog-link fs-4 fw-bold">Description</h2>
                            <p class="pt-1 pt-lg-2">{{ $item->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- blog-content -->
        </div>
    </section>
@endsection
