@extends('layouts.app')
@section('page-title', __('Predefined Packages'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.predefined.all') }}">{{__('Predefined Packages') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Predefined Package List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <a href="{{ route('useradmin.predefined') }}">
                    <button class="btn btn-sm btn-primary me-2"
                        data-title="{{ __('Add Package') }}">
                        <i class="ti ti-plus py-1" title="Add Package"></i> {{ __('Add Package') }}
                    </button>
                    </a>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>predefined Id</td>
                                        <th>Package Name</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packagedata as $package)
                                        <tr>
                                            <td> {{ $package->package_id}} </td>
                                            <td>{{ $package->package_name ?? 'N/A' }}</td>
                                            <td>{{ $package->category ?? 'N/A' }}</td>
                                            <td>{{ $package->package_status ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('useradmin.predefined.edit', $package->package_id) }}">
                                                    <button class="btn btn-sm btn-primary " data-title="{{ __('Edit Package') }}">
                                                        <i class="ti ti-pencil"></i>
                                                    </button>
                                                </a>
                                                <form action="{{ route('useradmin.predefined.delete',  $package->package_id) }}"
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
@endsection
