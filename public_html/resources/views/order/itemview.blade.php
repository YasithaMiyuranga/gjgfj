@extends('layouts.app')
@section('page-title', __('Orders'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        @if (Str::endsWith(URL::previous(), '/viewinvoice'))
             <a href="{{ route('useradmin.order.view') }}">{{ __('Order Invoice') }}</a>
        @elseif (Str::endsWith(URL::previous(), '/viewQuotation'))
            <a href="{{ route('useradmin.order.quotationorder') }}">{{ __('Order Quotationry') }}</a>
        @elseif( Str::endsWith(URL::previous(), '/view'))
            <a href="{{ route('useradmin.order.view') }}">{{ __('Order History') }}</a>
        @elseif(Str::endsWith(URL::previous(), '/book'))
            <a href="{{ route('useradmin.order.bookorder') }}">{{ __('Order Booking') }}</a>
            @elseif(Str::endsWith(URL::previous(), '/dashboard'))
            <a href="{{ route('useradmin.dashboard') }}">{{ __('Overview') }}</a>
        @endif
        <li class="breadcrumb-item active">{{ __('Edit Order') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                        <h5></h5>
                    <h3>Edit Order</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                {{-- @if (session('message'))
                    <div class="alert alert-success" id="success-alert">
                        {{ session('message') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" id="error-alert">
                        {{ session('error') }}
                    </div>
                @endif --}}
                {{-- <button class="btn btn-sm btn-primary me-2 mb-2"
                        data-url="{{ route('useradmin.order.event.create') }}"
                        data-size="md" data-ajax-popup="true" data-title="{{ __('Create Event') }}">
                        Create Event
                </button> --}}
                    <form method="post" action="{{ route('useradmin.orders.update', $order->order_id) }}" id="orderForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="rent_id" id="rent_id" value=0>
                        <input type="hidden" name="event_id" value="{{ $order->event_id }}">
                        <input type="hidden" name="orderAmount" id="orderAmount">
                        <input type="hidden" id="rentPackageList" name="rentPackageList" value="">
                        <input type="hidden" name="predefinedPackageList" id="predefinedPackageList" value="">
                        @if($order->order_type == 'invoice')
                            <input type="hidden" name="order_type" value="{{ $order->order_type }}">
                        @endif
                        <div class="row">
                            <div class="col-md-6"><b>Date: {{ date('Y F d') }}</b></div>
                            <div class="col-md-6"><b>Time: {{ date('h:i A') }}</b></div>
                        </div>
                        <br>
                        <div id="dineInSection1" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_name" class="form-label">Event:   *</label>
                                    <select class="form-select bg-dark" name="event_id" id="event_name" required disabled>
                                        <option value="">Select Event</option>
                                        @foreach ($events as $event)
                                            <option value='{{ $event->eid }}'
                                                {{ $order->event_id == $event->eid ? 'selected' : '' }}>
                                                {{ $event->event_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             @if($order->event?->customer)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_name" class="form-label">Customer Name:    *</label>
                                        <input type="text" class="form-control" name="customer_name" id="customer_name"
                                            value="{{ old('customer_name', $order->event->customer->customer_name) }}"  required readonly>
                                            @if( $errors->has('customer_name'))
                                                <span class="text-danger" id="nameError">{{ $errors->first('customer_name') }}</span>
                                            @endif
                                    </div>
                                    <input type="hidden" name="customer_id" id="customer_id" value="{{ $order->event->customer_id }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_phone" class="form-label">Phone Number:    *</label>
                                        <input type="text" class="form-control" name="customer_phone" id="customer_phone" readonly
                                            value="{{ old('customer_phone', $order->event->customer->customer_phone) }}" required>
                                            @if( $errors->has('customer_phone'))
                                                <span class="text-danger" id="phoneError">{{ $errors->first('customer_phone') }}</span>
                                            @endif
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location" class="form-label">Location:  *</label>
                                    <input type="text" class="form-control" name="location" id="location"
value="{{ isset($order->event) ? $order->event->location : $order->location }}" readonly required>
                                        <span class="text-danger" id="locationError"></span>
                                        @if( $errors->has('location'))
                                            <span class="text-danger" id="locationError">{{ $errors->first('location') }}</span>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div id="dineInSection" class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_time" class="form-label">Start Time:  *</label>
                                    <input type="text" class="form-control" name="start_time" id="start_time"
                                        value="{{ old('start_time', $order->start_time) }}" required>
                                        @if( $errors->has('start_time'))
                                            <span class="text-danger" id="start_timeError">{{ $errors->first('start_time') }}</span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_time" class="form-label">End Time:  *</label>
                                    <input type="text" class="form-control" name="end_time" id="end_time"
                                        value="{{ old('end_time', $order->end_time) }}" required>
                                        @if( $errors->has('end_time'))
                                            <span class="text-danger" id="end_timeError">{{ $errors->first('end_time') }}</span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_date" class="form-label">Booking Date:  *</label>
                                    <?php
                                    // Convert the date to the desired format
                                    $formattedDate = date('Y-m-d', strtotime($order->booking_date));
                                    ?>
                                    <input type="date" class="form-control" name="booking_date" id="booking_date"
                                        value="<?php echo $formattedDate; ?>">
                                </div>
                            </div>
                        </div>
                        <div id="dineInSection3" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inv_date" class="form-label">Past Invoice/Quoatation Date:  *</label>
                                    @php
                                        // Convert the date to the desired format
                                        $formattedDate = date('Y-m-d', strtotime($order->inv_date));
                                        echo $formattedDate;
                                    @endphp
                                    <input type="date" class="form-control" name="inv_date" id="inv_date"
                                        value="{{ $formattedDate }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_type" class="form-label">Order Type:  *</label>
                                    <select class="form-select {{ $order->order_type == 'invoice' ? 'bg-dark' : '' }}" name="order_type" id="order_type" required {{ $order->order_type == 'invoice' ? 'disabled' : '' }}>
                                        <option value="">Select order type</option>
                                        <option value="quotation" {{ $order->order_type == 'quotation' ? 'selected' : '' }}>
                                            Quotation</option>
                                        <option value="invoice" {{ $order->order_type == 'invoice' ? 'selected' : '' }}>Invoice
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="orderStatusField" class="col-md-6">
                                <div class="form-group">
                                    <label for="order_status" class="form-label">Status:    *</label>
                                    <select class="form-control" name="order_status" id="order_status" required>
                                        <option value="pending" {{  old('order_status', $order->order_status) == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="credit order" {{ old('order_status', $order->order_status) == 'credit order' ? 'selected' : '' }}>Credit Order
                                        </option>
                                        <option value="completed" {{ old('order_status', $order->order_status) == 'completed' ? 'selected' : '' }}>Complete
                                        </option>
                                        <option value="booking" {{ old('order_status',$order->order_status) == 'booking' ? 'selected' : '' }}>Booking
                                        </option>
                                        <option value="canceled" {{ old('order_status',$order->order_status) == 'canceled' ? 'selected' : ''}}>Canceled
                                        </option>
                                        <option value="pending payment" {{ old('order_status',$order->order_status) == 'pending payment' ? 'selected' : ''}}>Pending Payment
                                        </option>
                                        <option value="completed payment" {{ old('order_status',$order->order_status) == 'completed payment' ? 'selected' : ''}}>Completed Payment
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div id="payment_fields" style="display: none;" class="col-md-6">
                                <div class="d-flex flex-column-reverse">
                                    <div class="form-group mb-2">
                                        <label for="is_pay" class="form-label">Is Pay:</label>

                                        <input type="checkbox" name="is_pay" id="is_pay" value="1" class="form-check-input"
                                            {{ old('is_pay', $order->is_pay) == 1 ? 'checked' : '' }}>
                                        <label for="is_pay">Tick this box if the order is paid.</label>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <label for="pay_amount" class="form-label">Advance Amount:</label>
                                            <input type="text" name="pay_amount" id="pay_amount" step="0.01" class="form-control"
                                                value="{{ old('pay_amount', $order->pay_amount) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" id="display-none-edit">
                                <div class="form-group">
                                    <label for="name" class="form-label">Employee Name:</label>
                                    <select class="form-control select-2 emp-name" name="name[]" id="name" multiple>
                                        @foreach ($employees as $employee)
                                            <?php $selected = in_array($employee->name, explode(',', $order->name ?? '')); ?>
                                            <option value="{{ $employee->name }}" {{ $selected ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Bank_account" class="form-label">Bank Account:</label>
                                    <select class="form-control" name="Bank_account" id="Bank_account">
                                        <option value="">Select a Bank Account</option>
                                        @foreach ($bankAccounts as $bankAccount)
                                            <option value="{{ $bankAccount->id }}" {{ old('Bank_account', $order->bank_id) == $bankAccount->id ? 'selected' : '' }}>
                                                {{ $bankAccount->bank_name }} - {{ $bankAccount->branch_name }} {{ $bankAccount->account_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="special_note" class="form-label">Special Note:</label>
                                    <textarea name="special_note" id="special_note" class="form-control" id="special_note" >{{ old('special_note', $order->special_note) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-2" id="itemTable">
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
                                    @foreach ($items as $item)
                                        <tr>
                                            @php
                                                $isItemInOrder = $orderitems->contains('item_id', $item->item_id);
                                            @endphp
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->category }}</td>
                                            <td>
                                                <input type="number" step="0.01" class="form-control rent-input" name="rent-input"
                                                    value="{{ $item->rent_price }}" data-item="" oninput="validateRent(this, 'rentValidationMessage-{{ $item->item_id }}')">
                                                    <span class="text-danger" id="rentValidationMessage-{{ $item->item_id }}"></span>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" class="form-control discount-input"
                                                    name="discount-input" value="0" oninput="validateDiscount(this, 'discountValidationMessage-{{ $item->item_id }}')">
                                                    <span class="text-danger" id="discountValidationMessage-{{ $item->item_id }}"></span>
                                            </td>
                                            <td class="col-md-2">
                                                <input type="number" max="10000" min="0" class="form-control quantity-input"
                                                    name="quantity-input" value="1" data-item=""
                                                    oninput="validateQuantity(this, 'quantityValidationMessage-{{ $item->item_id }}')"
                                                    onkeypress="validateInputLength(this, 4)">
                                                    <span class="text-danger" id="quantityValidationMessage-{{ $item->item_id }}"></span>
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-warning" data-itemId="{{ $item->item_id }}"
                                                    onclick="setItemId(this, '{{ $item->item_name }}', '{{ $item->category }}', '{{ $item->rent_price }}', {{ $item->item_id }})"
                                                    {{ $isItemInOrder ? 'disabled' : '' }}>
                                                    Add <i class="ti ti-plus py-1"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <input type="text" name="oldOrderedItems" id="oldOrderedItems" hidden>
                        <input type="text" name="newOrderedItems" id="newOrderedItems" hidden>
                        <div class="table-responsive mt-2 order-items-table">
                            <p id="quantityValidationMessage2" style="color: red;"></p>
                            <table class="table mt-4" id="orderedItemsTable">
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
                                <tbody id="itemTableBody">
                                    <!-- Rows for newly added items will go here -->
                                </tbody>
                                <!-- Existing ordered items -->
                                <tbody id="oldItemTableBody">
                                @php
                                    $categories = collect($orderitems)->pluck('category')->unique();

                                    foreach ($categories as $category) {
                                        $categoryItems = $orderitems->where('category', $category);
                                        $categorySubTotalPrice = 0;
                                        $categorySubTotalDiscount = 0;
                                        $uniqid=$category."_".date('Y-m-d H:i:s');
                                @endphp

                                        <tr class="category-header-row bg-light" id="{{$uniqid}}">
                                            <td colspan="6" style="font-weight: bold; padding-top: 10px; padding-bottom: 10px;">
                                                Category: {{ $category }}

                                            </td>
                                        </tr>

                                    @foreach ($categoryItems as $orderItem)
                                        @php
                                             $itemSubTotalPrice = $orderItem->rent_price * $orderItem->quantity;
                                             $itemSubTotalDiscount = $orderItem->discount * $orderItem->quantity;
                                             $categorySubTotalPrice += $itemSubTotalPrice - $itemSubTotalDiscount;
                                             $categorySubTotalDiscount += $itemSubTotalDiscount;
                                        @endphp

                                        <tr>
                                            <td>
                                                {{ $orderItem->item_name }} &nbsp;&nbsp;

                                            {{-- Hidden input to store the item_id for each row --}}
                                                <input type="hidden" name="item_id[]" value="{{ $orderItem->item_id }}">

                                                <button type="button" class="btn btn-sm btn-info" onclick="addDescription(this)">Add
                                                    Description</button>

                                                <br>
                                            {{-- Display description below the item name when it exists --}}
                                                <div id="description" class="description text-break" style="word-wrap: break-word; white-space: pre-wrap;">{{ $orderItem->description }}</div>
                                            </td>
                                            <td><input type="number"  min="0"
                                                class="form-control rent-input" name="predefined_rentprice[]"
                                                value="{{ intval( $orderItem->rent_price) }}"
                                                    oninput="validateRent(this, 'rentpriceValidationMessage{{ $orderItem->item_id }}'); updateOrderBillNew()">
                                                <span id="rentpriceValidationMessage{{ $orderItem->item_id }}" style="color: red;"></span>
                                            </td>
                                            <td><input type="number"  min="1"
                                                class="form-control quantity-input" name="predefined_quantity[]"
                                                value="{{ $orderItem->quantity }}"
                                                    oninput="validateQuantity(this, 'quantityValidationMessage{{ $orderItem->item_id }}'); updateOrderBillNew()">
                                                <span id="quantityValidationMessage{{ $orderItem->item_id }}" style="color: red;"></span>
                                            </td>
                                            <td><input type="number"  min="0"
                                                class="form-control discount-input" name="predefined_discount[]"
                                                value="{{ $orderItem->discount }}"
                                            oninput="validateDiscount(this, 'discountValidationMessage{{ $orderItem->item_id}}'); updateOrderBillNew()">
                                                <span id="discountValidationMessage{{ $orderItem->item_id }}" style="color: red;"></span>
                                            </td>
                                            <td> <input type="number" step="0.01" class="form-control amount-input" name="predefined_amount[]"
                                                value="{{ $orderItem->rent_price * $orderItem->quantity-$orderItem->discount }}" readonly></td>
                                            <td>
                                                <button type="button" class="btn btn-md btn-danger" data-itemId="{{ $orderItem->item_id }}"
                                                    onclick="removeExistItem(this, {{ $orderItem->item_id }},{{ $orderItem->rent_price }},{{ $orderItem->discount }},{{ $orderItem->quantity }}, '{{ $orderItem->category }}', '{{ $uniqid }}')">
                                                        Delete
                                                </button>
                                            </td>
                                            <td style="display: none">
                                                <input type="hidden" name="order_item_id[]" value="{{ $orderItem->id }}">
                                            </td>
                                            <input type="hidden" name="predefined_item_id[]" value="{{ $orderItem->item_id }}">
                                        </tr>
                                    @endforeach
                                        <tr class="category-subtotal-row">
                                            <td colspan="4" style="text-align:right; font-weight: bold;">{{ $category }} Subtotal:</td>
                                            <td style="font-weight: bold;" class="category-subtotal-amount">{{ $categorySubTotalPrice }}</td>
                                            <td></td>
                                        </tr>
                                @php
                                    }
                                @endphp
                                </tbody>
                            </table>
                        </div>
                        <br><br>
                        <div class="px-4">
                            <div class="row justify-content-end">
                                <div class="col-md-12 mt-3 px-3 py-2">
                                    <h3>Order Bill</h3>

                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered" id="ordersTable">
                                            <tbody>

                                                <tr>
                                                    <td>Total Price:</td>
                                                    <td>
                                                        <input type="number" step="1" class="form-control" name="total_price"
                                                            id="orderTotalPrice"
                                                            value="{{ $order->net_amount }}" readonly>
                                                    </td>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Transport:</td>
                                                    <td>
                                                        <input type="number" min="0" step="0.01" class="form-control" name="transport"
                                                            id="transport" value="{{ $order->transport }}" oninput="updateOrderBillNew()">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Service Charge:</td>
                                                    <td>
                                                        <input type="number" min="0" step="0.01" class="form-control" name="tax"
                                                            id="tax" value="{{ $order->tax }}" oninput="updateOrderBillNew()">
                                                    </td>
                                                </tr>
                                                <tr>

                                                <tr>
                                                    <td>Net Amount:</td>
                                                    <td><input type="number" step="0.01" class="form-control" name="net_amount"
                                                            id="net_amount" value="{{ $order->grand_total }}" readonly
                                                            ></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Discount:</td>
                                                    <td><input type="number" min="0" step="0.01" class="form-control" name="total_discount"
                                                            id="total_discount" value="{{ $order->total_discount }}"oninput="updateOrderBillNew()"></td>
                                                </tr>
                                                <tr>
                                                    <td>Price:</td>
                                                    <td>
                                                        <input type="number" min="0" step="0.01" class="form-control"
                                                            name="additional_price" id="additional_price"
                                                            value="{{ $order->additional_price }}" oninput="updateOrderBillNew()">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Advance Amount:</td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control" name="advance_amount"
                                                            id="advance_amount" value="{{ $order->pay_amount }}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Grand Total:</td>
                                                    <td><input type="number" step="0.01" class="form-control" name="grand_total"
                                                            id="grand_total" value="{{ $order->final_amount }}" readonly>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="terms-conditions p-0 mb-3">
                                <h4>Terms & Conditions</h4>
                                <div class="border rounded">
                                    <div class="row py-3 px-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title" class="form-label">Select Title:*</label>
                                                <select class="form-control termsSelect" name="terms_and_conditions[term_id]" id="title" onchange="updateDescription()">
                                                    <option value="">Select a title</option>
                                                    @foreach($terms as $term)
                                                        <option value="{{ $term->id }}"
                                                                data-description="{{ htmlspecialchars($term->description) }}"
                                                                @if(old('terms_and_conditions.term_id', $orderTermsCondition ? $orderTermsCondition->terms_and_conditions_id : '') == $term->id)
                                                                    selected
                                                                @endif>
                                                            {{ $term->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="terms_conditions" class="form-label">Description:</label>
                                                <textarea class="form-control" name="terms_and_conditions[description]" id="terms_conditions" rows="5">{{ trim(old('terms_and_conditions.description', $orderTermsCondition ? $orderTermsCondition->terms_description : '')) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"style="width:100%;">
                                <div class="mb-3" style="display: flex; flex-direction: row; gap: 15px;">
                                    <input type="checkbox" class="form-check-input" id="confirmWithItemPrice" name="confirmWithItemPrice">
                                    <label for="confirmWithItemPrice">Generate Invoice or Quotation with Item Price</label>
                                </div>
                                <div class="button-style" style="display: flex; flex-direction: row; gap: 15px; flex-wrap: wrap; ">
                                    {{--Check Already Added Rent Package --}}
                                    @if( $rentPackage != null)
                                        <div class="mb-3">
                                            <!--Rent Package Button -->
                                            <button type="button" class="btn-light-success btn" data-url="{{ route('useradmin.event_rent_packages.eventEdit', ['rentItemPackage' => $rentPackage->id, 'event' => $order->event_id]) }}" data-size="md" id="rentPackageBtn"
                                                data-ajax-popup="true" data-title="{{ ('Update Rent Package') }}" style="width: 200px; padding: 10px; font-size: 14px;"> {{ ('Rent Package ') }}
                                            </button>
                                        </div>
                                    @else
                                      @if(isset($order->event_id))
    <button type="button" class="btn-light-success btn"
        data-url="{{ route('useradmin.event_rent_packages.eventCreate', ['event' => $order->event_id]) }}"
        data-size="md"
        id="rentPackageBtn"
        data-ajax-popup="true"
        data-title="Add Rent Package"
        style="width: 200px; padding: 10px; font-size: 14px;">
        Rent Package
    </button>
@endif

                                    @endif
                                    {{--Check Already Added Predefined Package --}}
                                    @if( $predefinedPackage != null)
                                    <div class="mb-3">
                                        <!--Predefined Package Edit Create Button -->
                                        <button type="button" class="btn-light-success btn" data-url="{{ route('useradmin.predefined.edit', ['id' => $predefinedPackage->package_id]) }}" data-size="md" id="predefinedPackageBtn"
                                            data-ajax-popup="true" data-title="{{ ('Edit Predefined Package') }}" style="width: 200px; padding: 10px; font-size: 14px;"> {{ ('Predefined Package') }}
                                        </button>
                                    </div>
                                    @else
                                        <div class="mb-3">
                                            <!--Predefined Package Create Button -->
                                            <button type="button" class="btn-light-success btn" data-url="{{ route('useradmin.predefined') }}" data-size="md" id="predefinedPackageBtn"
                                                data-ajax-popup="true" data-title="{{ ('Create Predefined Package') }}" style="width: 200px; padding: 10px; font-size: 14px;"> {{ ('Predefined Package') }}
                                            </button>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <!-- Update Order Button -->
                                        <input type="submit" class="btn btn-success" id="confirmOrderBtn" disabled form="orderForm"
                                        value="Update Order" style="width: 200px; padding: 10px; font-size: 14px;" />
                                    </div>
                                    <div class="mb-3">
                                        <!-- Generate Invoice Button -->
                                        <a href="#" onclick="generateInvoiceOrQuotation('{{ route('useradmin.order.invoice', ['id' => $order->order_id]) }}')">
                                            <button type="button" class="btn btn-success" id="generateInvoiceButton" style="width: 200px; padding: 10px; font-size: 14px;">
                                                Generate Invoice
                                            </button>
                                        </a>
                                    </div>
                                    <div class="mb-3">
                                        <!-- Generate Quotation Button -->
                                        <a href="#" onclick="generateInvoiceOrQuotation('{{ route('useradmin.order.quotation', ['id' => $order->order_id]) }}')">
                                            <button type="button" class="btn btn-success" id="generateQuotationButton" style="width: 200px; padding: 10px; font-size: 14px;">
                                                Generate Quotation
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <!-- Modal Structure -->
            <div class="modal fade" id="descriptionModal" tabindex="1" aria-labelledby="descriptionModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="descriptionModalLabel">Description</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="item_id_des" id="item_id_des">
                            <textarea name="description_modal" id="description_modal" class="form-control" rows="3" maxlength="255"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="saveDescription()">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Structure -->
            <div class="modal fade" id="orderAmountModal" tabindex="-1" aria-labelledby="orderAmountModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="orderAmountModalLabel">Confirm Order Completion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeOrderAmountModal"></button>
                    </div>
                    <div class="modal-body">
                    <p>Have you received the payment for this amount?</p>
                    <p>Order amount: <strong id="orderAmountDisplay"></strong></p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelOrderAmount" >Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmOrderAmount">OK</button>
                    </div>
                </div>
                </div>
            </div>
            <!-- Confirm Change Modal start-->
            <div class="modal fade" id="confirmChangeModal" tabindex="-1" aria-labelledby="confirmChangeModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmChangeModalLabel">Confirm Change</h5>
                            <button type="button" class="btn-close" id="closeConfirmModal" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to change Quotation to Invoice? If confirmed, this action cannot be reverted.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelChange">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmChange">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="confirmDeleteModal1" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <p id="deleteMessage"> Are you sure you want to delete this item?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        var previousOrderStatus;
        var disabledButtons = {}; // Object to keep track of disabled buttons
        let orderitems = @json($orderitems);
        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable(orderitems);
            previousOrderStatus = "{{ $order->order_status }}" ?? '';

            // for order type modal start
            const orderTypeSelect = document.getElementById('order_type');
            const originalValue = orderTypeSelect.value;

            orderTypeSelect.addEventListener('change', function() {

                if (originalValue ===  'quotation' ) {
                    // show modal
                    $('#confirmChangeModal').modal('show');
                }

            });

            // Check if success message exists in the session
            let successMessage = @json(session('success'));

            if (successMessage) {
                // Remove rentPackage from localStorage
                localStorage.removeItem('rentPackage');
                // Remove the predefinedItems from localStorage
                localStorage.removeItem('predefinedPackage');
            }

            // Handle modal confirmation
            document.getElementById('confirmChange').addEventListener('click', function() {
                $('#confirmChangeModal').modal('hide');
            });

            // Handle modal cancellation and close button
            function handleModalCancel() {
                // Reset dropdown to the original value
                orderTypeSelect.value = originalValue;

                // Disable certain elements and hide fields
                $('#name').prop('disabled', true);
                $('#display-none-edit').hide();
                document.getElementById('orderStatusField').style.display = 'none';
                document.getElementById('payment_fields').style.display = 'none';

                // Close the modal
                $('#confirmChangeModal').modal('hide');
            }

            // Attach event listener to the cancel button
            document.getElementById('cancelChange').addEventListener('click', handleModalCancel);
            document.getElementById('closeConfirmModal').addEventListener('click', handleModalCancel);

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
                            $(this).prop('id', "but"+itemId);
                        });
                });
            });

            // Refresh table initially
            table.draw();
        }
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
        })
        $(document).ready(function() {

            function toggleOrderStatusField() {
                var selectedOrderType = $('#order_type').val();
                if (selectedOrderType === 'quotation') {
                    $('#name').prop('disabled', true);
                    document.getElementById('orderStatusField').style.display = 'none';
                    document.getElementById('payment_fields').style.display = 'none';
                    $('#generateInvoiceButton').hide();
                    $('#generateQuotationButton').show();
                    $('#display-none-edit').hide();
                    // pay amount value and displayPayAmount value 0
                    document.getElementById('pay_amount').value = '0.00';
                    document.getElementById('advance_amount').value = '0.00';
                    // If Is Pay is checked, uncheck it
                    var isPayChecked = $('#is_pay').prop('checked');
                    if (isPayChecked) {
                        $('#is_pay').prop('checked', false);
                    }
                    // Assign order status to pending
                    $('#order_status').val('pending').trigger('change');

                } else {
                    $('#orderStatusField').show();
                    $('#name').prop('disabled', false);
                    $('#generateInvoiceButton').show();
                    // $('#generateQuotationButton').hide();
                    $('#display-none-edit').show();
                }
            }

            $('#order_type').change(function() {
                toggleOrderStatusField();
            });

            toggleOrderStatusField();

        });

        $(document).ready(function() {

            $('#order_status').change(function() {
                var selectedOrderStatus = $(this).val();
                togglePaymentFields(selectedOrderStatus);
                showOrderAmountModal(selectedOrderStatus);
            });


            $('#is_pay').change(function() {
                var selectedOrderStatus = $('#order_status').val();
                var isPayChecked = $('#is_pay').prop('checked');

                if (selectedOrderStatus === 'booking' && $(this).prop('checked')) {
                    $('#pay_amount').prop('disabled', false);

                } else {
                    $('#pay_amount').prop('disabled', true);
                }
            });

            $('#pay_amount').keyup(function() {
                var selectedOrderStatus = $('#order_status').val();
                var pay_amount = ($('#pay_amount').val())  || 0;

                if (selectedOrderStatus === 'booking' || selectedOrderStatus === 'pending payment') {
                    // pay amount value store in advance field
                    previous_advance_amount = parseFloat($('#advance_amount').val()) || 0;
                    new_advance_amount = parseFloat(pay_amount);
                    $('#advance_amount').val(new_advance_amount);
                    updateOrderBillNew();

                }
            })

            togglePaymentFields($('#order_status').val());
        });
        // Function to show the order amount modal
        function showOrderAmountModal(orderStatus) {
            if(orderStatus === 'completed'){
                // Grand total
                var grandTotal = $('#grand_total').val();
                // Set the order amount in the modal
                $('#orderAmount').val(grandTotal);
                $('#orderAmountDisplay').text(grandTotal);
                // Show the modal
                $('#orderAmountModal').modal('show');

            }
        }
        // Function to toggle payment fields
        function togglePaymentFields(orderStatus) {
            //check pay_amount
            var payAmount = ($('#pay_amount').val()) || 0;

            if (payAmount > 0) {
                $('#is_pay').prop('checked', true);
            } else {
                $('#is_pay').prop('checked', false);
                $('#pay_amount').prop('disabled', true);
            }
            if (orderStatus === 'booking' || orderStatus === 'pending payment' ) {
                $('#payment_fields').show();
            } else {
                $('#payment_fields').hide();
            }
        }
        // Handle "OK" button in the modal
        $('#confirmOrderAmount').click(function() {
            var orderAmount = $('#orderAmount').val();
            // Close the modal
            $('#orderAmountModal').modal('hide');
        });
        // Handle "Cancel" button in the modal
        $('#cancelOrderAmount').click(function() {
            // Close the modal
            $('#orderAmountModal').modal('hide');
            //  Assign previous value
            $('#order_status').val(previousOrderStatus);
            var selectedOrderStatus = previousOrderStatus;
                togglePaymentFields(selectedOrderStatus);

        })

        // Close the modal
        $('#closeOrderAmountModal').click(function() {
            // Close the modal
            $('#orderAmountModal').modal('hide');
            //  Assign previous value
            $('#order_status').val(previousOrderStatus);
            var selectedOrderStatus = previousOrderStatus;
                togglePaymentFields(selectedOrderStatus);

        })

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

        flatpickr("#booking_date", {
            enableTime: false,
            dateFormat: "Y-m-d"
        });

        flatpickr("#inv_date", {
            enableTime: false,
            dateFormat: "Y-m-d",
            defaultDate: "today",
        });
        function updateEndTimePicker(minTime) {
            flatpickr("#end_time", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                defaultDate: minTime,
                minuteIncrement: 15
            });
        }

        // Update booking date
        function updateBookingDate(startTime) {
            // Extract the date part from the start time
            var bookingDate = startTime.toISOString().split('T')[0];
            // Set the booking date input value
            document.getElementById('booking_date').value = bookingDate;
        }

        var today = new Date().toISOString().split('T')[0];

        // Set the value of the "Invoice Date" input field to today's date
        document.getElementById('inv_date').value = today;

        var disabledButtons = {}; // Object to keep track of disabled buttons

        $('.select-2').select2({
            // placeholder: "Select an Option",
            // minimumResultsForSearch: Infinity
        });

        //disbale disable the search field in select2
        $('.select2-search__field').css('display', 'none').prop('disabled', true);

        function setEmployeeIds() {
            var selectedEmployees = $('#employee_ids').val();

        }

        $(document).ready(function() {

            $('#order_book').change(function() {
                if ($(this).prop('checked')) {

                    $('#payment_fields').show();
                } else {

                    $('#payment_fields').hide();
                }
                enableSubmitButton();
            });


            $('input[type="text"], input[type="checkbox"]').on('input change', function() {
                enableSubmitButton();
            });

        });
        function validateRent(input, validationMessageId) {
            var rent = input.value;
            var validationMessage = document.getElementById(validationMessageId);
            if (rent < 0) {
                validationMessage.textContent = "Minimum value should be 0.";
                input.setCustomValidity("Minimum value should be 0.");
                input.value = '';
            }
            else{
                validationMessage.textContent = "";
                input.setCustomValidity("");
            }

        }

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

        function validateInputLength(input, maxLength) {
            var inputValue = input.value.toString();
            if (inputValue.length > maxLength) {
                input.value = inputValue.slice(0, maxLength);
            }
        }

        function updateOrderBillNew() {
            let totalItemPriceNewAdded = 0.00;
            let totalDiscountNewAdded = 0.00;
            let totalItemPriceOld = 0.00;
            let totalDiscountOld = 0.00;
            let totalAmountOld = 0.00;
            let totalAmountNew = 0.00;

            $('#itemTableBody tr').each(function() {
                var row = $(this);
                var priceInput = $(this).find('td').eq(1).find('input'); // Rent Price input
                var quantityInput = $(this).find('td').eq(2).find('input'); // Quantity input
                var discountInput = $(this).find('td').eq(3).find('input'); // Discount input
                var amountInput = $(this).find('td').eq(4).find('input'); // Amount input

                var itemPrice = parseFloat(priceInput.val()) || 0;

                var quantity = parseFloat(quantityInput.val()) || 0;
                var discount = parseFloat(discountInput.val()) || 0;

                // Multiply item price by quantity
                itemPrice *= quantity;

                // Calculate total amount
                var amount = itemPrice - discount;
                amountInput.val(amount.toFixed(2));

                // // Add item price to total
                // totalItemPriceNewAdded += itemPrice;

                // // Add discount to total
                // totalDiscountNewAdded += discount;

                // Get new amount input total
                totalAmountNew += parseFloat(amountInput.val()) || 0;

                // Get this row category
                var category = row.find('td').eq(0).text().replace('Category: ', '');

                // Find category subtotal row
                var subtotalRow = $('#itemTableBody').find('.category-subtotal-row:contains("' + category + '")');
                var subtotal = parseFloat(subtotalRow.find('.category-subtotal-amount').text()) || 0;
                subtotal += amount;
                updateCategorySubtotal();


            });


            $('#oldItemTableBody tr').each(function() {
                var row = $(this);
                var priceInput = $(this).find('td').eq(1).find('input'); // Rent Price input
                var quantityInput = $(this).find('td').eq(2).find('input'); // Quantity input
                var discountInput = $(this).find('td').eq(3).find('input'); // Discount input
                var amountInput = $(this).find('td').eq(4).find('input'); // Amount input

                var itemPrice = parseFloat(priceInput.val()) || 0;
                var quantity = parseFloat(quantityInput.val()) || 0;
                var discount = parseFloat(discountInput.val()) || 0;

                // Calculate item amount
                var amount = (itemPrice * quantity) - discount;
                amountInput.val(amount.toFixed(2));

                // Get old amount input total
                totalAmountOld += amount;

                // Get this row category
                var category = row.find('td').eq(0).text().replace('Category: ', '');

                // Get this row category
                var category = row.find('td').eq(0).text().replace('Category: ', '');
                 // Find category subtotal row
                 var subtotalRow = $('#itemTableBody').find('.category-subtotal-row:contains("' + category + '")');
                var subtotal = parseFloat(subtotalRow.find('.category-subtotal-amount').text()) || 0;
                subtotal += amount;
                updateCategorySubtotalExistItems();



            });







            var totalItemPrice = totalAmountNew+totalAmountOld;
            // Get the total discount from the input field
            var totalDiscount = parseFloat($('#total_discount').val()) || 0;


            // Update the corresponding input fields with the new values
            $('#orderTotalPrice').val(totalItemPrice.toFixed(2));
            // $('#total_discount').val(totalDiscount.toFixed(2));

            var transport = parseFloat($('#transport').val()) || 0;
            var tax = parseFloat($('#tax').val()) || 0;

            // Update the grand total
            var grandTotal = (totalItemPrice + transport + tax) - totalDiscount;
            $('#net_amount').val(grandTotal.toFixed(2));
            var finalTotal = totalItemPrice - totalDiscount;
            $('#grand_total').val(grandTotal.toFixed(2));

            // Other calculations for transport, tax, additional price, pay amount, etc.
            var additionalPrice = parseFloat($('#additional_price').val()) || 0;
            var payAmount = parseFloat($('#advance_amount').val()) || 0;

            var finalAmount;

            if (additionalPrice === 0) {
                finalAmount = grandTotal - payAmount;
            } else {
                finalAmount = additionalPrice - payAmount;
            }

            $('#grand_total').val(finalAmount.toFixed(2));

            enableSubmitButton();
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

                    validationMessage.textContent = "Discount cannot be greater than total price.";
                    input.setCustomValidity("Discount cannot be greater than total price.");
                    // input.value = 0;
                }
            }

        }

        function setItemId(button, itemName, category, rent_price, itemId) {
            var quantityInput = $(button).closest('tr').find('.quantity-input');
            var rentInput = $(button).closest('tr').find('.rent-input');
            var discountInput = $(button).closest('tr').find('.discount-input');
            var quantity = quantityInput.val();
            var rentPrice = rentInput.val();
            var discount = discountInput.val();
            var description = '';
            var category = category;

            var uniqid=category+"_"+Date.now();

            if (quantity > 0) {
                // // Find the category section in the table
                var categorySection = $('#itemTableBody').find('.category-header-row:contains("' + category + '")');

                // // If category doesn't exist, create it
                if (categorySection.length === 0) {
                    categorySection = $('<tr class="category-header-row bg-light" id="'+uniqid+'">' +
                        '<td colspan="6" style="font-weight: bold; padding-top: 10px; padding-bottom: 10px;">' +
                        'Category: ' + category +
                        '</td>' +
                        '</tr>');
                    $('#itemTableBody').append(categorySection);
                    // calculate category subtotal
                      subtotalRow = $('<tr class="category-subtotal-row">' +
                        '<td colspan="4" style="text-align:right; font-weight: bold;">' + category + ' Subtotal:</td>' +
                        '<td style="font-weight: bold;" class="category-subtotal-amount">' + (rentPrice * quantity - discount).toFixed(2) + '</td>' +
                        '<td></td>' +
                        '</tr>');

                }
                else{
                    // this category previous added all items total category subtotal
                    var subtotalRow = $('#itemTableBody').find('.category-subtotal-row:contains("' + category + '")');
                    var subtotal = parseFloat(subtotalRow.find('.category-subtotal-amount').text()) || 0;
                    subtotal += (rentPrice * quantity - discount);
                    subtotalRow.find('.category-subtotal-amount').text(subtotal.toFixed(2));
                    // update category-subtotal-row

                }

                var newRow = `
                        <tr>
                        <td>
                            ${itemName}&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm btn-info" onclick="addDescription(this)">Add Description</button>
                            <input type="hidden" name="item_id[]" value="${itemId}">
                            <br>
                            <div id="description" class="description text-break" style="word-wrap: break-word; white-space: pre-wrap;"></div>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control rent-input" name="rent_price[]" value="${rentPrice}" data-index="${itemId}"
                            oninput="validateRent(this, 'rentpriceValidationMessage${itemId}'); updateOrderBillNew()">
                            <span id="rentpriceValidationMessage${itemId}" style="color: red;"></span>
                        </td>
                        <td>
                            <input type="number" min="1" class="form-control quantity-input" name="quantity[]" value="${quantity}" data-index="${itemId}"
                            oninput="validateQuantity(this, 'quantityValidationMessage${itemId}'); updateOrderBillNew()">
                            <span id="quantityValidationMessage${itemId}" style="color: red;"></span>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control discount-input" name="discount[]" value="${discount}" data-index="${itemId}"
                            oninput="validateDiscount(this, 'discountValidationMessage${itemId}'); updateOrderBillNew()">
                            <span id="discountValidationMessage${itemId}" style="color: red;"></span>
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control amount-input" name="amount[]" value="${(rentPrice * quantity - discount).toFixed(2)}" readonly>
                        </td>
                        <td>
                            <button class="btn btn-md btn-danger" onclick="removeItem(this, ${itemId}, '${category}','${uniqid}')">Remove</button>
                        </td>
                        </tr>
                        `;




                  // Insert the new row after the category header
                  categorySection.after(newRow);


                  // Update category subtotal
                  updateCategorySubtotal();

                // After adding the new item, update the order bill
                updateOrderBillNew();

                 // Re-enable the "Add" button in the first tableAdd commentMore actions
                var addButton = $('button[data-itemId="' + itemId + '"]');
                addButton.prop('disabled', true);

            } else {
                $('#quantityValidationMessage').text('Please enter a valid quantity.');
            }


        }


      function removeItem(button, itemId, category, uniqid) {
          // Remove the row from the table
          var row = $(button).closest('tr');
          row.remove();

          // Find the category header for this item
          var categoryHeader = $('#itemTableBody').find('.category-header-row').filter(function() {
              return $(this).text().trim() === 'Category: ' + category;
          }).first();

          // Check if this was the last item in the category
          var categoryItems = categoryHeader.nextUntil('.category-header-row');
          var subtotalRow = categoryItems.filter('.category-subtotal-row').first();
          categoryItems = categoryItems.not('.category-subtotal-row');

          if (categoryItems.length === 0) {
              // Remove the category header and subtotal row
              categoryHeader.remove();
              if (subtotalRow.length > 0) {
                  subtotalRow.remove();
              }
          } else {
              // Update the category subtotal
              updateCategorySubtotal();
          }

          // Update the order bill
          updateOrderBillNew();

          // Re-enable the "Add" button in the first tableAdd commentMore actions
          var addButton = $('button[data-itemId="' + itemId + '"]');
            addButton.prop('disabled', false);
            delete disabledButtons[itemId];



      }
      function updateCategorySubtotal() {
          // Find all category headers
          var categoryHeaders = $('#itemTableBody').find('.category-header-row');

          // Iterate through each category header
          categoryHeaders.each(function() {
              var category = $(this).text().replace('Category: ', '');

              // Find all rows in the same category
              var categoryRows = $(this).nextUntil('.category-header-row');

              // Calculate subtotal for this category
              var subtotal = 0;
              categoryRows.each(function() {
                  var amountInput = $(this).find('.amount-input');
                  if (amountInput.length > 0) {
                      subtotal += parseFloat(amountInput.val()) || 0;
                  }
              });

        // Update category subtotal
        var subtotalRow = $('#itemTableBody').find('.category-subtotal-row:contains("' + category + '")');
        if (subtotalRow.length === 0) {
            subtotalRow = $('<tr class="category-subtotal-row">' +
                '<td colspan="4" style="text-align:right; font-weight: bold;">' + category + ' Subtotal:</td>' +
                '<td style="font-weight: bold;" class="category-subtotal-amount">' + subtotal.toFixed(2) + '</td>' +
                '<td></td>' +
                '</tr>');

            // Add after the last item row in this category
            var lastItemRow = $(this).nextUntil('.category-header-row').last();
            if (lastItemRow.length > 0) {
                lastItemRow.after(subtotalRow);
            } else {
                // If no items yet, add after the category header
                $(this).after(subtotalRow);
            }
        } else {
            subtotalRow.find('.category-subtotal-amount').text(subtotal.toFixed(2));
        }


          });
      }
      function updateCategorySubtotalExistItems() {
         // Find all category headers
         var categoryHeaders = $('#oldItemTableBody').find('.category-header-row');
         categoryHeaders.each(function() {
            var category = $(this).text().trim().replace('Category: ', '');

            // Find all items in this category
            var categoryRows = $(this).nextUntil('.category-header-row');

            // Calculate subtotal for this category
            var subtotal = 0;
            categoryRows.each(function() {
                var amountInput = $(this).find('.amount-input');
                if (amountInput.length > 0) {
                    subtotal += parseFloat(amountInput.val()) || 0;
                }
            });

            // Find or create subtotal row
            var subtotalRow = categoryRows.next('.category-subtotal-row');
            if (subtotalRow.length === 0) {
                // Create new subtotal row
                subtotalRow = $('<tr class="category-subtotal-row">' +
                    '<td colspan="4" style="text-align:right; font-weight: bold;">' + category + ' Subtotal:</td>' +
                    '<td style="font-weight: bold;" class="category-subtotal-amount">' + subtotal.toFixed(2) + '</td>' +
                    '<td></td>' +
                    '</tr>');

                // Add after the last item in this category
                var lastItem = categoryRows.last();
                if (lastItem.length) {
                    lastItem.after(subtotalRow);
                } else {
                    // If no items yet, add after the category header
                    $(this).after(subtotalRow);
                }
            } else {
                // Update existing subtotal row
                subtotalRow.find('.category-subtotal-amount').text(subtotal.toFixed(2));
            }
        });
     }

        // Function to remove existing item
        function removeExistItem(button, itemId, rentPrice, discount, quantity, category, uniqid) {
            // Show the modal
            $('#confirmDeleteModal1').modal('show');

            // Add event listener to the delete button
            $('#confirmDeleteButton').on('click', function() {
                // Remove the item row from the second table
                var row = $(button).closest('tr');
                row.remove();

                // Find the category header
                var categoryHeader = $('#oldItemTableBody').find('.category-header-row').filter(function() {
                    return $(this).text().trim() === 'Category: ' + category;
                }).first();

                // Check if this was the last item in the category
                var categoryItems = categoryHeader.nextUntil('.category-header-row');
                var subtotalRow = categoryItems.filter('.category-subtotal-row').first();
                categoryItems = categoryItems.not('.category-subtotal-row');


                if (categoryItems.length === 0) {
                    // Remove category header and subtotal if this was the last item
                    categoryHeader.remove();

                    if (subtotalRow.length > 0) {
                        subtotalRow.remove();
                    }
                } else {

                    // Update the category subtotal
                    updateExistCategorySubtotal(categoryItems, subtotalRow);
                }

                // Re-enable the "Add" button in the first table
                toggleAddButton(itemId, false);
                updateOrderBillNew();
                enableSubmitButton();
                // Close the modal
                $('#confirmDeleteModal1').modal('hide');
            });

        }

        // Function to update category subtotal when an item is removed
        function updateExistCategorySubtotal(categoryItems, subtotalRow) {
            var subtotal = 0;

            // Calculate new subtotal by summing remaining items
            categoryItems.each(function() {
                var amountInput = $(this).find('.amount-input');
                if (amountInput.length > 0) {
                    subtotal += parseFloat(amountInput.val()) || 0;
                }
            });

            subtotalRow.find('.category-subtotal-amount').text(subtotal.toFixed(2));

        }

        //  Form submit
        $('#orderForm').submit(function() {
            // Check if additional price is greater than 0
            if( parseFloat($('#additional_price').val()) > 0)
            {

                // Check if advance amount is greater than additional price
                if (parseFloat($('#advance_amount').val()) > parseFloat($('#additional_price').val())) {
                    showCustomAlert('Advance amount cannot be greater than  price.');
                    return false;
                }
                // Additional price can't less than tax+transport
                if (parseFloat($('#additional_price').val()) < parseFloat($('#tax').val()) + parseFloat($('#transport').val())) {
                    showCustomAlert('Price cannot be less than Transport and Service Charges.');
                    return false;
                }

            }
            // Check if advance amount is greater than net amount
            else if( parseFloat($('#net_amount').val()) < parseFloat($('#advance_amount').val()))
            {
                showCustomAlert('Advance amount cannot be greater than net amount.');
                return false;
            }
            var transport = parseFloat($('#transport').val()) || 0;
            var tax = parseFloat($('#tax').val()) || 0;
            var orderTotalPrice = parseFloat($('#orderTotalPrice').val()) || 0;
            // Check total discount
            if (parseFloat($('#total_discount').val()) > (orderTotalPrice + transport + tax)) {
                showCustomAlert('Total discount Maximum allowed is ' + (orderTotalPrice + transport + tax));
                return false;
            }
            // Get old order items
            let oldOrderItems = [];
            // Get new order items
            let newOrderItems = [];

            $('#oldItemTableBody tr').each(function() {
                // Get description
                let description = $(this).find('div.description').text();
                let oderItemId = $(this).find('input[name="order_item_id[]"]').val();
                let rentPrice = $(this).find('input[name="predefined_rentprice[]"]').val();
                let discount = $(this).find('input[name="predefined_discount[]"]').val();
                let quantity = $(this).find('input[name="predefined_quantity[]"]').val();

                // Filter out items with null or empty order_item_id
                if (!oderItemId) {
                    return;
                }


                oldOrderItems.push({
                    oderItemId: oderItemId,
                    rentPrice: rentPrice ? parseFloat(rentPrice) : 0,
                    discount: discount ? parseFloat(discount) : 0,
                    quantity: quantity ? parseInt(quantity) : 1,
                    description: description ? description : ''
                });


            });

            $('#itemTableBody tr').each(function() {
                // Get description
                let description = $(this).find('div.description').text();
                let itemId = $(this).find('input[name="item_id[]"]').val();
                let rentPrice = $(this).find('input[name="rent_price[]"]').val();
                let discount = $(this).find('input[name="discount[]"]').val();
                let quantity = $(this).find('input[name="quantity[]"]').val();

                // Filter out items with null or empty item_id
                if (!itemId) {
                    return;
                }

                newOrderItems.push({
                    itemId: itemId,
                    rentPrice: rentPrice ? parseFloat(rentPrice) : 0,
                    discount: discount ? parseFloat(discount) : 0,
                    quantity: quantity ? parseInt(quantity) : 1,
                    description: description ? description : ''
                });
            });

            $('#oldOrderedItems').val(JSON.stringify(oldOrderItems));
            $('#newOrderedItems').val(JSON.stringify(newOrderItems));

            // Retrieve rentPackage from localStorage
            var localData = JSON.parse(localStorage.getItem('rentPackage'));
            // Retrieve predefinedPackage from localStorage
            var predefinedData = JSON.parse(localStorage.getItem('predefinedPackage'));
            // Use localData as an object or array
            $('#rentPackageList').val(JSON.stringify(localData));
            $('#predefinedPackageList').val(JSON.stringify(predefinedData));

        });

        //  Add description
        function addDescription(button) {
            var descriptionDiv = $(button).closest('tr').find('div.description');
            var itemId = $(button).closest('tr').find('input[name="item_id[]"]').val(); // Get item ID

            // Open the modal and set the item_id and current description
            $('#descriptionModal').modal('show');
            $('#item_id_des').val(itemId); // Set item ID for modal
            $('#description_modal').val(descriptionDiv.text().trim()); // Populate modal with existing description

        }
        //  Save description
        function saveDescription() {
            var description = $('#description_modal').val(); // Get the description entered in the modal
            var itemIdDes = $('#item_id_des').val(); // Get the item ID

            // Close the modal
            $('#descriptionModal').modal('hide');

            //  Update the description in the table
            var descriptionDiv = $('input[name="item_id[]"][value="' + itemIdDes + '"]').closest('tr').find(
                'div.description');
            descriptionDiv.text(description); // Set the new description in the table

        }
        //  Enable/disable "Confirm Order" button
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

            // Check if required fields are filled and no item is selected
            if (customerName !== "" && location !== "" && eventName !== "" && startTime !== "" && endTime !==
                "" && customerPhone !== "" && orderType !== "" && bookingDate !== "" && invDate !== "" && (!($('#is_pay').prop('checked')) || $('#pay_amount').val() !== "" && $('#pay_amount').val() !== "0" )) {

                $('#confirmOrderBtn').prop('disabled', false);

            } else {
                $('#confirmOrderBtn').prop('disabled', true);
            }

        }

        $(document).ready(function() {

            // Enable/disable "Confirm Order" button on page load
            enableSubmitButton();

            // Event listener for change/input events on relevant form elements
            $('#customer_name, #order_type, #booking_date, #inv_date, #event_name, #start_time, #location, #end_time, #customer_phone')
                .on('change input', function() {
                    enableSubmitButton();
                });
        });
        function generateInvoiceOrQuotation(url) {
            // Check if the checkbox is checked
            const isChecked = document.getElementById('confirmWithItemPrice').checked;

            // Append the checkbox state as a query parameter
            const updatedUrl = `${url}?confirmWithItemPrice=${isChecked ? 1 : 0}`;

            // Redirect to the updated URL
            window.location.href = updatedUrl;
        }
        // Function to update the description

        function updateDescription() {
            const select = document.getElementById('title');
            const description = document.getElementById('terms_conditions');
            const selectedOption = select.options[select.selectedIndex];
            const descriptionData = selectedOption.getAttribute('data-description');

            if (descriptionData) {
                description.value = descriptionData;
            } else {
                description.value = '';
            }
        }
    </script>
@endsection
