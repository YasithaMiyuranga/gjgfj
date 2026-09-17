@extends('layouts.app')
@section('page-title', __('Events'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.view') }}">{{__('Events') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Event List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.events.addform') }}"
                        data-size="lg" data-ajax-popup="true"
                        data-title="{{ __('Add Event') }}">
                        <i class="ti ti-plus py-1" title="Add Event"></i> {{ __('Add Event') }}
                    </button>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Event Id</th>
                                        <th>Event Name</th>
                                        <th>Customer Name</th>
                                        <th>Event Date</th>
                                        <th>Event Start Time</th>
                                        <th>Event End Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($events) == 0)
                                        <tr>
                                            <td colspan="10" class="text-center">No Item Found</td>
                                        </tr>
                                    @endif
                                    @foreach ($events as $event)
                                        <tr>
                                            <td>{{ $event->eid}}</td>
                                            <td>{{ $event->event_name }}</td>
                                            <td>
                                                @foreach( $customers as $customer)
                                                    @if($customer->customer_id == $event->customer_id)
                                                        {{ $customer->customer_name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                           
                                            <td>{{ $event->event_date }}</td>
                                            <td>{{ $event->start_datetime }}</td>
                                            <td>{{ $event->end_datetime }}</td>
                                            <td>{{ $event->status == 'pending' || $event->status == 'Ongoing' ? 'Pending' : $event->status }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary "
                                                    data-url="{{ route('useradmin.events.edit', $event->eid) }}"
                                                    data-size="lg" data-ajax-popup="true"
                                                    data-title="{{ ('Edit Event') }}">
                                                    <i class="ti ti-pencil"></i>
                                                </button>
                                                <form action="{{ route('useradmin.events.delete',  $event->eid) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                        <i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="delete"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Choices.js -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endsection


