@extends('layouts.app')
@section('page-title', __('Predefined Packages'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.predefined.all') }}">{{__('Packages') }}</a>
        <li class="breadcrumb-item active">{{ __('Edit Predefined Packages List') }}</li>
    </li>
@endsection
@section('content')
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Add Predefined Packages List</h3>
            </div>
            <hr>
            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
            <div class="card-body">
                <form method="POST" action="{{ route('useradmin.predefined.update', $packagedata->package_id) }}"
                    id="sendForm">
                    @csrf
                    @method('PUT')
                    <?php
                    $user = Auth::user();
                    ?>
                    <input type="hidden" name="package_id" id="package_id" value="{{ $packagedata->package_id }}">
                    <input type="hidden" name="selected_items" id="selected_items" value="">
                    <input type="hidden" name="old_predefined_package_items" id="old_predefined_package_items" value="">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="package_name" class="form-label">{{ ('Package Name  *') }}</label>
                            <input type="text" class="form-control" id="package_name" name="package_name"
                                value="{{ $packagedata->package_name }}" maxlength="100" pattern="([0-9\s]+|[A-Za-z0-9\s]+)"
                                oninput="validatePackageName(this, 'packageNameValidationMessage', 100)">
                            <p id="packageNameValidationMessage" style="color: red;"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category" class="form-label">{{ ('Category  *') }}</label>
                            <select id="category" class="form-control" name="category">
                                <option value="">Select Category</option>
                                @foreach( $predefinedPackageCategories as $category)
                                <option value="{{ $category->category_name }}" {{ ( $packagedata->category == $category->category_name || old('category') == $category->category_name )? 'selected' : ''}}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="package_status" class="form-label">{{ ('Display Package Items On Order  *') }}</label>
                            <select id="package_status" class="form-control" name="package_status">
                                <option value="Active" {{ $packagedata->package_status == 'Active' ? 'selected' : '' }}>
                                    Yes</option>
                                <option value="Inactive"
                                    {{ $packagedata->package_status == 'Inactive' ? 'selected' : '' }}>
                                    No</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <p id="quantityValidationMessage" style="color: red;"></p>
                        <table class="table dataTable mt-4" id="orderedItemsIncludeTable">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Rent Price</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        @php
                                            $isItemInOrder = $predefinedItems->contains('item_id', $item->item_id);
                                        @endphp
                                        <td>{{ $item->item_name }}</td>
                                        <td class="col-md-4">
                                            <input type="number"  min="1"
                                            class="form-control rentprice-input" name="rentprice-input" value="{{ intval($item->rent_price) }}"
                                            data-item=""
                                            oninput="validateRentPrice(this, 'quantityValidationMessage')"
                                            onkeypress="validateInputLength(this, 7)">
                                        </td>
                                        <td class="col-md-2">
                                            <input type="number" max="10000" min="0"
                                                class="form-control quantity-input" name="quantity-input" value="1"
                                                oninput="validateQuantity(this, 'quantityValidationMessage')"
                                                onkeypress="validateInputLength(this, 4)">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning"
                                            data-itemId="{{ $item->item_id }}"
                                            onclick="setItemId(this, '{{ $item->item_name }}', {{ $item->item_id }})"  {{ $isItemInOrder ? 'disabled' : '' }}>Add
                                            <i class="ti ti-plus py-1"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4 ordertable">
                        <h5 class="px-4">Already Added Items</h5>
                        <p id="quantityValidationMessage2" style="color: red;"></p>
                        <table class="table dataTable mt-2" id="preItemTable">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Rent Price</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($predefinedItems as $predefinedItem)
                                    <tr>
                                        <td>{{ $predefinedItem->item_name }}</td>
                                        <td><input type="number"  min="1"
                                            class="form-control rentprice-input" name="predefined_rentprice[]"
                                            value="{{ intval($predefinedItem->item_price) }}"
                                            oninput="validateRentPrice(this, 'quantityValidationMessage2')"
                                            onkeypress="validateInputLength(this, 7)">
                                        </td>
                                        <td><input type="number" max="10000" min="1"
                                                class="form-control quantity-input" name="predefined_quantity[]"
                                                value="{{ $predefinedItem->quantity }}"
                                                oninput="validateQuantity(this, 'quantityValidationMessage2')"
                                                onkeypress="validateInputLength(this, 4)"></td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-itemId="{{ $predefinedItem->item_id }}"
                                                {{-- onclick="removeItemfromDB(this, '{{ $predefinedItem->item_id }}')">Remove</button> --}}
                                                onclick="removeExistItem(this, {{ $predefinedItem->item_id }}, {{ $predefinedItem->quantity }}, {{ $predefinedItem->predefined_item_id }})">Remove</button>
                                        </td>
                                        <input type="hidden" name="predefined_item_id[]"
                                            value="{{ $predefinedItem->predefined_item_id }}">
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
                                    <th>Rent Price</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary" disabled>Update Package</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        var selectedItems = [];
        var disabledButtons = {};
        var removedItems = [];
        let predefinedItems = @json($predefinedItems);

        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable(predefinedItems);

        });

        // Helper function to enable/disable the Add button and update disabledButtons object
        function toggleAddButton(itemId, disable) {

            const button = $(`button[data-itemid="${itemId}"]`);
            button.prop('disabled', disable);
            if (disable) {
                disabledButtons[itemId] = true;
            } else {
                delete disabledButtons[itemId];
            }
        }

        // Initialize disabledButtons based on predefinedItems
        function initializeDisabledButtons(predefinedItems) {
            predefinedItems.forEach(item => {
                disabledButtons[item.item_id] = true;
            });
        }

        // Function to initialize DataTable with a draw event listener
        function initializeDataTable(predefinedItems) {
            initializeDisabledButtons(predefinedItems);

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

        $('.select2').select2({
            placeholder: "Select an Option"
        });

        //Validate Quantity
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

        //Validate Input Length
        function validateInputLength(input, maxLength) {
            var inputValue = input.value.toString();
            if (inputValue.length > maxLength) {
                input.value = inputValue.slice(0, maxLength);
            }
        }

        //Validate Package Name
        function validatePackageName(input, messageElementId, maxLength = 100) {
            const messageElement = document.getElementById(messageElementId);
            if (input.value.length >= maxLength) {
                messageElement.textContent = `You have reached the maximum allowed limit of ${maxLength} characters. Please shorten your input.`;
            } else if (input.validity.patternMismatch) {
                messageElement.textContent = 'Package name is invalid.';
            } else if (input.validity.valueMissing) {
                messageElement.textContent = 'Package name is required.';
            } else {
                messageElement.textContent = ''; // Clear the message if input is valid
            }
        }

        function setItemId(button, itemName, itemId) {
            var quantityInput = $(button).closest('tr').find('.quantity-input');
            var quantity = quantityInput.val();
            var rentInput = $(button).closest('tr').find('.rentprice-input');
            var rent_price = rentInput.val();

            if (quantity > 0) {
                // Add selected item and quantity to the array
                selectedItems.push({
                    itemId: itemId,
                    itemName: itemName,
                    rent_price: rent_price,
                    quantity: quantity
                });
                $(button).prop('disabled', true);
                toggleAddButton(itemId, true);
                updateSendTable();
            } else {
                $('#quantityValidationMessage').text('Please enter a valid quantity.');
            }
        }

        function removeItem(button, itemId) {
            var indexToRemove = $(button).closest('tr').index();
            selectedItems.splice(indexToRemove, 1);
            var addButton = $('button[data-itemId="' + itemId + '"]');
            toggleAddButton(itemId, false);
            // addButton.prop('disabled', false);
            updateSendTable();
        }

        function updateSendTable() {
            var sendTableBody = $('#sendTable tbody');
            sendTableBody.empty();

            for (var i = 0; i < selectedItems.length; i++) {
                var item = selectedItems[i];
                sendTableBody.append(
                    '<tr><td>' + item.itemName + '</td>' +
                    '<td>' + item.rent_price + '</td>' +
                    '<td>' + item.quantity + '</td>' +
                    '<td><button type="button" class="btn btn-danger" onclick="removeItem(this, ' + item.itemId + ')">Remove</button></td>' +
                    '<input type="hidden" name="item_id[]" value="' + item.itemId + '">' +
                    '<input type="hidden" name="quantity[]" value="' + item.quantity + '">' +
                    '<input type="hidden" name="rent_price[]" value="' + item.rent_price + '">' +
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

        $('#sendForm').submit(async function (event) {
            event.preventDefault(); // Prevent form submission by default

            var packageName = $('#package_name').val();
            var packageId = $('#package_id').val();
            var packageNameMessage = document.getElementById('packageNameValidationMessage');
            if (!packageName.trim()) {
                packageNameMessage.textContent =  "Package name is required.";
                showCustomAlert('Please enter a package name.');
                return;
            }

            if (await checkPackageNameExists(packageName, packageId)) {
                packageNameMessage.textContent = "Package name already exists";
                showCustomAlert('Package name already exists');
                return;
            } else {
                $('#selected_items').val(JSON.stringify(selectedItems));
                this.submit();
            }
        });

        // Function to check if package name exists
        async function checkPackageNameExists(packageName, packageId) {
            try {
                const response = await fetch('/useradmin/check-predefinedpackage-edit-name', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token for Laravel
                    },
                    body: JSON.stringify({ packageName, packageId }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                return result.exists;
            } catch (error) {
                showCustomAlert('An error occurred while checking the package name. Please try again.');
                return false;
            }
        }

        function enableSubmitButton() {
            if ($('#package_name').val() != '') {
                //Check if predefined_quantity array has empty values
                var predefined_quantity = $('input[name="predefined_quantity[]"]').map(function() {
                    return $(this).val();
                }).get();
                var empty = false;
                for (var i = 0; i < predefined_quantity.length; i++) {
                    if (predefined_quantity[i] == '') {
                        empty = true;
                    }
                }
                // Check if any predefined_rent_price is empty
                var predefined_rentprice = $('input[name="predefined_rentprice[]"]').map(function() {
                    return $(this).val();
                }).get();
                for (var i = 0; i < predefined_rentprice.length; i++) {
                    if (predefined_rentprice[i] == '') {
                        empty = true;
                    }
                }

                if (empty) {
                    $('#sendForm button[type="submit"]').prop('disabled', true);
                } else {
                    $('#sendForm button[type="submit"]').prop('disabled', false);
                }
            } else {
                $('#sendForm button[type="submit"]').prop('disabled', true);
            }
        }

        $('input[name="predefined_quantity[]"]').on('input', function() {
            enableSubmitButton();
        });
        $('input[name="predefined_rentprice[]"]').on('input', function() {
            enableSubmitButton();
        });

        $('#package_name').on('input', function() {
            enableSubmitButton();
        });

        $('#category').change(function() {
            enableSubmitButton();
        });

        $('#package_status').change(function() {
            enableSubmitButton();
        })

    function removeExistItem(button, itemId, quantity, predefinedId) {
        // Ask for user confirmation
        if (confirm('Are you sure you want to Delete this item?')) {
            // Remove the item row from the second table
            $(button).closest('tr').remove();

            // Re-enable the "Add" button in the first table
            toggleAddButton(itemId, false);

            updateSendTable();
            // Add predefinedId to removedItems array
            removedItems.push(predefinedId);
            // old_predefined_package_items
            $('#old_predefined_package_items').val(JSON.stringify(removedItems));
        }
    }
    </script>
@endsection
