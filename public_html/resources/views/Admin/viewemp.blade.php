@extends('layouts.app')
@section('page-title', __('Employees'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.viewemployee') }}">{{ __('Emp Register') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Employee List</h3>
            </div>
            <hr>
            <div class="card-header pb-0">
                <button class="btn btn-sm btn-primary me-2"
                    data-url="{{ route('useradmin.emp.store') }}"
                    data-size="lg" data-ajax-popup="true" data-title="{{ __('Add Employee') }}">
                 <i class="ti ti-plus py-1" title="Add Employee"></i> {{ __('Add Employee') }}
                </button>
            </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                    <th>Emp_Id</th>
                                    <th>Emp_Name</th>
                                    <th>Email</th>
                                    <th>Emp_Type</th>
                                    <th>Basic_Amount</th>
                                    <th>Net Salary</th>
                                    <th>Phone No</th>
                                    <th>Code</th>
                                    <th>Active</th>
                                    <th style="text-align: center;">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($viewemployees as $row)
                                    <tr>
                                        <td>{{$row->emp_id }}</td>
                                        <td>{{$row->name }}</td>
                                        <td>{{$row->email }}</td>
                                        <td>{{$row->emp_type }}</td>
                                        <td>{{ number_format($row->basic_amount, 2) }}</td>
                                        <td>{{ number_format($row->net_salary, 2) }}</td>
                                        <td>{{$row->mobile }}</td>
                                        <td>{{$row->code }}</td>
                                        <td>{{$row->active }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning"
                                                data-url="{{ route('useradmin.assign-permissions.create', $row->emp_id) }}"
                                                data-size="lg" data-ajax-popup="true" data-title="{{ __('Assign Permission') }}">
                                                <i class="ti ti-lock py-1" data-bs-toggle="tooltip" title="Assign Permission"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-info" onclick="copyEmail('{{$row->email}}')">
                                                <i class="ti ti-copy py-1" data-bs-toggle="tooltip" title="Copy Email"></i>
                                            </button>
                                            <a href="javascript:void(0)" onclick="showCustomAlert('To open in private/incognito mode, use Ctrl+Shift+N or Command+Shift+N and paste the link. {{ route('emp.loginemp') }}');">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Login">
                                                    <i class="ti ti-eye"></i>
                                                </button>
                                            </a>
                                            <button class="btn btn-sm btn-primary"
                                            data-url="{{ route('useradmin.emp.edit', $row->emp_id) }} "
                                            data-size="lg" data-ajax-popup="true" data-title="{{ __('Edit Employee') }}">
                                            <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            <form action="{{ route('useradmin.emp.delete', $row->emp_id) }} " method="POST" class="d-inline">
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
<script>
    function copyEmail(email) {
        navigator.clipboard.writeText(email).then(function() {
            showCustomAlert('Email copied to clipboard', 'success');
        }, function(err) {
            showCustomAlert('Error copying email: ', err);
        });
    }
</script>
@endsection

