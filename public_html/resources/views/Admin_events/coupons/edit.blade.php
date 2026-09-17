<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.ticket.coupon_update', [ $couponDetails->id ]) }}"
    enctype="multipart/form-data" id="editCouponForm" data-ajax="true">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="event_id">{{ __('Event ID    *') }}:</label>
        <x-input value="{{ $couponDetails->event_id }}" id="event_id" name="event_id" class="form-control" type="text"  readonly/>
    </div>
    <div class="form-group mb-3">
        <label for="coupon_name" class="form-label">{{_('Coupon Name    *')}}:</label>
        <x-input value="{{ $couponDetails->name }}" id="coupon_name" name="coupon_name" class="form-control" type="text" required />
    </div>
    <div class="form-group mb-3">
        <label for="event_date" class="form-label">{{_('Event Date  *')}}:</label>
        <x-input value="{{ $couponDetails->event_date}}" id="event_date" name="event_date" class="form-control" type="text"  readonly />
    </div>
    <div class="form-group mb-3">
        <label for="coupon_no" class="form-label">{{_('Coupon Number    *')}}:</label>
        <x-input value="{{ $couponDetails->coupon_no}}" id="coupon_no" name="coupon_no" class="form-control" type="number" required  />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="discount">{{ ('Discount Amount') }}:</label><label class="form-label" for="discount">{{ ('%  *') }}:</label>
        <x-input id="discount" name="discount_percentage" class="form-control" type="number" value="{{ $couponDetails->discount_percentage }}" required />
        @error('discount')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="status">{{ ('Status  *') }}:</label>
        <select id="status" name="status" class="form-control" required>
            <option value="active" {{ $couponDetails->status == 'active' ? 'selected' : '' }} {{ old('status') == 'active' ? 'selected' : '' }}>{{ ('Active') }}</option>
            <option value="inactive"  {{ $couponDetails->status == 'inactive' ? 'selected' : '' }} {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ ('Inactive') }}</option>
        </select>
        @error('status')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Update Coupon') }}</button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {

        // Initialize Flatpickr
        flatpickr("#event_date", {
            enableTime: false,
            dateFormat: "Y-m-d"
        })
    });
</script>

