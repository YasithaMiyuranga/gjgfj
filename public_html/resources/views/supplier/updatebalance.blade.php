<form action="{{ route('useradmin.supplier.credit.update') }}" method="post">
    @csrf
    @method('PUT')
    <input type="hidden" id="supplier_id" name="supplier_id" value="{{$supplier->id}}">

    <div class="form-group">
        <label for="supplier_name">Supplier Name</label>
        <input type="text" class="form-control" id="supplier_name" name="supplier_name" readonly value="{{$supplier->supplier_name}}" required>
    </div>

    <div class="form-group">
        <label for="balance">Balance</label>
        <input type="text" class="form-control" id="balance" name="balance" readonly value="{{$supplier->credit_balance}}" required>
    </div>

    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" id="date" name="date" value="{{$supplier->date}}" required>
    </div>

    <div class="form-group">
        <label for="payment_amount">Payment</label>
        <input type="text" class="form-control" id="payment_amount" name="payment_amount" oninput="checkPaymentAmount()" required>
        <small id="warning-message" class="text-danger" style="display: none;">Warning: Payment amount exceeds balance.</small>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<script>
    // Close modal when click close button
    $('#closeModal').click(function() {
        $('#commanModel').modal('hide');
    });

    // Check payment amount and show warning if it exceeds the balance
    function checkPaymentAmount() {
        const balance = parseFloat(document.getElementById('balance').value);
        const paymentAmount = parseFloat(document.getElementById('payment_amount').value);
        const warningMessage = document.getElementById('warning-message');

        if (paymentAmount > balance) {
            warningMessage.style.display = 'inline'; // Show warning message
        } else {
            warningMessage.style.display = 'none'; // Hide warning message
        }
    }
</script>
