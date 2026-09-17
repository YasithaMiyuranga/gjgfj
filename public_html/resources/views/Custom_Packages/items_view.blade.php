@extends('layouts.userapp')

@section('content')
    {{-- Package Page Banner --}}

    <!--Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Packages</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Packages</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!--Banner Section ======================-->

    <x-line-up-banner />

    <!-- Start Packge List Section -->
    <section id="packages" class="pricing-section package-section pricing-1 pb-50 pb-lg-100 pb-xxl-120">
        <div class="container">
            <div class="row gy-4 gy-lg-0 align-items-lg-end justify-content-lg-between mb-30 mb-lg-70">
                <div class="col-lg-4">
                    <div class="section-title section-title-style-2 wow fadeInRight">
                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                class="straight-line"></span>Packages</span>
                        <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                            <span class="mb-n2 text-opacity">Competetive</span>
                            <span class="sub-title fw-extra-bold primary-text-shadow">Custom Package Design</span>
                        </h2>
                    </div>
                    <!-- section-title -->
                </div>
                <div class="col-lg-5">
                    <div class="highlights-text wow fadeInLeft">
                        <p class="custom-sans custom-font-style-1 text-lg-end mb-2">
                            Unleash the rhythm with an extraordinary lineup. Get ready for a musical extravaganza that will
                            captivate your senses.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row" data-masonry='{"percentPosition": true }'>
                @foreach ($items as $item)
                    <div class="col-md-4">
                        <a href="#" style="display: inline-block;" data-bs-toggle="modal"
                            data-bs-target="#{{ $item->item_id }}">
                            <div class="blog-content package-content blog-content-2 custom-inner-bg">
                                <div class="row package-img-cont-wrap gy-4 align-items-center justify-content-between">
                                    <div class="col-12 img-wrap">
                                        <div class="package-image-wrap">
                                            <img class="package-image" src="{{ asset('' . $item->image) }}"
                                                alt="{{ $item->item_name }}" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="col-12 content-wrap">
                                        <div class="blog-left-content">
                                            {{-- <p class="price-sec">
                                                LKR: {{ $item->rent_price }}
                                            </p> --}}
                                        </div>
                                    </div>
                                    <h2 class="package-title blog-link fs-4 fw-bold"><a
                                            href="{{ route('custom.package.single', $item->item_id) }}"
                                            class="text-decoration-none">{{ $item->item_name }} </a></h2>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- Modal -->
            @foreach ($items as $item)
                <div class="modal fade" id="{{ $item->item_id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- <h5 class="modal-title" id="exampleModalLabel">{{ $item->item_name }}</h5> -->
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row package-desc">
                                        <div class="col-md-7 img-wrap">
                                            <div class="pop-image">
                                                <img class="main-img" src="{{ asset('' . $item->image) }}"
                                                    alt="{{ $item->item_name }}" class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="col-lg-5 detail-wrap">
                                            <div
                                                class="blog-left-content d-flex flex-wrap align-items-center justify-content-center package-title">
                                                <h2 class="blog-link fw-bold title">{{ $item->item_name }}</h2>
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center">
                                                <div class="price-wrap">
                                                    <div class="price-title">
                                                        <span class="price">LKR: {{ $item->rent_price }} (Rent)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex flex-wrap align-items-center justify-content-center py-15 py-lg-28">
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
                                    <div class="col-lg-12 form-wrap from-wrap-popup">
                                        <div class="text-center">
                                            <form action="{{ route('add-to-cart') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="qty-wrap">
                                                    <div class="quantity-decrease-popup">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-dash"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                                        </svg>
                                                    </div>
                                                    <input type="hidden" name="product_id" value="{{ $item->item_id }}">
                                                    <input class="quantity-field-popup" type="number" name="quantity"
                                                        value="1">
                                                    <div class="quantity-increase-popup">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-plus"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                        </svg>
                                                    </div>

                                                    @if (Auth::user())
                                            
                                                        <button type="submit" class="btn btn-primary btn-md"> Add to
                                                            cart</button>
                                                    @else
                                                        <a data-bs-toggle="modal" data-bs-target="#loginModal"
                                                            class="btn btn-primary btn-md p-2 m-2" style="width: fit-content;height: fit-content;"
                                                            aria-label="buttons">Add to cart</a>
                                                    @endif




                                                </div>
                                            </form>
                                            @if (session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row description">
                                        <div class="col-lg-12">
                                            <div class="">
                                                <h2 class="blog-link fs-4 fw-bold">Description</h2>
                                                <p class="pt-1 pt-lg-2">{{ $item->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- End Package List Section -->

    {{-- End Package Page Banner --}}
@endsection
