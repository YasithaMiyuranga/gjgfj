@extends('layouts.events')
@section('page-title', __(' Ticketsales'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.agent_ticket_sale') }}">{{ ('Agents Ticketsales') }}</a>
    </li>
@endsection
@section('content')
    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Agents Ticketsales</h3>
                </div>
                <hr>
                {{-- <div class="card-header pb-0">
                    <a href="{{ route('useradmin.events.create_agent') }}">
                        <button class="btn btn-sm btn-primary me-2">
                            <i class="ti ti-plus py-1" data-bs-toggle="tooltip" title="Add Agent"></i>
                            Add Agent
                        </button>
                    </a>
                </div> --}}
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <a href="">
                        <button class="btn btn-sm btn-primary me-2">
                            <i class="ti ti-report-analytics py-1" data-bs-toggle="tooltip" title="Agents tickets sales report"></i>
                            Generate Report
                        </button>
                    </a>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <th>Agent ID</th>
                                <th>Agent Name</th>
                                <th>Event Name </th>
                                <th>Event Date </th>
                                <th>Total Tickets Assigned</th>
                                <th>Tickets Sold</th>
                                <th>Remaining Tickets</th>
                                <th>Total Sales Revenue</th>
                                <th>Commission Earned </th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                {{-- @foreach ($agents as $agent)
                                    <tr>
                                        <td>{{ $agent->agent_id }}</td>
                                        <td>{{ $agent->agent_name }}</td>
                                        <td>{{ $agent->event_name }}</td>
                                        <td>{{ $agent->event_date }}</td>
                                        <td>{{ $agent->total_tickets_assigned }}</td>
                                        <td>{{ $agent->tickets_sold }}</td>
                                        <td>{{ $agent->remaining_tickets }}</td>
                                        <td>{{ $agent->total_sales_revenue }}</td>
                                        <td>{{ $agent->commission_earned }}</td>
                                        <td>
                                            <a href="{{ route('useradmin.events.agent_ticketsales', $agent->id) }}">
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="ti ti-eye py-1" data-bs-toggle="tooltip" title="view"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
