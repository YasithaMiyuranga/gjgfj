@extends('layouts.app')
@section('page-title', __('Rent'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.rent.missing') }}">{{__('Missing Items') }}</a>
        <li class="breadcrumb-item active">{{ __('Update Missing Item Data  ') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Update Missing Item Data</h3>
                </div>
                <hr>
                <div class="card-body">
                    <form action="{{ route('useradmin.missing.update', $rent->rent_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class=" row form-group">
                            <div class="col-md-6">
                                <h5>Rent Date : {{ $rent->created_at }} </h5>
                            </div>
                            <div class="col-md-6">
                                <h5>Received Date : {{ $rent->updated_at }} </h5>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="employee_name" class="form-label">Employee Name</label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name"
                                value="{{ $rent->employee_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                value="{{  $rent->customer_name }}" readonly>
                        </div>
                        <div class="table-responsive mt-2 ordertable cash-flows-table order-items">
                            <p id="missingValidationMessage" style="color: red;"></p>
                            <table class="table dataTable mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-wrap">Item Name</th>
                                        <th class="text-center">Missing Quantity</th>
                                        <th class="text-center">Received Quantity</th>
                                        <th class="text-wrap">Remaining Missing Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($missingitems as $missingitem)
                                        <tr>
                                            <td class="text-wrap">{{ $missingitem->item_name }}</td>
                                            <td class="text-center">{{ $missingitem->quantity }}</td>
                                            <td class="text-center">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <div class="justify-content-center">
                                                                <button type="button" class="btn btn-secondary qty-btn-minus py-2 me-1"
                                                                    onclick="decrementValue(this, '{{ $missingitem->missing_id }}')">
                                                                    <i class="ti ti-minus"></i>
                                                                </button>
                                                            </div>
                                                            <div class="col-md-4 px-1">
                                                                <input type="number" readonly
                                                                    max={{ $missingitem->quantity }} min=0
                                                                    class="form-control"
                                                                    id="received_quantity{{ $missingitem->missing_id }}"
                                                                    name="received_quantity[]" value="0" pattern="\d*"
                                                                    oninput="validateQuantity(this, 'missingValidationMessage')"
                                                                    onkeypress="validateInputLength(this, 4)">
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-secondary qty-btn-plus py-2 mx-1"
                                                                    onclick="incrementValue(this, '{{ $missingitem->missing_id }}')">
                                                                    <i class="ti ti-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" max={{ $missingitem->quantity }} min=0 readonly
                                                    class="form-control"
                                                    id="missing_quantity{{ $missingitem->missing_id }}"
                                                    name="missing_quantity[]" value="{{ $missingitem->quantity }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- new added received notes and received status--}}
                        <div class="form-group mt-4">
                            <label for="received_status" class="form-label">Received Status</label>
                            <select class="form-control" id="received_status" name="received_status" required >
                                <option value="0">Select One</option>
                                <option value="Good" {{ $rent->received_status == 'Good'? 'selected' : ''}}>Good</option>
                                <option value="Damage/Missing"{{ $rent->received_status == 'Damage/Missing'? 'selected' : ''}}>Damage/Missing</option>
                                <option value="Missing"{{ $rent->received_status == 'Missing'? 'selected' : ''}}>Missing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="note" class="form-label">Special Notes :</label>
                            <textarea class="form-control" id="note" name="note" rows="3" >{{ old('note') ?? $rent->note ?? '' }}</textarea>
                            @if($errors->has('note'))
                                <span class="text-danger">{{ $errors->first('note') }}</span>
                            @endif
                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
         var Exist_received_status;
         var Exist_Note;
        // Page Load Event
        document.addEventListener("DOMContentLoaded", function () {
            Exist_received_status = document.getElementById('received_status').value;
            Exist_Note = document.getElementById('note').value;

        })
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
            var inputElement = document.getElementById('received_quantity' + itemId);

            var currentValue = parseInt(inputElement.value, 10);


            if (currentValue < inputElement.max) {
                inputElement.value = currentValue + 1;
                var missingQuantity = document.getElementById('missing_quantity' + itemId);
                //increment missing item
                missingQuantity.value = missingQuantity.value - 1;
            }
            updateReceivedStatus();
        }

        function decrementValue(button, itemId) {
            var inputElement = document.getElementById('received_quantity' + itemId);
            var currentValue = parseInt(inputElement.value, 10);
            if (currentValue > 0) {
                inputElement.value = currentValue - 1;

                var missingQuantity = document.getElementById('missing_quantity' + itemId);
                missingQuantity.value = parseInt(missingQuantity.value, 10) + 1;
            }
            updateReceivedStatus();
        }

        function updateReceivedStatus() {
            var remainMissingQuantityElements = document.querySelectorAll('[id^="missing_quantity"]');

            var totalRemainMissingQuantity = 0;

            //count total totalRemainMissingQuantity
            remainMissingQuantityElements.forEach(function(element) {
                totalRemainMissingQuantity += parseInt(element.value, 10);
            });
            //get received_status and note
            var receivedStatus = document.getElementById('received_status');
            var speicalNote=document.getElementById('note');

            //check no of totalRemainMissingQuantity
            if (totalRemainMissingQuantity > 0) {
                receivedStatus.value = Exist_received_status;
                // Special note field is enabled
                $('#note').prop('disabled', false).closest('.form-group').show();
                speicalNote.value=Exist_Note;
                receivedStatus.readOnly= true;

            } else {
                receivedStatus.value = "Good"; // already missing items received
                receivedStatus.disabled = false;
                // Disable special note field
                $('#note').prop('disabled', true).closest('.form-group').hide();
                // Clear the value of the special note field
                speicalNote.value = '';
            }

        }

    </script>
@endsection
