<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.ticket.coupon_store') }}" enctype="multipart/form-data" id="addCouponForm" data-ajax="true">
    @csrf
    <div class="col-md-12">
        <div class="form-group">
            <label for="event_id" class="form-label">{{ ('Event_ID   *') }}:</label>
            <select class="form-control select2" name="event_id" id="event_id" required>
                <option>Select Event ID</option>
                @foreach ($eventsIds as $eventsId)
                    <option value="{{ $eventsId->eid }}"
                        {{ old('eid') == $eventsId->eid ? 'selected' : '' }}>
                        {{ $eventsId->eid }}-{{ $eventsId->event_name }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('event_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Coupon Name *') }}</label>
        <x-input id="name" name="name" class="form-control" type="text" required />
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="event_date" class="form-label">{{ ('Event Date *') }}</label>
            <input type="text" class="form-control" name="event_date" id="event_date" required readonly
                value="{{ old('eventdate') }}">
        </div>
        @error('event_date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="coupon_no">{{ ('Coupon Number  *') }}</label>
        <x-input id="coupon_no" name="coupon_no" class="form-control" type="number" required />
        @error('coupon_no')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="discount">{{ ('Discount Amount') }}:</label><label class="form-label" for="discount">{{ ('%  *') }}:</label>
        <x-input id="discount" max='99' name="discount_percentage" class="form-control" type="number" required />
        @error('discount')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="status">{{ ('Status  *') }}:</label>
        <select id="status" name="status" class="form-control" required>
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ ('Active') }}</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ ('Inactive') }}</option>
        </select>
        @error('status')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Add Coupon') }}</button>
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
        $('#event_id').change(function() {
            var eventId = $(this).val();

            $.ajax({
                    url: '/useradmin/get-event-date',  //  route path
                    method: 'POST',  // Use POST request
                    data: { eid: eventId },
                    success: function(response) {


                        $('#event_date').val(response.event_date);

                    },
                    error: function(xhr, status, error) {
                        console.error(error);

                    }
               });
        });

        // Initialize Choices for the order_id dropdown
        const orderIdChoice = new Choices('#event_id', {
            placeholder: true,
            searchEnabled: true,
        });
    });
</script>
