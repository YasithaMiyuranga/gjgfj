@extends('layouts.app')
@section('page-title', __('Orders'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.order.create') }}">{{ __('Order Create') }} </a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header ">
                    <h5></h5>
                    <h3>Create Order</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.order.event.create') }}" data-size="lg" data-ajax-popup="true"
                        data-title="{{ __('Create Event') }}">
                        Create Event
                    </button>
                </div>
                    <div class="card-body table-border-style">
                        <form method="post" action="{{ route('useradmin.order.store') }}" id="orderForm">
                            @csrf
                            <?php
                            $user = Auth::user();
                            ?>
                            <input type="hidden" name="rent_id" id="rent_id" value=0>
                            <input type="hidden" name="selected_items" id="selected_items" value="">
                            <input type="hidden" name="rent_package" id="rent_package" value="">
                            <input type="hidden" name="predefinedPackage" id="predefinedPackage" value="">
                            <div class="row">
                                <div class="col-md-6"><b>Date: {{ date('Y F d') }}</b></div>
                                <div class="col-md-6"><b>Time: {{ date('h:i A') }}</b></div>
                            </div>
                            <br>
                            <div id="dineInSection1" class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="event_name" class="form-label">Event: *</label>
                                        <select class="form-control select2" name="event_id" id="event_name" required>
                                           <option value="">Select Event</option>
                                           @foreach ($events as $event)
                                               @php
                                                   $jsonevetValue = json_encode([
                                                       'id' => $event->eid,
                                                       'name' => $event->event_name,
                                                   ]);
                                               @endphp
                                               <option value="{{ $event->eid }}"
                                                   {{ old('event_id') == $jsonevetValue || $event->eid == $selectedEventId ? 'selected' : '' }}>
                                                   {{ $event->event_name }}
                                               </option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_name" class="form-label">Customer Name: *</label>
                                        <input type="text" class="form-control" name="customer_name" id="customer_name"
                                            readonly required value="{{ old('customer_name') }}">
                                            <input type="hidden" name="customer_id" id="customer_id" readonly required value="{{ old('customer_id') }}">
                                        @if ($errors->has('customer_name'))
                                            <span class="text-danger"
                                                id="nameError">{{ $errors->first('customer_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_phone" class="form-label">Phone Number:    *</label>
                                        <input type="text" class="form-control" name="customer_phone" id="customer_phone"
                                            readonly required value="{{ old('customer_phone') }}">
                                        @if ($errors->has('customer_phone'))
                                            <span class="text-danger"
                                                id="phoneError">{{ $errors->first('customer_phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="location" class="form-label">Location:  *</label>
                                        <input type="text" class="form-control" name="location" id="location" readonly required
                                            value="{{ old('location') }}">
                                        <span class="text-danger" id="locationError"></span>
                                        @if ($errors->has('location'))
                                            <span class="text-danger"
                                                id="locationError">{{ $errors->first('location') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="dineInSection" class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_time" class="form-label">Start Time:  *</label>
                                        <input type="text" class="form-control" name="start_time" id="start_time"
                                            required value="{{ old('start_time') }}">
                                        @if ($errors->has('start_time'))
                                            <span class="text-danger"
                                                id="start_timeError">{{ $errors->first('start_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="end_time" class="form-label">End Time:  *</label>
                                        <input type="text" class="form-control" name="end_time" id="end_time"
                                            required value="{{ old('end_time') }}">
                                        @if ($errors->has('end_time'))
                                            <span class="text-danger"
                                                id="end_timeError">{{ $errors->first('end_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="booking_date" class="form-label">Booking Date:  *</label>
                                        <input type="text" class="form-control" name="booking_date" id="booking_date"
                                            required value="{{ old('booking_date') }}">
                                        @if ($errors->has('booking_date'))
                                            <span class="text-danger"
                                                id="booking_dateError">{{ $errors->first('booking_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="dineInSection3" class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inv_date" class="form-label">Invoice Date:  *</label>
                                        <input type="date" class="form-control" name="inv_date" id="inv_date"
                                            required value="{{ old('inv_date') }}">
                                        @if ($errors->has('inv_date'))
                                            <span class="text-danger"
                                                id="inv_dateError">{{ $errors->first('inv_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_type" class="form-label">Order Type:  *</label>
                                        <select class="form-select" name="order_type" id="order_type" required>
                                            <option value="">Select order type</option>
                                            <option value="quotation"
                                                {{ old('order_type') == 'quotation' ? 'selected' : '' }}>
                                                Quotation</option>
                                            <option value="invoice" {{ old('order_type') == 'invoice' ? 'selected' : '' }}>
                                                Invoice
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div id="orderStatusField" class="col-md-6">
                                    <div>
                                        <div class="form-group">
                                            <label for="order_status" class="form-label">Status:    *</label>
                                            <select class="form-control" name="order_status" id="order_status">
                                                <option value="pending"
                                                    {{ old('order_status') == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="credit order"
                                                    {{ old('order_status') == 'credit order' ? 'selected' : '' }}>
                                                    Credit Order
                                                </option>
                                                <option value="completed" id="complete"
                                                    {{ old('order_status') == 'completed' ? 'selected' : '' }}>
                                                    Complete
                                                </option>
                                                <option value="booking"
                                                    {{ old('order_status') == 'booking' ? 'selected' : '' }}>
                                                    Booking
                                                </option>
                                                <option value="canceled"
                                                    {{ old('order_status') == 'canceled' ? 'selected' : '' }}>
                                                    Canceled
                                                </option>
                                                <option value="pending payment"
                                                    {{ old('order_status') == 'pending payment' ? 'selected' : '' }}>
                                                    Pending Payment
                                                </option>
                                                <option value="completed payment"
                                                    {{ old('order_status') == 'completed payment' ? 'selected' : '' }}>
                                                    Completed Payment
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="payment_fields" style="display: none;" class="col-md-6">
                                    <div class="d-flex  flex-column-reverse">
                                        <div class="form-group">
                                            <label for="is_pay" class="form-label">Is Pay:</label>
                                            <input type="checkbox" class="form-check-input" name="is_pay" id="is_pay" value="1"
                                                {{ old('is_pay') == '1' ? 'checked' : '' }}>
                                            <label for="is_pay">Tick this box if the order is paid.</label>
                                        </div>
                                        <div class="">
                                            <div class="form-group">
                                                <label for="pay_amount" class="form-label">Advance Amount:</label>
                                                <input type="text" name="pay_amount" class="form-control"
                                                    id="pay_amount" min="0" step="0.01"
                                                    value="{{ old('pay_amount') }}">
                                                @if ($errors->has('pay_amount'))
                                                    <span class="text-danger"
                                                        id="pay_amountError">{{ $errors->first('pay_amount') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" id="display-none">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Employee Name:</label>
                                        <select class="form-control" name="name[]" id="name" multiple>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->name }}"
                                                    {{ in_array($employee->name, old('name', [])) ? 'selected' : '' }}>
                                                    {{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="predefined_package" class="form-label">Select Items From Predefined
                                            Package:</label>
                                        <select class="form-control" name="predefined_package"
                                            id="predefined_package_id">
                                            <option value="0">Select a Package</option>
                                            @foreach ($predefined_packages as $predefinedPackage)
                                                <option value="{{ $predefinedPackage->package_id }}">
                                                    {{ $predefinedPackage->package_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class ="col-md-6">
                                    <div class="form-group">
                                        <label for="Bank_account" class="form-label">Bank Account:</label>
                                       <select class="form-control" name="Bank_account" id="Bank_account">
                                           <option value="">Select a Bank Account</option>
                                           @foreach ($bankAccounts as $bankAccount)
                                               <option value="{{ $bankAccount->id }}" {{ old('Bank_account') == $bankAccount->id ? 'selected' : '' }}>
                                                   {{ $bankAccount->bank_name }} - {{ $bankAccount->branch_name }} {{ $bankAccount->account_name }}
                                               </option>
                                           @endforeach
                                       </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="special_note" class="form-label">Special Note:</label>
                                        <textarea name="special_note" id="special_note" class="form-control" id="special_note" rows="4" >{{ old('special_note') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="table-responsive mt-2 px-4">
                                <p id="quantityValidationMessage" style="color: red;"></p>
                                <table class="table dataTable mt-4" id="orderedItemsIncludeTable">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Category</th>
                                            <th>Rent Price</th>
                                            <th>Discount</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($viewitems as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td>{{ $item->category }}</td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control rent-input"
                                                        name="rent-input" value="{{ $item->rent_price }}"
                                                        oninput="validateRent(this, 'rentValidationMessage-{{ $item->item_id }}')">
                                                        <span class="text-danger" id="rentValidationMessage-{{ $item->item_id }}"></span>
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01"
                                                        class="form-control discount-input" name="discount-input"
                                                        value="0"
                                                        oninput="validateDiscount(this, 'discountValidationMessage-{{ $item->item_id }}')">
                                                        <span class="text-danger" id="discountValidationMessage-{{ $item->item_id }}"></span>
                                                </td>
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
                                                        onclick="setItemId(this, '{{ $item->item_name }}', '{{ $item->category }}', '{{ $item->rent_price }}', {{ $item->item_id }})">Add
                                                        <i class="ti ti-plus py-1"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive px-4 mt-2 ordertable">
                                <table class="table  mt-4" id="sendTable" style="display: none">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Rent Price</th>
                                            <th>Quantity</th>
                                            <th>Discount</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    </th>
                                </table>
                            </div>
                            <br><br>
                            <div class="px-4">
                                <div class="row justify-content-end">
                                    <div class="col-md-12 mt-3 px-3 py-4">
                                        <h3>Order Bill</h3>
                                        <div class="table-responsive mt-4 px-2">
                                            <table class="table table-bordered" id="ordersTable">
                                                <tbody>
                                                    <tr>
                                                        <td>Total Price:</td>
                                                        <td>
                                                            <div id="totalPrice" class="mb-2"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Transport:</td>
                                                        <td><input type="number" min="0" step="0.01"
                                                                class="form-control" name="transport" id="transport"
                                                                value="{{ old('transport', '0') }}"
                                                                oninput="updateOrderBill()">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Service Charge:</td>
                                                        <td><input type="number" min="0" step="0.01"
                                                                class="form-control" name="tax" id="tax"
                                                                value="{{ old('tax', '0') }}"
                                                                oninput="updateOrderBill()"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Net Amount:</td>
                                                        <td><span id="netAmount">{{ old('net_amount', '0.00') }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Discount:</td>
                                                        <td><input type="number" min="0" step="0.01"
                                                                class="form-control" name="total_discount"
                                                                id="displayTotalDiscount"
                                                                value="{{ old('total_discount', '0') }}"
                                                                oninput="updateOrderBill()"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Price:</td>
                                                        <td><input type="number" min="0" step="0.01"
                                                                class="form-control" name="additional_price"
                                                                id="additional_price"
                                                                value="{{ old('additional_price', '0') }}"
                                                                oninput="updateOrderBill()"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Advance Amount:</td>
                                                        <td><span
                                                                id="displayPayAmount">{{ is_numeric(old('payment_amount')) ? old('payment_amount') : '0.00' }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Grand Total:</td>
                                                        <td><span id="displayFinalAmount"
                                                                name="displayFinalAmount">{{ old('final_amount', '0.00') }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="terms-conditions">
                                        <h4>Terms & Conditions</h4>
                                        <div class="border rounded">
                                            <div class="row py-3 px-2">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title" class="form-label">Select Title:</label>
                                                        <select class="form-control termsSelect" name="terms_and_conditions[term_id]" id="title" onchange="updateDescription()">
                                                            <option value="">Select a title</option>
                                                            @foreach ($terms as $term)
                                                                <option value="{{ $term->id }}" data-description="{{ htmlspecialchars($term->description) }}">
                                                                    {{ $term->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="terms_conditions" class="form-label">Description:</label>
                                                        <textarea class="form-control" name="terms_and_conditions[description]" id="terms_conditions" rows="5">{{ old('terms_and_conditions.description') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="mb-3" style="display: flex; flex-direction: row; gap: 15px;">
                                            <input type="checkbox" class="form-check-input" id="confirmWithItemPrice"
                                                name="confirmWithItemPrice">
                                            <label for="confirmWithItemPrice">Confirm Order With Item Price</label>
                                        </div>
                                        <div class="button-style" style="display: flex; flex-direction: row; gap: 15px; flex-wrap: wrap; padding-bottom:20px; ">
                                            <!-- Confirm Order Button -->
                                            <button type="submit" class="btn btn-success btn-custom" id="confirmOrderBtn" style="width: 200px; padding: 10px; font-size: 14px;"
                                                disabled>
                                                Confirm Order
                                            </button>
                                            {{--rent_package--}}
                                            <button type="button" class="btn btn-primary btn-md" data-url="" data-size="md" id="rentPackageBtn" style="width: 200px; padding: 10px; font-size: 14px;"
                                                data-ajax-popup="true" data-title="{{ ('Add Rent Package') }}"> {{ ('Rent Package') }}
                                            </button>
                                            {{--predefined_package--}}
                                            <button type="button" class="btn btn-primary btn-md" data-url="{{ route('useradmin.predefined') }}" data-size="md" id="predefinedPackageBtn" style="width: 200px; padding: 10px; font-size: 14px;"
                                                data-ajax-popup="true" data-title="{{ ('Create Predefined Package') }}"> {{ ('Predefined Package') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="descriptionModal" tabindex="1"
                                aria-labelledby="descriptionModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="descriptionModalLabel">Description</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="item_id_des" id="item_id_des">
                                            <textarea name="description_modal" id="description_modal" class="form-control" rows="3"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="savedescription()">Save changes</button>
                                        </div>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateSendTable();
            initializeDataTable();
            // Get the selected event's ID from the event name dropdown
            var eventId = $('#event_name').val();

            // Check if an event ID is selected
            if (eventId) {
                // Fetch event details using the selected event ID
                getEventDetails(eventId);
            }
        })
        // Get Selected Event Details
        function getEventDetails(eventId) {
              // Perform an AJAX request to fetch event details based on the selected event
              $.ajax({
                url: '/useradmin/fetch-event-details',
                method: 'POST',
                data: {
                    event_id: eventId
                },
                success: function(response) {
                    //  Assuming response is a JSON object with phone_number and location fields
                    $('#start_time').val(response.start_datetime);
                    $('#end_time').val(response.end_datetime);
                    $('#booking_date').val(response.event_date);
                    $('#customer_phone').val(response.customer_phone);
                    $('#location').val(response.location);
                    $('#customer_name').val(response.customer_name);
                    $("#customer_id").val(response.customer_id);

                },
                error: function(xhr, status, error) {
                    showCustomAlert(error);

                }
            });

        }

        // Function to enable or disable an Add button for a specific item
        function toggleAddButton(itemId, disable = true) {
            var addButton = $('button[data-itemId="' + itemId + '"]');
            addButton.prop('disabled', disable);
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

        // Initialize Select2 for multiple employee names
        $('#name').select2({
            // placeholder: "Select an Option",
        });
        $('.termsSelect').select2({
            placeholder: "Select a title",
            allowClear: true
        });
        // Initialize Select2 for event name
        $('#event_name').select2({
            placeholder: "Select an event",
            allowClear: true
        });

        // Event listener for Select2 selection
        $('#event_name').on('select2:select', function(e) {
            // Get the selected event's ID
            var eventId = $('#event_name').val();
            if (!eventId) {
                showCustomAlert('Please select a valid event.');
                return;
            }

            // Perform an AJAX request to fetch event details based on the selected event
            $.ajax({
                url: '/useradmin/fetch-event-details',
                method: 'POST',
                data: {
                    event_id: eventId
                },
                success: function(response) {
                    //  Assuming response is a JSON object with phone_number and location fields
                    $('#start_time').val(response.start_datetime);
                    $('#end_time').val(response.end_datetime);
                    $('#booking_date').val(response.event_date);
                    $('#customer_phone').val(response.customer_phone);
                    $('#location').val(response.location);
                    $('#customer_name').val(response.customer_name);
                    $("#customer_id").val(response.customer_id);

                },
                error: function(xhr, status, error) {
                    showCustomAlert(error);

                }
            });
        });

        // location keyup event
        $(document).on('keyup', '#location', function() {
            var location = $(this).val();
            // check characters
            if (location.length > 255) {
                // Display error message in locationError
                $('#locationError').text('Location cannot exceed 255 characters');

            } else {
                $('#locationError').text(''); // clear error message

            }
            enableSubmitButton();
        });
        // Event Name keyup event
        $(document).on('keyup', '#event_name', function() {
            var eventName = $(this).val();
            // check characters
            if (eventName.length > 255) {
                // Display error message in locationError
                $('#event_nameError').text('Event Name cannot exceed 255 characters');

            } else {
                $('#event_nameError').text(''); // clear error message

            }
            enableSubmitButton();
        })

        $(document).ready(function() {
            document.getElementById('payment_fields').style.display = 'none';

            $('#order_status').change(function() {
                var selectedOrderStatus = $(this).val();

                if (selectedOrderStatus === 'booking' || selectedOrderStatus === 'pending payment') {
                    document.getElementById('payment_fields').style.display = 'block';
                } else {
                    document.getElementById('payment_fields').style.display = 'none';
                }
            });
        });
        // Selected event id set to rent package create url
        $('#event_name').on('change', function() {
            var eventId = $(this).val();
            $('#rentPackageBtn').attr('data-url', '{{ route('useradmin.event_rent_packages.eventCreate', '') }}/' + eventId);
        });


        $(document).ready(function() {
            function toggleOrderStatusField() {
                var selectedOrderType = $('#order_type').val();
                if (selectedOrderType === 'quotation') {
                    $('#name').prop('disabled', true);
                    $('#display-none').hide();
                    document.getElementById('orderStatusField').style.display = 'none';
                    document.getElementById('payment_fields').style.display = 'none';
                    // pay amount value and displayPayAmount value 0
                    document.getElementById('pay_amount').value = '0.00';
                    document.getElementById('displayPayAmount').textContent = '0.00';
                    // If Is Pay is checked, uncheck it
                    var isPayChecked = $('#is_pay').prop('checked');
                    if (isPayChecked) {
                        $('#is_pay').prop('checked', false);
                    }
                    // Assign order status to pending
                    $('#order_status').val('pending').trigger('change');
                    updateOrderBill();

                } else {
                    $('#orderStatusField').show();
                    $('#name').prop('disabled', false);
                    $('#display-none').show();
                }

            }

            $('#order_type').change(function() {
                toggleOrderStatusField();
            });

        });

        $(document).ready(function() {
            $('#order_status').change(function() {
                var selectedOrderStatus = $(this).val();
                togglePaymentFields(selectedOrderStatus);
            });

            $('#is_pay').change(function() {
                var selectedOrderStatus = $('#order_status').val();
                var isPayChecked = $('#is_pay').prop('checked');


                if (selectedOrderStatus === 'booking' || selectedOrderStatus === 'pending payment' || isPayChecked) {
                    $('#payment_fields').show();

                    // If both Order Book and Is Pay are checked, enable Pay Amount
                    if (isPayChecked) {
                        // pay amount value 0
                        $('#pay_amount').value = 0;
                        $('#pay_amount').prop('disabled', false);

                    } else {
                        $('#pay_amount').prop('disabled', true);
                    }
                } else {
                    $('#payment_fields').hide();
                    $('#pay_amount').prop('disabled', true);
                }
            });

            togglePaymentFields($('#order_status').val());

        });

        function togglePaymentFields(orderStatus) {
            var isPayChecked = $('#is_pay').prop('checked');

            if (orderStatus === 'booking' || orderStatus === 'pending payment') {
                $('#payment_fields').show();

                // If  Is Pay are checked, enable Pay Amount
                if (isPayChecked) {
                    $('#pay_amount').prop('disabled', false);
                } else {
                    $('#pay_amount').prop('disabled', true);
                }
            } else {
                $('#payment_fields').hide();
                $('#pay_amount').prop('disabled', true);
            }
        }

        flatpickr("#start_time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            //defaultDate: "today",
            minuteIncrement: 15,
            onClose: function(selectedDates, dateStr, instance) {
                updateEndTimePicker(dateStr);
                updateBookingDate(selectedDates[0]);

            }

        });

        flatpickr("#end_time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            //defaultDate: "today",
            minuteIncrement: 15

        });

        flatpickr("#inv_date", {
            enableTime: false,
            dateFormat: "Y-m-d",
            defaultDate: "today",
        });

        flatpickr("#booking_date", {
            enableTime: false,
            dateFormat: "Y-m-d"
        });

        function updateEndTimePicker(minTime) {
            flatpickr("#end_time", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                defaultDate: minTime,
                minuteIncrement: 15
            });

        }

        //update booking date
        function updateBookingDate(startTime) {
            // Extract the date part from the start time
            var bookingDate = startTime.toISOString().split('T')[0];
            // Set the booking date input value
            document.getElementById('booking_date').value = bookingDate;
        }

        //extract date part from the today
        var today = new Date().toISOString().split('T')[0];

        // Set the value of the "Invoice Date" input field to today's date
        document.getElementById('inv_date').value = today;

        function setEmployeeIds() {
            var selectedEmployees = $('#employee_ids').val();

        }

        $(document).ready(function() {

            $('#order_book').change(function() {
                if ($(this).prop('checked')) {

                    $('#payment_fields').show();
                } else {

                    $('#payment_fields').show();
                }
                enableSubmitButton();
            });


            $('input[type="text"], input[type="checkbox"]').on('input change', function() {
                enableSubmitButton();
            });

        });

        function validateQuantity(input, validationMessageId) {
            var quantity = input.value;
            var validationMessage = document.getElementById(validationMessageId);
            // var itemTotal=$item->

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

        function validateInputLength(input, maxLength) {
            var inputValue = input.value.toString();
            if (inputValue.length > maxLength) {
                input.value = inputValue.slice(0, maxLength);
            }
        }

        var selectedItems = []; // Define selectedItems array in the global scope
        var disabledButtons = {}; // Object to keep track of disabled buttons

        // Select predefined package
        $('#predefined_package_id').change(function() {
            var predefinedPackageId = $('#predefined_package_id').val();

            // Clear the selectedItems array before pushing new items
            selectedItems = [];
            // Clear the selectedItems array in the localStorage before pushing new items
            localStorage.removeItem('selectedItems');


            // Enable all buttons previously disabled and clear the disabledButtons object
            Object.keys(disabledButtons).forEach(function(itemId) {
                toggleAddButton(itemId, false); // Enable button and remove from disabledButtons
            });

            $.ajax({
                url: "{{ route('useradmin.getpredefinedpackageitems.order') }}",
                type: 'GET',
                data: {
                    predefinedPackageId: predefinedPackageId
                },
                success: function(response) {
                    var packageItems = response.predefinedItems; // Renamed to avoid conflict
                    if (packageItems && Array.isArray(packageItems)) {
                        packageItems.forEach(function(item) {
                            // Check if item already exists in selectedItems by itemId before adding
                            var exists = selectedItems.some(function(si) { return si.itemId === item.item_id; });
                            if (!exists) {
                                selectedItems.push({
                                    itemId: item.item_id,
                                    itemName: item.item_name,
                                    category: item.category || 'Uncategorized',
                                    rent_price: item.item_price,
                                    quantity: item.quantity,
                                    discount: item.discount !== undefined ? item.discount : 0,
                                    description: item.description || ''
                                });
                            }
                            // Ensure add buttons for these items in the top table are disabled
                            toggleAddButton(item.item_id, true);
                        });
                    }
                    localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
                    enableSubmitButton();
                    updateSendTable();
                }

            });

        });

        function setItemId(button, itemName, category, rent_price, itemId) {
            var quantityInput = $(button).closest('tr').find('.quantity-input');
            var rentInput = $(button).closest('tr').find('.rent-input');
            var discountInput = $(button).closest('tr').find('.discount-input');

            var quantity = quantityInput.val();
            var rent_price = rentInput.val();
            var discount = discountInput.val();

            // Get selected items from localstorage
            selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];

            var isAlreadySelected = selectedItems.some(function(item) {
                return item.itemId === itemId;
            });

            // Convert quantity to an integer to avoid concatenation
            var quantityToAdd = parseInt(quantity, 10);

            if (quantityToAdd > 0) {
                if (!isAlreadySelected) {

                    toggleAddButton(itemId, true); // Disable the button for this item

                    // Get before add new item currently selected items
                    selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];

                    // Add the item to the selectedItems array
                    selectedItems.push({
                        itemId: itemId,
                        itemName: itemName,
                        rent_price: rent_price,
                        category: category,
                        quantity: quantity,
                        discount: discount,
                        description: ''
                    });

                    // Store  the selected items in localstorage
                    localStorage.setItem('selectedItems', JSON.stringify(selectedItems));

                } else {
                    // If the item is already selected, increase its quantity
                    selectedItems.forEach(function(item) {
                        if (item.itemId === itemId) {
                            item.quantity += quantityToAdd;
                        }
                    });
                    // Update  the selected items in localstorage
                    localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
                }

                var totalPrice = 0;
                //selected item price calculation
                for (var i = 0; i < selectedItems.length; i++) {
                    var item = selectedItems[i];
                    totalPrice += item.quantity * (item.rent_price - item.discount);
                }

                $('#totalPrice').text(totalPrice.toFixed(2));

                enableSubmitButton();

                updateSendTable();
            } else {
                $('#quantityValidationMessage').text('Please enter a valid quantity.');
            }

        }
        var payAmountInput = document.getElementById('pay_amount');
        payAmountInput.addEventListener('input', function() {
            updateOrderBill();
        });

        function updateOrderBill() {
            var originalTotalPrice = parseFloat($('#totalPrice').text().replace('Total Price: ', '')) || 0;
            var transport = parseFloat($('#transport').val()) || 0;
            var tax = parseFloat($('#tax').val()) || 0;
            // var totalDiscount = calculateTotalDiscount();
            var totalDiscount = parseFloat($('#displayTotalDiscount').val()) || 0;
            var additionalPrice = parseFloat($('#additional_price').val()) || 0;
            var totalPrice = originalTotalPrice;
            var payAmount = parseFloat(payAmountInput.value);

            var advanceAmount = document.getElementById('displayPayAmount').textContent = payAmount.toFixed(2);
            if (advanceAmount == 'NaN') {
                // displayPayAmount assign 0
                document.getElementById('displayPayAmount').textContent = '0.00';

            }
            $('#totalPrice').text(totalPrice.toFixed(2));
            $('#displayTotalDiscount').text(totalDiscount.toFixed(2));

            var payAmount = parseFloat($('#pay_amount').val()) || 0;
            var grandTotal = originalTotalPrice + transport + tax - totalDiscount;
            var finalAmount;

            if (additionalPrice === 0) {
                finalAmount = grandTotal - payAmount;
            } else {
                finalAmount = additionalPrice - payAmount;
            }

            // var finalAmount = additionalPrice - payAmount;
            $('#netAmount').text(grandTotal.toFixed(2));
            $('#displayFinalAmount').text(finalAmount.toFixed(2));

            enableSubmitButton();
        }

        function removeItem(button, itemId) {
            var currentSelectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];

            var indexToRemove = -1;
            for (var i = 0; i < currentSelectedItems.length; i++) {
                if (currentSelectedItems[i].itemId === itemId) {
                    indexToRemove = i;
                    break;
                }
            }

            if (indexToRemove > -1) {
                currentSelectedItems.splice(indexToRemove, 1);
                localStorage.setItem('selectedItems', JSON.stringify(currentSelectedItems));
                toggleAddButton(itemId, false); // Enable the "Add" button for this item in the top table
            } else {
                console.warn("Item with ID " + itemId + " not found in selectedItems for removal.");
            }

            updateSendTable();
        }

        function addDescription(button) {
            var row = $(button).closest('tr');
            // Attempt to get itemId from a data attribute on an input in the row
            var itemId = row.find('.rent-price').data('itemid') || row.find('input[type="hidden"][name^="item_id"]').val();

            if (!itemId) {
                console.error('Could not determine itemId for description.');
                return;
            }

            $('#descriptionModal').modal('show');
            $('#item_id_des').val(itemId);
            // Find the correct description div using the unique ID
            $('#description_modal').val($('#description-' + itemId).text());
        }

        function savedescription() {
            var descriptionText = $('#description_modal').val();
            var itemIdDes = $('#item_id_des').val();
            $('#descriptionModal').modal('hide');

            var currentSelectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
            var itemFound = false;
            currentSelectedItems.forEach(function(item) {
                // Ensure itemIdDes (from input) is compared correctly (e.g. string vs number)
                if (String(item.itemId) === String(itemIdDes)) {
                    item.description = descriptionText;
                    itemFound = true;
                }
            });

            if (itemFound) {
                localStorage.setItem('selectedItems', JSON.stringify(currentSelectedItems));
                // Update the displayed description in the table directly
                $('#description-' + itemIdDes).text(descriptionText);
            } else {
                console.warn("Item not found for saving description: " + itemIdDes);
            }
            // updateSendTable(); // Optional: re-render if other parts of the row might change or for simplicity
        }


        function validateDiscount(input, validationMessageId) {
            var discount = input.value;
            var validationMessage = document.getElementById(validationMessageId);
            if (discount < 0) {
                validationMessage.textContent = "Minimum value should be 0.";
                input.setCustomValidity("Minimum value should be 0.");
                input.value = '';
                // Discount less than rent_price*quantity
            } else {
                validationMessage.textContent = "";
                input.setCustomValidity("");
                var quantityInput = $(input).closest('tr').find('.quantity-input');
                var rentInput = $(input).closest('tr').find('.rent-input');
                var quantity = quantityInput.val();
                var rent_price = rentInput.val();
                if (discount > quantity * rent_price) {
                    input.value = 0;
                }
            }
            updateSendTable();
        }

        function validateRent(input, validationMessageId) {
            var rent = input.value;
            var validationMessage = document.getElementById(validationMessageId);
            if (rent < 1) {
                validationMessage.textContent = "Minimum value should be 1.";
                input.setCustomValidity("Minimum value should be 1.");
                input.value = '';
            } else {
                validationMessage.textContent = "";
                input.setCustomValidity("");
            }
            updateSendTable();


        }

        function updateSendTable() {

            var sendTableBody = $('#sendTable tbody');
            sendTableBody.empty();
            var overallTotalPrice = 0;
            var overallTotalDiscount = 0;

            var currentSelectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];

            var itemsByCategory = currentSelectedItems.reduce(function(acc, item) {
                var category = item.category || 'Uncategorized';
                if (!acc[category]) {
                    acc[category] = [];
                }
                acc[category].push(item);
                return acc;
            }, {});

            var sortedCategoryNames = Object.keys(itemsByCategory).sort();

            for (var i = 0; i < sortedCategoryNames.length; i++) {
                    var categoryName = sortedCategoryNames[i];
                    var itemsInCategory = itemsByCategory[categoryName];
                    var categorySubTotalPrice = 0;
                    var categorySubTotalDiscount = 0;

                    sendTableBody.append(
                        '<tr class="category-header-row bg-light">' +
                        '<td colspan="6" style="font-weight: bold; padding-top: 10px; padding-bottom: 10px;">Category: ' + categoryName + '</td>' +
                        '</tr>'
                    );

                    itemsInCategory.forEach(function(item) {

                        const actualItemIndex = currentSelectedItems.findIndex(selectedItem => selectedItem.itemId === item.itemId);

                        var rentPrice = parseFloat(item.rent_price) || 0;
                        var discount = parseFloat(item.discount) || 0;
                        var quantity = parseInt(item.quantity, 10) || 0;

                        var itemSubTotal = (rentPrice * quantity) - discount;
                        categorySubTotalPrice += itemSubTotal;
                        categorySubTotalDiscount += discount;
                        overallTotalPrice += itemSubTotal;
                        overallTotalDiscount += discount;

                        toggleAddButton(item.itemId, true);

                        sendTableBody.append('<tr>' +
                            '<td>' + item.itemName + '&nbsp;&nbsp;' +
                            '<button type="button"class="btn btn-sm btn-info" onclick="addDescription(this)">Add Description +</button>' +
                            '<br><div id="description-' + item.itemId + '" class="item-description">' + (item.description || '') + '</div>' +
                            '</td>' +
                            '<td><input type="number" min="0" step="0.01" class="form-control rent-price" value="' + rentPrice.toFixed(2) + '" data-itemid="' + item.itemId + '" data-index="' + actualItemIndex + '" /></td>' +
                            '<td><input type="number" min="1" class="form-control quantity" value="' + quantity + '" data-itemid="' + item.itemId + '" data-index="' + actualItemIndex + '" /></td>' +
                            '<td><input type="number" min="0" step="0.01" class="form-control discount" value="' + discount.toFixed(2) + '" data-itemid="' + item.itemId + '" data-index="' + actualItemIndex + '" /></td>' +
                            '<td><input type="text" class="form-control total-item-price" value="' + itemSubTotal.toFixed(2) + '" readonly /></td>' +
                            '<td><button type="button" class="btn btn-xs btn-danger" onclick="removeItem(this, ' + item.itemId + ')">Remove</button></td>' +
                            // Hidden inputs for form submission
                            '<input type="hidden" name="items[' + actualItemIndex + '][id]" value="' + item.itemId + '">' +
                            '<input type="hidden" name="items[' + actualItemIndex + '][category]" value="' + categoryName + '">' +
                            '<input type="hidden" name="items[' + actualItemIndex + '][name]" value="' + item.itemName + '">' +
                            '<input type="hidden" name="items[' + actualItemIndex + '][rent_price]" value="' + rentPrice.toFixed(2) + '">' +
                            '<input type="hidden" name="items[' + actualItemIndex + '][quantity]" value="' + quantity + '">' +
                            '<input type="hidden" name="items[' + actualItemIndex + '][discount]" value="' + discount.toFixed(2) + '">' +
                            '<input type="hidden" name="items[' + actualItemIndex + '][description]" value="' + (item.description || '') + '">' +
                            '</tr>');
                    });

                    sendTableBody.append(
                        '<tr class="category-subtotal-row">' +
                        '<td colspan="4" style="text-align:right; font-weight: bold;">' + categoryName + ' Subtotal:</td>' +
                        '<td style="font-weight: bold;" class="category-subtotal-amount">' + categorySubTotalPrice.toFixed(2) + '</td>' +
                        '<td></td>' +
                        '</tr>'
                    );
                }

            if (currentSelectedItems.length > 0) {
                $('#sendTable').show();
                //call check field fill or not
                enableSubmitButton();
            } else {
                $('#sendTable').hide();
            }

            $('#totalPrice').text(overallTotalPrice.toFixed(2));
            $('#displayTotalDiscount').val(overallTotalDiscount.toFixed(2));

            updateOrderBill();
            enableSubmitButton();
        }

        // Rent price keyup event
        $(document).on('keyup', '.rent-price', function() {
            var index = $(this).data('index');
            var rentPrice = parseFloat($(this).val());
            if (isNaN(rentPrice) || rentPrice < 1) rentPrice = 0;
            // Get the selectedItems array from localStorage
            var selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
            // Update the rent price in selectedItems array
            if (selectedItems[index]) {
                selectedItems[index].rent_price = rentPrice;
            }
            // Save the updated selectedItems array back to localStorage
            localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
            // Recalculate and update the table
            setTimeout(() => {
                updateSendTable();
            }, 2000);
        });
        $(document).on('change', '.rent-price', function() {
            var index = $(this).data('index');
            var rentPrice = parseFloat($(this).val());
            if (isNaN(rentPrice) || rentPrice < 1) rentPrice = 0;
            // Get the selectedItems array from localStorage
            var selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
            // Update the rent price in selectedItems array
            if (selectedItems[index]) {
                selectedItems[index].rent_price = rentPrice;
            }
            // Save the updated selectedItems array back to localStorage
            localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
            // Recalculate and update the table
            updateSendTable();
        })

        // Quantity keyup event
        $(document).on('keyup', '.quantity', function() {
            var index = $(this).data('index');
            var quantity = parseFloat($(this).val());
            if (isNaN(quantity) || quantity < 1) quantity = 1;
            // Get the selectedItems array from localStorage
            var selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
            // Update the quantity in selectedItems array
            if (selectedItems[index]) {
                selectedItems[index].quantity = quantity;
            }
            // Save the updated selectedItems array back to localStorage
            localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
            // Recalculate and update the table
            setTimeout(() => {
                updateSendTable();
            }, 1500);
        });
        $(document).on('change', '.quantity', function() {
            var index = $(this).data('index');
            var quantity = parseFloat($(this).val());
            if (isNaN(quantity) || quantity < 1) quantity = 1;
            // Get the selectedItems array from localStorage
            var selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
            // Update the quantity in selectedItems array
            if (selectedItems[index]) {
                selectedItems[index].quantity = quantity;
            }
            // Save the updated selectedItems array back to localStorage
            localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
            // Recalculate and update the table
            updateSendTable();
        })

        // Discount keyup event
        $(document).on('keyup', '.discount', function() {
            var index = $(this).data('index');
            var discount = parseFloat($(this).val());
            if (isNaN(discount) || discount < 0) discount = 0;
            // Get the selectedItems array from localStorage
            var selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
            // Before update check discount is less than rent_price*quantity
            if (discount > selectedItems[index].rent_price * selectedItems[index].quantity) {
                discount = 0;
            }
            // Update the discount in selectedItems array
            if (selectedItems[index]) {
                selectedItems[index].discount = discount;
            }
            // Save the updated selectedItems array back to localStorage
            localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
            // Recalculate and update the table
            setTimeout(() => {
                updateSendTable();
            }, 2000);
        });
        $(document).on('change', '.discount', function() {
            var index = $(this).data('index');
            var discount = parseFloat($(this).val());
            if (isNaN(discount) || discount < 0) discount = 0;
            // Get the selectedItems array from localStorage
            var selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
            // Before update check discount is less than rent_price*quantity
            if (discount > selectedItems[index].rent_price * selectedItems[index].quantity) {
                discount = 0;
            }
            // Update the discount in selectedItems array
            if (selectedItems[index]) {
                selectedItems[index].discount = discount;
            }
            // Save the updated selectedItems array back to localStorage
            localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
            // Recalculate and update the table
            updateSendTable();
        })


        // Function to enable/disable the confirm button
        function enableSubmitButton() {
            var customerName = $('#customer_name').val();
            var orderType = $('#order_type').val();
            var bookingDate = $('#booking_date').val();
            var invDate = $('#inv_date').val();
            var eventName = $('#event_name').val();
            var startTime = $('#start_time').val();
            var location = $('#location').val();
            var endTime = $('#end_time').val();
            var customerPhone = $('#customer_phone').val();
            var itemSelected = selectedItems.length;
            // Get the selectedItems array from localStorage
            var selectedItemsArray = JSON.parse(localStorage.getItem('selectedItems')) || [];

            if (customerName !== "" && location !== "" && eventName !== "" && startTime !== "" && endTime !== "" &&
                customerPhone !== "" && orderType !== "" && bookingDate !== "" && invDate !== "" && (itemSelected > 0 ||
                    selectedItemsArray.length > 0) && (!($('#is_pay').prop('checked')) || $('#pay_amount').val() !== "")) {
                $('#confirmOrderBtn').prop('disabled', false);
                $('#rentPackageBtn').prop('disabled', false);
                $('#predefinedPackageBtn').prop('disabled', false);
            } else {
                $('#confirmOrderBtn').prop('disabled', true);
                $('#rentPackageBtn').prop('disabled', true);
                $('#predefinedPackageBtn').prop('disabled', true);
            }

        }

        // Function to update the description
        function updateDescription() {

            var selectElement = document.getElementById("title");
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var description = selectedOption.getAttribute("data-description");

            document.getElementById("terms_conditions").value = description ? description : '';
        }

        $(document).ready(function() {

            function validateForm() {

                // Reset validation messages
                document.getElementById("quantityValidationMessage").innerText = "";

                // Validate required fields
                var requiredFields = ['order_type', 'customer_name', 'customer_phone', 'location', 'event_name',
                    'booking_date', 'start_time ', 'inv_date', 'order_status'
                ];
                for (var i = 0; i < requiredFields.length; i++) {
                    var fieldName = requiredFields[i];
                    var fieldValue = $('#' + fieldName).val();
                    if (!fieldValue) {
                        showCustomAlert("Please fill in all required fields.");
                        return false;
                    }
                }

                // Validate date fields
                var startTime = $('#start_time').val();
                var endTime = $('#end_time').val();
                var bookingDate = $('#booking_date').val();
                //get today date
                var today = new Date().toISOString().split('T')[0];

                if (startTime && !bookingDate) {
                    showCustomAlert("Please select a booking date.");
                    return false;
                }
                if (endTime && !startTime) {
                    showCustomAlert("Please select a start time.");
                    return false;
                }
                if (endTime <= startTime) {
                    showCustomAlert("End time should be after start time.");
                    return false;
                }

                // Location validation
                var location = $('#location').val();
                var EventName = $('#event_name').val();
                if (location.length > 255) {
                    showCustomAlert("Location cannot exceed 255 characters.");
                    return false;
                }
                if (EventName.length > 255) {
                    showCustomAlert("Event Name cannot exceed 255 characters.");
                    return false;
                }
                // Get pay amount/grand total/total discount
                var displayPayAmount = parseFloat(document.getElementById('displayPayAmount').textContent);
                var netAmount = parseFloat(document.getElementById('netAmount').textContent);
                var tax = parseFloat(document.getElementById('tax').value);
                var transport = parseFloat(document.getElementById('transport').value);
                var totalDiscount = parseFloat(document.getElementById('displayTotalDiscount').value);
                var totalPrice = parseFloat(document.getElementById('totalPrice').textContent);
                var grand_Total = parseFloat(document.getElementById('displayFinalAmount').textContent);


                // Check total discount validation
                if (totalDiscount < 0) {
                    showCustomAlert("Total Discount cannot be negative.");
                    return false;
                }
                // Check total discount less than grand total
                if (totalDiscount > (totalPrice + tax + transport)) {
                    showCustomAlert("Total Discount Maximum is " + (totalPrice + tax + transport) + ".");
                    return false;
                }

                // Additional price validation
                var transport = parseFloat($('#transport').val()) || 0;
                var tax = parseFloat($('#tax').val()) || 0;
                var additionalPrice = parseFloat($('#additional_price').val()) || 0;
                if (additionalPrice > 0) {
                    if (additionalPrice < transport + tax) {
                        showCustomAlert("Price cannot be less than Transport and Service Charges.");
                        return false;
                    }
                    // Advance amount validation
                    if (additionalPrice < displayPayAmount) {
                        showCustomAlert("Advance Amount cannot be greater than  Price.");
                        return false;
                    }
                }
                else if( additionalPrice < 0) {
                    // Additional price can't less than 0
                    showCustomAlert("Price cannot be less than 0.");
                    return false;
                }
                else {
                    // Advance amount validation can't greater than net amount
                    if (displayPayAmount > netAmount) {
                        showCustomAlert("Advance Amount cannot be greater than Net Amount.");
                        return false;
                    }
                }

                return true;
            }

            // Enable/disable "Confirm Order" button on page load
            enableSubmitButton();

            //Event listener for change/input events on relevant form elements
            $('#customer_name, #order_type, #booking_date, #inv_date, #event_name, #start_time, #location, #end_time, #customer_phone')
                .on('change input', function() {
                    enableSubmitButton();
                });

            // Submit button click event
            $('#confirmOrderBtn').click(function() {
                if (validateForm()) {
                    // Retrieve selectedItems from localStorage
                    var storedItems1 = JSON.parse(localStorage.getItem('selectedItems'));
                    // Retrieve rentPackage from localStorage
                    var storedItems2 = JSON.parse(localStorage.getItem('rentPackage'));
                    // Retrieve predefinedPacakage from localStorage
                    var storedItems3 = JSON.parse(localStorage.getItem('predefinedPackage'));

                    $('#selected_items').val(JSON.stringify(storedItems1));
                    $('#rent_package').val(JSON.stringify(storedItems2));
                    $('#predefinedPackage').val(JSON.stringify(storedItems3));

                    $('#FinalAmount').val($('#displayFinalAmount').text());
                } else {
                    return false;
                }
            });

    });
    </script>
@endsection
