@extends('layouts.userapp')

@section('content')
    <!-- Banner Section ======================-->
    <!-- <section class="banner-section banner-1 banner-2 position-relative parallax">
        <div class="container">
            <div class="banner-wrapper d-flex gap-20 gap-lg-40 justify-content-center align-items-lg-center flex-column">
                <h2 class="banner-heading display-3 fw-extra-bold custom-jakarta mb-0">Cart</h2>
                <nav aria-label="breadcrumb">
                    <ol class="blog-breadcrumb breadcrumb">
                        <li class="breadcrumb-item">Order Complete</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section> -->
    <!-- Banner Section ======================-->
<form id="sendForm">
    @csrf
    <section class="thank-you">
        <div class="container container-wrap">
            <div class="row row-wrap">
                <div class="col-12 col-wrap">
                    <div class="detail-wrap">
                        <img src="/assets/images/cart/thank-you.svg" class="icon" alt="Thank You">
                        <h2 class="title">Thank You!</h2>
                        <span class="desc">
                            We're grateful that you've chosen 4ZERO Events for
                            your rental needs! Your order is in good hands and is
                            currently being processed. Got questions or special requests? Our team is here
                            to help, ensuring your rental experience is smooth
                            and stress-free. Thanks again for trusting us with
                            your rental needs. We're excited to make your event or
                            project a success!
                        </span>
                        {{-- <a href="#" class="btn btn-primary btn-sm btn-quote-mb d-flex d-md-none">Print Quotation</a> --}}
                    </div>
                    <div class="row contact-info-wrap">
                        <div class="col-sm-12 col-md-5 contact-wrap">
                            <div class="item phone">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                                    </svg>
                                </div>
                                <div class="detail">
                                    <a href="tell:+94777836963">
                                        +94 777 83 6963
                                    </a>
                                </div>
                            </div>
                            <div class="item whatsapp">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                    </svg>
                                </div>
                                <div class="detail">
                                    <span>
                                        +94 777 83 6963
                                    </span>
                                </div>
                            </div>
                            <div class="item email">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
                                    </svg>
                                </div>
                                <div class="detail">
                                    <a href="mailto:contact@4zeroevents.com">
                                        contact@4zeroevents.com
                                    </a>
                                </div>
                            </div>
                            <div class="bottom-design"></div>
                        </div>
                        <div class="col-sm-12 col-md-5 location-wrap">
                            <div class="item location">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                    </svg>
                                </div>
                                <div class="detail">
                                    <span>
                                        4ZERO Events <br>
                                        No 169, Mahapala Waththa, Thudava, Matara.
                                    </span>
                                </div>
                            </div>
                            <div class="item time">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-check" viewBox="0 0 16 16">
                                        <path d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z"/>
                                        <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                </div>
                                <div class="detail">
                                    Monday - Sunday <br> 8:30AM - 17:30PM
                                </div>
                            </div>
                            <div class="bottom-design"></div>
                        </div>
                    </div>
                    @if ($downloadable == true)
                        <div class="quotation-btn d-none d-md-flex">
                            <button type="submit" class="btn btn-primary btn-sm btn-quote">Print Quotation</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</form>
 <script>
function downloadpdf() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/user/generate-custompdf/{{ $customerpacakge->package_id }}', true);
    xhr.responseType = 'blob';

    xhr.onload = function() {
        if(xhr.status === 200) {
            var url = window.URL.createObjectURL(xhr.response);
            var a = document.createElement('a');
            a.href = url;
            a.download = '{{ $customerpacakge->customer_name}}_Package_Quotation.pdf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.location.href = "{{ url('/Home') }}";
        } else {
            console.error('Error downloading PDF');
        }

    };
    xhr.onerror = function() {
            // Handle network error
            console.error('Network error while downloading PDF');
        };
    xhr.send();
}
 document.getElementById('sendForm').addEventListener('submit', function(e) {
        e.preventDefault();
        downloadpdf();
    });
</script>

@endsection
