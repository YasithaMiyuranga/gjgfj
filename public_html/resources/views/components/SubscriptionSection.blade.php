<section class="subscription-section subscription-1 bg-lg custom-inner-bg position-relative">
    <div class="ellipse-image-2">
        <img src="assets/images/home-1/ellipse-2.png" alt="ellipse-1">
    </div>
    <div class="container">
        <div class="subscription-wrapper py-50 py-lg-70 py-xxl-100">
            <div class="row justify-content-between gy-40 gy-lg-0">
                <div class="col-lg-5">
                    <div class="subscription-left-content wow fadeInRight">
                        <div class="section-title section-title-style-2 mb-4 mb-lg-5">
                            <span class="fs-3 straight-line-wrapper fw-semibold position-relative"> <span
                                    class="straight-line"></span>Contact Us</span>
                            <h2 class="title display-3 fw-extra-bold d-flex flex-column">
                                <span class="mb-n2 text-opacity">Call </span>
                                <span class="sub-title fw-extra-bold primary-text-shadow">0712345678</span>
                            </h2>
                        </div>
                        <!-- section-title -->
                        <p class="custom-sans custom-font-style-1 mb-30">
                            Join Our Vibrant Community and Stay Updated with Exclusive Offers, Exciting News, and Event
                            Updates Delivered Straight to Your Inbox.
                        </p>
                        <form method="POST" action="{{ route('subscription.store') }}" id="subscriptionform">
                            @csrf
                            <div class="subscription-form position-relative">

                                <input type="email" class="form-control" id="subscriptionInput1" name="subscriptionInput1"
                                    placeholder="Enter your Email" required>

                                <button class="subscription-form-arrow" type="submit">
                                    <svg width="37" height="38">
                                        <use xlink:href="#subscription-form-arrow"></use>
                                    </svg>
                                </button>
                            </div>
                        </form>
                        <!-- Modal -->
                        <div class="modal fade" id="form-success" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="box-shadow: 0 0 96px 1px #f6853473;">
                                    <div class="modal-header" style="border-bottom: none;">
                                        <button type="button" class="btn-close" id="modal-close-btn"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="padding-bottom: 0;">
                                        <h6 class="text-center">Thank you for subscribing to our newsletter!</h6>
                                    </div>
                                    <div class="modal-footer"
                                        style="border-top: none; display: flex; justify-content: center; padding-top: 0; padding-bottom: 48px;">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                            style="padding: 4px 34px;" id="footer-modal-close-btn">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- subscription-left-content -->
                </div>
                <!-- col-5 -->

                <div class="col-lg-5 wow fadeInLeft">
                    <h3 class="straight-line-wrapper fw-semibold position-relative mb-20"> <span
                            class="straight-line"></span>Location</h3>
                    <div class="map-image parallax position-relative">
                        <span class="map-marker">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                            </svg>
                        </span>

                        <div class="map-popup-content">
                            <h3>Lion Events</h3>
                            <p>No 123,  Matara</p><a id="mapDirectionBtn" href=""
                                class="btn btn-primary btn-sm d-flex align-items-center justify-content-center custom-roboto gap-10 btn-map-direction"
                                data-bs-toggle="modal" data-bs-target="#RoutingMapModal">Get Direction <svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                </svg></a>
                        </div>
                    </div>

                    <!-- Modal-Map -->
                    <div class="modal modal-fullscreen routing-map-modal fade" id="RoutingMapModal" tabindex="-1"
                        aria-labelledby="RoutingMapLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="RoutingMapLabel">No 169, Mahapala Waththa, Hakmana
                                        Road, Thudava, Matara</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3968.2491117824056!2d80.5437877758748!3d5.960380994024339!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae1391dbd1d3541%3A0x4aa69c0a9c2a4ca0!2scodeaisys.com!5e0!3m2!1sen!2slk!4v1709724223273!5m2!1sen!2slk"
                                        width="100%" height="450" style="border:0; border-radius: 18px"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
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
