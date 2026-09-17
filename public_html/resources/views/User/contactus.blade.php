@extends('layouts.userapp')
@php
    $settings = getAppSettings();

@endphp
@section('content')
    <!-- offcanvas-top -->


    <div class="offcanvas offcanvas-end offcanvasShop" id="offcanvasShop" data-bs-backdrop="static" tabindex="-1">
        <div class="offcanvas-header">
            <h3 class="text-uppercase fw-bold">Cart</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex justify-content-center">
            <h2 class="fw-semibold">
                Your Cart Is Empty
            </h2>
        </div>
    </div>
    <!-- offcanvasShop -->


    <div class="main" data-bs-spy="scroll" data-bs-target="#navContentmenu" data-bs-root-margin="0px 0px -50%"
        data-bs-smooth-scroll="true">

        <!--Banner Section ======================-->
        <section class="banner-section banner-1 banner-2 position-relative parallax">
            <div class="container">
                <div
                    class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                    <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Contact us</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="blog-breadcrumb breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>
        <!--Banner Section ======================-->


        <!--About Section ======================-->
        <section class="about-section about-1 pt-50 pt-lg-100 pt-xxl-150">
            <div class="container">
                <div class="row gy-50 gy-lg-0 gx-80 justify-content-lg-between align-items-lg-center">
                    <div class="col-lg-6">
                        <div class="wow fadeInRight">
                            <div class="section-title section-title-style-2 mb-4 mb-lg-30 mb-xxl-40">
                                <h3 class="sub-title display-3 fw-extra-bold primary-text-shadow custom-roboto">Events
                                </h3>
                            </div>
                            <!-- section-title -->
                            <h2 class="title display-3 fw-extra-bold mb-n2 custom-roboto">
                                <span>Where music and magic unite for unforgettable experiences</span>
                            </h2>
                            {{-- <a href="#ticket"
                                class="btn btn-gradient d-inline-flex align-items-center gap-2 mt-4 mt-lg-40 mt-xxl-60"
                                aria-label="buttons"><span class="buttons-logo"><svg width="25" height="25">
                                        <use xlink:href="#buttons-logo"></use>
                                    </svg></span>Get Ticket</a>  --}}
                        </div>
                    </div>
                    <!-- col-5 -->
                    <div class="col-lg-6">
                        <div class="about-content-wrapper position-relative wow fadeInLeft">
                            <div class="about-image-1 position-relative">
                                <div class="about-image-wrapper">
                                    <img src="assets/images/home-1/about-image-1_update.jpg" class="img-fluid"
                                        alt="img">
                                </div>
                                <div class="video-popup video-popup-center position-absolute">
                                    <div class="circle-wrapper">
                                        <div class="circle-bg"></div>
                                        <a href="https://www.youtube.com/watch?v=oOgZy6mmL-M"
                                            class="inner-circle video-icon video-popup-link">
                                            <span class=""><svg width="30" height="30">
                                                    <use xlink:href="#video-icon"></use>
                                                </svg></span>
                                        </a>
                                        <div class="rotate-text2 text-uppercase">
                                            <p>Where Melodies Unite Hearts Harmonia-</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="about-image-2">
                            </div>
                            <div class="ellipse-image-1">
                                <img src="assets/images/home-1/ellipse-1.png" class="img-fluid" alt="img">
                            </div>
                        </div>
                        <!-- about-content-wrapper -->
                    </div>
                </div>
            </div>
        </section>
        <!--About Section ======================-->


        <!--Contact Section ======================-->
        <section class="contact-section contact-page pt-70 pt-lg-120 pt-xxl-150">
            <div class="container">
                <div class="row gy-20 gy-lg-0 align-items-lg-end justify-content-lg-between mb-30 mb-lg-70">
                    <div class="col-lg-5">
                        <div class="section-title section-title-style-2 wow fadeInRight">
                            <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                    class="straight-line"></span>Contact</span>
                            <!-- <h2 class="title display-3 fw-extra-bold mb-n2 text-opacity">Music</h2> -->
                            <h3 class="sub-title display-3 fw-extra-bold primary-text-shadow">Get In Touch</h3>
                        </div>
                        <!-- section-title -->
                    </div>
                    <div class="col-lg-5">
                        <div class="highlights-text wow fadeInLeft">
                            <p class="custom-roboto custom-font-style-1 text-lg-end mb-2">
                                Join Our Vibrant Community and Stay Updated with Exclusive Offers,
                                Exciting News, and Event Updates Delivered Straight to Your Inbox
                            </p>
                        </div>
                    </div>
                </div>
                <!-- row -->
                <div class="contact-us-form">
                    <form action="{{ route('contactus.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row gx-5 gy-4 gy-lg-5">
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    placeholder="First Name *" required>
                            </div>

                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="lastName" name="lastName"
                                    placeholder="Last Name *" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="telephone" name="telephone"
                                    placeholder="Phone No *" required>
                            </div>
                            <div class="col">
                                <input type="email" class="form-control" placeholder="Email" name="email" required>
                            </div>

                            <div class="col-12">
                                <textarea class="form-control" placeholder="Your Comment" id="form-textarea" name="comment" style="height: 100px"></textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-gradient d-inline-flex"
                                    aria-label="buttons">Submit</button>
                            </div>
                        </div>
                        <!-- row -->
                    </form>
                </div>
                <!-- contact-us-form -->
            </div>
            <!-- container -->
        </section>
        <!--Contact Section ======================-->


        <!--Ticket Section ======================-->
        <section class="ticket-section about-ticket pt-60 pt-lg-100 pt-xxl-130">
            <div class="container">
                <div class="ticket-wrapper position-relative parallax">
                    <div class="ticket-inner">
                        <h2 class="display-3 text-gradient no-stroke fw-extra-bold custom-jakarta mb-20">
                            Early Bird Tickets Available!
                        </h2>
                        <h3 class="custom-jakarta ticket-text fw-semibold">Don't miss this extraordinary celebration of
                            music and create memories that will last a lifetime.</h3>
                        <!-- <a href="#ticket" class="btn btn-gradient d-inline-flex align-items-center gap-2 mt-4 mt-lg-40"
                                aria-label="buttons"><span class="buttons-logo"><svg width="25" height="25">
                                        <use xlink:href="#buttons-logo"></use>
                                    </svg></span>Get Ticket</a> -->
                    </div>
                </div>
            </div>

        </section>
        <!--Ticket Section ======================-->


        <!--Direction Section ======================-->
        <section id="direction"
            class="direction-section direction-1 position-relative pt-50 pt-lg-100 pt-xxl-130 pb-20 pb-lg-50">
            <div class="container">
                <div class="direction-wrapper">
                    <div class="row justify-content-between align-items-lg-center gy-40 gy-lg-0">
                        <div class="col-lg-5">
                            <div class="direction-left-content wow fadeInRight">
                                <h2 class="display-5 fw-extra-bold custom-jakarta">
                                    Get Direction to Lion Events & Entertainment
                                </h2>
                                <div
                                    class="d-flex flex-column flex-lg-row gap-5 justify-content-lg-between align-items-lg-center mt-30 mt-lg-50">
                                    <div class="direction-details">
                                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"><span
                                                class="straight-line"></span>Venue</span>
                                        <div class="mt-10 mt-lg-30">
                                            <h4 class="custom-jakarta fw-extra-bold">Lion Events</h4>
                                            <h4 class="custom-jakarta fw-normal">169, Mahapala Waththa, Hakamana Road,
                                                Thudava, Matara.</h4>
                                        </div>
                                    </div>
                                    <div class="direction-details">
                                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"><span
                                                class="straight-line"></span>Time</span>
                                        <div class="mt-10 mt-lg-30">
                                            <h4 class="custom-jakarta fw-normal">Monday To Saturday</h4>
                                            <h4 class="custom-jakarta fw-normal">Monday To Saturday 08:30 - 18:30</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mt-lg-40">
                                    <a id="mapDirectionBtn" href="#"
                                        class="btn btn-gradient d-flex align-items-center justify-content-center custom-roboto gap-10 btn-map-direction"
                                        data-bs-toggle="modal" data-bs-target="#RoutingMapModal">Get Direction <svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                        </svg></a>
                                </div>
                            </div>
                            <!-- direction-left-content -->
                        </div>
                        <!-- col-5 -->

                        <div class="col-lg-6 wow fadeInLeft">
                            <div class="parallax position-relative">
                                <span class="map-marker">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3968.2491117824056!2d80.5437877758748!3d5.960380994024339!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae1391dbd1d3541%3A0x4aa69c0a9c2a4ca0!2scodeaisys.com!5e0!3m2!1sen!2slk!4v1709724223273!5m2!1sen!2slk"
                                        width="100%" height="450" style="border:0; border-radius: 18px"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </span>
                            </div>

                            <!-- Modal-Map -->
                            <div class="modal modal-fullscreen routing-map-modal fade" id="RoutingMapModal"
                                tabindex="-1" aria-labelledby="RoutingMapLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="RoutingMapLabel">169, Mahapala Waththa,
                                                Hakamana Road, Thudava, Matara.</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3968.2491117824056!2d80.5437877758748!3d5.960380994024339!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae1391dbd1d3541%3A0x4aa69c0a9c2a4ca0!2scodeaisys.com!5e0!3m2!1sen!2slk!4v1709724223273!5m2!1sen!2slk"
                                                width="100%" height="450" style="border:0; border-radius: 18px"
                                                allowfullscreen="" loading="lazy"
                                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal-Map -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Direction Section ======================-->

    </div>

    <script>
        window.packageImagesAltMap = @json($settings['app']['contact']['images'] ?? []);
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
@endsection
