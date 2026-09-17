@extends('layouts.userapp')

@section('content')
    <!-- Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Package Details</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="/Packages">Package</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $package->package_name }}</li>
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
                                <img class="main-img" src="{{ asset($package->image) }}" class="img-fluid" alt="img">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="blog-left-content d-flex flex-wrap align-items-center justify-content-center package-title">
                                <h2 class="blog-link fs-4 fw-bold title">{{ $package->package_name }}</h2>
                            </div>
                            <div class="d-flex flex-wrap align-items-center justify-content-center">
                                <div class="price-wrap">
                                    <div class="price-title"> 
                                        @if($package->price_visible)
                                            <span class="price">LKR: {{ $package->price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap align-items-center justify-content-center py-15 py-lg-28">
                                <div class="category-wrap me-2">
                                    <div class="status-title">
                                        <span>{{ $package->category }}</span>
                                    </div>
                                </div>
                                <div class="category-wrap me-2">
                                    <div class="status-title">
                                        <span>{{ $package->type }}</span>
                                    </div>
                                </div>
                                <div class="category-wrap">
                                    <div class="status-title">
                                        <span>{{ $package->status }}</span>
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
                                <p class="pt-1 pt-lg-2">{{ $package->description }}</p>
                            </div>
                    </div>
                </div>
                {{-- If package Has Items --}}
                @if ($packageItems->count() > 0)
                    <div class="row g-4 mt-2" data-masonry='{"percentPosition": true }'>
                        @foreach ($packageItems as $item)
                            <div class="col-lg-4 item-wrap">
                                <div class="blog-content item-content blog-content-2 custom-inner-bg">
                                    <div class="row gy-4 align-items-center justify-content-between">
                                        <div class="col-12">
                                            <div class="item-image-wrap">
                                                @if ($item->item_image == null)
                                                    <p>No Image</p>
                                                @else
                                                    <a class="text-decoration-none" href="/single-item/{{ $item->item_id }}">
                                                        <img class="item-img" src="{{ asset($item->item_image) }}" class="img-fluid" alt="{{ $item->item_name }}">
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="blog-left-content">
                                                <h2 class="item-title fs-4 fw-bold"><a class="text-decoration-none" href="/single-item/{{ $item->item_id }}">{{ $item->item_name??'N/A' }}</a></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-bottom">
                                    <div class="card-bt"></div>
                                </div>
                            </div>                
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <!-- blog-content -->
        </div>
    </section>
@endsection
