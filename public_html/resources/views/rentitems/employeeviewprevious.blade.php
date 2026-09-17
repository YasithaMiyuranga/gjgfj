@extends('layouts.employee')
@section('page-title', ('Employee Assigned Rent Items'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.emp.assign.rent') }}">{{('Rent Details') }}</a>
        <li class="breadcrumb-item active">{{ ('>Assigned Rent Items') }}</li>
    </li>
@endsection
@section('content')
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3> Assigned Rent Items</h3>
            </div>
            <hr>
            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
            <div class="card-body">
                <form id="updateRentForm" method="POST" action="{{ route('employee.emp.assign.rent.update', $rents[0]->rent_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="text" name="employee_id" value="{{ $rents[0]->employee_id }}" hidden>
                    @foreach($rents as $rent)
                        <div class="form-group">
                            <label for="event_id">{{ ('Event Name') }}</label>
                            <input type="text" class="form-control" id="event_id" name="event_id" value="{{ $rent->event_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="employee_name">{{ ('Employee Name') }}</label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name" value="{{ $rent->employee_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="customer_name">{{ ('Customer Name') }}</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $rent->customer_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="rent_date">{{ ('Rent Date') }}</label>
                            <input type="text" class="form-control" id="rent_date" name="rent_date" value="{{ $rent->created_at }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="rent_date">{{ ('Setup Time') }}</label>
                            <input type="text" class="form-control" id="rent_date" name="rent_date" value="{{ $rent->setup_time }}" readonly>
                        </div>
                    @endforeach
                    <div class="table-responsive mt-2">
                        <p id="quantityValidationMessage" style="color: red;"></p>
                        <table class="table dataTable mt-4" id="orderedItemsIncludeTable">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        @php
                                            $isItemInOrder = $rents[0]->rent_items->contains('item_id', $item->item_id);
                                        @endphp
                                        <td>{{ $item->item_name }}</td>
                                        <td class="col-md-2">
                                            <input type="number" max="10000" min="0"
                                                class="form-control quantity-input" name="quantity-input" value="1"
                                                oninput="validateQuantity(this, 'quantityValidationMessage')"
                                                onkeypress="validateInputLength(this, 4)">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning"
                                            data-itemId="{{ $item->item_id }}"
                                            onclick="setItemId(this, '{{ $item->item_name }}', {{ $item->item_id }})"   {{ $isItemInOrder ? 'disabled' : '' }}>
                                            Add <i class="ti ti-plus py-1"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <input type="text" name="oldRentItems" id="oldRentItems" hidden>
                    <input type="text" name="newRentItems" id="newRentItems" hidden>
                    <div class="table-responsive mt-4 ordertable">
                        <table class="table table-bordered table-striped" id="orderedItemsTable">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody id="itemTableBody">
                                <!-- Rows for newly added items will go here -->
                            </tbody>
                                <!-- Existing ordered items -->
                                <tbody id="oldItemTableBody">
                                @foreach($rents[0]->rent_items as $item)
                                    <tr>
                                        {{-- Hidden input to store the item_id for each row --}}
                                        <input type="hidden" name="item_id[]" value="{{ $item->item_id }}">
                                        {{-- Hidden input to store the rent_item_id for each row --}}
                                        <input type="hidden" name="rent_item_id[]" value="{{ $item->rent_item_id }}">

                                        <td>{{ $item->item_name }}</td>
                                        <td>
                                          <input type="number" name="quantity[]" min="1" class="form-control" value="{{ $item->quantity }}" oninput="checkQuantity(this, {{ $item->item_id }}, '{{ $item->item_name }}'); validateQuantity(this, 'quantityValidationMessage'+{{ $item->item_id }})">
                                          <span id="quantityValidationMessage{{ $item->item_id }}" style="color: red;"></span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger"data-item-id="{{ $item->item_id }}" onclick="removeExistingItem(this, {{ $item->item_id }}, {{ $item->quantity }}, {{ $item->rent_item_id }})">Remove</button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Update Package</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var selectedItems = [];
        var disabledButtons = {}; // Object to keep track of disabled buttons
        let orderitems = @json($rents[0]->rent_items);
        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable(orderitems);
        });

        // Initialize disabledButtons based on predefinedItems
        function initializeDisabledButtons(orderitems) {
            orderitems.forEach(item => {
                disabledButtons[item.item_id] = true;
            });
        }

        // Helper function to enable/disable the Add button and update disabledButtons object
        function toggleAddButton(itemId, disable) {
            const button = $(`button[data-itemId="${itemId}"]`);
            button.prop('disabled', disable);
            if (disable) {
                disabledButtons[itemId] = true;
            } else {
                delete disabledButtons[itemId];
            }
        }

        // Function to initialize DataTable with a draw event listener
        function initializeDataTable(orderitems) {
            initializeDisabledButtons(orderitems);

            var table = new DataTable('#orderedItemsIncludeTable');

            // Add event listener for draw event
            table.on('draw.dt', function() {
                // Get all rows, not just the visible ones
                table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    const row = this.node(); // Get the DOM node for the row
                    $(row)
                        .find('button[data-itemId]')
                        .each(function() {
                            const itemId = $(this).data('itemid');

                            // Enable or disable based on the `disabledButtons` object
                            $(this).prop('disabled', !!disabledButtons[itemId]);
                        });
                });
            });

            // Refresh table initially
            table.draw();
        }

        // Validate Quantity
        function validateQuantity(input, validationMessageId) {
            var quantity = input.value;
            var validationMessage = document.getElementById(validationMessageId);

            if (quantity < 1) {
                validationMessage.textContent = "Minimum value should be 1.";
                input.setCustomValidity("Minimum value should be 1.");
                input.value = '';
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
        // Validate Rent Price
        function validateRentPrice(input, validationMessageId) {

            var rentPrice = input.value;
            var validationMessage = document.getElementById(validationMessageId);

            if (rentPrice < 1) {
                validationMessage.textContent = "Minimum value should be 1.";
                input.setCustomValidity("Minimum value should be 1.");
                input.value = '';
            } else {
                validationMessage.textContent = "";
                input.setCustomValidity("");
            }

        }

        //  Validate Input Length
        function validateInputLength(input, maxLength) {
            var inputValue = input.value.toString();
            if (inputValue.length > maxLength) {
                input.value = inputValue.slice(0, maxLength);
            }
        }

        // Set new item
        function setItemId(button, itemName, itemId) {
            var quantityInput = $(button).closest('tr').find('.quantity-input');
            var quantity = quantityInput.val();

                if (quantity > 0) {
                    // Add the new row to the table body
                    var newRow = '<tr>' +
                        '<td>' + itemName + '</td>' +
                        '<input type="hidden" name="item_id[]" value="' + itemId + '">' +
                        '<td><input type="number" min="1" class="form-control quantity-input" name="quantity[]" value="' + quantity + '" data-index="' +
                        itemId + '" oninput="validateQuantity(this, \'quantityValidationMessage2' + itemId + '\'); checkQuantity(this, ' + itemId + ', \'' + itemName + '\')"">' +
                        '<span id="quantityValidationMessage2' + itemId + '" style="color: red;"></span></td>' +
                        '<td><button type="button" class="btn btn-danger" onclick="removeItem(this, ' + itemId + ')">Remove</button></td>' +
                        '</tr>';

                    // Add the new row to the table body
                    $('#itemTableBody').append(newRow);
                    // Disable the "Add" button for this item in the first table
                    $(button).prop('disabled', true);
                    toggleAddButton(itemId, true);


                } else {
                    $('#quantityValidationMessage2').text('Please enter a valid quantity.');
                }
                enableSubmitButton();
            }

        function enableSubmitButton() {
            if( $('#itemTableBody tr').length > 0 || $('#oldItemTableBody tr').length > 0) {
                $('#updateRentForm button[type="submit"]').prop('disabled', false);
            }
            else{
                $('#updateRentForm button[type="submit"]').prop('disabled', true);
            }
        }

        // Function to remove  item
        function removeItem(button, itemId) {
            $(button).closest('tr').remove();
            // Re-enable the "Add" button in the first table
            var addButton = $('button[data-itemId="' + itemId + '"]');
            addButton.prop('disabled', false);
            delete disabledButtons[itemId]; // Remove from disabledButtons object
            enableSubmitButton();
        }


       //  Form submit
       $('#updateRentForm').submit(function() {

            // Get old rent items
            let oldRentItems = [];
            // Get new rent items
            let newRentItems = [];

            $('#oldItemTableBody tr').each(function() {
                var row = $(this);
                var itemId = row.find('input[name="item_id[]"]').val();
                var quantity = row.find('input[name="quantity[]"]').val();
                var rent_item_id = row.find('input[name="rent_item_id[]"]').val();

                oldRentItems.push({
                    itemId: itemId,
                    quantity: quantity,
                    rent_item_id: rent_item_id
                });

            });

            $('#itemTableBody tr').each(function() {
                var row = $(this);
                var itemId = row.find('input[name="item_id[]"]').val();
                var quantity = row.find('input[name="quantity[]"]').val();

                newRentItems.push({
                    itemId: itemId,
                    quantity: quantity
                });
            });

            $('#oldRentItems').val(JSON.stringify(oldRentItems));
            $('#newRentItems').val(JSON.stringify(newRentItems));

        });

        // Function to remove existing item
        function removeExistingItem(button, itemId, quantity, rent_item_id) {
             // Remove the item row from the second table
             $(button).closest('tr').remove();
            // Re-enable the "Add" button in the first table
            toggleAddButton(itemId, false);
            enableSubmitButton();
        }


        function checkQuantity(input, itemId, itemName) {
            var quantity = input.value;
            if (quantity > 0) {
                fetch(`/employee/check-item-quantity/${itemId}`)
                    .then(response => response.json())
                    .then(data => {
                        var quantityInput = quantity;

                        //check if item is in_stock > entered quantity
                        if ( data.in_stock >= quantity) {

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
                             `Sorry, ${itemName} cannot be added due to item value restrictions. Maximum value should be ${data.in_stock}.`;
                             alert(errorMessage);
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
                        alert('Error checking item availability.');
                    });
            }
        }

    </script>
@endsection
