@extends('layouts.app')
@section('page-title', __('Edit Employee Credits'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.purchaseorder.view') }}">{{__('Purchase Orders') }}</a>
        <li class="breadcrumb-item active">{{ __('Edit Employee Credits') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Edit Employee Credits</h3>
                </div>
                <hr>
                <div class="card-body">
                    <form action="{{ route('useradmin.emp.credits.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $credit->Employee_credit_id }}">
                        <input type="hidden" name="emp_id" class="form-control" type="hidden" value={{ $credit->employee_id }}>
                        <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="name">{{ ('Employee Name   *') }}</label><br>
                                   <input id="emp_name" name="emp_name" class="form-control" type="text" value={{ $employee_details->name }}  readonly>
                               </div>
                           </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit">{{ ('Credit Amount  *') }}</label>
                                    <input type="number" class="form-control" id="credit" name="credit" value="{{ $credit->credit_amount }}" min="1"  max="99999999.99" {{ old('credit') }} required {{ ($credit->credit_status == 'approved' || $credit->credit_status == 'paid') ? 'readonly' : '' }}>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit_date">{{ ('Credit Date   *') }}</label>
                                    <input type="date" class="form-control" id="credit_date" name="credit_date" value="{{ $credit->credit_date }}" required {{ ($credit->credit_status == 'approved' || $credit->credit_status == 'paid') ? 'readonly' : '' }}>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit_status">{{ ('Credit Status   *') }}</label>
                                    <select id="credit_status" name="credit_status" class="form-control" {{ $credit->credit_status == 'paid' ? 'disabled' : '' }} required>
                                        @if ($credit->credit_status == 'approved')
                                            <option value="approved" {{ $credit->credit_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="paid" {{ $credit->credit_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        @elseif ($credit->credit_status == 'pending')
                                            <option value="pending" {{ $credit->credit_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $credit->credit_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $credit->credit_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        @elseif ($credit->credit_status == 'rejected')
                                            <option value="rejected" {{ $credit->credit_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="pending" {{ $credit->credit_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $credit->credit_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        @else
                                            <option value="pending" {{ $credit->credit_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $credit->credit_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $credit->credit_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="paid" {{ $credit->credit_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="credit_status">{{ ('Payment Type *') }}</label>
                                <select id="payment_type" name="payment_type" class="form-control">
                                    <option value="Cash" {{ $credit->payment_type == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Bank" {{ $credit->payment_type == 'Bank' ? 'selected' : '' }}>Bank</option>
                                </select>
                            </div>
                        </div><br>
                        <button type="submit" class="btn btn-primary" {{ $credit->credit_status == 'paid' ? 'disabled' : '' }}>{{ ('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
