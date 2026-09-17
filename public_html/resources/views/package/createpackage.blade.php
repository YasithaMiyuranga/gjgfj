@extends('layouts.app')
@section('page-title', __('Packages'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.package') }}">{{__('Packages') }}</a>
        <li class="breadcrumb-item active">{{ __('Add Packages') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Add Packages</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                    <form method="post" action="{{ route('useradmin.savepackage') }}" id="sendForm"
                        enctype="multipart/form-data">
                        @csrf
                        <?php
                        $user = Auth::user();
                        ?>
                        <input type="hidden" name="package_id" id="package_id" value=0>
                        <input type="hidden" name="selected_items" id="selected_items" value="">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="package_name" class="form-label">{{ ('Package Name  *') }}</label>
                                <input type="text" class="form-control" id="package_name" name="package_name"
                                    value="{{ old('package_name') }}" required maxlength="255"
                                    pattern="([0-9\s]+|[A-Za-z0-9\s]+)"
                                    oninput="validatePackageName(this, 'packageNameValidationMessage', 255)"
                                    oninvalid="this.setCustomValidity('Please enter a package name that is either all numbers or includes letters.')">
                                <p id="packageNameValidationMessage" style="color: red;"></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="category" class="form-label">{{ ('Category  *') }}</label>
                                <select id="category" class="form-control" name="category" required>
                                    <option value="0">Select One</option>
                                    <option value="Wedding" {{ old('category') == 'Wedding' ? 'selected' : '' }}>Wedding
                                    </option>
                                    <option value="Party" {{ old('category') == 'Party' ? 'selected' : '' }}>Party</option>
                                    <option value="Musicalshow" {{ old('category') == 'Musicalshow' ? 'selected' : '' }}>
                                        Musicalshow</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group
                            col-md-6">
                                <label for="price" class="form-label">{{ ('Price    *') }}</label>
                                <input type="number" class="form-control" id="price"
                                    oninput="validatePrice(this, 'priceValidationMessage')" name="price"
                                    value="{{ old('price') }}" onkeypress="validateInputLength(this, 10)" required>
                                <p id="priceValidationMessage" style="color: red;"></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price_visible" class="form-label">{{ ('Price Visible *') }}</label>
                                <select id="price_visible" class="form-control" name="price_visible">
                                    <option value="1" {{ old('price_visible') == 'Yes' ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="0" {{ old('price_visible') == 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="status" class="form-label">{{ ('Status  *') }}</label>
                                <select id="status" class="form-control" name="status" required>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                oninput="validateInputLength(this, 255)">{{ old('description') }}</textarea>
                            <p id="descriptionValidationMessage" style="color: red;"></p>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="type" class="form-label">{{ ('Type  *') }}</label>
                                <select id="type" class="form-control" name="type" required>
                                    <option value="Indoor" {{ old('type') == 'Indoor' ? 'selected' : '' }}>Indoor</option>
                                    <option value="Outdoor" {{ old('type') == 'Outdoor' ? 'selected' : '' }}>Outdoor
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="image" class="form-label">{{ __('Image  *') }}</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept=".jpeg,.png,.jpg,.gif,.svg,.jfif" required onchange="validateFileSize(this, 5)" value="{{ old('image') }}">
                                <p id="imageValidationMessage" style="color: red;"></p>
                            </div>
                        </div>

                            <div class="table-responsive mt-2">
                                {{--<p id="quantityValidationMessage" style="color: red;"></p>--}}
                                <table class="table dataTable mt-4" id="orderedItemsIncludeTable">
                                    <thead>
                                        <tr>
                                            <th class="col-md-6">Item Name</th>
                                            <th class="col-md-4">Quantity</th>
                                            <th class="col-md-1">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td class="col-md-2">
                                                    <input type="number" max="10000" min="0"
                                                        class="form-control quantity-input" name="quantity-input"
                                                        value="1" data-item=""
                                                        oninput="validateQuantity(this, 'quantityValidationMessage-{{ $item->item_id }}')"
                                                        onkeypress="validateInputLength(this, 4)">
                                                        <span class="text-danger" id="quantityValidationMessage-{{ $item->item_id }}"></span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning"
                                                        data-itemId="{{ $item->item_id }}"
                                                        id="add-button-{{ $item->item_id }}"
                                                        onclick="setItemId(this, '{{ $item->item_name }}', {{ $item->item_id }})">Add
                                                        <i class="ti ti-plus py-1"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive ordertable">
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
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" disabled>Create Package</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>

        var selectedItems = [];
        var disabledButtons = {}; // Object to keep track of disabled buttons
        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable();
        });

        // Helper function to enable/disable the Add button
        function toggleAddButton(itemId, disable) {
            const button = $(`button[data-itemid="${itemId}"]`);
            button.prop('disabled', disable);
            if (disable) {
                disabledButtons[itemId] = true;
            } else {
                delete disabledButtons[itemId];
            }
        }

        // Function to initialize DataTable and handle button states
        function initializeDataTable() {
            const table = new DataTable('#orderedItemsIncludeTable');

            table.on('draw', function() {
                table.rows().every(function() {
                    const row = this.node();
                    $(row).find('button[data-itemid]').each(function() {
                        const itemId = $(this).data('itemid');
                        $(this).prop('disabled', !!disabledButtons[itemId]);
                    });
                });
            });

            table.draw(); // Initial table refresh
        }
        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select an Option"
        });

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

        // Validate Price
        function validatePrice(input, validationMessageId) {
            var price = input.value;
            var validationMessage = document.getElementById(validationMessageId);

            if (price < 1) {
                validationMessage.textContent = "Minimum value should be 1.";
                input.setCustomValidity("Minimum value should be 1.");
                input.value = '';
            } else {
                validationMessage.textContent = "";
                input.setCustomValidity("");
            }
            if (price > 100000000) {
                input.value = 100000000;
                validationMessage.textContent = "Maximum value should be 100000000.";
                input.setCustomValidity("Maximum value should be 100000000.");
            }
        }

        // Validate Input Length
        function validateInputLength(input, maxLength) {
            const messageElement = document.getElementById('descriptionValidationMessage');
            if (input.value.length > maxLength) {
                input.value = input.value.slice(0, maxLength); // Trim to max length
                messageElement.textContent =
                    `You have reached the maximum allowed limit of ${maxLength} characters. Please shorten your input.`;
            } else {
                messageElement.textContent = ''; // Clear the message if the input is valid
            }
        }

        // Validate Package Name
        function validatePackageName(input, messageElementId, maxLength) {
            const messageElement = document.getElementById(messageElementId);
            if (input.value.length >= maxLength) {
                messageElement.textContent =
                    `You have reached the maximum allowed limit of ${maxLength} characters. Please shorten your input.`;
            } else if (input.validity.patternMismatch) {
                messageElement.textContent = 'Package name is invalid.';
            } else if (input.validity.valueMissing) {
                messageElement.textContent = 'Package name is required.';
            } else {
                messageElement.textContent = ''; // Clear the message if input is valid
            }
        }

        // Validate File Size for Image
        function validateFileSize(input, maxSizeMB) {
            const file = input.files[0];
            const maxSizeBytes = maxSizeMB * 1024 * 1024; // Convert MB to bytes

            if (file && file.size > maxSizeBytes) {
                document.getElementById('imageValidationMessage').textContent =
                    `The file exceeds the maximum size of ${maxSizeMB} MB. Please select a smaller file.`;
                input.value = ''; // Clear the input
            } else {
                document.getElementById('imageValidationMessage').textContent = ''; // Clear any previous message
            }
        }


        function setItemId(button, itemName, itemId) {
            var quantityInput = $(button).closest('tr').find('.quantity-input');
            var quantity = quantityInput.val();

            var isAlreadySelected = selectedItems.some(function(item) {
                return item.itemId === itemId;
            });

            if (quantity > 0) {
                if (!isAlreadySelected) {
                    toggleAddButton(itemId, true); // Disable the button for this item

                    // Add selected item and quantity to the array
                    selectedItems.push({
                        itemId: itemId,
                        itemName: itemName,
                        quantity: quantity
                    });
                } else {
                    // If the item is already selected, increase its quantity
                    selectedItems.forEach(function(item) {
                        if (item.itemId === itemId) {
                            item.quantity += quantityToAdd;
                        }
                    });
                }
                updateSendTable();

            } else {
                $('#quantityValidationMessage').text('Please enter a valid quantity.');
            }
        }

        // Function to handle removing an item
        function removeItem(button, itemId) {
            const rowIndex = $(button).closest('tr').index();
            selectedItems.splice(rowIndex, 1);
            toggleAddButton(itemId, false);
            updateSendTable();
        }

        function updateSendTable() {
            var sendTableBody = $('#sendTable tbody');
            sendTableBody.empty();

            for (var i = 0; i < selectedItems.length; i++) {
                var item = selectedItems[i];
                sendTableBody.append('<tr><td>' + item.itemName + '</td><td>' + item.quantity +
                    '</td><td><button type="button" class="btn btn-danger" onclick="removeItem(this, ' + item.itemId + ')">Remove</button></td><input type="hidden" name="item_id[]" value="' +
                    item.itemId + '"><input type="hidden" name="quantity[]" value="' + item.quantity + '"></tr>');
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
            var packageNameMessage = document.getElementById('packageNameValidationMessage');
            if (!packageName.trim()) {
                packageNameMessage.textContent =  "Package name is required.";
                showCustomAlert('Please enter a package name.');
                return;
            }

            if (await checkPackageNameExists(packageName)) {
                packageNameMessage.textContent = "Package name already exists";
                showCustomAlert('Package name already exists');
                return;
            } else {
                $('#selected_items').val(JSON.stringify(selectedItems));
                this.submit();
            }
        });

        // Function to check if package name exists
        async function checkPackageNameExists(packageName) {
            try {
                const response = await fetch('/useradmin/check-package-name', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token for Laravel
                    },
                    body: JSON.stringify({ packageName }),
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
            if (selectedItems.length > 0 && $('#package_name').val() != '' && $('#category').val() != 0 && $('#price')
                .val() != '') {
                $('#sendForm button[type="submit"]').prop('disabled', false);
            } else {
                $('#sendForm button[type="submit"]').prop('disabled', true);
            }
        }

        $('#package_name').on('input', function() {
            enableSubmitButton();
        });

        $('#category').on('change', function() {
            enableSubmitButton();
        });

        $('#price').on('input', function() {
            enableSubmitButton();
        });
    </script>
@endsection
