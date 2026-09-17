@extends('layouts.app')
@section('page-title', ('Accounts'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.order.creditorder.payments.view') }}">{{('Credit Order Payment') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Credit Order Payment List</h3>
            </div>
            <hr>
            <div class=" card-body table-border-style">
                <div class="table-responsive">
                    <table class="table descending-order">
                        <thead>
                            <tr>
                                <th>{{ ('Payment Log ID') }}</th>
                                <th>{{ ('Credit Order ID') }}</th>
                                <th>{{ ('Order ID') }}</th>
                                <th>{{ ('Paid Amount') }}</th>
                                <th>{{ ('Paid Date') }}</th>
                                <th>{{ ('Payment Type') }}</th>
                                <th>{{ ('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($creditOrdersPayements as $row)
                                <tr>
                                    <td>{{ $row->payment_log_id }}</td>
                                    <td>{{ $row->credit_order_id }}</td>
                                    <td>{{ $row->order_id }}</td>
                                    <td>{{ $row->paid_amount }}</td>
                                    <td>{{ $row->paid_date }}</td>
                                    <td>{{ $row->payment_type }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info"
                                        onclick="downloadpdf('{{ $row->payment_log_id }}')">
                                        <i class="ti ti-download"></i>
                                    </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function downloadpdf(payment_log_id) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', `/useradmin/confirmation/pdf/${payment_log_id}`, true);
    xhr.responseType = 'blob';

    xhr.onload = function () {
        if (xhr.status === 200) {
            var url = window.URL.createObjectURL(xhr.response);
            var a = document.createElement('a');
            a.href = url;
            a.download = `${payment_log_id}_Confirmation_Report.pdf`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            // Redirect to the specified route after download
            window.location.href = "{{ route('useradmin.order.creditorder.payments.view') }}";
        } else {
            alert('Failed to generate PDF.');
        }
    };

    xhr.onerror = function () {
        alert('An error occurred during the request.');
    };

    xhr.send();
}
</script>
@endsection
