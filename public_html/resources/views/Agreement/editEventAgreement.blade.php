@extends('layouts.app')

@section('page-title', __('Edit Event Agreement'))
@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.show_agreement_event') }}">{{ __('Agreements') }}</a>
        <li class="breadcrumb-item active">{{ __('Edit Event Agreement') }}</li>
    </li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Edit Event Agreement</h3>
            </div>
            <hr>
            <div class="card-body table-border-style">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mb-3">Agreement Details</h5>
                        <section class="agreement-form-container">
                            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                            <form action="{{ route('useradmin.agreement.update_event', $agreement->id) }}" method="post" id="agreement-form">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="agreement_template_id" class="form-label">Select Agreement Template:</label>
                                        <select name="agreement_template_id" id="agreement_template_id" class="form-control template-name" required>
                                            <option value="">Select Template</option>
                                            @foreach ($agreementTemplates as $Template)
                                            <option value="{{ $Template->id }}"
                                                {{ old('agreement_template_id', $agreement->template_id) == $Template->id ? 'selected' : '' }}
                                                data-id="{{ $Template->id }}"
                                                data-agreement-category-name="{{ $Template->agreementCategory->name ?? '' }}"
                                                >{{ $Template->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="agreement_category" class="form-label">Agreement Category:</label>
                                        <input type="text" name="agreement_category" id="agreement_category" class="form-control" value="{{ old('agreement_category', $agreement->template->agreementCategory->name ?? '') }}" readonly>
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
                                                        <option value="{{ $event->eid }}" {{ old('event_details.event_id', $agreement->event_id) == $event->eid ? 'selected' : '' }}>
                                                            {{ $event->event_name }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" name="customer_details[customer_id]" class="form-control" value="{{ old('customer_details.customer_id', $agreement->customer_id) }}" >
                                        <div class="col-md-6">
                                            <label for="event-date" class="form-label">Event Date:</label>
                                            <input type="date" name="event_details[event_date]" class="form-control flatpickr" value="{{ old('event_details.event_date', $agreement->event['event_date'] ?? '') }}" id="event-date" placeholder="Event Date" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="start_date" class="form-label">Event Start Date & Time:</label>
                                           <input type="text" name="event_details[start_datetime]" class="form-control" value="{{ old('event_details.start_datetime', $agreement->event['start_datetime'] ?? '') }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="end_date" class="form-label">Event End Date & Time:</label>
                                            <input type="text" name="event_details[end_datetime]" class="form-control " value="{{ old('event_details.end_datetime', $agreement->event['end_datetime'] ?? '') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="location" class="form-label">Location:</label>
                                            <input type="text" name="event_details[location]" class="form-control" value="{{ old('event_details.location', $agreement->event['location'] ?? '') }}" readonly >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="location" class="form-label">Event Type:</label>
                                            <input type="text" name="event_details[type]" class="form-control" value="{{ old('event_details.type', $agreement->event['type'] ?? '') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="event_manager" class="form-label">Event Manager:</label>
                                            <input type="text" name="event_details[event_manager]" class="form-control" value="{{ old('event_details.event_manager', $agreement->event['event_manager'] ?? '') }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="event_manager_contact" class="form-label">Event Manager Contact:</label>
                                            <input type="text" name="event_details[event_manager_contact]" class="form-control" value="{{ old('event_details.event_manager_contact',$agreement->event['contact_no'] ?? '') }}" readonly>
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
                                        @if($agreement->agreementTerms && count($agreement->agreementTerms) > 0)
                                            @foreach($agreement->agreementTerms as $index => $term)
                                                <div class="col-12 col-md-6 col-xl-4">
                                                    <div class="terms-container border rounded p-3 h-100">
                                                        <div>
                                                            <div class="agreement-header d-flex justify-content-between align-items-center mb-3 gap-2">
                                                                <input type="hidden" name="topics[{{ $index }}][agreementTerm_id]" value="{{ $term['id'] }}">
                                                                <input type="hidden" name="topics[{{ $index }}][title]" value="{{ old("topics.$index.title", $term['title']) }}">
                                                                <button type="button" class="btn btn-sm remove-topic" data-index="{{ $index }}">
                                                                    <i class="ti ti-x remove-topic-icon"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="sub-topic-inner-wrap border rounded p-1">
                                                            @if(isset($term['agreementSubTerms']) && count($term['agreementSubTerms']) > 0)
                                                                @foreach($term['agreementSubTerms'] as $subIndex => $subTerm)
                                                                    <div class="sub-topic-outer-wrap border rounded m-1">
                                                                        <div class="p-2">
                                                                            <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                                                                                {{-- <input type="text" class="form-control subtopic-title-input" name="topics[{{ $index }}][subtopics][{{ $subIndex }}][subtitle]" value="{{ old("topics.$index.subtopics.$subIndex.subtitle", $subTerm['SubTerm_title']) }}"> --}}
                                                                                <label class="form-label"><b>{{ $subTerm['SubTerm_title'] }} </b> </label>
                                                                                <button type="button" class="btn btn-sm remove-subtopic" data-index="{{ $subIndex }}">
                                                                                    <i class="ti ti-x remove-topic-icon"></i>
                                                                                </button>
                                                                            </div>
                                                                            <input type="hidden" name="topics[{{ $index }}][subtopics][{{ $subIndex }}][agreementSubTerm_id]" value="{{ $subTerm['id'] }}">
                                                                            <input type="hidden" name="topics[{{ $index }}][subtopics][{{ $subIndex }}][subtitle]" value="{{ old("topics.$index.subtopics.$subIndex.subtitle", $subTerm['SubTerm_title']) }}">
                                                                            <textarea class="form-control" rows="3" name="topics[{{ $index }}][subtopics][{{ $subIndex }}][description]" required>{{ old("topics.$index.subtopics.$subIndex.description", $subTerm['SubTerm_description']) }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="oder-wrap d-flex justify-content-center p-3 align-items-center gap-2 border-top">
                                                            <label class="mb-0"><b>Section Order:</b></label>
                                                            <select class="form-control w-50 section-order" name="topics[{{ $index }}][order]">
                                                                @for($i = 1; $i <= count($agreement->agreementTerms); $i++)
                                                                    <option value="{{ $i }}" {{ $i == $index + 1 ? 'selected' : '' }}>{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div id="hidden-fields-container" style="display: none;"></div>
                                </section>
                                <div class="d-flex mt-4 flex-row-reverse justify-content-between gap-1">
                                    <div class="d-none d-xl-block">
                                        <button type="button" class="btn btn-secondary btn-sm" id="prev-page">Previous</button>
                                        <button type="button" class="btn btn-secondary btn-sm" id="next-page">Next Page</button>
                                    </div>
                                    <input type="submit" form="agreement-form" value="Update Agreement" class="btn btn-primary btn-sm">
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
    const agreementTerms = @json($agreement->agreementTerms->load('agreementSubTerms'));

    let currentPage = 0;
    let customerSection;
    const TOPICS_PER_PAGE = 3;

    let currentTemplateData = {
        topics: agreementTerms.map(term => ({
            id: term.id,
            title: term.title,
            subtopics: term.agreement_sub_terms.map(subTerm => ({
                id: subTerm.id,
                title: subTerm.SubTerm_title,
                description: subTerm.SubTerm_description
            }))
        }))
    };

    document.addEventListener('DOMContentLoaded', () => {
        initializeElements();
        setupEventListeners();
        renderTopics();


        // Get the selected event's ID from the event name dropdown
        var eventId = $('#event_id').val();

        // Check if an event ID is selected
        if (eventId) {
            // Fetch event details using the selected event ID
            updateEventCustomerDetails(eventId);
        }


    });

    function initializeElements() {
        customerSection = document.getElementById('customer-section');
    }

    function setupEventListeners() {
        document.getElementById('agreement_template_id').addEventListener('change', function(e) {
            const selectedTemplateId = parseInt(this.value);
            const selectedTemplate = agreementTemplates.find(t => t.id === selectedTemplateId);

            if (selectedTemplate) {
                const categoryName = selectedTemplate.agreement_category?.name || '';
                document.getElementById('agreement_catagory').value = categoryName;

                employeeSection.classList.toggle('d-none', categoryName !== 'Employee');

                currentPage = 0;
                renderTopics();
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
        document.getElementById('agreement-form').addEventListener('submit', updateHiddenFields);
    }

    // Update customer details based on selected event
  // Update customer details based on selected event
  function updateEventCustomerDetails(eventId) {
    const event = events.find(emp => emp.eid == eventId);
    const agreementCustomer = @json($agreementCustomerDetail ?? null);

    // Reset all fields first to clear any stale data
    $('input[name^="customer_details"]').val('');
    $('input[name^="event_details"]').val('');

    if (event) {
        // Set event details from the selected event
        const eventFields = {
            'event_details[event_date]': event.event_date,
            'event_details[start_datetime]': event.start_datetime,
            'event_details[end_datetime]': event.end_datetime,
            'event_details[location]': event.location,
            'event_details[type]': event.type,
            'event_details[event_manager]': event.event_manager,
            'event_details[event_manager_contact]': event.contact_no
        };

        // Set event details with null checks
        Object.entries(eventFields).forEach(([name, value]) => {
            if (value) $('input[name="' + name + '"]').val(value);
        });

        // Priority 1: Use agreement customer details if available
        if (agreementCustomer) {
            const customerFields = {
                'customer_details[customer_id]': agreementCustomer.customer_id,
                'customer_details[customer_name]': agreementCustomer.customer_name,
                'customer_details[nic]': agreementCustomer.nic,
                'customer_details[customer_phone]': agreementCustomer.customer_phone,
                'customer_details[location]': agreementCustomer.location,
                'customer_details[company_name]': agreementCustomer.company_name
            };

            Object.entries(customerFields).forEach(([name, value]) => {
                if (value) $('input[name="' + name + '"]').val(value);
            });
        }
        // Priority 2: Fall back to event's customer data
        else if (event.customer) {
            const customerFields = {
                'customer_details[customer_id]': event.customer.customer_id,
                'customer_details[customer_name]': event.customer.customer_name,
                'customer_details[nic]': event.customer.nic,
                'customer_details[customer_phone]': event.customer.customer_phone,
                'customer_details[company_name]': event.customer.company_name,
                'customer_details[location]': event.customer.location
            };

            Object.entries(customerFields).forEach(([name, value]) => {
                if (value) $('input[name="' + name + '"]').val(value);
            });
        }
    }
}
    function handleNextPage() {
        const totalPages = Math.ceil(currentTemplateData.topics.length / TOPICS_PER_PAGE);
        if (currentPage < totalPages - 1) {
            syncCurrentPageToData(currentPage);
            currentPage++;
            renderTopics();
        }
    }

    function handlePrevPage() {
        if (currentPage > 0) {
            syncCurrentPageToData(currentPage);
            currentPage--;
            renderTopics();
        }
    }

    function handleWindowResize() {
        if (window.innerWidth < 1200) {
            currentPage = 0;
            renderTopics(true);
        } else {
            renderTopics();
        }
    }

    function handleTopicActions(e) {

        if (e.target.closest('.remove-subtopic')) {
            syncCurrentPageToData(currentPage);

            const subtopicElement = e.target.closest('.sub-topic-outer-wrap');
            const topicElement = e.target.closest('.terms-container');

            if (!subtopicElement || !topicElement) return;

            const topicIndex = [...document.querySelectorAll('.terms-container')].indexOf(topicElement);
            const actualTopicIndex = currentPage * getTopicsPerPage() + topicIndex;
            const subtopicIndex = [...topicElement.querySelectorAll('.sub-topic-outer-wrap')].indexOf(subtopicElement);

            if (actualTopicIndex !== -1 && subtopicIndex !== -1) {
                currentTemplateData.topics[actualTopicIndex].subtopics.splice(subtopicIndex, 1);
                renderTopics();
            }

        } else if (e.target.closest('.remove-topic')) {
            syncCurrentPageToData(currentPage);

            const topicElement = e.target.closest('.terms-container');
            if (!topicElement) return;

            const topicIndex = [...document.querySelectorAll('.terms-container')].indexOf(topicElement);
            const actualTopicIndex = currentPage * getTopicsPerPage() + topicIndex;

            if (actualTopicIndex !== -1) {
                currentTemplateData.topics.splice(actualTopicIndex, 1);

                const totalPages = Math.ceil(currentTemplateData.topics.length / getTopicsPerPage());
                if (currentPage >= totalPages && currentPage > 0) {
                    currentPage--;
                }

                renderTopics();
            }
        }
    }

    function generateTopicHTML(topic, index, isVisible = true) {
        if (!isVisible) {

            return `
                <input type="hidden" name="topics[${index}][agreementTerm_id]" value="${topic.id}">
                <input type="hidden" name="topics[${index}][title]" value="${escapeHtml(topic.title)}">
                ${topic.subtopics.map((subtopic, subIndex) => `
                    <input type="hidden" name="topics[${index}][subtopics][${subIndex}][agreementSubTerm_id]" value="${subtopic.id}">
                    <input type="hidden" name="topics[${index}][subtopics][${subIndex}][subtitle]" value="${escapeHtml(subtopic.title)}">
                    <input type="hidden" name="topics[${index}][subtopics][${subIndex}][description]" value="${escapeHtml(subtopic.description || '')}">
                `).join('')}
                <input type="hidden" name="topics[${index}][order]" value="${topic.order || index + 1}"> <!-- Ensure order is included -->
            `;
        }

        return `
            <div class="col-12 col-md-6 col-xl-4">
                <div class="terms-container border rounded p-3 h-100">
                    <div>
                        <div class="agreement-header d-flex justify-content-between align-items-center mb-3 gap-2">
                            <input type="hidden" name="topics[${index}][agreementTerm_id]" value="${topic.id}">
                            <input type="text" class="form-control topic-title-input" name="topics[${index}][title]" value="${escapeHtml(topic.title)}">
                            <button type="button" class="btn btn-sm remove-topic" data-index="${index}">
                                <i class="ti ti-x remove-topic-icon"></i>
                            </button>
                        </div>
                    </div>
                <div class="sub-topic-inner-wrap border rounded p-1">
                        ${topic.subtopics.map((subtopic, subIndex) => `
                            <div class="sub-topic-outer-wrap border rounded m-1">
                                <div class="p-2">
                                    <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
                                        <input type="hidden" name="topics[${index}][subtopics][${subIndex}][agreementSubTerm_id]" value="${subtopic.id}">
                                        <input type="text" class="form-control subtopic-title-input" name="topics[${index}][subtopics][${subIndex}][subtitle]" value="${subtopic.title}">
                                        <button type="button" class="btn btn-sm btn remove-subtopic" data-index="${subIndex}">
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
                        <select class="form-control w-50 section-order" name="topics[${index}][order]" data-index="${index}">
                            ${currentTemplateData.topics.map((_, i) => `
                                <option value="${i+1}" ${i === index ? 'selected' : ''}>${i+1}</option>
                            `).join('')}
                        </select>
                    </div>
                </div>
            </div>
        `;
    }
    function renderTopics(showAll = false) {
        const container = document.getElementById('topics-container');
        const hiddenContainer = document.getElementById('hidden-fields-container');

        // Clear containers
        container.innerHTML = '';
        hiddenContainer.innerHTML = '';


        const isMobile = window.innerWidth < 1200;
        const topicsToShow = showAll || isMobile ?
            currentTemplateData.topics :
            currentTemplateData.topics.slice(currentPage * TOPICS_PER_PAGE, (currentPage + 1) * TOPICS_PER_PAGE);


        topicsToShow.forEach((topic, index) => {
            const actualIndex = showAll || isMobile ? index : (currentPage * TOPICS_PER_PAGE) + index;
            container.innerHTML += generateTopicHTML(topic, actualIndex, true);
        });


        currentTemplateData.topics.forEach((topic, index) => {
            const isVisible = topicsToShow.some((t, i) => {
                const visibleIndex = showAll || isMobile ? i : (currentPage * TOPICS_PER_PAGE) + i;
                return visibleIndex === index;
            });
            if (!isVisible) {
                hiddenContainer.innerHTML += generateTopicHTML(topic, index, false);
            }
        });

        // Setup order dropdowns
        setupOrderDropdowns();

        updatePaginationButtons();
    }


    function setupOrderDropdowns() {
        document.querySelectorAll('.section-order').forEach(dropdown => {
            dropdown.addEventListener('change', function () {
                syncCurrentPageToData(currentPage);

                const selectedIndex = parseInt(this.dataset.index);
                const newOrder = parseInt(this.value) - 1;

                const movedTopic = currentTemplateData.topics.splice(selectedIndex, 1)[0];
                currentTemplateData.topics.splice(newOrder, 0, movedTopic);

                renderTopics();
            });
        });
    }
    function updatePaginationButtons() {
        const isMobile = window.innerWidth < 1200;
        const totalPages = Math.ceil(currentTemplateData.topics.length / TOPICS_PER_PAGE);

        const paginationDiv = document.getElementById('next-page').closest('.d-none.d-xl-block');
        if (paginationDiv) {
            paginationDiv.classList.toggle('d-none', isMobile || currentTemplateData.topics.length <= TOPICS_PER_PAGE);
        }

        document.getElementById('prev-page').disabled = currentPage === 0;
        document.getElementById('next-page').disabled = currentPage >= totalPages - 1 || isMobile;
    }

    function updateHiddenFields() {
        syncCurrentPageToData(currentPage);

        const hiddenContainer = document.getElementById('hidden-fields-container');
        hiddenContainer.innerHTML = '';

        const start = currentPage * getTopicsPerPage();
        const end = start + getTopicsPerPage();

        for (let i = 0; i < currentTemplateData.topics.length; i++) {
            if (i >= start && i < end) continue;

            hiddenContainer.innerHTML += generateTopicHTML(currentTemplateData.topics[i], i, false);
        }
    }

     function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe.toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    function getTopicsPerPage() {
        return TOPICS_PER_PAGE;
    }
    function syncCurrentPageToData(currentPage) {
        const start = currentPage * TOPICS_PER_PAGE;
        const end = start + TOPICS_PER_PAGE;

        const topicContainers = document.querySelectorAll('.terms-container');

        for (let i = start; i < end && i < currentTemplateData.topics.length; i++) {
            const visibleIndex = i - start;
            const topicContainer = topicContainers[visibleIndex];
            if (!topicContainer) continue;

            // Sync title
            const titleInput = topicContainer.querySelector('.topic-title-input');
            if (titleInput) {
                currentTemplateData.topics[i].title = titleInput.value.trim();
            }

            // Sync subtopic descriptions
            const subtopicElements = topicContainer.querySelectorAll('.sub-topic-outer-wrap');
            subtopicElements.forEach((subtopicEl, j) => {
                const descTextarea = subtopicEl.querySelector('textarea');
                if (descTextarea && currentTemplateData.topics[i].subtopics[j]) {
                    currentTemplateData.topics[i].subtopics[j].description = descTextarea.value.trim();
                }
                const subtopicTitleInput = subtopicEl.querySelector('.subtopic-title-input');
                if (subtopicTitleInput && currentTemplateData.topics[i].subtopics[j]) {
                    currentTemplateData.topics[i].subtopics[j].title = subtopicTitleInput.value.trim();
                }
            });
        }
    }
</script>
@endsection
