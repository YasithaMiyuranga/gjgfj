@extends('layouts.userapp')
@php
    $settings = getAppSettings();

@endphp
@section('content')
    <!--Hero Section ======================-->

    <x-hero-section-index-banner :bannerdata="$bannerarr" />
    <!--Hero Section ======================-->


    <!--Countdown Section ======================-->
    <!--Countdown Section ======================-->

    <!--Contact Us Section ======================-->
    <x-SubscriptionSection />
    <!--Contact Us Section ======================-->




    <!--Tickets Section ======================-->
    <!--Tickets Section ======================-->


    <!--About Section ======================-->
    <br><br>
    <section class="award-section award-2 mt-60 mt-lg-0 mb-30" style="margin-top: 10%">
        <div class="container">
            <div class="row gy-50 gy-lg-0 align-items-lg-center">
                <div class="col-lg-6">
                    <div class="award-left-content py-lg-100 wow fadeInRight">
                        <div class="section-title section-title-style-2 mb-4 mb-lg-30 mb-xxl-40">
                            <h3 class="straight-line-wrapper fw-semibold position-relative"> <span
                                    class="straight-line"></span>About Us</h3>
                            <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                                <span class="mb-n2 "><span class="text-primary mb-n2 text-opacity">4</span>ZERO</span>
                                <span class="sub-title fw-extra-bold primary-text-shadow custom-roboto">Events &
                                    Entertainment</span>
                            </h2>
                        </div>
                        <!-- section-title -->

                        <div class="award-wrapper d-flex flex-column gap-40 mb-40 mb-lg-60">
                            <div class="award-info d-flex gap-4">
                                <div class="award-icon">
                                    <span class="billboard-icon"><svg width="40" height="40">
                                            <use xlink:href="#billboard-icon"></use>
                                        </svg></span>
                                </div>
                                <div class="award-details">
                                    <h4 class="fw-semibold mb-3">Passionate Pioneers</h4>
                                    <p class="custom-sans custom-font-style-1">We're passionate about crafting unforgettable
                                        experiences through DJ, sound, and lighting services.</p>
                                </div>
                            </div>
                            <!-- award-info -->

                            <div class="award-info d-flex gap-4">
                                <div class="award-icon">
                                    <span class="billboard-icon"><svg width="40" height="40">
                                            <use xlink:href="#billboard-icon"></use>
                                        </svg></span>
                                </div>
                                <div class="award-details">
                                    <h4 class="fw-semibold mb-3">Tailored Excellence</h4>
                                    <p class="custom-sans custom-font-style-1">We tailor our services to each client,
                                        ensuring every event is unique and memorable.</p>
                                </div>
                            </div>
                            <!-- award-info -->

                            <div class="award-info d-flex gap-4">
                                <div class="award-icon">
                                    <span class="billboard-icon"><svg width="40" height="40">
                                            <use xlink:href="#billboard-icon"></use>
                                        </svg></span>
                                </div>
                                <div class="award-details">
                                    <h4 class="fw-semibold mb-3">Innovation and Expertise</h4>
                                    <p class="custom-sans custom-font-style-1">Our team combines cutting-edge technology
                                        with artistic finesse to create immersive experiences.</p>
                                </div>
                            </div>
                            <!-- award-info -->

                            <div class="award-info d-flex gap-4">
                                <div class="award-icon">
                                    <span class="billboard-icon"><svg width="40" height="40">
                                            <use xlink:href="#billboard-icon"></use>
                                        </svg></span>
                                </div>
                                <div class="award-details">
                                    <h4 class="fw-semibold mb-3">Versatile Solutions</h4>
                                    <p class="custom-sans custom-font-style-1">From weddings to corporate events, we provide
                                        versatile solutions for any occasion.</p>
                                </div>
                            </div>
                            <!-- award-info -->

                        </div>
                        <!-- award-wrapper -->

                        <div>
                            <a href="/About" class="btn btn-outline-gradient d-inline-flex align-items-center"
                                aria-label="buttons"><span class="gradient-btn-arrow"></span>Explore More</a>
                        </div>

                    </div>
                    <!-- award-left-content -->
                </div>
                <!-- col-6 -->
                <div class="col-lg-6">
                    <div class="award-image position-relative wow fadeInLeft">
                        <img src="assets/images/home/AboutUs.webp" alt="image">
                        <div class="video-popup video-popup-left position-absolute">
                            <div class="circle-wrapper">
                                <div class="circle-bg"></div>
                                <a href="https://www.youtube.com/watch?v=_dqHnXj6HjA"
                                    class="inner-circle video-icon video-popup-link">
                                    <span class=""><svg width="30" height="30">
                                            <use xlink:href="#video-icon"></use>
                                        </svg></span>
                                </a>
                                <div class="rotate-text3 text-uppercase">
                                    <p>Where Melodies Unite Hearts Harmonia-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- col-5 -->

            </div>
        </div>
    </section>
    <!--About Section ======================-->


    <!--Events We are Done Section ======================-->
    <section id="line-up" class="lineup-section lineup-2 pt-lg-5 mb-20 mb-lg-30 mb-xxl-40" style="margin-top: 7%">

        <div class="container">
            <div class="row gx-80 gy-30">
                <div class="col-lg-4">
                    <div class="lineup-right-content mt-30 mt-lg-0 wow fadeInRight">
                        <div class="section-title section-title-style-2 mb-4 mb-lg-30 mb-xxl-40">
                            <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                    class="straight-line"></span>Events</span>
                            <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                                <span class="mb-n2 text-opacity">Projects</span>
                                <span class="sub-title fw-extra-bold primary-text-shadow">We Done</span>
                            </h2>
                        </div>
                        <!-- section-title -->
                        <p class="mb-4 mb-lg-30">
                            From elegant weddings to pulsating night parties, our diverse portfolio
                            showcases our commitment to excellence at every event.
                        </p>

                        <div class="py-2 pb-lg-0 pt-lg-3">
                            <a href="/Gallery" class="download-link d-flex align-items-center gap-30"
                                aria-label="buttons">See More<span class="ticket-arrow arrow-up-right"><svg width="32"
                                        height="32">
                                        <use xlink:href="#arrow-up-right"></use>
                                    </svg></span></a>
                        </div>
                    </div>
                    <!-- lineup-right-content -->
                </div>
                <!-- col-5 -->
                <div class="col-lg-8">
                    <div class="swiper-custom-progress position-relative wow fadeInLeft">
                        <div class="swiper lineup-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="lineup-image-wrapper position-relative">
                                        <div class="lineup-image">
                                            <img src="assets/images/home/Projectwedone/thraithala.webp" class="img-fluid"
                                                alt="lineup-image">
                                        </div>
                                        <div class="lineup-image-hover">
                                            <p class="author-name">Thraithala Event</p>
                                            <div class="line-up-hover-content">
                                                <h5 class="fw-medium mb-20">Genere : <span
                                                        class="text-uppercase">Music</span>
                                                </h5>
                                                <div class="line-up-icons d-flex align-items-center gap-3 gap-lg-20">
                                                    <a href="#" class="facebook-icon" aria-label="facebook"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#facebook-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="instagram-icon" aria-label="instagram"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#instagram-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="youtube-icon" aria-label="youtube"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#youtube-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="spotify-icon" aria-label="spotify"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#spotify-icon"></use>
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- lineup-image-hover -->
                                    </div>
                                    <!-- lineup-image-wrapper -->
                                </div>
                                <!-- swiper-slide-->
                                <div class="swiper-slide">
                                    <div class="lineup-image-wrapper position-relative">
                                        <div class="lineup-image">
                                            <img src="assets/images/home/Projectwedone/flyyingdust.webp" class="img-fluid"
                                                alt="lineup-image">
                                        </div>
                                        <div class="lineup-image-hover">
                                            <p class="author-name">Private DJ Party</p>
                                            <div class="line-up-hover-content">
                                                <h5 class="fw-medium mb-20">Genere : <span
                                                        class="text-uppercase">rock</span></h5>
                                                <div class="line-up-icons d-flex align-items-center gap-3 gap-lg-20">
                                                    <a href="#" class="facebook-icon" aria-label="facebook"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#facebook-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="instagram-icon" aria-label="instagram"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#instagram-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="youtube-icon" aria-label="youtube"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#youtube-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="spotify-icon" aria-label="spotify"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#spotify-icon"></use>
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- lineup-image-hover -->
                                    </div>
                                    <!-- lineup-image-wrapper -->
                                </div>
                                <!-- swiper-slide-->
                                <div class="swiper-slide">
                                    <div class="lineup-image-wrapper position-relative">
                                        <div class="lineup-image">
                                            <img src="assets/images/home/Projectwedone/kalabaraheena.webp"
                                                class="img-fluid" alt="lineup-image">
                                        </div>
                                        <div class="lineup-image-hover">
                                            <p class="author-name">Kalabara Heena</p>
                                            <div class="line-up-hover-content">
                                                <h5 class="fw-medium mb-20">Genere : <span
                                                        class="text-uppercase">Music</span></h5>
                                                <div class="line-up-icons d-flex align-items-center gap-3 gap-lg-20">
                                                    <a href="#" class="facebook-icon" aria-label="facebook"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#facebook-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="instagram-icon" aria-label="instagram"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#instagram-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="youtube-icon" aria-label="youtube"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#youtube-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="spotify-icon" aria-label="spotify"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#spotify-icon"></use>
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- lineup-image-hover -->
                                    </div>
                                    <!-- lineup-image-wrapper -->
                                </div>
                                <!-- swiper-slide-->
                                <div class="swiper-slide">
                                    <div class="lineup-image-wrapper position-relative">
                                        <div class="lineup-image">
                                            <img src="assets/images/home/Projectwedone/laforesta.webp" class="img-fluid"
                                                alt="lineup-image">
                                        </div>
                                        <div class="lineup-image-hover">
                                            <p class="author-name">La Foresta</p>
                                            <div class="line-up-hover-content">
                                                <h5 class="fw-medium mb-20">Genere : <span
                                                        class="text-uppercase">DJ</span></h5>
                                                <div class="line-up-icons d-flex align-items-center gap-3 gap-lg-20">
                                                    <a href="#" class="facebook-icon" aria-label="facebook"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#facebook-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="instagram-icon" aria-label="instagram"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#instagram-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="youtube-icon" aria-label="youtube"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#youtube-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="spotify-icon" aria-label="spotify"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#spotify-icon"></use>
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- lineup-image-hover -->
                                    </div>
                                    <!-- lineup-image-wrapper -->
                                </div>
                                <!-- swiper-slide-->
                                <div class="swiper-slide">
                                    <div class="lineup-image-wrapper position-relative">
                                        <div class="lineup-image">
                                            <img src="assets/images/home/Projectwedone/maskiya.webp" class="img-fluid"
                                                alt="lineup-image">
                                        </div>
                                        <div class="lineup-image-hover">
                                            <p class="author-name">Fashion Show</p>
                                            <div class="line-up-hover-content">
                                                <h5 class="fw-medium mb-20">Genere : <span
                                                        class="text-uppercase">Modeling</span></h5>
                                                <div class="line-up-icons d-flex align-items-center gap-3 gap-lg-20">
                                                    <a href="#" class="facebook-icon" aria-label="facebook"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#facebook-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="instagram-icon" aria-label="instagram"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#instagram-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="youtube-icon" aria-label="youtube"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#youtube-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="spotify-icon" aria-label="spotify"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#spotify-icon"></use>
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- lineup-image-hover -->
                                    </div>
                                    <!-- lineup-image-wrapper -->
                                </div>
                                <!-- swiper-slide-->
                                <div class="swiper-slide">
                                    <div class="lineup-image-wrapper position-relative">
                                        <div class="lineup-image">
                                            <img src="assets/images/home/Projectwedone/ocendrive.webp" class="img-fluid"
                                                alt="lineup-image">
                                        </div>
                                        <div class="lineup-image-hover">
                                            <p class="author-name">Ocean Drive</p>
                                            <div class="line-up-hover-content">
                                                <h5 class="fw-medium mb-20">Genere : <span class="text-uppercase">DJ CLub
                                                        Party</span></h5>
                                                <div class="line-up-icons d-flex align-items-center gap-3 gap-lg-20">
                                                    <a href="#" class="facebook-icon" aria-label="facebook"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#facebook-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="instagram-icon" aria-label="instagram"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#instagram-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="youtube-icon" aria-label="youtube"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#youtube-icon"></use>
                                                        </svg></a>
                                                    <a href="#" class="spotify-icon" aria-label="spotify"><svg
                                                            width="20" height="20">
                                                            <use xlink:href="#spotify-icon"></use>
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- lineup-image-hover -->
                                    </div>
                                    <!-- lineup-image-wrapper -->
                                </div>
                                <!-- swiper-slide-->
                            </div>
                            <!-- swiper-wrapper -->
                        </div>
                        <!-- swiper -->
                        <div class="lineup-swiper-pagination"></div>

                        <div class="swiper-button-progress">
                            <div class="swiper-button-next">
                                <span class="chevron-right-icon"><svg width="12" height="14">
                                        <use xlink:href="#chevron-right-icon"></use>
                                    </svg></span>
                            </div>
                            <div class="swiper-button-prev">
                                <span class="chevron-left-icon"><svg width="12" height="14">
                                        <use xlink:href="#chevron-left-icon"></use>
                                    </svg></span>
                            </div>
                        </div>
                        <div class="ellipse-image-2">
                            <img src="assets/images/home-1/ellipse-2.png" class="img-fluid" alt="img">
                        </div>
                    </div>
                </div>
                <!-- col-7 -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </section>
    <!--Events We are Done Section ======================-->


    <!--Scroll Section ======================-->
    <!--Scroll Section ======================-->


    <!--Highlights Section ======================-->

    <!--Highlights Section ======================-->


    <!--Schedule Section ======================-->

    <!--Schedule Section ======================-->


    <!--Client Section ======================-->
    <br>
    <section id="sponsor" style="margin-top: 7%"
        class="sponsor-section sponser-section-slide sponsor-1 bg-lg custom-inner-bg position-relative pt-50 pt-lg-100 pt-xxl-120 pb-30 pb-lg-80 pb-xxl-100">
        <div class="ellipse-image-1">
            <img src="assets/images/home-1/ellipse-1.png" alt="ellipse-1">
        </div>
        <div class="container">
            <div class="row gy-4 gy-lg-0 align-items-lg-end justify-content-lg-between mb-30 mb-lg-70">
                <div class="col-lg-4">
                    <div class="section-title section-title-style-2 wow fadeInRight">
                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                class="straight-line"></span>The Power Behind Us</span>
                        <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                            <span class="mb-n2 text-opacity">Our</span>
                            <span class="sub-title fw-extra-bold primary-text-shadow">Clients</span>
                        </h2>
                    </div>
                    <!-- section-title -->
                </div>
                <div class="col-lg-5">
                    <div class="highlights-text wow fadeInLeft">
                        <p class="custom-sans custom-font-style-1 text-lg-end mb-2">
                            Our valued partners and sponsors play a pivotal role in bringing the vision of Lion Events to
                            life.
                            With their unwavering support, we orchestrate unforgettable experience that resonate deeply with
                            our audience.
                        </p>
                    </div>
                </div>
            </div>

            <div class="brand-logos position-relative wow slideInUp d-none d-md-block">
                <div class="swiper brand-2-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                    <img src="assets/images/home/OurClients/Dots_Bay.png" class="img-fluid"
                                        alt="brand-image">
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                    <img src="assets/images/home/OurClients/Mas.png" class="img-fluid" alt="brand-image">
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                    <img src="assets/images/home/OurClients/Outpost.png" class="img-fluid"
                                        alt="brand-image">
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                    <img src="assets/images/home/OurClients/Salt.png" class="img-fluid"
                                        alt="brand-image">
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                    <img src="assets/images/home/OurClients/The_Doctors_House.png" class="img-fluid"
                                        alt="brand-image">
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                    <img src="assets/images/home/OurClients/W15.png" class="img-fluid" alt="brand-image">
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                    <img src="assets/images/home/OurClients/IDM.png" class="img-fluid" alt="brand-image">
                            </div>
                        </div>
                        <!-- swiper-slide-->
                    </div>
                    <!-- swiper-wrapper -->
                </div>
            </div>

            <div class="row brand-logos position-relative wow slideInUp d-block d-md-none">
                <div class="col-12">
                    <div class="brand-image position-relative">
                            <img src="assets/images/home/OurClients/Dots_Bay.png" class="img-fluid" alt="brand-image">
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                            <img src="assets/images/home/OurClients/Mas.png" class="img-fluid" alt="brand-image">
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                            <img src="assets/images/home/OurClients/Outpost.png" class="img-fluid" alt="brand-image">
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                            <img src="assets/images/home/OurClients/Salt.png" class="img-fluid" alt="brand-image">
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                            <img src="assets/images/home/OurClients/The_Doctors_House.png" class="img-fluid"
                                alt="brand-image">
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                            <img src="assets/images/home/OurClients/W15.png" class="img-fluid" alt="brand-image">
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                            <img src="assets/images/home/OurClients/IDM.png" class="img-fluid" alt="brand-image">
                    </div>
                </div>
            </div>

            <div class="text-center mt-30 mt-lg-60 mt-xxl-70">
                <a href="/Contact" class="btn btn-outline-primary d-inline-flex align-items-center gap-2"
                    aria-label="buttons">Become A Sponsor<span class="arrow-up-short"><svg width="25"
                            height="25">
                            <use xlink:href="#arrow-up-short"></use>
                        </svg></span></a>
            </div>
        </div>
    </section>
    <!--Client Section ======================-->


    <!--Gallery Section ======================-->
    <x-gallery-section />
    <!--Gallery Section ======================-->

    <!--Least Updates Section ======================-->
    <x-highlights-section />
    <!--Least Updates Section ======================-->


    <!--Package List Section ======================-->
    <section id="merchandise"
        class="merchandise-section merchandise-1 position-relative mb-50 mb-lg-100 mb-xxl-120 py-50 py-lg-100 py-xxl-120">
        <div class="container">
            <div class="row gy-4 gy-lg-0 align-items-lg-end justify-content-lg-between mb-40 mb-lg-70">
                <div class="col-lg-4">
                    <div class="section-title section-title-style-2 wow fadeInRight"
                        style="visibility: visible; animation-name: fadeInRight;">
                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                class="straight-line"></span>The Shop</span>
                        <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                            <span class="mb-n2 text-opacity"><span style="opacity: 1;">Our</span></span>
                            <span class="sub-title fw-extra-bold primary-text-shadow">Packages</span>
                        </h2>
                    </div>
                    <!-- section-title -->
                </div>
                <div class="col-lg-5">
                    <div class="highlights-text wow fadeInLeft">
                        <p class="custom-jakarta custom-font-style-2 text-lg-end mb-2">
                            Explore our curated packages designed to make your event unforgettable.
                            Choose the perfect package for your occasion and let Lion Events turn your vision into reality.
                        </p>
                    </div>
                </div>
            </div>
            <!-- row -->

            <div class="merchandise-contents position-relative">
                <div class="ellipse-image-6" style="z-index: -1">
                    <img src="assets/images/ellipse-6.png" class="img-fluid" alt="img">
                </div>

                @if (isset($packages) && $packages->isNotEmpty())
                    <div class="scroll-container-wrapper position-relative">
                        <!-- Scrollable packages -->
                        <div class="scroll-container" id="packageScroll">
                            @foreach ($packages as $package)
                                <div class="package-item-scroll">
                                    <div class="merchandise-wrapper merchandise-dark">
                                        <div class="merchandise-image mb-4">
                                            <img src="{{ asset($package->image) }}" alt="{{ $package->package_name }}"
                                                class="img-fluid">
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="product-information">
                                                <h5>{{ $package->package_name }}</h5>
                                            </div>
                                            <div>
                                                <a href="{{ url('/single-package/' . $package->package_id) }}"
                                                    class="btn btn-outline-primary btn-custom-dark">View Package</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($packages as $package)
                                <div class="package-item-scroll">
                                    <div class="merchandise-wrapper merchandise-dark">
                                        <div class="merchandise-image mb-4">
                                            <img src="{{ asset($package->image) }}" alt="{{ $package->package_name }}"
                                                class="img-fluid">
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="product-information">
                                                <h5>{{ $package->package_name }}</h5>
                                            </div>
                                            <div>
                                                <a href="{{ url('/single-package/' . $package->package_id) }}"
                                                    class="btn btn-outline-primary btn-custom-dark">View Package</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p>No packages found.</p>
                @endif
            </div>
        </div>
    </section>
    <!--Package List Section ======================-->


    <!--Book Package Section ======================-->
    <section class="cta-section cta-1 pb-50 pb-lg-80">
        <div class="container">
            <div class="row gy-20 gy-lg-0 align-items-lg-center justify-content-lg-between">
                <div class="col-lg-4">
                    <div class="d-flex justify-content-between">
                        <h2 class="fs-180-style-2 fw-extra-bold primary-text-shadow d-flex align-items-center gap-2 mb-0">
                            <span class="odometer" data-count-to=25></span>
                            <span class="d-flex flex-column">
                                <span class="cta-percent fw-extra-bold">%</span>
                                <span class="cta-off fw-extra-bold">Off</span>
                            </span>
                        </h2>
                        <div class="d-block d-lg-none">
                            <div class="cta-icon">
                                <a href="#ticket" aria-label="icons">
                                    <span class="arrow-up-right-big"><svg>
                                            <use xlink:href="#arrow-up-right-big"></use>
                                        </svg></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <h2 class="cta-text ms-xl-n70 display-3 fw-extra-bold text-opacity">
                        Book Your Package Now!
                    </h2>
                </div>
                <div class="col-lg-3">
                    <div class="cta-icon d-none d-lg-block ms-xl-70 ms-xxl-100">
                        <a href="/Packages" aria-label="icons">
                            <span class="arrow-up-right-big"><svg width="205" height="205">
                                    <use xlink:href="#arrow-up-right-big"></use>
                                </svg></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        window.packageImagesAltMap = @json($settings['app']['home']['images'] ?? []);
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

    <!--Book Package Section ======================-->
@endsection
