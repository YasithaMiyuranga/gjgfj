@extends('layouts.events')

@section('page-title', __('Transactions'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.ticket.coupon.list') }}">{{ __('Transactions List') }}</a>
    </li>
@endsection


@section('content')
    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Transactions List</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <th>Event ID</th>
                                <th>Event Name</th>
                                <th>Event Date</th>
                                <th>Event Start Time</th>
                                <th>Event End Time</th>
                                <th>Transactions Count</th>
                                <th>Total</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr>
                                        @php
                                            $transactions_count = 0;
                                            $total = 0;
                                        @endphp

                                        @foreach ($event->transactions as $transaction)
                                            @php
                                                $transactions_count += 1;
                                                $total += $transaction->amount;
                                            @endphp
                                        @endforeach
                                        <td>{{ $event->eid }}</td>
                                        <td>{{ $event->event_name }}</td>
                                        <td>{{ $event->event_date }}</td>
                                        <td>{{ $event->start_datetime }}</td>
                                        <td>{{ $event->end_datetime }}</td>
                                        <td>{{ $transactions_count }}</td>
                                        <td>{{ $total }}</td>

                                        <td>
                                            <button class="btn btn-sm btn-primary me-2" data-url="{{ route('useradmin.transaction.show', $event->eid) }}" data-size="lg"
                                                data-ajax-popup="true" data-title="{{ $event->event_name }}">
                                                <i class="ti ti-eye py-1" data-bs-toggle="tooltip" title="view"></i>
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
