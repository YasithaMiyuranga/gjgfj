<!DOCTYPE html>
<html>
<head>
    <title>{{ $rent->customer_name }}-Missing Item Report</title>
    <style>
         h2, h4, hr{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container-wrap .heading-wrap{
            display: block;
        }

        .container-wrap .heading-wrap .heading .title,
        .container-wrap .heading-wrap .heading .company{
            text-transform: uppercase;
            font-weight: bold;
        }

        .container-wrap .heading-wrap .rent-details{
            margin-top: 10px;
        }

        .container-wrap .heading-wrap .rent-details .rent,
        .container-wrap .heading-wrap .rent-details .issue{
            text-transform: uppercase;
            font-weight: bold;
            font-size: 12px;
        }

        .container-wrap .heading-wrap .rent-details .rent span,
        .container-wrap .heading-wrap .rent-details .issue span{
            text-transform: none;
            font-weight: normal;
        }

        .container-wrap .hr-rule{
            margin: 10px 0;
        }

        .container-wrap .bottom-wrap .rent-details .employee,
        .container-wrap .bottom-wrap .rent-details .customer{
            text-transform: uppercase;
            font-weight: bold;
            font-size: 12px;
        }

        .container-wrap .bottom-wrap .rent-details .employee span,
        .container-wrap .bottom-wrap .rent-details .customer span{
            text-transform: none;
            font-weight: normal;
        }

        .container-wrap .table-wrap .table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .container-wrap .table-wrap .table,
        .container-wrap .table-wrap .table thead th,
        .container-wrap .table-wrap .table tbody td{
            border: 2px solid #000;
            padding: 8px;
            text-align: left;
        }

        .container-wrap .table-wrap .table thead th{
            background-color: #000;
            color: #fff;
        }
    </style>
</head>
<body>
    <body>
        <div class="container-wrap">
            <div class="heading-wrap">
                <div class="heading">
                    <h2 class="title">Missing Item Report</h2>
                    <span class="company">{{ Str::title(str_replace('-', ' ', config('app.name')))}}</span>
                </div>
                <div class="rent-details"></div>
                    <h4 class="rent">Rent ID: <span>{{ $rent->rent_id }}</span></h4>
                    <h4 class="issue">Issued At: <span>{{ $rent->created_at }}</span></h4>
            </div>
            <hr class="hr-rule">
            <div class="bottom-wrap">
                <div class="rent-details"></div>
                    <h4 class="employee">Employee Name: <span> {{ $rent->employee_name}}</span></h4>
                    <h4 class="customer">Customer Name: <span>Mr/Mrs {{ $rent->customer_name }}</span></h4>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($missingitems as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

   

</body>
</html>
