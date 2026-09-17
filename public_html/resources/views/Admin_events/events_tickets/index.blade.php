@extends('layouts.events')

@section('page-title', __('Events Tickets'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.events_list') }}">{{ __('Events Tickets List') }}</a>
    </li>
@endsection

@section('content')
<div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Events Tickets List</h3>
                </div>
                <hr>
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <button class="btn btn-sm btn-primary me-2" data-url="{{ route('useradmin.events.ticket_create') }}" data-size="lg"
                        data-ajax-popup="true" data-title="{{ __('Create Events Tickets') }}">
                        <i class="ti ti-plus py-1" data-bs-toggle="tooltip" title="Create Events Tickets"></i>
                        Add Event Tickets
                    </button>
                    <a href="{{ route('useradmin.events.ticket_report_generate') }}">
                        <button class="btn btn-sm btn-primary me-2">
                            <i class="ti ti-report py-1" data-bs-toggle="tooltip" title="Generate Tickets Report"></i>
                            Generate Report
                        </button>
                    </a>
                </div>
                <div class="card-header pb-0 d-flex justify-content-end align-items-center">
                    <a href="{{ route('useradmin.events.ticket_total_report') }}">
                        <button class="btn btn-sm btn-primary me-2">
                            <i class="ti ti-report-analytics py-1" data-bs-toggle="tooltip" title="Generate summary report"></i>
                            Summary 
                        </button>
                    </a>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <th>ID</th>
                                <th>EVENT NAME</th>
                                <th>TICKETS_CATEGORY</th>
                                <th>PRICE</th>
                                <th>CURRENCY</th>
                                <th>NUMBER OF TICKETS</th>
                                <th>REMAINING TICKETS</th>
                                <th>SOLD TICKETS</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->id }}</td>
                                        @foreach($events as $event)

                                            @if($event->eid==$ticket->eid)

                                              <td>{{ $event->event_name }}</td>

                                            @endif

                                        @endforeach
                                        <td>{{ $ticket->tickets_category }}</td>
                                        <td>{{ $ticket->price }}</td>
                                        <td>{{ $ticket->currency }}</td>
                                        <td>{{ $ticket->initial_tickets_count }}</td>
                                        <td>{{ $ticket->number_of_tickets }}</td>
                                        <td>{{ $ticket->baught_tickets_count }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                data-url="{{ route('useradmin.events.ticket_edit', $ticket->id) }} "
                                                data-size="lg" data-ajax-popup="true" data-title="{{ __('Edit Tickets Details') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                data-url="{{ route('useradmin.events.ticket_delete_view', $ticket->id) }} "
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ __('Delete Event Ticket') }}">
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
@endsection
