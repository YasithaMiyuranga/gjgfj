@extends('layouts.app')
@section('page-title', __('Employees'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.agreement_templates.index') }}">{{ __('Agreement Templates') }}</a>
        <li class="breadcrumb-item active">{{ ('Create Agreement Templates') }}</li>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <form method="POST" id="agreement-form" action="{{ route('useradmin.agreement_templates.store') }}">
                @csrf
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="card-header">
                        <h5></h5>
                        <h3>Create Agreement Templates</h3>
                    </div>
                    <div class="form-check mx-3">
                        <label class="form-label" for="is_default"><b>{{ ('Default Agreement') }}</b></label>
                        <input type="checkbox" name="is_default" class="form-check-input" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
                    </div>
                </div>
                <hr>
                <div class="card-body table-border-style p-15">
                    <div class="add-agreement-form mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="agreement_name" class="form-label">Agreement Name*</label>
                                <input type="text" class="form-control" name="agreement_name" required id="agreement_name" placeholder="Enter Agreement Name" required></label>
                                @error('agreement_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="agreement_type" class="form-label">Agreement  Category*</label>
                                <select class="form-control" id="agreement_type" name="agreement_category_id" required>
                                    <option value="" disabled selected>Select Agreement Category</option>
                                    @foreach($agreementCategories as $agreement_type)
                                        <option value="{{ $agreement_type->id }}">{{ $agreement_type->name }}</option>
                                    @endforeach
                                </select>
                                @error('agreement_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="agreement_description" class="form-label">Agreement Content*</label>
                                <textarea class="form-control" name="agreement_description"  id="agreement_description" placeholder="Enter Agreement Content" required></textarea>
                            </div>
                            @error('agreement_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="agreement-container border rounded p-2 p-md-3">
                        <div class="main-topic-wrap border rounded p-2 p-md-3 mb-3" data-topic-index="1" data-subtopic-count="0">
                            <div class="agreement-header mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Term <span class="topic-number">01</span></h5>
                                    <div>
                                        <button type="button" class="btn btn-sm toggle-agenda-day"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#topic-1-content">
                                            <span class="dropdown-icon">⮟</span>
                                        </button>
                                        <button type="button" class="btn btn-sm remove-topic text-danger">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="text" name="topics[1][title]" class="form-control main-topic-input" placeholder="Enter Main Term" required>
                                @error('topics.1.title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div id="topic-1-content" class="collapse show">
                                <div class="sub-topics-container">

                                    <div class="sub-topic-wrap border rounded p-2 p-md-3 mb-3">
                                        <div class="agreement-header d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">Sub Term <span class="subtopic-number">01</span></h6>
                                            <div>
                                                <button type="button" class="btn btn-sm toggle-agenda-day"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#subtopic-1-1-content">
                                                    <span class="dropdown-icon">⮟</span>
                                                </button>
                                                <button type="button" class="btn btn-sm text-danger remove-subtopic">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="subtopic-1-1-content" class="collapse show">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Sub Term*</label>
                                                        <input type="text" class="form-control" name="topics[1][subtopics][1][title]" required>
                                                        @error('topics.1.subtopics.1.title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Description*</label>
                                                        <textarea class="form-control" name="topics[1][subtopics][1][description]" required></textarea>
                                                        @error('topics.1.subtopics.1.description')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary add-subtopic">
                                    <i class="ti ti-plus me-2"></i>Add Sub Term
                                </button>
                            </div>
                        </div>
                        <div class="add-topic-btn d-flex justify-content-md-between align-items-md-center gap-3 flex-column flex-md-row mt-4">
                            <button type="button" class="btn btn-sm btn-secondary add-topic">
                                <i class="ti ti-plus me-2"></i>Add Main Term
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Agreement
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .dropdown-icon {
        transition: transform 0.2s ease;
        display: inline-block;
    }

    button[aria-expanded="true"] .dropdown-icon {
        transform: rotate(180deg);
    }

    .agreement-header {
        padding: 0.75rem 1rem;
    }

</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const agreementContainer = document.querySelector('.agreement-container');

    // Initialize Bootstrap Collapse with proper event handling
    const initCollapse = (element) => {
        const collapse = new bootstrap.Collapse(element, { toggle: false });
        element.addEventListener('shown.bs.collapse', updateIcons);
        element.addEventListener('hidden.bs.collapse', updateIcons);
    };

    // Update dropdown icons
    const updateIcons = (e) => {
        const toggleBtn = document.querySelector(`[data-bs-target="#${e.target.id}"]`);
        if (toggleBtn) {
            const icon = toggleBtn.querySelector('.dropdown-icon');
            icon.style.transform = e.type === 'shown' ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    };

    // Add Main Topic
    agreementContainer.addEventListener('click', e => {
        const addBtn = e.target.closest('.add-topic');
        if (addBtn) {
            e.preventDefault();
            const topics = document.querySelectorAll('.main-topic-wrap');
            const newIndex = topics.length + 1;

            const template = `
                <div class="main-topic-wrap border rounded p-2 p-md-3 mb-3" data-topic-index="${newIndex}" data-subtopic-count="0">
                    <div class="agreement-header mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Term <span class="topic-number">${String(newIndex).padStart(2, '0')}</span></h5>
                            <div>
                                <button type="button" class="btn btn-sm toggle-agenda-day"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#topic-${newIndex}-content">
                                    <span class="dropdown-icon">⮟</span>
                                </button>
                                <button type="button" class="btn btn-sm remove-topic text-danger">
                                    <i class="ti ti-x"></i>
                                </button>
                            </div>
                        </div>
                        <input type="text" name="topics[${newIndex}][title]" class="form-control main-topic-input" placeholder="Enter Main Term" required>
                        @error('topics.${newIndex}.title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="topic-${newIndex}-content" class="collapse show">
                        <div class="sub-topics-container"></div>
                        <button type="button" class="btn btn-sm btn-secondary add-subtopic">
                            <i class="ti ti-plus me-2"></i>Add Sub Term
                        </button>
                    </div>
                </div>`;

            addBtn.closest('.add-topic-btn').insertAdjacentHTML('beforebegin', template);
            initCollapse(document.getElementById(`topic-${newIndex}-content`));
        }
    });

    // Add Subtopic
    agreementContainer.addEventListener('click', e => {
        const addBtn = e.target.closest('.add-subtopic');
        if (addBtn) {
            e.preventDefault();
            const mainTopic = addBtn.closest('.main-topic-wrap');
            const topicIndex = mainTopic.dataset.topicIndex;
            const subCount = parseInt(mainTopic.dataset.subtopicCount) + 1;
            mainTopic.dataset.subtopicCount = subCount;

            const template = `
                <div class="sub-topic-wrap border rounded p-2 p-md-3 mb-3">
                    <div class="agreement-header d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Sub Term <span class="subtopic-number">${String(subCount).padStart(2, '0')}</span></h6>
                        <div>
                            <button type="button" class="btn btn-sm toggle-agenda-day"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#subtopic-${topicIndex}-${subCount}-content">
                                <span class="dropdown-icon">⮟</span>
                            </button>
                            <button type="button" class="btn btn-sm text-danger remove-subtopic">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    </div>
                    <div id="subtopic-${topicIndex}-${subCount}-content" class="collapse show">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Sub Term*</label>
                                    <input type="text" class="form-control" name="topics[${topicIndex}][subtopics][${subCount}][title]" required>
                                    @error('topics.${topicIndex}.subtopics.${subCount}.title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Description*</label>
                                    <textarea class="form-control" name="topics[${topicIndex}][subtopics][${subCount}][description]" required></textarea>
                                    @error('topics.${topicIndex}.subtopics.${subCount}.description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

            mainTopic.querySelector('.sub-topics-container').insertAdjacentHTML('beforeend', template);
            initCollapse(document.getElementById(`subtopic-${topicIndex}-${subCount}-content`));
        }
    });

    // Remove elements
    agreementContainer.addEventListener('click', e => {
        // Remove Topic
        if (e.target.closest('.remove-topic')) {
            const topicWrap = e.target.closest('.main-topic-wrap');
            topicWrap.remove();
            updateTopicNumbers();
        }
        // Remove Subtopic
        else if (e.target.closest('.remove-subtopic')) {
            const subTopicWrap = e.target.closest('.sub-topic-wrap');
            const mainTopic = subTopicWrap.closest('.main-topic-wrap');
            subTopicWrap.remove();
            updateSubTopicNumbers(mainTopic);
        }
    });

    // Update topic numbers
    function updateTopicNumbers() {
        document.querySelectorAll('.main-topic-wrap').forEach((topic, index) => {
            const newIndex = index + 1;
            topic.dataset.topicIndex = newIndex;
            topic.querySelector('.topic-number').textContent = String(newIndex).padStart(2, '0');

            // Update input names
            const mainInput = topic.querySelector('.main-topic-input');
            mainInput.name = `topics[${newIndex}][title]`;

            // Update subtopics
            updateSubTopicNumbers(topic);
        });
    }

    // Update subtopic numbers
    function updateSubTopicNumbers(mainTopic) {
        const topicIndex = mainTopic.dataset.topicIndex;
        let subCount = 0;

        mainTopic.querySelectorAll('.sub-topic-wrap').forEach((sub, index) => {
            subCount = index + 1;
            sub.querySelector('.subtopic-number').textContent = String(subCount).padStart(2, '0');

            // Update data attributes and IDs
            const collapseContent = sub.querySelector('.collapse');
            const newSubId = `subtopic-${topicIndex}-${subCount}-content`;
            collapseContent.id = newSubId;
            sub.querySelector('[data-bs-target]').dataset.bsTarget = `#${newSubId}`;

            // Update input names
            const inputs = sub.querySelectorAll('input, textarea');
            inputs[0].name = `topics[${topicIndex}][subtopics][${subCount}][title]`;
            inputs[1].name = `topics[${topicIndex}][subtopics][${subCount}][description]`;
        });

        mainTopic.dataset.subtopicCount = subCount;
    }

    // Initialize existing collapses
    document.querySelectorAll('.collapse').forEach(initCollapse);
});
</script>
@endsection
