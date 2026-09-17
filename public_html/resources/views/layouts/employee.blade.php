@php
    $SITE_RTL = '';
    $cust_darklayout = 'on';
    $color = 'theme-3';
    if (!empty($settings['color'])) {
        $color = $settings['color'];
    }
@endphp

<!DOCTYPE html>
<html lang="en" dir="{{ isset($SITE_RTL) && $SITE_RTL == 'on' ? 'rtl' : '' }}">

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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Favicon icon -->
    {{-- <link rel="icon" href="{{(!empty($favicon))? $favicon : $profile.'/logo-sm.svg'}}" type="image/x-icon" /> --}}
    <link rel="icon" href="{{ asset('assets/images/Company/' . config('app.company_favicon_icon')) }}" type="image/x-icon" />


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

    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif

    {{-- datatable --}}
    <!-- CSS Links -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">

    <!-- JavaScript Files -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/rowReorder.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>

    <!-- vendor css -->
    @if ($cust_darklayout == 'on')
        <link rel="stylesheet" href="{{ asset('Admin/assets/css/style-dark.css') }}" id="main-style-link">
    @else
        <link rel="stylesheet" href="{{ asset('Admin/assets/css/style.css') }}" id="main-style-link">
    @endif

    <link rel="stylesheet" href="{{ asset('Admin/css/custom.css') }}{{ '?v=' . time() }}">


</head>

<body class={{ $color }}>
    @include('partision.employee_sidebar')
    @include('partision.employee_header')

    <!-- [ Main Content ] start -->
    <div class="dash-container">
        <div class="dash-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-xl-5">
                            <div class="page-header-title">
                                <h4 class="m-b-10">@yield('page-title')</h4>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('employee.emp.empdashboard') }}">{{ __('Dashboard') }}</a>
                                </li>
                                @yield('breadcrumb')
                            </ul>
                        </div>
                        <div class="col-xl-7">
                            @yield('action-button')
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            @yield('content')
        </div>
    </div>
    <!-- [ Main Content ] end -->

    {{-- @include('partision.footer') --}}

    <div id="commanModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelCommanModelLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelCommanModelLabel"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <div id="commanModelOver" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelCommanModelLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelCommanModelLabel"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>


    @include('partision.footerlink')

    @if ($message = Session::get('success'))
        <script>
            show_toastr('{{ __('Success') }}', '{!! $message !!}', 'success');
        </script>
    @endif

    @if ($message = Session::get('error'))
        <script>
            show_toastr('{{ __('Error') }}', '{!! $message !!}', 'error');
        </script>
    @endif



    <script src="{{ asset('Admin/js/scripts.js') }}"></script>

    <!-- Scripts/Plugins ======================-->

<script>

$(document).ready(function() {
    $('.btn-info').on('click', function() {
            var url = $(this).data('url');
            var title = $(this).data('title');



            // AJAX request
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    // Handle the response and inject into the modal or desired location
                    $('#modelCommanModelLabel').text(title);
                    $('#commanModel .modal-body').html(response);
                    $('#commanModel').modal('show');
                },
                error: function(xhr) {
                    // Handle errors
                    showCustomAlert('Error: ' + xhr.status + ' ' + xhr.statusText);
                }
            });
        });
    });
 </script>

</body>
</html>
