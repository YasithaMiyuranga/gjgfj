@extends('layouts.events')

@section('page-title', __('Event Coupons'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.ticket.coupon.list') }}">{{ __('Coupon List') }}</a>
    </li>
@endsection


@section('content')
    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Coupon List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2" data-url="{{ route('useradmin.events.ticket.coupon_create') }}" data-size="md"
                        data-ajax-popup="true" data-title="{{ __('Create Coupon') }}">
                        <i class="ti ti-plus py-1" data-bs-toggle="tooltip" title="Create Coupon"></i>
                        Add  Coupon
                    </button>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <th>COUPON  ID</th>
                                <th>EVENT   ID AND NAME</th>
                                <th>EVENT   DATE</th>
                                <th>COUPON NAME</th>
                                <th>COUPON CODE</th>
                                <th>DISCOUNT PERCENTAGE</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @foreach ($couponList as $coupon)
                                    <tr>
                                        <td>{{ $coupon->id }}</td>
                                       <td>{{ $coupon->event_id }} {{ $coupon->event->event_name }}</td>
                                        <td>{{ date('Y-m-d', strtotime($coupon->event_date)) }}</td>
                                        <td>{{ $coupon->name }}</td>
                                        <td>{{ $coupon->coupon_no }}</td>
                                        <td>{{ $coupon->discount_percentage == null ? '-' : $coupon->discount_percentage }} </td>
                                        <td>{{ $coupon->status }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                data-url="{{ route('useradmin.events.ticket.coupon_edit', $coupon->id) }} "
                                                data-size="md" data-ajax-popup="true" data-title="{{ __('Edit Coupon') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                data-url="{{ route('useradmin.events.ticket_coupon_delete_view', $coupon->id) }} "
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ __('Delete Coupon') }}">
                                                <i class="ti ti-trash py-1" data-bs-toggle="tooltip" title="delete"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection
