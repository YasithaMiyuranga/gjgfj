@extends('layouts.events')

@section('page-title', __('Edit Strategy'))

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.strategies.index') }}">{{ __('Strategies List') }}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit Strategy') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>{{ __('Edit Strategy') }}</h3>
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

                <form method="POST" action="{{ route('useradmin.strategies.update', $strategy->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Strategy Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Strategy Name') }} *</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name', $strategy->name) }}" required>
                    </div>

                    {{-- Category --}}
                    <div class="mb-3">
                        <label for="category_id" class="form-label">{{ __('Category') }} *</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">{{ __('Select Category') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $strategy->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Is Default --}}
                    <div class="mb-3">
                        <label for="is_default" class="form-label">{{ __('Is Default?') }} *</label>
                        <select name="is_default" id="is_default" class="form-control" required>
                            <option value="0" {{ old('is_default', $strategy->is_default) == 0 ? 'selected' : '' }}>
                                {{ __('No') }}
                            </option>
                            <option value="1" {{ old('is_default', $strategy->is_default) == 1 ? 'selected' : '' }}>
                                {{ __('Yes') }}
                            </option>
                        </select>
                    </div>

                    {{-- Options & Sub-Options --}}
                    <div class="mb-3">
                        <label class="form-label">{{ __('Strategy Options') }}*</label>
                        <div id="strategy-options-group">
                            @php
                                /* Build an array that looks like:
                                   [
                                     0 => ['name' => 'Foo', 'sub_options' => [1,5]],
                                     1 => ['name' => 'Bar', 'sub_options' => [3]],
                                   ]
                                */
                                $oldOptions = old('options', []);
                                if (!is_array($oldOptions) || !$oldOptions) {
                                    $oldOptions = $strategyOptions->map(function ($so) {
                                        return [
                                            'name'        => $so->option->name,
                                            'sub_options' => $so->subOptions->pluck('id')->toArray(),
                                        ];
                                    })->toArray();
                                }
                            @endphp

                            @forelse ($oldOptions as $idx => $opt)
                                <div class="option-block border p-3 mb-3" data-index="{{ $idx }}">
                                    <div class="mb-2">
                                        <label class="form-label">{{ __('Option Name') }}</label>
                                        <input type="text"
                                               name="options[{{ $idx }}][name]"
                                               class="form-control"
                                               value="{{ $opt['name'] ?? '' }}" required>
                                    </div>

                                    <div class="sub-options-container">
                                        <label class="form-label">{{ __('Sub Options') }}</label>
                                        @php
                                            $subOptionsGroup = $opt['sub_options'] ?? [];
                                            if (!is_array($subOptionsGroup)) $subOptionsGroup = [$subOptionsGroup];
                                        @endphp
                                        @foreach ($subOptionsGroup as $subIdx => $subId)
                                            <div class="input-group mb-2 sub-option-row">
                                                <select name="options[{{ $idx }}][sub_options][]" class="form-control" required>
                                                    <option value="">{{ __('Select Sub Option') }}</option>
                                                    @foreach ($subOptions as $so)
                                                        <option value="{{ $so->id }}" {{ $subId == $so->id ? 'selected' : '' }}>
                                                            {{ $so->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="button"
                                                        class="btn btn-outline-secondary add-sub-option">+</button>
                                                <button type="button"
                                                        class="btn btn-outline-danger remove-sub-option">−</button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-end">
                                        <button type="button" class="btn btn-outline-danger remove-option">
                                            {{ __('Remove Option') }}
                                        </button>
                                    </div>
                                </div>
                            @empty                               
                            @endforelse
                        </div>

                        <button type="button" class="btn btn-outline-primary mt-2" id="add-option-btn">
                            {{ __('Add Option') }}
                        </button>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">{{ __('Update Strategy') }}</button>
                        <a href="{{ route('useradmin.strategies.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
    const subOptions = @json($subOptions);

    function buildSubSelect(idx, selected = null) {
        let html = `<div class="input-group mb-2 sub-option-row">
                        <select name="options[${idx}][sub_options][]" class="form-control" required>
                            <option value="">{{ __('Select Sub Option') }}</option>`;
        subOptions.forEach(so => {
            html += `<option value="${so.id}" ${selected == so.id ? 'selected' : ''}>${so.name}</option>`;
        });
        html += `</select>
                 <button type="button" class="btn btn-outline-secondary add-sub-option">+</button>
                 <button type="button" class="btn btn-outline-danger remove-sub-option">−</button>
               </div>`;
        return html;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const group = document.getElementById('strategy-options-group');
        const addBtn = document.getElementById('add-option-btn');

        let maxIdx = [...group.children].reduce((m, el) =>
            Math.max(m, parseInt(el.dataset.index || 0)), 0);

        addBtn.addEventListener('click', () => {
            maxIdx++;
            const block = document.createElement('div');
            block.className = 'option-block border p-3 mb-3';
            block.dataset.index = maxIdx;
            block.innerHTML = `
                <div class="mb-2">
                    <label class="form-label">{{ __('Option Name') }}</label>
                    <input type="text" name="options[${maxIdx}][name]" class="form-control" placeholder="Option name" required>
                </div>
                <div class="sub-options-container">
                    <label class="form-label">{{ __('Sub Options') }}</label>
                    ${buildSubSelect(maxIdx)}
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-outline-danger remove-option">{{ __('Remove Option') }}</button>
                </div>`;
            group.appendChild(block);
        });

        group.addEventListener('click', e => {
            const t = e.target;
            if (t.classList.contains('add-sub-option')) {
                const block = t.closest('.option-block');
                const idx = block.dataset.index;
                block.querySelector('.sub-options-container')
                     .insertAdjacentHTML('beforeend', buildSubSelect(idx));
            }
            if (t.classList.contains('remove-sub-option')) {
                const row = t.closest('.sub-option-row');
                if (row.parentElement.querySelectorAll('.sub-option-row').length > 1) row.remove();
            }
            if (t.classList.contains('remove-option')) {
                t.closest('.option-block').remove();
            }
        });
    });
</script>
