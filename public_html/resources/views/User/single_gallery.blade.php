@extends('layouts.userapp')

@section('content')
    <!--Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0 text-center">{{ $album->name }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="/Gallery">Gallery</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!--Banner Section ======================-->

    <section class="album-images">
        <div class="container">
            <div class="row" id="gallery-row">
                @foreach ($albumImages as $image)
                <div class="col-12 col-md-4 item-wrap">
                    <div class="img-wrap">
                        <a data-fancybox="gallery"
                           href="{{ asset($image->image) }}"
                           data-caption="{{ $image->meta?->image_name }}">
                            <img class="image" src="{{ asset($image->image) }}" alt="{{ $image->meta?->image_alt }}">
                        </a>
                    </div>
                </div>
                
                @endforeach
            </div>
        </div>
    </section>
@endsection
