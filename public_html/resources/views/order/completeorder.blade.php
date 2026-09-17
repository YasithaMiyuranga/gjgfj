@extends('layouts.app')
@section('page-title', __('Accounts'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.order.completeorder') }}">{{__('Complete Order') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Complete Order List</h3>
                </div>
                <hr>
                    <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table descending-order">
                                    <thead>
                                        <th>Id</th>
                                        <th>Booking_Date</th>
                                        <th>Customer_Name</th>
                                        <th>Status</th>
                                        <th>Total Balance</th>
                                        <th>Employee_Name</th>

                                    </thead>
                                    <tbody>
                                        @foreach ($completeOrders as $row)
                                            <tr>
                                                <td>{{ $row->order_id }}</td>
                                                <td>{{ $row->booking_date }}</td>
                                                <td>{{ $row->customer_name }}</td>
                                                <td>{{ $row->order_status }}</td>
                                                <td>{{ number_format($row->pay_amount + $row->final_amount, 2) }}</td>
                                                <td style="white-space: normal; word-wrap: break-word;">
                                                    @foreach (explode(',', $row->name) as $employee)
                                                        {{ $employee }}<br>
                                                    @endforeach
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
