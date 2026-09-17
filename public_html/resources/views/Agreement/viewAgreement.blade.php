@extends('layouts.app')

@section('page-title', __('Agreement Create'))
@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.show_agreement_employee') }}">{{('Agreements') }}</a>
        <li class="breadcrumb-item active">{{ ('Create Agreement') }}</li>
    </li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Create Agreement</h3>
            </div>
            <hr>
            <div class="card-body table-border-style">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mb-3">Agreement Details</h5>
                        <section class="agreement-form-container">
                            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
                            <form action="{{ route('useradmin.agreement.store_create_agreement') }}" method="post" id="agreement-form">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="agreement_template_id" class="form-label">Select Agreement Template:</label>
                                        <select name="agreement_template_id" id="agreement_template_id" class="form-control" required>
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
                                        <label for="agreement_catagory" class="form-label">Agreement Category:</label>
                                        <input type="text" name="agreement_catagory" id="agreement_catagory" class="form-control" value="{{ old('agreement_catagory') }}" readonly>
                                    </div>
                                </div>
                                <div class="employee-section d-none" id="employee-section">
                                    <h5 class="mb-3">Employee Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="emp_id" class="form-label">Employee Name</label>
                                            <select name="emp_id" class="form-control" id="emp_id" required>
                                                <option value="">Select Employee</option>
                                                @foreach ($employee_details as $employee)
                                                <option value="{{ $employee->emp_id }}"
                                                    {{ old('emp_id') == $employee->emp_id ? 'selected' : '' }}
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
                                            <input type="text" name="employee-details[emp_join_date]" class="form-control" placeholder="Enter Join Date" value={{ old('emp_join_date') }} readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="employee_nic" class="form-label">Employee NIC:</label>
                                            <input type="text" name="employee-details[employee_nic]" class="form-control" placeholder="Enter Employee ID" value="{{ old('employee_nic') }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="job_title" class="form-label">Job Title:</label>
                                            <input type="text" name="employee-details[job_title]" class="form-control" placeholder="Enter Job Title" value="{{ old('job_title') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label for="employee_address" class="form-label">Employee Address</label>
                                            <textarea type="text" name="employee-details[employee_address]" class="form-control" placeholder="Enter Employee Address" rows="2" readonly>
                                                {{ old('employee-details.employee_address') }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <section class="topic-section mt-4 d-none">
                                    <h5 class="mb-3">Agreement Terms</h5>
                                    <div class="row g-3" id="topics-container"></div>
                                </section>

                                <div class="d-flex mt-4 flex-row-reverse justify-content-between gap-1 d-none">
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

<script>
    const employees = @json($employee_details);
    const agreementTemplates = @json($agreementTemplates);

    let currentTemplateData = { topics: [] };
    let currentPage = 0;
    let employeeSection;

    document.addEventListener('DOMContentLoaded', () => {
        initializeElements();
        setupEventListeners();
    });

    function initializeElements() {
        employeeSection = document.getElementById('employee-section');
    }

    function setupEventListeners() {
        // Template selection handler
        document.getElementById('agreement_template_id').addEventListener('change', function(e) {
            const selectedTemplateId = parseInt(this.value);
            const selectedTemplate = agreementTemplates.find(t => t.id === selectedTemplateId);

            if (selectedTemplate) {
                const categoryName = selectedTemplate.agreement_category?.name || '';
                document.getElementById('agreement_catagory').value = categoryName;

                if (document.getElementById('agreement_template_id').value === '') {
                    employeeSection.classList.add('d-none');
                    document.getElementById('prev-page').closest('.d-flex.mt-4.flex-row-reverse.justify-content-between.gap-1').classList.add('d-none');
                    document.querySelector('.topic-section').classList.add('d-none');
                    document.getElementById('agreement_catagory').value = '';
                } else {
                    employeeSection.classList.remove('d-none');
                    document.getElementById('prev-page').closest('.d-flex.mt-4.flex-row-reverse.justify-content-between.gap-1').classList.remove('d-none');
                    document.querySelector('.topic-section').classList.remove('d-none');
                }

                // Reset employee details
                document.getElementById('emp_id').value = '';
                document.querySelector('input[name="employee-details[emp_join_date]"]').value = '';
                document.querySelector('input[name="employee-details[employee_nic]"]').value = '';
                document.querySelector('input[name="employee-details[job_title]"]').value = '';
                document.querySelector('textarea[name="employee-details[employee_address]"]').value = '';

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
                employeeSection.classList.add('d-none');
                document.getElementById('agreement_catagory').value = '';
            }
        });

        // Employee selection handler
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


        // Maintain pagination functionality
        document.getElementById('next-page').addEventListener('click', handleNextPage);
        document.getElementById('prev-page').addEventListener('click', handlePrevPage);
        window.addEventListener('resize', handleWindowResize);
        document.getElementById('topics-container').addEventListener('click', handleTopicActions);
    }

    // Keep all existing functions with real data integration
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
                syncFormWithTemplateData(); // 🔄 Save current state
                currentTemplateData.topics[topicIndex].subtopics.splice(subtopicIndex, 1);
                renderTopics();
            }

        }

        else if (e.target.closest('.remove-topic')) {
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
                                <i class="ti ti-x remove-topic-icon";"></i>
                            </button>
                        </div>
                    </div>
                    <div class="sub-topic-inner-wrap border rounded p-1">
                        ${topic.subtopics.map((subtopic, subIndex) => `
                            <div class="sub-topic-outer-wrap border rounded m-1">
                                <div class="p-2">
                                    <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                                        <input type="text" class="form-control subtopic-title-input" name="topics[${index}][subtopics][${subIndex}][subtitle]" value="${subtopic.title}">
                                        <button type="button" class="btn btn-sm remove-subtopic data-index="${subIndex}">
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

</script>
@endsection
