@extends('layouts.app')
@section('page-title', __('Employees'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.emp.credits.view') }}">{{ __('Emp Credits') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('Add Credits') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Add Credit List</h3>
                </div>
                <hr>
                <div class="card-body">
                    <form action="{{ route('useradmin.emp.credits.store') }}" method="POST" class="form-submit-click">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{('Employee Name *') }}</label><br>
                                    <select id="emp_id" name="emp_id" class="form-control" required {{ old('emp_id')}}>
                                        <option value="">Select employee name</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->emp_id }}">{{ $employee->emp_id }}-{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                  <p class="text-danger">{{ $errors->first('emp_id') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit">{{ ('Credit Amount  *') }}</label>
                                    <input type="number" class="form-control" id="credit" name="credit" value="{{ old('credit')}}" min="1" max="99999999.99" required>
                                </div>
                                <p class="text-danger">{{ $errors->first('credit') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit_date">{{ ('Credit Date   *') }}</label>
                                    <input type="date" class="form-control" id="credit_date" name="credit_date" value="{{ date('Y-m-d') }}" required {{ old('credit_date')}}>
                                </div>
                                  <p class="text-danger">{{ $errors->first('credit_date') }}</p>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label for="credit_status">{{ ('Credit Status   *') }}</label>
                                  <select id="credit_status" name="credit_status" class="form-control" required>
                                      <option value="pending">Pending</option>
                                      <option value="approved" selected>Approved</option>
                                      <option value="rejected">Rejected</option>
                                      {{-- <option value="paid">Paid</option> --}}
                                  </select>
                              </div>
                                <p class="text-danger">{{ $errors->first('credit_status') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="credit_status">{{ ('Payment Type *') }}</label>
                                <select id="payment_type" name="payment_type" class="form-control">
                                    <option value="Cash" selected>Cash</option>
                                    <option value="Bank">Bank</option>
                                </select>
                            </div>
                        </div><br>
                            <button type="submit" id="submitBtn" class="btn btn-primary">{{ ('Create') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
       // Initialize Select2 for  employee name
       $('#emp_id').select2({
            placeholder: "Select an Option",
        });

        $(doument).ready(function() {
           // Submit form on button click
           $('#submitBtn').click(function() {
                 $('#form').submit();
           });
        })
    </script>

@endsection
