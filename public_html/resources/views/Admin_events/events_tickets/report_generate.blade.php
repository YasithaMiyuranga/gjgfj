@extends('layouts.events')
@section('page-title', ('Tickets'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.ticket.list') }}">{{ __('Tickets') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('Generate Report') }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card px-4 ">
            <div class="card-header card-body table-border-style">
                <div class="col-xl-12">
                    <form id ="reportForm" method="POST" action="{{ route('useradmin.events.ticket_report_generate') }}">
                        @csrf
                        <div  class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="event_name" class="form-label">Event Name: *</label>
                                    <select class="form-control select2" name="event_id" id="event_id" required>
                                        <option value="">Select Event Name</option>
                                        @foreach ($events as $event)
                                            <option value="{{ $event->eid }}"
                                                {{ ($selectedEvent && $selectedEvent->eid == $event->eid) || old('event_id') == $event->eid ? 'selected' : '' }}>
                                                {{ $event->event_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('event_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="ticket_category" class="form-label">Ticket Category:</label>
                                    <select class="form-control select2" name="tickets_category" id="tickets_category">
                                        <option value="">All</option>
                                        @foreach ($ticketCategories as $category)
                                            <option value="{{ $category }}" {{ old('tickets_category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tickets_category')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>                                
                            </div>
                        </div>
                        </div>
                        <div class="mb-3">
                           <button class="btn btn-primary" id="report-btn" type="submit">
                               {{ ('Generate Report') }}
                           </button>
                        </div>
                    </form>
                    <div id="reportResult" class="mt-4"></div>
                    <div class="mb-3">
                        <div id="downloadSection" class="mt-3 text-end" style="display: none;">
                            <button id="downloadReportBtn" class="btn btn-success" onclick="window.location.href='{{ route('useradmin.events.ticket_report',['eid' => $event->eid]) }}'">
                                Download Report
                            </button>                            
                        </div>                                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById('reportForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from reloading the page

        const eventId = document.getElementById('event_id').value;
        const ticketCategory = document.getElementById('tickets_category').value;

        fetch("{{ route('useradmin.events.ticket_report_generate') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                eid: eventId,
                tickets_category: ticketCategory
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                document.getElementById('reportResult').innerHTML = `<div class="alert alert-warning">No ticket data found for the selected filters.</div>`;
                localStorage.setItem('ticket_report_html', '');
                document.getElementById('downloadSection').style.display = 'none';
                return;
            }

            // Main tickets table
            let table = `<br>
                        <div class="table-responsive"><table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Tickets Category</th>
                                    <th>Price</th>
                                    <th>Number of Tickets</th>
                                    <th>Sold Tickets</th>
                                    <th>Remaining Tickets</th>
                                </tr>
                            </thead>
                            <tbody>`;

            let totalTickets = 0;
            let totalSoldTickets = 0;
            let totalRemainingTickets = 0;

            // For sales summary
            let salesSummary = {};
            let grandTotalSales = 0;

            data.forEach(ticket => {
                table += `<tr>
                            <td>${ticket.event_name}</td>
                            <td>${ticket.tickets_category}</td>
                            <td>${ticket.price}</td>
                            <td>${ticket.totalTickets}</td>
                            <td>${ticket.soldTickets ?? 0}</td>
                            <td>${ticket.remainingTickets}</td>
                        </tr>`;

                totalTickets += ticket.totalTickets;
                totalSoldTickets += ticket.soldTickets;
                totalRemainingTickets += ticket.remainingTickets;

                const category = ticket.tickets_category;
                const sales = ticket.price * ticket.soldTickets;

                if (!salesSummary[category]) {
                    salesSummary[category] = 0;
                }
                salesSummary[category] += sales;
                grandTotalSales += sales;
            });

            table += `<tr>
                        <th colspan="3">Total</th>
                        <th>${totalTickets}</th>
                        <th>${totalSoldTickets}</th>
                        <th>${totalRemainingTickets}</th>
                    </tr>`;
            table += `</tbody></table></div>`;
            // Second table: Sales by category
            let salesTable = `<br>
                                <b>Total Ticket Sales Summary</b>
                                <div class="table-responsive">
                                <table class="table table-bordered mt-4">
                                    <thead>
                                        <tr>
                                            <th>Tickets Category</th>
                                            <th>Total Sales</th>
                                        </tr>
                                    </thead>
                                <tbody>`;

            for (let category in salesSummary) {
                salesTable += `<tr>
                                    <td>${category}</td>
                                    <td>${salesSummary[category].toFixed(2)}</td>
                                </tr>`;
            }

            salesTable += `<tr>
                                <th>Total</th>
                                <th>${grandTotalSales.toFixed(2)}</th>
                        </tr>`;
            salesTable += `</tbody></table></div>`;

            // Combine both tables
            const finalHTML = table + salesTable;

            document.getElementById('reportResult').innerHTML = finalHTML;
            localStorage.setItem('ticket_report_html', finalHTML);
            localStorage.setItem('ticket_report_date', new Date().toLocaleString());
            document.getElementById('downloadSection').style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('reportResult').innerHTML = `<div class="alert alert-danger">Something went wrong while generating the report.</div>`;
        });

    });

    $('.select2').select2({
        Multiple: true,
    });

</script>

    
@endsection

