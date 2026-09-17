@extends('layouts.app')
@section('page-title', __('Predefined Packages'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.predefined.all') }}">{{__('Packages') }}</a>
        <li class="breadcrumb-item active">{{ __('Add Predefined Packages List') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Add Predefined Packages List</h3>
                </div>
                <hr>
                <div class="card-body table-border-styles">
                    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                    <form method="post" action="{{ route('useradmin.savepredefined') }}" id="sendForm" class="form-submit-click">
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
                                    value="" required  maxlength="100" pattern="([0-9\s]+|[A-Za-z0-9\s]+)"
                                    oninput="validatePackageName(this, 'packageNameValidationMessage', 100)">
                                <p id="packageNameValidationMessage" style="color: red;"></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="category" class="form-label">{{ ('Category  *') }}</label>
                                <select id="category" class="form-control" name="category" required>
                                    <option value="">Select Category</option>
                                    @foreach ($packageCategories as $category)
                                        <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="package_status" class="form-label">{{ ('Display Package Items On Order  *') }}</label>
                                <select id="package_status" class="form-control" name="package_status" required>
                                    <option value="Active">Yes</option>
                                    <option value="Inactive">No</option>
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
                                            <td>{{ $item->item_name }}</td>
                                            <td class="col-md-4">
                                                <input type="number"  min="1"
                                                class="form-control rentprice-input" name="rentprice-input" value="{{ intval($item->rent_price) }}"
                                                oninput="validateRentPrice(this, 'quantityValidationMessage')"
                                                onkeypress="validateInputLength(this, 7)">
                                            </td>
                                            <td class="col-md-4">
                                                <input type="number" max="10000" min="0"
                                                    class="form-control quantity-input" name="quantity-input" value="1"
                                                    oninput="validateQuantity(this, 'quantityValidationMessage')"
                                                    onkeypress="validateInputLength(this, 4)">
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-warning"
                                                    data-itemId="{{ $item->item_id }}"
                                                    onclick="setItemId(this, '{{ $item->item_name }}', {{ $item->item_id }})">Add
                                                    <i class="ti ti-plus py-1"></i></button>
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
                                <button type="submit" class="btn btn-primary" disabled>Create Package</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}

    <script>
        // JavaScript Code
        var selectedItems = [];
        var disabledButtons = {}; // Tracks disabled state for buttons

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

        // $('.select2').select2({
        //     placeholder: "Select an Option"
        // });
        $(document).ready(function() {
            // Initialize Choices for the order_id dropdown
            const orderIdChoice = new Choices('#category', {
                placeholder: true,
                searchEnabled: true,
            });
        })
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
                // Add selected item and quantity and rent price to the array
                selectedItems.push({
                    itemId: itemId,
                    itemName: itemName,
                    rent_price: rent_price,
                    quantity: quantity
                });
                toggleAddButton(itemId, true);
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
                const response = await fetch('/useradmin/check-predefinedpackage-name', {
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
            if (selectedItems.length > 0 && $('#package_name').val() != '') {
                $('#sendForm button[type="submit"]').prop('disabled', false);
            } else {
                $('#sendForm button[type="submit"]').prop('disabled', true);
            }
        }

        $('#package_name').on('input', function() {
            enableSubmitButton();
        });
    </script>
@endsection
