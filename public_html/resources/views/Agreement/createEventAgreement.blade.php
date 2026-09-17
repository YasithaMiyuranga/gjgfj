@extends('layouts.app')

@section('page-title', __('Create Event Agreement'))
@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.show_agreement_event') }}">{{ __('Agreements') }}</a>
        <li class="breadcrumb-item active">{{ __('Create Event Agreement') }}</li>
    </li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Create Event Agreement</h3>
            </div>
            <hr>
            <div class="card-body table-border-style">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mb-3">Agreement Details</h5>
                        <section class="agreement-form-container">
                            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                            <form action="{{ route('useradmin.agreements.store_event') }}" method="post" id="agreement-form">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="agreement_template_id" class="form-label">Select Agreement Template:</label>
                                        <select name="agreement_template_id" id="agreement_template_id" class="form-control template-name" required>
                                            <option value="">Select Template</option>
                                            @foreach ($agreementTemplates as $Template)
                                            <option value="{{ $Template->id }}"
                                                {{ old('agreement_template_id') == $Template->id ? 'selected' : '' }}
                                                data-id="{{ $Template->id }}"
                                                data-agreement-category-name="{{ $Template->agreementCategory->name ?? '' }}"
                                                >{{ $Template->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="agreement_category" class="form-label">Agreement Category:</label>
                                        <input type="text" name="agreement_category" id="agreement_category" class="form-control" value="{{ old('agreement_category') }}" readonly>
                                    </div>
                                </div>
                                <div class="customer-section" id="customer-section">
                                    <h5 class="mb-3">Event Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="event_id" class="form-label">Event Name</label>
                                            <select name="event_details[event_id]" class="form-control event-name" id="event_id" required>
                                                <option value="">Select Event:</option>
                                                    @foreach ($eventDetails as $event)
                                                        <option value="{{ $event->eid }}" {{ old('event_details.event_id') == $event->eid || (isset($selectedEventDetails) && $event->eid == $selectedEventDetails->eid) ? 'selected' : '' }}>
                                                            {{ $event->event_name }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" name="customer_details[customer_id]" class="form-control" value="{{ old('customer_details.customer_id') }}" >
                                        <div class="col-md-6">
                                            <label for="event-date" class="form-label">Event Date:</label>
                                            <input type="date" name="event_details[event_date]" class="form-control flatpickr" value="{{ old('event_details.event_date') }}" id="event-date" placeholder="Event Date" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="start_date" class="form-label">Event Start Date & Time:</label>
                                            <input type="time" name="event_details[start_datetime]" class="form-control flatpickr" value="{{ old('event_details.start_datetime') }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="end_date" class="form-label">Event End Date & Time:</label>
                                            <input type="time" name="event_details[end_datetime]" class="form-control flatpickr" value="{{ old('event_details.end_datetime') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="location" class="form-label">Location:</label>
                                            <input type="text" name="event_details[location]" class="form-control" value="{{ old('event_details.location') }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="location" class="form-label">Event Type:</label>
                                            <input type="text" name="event_details[type]" class="form-control" value="{{ old('event_details.type') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="event_manager" class="form-label">Event Manager:</label>
                                            <input type="text" name="event_details[event_manager]" class="form-control" value="{{ old('event_details.event_manager') }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="event_manager_contact" class="form-label">Event Manager Contact:</label>
                                            <input type="text" name="event_details[event_manager_contact]" class="form-control" value="{{ old('event_details.event_manager_contact') }}" readonly>
                                        </div>
                                    </div>
                                    <h5 class="mt-3">Customer Details</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="customer_name" class="form-label">Customer Name:</label>
                                                <input type="text" name="customer_details[customer_name]" class="form-control" value="{{ old('customer_details.customer_name') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="customer_nic" class="form-label">Customer NIC:</label>
                                                <input type="text" name="customer_details[nic]" class="form-control" value="{{ old('customer_details.nic') }}" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label for="company_name" class="form-label">Company Name:</label>
                                                <input type="text" name="customer_details[company_name]" class="form-control" value="{{ old('customer_details.company_name') }}" >
                                            </div>
                                            <div class="col-md-6">
                                                <label for="customer_phone" class="form-label">Customer Contact:</label>
                                                <input type="text" name="customer_details[customer_phone]" class="form-control" value="{{ old('customer_details.customer_phone') }}" required>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <label for="location" class="form-label">Customer Location:</label>
                                                <input type="text" name="customer_details[location]" class="form-control" value="{{ old('customer_details.location') }}" rows="2" required>
                                            </div>
                                        </div>
                                    </div>
                                <section class="topic-section mt-4">
                                    <h5 class="mb-3">Agreement Terms</h5>
                                    <div class="row g-3" id="topics-container">
                                        @if($defaultAgreementTerms)
                                            @foreach($defaultAgreementTerms as $term)
                                                <div class="col-12 col-md-6 col-xl-4">
                                                    <div class="terms-container border rounded p-3 h-100">
                                                        <div>
                                                            <div class="agreement-header d-flex justify-content-between align-items-center mb-3 gap-2">
                                                                <input type="text" class="form-control" name="topics[{{ $loop->index }}][title]" value="{{ $term->title }}">
                                                                <button type="button" class="btn btn-sm remove-topic" data-index="{{ $loop->index }}">
                                                                    <i class="ti ti-x remove-topic-icon"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="sub-topic-inner-wrap border rounded p-1">
                                                            @foreach($term->subTerms as $subTerm)
                                                                <div class="sub-topic-outer-wrap border rounded m-1">
                                                                    <div class="p-2">
                                                                        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                                                                            <input type="text" class="form-control subtopic-title-input" name="topics[{{ $loop->parent->index }}][subtopics][{{ $loop->index }}][subtitle]" value="{{ $subTerm->title }}">
                                                                            <button type="button" class="btn btn-sm remove-subtopic" data-index="{{ $loop->index }}">
                                                                                <i class="ti ti-x remove-topic-icon"></i>
                                                                            </button>
                                                                        </div>
                                                                        <textarea class="form-control" rows="3" name="topics[{{ $loop->parent->index }}][subtopics][{{ $loop->index }}][description]" required>{{ $subTerm->description }}</textarea>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="oder-wrap d-flex justify-content-center p-3 align-items-center gap-2 border-top">
                                                            <label class="mb-0"><b>Section Order:</b></label>
                                                            <select class="form-control w-50 section-order" name="topics[{{ $loop->index }}][order]">
                                                                @for($i = 1; $i <= $defaultAgreementTerms->count(); $i++)
                                                                    <option value="{{ $i }}" {{ $i == $loop->index + 1 ? 'selected' : '' }}>{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </section>
                                <div class="d-flex mt-4 flex-row-reverse justify-content-between gap-1">
                                    <div class="d-none d-xl-block">
                                        <button type="button" class="btn btn-secondary btn-sm" id="prev-page">Previous</button>
                                        <button type="button" class="btn btn-secondary btn-sm" id="next-page">Next Page</button>
                                    </div>
                                    <input type="submit" form="agreement-form" value="Create Agreement" class="btn btn-primary btn-sm">
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>

    const agreementTemplates = @json($agreementTemplates);
    const events = @json($eventDetails);
    const defaultAgreementTerms = @json($defaultAgreementTerms ?? []);

    let currentTemplateData = { topics: [] };
    let currentPage = 0;
    let customerSection;

    document.addEventListener('DOMContentLoaded', () => {
        initializeElements();
        setupEventListeners();

        // Load default agreement terms
        if (defaultAgreementTerms.length > 0) {
            currentTemplateData.topics = defaultAgreementTerms.map(term => ({
                title: term.title,
                subtopics: term.sub_terms.map(subTerm => ({
                    title: subTerm.title,
                    description: subTerm.description
                }))
            }));
            renderTopics();
        }
        // Get the selected event's ID from the event name dropdown
        var eventId = $('#event_id').val();

        // Check if an event ID is selected
        if (eventId) {
            // Fetch event details using the selected event ID
            updateEventCustomerDetails(eventId);
        }

        // Initialize agreement template and category fields
        initializeAgreementFields(defaultAgreementTerms[0]?.agreement_template_id);
    });

    function initializeElements() {
        customerSection = document.getElementById('customer-section');
    }

    function setupEventListeners() {
        // Template selection handler
        document.getElementById('agreement_template_id').addEventListener('change', function(e) {
            const selectedTemplateId = parseInt(this.value);
            const selectedTemplate = agreementTemplates.find(t => t.id === selectedTemplateId);

            if (selectedTemplate) {
                const categoryName = selectedTemplate.agreement_category?.name || '';
                document.getElementById('agreement_category').value = categoryName;

                if (document.getElementById('agreement_template_id').value === '') {
                    customerSection.classList.add('d-none');
                    document.getElementById('prev-page').closest('.d-flex.mt-4.flex-row-reverse.justify-content-between.gap-1').classList.add('d-none');
                    document.querySelector('.topic-section').classList.add('d-none');
                    document.getElementById('agreement_category').value = '';
                } else {
                    customerSection.classList.remove('d-none');
                    document.getElementById('prev-page').closest('.d-flex.mt-4.flex-row-reverse.justify-content-between.gap-1').classList.remove('d-none');
                    document.querySelector('.topic-section').classList.remove('d-none');
                }

                // Reset customer details
                document.getElementById('event_id').value = '';
                document.querySelector('input[name="customer_details[customer_name]"]').value = '';
                document.querySelector('input[name="customer_details[customer_id]"]').value = '';
                document.querySelector('input[name="customer_details[location]"]').value = '';
                document.querySelector('input[name="customer_details[nic]"]').value = '';
                document.querySelector('input[name="customer_details[customer_phone]"]').value = '';
                document.querySelector('input[name="customer_details[company_name]"]').value = '';

                // Reset event details
                document.querySelector('input[name="event_details[event_date]"]').value = '';
                document.querySelector('input[name="event_details[start_datetime]"]').value = '';
                document.querySelector('input[name="event_details[end_datetime]"]').value = '';
                document.querySelector('input[name="event_details[location]"]').value = '';
                document.querySelector('input[name="event_details[type]"]').value = '';
                document.querySelector('input[name="event_details[event_manager]"]').value = '';
                document.querySelector('input[name="event_details[event_manager_contact]"]').value = '';

                // Load actual terms and subterms while maintaining existing structure
                currentTemplateData.topics = selectedTemplate.terms.map(term => ({
                    title: term.title,
                    subtopics: term.sub_terms.map(subTerm => ({
                        title: subTerm.title,
                        description: subTerm.description
                    }))
                }));

                // Show pagination and topic heading after selecting template
                document.getElementById('prev-page').closest('.d-flex.mt-4.flex-row-reverse.justify-content-between.gap-1').classList.remove('d-none');
                document.querySelector('.topic-section').classList.remove('d-none');

                renderTopics();
            } else {
                // Hide pagination and topic heading when no template is selected
                document.getElementById('prev-page').closest('.d-flex.mt-4.flex-row-reverse.justify-content-between.gap-1').classList.add('d-none');
                document.querySelector('.topic-section').classList.add('d-none');
                customerSection.classList.add('d-none');
                document.getElementById('agreement_category').value = '';
            }
        });

        // Event selection handler
        $('#event_id').on('change', function () {
            const eventId = this.value;
            updateEventCustomerDetails(eventId);
        });

        // Maintain pagination functionality
        document.getElementById('next-page').addEventListener('click', handleNextPage);
        document.getElementById('prev-page').addEventListener('click', handlePrevPage);
        window.addEventListener('resize', handleWindowResize);
        document.getElementById('topics-container').addEventListener('click', handleTopicActions);
    }

    // Update customer details based on selected event
    function updateEventCustomerDetails(eventId) {
        const event = events.find(emp => emp.eid == eventId);

        if (event && event.customer) {
            $('input[name="customer_details[customer_name]"]').val(event.customer.customer_name || '');
            $('input[name="customer_details[customer_id]"]').val(event.customer.customer_id || '');
            $('input[name="customer_details[location]"]').val(event.customer.location || '');
            $('input[name="customer_details[nic]"]').val(event.customer.nic || '');
            $('input[name="customer_details[company_name]"]').val(event.customer.company_name || '');
            $('input[name="customer_details[customer_phone]"]').val(event.customer.customer_phone || '');
            $('input[name="event_details[event_date]"]').val(event.event_date || '');
            $('input[name="event_details[start_datetime]"]').val(event.start_datetime || '');
            $('input[name="event_details[end_datetime]"]').val(event.end_datetime || '');
            $('input[name="event_details[location]"]').val(event.location || '');
            $('input[name="event_details[type]"]').val(event.type || '');
            $('input[name="event_details[event_manager]"]').val(event.event_manager || '');
            $('input[name="event_details[event_manager_contact]"]').val(event.event_manager_contact || '');
        } else {
            // reset all
            $('input[name^="customer_details"]').val('');
            $('input[name^="event_details"]').val('');
        }
    }
    function initializeAgreementFields( selectedTemplateId) {
        if (selectedTemplateId) {
            const selectedTemplate = agreementTemplates.find(t => t.id == selectedTemplateId);
            if (selectedTemplate) {
                const categoryName = selectedTemplate.agreement_category?.name || '';
                document.getElementById('agreement_category').value = categoryName;
                document.getElementById('agreement_template_id').value = selectedTemplateId;
            }
        }
    }

    function handleNextPage() {
        syncFormWithTemplateData();
        currentPage++;
        renderTopics();
    }

    function handlePrevPage() {
        if(currentPage > 0) currentPage--;
        syncFormWithTemplateData();
        renderTopics();
    }

    function handleWindowResize() {
        if (window.innerWidth < 1200) currentPage = 0;
        renderTopics();
    }

    function handleTopicActions(e) {
        // Removing a subtopic
        if (e.target.closest('.remove-subtopic')) {
            const subtopicElement = e.target.closest('.sub-topic-outer-wrap');
            const topicElement = e.target.closest('.terms-container');

            if (!subtopicElement || !topicElement) return;

            const topicIndex = [...document.querySelectorAll('.terms-container')].indexOf(topicElement);
            const subtopicIndex = [...topicElement.querySelectorAll('.sub-topic-outer-wrap')].indexOf(subtopicElement);

            if (topicIndex !== -1 && subtopicIndex !== -1) {
                syncFormWithTemplateData(); // Save current state
                currentTemplateData.topics[topicIndex].subtopics.splice(subtopicIndex, 1);
                renderTopics();
            }
        } else if (e.target.closest('.remove-topic')) {
            const topicElement = e.target.closest('.terms-container');
            if (!topicElement) return;

            const topicIndex = [...document.querySelectorAll('.terms-container')].indexOf(topicElement);

            if (topicIndex !== -1) {
                currentTemplateData.topics.splice(topicIndex, 1);
                const totalPages = Math.ceil(currentTemplateData.topics.length / getTopicsPerPage());

                if (currentPage >= totalPages && currentPage > 0) {
                    currentPage--;
                }

                renderTopics();
            }
        }
    }

    function getTopicsPerPage() {
        return window.innerWidth < 1200 ? currentTemplateData.topics.length : 3;
    }

    function generateTopicHTML(topic, index) {
        return `
            <div>
                <div class="terms-container border rounded p-3 h-100" data-topic-index="${index}">
                    <div>
                        <div class="agreement-header d-flex justify-content-between align-items-center mb-3 gap-2">
                            <input type="text" class="form-control" name="topics[${index}][title]" value="${topic.title}">
                            <button type="button" class="btn btn-sm remove-topic" data-index="${index}">
                                <i class="ti ti-x remove-topic-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="sub-topic-inner-wrap border rounded p-1">
                        ${topic.subtopics.map((subtopic, subIndex) => `
                            <div class="sub-topic-outer-wrap border rounded m-1">
                                <div class="p-2">
                                    <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                                        <input type="text" class="form-control subtopic-title-input" name="topics[${index}][subtopics][${subIndex}][subtitle]" value="${subtopic.title}">
                                        <button type="button" class="btn btn-sm remove-subtopic" data-index="${subIndex}">
                                            <i class="ti ti-x remove-topic-icon"></i>
                                        </button>
                                    </div>
                                    <textarea class="form-control" rows="3" name="topics[${index}][subtopics][${subIndex}][description]" required>${subtopic.description || ''}</textarea>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    <div class="oder-wrap d-flex justify-content-center p-3 align-items-center gap-2 border-top">
                        <label class="mb-0"><b>Section Order:</b></label>
                        <select class="form-control w-50 section-order" name="topics[${index}][order]">
                            ${currentTemplateData.topics.map((_, i) => `
                                <option value="${i+1}" ${i === index ? 'selected' : ''}>${i+1}</option>
                            `).join('')}
                        </select>
                    </div>
                </div>
            </div>
        `;
    }

    function syncFormWithTemplateData() {
        document.querySelectorAll('.terms-container').forEach((topicEl, topicIndex) => {
            const titleInput = topicEl.querySelector(`input[name="topics[${topicIndex}][title]"]`);
            if (titleInput) {
                currentTemplateData.topics[topicIndex].title = titleInput.value;
            }

            const subtopicEls = topicEl.querySelectorAll('.sub-topic-outer-wrap');
            subtopicEls.forEach((subEl, subIndex) => {
                const subtitleInput = subEl.querySelector('input[name^="topics"][name$="[subtitle]"]');
                if (subtitleInput) {
                    currentTemplateData.topics[topicIndex].subtopics[subIndex].title = subtitleInput.value;
                }
                const textarea = subEl.querySelector('textarea');
                if (textarea) {
                    currentTemplateData.topics[topicIndex].subtopics[subIndex].description = textarea.value;
                }
            });
        });
    }

    function renderTopics() {
        const topicsPerPage = getTopicsPerPage();
        const paginatedTopics = window.innerWidth >= 1200
            ? currentTemplateData.topics.slice(currentPage * topicsPerPage, (currentPage + 1) * topicsPerPage)
            : currentTemplateData.topics;

        let html = '';
        currentTemplateData.topics.forEach((topic, index) => {
            const isVisible = window.innerWidth >= 1200
                ? (index >= currentPage * topicsPerPage && index < (currentPage + 1) * topicsPerPage)
                : true;

            html += `
                <div class="col-12 col-md-6 col-xl-4" ${isVisible ? '' : 'hidden'}>
                    ${generateTopicHTML(topic, index)}
                </div>
            `;
        });

        document.getElementById('topics-container').innerHTML = html;

        if (window.innerWidth >= 1200) {
            document.getElementById('prev-page').disabled = currentPage === 0;
            document.getElementById('next-page').disabled =
                (currentPage + 1) * topicsPerPage >= currentTemplateData.topics.length;
        }

        setupOrderDropdowns();
    }

    function setupOrderDropdowns() {
        document.querySelectorAll('.section-order').forEach(dropdown => {
            dropdown.addEventListener('change', function() {
                const selectedIndex = parseInt(this.closest('.terms-container').dataset.topicIndex);
                const newOrder = parseInt(this.value) - 1;

                if (selectedIndex !== newOrder) {
                    syncFormWithTemplateData();

                    const movedTopic = currentTemplateData.topics.splice(selectedIndex, 1)[0];
                    currentTemplateData.topics.splice(newOrder, 0, movedTopic);

                    renderTopics();
                }
            });
        });
    }

   flatpickr(".flatpickr", {
       enableTime: true,
       dateFormat: "Y-m-d H:i",
       //defaultDate: "today",
       minuteIncrement: 15,
   });

   $(document).ready(function() {
        const eventChoice = new Choices('.event-name', {
            placeholder: true,
            searchEnabled: true,
        });
    })

    $(document).ready(function() {
        const templateChoice = new Choices('.template-name', {
            placeholder: true,
            searchEnabled: true,
        });
    })
</script>
@endsection
