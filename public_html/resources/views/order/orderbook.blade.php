@extends('layouts.app')

@section('page-title', __('Orders'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.order.view') }}">{{ __('Order Booking') }}</a>
    </li>
@endsection
@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Order Booking List</h3>
                </div>
                <hr>
                    <div class=" card-body table-border-style">
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
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($bookingOrders as $row)
                                        <tr>
                                            <td>{{ $row->order_id }}</td>
                                            <td>{{ $row->start_time }}</td>
                                            <td>{{ $row->customer_name }}</td>
                                            <td>{{ $row->order_status }}</td>
                                            <td>{{ $row->pay_amount ? 'Yes' : 'No' }}</td>
                                            <td>{{ number_format($row->pay_amount, 2) }}</td>
                                            <td style="white-space: normal; word-wrap: break-word;">
                                                @foreach (explode(',', $row->name) as $employee)
                                                    {{ $employee }}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('useradmin.order.vieworderitems.edit', $row->order_id) }}">
                                                    <button class="btn btn-sm btn-primary " data-title="{{ __('Edit Order Items') }}">
                                                        <i class="ti ti-pencil"></i>
                                                    </button>
                                                </a>
                                                <form id="cancelOrderForm-{{ $row->order_id }}" action="{{ route('useradmin.order.cancel', $row->order_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button id="cancelOrderButton" type="button" onclick="cancelConfirm({{ $row->order_id }})" class="btn btn-sm btn-warning cancel-order-button">
                                                        <i class="ti ti-x"></i>
                                                    </button>
                                                </form>

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
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this order?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <script>
            function cancelConfirm(formID) {
                $('#confirmModal').modal('show');

                $('#confirmButton').on('click', function() {
                    $('#confirmModal').modal('hide');
                    $('#cancelOrderForm-'+formID+'').submit();
                });

            }
    </script>
@endsection

