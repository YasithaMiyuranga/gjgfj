<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rent Received Item Report for {{ $rent->updated_at }}</title>
    <style>
        h2, h6, hr{
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
    <div class="container-wrap">
        <div class="heading-wrap">
            <div class="heading">
                <h2 class="title">Rent Recieved Item Report</h2>
                <span class="company">{{ Str::title(str_replace('-', ' ', config('app.name')))}}</span>
            </div>
            <div class="rent-details">
                <h6 class="rent">Rent ID: <span>{{ $rent->rent_id }}</span></h6>
                <h6 class="issue">Issued At: <span>{{ $rent->created_at }}</span></h6>
                {{-- receive date --}}
                <h6 class="issue">Received At: <span>{{ $rent->updated_at }}</span></h6>
            </div>
        </div>
        <hr class="hr-rule">
        <div class="bottom-wrap">
            <div class="rent-details">
                <h6 class="employee">Employee Name: <span>Mr/Mrs {{ $rent->employee_name}}</span></h6>
                <h6 class="customer">Customer Name: <span>Mr/Mrs {{ $rent->customer_name }}</span></h6>
            </div>
        </div>
        <div class="table-wrap">
            <br>
            <br>
            <h3>RENT ITEMS</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rentitems as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Check if $missingitems collection is not empty -->
        @if($missingitems->isNotEmpty())

            <div class="table-wrap">
                <br>
                <br>
                <h3>MISSING ITEMS</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($missingitems as $missingitem)
                        <tr>
                            <td>{{ $missingitem->item_name }}</td>
                            <td>{{ $missingitem->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
         @endif
         <!-- Check if $missingitems collection is not empty -->
         @if($damageitems->isNotEmpty())
         <div class="table-wrap">
             <h3>DAMAGE ITEMS</h3>
             <table class="table">
                 <thead>
                     <tr>
                         <th>Item Name</th>
                         <th>Quantity</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($damageitems as $damageitem)
                     <tr>
                         <td>{{ $damageitem->item_name }}</td>
                         <td>{{ $damageitem->item_quantity }}</td>
                     </tr>
                     @endforeach
                 </tbody>
             </table>
         </div>
     @endif
     <h3>Received Status: {{ $rent->received_status ?? 'N/A' }}</h3>

     @if(!empty($rent->note))
         <h3>Received Note: {{ $rent->note }}</h3>
     @endif
     {{-- // When one or damage note include it show --}}
     @if(!empty($damageitems->first()->damage))
         <h3>Damage Note: {{ $damageitems->first()->damage }}</h3>
     @endif


    </div>
</body>
</html>
