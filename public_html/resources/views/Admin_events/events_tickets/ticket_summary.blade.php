<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ticket Summary Modal</title>

</head>

<body>
    <div class="container mt-4">
        <div id="eventTableContainer">
            <div class="input-group mb-3" style="max-width: 400px;">
                <input type="text" id="customerSearchInput" class="form-control"
                    placeholder="Search by name, NIC, phone, or email">
                <button class="btn btn-primary" id="customerSearchBtn" type="button">Search</button>
            </div>

            <div class="table-responsive">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>NIC</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Total Amount</th>
                            <th>Purchase Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketOwners as $ticketOwner)
                            <tr>
                                <td>{{ $ticketOwner->oid }}</td>
                                <td>{{ $ticketOwner->name }}</td>
                                <td>{{ $ticketOwner->nic }}</td>
                                <td>{{ $ticketOwner->phone_number }}</td>
                                <td>{{ $ticketOwner->email }}</td>
                                <td>{{ $ticketOwner->total }}</td>
                                <td>{{ $ticketOwner->created_at }}</td>


                                @php
                                    $ticketData = json_encode([
                                        'event_id' => $ticketOwner->event_id,
                                        'user_email' => $ticketOwner->email,
                                        'owner' => $ticketOwner->oid,
                                        'ticket' => json_decode($ticketOwner->tickets_json, true), // decode to ensure valid nested JSON
                                    ]);
                                @endphp
                                <td class="text-center">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary view-ticket-btn"
                                        data-tickets='@json($ticketData)'>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!--  Ticket Details Modal -->
    <div class="modal fade" id="ticketDetailsModal" tabindex="-1" aria-labelledby="ticketDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketDetailsModalLabel">Ticket Summary - <span id="modalCustomerName"
                            class="text-customer"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body position-relative" style="overflow: auto">
                    <!-- Alert Placeholder -->
                    <div id="alertPlaceholder" class="position-relative top-0 start-50 translate-middle-x mt-4"
                        style="z-index: 1060; min-width: 300px;"></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ticket Name</th>
                                <th>Status</th>
                                <th>Buy date</th>
                                <th>QR Code</th>
                                <th>BAR Code</th>
                            </tr>
                        </thead>
                        <tbody id="ticketModalBody">
                            <!-- Ticket rows will be added here dynamically -->
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-3 ms-2 mb-2">
                        <button id="sendToCustomerBtn" class="btn btn-success">
                            Send to Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- NEW: Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('customerSearchBtn').addEventListener('click', function() {
            const query = document.getElementById('customerSearchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#eventTableContainer table tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell =>
                    cell.textContent.toLowerCase().includes(query)
                );
                row.style.display = match ? '' : 'none';
            });
        });
    </script>

    <!-- Custom Script (after Bootstrap is loaded) -->
    <script>
        document.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'sendToCustomerBtn') {
                const response = {
                    message: 'Ticket summary has been sent to the customer !'
                };

                const alertPlaceholder = document.getElementById('alertPlaceholder');
                alertPlaceholder.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                        ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                // Auto-dismiss after 2 seconds
                setTimeout(() => {
                    const alert = bootstrap.Alert.getOrCreateInstance(document.querySelector('.alert'));
                    alert.close();
                }, 2000);
            }
        });



        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('view-ticket-btn')) {
                const ticketData = JSON.parse(e.target.getAttribute('data-tickets'));




                // Set up the click handler ONCE — not inside this block every time
                const sendBtn = document.getElementById("sendToCustomerBtn");
                sendBtn.onclick = function() {
                    const owner_id = JSON.parse(ticketData).owner;
                    const event_id = JSON.parse(ticketData).event_id;
                    const user_email = JSON.parse(ticketData).user_email;

                    fetch('/useradmin/ticket/send', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                event_id: event_id,
                                owner_id: owner_id,
                                user_email: user_email
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Optionally show success message
                            console.log('Tickets sent:', data);
                        })
                        .catch(error => console.error('Error:', error));
                };

                const tbody = document.getElementById('ticketModalBody');
                tbody.innerHTML = '';

                JSON.parse(ticketData).ticket.forEach((ticket, index) => {
                    tbody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${ticket.name}</td>
                    <td class="text-end">${ticket.ticket_status ?? ''}</td>
                    <td class="text-end">${ticket.buy_date ?? ''}</td>
                    <td class="text-end" style="background-color: white;display:flex;justify-content:center;align-items:center"><img src="${ticket.qr_code ?? ''}" class="card-img-top" style="width: 60%;aspect-ration:1;" alt="QR Code"></td>
                    <td class="text-end" style="background-color: white;"><img src="${ticket.bar_code ?? ''}" class="card-img-top" style="width: 100%; aspect-ratio:16/9;" alt="Bar Code"></td>
                </tr>
            `;
                });

                // Set customer name
                const row = e.target.closest('tr');
                const customerName = row.children[1].innerText;
                document.getElementById('modalCustomerName').innerText = customerName;

                // Show modal
                document.getElementById('eventTableContainer').style.display = 'none';
                const modalEl = document.getElementById('ticketDetailsModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();

                modalEl.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('eventTableContainer').style.display = 'block';
                }, {
                    once: true
                });
            }
        });
    </script>

</body>

</html>
