@extends('layouts.userapp')

@section('content')
    <!-- Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Item Details</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="/Packages">Packages</a></li>
                        <li class="breadcrumb-item"><a href="#">Item</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $item->item_name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner Section ======================-->


    <section class="blog-content-section package-detail py-50 py-lg-80 py-xxl-100">
        <div class="container">
            <div class="blog-wrapper package-wrap">
                <div class="blog-content package-desc blog-content-2 custom-inner-bg p-4 mb-30 mb-lg-50">
                    <div class="row justify-content-between g-5 align-items-center">
                        <div class="col-lg-7">
                            <div class="blog-image">
                                <img class="main-img" src="{{ asset($item->image) }}" class="img-fluid" alt="{{ $item->item_name }}">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="blog-left-content d-flex flex-wrap align-items-center justify-content-center package-title">
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
