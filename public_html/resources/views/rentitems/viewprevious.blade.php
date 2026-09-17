<form id="sendForm">
    @csrf
    @method('PUT')
    <div class="form-group">
        <h5>Rent Date: {{ $rent->created_at }}</h5>
        <h5>Received Date: {{ $rent->updated_at }}</h5>
    </div>
    <div class="form-group">
        <label for="employee_name">Employee Name</label>
        <input type="text" class="form-control" id="employee_name" name="employee_name" value="{{ $rent->employee_name }}" readonly>
    </div>
    <div class="form-group">
        <label for="customer_name">Customer Name</label>
        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $rent->customer_name }}" readonly>
    </div>
    <div class="table-responsive mt-2">
        <table class="table dataTable mt-4">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rentitems as $rentitem)
                <tr>
                    <td>{{ $rentitem->item_name }}</td>
                    <td>{{ $rentitem->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <div class="form-group">
        <label for="received_status">Received Status</label>
        <input type="text" class="form-control" id="received_status" name="received_status" value="{{ $rent->received_status }}" readonly>
    </div>
    @if ($rent->note != null)
    <div class="form-group">
        <label for="note">Special Notes:</label>
        <textarea class="form-control" id="note" name="note" rows="3" readonly>{{ $rent->note }}</textarea>
    </div>
    @endif
    @if ($damageitems->isNotEmpty())
    <div class="form-group">
        <label for="note">Damage Notes:</label>
        <textarea class="form-control" id="damage" name="damage" rows="3" readonly>{{ $damageitems->first()->damage }}</textarea>
    </div>
    @endif

    <div class="form-group">
        @if ($downloadable == true)
            <button type="submit" class="btn btn-info">
                <i class="fa fa-download"></i>
            </button>
        @endif
    </div>
</form>
<script>
    function downloadpdf() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/useradmin/generate-viewpdf/{{ $rent->rent_id }}', true);
        xhr.responseType = 'blob';

        xhr.onload = function() {
            // Check status  success
            if (xhr.status === 200) {

                var url = window.URL.createObjectURL(xhr.response);
                var a = document.createElement('a');
                a.href = url;
                a.download = '{{ $rent->customer_name }}__{{ $rent->created_at }}_Receiveditem_Report.pdf';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.location.href = "{{ route('useradmin.rent.history') }}";
            } else {
                // Handle error
                showCustomAlert('Error downloading PDF');
            }
        };
        xhr.onerror = function() {
            // Handle network error
           showCustomAlert('Network error while downloading PDF');
        };
        xhr.send();
    }
    document.getElementById('sendForm').addEventListener('submit', function(e) {
        e.preventDefault();
        downloadpdf();
    });
</script>
