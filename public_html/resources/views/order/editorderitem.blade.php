{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Display order details here -->

        <form action="{{ route('useradmin.order.updates', ['order_id' => $order->order_id, 'orderitem_id' => $orderitem->id]) }}" method="POST">

            @csrf
            @method('PUT')

            <!-- Add form fields to edit order item details -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="order_status" class="form-label">Status:</label>
                        <select class="form-control" name="order_status" id="order_status" required>
                            <option value="">Choose order status</option>
                            <option value="completed" @if($orderitem->order_status === 'completed') selected @endif>Complete</option>
                            <option value="advanced" @if($orderitem->order_status === 'advanced') selected @endif>Advance</option>
                            <option value="booking" @if($orderitem->order_status === 'booking') selected @endif>Booking</option>
                            <option value="credit order" @if($orderitem->order_status === 'credit order') selected @endif>Credit Order</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pay_amount" class="form-label">Advance Amount:</label>
                        <input type="text" name="pay_amount" id="pay_amount" value="{{ $orderitem->pay_amount }}" step="0.01">
                    </div>
                </div>
            </div>

            <!-- Dynamic item rows -->
            <div class="row mt-2" id="itemRowsContainer">


                <!-- Add button to dynamically add new item rows -->
                <div class="col-md-12 mt-2">
                    <button type="button" class="btn btn-primary" onclick="addNewItemRow()">Add Item</button>
                </div>
            </div>

            <!-- Submit button -->
            <div class="row mt-2">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">Update Order Item</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Script section -->
    <script>
        // Function to add a new item row dynamically
        function addNewItemRow() {
            var newItemRow = `
                <div class="col-md-12 mt-2">
                    <label>New Item:</label>
                    <input type="text" class="form-control" name="new_item_name[]" placeholder="Item Name" required>
                    <input type="number" step="0.01" class="form-control" name="new_rent_price[]" placeholder="Rent Price" required>
                    <input type="number" step="0.01" class="form-control" name="new_discount[]" placeholder="Discount">
                    <input type="number" class="form-control" name="new_quantity[]" placeholder="Quantity" required>
                    <button type="button" class="btn btn-danger" onclick="removeItemRow(this)">Remove</button>
                </div>
            `;

            // Append the new item row to the container
            $('#itemRowsContainer').append(newItemRow);
        }

        // Function to remove an item row dynamically
        function removeItemRow(button) {
            // Remove the parent row of the clicked button
            $(button).closest('.col-md-12').remove();
        }
    </script>
@endsection --}}
