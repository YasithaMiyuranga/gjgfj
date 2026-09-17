@extends('layouts.app')
@section('page-title', ('Accounts'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.order.creditorder') }}">{{('Credit Order List') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Credit Order List</h3>
            </div>
            <hr>
            <div class=" card-body table-border-style">
                <div class="table-responsive">
                    <table class="table descending-order">
                        <thead>
                                <th>credit_order_Id</th>
                                <th>order_Id</th>
                                <th>Booking_Date</th>
                                <th>Customer_Name</th>
                                <th>Event Name</th>
                                <th>Status</th>
                                <th>Is Pay</th>
                                <th>Final Total</th>
                                <th>Arrears</th>
                                <th>Employee_Name</th>
                                <th>Action</th>

                        </thead>
                        <tbody>
                            @foreach ($OrderDetails as $row)

                                <tr>
                                    <td>{{$row->credit_order_id }}</td>
                                    <td>{{$row->order_id }}</td>
                                    <td>{{$row->booking_date  }}</td>
                                    <td>{{$row->customer_name }}</td>
                                    <td>
                                        {{$row->event_name }}
                                    </td>
                                    <td>{{$row->order_status }}</td>
                                    <td>{{ $row->is_pay ? 'Yes' : 'No' }}</td>
                                    <td>{{ number_format($row->final_amount, 2) }}</td>
                                    <td>{{ number_format(($row->credit_amount), 2) }}</td>
                                    <td style="white-space: normal; word-wrap: break-word;">
                                        @foreach (explode(',', $row->name) as $employee)
                                            {{ $employee }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary me-2"
                                            data-url="{{ route('useradmin.order.creditorderpayment', $row) }}"
                                            data-size="md" data-ajax-popup="true" data-title="{{ ('Credit Order Payments') }}">
                                            <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                        </button>

                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    @endsection
