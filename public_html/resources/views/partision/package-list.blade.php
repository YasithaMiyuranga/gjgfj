@if ($packages->count())
    @foreach ($packages as $package)
        <div class="col-md-4 package-item" data-category="{{ $package->category }}">
            <a href="/single-package/{{ $package->package_id }}" style="display: inline-block; padding-top:10px;">
                <div class="blog-content package-content blog-content-2 custom-inner-bg">
                    <div class="row package-img-cont-wrap gy-4 align-items-center justify-content-between">
                        <div class="col-12 img-wrap">
                            <div class="package-image-wrap">
                                <img class="package-image" src="{{ asset($package->image) }}" alt="{{ $package->name }}">
                            </div>
                        </div>
                        <div class="col-12 content-wrap">
                            <div class="blog-left-content">
                                @if($package->price_visible)
                                    <p class="price-sec">LKR: {{ $package->price }}</p>
                                @endif
                            </div>
                        </div>
                        <h2 class="package-title blog-link fs-4 fw-bold">
                            <a class="text-decoration-none" href="/single-package/{{ $package->package_id }}">{{ $package->package_name }}</a>
                        </h2>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@else
    <div class="col-12 text-center">
        <p class="text-muted">No packages available.</p>
    </div>
@endif

