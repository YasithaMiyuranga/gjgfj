@extends('layouts.events')
@section('page-title', 'Agenda')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.agenda.view') }}">{{ __('Agenda') }}</a>
        <li class="breadcrumb-item active">{{ __('Create Agenda') }}</li>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                    <h3> Create Agenda</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                    <!-- Form for adding an agenda -->
                    <form action="{{ route('useradmin.agenda.store') }}" method="POST">
                        @csrf
                        <!-- Event Selection -->
                        <div class="mb-4">
                            <label for="event_id" class="form-label">Event *</label>
                            <select name="event_id" id="event_id" class="form-select" required>
                                <option value="" disabled selected>Select an Event</option>
                                @foreach($events as $event)
                                   <option value="{{ $event->eid }}" {{ $event->eid == old('event_id') ? 'selected' : '' }}>{{ $event->event_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="eventError"></span>
                        </div>
                        <!-- Event Dates -->
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label for="event_start_date" class="form-label">Event Start Date/Time *</label>
                                <input type="text" name="event_start_date" id="event_start_date" class="form-control" value="{{ old('event_start_date') }}" required readonly>
                            </div>

                            <div class="col-md-6 mb-6">
                                <label for="event_end_date" class="form-label">Event End Date/Time *</label>
                                <input type="text" name="event_end_date" id="event_end_date" class="form-control" value="{{ old('event_end_date') }}" required readonly>
                            </div>
                        </div>
                        <br>
                            <!-- Agenda Days -->
                            <div id="agenda-days-container">
                                <div class="agenda-day mb-4 border p-3 rounded" data-day-index="0">
                                    <div class="agenda-heder d-flex justify-content-between align-items-center">
                                        <h4 class="mb-3 ">Agenda Day </h4>
                                        <span class="float-end d-flex align-items-center">
                                            <button type="button" class="btn btn-sm text-decoration-none toggle-agenda-day" data-bs-toggle="collapse" data-bs-target="#agenda-day-0-content" aria-expanded="true">
                                                <span class="dropdown-icon" aria-hidden="true">⮟</span> <!-- Dropdown icon -->
                                            </button>
                                        </span>
                                    </div>
                                    <div id="agenda-day-0-content" class="collapse show">
                                        <div class="row ">
                                            <div class="col-6">
                                                <label for="agenda[0][date]" class="form-label">Date *</label>
                                                <input type="date" name="agenda[0][date]" class="form-control" value="{{ old('agenda.0.date') }}" required>
                                            </div>
                                            <div class="col-6">
                                                <label for="agenda[0][date_name]" class="form-label">Date Name *</label>
                                                <input type="text" name="agenda[0][date_name]" class="form-control" value="{{ old('agenda.0.date_name') }}" maxlength="255" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <label for="agenda[0][is_active]" class="form-label">Is Active *</label>
                                                <select name="agenda[0][is_active]" class="form-select" required>
                                                    <option value="active" {{ old('agenda.0.is_active') == 'active' ? 'selected' : '' }}>Yes</option>
                                                    <option value="inactive" {{ old('agenda.0.is_active') == 'inactive' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="agenda-details-container ">
                                            <div class="mt-3 border p-2 mb-3 rounded">
                                                <div class="agenda-heder d-flex justify-content-between align-items-center ">
                                                    <h6 class="mb-2">Agenda Details 1</h6>
                                                    <span>
                                                        <button type="button" class="btn btn-sm text-decoration-none toggle-agenda-day" data-bs-toggle="collapse" data-bs-target="#agenda-details-0-content" aria-expanded="true">
                                                            <span class="dropdown-icon" aria-hidden="true">⮟</span> <!-- Dropdown icon -->
                                                        </button>
                                                    </span>
                                                </div>
                                                <div id="agenda-details-0-content" class="collapse show">
                                                    <div class="agenda-detail" data-detail-index="0">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="agenda[0][details][0][time]" class="form-label">Time *</label>
                                                                <input type="time" name="agenda[0][details][0][time]" class="form-control" value="{{ old('agenda.0.details.0.time') }}" value="{{ old('agenda.0.details.0.time') }}" required >
                                                            </div>
                                                            <div class="col">
                                                                <label for="agenda[0][details][0][title]" class="form-label">Title *</label>
                                                                <input type="text" name="agenda[0][details][0][title]" class="form-control" value="{{ old('agenda.0.details.0.title') }}" required maxlength="255" value="{{ old('agenda.0.details.0.title') }}">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 mt-2">
                                                            <label for="agenda[0][details][0][description]" class="form-label">Description</label>
                                                            <textarea name="agenda[0][details][0][description]" class="form-control" rows="3" maxlength="255">{{ old('agenda.0.details.0.description') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Add More Agenda Details -->
                                    </div>
                                    <button type="button" class="btn btn-sm btn-secondary add-agenda-detail mt-1">+ Add Agenda Detail</button>
                                </div>
                            </div>
                        <div style="float: left;">
                            <!-- Add Another Day -->
                            <button type="button" class="btn btn-primary add-agenda-day">+ Add Another Day</button>
                        </div>
                        <!-- Submit Button -->
                        <div  style="float: right;">
                            <button type="submit" class="btn btn-success from-prevent-multiple-submits" id="saveBtn">Save Agenda</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template for Agenda Day -->
<div id="agenda-day-template" class="d-none">
    <div class="agenda-day" data-day-index="__DAY_INDEX__">
        <div class="mb-4 border p-3 rounded">
            <div class="agenda-heder d-flex justify-content-between align-items-center">
                <h4 class="mb-3">Agenda Day</h4>
                <span class="float-end d-flex align-items-center">
                    <button type="button" class="btn btn-sm text-decoration-none toggle-agenda-day" data-bs-toggle="collapse" data-bs-target="#agenda-__DAY_INDEX__" aria-expanded="true">
                        <span class="dropdown-icon" aria-hidden="true">⮟</span>
                    </button>
                    <button type="button" id="remove-agenda-day-__DAY_INDEX__" class="btn btn-sm  remove-agenda-day text-pinterest">X</button>
                </span>
            </div>
            <div id="agenda-__DAY_INDEX__" class="collapse show">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Date *</label>
                        <input type="date" name="agenda[__DAY_INDEX__][date]" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Date Name *</label>
                        <input type="text" name="agenda[__DAY_INDEX__][date_name]" class="form-control" maxlength="255" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <label class="form-label">Is Active *</label>
                        <select name="agenda[__DAY_INDEX__][is_active]" class="form-select" required>
                            <option value="active">Yes</option>
                            <option value="inactive">No</option>
                        </select>
                    </div>
                </div>
                <div class="agenda-details-container mt-2">
                    {{-- <h6 class="mb-2">Agenda Details</h6> --}}
                </div>
                <button type="button" class="btn btn-sm btn-secondary add-agenda-detail mt-1">+ Add Agenda Detail</button>
            </div>
        </div>
    </div>
</div>
{{-- <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<!-- Choices.js -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
// Initialize Choices for the Event dropdown
const orderIdChoice = new Choices('#event_id', {
    placeholder: true,
    searchEnabled: true,
});

$(document).ready(function() {
    // Event change handler
    $('#event_id').change(function() {
        var eventId = $(this).val();
        var eventData = @json($events);
        var selectedEvent = eventData.find(event => event.eid == eventId);
        if (selectedEvent) {
            $('#event_start_date').val(selectedEvent.start_datetime);
            $('#event_end_date').val(selectedEvent.end_datetime);
        }
    });
});

let dayCounter = 1;
let dayIndex = 2;
let detailsCounter = 2;

// Add another agenda day
document.querySelector('.add-agenda-day').addEventListener('click', function () {
    const template = document.querySelector('#agenda-day-template').innerHTML;
    const container = document.querySelector('#agenda-days-container');
    const newDayHtml = template.replace(/__DAY_INDEX__/g, dayCounter);
    const newDay = document.createElement('div');
    newDay.innerHTML = newDayHtml;
    container.appendChild(newDay.firstElementChild);
    dayCounter++;
    dayIndex++;
});

// Add agenda detail
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('add-agenda-detail')) {
        const agendaDay = e.target.closest('.agenda-day');
        const detailsContainer = agendaDay.querySelector('.agenda-details-container');
        const dayIndex = agendaDay.getAttribute('data-day-index');

        // Calculate the new detail index based on the number of details for this specific day
        const detailIndex = detailsContainer.querySelectorAll('.agenda-detail').length;
        const detailTemplate = `
        <div class="agenda-detail border p-2 mb-3 rounded" data-detail-index="${detailIndex}">
            <div class="agenda-header d-flex justify-content-between align-items-center">
                <h6 class="mb-2">Agenda Details ${detailsCounter}</h6>
                <span class="float-end d-flex align-items-center">
                    <button type="button" class="btn btn-sm text-decoration-none toggle-agenda-day" data-bs-toggle="collapse" data-bs-target="#agenda_${dayIndex}_details_${detailIndex}" aria-expanded="true">
                        <span class="dropdown-icon" aria-hidden="true">⮟</span> <!-- Dropdown icon -->
                    </button>
                    <button type="button" class="btn btn-sm remove-agenda-detail text-pinterest">X</button>
                </span>
            </div>
            <div id="agenda_${dayIndex}_details_${detailIndex}" class="collapse show">
                <div class="row">
                    <div class="col">
                        <label for="agenda_${dayIndex}_details_${detailIndex}_time" class="form-label">Time *</label>
                        <input type="time" name="agenda[${dayIndex}][details][${detailIndex}][time]" id="agenda_${dayIndex}_details_${detailIndex}_time" class="form-control" required  value="{{ old('agenda.${dayIndex}.details.${detailIndex}.time') }}">
                    </div>
                    <div class="col">
                        <label for="agenda_${dayIndex}_details_${detailIndex}_title" class="form-label">Title *</label>
                        <input type="text" name="agenda[${dayIndex}][details][${detailIndex}][title]" id="agenda_${dayIndex}_details_${detailIndex}_title" class="form-control" maxlength="255" required value="{{ old('agenda.${dayIndex}.details.${detailIndex}.title') }}">
                    </div>
                </div>
                <div class="mb-3 mt-2">
                    <label for="agenda_${dayIndex}_details_${detailIndex}_description" class="form-label">Description</label>
                    <textarea name="agenda[${dayIndex}][details][${detailIndex}][description]" id="agenda_${dayIndex}_details_${detailIndex}_description" class="form-control" rows="3" maxlength="255">{{ old('agenda.${dayIndex}.details.${detailIndex}.description') }}</textarea>
                </div>
            </div>
        </div>
        `;

        detailsContainer.insertAdjacentHTML('beforeend', detailTemplate);
        detailsCounter++;
    }
});
// Remove agenda day
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-agenda-day')) {
        e.target.closest('.agenda-day').remove();
        dayIndex--;
    }
});
// Remove agenda detail
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-agenda-detail')) {
        const agendaDetail = e.target.closest('.agenda-detail');
        if (agendaDetail) {
            agendaDetail.remove();
            detailsCounter--;
        }
    }
});

document.getElementById('saveBtn').addEventListener('click', function () {
    // Event validation
    const eventSelect = document.getElementById('event_id');
    if (eventSelect.value === '') {
        document.getElementById('eventError').textContent = 'Please select an event';
    } else {
        document.getElementById('eventError').textContent = '';
    }

    // Date validation
    const startDate = document.getElementById('event_start_date');
    const endDate = document.getElementById('event_end_date');
    if (startDate.value === '') {
        document.getElementById('startDateError').textContent = 'Please select the event start date';
    } else {
        document.getElementById('startDateError').textContent = '';
    }
    if (endDate.value === '') {
        document.getElementById('endDateError').textContent = 'Please select the event end date';
    } else {
        document.getElementById('endDateError').textContent = '';
    }

    // Agenda days validation
    const agendaDays = document.querySelectorAll('.agenda-day');
    let isValid = true;
    agendaDays.forEach((day, index) => {
        const dateInput = day.querySelector(`[name="agenda[${index}][date]"]`);
        const dateNameInput = day.querySelector(`[name="agenda[${index}][date_name]"]`);
        const isActivitySelect = day.querySelector(`[name="agenda[${index}][is_active]"]`);

        if (dateInput.value === '') {
            document.getElementById(`agendaDay${index}DateError`).textContent = 'Please enter the agenda day date';
            isValid = false;
        } else {
            document.getElementById(`agendaDay${index}DateError`).textContent = '';
        }

        if (dateNameInput.value === '') {
            document.getElementById(`agendaDay${index}DateNameError`).textContent = 'Please enter the agenda day name';
            isValid = false;
        } else {
            document.getElementById(`agendaDay${index}DateNameError`).textContent = '';
        }

        if (isActivitySelect.value === '') {
            document.getElementById(`agendaDay${index}ActivityError`).textContent = 'Please select whether it is an activity';
            isValid = false;
        } else {
            document.getElementById(`agendaDay${index}ActivityError`).textContent = '';
        }
    });

    // Agenda details validation
    const agendaDetails = document.querySelectorAll('.agenda-detail');
    agendaDetails.forEach((detail, index) => {
        const timeInput = detail.querySelector(`[name="agenda[${detail.getAttribute('data-day-index')}][details][${index}][time]"]`);
        const titleInput = detail.querySelector(`[name="agenda[${detail.getAttribute('data-day-index')}][details][${index}][title]"]`);
        const descriptionTextarea = detail.querySelector(`[name="agenda[${detail.getAttribute('data-day-index')}][details][${index}][description]"]`);

        if (timeInput.value === '') {
            document.getElementById(`agendaDetail${index}TimeError`).textContent = 'Please enter the time for this detail';
            isValid = false;
        } else {
            document.getElementById(`agendaDetail${index}TimeError`).textContent = '';
        }

        if (titleInput.value === '') {
            document.getElementById(`agendaDetail${index}TitleError`).textContent = 'Please enter a title for this detail';
            isValid = false;
        } else {
            document.getElementById(`agendaDetail${index}TitleError`).textContent = '';
        }

        if (descriptionTextarea.value === '') {
            document.getElementById(`agendaDetail${index}DescriptionError`).textContent = 'Please enter a description for this detail';
            isValid = false;
        } else {
            document.getElementById(`agendaDetail${index}DescriptionError`).textContent = '';
        }
    });

    if (!isValid) {
        return;
    }

    // Disable the button to prevent multiple submissions
    this.disabled = true;

    // Submit the form
    this.form.submit();
});

</script>
@endsection
