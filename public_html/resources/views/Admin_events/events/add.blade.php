@extends('layouts.events')
@section('page-title', __('Events'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.agents_list') }}">{{ __('Create Event') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Create Event</h3>
            </div>
            <hr>
            <div class="card-body table-border-style">
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <form method="post" action="{{ route('useradmin.events.event_store') }}" id="orderForm" enctype="multipart/form-data">
                    @csrf
                    <?php
                    $user = Auth::user();
                    ?>
                    <div class="row">
                        <div class="col-md-6"><b>Date: {{ date('Y F d') }}</b></div>
                        <div class="col-md-6"><b>Time: {{ date('h:i A') }}</b></div>
                    </div>
                    <br>
                    <div id="dineInSection1" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_name" class="form-label">Event Name: *</label>

                                <input type="text" class="form-control" name="event_name" id="event_name" required
                                    value="{{ old('event_name') }}">
                                @error('event_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="margin" class="form-label"> Margin (in %):</label>
                                <input type="number" class="form-control" name="margin" id="margin" min="1"
                                    value="{{ old('margin') }}">
                                @error('margin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="dineInSection1" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="evenstartdate" class="form-label">Event Start Time: *</label>
                                <input type="text" class="form-control" name="start_time" id="start_time" required
                                    value="{{ old('start_time') }}">
                                @if ($errors->has('start_time'))
                                    <span class="text-danger" id="start_timeError">{{ $errors->first('start_time') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eventenddate" class="form-label">Event End Time: *</label>
                                <input type="text" class="form-control" name="end_time" id="end_time" required
                                    value="{{ old('end_time') }}">
                                <span class="text-danger" id="end_timeError"></span>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger" id="end_timeError">{{ $errors->first('end_time') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="dineInSection1" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eventdate" class="form-label">Event Date: *</label>
                                <input type="text" class="form-control" name="eventdate" id="eventdate" required
                                    value="{{ old('eventdate') }}">
                                <span class="text-danger" id="eventdateError"></span>
                                @error('eventdate')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_manager" class="form-label">Event Manager: *</label>
                                <input type="text" class="form-control" name="event_manager" id="event_manager" required
                                    value="{{ old('event_manager') }}">
                                @error('event_manager')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-md-6">


                            <label class="form-label " for="manager">{{ 'Manager *' }}</label>


                            {{-- <button class="btn btn-sm mb-3 btn-primary me-2" data-url="{{ route('useradmin.man.add') }}" data-size="lg"
                                data-ajax-popup="true" data-title="{{ __('') }}">
                                <i class="ti ti-plus py-1" title="Add Manager"></i> {{ __('') }}
                            </button> --}}

                            <select name="event_manager_id" id="manager_id" class="form-control" required>
                                <option value="">Select Manager</option>
                                @foreach ($managers as $manager)
                                    <option value="{{ $manager->manager_id }}" {{ old('manager_id') == $manager->manager_name ? 'selected' : '' }}>{{ $manager->name }}</option>
                                @endforeach
                            </select>
                            @error('manager_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            <span class="text-danger" id="managerError">{{ $errors->first('manager') }}</span>
                        </div>


{{--
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="category" class="form-label">Event Category: *</label>
                                <select class="form-control select2" name="category" id="category" required>
                                    @foreach ($categoryNames as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category') == $category->category_name ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div> --}}



                    </div>

                    <div id="dineInSection1" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_type" class="form-label">Event Type: *</label>
                                <select class='form-control select' name='event_type' id='event_type' required>
                                    <option value="Indoor"{{ old('event_type') == 'Indoor' ? 'selected' : '' }}>Indoor</option>
                                    <option value="Outdoor"{{ old('event_type') == 'Outdoor' ? 'selected' : '' }}>Outdoor</option>
                                </select>
                                @error('event_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="category" class="form-label">Event Category: *</label>
                                <select class="form-control select2" name="category" id="category" required>
                                    <option value="">Select Category</option>
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
                                <label for="phone_no" class="form-label">Phone No: *</label>
                                <input type="number" class="form-control" name="phone_no" id="phone_no" required
                                    value="{{ old('phone_no') }}">
                                @error('phone_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="state">{{ __('State *') }}</label>
                                <select id="state" name="state" class="form-control" required>
                                    <option value="Ongoing " {{ old('state') == 'Ongoing ' ? 'selected' : '' }}>
                                        {{ 'Ongoing' }}</option>
                                    <option value="Completed" {{ old('state') == 'Completed' ? 'selected' : '' }}>
                                        {{ 'Completed' }}</option>
                                </select>
                                @error('state')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="dineInSection2" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Logo" class="form-label">{{ __('Logo: *') }} <br>
                                    <span style="color:rgb(207, 208, 218);">Size(600x400)</span></label>
                                <input class="form-control" name="Logo" type="file"
                                    id="Logo"accept=".jpeg,.png,.jpg,.gif,.svg,.jfif" required>
                                <div id="logoError" class="error-message"style="color: #ec0a0a;"></div>
                                @error('Logo')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="banner" class="form-label">{{ __('Banner: *') }} <br>
                                    <span style="color:rgb(207, 208, 218);">Size(1920x1080)</span></label>
                                <input class="form-control" name="banner" type="file" id="banner"
                                    accept=".jpeg,.png,.jpg,.gif,.svg,.jfif" required>
                                <div id="bannerError" class="error-message" style="color: #ec0a0a;"></div>
                                @error('banner')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="dineInSection2" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="is_public" class="form-label">Visible to Users *</label>
                                <select class="form-control" name="is_public" id="is_public" required>
                                    <option value="1"{{ old('is_public') == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0"{{ old('is_public') == '0' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('is_public')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="details-docs" class="form-label">Details Docs:</label>
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
                                <select class="form-control select2" name="artistname[]" id="artistname" multiple>
                                    @foreach ($artists as $artist)
                                        <option value="{{ $artist->artist_name }}"
                                            {{ in_array($artist->artist_name, old('artistname', [])) ? 'selected' : '' }}>
                                            {{ $artist->artist_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Sponsor" class="form-label">Sponsor:</label>
                                <select class="form-control select2" name="sponsor[]" id="sponsor" multiple>
                                    @foreach ($sponsors as $sponsor)
                                        <option value="{{ $sponsor->sponsor_id }}"
                                            {{ in_array($sponsor->sponsor_id, old('sponsor', [])) ? 'selected' : '' }}>
                                            {{ $sponsor->sponsor_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- <div id="dineInSection2" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="margin" class="form-label"> Margin (in %):</label>
                                <input type="number" class="form-control" name="margin" id="margin" min="1"
                                    value="{{ old('margin') }}">
                                @error('margin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                    <div id="dineInSection1" class="row">
                        <div class="form-group">
                            <label for="description" class="form-label">Description: *</label>
                            <textarea class="form-control" name="description" id="description" required >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="taskTemplateSection" class="row" style="display: none;">
                        <div class="col-md-6">
                            <div class="form-group d-flex flex-column">
                                <label for="taskTemplate" class="form-label">Task Template:</label>
                                <select class="form-control select2" name="task_template_id" id="taskTemplate">
                                    <option value="">Select Task Template</option>
                                      {{-- dynamically load --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="dineInSection1" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location" class="form-label">Location: *</label>
                                <input type="text" id="locationInput" class="form-control" name="location" required id="location" placeholder="Enter location" value="{{ old('location') }}">
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
                                    id="mapIframe"
                                    width="100%"
                                    height="300"
                                    style="border:0"
                                    allowfullscreen
                                    loading="lazy">
                                </iframe>
                            </div>
                        </div>
                    </div>
                    <h3><center><b>Customer Care Option</b></center></h3>
                    <br>
                    <div id="dineInSectionAddress" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address: </label>
                                <input type="text" class="form-control" name="address" id="address"
                                       value="{{ old('address') }}">
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="whatsapp_no" class="form-label">WhatsApp No: </label>
                                <input type="number" class="form-control" name="whatsapp_no" id="whatsapp_no"
                                       value="{{ old('whatsapp_no') }}" >
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
                                       value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="display: flex; justify-content:flex-start">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.getElementById('getLocationButton').addEventListener('click', function () {
        const query = document.getElementById('locationInput').value;
        if (query.trim() !== "") {
            const url = `https://www.google.com/maps?q=${encodeURIComponent(query)}&output=embed`;
            document.getElementById("mapIframe").src = url;
        }
    });
   $('#category').on('select2:select', function (e) {
       // Show the task template section
       document.getElementById('taskTemplateSection').style.display = 'block';
       const selectedCategory = e.params.data.id;
       $.ajax({
           url: '{{ route('useradmin.getTaskTemplates') }}',
           method: 'GET',
           data: { category: selectedCategory },
           success: function (response) {

               const taskTemplateSelect = document.getElementById('taskTemplate');
               // Remove all existing options
               taskTemplateSelect.innerHTML = '';
               // Add the default "Select Event" option
               var defaultOption = document.createElement("option");
               defaultOption.value = "";
               defaultOption.text = "Select Task Template";
               taskTemplateSelect.appendChild(defaultOption);
               response.forEach(function (template) {
                   const option = document.createElement('option');
                   option.value = template.id;
                   option.textContent = template.template_name;
                   taskTemplateSelect.appendChild(option);
               });
           },
           error: function (xhr, status, error) {
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

    flatpickr("#eventdate", {
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
        document.getElementById('eventdate').value = bookingDate;
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

        if ( phonePattern.test(phoneInput.value)) {
            phoneInput.setCustomValidity('');
        } else {
            phoneInput.setCustomValidity('Invalid Whatsapp number');
        }
    })

    //Check Logo and Banner size check
    document.getElementById('Logo').addEventListener('change', function() {
        validateImageSize(this, 600, 400, 'logoError');
    });

    // Listen for changes on the Banner input
    document.getElementById('banner').addEventListener('change', function() {
        validateImageSize(this, 1920, 1080, 'bannerError');
    });

    // Function to validate image dimensions
    function validateImageSize(inputElement, expectedWidth, expectedHeight, errorElementId) {
        const file = inputElement.files[0];
        const errorElement = document.getElementById(errorElementId);
        errorElement.textContent = ''; // Clear previous error messages

        if (!file) {
            inputElement.setCustomValidity(''); // Clear custom validity if no file is selected
            return; // No file selected, no validation needed
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                if (this.width !== expectedWidth || this.height !== expectedHeight) {
                    const errorMessage = `Please upload an image with dimensions ${expectedWidth}x${expectedHeight}.`;
                    errorElement.textContent = errorMessage;
                    inputElement.setCustomValidity(errorMessage); // Set custom validity to prevent form submission
                } else {
                    errorElement.textContent = ''; // Clear error message
                    inputElement.setCustomValidity(''); // Clear custom validity if dimensions are correct
                }
            };
            img.onerror = function() {
                const errorMessage = 'Could not load image. Please ensure it is a valid image file.';
                errorElement.textContent = errorMessage;
                inputElement.setCustomValidity(errorMessage); // Set custom validity for invalid image
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
        var eventDate = $('#eventdate').val();
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
    document.getElementById('orderForm').addEventListener('submit', function(event) {
        event.preventDefault();
        //  Check validation and submit the form
        console.log(event)

        if (checkValidation()) {

            // Submit the form if validation is successful
            document.getElementById('orderForm').submit();
        }
    })
</script>
@endsection
