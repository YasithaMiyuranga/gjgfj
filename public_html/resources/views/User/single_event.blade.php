@extends('layouts.userapp')

@section('content')

    <style>
        .bg-white-important {
            background-color: #ffffff !important;
        }

        .bg-yellow-important {
            background-color: #FFFF00 !important;
        }
    </style>
    <!-- Start Hero Section -->
    <section class="hero-section hero-8 position-relative">
        <div class="hero-wrapper mx-auto position-relative parallax"
            style="--bg-parallax-image: url('{{ asset($event->banner) }}');background-repeat:no-repeat">
            {{-- <div class="hero-8-image">
                <img src="{{ asset($event->banner) }}" class="img-fluid" alt="img">
            </div> --}}
            <div class="container">
                <div class="hero-8-inner">
                    <h1 class="hero-heading-text text-white text-uppercase custom-poppins mb-20">{{ $event->event_name }}
                    </h1>
                    @if ($event->sponsors->count() > 0)
                        <div class="mb-40 mb-lg-0 hero-brand-images">
                            <h3 class="fst-italic fw-semibold mb-3">Powered by</h3>
                            <div class="d-flex flex-md-wrap align-items-center gap-4 gap-lg-5">
                                @foreach ($event->sponsors as $sponsor)
                                    <a href="#" aria-label="brand-image">
                                        <img src="{{ asset($sponsor->sponsor_logo) }}" class="img-fluid"
                                            style="width: 100px; height: 100px;" alt="Sponsor"></td>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="event-info event-info-outside event-down-sm custom-inner-bg wow slideInUp">
                <div class="event-inner">
                    <div class="row align-items-center justify-content-between gy-xl-0 gy-4">
                        {{-- date done --}}
                        <div class="col-md-4 col-xl-3 col-lg-4">
                            <div class="event-content" id="countdown" data-event-date="{{ $event->event_date }}">
                                <h2 id="event-date"></h2>
                                <h4 id="event-time"></h4>
                            </div>
                        </div>
                        {{-- done --}}
                        <div class="col-md-5 col-xl-4 col-lg-5">
                            <div class="event-content ms-xxl-5">
                                <h2>{{ $event->event_name }}</h2>
                                <h3>{{ $event->location }}</h3>
                                {{-- <h4>Mahapala Waththa, Thudawa, Matara</h4> --}}
                            </div>
                        </div>
                        <div class="col-md-3 col-xl-2 col-lg-3">
                            <div class="ms-xxl-30">
                                <span class="event-odometer-heading fs-2 odometer" data-count-to=280></span>
                                <h4>Attending</h4>
                            </div>
                        </div>
                        <div class="col-md-3 col-xxl-2 col-xl-3 col-lg-3">
                            <div>
                                <a href="#schedule" class="btn btn-gradient d-inline-flex align-items-center"
                                    aria-label="buttons"><span class="contact-plus-icon"><svg width="41" height="34">
                                            <use xlink:href="#contact-plus-icon"></use>
                                        </svg></span> Interested</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Section -->
    <!-- Start Count Down Section -->
    {{-- half data set done --}}
    <div class="countdown-section pb-40 pb-lg-60 pb-xl-80 pt-300 pt-md-150 pt-lg-180 position-relative"
        data-event-date={{ $event->event_date }}>
        <div class="container">
            <div class="countdown wow fadeInUp">
                <div class="row row-cols-2 row-cols-lg-3 row-cols-xl-4 justify-content-between align-items-center">
                    <div class="col">
                        <div class="countdown-item">
                            <span class="countdown-number primary-text-shadow" id="days"></span>
                            <span class="countdown-label text-opacity">Days</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="countdown-item">
                            <span class="countdown-number primary-text-shadow" id="hours">00</span>
                            <span class="countdown-label text-opacity">Hours</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="countdown-item">
                            <span class="countdown-number primary-text-shadow" id="minutes">00</span>
                            <span class="countdown-label text-opacity">Minutes</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="countdown-item">
                            <span class="countdown-number primary-text-shadow" id="seconds">00</span>
                            <span class="countdown-label text-opacity">Seconds</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Count Down Section -->
    <!-- Start Ticket Section -->
    <section id="ticket" class="ticket-section ticket-1 pb-lg-100 pb-xxl-130 position-relative parallax">
        <div class="container">
            <div class="section-title section-title-style-2 mb-30 mb-lg-40 mb-xxl-50 wow fadeInDown">
                <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                        class="straight-line"></span>Ticket</span>
                <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                    <span class="mb-n2 text-opacity text-capitalize ">{{ $event->event_name }}</span>
                    <span class="sub-title fw-extra-bold primary-text-shadow custom-roboto">Admissions</span>
                </h2>
            </div>
            <div class="ticket-content">
                <div class="d-flex flex-column flex-xl-row gap-50 gap-xl-30 align-items-xl-center">
                    <div class="ticket-content-1">
                        <div class="ticket-form-wrapper custom-inner-bg">
                            {{-- done --}}
                            @foreach ($ticketDetails as $ticketDetail)
                                @if ($ticketDetail->number_of_tickets > $ticketDetail->baught_count)
                                    <div class="ticket-form ticket-form-1 text-capitalize form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios"
                                            id="exampleRadios1" value="option1" checked>
                                        <label class="form-check-label d-flex align-items-center justify-content-between"
                                            for="exampleRadios1">
                                            <span
                                                class="text-opacity">{{ $ticketDetail->tickets_category }}</span><span>{{ $ticketDetail->currency }}{{ $ticketDetail->price }}</span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach



                            {{-- <div class="ticket-form ticket-form-2 form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                <label class="form-check-label d-flex align-items-center justify-content-between" for="exampleRadios2">
                                <span class="text-opacity">VIP Experience</span><span>$100</span>
                                </label>
                            </div>
                            <div class="ticket-form ticket-form-3 form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">
                                <label class="form-check-label d-flex align-items-center justify-content-between" for="exampleRadios3">
                                <span class="text-opacity">Student Discount</span><span>$25</span>
                                </label>
                            </div> --}}
                        </div>
                        <p class="extra-small fw-semibold d-flex justify-content-lg-end">Sales close: Sat, Jul 22, 8:00 AM
                            (EST).</p>
                        <div class="d-flex gap-3 justify-content-between">

                            {{-- <div class="ticket-amounts d-flex align-items-center gap-0 gap-lg-3">
                                <span class="ticket-icon dash-icon"><svg width="16" height="16"><use xlink:href="#dash-icon"></use></svg></span>
                                <span class="input-values"><input type="text" name="input-value" value="1" class="input-number"></span>
                                <span class="ticket-icon plus-icon"><svg width="16" height="16"><use xlink:href="#plus-icon"></use></svg></span>
                            </div>						 --}}
                            <div class="text-lg-end">



                                <a id="buyTicketsButton" data-bs-toggle="modal" data-bs-target="#ticketModal"
                                    class="btn btn-outline-primary d-inline-flex align-items-center gap-2"
                                    aria-label="buttons"><span class="buttons-logo"><svg width="25" height="25">
                                            <use xlink:href="#buttons-logo"></use>
                                        </svg></span> Buy Tickets</a>




                                {{-- check user login or not --}}
                                {{-- @if (Auth::user())
                                    <a id="buyTicketsButton" data-bs-toggle="modal" data-bs-target="#ticketModal"
                                        class="btn btn-outline-primary d-inline-flex align-items-center gap-2"
                                        aria-label="buttons"><span class="buttons-logo"><svg width="25" height="25">
                                                <use xlink:href="#buttons-logo"></use>
                                            </svg></span> Buy Tickets</a>
                                @else
                                    <a data-bs-toggle="modal" data-bs-target="#loginModal"
                                        class="btn btn-outline-primary d-inline-flex align-items-center gap-2"
                                        aria-label="buttons"><span class="buttons-logo"><svg width="25"
                                                height="25">
                                                <use xlink:href="#buttons-logo"></use>
                                            </svg></span> Buy Tickets</a>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                    <div class="ticket-content-2 position-relative parallax">
                        <div class="ticket-content-2-inner">
                            <div class="swiper ticket-swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="p-30">
                                            <div
                                                class="d-flex flex-wrap align-items-center justify-content-between justify-content-lg-start gap-lg-20 mb-5 mb-lg-60">
                                                <div class="ticket-images">
                                                    <img class="ticket-icon-1"
                                                        src="{{ asset('assets/images/home-1/ticket-icon-1.png') }}"
                                                        alt="img">
                                                    <img class="ticket-icon-2 ms-n3"
                                                        src="{{ asset('assets/images/home-1/ticket-icon-2.png') }}"
                                                        alt="img">
                                                    <img class="ticket-icon-3 ms-n3"
                                                        src="{{ asset('assets/images/home-1/ticket-icon-3.png') }}"
                                                        alt="img">
                                                </div>
                                                <h4 class="fw-normal">+<span class="odometer" data-count-to=352></span>
                                                    Attending</h4>
                                            </div>
                                            <h2 class="display-6 fw-extra-bold text-uppercase mb-0"><span>Secure Your Spot
                                                    Now</span></h2>
                                            <a href="#" class="ticket-arrow arrow-up-right"><svg width="32"
                                                    height="32">
                                                    <use xlink:href="#arrow-up-right"></use>
                                                </svg></a>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="py-4 ps-30 pe-20">
                                            <h2 class="mb-0 d-flex gap-2 gap-lg-3 align-items-center">
                                                <span class="fs-100 fw-extra-bold">248</span>
                                                <span class="fw-extra-bold fs-1">Seats Available</span>
                                            </h2>
                                            <a href="#" class="ticket-arrow arrow-up-right"><svg width="32"
                                                    height="32">
                                                    <use xlink:href="#arrow-up-right"></use>
                                                </svg></a>
                                            <div class="progress mt-50">
                                                <div class="progress-bar" style="width: 73%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ticket-swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ticket-content-3 d-flex flex-lg-column gap-3 gap-lg-4">
                        <div class="brand custom-inner-bg">
                            <h2 class="display-6 fw-extra-bold mb-0"><span class="odometer" data-count-to=30></span>+</h2>
                            <h2 class="fs-1 fw-light mb-0 text-opacity">Brands</h2>
                        </div>
                        <div class="brand custom-inner-bg">
                            <h2 class="display-6 fw-extra-bold mb-0"><span class="odometer" data-count-to=120></span>+
                            </h2>
                            <h2 class="fs-1 fw-light mb-0 text-opacity">Artworks</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Ticket Section -->
    <!-- Start About Section -->
    <section class="about-section about-1 py-50 py-lg-80 pb-xxl-100">
        <div class="container">
            <div class="row gy-50 gy-lg-0 gx-80 justify-content-lg-between">
                <div class="col-lg-5">
                    <div class="wow fadeInRight">
                        <div class="section-title section-title-style-2 mb-4 mb-lg-30 mb-xxl-40">
                            <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                    class="straight-line"></span>About The Event</span>
                            <h2 class="title display-3 fw-extra-bold mb-n2 d-flex flex-column">
                                <span class="mb-n2 text-opacity">Soulful</span>
                                <span class="sub-title fw-extra-bold primary-text-shadow custom-roboto">Symphony</span>
                            </h2>
                        </div>
                        <p class="custom-sans custom-font-style-1 mb-4 mb-lg-30">
                            Experience Harmonia: where melodies transcend boundaries. Immerse in captivating performances
                            that ignite the stage. Unleash your musical senses and embrace rhythmic bliss.
                        </p>
                        <p class="custom-sans custom-font-style-1">
                            Don't miss this extraordinary celebration of music and create memories that will last a
                            lifetime.
                        </p>

                        {{-- @if (Auth::user())
                            <a id="buyTicketsButton" data-bs-toggle="modal" data-bs-target="#ticketModal"
                                class="btn btn-gradient d-inline-flex align-items-center gap-2 mt-4 mt-lg-30 mt-xxl-40"
                                aria-label="buttons"><span class="buttons-logo"><svg width="25" height="25">
                                        <use xlink:href="#buttons-logo"></use>
                                    </svg></span>Get Ticket</a>
                        @else
                            <a data-bs-toggle="modal" data-bs-target="#loginModal"
                                class="btn btn-gradient d-inline-flex align-items-center gap-2 mt-4 mt-lg-30 mt-xxl-40"
                                aria-label="buttons"><span class="buttons-logo"><svg width="25" height="25">
                                        <use xlink:href="#buttons-logo"></use>
                                    </svg></span> Get Ticket</a>
                        @endif --}}

                        <a id="buyTicketsButton" data-bs-toggle="modal" data-bs-target="#ticketModal"
                            class="btn btn-gradient d-inline-flex align-items-center gap-2 mt-4 mt-lg-30 mt-xxl-40"
                            aria-label="buttons"><span class="buttons-logo"><svg width="25" height="25">
                                    <use xlink:href="#buttons-logo"></use>
                                </svg></span>Get Ticket</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content-wrapper position-relative wow fadeInLeft">
                        <div class="about-image-1 position-relative">
                            <div class="about-image-wrapper">
                                <img src="{{ asset('assets/images/home-1/about-image-1.jpg') }}" class="img-fluid"
                                    alt="img">
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
                            <img src="{{ asset('assets/images/home-1/ellipse-1.png') }}" class="img-fluid"
                                alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section -->
    <!-- Start Line Up Section -->
    @if ($event->artists->count() > 0)
        <section id="line-up" class="lineup-section lineup-1 pt-60 pt-lg-0 mb-20 mb-lg-30 mb-xxl-40">
            <div class="lineup-contents custom-inner-bg bg-lg py-30 py-lg-50 position-relative">
                <div class="container">
                    <div class="row gx-80 gy-30">
                        <div class="col-lg-7">
                            <div class="swiper-custom-progress position-relative wow fadeInRight">
                                <div class="swiper lineup-swiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($event->artists as $artist)
                                            <div class="swiper-slide">
                                                <div class="lineup-image-wrapper position-relative">
                                                    <div class="lineup-image">
                                                        <img src="{{ asset($artist->image) }}" class="img-fluid"
                                                            alt="lineup-image">
                                                    </div>
                                                    <div class="lineup-image-hover">
                                                        <p class="author-name">{{ $artist->artist_name }}</p>
                                                        <div class="line-up-hover-content">
                                                            {{-- <h5 class="fw-medium mb-20">Genere : <span class="text-uppercase">pop</span></h5> --}}
                                                            <ul
                                                                class="list-unstyled line-up-icons d-flex align-items-center gap-3 gap-lg-20 mb-0">
                                                                <li><a href="#" class="facebook-icon"><svg
                                                                            width="20" height="20">
                                                                            <use xlink:href="#facebook-icon"></use>
                                                                        </svg></a></li>
                                                                <li><a href="#" class="instagram-icon"><svg
                                                                            width="20" height="20">
                                                                            <use xlink:href="#instagram-icon"></use>
                                                                        </svg></a></li>
                                                                <li><a href="#" class="youtube-icon"><svg
                                                                            width="20" height="20">
                                                                            <use xlink:href="#youtube-icon"></use>
                                                                        </svg></a></li>
                                                                <li><a href="#" class="spotify-icon"><svg
                                                                            width="20" height="20">
                                                                            <use xlink:href="#spotify-icon"></use>
                                                                        </svg></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
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
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="lineup-right-content mt-60 mt-lg-0 wow fadeInLeft">
                                <div class="section-title section-title-style-2 mb-4 mb-lg-30 mb-xxl-40">
                                    <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                            class="straight-line"></span>Line-Up</span>
                                    <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                                        <span class="mb-n2 text-opacity">Rhythm</span>
                                        <span class="sub-title fw-extra-bold primary-text-shadow">Revelations</span>
                                    </h2>
                                </div>
                                <p class="custom-sans custom-font-style-1 mb-4 mb-lg-30">
                                    Unleash the rhythm with an extraordinary lineup. Get ready for a musical extravaganza that
                                    will captivate your senses.
                                </p>
                                <p class="custom-sans custom-font-style-1">
                                    Experience the magic of harmonious melodies in a night to remember.
                                </p>

                                <div class="mt-20 mt-lg-0">
                                    <a href="#"
                                        class="download-link d-flex align-items-center justify-content-lg-end gap-30"
                                        aria-label="buttons">See More<span class="ticket-arrow arrow-up-right"><svg
                                                width="32" height="32">
                                                <use xlink:href="#arrow-up-right"></use>
                                            </svg></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ellipse-image-2">
                    <img src="{{ asset('assets/images/home-1/ellipse-2.png') }}" class="img-fluid" alt="img">
                </div>
            </div>
        </section>
    @endif
    <x-line-up-banner />
    <!-- End Line Up Section -->
    <!-- Start Highlight Section -->
    <section class="highlight-section highlight-1 py-50 py-lg-100 py-xxl-120 mt-20 mt-lg-40" data-bs-theme="dark">
        <div class="container position-relative">
            <div class="ellipse-image-1">
                <img src="{{ asset('assets/images/home-1/ellipse-1.png') }}" alt="ellipse-1">
            </div>
            <div class="row gy-4 gy-lg-0 align-items-lg-end justify-content-lg-between mb-30 mb-lg-70">
                <div class="col-lg-5">
                    <div class="section-title section-title-style-2 wow fadeInRight">
                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                class="straight-line"></span>Highlights</span>
                        <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                            <span class="mb-n2 text-opacity">Music</span>
                            <span class="sub-title fw-extra-bold primary-text-shadow">Extravaganza</span>
                        </h2>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="highlights-text wow fadeInLeft">
                        <p class="custom-sans custom-font-style-1 text-lg-end mb-2">
                            Immerse in mesmerizing performances,vibrant soundscapes,and interactive art at our music
                            extravaganza. Experience a festival atmosphere like no other, where unforgettable moments.
                        </p>
                    </div>
                </div>
            </div>
            <div class="highlight-swiper">
                <div class="row highlight-wrapper">
                    <div class="col-4">
                        <div
                            class="highlights-item position-relative d-flex flex-column gap-20 px-30 py-40 px-xl-40 py-xl-60">
                            <div class="highlights-icon">
                                <img src="{{ asset('assets/images/home-1/highlights-icon-1.png') }}" alt="img">
                            </div>
                            <h2 class="fw-extra-bold mb-0">Main Stage Extravaganza</h2>
                        </div>
                    </div>
                    <div class="col-4">
                        <div
                            class="highlights-item position-relative d-flex flex-column gap-20 px-30 py-40 px-xl-40 py-xl-60 active">
                            <div class="highlights-icon">
                                <img src="{{ asset('assets/images/home-1/highlights-icon-2.png') }}" alt="img">
                            </div>
                            <h2 class="fw-extra-bold mb-0">Immersive Sound and Lighting</h2>
                        </div>
                    </div>
                    <div class="col-4">
                        <div
                            class="highlights-item position-relative d-flex flex-column gap-20 px-30 py-40 px-xl-40 py-xl-60">
                            <div class="highlights-icon">
                                <img src="{{ asset('assets/images/home-1/highlights-icon-3.png') }}" alt="img">
                            </div>
                            <h2 class="fw-extra-bold mb-0">Exquisite Food & Drinks</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Highlight Section -->
    <!-- Start Event Shedule -->
    @if ($event->agendas->count() > 0)
        <section id="schedule" class="schedule-section schedule-1 py-50 py-lg-100 pt-xxl-120 position-relative ">
            <div class="container">
                <div class="row g-70">
                    <div class="col-lg-4">
                        <div class="schedule-left-content wow fadeInRight">
                            <div class="section-title section-title-style-2 mb-30 mb-lg-40 mb-xxl-60">
                                <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                        class="straight-line"></span>Schedule</span>
                                <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                                    <span class="mb-n2 text-opacity">{{ ucfirst($event->event_name) }}</span>
                                    <span class="sub-title fw-extra-bold primary-text-shadow">Agenda</span>
                                </h2>
                            </div>
                            <p class="custom-sans custom-font-style-1">
                                {{ $event->description }}
                            </p>
                            <a href="{{ route('useradmin.agenda_pdf', $event->eid) }}"
                                class="download-link d-flex align-items-center gap-40" aria-label="buttons">
                                Download Agenda
                                <span class="ticket-arrow arrow-down-right">
                                    <svg width="36" height="36">
                                        <use xlink:href="#arrow-down-right"></use>
                                    </svg>
                                </span>
                            </a>
                            <div class="schedule-image bg-mask">
                                <img src="{{ asset('assets/images/home-1/schedule-imag') }}e.png" class="img-fluid"
                                    alt="image">
                            </div>

                            <div class="ellipse-image-1">
                                <img src="{{ asset('assets/images/home-1/ellipse-1.png') }}" class="img-fluid"
                                    alt="img">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="schedule-right-content position-relative wow fadeInLeft">
                            <div class="ellipse-image-2">
                                <img src="{{ asset('assets/images/home-1/ellipse-2.png') }}" class="img-fluid"
                                    alt="img">
                            </div>
                            <ul class="schedule-tabs custom-inner-bg nav nav-pills mb-50 mb-lg-70 d-flex justify-content-center"
                                id="pills-tab" role="tablist">
                                @foreach ($event->agendas as $agenda)
                                    <li class="nav-item" role="presentation">
                                        <button class="schedule-button" id="day-{{ $loop->iteration }}-tab"
                                            data-bs-toggle="pill" data-bs-target="#day-{{ $loop->iteration }}"
                                            type="button" role="tab" aria-controls="day-{{ $loop->iteration }}"
                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                            <span class="fs-3 fw-extra-bold mb-1">{{ $agenda->date_name }}</span>
                                            <span class="fs-5 fw-semibold mb-0">{{ $agenda->date }}</span>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                @foreach ($event->agendas as $agenda)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                        id="day-{{ $loop->iteration }}" role="tabpanel"
                                        aria-labelledby="day-{{ $loop->iteration }}-tab" tabindex="0">
                                        <ul class="schedule-tabs-content list-unstyled d-flex flex-column gap-30">
                                            @foreach ($agenda->agendaDetails as $agendaDetail)
                                                <li class="d-flex flex-column flex-lg-row gap-1 gap-lg-70 gap-xxl-90">
                                                    <h2 class="fw-extra-bold schedule-time text-opacity">
                                                        {{ date('h:i A', strtotime($agendaDetail->time)) }}</h2>
                                                    <div>
                                                        <h2 class="fw-semibold text-opacity">{{ $agendaDetail->title }}
                                                        </h2>
                                                        <p class="custom-sans custom-font-style-1">
                                                            {{ $agendaDetail->description ?? '' }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    @endif
    <!-- End Event Shedule -->
    <!-- Start Sponser List Section -->
    <section id="sponsor"
        class="sponsor-section sponsor-1 bg-lg custom-inner-bg position-relative pt-50 pt-lg-100 pt-xxl-120 pb-30 pb-lg-80 pb-xxl-100">
        <div class="ellipse-image-1">
            <img src="{{ asset('assets/images/home-1/ellipse-1.png') }}" alt="ellipse-1">
        </div>
        <div class="container">
            <div class="row gy-4 gy-lg-0 align-items-lg-end justify-content-lg-between mb-30 mb-lg-70">
                <div class="col-lg-4">
                    <div class="section-title section-title-style-2 wow fadeInRight">
                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                class="straight-line"></span>The Power Behind Us</span>
                        <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                            <span class="mb-n2 text-opacity">Cadence</span>
                            <span class="sub-title fw-extra-bold primary-text-shadow">Contributors</span>
                        </h2>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="highlights-text wow fadeInLeft">
                        <p class="custom-sans custom-font-style-1 text-lg-end mb-2">
                            Elevating the Music. Our valued partners and sponsors play a pivotal role in bringing our vision
                            to life. With their support, we orchestrate an unforgettable music celebration that resonates.
                        </p>
                    </div>
                </div>
            </div>
            <div class="brand-logos position-relative wow slideInUp d-none d-md-block">
                <div class="swiper brand-2-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($event->sponsors as $sponsor)
                            <div class="swiper-slide">
                                <div class="brand-image position-relative">
                                    <a href="#" aria-label="brand-image">
                                        <img src="{{ asset($sponsor->sponsor_logo) }}" class="img-fluid"
                                            style="width: 100px; height: 100px;" alt="Sponsor"></td>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                <a href="#">
                                    <img src="{{ asset('assets/images/home-2/brand-2.png') }}" class="img-fluid"
                                        alt="brand-image">
                                </a>
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                <a href="#">
                                    <img src="{{ asset('assets/images/home-2/brand-3.png') }}" class="img-fluid"
                                        alt="brand-image">
                                </a>
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                <a href="#">
                                    <img src="{{ asset('assets/images/home-2/brand-4.png') }}" class="img-fluid"
                                        alt="brand-image">
                                </a>
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                <a href="#">
                                    <img src="{{ asset('assets/images/home-2/brand-5.png') }}" class="img-fluid"
                                        alt="brand-image">
                                </a>
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                <a href="#">
                                    <img src="{{ asset('assets/images/home-2/brand-3.png') }}" class="img-fluid"
                                        alt="brand-image">
                                </a>
                            </div>
                        </div>
                        <!-- swiper-slide-->
                        <div class="swiper-slide">
                            <div class="brand-image position-relative">
                                <a href="#">
                                    <img src="{{ asset('assets/images/home-2/brand-2.png') }}" class="img-fluid"
                                        alt="brand-image">
                                </a>
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
                        <a href="#">
                            <img src="{{ asset('assets/images/home-2/brand-2.png') }}" class="img-fluid"
                                alt="brand-image">
                        </a>
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                        <a href="#">
                            <img src="{{ asset('assets/images/home-2/brand-5.png') }}" class="img-fluid"
                                alt="brand-image">
                        </a>
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                        <a href="#">
                            <img src="{{ asset('assets/images/home-2/brand-3.png') }}" class="img-fluid"
                                alt="brand-image">
                        </a>
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                        <a href="#">
                            <img src="{{ asset('assets/images/home-2/brand-4.png') }}" class="img-fluid"
                                alt="brand-image">
                        </a>
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                        <a href="#">
                            <img src="{{ asset('assets/images/home-2/brand-2.png') }}" class="img-fluid"
                                alt="brand-image">
                        </a>
                    </div>
                </div>
                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                        <a href="#">
                            <img src="{{ asset('assets/images/home-2/brand-1.png') }}" class="img-fluid"
                                alt="brand-image">
                        </a>
                    </div>
                </div>

                <hr class="my-15">
                <div class="col-12">
                    <div class="brand-image position-relative">
                        <a href="#">
                            <img src="{{ asset('assets/images/home-2/brand-3.png') }}" class="img-fluid"
                                alt="brand-image">
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-30 mt-lg-60 mt-xxl-70">
                <a href="#" class="btn btn-outline-primary d-inline-flex align-items-center gap-2"
                    aria-label="buttons">Become A Sponsor<span class="arrow-up-short"><svg width="25"
                            height="25">
                            <use xlink:href="#arrow-up-short"></use>
                        </svg></span></a>
            </div>
        </div>
    </section>
    <!-- End Sponser List Section -->
    <!-- Start Gallery Section -->
    <div class="gallery-section gallery-1 py-50 py-lg-100 py-xxl-120">
        <div class="gallery-slider">
            <div class="gallery-slider-1">
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-1.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-1.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-2.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-2.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-3.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-3.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-4.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-4.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-5.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-5.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-6.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-6.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-1.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-1.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-2.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-2.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-3.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-3.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-4.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-4.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-5.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-5.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-6.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-6.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-1.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-1.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-2.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-2.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-3.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-3.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-4.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-4.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-5.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-5.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-6.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-6.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-1.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-1.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-2.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-2.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-3.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-3.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-4.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-4.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-5.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-5.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-6.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-6.jpg') }}" alt="img">
                    </a>
                </div>
            </div>
            <div class="gallery-slider-2">
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-7.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-7.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-8.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-8.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-9.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-9.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-10.jp') }}g" class="image-link">
                        <img src="{{ asset('assets/images/gallery-10.jp') }}g" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-11.jp') }}g" class="image-link">
                        <img src="{{ asset('assets/images/gallery-11.jp') }}g" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-7.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-7.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-8.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-8.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-9.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-9.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-10.jp') }}g" class="image-link">
                        <img src="{{ asset('assets/images/gallery-10.jp') }}g" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-11.jp') }}g" class="image-link">
                        <img src="{{ asset('assets/images/gallery-11.jp') }}g" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-7.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-7.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-8.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-8.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-9.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-9.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-10.jp') }}g" class="image-link">
                        <img src="{{ asset('assets/images/gallery-10.jp') }}g" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-11.jp') }}g" class="image-link">
                        <img src="{{ asset('assets/images/gallery-11.jp') }}g" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-7.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-7.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-8.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-8.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-9.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-9.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-10.jp') }}g" class="image-link">
                        <img src="{{ asset('assets/images/gallery-10.jp') }}g" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-11.jp') }}g" class="image-link">
                        <img src="{{ asset('assets/images/gallery-11.jp') }}g" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-7.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-7.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-8.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-8.jpg') }}" alt="img">
                    </a>
                </div>
                <div class="gallery-item">
                    <a href="{{ asset('assets/images/gallery-9.jpg') }}" class="image-link">
                        <img src="{{ asset('assets/images/gallery-9.jpg') }}" alt="img">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Gallery Setion -->
    <!-- Start Sponser Ads Section -->
    <section class="blog-section blog-vertical pb-50 pb-lg-80">
        <div class="container">
            <div class="row gy-4 gy-lg-0 align-items-lg-end justify-content-lg-between mb-30 mb-lg-70">
                <div class="col-lg-4">
                    <div class="section-title section-title-style-2 wow fadeInRight">
                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                class="straight-line"></span>The Power Behind Us</span>
                        <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                            <span class="mb-n2 text-opacity">Harmonia</span>
                            <span class="sub-title fw-extra-bold primary-text-shadow">Headlines</span>
                        </h2>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="highlights-text wow fadeInLeft">
                        <p class="custom-sans custom-font-style-1 text-lg-end mb-2">
                            Elevating the Music. Our valued partners and sponsors play a pivotal role in bringing our vision
                            to life. With their support, we orchestrate an unforgettable music celebration that resonates.
                        </p>
                    </div>
                </div>
            </div>
            <div class="blog-content-wrapper position-relative">
                <div class="ellipse-image-1">
                    <img src="{{ asset('assets/images/home-1/ellipse-1.png') }}" alt="ellipse-1">
                </div>
                <div class="blog-2-swiper p-10">
                    <div class="row">
                        <div class="col-4">
                            <div class="blog-content blog-content-2 custom-inner-bg">
                                <div class="row gy-4 align-items-center justify-content-between">
                                    <div class="col-12 blog-image-wrap">
                                        <div class="blog-image">
                                            <img class="image"
                                                src="{{ asset('assets/images/home-2/blog-image-1.png') }}"
                                                class="img-fluid" alt="img">
                                        </div>
                                        <div class="ads-label-wrap">
                                            <span class="label-name">ADS</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="blog-left-content">
                                            <p><span class="calendar me-10"><svg width="16" height="16">
                                                        <use xlink:href="#calendar"></use>
                                                    </svg></span>09 Aug 2023</p>
                                            <h2 class="blog-link fs-4 fw-bold"><a class="text-decoration-none"
                                                    href="blog-single-1.html">Unveils Star-Studded Lineup for Epic Comeback
                                                    Event!</a></h2>
                                            <div>
                                                <a href="blog-single-1.html"
                                                    class="download-link d-flex align-items-center gap-30"
                                                    aria-label="buttons">Read more<span
                                                        class="ticket-arrow arrow-up-right"><svg width="32"
                                                            height="32">
                                                            <use xlink:href="#arrow-up-right"></use>
                                                        </svg></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="blog-content blog-content-2 custom-inner-bg">
                                <div class="row gy-4 align-items-center justify-content-between">
                                    <div class="col-12 blog-image-wrap">
                                        <div class="blog-image">
                                            <img class="image"
                                                src="{{ asset('assets/images/home-2/blog-image-2.png') }}"
                                                class="img-fluid" alt="img">
                                        </div>
                                        <div class="ads-label-wrap">
                                            <span class="label-name">ADS</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="blog-left-content">
                                            <p><span class="calendar me-10"><svg width="16" height="16">
                                                        <use xlink:href="#calendar"></use>
                                                    </svg></span>09 Aug 2023</p>
                                            <h2 class="blog-link fs-4 fw-bold"><a class="text-decoration-none"
                                                    href="blog-single-1.html">Unveils Star-Studded Lineup for Epic Comeback
                                                    Event!</a></h2>
                                            <div>
                                                <a href="blog-single-1.html"
                                                    class="download-link d-flex align-items-center gap-30"
                                                    aria-label="buttons">Read more<span
                                                        class="ticket-arrow arrow-up-right"><svg width="32"
                                                            height="32">
                                                            <use xlink:href="#arrow-up-right"></use>
                                                        </svg></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="blog-content blog-content-2 custom-inner-bg">
                                <div class="row gy-4 align-items-center justify-content-between">
                                    <div class="col-12 blog-image-wrap">
                                        <div class="blog-image">
                                            <img class="image"
                                                src="{{ asset('assets/images/home-2/blog-image-3.png') }}"
                                                class="img-fluid" alt="img">
                                        </div>
                                        <div class="ads-label-wrap">
                                            <span class="label-name">ADS</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="blog-left-content">
                                            <p><span class="calendar me-10"><svg width="16" height="16">
                                                        <use xlink:href="#calendar"></use>
                                                    </svg></span>09 Aug 2023</p>
                                            <h2 class="blog-link fs-4 fw-bold"><a class="text-decoration-none"
                                                    href="blog-single-1.html">Unveils Star-Studded Lineup for Epic Comeback
                                                    Event!</a></h2>
                                            <div>
                                                <a href="blog-single-1.html"
                                                    class="download-link d-flex align-items-center gap-30"
                                                    aria-label="buttons">Read more<span
                                                        class="ticket-arrow arrow-up-right"><svg width="32"
                                                            height="32">
                                                            <use xlink:href="#arrow-up-right"></use>
                                                        </svg></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Sponser Ads Section -->
    <!-- Start Ticket Booking -->
    <section class="cta-section cta-1 pb-50 pb-lg-80">
        <div class="container">
            <div class="row gy-20 gy-lg-0 align-items-lg-center justify-content-lg-between">
                <div class="col-lg-4">
                    <div class="d-flex justify-content-between">
                        <h2 class="fs-180-style-2 fw-extra-bold primary-text-shadow d-flex align-items-center gap-2 mb-0">
                            <span class="odometer" data-count-to=80></span>
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
                        Get Your Tickets Today!
                    </h2>
                </div>
                <div class="col-lg-3">
                    <div class="cta-icon d-none d-lg-block ms-xl-70 ms-xxl-100">
                        <a href="#ticket" aria-label="icons">
                            <span class="arrow-up-right-big"><svg width="205" height="205">
                                    <use xlink:href="#arrow-up-right-big"></use>
                                </svg></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Ticket Booking -->
    <!-- Start Event Location -->
    <section class="subscription-section subscription-1 bg-lg custom-inner-bg position-relative mb-50 mb-lg-80">
        <div class="ellipse-image-2">
            <img src="{{ asset('assets/images/home-1/ellipse-2.png') }}" alt="img">
        </div>
        <div class="container">
            <div class="subscription-wrapper py-50 py-lg-70 py-xxl-100">
                <div class="row justify-content-between gy-40 gy-lg-0">
                    <div class="col-lg-5">
                        <div class="subscription-left-content wow fadeInRight">
                            <div class="section-title section-title-style-2 mb-4 mb-lg-5">
                                <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                        class="straight-line"></span>Schedule</span>
                                <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                                    <span class="mb-n2 text-opacity">Sonic</span>
                                    <span class="sub-title fw-extra-bold primary-text-shadow">Dispatch</span>
                                </h2>
                            </div>
                            <!-- section-title -->
                            <p class="custom-sans custom-font-style-1 mb-30">
                                Become Part of Our Harmonious Community and Receive Exclusive Updates, Special Offers, and
                                Exciting News about the Festival Straight to Your Inbox.
                            </p>
                            <form action="#">
                                <div class="subscription-form position-relative">
                                    <input type="email" class="form-control" id="subscriptionInput1"
                                        placeholder="Enter your Email">
                                    <button class="subscription-form-arrow" type="submit"><svg width="37"
                                            height="38">
                                            <use xlink:href="#subscription-form-arrow"></use>
                                        </svg></button>
                                </div>
                            </form>
                        </div>
                        <!-- subscription-left-content -->
                    </div>
                    <!-- col-5 -->

                   <!-- Event Location and Button -->
                    <div class="col-lg-5 wow fadeInLeft">
                        <h3 class="straight-line-wrapper fw-semibold position-relative mb-20">
                            <span class="straight-line"></span>{{ $event->location }}
                        </h3>

                        <div class="map-image parallax position-relative">
                            <span class="map-marker">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                            </span>

                            <div class="map-popup-content">
                                <h3>{{ $event->location }}</h3>
                                <p></p>
                                <a id="mapDirectionBtn"
                                href="#"
                                class="btn btn-primary btn-sm d-flex align-items-center justify-content-center custom-roboto gap-10 btn-map-direction"
                                data-bs-toggle="modal"
                                data-bs-target="#RoutingMapModal">
                                Get Direction
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Modal Map -->
                        <div class="modal modal-fullscreen routing-map-modal fade" id="RoutingMapModal" tabindex="-1"
                            aria-labelledby="RoutingMapLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="RoutingMapLabel">{{ $event->location }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <iframe id="RoutingMap"
                                                width="100%"
                                                height="500"
                                                style="border:0"
                                                loading="lazy"
                                                allowfullscreen
                                                referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- Modal-Map -->
                </div>
            </div>
        </div>
        {{-- Ticket Model --}}


        <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 80% !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ticketModalLabel">Select Your Seat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>








                    <form method="POST" id="ticketForm" action="{{ route('user.viewTicket', $event->eid) }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="categories" name="categories">
                            <input type="hidden" id="quantities" name="quantities">
                            <input type="hidden" id="seats" name="seats">
                            <div class="report-form-box">
                                <table class="table rounded">
                                    {{-- <thead>
                                        <tr class="fs-6">
                                            <th class="col-md-3">Category</th>
                                            <th class="text-center col-md-3">Quantity</th>
                                            <th class="text-end col-md-3">Subtotal</th>
                                        </tr>
                                    </thead> --}}


                                    @foreach ($ticketDetails as $ticket)
                                        <div>
                                            <h3>{{ $ticket->tickets_category . ' - ' . $ticket->price . ' ' . $ticket->currency }}
                                            </h3>
                                        </div>
                                        <div>
                                            <h6>Avilable : {{ $ticket->number_of_tickets }}</h6>
                                        </div>
                                        <div>
                                            Count : <span class="ticket-field-popup"
                                                data-ticket-id="{{ $ticket->id }}" class="mx-2">0</span>
                                        </div>
                                        <div>
                                            SubTotal : <span class="p-4 text-center text-body subtotal"
                                                id="subtotal-{{ $ticket->id }}">
                                                0.00

                                                </td>
                                        </div>
                                        <div>
                                            <span hidden class="text-capitalize text-muted"
                                                id="category-{{ $ticket->id }}">
                                                {{ $ticket->tickets_category }}</span>
                                        </div>
                                        <hr />
                                        <div
                                            class="p-4 bg-blue-700 bg-opacity-25 rounded-4 d-flex flex-wrap justify-content-center align-items-center gap-2">
                                            @for ($i = 0; $i < $ticket->initial_tickets_count; $i++)
                                                @php
                                                    $seatNumber = $i + 1;
                                                    $isSoldOut = in_array($seatNumber, $ticket->sold_out_seats ?? []);
                                                @endphp
                                                <button id='but{{ $ticket->tickets_category }}{{ $seatNumber }}'
                                                    value="notSelected" type="button"
                                                    onclick="select('{{ $ticket->tickets_category }}', {{ $seatNumber }}, {{ $ticket->id }}, {{ $ticket->price }}, {{ $ticket->number_of_tickets }})"
                                                    class="p-0 btn rounded-3 d-flex justify-content-center align-items-center shadow-sm
                                                    {{ $isSoldOut ? 'btn-danger' : 'btn-light bg-white' }}"
                                                    style="width:40px;aspect-ratio: 1; font-size: 10px;"
                                                    {{ $isSoldOut ? 'disabled' : '' }}>
                                                    {{ $seatNumber }}
                                                </button>
                                            @endfor

                                        </div>

                                        <hr />
                                    @endforeach




                                    <!--old Ticket Selection-->

                                    {{-- <tbody class="rounded">
                                        @foreach ($ticketDetails as $ticketDetail)
                                            <tr>
                                                <td class="p-4 text-body ">
                                                    <span class="text-capitalize text-muted"
                                                        id="category-{{ $ticketDetail->id }}">
                                                        {{ $ticketDetail->tickets_category }}</span>
                                                    <br>{{ $ticketDetail->currency }} {{ $ticketDetail->price }}
                                                    @php
                                                        $tickets_category[] = $ticketDetail->tickets_category;

                                                    @endphp
                                                </td>
                                                <td class="p-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        @if ($ticketDetail->number_of_tickets > 0)
                                                            <div class="form-wrap from-wrap-popup">
                                                                <div
                                                                    class="ticket-wrap d-flex align-items-center justify-content-center text-body">
                                                                    <button class="ticket-decrease-popup"
                                                                        onclick="decreaseQuantity({{ $ticketDetail->id }}, {{ $ticketDetail->price }})">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="16"
                                                                            fill="currentColor" class="bi bi-dash"
                                                                            viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                                                        </svg>
                                                                    </button>
                                                                    <span class="ticket-field-popup"
                                                                        data-ticket-id="{{ $ticketDetail->id }}"
                                                                        class="mx-2">0</span>
                                                                    <button class="ticket-increase-popup"
                                                                        onclick="increaseQuantity({{ $ticketDetail->id }}, {{ $ticketDetail->price }}, {{ $ticketDetail->number_of_tickets }})">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="16"
                                                                            fill="currentColor" class="bi bi-plus"
                                                                            viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span data-ticket-id="{{ $ticketDetail->id }}"
                                                                class="text-danger text-capitalize">Sold Out</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="p-4 text-center text-body subtotal"
                                                    id="subtotal-{{ $ticketDetail->id }}">
                                                    0.00
                                                    <div
                                                        class="text-center subtotal align-items-center d-flex flex-column">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody> --}}
                                    <!--old Ticket Selection-->




                                </table>
                                <div class="total-display d-flex flex-column mb-3 justify-content-center text-center">
                                    <h6 class="mb-0" id="total">Total : </h6>
                                </div>
                                <div class="report-button">
                                    <a class="btn btn-danger disabled w-100" id="buyTicketText">Please Select a Ticket</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    </section>
    <!-- End Event Location -->

    <!-- Start customer care Section -->
    @if( isset($customerCare) && !empty($customerCare) )
        @if ($customerCare->email || $customerCare->whatsapp || $customerCare->address)
            <section id="line-up" class="lineup-section lineup-1 pt-60 pt-lg-0 mb-20 mb-lg-30 mb-xxl-40">
                <div class="lineup-contents custom-inner-bg bg-lg py-30 py-lg-50 position-relative">
                    <div class="container">
                        <div class="row gx-80 gy-30">
                            <div class="col-lg-7">
                                <div class="swiper-custom-progress position-relative wow fadeInRight">
                                    <div class="about-image-1 position-relative">
                                        <div class="about-image-wrapper">
                                            <img src="{{ asset('assets/images/home-1/customerDetails.webp') }}" class="img-fluid"
                                                alt="img">
                                        </div>
                                    </div>
                                    <div class="about-image-2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="lineup-right-content mt-60 mt-lg-0 wow fadeInLeft">
                                    <div class="section-title section-title-style-2 mb-4 mb-lg-30 mb-xxl-40">
                                        <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                                class="straight-line"></span>Your Booking Info</span>
                                        <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                                            <span class="mb-n2 text-opacity">Customer</span>
                                            <span class="sub-title fw-extra-bold primary-text-shadow">Care</span>
                                        </h2>
                                    </div>
                                    <p class="custom-sans custom-font-style-1 mb-4 mb-lg-30">
                                        Get ready to feel the rhythm with a show that will dazzle your senses. Have questions? Our team is just a beat away!
                                    </p>
                                    <div class="customer-info mt-4">
                                        @if($customerCare->email)
                                            <div>
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted">Email : <span class="fs-5 text-light">{{ $customerCare->email }}</span></h6>
                                                </div>
                                            </div>
                                        @endif
                                        @if($customerCare->whatsapp)
                                            <div>
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted">WhatsApp Number : <span class="fs-5 text-light">{{ $customerCare->whatsapp }}</span></h6>
                                                </div>
                                            </div>
                                        @endif
                                        @if($customerCare->address)
                                            <div>
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted">Address : <span class="fs-5 text-light">{{ $customerCare->address }}</span></h6>
                                                </div>
                                            </div>
                                        @endif
                                        <hr class="border-secondary" />
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- End customer care Section -->

    <script>
        const seatDetails = {

        }

        function select(category, id, ticket_id, price, maxTickets) {
            const button = document.getElementById("but" + category + id);
            value = button.getAttribute('value')



            if (value == 'selected') {
                decreaseQuantity(ticket_id, price);
                seatDetails[ticket_id] = seatDetails[ticket_id].filter(item => item !== id);

                button.classList.remove('bg-yellow-important','bg-white');
                button.classList.add('bg-white');

                button.setAttribute('value', "notSelected");
            }
            if (value == 'notSelected') {
                const ret = increaseQuantity(ticket_id, price, maxTickets);

                if (ret) {
                    showCustomAlert(ret);
                } else {
                    if (!Array.isArray(seatDetails[ticket_id])) {
                        seatDetails[ticket_id] = [];
                    }
                    seatDetails[ticket_id].push(id);

                    button.classList.remove('bg-white-important','bg-white');
                    button.classList.add('bg-yellow-important');

                    button.setAttribute('value', "selected");
                }

            }

            console.log(seatDetails);
        }


        document.addEventListener("DOMContentLoaded", function() {
            // Get the countdown element
            const countdownElement = document.getElementById('countdown');

            // Get the event date from the data attribute
            const eventDateStr = countdownElement.getAttribute('data-event-date');

            // Parse the event date
            const eventDate = new Date(eventDateStr);

            // Format the date and time
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const eventDateFormatted = eventDate.toLocaleDateString(undefined, options);

            const eventTimeFormatted = eventDate.toLocaleTimeString(undefined, {
                hour: '2-digit',
                minute: '2-digit'
            });


            // Display the date and time
            document.getElementById('event-date').textContent = eventDateFormatted;
            document.getElementById('event-time').textContent = eventTimeFormatted;
        });

        // Add click event listener to the Buy Tickets button
        document.addEventListener("DOMContentLoaded", function() {
            @if (Auth::user())
                // Get the Buy Tickets button by its ID
                const buyTicketsButton = document.querySelector('#buyTicketsButton');

                // Get the modal by its ID
                const ticketModal = new bootstrap.Modal(document.getElementById('ticketModal'));

                // Add click event listener to the Buy Tickets button
                buyTicketsButton.addEventListener('click', function() {
                    ticketModal.show(); // Show the modal when the button is clicked


                    // Get the close button by its ID
                    const closeButton = document.querySelector('#ticketModal .btn-close');


                    // Add click event listener to the close button
                    closeButton.addEventListener('click', function() {
                        ticketModal.hide(); // Hide the modal when the close button is clicked
                    });
                });
            @endif
        });

        // Increase  ticket quantity
        function increaseQuantity(id, price, maxTickets) {
            event.preventDefault(); // Prevent the default form submission behavior
            var quantityElement = document.querySelector(`[data-ticket-id="${id}"]`);
            var quantity = parseInt(quantityElement.textContent);
            //currently include all tickets in category
            if (quantity < maxTickets) {
                //maximun quantity a user can buy in one category
                // if(quantity <10){
                quantity++;
                quantityElement.textContent = quantity;
                updateSubtotal(id, quantity, price);
                handleTicketSelection();
                // }
            } else {
                event.preventDefault();
                //old method
                // showCustomAlert("No more tickets available in this category.");
                return "No more tickets available in this category.";
            }
        }

        //decrease ticket quantity
        function decreaseQuantity(id, price) {
            event.preventDefault();
            var quantityElement = document.querySelector(`[data-ticket-id="${id}"]`);
            var quantity = parseInt(quantityElement.textContent);
            if (quantity > 0) {
                quantity--;
                quantityElement.textContent = quantity;
                updateSubtotal(id, quantity, price); // Call the updateSubtotal function
            }

        }

        // Update the subtotal
        function updateSubtotal(id, quantity, ticketPrice) {
            event.preventDefault(); // Prevent the default form submission behavior
            var subtotalElement = document.getElementById(`subtotal-${id}`);
            var subtotal = quantity * ticketPrice;
            subtotalElement.textContent = subtotal.toFixed(2); // Display the subtotal with 2 decimal places
            updateTotal(); // Call the updateTotal function
        }


        // Update the total
        function updateTotal() {
            event.preventDefault(); // Prevent the default form submission behavior
            var totalElement = document.getElementById('total');
            var subtotalElements = document.querySelectorAll('span.subtotal');



            console.log(subtotalElements);

            var total = 0;

            subtotalElements.forEach(function(el) {
                const value = parseFloat(el.textContent);
                if (!isNaN(value)) {
                    total += value;
                }
            });
            console.log(total);
            @if (isset($ticketDetails->currency))
                totalElement.textContent = "Total:" + "{{ $ticketDetails->currency }}" + total.toFixed(2);
            @else
                totalElement.textContent = "Total:" + total.toFixed(2);
            @endif
            if (total === 0) {
                event.preventDefault();
                document.querySelector('#buyTicketText').innerText = 'Please Select a Ticket';
                document.querySelector('#buyTicketText').className = 'btn btn-danger disabled w-100';
            }
        }

        // Assuminge a function to handle the ticket selection event
        function handleTicketSelection() {

            event.preventDefault(); // Prevent the default form submission behavior
            document.querySelector('#buyTicketText').innerText = 'Next';
            document.querySelector('#buyTicketText').className = 'btn btn-primary w-100';
        }

        // Submit the form
        document.querySelector('#buyTicketText').addEventListener('click', function() {
            var formData = new FormData(document.querySelector('#ticketForm'));
            var categories = [];
            var quantities = [];

            @foreach ($ticketDetails as $ticketDetail)
                //check if ticket is sold out
                if (document.querySelector(`span[data-ticket-id="{{ $ticketDetail->id }}"]`).textContent ===
                    "Sold Out") {

                    //all tickets sold out
                } else if (parseInt(document.querySelector(`span[data-ticket-id="{{ $ticketDetail->id }}"]`)
                        .textContent) === 0) {

                    //no ticket selected
                } else {
                    var quantity = parseInt(document.querySelector(
                        `span[data-ticket-id="{{ $ticketDetail->id }}"]`).textContent);
                    // var quantity = document.querySelector(`span[data-ticket-id="{{ $ticketDetail->id }}"]`).textContent;

                    categories.push({
                        'id': '{{ $ticketDetail->id }}',
                        'category': document.querySelector(`span#category-{{ $ticketDetail->id }}`)
                            .textContent
                    });
                    quantities.push({
                        'id': '{{ $ticketDetail->id }}',
                        'quantity': quantity
                    });

                }
            @endforeach
            // Convert the arrays to JSON strings
            var categories = JSON.stringify(categories);
            var quantities = JSON.stringify(quantities);

            // Set the JSON strings in hidden input fields
            document.querySelector('#categories').value = categories;
            document.querySelector('#quantities').value = quantities;
            document.querySelector('#seats').value = JSON.stringify(seatDetails);




            // Submit the form
            document.querySelector('#ticketForm').submit();

        });
        document.getElementById('mapDirectionBtn').addEventListener('click', function () {
            const location = @json($event->location);
            const mapUrl = `https://www.google.com/maps?q=${encodeURIComponent(location)}&output=embed`;
            document.getElementById('RoutingMap').src = mapUrl;
        });

        const modal = document.getElementById('RoutingMapModal');
        modal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('RoutingMap').src = '';
        });
    </script>
@endsection
