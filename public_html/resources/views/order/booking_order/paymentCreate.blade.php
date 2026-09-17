<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form action="{{ route('useradmin.order.bookingPayment.store', $order->order_id) }}" method="post" enctype="multipart/form-data" id="paymentForm" data-ajax="true">
    @csrf
    <div class="col">
        <div class="form-group">
            <label for="Order_id" class="form-label">Order Id:</label>
            <input type="text" class="form-control" name="Order_id" id="Order_id" value="{{ $order->order_id }}"
                readonly>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="customer name" class="form-label">Customer Name:</label>
            <input type="text" class="form-control" name="customer_name" id="customer_name" value="{{ $order->customer_name }}"
                readonly>
        </div>
    </div>
    <div class="col">
        <div class="form-group"></div>
            <label for="total_amount" class="form-label">Grand Total:</label>
            <input type="text" class="form-control" name="total_amount" id="total_amount" value="{{ ($order->additional_price) != 0 ? $order->additional_price : $order->grand_total }}" readonly>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="arrears" class="form-label">Balance:</label>
            <input type="text" class="form-control" name="arrears" id="arrears" value="{{ $order->final_amount }}" readonly>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="pay_amount" class="form-label">Pay Amount:</label>
            <input type="text" class="form-control" name="pay_amount" id="pay_amount" min="1">
            <div id="error-message" style="color: red; display: none;">Pay Amount must be less than or equal to Balance.</div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="payement_type" class="form-label">Payment Type:</label>
            <select class="form-control" name="payement_type" id="payement_type">
                <option value="Cash">Cash</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cheque">Cheque</option>
            </select>
        </div>
    </div>
    <div class="col-md-4-align">
        <div class="form-group"></div>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>
<script>
    document.getElementById('pay_amount').addEventListener('input', function() {
        var balance = parseFloat(document.getElementById('arrears').value);
        var payAmount = parseFloat(this.value);
        var errorMessage = document.getElementById('error-message');

        if (payAmount > balance) {
            errorMessage.style.display = 'block';
            this.setCustomValidity('Pay Amount must be less than or equal to Balance.');
        } else {
            errorMessage.style.display = 'none';
            this.setCustomValidity('');
        }
    });
</script>
