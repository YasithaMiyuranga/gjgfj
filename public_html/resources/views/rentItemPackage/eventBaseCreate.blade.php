<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form>
    <input type="hidden" id="event_name_hidden" value="{{ $selectedEvent->event_name }}">
    <div class="form-group">
        <label for="event_name">Event Name</label>
        <input type="text" class="form-control" id="event_name" name="event_name" value="{{ $selectedEvent->event_name }}" readonly>
    </div>
   <div class="form-group">
       <label for="package_name" class="form-label">Package Name   *</label>
       <input type="text" name="package_name" id="package_name" class="form-control" value="{{ old('package_name') }}"  maxlength="100" required>
   </div>
    <button type="button" class="btn btn-primary from-prevent-multiple-submits" id="saveBtn">Save</button>
</form>
<script>
    function savePackage() {
        var rentPackage = [];
        //  Check if already added in localstorage
        if (localStorage.getItem('rentPackage')) {
            // Delete existing package
            delete localStorage.rentPackage;
        }
        rentPackage.push({
            event_name: $('#event_name_hidden').val(),
            package_name: $('#package_name').val(),
            package_id: '',
        })
        // Save in local storage
        localStorage.setItem('rentPackage', JSON.stringify(rentPackage));

        $('#commanModel').modal('hide');

    }
    $(document).ready(function() {
        // Save Button Click
        $("#saveBtn").click(function() {
            savePackage();
        })
    });
</script>
