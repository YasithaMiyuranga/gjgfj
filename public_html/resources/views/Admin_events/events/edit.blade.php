@extends('layouts.events')
@section('page-title', __('Events'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.events_list') }}">{{ __('Events List') }}</a>
    <li class="breadcrumb-item active">{{ __('Edit Event') }}</li>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Edit Event</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="post" action="{{ route('useradmin.events.event_update', [$event->eid]) }}"
                        enctype="multipart/form-data" id="EventEditForm">
                        @csrf
                        <div id="dineInSection1" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_name" class="form-label">{{ 'Event Name' }}: *</label>
                                    <x-input value="{{ old('event_name') ?? $event->event_name }}" id="event_name"
                                        name="event_name" class="form-control" type="text" required />
                                    @error('event_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location" class="form-label">{{ 'Location' }}: *</label>
                                    <x-input value="{{ old('location') ?? $event->location }}" id="location"
                                        name="location" class="form-control" type="text" required />
                                    @error('location')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="margin" class="form-label"> Margin (in %):</label>
                                    <input type="number" class="form-control" name="margin" id="margin" min="1"
                                        value="{{ old('margin', $event->margin) }}">
                                    @error('margin')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="dineInSection1" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_time" class="form-label">{{ 'Event Start Time' }}: *</label>
                                    <x-input value="{{ $event->start_datetime }}" id="start_time" name="start_time"
                                        class="form-control" type="text" required />
                                    @error('start_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_time" class="form-label">{{ 'Event End Time' }}: *</label>
                                    <x-input value="{{ $event->end_datetime }}" id="end_time" name="end_time"
                                        class="form-control" type="text" required />
                                    <span class="text-danger" id="end_timeError"></span>
                                    @error('end_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="dineInSection1" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_date" class="form-label">{{ 'Event Date' }}: *</label>
                                    <x-input value="{{ $event->event_date }}" id="event_date" name="event_date"
                                        class="form-control" type="text" required />
                                    <span class="text-danger" id="eventdateError"></span>
                                    @error('event_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>




                            {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_manager" class="form-label">{{ 'Event Manager' }}: *</label>
                                <x-input value="{{ $event->event_manager }}" id="event_manager" name="event_manager"
                                    class="form-control" type="text" required />
                                @error('event_manager')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}

                            <div class="col-md-6">


                                <label class="form-label " for="manager">{{ 'Manager *' }}</label>

                                <select name="event_manager_id" id="manager_id" class="form-control" required>
                                    <option value="">Select Manager</option>
                                    @foreach ($managers as $manager)
                                        <option
                                            {{ optional($event->manager)->manager_id == $manager->manager_id ? 'selected' : '' }}
                                            value="{{ $manager->manager_id }}">
                                            {{ $manager->name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span class="text-danger" id="managerError">{{ $errors->first('manager') }}</span>
                            </div>


                        </div>
                        <div id="dineInSection1" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_type" class="form-label">{{ 'Event Type' }}: *</label>
                                    <select id="event_type" name="event_type" class="form-control" required>
                                        <option value="Indoor" {{ $event->type == 'Indoor' ? 'selected' : '' }}>Indoor
                                        </option>
                                        <option value="Outdoor" {{ $event->type == 'Outdoor' ? 'selected' : '' }}>Outdoor
                                        </option>
                                    </select>
                                    @error('event_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="category">{{ 'Event Category *' }}</label>
                                    <select class="form-control select2" name="category" id="category" required>
                                        @foreach ($categoryNames as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category') == $category->category_name ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="dineInSection1" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">{{ 'State *' }}</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="Ongoing"
                                            {{ old('status') == 'Ongoing' ? 'selected' : ($event->status == 'Ongoing' ? 'selected' : '') }}>
                                            Ongoing</option>
                                        <option value="Completed"
                                            {{ old('status') == 'Completed' ? 'selected' : ($event->status == 'Completed' ? 'selected' : '') }}>
                                            Completed
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_no" class="form-label">{{ 'Phone Number' }}: *</label>
                                    <x-input value="{{ $event->contact_no }}" id="phone_no" name="phone_no"
                                        class="form-control" type="text" required />
                                    @error('phone_no')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="dineInSection1" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Logo" class="form-label">{{ 'Logo' }}</label><br>
                                    <span style="color:rgb(207, 208, 218);">If you want to update the Logo, insert
                                        only.<br>Size
                                        (600x400)</span>
                                    </label>
                                    <x-input value="{{ asset('public/uploads/events/logo/' . $event->logo) }}"
                                        id="Logo" name="Logo" class="form-control" type="file"
                                        accept=".jpeg,.png,.jpg,.gif,.svg,.jfif" />
                                    <div id="logoError" class="error-message"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="banner" class="form-label">{{ 'Banner' }}</label><br>
                                    <label for="banner" class="form-label"><span style="color:rgb(207, 208, 218);">If
                                            you want
                                            to update the Banner, insert only<br>Size(1920x1080)</span></label>
                                    <x-input value="{{ asset('public/uploads/events/banner/' . $event->banner) }}"
                                        id="banner" name="banner" class="form-control" type="file"
                                        accept=".jpeg,.png,.jpg,.gif,.svg,.jfif" />
                                    <div id="bannerError" class="error-message"></div>
                                </div>
                            </div>
                        </div>
                        <div id="dineInSection2" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_public" class="form-label">Visible to Users *</label>
                                    <select class="form-control" name="is_public" id="is_public" required>
                                        <option
                                            value="1"{{ old('is_public') == '1' ? 'selected' : '' }}{{ $event->is_public == '1' ? 'selected' : '' }}>
                                            Yes</option>
                                        <option
                                            value="0"{{ old('is_public') == '0' ? 'selected' : '' }}{{ $event->is_public == '0' ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                    @error('is_public')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="details-docs" class="form-label">Details Docs:</label><br>
                                    @if ($event->details_docs)
                                        <label for="details-docs" class="form-label"><span
                                                style="color:rgb(207, 208, 218);">If you want
                                                to update the Details Docs, insert only</span></label>
                                    @endif
                                    <input class="form-control" name="details_docs" type="file" id="details-docs"
                                        accept=".jpeg,.png,.jpg,.gif,.svg,.jfif,.pdf,.docx,.doc">
                                    @error('details_docs')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="dineInSection2" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="artistname" class="form-label">Artist Name:</label>
                                    <select class="form-control select2" name="artistname[]" multiple>
                                        @foreach ($artists as $artist)
                                            <option value="{{ $artist->artist_name }}"
                                                {{ in_array($artist->artist_name, $event->artists->pluck('artist_name')->toArray()) ? 'selected' : '' }}>
                                                {{ $artist->artist_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Sponsor" class="form-label">Sponsor:</label>
                                    <select class="form-control select2" name="sponsor[]" multiple>
                                        <option value="">Select Sponsor</option>
                                        @foreach ($sponsors as $sponsor)
                                            <option value="{{ $sponsor->sponsor_id }}"
                                                {{ in_array($sponsor->sponsor_id, $event->sponsors->pluck('sponsor_id')->toArray()) ? 'selected' : '' }}>
                                                {{ $sponsor->sponsor_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="taskTemplateSection1" class="row">
                            <div class="col-md-6">
                                <div class="form-group d-flex flex-column">
                                    <label for="taskTemplate" class="form-label">Task Template:</label>
                                    <select class="form-control select2" name="task_template_id" id="taskTemplate">
                                        <option value="">Select Task Template</option>
                                        @foreach ($taskTemplates as $taskTemplate)
                                            @php
                                                $isV2 = Str::contains($taskTemplate->template_name, '(v2)');
                                            @endphp

                                            @if ($taskTemplate->id == $event->task_template_id || !$isV2)
                                                <option value="{{ $taskTemplate->id }}"
                                                    {{ $taskTemplate->id == $event->task_template_id ? 'selected' : '' }}>
                                                    {{ $taskTemplate->template_name }}
                                                </option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="dineInSection1" class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">{{ 'Description' }}: *</label>
                                    <textarea class="form-control" name="description" id="description" required>{{ old('description', $event->des) }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="dineInSection2" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location" class="form-label">{{ 'Location' }}: *</label>
                                    <x-input value="{{ old('location') ?? $event->location }}" id="locationInput"
                                        name="location" class="form-control" type="text" required />
                                    @error('location')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="button" id="getLocationButton" class="btn btn-primary">Show Map</button>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="map" class="form-label">Map:</label>
                                    <iframe
                                        src="{{ old('map', $event->location ? 'https://www.google.com/maps?q=' . urlencode($event->location) . '&output=embed' : '') }}"
                                        id="mapIframe" width="100%" height="300" style="border:0" allowfullscreen
                                        loading="lazy">
                                    </iframe>
                                </div>
                            </div>
                            <h3>
                                <center><b>Customer Care Option</b></center>
                            </h3>

                            <div id="dineInSectionAddress" class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address" class="form-label">Address: </label>
                                        <input type="text" class="form-control" name="address" id="address"
                                            value="{{ old('address', $customerCare ? $customerCare->address : '') }}">
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="whatsapp_no" class="form-label">WhatsApp No: </label>
                                        <input type="number" class="form-control" name="whatsapp_no" id="whatsapp_no"
                                            value="{{ old('whatsapp_no', $customerCare ? $customerCare->whatsapp_number : '') }}">
                                        @error('whatsapp_no')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div id="dineInSectionEmail" class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email: </label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ old('email', $customerCare ? $customerCare->email : '') }}">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-block mt-2"
                                        type="submit">{{ __('Update Event') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Include jQuery before Select2 scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        document.getElementById('getLocationButton').addEventListener('click', function() {
            const query = document.getElementById('locationInput').value;
            if (query.trim() !== "") {
                const url = `https://www.google.com/maps?q=${encodeURIComponent(query)}&output=embed`;
                document.getElementById("mapIframe").src = url;
            }
        });
        $('#category').on('select2:select', function(e) {
            // Show the task template section
            document.getElementById('taskTemplateSection');
            const selectedCategory = e.params.data.id;
            $.ajax({
                url: '{{ route('useradmin.getTaskTemplates') }}',
                method: 'GET',
                data: {
                    category: selectedCategory
                },
                success: function(response) {

                    const taskTemplateSelect = document.getElementById('taskTemplate');
                    // Remove all existing options
                    taskTemplateSelect.innerHTML = '';
                    // Add the default "Select Event" option
                    var defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Select Task Template";
                    taskTemplateSelect.appendChild(defaultOption);
                    response.forEach(function(template) {
                        const option = document.createElement('option');
                        option.value = template.id;
                        option.textContent = template.template_name;
                        taskTemplateSelect.appendChild(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
        // Initialize Flatpickr
        flatpickr("#start_time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            //defaultDate: "today",
            minuteIncrement: 15,
            onClose: function(selectedDates, dateStr, instance) {
                updateEndTimePicker(dateStr);
                updateEventDate(selectedDates[0]);

            }

        });

        flatpickr("#end_time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            //defaultDate: "today",
            minuteIncrement: 15
        });

        flatpickr("#event_date", {
            enableTime: false,
            dateFormat: "Y-m-d"
        });

        function updateEndTimePicker(minTime) {
            flatpickr("#end_time", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                defaultDate: minTime,
                minuteIncrement: 15
            });

        }

        // Update event date
        function updateEventDate(startTime) {
            // Extract the date part from the start time
            var bookingDate = startTime.toISOString().split('T')[0];
            // Set the event date input value
            document.getElementById('event_date').value = bookingDate;
        }

        // Initialize Select2 for multiple Artists names
        $('.select2').select2({
            Multiple: true,
        });


        //Phone Number validation
        document.getElementById('phone_no').addEventListener('input', function(e) {
            const phoneInput = e.target;
            const phonePattern = /^[0-9]{10}$/; // Adjust this pattern based  phone number format

            if (phoneInput.value === '') {
                phoneInput.setCustomValidity('Phone number is required');
            } else if (phonePattern.test(phoneInput.value)) {
                phoneInput.setCustomValidity('');
            } else {
                phoneInput.setCustomValidity('Invalid phone number');
            }
        });
        // whatsapp number validation
        document.getElementById('whatsapp_no').addEventListener('input', function(e) {
            const phoneInput = e.target;
            const phonePattern = /^[0-9]{10}$/; // Adjust this pattern based  phone number format

            if (phonePattern.test(phoneInput.value)) {
                phoneInput.setCustomValidity('');
            } else {
                phoneInput.setCustomValidity('Invalid Whatsapp number');
            }
        })

        //Check Logo and Banner size check
        document.getElementById('dineInSection2').addEventListener('input', function(event) {
            event.preventDefault();
            validateImages();
        });

        function validateImages() {
            var logoInput = document.getElementById('Logo');
            var bannerInput = document.getElementById('banner');

            validateImageSize(logoInput, 600, 400, 'logoError');
            validateImageSize(bannerInput, 1920, 1080, 'bannerError');
        }

        function validateImageSize(input, expectedWidth, expectedHeight, errorElementId) {
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = new Image();
                img.onload = function() {
                    if (this.width !== expectedWidth || this.height !== expectedHeight) {
                        document.getElementById(errorElementId).textContent =
                            `Please upload an image with dimensions ${expectedWidth}x${expectedHeight}.`;
                    } else {
                        document.getElementById(errorElementId).textContent = '';
                    }
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        // Check validation
        function checkValidation() {
            var isValid = true;

            $('#eventdateError').text('');
            $('#end_timeError').text('');

            // Check if event_date matches start_event date
            var startDatetime = $('#start_time').val().split(' ')[0];
            var eventDate = $('#event_date').val();
            if (eventDate !== startDatetime) {
                // Display an error message
                $('#eventdateError').text('Event Date should match Event Start Date.');
                isValid = false;
            }
            // Check if end_time is after start_time
            var startTime = $('#start_time').val();
            var endTime = $('#end_time').val();
            if (endTime < startTime) {
                // Display an error message
                $('#end_timeError').text('End Time should be after Start Time.');
                isValid = false;
            }

            return isValid;
        }

        // Order Form submission
        document.getElementById('EventEditForm').addEventListener('submit', function(event) {
            event.preventDefault();
            //  Check validation and submit the form
            if (checkValidation()) {
                // Submit the form if validation is successful
                document.getElementById('EventEditForm').submit();
            }
        })
    </script>
@endsection
