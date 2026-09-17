<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .agreement-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            position: relative;
            min-height: 100vh;
        }

        .main-header {
            text-decoration: underline;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .term-section {
            margin-top: 20px;
            /* page-break-inside: avoid; */
        }

        .main-term-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 10px;
        }

        .sub-term-wrap ul {
            padding-left: 20px;
        }

        .description {
            text-align: justify;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .signature-section {
            position: absolute;
            bottom: 20px;
            width: 100%;
            page-break-before: auto;
        }

        .signature-box {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }

        .signature-box h5 {
            margin-bottom: 5px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            border-style: dotted;
            max-width: 250px;
            margin-top: 35px;
        }

        @media print {
            .agreement-container {
                position: relative;
                padding-bottom: 150px;
            }

            .signature-section {
                position: absolute;
                bottom: 20px;
                width: 100%;
                background-color: #f9f9f9;
            }
        }

        @page {
            size: A4;
            margin: 10mm 10mm;
      }
    </style>
</head>
<body>

    <section class="agreement-container">
        <div class="main-header">
            <h6>{{ $agreement->template->name }} Contract Agreement</h6>
        </div>
        <p>This Event and Customer Agreement (hereinafter referred to as "Agreement"") is made on the {{ date('Y-m-d') }}</p>

        <h6 class="text-center">BETWEEN</h6>
        <p>{{ Str::title(str_replace('-', ' ', config('app.company_name'))) }}, a company duly incorporated under the Companies Act of Sri Lanka bearing registration No {{ Str::title(str_replace('-', ' ', config('app.company_reg_no'))) }},
            having its registered office at {{ Str::title(str_replace('-', ' ', config('app.company_address_line_one'))) }}, {{ Str::title(str_replace('-', ' ', config('app.company_address_line_two'))) }}<br> (hereinafter referred to as "Employer").</p>

        <h6 class="text-center">AND</h6>
        <p>{{ $agreement->employee->name }}, residing at {{ $agreement->employee->address }},
            holding National Identity Card Number {{ $agreement->employee->nic }},
            hereinafter referred to as "{{ $agreement->employee->emp_type }}".</p>

        <p>WHEREAS the Company agrees to provide event services, and the Customer agrees to the terms outlined herein.</p>

        <h6 class="text-center">Event Details</h6>
        The event named [Event Name] is scheduled to take place on [Event Date & Time] at [Venue Name & Address]. The expected number of guests is [Number of Guests].
        Any special requirements for the event include [Specify if any]. The total cost for the event services is $[Amount], with a deposit of $[Amount] due upon signing this
        Agreement and the balance payment of $[Amount] due [Number] days before the event.

        <p>
            The event named [Event Name] is scheduled to take place on [Event Date & Time] at [Venue Name & Address]. The expected number of guests is [Number of Guests]. Any special requirements for the event include [Specify if any]. <br>

            The total cost for the event services is $[Amount], with a deposit of $[Amount] due upon signing this Agreement and the balance payment of $[Amount] due [Number] days before the event.
            Additional charges may apply for extra services requested after signing the Agreement. <br>

            The Company shall provide event coordination from the planning stage to execution, ensuring all agreed services are delivered to the highest standard. A dedicated event manager will be assigned as the primary point of contact.
        </p>

        <div class="term-section">
            @foreach ($agreement->agreementTerms as $term)
                <h6 class="main-term-title">{{ $term->title }}</h6>
                @foreach ($term->agreementSubTerms as $subTerm)
                    <div class="sub-term-wrap">
                        <ul>
                            <li>
                                <b>{{ $subTerm->SubTerm_title }}:</b>
                                <span class="description">{{ $subTerm->SubTerm_description }}</span>
                            </li>
                        </ul>
                    </div>
                @endforeach
            @endforeach
        </div>

        <!-- Signature Section (Always at the Bottom) -->
        <div class="signature-section">
            <p>I have read and understood the terms and conditions set out in this agreement and agree to abide by them.</p>

            <div class="d-flex justify-content-between">
                <div class="signature-box">
                    <h5>Employer</h5>
                    <h6>{{ Str::title(str_replace('-', ' ', config('app.company_name'))) }}</h6>
                    <div class="signature-line"></div> <br>
                    <p>Name: Mr. Kasun Kavinda <br> Title: CEO <br> Date: {{ date('Y-m-d') }}</p>
                </div>

                <div class="signature-box">
                    <h5>Employee</h5>
                    <h6>{{ $agreement->employee->name }}</h6>
                    <div class="signature-line"></div> <br>
                    <p>Title: {{ $agreement->employee->emp_type }} <br> Date: {{ date('Y-m-d') }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <div class="signature-box">
                    <h5>Witness</h5>
                    <div class="signature-line"></div> <br>
                    <p>Name: Bewangi Weeraman <br>
                        Address: {{ Str::title(str_replace('-', ' ', config('app.company_name'))) }}, <br>
                        {{ Str::title(str_replace('-', ' ', config('app.company_address_line_one'))) }}, <br>
                        {{ Str::title(str_replace('-', ' ', config('app.company_address_line_two'))) }}, <br>
                        {{ date('Y-m-d') }}</p>
                </div>

                <div class="signature-box">
                    <h5>Witness</h5>
                    <div class="signature-line"></div> <br>
                    <p>Name: K A J N Ishani <br>
                        Address: {{ Str::title(str_replace('-', ' ', config('app.company_name'))) }}, <br>
                        {{ Str::title(str_replace('-', ' ', config('app.company_address_line_one'))) }}, <br>
                        {{ Str::title(str_replace('-', ' ', config('app.company_address_line_two'))) }}, <br>
                        {{ date('Y-m-d') }}</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
