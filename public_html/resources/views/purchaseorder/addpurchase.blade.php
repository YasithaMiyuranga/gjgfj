@extends('layouts.app')
@section('page-title', __('Purchase Order'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.purchaseorder.view') }}">{{__('Purchase Orders') }}</a>
        <li class="breadcrumb-item active">{{ __('Add Purchase Order') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Add Purchase Order</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <br>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="post" action="{{ route('useradmin.purchaseorder.add') }}" id="sendForm" class="form-submit-click">
                        @csrf
                        <?php
                        $user = Auth::user();
                        ?>
                        {{-- <input type="hidden" name="rent_id" id="rent_id" value=0> --}}
                        <input type="hidden" name="selected_items" id="selected_items" value="">

                        <div class="row">
                            <div class="col-md-6"><b>Date: {{ date('Y F d') }}</b></div>
                            <div class="col-md-6 text-right"><b>Time: {{ date('h:i A') }}</b></div>
                        </div>

                        <div id ="fillable_section" style="display: block">
                            <div class="row mt-4">
                                <div class="col-md-12" style="padding-right: 25px">
                                    <div class="form-group">
                                        <label for="supplier_id" class="form-label">Supplier:   *</label>
                                        <select name="supplier_id" id="supplier_id" class="form-control select2 mt-1" required>
                                            <option value="0">Select Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="invoice_number" class="form-label">Invoice Number:*</label>
                                        <input type="text" class="form-control" id="invoice_number"
                                            name="invoice_number" value="" oninput="validateInputLength(this,50)"
                                            required>
                                        <p id="invoiceValidationMessage" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="invoice_number" class="form-label">Purchase Date:*</label>
                                        <input type="date" class="form-control" id="purchase_date"
                                            name="purchase_date" value="{{ date('Y-m-d') }}" max="" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary btn-sm" id="toggle_section"
                                    onclick="showItemSection()" disabled> Show/Hide Sections</button>
                            </div>
                        </div>

                        <div id="item_section" style="display: none">
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="mt-1 table-responsive">
                                        <p id="quantityValidationMessage" style="color: red;"></p>
                                        <p id="priceValidationMessage" style="color: red;"></p>
                                        <table class="table dataTable mt-4" id="orderedItemsIncludeTable">
                                            <thead>
                                                <tr>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $item)
                                                    <tr>
                                                        <td class="col-md-5">{{ $item->item_name }}</td>
                                                        <td class="col-md-1">
                                                            <input type="number" max="10000" min="0"
                                                                class="form-control quantity-input"
                                                                name="quantity-input" value="1" data-item=""
                                                                oninput="validateQuantity(this, 'quantityValidationMessage')"
                                                                onkeypress="validateInputLength(this, 4)">
                                                        </td>
                                                        <td class="col-md-1">
                                                            <input type="number" max="10000000" min="0"
                                                                class="form-control price-input" name="quantity-input"
                                                                value="{{ $item->product_amount }}" data-item=""
                                                                oninput="validatePrice(this, 'priceValidationMessage')"
                                                                onkeypress="validateInputLength(this, 7)">
                                                        </td>
                                                        <td class="col-md-1">
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
                                </div>
                                &nbsp;&nbsp;
                                <div class="col-md-12 mb-4">
                                    <div class="mt-2 table-responsive cash-flows-table order-items ordertable">
                                        <table class="table dataTable mt-6" id="sendTable" style="display: none">
                                            <thead>
                                                <tr>
                                                    <th>Item Name</th>
                                                    <th>Unit Price</th>
                                                    <th>Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-20">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="credit_balance" class="form-label">Credit Balance:*</label>
                                            <input type="number" class="form-control" id="credit_balance"
                                                name="credit_balance" value=0.00 oninput="validateInputLength(this,12)"
                                                readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_price" class="form-label">Total Price:*</label>
                                            <input type="number" class="form-control" id="total_price"
                                                name="total_price" value=0.00 oninput="validateInputLength(this,12)"
                                                readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pay_type" class="form-label">Pay Type:  *</label>
                                            <select name="pay_type" id="pay_type" class="form-control mt-1" required>
                                                <option value="0">Select Pay Type</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Cheque">Cheque</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="discount_percentage" class="form-label">Discount Percentage (%):*</label>
                                            <input type="number" class="form-control" id="discount_percentage"
                                                name="discount_percentage" value=0 step=0.1
                                                onkeypress="validateInputLength(this,3)" oninput="validatePercentage()"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cash_payment" class="form-label">Payment Amount:*</label>
                                            <input type="number" class="form-control" id="cash_payment"
                                                name="cash_payment" value=0.00 step="0.1"
                                                onkeypress="validateInputLength(this,12)" oninput="calculateBalance()"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="discount_amount" class="form-label">Discount Amount:*</label>
                                            <input type="number" class="form-control" id="discount_amount"
                                                name="discount_amount" value=0.00 step=0.1
                                                onkeypress="validateInputLength(this,10)" oninput="calculateDiscount()"
                                                readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="balance" class="form-label">Balance:</label>
                                            <input type="number" class="form-control" id="balance" name="balance"
                                                value=0.00 oninput="validateInputLength(this,12)" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="grand_total" class="form-label">Grand Total:*</label>
                                            <input type="number" class="form-control" id="grand_total"
                                                name="grand_total" value=0.00 step=0.1
                                                onkeypress="validateInputLength(this,12)" oninput="validatePercentage()"
                                                readonly required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="submit" id="purchase_btn" class="btn btn-primary"
                                            disabled>Complete
                                            Purchase Order</button>
                                    </div>
                                </div>
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

        $('.select2').select2({
            placeholder: "Select an Option"
        });

        var today = new Date().toISOString().split('T')[0];
        document.getElementById('purchase_date').setAttribute('max', today);

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
        //Validate Input Length
        function validateInputLength(input, maxLength) {
            var inputValue = input.value.toString();
            if (inputValue.length > maxLength) {
                input.value = inputValue.slice(0, maxLength);
            }
        }

        //Validate Percentage
        function validatePercentage() {
            var discountPercentage = document.getElementById('discount_percentage').value;
            if (discountPercentage < 0) {
                document.getElementById('discount_percentage').value = 0;
            }
            if (discountPercentage > 100) {
                document.getElementById('discount_percentage').value = 100;
            }
            calculateDiscount();
        }

        //Calculate Discount
        function calculateDiscount() {
            var discountPercentage = document.getElementById('discount_percentage').value;
            var totalPrice = document.getElementById('total_price').value;
            var discountAmount = (totalPrice * discountPercentage) / 100;
            document.getElementById('discount_amount').value = discountAmount;
            calculateGrandTotal();
        }

        //Calculate Grand Total
        function calculateGrandTotal() {

            var credit_balance = document.getElementById('credit_balance').value;
            credit_balance = parseFloat(credit_balance);
            if (isNaN(credit_balance)) {
                credit_balance = 0.00;
            }
            let totalPrice = document.getElementById('total_price').value;
            let discountAmount = document.getElementById('discount_amount').value;
            let grandTotal = totalPrice - discountAmount;
            document.getElementById('grand_total').value = grandTotal;
            grandTotal = parseFloat(grandTotal);
            if (isNaN(grandTotal)) {
                grandTotal = 0.00;
            }
            grandTotal = grandTotal + credit_balance;
            document.getElementById('grand_total').value = grandTotal;
            calculateBalance();
        }

        //Calculate Balance
        function calculateBalance() {
            var grandTotal = document.getElementById('grand_total').value;
            grandTotal = parseFloat(grandTotal);
            var cashPayment = document.getElementById('cash_payment').value;
            cashPayment = parseFloat(cashPayment);
            if (isNaN(cashPayment)) {
                cashPayment = 0.00;
            }
            var balance = cashPayment - grandTotal;
            document.getElementById('balance').value = balance;
        }

        //Calculate Credit Balance
        function calculateCreditBalance() {
            var grandTotal = document.getElementById('grand_total').value;
            var cashPayment = document.getElementById('cash_payment').value;
            var creditBalance = grandTotal - cashPayment;
            document.getElementById('credit_balance').value = creditBalance;
        }

        //Validate Price
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
            if (price > 10000000) {
                input.value = 10000000;
                validationMessage.textContent = "Maximum value should be 10000000.";
                input.setCustomValidity("Maximum value should be 10000000.");
            }
        }

        function setItemId(button, itemName, itemId) {
            var quantityInput = $(button).closest('tr').find('.quantity-input');
            var quantity = quantityInput.val();
            var price = $(button).closest('tr').find('.price-input').val();

            if (quantity > 0 && price > 0) {
                // Add selected item and quantity to the array
                selectedItems.push({
                    itemId: itemId,
                    itemName: itemName,
                    quantity: quantity,
                    price: price
                });
                toggleAddButton(itemId, true);
                updateSendTable();
                calculateDiscount();
                calculateGrandTotal();
            } else {
                $('#quantityValidationMessage').text('Please enter a valid value.');
            }
        }

        function removeItem(button, itemId) {
            var indexToRemove = $(button).closest('tr').index();
            selectedItems.splice(indexToRemove, 1);
            toggleAddButton(itemId, false);
            updateSendTable();
            calculateDiscount();
            calculateGrandTotal();
        }

        function updateSendTable() {
            var sendTableBody = $('#sendTable tbody');
            sendTableBody.empty();

            for (var i = 0; i < selectedItems.length; i++) {
                var item = selectedItems[i];
                var row = $('<tr></tr>');

                // Item Name
                row.append('<td>' + item.itemName + '</td>');
                // Price
                row.append('<td>' + item.price + '</td>');

                // Quantity controls
                var quantityControls = $('<td class="qty d-flex"></td>');
                quantityControls.append('<input type="number" class="form-control qty-input-field w-50" inputmode="numeric" value="' + item.quantity +
                    '" oninput="updateQuantity(this, ' + i + ')" min="1" max="10000" readonly>');
                quantityControls.append(
                    '<button type="button" class="btn btn-secondary qty-btn-plus" onclick="increaseQuantity(this)"><i class="ti ti-plus"></i></button>');
                quantityControls.append(
                    '<button type="button" class="btn btn-secondary qty-btn-minus" onclick="decreaseQuantity(this)"><i class="ti ti-minus"></i></button>');
                row.append(quantityControls);

                // Remove button
                row.append(
                    '<td><button type="button" class="btn btn-danger"  onclick="removeItem(this, ' + item.itemId + ')">Remove</button></td>');

                row.append('<input type="hidden" name="item_id[]" value="' + item.itemId + '">');
                row.append('<input type="hidden" name="quantity[]" value="' + item.quantity + '">');

                sendTableBody.append(row);
            }

            var totalPrice = 0.00;
            for (var i = 0; i < selectedItems.length; i++) {
                totalPrice += selectedItems[i].quantity * selectedItems[i].price;
            }
            $('#total_price').val(totalPrice);

            if (selectedItems.length > 0) {
                $('#sendTable').show();
            } else {
                $('#sendTable').hide();
            }
            enableSubmitButton();
        }


        $('#sendForm').submit(function() {
            $('#selected_items').val(JSON.stringify(selectedItems));
        });

        // //Disable 'Add' button for item if it is already added
        // function disableAddButton(itemId) {
        //     var addButton = $('button[data-item="' + itemId + '"]');
        //     addButton.prop('disabled', true);
        //     var priceInput = addButton.closest('tr').find('.price-input');
        //     priceInput.prop('readonly', true);
        //     var quantityInput = addButton.closest('tr').find('.quantity-input');
        //     quantityInput.prop('readonly', true);
        // }


        var allitems = @json($items);

        // //Enable 'Add' button for item if it is removed
        // function enableAddButton(itemId) {
        //     var addButton = $('button[data-item="' + itemId + '"]');
        //     addButton.prop('disabled', false);
        //     var priceInput = addButton.closest('tr').find('.price-input');
        //     priceInput.prop('readonly', false);
        //     var quantityInput = addButton.closest('tr').find('.quantity-input');
        //     quantityInput.prop('readonly', false);
        // }

        function decreaseQuantity(button) {
            var input = $(button).siblings('.qty-input-field'); // Correctly select the input field
            var newValue = parseInt(input.val()) - 1;
            if (newValue < 1) {
                newValue = 1;
            }
            input.val(newValue); // Update the input value
            updateQuantity(newValue, input.closest('tr').index()); // Call updateQuantity with correct arguments
        }


        function increaseQuantity(button) {
            var input = $(button).prev('input');
            var newValue = parseInt(input.val()) + 1;
            if (newValue > 10000) {
                newValue = 10000;
            }
            input.val(newValue);
            updateQuantity(newValue, input.closest('tr').index());
        }

        function updateQuantity(input, index) {
            var newValue = parseInt(input);
            if (newValue < 1) {
                newValue = 1;
            }
            if (newValue > 10000) {
                newValue = 10000;
            }
            selectedItems[index].quantity = newValue;

            //Get the price of the item from Selected Items Array
            var price = selectedItems[index].price;
            $('#total_price').val(price);
            updateSendTable();
            calculateDiscount();
            calculateGrandTotal();
        }

        function enableSubmitButton() {
            if (selectedItems.length > 0 && $('#supplier_id').val() != 0 && $('#invoice_number').val() != '' &&
                $('#purchase_date').val() != '' && $('#pay_type').val() != 0 &&
                $('#cash_payment').val() != 0) {
                $('button[type="submit"]').prop('disabled', false);
            } else {
                $('button[type="submit"]').prop('disabled', true);
            }
        }

        $('#supplier_id').change(function() {
            var supplierId = $(this).val();
            var creditBalance = 0.00;
            if (supplierId != 0) {
                var supplier = @json($suppliers);
                creditBalance = supplier.find(supplier => supplier.id == supplierId).credit_balance;
            }
            $('#credit_balance').val(creditBalance);
            calculateGrandTotal();
            enableSubmitButton();
        });


        $('#invoice_number').on('input', function() {
            enableSubmitButton();
            enableToggleBtn();
        });

        $('#purchase_date').on('input', function() {
            enableSubmitButton();
            enableToggleBtn();
        });

        $('#pay_type').change(function() {
            enableSubmitButton();
        });

        $('#cash_payment').on('input', function() {
            enableSubmitButton();
            //calculateCreditBalance();
        });

        $('#supplier_id').change(function() {
            enableSubmitButton();
            //calculateCreditBalance();
            enableToggleBtn();
        });

        //Enable toggle section button
        function enableToggleBtn() {
            if ($('#supplier_id').val() != 0 && $('#invoice_number').val() != '' &&
                $('#purchase_date').val() != '') {
                $('#toggle_section').prop('disabled', false);
            } else {
                $('#toggle_section').prop('disabled', true);
            }
        }

        function showItemSection() {
            var itemSection = document.getElementById('item_section');
            var fillableSection = document.getElementById('fillable_section');
            var toggleSection = document.getElementById('toggle_section');
            if (itemSection.style.display === "none") {
                itemSection.style.display = "block";
                fillableSection.style.display = "none";
            } else {
                itemSection.style.display = "none";
                fillableSection.style.display = "block";
            }
        }
    </script>
@endsection
