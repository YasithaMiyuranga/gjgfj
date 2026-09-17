@extends('layouts.agent')
@section('page-title', ('Ticket'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('agent.tickets') }}">{{__('Ticket') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Ticket List </h3>
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
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <th>Ticket ID</th>
                                <th>Ticket Type</th>
                                <th>Price</th>
                                <th>Assigned Date</th>
                                <th>Buyer Name</th>
                                <th>Buyer Contact</th>
                                <th>Purchase Date</th>
                                <th>Payment Status</th>
                                <th>Actions</th>
                            </thead>
                            {{-- <tbody>
                                <td>
                                    <button class="btn btn-sm" style="background-color: #a3b8fa; color: #ffffff;"
                                        data-url="{{ route('useradmin.rent.history.view', $rent->rent_id) }}"
                                        data-size="md" data-ajax-popup="true" data-title="{{ __('View') }}">
                                        <i class="ti ti-eye py-1" title="View"></i>
                                    </button>
                                </td>
                            </tbody> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
