@extends('layouts.app')
@section('page-title', __('Rent'))
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div>
                <div class="card-header d-flex justify-content-between align-items-center flex-row">
                    <div>
                        <h5></h5>
                        <h3>Receive Rent Items</h3>
                    </div>
                    <div>
                        <h6 class="text-body">Rent Date : {{ $rent->created_at }} </h6>
                    </div>
                </div>
            </div>
            <hr>
                <div class="card-body table-border-style">
                    <form action="{{ route('useradmin.rent.update', $rent->rent_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- <div class="form-group">
                            <h4>Rent Date : {{ $rent->created_at }} </h4>
                        </div> --}}
                        <div class="form-group">
                            <label for="employee_name" class="form-label"s>Employee Name</label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name"
                                value="{{ $rent->employee_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                value="{{ $rent->customer_name }}" readonly>
                        </div>
                        <div class="table-responsive mt-2">
                            <p id="missingValidationMessage" style="color: red;"></p>
                            <table class="table table-striped  mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-wrap">Item Name</th>
                                        <th class="text-wrap">Sent Quantity</th>
                                        <th class="text-wrap">Missing Quantity</th>
                                        <th class= "text-wrap"> Damaged Quantity</th>
                                        <th class="text-wrap">Received Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rentitems as $rentitem)
                                        <tr>
                                            <td class="text-wrap">{{ $rentitem->item_name }}</td>
                                            <td class="text-center" id="sent_quantity{{ $rentitem->rent_item_id }}">{{ $rentitem->quantity }}</td>
                                            <td class="text-center">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group justify-content-center">
                                                            <div>
                                                                <button type="button" class="btn btn-secondary qty-btn-minus py-2 me-1"
                                                                    onclick="decrementValue(this, '{{ $rentitem->rent_item_id }}')">
                                                                    <i class="ti ti-minus"></i>
                                                                </button>
                                                            </div>
                                                            <div class="col-md-4 px-1">
                                                                <input type="number" readonly max={{ $rentitem->quantity }}
                                                                    min=0 class="form-control"
                                                                    id="missing_quantity_{{ $rentitem->rent_item_id }}"
                                                                    name="missing_quantity[]"
                                                                    value="{{ old('missing_quantity.' . $loop->index, 0) }}"
                                                                     pattern="\d*"
                                                                    oninput="validateQuantity(this, 'missingValidationMessage')"
                                                                    onkeypress="validateInputLength(this, 4)">
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-secondary qty-btn-plus py-2 mx-1"
                                                                    onclick="incrementValue(this, '{{ $rentitem->rent_item_id }}')">
                                                                    <i class="ti ti-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group justify-content-center">
                                                            <div>
                                                                <button type="button" class="btn btn-secondary qty-btn-minus py-2 me-1"
                                                                    onclick="decrementDamagedValue(this, '{{ $rentitem->rent_item_id }}')">
                                                                    <i class="ti ti-minus"></i>
                                                                </button>
                                                            </div>
                                                            <div class="col-md-4 px-1">
                                                                <input type="number" readonly max={{ $rentitem->quantity }}
                                                                    min=0 class="form-control"
                                                                    id="damaged_quantity_{{ $rentitem->rent_item_id }}"
                                                                    name="damaged_quantity[]"
                                                                    value="{{ old('damaged_quantity.' . $loop->index, 0) }}"
                                                                     pattern="\d*"
                                                                    oninput="validateQuantity(this, 'damagedValidationMessage')"
                                                                    onkeypress="validateInputLength(this, 4)">
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn qty-btn-plus py-2 mx-1"
                                                                    onclick="incrementDamagedValue(this, '{{ $rentitem->rent_item_id }}')">
                                                                    <i class="ti ti-plus"></i>
                                                                 </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" readonly max={{ $rentitem->quantity }} min=0
                                                    class="form-control"
                                                    id="received_quantity{{ $rentitem->rent_item_id }}"
                                                    name="received_quantity[]" value="{{ old('received_quantity.' . $loop->index, $rentitem->quantity) }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="received_status" class="form-label">Received Status</label>
                            <select class="form-control" id="received_status" name="received_status" required>
                                {{-- <option value="0" >Select One</option> --}}
                                <option value="Good" {{ old('received_status') == 'Good'? 'selected' : ''}}>Good</option>
                                <option value="Missing" {{ old('received_status') == 'Missing'? 'selected' : ''}} va>Missing</option>
                                <option value="Damage" {{ old('received_status') == 'Damage'? 'selected' : ''}}>Damage</option>
                                <option value="Damage/Missing" {{ old('received_status') == 'Damage/Missing'? 'selected' : ''}}>Damage/Missing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="note" class="form-label">Missing Item Notes </label>
                            <textarea class="form-control" id="note" name="note" rows="3" oninput="validateInputLength(this, 255)">{{ old('note') }}</textarea>
                            @if($errors->has('note'))
                            <span class="text-danger">{{ $errors->first('note') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="damage_note" class="form-label">Damage Item Notes </label>
                            <textarea class="form-control" id="damage_note" name="damage_note" rows="3" oninput="validateInputLength(this, 255)">{{ old('damage_note') }}</textarea>
                            @if($errors->has('damage_note'))
                            <span class="text-danger">{{ $errors->first('damage_note') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Item Received</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        // Page Load Event
        document.addEventListener("DOMContentLoaded", function () {
            // Disable  all  notes
            $('#note').prop('disabled', true).closest('.form-group').hide();
            $('#damage_note').prop('disabled', true).closest('.form-group').hide();
            // Enable submit button
            $('#submitBtn').prop('disabled', false);

        });
        function validateInputLength(input, maxLength) {
            var inputValue = input.value.toString();
            if (inputValue.length > maxLength) {
                input.value = inputValue.slice(0, maxLength);
            }
        }
        //Validate Quantity
        function validateQuantity(input, validationMessageId) {
            var quantity = input.value;
            var validationMessage = document.getElementById(validationMessageId);

            if (quantity < 0) {
                validationMessage.textContent = "Minimum value should be 0.";
                input.setCustomValidity("Minimum value should be 0.");
                input.value = '0';
            } else {
                validationMessage.textContent = "";
                input.setCustomValidity("");
            }
            if (quantity > 10000) {
                input.value = 10000;
                validationMessage.textContent = "Maximum value should be 10000.";
                input.setCustomValidity("Maximum value should be 10000.");
            }
        }


        function incrementValue(button, itemId) {
            // Missing Quantity
            var inputElement = document.getElementById('missing_quantity_' + itemId);
            var currentValue = parseInt(inputElement.value, 10);
            // Received Quantity
            var receivedQuantity = document.getElementById('received_quantity' + itemId);
            var receivedValue = parseInt(receivedQuantity.value, 10);
            // Damage Quantity
            var damageQuantity =document.getElementById('damaged_quantity_' + itemId);
            var damageValue = parseInt(damageQuantity.value, 10);


            if (currentValue < inputElement.max && (damageValue !=  receivedValue)) {
                inputElement.value = currentValue + 1;
                //status change to Missing
                $('#received_status').val("Missing");
                // Reduce received quantity
                var receivedQuantity = document.getElementById('received_quantity' + itemId);
                receivedQuantity.value = receivedQuantity.value - 1;
            }
            // Update received status
           updateReceivedStatus();
        }

        function decrementValue(button, itemId) {
            var inputElement = document.getElementById('missing_quantity_' + itemId);
            var currentValue = parseInt(inputElement.value, 10);
            if (currentValue > 0) {
                inputElement.value = currentValue - 1;
                //Increase received quantity
                var receivedQuantity = document.getElementById('received_quantity' + itemId);
                receivedQuantity.value = parseInt(receivedQuantity.value, 10) + 1;
            }

            // Update received status
            updateReceivedStatus();
        }

        // Damage Items
        function  decrementDamagedValue(button, itemId) {
            var inputElement = document.getElementById('damaged_quantity_' + itemId);
            var currentValue = parseInt(inputElement.value, 10);

            if (currentValue > 0) {
                inputElement.value = currentValue - 1;
                if (inputElement.value == 0) {
                    // Status change to Good
                    $('#received_status').val("Good");
                }
            }
            // Update received status
            updateReceivedStatus();
        }

        function incrementDamagedValue(button, itemId) {
            var inputElement = document.getElementById('damaged_quantity_' + itemId);
            var currentValue = parseInt(inputElement.value, 10);
            var receivedQuantity = document.getElementById('received_quantity' + itemId);
            var sent_quantity = document.getElementById('sent_quantity' + itemId);

            // Check damaged quantity is less than or equal to received quantity
            if (currentValue< receivedQuantity.value ) {
                inputElement.value = currentValue + 1;

                // Status change to Damage
                $('#received_status').val("Damage");
            }
           // Update received status
           updateReceivedStatus();

        }

        function updateReceivedStatus() {
            var missingQuantityElements = document.querySelectorAll('[id^="missing_quantity_"]');
            var damagedQuantityElements = document.querySelectorAll('[id^="damaged_quantity_"]');
            var totalMissingQuantity = 0;
            var totalDamagedQuantity = 0;

            missingQuantityElements.forEach(function(element) {
                totalMissingQuantity += parseInt(element.value, 10);
            });


            // Total damaged quantity
            damagedQuantityElements.forEach(function(element) {
                totalDamagedQuantity += parseInt(element.value, 10);
            });


            var receivedStatus = document.getElementById('received_status');
            // Both missing and damaged quantity are greater than 0
            if(totalDamagedQuantity > 0 && totalMissingQuantity > 0) {
                receivedStatus.value = "Damage/Missing";
                // Enable damage note field
                $('#damage_note').prop('disabled', false).closest('.form-group').show();
                $('#note').prop('disabled', false).closest('.form-group').show();

            }
            else if(totalDamagedQuantity > 0) {
                receivedStatus.value = "Damage";
                  // Enable damage note field
                  $('#damage_note').prop('disabled', false).closest('.form-group').show();
                  // Disable note field
                  $('#note').prop('disabled', true).closest('.form-group').hide();
            }
            else if(totalMissingQuantity > 0) {
                receivedStatus.value = "Missing";
                // Disable damage note field
                $('#damage_note').prop('disabled', true).closest('.form-group').hide();
                // Enable note field
                $('#note').prop('disabled', false).closest('.form-group').show();

            }
            else {
                receivedStatus.value = "Good";
                // Disable damage note field
                $('#damage_note').prop('disabled', true).closest('.form-group').hide();
                // Disable note field
                $('#note').prop('disabled', true).closest('.form-group').hide();
            }


            //calling submit button
            enableSubmitButton();
        }
        $('#received_status').change(function() {
            var received_status = $('#received_status').val();

            if (received_status == 0) {
                $('#submitBtn').prop('disabled', true);
            } else {
                $('#submitBtn').prop('disabled', false);
            }
        });


        function enableSubmitButton()
        {
            var received_status = $('#received_status').val();
            if (received_status == 0) {
                $('#submitBtn').prop('disabled', true);
            } else {
                $('#submitBtn').prop('disabled', false);
            }
        }

    </script>
@endsection
