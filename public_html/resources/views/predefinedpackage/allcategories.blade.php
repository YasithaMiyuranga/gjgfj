@extends('layouts.app')
@section('page-title', __('Predefined Packages'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.predefined.all') }}">{{__('Predefined Category') }}</a>
        {{-- <li class="breadcrumb-item active">{{ __('Update Missing Item Data  ') }}</li> --}}
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Predefined Category List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.add.package.category') }}"
                        data-size="md" data-ajax-popup="true" data-title="{{ __('Add  Category') }}">
                        <i class="ti ti-plus py-1" title="Add Category"></i> {{ __('Add Category') }}
                    </button>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Category  Id</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->category_id  ?? 'N/A' }}</td>
                                            <td>{{ $category->category_name ?? 'N/A' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                data-url="{{ route('useradmin.edit.package.category', $category->category_id) }} "
                                                data-size="md" data-ajax-popup="true" data-title="{{ __('Edit Category') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                                </button>

                                                <form action="{{ route('useradmin.delete.package.category', $category->category_id) }}"
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
