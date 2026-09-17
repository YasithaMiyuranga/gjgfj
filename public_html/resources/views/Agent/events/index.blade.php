@extends('layouts.agent')
@section('page-title', ('Assigned Events'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('agent.events') }}">{{__('Assigned Events') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Assigned Events</h3>
            </div>
            <hr>
            {{-- <div class="card-header pb-0">
                <a href="{{ route('t') }}">
                    <button class="btn btn-sm btn-primary me-2">
                        <i class="fas fa-user-edit py-1" data-bs-toggle="tooltip" title="name"></i>
                        Name
                    </button>
                </a>
            </div> --}}
                <div class="card-header pb-0">
            </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <th>Event Name</th>
                                <th>Event Date</th>
                                <th>Assigned Ticket Count</th>
                                <th>Sold Ticket Count</th>
                                <th>Event Location</th>
                                <th>Commission Earned</th>
                                <th>Event Status</th>
                                <th>Event Description</th>
                            </thead>
                            <tbody>
                                {{-- <td>
                                    <button class="btn btn-sm" style="background-color: #a3b8fa; color: #ffffff;"
                                        data-url=""
                                        data-size="md" data-ajax-popup="true" data-title="{{ __('View') }}">
                                        <i class="ti ti-eye py-1" title="View More Details"></i>
                                    </button>
                                </td> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
