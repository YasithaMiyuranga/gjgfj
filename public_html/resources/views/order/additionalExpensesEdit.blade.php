<form method="POST" action="{{ route('useradmin.order.expenses.update', $additionalExpenses->id) }}" method="POST" id="additionalExpensesEditForm">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label for="event_id">{{ __('Event') }}</label>
        <x-input id="event_id" name="event_id" class="form-control" type="text" value="{{ $additionalExpenses->event_id }}" readonly />
    </div>
    <div class="form-group mb-3">
        <label for="order_id">{{ __('Order Id') }}</label>
        <x-input id="order_id" name="order_id" class="form-control" type="text" value="{{ $additionalExpenses->order_id }}" readonly />
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Expense Name') }}</label>
        <x-input id="name" name="name" class="form-control" type="text" value="{{ $additionalExpenses->expense_name }}" required />
        <span class="text-danger" id="nameError"></span>
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="amount">{{ __('Amount') }}</label>
        <x-input id="amount" name="amount" class="form-control" type="number" value="{{ $additionalExpenses->amount }}" required />
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="date">{{ __('Date') }}</label>
        <x-input id="date" name="date" class="form-control" type="date" value="{{ $additionalExpenses->expense_date }}" required />
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="description">{{ __('Description') }}</label>
       <textarea class="form-control" id="description" name="description" rows="3" value=" ">{{ $additionalExpenses->description }}</textarea>
        <span class="text-danger" id="descriptionError"></span>
    </div>
    <button type="submit" class="btn btn-primary from-prevent-multiple-submits">{{ __('Update') }}</button>
</form>
<script>
    $('#additionalExpensesEditForm').on('submit', function(e) {
        var description = $('#description').val();
        var expenseName = $('#name').val();
        var hasErrors = false;
        if (description.length > 255) {
            $('#descriptionError').text('Description should be less than 255 characters.');
            hasErrors = true;
        } else {
            $('#descriptionError').text('');
        }

        if (expenseName.length > 255) {
            $('#nameError').text('Expense Name should be less than 255 characters.');
            hasErrors = true;
        } else {
            $('#nameError').text('');
        }

        if (hasErrors) {
            e.preventDefault();
        } else {
            $('.from-prevent-multiple-submits').attr('disabled', 'true');
            this.submit();
        }

    });
</script>
