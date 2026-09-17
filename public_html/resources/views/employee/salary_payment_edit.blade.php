<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.emp.salary.payment.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" name="id" value="{{ $details->id }}" value="admin">
    <input type="hidden" name="created_by" value="admin">

    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Employee Name') }}</label>
        <x-input value="{{ $details->emp_id }}-{{ $details->name }}" id="name" name="name" class="form-control" type="text" required readonly/>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="pay_amount">{{ __('Pay_Amount') }}</label>
        <x-input value="{{ $details->pay_amount }}" id="pay_amount" name="pay_amount" class="form-control" type="text"
            required readonly/>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="payment_status">{{ __('Payment_Type') }}</label>
        <select id="payment_status" name="payment_status" class="form-control" required>
            <option value="Cash"{{ $details->payment_status	 == 'Cash' ? 'selected' : '' }}>Cash</option>
            <option value="Bank"{{ $details->payment_status	 == 'Bank' ? 'selected' : '' }}>Bank</option>
            <option value="Other"{{ $details->payment_status == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Update Payment') }}</button>
        </div>
    </div>
</form>




