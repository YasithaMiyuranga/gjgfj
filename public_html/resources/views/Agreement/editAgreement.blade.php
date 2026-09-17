@extends('layouts.app')

@section('page-title', __('Agreement Edit'))
@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.show_agreement_employee') }}">{{ __('Agreements') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.agreement.edit', $agreement->id) }}">{{ __('Edit Agreement') }}</a>
    </li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Edit Agreement</h3>
            </div>
            <hr>
            <div class="card-body table-border-style">
                <div class="row">
                    <div class="col-md-12">
                        <section class="agreement-form-container">
                            <h5 class="mb-3">Agreement Details</h5>
                            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                            <form action="{{ route('useradmin.agreement.update', $agreement->id) }}" method="post" id="agreement-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="agreement_id" value="{{ $agreement->id }}">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="agreement_template_id" class="form-label">Select Agreement Template:</label>
                                        <select name="agreement_template_id" id="agreement_template_id" class="form-control" disabled>
                                            <option value="">Select Template</option>
                                            @foreach ($agreementTemplates as $Template)
                                            <option value="{{ $Template->id }}"
                                                {{ old('agreement_template_id', $agreement->template_id) == $Template->id ? 'selected' : '' }}
                                                data-id="{{ $Template->id }}"
                                                data-agreement-category-name="{{ $Template->agreementCategory->name ?? '' }}"
                                                >{{ $Template->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="agreement_template_id" value="{{ old('agreement_template_id', $agreement->template_id) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="agreement_catagory" class="form-label">Agreement Category:</label>
                                        <input type="text" name="agreement_catagory" id="agreement_catagory" class="form-control" value="{{ old('agreement_catagory', $agreement->template->agreementCategory->name ?? '') }}" readonly>
                                    </div>
                                </div>
                                <div id="employee-section">
                                    <h5 class="mb-3">Employee Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="emp_id" class="form-label">Employee Name</label>
                                            <select name="emp_id" class="form-control" id="emp_id">
                                                <option value="">Select Employee</option>
                                                @foreach ($employee_details as $employee)
                                                <option value="{{ $employee->emp_id }}"
                                                    {{ old('emp_id', $agreement->emp_id) == $employee->emp_id ? 'selected' : '' }}
                                                    data-nic="{{ $employee->nic }}"
                                                    data-email="{{ $employee->email }}"
                                                    data-address="{{ $employee->address }}"
                                                    data-emp_type="{{ $employee->emp_type }}"
                                                    data-net_salary="{{ $employee->net_salary }}"
                                                    data-regdate="{{ $employee->regdate }}">
                                                    {{ $employee->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="emp_join_date" class="form-label">Join Date:</label>
                                            <input type="text" name="employee-details[emp_join_date]" class="form-control" placeholder="Enter Join Date" value="{{ old('employee-details.emp_join_date', \Carbon\Carbon::parse($employee->regdate)->format('Y-m-d')) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="employee_nic" class="form-label">Employee NIC:</label>
                                            <input type="text" name="employee-details[employee_nic]" class="form-control" placeholder="Enter Employee ID" value="{{ old('employee-details.employee_nic', $employee->nic ?? '') }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="job_title" class="form-label">Job Title:</label>
                                            <input type="text" name="employee-details[job_title]" class="form-control" placeholder="Enter Job Title" value="{{ old('employee-details.job_title', $employee->emp_type ?? '') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label for="employee_address" class="form-label">Employee Address</label>
                                            <textarea name="employee-details[employee_address]" class="form-control" placeholder="Enter Employee Address" rows="2" readonly>{{ old('employee-details.employee_address', $employee->address ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <section class="topic-section mt-4">
                                    <h5 class="mb-3">Agreement Terms</h5>
                                    <div class="row g-3" id="topics-container">

                                      @foreach($agreement->agreementTerms as $index => $term)
                                          <div class="col-12 col-md-6 col-xl-4">
                                              <div class="terms-container border rounded p-3 h-100">
                                                  <div>
                                                      <div class="agreement-header d-flex justify-content-between align-items-center mb-3">

                                                          <h6 class="mb-3">{{ $term->title }}</h6>
                                                          <input type="hidden" name="topics[{{ $index }}][agreementTerm_id]" value="{{ $term->id }}">
                                                          <input type="hidden" name="topics[{{ $index }}][title]" value="{{ $term->title }}">
                                                          <button type="button" class="btn btn-sm text-danger remove-topic" data-topic-index="{{ $index }}">
                                                              <i class="ti ti-x"></i>
                                                          </button>
                                                      </div>
                                                  </div>
                                                  <div class="sub-topic-inner-wrap border rounded p-1">
                                                    @foreach($term->agreementSubTerms as $subIndex => $subTerm)
                                                    <div class="sub-topic-outer-wrap border rounded m-1">
                                                        <div class="p-2">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <label class="form-label"><b>{{ $subTerm->SubTerm_title }}</b></label>
                                                                <button type="button" class="btn btn-sm text-danger remove-subtopic" data-subtopic-index="{{ $subIndex }}">
                                                                    <i class="ti ti-x"></i>
                                                                </button>
                                                            </div>
                                                            <input type="hidden" name="topics[{{ $index }}][subtopics][{{ $subIndex }}][agreementSubTerm_id]" value="{{ $subTerm->id }}">
                                                            <input type="hidden" name="topics[{{ $index }}][subtopics][{{ $subIndex }}][subtitle]" value="{{ $subTerm->SubTerm_title }}">
                                                            <textarea class="form-control" rows="3" name="topics[{{ $index }}][subtopics][{{ $subIndex }}][description]"></textarea>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                  </div>
                                                  <div class="oder-wrap d-flex justify-content-center p-3 align-items-center gap-2 border-top">
                                                      <label class="mb-0"><b>Section Order:</b></label>
                                                      <select class="form-control w-50 section-order" name="topics[{{ $index }}][order]" data-index="{{ $index }}">
                                                          @foreach($agreement->agreementTerms as $i => $t)
                                                          <option value="{{ $i+1 }}" {{ $i == $index ? 'selected' : '' }}>{{ $i+1 }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                          </div>
                                      @endforeach
                                    </div>
                                    <div id="hidden-fields-container" style="display: none;"></div>
                                </section>
                                <div class="d-flex mt-4 flex-row-reverse justify-content-between gap-1">
                                    <div class="d-none d-xl-block">
                                        <button type="button" class="btn btn-secondary btn-sm" id="prev-page">Previous</button>
                                        <button type="button" class="btn btn-secondary btn-sm" id="next-page">Next Page</button>
                                    </div>
                                    <input type="submit" value="Update Agreement" class="btn btn-primary btn-sm">
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const employees = @json($employee_details);
    const agreementTemplates = @json($agreementTemplates);
    const existingTerms = @json($agreement->agreementTerms->load('agreementSubTerms'));

    let currentPage = 0;
    let employeeSection;
    const TOPICS_PER_PAGE = 3;

    let currentTemplateData = {
        topics: existingTerms.map(term => ({
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
    });

    function initializeElements() {
        employeeSection = document.getElementById('employee-section');
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


        document.getElementById('emp_id').addEventListener('change', function(e) {
            const empId = this.value;
            const employee = employees.find(emp => emp.emp_id == empId);

            if (employee) {
                const formattedDate = new Date(employee.regdate).toISOString().split('T')[0];
                document.querySelector('input[name="employee-details[emp_join_date]"]').value = formattedDate;

                document.querySelector('input[name="employee-details[employee_nic]"]').value = employee.nic || '';
                document.querySelector('input[name="employee-details[job_title]"]').value = employee.emp_type || '';
                document.querySelector('textarea[name="employee-details[employee_address]"]').value = employee.address || '';
            } else {
                // Reset fields
                document.querySelector('input[name="employee-details[emp_join_date]"]').value = '';
                document.querySelector('input[name="employee-details[employee_nic]"]').value = '';
                document.querySelector('input[name="employee-details[job_title]"]').value = '';
                document.querySelector('textarea[name="employee-details[employee_address]"]').value = '';
            }
        });

        document.getElementById('next-page').addEventListener('click', handleNextPage);
        document.getElementById('prev-page').addEventListener('click', handlePrevPage);

        window.addEventListener('resize', handleWindowResize);

        // Topic actions
        document.getElementById('topics-container').addEventListener('click', handleTopicActions);

        document.getElementById('agreement-form').addEventListener('submit', updateHiddenFields);
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

