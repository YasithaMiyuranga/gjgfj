<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('employee.vacations.store') }}" id="vacationForm" data-ajax="true" enctype="multipart/form-data">
@csrf
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Get_date *') }}</label>
        <x-input id="vacation_get" class="form-control" type="date" name="get_date" required autofocus />
    </div>
        <label class="form-label" for="name">{{ ('Return_date *') }}</label>
        <x-input id="vacation_end" class="form-control" type="date" name="return_date" required autofocus />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Reason *') }}</label>
        <textarea id="reason" class="form-control" type="text" name="reason" rows="4" required autofocus ></textarea>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Status *') }}</label>
        <x-input id="status" class="form-control" type="text" name="status" value="pending" readonly />
    </div>
    <div class="form-group mb-3">
        <button id="submitButton" class="btn btn-primary btn-block mt-2" type="submit"> {{ ('Submit') }} </button>
    </div>
</form>
