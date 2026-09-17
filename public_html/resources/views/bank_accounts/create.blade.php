<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.bank_accounts.store') }}" id="bankAccountAddForm" data-ajax="true" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Bank Name') }}</label>
        <x-input id="name" name="bank_name" class="form-control" type="text"   maxlength="100" required />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Branch Name') }}</label>
        <x-input id="name" name="branch_name" class="form-control" type="text"   maxlength="100" required />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Account Name') }}</label>
        <x-input id="name" name="account_name" class="form-control" type="text"   maxlength="100" required />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Account Number') }}</label>
        <x-input id="name" name="account_number" class="form-control" type="text"   maxlength="100" required />
    </div>
       <div class="mb-3 form-check">
            <label class="form-label" for="is_default">{{ ('Default') }}</label>
            <input type="checkbox" name="is_default" class="form-check-input" id="is_default">
        </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Add Bank Account') }}</button>
        </div>
    </div>
</form>
