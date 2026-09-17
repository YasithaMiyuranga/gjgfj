@extends('layouts.events')

@section('page-title', __('Strategies'))

@section('content')
    <form method="POST" id="subOptionForm"
        action="{{ route('useradmin.strategies.saveSubOption', [$strategy->id, $page, $subPage]) }}">
        @csrf
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-0">{{ $currentOption->name }}</h3>
                <small>Sub-option {{ $subPage + 1 }}</small>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h3 class="form-label fw-bold">{{ $subOption->name }}</h3>
                </div>

                <div id='subOption'>

                </div>

            </div>

            <div class="card-footer d-flex justify-content-between">
                @if ($subPage > 0)
                    <a href="{{ route('useradmin.strategies.view', ['page' => $page, 'sub_page' => $subPage - 1]) }}"
                        class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> Previous
                    </a>
                @endif

                <button type="submit" onclick="saveAndNext()" class="btn btn-primary">
                    {{ $subPage < $lastSubPage ? 'Save & Next Sub Option' : ($page < $lastPage ? 'Save & Next Option' : 'Finish') }}
                </button>
            </div>
        </div>
    </form>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (required for Bootstrap 4 tooltips/modals) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            fetch("{{ route('useradmin.strategies.mainTasks.load') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        sub_option_name: '{{ $subOption->name }}'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        $('#subOption').html(data.html);
                    }
                })
                .catch(err => console.error(err));

        });

        const loaded = [];


        document.getElementById('subOptionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            save('subOptionForm');
            // document.getElementById('subOptionForm').submit();
        })

        // function saveAndNext(e) {
        //     e.preventDefault();
        //     save();


        // }
    </script>
@endsection
