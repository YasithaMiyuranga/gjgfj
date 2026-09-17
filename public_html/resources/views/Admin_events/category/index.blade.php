@extends('layouts.events')

@section('page-title', __('Events Category'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.category') }}">{{ __('Category List') }}</a>
    </li>
@endsection

@section('content')
    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Category List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.events.category_create') }}"
                        data-size="md" data-ajax-popup="true" data-title="{{ __('Add Category') }}">
                        <i class="ti ti-plus py-1" title="Add Category"></i> {{ __('Add Category') }}
                    </button>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table  descending-order">
                            <thead>
                                <th>ID</th>
                                <th>CATEGORY NAME</th>
                                <th>CREATED_AT</th>
                                <th>UPDATED AT</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>{{ $category->updated_at }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                data-url="{{ route('useradmin.events.category_edit', $category->id) }} "
                                                data-size="md" data-ajax-popup="true" data-title="{{ __('Edit Category') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                data-url="{{ route('useradmin.events.category_delete_view', $category->id) }} "
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ __('Delete Category') }}">
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
    </div>
    </div>
@endsection
