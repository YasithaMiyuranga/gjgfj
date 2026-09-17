<form id="qr-search-form" method="GET" style="margin-bottom: 1rem;">
    <div class="input-group">
        <input type="text" name="search" class="form-control col-6" placeholder="Search by name, seat no, etc"
               value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Seat No</th>
            <th>Status</th>
            <th>User Name</th>
            <th>Mobile</th>
            <th>Booked Date</th>
            <th>Qr Code</th>
            <th>Bar Code</th>
        </tr>
    </thead>
    <tbody>
        @php $i = ($user_tickets->currentPage() - 1) * $user_tickets->perPage(); @endphp
        @foreach ($user_tickets as $ticket)
            <tr class="{{ $ticket->ticket_status == 'active' ? '' : 'bg-warning text-light' }}">
                <th>{{ ++$i }}</th>
                <td>{{ $ticket->ticket->tickets_category }}</td>
                <td>{{ $ticket->seat_number }}</td>
                <td>{{ $ticket->ticket_status }}</td>
                <td>{{ $ticket->user_name }}</td>
                <td>{{ $ticket->user_phone_number }}</td>
                <td>{{ $ticket->buy_date }}</td>
                <td class="text-center" style="background-color: white;">
                    <img src="{{ asset('storage/' . $ticket->qr_code) }}" style="width: 40%; aspect-ratio: 1;"
                        alt="QR Code">
                </td>
                <td class="text-center" style="background-color: white;">
                    <img src="{{ asset('storage/' . $ticket->bar_code) }}" style="width: 60%; aspect-ratio: 16/9;"
                        alt="Bar Code">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {!! $user_tickets->links() !!}
</div>

<script>
    // Handle pagination via AJAX
    $(document).off('click', '.pagination a').on('click', '.pagination a', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');
        fetchPopupTable(url);
    });

    // Handle search form submission
    $(document).off('submit', '#qr-search-form').on('submit', '#qr-search-form', function (e) {
        e.preventDefault();

        let url = "{{ request()->url() }}"; // current popup URL
        let searchQuery = $(this).serialize();

        fetchPopupTable(url + '?' + searchQuery);
    });

    function fetchPopupTable(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                $('.modal-body').html(data);
            },
            error: function () {
                alert('Failed to load data.');
            }
        });
    }
</script>


