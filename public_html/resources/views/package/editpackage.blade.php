@extends('layouts.app')
@section('page-title', __('Packages'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.package.all') }}">{{ __('Packages') }}</a>
    <li class="breadcrumb-item active">{{ __('Edit  Package') }}</li>
    </li>
@endsection
@section('content')
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Edit Package</h3>
            </div>
            <hr>
            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
            <div class="card-body">
                <form method="POST" action="{{ route('useradmin.package.update', $packagedata->package_id) }}" id="sendForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <?php
                    $user = Auth::user();
                    ?>
                    <input type="hidden" name="package_id" id="package_id" value="{{ $packagedata->package_id }}">
                    <input type="hidden" name="selected_items" id="selected_items" value="">
                    <input type="hidden" name="old_package_items" id="old_package_items" value="">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="package_name" class="form-label">{{ 'Package Name  *' }}</label>
                            <input type="text" class="form-control" id="package_name" name="package_name"
                                value="{{ old('package_name') ?? $packagedata->package_name }}" required maxlength="255"
                                pattern="([0-9\s]+|[A-Za-z0-9\s]+)"
                                oninput="validatePackageName(this, 'packageNameValidationMessage' , 255)"
                                oninvalid="this.setCustomValidity('Please enter a package name that is either all numbers or includes letters.')">
                            <p id="packageNameValidationMessage" style="color: red;"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category" class="form-label">{{ 'Category  *' }}</label>
                            <select id="category" class="form-control" name="category">
                                <option value="Wedding" {{ old('category') == 'Wedding' ? 'selected' : '' }}
                                    {{ $packagedata->category == 'Wedding' ? 'selected' : '' }}>
                                    Wedding
                                </option>
                                <option value="Party" {{ old('category') == 'Party' ? 'selected' : '' }}
                                    {{ $packagedata->category == 'Party' ? 'selected' : '' }}>Party
                                </option>
                                <option value="Musicalshow" {{ old('category') == 'Musicalshow' ? 'selected' : '' }}
                                    {{ $packagedata->category == 'Musicalshow' ? 'selected' : '' }}>
                                    Musicalshow</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}
                                    {{ $packagedata->category == 'Other' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="price" class="form-label">{{ 'Price    *' }}</label>
                            <input type="text" class="form-control" id="price"
                                oninput="validatePrice(this, 'priceValidationMessage')" name="price"
                                onkeypress="validateInputLength(this, 10)" value="{{ old('price', $packagedata->price) }}"
                                required>
                            <p id="priceValidationMessage" style="color: red;"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price_visible" class="form-label">{{ 'Price Visible *' }}</label>
                            <select id="price_visible" class="form-control" name="price_visible">
                                <option value="1" {{ old('price_visible') == '1' ? 'selected' : '' }}
                                    {{ $packagedata->price_visible == '1' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="0" {{ old('price_visible') == '0' ? 'selected' : '' }}
                                    {{ $packagedata->price_visible == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="status" class="form-label">{{ 'Status  *' }}</label>
                            <select id="status" class="form-control" name="status" required>
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}
                                    {{ $packagedata->status == 'Active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}
                                    {{ $packagedata->status == 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control" id="description" name="description" rows="4"
                            oninput="validateInputLength(this, 255)">{{ old('description', $packagedata->description) }}</textarea>
                        <p id="descriptionValidationMessage" style="color: red;"></p>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="type" class="form-label">{{ 'Type  *' }}</label>
                            <select name="type" class="form-control" id="type" required>
                                <option value="Indoor" {{ old('type') == 'Indoor' ? 'selected' : '' }}
                                    {{ $packagedata->type == 'Indoor' ? 'selected' : '' }}>Indoor
                                </option>
                                <option value="Outdoor" {{ old('type') == 'Outdoor' ? 'selected' : '' }}
                                    {{ $packagedata->type == 'Outdoor' ? 'selected' : '' }}>Outdoor
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="image" class="form-label">{{ __('Image') }}</label>
                            <input type="file" class="form-control" id="image" name="image" value=""
                                accept=".jpeg,.png,.jpg,.gif,.svg,.jfif" onchange="validateFileSize(this, 5)">
                            <p id="imageValidationMessage" style="color: red;"></p>
                        </div>
                    </div>

                    <div class="table-responsive mt-2 px-4">
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
                                            $isItemInOrder = $addedItems->contains('item_id', $item->item_id);
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
                                                onclick="setItemId(this, '{{ $item->item_name }}', {{ $item->item_id }})"
                                                {{ $isItemInOrder ? 'disabled' : '' }}>Add
                                                <i class="ti ti-plus py-1"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive  mt-4 px-4" id="already_added_table">
                        <h5>Already Added Items</h5>
                        <p id="quantityValidationMessage2" style="color: red;"></p>
                        <table class="table dataTable mt-2" id="preItemTable">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Confirmation Modal (outside loop) -->
                                <div class="modal fade" id="confirmPackageItemRemoveModal" tabindex="-1"
                                    aria-labelledby="confirmLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Removal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to remove this item from the package?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-danger"
                                                    id="confirmRemovePackageItemBtn">Yes, Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @foreach ($addedItems as $packageItem)
                                    <tr>
                                        <td>{{ $packageItem->item_name }}</td>
                                        <td><input type="number" max="10000" min="0"
                                                class="form-control quantity-input" name="package_quantity[]"
                                                value="{{ $packageItem->quantity }}"
                                                oninput="validateQuantity(this, 'quantityValidationMessage2')"
                                                onkeypress="validateInputLength(this, 4)"></td>
                                        <td>
                                            <button type="button" class="btn btn-danger"
                                                onclick="showConfirmRemoveModal(this, {{ $packageItem->item_id }}, {{ $packageItem->quantity }}, {{ $packageItem->package_item_id }})">
                                                Remove
                                            </button>

                                        </td>
                                        <input type="hidden" name="package_item_id[]"
                                            value="{{ $packageItem->package_item_id }}">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        var selectedItems = [];
        var disabledButtons = {}; // Object to keep track of disabled buttons
        var removedItems = [];
        let packageItem = @json($addedItems);
        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable(packageItem);
        });


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
        // Initialize disabledButtons based on predefinedItems
        function initializeDisabledButtons(packageItem) {
            packageItem.forEach(item => {
                disabledButtons[item.item_id] = true;
            });
        }

        // Function to initialize DataTable with a draw event listener
        function initializeDataTable(packageItem) {
            initializeDisabledButtons(packageItem);

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

        //  Validate Quantity
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

        //  Validate Price
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
            // if (quantity > 100000000) {
            //     input.value = 100000000;
            //     validationMessage.textContent = "Maximum value should be 100000000.";
            //     input.setCustomValidity("Maximum value should be 100000000.");
            // }
        }

        //  Validate Input Length
        function validateInputLength(input, maxLength) {
            var inputValue = input.value.toString();
            if (inputValue.length > maxLength) {
                input.value = inputValue.slice(0, maxLength);
            }
        }

        //Validate Package Name
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

        //Validate Description
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

        //Validate File Size for Image
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
                // Add selected item and quantity to the array
                selectedItems.push({
                    itemId: itemId,
                    itemName: itemName,
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
            addButton.prop('disabled', false);
            delete disabledButtons[itemId]; // Remove from disabledButtons object
            updateSendTable();


        }

        function updateSendTable() {
            var sendTableBody = $('#sendTable tbody');
            sendTableBody.empty();

            for (var i = 0; i < selectedItems.length; i++) {
                var item = selectedItems[i];
                sendTableBody.append('<tr><td>' + item.itemName + '</td><td>' + item.quantity +
                    '</td><td><button type="button" class="btn btn-danger" onclick="removeItem(this, ' + item.itemId +
                    ')">Remove</button></td><input type="hidden" name="item_id[]" value="' +
                    item.itemId + '"><input type="hidden" name="quantity[]" value="' + item.quantity + '"></tr>');
            }
            if (selectedItems.length > 0) {
                $('#sendTable').show();
            } else {
                $('#sendTable').hide();
            }
            enableSubmitButton();
        }

        $('#sendForm').submit(async function(event) {
            event.preventDefault(); // Prevent form submission by default

            var packageName = $('#package_name').val();
            var packageId = $('#package_id').val();
            var packageNameMessage = document.getElementById('packageNameValidationMessage');
            if (!packageName.trim()) {
                packageNameMessage.textContent = "Package name is required.";
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
                const response = await fetch('/useradmin/check-package-edit-name', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token for Laravel
                    },
                    body: JSON.stringify({
                        packageName,
                        packageId
                    }),
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
                //Check if package_quantity array has empty values
                var package_quantity = $('input[name="package_quantity[]"]').map(function() {
                    return $(this).val();
                }).get();
                var empty = false;
                for (var i = 0; i < package_quantity.length; i++) {
                    if (package_quantity[i] == '') {
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

        $('input[name="package_quantity[]"]').on('input', function() {
            enableSubmitButton();
        });

        $('#package_name').on('input', function() {
            enableSubmitButton();
        });

        $('#category').change(function() {
            enableSubmitButton();
        });

        $('#price').on('input', function() {
            enableSubmitButton();
        });

        $('#status').change(function() {
            enableSubmitButton();
        });

        $('#description').on('input', function() {
            enableSubmitButton();
        });

        $('#type').change(function() {
            enableSubmitButton();
        });

        $('#image').change(function() {
            enableSubmitButton();
        });
        $('#price_visible').change(function() {
            enableSubmitButton();
        })

        function removeExistItem(button, itemId, quantity, packageItemId) {



            // Remove the item row from the second table
                $(button).closest('tr').remove();

                // Re-enable the "Add" button in the first table
                toggleAddButton(itemId, false);

                updateSendTable();
                // Add pacakgeItemId to removedItems array
                removedItems.push(packageItemId);
                // old_package_items
                $('#old_package_items').val(JSON.stringify(removedItems));

            
        }



        let currentRemoveButton = null;
        let currentItemId = null;
        let currentQuantity = null;
        let currentPackageItemId = null;

        function showConfirmRemoveModal(button, itemId, quantity, packageItemId) {
            currentRemoveButton = button;
            currentItemId = itemId;
            currentQuantity = quantity;
            currentPackageItemId = packageItemId;

            const modal = new bootstrap.Modal(document.getElementById('confirmPackageItemRemoveModal'));
            modal.show();
        }

        document.getElementById('confirmRemovePackageItemBtn').addEventListener('click', function() {
            if (currentRemoveButton) {
                removeExistItem(currentRemoveButton, currentItemId, currentQuantity, currentPackageItemId);
                const modal = bootstrap.Modal.getInstance(document.getElementById('confirmPackageItemRemoveModal'));
                modal.hide();
            }
        });
    </script>
@endsection
