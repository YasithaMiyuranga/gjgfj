@extends('layouts.app')

@section('page-title', __('SEO'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.seo.show') }}">{{ __('SEO') }}</a>
    </li>
@endsection

@section('action-button')
@endsection

@section('content')
    <style>
        .popover {
            max-width: 300px;
            height: fit-content;
            font-size: 14px;
        }

        .popover-header {
            color:gray;
            border-radius: 15px;
            font-size: 13px
        }

        .popover-body {}
    </style>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <!-- Banner Section -->
                    <div class="card-header text-white bg-dark">
                        <h4 class="text-center">App SEO Settings</h4>
                    </div>
                    <div class="card-body">
                        <!-- App Icon Section -->
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <div class="bg-light p-3">
                                    <img id='image-icon' src="{{ asset('assets/images/Company/' . $settings['app_icon']) }}"
                                        alt="App Icon" class="img-fluid ">
                                </div>
                                <p class="mt-2">App Icon
                                    <span type="button" data-toggle="popover"
                                        title=" The visual symbol of your app that appears on users’ devices. It should be simple,
                                    recognizable, and reflective of your app’s brand and purpose."
                                        data-content="">
                                        <i style="color:white" class="fas fa-info-circle"></i> 
                                    </span>
                                </p>
                                <input type='file' hidden id='app-icon' onchange="showImage('image-icon','app-icon')" />
                                <label class="btn btn-primary" for='app-icon'>Update Image</label>



                                <div class="bg-light p-3 mt-4">
                                    <img id='image-logo' src="{{ asset('assets/images/Company/' . $settings['app_logo']) }}"
                                        alt="App Logo" class="img-fluid ">
                                </div>
                                <p class="mt-2">App Logo
                                    <span type="button" data-toggle="popover"
                                        title="Logo of your app . It should be simple,
                                    recognizable, and reflective of your app’s brand and purpose."
                                        data-content="">
                                        <i style="color:white" class="fas fa-info-circle"></i>
                                    </span>
                                </p>
                                <input type='file' onchange="showImage('image-logo','app-logo')" hidden id='app-logo' />
                                <label class="btn btn-primary" for='app-logo'>Update Image</label>
                            </div>
                            <!-- App Name and Description -->


                            <div class="col-md-9 ">
                                <h5 class="font-weight-bold mb-4">
                                    App Name
                                    <!-- Info Icon with Popover -->
                                    <span type="button" data-toggle="popover"
                                        title="The name of your app as it appears on search engines and app stores. It should be clear, unique, and include relevant keywords to help users find your app easily."
                                        data-content="">
                                        <i style="color:white" class="fas fa-info-circle"></i> </span>
                                </h5>

                                <input value='{{ $settings['app_name'] }}' type="text" class="form-control mb-2"
                                    id="AppName" placeholder="App Name">

                                <h5 class="font-weight-bold mb-4 mt-4">
                                    Facebook Link
                                    <!-- Info Icon with Popover -->
                                    <span type="button" data-toggle="popover"
                                        title="Link of your facebook account" data-content="">
                                        <i style="color:white" class="fas fa-info-circle"></i> </span>
                                </h5>

                                <input value='{{ $settings['facebook_link'] }}' type="text" class="form-control mb-2"
                                    id="facebook" placeholder="Facebook Link">


                                <h5 class="font-weight-bold mb-4 mt-4">
                                    Instagram Link
                                    <!-- Info Icon with Popover -->
                                    <span type="button" data-toggle="popover"
                                        title="Link of your Instagram account" data-content="">
                                        <i style="color:white" class="fas fa-info-circle"></i> </span>
                                </h5>

                                <input value='{{ $settings['instagram_link'] }}' type="text" class="form-control mb-2"
                                    id="instagram" placeholder="Instagram Link">


                                <h6 class="font-weight-bold mb-4 mt-4">
                                    App Description
                                    <!-- Info Icon with Popover -->
                                    <span type="button" data-toggle="popover"
                                        title=" A brief summary of what your app does, its features, and benefits. This description helps users understand the value of your app and should include SEO keywords to improve search visibility."
                                        data-content="">
                                        <i style="color:white" class="fas fa-info-circle"></i> </span>
                                </h6>

                                <textarea class="form-control mb-2" id="appDescription" rows="4" placeholder="App Description">{{ $settings['app_description'] }}</textarea>



                                <h6 class="font-weight-bold mb-4 mt-4">
                                    Keywords
                                    <!-- Info Icon with Popover -->
                                    <span type="button" data-toggle="popover"
                                        title=" Relevant search terms that describe your app and improve its discoverability in search results. Choose keywords that match what users would search for related to your app."
                                        data-content="">
                                        <i style="color:white" class="fas fa-info-circle"></i>
                                    </span>
                                </h6>

                                <textarea class="form-control mb-2" id="appKeywords" rows="4" placeholder="App Description">{{ $settings['app_keywords'] }}</textarea>

                                <h5 class="font-weight-bold mb-4 mt-4">
                                    Google Analytics ID
                                    <!-- Info Icon with Popover -->
                                    <span type="button" data-toggle="popover"
                                        title="A Google Analytics ID is a unique identifier assigned to your website or app by Google Analytics. It links your site to your Google Analytics account so data like page views, user behavior, and traffic sources can be tracked."
                                        data-content="">
                                        <i style="color:white" class="fas fa-info-circle"></i> </span>
                                </h5>

                                <input value='{{ $settings['google_analytics_id'] }}' type="text"
                                    class="form-control mb-2" id="googleAId" placeholder="Google Analytics ID">

                                <div style="justify-content: end;display: flex" class="mt-4">
                                    <button class="btn btn-primary" onclick="save()">Save</button>
                                </div>
                            </div>


                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showImage(componentId, inputId) {
            const input = document.getElementById(inputId);
            const component = document.getElementById(componentId);

            if (input && input.files && input.files[0]) {
                const file = input.files[0];
                const imageUrl = URL.createObjectURL(file);
                component.src = imageUrl;
            }
        }

        function save() {
            const image_icon = document.getElementById('app-icon');
            const image_logo = document.getElementById('app-logo');
            const app_name = document.getElementById('AppName').value;
            const app_description = document.getElementById('appDescription').value;
            const app_keywords = document.getElementById('appKeywords').value;
            const facebook_link = document.getElementById('facebook').value;
            const instagram_link = document.getElementById('instagram').value;
            const google_analytics_id = document.getElementById('googleAId').value;



            const formData = new FormData();

            if (image_icon.files && image_icon.files.length > 0) {
                formData.append("imageIcon", image_icon.files[0]);
            }

            if (image_logo.files && image_logo.files.length > 0) {
                formData.append("imageLogo", image_logo.files[0]);
            }

            formData.append("appName", app_name);
            formData.append("appDescription", app_description);
            formData.append("appKeywords", app_keywords);
            formData.append("facebookLink", facebook_link);
            formData.append("instagramLink", instagram_link);
            formData.append("googleAnalyticsId", google_analytics_id);



            fetch("/useradmin/SEO/save", {
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



        $(document).ready(function() {
            // Initialize popovers with manual trigger control
            $('[data-toggle="popover"]').popover({
                trigger: 'manual', // we'll handle toggling manually
                html: true
            });

            // Handle click on popover toggle elements
            $('[data-toggle="popover"]').on('click', function(e) {
                e.stopPropagation();

                // Close all other popovers
                $('[data-toggle="popover"]').not(this).popover('hide');

                // Toggle the clicked popover
                $(this).popover('toggle');
            });

            // Close popover when clicking outside
            $(document).on('click', function() {
                $('[data-toggle="popover"]').popover('hide');
            });
        });
    </script>
@endsection
