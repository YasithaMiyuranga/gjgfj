@extends('layouts.employee')
@section('page-title', __('Task Management'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.taskmanage.employee.show') }}">{{ __('Task Management') }}</a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card d-flex justify-content-center align-items-center" style="height: 300px;">
                <p class="text-center font-weight-bold">This section under development</p>
            </div>
        </div>
    </div>
@endsection
