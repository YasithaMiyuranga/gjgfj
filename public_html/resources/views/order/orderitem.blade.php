@extends('layouts.app')
@section('page-title', __('Orders'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.order.view') }}">{{ $title }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>{{ $title }}</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Order NO</th>
                                        <th>Customer Name</th>
                                        <th>Order Type</th>
                                        <th>Order Status</th>
                                        <th>Booking Date</th>
                                        <th>Invoice Date</th>
                                        <th>Recieved Amount</th>
                                        <th>Grand Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $order)
                                        <tr>
                                            <td>{{ $order->order_id  ?? 'N/A' }}</td>
                                            <td>{{ $order->customer_name ?? 'N/A' }}</td>
                                            <td>{{ $order->order_type  ?? 'N/A' }}</td>
                                            <td>{{ $order->order_status  ?? 'N/A' }}</td>
                                            <td>{{ $order->booking_date  ?? 'N/A' }}</td>
                                            <td>{{ $order->inv_date  ?? 'N/A' }}</td>

                                            <td>{{ $order->pay_amount   ?? 'N/A' }}</td>
                                            <td>
                                                @if(isset($order->pay_amount) && isset($order->final_amount))
                                                {{ number_format($order->pay_amount + $order->final_amount, 2) }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($order->order_type == 'quotation')
                                                    <button class="btn btn-sm btn-info-disabled " data-title="{{ __('View Cash Flow') }}" disabled>
                                                        <i class="ti ti-cash"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('useradmin.order.cashflow', $order->order_id) }}">
                                                        <button class="btn btn-sm btn-info " data-title="{{ __('View Cash Flow') }}" >
                                                            <i class="ti ti-cash"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                                <a href="{{ route('useradmin.order.vieworderitems.edit', $order->order_id) }}">
                                                    <button class="btn btn-sm btn-primary " data-title="{{ __('Edit Order Items') }}">
                                                        <i class="ti ti-pencil"></i>
                                                    </button>
                                                </a>
                                                <form id="cancelOrderForm-{{ $order->order_id }}" action="{{ route('useradmin.order.cancel', $order->order_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    {{-- <button id="cancelOrderButton" type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to cancel this order?')"> --}}
                                                    <button id="cancelOrderButton" type="button" onclick="cancelConfirm({{ $order->order_id }})" class="btn btn-sm btn-warning cancel-order-button">
                                                        <i class="ti ti-x"></i>
                                                    </button>
                                            </form>
                                                <form id="deleteOrderForm" action="{{ route('useradmin.order.delete', $order->order_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button id="deleteOrderButton" type="button" class="btn btn-sm btn-danger show_confirm" >
                                                        <i class="ti ti-trash"></i>
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
