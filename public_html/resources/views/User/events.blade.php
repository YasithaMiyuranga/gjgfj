@extends('layouts.userapp')
{{-- <style>
    .countdown {
        display: flex;
        justify-content: center;
        gap: 10px;
        font-family: Arial, sans-serif;
    }
    .countdown-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .countdown-value {
        font-size: 2em;
    }
    .countdown-heading {
        font-size: 0.8em;
    }
</style> --}}

@section('content')
    <!--Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Events</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Events</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!--Banner Section ======================-->

    <section class="event-boxes-wrap">

        <div class="container">
            <div class="row">
                @foreach ($events as $event)
                <div class="col-md-6 full-wrap">
                    <div class="row g-0">
                        <div class="col-md-6 name-wrap">
                            <div class="box">
                                <div class="wave -one"></div>
                                <div class="wave -two"></div>
                                <div class="wave -three"></div>
                                <div class="title">{{ $event->event_name }}</div>
                                <div class="description">{{ $event->des }}</div>
                                <div class="date">{{ $event->event_date }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 image-btn-wrap">
                            <img src="{{ asset($event->logo) }}" alt="" class="image">
                            <div class="btn-wrap">
                                <a href="{{ route('single.event', ['event' => $event->eid]) }}" class="btn btn-primary btn-md btn-custom">View Event</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const countdownElement = document.getElementById('countdown');
            const eventDate = new Date(countdownElement.getAttribute('data-event-date')).getTime();
            D

            function updateCountdown() {
                const now = new Date().getTime();
                const timeDifference = eventDate - now;

                if (timeDifference < 0) {
                    document.getElementById('days').innerText = 0;
                    document.getElementById('hours').innerText = 0;
                    document.getElementById('minutes').innerText = 0;
                    document.getElementById('seconds').innerText = 0;
                    return;
                }

                const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                document.getElementById('days').innerText days;
                document.getElementById('hours').innerText = hours;
                document.getElementById('minutes').innerText = minutes;
                document.getElementById('seconds').innerText = seconds;
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script> --}}

@endsection
