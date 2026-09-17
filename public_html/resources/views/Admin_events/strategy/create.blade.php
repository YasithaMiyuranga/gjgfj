@extends('layouts.events')

@section('page-title', __('Create Strategy'))

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.strategies.index') }}">{{ __('Strategies List') }}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Create Strategy') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('Create Strategy') }}</h3>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('useradmin.strategies.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Strategy Name') }} *</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">{{ __('Category') }} *</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="is_default" class="form-label">{{ __('Is Default?') }} *</label>
                            <select name="is_default" id="is_default" class="form-control" required>
                                <option value="0" {{ old('is_default') == '0' ? 'selected' : '' }}>
                                    {{ __('No') }}</option>
                                <option value="1" {{ old('is_default') == '1' ? 'selected' : '' }}>
                                    {{ __('Yes') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Strategy Options') }}*</label>
                            <div id="strategy-options-group">
                                {{-- Option block --}}
                                <div class="option-block border p-3 mb-3">
                                    <div class="mb-2">
                                        <label class="form-label">{{ __('Option Name') }}</label>
                                        <input type="text" name="options[0][name]" class="form-control"
                                            placeholder="Option name" required>
                                    </div>

                                    <div class="sub-options-container">
                                        <label class="form-label">{{ __('Sub Options') }}</label>
                                        <div class="input-group mb-2 sub-option-row">
                                            <select name="options[0][sub_options][]" class="form-control" required>
                                                <option value="">{{ __('Select Sub Option') }}</option>
                                                @foreach ($subOptions as $subOption)
                                                    <option value="{{ $subOption->id }}">{{ $subOption->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button"
                                                class="btn btn-outline-secondary add-sub-option">+</button>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="button" class="btn btn-outline-danger remove-option">Remove
                                            Option</button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary mt-2" id="add-option-btn">Add
                                Option</button>
                        </div>
                        
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">{{ __('Save Strategy') }}</button>
                    <a href="{{ route('useradmin.strategies.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const optionGroup = document.getElementById('strategy-options-group');
        const addOptionBtn = document.getElementById('add-option-btn');
        const subOptions = @json($subOptions);
        let optionIndex = 1;

        function getSubOptionDropdownHTML(optionIdx) {
            return `
                <div class="input-group mb-2 sub-option-row">
                    <select name="options[${optionIdx}][sub_options][]" class="form-control" required>
                        <option value="">Select Sub Option</option>
                        ${subOptions.map(opt => `<option value="${opt.id}">${opt.name}</option>`).join('')}
                    </select>
                    <button type="button" class="btn btn-outline-secondary add-sub-option">+</button>
                    <button type="button" class="btn btn-outline-danger remove-sub-option">−</button>
                </div>
            `;
        }

        addOptionBtn.addEventListener('click', function() {
            const wrapper = document.createElement('div');
            wrapper.className = 'option-block border p-3 mb-3';
            wrapper.innerHTML = `
                <div class="mb-2">
                    <label class="form-label">Option Name</label>
                    <input type="text" name="options[${optionIndex}][name]" class="form-control" placeholder="Option name" required>
                </div>

                <div class="sub-options-container">
                    <label class="form-label">Sub Options</label>
                    ${getSubOptionDropdownHTML(optionIndex)}
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-outline-danger remove-option">Remove Option</button>
                </div>
            `;
            optionGroup.appendChild(wrapper);
            optionIndex++;
        });

        optionGroup.addEventListener('click', function(e) {
            const target = e.target;

            // Add sub-option
            if (target.classList.contains('add-sub-option')) {
                const optionBlock = target.closest('.option-block');
                const subContainer = optionBlock.querySelector('.sub-options-container');
                const index = [...optionGroup.children].indexOf(optionBlock);
                subContainer.insertAdjacentHTML('beforeend', getSubOptionDropdownHTML(index));
            }

            // Remove sub-option
            if (target.classList.contains('remove-sub-option')) {
                const row = target.closest('.sub-option-row');
                const container = row.parentElement;
                if (container.querySelectorAll('.sub-option-row').length > 1) {
                    row.remove();
                }
            }

            // Remove whole option
            if (target.classList.contains('remove-option')) {
                const optionBlock = target.closest('.option-block');
                optionBlock.remove();
            }
        });
    });
</script>
