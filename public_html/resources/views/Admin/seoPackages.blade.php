@extends('layouts.app')

@section('page-title', __('Packages'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.seo.packages') }}">{{ __('Packages') }}</a>
    </li>
@endsection

@section('action-button')
@endsection

@section('content')
    <style>
        .masonry {
            column-count: 3;
            column-gap: 1rem;
        }

        @media (max-width: 768px) {
            .masonry {
                column-count: 2;
            }
        }

        @media (max-width: 576px) {
            .masonry {
                column-count: 1;
            }
        }

        .masonry-item {
            break-inside: avoid;
            margin-bottom: 1rem;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <!-- Banner Section -->
                    <div class="card-header text-white bg-dark">
                        <h4 class="text-center">App Packages Images</h4>
                    </div>
                    @php
                        $i = 0;
                    @endphp
                    <!-- App Icon Section -->
                    <div class="masonry mb-4">
                        @foreach ($settings['app']['packages']['images'] as $filename => $image)
                            <div class="masonry-item ">
                                <img style="width:100%" src="{{ asset($image['url']) }}"
                                    alt="{{ $image['alt'] ?? 'Image' }}" class="img-fluid rounded shadow-sm" />
                                <input type="text" value="{{ $image['alt'] }}" placeholder="Alt"
                                    class="form-control mt-2" id='alt{{ $filename }}' />
                                <div style="justify-content: end;display: flex" class="mt-1 mb-2">
                                    <button class="btn btn-primary col-12"
                                        onclick="save('packages','{{ $filename }}')">Save</button>
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function save(page, filename) {
            const image_alt = document.getElementById("alt" + filename).value;

            const formData = new FormData();

            formData.append("file_name", filename);
            formData.append("image_alt", image_alt);
            formData.append("image_page", page);
            
            fetch("/useradmin/SEO/images/alt/save", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(resp => resp.json())
                .then(json => {
                    console.log(json);
                    showCustomAlert(json.message);
                })
                .catch(e => {
                    console.error("Error", e);
                });

        }
    </script>
@endsection
