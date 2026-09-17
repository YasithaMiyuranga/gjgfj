@extends('layouts.agent')
@section('page-title', ('Customer Offers'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('agent.offers') }}">{{__('Customer Offers') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Customer Offers</h3>
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
                                <th>Offer ID</th>
                                <th>Customer Name</th>
                                <th>Contact Information </th>
                                <th>Offer Title</th>
                                <th>Offer Details</th>
                                <th>Discount Percentage</th>
                                <th>Offer Start Date</th>
                                <th>Offer Expiry Date</th>
                                <th>Offer Status</th>
                                <th>Actions</th>
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
