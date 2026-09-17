<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Seat Summary</title>

</head>

<body>
    <div class="container mt-4">
        <div id="eventTableContainer">
            <div class="table-responsive">
                @foreach ($tickets as $ticket)
                    <div>
                        <h3>{{ $ticket->tickets_category . ' - ' . $ticket->price . ' ' . $ticket->currency }}</h3>
                    </div>
                    <div>
                        <h6>Available : {{ $ticket->number_of_tickets }}</h6>
                        <h6>Sold : {{ $ticket->initial_tickets_count-$ticket->number_of_tickets }}</h6>

                    </div>
                    <hr />
                    <div
                        class="p-4 bg-blue-700 bg-opacity-25 rounded-4 d-flex flex-wrap justify-content-center align-items-center gap-2">
                        @for ($i = 0; $i < $ticket->initial_tickets_count; $i++)
                            @php
                                $seatNumber = $i + 1;
                                $isSoldOut = in_array($seatNumber, $ticket->sold_out_seats ?? []);
                            @endphp
                            <button disabled
                                class="btn rounded-3 d-flex justify-content-center align-items-center shadow-sm
                                {{ $isSoldOut ? 'btn-danger' : 'btn-light bg-white' }}"
                                style="width: 30px; aspect-ratio: 1; max-width: fit-content;font-size: 10px">
                                {{ $seatNumber }}
                            </button>
                        @endfor
                    </div>
                    <hr />
                @endforeach

            </div>
        </div>
    </div>


    <!-- NEW: Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Custom Script (after Bootstrap is loaded) -->
    <script></script>

</body>

</html>
