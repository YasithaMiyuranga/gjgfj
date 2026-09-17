<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="get" action="{{ route('useradmin.cashflow.search.result') }}">   
    <input type="hidden" name="created_by" value="admin">

    <div class="form-group mb-3">
        <label class="form-label" for="date">{{ __('Enter Start Date') }}</label>
        <x-input id="start_date" class="form-control" type="date" name="start_date" required autofocus />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="date">{{ __('Enter EndDate') }}</label>
        <x-input id="end_date" class="form-control" type="date" name="end_date" required autofocus />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="date">{{ __('Enter Amount') }}</label>
        <x-input id="amount" class="form-control" type="number" name="amount" />
    </div>
    <div class="form-group mb-3">
        <input class="form-check-input" type="checkbox" name="with_deleted_records" id="with_deleted_records">
        <label for="with_deleted_records">With Deleted Records</label>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit"> {{ __('Search') }} </button>
        </div>
    </div>

</form>
