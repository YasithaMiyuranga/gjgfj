@extends('layouts.events')

@section('page-title', __(' Agents'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.agents_list') }}">{{ __('Agent List') }}</a>
    </li>
@endsection


@section('content')
    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Agent List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                   <a href="{{ route('useradmin.events.create_agent') }}">
                        <button class="btn btn-sm btn-primary me-2">
                            <i class="ti ti-plus py-1" data-bs-toggle="tooltip" title="Add Agent"></i>
                            Add Agent
                        </button>
                    </a>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                        <thead>
                            <th>Id</th>
                            <th>Agent Name</th>
                            <th>Agent Email</th>
                            <th>Agent Phone</th>
                            <th>Agent Address</th>
                            <th>Agent Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($agents as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->address }}</td>
                                    <td>{{ $row->status }}</td>
                                    <td>
                                        <a href="{{ route('useradmin.events.edit_agent', $row->id) }} ">
                                            <button class="btn btn-sm btn-primary">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                        </a>
                                        <button class="btn btn-sm btn-danger"
                                            data-url="{{ route('useradmin.events.delete_agent_view', $row->id) }} "
                                            data-size="md" data-ajax-popup="true"
                                            data-title="{{ __('Delete Agent') }}">
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
