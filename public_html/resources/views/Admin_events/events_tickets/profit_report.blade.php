<!DOCTYPE html>
<html lang="en">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<html lang="en">

<head>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<title>Company Profit Report</title>
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
                    <h1>Profit Report</h1>
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
                    <br/>
                    REPORT DATE: <b>{{ $reportDate }}</b>
            </div>
        </div>
        @foreach ($events as $event)

            @if($event->tickets->count() > 0)
                <div class="event-section" style="margin-top: 20px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <div>
                            <h5 style="margin-bottom: 10px;">EVENT: {{ $event->event_name }}</h5>
                            <h5 style="margin-bottom: 10px;">LOCATION: {{ $event->location }}</h5>
                        </div>
                        <div style="text-align: right;">
                            <br>
                            <h5 style="margin-bottom: 10px;">EVENT DATE: {{ $event->event_date }}</h5>
                        </div>
                    </div>

                    <table class="table" border="1" cellpadding="5" cellspacing="0" width="100%">
                        <thead>
                            <tr style="background-color: #f2f2f2;">
                                <th>Ticket Category</th>
                                <th>Price</th>
                                <th>Initial Tickets</th>
                                <th>Remaining Tickets</th>
                                <th>Sold Tickets</th>
                                <th>Total Sales</th>
                                <th>Profit Margin</th>
                                <th>Current Profit</th>
                                <th>Total Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalInitial = 0;
                                $totalRemaining = 0;
                                $totalSold = 0;
                                $totalSales = 0;
                                $totalProfit = 0;
                                $currentTotalProfit = 0;
                            @endphp

                            @foreach ($event->tickets as $ticket)
                                @php
                                    $ticketSales = $ticket->price * $ticket->baught_tickets_count;
                                    $totalInitial += $ticket->initial_tickets_count;
                                    $totalRemaining += $ticket->number_of_tickets;
                                    $totalSold += $ticket->baught_tickets_count;
                                    $totalSales += $ticketSales;
                                    if( $event -> margin)
                                    {
                                        $currentTotalProfit += ( $ticket->price * $ticket->baught_tickets_count )  * ($event->margin/100);
                                        $totalProfit += ( $ticket->price * $ticket->initial_tickets_count )  * ($event->margin/100);
                                        $ticket->ourCurrentCommission = ( $ticket->price * $ticket->baught_tickets_count )  * ($event->margin/100);
                                        $ticket->ourTotalCommission = ( $ticket->price * $ticket->initial_tickets_count )  * ($event->margin/100);
                                    }
                                    else{
                                        $ticket->ourCurrentCommission = 0;
                                        $ticket->ourTotalCommission = 0;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $ticket->tickets_category }}</td>
                                    <td>{{ $ticket->price }}</td>
                                    <td>{{ $ticket->initial_tickets_count }}</td>
                                    <td>{{ $ticket->number_of_tickets }}</td>
                                    <td>{{ $ticket->baught_tickets_count ?? 0}}</td>
                                    <td>{{ number_format($ticketSales, 2) }}</td> <!-- Display per-ticket sales -->
                                    <td>{{ isset($event->margin) ? $event->margin : '0.00' }}%</td>
                                    <td>{{ number_format($ticket->ourCurrentCommission, 2) }}</td>
                                    <td>{{ number_format($ticket->ourTotalCommission, 2) }}</td>
                                </tr>
                            @endforeach

                            <!-- Totals row -->
                            <tr style="background-color: #e9ecef; font-weight: bold;">
                                <td colspan="2" style="text-align: right;">Total:</td>
                                <td>{{ $totalInitial }}</td>
                                <td>{{ $totalRemaining }}</td>
                                <td>{{ $totalSold }}</td>
                                <td>{{ number_format($totalSales, 2) }}</td>
                                <td></td>
                                <td>{{ number_format($currentTotalProfit, 2) }}</td>
                                <td>{{ number_format($totalProfit, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach
    </div>
    <div class="form-group">
        <a class="btn btn-secondary" id="backButton" style="align-items: center" href="{{ url()->previous() }}">Go Back</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <button class="btn-print" id="printpagebutton" onclick="printBill()">Print Report</button>
    </div>
</body>
</html>


