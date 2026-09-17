<div class="card-body table-border-style">
    <div class="table-responsive">
        <table class="table descending-order">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Buyer Mobile</th>
                    <th>User Name</th>
                    <th>Agent Name</th>
                    <th>NIC</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($event->transactions as $transaction)
                    <tr class="{{ $transaction->amount < 0 ? 'table-danger' : '' }}">
                        <td>{{ $transaction->transaction_id }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->buyer_phone_number }}</td>
                        <td>{{ $transaction->user?->name ?? 'N/A' }}</td>
                        <td>{{ $transaction->agent?->name ?? 'N/A' }}</td>
                        <td>{{ $transaction->nic }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
