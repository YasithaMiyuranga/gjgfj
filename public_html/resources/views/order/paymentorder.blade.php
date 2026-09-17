@extends('layouts.app')
@section('page-title', __('Accounts'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.order.advanceorder') }}">{{__('Payments Order') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Payments Order List</h3>
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
                                    <th>Is Pay</th>
                                    <th>Pay Amount</th>
                                    <th>Employee_Name</th>
                                    {{-- <th>Action</th> --}}
                                </thead>
                                <tbody>
                                    @foreach ($advanceOrders as $row)
                                        <tr>
                                            <td>{{ $row->order_id }}</td>
                                            <td>{{ $row->booking_date }}</td>
                                            <td>{{ $row->customer_name }}</td>
                                            <td>{{ $row->order_status }}</td>
                                            <td>{{ $row->pay_amount ? 'Yes' : 'No' }}</td>
                                            <td>{{ number_format($row->pay_amount, 2) }}</td>
                                            <td style="white-space: normal; word-wrap: break-word;">
                                                @foreach (explode(',', $row->name) as $employee)
                                                    {{ $employee }}<br>
                                                @endforeach
                                            </td>
                                            {{-- <td>
                                            <form action=" " method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to cancel this order?')">
                                                    <i class="fas fa-times-circle" data-bs-toggle="tooltip" title="cancel"></i>
                                                </button>
                                            </form>
                                        </td> --}}
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
