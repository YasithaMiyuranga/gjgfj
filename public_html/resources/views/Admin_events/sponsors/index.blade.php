@extends('layouts.events')
@section('page-title', ('Event Sponsors'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.sponsor.list') }}">{{ __('Sponsor List') }}</a>
    </li>
@endsection

@section('content')
    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Sponsor List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2" data-url="{{ route('useradmin.events.sponsor_create') }}" data-size="md"
                        data-ajax-popup="true" data-title="{{ __('Create Sponsor') }}">
                        <i class="ti ti-plus py-1" data-bs-toggle="tooltip" title="Create Sponsor"></i>
                        Add  Sponsor
                    </button>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <th>Sponsor ID</th>
                                <th>Sponsor Logo</th>
                                <th>Sponsor Name</th>
                                <th>Sponsor Phone</th>
                                <th>Sponser web link</th>
                                <th>Sponsor Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($sponsors as $sponsor)
                                    <tr>
                                        <td>{{ $sponsor->sponsor_id }}</td>
                                        <td><img src="{{ asset($sponsor->sponsor_logo) }}" class="card-img-top" style="width: 50px; height: 50px;" alt="Sponsor Image"></td>
                                        <td>{{ $sponsor->sponsor_name }}</td>
                                        <td>{{ $sponsor->sponsor_phone }}</td>
                                        <td class="text-wrap">{{ $sponsor->sponsor_link }}</td>
                                        <td>{{ $sponsor->status }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                data-url="{{ route('useradmin.events.sponsor_edit', $sponsor->sponsor_id) }} "
                                                data-size="md" data-ajax-popup="true" data-title="{{ ('Edit Sponsor') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                    data-url="{{ route('useradmin.events.sponsor_delete_view', $sponsor->sponsor_id) }} "
                                                    data-size="md" data-ajax-popup="true"
                                                    data-title="{{ ('Delete Sponsor') }}">
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
@endsection
