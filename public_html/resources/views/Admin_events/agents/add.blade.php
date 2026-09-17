@extends('layouts.events')
@section('page-title', ('Agent Create'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.ticket.list') }}">{{ __('Agent List') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('Create New Agents') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card px-4 ">
            <div class="card-header card-body table-border-style">
                <div class="col-xl-12">
                    <form method="post" action="{{ route('useradmin.events.agets.store') }}" id="agentAddForm">
                        @csrf
                        <?php
                        $user = Auth::user();
                        ?>
                        <div  class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-label" for="name">{{ ('Name *') }}</label>
                                    <x-input id="name" name="name" class="form-control" type="text" required maxlength="255" value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="email">{{ ('Email *') }}</label>
                                    <x-input id="email" name="email" class="form-control" type="email" required maxlength="255" value="{{ old('email')}}" />
                                    @error('email')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div  class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="phone">{{ ('Phone    *') }}</label>
                                    <x-input id="phone" name="phone" class="form-control" type="text" required maxlength="10" value="{{ old('phone')}}"/>
                                    @error('phone')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="address">{{ ('Address') }}</label>
                                    <x-input id="address" name="address" class="form-control" type="text"  maxlength="255"  value="{{ old('address')}}"/>
                                    @error('address')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div  class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="city">{{ ('City ') }}</label>
                                    <x-input id="city" name="city" class="form-control" type="text"  maxlength="100" value="{{ old('city')}}"/>
                                    @error('city')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="state">{{ ('State ') }}</label>
                                    <x-input id="state" name="state" class="form-control" type="text"  maxlength="100" value="{{ old('state')}}"/>
                                    @error('state')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div  class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="zip">{{ ('ZIP ') }}</label>
                                    <x-input id="zip" name="zip" class="form-control" type="text"  maxlength="8" minlength="4"  value="{{ old('zip')}}"/>
                                    @error('zip')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">{{ ('Status *') }}</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : ''}}>{{ ('Active') }}</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : ''}}>{{ ('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div  class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="type">{{ ('Type *') }}</label>
                                    <select id="type" name="type" class="form-control" required>
                                        <option value="sales" {{ old('type') == 'sales' ? 'selected' : ''}}>{{ ('Sales') }}</option>
                                        <option value="support" {{ old('type') == 'support' ? 'selected' : ''}}>{{ ('Support') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                               <div class="form-group">
                                   <label class="form-label" for="password">{{ ('Password *') }}</label>
                                   <x-input id="password" name="password" class="form-control" type="text" required minlength="8" maxlength="20" value="{{ old('password')}}" />
                                   @error('password')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                               </div>
                            </div>
                        </div>
                        <div  class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="event_id">{{ ('Event') }}</label><br>
                                    <div id="selected-events"></div>
                                     <select id="event_id" name="event_id[]" class="form-control select2" multiple placeholder="Select an event">
                                         @foreach ($events as $event)
                                         <option value="{{ $event->eid }}"
                                            {{ in_array($event->eid, old('event_id', [])) ? 'selected' : '' }}>
                                             {{ $event->event_name }}
                                             </option>
                                             @endforeach
                                         </select>
                                     </div>
                                     <div id="alleventboxdiv" style="display: block">
                                        <input type="checkbox" name="event_id[]" value="allevent" id="alleventbox" onclick="toggleSelect(this)">
                                         <span>  All Events</span>
                                     </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                        <div class="mb-3 mt-3">
                           <button class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits" id="addBtn" type="submit">
                               {{ ('Add Agent') }}
                           </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Include Select2 library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
     // Initialize Select2 for event name
     $('#event_id').select2({
     })

    // Get the checkbox and select elements
    const checkbox = document.getElementById('alleventbox');
    const select = document.getElementById('event_id');

    // Add event listener to the checkbox
    checkbox.addEventListener('change', function() {
      if (this.checked) {
        // Disable the select option
        select.disabled = true;
        // Hide the select option
        select.style.display = 'none';
        // Select all options
        select.querySelectorAll('option').forEach(option => option.selected = true);
      } else {
        // Enable the select option
        select.disabled = false;
        // Show the select option
        select.style.display = 'block';
        // Deselect all options
        select.querySelectorAll('option').forEach(option => option.selected = false);
      }
    });

    // Event listener for the select option when select alleventboxdiv hide
    const div = document.getElementById('alleventboxdiv');


    // Event listener for the select option when select alleventboxdiv hide
    // We are using select2:select event here to detect when the user selects an option
    // from the dropdown. When the user selects an option, we hide the div
    // containing the checkbox and label.
    $('#event_id').on('select2:select', function(e) {
        var customerName = e;

        if( customerName ) {
            // Hide the div when an option is selected
            div.style.display = 'none';
        }
        else{
            // Show the div when no option is selected
            div.style.display = 'block';
        }
    });

    // Event listener for the select option when select alleventboxdiv hide
    // We are using the change event here to detect when the user selects an option
    // from the dropdown. When the user selects an option, we hide the div
    // containing the checkbox and label.
    $('#event_id').on('change', function() {
        if ($(this).val().length === 0) {
            // Show the div when no option is selected
            div.style.display = 'block';
        } else {
            // Hide the div when an option is selected
            div.style.display = 'none';
        }
    });

    /**
     * Toggle the select option based on the checkbox state.
     * If the checkbox is checked, the select option will be disabled and hidden.
     * If the checkbox is unchecked, the select option will be enabled and shown.
     * @param {HTMLInputElement} checkbox The checkbox element.
     */
    function toggleSelect(checkbox) {
      const select = document.getElementById('event_id');
      if (checkbox.checked) {
        // Disable and hide the select option when the checkbox is checked
        select.disabled = true;
        select.style.display = 'none';
        select.querySelectorAll('option').forEach(option => option.selected = true);
      } else {
        // Enable and show the select option when the checkbox is unchecked
        select.disabled = false;
        select.style.display = 'block';
        select.querySelectorAll('option').forEach(option => option.selected = false);
      }
    }

    $(document).ready(function () {
        // Phone number validation
        document.getElementById('phone').addEventListener('input', function (e) {
            const phoneInput = e.target;
            const phonePattern = /^[0-9]{10}$/;
            if (phoneInput.value === '') {
                phoneInput.setCustomValidity('Phone number is required.');
            } else if (phonePattern.test(phoneInput.value)) {
                phoneInput.setCustomValidity('');
            } else {
                phoneInput.setCustomValidity('Please enter a valid 10-digit phone number.');
            }
        });

        // ZIP validation
        document.getElementById('zip').addEventListener('input', function (e) {
            const zipInput = e.target;
            const zipPattern = /^[0-9]{5,6}$/; // Adjust pattern based on ZIP format
            if (zipInput.value === '') {
                zipInput.setCustomValidity('ZIP code is required.');
            } else if (zipPattern.test(zipInput.value)) {
                zipInput.setCustomValidity('');
            } else {
                zipInput.setCustomValidity('Please enter a valid ZIP code.');
            }
        });

    let isSubmitting = false;

    document.getElementById('addBtn').addEventListener('click', function() {
        if (!isSubmitting) {
            isSubmitting = true;
            // Disable the button
            this.disabled = true;
            // Submit the form
            this.form.submit();
        }
    });

    document.getElementById('addBtn').form.addEventListener('submit', function() {
        // Re-enable the button after the form submission is complete
        document.getElementById('addBtn').disabled = false;
        isSubmitting = false;
    });
    });
</script>
@endsection
