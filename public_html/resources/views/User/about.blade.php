@extends('layouts.userapp')

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
                    <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">About us</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="blog-breadcrumb breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About us</li>
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
                                <h3 class="sub-title display-3 fw-extra-bold primary-text-shadow custom-roboto">Lion Events & Entertainment</h3>
                                </h3>
                            </div>
                            <!-- section-title -->
                            <h1 class="display-5 custom-jakarta fw-extra-bold mb-0">
                                We are an experienced Total Event Management Solutions company.
                            </h1>
                            {{-- <a href="#ticket"
                                class="btn btn-gradient d-inline-flex align-items-center gap-2 mt-4 mt-lg-40 mt-xxl-60"
                                aria-label="buttons"><span class="buttons-logo"><svg width="25" height="25">
                                        <use xlink:href="#buttons-logo"></use>
                                    </svg></span>Get Ticket</a> --}}
                        </div>
                    </div>
                    <!-- col-5 -->
                    <div class="col-lg-6">
                        <div class="about-content-wrapper position-relative wow fadeInLeft">
                            <div class="about-image-1 position-relative">
                                <div class="about-image-wrapper">
                                    <img src="assets/images/home-1/about-image-1.jpg" class="img-fluid" alt="img">
                                </div>
                                <div class="video-popup video-popup-center position-absolute">
                                    <div class="circle-wrapper">
                                        <div class="circle-bg"></div>
                                        <a href="http://www.youtube.com/watch?v=0O2aH4XLbto"
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


        <!--Commanders Section ======================-->
        <section id="commanders" class="commander-section about-1 pt-50 pt-lg-100 pt-xxl-150">
            <div class="container">
                <div class="row gy-4 gy-lg-0 align-items-lg-end justify-content-lg-between mb-30 mb-lg-70">
                    <div class="col-lg-4">
                        <div class="section-title section-title-style-2 wow fadeInRight">
                            <span class="fs-3 straight-line-wrapper fw-semibold position-relative custom-roboto"> <span
                                    class="straight-line"></span>Behind The Lion Events</span>
                            <h2 class="title display-3 fw-extra-bold mb-n2 text-opacity custom-roboto">Meet Our</h2>
                            <h3 class="sub-title display-3 fw-extra-bold primary-text-shadow custom-roboto">Crew Members
                            </h3>
                        </div>
                        <!-- section-title -->
                    </div>
                    <div class="col-lg-4">
                        <div class="highlights-text wow fadeInLeft">
                            <p class="custom-jakarta custom-font-style-1 text-lg-end mb-2">
                                At Lion Events, we're proud to have a dedicated team of talented
                                individuals who bring passion, expertise, and creativity to every event.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- row -->
                <div class="d-flex flex-column gap-50 gap-lg-80 gap-xl-100">
                    <div class="row gx-30 gy-50 gy-lg-0">
                        <!-- col -->
                        <div class="col-md-3">
                            <div class="commander-wrapper">
                                <div class="commander-image mb-3">
                                    <img src="assets/images/crew/Ravindu.png" class="img-fluid" alt="img">
                                </div>
                                <div class="commander-info">
                                    <h2 class="fw-semibold custom-jakarta mb-0">Ravindu Yasara</h2>
                                    <p class="mb-0 custom-font-style-1 fw-semibold custom-jakarta">Event Manager</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="commander-wrapper">
                                <div class="commander-image mb-3">
                                    <img src="assets/images/crew/Isuru.png" class="img-fluid" alt="img">
                                </div>
                                <div class="commander-info">
                                    <h2 class="fw-semibold custom-jakarta mb-0">Isuru Gamage</h2>
                                    <p class="mb-0 custom-font-style-1 fw-semibold custom-jakarta">Event Supervisor</p>
                                </div>
                            </div>
                        </div>

                        <!-- col -->
                        <div class="col-md-3">
                            <div class="commander-wrapper">
                                <div class="commander-image mb-3">
                                    <img src="assets/images/crew/Thaki.png" class="img-fluid" alt="img">
                                </div>
                                <div class="commander-info">
                                    <h2 class="fw-semibold custom-jakarta mb-0">Thakshila (Thaki)</h2>
                                    <p class="mb-0 custom-font-style-1 fw-semibold custom-jakarta">Lighting Supervisor
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- col -->
                        <div class="col-md-3">
                            <div class="commander-wrapper">
                                <div class="commander-image mb-3">
                                    <img src="assets/images/crew/Tharaka.png" class="img-fluid" alt="img">
                                </div>
                                <div class="commander-info">
                                    <h2 class="fw-semibold custom-jakarta mb-0">Tharaka Sumudu</h2>
                                    <p class="mb-0 custom-font-style-1 fw-semibold custom-jakarta">Sponsorship Coordinator
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- col -->
                    </div>
                    <div class="row gx-30 gy-50 gy-lg-0">
                        <!-- col -->
                        <div class="col-md-3">
                            <div class="commander-wrapper">
                                <div class="commander-image mb-3">
                                    <img src="assets/images/crew/Eshan.png" class="img-fluid" alt="img">
                                </div>
                                <div class="commander-info">
                                    <h2 class="fw-semibold custom-jakarta mb-0">Eshan Venura</h2>
                                    <p class="mb-0 custom-font-style-1 fw-semibold custom-jakarta">Crew Member</p>
                                </div>
                            </div>
                        </div>



                        <!-- col -->
                        <div class="col-md-3">
                            <div class="commander-wrapper">
                                <div class="commander-image mb-3">
                                    <img src="assets/images/crew/Ruchira.png" class="img-fluid" alt="img">
                                </div>
                                <div class="commander-info">
                                    <h2 class="fw-semibold custom-jakarta mb-0">Ruchira Thilan</h2>
                                    <p class="mb-0 custom-font-style-1 fw-semibold custom-jakarta">Lighting Planer
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- col -->

                    </div>
                    <!-- row -->
                </div>
            </div>

        </section>
        <!--Commanders Section ======================-->


        <!--Highlights Section ======================-->
        <section id="events" class="highlight-section pt-50 pt-lg-100 pt-xxl-130">
            <div class="container position-relative">
                <div class="row gy-4 gy-lg-0 align-items-lg-end justify-content-lg-between mb-30 mb-lg-70">
                    <div class="col-lg-4">
                        <div class="section-title section-title-style-2 wow fadeInRight">
                            <span class="fs-3 straight-line-wrapper fw-semibold position-relative custom-roboto"> <span
                                    class="straight-line"></span>Services</span>
                            <h2 class="title display-3 fw-extra-bold mb-n2 text-opacity custom-roboto">What</h2>
                            <h3 class="sub-title display-3 fw-extra-bold primary-text-shadow custom-roboto">Will You Get
                            </h3>
                        </div>
                        <!-- section-title -->
                    </div>
                    <div class="col-lg-5">
                        <div class="highlights-text wow fadeInLeft">
                            <p class="custom-jakarta custom-font-style-1 text-lg-end mb-2">
                                Whatever your requirements, we have the expertise and equipment to bring your vision to life.
                                Explore our services and let us help you create an unforgettable event experience.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- row -->
                <div class="row services-wrap">
                    <div class="col-lg-4 services-item-wrap">
                        <div class="highlights-item-3 text-decoration-none position-relative d-flex flex-column gap-20 px-30 px-lg-40 py-40 py-lg-50">
                            <div class="info-wrap">
                                <div class="highlights-icon-style-1">
                                    <img src="assets/images/services/sound-system.svg" alt="Sound System">
                                </div>
                                <h3 class="fw-extra-bold mb-0">Sound Systems</h3>
                            </div>
                            <div class="img-wrap">
                                <img src="assets/images/services/icon-pattern.png" alt="Sound System">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 services-item-wrap">
                        <div class="highlights-item-3 text-decoration-none position-relative d-flex flex-column gap-20 px-30 px-lg-40 py-40 py-lg-50">
                            <div class="info-wrap">
                                <div class="highlights-icon-style-1">
                                    <img src="assets/images/services/generators.svg" alt="Generators">
                                </div>
                                <h3 class="fw-extra-bold mb-0">Generators</h3>
                            </div>
                            <div class="img-wrap">
                                <img src="assets/images/services/icon-pattern.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 services-item-wrap">
                        <div class="highlights-item-3 text-decoration-none position-relative d-flex flex-column gap-20 px-30 px-lg-40 py-40 py-lg-50">
                            <div class="info-wrap">
                                <div class="highlights-icon-style-1">
                                    <img src="assets/images/services/show-lighting.svg" alt="Professional Show Lighting">
                                </div>
                                <h3 class="fw-extra-bold mb-0">Professional Show Lighting</h3>
                            </div>
                            <div class="img-wrap">
                                <img src="assets/images/services/icon-pattern.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 services-item-wrap">
                        <div class="highlights-item-3 text-decoration-none position-relative d-flex flex-column gap-20 px-30 px-lg-40 py-40 py-lg-50">
                            <div class="info-wrap">
                                <div class="highlights-icon-style-1">
                                    <img src="assets/images/services/in-out-led.svg" alt="Indoor/Outdoor LED Screens">
                                </div>
                                <h3 class="fw-extra-bold mb-0">Indoor/Outdoor LED Screens</h3>
                            </div>
                            <div class="img-wrap">
                                <img src="assets/images/services/icon-pattern.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 services-item-wrap">
                        <div class="highlights-item-3 text-decoration-none position-relative d-flex flex-column gap-20 px-30 px-lg-40 py-40 py-lg-50">
                            <div class="info-wrap">
                                <div class="highlights-icon-style-1">
                                    <img src="assets/images/services/maequees.svg" alt="Marquees Tents Gazeebos">
                                </div>
                                <h3 class="fw-extra-bold mb-0">Marquees, Tents, Gazeebos</h3>
                            </div>
                            <div class="img-wrap">
                                <img src="assets/images/services/icon-pattern.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 services-item-wrap">
                        <div class="highlights-item-3 text-decoration-none position-relative d-flex flex-column gap-20 px-30 px-lg-40 py-40 py-lg-50">
                            <div class="info-wrap">
                                <div class="highlights-icon-style-1">
                                    <img src="assets/images/services/dance-floor.svg" alt="Dance Floor Platforms">
                                </div>
                                <h3 class="fw-extra-bold mb-0">Dance Floor, Platforms</h3>
                            </div>
                            <div class="img-wrap">
                                <img src="assets/images/services/icon-pattern.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 services-item-wrap">
                        <div class="highlights-item-3 text-decoration-none position-relative d-flex flex-column gap-20 px-30 px-lg-40 py-40 py-lg-50">
                            <div class="info-wrap">
                                <div class="highlights-icon-style-1">
                                    <img src="assets/images/services/aluminium-stage.svg" alt="Aluminium stages">
                                </div>
                                <h3 class="fw-extra-bold mb-0">Aluminium stages</h3>
                            </div>
                            <div class="img-wrap">
                                <img src="assets/images/services/icon-pattern.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 services-item-wrap">
                        <div class="highlights-item-3 text-decoration-none position-relative d-flex flex-column gap-20 px-30 px-lg-40 py-40 py-lg-50">
                            <div class="info-wrap">
                                <div class="highlights-icon-style-1">
                                    <img src="assets/images/services/platforms.svg" alt="Platforms">
                                </div>
                                <h3 class="fw-extra-bold mb-0">Platforms</h3>
                            </div>
                            <div class="img-wrap">
                                <img src="assets/images/services/icon-pattern.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 services-item-wrap">
                        <div class="highlights-item-3 text-decoration-none position-relative d-flex flex-column gap-20 px-30 px-lg-40 py-40 py-lg-50">
                            <div class="info-wrap">
                                <div class="highlights-icon-style-1">
                                    <img src="assets/images/services/glassware.svg" alt="Cutlery Glassware">
                                </div>
                                <h3 class="fw-extra-bold mb-0">Cutlery, Glassware</h3>
                            </div>
                            <div class="img-wrap">
                                <img src="assets/images/services/icon-pattern.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Highlights Section ======================-->


        <!--Counter Section ======================-->
        <div class="counter-section pt-50 pt-lg-100 pt-xxl-130">
            <div class="container">
                <div class="event-counter event-counter-style-2">
                    <div class="row row-cols-2 gy-lg-0 gy-4 justify-content-between">
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <span class="odometer text-primary display-2" data-count-to=30></span>
                                <h3 class="fw-extra-bold d-flex flex-column custom-jakarta">
                                    <span>Event</span><span>Artists</span>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <span class="odometer text-primary display-2" data-count-to=10></span>
                                <h3 class="fw-extra-bold d-flex flex-column custom-jakarta">
                                    <span>Event</span><span>Stages</span>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <span class="odometer text-primary display-2" data-count-to=13></span>
                                <h3 class="fw-extra-bold d-flex flex-column custom-jakarta">
                                    <span>Days</span><span>Concert</span>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <span class="odometer text-primary display-2" data-count-to=8></span>
                                <h3 class="fw-extra-bold d-flex flex-column custom-jakarta">
                                    <span>Event</span><span>Sponsor</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Counter Section ======================-->


        <!--Sponsor Section ======================-->
        <section id="sponsors" class="sponsor-section sponsor-2 position-relative pt-50 pt-lg-100 pt-xxl-130">

            <div class="container">
                <div class="row gy-4 gy-lg-0 align-items-lg-end justify-content-lg-between mb-40 mb-lg-70">
                    <div class="col-lg-4">
                        <div class="section-title wow fadeInRight">
                            <span class="fs-3 straight-line-wrapper fw-semibold position-relative custom-roboto"><span
                                    class="straight-line"></span>The Power Behind Us</span>
                            <h2 class="title display-3 fw-extra-bold mb-n2 text-opacity custom-roboto">Cadence</h2>
                            <h3 class="sub-title display-3 fw-extra-bold primary-text-shadow custom-roboto">Contributors
                            </h3>
                        </div>
                        <!-- section-title -->
                    </div>
                    <div class="col-lg-5">
                        <div class="highlights-text wow fadeInLeft">
                            <p class="custom-jakarta custom-font-style-2 text-lg-end mb-2">
                                Lion Events is a Total Event Management Solutions company specializing in social and corporate gatherings.
                                Lion Events creates one-of-a-kind, unforgettable events for you and your guests also we can provide many services.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- row -->

                <div class="row gy-4 gy-lg-0 justify-content-lg-between mb-60 mb-lg-100">
                    <div class="col-lg-3">
                        <div class="sponsors-type">
                            <h2 class="fw-extra-bold mb-0">Our Clients</h2>
                        </div>
                    </div>
                    <!-- col-3 -->
                    <div class="col-lg-8">
                        <div class="row row-cols-2 row-cols-md-2 row-cols-lg-3 g-20 g-lg-30 align-items-center">
                            <div class="col">
                                <a style="height: 108px" class="sponsor-wrapper">
                                    <img style="filter:unset" src="assets/images/home/OurClients/Dots_Bay.png" class="img-fluid"
                                        alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a style="height: 108px" class="sponsor-wrapper">
                                    <img style="filter:unset" src="assets/images/home/OurClients/Mas.png" class="img-fluid" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a  style="height: 108px" class="sponsor-wrapper">
                                    <img style="filter:unset" src="assets/images/home/OurClients/Outpost.png" class="img-fluid"
                                        alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a  style="height: 108px" class="sponsor-wrapper">
                                    <img style="filter:unset" src="assets/images/home/OurClients/Salt.png" class="img-fluid" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a style="height: 108px" class="sponsor-wrapper">
                                    <img style="filter:unset" src="assets/images/home/OurClients/The_Doctors_House.png" class="img-fluid"
                                        alt="img">
                                </a>
                            </div>
                        </div>
                        <!-- row -->
                    </div>
                    <!-- col-8 -->
                </div>
                <!-- row -->
            </div>
        </section>
        <!--Sponsor Section ======================-->


        <!--Ticket Section ======================-->
        <section class="ticket-section about-ticket pt-50 pt-lg-100 pt-xxl-130">
            <div class="container">
                <div class="ticket-wrapper position-relative parallax">
                    <div class="ticket-inner">
                        <h2 class="display-3 text-gradient no-stroke fw-extra-bold custom-jakarta mb-20">
                            Early Bird Tickets Available!
                        </h2>
                        <h3 class="custom-jakarta ticket-text fw-semibold">Don't miss this extraordinary celebration of
                            music and create memories that will last a lifetime.</h3>
                        <!-- <a href="/Packages" class="btn btn-gradient d-inline-flex align-items-center gap-2 mt-4 mt-lg-40"
                            aria-label="buttons"><span class="buttons-logo"><svg width="25" height="25">
                                    <use xlink:href="#buttons-logo"></use>
                                </svg></span>Book Your Package Now</a> -->
                    </div>
                </div>
            </div>

        </section>
        <!--Ticket Section ======================-->


        <!--Direction Section ======================-->
        <section id="direction" class="direction-section direction-1 position-relative pt-50 pt-lg-100 pt-xxl-130">
            <div class="container">
                <div class="direction-wrapper">
                    <div class="row justify-content-between align-items-lg-center gy-40 gy-lg-0">
                        <div class="col-lg-5">
                            <div class="direction-left-content wow fadeInRight">
                                <h2 class="display-5 fw-extra-bold custom-jakarta">
                                    Get Direction to Lion Events
                                </h2>
                                <div
                                    class="d-flex flex-column flex-lg-row gap-5 justify-content-lg-between align-items-lg-center mt-30 mt-lg-50">
                                    <div class="direction-details">
                                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"><span
                                                class="straight-line"></span>Venue</span>
                                        <div class="mt-10 mt-lg-30">
                                            <h4 class="custom-jakarta fw-extra-bold">Lion Events</h4>
                                            <h4 class="custom-jakarta fw-normal">No 123, Matara.</h4>
                                        </div>
                                    </div>
                                    <div class="direction-details">
                                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"><span
                                                class="straight-line"></span>Time</span>
                                        <div class="mt-10 mt-lg-30">
                                            <h4 class="custom-jakarta fw-normal">Open</h4>
                                            <h4 class="custom-jakarta fw-normal">Monday - Sunday 8:30AM - 17:30PM</h4>
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
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3968.2491117824056!2d80.5437877758748!3d5.960380994024339!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae1391dbd1d3541%3A0x4aa69c0a9c2a4ca0!2scodeaisys.com!5e0!3m2!1sen!2slk!4v1709724223273!5m2!1sen!2slk" width="100%" height="450" style="border:0; border-radius: 18px" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </span>
                            </div>

                            <!-- Modal-Map -->
                            <div class="modal modal-fullscreen routing-map-modal fade" id="RoutingMapModal"
                                tabindex="-1" aria-labelledby="RoutingMapLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="RoutingMapLabel">No 169, Mahapala Waththa, Thudava , Matara.
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="RoutingMap"></div>
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


        <!--Contact Section ======================-->
        <section class="contact-section contact-1 mt-50 mt-lg-100 mt-xxl-130">
            <div class="container">
                <div class="contact-wrapper pt-60 pt-lg-100 pt-xxl-120 pb-40 pb-lg-50 pb-xxl-70">
                    <div class="row gy-lg-0 gy-50">
                        <div class="col-lg-7">
                            <span
                                class="fs-3 straight-line-wrapper fw-semibold position-relative custom-heading-color-1"><span
                                    class="straight-line"></span>Contact Us</span>
                            <div class="mt-20 mt-md-30 mt-lg-40 mt-xxl-60">
                                <a href="mailto:4aholdingpvt@gmail.com"
                                    class="text-decoration-none display-6 custom-jakarta fw-extra-bold">lionevents.com</a>
                                <div class="contact-details custom-heading-color-2 mt-10 mt-lg-30">
                                    <h3 class="custom-jakarta fw-bold mb-20">Lion Events</h3>
                                    <h3 class="custom-jakarta fw-semibold mb-5">No 123, Matara</h3>
                                    <h3 class="custom-jakarta fw-bold">+94 712345678</h3>
                                    <ul
                                        class="list-unstyled contact-icons d-flex align-items-center gap-20 gap-lg-30 mt-4 mt-lg-40 mb-0">
                                        <li><a href="#" aria-label="icons"><svg width="30" height="30">
                                                    <use xlink:href="#social-share-icon-1"></use>
                                                </svg></a></li>
                                        <li><a href="#" aria-label="icons"><svg width="30" height="30">
                                                    <use xlink:href="#social-share-icon-2"></use>
                                                </svg></a></li>
                                        <li><a href="#" aria-label="icons"><svg width="28" height="26">
                                                    <use xlink:href="#social-share-icon-3"></use>
                                                </svg></a></li>
                                        <li><a href="#" aria-label="icons"><svg width="30" height="31">
                                                    <use xlink:href="#social-share-icon-4"></use>
                                                </svg></a></li>
                                        <li><a href="#" aria-label="icons"><svg width="30" height="31">
                                                    <use xlink:href="#social-share-icon-5"></use>
                                                </svg></a></li>
                                    </ul>
                                    <!-- social-share-icons -->
                                </div>
                            </div>
                        </div>
                        <!-- col-5 -->
                        <div class="col-lg-4">
                            <span class="fs-3 straight-line-wrapper fw-semibold position-relative">
                                <!-- <span class="straight-line custom-heading-color-1"></span> -->
                            </span>
                            <div class="contact-details mt-20 mt-md-30 mt-lg-40 mt-xxl-60">
                                <h3
                                    class="display-6 custom-jakarta fw-semibold custom-heading-color-1 border-bottom border-3">
                                    About Us</h3>
                                <ul class="list-unstyled contact-lists d-flex flex-column gap-2 mt-20 mt-lg-30 mb-0">
                                    <li><a href="/Packages" target="_blank"
                                            class="text-decoration-none custom-heading-color-2">Packages</a></li>
                                    <li><a href="#events" target="_blank"
                                            class="text-decoration-none custom-heading-color-2">Services</a></li>
                                    <li><a href="/Gallery" target="_blank"
                                            class="text-decoration-none custom-heading-color-2">Gallery</a></li>
                                    <li><a href="/Events" target="_blank"
                                            class="text-decoration-none custom-heading-color-2">Events</a></li>
                                    <li><a href="/Contact" target="_blank"
                                            class="text-decoration-none custom-heading-color-2">Contact Us</a></li>
                                </ul>
                                <!-- social-share-icons -->
                            </div>
                        </div>
                        <!-- col-4 -->
                    </div>
                </div>
            </div>
        </section>
        <!--Contact Section ======================-->


    </div>
@endsection
