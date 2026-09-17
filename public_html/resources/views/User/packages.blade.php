<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@extends('layouts.userapp')
@php
    $settings = getAppSettings();

@endphp
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
                                class="straight-line"></span>Customized</span>
                        <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                            <span class="mb-n2 text-opacity">Competetive</span>
                            <span class="sub-title fw-extra-bold primary-text-shadow">Packages</span>
                        </h2>
                    </div>
                    <!-- section-title -->
                </div>
                <div class="col-lg-5">
                    <div class="highlights-text wow fadeInLeft">
                        <p class="custom-sans custom-font-style-1 text-lg-end mb-2">
                            We believe in empowering our customers to create the perfect event experience tailored to their
                            unique needs.
                            With our Competitive Custom Package Design feature, you're in control every step of the way.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Search Bar + Category Select -->
            <div class="row category-select-section">
                <div class="col-md-4 category-select-wrap" style="position: relative; margin-bottom: 10px;">
                    <form id="search-form" method="GET" style="position: relative;">
                        <input type="text" name="query" id="package-search" class="form-control"
                            placeholder="Search package..."
                            style="width: 100%; padding: 8px 30px 8px 10px; border-radius: 8px !important; border: 2px solid #f68634; height: 40px;">
                        <button type="submit"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none;">
                            <i class="fa fa-search" style="color: #f68634;"></i>
                        </button>
                    </form>
                </div>

                <div class="col-md-4 category-select-wrap" style="position: relative; margin-bottom: 10px;">
                    <select id="category-select" class="form-control"
                        style="width: 100%; padding: 8px 10px; border-radius: 8px !important; border: 2px solid #f68634; height: 40px;">>
                        <option value="all">All</option>
                        @foreach ($packages->pluck('category')->unique() as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Package List Results -->
            <div class="row" id="package-list">
                @include('partision.package-list', ['packages' => $packages])
            </div>


            {{-- <div class="row">
                @foreach ($packages as $package)
                    <div class="col-md-4 package-item" data-category="{{ $package->category }}">
                        <a href="/single-package/{{ $package->package_id }}" style="display: inline-block;">
                            <div class="blog-content package-content blog-content-2 custom-inner-bg">
                                <div class="row package-img-cont-wrap gy-4 align-items-center justify-content-between">
                                    <div class="col-12 img-wrap">
                                        <div class="package-image-wrap">
                                            <img class="package-image" src="{{ asset($package->image) }}"
                                                alt="{{ $package->name }}" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="col-12 content-wrap">
                                        <div class="blog-left-content">
                                            <p class="price-sec">
                                                LKR: {{ $package->price }}
                                            </p>
                                        </div>
                                        <!-- left-content -->
                                    </div>
                                    <h2 class="package-title blog-link fs-4 fw-bold"><a class="text-decoration-none"
                                        href="/single-package/{{ $package->package_id }}">{{ $package->package_name }}</a>
                                    </h2>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div> --}}

            <div class="row custom-package-wrap">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="{{ route('custom.package') }}" class="btn btn-primary btn-lg"
                            style="color: aliceblue">Create Custom Package</a>
                    </div>
                </div>
            </div>
            {{--  <a href="{{ route(custom.package) }}"><div class="category-wrap me-2">
                <div class="status-title">
                    <span>Wedding</span>
                </div>
            </div></a> --}}
        </div>
    </section>
    <!-- End Package List Section -->

    {{-- End Package Page Banner --}}
@endsection

{{-- SCRIPT TO SERCH AND FILTER CATERGORY PACKAGES --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchPackages() {
        let query = $('#package-search').val();
        let category = $('#category-select').val();

        $.ajax({
            url: "{{ route('useradmin.package.search') }}",
            method: 'GET',
            dataType: 'json',
            data: {
                query: query,
                category: category
            },
            success: function(response) {
                if (response.html && response.html.trim() !== '') {
                    $('#package-list').html(response.html);
                } else {
                    $('#package-list').html(
                        '<div class="col-12 text-center"><p class="text-warning">No packages found.</p></div>'
                    );
                }
            },
            error: function() {
                $('#package-list').html(
                    '<div class="col-12 text-center"><p class="text-danger">Something went wrong.</p></div>'
                );
            }
        });
    }

    $(document).ready(function() {
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            fetchPackages();
        });

        $('#category-select').on('change', function() {
            fetchPackages();
        });
    });
</script>
<script>
    window.packageImagesAltMap = @json($settings['app']['packages']['images'] ?? []);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function getFilenameFromUrl(url) {
            return url.split('/').pop();
        }

        const images = Array.from(document.getElementsByTagName('img'));
        const imageAltMap = window.packageImagesAltMap || {};



        images.forEach(img => {
            const imgName = getFilenameFromUrl(img.src);
            if (imageAltMap[imgName] && imageAltMap[imgName].alt) {
                img.alt = imageAltMap[imgName].alt;
            }
        });
    });
</script>
