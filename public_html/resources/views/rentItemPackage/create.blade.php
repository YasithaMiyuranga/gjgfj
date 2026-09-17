@extends('layouts.app')
@section('page-title', __('Rent Create Package'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.event_rent_packages.create') }}">{{__('Rent Create Package') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>{{ ('Rent Create Package') }}</h3>
            </div>
            <hr>
            <div class="card-body table-border-style">
                <div class="col-xl-12">
                    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                    <form method="post" action="{{ route('useradmin.event_rent_packages.store') }}" id="EventRentForm">
                        @csrf
                        <?php
                        $user = Auth::user();
                        ?>
                        <input type="hidden" name="rent_id" id="rent_id" value=0>
                        <input type="hidden" name="selected_items" id="selected_items" value="{{ old('selected_items') }}">
                        <div class="row">
                            <div class="col-md-6"><b>Date: {{ date('Y F d') }}</b></div>
                            <div class="col-md-6"><b>Time: {{ date('h:i A') }}</b></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_id" class="form-label">Event :</label>
                                    <select name="event_id" id="event_id" class="form-control select2 mt-1">
                                        <option value="0">Select Event </option>
                                       @foreach ($events as $event)
                                           <option value="{{ $event->eid }}"
                                               {{ old('event_id', $selectedEvent ? $selectedEvent->eid : null) == $event->eid ? 'selected' : '' }}>
                                               {{ $event->event_name }}
                                           </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="package_name" class="form-label">Package Name :</label>
                                    <input type="text" name="package_name" id="package_name" class="form-control" value="{{ old('package_name') }}"  maxlength="100" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description" class="form-label">description :</label>
                                    <textarea id="description" class="form-control" name="description" rows="3" value="{{ old('description') }}" maxlength="255" ></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="predefined_package_id" class="form-label">Select Items From Predefined Package:</label>
                                    <select name="predefined_package_id" id="predefined_package_id"
                                        class="form-control select2 mt-1">
                                        <option value="0">Select a Package</option>
                                        @foreach ($predefinedPackages as $predefinedPackage)
                                        <option value="{{ $predefinedPackage->package_id }}"
                                            {{ old('predefined_package_id') == $predefinedPackage->package_id ? 'selected' : '' }}>
                                            {{ $predefinedPackage->package_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive ">
                            {{--<p id="quantityValidationMessage" style="color: red;"></p> --}}
                            <table class="table dataTable mt-4">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Item Type</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->item_type }}</td>
                                            <td class="col-md-2">
                                                <input type="number" max="10000" min="0"
                                                    class="form-control quantity-input" name="quantity-input" value="1"
                                                    data-item=""
                                                    oninput="validateQuantity(this, 'quantityValidationMessage-{{ $item->item_id }}')"
                                                    onkeypress="validateInputLength(this, 4)">
                                                    <span class="text-danger" id="quantityValidationMessage-{{ $item->item_id }}"></span>
                                                </td>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning"
                                                    onclick="setItemId(this, '{{ $item->item_name }}', {{ $item->item_id }} )">
                                                    Add <i class="ti ti-plus py-1"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive mt-2 ordertable">
                            <table class="table dataTable mt-4" id="sendTable" style="display: none">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-2" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-primary from-prevent-multiple-submits" id="submitBtn"
                                    disabled>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        var oldSelectedItems = @json(old('selected_items', '[]'));
        if (oldSelectedItems) {
            selectedItems = JSON.parse(oldSelectedItems);
            updateSendTable();
        }
    });

    var selectedItems = [];

    $('.select2').select2({
        placeholder: "Select an Option"
    });


    // Event change handler
    $('#event_id').change(function() {
        var eventId = $(this).val();
        if (eventId) {
        // Clear the existing selectedItems array
        selectedItems = [];
        updateSendTable();
        }
    });

    // Validate Quantity
    function validateQuantity(input, validationMessageId) {
        var quantity = input.value;
        var validationMessage = document.getElementById(validationMessageId);

        if (quantity < 1) {
            validationMessage.textContent = "Minimum value should be 1.";
            input.setCustomValidity("Minimum value should be 1.");
            // input.value = '1';
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
    // Validate Input Length
    function validateInputLength(input, maxLength) {
        var inputValue = input.value.toString();
        if (inputValue.length > maxLength) {
            input.value = inputValue.slice(0, maxLength);
        }
    }
    function setItemId(button, itemName, itemId) {

        fetch(`/useradmin/check-item-quantity/total-quantity/${itemId}`)
            .then(response => response.json())
            .then(data => {
                var quantityInput = $(button).closest('tr').find('.quantity-input');
                var quantity = quantityInput.val();

                //check if item is totalStock > entered quantity
                if ( data.totalStock >= quantity) {
                    var quantityInput = $(button).closest('tr').find('.quantity-input');
                    var quantity = quantityInput.val();

                    if (quantity > 0) {
                        // Check if the item is already in the array
                        for (var i = 0; i < selectedItems.length; i++) {
                            if (selectedItems[i].itemId == itemId) {
                                var existingItem = parseInt(selectedItems[i].quantity);
                                selectedItems[i].quantity = existingItem + parseInt(quantity);
                                updateSendTable();
                                return;

                            }

                        }
                        // Add selected item and quantity to the array
                        selectedItems.push({
                            itemId: itemId,
                            itemName: itemName,
                            quantity: quantity
                        });
                        updateSendTable();
                    } else {
                        $('#quantityValidationMessage').text('Please enter a valid quantity.');
                    }
                } else {
                    let errorMessage = data.quantity <= 0 ?
                         `Sorry, ${itemName} is out of stock.` :
                         `Sorry, ${itemName} cannot be added due to item value restrictions. Maximum value should be ${data.totalStock}.`;
                       showCustomAlert(errorMessage);
                }
            })
            .catch(error => {
                showCustomAlert('Error checking item availability.');
            });
    }

    function removeItem(button) {
        var indexToRemove = $(button).closest('tr').index();
        selectedItems.splice(indexToRemove, 1);
        updateSendTable();
    }

    function updateSendTable() {
        var sendTableBody = $('#sendTable tbody');
        sendTableBody.empty();

        for (var i = 0; i < selectedItems.length; i++) {
            var item = selectedItems[i];
            sendTableBody.append(
                '<tr>' +
                    '<td>' + item.itemName + '</td>' +
                    '<td>' +
                        '<input type="number" class="form-control quantity-input-2"  oninput="validateQuantity(this, \'quantityValidationMessage2\'); checkQuantity(this, ' + item.itemId + ', \'' + item.itemName + '\')" value="' + item.quantity + '">' +
                        '<span class="text-danger" id="quantityValidationMessage2"></span>' +
                    '</td>' +
                    '<td>' +
                        '<button type="button" class="btn btn-danger" onclick="removeItem(this)">Remove</button>' +
                    '</td>' +
                    '<input type="hidden" name="item_id[]" value="' + item.itemId + '">' +
                    '<input type="hidden" name="quantity[]" value="' + item.quantity + '">' +
                '</tr>'
            );

        }
        if (selectedItems.length > 0) {
            $('#sendTable').show();
        } else {
            $('#sendTable').hide();
        }
        enableSubmitButton();
    }

    function enableSubmitButton() {

        if ($('#event_id').val() != 0 && selectedItems.length > 0 && $('#package_name').val() != '') {
            $('#EventRentForm button[type="submit"]').prop('disabled', false);
        } else {
            $('#EventRentForm button[type="submit"]').prop('disabled', true);
        }
    }

    $('#event_id').change(function() {
        enableSubmitButton();
    });

    $('#predefined_package_id').change(function() {
        var predefinedPackageId = $('#predefined_package_id').val();
        selectedItems = [];
        $.ajax({
            url: "{{ route('useradmin.getpredefinedpackageitems') }}",
            type: 'GET',
            data: {
                predefined_package_id: predefinedPackageId
            },
            success: function(data) {
                var items = data.predefinedItems;
                for (var i = 0; i < items.length; i++) {
                    var item = items[i];
                    selectedItems.push({
                        itemId: item.item_id,
                        itemName: item.item_name,
                        quantity: item.quantity
                    });
                }
                updateSendTable();
            }
        });
    });

    // Prevent multiple form submissions
    $('#EventRentForm').on('submit', function(e) {
        $('.from-prevent-multiple-submits').attr('disabled', 'true');
        $('#selected_items').val(JSON.stringify(selectedItems));
        this.submit();
    });

    function checkQuantity(input, itemId, itemName) {
        var quantity = input.value;
        if (quantity > 0) {
            fetch(`/useradmin/check-item-quantity/total-quantity/${itemId}`)
                .then(response => response.json())
                .then(data => {
                    var quantityInput = quantity;

                    //check if item is totalStock > entered quantity
                    if ( data.totalStock >= quantity) {


                        if (quantity > 0) {
                            // Check if the item is already in the array
                            for (var i = 0; i < selectedItems.length; i++) {
                                if (selectedItems[i].itemId == itemId) {
                                    var existingItem = parseInt(selectedItems[i].quantity);
                                    selectedItems[i].quantity = quantity;
                                    updateSendTable();
                                    return;

                                }
                            }
                        } else {
                            $('#quantityValidationMessage').text('Please enter a valid quantity.');
                        }
                    } else {
                       let errorMessage = data.quantity <= 0 ?
                         `Sorry, ${itemName} is out of stock.` :
                         `Sorry, ${itemName} cannot be added due to item value restrictions. Maximum value should be ${data.totalStock}.`;
                       showCustomAlert(errorMessage);
                       // Show currently selected items include quantity in quantity-input-2
                        for (var i = 0; i < selectedItems.length; i++) {
                            if (selectedItems[i].itemId == itemId) {
                                var existingItem = parseInt(selectedItems[i].quantity);
                                selectedItems[i].quantity = existingItem;
                                updateSendTable();
                                return;
                            }
                        }
                    }

                })
                .catch(error => {
                    showCustomAlert('Error checking item availability.');
                });
        }
    }
</script>
@endsection

