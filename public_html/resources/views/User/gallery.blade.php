@extends('layouts.userapp')

@section('content')
    <!--Banner Section ======================-->
    <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Gallery</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!--Banner Section ======================-->

    <div class="container mt-50">
        <div class="row">
            @foreach ($viewgallery as $row)
            <div class="col-12 col-md-4 outline-wrap">
                <a href="/single_gallery/{{ $row->id }}">    
                    <div class="circle">
                        <div class="item-wrap">
                            <div class="img-wrap">
                                <img class="image" src="{{ asset($row->album_images) }}" alt="">
                            </div>
                        </div>
                    </div>
                </a>
                <div class="album-name-wrap">
                    <span class="album-name">{{ $row->name }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
