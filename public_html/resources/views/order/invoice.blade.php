
<!DOCTYPE html>
<html lang="en">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{{$order->event_name.' - '. date('d/m/Y', strtotime($order->booking_date)).'' }}</title>

<html lang="en">

<head>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<title>Invoice</title>
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

        .invoice {
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
            background-color: #000 !important;
            color: #fff !important;
        }

        .category-cell {
            background-color: #838383 !important;
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

    .invoice {
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

    .invoice-heading{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 5px;
    }

    .invoice-heading .left-wrap{
        display: flex;
        align-items: flex-start;
    }

    .invoice-heading .left-wrap .left-rect{
        width: 50px;
        height: 40px;
        background: #000 !important;
        margin-right: 10px;
    }

    .invoice-heading .left-wrap .invo-title h1{
        font-weight: bold;
        margin: 0;
    }

    .invoice-heading .left-wrap .invo-title h3{
        font-weight: bold;
        margin: 0;
    }

    .invoice-heading .right-wrap{
        display: flex;
        align-items: flex-start;
        justify-content: end;
    }

    address{
        margin: 0px;
    }

    .invoice-heading .right-wrap .address{
        text-align: right;
    }

    .invoice-heading .right-wrap .right-rect{
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
        background-color: #000;
        color: #fff;

    }

    .invoice-details td {
        width: 30%;

    }

    .centered-message {
        text-align: center;
        font-size: 25px;
        font-weight: bold;

    }
    .signature-lines {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;

    }

    .signature {
        width: 200px;
        padding: 10px;
        border-radius: 5px;
        margin-right: 20px;
        text-align: center;
    }

    .signature p {
        margin: 0;
    }

    .signature p.signature-text {
        font-weight: bold;
    }
    .footer {
        background-color: #000;
        color: #fff;
        padding: 14px;
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;

    }

    .footer-bottom{
        width: 100%;
        height: 40px;
        background: #000 !important;

    }
    .category-cell {
        background-color: #838383;
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
    .invoice-details-wrap{
        line-height: 3px !important;
        margin-bottom: 5px;
    }
    .additional-price{
        font-weight: bold;
    }
    .right-wrap {
        display: flex;
        justify-content: end;
        text-align: end
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
    <div class="invoice">
        <div class="invoice-heading">
            <div class="left-wrap">
                <div class="left-rect"></div>
                <div class="invo-title">
                    <h1>INVOICE</h1>
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

        <div class="row invoice-details-wrap">
            <div class="col-xs-6">
                <address>
                    <p>INVOICE TO :<b>{{ $customerName }}</b></p>
                    <P>EVENT :{{ $order->event_name }}</p>
                    <P>LOCATION :{{ $Location }}</p>
                    <P>TEL NO : {{ $customerPhone }}</P><br>
                    BOOKING DATE :<b>{{ date('d/m/Y', strtotime($order->booking_date)) }}</b>
                </address>
            </div>
            <div class="col-xs-6 right-wrap">
                <address>
                    @php
                        $currentBalance = ($additionalPrice > 0) ? ($additionalPrice - $payAmount) : ($grandTotal - $payAmount);
                    @endphp

                    @if(number_format($currentBalance, 2) != 0.00)
                        <div class="due-wrap">
                        <strong>TOTAL DUE:</strong> <br>
                            <h4 class="additional-price">
                                {{ number_format($currentBalance, 2) }}
                            </h4>
                        </div>
                    @endif

                    @if( isset($eventDates) && count($eventDates) > 0 || $eventDates == null)
                      <table  style="max-width: 300px;">
                          <tr>
                            <th style="text-align: center;">DATE & TIME</th>
                          </tr>
                          @php $day = 1; @endphp
                          @foreach($eventDates as $eventDate)
                              <tr>
                                  <td style="text-align: right;">
                                      {{ date('d/m/Y', strtotime($eventDate->date)) }} {{ date('H:i', strtotime($eventDate->start_time)) }} - {{ date('H:i', strtotime($eventDate->end_time)) }}
                                  </td>
                              </tr>
                              @php $day++; @endphp
                          @endforeach
                      </table>
                    @else
                        DATE & TIME<br>
                        {{ date('d/m/Y:H:i', strtotime($startTime)) }}<br>
                        {{ date('d/m/Y:H:i', strtotime($endTime)) }}<br>
                        <br>
                    @endif
                    @isset($invoice)
                        INV NO - {{ str_pad($invoice, 5, '0', STR_PAD_LEFT) }}
                    @else
                        Order-{{ $order->order_id }}
                    @endisset
                    <br>

                    INV DATE: {{ date('d/m/Y', strtotime($order->inv_date)) }}
            </div>
        </div>

        <table class="invoice-details">
            <thead>
                <tr>
                    @if($confirmWithItemPrice == 'on')
                        <th style="text-align: center;">PRODUCTS</th>
                        <th style="text-align: center;">PRICE</th>
                        <th style="text-align: center;">QTY</th>
                        <th style="text-align: center;">DISCOUNT</th>
                        <th style="text-align: center;">AMOUNT</th>
                    @else
                        <th style="text-align: center;" colspan="4">PRODUCTS</th>
                        <th style="text-align: center;" colspan="2">QTY</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $category => $items)
                    @php $categoryTotal = 0; @endphp
                    <tr>
                        <td colspan="{{ $confirmWithItemPrice == 'on' ? 5 : 6 }}" class="category-cell">{{ $category }}</td>
                    </tr>
                    @foreach ($items as $item)
                        @php
                            $itemTotal = $item->rent_price * $item->quantity - $item->discount;
                            if ($confirmWithItemPrice == 'on') {
                                $categoryTotal += $itemTotal;
                            }
                        @endphp
                        <tr>
                            @if ($confirmWithItemPrice == 'on')
                                <td>
                                    <div style="word-wrap: break-word; max-width: 350px;">{{ $item->item_name }}</div>
                                    @if($item->description)
                                        <div style="word-wrap: break-word; max-width: 350px; overflow-wrap: break-word;">
                                            {{ $item->description }}
                                        </div>
                                    @endif
                                </td>
                                <td style="text-align: center;">{{ $item->rent_price }}</td>
                                <td style="text-align: center;">{{ $item->quantity }}</td>
                                <td style="text-align: center;">{{ $item->discount }}</td>
                                <td style="text-align: center;">{{ $item->rent_price * $item->quantity - $item->discount }}</td>
                            @else
                                <td colspan="4">
                                    <div style="word-wrap: break-word; max-width: 350px;">{{ $item->item_name }}</div>
                                    @if($item->description)
                                        <div style="word-wrap: break-word; max-width: 350px; overflow-wrap: break-word;">
                                            {{ $item->description }}
                                        </div>
                                    @endif
                                </td>
                                <td style="text-align: center;" colspan="2">{{ $item->quantity }}</td>
                            @endif
                        </tr>
                    @endforeach
                    @if ($confirmWithItemPrice == 'on')
                        <tr>
                            <td colspan="4" style="text-align: right; font-weight: bold;">Total for {{ $category }}</td>
                            <td style="text-align: center; font-weight: bold;">{{ $categoryTotal }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>

            <tr>
                <td colspan="{{ $confirmWithItemPrice == 'on'? 2: 3}}">
                    <address>
                        <h4>Payment Method :</h4>
                        @if($bank_details)
                            Bank Name :{{ Str::upper(str_replace('-', ' ', $bank_details->bank_name))}}<br>
                            Branch Name :{{ Str::upper(str_replace('-', ' ', $bank_details->branch_name))}}<br>
                            Bank Account :{{ $bank_details->account_number}}<br>
                            Account Name :{{ Str::upper(str_replace('-', ' ', $bank_details->account_name))}}
                        @endif
                    </address>
                </td>
                <td style="text-align: right;" colspan="{{ $confirmWithItemPrice == 'on'? 3 : 2 }}">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>Sub-total:</div>
                        <h5>
                            {{ number_format((($finalAmount - $transport - $tax) + $totalDiscount + $payAmount), 2) }}
                        </h5>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>Transport:</div>
                        <div>{{ number_format($transport, 2) }}</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>Service Charge:</div>
                        <div>{{ number_format($tax, 2) }}</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>Discount:</div>
                        <div>{{ number_format($totalDiscount, 2) }}</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>Grand Total:</div>
                        <div>{{ number_format($grandTotalCorrect, 2) }}</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>Paid:</div>
                        <div>{{ number_format($payAmount, 2) }}</div>
                    </div>
                    <hr>
                    @if(number_format($currentBalance, 2) != 0.00)
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h4>Balance:</h4>
                            <h4>
                                {{ number_format($currentBalance, 2) }}
                            </h4>
                        </div>
                    @endif
                </td>
            </tr>
        </table>
        @if($special_note)
            <p><b>SPECIAL NOTE:</b> {{ ucfirst($special_note) }}</p>
        @else
            <p><b>SPECIAL NOTE:</b> A 50% of the total invoice amount is due upon confirmation or before the event date. Please note that this payment is non-refundable. The remaining balance must be paid in full on the event day, either before or during setup. Extra charges will apply for any additional hours beyond the agreed time.</p>
        @endif
        @if($terms_description)
            <div style="page-break-inside: avoid; margin: 20px 0;">
                <h6><b>TERMS AND CONDITIONS</b></h6>
                <div style="line-height: 1.5; word-wrap: break-word; width: 100%;">
                    {!! preg_replace('/\./', '.<br>', $terms_description) !!}
                </div>
            </div>
        @endif
        <div class="signature-lines" style="display: flex; justify-content: flex-end;">
            <div class="signature" style="margin-right: 20px;">
                <p>_________________________</p>
                <p style="text-align: center;">Client</p>
            </div>
            <div class="signature">
                <p>_________________________</p>
                <p style="text-align: center;">Administrator</p>
            </div>
        </div>
        <p class="centered-message"> Thank you for purchase! </p>
        <div class="footer-bottom"></div>
    </div>
    <div class="form-group">
        <a class="btn btn-secondary" id="backButton" style="align-items: center" href="{{ url()->previous() }}">Go Back</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <button class="btn-print" id="printpagebutton" onclick="printBill()">Print Bill</button>
    </div>
</body>
<script>
     // Clear the selectedItems array in the localStorage
     localStorage.removeItem('selectedItems');
     // Clear the rentpackge array in the localStorage
     localStorage.removeItem('rentPackage');
     // Clear the predefinedPackage array in the localStorage
     localStorage.removeItem('predefinedPackage');
 </script>
</html>


