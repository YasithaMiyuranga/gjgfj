@extends('layouts.employee')
@section('page-title', 'Rent')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.emp.assign.rent') }}">{{ 'Rent Details' }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Sent Rent Items</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <div class="col-xl-12">
                        <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                        <form method="post" action="{{ route('employee.emp.send.store') }}" id="sendForm">
                            @csrf
                            <?php
                            $user = Auth::user();
                            ?>
                            <input type="hidden" name="rent_id" id="rent_id" value=0>
                            <input type="hidden" name="selected_items" id="selected_items"
                                value="{{ old('selected_items') }}">
                            <div class="row">
                                <div class="col-md-6"><b>Date: {{ date('Y F d') }}</b></div>
                                <div class="col-md-6"><b>Time: {{ date('h:i A') }}</b></div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="event_id" class="form-label">Event :</label>
                                        <select name="event_id" id="event_id" class="form-control select2 mt-1">
                                            <option value="0">Select Event </option>
                                            @foreach ($events as $event)
                                                <option value="{{ $event->eid }}"
                                                    {{ old('event_id') == $event->eid ? 'selected' : '' }}>
                                                    {{ $event->event_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="package_name" class="form-label">Package Name :</label>
                                        <select name="rent_package_id" id="rent_package_id"
                                            class="form-control select2 mt-1">
                                            <option value="0">Select Package</option>
                                            {{-- Dynamically populate the package dropdown based on the selected event --}}
                                            @foreach ($rentItemPackages as $rentItemPackage)
                                                <option value="{{ $rentItemPackage->id }}"
                                                    {{ old('rent_package_id') == $rentItemPackage->id ? 'selected' : '' }}>
                                                    {{ $rentItemPackage->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_id" class="form-label">Order :</label>
                                        <select name="order_id" id="order_id" class="form-control select2 mt-1">
                                            <option value="0">Select Order </option>
                                            {{-- Dynamically populate the order dropdown based on the selected event --}}
                                            @foreach ($orders as $order)
                                                <option value="{{ $order->order_id }}"
                                                    {{ old('order_id') == $order->order_id ? 'selected' : '' }}>
                                                    {{ $order->order_id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="employee_id" class="form-label">Employee:</label>
                                        <input type="text" name="employee_name" id="employee_name" class="form-control"
                                            value="{{ Auth::user()->name }}" readonly>
                                        <input type="hidden" name="employee_id" id="employee_id"
                                            value="{{ Auth::guard('employee')->user()->emp_id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_name" class="form-label">Customer :</label>
                                        <input type="text" name="customer_name" id="customer_name" class="form-control"
                                            value="{{ old('customer_name') }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="predefined_package_id" class="form-label">Select Items From Predefined
                                            Package:</label>
                                        <select name="predefined_package_id" id="predefined_package_id"
                                            class="form-control select2 mt-1">
                                            <option value="">Select a Package</option>
                                            @foreach ($predefined_packages as $predefinedPackage)
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
                                {{-- <p id="quantityValidationMessage" style="color: red;"></p> --}}
                                <table class="table dataTable mt-4">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Item Type</th>
                                            <th>Quantity</th>
                                            <th>External Supplier</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td>{{ $item->item_type }}</td>
                                                @if ($item->in_stock == 0)
                                                    <td></td>
                                                    <td>
                                                        <input type="checkbox" id="external-item-{{ $item->item_id }}"
                                                            onchange="toggleExternalItemModal(this, {{ $item->item_id }}, '{{ $item->item_name }}')">
                                                        <label for="external-item-{{ $item->item_id }}">External
                                                            Supplier</label>
                                                    </td>
                                                    <td></td>
                                                @else
                                                    <td class="col-md-2">
                                                        <input type="number" max="10000" min="0"
                                                            class="form-control quantity-input" name="quantity-input"
                                                            value="1" data-item=""
                                                            oninput="validateQuantity(this, 'quantityValidationMessage-{{ $item->item_id }}')"
                                                            onkeypress="validateInputLength(this, 4)">
                                                        <span class="text-danger"
                                                            id="quantityValidationMessage-{{ $item->item_id }}"></span>
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning"
                                                            onclick="setItemId(this, '{{ $item->item_name }}', {{ $item->item_id }} )">
                                                            Add <i class="ti ti-plus py-1"></i>
                                                        </button>
                                                    </td>
                                                @endif
                                            </tr>
                                            {{-- External Supplier Modal (ONLY for out-of-stock items) --}}
                                            @if ($item->in_stock == 0)
                                                <div class="modal fade" id="externalSupplierModal-{{ $item->item_id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="externalSupplierModalLabel-{{ $item->item_id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="externalSupplierModalLabel-{{ $item->item_id }}">
                                                                    Select External Suppliers for {{ $item->item_name }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="externalSupplierForm-{{ $item->item_id }}">
                                                                    <div id="supplier-entries-{{ $item->item_id }}">
                                                                        <div class="supplier-entry mb-3">
                                                                            <label for="supplier-name"
                                                                                class="form-label">Supplier</label>
                                                                            <select class="form-control supplier-name">
                                                                                <option value="">Select Supplier
                                                                                </option>
                                                                                @foreach ($suppliers as $supplier)
                                                                                    <option value="{{ $supplier->id }}">
                                                                                        {{ $supplier->supplier_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <label for="supplier-price"
                                                                                class="form-label mt-2">Supplier
                                                                                Price</label>
                                                                            <input type="number"
                                                                                class="form-control supplier-price"
                                                                                placeholder="Supplier Price">
                                                                            <label for="supplier-quantity"
                                                                                class="form-label mt-2">Supplier
                                                                                Quantity</label>
                                                                            <input type="number"
                                                                                class="form-control supplier-quantity"
                                                                                placeholder="Supplier Quantity">
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm mt-2"
                                                                                onclick="removeSupplierEntry(this)">Remove</button>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-success btn-sm mt-3"
                                                                        onclick="addSupplierEntry({{ $item->item_id }})">Add
                                                                        Another Supplier</button>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button" class="btn btn-primary"
                                                                    onclick="saveExternalSuppliers({{ $item->item_id }}, '{{ $item->item_name }}')">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
                                    <button type="submit" class="btn btn-primary from-prevent-multiple-submits"
                                        id="submitBtn" disabled>Items Sent</button>
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
                // Create Ajax Request for get rent_item_packages and Order that belongs to the selected event
                $.ajax({
                    url: '/useradmin/get_rent_item_packages_and_orders/' + eventId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var rentItemPackages = response.rent_item_packages;
                        var orders = response.orders;
                        $('#customer_name').val(response.customerName);

                        // Load rent_item_packages into the select element
                        $('#rent_package_id').empty();
                        $('#rent_package_id').append(
                            '<option value="">Select a Rent Item Package</option>');
                        for (var i = 0; i < rentItemPackages.length; i++) {
                            var rentItemPackage = rentItemPackages[i];
                            var isSelected = '@json(old('rent_package_id'))' == rentItemPackage.id ?
                                'selected' : '';
                            $('#rent_package_id').append('<option value="' + rentItemPackage.id + '" ' +
                                isSelected + '>' + rentItemPackage.name + '</option>');
                        }

                        // Load orders into the select element
                        $('#order_id').empty();
                        $('#order_id').append('<option value="">Select an Order</option>');
                        for (var i = 0; i < orders.length; i++) {
                            var order = orders[i];
                            var isSelected = '@json(old('order_id'))' == order.order_id ?
                                'selected' : '';
                            $('#order_id').append('<option value="' + order.order_id + '">' + order
                                .order_id + '</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        showCustomAlert('Error fetching data.');
                    }
                })
                updateSendTable();
            }
        })
        // Rent Item Package change handler
        $('#rent_package_id').change(function() {
            var rentPackageId = $(this).val();
            if (rentPackageId) {
                $.ajax({
                    url: '/useradmin/get_rent_item_package/items/' + rentPackageId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var items = response.rent_item_package_items;
                        // Clear the existing selectedItems array
                        selectedItems = [];
                        for (var i = 0; i < items.length; i++) {
                            var item = items[i];
                            selectedItems.push({
                                itemId: item.item_id,
                                itemName: item.item_name,
                                quantity: item.quantity,
                                 supplierId: null,
                            });
                        }
                        updateSendTable();
                    },
                    error: function(xhr, status, error) {
                        showCustomAlert('Error fetching data.');
                    }
                })
            }
        });

        // Order change handler
        $('#order_id').change(function() {

            var orderId = $(this).val();
            var orderData = @json($orders);
            var selectedOrder = orderData.find(order => order.order_id == orderId);
            if (selectedOrder) {
                var orderedItems = selectedOrder.order_items;

                // // Clear the existing selectedItems array
                // selectedItems = [];

                for (var i = 0; i < orderedItems.length; i++) {
                    // Check if the item is already in the array
                    if (selectedItems.some(item => item.itemId == orderedItems[i].item_id)) {
                        continue;
                    } else {

                        var item = orderedItems[i];
                        selectedItems.push({
                            itemId: item.item_id,
                            itemName: item.item_name,
                            quantity: item.quantity,
                             supplierId: null,
                        });
                    }
                }
                updateSendTable();
            }
        });

        // Predefined Package change handler
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
                            quantity: item.quantity,
                            supplierId: null,
                        });
                    }
                    updateSendTable();
                }
            });
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
                        // Check external item checkbox
            const externalItemCheckbox = $(button).closest('tr').find(`#external-item-${itemId}`);
            // Check if the item is an external item and the checkbox is checked
            if (externalItemCheckbox.is(':checked')) {
                const supplierId = $(button).closest('tr').find(`#supplier-name-${itemId}`);
                var quantityInput = $(button).closest('tr').find('.quantity-input');
                const supplierPriceInput = $(button).closest('tr').find(`#supplier-price-${itemId}`);
                 // Check if the item is already in the array
                for (var i = 0; i < selectedItems.length; i++) {
                    if (selectedItems[i].itemId == itemId) {
                        var existingItem = parseInt(selectedItems[i].quantity);
                        selectedItems[i].quantity = existingItem + parseInt(quantityInput.val());
                        selectedItems[i].supplierId = supplierId.val();
                        selectedItems[i].supplierPrice = supplierPriceInput.val();
                        updateSendTable();
                        return;
                    }
                }
                // Add selected item and quantity to the array
                selectedItems.push({
                    itemId: itemId,
                    itemName: itemName,
                    quantity: quantityInput.val(),
                    supplierId: supplierId.val(),
                    supplierPrice: supplierPriceInput.val()
                })

                updateSendTable();
            }
            else{ fetch(`/useradmin/check-item-quantity/${itemId}`)
                .then(response => response.json())
                .then(data => {
                    var quantityInput = $(button).closest('tr').find('.quantity-input');
                    var quantity = quantityInput.val();

                    //check if item is in_stock > entered quantity
                    if (data.in_stock >= quantity) {
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
                            `Sorry, ${itemName} cannot be added due to item value restrictions. Maximum value should be ${data.in_stock}.`;
                        showCustomAlert(errorMessage);
                    }
                })
                .catch(error => {
                    showCustomAlert('Error checking item availability.');
                });
            }
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
                    '<input type="number" class="form-control quantity-input-2" oninput="validateQuantity(this, \'quantityValidationMessage2-' +
                    item.itemId + '\'); checkQuantity(this, ' + item.itemId + ', \'' + item.itemName + '\')" value="' +
                    item.quantity + '">' +
                    '<span class="text-danger" id="quantityValidationMessage2-' + item.itemId + '"></span>' +
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
            if ($('#employee_id').val() != 0 && selectedItems.length > 0 && $('#customer_name').val() != 0) {
                console.log('enable');

                $('#sendForm button[type="submit"]').prop('disabled', false);
            } else {
                console.log('disable');
                $('#sendForm button[type="submit"]').prop('disabled', true);
            }
        }

        $('#employee_id').change(function() {
            enableSubmitButton();
        });

        $('#customer_id').change(function() {
            enableSubmitButton();
        });

        $(document).ready(function() {
            $('#sendForm').on('submit', function() {
                $('.from-prevent-multiple-submits').attr('disabled', 'true');
                $('#selected_items').val(JSON.stringify(selectedItems));
                this.submit();
            });
        });

        function checkQuantity(input, itemId, itemName) {
           // Get the quantity
            var quantity = input.value;

            // Check that item has supplierId in selectedItems
            const item = selectedItems.find(item => item.itemId == itemId);
            if (item && item.supplierId) {
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
                }

                return;
            }
            if (quantity > 0) {
                fetch(`/useradmin/check-item-quantity/${itemId}`)
                    .then(response => response.json())
                    .then(data => {
                        var quantityInput = quantity;

                        //check if item is in_stock > entered quantity
                        if (data.in_stock >= quantity) {

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











 // Show External Supplier Modal
        function toggleExternalItemModal(checkbox, itemId, itemName) {
            if (checkbox.checked) {
                // Open the modal for the specific item
                $(`#externalSupplierModal-${itemId}`).modal('show');
            } else {
                // Remove the item from the selectedItems array if unchecked
                selectedItems = selectedItems.filter(item => item.itemId !== itemId || !item.supplierId);
                updateSendTable();
            }
        }
        // Add supplier entry
        function addSupplierEntry(itemId) {
            const supplierEntries = document.getElementById(`supplier-entries-${itemId}`);
            const newEntry = document.createElement('div');
            newEntry.classList.add('supplier-entry', 'mb-3');
            newEntry.innerHTML = `
                <label for="supplier-name" class="form-label">Supplier</label>
                <select class="form-control supplier-name" required>
                    <option value="">Select Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                    @endforeach
                </select>
                <label for="supplier-price" class="form-label mt-2">Supplier Price</label>
                <input type="number" class="form-control supplier-price" placeholder="Supplier Price" required>
                <label for="supplier-quantity" class="form-label mt-2">Supplier Quantity</label>
                <input type="number" class="form-control supplier-quantity" placeholder="Supplier Quantity" required>
                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeSupplierEntry(this)">Remove</button>
            `;
            supplierEntries.appendChild(newEntry);
        }
        // Remove supplier entry
        function removeSupplierEntry(button) {
            button.parentElement.remove();
        }
        // Save external suppliers
        function saveExternalSuppliers(itemId, itemName) {
            const supplierEntries = document.querySelectorAll(`#supplier-entries-${itemId} .supplier-entry`);

            supplierEntries.forEach(entry => {
                const supplierId = entry.querySelector('.supplier-name').value;
            const supplierName = entry.querySelector('.supplier-name').options[entry.querySelector('.supplier-name').selectedIndex].text;
                const supplierPrice = entry.querySelector('.supplier-price').value;
                const supplierQuantity = entry.querySelector('.supplier-quantity').value;

                if (!supplierId || !supplierPrice || !supplierQuantity) {
                    alert('Please select a supplier and enter a price and quantity.');
                    return;
                }

                // Check if the item with the same supplier already exists
                const existingItem = selectedItems.find(item => item.itemId === itemId && item.supplierId === parseInt(supplierId));
                if (existingItem) {
                    alert(`Supplier ${supplierName} is already added for this item.`);
                    return;
                }

                // Add the item to the selectedItems array
                selectedItems.push({
                    itemId: itemId,
                    itemName: `${itemName} - ${supplierName}`,
                    supplierId: parseInt(supplierId),
                    supplierName: supplierName,
                    supplierPrice: parseFloat(supplierPrice),
                    quantity: parseInt(supplierQuantity)
                });
            });

            // Close the modal and update the table
            $(`#externalSupplierModal-${itemId}`).modal('hide');
            updateSendTable();
        }













    </script>
@endsection
