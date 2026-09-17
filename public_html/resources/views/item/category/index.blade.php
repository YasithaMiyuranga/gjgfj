@extends('layouts.app')
@section('page-title', __('Items'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.stockcategory.view') }}">{{__('Item Category') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>
                    <h3>Item Category List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-primary btn-sm" data-url="{{ route('useradmin.stockcategory.addform') }}" data-size="md"
                        data-ajax-popup="true" data-title="{{ __('Add Category') }}">
                   <i class="ti ti-plus py-1" title="Add"></i> {{ __('Add Category') }}
                </button>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Category Id</th>
                                        <th>Category Name</th>
                                        <th>Category Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->status }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                    data-url="{{ route('useradmin.stockcategory.edit', $category->id) }}"
                                                    data-size="md" data-ajax-popup="true" data-title="{{ __('Category Edit') }}">
                                                    <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                                </button>

                                                <form action="{{ route('useradmin.stockcategory.delete', $category->id) }}"
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

