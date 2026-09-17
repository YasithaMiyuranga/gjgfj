<!DOCTYPE html>
<html lang="en">

<head>
    <title>Rent item Report for {{ $rent->created_at }}</title>
    <style>
        body {
            position: relative;
            min-height: 100vh;
            margin: 0;
            padding-bottom: 100px;
        }

        .container-wrap {
            padding-bottom: 80px;
        }

        h2, h6, hr {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container-wrap .heading-wrap {
            display: block;
        }

        .container-wrap .heading-wrap .heading .title,
        .container-wrap .heading-wrap .heading .company {
            text-transform: uppercase;
            font-weight: bold;
        }

        .container-wrap .heading-wrap .rent-details {
            margin-top: 10px;
        }

        .container-wrap .heading-wrap .rent-details .rent,
        .container-wrap .heading-wrap .rent-details .issue {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 12px;
        }

        .container-wrap .heading-wrap .rent-details .rent span,
        .container-wrap .heading-wrap .rent-details .issue span {
            text-transform: none;
            font-weight: normal;
        }

        .container-wrap .hr-rule {
            margin: 10px 0;
        }

        .container-wrap .bottom-wrap .rent-details .employee,
        .container-wrap .bottom-wrap .rent-details .customer {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 12px;
        }

        .container-wrap .bottom-wrap .rent-details .employee span,
        .container-wrap .bottom-wrap .rent-details .customer span {
            text-transform: none;
            font-weight: normal;
        }

        .container-wrap .table-wrap .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .container-wrap .table-wrap .table,
        .container-wrap .table-wrap .table thead th,
        .container-wrap .table-wrap .table tbody td {
            border: 2px solid #000;
            padding: 8px;
            text-align: left;
        }

        .container-wrap .table-wrap .table thead th {
            background-color: #000;
            color: #fff;
        }

        .confirmation-signs {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            padding: 5px;
            border-radius: 3px;
            margin: 0 auto;
            width: 100%;
            max-width: 800px;
        }

        .confirmation-signs-header {
            padding-bottom: 35px;
        }

        .confirmation-box input[type="text"] {
            padding: 20px 0px;
            border: 1px solid #252525;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .border-bottom {
            border-bottom: 1px solid #000;
            border-style: dotted;
            width: 200px;
            display: block;
            margin: 0 auto;
        }

        .confirmation-box td {
            text-align: center !important;
            vertical-align: middle;
            padding: 15px
        }

        .main-content {
            padding-bottom: 180px;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="container-wrap">
            <div class="heading-wrap">
                <div class="heading">
                    <h2 class="title">Rent Item Report</h2>
                    <span class="company">{{ Str::title(str_replace('-', ' ', config('app.name'))) }}</span>
                </div>
                <div class="rent-details">
                    <h6 class="rent">Rent ID: <span>{{ $rent->rent_id }}</span></h6>
                    <h6 class="issue">Issued At: <span>{{ $rent->created_at }}</span></h6>
                </div>
            </div>
            <hr class="hr-rule">
            <div class="bottom-wrap">
                <div class="rent-details">
                    <h3 class="employee">Employee Name: <span>Mr/Mrs {{ $rent->employee_name }}</span></h3>
                    <h3 class="customer">Customer Name: <span>Mr/Mrs {{ $rent->customer_name }}</span></h3>
                </div>
            </div>
            <div class="table-wrap">
                <table class="table dataTable mt-2">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Supplier</th>
                            <th>Received</th>
                            <th>Inspected</th>
                            <th>Returned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rentitems as $rentitem)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rentitem->item_name }}</td>
                                <td class="text-center">{{ $rentitem->quantity }}</td>
                                <td>
                                    @if ($rentitem->suppliers->count() > 0)
                                        @foreach ($rentitem->suppliers as $supplier)
                                            {{ $supplier->supplier_name }} ({{ $supplier->rent_quantity }}) <br>
                                        @endforeach
                                    @else
                                       -
                                    @endif
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="confirmation-signs">
        <table class="border-none text-center" style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="3" class="confirmation-signs-header">
                        Confirmation Signs
                    </th>
                </tr>
            </thead>
            <tbody class="confirmation-box">
                <tr>
                    <td class="confirmation-item text-center">
                        <div class="border-bottom text-center"></div>
                        <div class="text-center">
                            Received
                        </div>
                    </td>
                    <td class="confirmation-item text-center">
                        <div class="border-bottom text-center"></div>
                        <div class="text-center">
                            Inspected
                        </div>
                    </td>
                    <td class="confirmation-item">
                        <div class="border-bottom text-center"></div>
                        <div class="text-center">
                            Returned
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
