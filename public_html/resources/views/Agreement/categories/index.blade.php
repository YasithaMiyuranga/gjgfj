@extends('layouts.app')
@section('page-title', ('Agreement Categories'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.agreement_categories.index') }}">{{('Agreement Categories') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>{{ ('Agreement Categories') }}</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.agreement_categories.create') }}"
                        data-size="md" data-ajax-popup="true"
                        data-title="{{ ('Add Category') }}">
                        <i class="ti ti-plus py-1" title="Add Category"></i> {{ ('Add Category') }}
                    </button>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Category Id</th>
                                        <th>Category Name</th>
                                        <th>Category Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id}}</td>
                                            <td>{{ $category->name }}</td>
                                            <td style="white-space: normal; word-break: break-word;">{{ $category->description }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary "
                                                    data-url="{{ route('useradmin.agreement_categories.edit', $category->id) }}"
                                                    data-size="md" data-ajax-popup="true"
                                                    data-title="{{ ('Edit Category') }}">
                                                    <i class="ti ti-pencil"></i>
                                                </button>
                                                <form action="{{ route('useradmin.agreement_categories.destroy',  $category->id) }}"
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


