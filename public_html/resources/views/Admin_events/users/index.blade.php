@extends('layouts.events')

@section('page-title', __('Users'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.user_list') }}">{{ __('User List') }}</a>
    </li>
@endsection


@section('content')
    <div class="mb-4"></div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>User List</h3>
                </div>
                <hr>
                {{-- <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.user.store') }}"
                        data-size="lg" data-ajax-popup="true" data-title="{{ __('Add User') }}">
                        <i class="ti ti-plus py-1" title="Add User"></i> {{ __('Add User') }}
                    </button>
                </div> --}}
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <a href="{{ route('useradmin.events.report') }}">
                        <button class="btn btn-sm btn-primary me-2">
                            <i class="ti ti-report-analytics py-1" data-bs-toggle="tooltip" title="Generate summary report"></i>
                            Users Report
                        </button>
                    </a>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <th>ID</th>
                                <th>USER NAME</th>
                                <th>MOBILE NO</th>
                                <th>EMAIL</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)

                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->status }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary me-2"
                                                data-url="{{ route('useradmin.events.edit_user', $user->id) }} "
                                                data-size="md" data-ajax-popup="true" data-title="{{ __('Edit User Status') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
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
