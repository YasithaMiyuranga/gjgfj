{{-- @extends('layouts.app') --}}
@extends('layouts.events')
@section('page-title', __('Managers'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.viewmanager') }}">{{ __('Manager Register') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Manager List</h3>
            </div>
            <hr>
            <div class="card-header pb-0">
                <button class="btn btn-sm btn-primary me-2"
                    data-url="{{ route('useradmin.man.create') }}"
                    data-size="lg" data-ajax-popup="true" data-title="{{ __('Add Manager') }}">
                 <i class="ti ti-plus py-1" title="Add Manager"></i> {{ __('Add Manager') }}
                </button>
            </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                    <th>Manager_Id</th>
                                    <th>Manager_Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($viewmanagers as $row)
                                    <tr>
                                        <td>{{$row->manager_id }}</td>
                                        <td>{{$row->name }}</td>
                                        <td>{{$row->email }}</td>
                                        <td>{{$row->mobile }}</td>
                                        <td>{{$row->status }}</td>
                                        <td>
                                            {{-- <button class="btn btn-sm btn-warning"
                                                data-url="{{ route('useradmin.assign-permissions.create', $row->manager_id) }}"
                                                data-size="lg" data-ajax-popup="true" data-title="{{ __('Assign Permission') }}">
                                                <i class="ti ti-lock py-1" data-bs-toggle="tooltip" title="Assign Permission"></i>
                                            </button> --}}
                                            <button type="button" class="btn btn-sm btn-info" onclick="copyEmail('{{$row->email}}')">
                                                <i class="ti ti-copy py-1" data-bs-toggle="tooltip" title="Copy Email"></i>
                                            </button>
                                            <a href="javascript:void(0)" onclick="showAlert('To open in private/incognito mode, use Ctrl+Shift+N or Command+Shift+N and paste the link. {{ route('manager.login') }}');">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Login">
                                                    <i class="ti ti-eye"></i>
                                                </button>
                                            </a>
                                            <button class="btn btn-sm btn-primary"
                                            data-url="{{ route('useradmin.man.edit', $row->manager_id) }} "
                                            data-size="lg" data-ajax-popup="true" data-title="{{ __('Edit Manager') }}">
                                            <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <form action="{{ route('useradmin.man.delete', $row->manager_id) }} " method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger show_confirm" >
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


<div id="customAlert" class="alert d-none alert-dismissible fade show position-fixed top-0 end-0 m-4" role="alert" style="z-index: 1050; min-width: 250px;">
    <span id="customAlertMessage"></span>
    <button type="button" class="btn-close" aria-label="Close" onclick="hideAlert()"></button>
</div>
<script>
    function showAlert(message, type = 'success') {
        const alertBox = document.getElementById('customAlert');
        const alertMessage = document.getElementById('customAlertMessage');

        alertBox.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-4`;
        alertMessage.textContent = message;
        alertBox.classList.remove('d-none');

        // Auto-hide after 3 seconds
        // setTimeout(() => {
        //     hideAlert();
        // }, 3000);
    }

    function hideAlert() {
        const alertBox = document.getElementById('customAlert');
        alertBox.classList.add('d-none');
    }

    function copyEmail(email) {
        navigator.clipboard.writeText(email).then(function () {
            showAlert('Email copied to clipboard', 'success');
        }, function (err) {
            showAlert('Error copying email', 'danger');
        });
    }
</script>


<script>
    function copyEmail(email) {
        navigator.clipboard.writeText(email).then(function() {
            showAlert('Email copied to clipboard', 'success');
        }, function(err) {
            showAlert('Error copying email: ', err);
        });
    }
</script>

@endsection

