<form id="expenseIncomeForm" method="post" action="{{ route('useradmin.manual.expenses.income.store') }}">
    @csrf
    <input type="hidden" name="created_by" value="admin">

    <div class="form-group mb-3">
        <label class="form-label" for="date">{{ __('Enter Date') }}</label>
        <x-input id="date" class="form-control" type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" autofocus />
        <div id="dateError" class="text-danger"></div>
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Expense/Income Name') }}</label>
        <x-input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" autofocus />
        <div id="nameError" class="text-danger"></div>
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="amount">{{ __('Enter Amount') }}</label>
        <x-input id="amount" class="form-control" type="text" name="amount" value="{{ old('amount') }}" autofocus   onkeypress="validateInputLength(this, 7)"/>
        <div id="amountError" class="text-danger"></div>
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="type">{{ __('Select Type') }}</label>
        <select id="type" class="form-control" name="type">
            <option value="" disabled {{ old('type') ? '' : 'selected' }}>{{ __('Choose Type') }}</option>
            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>{{ __('Income') }}</option>
            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>{{ __('Expense') }}</option>
        </select>
        <div id="typeError" class="text-danger"></div>
    </div>

    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits" type="submit"> {{ __('Add') }} </button>
        </div>
    </div>
</form>
<script>
    //Validate Input Length
    function validateInputLength(input, maxLength) {
        var inputValue = input.value.toString();
        if (inputValue.length > maxLength) {
            input.value = inputValue.slice(0, maxLength);
        }
    }
    $('#expenseIncomeForm').on('submit', function(e) {
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
