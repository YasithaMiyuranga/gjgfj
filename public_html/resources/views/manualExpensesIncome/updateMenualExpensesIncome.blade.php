<form action="{{ route('useradmin.manual.expenses.income.update', $manualExpensesIncome) }}" method="POST" id="expenseIncomeEditForm">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="customer_id">Date</label>
        <input type="date" class="form-control" id="date" name="date" value="{{ $manualExpensesIncome->date }}">
    </div>
    <div class="form-group">
        <label for="customer_name">Name</label>
        <input type="text" class="form-control" id="name" name="name"
            value="{{ $manualExpensesIncome->name }}">
        <span class="text-danger" id="nameError"></span>
    </div>
    <div class="form-group">
        <label for="amount">Amount</label>
        <input type="text" class="form-control" id="amount" name="amount"
            value="{{ $manualExpensesIncome->amount }}"onkeypress="validateInputLength(this, 7)"/>
            <span class="text-danger" id="amountError"></span>
    </div>
    <div class="form-group">
        <label for="type">Type</label>
        <select class="form-control" id="type" name="type">
            <option value="" disabled>Select Type</option>
            <option value="expense" {{ $manualExpensesIncome->type == 'expense' ? 'selected' : '' }}>Expense</option>
            <option value="income" {{ $manualExpensesIncome->type == 'income' ? 'selected' : '' }}>Income</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits">Update</button>
</form>
<script>
    //Validate Input Length
    function validateInputLength(input, maxLength) {
        var inputValue = input.value.toString();
        if (inputValue.length > maxLength) {
            input.value = inputValue.slice(0, maxLength);
        }
    }
    $('#expenseIncomeEditForm').on('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Clear previous errors
        $('.text-danger').text('');

        // Validate Date
        if ($('#date').val().trim() === '') {
            $('#dateError').text('Date is required.');
            isValid = false;
        }

        // Validate Name
        if ($('#name').val().trim() === '') {
            $('#nameError').text('Name is required.');
            isValid = false;
        }

        // Validate Name
        if ($('#name').val().trim().length > 255) {
            $('#nameError').text('Name cannot exceed 255 characters.');
            isValid = false;
        }

        // Validate Amount
        const amount = $('#amount').val().trim();
        if (amount === '') {
            $('#amountError').text('Amount is required.');
            isValid = false;
        } else if (isNaN(amount) || parseFloat(amount) <= 0) {
            $('#amountError').text('Please enter a valid positive amount.');
            isValid = false;
        }

        // Validate Type
        if ($('#type').val() === null) {
            $('#typeError').text('Please select a type (Income or Expense).');
            isValid = false;
        }

        // If the form is valid, submit it
        if (isValid) {
            $('.from-prevent-multiple-submits').attr('disabled', true);
            this.submit();
        }
    });
</script>
