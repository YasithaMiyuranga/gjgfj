{{-- <div class="mb-3 d-flex align-items-center" style="gap: 10px;">
    <label for="task_template_select" class="form-label fw-bold mb-0">Select Task Template</label>

    <select class="form-control" id="task_template_select" name="task_template">
        <option value="" selected>Select Template</option>
        @foreach ($taskTemplates as $template)
            @if (!Str::contains($template->template_name, '(v2)'))
                <option value="{{ $template->id }}">{{ $template->template_name }}</option>
            @endif
        @endforeach
    </select>

    <!-- Plus button to add new template -->
    <button type="button" id="createTemplateBtn" class="btn btn-success btn-sm">
        +
    </button>
</div> --}}

<div id="subOption_main">

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (required for Bootstrap 4 tooltips/modals) -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    const res = fetch("{{ route('useradmin.strategies.suboptions.load') }}")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#subOption_main').html(data.html);
                $('#task_template_select').val("");
            } else {
                $('#subOption_main').html('');
            }
        }).catch(err => {
            console.error('Error fetching sub-options:', err);
        });








    $(document).ready(function() {
        $(document).on('change', '#task_template_select', async function() {
            const templateId = $(this).val();

            if (!templateId) {
                $('#subOption_main').html('');
                return;
            }

            try {
                const res = await fetch("{{ route('useradmin.strategies.suboptionsEdit.load') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: templateId
                    })
                });

                const data = await res.json();

                if (data.success) {
                    $('#subOption_main').html(data.html);
                } else {
                    $('#subOption_main').html('');
                }
            } catch (err) {
                console.error('Error fetching sub-options:', err);
            }
        });


        $(document).on('click', '#createTemplateBtn', async function() {
            try {
                const res = await fetch("{{ route('useradmin.strategies.suboptions.load') }}")
                const data = await res.json();

                if (data.success) {
                    $('#subOption_main').html(data.html);
                    $('#task_template_select').val("");
                } else {
                    $('#subOption_main').html('');
                }
            } catch (err) {
                console.error('Error fetching sub-options:', err);
            }
        })

    });
</script>
