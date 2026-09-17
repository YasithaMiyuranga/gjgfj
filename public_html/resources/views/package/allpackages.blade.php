@extends('layouts.app')
@section('page-title', ('Packages'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.package') }}">{{__('Packages') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Package List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <a href="{{ route('useradmin.package') }}">
                        <button class="btn btn-sm btn-primary"
                            data-title="{{ __('Add Package') }}">
                           <i class="ti ti-plus py-1" title="Add Package"></i> {{ __('Add Package') }}
                        </button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>Package Id</th>
                                    <th>Package Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Price Visible</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Cover Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packagedata as $package)
                                    <tr>
                                        <td>{{ $package->package_id ?? 'N/A' }}</td>
                                        <td>{{ $package->package_name ?? 'N/A' }}</td>
                                        <td>{{ $package->category ?? 'N/A' }}</td>
                                        <td>{{ $package->price ?? 'N/A' }}</td>
                                        <td>{{ $package->price_visible ?? 'N/A' == 1 ? 'Yes' : 'No' }}</td>
                                        <td>{{ $package->status ?? 'N/A' }}</td>
                                        <td>{{ $package->type ?? 'N/A' }}</td>
                                        @if ($package->image == null)
                                            <td>No Image</td>
                                        @else
                                        <td>
                                            <img src="{{ asset( $package->image) }}" width='50' height='50' class="img img-responsive" />
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('useradmin.package.edit', $package->package_id) }}">
                                                <button class="btn btn-sm btn-primary " data-title="{{ ('Edit Package') }}">
                                                    <i class="ti ti-pencil"></i>
                                                </button>
                                            </a>
                                             <!-- upload multiple images -->
                                             <a href="{{ route('useradmin.package.images', $package->package_id)}}">
                                                <button class="btn btn-sm btn-info" data-title="{{ ('Upload Images') }}">
                                                    <i class="fas fa-images"></i>
                                                </button>
                                            </a>
                                            <form action="{{ route('useradmin.package.delete',  $package->package_id) }}"
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
@endsection
