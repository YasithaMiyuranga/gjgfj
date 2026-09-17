@php
    $SITE_RTL = '';
    $cust_darklayout = 'on';
    $color = 'theme-3';
    if (!empty($settings['color'])) {
        $color = $settings['color'];
    }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('page-title') </title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="CodeAiSys" />
    <meta name="base-url" content="{{-- {{URL::to('/')}} --}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    {{-- <link rel="icon" href="{{(!empty($favicon))? $favicon : $profile.'/logo-sm.svg'}}" type="image/x-icon" /> --}}


    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- notification css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/plugins/notifier.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/plugins/bootstrap-switch-button.min.css') }}">
    <!-- datatable css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/plugins/style.css') }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('Admin/css/custom.css') }}{{ '?v=' . time() }}">
    <link rel="stylesheet" href="{{ asset('Admin/css/auth.css') }}">
</head>

<body class={{ $color }}>
    <div class="auth-wrapper auth-v3">
        <div class="bg-auth-side"></div>
        <div class="auth-content">
            <nav class="">
            </nav>

            <div class="card bg-white">
                <div class="row align-items-center text-start">
                    <div class="col-xl-6 justify-content-center d-xl-grid">
                        <div class="card-body">
                            <h3 class="mb-1 mt-0">
                                {{ Str::title(str_replace('-', ' ', config('app.name')))  }}
                            </h3>
                            <p class="mb-4">
                                Effortlessly plan, manage, and organize your events from start to finish.
                            </p>
                            @yield('content')
                            <p class="text-black text-center mt-2">{{ __('Copyright') }} &copy; {{ date('Y') }}
                                <a href="https://codeaisys.com" target="_blank"><span class="text-primary">CodeAIsys.com</span></a>
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-6 img-card-side d-none d-xl-block">
                        <div >
                            <img src="{{ asset('assets/images/home/AboutUs.webp') }}" alt="loginImg"
                                class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signup ] end -->

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/vendor-all.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/plugins/feather.min.js') }}"></script>



</body>
</html>

