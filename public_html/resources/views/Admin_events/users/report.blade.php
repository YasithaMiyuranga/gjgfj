<!DOCTYPE html>
<html lang="en">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<html lang="en">

<head>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<title>Users Report</title>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;

    }

     @page {
        size: A4;
        margin: 5mm 5mm;

      }

    @media print {
        body {
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.4;
        }

        .ticket {
            page-break-inside: avoid;
            margin: 0 !important;
            padding: 10px;
            background-color: #ffffff;
        }


        html, body {
            height: 100%;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        th {
            background-color: #9d9d9d !important;
            color: #000000 !important;
        }

        .category-cell {
            background-color: #000000 !important;
            color: #fff !important;
        }
    }

    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        font-size: 13px;
        background-color: #ffffff;
        page-break-inside: avoid;

    }

    .ticket {
        width: 842px;
        max-width: 780px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;

        position: relative;

    }

    hr {
        border: 0;
        border-top: 2px solid #000;
        margin-top: 0px;
        margin-bottom: 8px;
    }

    .ticket-heading{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 5px;
    }

    .ticket-heading .left-wrap{
        display: flex;
        align-items: flex-start;
    }

    .ticket-heading .left-wrap .left-rect{
        width: 50px;
        height: 40px;
        background: #000 !important;
        margin-right: 10px;
    }

    .ticket-heading .left-wrap .invo-title h1{
        font-weight: bold;
        margin: 0;
    }

    .ticket-heading .left-wrap .invo-title h3{
        font-weight: bold;
        margin: 0;
    }

    .ticket-heading .right-wrap{
        display: flex;
        align-items: flex-start;
        justify-content: end;
    }

    address{
        margin: 0px;
    }

    .ticket-heading .right-wrap .address{
        text-align: right;
    }

    .ticket-heading .right-wrap .right-rect{
        width: 120px;
        height: 40px;
        background: #000 !important;
        margin-left: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;

    }

    th, td {
        border: 1px solid #000;
        padding: 5px;
        text-align: left;
    }

    th {
        background-color: #838383;
        color: #000000;

    }

    .ticket-details td {
        width: 30%;

    }

    .category-cell {
        background-color: #161616;
        color: #f5eded;
        padding: 5px;
    }
    .disable-row {
        padding: 0px;
    }
    .company-title{
        margin: 0px;
    }
    p{
        margin-bottom: 5px;
    }
    h4{
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .due-wrap{
        padding-bottom: 3px;
    }
    .ticket-details-wrap{
        line-height: 3px !important;
        margin-bottom: 5px;
    }
    .additional-price{
        font-weight: bold;
    }

</style>

<script>
    function printBill() {
        //Get the print,back button and put it into a variable
        var printButton = document.getElementById("printpagebutton");
        var backButton = document.getElementById("backButton");
        //Set the print,back button visibility to 'hidden'
        printButton.style.visibility = 'hidden';
        backButton.style.visibility = 'hidden';
        //Print the page content
        window.print();
        //Set the print button and back button to 'visible' again
        printButton.style.visibility = 'visible';
        backButton.style.visibility = 'visible';

    }
</script>
</head>
<body>
    <div class="ticket">
        <div class="ticket-heading">
            <div class="left-wrap">
                <div class="left-rect"></div>
                <div class="invo-title">
                    <h1>Users Report</h1>
                    <h3>{{ Str::title(str_replace('-', ' ', config('app.name')))}}</h3>
                </div>
            </div>
            <div class="right-wrap">
                <div class="address">
                    <address>
                        <strong>
                            <h4 class="company-title">{{ Str::title(str_replace('-', ' ', config('app.company_name')))}}</h4>
                        </strong>
                        {{ Str::title(str_replace('-', ' ', config('app.company_address_line_one')))}}<br>
                        {{ Str::title(str_replace('-', ' ', config('app.company_address_line_two')))}}<br>
                        Tel - {{ config('app.company_contact')}}
                    </address>
                </div>
                <div class="right-rect"></div>
            </div>
        </div>
        <hr class="m-0">

        <div class="row ticket-details-wrap">
            <div class="col-xs-6 text-left">
                <address>
                    <div class="user-count-wrap">
                        <strong>TOTAL USERS:</strong>
                        <h4 class="user-count">
                            {{ $users->count() }}
                        </h4>
                    </div>
            </div>
            <div class="col-xs-6 text-right">
                <address>
                    <br/>
                    REPORT DATE: <b>{{ $reportDate }}</b>
            </div>
        </div>
        <table class="Users" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>USER NAME</th>
                    <th>MOBILE NO</th>
                    <th>EMAIL</th>
                    <th>ADDRESS</th>
                    <th>CREATE DATE</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->address || $user->city || $user->postal_code)
                                {{ $user->address ?? '' }}<br>
                                {{ $user->city ?? '' }}{{ $user->postal_code ? ' - ' . $user->postal_code : '' }}
                            @else
                                No Address
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>{{ $user->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="form-group">
        <a class="btn btn-secondary" id="backButton" style="align-items: center" href="{{ url()->previous() }}">Go Back</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <button class="btn-print" id="printpagebutton" onclick="printBill()">Print Report</button>
    </div>
</body>
</html>


