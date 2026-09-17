@extends('layouts.app')
@section('page-title', ('Rent Package'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.event_rent_packages.index') }}">{{__('Rent  Package') }}</a>
        <li class="breadcrumb-item active">{{ __('Rent Package ') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>
                    <h3>{{ ('Rent Package') }}</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <a href="{{ route('useradmin.event_rent_packages.create') }}" class="btn btn-primary me-2 btn-sm">
                        <i class="ti ti-plus py-1" title="Add"></i> {{ __('Add Rent Item Package') }}
                    </a>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Event Id</th>
                                        <th>Rent Item Package Id</th>
                                        <th>Event Name</th>
                                        <th>Package Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rentItemPackages as $rentItemPackage)
                                        <tr>
                                            <td>{{ $rentItemPackage->event_id }}</td>
                                            <td>{{ $rentItemPackage->id }}</td>
                                            <td>{{ $rentItemPackage->event_name }}</td>
                                            <td>{{ $rentItemPackage->name }}</td>
                                            <td style="white-space: normal; word-wrap: break-word;">{{ nl2br(Str::limit($rentItemPackage->description, 100)) }}</td>
                                            <td>
                                                <a href="{{ route('useradmin.event_rent_packages.edit', $rentItemPackage->id) }}">
                                                    <button class="btn btn-sm btn-primary " data-title="{{ ('Edit') }}">
                                                        <i class="ti ti-pencil"></i>
                                                    </button>
                                                </a>
                                                <form action="{{ route('useradmin.event_rent_packages.destroy', $rentItemPackage->id) }}" method="POST" class="d-inline">
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
@endsection
