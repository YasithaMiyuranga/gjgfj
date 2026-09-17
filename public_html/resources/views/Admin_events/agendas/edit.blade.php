@extends('layouts.events')
@section('page-title', 'Agenda')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.ticket.coupon.list') }}">{{ __('Coupon List') }}</a>
        <li class="breadcrumb-item active">{{ __('Edit Agenda') }}</li>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Edit Agenda</h3>
            </div>
            <hr>
            <div class="card-body table-border-style">
                <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                <!-- Form for editing an agenda -->
                <form action="{{ route('useradmin.agenda.update', $agenda->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="agenda_id" value="{{ $agenda->id }}">
                    <!-- Event Selection -->
                    <div class="mb-4">
                        <label for="event_id" class="form-label">Event</label>
                        <input type="hidden" name="event_id" value="{{ $agenda->event_id }}">
                        <input type="text" class="form-control" value="{{ $event->event_name}}" readonly>
                    </div>
                    <!-- Event Dates -->
                    <div class="row">
                        <div class="col-md-6 mb-6">
                            <label for="event_start_date" class="form-label">Event Start Date/Time</label>
                            <input type="text" name="event_start_date" id="event_start_date" class="form-control" value="{{ old('event_start_date', $event->start_datetime) }}" readonly>
                        </div>

                        <div class="col-md-6 mb-6">
                            <label for="event_end_date" class="form-label">Event End Date/Time</label>
                            <input type="text" name="event_end_date" id="event_end_date" class="form-control" value="{{ old('event_end_date', $event->end_datetime) }}" readonly>
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
                            <div id="agenda-day-0-content" class="collapse show mb-3">
                                <div class="row">
                                    <!-- Date -->
                                    <div class="col-6">
                                        <label for="agenda[0][date]" class="form-label">Date *</label>
                                        <input type="date" name="agenda[0][date]" class="form-control" value="{{ old('agenda.0.date', $agenda->date) }}" required>
                                    </div>
                                    <!-- Date Name -->
                                    <div class="col-6">
                                        <label for="agenda[0][date_name]" class="form-label">Date Name *</label>
                                        <input type="text" name="agenda[0][date_name]" class="form-control" value="{{ old('agenda.0.date_name', $agenda->date_name) }}" maxlength="255" required>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <!-- Is Active -->
                                    <div class="col-6">
                                        <label for="agenda[0][is_active]" class="form-label">Is Active *</label>
                                        <select name="agenda[0][is_active]" class="form-select" required>
                                            <option value="active" {{ old('agenda.0.is_active', $agenda->is_active) == 'active' ? 'selected' : '' }}>Yes</option>
                                            <option value="inactive" {{ old('agenda.0.is_active', $agenda->is_active) == 'inactive' ? 'selected' : '' }} >No</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Agenda Details -->
                                <div class="agenda-details-container">
                                    @foreach ($agenda->agendaDetails as $key => $detail)
                                        <div class="mt-3 agenda-detail data-detail-index= {{ $key }}, data-detail-id={{ $detail->id }}">
                                            <div class="mt-3 border p-2 mb-3 rounded">
                                                <div class="agenda-heder d-flex justify-content-between align-items-center ">
                                                    <h6 class="mb-2">Agenda Details</h6>
                                                    <span>
                                                        <button type="button" class="btn btn-sm text-decoration-none toggle-agenda-day" data-bs-toggle="collapse" data-bs-target="#agenda-detail-{{ $key }}" aria-expanded="true">
                                                            <span class="dropdown-icon" aria-hidden="true">⮟</span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm remove-agenda-detail text-pinterest" style="float: right;">X</button>
                                                    </span>
                                                </div>
                                                <div id="agenda-detail-{{ $key }}" class="collapse show">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="agenda[0][details][{{ $key }}][time]" class="form-label">Time *</label>
                                                            <input type="time" name="agenda[0][details][{{ $key }}][time]" class="form-control" value="{{ old('agenda.0.details.'.$key.'.time', $detail->time) }}" required>
                                                        </div>
                                                        <div class="col">
                                                            <label for="agenda[0][details][{{ $key }}][title]" class="form-label">Title *</label>
                                                            <input type="text" name="agenda[0][details][{{ $key }}][title]" class="form-control" value="{{ old('agenda.0.details.'.$key.'.title', $detail->title) }}" required maxlength="255">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 mt-2">
                                                        <label for="agenda[0][details][{{ $key }}][description]" class="form-label">Description</label>
                                                        <textarea name="agenda[0][details][{{ $key }}][description]" class="form-control" rows="3" maxlength="255">{{ old('agenda.0.details.'.$key.'.description', $detail->description) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                                <!-- Add More Agenda Details -->
                                <button type="button" class="btn btn-sm btn-secondary add-agenda-detail">+ Add Agenda Detail</button>
                        </div>
                    </div>
                    {{-- <div style="float: left;">
                        <!-- Add Another Day -->
                        <button type="button" class="btn btn-primary add-agenda-day">+ Add Another Day</button>
                    </div> --}}
                    <!-- Submit Button -->
                    <div  style="float: right;">
                        <button type="submit" class="btn btn-success">Update Agenda</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Template for Agenda Day -->
{{-- <div id="agenda-day-template" class="d-none">
    <div class="agenda-day mb-4 border p-3 rounded" data-day-index="__DAY_INDEX__">
        <h4 class="mb-3">Agenda Day __DAY_INDEX__</h4>
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
        <div class="row">
            <div class="col-6">
                <label class="form-label">Is Active *</label>
                <select name="agenda[__DAY_INDEX__][is_active]" class="form-select" required>
                    <option value="active">Yes</option>
                    <option value="inactive">No</option>
                </select>
            </div>
        </div>
        <div class="agenda-details-container">
            <h6 class="mb-2">Agenda Details</h6>
        </div>
        <button type="button" class="btn btn-sm btn-secondary add-agenda-detail">+ Add Agenda Detail</button>
    </div>
</div> --}}
<script>

// let dayCounter = 1;

// // Add another agenda day
// document.querySelector('.add-agenda-day').addEventListener('click', function () {
//     const template = document.querySelector('#agenda-day-template').innerHTML;
//     const container = document.querySelector('#agenda-days-container');
//     const newDayHtml = template.replace(/__DAY_INDEX__/g, dayCounter);
//     const newDay = document.createElement('div');
//     newDay.innerHTML = newDayHtml;
//     container.appendChild(newDay.firstElementChild);
//     dayCounter++;
// });

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
                <h6 class="mb-2">Agenda Details</h6>
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
                        <label for="agenda[${dayIndex}][details][${detailIndex}][time]" class="form-label">Time *</label>
                        <input type="time" name="agenda[${dayIndex}][details][${detailIndex}][time]" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="agenda[${dayIndex}][details][${detailIndex}][title]" class="form-label">Title *</label>
                        <input type="text" name="agenda[${dayIndex}][details][${detailIndex}][title]" class="form-control" maxlength="255" required>
                    </div>
                </div>
                <div class="mb-3 mt-2">
                    <label for="agenda[${dayIndex}][details][${detailIndex}][description]" class="form-label">Description</label>
                    <textarea name="agenda[${dayIndex}][details][${detailIndex}][description]" class="form-control" rows="3" maxlength="255"></textarea>
                </div>
            </div>
        </div>
        `;

        detailsContainer.insertAdjacentHTML('beforeend', detailTemplate);
    }
});
// Remove agenda detail
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-agenda-detail')) {
        const agendaDetail = e.target.closest('.agenda-detail');
        if (agendaDetail) {
            agendaDetail.remove();
        }
    }
});
</script>
@endsection
